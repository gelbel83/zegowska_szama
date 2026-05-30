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

        <div class="modal fade" id="order-success-popup" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-2">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body text-center pb-5">
                        <h3 class="mb-3">Zamówienie złożone!</h3>
                        <h5>Twój numer zamówienia to:</h5>
                        <h1 id="popup-order-number" class="text-success fw-bold my-4"></h1>
                        <button type="button" class="btn btn-dark px-5" data-bs-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>