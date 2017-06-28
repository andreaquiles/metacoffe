<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
$i = 1;
try {
    $formularios = filter_input(INPUT_POST, 'formulario', FILTER_CALLBACK, array('options' => 'filter_var'));
    if (is_array($formularios)) {
        require_once ('../lib/fpdf/fpdf.php');
        $relatorio = "formulario";
        require_once('../sealed/controler/pdf_1.php');
        if (empty($response['error'])) {
            $response['success'][] = 'Fomulário gerado com sucesso!';
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
        <title><?= 'Formulário PDF'; ?></title>
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
        <script src="assets/js/bootstrap-datepicker.js"></script>
        <script src="assets/js/bootstrap-datepicker.pt-BR.js"></script>
        <link href="assets/css/datepicker3.css" rel="stylesheet" type="text/css"/>
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
        <?php include 'includes/header_1.php'; ?>

        <div class="container-fluid">
            <ol class="breadcrumb">
                <li><a href="#">Formulário</a></li>
            </ol>
            <!--            <div class="form-group col-sm-12">
                            <h2>Cadastro de amostra</h2>
                        </div>-->
            <div class="well">

                <form role="form" method="post" >
                    <div class="row" >
                        <div class="col-sm-12"  >
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="razao_social">Peça</label>
                                    <input type="text" maxlength="35"  class="form-control" name="formulario[0][peca]" placeholder="" maxlength="15" value="" >
                                </div>
                                <div class="form-group col-sm-1">
                                    <label for="">Unidade</label>
                                    <input type="text" maxlength="3" class="form-control" name="formulario[0][unidade]" placeholder="" value="" >
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="cnpj">Destinatário</label>
                                    <input type="text" maxlength="50" class="form-control" name="formulario[0][destinatario]" placeholder="" value="" >
                                </div>

                            </div>
                            <?php while ($i < 20) { ?>
                                <div class="row" >
                                    <div class="form-group col-sm-4">
                                        <input type="text" maxlength="35"  class="form-control" name="formulario[<?= $i ?>][peca]" placeholder="" maxlength="15" value="" >
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <input type="text" maxlength="3" class="form-control" name="formulario[<?= $i ?>][unidade]" placeholder="" value="" >
                                    </div>
                                    <div class="form-group col-sm-5">
                                        <input type="text" maxlength="50" class="form-control" name="formulario[<?= $i ?>][destinatario]" placeholder="" value="" >
                                    </div>
                                </div>
                                <?php
                                $i++;
                            }
                            ?>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-download" aria-hidden="true"></span> Gerar PDF</button>
                            <a href="<?php echo ''; ?>" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="footer" class="navbar-default">
            <div class="container">
            </div>
        </div>
        <script>
            jQuery(function (o) {
                $('form input').on('keypress', function (e) {
                    return e.which !== 13;
                });
                o('input[name^="formulario"][name$="[unidade]"]').on("keyup", function () {
                    var a = /[^0-9]/g;
                    o(this).val().match(a) && o(this).val(o(this).val().replace(a, ""))
                })
            });
        </script>
        <script src="assets/js/gerenciador.min.js"></script>
    </body>
</html>
