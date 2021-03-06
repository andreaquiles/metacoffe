<?php

class statusDAO {

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
                    $fields['amostra_id'] = $dbk;
                    $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (amostra_id=:amostra_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

//    public static function deletarImagens($amostra_imagem_id) {
//        try {
//            $sql = 'DELETE FROM amostras_imagens'
//                    . ' WHERE amostra_imagem_id =' . $amostra_imagem_id;
//            $db = new DB();
//            $db->query($sql);
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    public static function updateImagens($amostra_imagem_id) {
//        try {
//            $sql = 'UPDATE amostras_imagens '
//                    . ' SET principal = NULL'
//                    . ' WHERE amostra_imagem_id <>' . $amostra_imagem_id;
//            $db = new DB();
//            $db->query($sql);
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    public static function getListaAmostras($Limit) {
//        try {
//            $sql = " SELECT amostra_id,n_lote,regiao "
//                    . " FROM amostras "
//                    . " WHERE usuario_id=" . $_SESSION['admin']
//                    . " LIMIT $Limit";
//            $db = new DB();
//            $sqlmy = $db->query($sql);
//            $dados = $db->GetData($sqlmy);
//            return $dados;
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    static function getListaAmostrasCount() {
//        try {
//            $SQL = " SELECT amostra_id "
//                    . " FROM amostras "
//                    . " WHERE usuario_id= " . $_SESSION['admin'];
//            $db = new DB();
//            $count = $db->RowCount($SQL);
//            return $count;
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    static function getListaAmostrasHTMLCount($user_id) {
//        try {
//            $SQL = " SELECT a.amostra_id "
//                    . " FROM amostras a "
//                    . " INNER JOIN status s ON s.amostra_id = a.amostra_id "
//                    . " WHERE a.usuario_id= " . $user_id
//                    . " AND (s.situacao IS NULL) ";
//            $db = new DB();
//            $count = $db->RowCount($SQL);
//            return $count;
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    static function getAmostra($amostra_id) {
//        try {
//            $SQL = "SELECT * "
//                    . " FROM amostras"
//                    . " WHERE amostra_id =" . $amostra_id;
//            $db = new DB();
//            $sqlmy = $db->query($SQL);
//            $dado = $db->GetData($sqlmy, false);
//
//            return $dado;
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    static function getPesquisaAmostrasCount($dataGet) {
//        try {
//            $SQL = "SELECT amostra_id "
//                    . " FROM amostras"
//                    . " WHERE tipo ='" . $dataGet['tipo'] . "'"
//                    . " AND bebida = '" . $dataGet['bebida'] . "'"
//                    . " AND regiao= '" . $dataGet['regiao'] . "'"
//                    . " AND usuario_id=" . $_SESSION['admin'];
//            $db = new DB();
//            $count = $db->RowCount($SQL);
//            return $count;
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }
//
//    static function getPesquisaAmostras($dataGet, $limit) {
//        try {
//            $SQL = "SELECT * "
//                    . " FROM amostras"
//                    . " WHERE tipo ='" . $dataGet['tipo'] . "'"
//                    . " AND bebida = '" . $dataGet['bebida'] . "'"
//                    . " AND regiao= '" . $dataGet['regiao'] . "'"
//                    . " AND usuario_id=" . $_SESSION['admin']
//                    . " LIMIT $limit";
//            $db = new DB();
//            return $db->GetData($db->query($SQL), true);
//            // return $db->executeReturnFetch($SQL, array($dataGet['tipo'], $dataGet['bebida'],$dataGet['regiao']), true);
//        } catch (Exception $err) {
//            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
//        }
//    }

}
