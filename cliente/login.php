<?php
require_once dirname(__DIR__).DIRECTORY_SEPARATOR."autoload.php";
define("DOWNLOAD_DIR", "./includes/files/");


$filter = array(
    'email' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,255}$/")
    ),
    'senha' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,255}$/")
    )
);
$dataPost = filter_input_array(INPUT_POST, $filter);
if ($dataPost){
    try {
        pessoasBO::getLogin($dataPost);
        $response['success'][] = "aguarde...";
        $response['link'][] = "./";
    } catch (Exception $e) {
        $response['error'][] = $e->getMessage();
    }
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

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="../assets/js/jquery.forms/jquery.forms.js"></script>
        <script src="../assets/js/manager.js"></script>
        <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    </head>
    <body>
        <div class="modal-body">
            <div class="row" style="margin-top:2em;">
                <div class="col-sm-4 col-sm-offset-4">
                    
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
                   
                    <form action="" role="form">
                        <div style="text-align: center"></div>
                        <p><input type="email" autofocus="" required="" placeholder="email" class="form-control input-lg" name="email"></p>
                        <p><input type="password" required="" placeholder="senha" class="form-control input-lg" name="senha"></p>
                        <p><button type="submit" class="btn btn-lg btn-success btn-block">Entrar</button></p>
                        <p ><a class="btn btn-lg btn-link btn-block"  href="">Esqueceu sua senha?</a></p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
