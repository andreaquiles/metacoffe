<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
pessoasBO::checkExpireLogin();
pessoasBO::checkLogin();

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|alterar)$/")
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

try {
    if ($dataGet['action'] == 'excluir' && $dataGet['foto']) {
        if ($dataGet['amostra_imagem_id']) {
            amostrasDAO::deletarImagens($dataGet['amostra_imagem_id']);
            if (file_exists('../upload/' . $dataGet['foto'])) {
                unlink('../upload/' . $dataGet['foto']);
            }
            $response['success'][] = 'Registro excluído com sucesso!';
            $response['link'] = $_SERVER['PHP_SELF'] . '?amostra_id=' . $dataGet['amostra_id'];
        }
    } else {
        if ($dataGet['action'] == 'alterar') {
            if ($dataGet['amostra_imagem_id']) {
                $data = array();
                $data['principal'] = 1;
                amostrasDAO::salvar($data, 'amostras_imagens', $dataGet['amostra_imagem_id']);
                amostrasDAO::updateImagens($dataGet['amostra_imagem_id']);
                $response['success'][] = 'Imagem alterada com sucesso!';
                $response['link'] = $_SERVER['PHP_SELF'] . '?amostra_id=' . $dataGet['amostra_id'];
            }
        }
    }
    /**
     * Editar cliente
     */
    if ($dataGet['amostra_id'] && empty($dataGet['action'])) {
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

        <link rel="stylesheet" type="text/css" href="picEdit/dist/css/picedit.css" />
        <link rel="stylesheet" type="text/css" href="picEdit/src/css/font.css" />
        <script src="assets/js/jquery.min.js"></script>

        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/imagens.css" rel="stylesheet">
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!--        <script src="assets/js/jquery.forms/jquery.forms.js"></script>-->
        <script src="assets/js/bootbox.min.js"></script>
        <script src="assets/js/imagelightbox.min.js"></script>
        <script>
            $(function ()
            {
                $('a.lightbox').imageLightbox();
            });
        </script>
    </head>
    <body>
        <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="LoginLabel" aria-hidden="true" >
            <div class="modal-dialog modal-lg">
                <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="modal-title">Imagem</h3>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="noAjax" action="picEdit/src/out.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="amostra_id" value="<?= $dataGet['amostra_id'] ?>">
                            <div style="margin:2% auto 0 auto; display: table;">
                                <div class="picedit_box">
                                    <!-- Placeholder for messaging -->
                                    <div class="picedit_message">
                                        <span class="picedit_control ico-picedit-close" data-action="hide_messagebox"></span>
                                        <div></div>
                                    </div>
                                    <!-- Picedit navigation -->
<!--                                    <div class="picedit_nav_box picedit_gray_gradient">
                                        <div class="picedit_pos_elements"></div>
                                        <div class="picedit_nav_elements">
                                             Picedit button element begin 
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-pencil" title="Pen Tool"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_3">
                                                        <label class="picedit_colors">
                                                            <span title="Black" class="picedit_control picedit_action picedit_black active" data-action="toggle_button" data-variable="pen_color" data-value="black"></span>
                                                            <span title="Red" class="picedit_control picedit_action picedit_red" data-action="toggle_button" data-variable="pen_color" data-value="red"></span>
                                                            <span title="Green" class="picedit_control picedit_action picedit_green" data-action="toggle_button" data-variable="pen_color" data-value="green"></span>
                                                        </label>
                                                        <label>
                                                            <span class="picedit_separator"></span>
                                                        </label>
                                                        <label class="picedit_sizes">
                                                            <span title="Large" class="picedit_control picedit_action picedit_large" data-action="toggle_button" data-variable="pen_size" data-value="16"></span>
                                                            <span title="Medium" class="picedit_control picedit_action picedit_medium" data-action="toggle_button" data-variable="pen_size" data-value="8"></span>
                                                            <span title="Small" class="picedit_control picedit_action picedit_small" data-action="toggle_button" data-variable="pen_size" data-value="3"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                             Picedit button element end 
                                             Picedit button element begin 
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-insertpicture" title="Crop" data-action="crop_open"></span>
                                            </div>
                                             Picedit button element end 
                                             Picedit button element begin 
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-redo" title="Rotate"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_1">
                                                        <label>
                                                            <span>90° CW</span>
                                                            <span class="picedit_control picedit_action ico-picedit-redo" data-action="rotate_cw"></span>
                                                        </label>
                                                        <label>
                                                            <span>90° CCW</span>
                                                            <span class="picedit_control picedit_action ico-picedit-undo" data-action="rotate_ccw"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                             Picedit button element end 
                                             Picedit button element begin 
                                            <div class="picedit_element">
                                                <span class="picedit_control picedit_action ico-picedit-arrow-maximise" title="Resize"></span>
                                                <div class="picedit_control_menu">
                                                    <div class="picedit_control_menu_container picedit_tooltip picedit_elm_2">
                                                        <label>
                                                            <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="resize_image"></span>
                                                            <span class="picedit_control picedit_action ico-picedit-close" data-action=""></span>
                                                        </label>
                                                        <label>
                                                            <span>Width (px)</span>
                                                            <input type="text" class="picedit_input" data-variable="resize_width" value="0">
                                                        </label>
                                                        <label class="picedit_nomargin">
                                                            <span class="picedit_control ico-picedit-link" data-action="toggle_button" data-variable="resize_proportions"></span>
                                                        </label>
                                                        <label>
                                                            <span>Height (px)</span>
                                                            <input type="text" class="picedit_input" data-variable="resize_height" value="0">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                             Picedit button element end 
                                        </div>
                                    </div>-->
                                    <!-- Picedit canvas element -->
                                    <div class="picedit_canvas_box" >
                                        <div class="picedit_painter">
                                            <canvas></canvas>
                                        </div>
                                        <div class="picedit_canvas">
                                            <canvas></canvas>
                                        </div>
                                        <div class="picedit_action_btns active">
                                            <div class="picedit_control ico-picedit-picture" style="" data-action="load_image"></div>
                                            <div class="picedit_control ico-picedit-camera" data-action="camera_open"></div>
                                            <div class="center">ou copie/cole a imagem aqui</div>
                                        </div>
                                    </div>
                                    <!-- Picedit Video Box -->
                                    <div class="picedit_video">
                                        <video autoplay></video>
                                        <div class="picedit_video_controls">
                                            <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="take_photo"></span>
                                            <span class="picedit_control picedit_action ico-picedit-close" data-action="camera_close"></span>
                                        </div>
                                    </div>
                                    <!-- Picedit draggable and resizeable div to outline cropping boundaries -->
                                    <div class="picedit_drag_resize">
                                        <div class="picedit_drag_resize_canvas"></div>
                                        <div class="picedit_drag_resize_box">
                                            <div class="picedit_drag_resize_box_corner_wrap">
                                                <div class="picedit_drag_resize_box_corner"></div>
                                            </div>
                                            <div class="picedit_drag_resize_box_elements">
                                                <span class="picedit_control picedit_action ico-picedit-checkmark" data-action="crop_image"></span>
                                                <span class="picedit_control picedit_action ico-picedit-close" data-action="crop_close"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="text-left" >
                                    <div class="form-group col-sm-2" style="padding-left: 0px;width:120px">
                                        <label>
                                            <input type="checkbox" value="1"  name="principal"> <span style="font-size: 12px;" class="label label-default"> Principal</span>
                                        </label>
<!--                                        <input type="text" name="ordem" maxlength="2" class="form-control" value="">-->
                                    </div>
                                </div>
                                <!-- end_picedit_box -->
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success">Salvar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <?php include 'includes/header.php'; ?>
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li><a href="index">Home</a></li>
                <li><a href="amostras"><?= AMOSTRAS ?> </a></li>
                <li class="active"><?= AMOSTRAS_IMAGENS ?> </li>
            </ol>
            <ol class="breadcrumb">
                <li><div class="">
<!--                        <span class="label label-primary">Lote: <b><?= $data['n_lote'] ?></b></span>-->
                        <span class="file-input btn btn-primary btn-file btn-sm" href="#myModal" data-toggle="modal" id="btnProdutos">
                            <span class="glyphicon glyphicon-import" ></span> <b>Carregar imagem</b> 
                        </span>

                    </div>
                </li>
            </ol>
            <div class="well" style="">
                <div class="row">
                    <?php
                    $images = amostrasDAO::getListaImagens($dataGet['amostra_id']);
                    foreach ($images as $img) {
                        //$image_info = getimagesize('../upload/thumb/'.$img['foto']);
                        //$image_height = $image_info[1];
                        echo "<div class=\"photo\">";
                        echo "<img src=\"../upload/{$img['foto']}\"  alt=\"\" height=\"100\" width=\"125\"><br>\n";
                        echo "<a  class=\"lightbox\" href=\"../upload/{$img['foto']}\">", basename('../upload/' . $img['foto']), "</a>\n";
                        echo '<br>' . $img['size'] . '<br>';
                        echo $img['mimetype'] . "<br>";
                        echo '<a class="btn btn-danger btn-xs AjaxConfirm" style="float:right; " data-toggle="tooltip" title="Excluir" 
                         href="' . $_SERVER['SELF'] . '?action=excluir&amostra_imagem_id=' . $img['amostra_imagem_id']
                        . '&foto=' . $img['foto'] . '&amostra_id=' . $dataGet['amostra_id'] . '">
                         <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 
                       </a>';
                        if (empty($img['principal'])) {
                            echo '<a class="btn btn-default btn-xs" style="float:right;margin-right:3px" data-toggle="tooltip" title="Tornar principal" 
                         href="' . $_SERVER['SELF'] . '?action=alterar&amostra_imagem_id=' . $img['amostra_imagem_id']
                            . '&foto=' . $img['foto'] . '&amostra_id=' . $dataGet['amostra_id'] . '">
                         <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                       </a>';
                        } else {
                            echo '<a class="btn btn-warning btn-xs" style="float:right;margin-right:3px" data-toggle="tooltip" title="Principal" href="#">
                                 <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                 </a>';
                        }
                        echo "</div>\n";
                    }
                    ?>
                </div>
            </div>
        </div>
        <div id="footer" class="navbar-default">

        </div>
        <script src="assets/js/gerenciador.min_dev.js"></script>
        <script type="text/javascript" src="picEdit/src/js/picedit.js"></script>
        <script type="text/javascript">
            NumeroInteiros('ordem');
            $(function () {
                $('.picedit_box').picEdit({
                    imageUpdated: function (img) {
                    },
                    formSubmitted: function () {
                    },
                    redirectUrl: false,
                    defaultImage: false
                });
            });
        </script>

    </body>
</html>