<?php

session_start();
unset($_SESSION['pessoa_id']);
unset($_SESSION['login']);
unset($_SESSION["sessiontimeCliente"]);
session_write_close();
header('Location: index.php');
