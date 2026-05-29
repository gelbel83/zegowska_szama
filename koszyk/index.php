<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php create_head_tags()?>

        <script>const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;</script>
        <script src='../js/from_cart.js' defer></script>
        <script src='../js/popups.js' defer></script>
    </head>
    
    <body class="d-flex flex-column vh-100">
        <?php create_header();?>

        <div id="products_display" class="flex-fill d-flex flex-column"></div>
        
        <?php create_footer();?>

        <!--popup-->
        <div id="order-success-popup" class="popup hidden p-4">
            <div class="d-flex flex-column align-items-center justify-content-center text-center">
                <h3>Zamówienie złożone!</h3>
                <h3>Twój numer zamówienia to:</h3>
                <h1 id="popup-order-number" class="text-success fw-bold my-3"></h1>
            </div>
        </div>
    </body>
</html>