<?php 
require_once(__DIR__ . '/functions.php');

function create_head_tags($is_index = false) {
    $path_dots = $is_index ? '.' : '..';

    echo "
        <title>ZEGOWSKA SZAMA</title>
        <meta lang='pl' />
        <meta charset='UTF-8' />
        <meta name='viewport' content='width=device-width, initial-scale=1.0' />

        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous' />
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css' />

        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Podkova:wght@400..800&family=Luckiest+Guy&display=swap' rel='stylesheet' />

        <link rel='stylesheet' href='{$path_dots}/style.css' type='text/css' />
        <link rel='shortcut icon' href='{$path_dots}/resources/favicon.ico' type='image/x-icon' />
    ";
}

function create_header($is_index = false){
    if (!isset($_SESSION['user']) && !$is_index){
        header("Location: /");
        exit;
    }

    $path_dots = $is_index ? '.' : '..';

    echo "<header class='w-100 d-flex align-items-center justify-content-center my-3'>
            <a href='/'><img src='{$path_dots}/resources/logo.gif' alt='ZEGOWSKA SZAMA' id='logo-image'/></a>
        </header>
        
        <nav class='d-flex align-items-center justify-content-end'>";
            if((isset($_SESSION['user_type']) && $_SESSION['user_type'] == 2)  ){
            echo "<button id='admin-panel-button' class='btn' onclick='window.location.href =`/admin`'>Panel administratora</button>";
            }
            if (isset($_SESSION['user'])){
                echo "<a href='/zamowienia' class='nav-link'><i class='bi bi-receipt'></i></a>
                <a href='/koszyk' class='nav-link'><i class='bi bi-cart'></i></a>";
            }
            echo "<a href='";
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