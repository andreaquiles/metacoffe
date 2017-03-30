<?php 

class usuariosBO {

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
            $dado = usuariosDAO::getLogin($data);
            if ($dado) {
                $_SESSION['admin'] = $dado['usuario_id'];
                $_SESSION['admin_email'] = $dado['email'];
                $_SESSION["sessiontimeAdmin"] = time();
            } else {
                throw new Exception("email e senha incorretos");
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    public static function checkExpireLogin() {
        $temposessao = 3600 * 24; //1 dia
        if ($_SESSION["sessiontimeAdmin"]) {
            if (($_SESSION["sessiontimeAdmin"] < (time() - $temposessao))) {
                header("Location: logout.php");
            }
        } else {
            header("Location: logout.php");
        }
    }

    
     public static function checkLogin() {
        try {
            if (!isset($_SESSION['admin'])) {
                header("Location: login.php ");
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    
    
     public static function getEspecifico($cpf_cnpj) {
        try {
              return clientesDAO::getEspecifico($cpf_cnpj);
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
            return clientesDAO::salvar($data, $table, $dbk);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function deletarContato($contato_id) {
        try {
            return contactsDAO::deletarContato($contato_id);
        } catch (Exception $err) {
            die('Erro: ' . $err->getMessage());
        }
    }

    public static function getQuantidadeContatos($grupo_id) {
        try {
            return contatoDAO::getQuantidadeContatos($grupo_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public static function getContatosPorGrupo($grupo_id) {
        try {
            return contatoDAO::getContatosPorGrupo($grupo_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public static function getConferirContatosPorGrupo($dado) {
        try {
            if (contatoDAO::getConferirContatosPorGrupo($dado)) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }
    
    

}

?>