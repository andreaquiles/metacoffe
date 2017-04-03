<?php

require_once '../../../autoload.php';
try {
    $desired_width = 125;
    foreach ($_FILES as $file) {
        $imgData = base64_encode(file_get_contents($file['tmp_name']));
        if ($file["size"] <= 2048000) { // 2MB
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
                $imagem['amostra_id'] = $_POST['amostra_id'];
                $imagem['usuario_id'] = $_SESSION['admin'];
                amostrasBO::salvar($imagem, 'amostras_imagens');
                echo '{"status":"1","link":"amostra_imagens.php"}';
            }
        } else {
            echo '{"status":"0","msg":"Limite da imagem é de {2 MB}"}';
        }
    }
} catch (Exception $err) {
    echo '{"status":"0","msg":"' . $err->getMessage() . '"}';
}
?>