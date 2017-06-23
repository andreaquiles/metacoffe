<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir|not_vendedor|vendedor|bloquear)$/")
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
    'nome' => array(
        'filter' => FILTER_DEFAULT,
    ),
    'email' => array(
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
        'flags' => FILTER_REQUIRE_ARRAY,
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT,
    )
);

$inputPOST = filter_input_array(INPUT_POST, $argsPost);
$dataGet = filter_input_array(INPUT_GET, $filterGET);
$dataGetBusca = filter_input_array(INPUT_GET, $filterGETBusca);
$arrayBusca = array('busca' => $dataGet['busca'], 'nome' => $dataGet['nome'], 'email' => $dataGet['email']);


try {
    if (!$dataGet['page']) {
        $dataGet['page'] = 1;
    }

    if (($dataGet['busca'])) {
        $count = pessoasBO::getPesquisaPessoasCount($dataGet);
        $paginador = new paginador($dataGet['page'], $count, 20, '', $arrayBusca);
        $dados = pessoasBO::getPesquisaPessoas($dataGet, $paginador->getPage());
    } else {
        $count = pessoasBO::getListaPessoasCount();
        $paginador = new paginador($dataGet['page'], $count, 20, '');
        $dados = pessoasBO::getListaPessoas($paginador->getPage());
    }
    /**
     * action via post EXCLUIR
     */
    if (isset($dataGet['action'])) {
        if ($dataGet['action'] == 'bloquear') {
            if (isset($dataGet['pessoa_id'])) {
                try {
                    $data['bloqueado'] = 1;
                    pessoasBO::salvar($data, 'pessoas', $dataGet['pessoa_id']);
                    $response['success'][] = 'Cliente Removido com sucesso!';
                    $response['link'] = $_SERVER['PHP_SELF'] . '?' . http_build_query($dataGetBusca);
                } catch (Exception $err) {
                    $response['error'][] = $err->getMessage();
                }
            }
        }
    }
    
    /**
     * action via post EXCLUIR
     */
//    if ($inputPOST['action'] == 'excluir') {
//        if (isset($inputPOST['ids'])) {
//            $params = is_array($inputGET) ? "?&" . http_build_query($inputGET) : '';
//            try {
//                pessoasDAO::remover($inputPOST['ids'] , $_SESSION['admin']);
//                $response['success'][] = 'Registros excluídos com sucesso!';
//                $response['link'] = $_SERVER['PHP_SELF']. $params;
//            } catch (Exception $err) {
//                $response['error'][] = $err->getMessage();
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
                <li class="active"><?= PESSOAS ?> </li>
            </ol>
            <ol class="breadcrumb" >
                <a  href="pessoa_editar.php" role="button" class="btn btn-primary"> <span class="glyphicon glyphicon-plus-sign"></span>
                    <b>Novo Cliente</b>
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
                        <div class="form-group">
                            <select class="form-control" name="busca">
                                <option value="nome"  <?php if ($dataGet['busca'] == "nome") echo "selected"; ?> >Nome</option>
                                <option value="email" <?php if ($dataGet['busca'] == "email") echo "selected"; ?> >Email</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="nome" style="width: 400px"  placeholder="" value="<?= $dataGet['nome'] ?>">
                            <input type="text" class="form-control" name="email" style="width: 400px"  placeholder="" value="<?= $dataGet['email'] ?>">
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
                            <th>Nome</th>
                            <th>Email</th>
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
                                <tr <?php echo $dado['bloqueado'] ? 'class="danger"' : '' ?> >
                                    <td class="" width='7px'> 
                                        <input name="selecao" value="<?php echo $dado['pessoa_id']; ?>" type="checkbox">
                                        <input name="page" type="hidden"  value="<?= $dataGet['page']; ?>">
                                    </td>
                                    <td style="width:150px;"><?= $dado['nome']; ?></td>
                                    <td style="width:100px;"><span class="label label-default"><?= $dado['email']; ?></span></td>
                                    <td style="width:65px;" class="text-right">

                                        <a class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar" 
                                           href="pessoa_editar?pessoa_id=<?= $dado['pessoa_id']; ?>&page=<?= $dataGet['page']; ?>">
                                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        </a>
        <!--                                        <a class="btn btn-default btn-xs alert-<?= $btnStatus ?>" data-toggle="tooltip" title="<?= $title; ?>" 
                                           href="<?php $_SERVER['PHP_SELF']; ?>?pessoa_id=<?= $dado['pessoa_id']; ?>&action=<?= $action; ?>&page=<?= $dataGet['page'] . '&' . http_build_query($arrayBusca) ?>">
                                            <span class="glyphicon glyphicon glyphicon-user" aria-hidden="true"></span>
                                        </a>-->
                                        <?php if (empty($dado['bloqueado'])) { ?>
                                            <a class="btn btn-danger btn-xs AjaxConfirm" data-toggle="tooltip" title="Remover" 
                                               href="pessoas.php?action=bloquear&pessoa_id=<?= $dado['pessoa_id']; ?>&page=<?= $dataGet['page']; ?>">
                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                            </a>
                                        <?php } ?>
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
        <script src="../assets/js/gerenciador.min.js"></script>
        <script>
            $('input[name=email]').hide();
            $('select[name=busca]').change(function () {
                if (this.value === 'email') {
                    $('input[name=email]').show();
                    $('input[name=nome]').hide();
                    $('input[name=nome]').val("");
                } else if (this.value === 'nome') {
                    $('input[name=nome]').show();
                    $('input[name=email]').hide();
                    $('input[name=email]').val("");
                } else {
                    $('input[name=nome]').hide();
                    $('input[name=nome]').val("");
                    $('input[name=email]').hide();
                    $('input[name=email]').val("");


                }
            });
        </script>
        <script src="assets/js/pessoas.js"></script>
    </body>
</html>
