<?php
session_start();
require_once(__DIR__ . '/functions.php');

$json = file_get_contents('php://input');
$cart_ids = json_decode($json, true);

if (empty($cart_ids)) {
    echo "<div class='d-flex flex-column justify-content-center align-items-center w-100 h-100 text-center p-4'>";
    echo "  <i class='bi bi-cart-x mb-3' style='font-size: 5rem; color: #212529;'></i>";
    echo "  <h2 class='fw-bold text-dark'>Twój koszyk jest pusty :(</h2>";
    echo "</div>";
    exit;
}

$safe_ids = array_map('intval', $cart_ids);
$item_counts = array_count_values($safe_ids);

$unique_ids = array_keys($item_counts);
$num_ids = count($unique_ids);

$placeholders = implode(',', array_fill(0, $num_ids, '?'));
$sql = "SELECT id, nazwa, cena, promocja, zdjecie FROM produkt WHERE id IN ($placeholders)";
$products = mysqli_select_values($sql, $unique_ids, $num_ids);

if (!empty($products)) {
    $total_original_price = 0;
    $total_final_price = 0;
    
    echo "<div class='container py-4'>";
    echo "  <div class='row g-4'>";
    
    echo "    <div class='col-12 col-lg-8'>";
    echo "      <h3 class='mb-4 fw-bold'>Twoja szama:</h3>";

    foreach ($products as $product) {
        $id = (int)$product['id'];
        $quantity = isset($item_counts[$id]) ? (int)$item_counts[$id] : 1; 
        
        $cena_db = str_replace(',', '.', $product['cena']);
        $original_price = (float)$cena_db;
        $actual_price = $original_price;
        
        if ($product['promocja'] > 0) {
            $discount = (float)$product['promocja'];
            $actual_price = $original_price - ($original_price * ($discount / 100));
        }
        
        $total_original_price += ($original_price * $quantity);
        $total_final_price += ($actual_price * $quantity);
        
        $disabledStyle = ($quantity <= 1) ? 'disabled' : '';
        
        $image_src = (!empty($product['zdjecie'])) ? '/resources/produkty/' . $product['zdjecie'] : 'https://via.placeholder.com/150x150?text=Insert+Zdjecie';

        echo "<div class='card mb-3 p-3 border rounded-3 shadow-sm'>";
        echo "  <div class='row align-items-center g-3'>";
        
        echo "    <div class='col-4 col-sm-3 text-center'>";
        echo "      <img src='{$image_src}' class='img-fluid rounded-3' style='max-height: 110px; object-fit: cover;' alt='szama'>";
        echo "    </div>";
        
        echo "    <div class='col-8 col-sm-9'>";
        echo "      <div class='d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2'>";
        echo "          <h4 class='fw-bold mb-0'>" . htmlspecialchars($product['nazwa']) . "</h4>";
        
        echo "          <div class='d-flex align-items-center border rounded-3 p-1 bg-light'>";
        echo "              <button class='btn btn-sm remove-product me-1' data-id='{$id}' title='Usuń z koszyka'><i class='bi-trash'></i></button>";
        echo "              <button class='btn btn-sm btn-outline-dark decrease-quantity' data-id='{$id}' {$disabledStyle}>-</button>";
        echo "              <strong class='fs-5 mx-3'>{$quantity}</strong>";
        echo "              <button class='btn btn-sm btn-outline-dark increase-quantity' data-id='{$id}'>+</button>";
        echo "          </div>";
        echo "      </div>";
        
        echo "      <div class='d-flex justify-content-between align-items-end mt-3'>";
        if ($product['promocja'] > 0) {
            echo "          <span class='fw-bold text-danger fs-3'>-{$product['promocja']}%</span>";
            echo "          <div class='text-end'>";
            echo "              <small class='text-muted d-block'>" . number_format($original_price, 2, '.', '') . " zł / szt</small>";
            echo "              <strong class='fs-4 text-dark'>" . number_format($actual_price, 2, '.', '') . " zł</strong>";
            echo "          </div>";
        } else {
            echo "          <span></span>";
            echo "          <div class='text-end'>";
            echo "              <strong class='fs-4 text-dark'>" . number_format($actual_price, 2, '.', '') . " zł</strong>";
            echo "          </div>";
        }
        echo "      </div>";
        
        echo "    </div>";
        echo "  </div>"; 
        echo "</div>"; 
    }
    echo "    </div>"; 

    $total_savings = $total_original_price - $total_final_price;
    
    echo "    <div class='col-12 col-lg-4'>";
    echo "      <div class='sticky-top' style='top: 20px;'>";
    
    echo "        <div class='card p-4 border rounded-3 bg-white shadow-sm mb-3'>";
    echo "            <div class='d-flex justify-content-between mb-2'>";
    echo "                <span class='text-muted fs-5'>Suma częściowa</span>";
    echo "                <span class='fw-bold fs-5'>" . number_format($total_original_price, 2, '.', '') . " zł</span>";
    echo "            </div>";
    echo "            <div class='d-flex justify-content-between mb-3 text-success'>";
    echo "                <span class='fs-5'>Zaoszczędziłeś</span>";
    echo "                <span class='fw-bold fs-5'>-" . number_format($total_savings, 2, '.', '') . " zł</span>";
    echo "            </div>";
    echo "            <hr>";
    echo "            <div class='d-flex justify-content-between align-items-center my-2'>";
    echo "                <span class='fw-bold h3 mb-0'>Łącznie</span>";
    echo "                <span class='fw-bold h2 mb-0 text-dark'>" . number_format($total_final_price, 2, '.', '') . " zł</span>";
    echo "            </div>";
    echo "        </div>";
    
    echo "        <button id='place-order-button' class='btn w-100 py-3 fs-4 fw-bold rounded-3 shadow orange-button'>Złóż zamówienie</button>";
    
    echo "      </div>";
    echo "    </div>";
    
    echo "  </div>";
    echo "</div>";
    
} else {
    echo "<div class='d-flex flex-column justify-content-center align-items-center w-100 h-100 text-center'>";
    echo "  <h4 class='text-danger'>Nie udało się załadować produktów.</h4>";
    echo "</div>";
}
?>