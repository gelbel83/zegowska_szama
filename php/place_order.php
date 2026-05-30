<?php
session_start();
require_once(__DIR__ . '/functions.php');

header('Content-Type: application/json');

$json = file_get_contents('php://input');
$cart_ids = json_decode($json, true);

if (empty($cart_ids)) {
    echo json_encode(['success' => false, 'message' => 'Koszyk jest pusty.']);
    exit;
}

$safe_ids = array_map('intval', $cart_ids);
$item_counts = array_count_values($safe_ids);
$unique_ids = array_keys($item_counts);
$num_ids = count($unique_ids);

$placeholders = implode(',', array_fill(0, $num_ids, '?'));
$sql = "SELECT id, cena, promocja FROM produkt WHERE id IN ($placeholders)";
$products = mysqli_select_values($sql, $unique_ids, $num_ids);

if (empty($products)) {
    echo json_encode(['success' => false, 'message' => 'Produkty już nie istnieją w bazie.']);
    exit;
}

$total_final_price = 0;
$order_items = [];

foreach ($products as $product) {
    $id = (int)$product['id'];
    $quantity = $item_counts[$id];
    
    $cena_db = str_replace(',', '.', $product['cena']);
    $original_price = (float)$cena_db;
    $actual_price = $original_price;
    
    if ($product['promocja'] > 0) {
        $discount = (float)$product['promocja'];
        $actual_price = $original_price - ($original_price * ($discount / 100));
    }
    
    $total_final_price += ($actual_price * $quantity);
    
    $order_items[] = [
        'id' => $id,
        'quantity' => $quantity
    ];
}

global $dbhost, $dbname, $dbusername, $dbpassword, $charset;
$dbh = null;

try {
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset;", $dbusername, $dbpassword);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $uzytkownik_id = null;
    if (isset($_SESSION['user'])) {
        $stmt_user = $dbh->prepare("SELECT id FROM uzytkownik WHERE login = ?");
        $stmt_user->execute([$_SESSION['user']]);
        $user_row = $stmt_user->fetch(PDO::FETCH_ASSOC);
        if ($user_row) {
            $uzytkownik_id = $user_row['id'];
        }
    }

    $status_id = 1; 

    $dbh->beginTransaction();
    
    $stmt = $dbh->prepare("INSERT INTO zamowienie (data_zamowienia, status_id, uzytkownik_id, cena) VALUES (NOW(), ?, ?, ?)");
    $stmt->execute([$status_id, $uzytkownik_id, $total_final_price]);
    $order_id = $dbh->lastInsertId();
    
    $stmt_items = $dbh->prepare("INSERT INTO zawartosc_zamowienia (ilosc, zamowienie_id, produkt_id) VALUES (?, ?, ?)");
    foreach ($order_items as $item) {
        $stmt_items->execute([$item['quantity'], $order_id, $item['id']]);
    }
    
    $dbh->commit();
    
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (PDOException $e) {
    $dbh->rollBack();
    echo json_encode(['success' => false, 'message' => 'Błąd bazy danych: ' . $e->getMessage()]);
}
?>