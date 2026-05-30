<?php
    session_start();
    require_once(__DIR__ . '/../php/functions.php');
    require_once(__DIR__ . '/../php/components.php');

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 2){
        header("Location: /");
        exit(); 
    }

    $page = $_GET['page'] ?? 'users';

    if(isset($_POST['change_user'])){
        $user_sql = "UPDATE uzytkownik SET uprawnienia_id = ? WHERE id = ?;";
        $user_access = $_POST['user_access'];
        $user_id = $_POST['user_id'];
        mysqli_change_values($user_sql, array($user_access, $user_id), 2);
    }

    if(isset($_POST['user_d_confirm'])){
        $user_del_sql = "DELETE FROM uzytkownik WHERE id = ?";
        $user_id = $_POST['user_id']; 
        mysqli_change_values($user_del_sql, array($user_id), 1);
    }

    if(isset($_POST['add_product'])){
        $product_sql = "INSERT INTO produkt(nazwa, kategoria_id, cena, dostepnosc, promocja, zdjecie) VALUES (?,?,?,?,?,?)";
        $product_name = $_POST['nazwa_pr'];
        $product_price = $_POST['cena_pr'];
        $product_availability = isset($_POST['dostepnosc_pr']) ? 1 : 0;
        $product_sale = $_POST['promocja_pr']; 
        $product_cat = $_POST['kategoria_pr'];

        $uploads_dir = "../resources/produkty/";
        $file_name = basename($_FILES["plik"]["name"]);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $target_file = $uploads_dir . $file_name;

        $allowed_types = ['jpg', 'png', 'webp', 'svg', 'gif'];
        $max_file_size = 10 * 1024 * 1024; // 10 MB

        if($_FILES["plik"]["error"] == UPLOAD_ERR_OK && in_array($file_type, $allowed_types) && $_FILES["plik"]["size"] < $max_file_size){
            if(move_uploaded_file($_FILES["plik"]["tmp_name"], $target_file)){
                mysqli_change_values($product_sql, array($product_name, $product_cat, $product_price, $product_availability, $product_sale, $file_name), 6);
            }
        }
    }

    if(isset($_POST['change_product'])){
        $product_sql = "UPDATE produkt SET nazwa=?, cena=?, dostepnosc=?, promocja=? WHERE id = ?;";
        $product_name = $_POST['nazwa_pr'];
        $product_price = $_POST['cena_pr'];
        $product_availability = isset($_POST['dostepnosc_pr']) ? 1 : 0;
        $product_sale = $_POST['promocja_pr'];
        $product_id = $_POST['product_id']; 
        mysqli_change_values($product_sql, array($product_name, $product_price, $product_availability, $product_sale, $product_id), 5);
    }

    if(isset($_POST['product_d_confirm'])){
        $product_del_sql = "DELETE FROM produkt WHERE id = ?";
        $product_id = $_POST['product_id'];
        mysqli_change_values($product_del_sql, array($product_id), 1);
    }

    if(isset($_POST['change_order'])){
        $order_sql = "UPDATE zamowienie SET status_id = ? WHERE id = ?;";
        $order_status = $_POST['status_zam'];
        $order_id = $_POST['order_id'];
        mysqli_change_values($order_sql, array($order_status, $order_id), 2);
    }

    if(isset($_POST['order_d_confirm'])){
        $order_id = $_POST['order_id'];
        mysqli_change_values("DELETE FROM zawartosc_zamowienia WHERE zamowienie_id = ?", array($order_id), 1);
        mysqli_change_values("DELETE FROM zamowienie WHERE id = ?", array($order_id), 1);
    }
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <?php create_head_tags() ?>
        <script>const isLoggedIn = <?php echo isset($_SESSION["user"]) ? "true" : "false"; ?>;</script>
    </head>
    
    <body class="d-flex flex-column min-vh-100 bg-light">
        <?php create_header(); ?>

        <main class='flex-fill container py-4'>
            <div class="row mb-4 admin-nav">
                <div class="col-12 d-flex justify-content-center gap-2 flex-wrap">
                    <a href="?page=users" class="btn btn-light px-4 py-2 <?= $page == 'users' ? 'active' : '' ?>">Użytkownicy</a>
                    <a href="?page=products" class="btn btn-light px-4 py-2 <?= $page == 'products' ? 'active' : '' ?>">Produkty</a>
                    <a href="?page=orders" class="btn btn-light px-4 py-2 <?= $page == 'orders' ? 'active' : '' ?>">Zamówienia</a>
                </div>
            </div>

            <?php if ($page == 'users'): ?>
            <div class="users-container"> 
                <?php 
                    $users_sql = "SELECT * FROM uzytkownik";
                    $users_arr = mysqli_select_no_parameters($users_sql);
                    if(!empty($users_arr)):
                        foreach($users_arr as $user):
                ?>
                <div class='list-card p-3 bg-white'>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex flex-column flex-md-row gap-2 gap-md-5 mb-3 mb-md-0 text-start">
                            <div>
                                <strong>Login:</strong> <?= htmlspecialchars($user['login']) ?><br>
                                <small>Imię: <?= htmlspecialchars($user['imie']) ?></small>
                            </div>
                            <div>
                                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?><br>
                                <small>Nazwisko: <?= htmlspecialchars($user['nazwisko']) ?></small>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-3 text-start text-md-center mb-3 mb-md-0">
                            <strong>Typ:</strong><br>
                            <span class="badge bg-<?= $user['uprawnienia_id'] == 2 ? 'danger' : 'secondary' ?>">
                                <?= $user['uprawnienia_id'] == 2 ? 'Administrator' : 'Użytkownik' ?>
                            </span>
                        </div>
                        
                        <div class="col-12 col-md-3 d-flex gap-2 justify-content-start justify-content-md-end">
                            <button class="btn btn-wireframe px-4 py-1" data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                    data-id="<?= $user['id'] ?>" data-login="<?= htmlspecialchars($user['login']) ?>" data-role="<?= $user['uprawnienia_id'] ?>">Edytuj</button>
                            <button class="btn btn-wireframe px-4 py-1" data-bs-toggle="modal" data-bs-target="#deleteUserModal" 
                                    data-id="<?= $user['id'] ?>">Usuń</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <h4 class="text-center mt-5">Brak użytkowników</h4>
                <?php endif; ?>
            </div>

            <div class="modal fade" id="editUserModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-dark border-2">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">Zmień uprawnienia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="?page=users">
                            <div class="modal-body text-center">
                                <h3 id="display_user_login" class="mb-4"></h3>
                                <input type="hidden" name="user_id" id="edit_user_id_input">
                                <select name="user_access" id="edit_user_role_select" class="form-select border-dark border-2 rounded-3 mb-3">
                                    <option value="1">Użytkownik</option>
                                    <option value="2">Administrator</option>
                                </select>
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button type="submit" name="change_user" class="btn orange-button px-5 py-2">Zapisz</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteUserModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-dark border-2">
                        <div class="modal-body text-center p-5">
                            <h4 class="mb-4">Czy na pewno usunąć tego użytkownika?</h4>
                            <form method="post" action="?page=users">
                                <input type="hidden" name="user_id" id="delete_user_id_input">
                                <div class="d-flex justify-content-center gap-3">
                                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal">Anuluj</button>
                                    <button type="submit" name="user_d_confirm" class="btn orange-button px-4 py-2">Usuń</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>


            <?php if ($page == 'products'): ?>
            <div class="products-div"> 
                <button class="btn orange-button w-100 mb-4 py-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Dodaj nowy produkt</button>
                
                <div class="products-container"> 
                <?php 
                    $products_sql = "SELECT *, produkt.id AS id_pr, produkt.nazwa AS nazwa_pr, kategoria.nazwa AS nazwa_kat FROM produkt JOIN kategoria on kategoria_id=kategoria.id;";
                    $products_arr = mysqli_select_no_parameters($products_sql);
                    if(!empty($products_arr)):
                        foreach($products_arr as $product):
                ?>
                <div class='list-card p-3 bg-white'>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex flex-column flex-md-row gap-2 gap-md-5 mb-3 mb-md-0 text-start">
                            <div>
                                <h5 class="mb-0 fw-bold"><?= htmlspecialchars($product['nazwa_pr']) ?></h5>
                                <small class="text-muted"><?= htmlspecialchars($product['nazwa_kat']) ?></small>
                            </div>
                            <div>
                                <strong>Cena:</strong> <?= number_format($product['cena'], 2, '.', '') ?> zł<br>
                                <small>Promocja: <?= $product['promocja']?>%</small>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 text-start text-md-center mb-3 mb-md-0">
                            <span class="badge bg-<?= $product['dostepnosc'] == 1 ? 'success' : 'danger' ?>">
                                <?= $product['dostepnosc'] == 1 ? 'Dostępny' : 'Niedostępny' ?>
                            </span>
                        </div>

                        <div class="col-12 col-md-3 d-flex gap-2 justify-content-start justify-content-md-end">
                            <button class="btn btn-wireframe px-3" data-bs-toggle="modal" data-bs-target="#editProductModal" 
                                data-id="<?= $product['id_pr'] ?>" 
                                data-nazwa="<?= htmlspecialchars($product['nazwa_pr']) ?>"
                                data-cena="<?= $product['cena'] ?>"
                                data-promo="<?= $product['promocja']?>"
                                data-dostepnosc="<?= $product['dostepnosc'] ?>">Edytuj</button>
                            <button class="btn btn-wireframe px-3" data-bs-toggle="modal" data-bs-target="#deleteProductModal" 
                                data-id="<?= $product['id_pr'] ?>">Usuń</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <h4 class="text-center mt-5">Brak produktów</h4>
                <?php endif; ?>
                </div>
            </div>

            <div class="modal fade" id="addProductModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content border-dark border-2">
                        <div class="modal-header border-0"><h5 class="modal-title fw-bold">Nowy produkt</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <form method="post" action="?page=products" enctype="multipart/form-data"> 
                            <div class="modal-body d-flex flex-column gap-3">
                                <input type="text" name="nazwa_pr" class="form-control" placeholder="Nazwa" required> 
                                <input type="number" step="0.01" name="cena_pr" class="form-control" placeholder="Cena" required>
                                <div class="form-check px-4">
                                    <input type="checkbox" name="dostepnosc_pr" class="form-check-input" id="dost_add" checked>
                                    <label class="form-check-label" for="dost_add">Dostępny</label>
                                </div>
                                <input type="number" name="promocja_pr" class="form-control" placeholder="Promocja w % (np. 15)" value="0" required>
                                <select name="kategoria_pr" class="form-select" required>
                                    <?php 
                                        $categories = mysqli_select_no_parameters("SELECT * FROM kategoria");
                                        foreach($categories as $category) {
                                            echo "<option value='{$category['id']}'>{$category['nazwa']}</option>";
                                        }
                                    ?>
                                </select>
                                <input type="file" name="plik" class="form-control" required>
                            </div>
                            <div class="modal-footer border-0"><button type="submit" name="add_product" class="btn orange-button w-100 py-2">Dodaj</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editProductModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content border-dark border-2">
                        <div class="modal-header border-0"><h5 class="modal-title fw-bold">Edytuj produkt</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <form method="post" action="?page=products"> 
                            <div class="modal-body d-flex flex-column gap-2">
                                <input type="hidden" name="product_id" id="edit_prod_id">
                                <label>Nazwa</label><input type="text" name="nazwa_pr" id="edit_prod_nazwa" class="form-control" required> 
                                <label>Cena</label><input type="number" step="0.01" name="cena_pr" id="edit_prod_cena" class="form-control" required>
                                <div class="form-check mt-2 px-4">
                                    <input type="checkbox" name="dostepnosc_pr" id="edit_prod_dostepnosc" class="form-check-input">
                                    <label class="form-check-label">Dostępny</label>
                                </div>
                                <label>Promocja (%)</label><input type="number" name="promocja_pr" id="edit_prod_promo" class="form-control" required>
                            </div>
                            <div class="modal-footer border-0"><button type="submit" name="change_product" class="btn orange-button w-100 py-2">Zapisz</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteProductModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-dark border-2 text-center p-4">
                        <h4 class="mb-3">Usunąć produkt?</h4>
                        <form method="post" action="?page=products">
                            <input type="hidden" name="product_id" id="delete_prod_id">
                            <button type="button" class="btn btn-secondary px-4 py-2 me-2" data-bs-dismiss="modal">Anuluj</button>
                            <button type="submit" name="product_d_confirm" class="btn orange-button px-4 py-2">Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif;?>


            <?php if ($page == 'orders'): ?>
            <div class="orders-div"> 
                <?php 
                    $orders_sql = "SELECT zamowienie.id AS z_id, zamowienie.data_zamowienia AS z_data, zamowienie.cena AS z_cena, zamowienie.status_id, status.nazwa AS z_status, uzytkownik.login AS z_login 
                                   FROM zamowienie 
                                   JOIN status ON zamowienie.status_id = status.id 
                                   JOIN uzytkownik ON uzytkownik.id = zamowienie.uzytkownik_id ORDER BY zamowienie.id DESC;"; 
                    $orders_arr = mysqli_select_no_parameters($orders_sql);
                    if(!empty($orders_arr)):
                        foreach($orders_arr as $order):
                ?>
                <div class='list-card p-3 bg-white'>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 d-flex flex-column flex-md-row gap-2 gap-md-5 mb-3 mb-md-0 text-start">
                            <div>
                                <strong class="fs-5">Nr <?= $order['z_id'] ?></strong><br>
                                <small class="text-muted">Zamawiający: <?= htmlspecialchars($order['z_login']) ?></small>
                            </div>
                            <div>
                                <strong>Cena:</strong> <?= number_format($order['z_cena'], 2) ?> zł<br>
                                <small>Data: <?= $order['z_data'] ?></small>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 text-start text-md-center mb-3 mb-md-0">
                            <strong>Status:</strong><br>
                            <span class="text-primary fw-bold"><?= $order['z_status'] ?></span>
                        </div>

                        <div class="col-12 col-md-3 d-flex gap-2 justify-content-start justify-content-md-end">
                            <button class="btn btn-wireframe px-3" data-bs-toggle="modal" data-bs-target="#editOrderModal" 
                                data-id="<?= $order['z_id'] ?>" 
                                data-status="<?= $order['status_id'] ?>">Edytuj</button>
                            <button class="btn btn-wireframe px-3" data-bs-toggle="modal" data-bs-target="#deleteOrderModal" 
                                data-id="<?= $order['z_id'] ?>">Usuń</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; else: ?>
                    <h4 class="text-center mt-5">Brak zamówień</h4>
                <?php endif; ?>
            </div>

            <div class="modal fade" id="editOrderModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content border-dark border-2">
                        <div class="modal-header border-0"><h5 class="modal-title fw-bold">Status zamówienia</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <form method="post" action="?page=orders"> 
                            <div class="modal-body text-center">
                                <h4 class="mb-3">Zamówienie Nr <span id="edit_order_id_display"></span></h4>
                                <input type="hidden" name="order_id" id="edit_order_id_input">
                                <label class="mb-1">Aktualizuj status:</label>
                                <select name="status_zam" id="edit_order_status_select" class="form-select border-dark border-2 mb-3" required>
                                    <?php 
                                        $statuses = mysqli_select_no_parameters("SELECT * FROM status");
                                        foreach($statuses as $status) {
                                            echo "<option value='{$status['id']}'>{$status['nazwa']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer border-0 justify-content-center"><button type="submit" name="change_order" class="btn orange-button py-2 w-100">Zapisz</button></div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="deleteOrderModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-dark border-2 text-center p-4">
                        <h4 class="mb-3">Usunąć zamówienie?</h4>
                        <form method="post" action="?page=orders">
                            <input type="hidden" name="order_id" id="delete_order_id_input">
                            <button type="button" class="btn btn-secondary px-4 py-2 me-2" data-bs-dismiss="modal">Anuluj</button>
                            <button type="submit" name="order_d_confirm" class="btn orange-button px-4 py-2">Usuń</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif;?>

        </main>
        
        <?php create_footer();?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editUserModal = document.getElementById('editUserModal');
                if (editUserModal) {
                    editUserModal.addEventListener('show.bs.modal', event => {
                        const btn = event.relatedTarget;
                        document.getElementById('display_user_login').innerText = btn.getAttribute('data-login');
                        document.getElementById('edit_user_id_input').value = btn.getAttribute('data-id');
                        document.getElementById('edit_user_role_select').value = btn.getAttribute('data-role');
                    });
                }
                
                const deleteUserModal = document.getElementById('deleteUserModal');
                if (deleteUserModal) {
                    deleteUserModal.addEventListener('show.bs.modal', event => {
                        document.getElementById('delete_user_id_input').value = event.relatedTarget.getAttribute('data-id');
                    });
                }

                const editProductModal = document.getElementById('editProductModal');
                if(editProductModal) {
                    editProductModal.addEventListener('show.bs.modal', event => {
                        const btn = event.relatedTarget;
                        document.getElementById('edit_prod_id').value = btn.getAttribute('data-id');
                        document.getElementById('edit_prod_nazwa').value = btn.getAttribute('data-nazwa');
                        document.getElementById('edit_prod_cena').value = btn.getAttribute('data-cena');
                        document.getElementById('edit_prod_promo').value = btn.getAttribute('data-promo');
                        document.getElementById('edit_prod_dostepnosc').checked = (btn.getAttribute('data-dostepnosc') === '1');
                    });
                }

                const deleteProductModal = document.getElementById('deleteProductModal');
                if (deleteProductModal) {
                    deleteProductModal.addEventListener('show.bs.modal', event => {
                        document.getElementById('delete_prod_id').value = event.relatedTarget.getAttribute('data-id');
                    });
                }

                const editOrderModal = document.getElementById('editOrderModal');
                if(editOrderModal) {
                    editOrderModal.addEventListener('show.bs.modal', event => {
                        const btn = event.relatedTarget;
                        const id = btn.getAttribute('data-id');
                        document.getElementById('edit_order_id_display').innerText = id;
                        document.getElementById('edit_order_id_input').value = id;
                        document.getElementById('edit_order_status_select').value = btn.getAttribute('data-status');
                    });
                }

                const deleteOrderModal = document.getElementById('deleteOrderModal');
                if (deleteOrderModal) {
                    deleteOrderModal.addEventListener('show.bs.modal', event => {
                        document.getElementById('delete_order_id_input').value = event.relatedTarget.getAttribute('data-id');
                    });
                }
            });
        </script>
    </body>
</html>