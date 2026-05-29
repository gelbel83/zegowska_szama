<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');

    $current_user = $_SESSION['user'] ?? '';
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php create_head_tags() ?>

        <script>const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;</script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous" defer></script>
    </head>
    
    <body class="d-flex flex-column min-vh-100 bg-light">
        <?php create_header(); ?>

        <main class="container py-4 flex-grow-1">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold">Twoje zamówienia</h2>
                </div>
            </div>

            <div id="orders_display" class="row"> 
                <div class="col-12">
                    <?php 
                        $orders_sql = "SELECT 
                                        zamowienie.id AS z_id, 
                                        zamowienie.data_zamowienia AS z_data, 
                                        zamowienie.cena AS z_cena, 
                                        status.nazwa AS z_status, 
                                        produkt.nazwa AS p_nazwa, 
                                        zawartosc_zamowienia.ilosc AS p_ilosc 
                                     FROM zamowienie 
                                     JOIN zawartosc_zamowienia ON zawartosc_zamowienia.zamowienie_id = zamowienie.id 
                                     JOIN produkt ON produkt.id = zawartosc_zamowienia.produkt_id 
                                     JOIN status ON status.id = zamowienie.status_id 
                                     JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id 
                                     WHERE zamowienie.status_id < 4 AND uzytkownik.login = ? 
                                     ORDER BY zamowienie.data_zamowienia DESC";
                        
                        $orders_arr = mysqli_select_values($orders_sql, array($current_user), 1);   
                        
                        $grouped_orders = [];
                        if (!empty($orders_arr)) {
                            foreach ($orders_arr as $row) {
                                $id = $row['z_id'];
                                if (!isset($grouped_orders[$id])) {
                                    $grouped_orders[$id] = [
                                        'id' => $id,
                                        'data' => $row['z_data'],
                                        'cena' => $row['z_cena'],
                                        'status' => $row['z_status'],
                                        'produkty' => []
                                    ];
                                }
                                $grouped_orders[$id]['produkty'][] = [
                                    'nazwa' => $row['p_nazwa'],
                                    'ilosc' => $row['p_ilosc']
                                ];
                            }
                        }

                        if (!empty($grouped_orders)) {
                            foreach ($grouped_orders as $order) {
                                $status_color = 'bg-secondary';
                                if ($order['status'] == 'Nowe') $status_color = 'bg-primary';
                                if ($order['status'] == 'W przygotowaniu') $status_color = 'bg-warning text-dark';
                                if ($order['status'] == 'Gotowe') $status_color = 'bg-success';

                                echo "<div class='card shadow-sm w-100 mb-3'>";
                                echo "  <div class='card-body'>";
                                
                                echo "      <div class='d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3'>";
                                echo "          <div>";
                                echo "              <h4 class='mb-1 fw-bold'>Zamówienie #" . $order['id'] . "</h4>";
                                echo "              <p class='text-muted mb-0'><i class='bi bi-calendar3 me-2'></i>" . $order['data'] . "</p>";
                                echo "          </div>";
                                echo "          <div class='mt-2 mt-sm-0 text-start text-sm-end'>";
                                echo "              <span class='badge {$status_color} rounded-pill fs-6 mb-1'>" . $order['status'] . "</span>";
                                echo "              <h4 class='fw-bold mb-0'>" . number_format($order['cena'], 2, '.', '') . " zł</h4>";
                                echo "          </div>";
                                echo "      </div>";
                                
                                echo "      <button class='btn orange-button text-white fw-bold w-100' type='button' data-bs-toggle='collapse' data-bs-target='#orderDetails" . $order['id'] . "' aria-expanded='false' aria-controls='orderDetails" . $order['id'] . "'>";
                                echo "          Szczegóły zamówienia";
                                echo "      </button>";
                                
                                echo "      <div class='collapse mt-3' id='orderDetails" . $order['id'] . "'>";
                                echo "          <div class='card card-body bg-light border-0'>";
                                echo "              <h6 class='fw-bold mb-3'>Produkty:</h6>";
                                echo "              <ul class='list-group list-group-flush'>";
                                
                                foreach ($order['produkty'] as $prod) {
                                    echo "              <li class='list-group-item bg-transparent d-flex justify-content-between align-items-center px-0 border-bottom-0'>";
                                    echo "                  " . $prod['nazwa'];
                                    echo "                  <span class='badge bg-dark rounded-pill'>" . $prod['ilosc'] . " szt.</span>";
                                    echo "              </li>";
                                }
                                
                                echo "              </ul>";
                                echo "          </div>";
                                echo "      </div>";

                                echo "  </div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='text-center py-5'>";
                            echo "  <h3 class='text-muted'>Nie masz jeszcze żadnych zamówień.</h3>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </main>

        <?php create_footer(); ?>
    </body>
</html>