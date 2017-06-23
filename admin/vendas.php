<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir|not_vendedor|vendedor)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);


$filterGETBusca = array(
    'page' => array(
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
    ),
    'amostra_id' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);

$filterPost = array(
//    'oferta_id' => array(
//        'filter' => FILTER_VALIDATE_INT
//    ),
    'pessoa_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'amostra_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'valor' => array(
        'filter' => FILTER_SANITIZE_STRING
    )
);

$inputPOST = filter_input_array(INPUT_POST, $filterPost);
$dataGet = filter_input_array(INPUT_GET, $filterGET);
$dataGetBusca = filter_input_array(INPUT_GET, $filterGETBusca);
//$arrayBusca = array('busca' => $dataGet['busca'], 'nome' => $dataGet['nome'], 'email' => $dataGet['email']);

try {
    if (!$dataGet['page']) {
        $dataGet['page'] = 1;
    }

    if ($inputPOST) {
//        $inputPOST['usuario_id'] = $_SESSION['admin'];
//        vendasDAO::salvar($inputPOST, 'vendas');
//        $data = array();
//        $data['situacao'] = 'vendida';
//        statusDAO::salvar($data, 'status',  $inputPOST['amostra_id']);
//        $response['success'][] = 'Oferta confirmada com sucesso!!';
//        $response['link'] = $_SERVER['PHP_SELF'];
    } else {
        if (empty($dataGetBusca['amostra_id'])) {
            $count = vendasDAO::getListaVendasCount();
            $paginador = new paginador($dataGet['page'], $count, 20, '');
            $dados = vendasDAO::getListaVendas($paginador->getPage());
        } else {
//            $count = ofertasDAO::getListaOfertasCountAmostraID($dataGetBusca['amostra_id']);
//            $paginador = new paginador($dataGet['page'], $count, 20, '');
//            $dados = ofertasDAO::getListaOfertasAmostra($paginador->getPage(), $dataGetBusca['amostra_id']);
        }
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
        <div class="modal fade bd-example-modal-lg" id="modalsession" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title" id="texto">Oferta</h3>
                    </div>
                    <form name="formoferta" class="form-horizontal">
                        <input type="hidden" name="pessoa_id" class="pessoa_id">
                        <input type="hidden" name="amostra_id" class="amostra_id">
                        <input type="hidden" name="valor" class="valor">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Comprador:</label>
                                <div class="col-sm-10">
                                    <p id="oferta_comprador" class="form-control-static">email@example.com</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Oferta:</label>
                                <div class="col-sm-10">
                                    <p id="oferta_oferta" style="" class="form-control-static">R$ 1.000.000,00</p>
                                </div>
                            </div>
                            <div class="form-group" id="oferta_observacao_div" style="display: none">
                                <label class="col-sm-2 control-label">Observação:</label>
                                <div class="col-sm-10">
                                    <p id="oferta_observacao" style="" class="form-control-static">R$ 1.000.000,00</p>
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox"> Comprar
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                            <div class="padded-box">
                                <div id="archive">
                                    <ul class="list-group">
                                        <div id="conversacao"></div>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer" id="buttons-modal">
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                <li class="active"><?= VENDAS ?> </li>
            </ol>
            <ol class="breadcrumb">
<!--                <a  href="pessoa_editar.php" role="button" class="btn btn-primary"> <span class="glyphicon glyphicon-plus-sign"></span>
                    <b>Novo Cliente</b>
                </a>-->
<!--                <a class="btn btn-default excluir" >
                    <span class="glyphicon glyphicon-trash excluir" aria-hidden="true"></span> Excluir
                </a>-->
                <a class="btn btn-danger" data-toggle="tooltip" title="PDF" 
                   href="index.php?action=usuarios&<?= http_build_query($dataGet) ?>" target="_blank">
                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download
                </a>
                <div class="form-group pull-right">
                    <!--                    <form class="form-inline pull-right noAjax" method="get">
                                            <div class="form-group">
                                                <select class="form-control" name="busca">
                                                </select>
                                            </div>
                                            <div class="form-group">
                                            </div>
                                            <button type="submit" class="btn btn-success">
                                                <span class="glyphicon glyphicon-search" aria-hidden="true"></span>  Pesquisar
                                            </button>
                                        </form>-->
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
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Comprador</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cont = 1;
                        if ($dados) {
                            foreach ($dados as $dado) {
                                if ($dado['nome']) {
                                    $nome = $dado['nome'];
                                } else {
                                    $nome = $dado['razao_social'];
                                }
                                ?>
                                <tr <?php echo $dado['bloqueado'] ? 'class="danger"' : '' ?> >
                                    <td class="" width='7px'> 
                                        <input name="selecao" value="<?php echo $dado['oferta_id']; ?>" type="checkbox">
                                        <input name="page" type="hidden"  value="<?= $dataGet['page']; ?>">
                                    </td>
                                    <td style="width:30px;"><?= $dado['n_lote']; ?></td>
                                    <td style="width:30px;"><span class="label label-success"><?= $dado['situacao']; ?></span></td>
                                    <td style="width:50px;"><?= 'R$ ' . FUNCOES::formatoDecimalHTML($dado['valor']); ?></td>
                                    <td style="width:150px;"><?= $nome; ?></span></td>
                                    <td style="width:100px;"><?= ($dado['data']) ?></span></td>
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
        <script src="../assets/js/gerenciador.min.js"></script>
    </body>
</html>
