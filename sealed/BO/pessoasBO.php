<?php
class pessoasBO {

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

    public static function getLogin($data) {
        try {
            $login = pessoasDAO::getLogin($data);
            if ($login) {
                $_SESSION['cliente_id'] = $login['cliente_id'];
                $_SESSION['cliente_nome'] = $login['nome'];
                $_SESSION["sessiontimeCliente"]  = time();
            } else {
                throw new Exception("Login e senha incorretos");
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
      public static function checkExpireLogin() {
        $temposessao = 3600 * 24; //1 dia
        if ($_SESSION["sessiontimeCliente"]) {
            if (($_SESSION["sessiontimeCliente"] < (time() - $temposessao))) {
                header("Location: logout.php");
            }
        } else {
             header("Location: logout.php");
        }
    }
    
     public static function getEspecifico($cpf_cnpj) {
        try {
              return clientesDAO::getEspecifico($cpf_cnpj);
        } catch (Exception $err) {
           throw new Exception($err->getMessage());
        }
    }

    public static function checkLogin() {
        try {
            if (!isset($_SESSION['cliente_id'])) {
                header("Location: login.php ");
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
   

    public static function logout() {
        $_SESSION['cliente_id'] = NULL;
       // header("Location: login.php ");
    }

    public static function salvar($data, $table, $dbk = NULL) {
        try {
            return pessoasDAO::salvar($data, $table, $dbk);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    
     public static function checkEmail($email) {
        try {
            return pessoasDAO::checkEmail($email);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }
    
    
    public static function getListaPessoas($Limit) {
        try {
            return pessoasDAO::getListaPessoas($Limit);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    
     public static function getListaPessoasCount() {
        try {
            return pessoasDAO::getListaPessoasCount();
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    
     public static function getCpfCnpj($cpf_cnpj) {
        try {
            return pessoasDAO::getCpfCnpj($cpf_cnpj);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
     public static function checkCnpjDiff($cnpj, $pessoa_id) {
        try {
            return pessoasDAO::checkCnpjDiff($cnpj, $pessoa_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
     public static function getPessoa($pessoa_id) {
        try {
            return pessoasDAO::getPessoa($pessoa_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    public static function ajax_autocomplete($field,$request) {
        try {
            return pessoasDAO::ajax_autocomplete($field,$request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    public static function getPesquisaPessoas($inputGET,$limit){
        try {
            if ($inputGET['nome']){
                $valor = $inputGET['nome'];
            }else{
               $valor = $inputGET['email']; 
            }
            return pessoasDAO::getPesquisaPessoas($inputGET,$valor,$limit);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    
     public static function getPesquisaPessoasCount($inputGET){
        try {
            if ($inputGET['nome']){
                $valor = $inputGET['nome'];
            }else{
               $valor = $inputGET['email']; 
            }
            return pessoasDAO::getPesquisaPessoasCount($inputGET,$valor);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
     

}

?>