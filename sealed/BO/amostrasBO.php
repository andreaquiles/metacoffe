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

    public static function ajax_autocomplete($action, $request, $user_id = NULL) {
        try {
            if (empty($user_id)){
                $user_id = $_SESSION['admin'];
            }
            return amostrasDAO::ajax_autocomplete($action, $request, $user_id);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

}
