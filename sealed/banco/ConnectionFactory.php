<?php

class ConnectionFactory extends PDO {
       
    static $MYSQL = 1;
    static $FIREBIRD = 2;
    static $ACCESS = 3;
    static $TIMEOUT = 13;

    public function __construct($url, $user, $pwd) {

        parent::__construct($url, $user, $pwd);
    }

    public static function getConnection($srv, $db, $sgdb, $user, $pwd) {

        $url = "";
        $conn = "";
        $utf8 = ';charset=utf8';
        if ($sgdb == ConnectionFactory::$MYSQL) {
            $url = 'mysql:host=' . $srv .
                    ';dbname=' . $db .
                    $utf8 . ';connect_timeout='.self::$TIMEOUT;
        } else if ($sgdb == ConnectionFactory::$FIREBIRD) {
            $url = 'firebird:dbname=' . $db .
                    $utf8 . ';connect_timeout='.self::$TIMEOUT;
        } else if ($sgdb == ConnectionFactory::$ACCESS) {
            $url = "odbc:Driver=" . $srv . ";" .
                    "Dbq=" . $db . ";" .
                    "Uid=" . $user . ";Pwd=" . $pwd .
                    $utf8 . ';connect_timeout='.self::$TIMEOUT;
            $conn = new PDO($url);
        } else
            throw new PDOException(('BANCO DE DADOS NAO EXISTE'));

        try {
            if (!$conn && $sgdb <> ConnectionFactory::$ACCESS) {
                $conn = new self($url, $user, $pwd);

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $conn;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}
