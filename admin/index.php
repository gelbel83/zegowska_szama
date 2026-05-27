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
            <div class="users-div"> 
                <?php 
                    $users_sql = "";
                ?>
            </div>
            <?php endif;?>
        </main>
        
        <?php create_footer();?>

        </div>
    </body>
</html>



