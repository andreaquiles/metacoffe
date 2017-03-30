<?php

class DB {

    private $conn;
    public static $Mysql = 1;
    public static $Access = 2;
    var $msgMYSQL;

    function __construct() {
        global $msgMYSQL;
        require ('config.inc.php');


        try {
            $this->conn = ConnectionFactory::getConnection(
                            $this->host, '' .
                            $this->banco, '' .
                            ConnectionFactory::$MYSQL, '' .
                            $this->usuario, '' .
                            $this->senha);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    public function __destruct() {
        $this->conn = null;
    }

    public function __set($campo, $valor) {
        $this->$campo = $valor;
    }

    public function __get($campo) {
        return $this->$campo;
    }

   private function cleanXSS($dirtyhtml) {
        return htmlspecialchars($dirtyhtml, ENT_QUOTES, 'UTF-8');
   }

    function InsertData($sqlInsertCadastros, $data) {
        $stmt = $this->conn->prepare($sqlInsertCadastros);
        if (!$stmt->execute($data)) {
            $error = $stmt->errorInfo() . ': ' . __FUNCTION__;
            throw new Exception($error);
        } else {
            return $this->conn->lastInsertId();
        }
    }

    function query($sql) {
        global $msgMYSQL;
        if (!self::ErroBanco()) {

            try {
                $stmt = $this->conn->prepare($sql);
                if ($stmt->execute()) {
                    return $stmt;
                } else {
                    $error = $stmt->errorInfo();
                    throw new Exception($error[2]);
                }
            } catch (PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function executeReturnFetch($sql, $data, $all = false) {
        global $msgMYSQL;
        if (!self::ErroBanco()) {
            try {
                $query = $this->conn->prepare($sql);
                $query->execute($data);
                if (!$all) {
                    $return = $query->fetch(PDO::FETCH_OBJ);
                } else {
                    $return = $query->fetchAll(PDO::FETCH_OBJ);
                }
                return $return;
            } catch (Exception $ex) {
                throw new Exception($ex->getMessage());
            }
        }
    }

    /*     * *
     * segurança contra SQLInjection
     */

    function executeBindParam($sql, $param, $request) {
        global $msgMYSQL;
        if (!self::ErroBanco()) {
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam($param, $request, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    return $stmt->fetchAll(PDO::FETCH_OBJ);
                } else {
                    $error = $stmt->errorInfo();
                    throw new Exception($error[2]);
                }
            } catch (PDOException $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    function GetData($stmt, $All = true) {
        if (!self::ErroBanco()) {
            try {
                $temp = array();
                if ($All) {
                    while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                        $temp = $row;
                    }
                } else
                    $temp = $stmt->fetch(PDO::FETCH_ASSOC);
                return $temp;
            } catch (PDOException $e) {
                throw new Exception($e->getMessage() . ': ' . __FUNCTION__);
            }
        }
    }

    public function RowCount($SQL) {
        try {
            $query = $this->query($SQL);
            return $query->rowCount();
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

    function Get_NumRows($dados) {
        $n_rows = count($dados);
        return $n_rows;
    }

    static function ErroBanco() {
        global $msgMYSQL;

        if ($msgMYSQL[0] != NULL)
            return utf8_encode($msgMYSQL[0]);
        else
            return '';
    }

}

?>
