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

        <script src="../js/popups.js"></script>
    </head>
    
    <body class="d-flex flex-column vh-100">
        <?php create_header();
            if ($_SESSION['user_type'] !== 2){
                header("Location: /");
            }
        ?>
        <main class='flex-fill d-flex flex-column justify-content-start align-items-center'>
            <div class="current-page-buttons d-flex align-items-center justify-content-center w-100 p-3">
                <button type="submit" name="users-page-button" class="btn w-100" onclick="window.location.href = '?page=users'">Użytkownicy</button>
                <button type="submit" name="products-page-button" class="btn w-100" onclick="window.location.href = '?page=products'">Produkty</button>
                <button type="submit" name="orders-page-button" class="btn w-100" onclick="window.location.href = '?page=orders'">Zamówienia</button>
            </div>
            <?php 
              if ((isset($_GET['page']) && $_GET['page']=='users') || !isset($_GET['page'])): 
            ?>
            <div class="users-container d-flex"> 
                <?php 
                    $users_sql = "SELECT * FROM uzytkownik";
                    $users_arr = mysqli_select_no_parameters($users_sql);
                    if(!empty($users_arr)){
                        foreach($users_arr as $user){
                            echo "<div class='user card m-1'>";
                            echo "Login: ";
                            echo $user['login'];
                            echo "<br>";
                            echo "Email: ";
                            echo $user['email'];
                            echo "<br>";
                            echo "Imię: ";
                            echo $user['imie'];
                            echo "<br>";
                            echo "Nazwisko: ";
                            echo $user['nazwisko'];
                            echo "<br>";
                           
                            echo "Typ użytkownika: ";
                            if($user['uprawnienia_id'] == 2){
                                echo "administrator";
                            }
                            else{
                                echo "użytkownik";
                            }
                            echo "<button class='edit-user-button'>Zmień</button>";
                            echo "<button class='remove-user-button'>Usuń</button>";
                            echo "</div>";
                            //ogarnac popupa dla usera wedlug id
                            //ogarnac popupa dla usuwania
                        }
                    }
                    else{
                        echo "<h3> Brak danych </h3>";
                    }
                ?>
            </div>
            
            <!-- fajnie by było jak byś mógł jakoś przekazać id i login tego usera - login do wyswietlenia, id do kwerendy-->
            <div class="popup card hidden" id="user_access_popup"> 
                <div> tu login </div>
                <form method="post" action=""> 
                    <select name="user_access">
                        <option value="1"> użytkownik </option>
                        <option value="2"> administrator </option>
                    </select>
                    <input type="submit" name="change_user" value="Zmień">
                </form>
                <?php 
                    if(isset($_POST['change_user'])){
                        $user_sql = "UPDATE uzytkownik SET uprawnienia_id = ? WHERE id = ?;";
                        $user_access = $_POST['user_access'];
                        $user_id = 4; //gunk ogarnij przekazywanie id
                        mysqli_change_values($user_sql, array($user_access, $user_id), 2);
                    }
                ?>
            </div>
            <div class="popup card hidden" id="delete_user_confirm"> 
                <input type="submit" name="user_d_confirm" value="Usuń">
                <button onclick="//zamknij popupa">Anuluj</button>
                <?php 
                    if(isset($_POST['user_d_confirm'])){
                        $user_del_sql = "DELETE FROM uzytkownik where id = ?";
                        $user_id = 0;//gunk ogarnij przekazywanie id
                        mysqli_change_values($user_del_sql, array($user_id), 1);
                    }
                ?>
            </div>

            <?php endif;?>
             <?php 
              if ((isset($_GET['page']) && $_GET['page']=='products')): 
            ?>
            <div class="products-div"> 
                <button id="add-product-button" class = "w-100">dodaj produkt</button>
                <div class="products-container d-flex overflow-scroll"> 
                <?php 
                    $products_sql = "SELECT *, produkt.id AS id_pr, produkt.nazwa AS nazwa_pr, kategoria.nazwa AS nazwa_kat FROM produkt JOIN kategoria on kategoria_id=kategoria.id;";
                    $products_arr = mysqli_select_no_parameters($products_sql);
                    if(!empty($products_arr)){
                        foreach($products_arr as $product){
                            echo "<div class='product card m-1'>";

                            echo "<h4>".$product['nazwa_pr']."</h4>"; 
                            
                            echo "Kategoria: ";
                            echo $product['nazwa_kat']; 
                            echo "<br>";

                            echo "Cena podstawowa: ";
                            echo number_format($product['cena'], 2, '.', '') . "zł";
                            echo "<br>";
                            echo "Promocja: ";
                            echo $product['promocja'] . "%";
                            echo "<br>";
                            echo "Dostępność: ";
                            if($product['dostepnosc'] == 1){
                                echo "dostępny";
                            }
                            else{
                                echo "niedostępny";
                            }
                            echo "<br>";

                            echo "<button>Edytuj</button>";
                            echo "<button>Usuń</button>";
                            echo "</div>";
                            //ogarnac popupa dla produktu wedlug id
                            //ogarnac popupa dla usuwania
                        }
                    }
                    else{
                        echo "<h3> Brak danych </h3>";
                    }
                ?>
                </div>
            </div>
            <div class="popup card hidden" id="product_edit_popup"> 
                <form method="post" action=""> 
                    <label for="nazwa_pr">Nazwa: </label>
                    <input type="text" name="nazwa_pr" value=""> <!--value z bazy gunk ogarnij dla każdego inputa-->
                    <label for="cena_pr">Cena: </label>
                    <input type="text" name="cena_pr" value="">
                    <label for="dostepnosc_pr">Dostępny: </label>
                    <input type="checkbox" name="dostepnosc_pr" value="">
                    <label for="promocja_pr">Promocja: </label>
                    <input type="number" name="promocja_pr" value="">
                    <input type="submit" name="change_product" value="Zapisz">
                </form>
                <?php 
                    if(isset($_POST['change_product'])){
                        $product_sql = "UPDATE produkt SET nazwa=?, cena=?, dostepnosc=?, promocja=? WHERE produkt.id = ?;";
                        $product_name = $_POST['nazwa_pr'];
                        $product_price = $_POST['cena_pr'];
                        $product_availability = $_POST['dostepnosc_pr'];
                        $product_sale = $_POST['promocja_pr'];
                        $product_id = -1; //gunk ogarnij przekazywanie id
                        mysqli_change_values($product_sql, array($product_name, $product_price, $product_availability, $product_sale, $product_id), 5);
                    }
                ?>
            </div>
            <div class="popup card hidden" id="delete_product_confirm"> 
                <input type="submit" name="product_d_confirm" value="Usuń">
                <button onclick="//zamknij popupa">Anuluj</button>
                <?php 
                    if(isset($_POST['user_d_confirm'])){
                        $product_del_sql = "DELETE FROM produkt where id = ?";
                        $product_id = 0;//gunk ogarnij przekazywanie id
                        mysqli_change_values($product_del_sql, array($product_id), 1);
                    }
                ?>
            <?php endif;?>
             <?php 
              if ((isset($_GET['page']) && $_GET['page']=='orders')): 
            ?>
            <div class="orders-div"> 
                <?php 
                    $orders_sql = "SELECT zamowienie.id AS z_id, zamowienie.data_zamowienia AS z_data, zamowienie.cena AS z_cena, status.nazwa AS z_status, uzytkownik.login AS z_login FROM zamowienie JOIN status ON zamowienie.status_id = status.id JOIN uzytkownik ON uzytkownik.id = zamowienie.status_id;"; 
                    $orders_arr = mysqli_select_no_parameters($orders_sql);
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
            <?php endif;?>
        </main>
        
        <?php create_footer();?>

        </div>
    </body>
</html>



