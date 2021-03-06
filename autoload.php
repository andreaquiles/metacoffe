<?php

include realpath(__DIR__) . '/sealed/init.php';
$filterGET = array(
    'lang' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);

$tl = parse_ini_file(realpath(__DIR__).'/assets/lang/pt_br.ini', true);

function __autoload($class) {
    /**
     * require banco
     */
    if (file_exists(PATH_SEALED_BANCO . DIRECTORY_SEPARATOR . $class . '.php')) {
        require_once (PATH_SEALED_BANCO . DIRECTORY_SEPARATOR . $class . '.php');
    }
    /**
     * require BO
     */
    elseif (file_exists(PATH_SEALED_BO . DIRECTORY_SEPARATOR . $class . '.php')) {
        require_once (PATH_SEALED_BO . DIRECTORY_SEPARATOR . $class . '.php');
    }
    /**
     * require DAO
     */
    elseif (file_exists(PATH_SEALED_DAO . DIRECTORY_SEPARATOR . $class . '.php')) {
        require_once (PATH_SEALED_DAO . DIRECTORY_SEPARATOR . $class . '.php');
    }
    /**
     * require controler
     */
    elseif (file_exists(PATH_SEALED_CONTROLER . DIRECTORY_SEPARATOR . $class . '.php')) {
        require_once (PATH_SEALED_CONTROLER . DIRECTORY_SEPARATOR . $class . '.php');
    }
    /**
     * require utils
     */
    elseif (file_exists(PATH_SEALED_UTILS . DIRECTORY_SEPARATOR . $class . '.php')) {
        require_once (PATH_SEALED_UTILS . DIRECTORY_SEPARATOR . $class . '.php');
    }
}
?>


