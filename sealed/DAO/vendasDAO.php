<?php

class vendasDAO {

    private $banco;

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
                    $fields['venda_id'] = $dbk;
                    $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (venda_id=:venda_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }


}
