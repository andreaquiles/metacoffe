<?php
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();
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
        <script src="../assets/js/jquery.forms/jquery.forms.js"></script>
        <script src="../assets/bootstrap/js/bootbox.min.js"></script>



<!--        <script src="includes/js/produtos_editar.min.js"></script>-->
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
            <ol class="breadcrumb">
                <li><a href="index">Home</a></li>
            </ol>
            <div class="well" style="text-align: center">
                <h1><span class="label label-default" >Bem vindo ao  
                        <?= TITLE ?> !!!</span></h1>
            </div>
        </div>

        <div id="footer" class="navbar-default">
          
        </div>

    </body>
</html>
