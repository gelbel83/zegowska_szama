<?php
    session_start();
    require_once('..\php\functions.php');
    require_once('..\php\components.php');

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
        <link rel="shortcut icon" href="../resources/favicon.ico" type="image/x-icon" />

        <script>
            const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;
        </script>

    </head>
    
    <body class="d-flex flex-column vh-100">
        <?php create_header();?>
        
        <?php create_footer();?>
    </body>
</html>



