<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');

    $account_info_query = "SELECT * FROM uzytkownik WHERE login LIKE(?)";
    $account_info = mysqli_select_values($account_info_query, array($_SESSION['user']), 1) [0];
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
        <?php create_header();
            if ($_SESSION['user_type'] !== 2){
                header("Location: /");
            }
        ?>
        <main class='flex-fill d-flex flex-column justify-content-start align-items-center'>
            <div class="current-page-buttons d-flex align-items-center justify-content-center w-100 p-3">
                <button type="submit" name="users-page-button" class="btn w-100">Użytkownicy</button>
                <button type="submit" name="products-page-button" class="btn w-100">Produkty</button>
                <button type="submit" name="orders-page-button" class="btn w-100">Zamówienia</button>
            </div>
        </main>
        
        <?php create_footer();?>

        </div>
    </body>
</html>



