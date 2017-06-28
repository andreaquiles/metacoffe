<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
pessoasBO::checkExpireLogin();
pessoasBO::checkLogin();

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir|not_vendedor|vendedor)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'pessoa_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'busca' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'nome' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'email' => array(
        'filter' => FILTER_DEFAULT,
    )
);


$filterGETBusca = array(
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'busca' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'tipo' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'bebida' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'regiao' => array(
        'filter' => FILTER_DEFAULT,
    )
);

$argsPost = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir|exportar_xls)$/")
    ),
    'ids' => array(
        'filter' => FILTER_VALIDATE_INT,
        'flags' => FILTER_REQUIRE_ARRAY
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);


$inputPOST = filter_input_array(INPUT_POST, $argsPost);
$dataGet = filter_input_array(INPUT_GET, $filterGET);
$dataGetBusca = filter_input_array(INPUT_GET, $filterGETBusca);
if (!$dataGet['page']) {
    $dataGet['page'] = 1;
}

try {
    $regioes = regiaoDAO::listaRegioes();

    if (($dataGetBusca['bebida'] && $dataGetBusca['regiao'])) {
        $arrayBusca = array('tipo' => $dataGet['tipo'], 'bebida' => $dataGet['bebida'], 'regiao' => $dataGet['regiao'], 'page' => $dataGet['page']);
        $count = amostrasDAO::getPesquisaAmostrasPessoasCount($dataGetBusca);
        $paginador = new paginador($dataGetBusca['page'], $count, 20, '', $arrayBusca);
        $dados = amostrasDAO::getPesquisaAmostrasPessoas($dataGetBusca, $paginador->getPage());
    } else {
        $count = amostrasDAO::getListaAmostrasPessoasCount();
        $paginador = new paginador($dataGet['page'], $count, 20, '');
        $dados = amostrasDAO::getListaAmostrasPessoas($paginador->getPage());
    }
    /**
     * action via post EXCLUIR
     */
//    if (isset($dataGet['action'])) {
//        if ($dataGet['action'] == 'excluir') {
//            if (isset($dataGet['fornecedor_id'])) {
//                try {
//                    $result = fornecedoresBO::deletar($dataGet['fornecedor_id']);
//                    if ($result == true) {
//                        $response['success'][] = 'Fornecedor excluído com sucesso!';
//                        $response['link'] = 'fornecedor?page=' . $dataGet['page'];
//                    }else{
//                        $response['error'][] = "Fornecedor já está vinculado a uma cotação !!";
//                    }
//                } catch (Exception $err) {
//                    $response['error'][] = $err->getMessage();
//                }
//            }
//        }
//    }
//    if (isset($dataGet['action'])) {
//        if ($dataGet['action'] == 'not_vendedor') {
//            try {
//                $data = array();
//                $data['vender'] = NULL;
//                pessoasBO::salvar($data, 'pessoas', $dataGet['pessoa_id']);
//                $response['success'][] = 'Alteração realizada com sucesso!';
//                $response['link'] = $_SERVER['PHP_SELF'] . '?'.  http_build_query($dataGetBusca);
//            } catch (Exception $err) {
//                $response['error'][] = $err->getMessage();
//            }
//        }
//        if ($dataGet['action'] == 'vendedor') {
//            try {
//                $data = array();
//                $data['vender'] = 1;
//                pessoasBO::salvar($data, 'pessoas', $dataGet['pessoa_id']);
//                $response['success'][] = 'Alteração realizada com sucesso!';
//                $response['link'] = $_SERVER['PHP_SELF'] . '?'.  http_build_query($dataGetBusca);
//            } catch (Exception $err) {
//                $response['error'][] = $err->getMessage();
//            }
//        }
//    }

    if (!$dataGet['page']) {
        $dataGet['page'] = 1;
    }
} catch (Exception $e) {
    $response['error'][] = $e->getMessage();
}
if (FUNCOES::isAjax()) {
    print json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?= TITLE; ?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../admin/assets/js/bootbox.min.js"></script>
        <script src="../assets/js/autocomplete.js"></script>
        <link href="../assets/css/autocomplete.css" rel="stylesheet">

        <style>
            .photo {
                float: left;
                margin: 0.5em;
                border: 1px solid #ccc;
                padding: 1em;
                font-size: 10px;
            }
            #footer {
                background-color: #F5F5F5;
                bottom: 0;
                height: 50px;
                position: relative;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div id="alerta">
            <?php
            if (isset($response['error'])) {
                if (!empty($response['error'])) {
                    ?>
                    <div class="alert alert-danger fade in" role="alert">
                        <?php echo implode('<br>', $response['error']); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                        <h4 class="modal-title">Aguarde</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <?php include 'includes/header.php'; ?>


        <div class="container-fluid">

            <div id="paginador_info_clientes">
                <?php echo $paginador->getInfo(); ?>
            </div>


            <ol class="breadcrumb">
                <li><a href="<?= HOME ?>">Home</a></li>
                <li class="active"><?= AMOSTRAS ?> </li>
            </ol>
            <ol class="breadcrumb" >
                <a  href="amostra_editar.php" role="button" class="btn btn-primary"> <span class="glyphicon glyphicon-plus-sign"></span>
                    <b>Nova Amostra</b>
                </a>
                <a class="btn btn-default excluir" >
                    <span class="glyphicon glyphicon-remove-circle excluir" aria-hidden="true"></span> Remover
                </a>
                <a class="btn btn-danger" data-toggle="tooltip" title="PDF" 
                   href="index.php?action=usuarios&<?= http_build_query($dataGet) ?>" target="_blank">
                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download
                </a>
                <div class="form-group pull-right">
                    <form class="form-inline pull-right noAjax" method="get">
                        <input name="page" type="hidden"  value="<?= $dataGet['page']; ?>">

                        <div class="form-group" style="">
                            <div class="checkbox pull-left">
                                <label>
                                    <input type="radio" value="arabica"  name="tipo" <?php if ($dataGetBusca['tipo'] == "arabica" || empty($dataGetBusca['tipo'])) echo " checked"; ?> > Arábica
                                </label>
                            </div>
                        </div>

                        <div class="form-group" style="">
                            <div class="checkbox pull-left">
                                <label style="">
                                    <input type="radio" value="conilon"  name="tipo" <?php if ($dataGetBusca['tipo'] == "conilon") echo " checked"; ?>> Conilon
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="bebida" style="width: 250px"  placeholder="Bebida" value="<?= $dataGetBusca['bebida'] ?>">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="regiao">
                                <?php
                                if (is_array($regioes)) {
                                    foreach ($regioes as $regiao) {
                                        ?>
                                        <option value="<?= $regiao->descricao ?>" <?php echo $dataGetBusca['regiao'] == $regiao->descricao ? ' selected' : ''; ?>><?= $regiao->descricao ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  Pesquisar
                        </button>
                    </form>
                </div>
            </ol>

            <!--            <div  style="padding: 5px;">
                            <a  href="fornecedor_editar.php" role="button" class="btn btn-primary"> <span class="glyphicon glyphicon-plus-sign"></span>
                                <b>Novo Fornecedor</b>
                            </a>
                        </div>-->
            <div class="well" style="background-color: #FFF">
                <table class="table table-hover table-striped" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Lote</th>
                            <th>Proprietário</th>
                            <th>Região</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        if ($dados) {
                            foreach ($dados as $dado) {
//                                if ($dado['vender']) {
//                                    $action = 'not_vendedor';
//                                    $title = 'retirar vendedor';
//                                    $btnStatus = 'danger AjaxConfirm';
//                                } else {
//                                    $action = 'vendedor';
//                                    $title = 'ativar vendedor';
//                                    $btnStatus = 'success AjaxConfirm';
//                                }
                                ?>
                                <tr <?php echo (strtotime($dado['data_expiracao']) < strtotime(date('d-m-Y'))) ? 'class="danger"' : '' ?> >
                                    <td class="" width='7px'> 
                                        <input name="selecao" value="<?php echo $dado['amostra_id']; ?>" type="checkbox">
                                        <input name="page" type="hidden"  value="<?= $dataGet['page']; ?>">
                                    </td>
                                    <td style="width:50px;"><?= $dado['n_lote']; ?></td>
                                    <?php if (empty($dado['nome'])) { ?>
                                        <td style="width:50px;"><?= 'Administrador' ?></td>
                                    <?php } else { ?>
                                        <td style="width:50px;"><?= $dado['nome'] ?></td>
                                    <?php } ?>
                                    <td style="width:50px;"><span class="label label-default"><?= $dado['regiao']; ?></span></td>
                                    <?php if (strtotime($dado['data_expiracao']) < strtotime(date('d-m-Y'))) { ?>
                                        <td style="width:50px;"><span class="label label-danger"><?= 'expirada' ?></span></td>
                                    <?php } ?>
                                    <?php if ($dado['venda_id']) { ?>
                                        <td style="width:50px;"><span class="label label-success"><?= 'vendida' ?></span></td>
                                    <?php } ?>
                                    <td style="width:70px;" class="text-right">

                                        <a class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar" 
                                           href="amostra_editar?amostra_id=<?= $dado['amostra_id']; ?>&page=<?= $dataGet['page']; ?>">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        </a>
                                        <a class="btn btn-default btn-xs" data-toggle="tooltip" title="Imagens" 
                                           href="amostra_imagens.php?amostra_id=<?= $dado['amostra_id']; ?>">
                                            <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                                        </a>
                                        <?php if ($dado['oferta_id'] && empty($dado['venda_id'])) { ?>
                                            <a class="btn btn-warning btn-xs" data-toggle="tooltip" title="Ofertas" 
                                               href="ofertas.php?amostra_id=<?= $dado['amostra_id']; ?>">
                                                <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                                            </a>
                                        <?php } ?>


                                        <a class="btn btn-danger btn-xs AjaxConfirm" data-toggle="tooltip" title="Remover" 
                                           href="clientes?action=excluir&amostra_id=<?= $dado['amostra_id']; ?>&page=<?= $dataGet['page']; ?>">
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                                $cont++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center" id="paginador_clientes">
                <?php
                echo $paginador->getPagi();
                ?>
            </div>
        </div>
        <div id="footer" class="navbar-default">
            <div class="container">
            </div>
        </div>
        <script src="../assets/js/gerenciador.min_dev.js"></script>
        <script src="assets/js/amostras.js"></script>
    </body>
</html>
