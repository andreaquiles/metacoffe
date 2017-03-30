<?php
if(!isset($_SESSION)){
    session_start();
};
$_SESSION['admin'] = NULL;
$_SESSION['admin_email'] = NULL;
$_SESSION["sessiontimeAdmin"] = NULL;
header("Location:login");
exit;