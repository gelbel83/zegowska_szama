<?php
    session_start();
    require_once('..\php\functions.php');

    $account_info_query = "SELECT * FROM uzytkownik WHERE login LIKE(?)";
    $account_info = mysqli_select_values($account_info_query, array($_SESSION['user']), 1) [0];
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

        <link rel="stylesheet" href="../style.css" type="text/css" />
        <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon" />

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

    </head>
    
    <body class="d-flex flex-column">
        <header class="w-100 d-flex align-items-center justify-content-center my-3">
            <img src="../resources/logo.gif" alt="ZEGOWSKA SZAMA" id="logo-image"/>
        </header>
        
        <nav class="d-flex align-items-center justify-content-start">
            <button id="admin-panel-button" class="btn" style="<?php if(!isset($_SESSION['user_type']) || $_SESSION['user_type']==1 ){
                echo "display:none;";
                }?>" >Panel administratora</button>

            <a href="/zamowienia" class="nav-link"><i class="bi bi-receipt"></i></a>
            <a href="/koszyk" class="nav-link"><i class="bi bi-cart"></i></a>
            <a href="<?php if(isset($_SESSION['user'])) {
                echo "/konto";
            }else{
                echo "$host/";
                }?>" id="konto-link" class="nav-link"><i class="bi bi-person-circle"></i></a>
            <a href="/ustawienia" class="nav-link"><i class="bi bi-gear"></i></a>
        </nav>
        <main class='card text-center'>
            <p>
                <h5>Login </h5>
                <?php 
                    echo $account_info['login'];
                ?>
            </p>
            <p>
                <h5>Imie </h5>
                <?php 
                    echo $account_info['imie'];
                ?>
            </p>
            <p>
                <h5>Nazwisko </h5>
                <?php 
                    echo $account_info['nazwisko'];
                ?>
            </p>
            <p>
                <h5>email </h5>
                <?php 
                    echo $account_info['email'];
                ?>
            </p>
            <a href="/"><button>Powrót do strony głównej</button></a>
        </main>

        <footer class="w-100 d-flex align-items-center justify-content-center my-3">
            <p class="m-0">siema tu stopka</p>
        </footer>

        </div>
    </body>
</html>



