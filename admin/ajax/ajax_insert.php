<?php
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."autoload.php";
$action = filter_input(INPUT_POST, 'action');
$produto = filter_input(INPUT_POST, 'produto');

switch ($action) {
    case "_produto":
        try {
            $data['item'] = $produto;
            $data['codigo_barras'] = '000000';
            $data['cliente_id'] = $_SESSION['cliente_id'];
            $produto_id = produtosBO::salvar($data, 'produtos');
            $codigo_Interno = $_SESSION['cliente_id'].$produto_id.FUNCOES::random_pass(4,FALSE,FALSE,TRUE);
            $data['codigo_interno'] = $codigo_Interno;
            $produto_id = produtosBO::salvar($data, 'produtos',$produto_id);
            $response['id_produto'] = $produto_id;
        } catch (Exception $e) {
            $response['error'] = $e->getMessage();
        }
        break;
}

if (funcoes::isAjax()) {
    print json_encode($response);
}
