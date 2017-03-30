<?php

class usuariosDAO {

    function __construct() {
        
    }

    function __destruct() {
        //$this->banco = NULL;
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
                $fields['cliente_id'] = $dbk;
                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (cliente_id=:cliente_id)';
//                $fields['fornecedor_id'] = $dbk;
//                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (fornecedor_id=:fornecedor_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getCotacaoEspecifica($id) {
        try {
            $sql = " SELECT LC.lista_cotacao_id,C.nome,LC.preco,P.quantidade,P.item FROM cotacao C  "
                    // . " INNER JOIN cotacao_fornecedores CF ON C.cotacao_id = CF.cotacao_id "
                    . " INNER JOIN lista_cotacao LC ON LC.cotacao_id = C.cotacao_id "
                    . " INNER JOIN produtos_cotacao P ON P.produto_id = LC.produto_id "
                    . " WHERE LC.fornecedor_id =   " . $_SESSION['fornecedor_id']
                    . " AND LC.cotacao_id = $id"
                    . " GROUP BY LC.lista_cotacao_id";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getEspecifico($cpf_cnpj) {
        try {
            $sql = "SELECT cpf,cnpj FROM clientes  "
                    . " WHERE cpf = '" . $cpf_cnpj . "'"
                    . " OR cnpj= '" . $cpf_cnpj . "'";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy, false);

            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getCotacao($data) {
        try {
            $sql = " SELECT C.nome,P.* FROM cotacao C  "
                    . " INNER JOIN cotacao_fornecedores CF ON C.cotacao_id = CF.cotacao_id "
                    . " INNER JOIN produtos_cotacao P ON P.cotacao_id = C.cotacao_id "
                    . " WHERE CF.fornecedor_id = " . $data['fornecedor_id'] . " "
                    . " AND C.cotacao_id =" . $data['cotacao_id'] . " "
                    . " AND C.data_encerramento IS NULL";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getLogin($data) {
        try {
            $email = $data['email'];
            $senha = FUNCOES::cryptografar($data['senha']);
            $sql = "SELECT * FROM usuarios where email='$email' AND senha='$senha' ";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy, FALSE);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    

    

}