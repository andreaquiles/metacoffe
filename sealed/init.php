<?php
/* =============================
   Configurações do PHP
=========================== */
if(!isset($_SESSION)){session_start();};
ini_set('display_errors',true);
//error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);

/**
 *  timezone
 */
date_default_timezone_set('America/Sao_Paulo' );
/**
 *  tempo máximo de execução de um script
 */
set_time_limit( 0 );

/* =============================
   Constantes do PHP
=========================== */
define('HOME', "index");
define('TITLE', "Manager MetaCoffee");
define('PESSOAS', "Clientes");
define('OFERTAS', "Ofertas");
define('AMOSTRAS', "Amostras");
define('AMOSTRAS_IMAGENS', "Amostras Imagens");
define('DS', DIRECTORY_SEPARATOR);
define('PATH', realpath(dirname(dirname(__FILE__))));
define('PATH_SEALED', PATH.DS."sealed");
define('PATH_SEALED_BO', PATH_SEALED.DS."BO");
define('PATH_SEALED_DAO', PATH_SEALED.DS."DAO");
define('PATH_SEALED_BANCO', PATH_SEALED.DS."banco");
define('PATH_SEALED_CONTROLER', PATH_SEALED.DS."controler");
define('PATH_SEALED_UTILS', PATH_SEALED.DS."utils");
define('MSG_CLIQUE_LINK', "Clique no link ao lado");

/* =============================
   Constantes do Mysql
=========================== */
define('AMOSTRAS_AVALIABLE', "(s.situacao IS NULL OR s.situacao = 'aguardando') AND data_expiracao >= CURDATE() ");
