<?php

class amostrasBO {

    function __construct() {
        
    }

    function __destruct() {
        
    }

    public function __set($campo, $valor) {
        $this->$campo = $valor;
    }

    public function __get($campo) {
        return $this->$campo;
    }

    

    public static function salvar($data, $table, $dbk = NULL) {
        try {
            return amostrasDAO::salvar($data, $table, $dbk);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    
}
