<?php
if(!isset($_SESSION)){
    session_start();
};
$_SESSION['pessoa_id'] = NULL;
$_SESSION['login'] = NULL;
$_SESSION["sessiontimeCliente"] = NULL;
header("Location:login");
exit;