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
                    $orders_sql = "SELECT zamowienie.id, zamowienie.data_zamowienia, zamowienie.cena, status.nazwa, uzytkownik.login, produkt.nazwa, zawartosc_zamowienia.ilosc FROM zamowienie JOIN zawartosc_zamowienia ON zawartosc_zamowienia.zamowienie_id = zamowienie.id JOIN produkt ON produkt.id=zawartosc_zamowienia.produkt_id JOIN status ON status.id = zamowienie.status_id JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id WHERE zamowienie.status_id < 4;"; 
                    $orders_arr = mysqli_select_no_parameters($orders_sql);
                }else{
                    $orders_sql = "SELECT zamowienie.id, zamowienie.data_zamowienia, zamowienie.cena, status.nazwa, uzytkownik.login, produkt.nazwa, zawartosc_zamowienia.ilosc FROM zamowienie JOIN zawartosc_zamowienia ON zawartosc_zamowienia.zamowienie_id = zamowienie.id JOIN produkt ON produkt.id=zawartosc_zamowienia.produkt_id JOIN status ON status.id = zamowienie.status_id JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id WHERE zamowienie.status_id < 4 AND uzytkownik.login LIKE (?);"; 
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
                        echo "<button>Usuń</button>";
                        echo "</div>";
                        //ogarnac popupa dla zamowienia wedlug id
                        //ogarnac popupa dla usuwania
                    }
                }
                else{
                    echo "<h3> Brak danych </h3>";
                }
            ?>
        </div>
        
        <?php create_footer();?>

        <script src='../js/from_cart.js'> </script>
    </body>
</html>