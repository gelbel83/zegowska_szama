<?php
    session_start();
    require_once(__DIR__ . '/php/functions.php');
    require_once(__DIR__ . '/php/components.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php create_head_tags(true)?>

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

        <script src="js/popups.js" defer></script>
        <script src="js/scroll.js" defer></script>
    </head>
    
    <body class="d-flex flex-column">
        <?php create_header(true)?>

        <?php if (isset($_SESSION['user'])): ?>
        <section class="sales-section d-flex flex-column p-3 ">
            <h3>Po taniości</h3>
            <div class="sales-container h-25">
                <?php 
                    $products_sql = "SELECT *, produkt.id AS id_pr, produkt.nazwa AS nazwa_pr, kategoria.nazwa AS nazwa_kat FROM produkt JOIN kategoria on kategoria_id=kategoria.id WHERE produkt.promocja > 0;";
                    $products_arr = mysqli_select_no_parameters($products_sql);
                    if(!empty($products_arr)){
                        foreach($products_arr as $product){
                            echo "<div class='product card m-1'>";

                            echo "<h4>".$product['nazwa_pr']."</h4>"; 
                             
                            echo "Kategoria: ";
                            echo $product['nazwa_kat']; 
                            echo "<br>";

                            echo "Cena: ";
                            echo number_format($product['cena'], 2, '.', '') . "zł";
                            echo "<br>";
                            if($product['promocja'] > 0){
                                echo "-".$product['promocja'] . "%";
                            }
                            
                            if($product['dostepnosc'] == 1){
                                echo "dostępny";
                            }
                            else{
                                echo "niedostępny";
                            }
                            echo "<br>";

                            echo "<button class='to-cart-button' id='to-cart-".$product['id_pr']."'>Dodaj do koszyka</button>";
                            
                            echo "</div>";
                            //ogarnac popupa dla produktu wedlug id
                            //ogarnac popupa dla usuwania
                        }
                    }
                ?>
            </div>
        </section>
        <?php endif; ?>

        <section class="d-flex flex-column p-3">
            <h3>Co u nas wszamasz?</h3>
            <div class="products-container">
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

                            echo "Cena: ";
                            echo number_format($product['cena'], 2, '.', '') . "zł";
                            echo "<br>";
                            if($product['promocja'] > 0){
                                echo "-".$product['promocja'] . "%";
                            }
                            
                            if($product['dostepnosc'] == 1){
                                echo "dostępny";
                            }
                            else{
                                echo "niedostępny";
                            }
                            echo "<br>";
                            
                            echo "<button class='to-cart-button' id='to-cart-".$product['id_pr']."'>Dodaj do koszyka</button>";
                            
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </section>

        <?php create_footer() ?>

        <div id="login-popup" class="popup hidden p-4">
            <form method="post">
                <div class="form-group m-3">
                    <label for="login-email" class="m-1">Login lub e-mail</label>
                    <input type="text" class="form-control m-1 " name="login-email" required />
                </div>

                <div class="form-group m-3">
                    <label for="passwd" class="m-1">Hasło</label>
                    <input type="password" class="form-control m-1 " name="passwd" required />
                </div>

                <div class="form-group m-3">
                    <span>Nie masz konta? Zarejestruj się <span class="show-popup-text" id="show-register-popup-span">tutaj!</span></span>
                </div>

                <div class="d-flex align-items-center justify-content-center"><button type="submit" id="login-button" name="login-button" class="btn w-75">Zaloguj</button></div>
            </form>
            
            <?php 
                if(isset($_POST['login-button'])){
                    $login_email = $_POST['login-email'];
                    $passwd = $_POST['passwd'];
                    
                    if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
                        $email = $login_email;
                        check_login($email);
                    }
                    else{
                        check_login($login_email);
                    }
                }
            ?>
        </div>
       
        <div id="register-popup" class="popup hidden p-4">
            <form method="post">
                <div class="form-group m-3">
                    <label for="login" class="m-1">Login</label>
                    <input type="text" class="form-control m-1" name="login" required />
                </div>

                <div class="form-group m-3">
                    <label for="email" class="m-1">E-mail</label>
                    <input type="email" class="form-control m-1" name="email" required />
                </div>

                <div class="form-group m-3">
                    <label for="passwd" class="m-1">Hasło</label>
                    <input type="password" class="form-control m-1" name="passwd" required />
                </div>

                <div class="form-group m-3">
                    <label for="repeat-passwd" class="m-1">Powtórz hasło</label>
                    <input type="password" class="form-control m-1" name="repeat-passwd" required />
                </div>

                <div class="form-group m-3">
                    <label for="name" class="m-1">Imię</label>
                    <input type="text" class="form-control m-1" name="name" required />
                </div>

                <div class="form-group m-3">
                    <label for="surname" class="m-1">Nazwisko</label>
                    <input type="text" class="form-control m-1" name="surname" required />
                </div>

                <div class="form-group m-3">
                    <span>Masz już konto? Zaloguj się <span class="show-popup-text" id="show-login-popup-span">tutaj!</span></span>
                </div>

                <div class="d-flex align-items-center justify-content-center"><button type="submit" id="register-button" name="register-button" class="btn w-75">Zarejestruj</button></div>
            </form>

            <?php 
                $query = "INSERT INTO `uzytkownik`(`login`, `email`, `haslo`, `imie`, `nazwisko`, `uprawnienia_id`) VALUES (?, ?, ?, ?, ?, 1)";
                if(isset($_POST['register-button'])){
                    $login = $_POST['login'];
                    $email = $_POST['email'];
                    $passwd = $_POST['passwd'];
                    $repeat_passwd = $_POST['repeat-passwd'];
                    $name = $_POST['name'];
                    $surname = $_POST['surname'];
                    
                    mysqli_change_values($query, array($login, $email, $passwd, $name, $surname), 5);
                }
            ?>
        </div>
        <script src="./js/to_cart.js"></script>
    </body>
</html>