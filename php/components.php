<?php 
require_once(__DIR__ . '/functions.php');

function create_header($is_index = false){
    if (!isset($_SESSION['user'])){
        header("Location: /");
        exit;
    }

    $path_dots = $is_index ? '.' : '..';

    echo "<header class='w-100 d-flex align-items-center justify-content-center my-3'>
            <a href='/'><img src='{$path_dots}/resources/logo.gif' alt='ZEGOWSKA SZAMA' id='logo-image'/></a>
        </header>
        
        <nav class='d-flex align-items-center justify-content-end'>
            <button id='admin-panel-button' class='btn' onclick='window.location.href =`/admin`' style='";
            if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 1  ){
                echo 'display:none;';
            }
            echo "' >Panel administratora</button>

            <a href='/zamowienia' class='nav-link'><i class='bi bi-receipt'></i></a>
            <a href='/koszyk' class='nav-link'><i class='bi bi-cart'></i></a>
            <a href='";
            if(isset($_SESSION['user'])) {
                echo '/konto';
            }else{
                echo "javascript:void(0);"; 
            }
            echo "' id='konto-link' class='nav-link'><i class='bi bi-person-circle'></i></a>
        </nav>";
}

function create_footer(){
    echo "<footer class='w-100 d-flex align-items-center justify-content-center flex-row'>
        <div class='m-2'><div>Pomoc techniczna:</div><div>+48 882 466 642</div><div>pomoc_szama@zeg.pl</div></div>
        <div class='m-2'><div>Kontakt z właścicielami sklepiku:</div><div>+48 412 642 537</div><div>sklepik_szama@zeg.pl</div></div>
        <div class='m-2'><div>Autorzy:</div><div>Konrad Goliński</div><div>Kacper Gonciarz</div></div>
    </footer>";
}
?>