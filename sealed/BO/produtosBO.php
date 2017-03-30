<?php

//require_once dirname(dirname(__FILE__)).'/DAO/produtosDAO.php';

class produtosBO {

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

    public static function getContatos($id, $bool_user_id) {
        try {
            return contactsDAO::getContatos($id, $bool_user_id);
        } catch (Exception $err) {
            die('Erro: ' . $err->getMessage());
        }
    }

    public static function getContato($id) {
        try {
            return contatoDAO::getContato($id);
        } catch (Exception $err) {
            die('Erro: ' . $err->getMessage());
        }
    }

    public static function salvar($data, $table, $dbk = NULL) {
        try {
            return produtosDAO::salvar($data, $table, $dbk);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function ajax_autocomplete_produtos($request) {
        try {
            return produtosDAO::ajax_autocomplete_produtos($request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public static function getListaCountProdutos() {
        try {
            return produtosDAO::getListaCountProdutos();
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public static function getListaProdutos($limit) {
        try {
            return produtosDAO::getListaProdutos($limit);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public static function getProdutoEpecifico($produto_id) {
        try {
            return produtosDAO::getProdutoEpecifico($produto_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

//    static function deletarContato($contato_id) {
//        try {
//            return contactsDAO::deletarContato($contato_id);
//        } catch (Exception $err) {
//            die('Erro: ' . $err->getMessage());
//        }
//    }
//    public static function getQuantidadeContatos($grupo_id) {
//        try {
//            return contatoDAO::getQuantidadeContatos($grupo_id);
//        } catch (Exception $err) {
//           throw new Exception($err->getMessage());
//        }
//    }
//    
//    public static function getContatosPorGrupo($grupo_id) {
//        try {
//            return contatoDAO::getContatosPorGrupo($grupo_id);
//        } catch (Exception $err) {
//             throw new Exception($err->getMessage());
//        }
//    }
//    public static function getConferirContatosPorGrupo($dado) {
//        try {
//            if (contatoDAO::getConferirContatosPorGrupo($dado)) {
//                return true;
//            } else {
//                return false;
//            }
//        } catch (Exception $err) {
//             throw new Exception($err->getMessage());
//        }
//    }

    public static function deletar($produto_id) {
        try {
            $dado = produtosDAO::checkProduto($produto_id);
            if ($dado) {
                return false;
            } else {
                produtosDAO::deletar($produto_id);
                return true;
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function checkCodigoBarras($request) {
        try {
            return produtosDAO::checkCodigoBarras($request);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function compararPreco($produto_id, $cotacao_id) {
        try {
            return produtosDAO::compararPreco($produto_id, $cotacao_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function produtosMaisComprados() {
        try {
            return produtosDAO::produtosMaisComprados();
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function produtosMaisCotados($ORDER) {
        try {
            if ($ORDER == "+") {
                $ORDER = "ORDER BY quantidade DESC";
            } elseif ($ORDER == "-") {
                $ORDER = "ORDER BY quantidade ASC";
            }
            return produtosDAO::produtosMaisCotados($ORDER);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function produtosDaCotacao($cotacao_id) {
        try {

            return produtosDAO::produtosDaCotacao($cotacao_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function getProdutosEmpates($cotacao_id) {
        try {

            return produtosDAO::getProdutosEmpates($cotacao_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function getProdutosEmpatesCount($cotacao_id) {
        try {

            return produtosDAO::getProdutosEmpatesCount($cotacao_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function getProdutosSemPrecos($cotacao_id) {
        try {

            return produtosDAO::getProdutosSemPrecos($cotacao_id);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }

    public static function getProdutosSemPrecos2($cotacao_id) {
        try {
            $semprecos = produtosDAO::getProdutosSemPrecos2($cotacao_id);
            if (empty($semprecos)) {
                $semprecos = produtosDAO::getProdutosSemPrecos($cotacao_id);
            }
            return $semprecos;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ');
        }
    }
    
    public static function getDuplicado($produto_id, $cotacao_id, $preco) {
        try {
            return produtosDAO::getDuplicado($produto_id, $cotacao_id, $preco);
        } catch (Exception $err) {
            die('Erro: ' . $err->getMessage());
        }
    }

}

?>