<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'amostra_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'amostra_imagem_id' => array(
        'filter' => FILTER_VALIDATE_INT
    )
    ,
    'foto' => array(
        'filter' => FILTER_SANITIZE_STRING
    )
);

$data_org = filter_input_array(INPUT_POST);
$dataGet = filter_input_array(INPUT_GET, $filterGET);

if (isset($_FILES["myfile"]["name"])) {
    $response['error'][] = "Erro: carregue somente arquivos do Excell excell "
            . "<b>{$_FILES["myfile"]["type"]}";
}

try {

    if ($dataGet['action'] == 'excluir' && $dataGet['foto']) {
        if ($dataGet['amostra_imagem_id']) {
            amostrasDAO::deletarImagens($dataGet['amostra_imagem_id']);
                if (file_exists('../upload/' . $dataGet['foto'])) {
                unlink('../upload/' . $dataGet['foto']);
            }
            $response['success'][] = 'Registro excluído com sucesso!';
            $response['link'] = $_SERVER['PHP_SELF'];
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
        <link href="assets/css/imagens.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.forms/jquery.forms.js"></script>
        <script src="assets/bootstrap/js/bootbox.min.js"></script>
        <script src="assets/js/imagelightbox.min.js"></script>
        <script>
            $(function ()
            {
                $('a.lightbox').imageLightbox();
            });
        </script>
    </head>
    <body>
        <?php include 'includes/header.php'; ?>
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li><a href="index">Home</a></li>
                <li><a href="amostras"><?= AMOSTRAS ?> </a></li>
                <li class="active"><?= AMOSTRAS_IMAGENS ?> </li>
            </ol>
            <ol class="breadcrumb">
                <li><div class="">
                        <span class="file-input btn btn-primary btn-file btn-sm" id="btnProdutos">
                            <span class="glyphicon glyphicon-import"></span> <b>Carregar imagens</b> 
                            <input type="file" name="myfile" multiple="">
                        </span>
                    </div>
                </li>
            </ol>
            <div class="well" style="">
                <div class="row">
                    <?php
                    $images = amostrasDAO::getListaImagens();
                    foreach ($images as $img) {
                        echo "<div class=\"photo\">";
                        echo "<img src=\"../upload/{$img['foto']}\"  alt=\"\" height=\"100\" width=\"150\"><br>\n";
                        echo "<a  class=\"lightbox\" href=\"../upload/{$img['foto']}\">", basename('../upload/' . $img['foto']), "</a><br>\n";
                        echo '<br>' . $img['size'] . '<br>';
                        echo $img['mimetype'];
                        echo '<a class="btn btn-danger btn-xs AjaxConfirm" style="float:right" data-toggle="tooltip" title="Excluir" 
                         href="' . $_SERVER['SELF'] . '?action=excluir&amostra_imagem_id=' . $img['amostra_imagem_id'] . '&foto=' . $img['foto'] . '">
                         <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                       </a>';
                        echo "</div>\n";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="footer" class="navbar-default">
            <div class="container">
            </div>
        </div>
        <script src="assets/js/gerenciador.min.js"></script>
    </body>
</html>