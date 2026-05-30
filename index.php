<?php
    session_start();
    require_once(__DIR__ . '/php/functions.php');
    require_once(__DIR__ . '/php/components.php');

    if(isset($_POST['login-button'])){
        $login_email = $_POST['login-email'];
        $passwd = $_POST['passwd'];
        
        check_login($login_email, $passwd);
        
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['register-button'])){
        $login = $_POST['login'];
        $email = $_POST['email'];
        $passwd = $_POST['passwd'];
        $repeat_passwd = $_POST['repeat-passwd'];
        $name = $_POST['name'];
        $surname = $_POST['surname'];

        if ($passwd === $repeat_passwd) {
            $hashed_passwd = sha1($passwd);
            
            $query = "INSERT INTO `uzytkownik`(`login`, `email`, `haslo`, `imie`, `nazwisko`, `uprawnienia_id`) VALUES (?, ?, ?, ?, ?, 1)";
            mysqli_change_values($query, array($login, $email, $hashed_passwd, $name, $surname), 5);
            
            header("Location: index.php?registered=1");
            exit;
        } else {
            $register_error = "Hasła nie są identyczne!";
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php create_head_tags(true)?>
        <script>const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;</script>
        <script src="./js/popups.js" defer></script>
        <script src="./js/scroll.js" defer></script>
        <script src="./js/to_cart.js" defer></script>
    </head>
    
    <body class="d-flex flex-column min-vh-100 bg-light">
        <?php create_header(true)?>

        <?php if (isset($_SESSION['user'])): ?>
        <section class="container my-4">
            <h2 class="fw-bold mb-3">Po taniości</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                <?php 
                    $promo_sql = "SELECT *, produkt.id AS id_pr, produkt.nazwa AS nazwa_pr, kategoria.nazwa AS nazwa_kat FROM produkt JOIN kategoria on kategoria_id=kategoria.id WHERE produkt.promocja > 0 AND produkt.dostepnosc = 1 ORDER BY kategoria.id DESC;";
                    $promo_products = mysqli_select_no_parameters($promo_sql);
                    
                    if(!empty($promo_products)){
                        foreach($promo_products as $product){
                            $cena_base = (float)$product['cena'];
                            $cena_promo = $cena_base - ($cena_base * ((float)$product['promocja'] / 100));
                            $image_src = (!empty($product['zdjecie'])) ? 'resources/produkty/' . $product['zdjecie'] : 'https://via.placeholder.com/150?text=Insert+Zdjecie';
                            
                            echo "<div class='col'>";
                            echo "  <div class='card h-100 p-3 border rounded-3 shadow-sm bg-white'>";
                            echo "      <div class='row align-items-center h-100'>";
                            echo "          <div class='col-5 text-center'>";
                            echo "              <img src='{$image_src}' class='img-fluid rounded-3' style='max-height: 100px; object-fit: cover;' alt='produkt'>";
                            echo "          </div>";
                            echo "          <div class='col-7 d-flex flex-column justify-content-between h-100'>";
                            echo "              <div><h5 class='fw-bold mb-1 text-truncate'>".$product['nazwa_pr']."</h5></div>";
                            echo "              <div class='d-flex justify-content-between align-items-end mt-2'>";
                            echo "                  <span class='fw-bold text-danger fs-3'>-".$product['promocja']."%</span>";
                            echo "                  <div class='text-end'>";
                            echo "                      <small class='text-muted d-block text-decoration-line-through'>".number_format($cena_base, 2, '.', '')." zł</small>";
                            echo "                      <strong class='fs-4 text-dark'>".number_format($cena_promo, 2, '.', '')."</strong>";
                            echo "                  </div>";
                            echo "              </div>";
                            echo "              <button class='btn btn-sm w-100 mt-2 to-cart-button orange-button' data-id='{$product['id_pr']}'>Do koszyka</button>";
                            echo "          </div>";
                            echo "      </div>";
                            echo "  </div>";
                            echo "</div>";
                        }
                    }
                ?>
            </div>
        </section>
        <?php endif; ?>

        <section class="container my-4 flex-grow-1">
            <h2 class="fw-bold mb-4">Co u nas wszamasz?</h2>
            <?php 
                $categories_sql = "SELECT DISTINCT kategoria.id, kategoria.nazwa FROM kategoria JOIN produkt ON produkt.kategoria_id = kategoria.id ORDER BY kategoria.id DESC;";
                $categories = mysqli_select_no_parameters($categories_sql);
                
                if(!empty($categories)){
                    foreach($categories as $cat) {
                        $cat_id = (int)$cat['id'];
                        echo "<div class='category-block mb-5'>";
                        echo "  <h3 class='text-muted mb-3 fs-4 fw-semibold border-bottom pb-2'>" . htmlspecialchars($cat['nazwa']) . "</h3>";
                        echo "  <div class='row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3'>";
                        
                        $products_by_cat_sql = "SELECT * FROM produkt WHERE kategoria_id = {$cat_id} AND dostepnosc = 1;";
                        $cat_products = mysqli_select_no_parameters($products_by_cat_sql);
                        
                        if(!empty($cat_products)){
                            foreach($cat_products as $product) {
                                $cena_base = (float)$product['cena'];
                                $promocja = (float)$product['promocja'];
                                $is_promo = ($promocja > 0);
                                $cena_final = $is_promo ? ($cena_base - ($cena_base * ($promocja / 100))) : $cena_base;
                                $image_src = (!empty($product['zdjecie'])) ? 'resources/produkty/' . $product['zdjecie'] : 'https://via.placeholder.com/150?text=Brak+zdjecia';
                                
                                echo "<div class='col'>";
                                echo "  <div class='card h-100 p-3 text-center border rounded-3 bg-white shadow-sm d-flex flex-column justify-content-between'>";
                                echo "      <div class='mb-2'><img src='{$image_src}' class='img-fluid rounded-3' style='height: 110px; object-fit: cover;' alt='produkt'></div>";
                                echo "      <div>";
                                echo "          <h6 class='fw-bold mb-1 text-truncate'>".htmlspecialchars($product['nazwa'])."</h6>";
                                
                                if(isset($_SESSION['user']) && $is_promo) {
                                    echo "      <div class='d-flex justify-content-center gap-2 align-items-center mb-2'>";
                                    echo "          <small class='text-muted text-decoration-line-through'>".number_format($cena_base, 2, '.', '')." zł</small>";
                                    echo "          <strong class='text-danger'>".number_format($cena_final, 2, '.', '')." zł</strong>";
                                    echo "      </div>";
                                } else {
                                    echo "      <p class='text-dark fw-bold mb-2'>".number_format($cena_base, 2, '.', '')." zł</p>";
                                }
                                
                                echo "      </div>";
                                echo "      <button class='btn btn-sm w-100 to-cart-button mt-auto orange-button' data-id='{$product['id']}'>Do koszyka</button>";
                                echo "  </div>";
                                echo "</div>";
                            }
                        }
                        echo "  </div></div>";
                    }
                }
            ?>
        </section>

        <?php create_footer() ?>

        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="loginModalLabel">Logowanie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Login/E-mail</label>
                                <input type="text" class="form-control" name="login-email" required />
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Hasło</label>
                                <input type="password" class="form-control" name="passwd" required />
                            </div>
                            <div class="mb-3 text-center">
                                <span>Nie masz konta? <a href="#" class="text-decoration-none fw-bold" style="color: #F30;" id="show-register-popup-span">Zarejestruj się!</a></span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" name="login-button" class="btn w-100 orange-button">Zaloguj</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="registerModalLabel">Rejestracja</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Login</label>
                                <input type="text" class="form-control" name="login" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hasło</label>
                                <input type="password" class="form-control" name="passwd" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Powtórz hasło</label>
                                <input type="password" class="form-control" name="repeat-passwd" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Imię</label>
                                <input type="text" class="form-control" name="name" required />
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nazwisko</label>
                                <input type="text" class="form-control" name="surname" required />
                            </div>
                            <div class="mb-3 text-center">
                                <span>Masz już konto? <a href="#" class="text-decoration-none fw-bold" style="color: #F30;" id="show-login-popup-span">Zaloguj się!</a></span>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" name="register-button" class="btn w-100 orange-button">Zarejestruj</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addedToCartModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content text-center p-4">
                    <div class="modal-body">
                        <h4 class="mb-3">Dodano do koszyka!</h4>
                        <button type="button" class="btn btn-sm w-100 orange-button" data-bs-dismiss="modal">Kontynuuj zakupy</button>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>