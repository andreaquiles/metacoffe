<?php

class ofertasBO {

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
            return ofertasDAO::salvar($data, $table, $dbk);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
    public static function deletarOferta($amostra_id,$pessoa_id) {
        try {
            return ofertasDAO::deletarOferta($amostra_id,$pessoa_id);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}
