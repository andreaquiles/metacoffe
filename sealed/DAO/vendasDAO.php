<?php

class vendasDAO {

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
                $fields['venda_id'] = $dbk;
                $SQL = 'UPDATE ' . $table . ' SET ' . implode(', ', $tmp) . ' WHERE (venda_id=:venda_id)';
            } else {
                $SQL = 'INSERT INTO ' . $table . ' SET ' . implode(', ', $tmp);
            }

            $db = new DB();
            return $db->InsertData($SQL, $fields);
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage() . ': ' . __FUNCTION__);
        }
    }

    public static function getListaVendas($Limit) {
        try {
             $SQL = " SELECT a.n_lote,s.situacao,v.valor,DATE_FORMAT(v.data, '%d/%m/%Y')data,p.nome,p.razao_social "
                    . " FROM amostras a INNER JOIN status s ON s.amostra_id = a.amostra_id "
                    . " INNER JOIN ofertas o ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN vendas v ON a.amostra_id = v.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = v.pessoa_id "
                    . " WHERE v.usuario_id = ".$_SESSION['admin']
                    . " GROUP BY v.venda_id"
                    . " ORDER BY v.data DESC"
                    . " LIMIT $Limit";
            $db = new DB();
            $sqlmy = $db->query($SQL);
            $dados = $db->GetData($sqlmy);
            return $dados;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

    static function getListaVendasCount() {
        try {
            $SQL = " SELECT v.venda_id "
                    . " FROM amostras a INNER JOIN status s ON s.amostra_id = a.amostra_id "
                    . " INNER JOIN ofertas o ON o.amostra_id = a.amostra_id "
                    . " INNER JOIN vendas v ON a.amostra_id = v.amostra_id "
                    . " INNER JOIN pessoas_informacao p ON p.pessoa_id = v.pessoa_id "
                    . " WHERE v.usuario_id = ".$_SESSION['admin']
                    . " GROUP BY v.venda_id";
            $db = new DB();
            $count = $db->RowCount($SQL);
            return $count;
        } catch (Exception $err) {
            throw new Exception($err->getMessage() . ': ' . __FUNCTION__);
        }
    }

}
