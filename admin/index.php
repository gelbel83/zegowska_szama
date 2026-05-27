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
            <div class="users-div d-flex" > 
                <?php 
                    $users_sql = "SELECT * FROM uzytkownik";
                    $users_arr = mysqli_select_no_parameters($users_sql);
                    if(!empty($users_arr)){
                        foreach($users_arr as $user){
                            echo "<div class='user card'>";
                            echo "Login: ";
                            echo $user['login'];
                            echo "<br>";
                            echo "Email: ";
                            echo $user['email'];
                            echo "<br>";
                            echo "Imię: ";
                            echo $user['imie'];
                            echo "<br>";
                            echo "Nazwisko: ";
                            echo $user['nazwisko'];
                            echo "<br>";
                           
                            
                            echo "Typ użytkownika: ";
                            if($user['uprawnienia_id'] == 2){
                                echo "administrator";
                            }
                            else{
                                echo "użytkownik";
                            }
                            echo "<button>Zmień</button>";
                            echo "<button>Usuń</button>";
                            echo "</div>";
                        }
                    }
                    else{
                        echo "<h3> Brak danych </h3>";
                    }
                ?>
            </div>
            <?php endif;?>
             <?php 
              if ((isset($_GET['page']) && $_GET['page']=='products')): 
            ?>
            <div class="products-div"> 
                <?php 
                    $users_sql = "SELECT * FROM uzytkownik";
                    
                ?>
            </div>
            <?php endif;?>
             <?php 
              if ((isset($_GET['page']) && $_GET['page']=='orders')): 
            ?>
            <div class="orders-div"> 
                <?php 
                    $users_sql = "SELECT * FROM uzytkownik";
                    
                ?>
            </div>
            <?php endif;?>
        </main>
        
        <?php create_footer();?>

        </div>
    </body>
</html>



