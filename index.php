<?php
    session_start();
    require_once('.\php\functions.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ZEGOWSKA SZAMA</title>

        <meta lang="pl" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Podkova:wght@400..800&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="./style.css" type="text/css" />
        <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon" />

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

        <script src="js/popups.js" defer></script>
        <script src="js/scroll.js" defer></script>
    </head>
    
    <body class="d-flex flex-column">
        <header class="w-100 d-flex align-items-center justify-content-center my-3">
            <img src="resources/logo.gif" alt="ZEGOWSKA SZAMA" id="logo-image"/>
        </header>
        
        <nav class="d-flex align-items-center justify-content-end">
            <button id="admin-panel-button" class="btn" onclick="window.location.href = '/admin'" style="<?php if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 1  ){
                echo "display:none;";
                }?>">Panel administratora</button>
            <?php if (isset($_SESSION['user'])): ?>
            <a href="/zamowienia" class="nav-link"><i class="bi bi-receipt"></i></a>
            <a href="/koszyk" class="nav-link"><i class="bi bi-cart"></i></a>
            <?php endif;?>
            <a href="<?php if(isset($_SESSION['user'])) {
                echo "/konto";
            }else{
                echo "javascript:void(0);";
                }?>" id="konto-link" class="nav-link"><i class="bi bi-person-circle"></i></a>
        </nav>
        <?php if (isset($_SESSION['user'])): ?>
        <section class="sales-section d-flex flex-column p-3 ">
            <h3>Po taniości</h3>
                <div>
                    <button class="scroll-btn btn-left" onclick="scrollContainer(-(document.getElementById('product-scroll-container').style.width/2))">&#10094;</button>
                    <button class="scroll-btn btn-right" onclick="scrollContainer((document.getElementById('product-scroll-container').style.width/2))">&#10095;</button>
                    <div id='product-scroll-container' class='d-flex flex-nowrap gap-3 overflow-auto p-2' style='scroll-behavior: smooth;'>
                    <?php 
                        $sales_sql = "SELECT * FROM produkt WHERE promocja > 0;";
                        $sales_arr = mysqli_select_no_parameters($sales_sql);
                        if($sales_arr != null){
                            foreach($sales_arr as $sale){
                                echo "<div class='product-card card flex-row p-3 align-items-center justify-content-between shadow-sm'>
                                    <div class='d-flex flex-column align-items-center w-50 pe-2'>
                                        <h3 class='fw-bold mb-2'>";
                                        
                                echo $sale['nazwa'];
                                echo "</h3>
                                        <img src='/resources/produkty/bulki/";
                                echo $sale['zdjecie'];
                                        echo "' class='img-fluid rounded' style='max-height: 100px; object-fit: cover;' />
                                    </div>
                                    
                                    <div class='d-flex flex-column align-items-center w-50 ps-2 border-start'>
                                        <span class='badge mb-1 fs-6'>";
                                        echo floatval($sale['promocja'])*100 . '%'; 
                                        echo "</span>
                                        <h2 class='fw-bold text-dark mb-3'>";
                                        echo floatval($sale['cena']) . 'zł'; 
                                        echo "</h2>
                                        <button class='btn w-100 fw-semibold btn-sm'>Do koszyka</button>
                                    </div>
                                </div>";
                            }
                        }
                        else {
                            echo "<h4> Brak promocji </h4>";
                        }
                    ?>
                    </div>
                </div>
        </section>
        <?php endif; ?>
        <section class="d-flex flex-column p-3">
            <h3>Co u nas wszamasz?</h3>
            <div class="products-container">

            </div>
        </section>

        <footer class='w-100 d-flex align-items-center justify-content-center my-3 flex-column flex-md-row'>
            <div class='m-2'><div>Pomoc techniczna:</div><div>+48 882 466 642</div><div>pomoc_szama@zeg.pl</div></div>
            <div class='m-2'><div>Kontakt z właścicielami sklepiku:</div><div>+48 412 642 537</div><div>sklepik_szama@zeg.pl</div></div>
            <div class='m-2'><div>Autorzy:</div><div>Konrad Goliński</div><div>Kacper Gonciarz</div></div>
        </footer>

        <!--popupy-->

        <div id="login-popup" class="popup hidden w-25 p-4">
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
       
        <div id="register-popup" class="popup hidden w-25 p-4">
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
    </body>
</html>