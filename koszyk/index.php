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
        <?php create_header();?>
        
        <?php create_footer();?>
    </body>
</html>



