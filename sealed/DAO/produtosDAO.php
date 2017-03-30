<?php

class produtosDAO {

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
                $fields['produto_id'] = $dbk;
                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (produto_id=:produto_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getQuantidadeContatos($grupo_id) {
        try {
            $sql = "SELECT count(G.grupo_id) QUANTIDADE "
                    . " FROM grupos G INNER JOIN contatos "
                    . " C ON C.grupo_id=G.grupo_id "
                    . " WHERE G.grupo_id=" . $grupo_id;
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy, $All = false);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getContatosPorGrupo($grupo_id) {
        try {

            $sql = "SELECT * FROM contatos C  "
                    . " INNER JOIN grupos G  "
                    . " ON C.grupo_id = G.grupo_id "
                    . " WHERE C.grupo_id = " . $grupo_id;
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            $array = array();
            foreach ($dados as $dado) {
                $array[] = $dado['numero'];
            }
            return $array;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaProdutos($limit) {
        try {

            $sql = "SELECT * FROM produtos "
                    . " WHERE cliente_id=" . $_SESSION['cliente_id']
                    . " LIMIT $limit";
            $db = new DB();
            $sqlmy = $db->query($sql);
            return $dados = $db->GetData($sqlmy);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaCountProdutos() {
        try {
            $SQL = "  SELECT produto_id "
                    . " FROM produtos "
                    . " WHERE cliente_id =" . $_SESSION['cliente_id'];
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getProdutoEpecifico($produto_id) {
        try {

            $sql = "SELECT * FROM produtos "
                    . " WHERE produto_id=?"
                    . " AND cliente_id=" . $_SESSION['cliente_id'];
            $db = new DB();
            return $db->executeReturnFetch($sql, array($produto_id));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function ajax_autocomplete_produtos($request) {
        try {
            $param = ':search';
            $sql = "SELECT * FROM produtos "
                    . "WHERE LOCATE($param,item)  "
                    . " AND cliente_id=" . $_SESSION['cliente_id']
                    . " ORDER BY item LIMIT 10";
            $db = new DB();
            return $db->executeBindParam($sql, $param, $request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function deletar($produto_id) {
        try {
            $sql = "delete from produtos"
                    . " WHERE produto_id=" . $produto_id
                    . " AND cliente_id=" . $_SESSION['cliente_id'];
            $db = new DB();
            $db->query($sql);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function checkProduto($produto_id) {
        try {
            $SQL = "SELECT * FROM produtos_cotacao "
                    . " WHERE produto_id= ?"
                    . " AND cliente_id=" . $_SESSION['cliente_id'];
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($produto_id), FALSE);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function checkCodigoBarras($request) {
        try {
            $param = ':codigo_barras';
            $sql = "SELECT * FROM produtos "
                    . "WHERE LOCATE($param,codigo_barras)  "
                    . " AND cliente_id=" . $_SESSION['cliente_id']
                    . " ORDER BY item LIMIT 10";
            $db = new DB();
            return $db->executeBindParam($sql, $param, $request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function compararPreco($produto_id, $cotacao_id) {
        try {

            $SQL = "SELECT p.item,lc.cotacao_id,lc.preco ,lc.lista_cotacao_id
                    FROM produtos p INNER JOIN lista_cotacao lc  ON p.produto_id = lc.produto_id 
                    WHERE p.produto_id = ?
                    AND lc.cotacao_id = ?
                    AND lc.excluido IS NULL
                    ORDER BY lista_cotacao_id DESC
                    LIMIT 1";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($produto_id, $cotacao_id));
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function produtosMaisComprados() {
        try {

            $SQL = "SELECT p.item,count(lic.produto_id) quantidade
                     FROM lista_cotacao lic INNER JOIN cotacao c ON c.cotacao_id = lic.cotacao_id 
                     INNER JOIN produtos p ON p.produto_id = lic.produto_id
                     WHERE c.cliente_id = ? 
                     GROUP BY lic.produto_id
                     ORDER BY quantidade DESC 
                     LIMIT 30";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($_SESSION['cliente_id']), TRUE);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function produtosMaisCotados($ORDER) {
        try {
            $SQL = "SELECT p.item,COUNT(pc.produto_id)quantidade FROM produtos_cotacao pc INNER JOIN produtos p ON p.produto_id = pc.produto_id
                    WHERE pc.cliente_id = ?
                    GROUP BY pc.produto_id
                    $ORDER
                    LIMIT 10";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($_SESSION['cliente_id']), TRUE);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function produtosDaCotacao($cotacao_id) {
        try {
            $SQL = "SELECT p.item,p.produto_id FROM produtos_cotacao pc INNER JOIN produtos p ON p.produto_id = pc.produto_id
                    WHERE pc.cliente_id = ?
                    AND pc.cotacao_id = ?
                    GROUP BY pc.produto_id
                    ORDER BY p.produto_id";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($_SESSION['cliente_id'], $cotacao_id), TRUE);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getProdutosEmpatesCount($cotacao_id) {
        try {
            $SQL = "SELECT lic.lista_cotacao_id
                    FROM lista_cotacao lic INNER JOIN  
                    (SELECT a.cotacao_id,cot.cliente_id,b.min_val,pr.item,pr.produto_id,pr.codigo_barras,
                     f.nome,a.preco
                    FROM lista_cotacao a 
                    INNER JOIN( SELECT MIN(LC.preco)min_val,LC.produto_id 
                                FROM lista_cotacao LC
                                INNER JOIN cotacao COT ON COT.cotacao_id= LC.cotacao_id
                                WHERE LC.cotacao_id = $cotacao_id 
                                AND COT.cliente_id = " . $_SESSION['cliente_id'] . "
                                AND LC.preco <> 0
                                AND LC.excluido IS NULL 
                                GROUP BY produto_id)b 
                    ON a.preco = b.min_val
                    INNER JOIN cotacao cot ON cot.cotacao_id= a.cotacao_id
                    INNER JOIN cotacao_fornecedores CF ON CF.fornecedor_id= a.fornecedor_id
                    INNER JOIN produtos_cotacao p ON p.produto_id = a.produto_id
                    INNER JOIN produtos pr ON pr.produto_id = p.produto_id
                    INNER JOIN fornecedores f on f.fornecedor_id = a.fornecedor_id
                    WHERE a.cotacao_id = $cotacao_id
                    AND CF.cotacao_id = $cotacao_id
                    AND cot.cliente_id = " . $_SESSION['cliente_id'] . "
                    AND p.produto_id = b.produto_id    
                    AND a.excluido IS NULL 
                    GROUP BY p.produto_id 
                    HAVING COUNT(DISTINCT a.lista_cotacao_id)>1
                    )interno ON interno.produto_id = lic.produto_id AND lic.preco = interno.min_val
                    WHERE lic.cotacao_id =". $cotacao_id;
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getProdutosEmpates($cotacao_id) {
        try {
            $SQL = "SELECT lic.lista_cotacao_id,interno.produto_id,interno.item,
                    interno.codigo_barras,forn.nome,interno.preco,interno.cotacao_id 
                    FROM lista_cotacao lic INNER JOIN  
                    (SELECT a.cotacao_id,cot.cliente_id,b.min_val,pr.item,pr.produto_id,pr.codigo_barras,
                     f.nome,a.preco
                    FROM lista_cotacao a 
                    INNER JOIN( SELECT MIN(LC.preco)min_val,LC.produto_id 
                                FROM lista_cotacao LC
                                INNER JOIN cotacao COT ON COT.cotacao_id= LC.cotacao_id
                                WHERE LC.cotacao_id = $cotacao_id 
                                AND COT.cliente_id = " . $_SESSION['cliente_id'] . "
                                AND LC.preco <> 0
                                AND LC.excluido IS NULL 
                                GROUP BY produto_id)b 
                    ON a.preco = b.min_val
                    INNER JOIN cotacao cot ON cot.cotacao_id= a.cotacao_id
                    INNER JOIN cotacao_fornecedores CF ON CF.fornecedor_id= a.fornecedor_id
                    INNER JOIN produtos_cotacao p ON p.produto_id = a.produto_id
                    INNER JOIN produtos pr ON pr.produto_id = p.produto_id
                    INNER JOIN fornecedores f on f.fornecedor_id = a.fornecedor_id
                    WHERE a.cotacao_id = $cotacao_id
                    AND CF.cotacao_id = $cotacao_id
                    AND cot.cliente_id = " . $_SESSION['cliente_id'] . "
                    AND p.produto_id = b.produto_id  
                    AND a.excluido IS NULL 
                    GROUP BY p.produto_id 
                    HAVING COUNT(DISTINCT a.lista_cotacao_id)>1
                    )interno ON interno.produto_id = lic.produto_id AND lic.preco = interno.min_val
                     INNER JOIN fornecedores forn ON forn.fornecedor_id = lic.fornecedor_id
                    WHERE lic.cotacao_id =". $cotacao_id;
                     
            $db = new DB();
            $sqlmy = $db->query($SQL);
            $dado = $db->GetData($sqlmy);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getProdutosSemPrecos($cotacao_id) {
        try {
            $cliente_id = $_SESSION['cliente_id'];
            $sql = "SELECT p.item,p.codigo_barras,lc.preco,pc.produto_id 
                    FROM  lista_cotacao lc 
                    RIGHT JOIN produtos_cotacao pc ON pc.cotacao_id = lc.cotacao_id AND pc.produto_id = lc.produto_id
                    INNER JOIN produtos p ON p.produto_id = pc.produto_id
                    WHERE 
                    pc.cotacao_id = $cotacao_id
                    AND pc.cliente_id = $cliente_id
                    AND lc.excluido IS NULL    
                    AND lc.preco IS NULL 
                    GROUP BY pc.produto_id";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($sql);
        }
    }

    public static function getProdutosSemPrecos2($cotacao_id) {
        try {
            $cliente_id = $_SESSION['cliente_id'];
            $sql = "SELECT max(lc.preco) maximo,p.item,p.codigo_barras,lc.preco,pc.produto_id 
                    FROM  lista_cotacao lc 
                    INNER JOIN produtos_cotacao pc ON pc.cotacao_id = lc.cotacao_id AND pc.produto_id = lc.produto_id
                    INNER JOIN produtos p ON p.produto_id = pc.produto_id
                    WHERE 
                    pc.cotacao_id = $cotacao_id
                    AND pc.cliente_id = $cliente_id
                    AND lc.excluido IS NULL
                    GROUP BY p.produto_id
                    HAVING max(lc.preco)  = 0 ";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($sql);
        }
    }
    
    static function getDuplicado($produto_id, $cotacao_id, $preco) {
        try {
            $SQL = " SELECT LC.lista_cotacao_id
            FROM  lista_cotacao LC
            INNER JOIN cotacao_fornecedores CF ON LC.fornecedor_id = CF.fornecedor_id
            WHERE CF.cotacao_id = $cotacao_id
            AND LC.cotacao_id   = $cotacao_id
            AND LC.produto_id = $produto_id
            AND LC.preco = $preco
            AND LC.excluido IS NULL    
            GROUP BY  LC.lista_cotacao_id";

            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function teste() {
        try {
            $SQL = "SELECT count(produto_id)quantidade FROM produtos_cotacao "
                    . " WHERE cotacao_id = 28"
                    . " AND cliente_id = ?";
            $db = new DB();
            return $db->executeReturnFetch($SQL, array($_SESSION['cliente_id']), false);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

}

?>
