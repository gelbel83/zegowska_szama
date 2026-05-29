<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php create_head_tags()?>

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>
    </head>
    
    <body class="d-flex flex-column vh-100">
        <?php create_header();?>

        <div id="products_display" class="flex-fill d-flex flex-column"></div>
        
        <?php create_footer();?>

        <script src='../js/from_cart.js'> </script>
    </body>
</html>