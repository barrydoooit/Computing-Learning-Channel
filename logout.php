<?php
include('app/classes/DB.php');
include('app/classes/Login.php');
if (Login::isLoggedIn()) {
    if (isset($_COOKIE['SNID'])) {
        DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token' => $_COOKIE['SNID']));
    }
    setcookie('SNID', '1', time()-3600, '/');
    setcookie('SNID_', '1', time()-3600, '/');
   
}
$url = "index.php";
header( "Location: $url" );
?>