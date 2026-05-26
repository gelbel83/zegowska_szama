<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$dbhost = 'localhost';
$dbname   = 'zegowska_szama';
$dbusername = 'root';
$dbpassword = '';
$charset = 'utf8mb4';

function mysqli_select_values($query, $values_arr, $parameters_num) {
    global $dbname;
    global $dbhost;
    global $dbusername;
    global $dbpassword;
    global $charset;

    if (strlen($query) < 3) {
        return false;
    }

    if (!isset($parameters_num) || !is_numeric($parameters_num) || $parameters_num < 1) {
        return false;
    }

    if (!isset($values_arr) || !is_array($values_arr) || sizeof($values_arr) == 0 || sizeof($values_arr) != $parameters_num) {
        return false;
    }
    try {
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset;", $dbusername, $dbpassword);
        $stmt = $dbh->prepare($query);
        $result = $stmt->execute($values_arr);
        $rows = $stmt->fetchAll();
        if (count($rows) > 0) {
            return $rows;
        }
    }

    catch(PDOException $e) {
        $_SESSION['dbError'] = $e->getMessage();
        echo $e;
        return false;
    }
}

function mysqli_select_no_parameters($query) {
    global $dbname;
    global $dbhost;
    global $dbusername;
    global $dbpassword;
    global $charset;

    if (strlen($query) < 3) {
        return false;
    }

    try {
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset;", $dbusername, $dbpassword);
        $stmt = $dbh->prepare($query);
        $result = $stmt->execute();
        $rows = $stmt->fetchAll();
        if (count($rows) > 0) {
            return $rows;
        }
    }

    catch(PDOException $e) {
        $_SESSION['dbError'] = $e->getMessage();
        echo $e;
        return false;
    }
}

function mysqli_change_values($query, $values_arr, $parameters_num){
    global $dbname;
    global $dbhost;
    global $dbusername;
    global $dbpassword;
    global $charset;

    if (strlen($query) < 3) {
        return false;
    }

    if (!isset($parameters_num) || !is_numeric($parameters_num) || $parameters_num < 1) {
        return false;
    }

    if (!isset($values_arr) || !is_array($values_arr) || sizeof($values_arr) == 0 || sizeof($values_arr) != $parameters_num) {
        return false;
    }

    try {
        $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=$charset;", $dbusername, $dbpassword);
        $stmt = $dbh->prepare($query);
        $result = $stmt->execute($values_arr);
        $rows = $stmt->fetchAll();
    }

    catch(PDOException $e) {
        $_SESSION['dbError'] = $e->getMessage();
        return false;
    }
}

function check_login($login){
    $query = "SELECT * FROM uzytkownik WHERE login LIKE(?) OR email LIKE(?);";
    $users_arr = mysqli_select_values($query, array(trim($login), trim($login)), 2);
    if(empty($users_arr)){
        return false;
    }else{
        
        $_SESSION['user'] = $users_arr[0]['login'];
        $_SESSION['user_type'] = $users_arr[0]['uprawnienia_id'];
        echo "<script>window.location.href='/';</script>";
        return true;
    }
};

?>