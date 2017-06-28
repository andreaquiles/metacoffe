<?php

class pessoasDAO {

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
            $fields = $data;

            $tmp = array();
            foreach ($fields as $k => $v) {
                if ($k != $dbk) {
                    $tmp[] = $k . ' = :' . $k;
                }
            }
            if (isset($dbk)) {
                if ($table === 'pessoas') {
                    $fields['pessoa_id'] = $dbk;
                    $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (pessoa_id=:pessoa_id)';
                } elseif ($table === 'pessoas_informacao') {
                    $fields['pessoa_id'] = $dbk;
                    $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (pessoa_id=:pessoa_id)';
                }
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
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

    static function getPessoa($pessoa_id) {
        try {
            $sql = "SELECT p.*,pi.* FROM pessoas p "
                    . " INNER JOIN pessoas_informacao pi  ON p.pessoa_id = pi.pessoa_id"
                    . " WHERE p.pessoa_id = '" . $pessoa_id . "'";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy, false);

            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getListaPessoas($Limit) {
        try {
            $sql = " SELECT p.*,pi.nome,pi.email "
                    . " FROM pessoas p INNER JOIN pessoas_informacao pi ON p.pessoa_id = pi.pessoa_id"
                    . " WHERE p.usuario_id=" . $_SESSION['admin']
                    . " LIMIT $Limit";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaPessoasCount() {
        try {
            $SQL = "SELECT pessoa_id FROM pessoas"
                    . " WHERE usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkEmail($email) {
        try {
            $SQL = "SELECT * FROM pessoas_informacao "
                    . " WHERE email= ?"
                    . " AND usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($email), TRUE);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getCpfCnpj($cpf_cnpj) {
        try {
            $SQL = "SELECT cpf,cnpj FROM pessoas_informacao  "
                    . " WHERE (cpf = ? OR cnpj= ?) "
                    . " AND usuario_id=".USUARIO_ID;
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($cpf_cnpj, $cpf_cnpj));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkCnpjDiff($cnpj, $pessoa_id) {
        try {
            $SQL = "SELECT * FROM pessoas_informacao "
                    . " WHERE cnpj = ? "
                    . " AND pessoa_id <> ?"
                    . " AND usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($cnpj, $pessoa_id));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkLogin($login) {
        try {
            $SQL = "SELECT pessoa_id FROM pessoas "
                    . " WHERE login = ? "
                    . " AND usuario_id=".USUARIO_ID;
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($login));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkLoginDiff($login, $pessoa_id) {
        try {
            $SQL = "SELECT * FROM pessoas "
                    . " WHERE login = ? "
                    . " AND pessoa_id <> ?"
                    . " AND usuario_id=".USUARIO_ID;
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($login, $pessoa_id));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkCpfDiff($cpf, $pessoa_id) {
        try {
            $SQL = "SELECT * FROM pessoas_informacao "
                    . " WHERE cpf = ? "
                    . " AND pessoa_id <> ?"
                    . " AND usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($cpf, $pessoa_id));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function ajax_autocomplete($field, $request) {
        try {
            $param = ':search';
            $sql = "SELECT * FROM pessoas_informacao "
                    . " WHERE LOCATE($param, CONVERT($field USING latin1))   "
                    . " AND usuario_id=" . $_SESSION['admin']
                    . " GROUP BY $field"
                    . " ORDER BY $field ASC"
                    . " LIMIT 15";
            $db = new DB();
            return $db->executeBindParam($sql, $param, $request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getPesquisaPessoas($inputGET, $valor, $limit) {
        try {
            $SQL = "SELECT pi.nome,pi.email,pi.pessoa_id,p.vender,p.comprar"
                    . " FROM pessoas_informacao pi INNER JOIN pessoas p ON pi.pessoa_id = p.pessoa_id "
                    . " WHERE " . $inputGET['busca'] . " LIKE '%" . $valor . "%'"
                    . " AND p.usuario_id=" . $_SESSION['admin']
                    . " LIMIT $limit";
            $db = new DB();
            return $db->GetData($db->query($SQL), true);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getPesquisaPessoasCount($inputGET, $valor) {
        try {
            $SQL = "SELECT pessoa_id FROM pessoas_informacao "
                    . " WHERE " . $inputGET['busca'] . " LIKE '%" . $valor . "%'"
                    . " AND usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            return $db->RowCount($SQL);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    
    public static function getLogin($data) {
        try {
            $email = $data['email'];
            $senha = FUNCOES::cryptografar($data['senha']);
            
            $sql = "SELECT p.pessoa_id,p.login, pi.nome"
                    . " FROM pessoas p INNER JOIN pessoas_informacao pi ON p.pessoa_id = pi.pessoa_id"
                    . " WHERE pi.email='$email' "
                    . " AND p.password='$senha' ";
            $db = new DB();
            $sqlmy = $db->query($sql);
            return $db->GetData($sqlmy, false);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }
    
    static function remover($ids,$usuario_id) {
        try {
            $SQL = "UPDATE pessoas SET bloqueado = 1"
                    . " WHERE pessoa_id  IN(" . implode(', ', $ids) . ')'
                    . " AND usuario_id = ".$usuario_id;
            $db = new DB();
            $db->query($SQL);
        } catch (Exception $err) {
            throw new Exception($SQL);
        }
    }

}
