<?php

require_once '../../../autoload.php';
$filterPost = array(
    'amostra_id' => array(
         'filter' => FILTER_VALIDATE_INT
    ),
    'ordem' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
     'principal' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);
$dataPost = filter_input_array(INPUT_POST, $filterPost);

try {
    $desired_width = 125;
    foreach ($_FILES as $file) {
        $imgData = base64_encode(file_get_contents($file['tmp_name']));
        if ($file["size"] <= 3072000) { // 3MB
            list($width, $height) = getimagesize($file['tmp_name']);
            $mimitype = $file["type"];
            $size = '(' . $width . ' x ' . $height . ' pixels)';
            $extensao = FUNCOES::getExtension($file['name']);
            $name = '(' . $_SESSION['admin'] . ')' . time() . '.' . $extensao;
            $midia = '../../../upload/' . $name;

            if (move_uploaded_file($file['tmp_name'], $midia)) {
                //FUNCOES::make_thumb("../../../upload/$name", "../../../upload/thumb/$name", $desired_width);
                $imagem = array();
                $imagem['foto'] = $name;
                $imagem['mimetype'] = $mimitype;
                $imagem['size'] = $size;
                $imagem['amostra_id'] = $dataPost['amostra_id'];
                $imagem['ordem'] = $dataPost['ordem'];
                $imagem['principal'] = $dataPost['principal'];
                $imagem['pessoa_id'] = $_SESSION['pessoa_id'];
                $imagem['usuario_id'] = USUARIO_ID;
                $amostra_imagem_id = amostrasBO::salvar($imagem, 'amostras_imagens');
                if (!empty($dataPost['principal'])){
                    amostrasDAO::updateImagens($amostra_imagem_id);
                }
                echo '{"status":"1","link":"amostra_imagens?amostra_id='.$dataPost['amostra_id'].'"}';
            }
        } else {
            echo '{"status":"0","msg":"Limite da imagem é de {3 MB}"}';
        }
    }
} catch (Exception $err) {
    echo '{"status":"0","msg":"' . $err->getMessage() . '"}';
}
?>