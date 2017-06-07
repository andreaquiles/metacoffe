<?php

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "autoload.php";

$action = filter_input(INPUT_POST, 'acao');
$oferta_id = filter_input(INPUT_POST, 'oferta_id');

switch ($action) {
    case "load_oferta":
        try {
            $dado = ofertasDAO::getOfertaEspecifica($oferta_id);
            $dado['valor'] = $dado['valor_oferta'];
            $dado['valor_oferta'] = 'R$ ' . FUNCOES::formatoDecimalHTML($dado['valor_oferta']);
            if (!empty($dado['razao_social'])) {
                $dado['nome'] = $dado['razao_social'];
            }
            $response = $dado;
            if (funcoes::isAjax()) {
                echo json_encode($response);
            }
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
        break;
}

