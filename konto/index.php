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
        <main class='flex-fill d-flex justify-content-center align-items-center'>
            <div class="card text-center p-4 shadow-sm" style="width: 100%; max-width: 450px;">
                <div class="account-info">
                    <h4>Login </h4>
                    <?php 
                        echo "<span>{$account_info['login']}</span>";
                    ?>
                </div>

                <div class="account-info">
                    <h4>Imię </h4>
                    <?php 
                        echo "<span>{$account_info['imie']}</span>";
                    ?>
                </div>

                <div class="account-info">
                    <h4>Nazwisko </h4>
                    <?php 
                        echo "<span>{$account_info['nazwisko']}</span>";
                    ?>
                </div>
                
                <div class="account-info">
                    <h4>E-mail </h4>
                    <?php 
                        echo "<span>{$account_info['email']}</span>";
                    ?>
                </div>
                
                <button onclick="window.location.href = '?akcja=wyloguj'" class="btn w-50 m-auto my-3 orange-button">Wyloguj</button>
                <?php 
                    if(isset($_GET['akcja']) && $_GET['akcja'] == 'wyloguj'){
                        session_destroy();

                        echo "<script>
                                sessionStorage.clear(); // Czyści cały koszyk/dane w pamięci
                                window.location.href = '/'; // Przekierowuje po wyczyszczeniu
                            </script>";
                        exit;
                    }
                ?>
            </div>
        </main>
        
        <?php create_footer();?>

        </div>
    </body>
</html>



