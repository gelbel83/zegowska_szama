<?php
    session_start();
    $mysql = mysqli_connect("localhost", "root", '', "zegowska_szama");
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
        <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="./style.css" type="text/css" />
        <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon" />

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

        <script src="src/popups.js" defer></script>
    </head>
    
    <body class="d-flex flex-column">
        <header class="w-100 d-flex align-items-center justify-content-center my-3">
            <img src="resources/logo.gif" alt="ZEGOWSKA SZAMA" id="logo-image"/>
        </header>
        
        <nav class="d-flex align-items-center justify-content-start">
            <button id="admin-panel-button" class="btn">Panel administratora</button>

            <a href="/zamowienia" class="nav-link"><i class="bi bi-receipt"></i></a>
            <a href="/koszyk" class="nav-link"><i class="bi bi-cart"></i></a>
            <a href="#" id="konto-link" class="nav-link"><i class="bi bi-person-circle"></i></a>
            <a href="/ustawienia" class="nav-link"><i class="bi bi-gear"></i></a>
        </nav>

        <section class="sales-section d-flex flex-column p-3">
            <h3>Po taniości</h3>
            <div class="sales-containers">
                <div class="sales-container">
                    
                </div>
            </div>
        </section>

        <section class="d-flex flex-column p-3">
            <h3>Co u nas wszamasz?</h3>
            <div class="products-container">

            </div>
        </section>

        <footer class="w-100 d-flex align-items-center justify-content-center my-3">
            <p class="m-0">siema tu stopka</p>
        </footer>

        <!--popupy-->

        <div id="login-popup" class="popup hidden w-25 p-4">
            <form method="post">
                <div class="form-group m-3">
                    <label for="login-email" class="m-1">Login lub e-mail</label>
                    <input type="text" class="form-control m-1 email-input" name="login-email" required />
                </div>

                <div class="form-group m-3">
                    <label for="password" class="m-1">Hasło</label>
                    <input type="password" class="form-control m-1 password-input" name="password" required />
                </div>

                <div class="form-group m-3">
                    <span>Nie masz konta? Zarejestruj się <span class="show-popup-text" id="show-register-popup-span">tutaj!</span></span>
                </div>

                <div class="d-flex align-items-center justify-content-center"><button type="submit" id="login-button" name="login" class="btn w-75">Zaloguj</button></div>
            </form>
        </div>

        <?php

        ?>

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
                    <label for="password" class="m-1">Hasło</label>
                    <input type="password" class="form-control m-1" name="password" required />
                </div>

                <div class="form-group m-3">
                    <label for="repeat-password" class="m-1">Powtórz hasło</label>
                    <input type="password" class="form-control m-1" name="repeat-password" required />
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

                <div class="d-flex align-items-center justify-content-center"><button type="submit" id="register-button" name="register" class="btn w-75">Zarejestruj</button></div>
            </form>
        </div>
    </body>
</html>

<?php
    mysqli_close($mysql);
?>


