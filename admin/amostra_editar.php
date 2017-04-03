<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();


$filterPost = array(
    'n_lote' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'qtde_sacas' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'bebida' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'aspecto' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'quebra_f13_cata' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'defeitos' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'regiao' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'safra' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'porc_umidade' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'impurezas' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'gpi' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'aproveitamento' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'f10' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'pva' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'peneiras' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    '17_acima' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    '13_abaixo' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    '14_15_16' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
     'tipo' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'observacao' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'amostra_id' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);


$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'amostra_id' => array(
        'filter' => FILTER_VALIDATE_INT
    )
    ,
    'pgname' => array(
        'filter' => FILTER_SANITIZE_STRING
    )
);

$data_org = filter_input_array(INPUT_POST);
$data = filter_input_array(INPUT_POST, $filterPost);
$dataGet = filter_input_array(INPUT_GET, $filterGET);


if (isset($_FILES["myfile"]["name"])) {
    $response['error'][] = "Erro: carregue somente arquivos do Excell excell "
            . "<b>{$_FILES["myfile"]["type"]}";
}

//
try {
    $regioes = regiaoDAO::listaRegioes();

    if ($data) {
        $response = array();
        if (empty($data['n_lote'])) {
            $response['error'][] = 'Preencher Lote!';
        } else if ($data['qtde_sacas'] == NULL) {
            $response['error'][] = 'Preencher Quantidade de sacas!';
        } else if ($data['bebida'] == NULL) {
            $response['error'][] = 'Preencher Bebida!';
        } else if (empty($data['aspecto'])) {
            $response['error'][] = 'Preencher aspecto!';
        } else if ($data['quebra_f13_cata'] == NULL) {
            $response['error'][] = 'Preencher Quebra !';
        } else if ($data['porc_umidade'] == NULL) {
            $response['error'][] = 'Preencher umidade!';
        } else if ($data['regiao'] == NULL) {
            $response['error'][] = 'Preencher Região!';
        } else if ($data['safra'] == NULL) {
            $response['error'][] = 'Preencher safra!';
        } else if ($data['defeitos'] == NULL) {
            $response['error'][] = 'Preencher Defeitos!';
        } else if ($data['impurezas'] == NULL) {
            $response['error'][] = 'Preencher Impurezas!';
        } else if ($data['gpi'] == NULL) {
            $response['error'][] = 'Preencher G.P.I!';
        } else if ($data['aproveitamento'] == NULL) {
            $response['error'][] = 'Preencher Aproveitamento!';
        } else if ($data['f10'] == NULL) {
            $response['error'][] = 'Preencher F.10!';
        } else if ($data['pva'] == NULL) {
            $response['error'][] = 'Preencher P.V.A';
        } else if ($data['peneiras'] == NULL) {
            $response['error'][] = 'Preencher Peneiras!';
        } else if ($data['17_acima'] == NULL) {
            $response['error'][] = 'Preencher 17 Acima!';
        } else if ($data['13_abaixo'] == NULL) {
            $response['error'][] = 'Preencher 13 Abaixo!';
        } else if ($data['14_15_16'] == NULL) {
            $response['error'][] = 'Preencher 14/15/16!';
        } else {
            if (!$dataGet['page']) {
                $page = 1;
            } else {
                $page = $data['page'];
            }
            unset($data['page']);
//            $data['aproveitamento'] = FUNCOES::formatoDecimal( $data['aproveitamento']);


            if (empty($response['error'])) {
                if ($data['amostra_id']) {
                    /**
                     * (((((((((((((((((( atualizar amostra ))))))))))))))))))))))))))
                     */
                    $amostra_id = ($data['amostra_id']);
                    unset($data['amostra_id']);
                    amostrasBO::salvar($data, 'amostras', $amostra_id);
                    $response['success'][] = 'Amostra atualizada com sucesso!!';
                } else {
                    /**
                     * (((((((((((((((((( inserir usuario  )))))))))))))))))))))))
                     */
                    unset($data['amostra_id']);
                    $data['usuario_id'] = $_SESSION['admin'];
                    $pessoa_id = amostrasBO::salvar($data, 'amostras');
                    $response['success'][] = 'Amostra inserida com sucesso!!';
                }
                $response['link'] = 'javascript:history.go(-1)';
            }
        }
    }
    /**
     * Editar cliente
     */
    if ($dataGet['amostra_id']) {
        try {
            $data = amostrasDAO::getAmostra($dataGet['amostra_id']);
        } catch (Exception $err) {
            $response['error'][] = $err->getMessage();
        }
    }
} catch (Exception $ex) {
    $response['error'][] = $ex->getMessage();
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
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.forms/jquery.forms.js"></script>
        <script src="assets/bootstrap/js/bootbox.min.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="assets/js/typeahead.js"></script>
        <script src="assets/js/tipo_pessoa.min.js"></script>
        <script src="assets/js/jquery.maskMoney.min.js"></script>
        <style>

            #footer {
                background-color: #F5F5F5;
                bottom: 0;
                height: 50px;
                position: relative;
                width: 100%;
            }

            input[readonly] {
                background-color: white !important;
                cursor: text !important;
            }
        </style>
    </head>
    <body>
        <div id="alerta">
            <?php
            if (isset($response)) {
                if (!empty($response['error'])) {
                    ?>
                    <div class="alert alert-danger fade in" role="alert">
                        <?php echo implode('<br>', $response['error']); ?>
                    </div>
                    <?php
                }
                if (!empty($response['success'])) {
                    ?>
                    <div class="alert alert-success fade in" role="alert">
                        <?php echo implode('<br>', $response['success']); ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>


        <?php include 'includes/header.php'; ?>

        <div class="container-fluid">
            <ol class="breadcrumb">
                <li><a href="index">Home</a></li>
                <li><a href="amostras"><?= AMOSTRAS ?> </a></li>
                <li class="active"><?= 'Edição de amostra' ?> </li>
            </ol>
            <!--            <div class="form-group col-sm-12">
                            <h2>Cadastro de amostra</h2>
                        </div>-->
            <div class="well">

                <form role="form" method="post">
                    <div class="row">

                        <div class="col-sm-12">
                            <input type="hidden"  name="amostra_id" value="<?php echo $dataGet['amostra_id']; ?>">
                            <div class="row">

                                <div class="form-group col-sm-2">
                                    <label for="razao_social">Nº Lote</label>
                                    <input type="text" maxlength="15"  class="form-control" name="n_lote" placeholder="" maxlength="15" value="<?php echo $data['n_lote']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="">Qtde. de sacas</label>
                                    <input type="text" maxlength="15" class="form-control" name="qtde_sacas" placeholder="" value="<?php echo $data['qtde_sacas']; ?>" >
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="cnpj">Bebida</label>
                                    <input type="text" maxlength="50" class="form-control" name="bebida" placeholder="" value="<?php echo $data['bebida']; ?>" >
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="cnpj">Aspecto</label>
                                    <input type="text" maxlength="50" class="form-control" name="aspecto" placeholder="" value="<?php echo $data['bebida']; ?>" >
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="razao_social">Quebra (F13+CATA)</label>
                                    <input type="text" class="form-control" maxlength="15" name="quebra_f13_cata" placeholder="" value="<?php echo $data['quebra_f13_cata']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="">Umidade(%)</label>
                                    <input type="text" maxlength="5" class="form-control"  name="porc_umidade" placeholder="" value="<?php echo $data['porc_umidade']; ?>" >
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="data_fundacao">Região</label>
                                    <select class="form-control" name="regiao">
                                        <option value="" selected="">selecione</option>
                                        <?php
                                        if (is_array($regioes)) {
                                            foreach ($regioes as $regiao) {
                                                ?>
                                                <option value="<?= $regiao->descricao ?>" <?php echo $data['regiao'] == $regiao->descricao ? ' selected' : ''; ?>><?= $regiao->descricao ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!--                                <div class="form-group col-sm-4">
                                                                    <label for="cnpj">Região</label>
                                                                    <input type="text" class="form-control" name="regiao" placeholder="" value="<?php echo $data['regiao']; ?>" >
                                                                </div>-->
                                <div class="form-group col-sm-3">
                                    <label for="cnpj">Safra</label>
                                    <input type="text" class="form-control" name="safra" placeholder="" value="<?php echo $data['safra']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="observacao">Defeitos</label>
                                    <input type="text" maxlength="15" class="form-control" name="defeitos" placeholder="" value="<?php echo $data['defeitos']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="observacao">Impurezas(%)</label>
                                    <input type="text" maxlength="15" class="form-control" name="impurezas" placeholder="" value="<?php echo $data['impurezas']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="razao_social">G.P.I(%)</label>
                                    <input type="text" maxlength="15" class="form-control" name="gpi" placeholder="" value="<?php echo $data['gpi']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="">Aproveitamento(%)</label>
                                    <input type="text" maxlength="5" class="form-control percentual" name="aproveitamento" placeholder="" value="<?php echo $data['aproveitamento']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="cnpj">F.10(%)</label>
                                    <input type="text" maxlength="5" class="form-control" name="f10" placeholder="" value="<?php echo $data['f10']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="cnpj">P.V.A(%)</label>
                                    <input type="text" maxlength="5" class="form-control" name="pva" placeholder="" value="<?php echo $data['pva']; ?>" >
                                </div>

                                <div class="form-group col-sm-2">
                                    <label for="razao_social">Peneiras(%)</label>
                                    <input type="text" maxlength="5" class="form-control" name="peneiras" placeholder="" value="<?php echo $data['peneiras']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="">17 acima(%)</label> <span class="glyphicon glyphicon-circle-arrow-up"></span>
                                    <input type="text" maxlength="5" class="form-control" name="17_acima" placeholder="" value="<?php echo $data['17_acima']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="cnpj">13 abaixo(%)</label> <span class="glyphicon glyphicon-circle-arrow-down"></span>
                                    <input type="text" maxlength="5" class="form-control" name="13_abaixo" placeholder="" value="<?php echo $data['13_abaixo']; ?>" >
                                </div>
                                <div class="form-group col-sm-2">
                                    <label for="cnpj">14/15/16(%)</label>
                                    <input type="text" maxlength="5" class="form-control" name="14_15_16" placeholder="" value="<?php echo $data['14_15_16']; ?>" >
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="radio pull-left" >
                                        <label>
                                            <input type="radio" value="arabica"  name="tipo" <?= $data['tipo']=='arabica' ? " checked" : "" ?>><span style="font-size: 14px;" class="label label-default">Arábica</span>
                                        </label>
                                        <label style="margin-left:1.2em;">
                                            <input type="radio" value="conilon"  name="tipo" <?= $data['tipo']=='conilon' ? " checked" : "" ?>><span style="font-size: 14px;" class="label label-default">Conilon</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                <?php
                                /*
                                 * Observações
                                 */
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#observacao_cliente"><span class="glyphicon glyphicon-circle-arrow-down"></span> Informar Observações</a> <small>(Opcional)</small>
                                        </h4>
                                    </div>

                                    <div id="observacao_cliente" class="collapse <?php echo (!empty($data['observacao'])) ? 'in' : ''; ?>">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="observacao">Observações</label>
                                                <textarea class="form-control" name="observacao" rows="6"><?php echo $data['observacao']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="text-right">




                            <a href="<?php echo ''; ?>" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Salvar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="footer" class="navbar-default">
            <div class="container">
            </div>
        </div>

        <script src="assets/js/gerenciador.min.js"></script>
        <script>


        </script>

    </body>
</html>
