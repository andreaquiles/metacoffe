<?php

class regiaoDAO {

    function __construct() {
        
    }

    public function __set($campo, $valor) {
        $this->$campo = $valor;
    }

    public function __get($campo) {
        return $this->$campo;
    }

    static function salvar($data, $table, $dbk = NULL) {
        try {
            $fields = ($data);
            $tmp = array();
            foreach ($fields as $k => $v) {
                if ($k != $dbk) {
                    $tmp[] = $k . ' = :' . $k;
                }
            }
            if (isset($dbk)) {
                $fields['regiao_id'] = $dbk;
                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (regiao_id=:regiao_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function deletarContatoFornecedores($cotacao_id) {
        try {
            $sql = 'DELETE FROM cotacao_fornecedores WHERE cotacao_id =' . $cotacao_id;
            $db = new DB();
            $sqlmy = $db->query($sql);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    
    public static function listaRegioesHTML($user_id) {
        try {
            $SQL = "SELECT * FROM regiao "
                    . " WHERE usuario_id = ?";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($user_id),true);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    
     public static function listaRegioes() {
        try {
            $SQL = "SELECT * FROM regiao "
                    . " WHERE usuario_id = ?";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($_SESSION['admin']),true);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

}
