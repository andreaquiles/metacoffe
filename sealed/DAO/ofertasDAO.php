<?php

class ofertasDAO {

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
                $fields['oferta_id'] = $dbk;
                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (oferta_id=:oferta_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function deletarOferta($amostra_id, $pessoa_id) {
        try {
            $sql = 'DELETE FROM ofertas'
                    . ' WHERE amostra_id =' . $amostra_id
                    . ' AND pessoa_id=' . $pessoa_id;
            $db = new DB();
            $db->query($sql);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getOfertaEspecifica($oferta_id) {
        try {
            $sql = " SELECT o.oferta_id,s.situacao,o.valor valor_oferta,o.amostra_id,o.observacao,p.pessoa_id,p.nome,p.razao_social "
                    . " FROM ofertas o INNER JOIN status s "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = o.pessoa_id "
                    . " WHERE p.usuario_id = " . $_SESSION['admin']
                    . " AND o.oferta_id=" . $oferta_id;
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dado = $db->GetData($sqlmy, FALSE);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getListaOfertas($Limit) {
        try {
            $sql = " SELECT o.oferta_id,a.n_lote,s.situacao,o.valor valor_oferta,p.pessoa_id,p.nome,"
                    . " p.razao_social,DATE_FORMAT(o.data, '%d/%m/%Y')data "
                    . " FROM ofertas o  INNER JOIN status s "
                    . " INNER JOIN amostras A ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = o.pessoa_id "
                    . " WHERE p.usuario_id = " . $_SESSION['admin']
                    . " AND ".AMOSTRAS_AVALIABLE
                    . " ORDER BY n_lote,o.valor DESC"
                    . " LIMIT $Limit";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaOfertasCount() {
        try {
            $SQL = " SELECT o.oferta_id  FROM ofertas o INNER JOIN status s "
                    . " INNER JOIN amostras A ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = o.pessoa_id "
                    . " WHERE p.usuario_id = " . $_SESSION['admin']
                    . " AND ".AMOSTRAS_AVALIABLE;
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaOfertasCountAmostraID($amostra_id) {
        try {
            $SQL = " SELECT o.oferta_id  FROM ofertas o INNER JOIN status s "
                    . " INNER JOIN amostras A ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = o.pessoa_id "
                    . " WHERE p.usuario_id = " . $_SESSION['admin']
                    . " AND o.amostra_id = " . $amostra_id
                    . " AND ".AMOSTRAS_AVALIABLE;
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getListaOfertasAmostra($Limit, $amostra_id) {
        try {
            $sql = " SELECT o.oferta_id,a.n_lote,s.situacao,o.valor valor_oferta,p.pessoa_id,"
                    . " p.nome,p.razao_social,DATE_FORMAT(o.data, '%d/%m/%Y')data "
                    . " FROM ofertas o  INNER JOIN status s "
                    . " INNER JOIN amostras A ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = o.pessoa_id "
                    . " WHERE p.usuario_id = " . $_SESSION['admin']
                    . " AND o.amostra_id = " . $amostra_id
                    . " AND ".AMOSTRAS_AVALIABLE
                    . " ORDER BY n_lote,o.valor DESC"
                    . " LIMIT $Limit";
            $db = new DB();
            $sqlmy = $db->query($sql);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaAmostrasHTMLCount($user_id) {
        try {
            $SQL = " SELECT a.amostra_id "
                    . " FROM amostras a "
                    . " INNER JOIN status s ON s.amostra_id = a.amostra_id "
                    . " WHERE a.usuario_id= " . $user_id
                    . " AND (s.situacao IS NULL) ";
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getAmostra($amostra_id) {
        try {
            $SQL = "SELECT * "
                    . " FROM amostras"
                    . " WHERE amostra_id =" . $amostra_id;
            $db = new DB();
            $sqlmy = $db->query($SQL);
            $dado = $db->GetData($sqlmy, false);
            return $dado;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getPesquisaAmostrasCount($dataGet) {
        try {
            $SQL = "SELECT amostra_id "
                    . " FROM amostras"
                    . " WHERE tipo ='" . $dataGet['tipo'] . "'"
                    . " AND bebida = '" . $dataGet['bebida'] . "'"
                    . " AND regiao= '" . $dataGet['regiao'] . "'"
                    . " AND usuario_id=" . $_SESSION['admin'];
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getPesquisaAmostras($dataGet, $limit) {
        try {
            $SQL = "SELECT * "
                    . " FROM amostras"
                    . " WHERE tipo ='" . $dataGet['tipo'] . "'"
                    . " AND bebida = '" . $dataGet['bebida'] . "'"
                    . " AND regiao= '" . $dataGet['regiao'] . "'"
                    . " AND usuario_id=" . $_SESSION['admin']
                    . " LIMIT $limit";
            $db = new DB();
            return $db->GetData($db->query($SQL), true);
            // return $db->executeReturnFetch($SQL, array($dataGet['tipo'], $dataGet['bebida'],$dataGet['regiao']), true);
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

}
