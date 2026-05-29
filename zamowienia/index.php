<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php create_head_tags()?>

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

    </head>
    
    <body class="d-flex flex-column vh-100">
        <?php create_header();?>

        <div id="orders_display"> 
            <?php 
                if($_SESSION['user_type'] == 2){
                    $orders_sql = "SELECT zamowienie.id, zamowienie.data_zamowienia, zamowienie.cena, status.nazwa as nazwa_st, uzytkownik.login, produkt.nazwa as nazwa_pr, zawartosc_zamowienia.ilosc FROM zamowienie JOIN zawartosc_zamowienia ON zawartosc_zamowienia.zamowienie_id = zamowienie.id JOIN produkt ON produkt.id=zawartosc_zamowienia.produkt_id JOIN status ON status.id = zamowienie.status_id JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id WHERE zamowienie.status_id < 4"; 
                    $orders_arr = mysqli_select_no_parameters($orders_sql);
                }else{
                    $orders_sql = "SELECT zamowienie.id, zamowienie.data_zamowienia, zamowienie.cena, status.nazwa as nazwa_st, uzytkownik.login, produkt.nazwa as nazwa_pr, zawartosc_zamowienia.ilosc FROM zamowienie JOIN zawartosc_zamowienia ON zawartosc_zamowienia.zamowienie_id = zamowienie.id JOIN produkt ON produkt.id=zawartosc_zamowienia.produkt_id JOIN status ON status.id = zamowienie.status_id JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id WHERE zamowienie.status_id < 4 AND uzytkownik.login LIKE (?)"; 
                    $orders_arr = mysqli_select_values($orders_sql, array($_SESSION['user']), 1);   
                }
                
                
                if(!empty($orders_arr)){
                    foreach($orders_arr as $order){
                        echo "<div class='order card m-1'>";

                        echo "<h4> Zamówienie nr. ".$order['z_id']."</h4>";
                        echo "Data zamówienia: ";
                        echo $order['z_data'];
                        echo "<br>";
                        echo "Zamawiający: ";
                        echo $order['z_login'];
                        echo "<br>";
                        echo "Cena: ";
                        echo $order['z_cena'];
                        echo "<br>";
                        echo "Status: ";
                        echo $order['z_status'];
                        echo "<br>";

                        echo "<button>Szczegóły</button>";
                        echo "</div>";
                        //ogarnac popupa dla zamowienia wedlug id
                    }
                }
                else{
                    echo "<h3> Brak danych </h3>";
                }
            ?>
        </div>
        <div class="popup card hidden" id="order_edit_popup"> 
            <?php 
                $all_orders_sql = $orders_sql . " AND zamowienie.id = ?";
                $all_orders_arr = mysqli_select_values($all_orders_sql, array(1, 1), 1); //gunk pobierz wartosc nie wiem jak to zrobisz ale zrob glhf
                echo "Numer zamówienia: ".$all_orders_arr[0]['id'];
                echo "Data zamówienia: ".$all_orders_arr[0]['data_zamowienia'];
                echo "Cena zamówienia: ".$all_orders_arr[0]['cena'];
                echo "Status zamówienia: ".$all_orders_arr[0]['nazwa_st'];
                echo "Zamawiający: ".$all_orders_arr[0]['login'];
                echo "Produkty: ";
                foreach($all_orders_arr as $order){
                    echo $order['nazwa_pr'] . " - ilość: " . $order['ilosc'];
                }
            ?>
        </div>
        <?php create_footer();?>

        <script src='../js/from_cart.js'> </script>
    </body>
</html>