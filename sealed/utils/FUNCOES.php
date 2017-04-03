<?php

class FUNCOES {

    public function __construct() {
        
    }

    public static function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    public static function getExtension($string) {
        $explode = explode(".", $string);
        $extensao = $explode[count($explode) - 1];
        return $extensao;
    }

    static function removerAcentosArquivos($str) {
        $str = preg_replace('/[áàãâä]/ui', 'a', $str);
        $str = preg_replace('/[éèêë]/ui', 'e', $str);
        $str = preg_replace('/[íìîï]/ui', 'i', $str);
        $str = preg_replace('/[óòõôö]/ui', 'o', $str);
        $str = preg_replace('/[úùûü]/ui', 'u', $str);
        $str = preg_replace('/[ç]/ui', 'c', $str);
        $str = preg_replace('/\s+/ui', '_', $str);
        return $str;
    }

    static function random_pass($numchars = 6, $specialchars = false, $extrashuffle = false, $Onlynumbers = false) {
        $numchars = intval($numchars);

        if ($Onlynumbers)
            $chars = array_merge(range(0, 9));
        else
            $chars = array_merge(range(0, 9), range('a', 'z'));

        if ($specialchars) {
            $chars = array_merge($chars, array('!', '$', '_', '-', '#', '@'));
        }
        shuffle($chars);
        $pass = '';

        for ($i = 1; $i <= $numchars; $i++) {
            $pass .= $chars[$i];
        }

        if ($extrashuffle) {
            return str_shuffle($pass);
        }
        return $pass;
    }

    public static function formatoDecimal($valor, $symbol = false) {

        return $valor = str_replace(',', '.', str_replace('.', '', $valor));
    }

    public static function formatoDecimalHTML($valor, $symbol = false) {

        //str_replace('.', ',', $valor);
        return number_format($valor, 2, ',', '.');
    }

    public static function formatarDatatoHTML($data) {
        $dt = explode('-', $data);

        return $dt[2] . '/' . $dt[1] . '/' . $dt[0];
    }

    public static function formatarDatatoMYSQL($data) {
        $dt = explode('/', $data);

        return $dt[2] . '-' . $dt[1] . '-' . $dt[0];
    }

    public static function cryptografar($value) {
        return sha1(md5($value));
    }

    public static function Upload($FILES, $output_dir, $array) {
        $arquivo = explode(".", $FILES["myfile"]["name"]);
        $extensao = $arquivo[count($arquivo) - 1];
        if (!in_array($extensao, $array)) {
            return $output_dir . 'unknown.jpg';
        }
        if (!is_array($FILES["myfile"]["name"])) { //single file
            $random = self::random_pass(3);
            $fileName = $random . '_@_' . $FILES["myfile"]["name"];
            move_uploaded_file($FILES["myfile"]["tmp_name"], $output_dir . $fileName);
            return $output_dir . $fileName;
        } else {
            return $output_dir . 'unknown.jpg';
        }
    }

    static function getExtensionImages() {
        return $array = array('jpg', 'jpeg', 'gif', 'png');
    }

    static function getExtensionAudios() {
        return $array = array('3gp', 'caf', 'wav', 'mp3', 'wma', 'ogg', 'aif', 'aac', 'm4a');
    }

    static function getExtensionVideos() {
        return $array = array('3gp', 'mp4', 'mov', 'avi');
    }

    static function getExtensionExcel() {
        return $array = array("csv", "xls", "xlsx");
    }

    function numero_random($linhas) {
        $random = rand(0, $linhas);
        return $random;
    }

    function random_palavra($linhas) {
        $fn = "Addons/palavras.txt";
        $nr_linha = numero_random($linhas);
        $f_contents = file($fn);
        $senha = $f_contents[$nr_linha];

        return trim($senha);
    }

    function apaga_files($dir) {
        foreach ($fotos = scandir("$dir") as $deletar) {
            @unlink($dir . "/" . $deletar);
        }
    }

    function DiffDatasHoras($dt1, $dt2) {
        $datetime1 = new DateTime($dt1);
        $datetime2 = new DateTime($dt2);
        //$interval = $datetime1->diff($datetime2); //return  $horas;//%a dias
        $data_1 = mktime($datetime1->format('H'), $datetime1->format('i'), $datetime1->format('s'), $datetime1->format('n'), $datetime1->format('j'), $datetime1->format('Y'));
        $data_2 = mktime($datetime2->format('H'), $datetime2->format('i'), $datetime2->format('s'), $datetime2->format('n'), $datetime2->format('j'), $datetime2->format('Y'));

        $diferenca = $data_2 - $data_1;
        $horas = $diferenca / 3600; // dividimos os segundos por 3600 para transformá-los em horas, 86400 em dias

        $datetime1 = NULL;
        $datetime2 = NULL;

        return number_format(abs($horas), 0, '.', '');
    }

    static function DiffDataDias($data_inicial, $data_final) {
        $time_inicial = strtotime($data_inicial);
        $time_final = strtotime($data_final);
        $diferenca = $time_final - $time_inicial; // 19522800 segundos
        $dias = (int) floor($diferenca / (60 * 60 * 24)); // 225 dias
        return $dias;
    }

    static function ContagemDatas($data, $limite) {
        return date('Y/m/d', strtotime("+" . $limite . " days", strtotime($data)));
    }

    static function removerAcentos($string) {
        return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
    }

    static function timetoDays($time) {
        return (int) $time / (60 * 60 * 24);
    }

    static function isHtml($string) {
        if ($string != strip_tags($string)) {
            return true;
        }
        return false;
    }

    static function email($destinatario, $Subject, $type, $mensagem) {
        $response = array();
        require_once './includes/lib/PHPMailer/PHPMailerAutoload.php';
        $Mailer = new PHPMailer();
        // define que será usado SMTP
        $Mailer->IsSMTP();
        $Mailer->smtpConnect([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ]);
        // envia email HTML
        $Mailer->isHTML(true);
        // codificação UTF-8, a codificação mais usada recentemente
        $Mailer->Charset = 'UTF-8';
        // Configurações do SMTP
        $Mailer->SMTPAuth = true;
        //$Mailer->SMTPDebug = 4;
        //$Mailer->SMTPSecure = 'ssl';
        //$Mailer->SMTPSecure = "tls";
        $Mailer->Host = 'mail.cotaaqui.com.br';
        $Mailer->Port = 25; // tbm já tentei 465 e tbm sem porta nenhuma

        $Mailer->Username = 'cotacao@cotaaqui.com.br';
        $Mailer->Password = '*fG1hAgIw$wo';

        // E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
        // nesse caso seu_login@gmail.com)
        $Mailer->SetFrom = 'cotacao@cotaaqui.com.br';
        // Nome do remetente
        $Mailer->FromName = 'Cota Aqui';
        // assunto da mensagem
        $Mailer->Subject = $Subject;
        // corpo da mensagem
        if ($type === 'HTML') {
            $Mailer->Body = $mensagem; //'Mensagem em HTML';
            // corpo da mensagem em modo texto
        } else {
            $Mailer->AltBody = $mensagem; //'Mensagem em texto';
        }
        // adiciona destinatário (pode ser chamado inúmeras vezes)
        $Mailer->addAddress($destinatario);
        if (!$Mailer->send()) {
            $response['error'][] = 'Erro do PHPMailer: ' . $Mailer->ErrorInfo;
        } else {
            // $response['success'][] = "Email Enviado com sucesso !!!";
        }
        $Mailer->smtpClose();
        return $response;
    }

    static function get_file_extension($file_name) {
        return substr(strrchr($file_name, '.'), 1);
    }

    static function make_thumb($src, $dest, $desired_width) {
        /* read the source image */
        $extension = self::get_file_extension($src);
        if (in_array($extension, array('jpeg', 'jpg'))) {
            $source_image = imagecreatefromjpeg($src);
        } elseif ($extension == "png") {
            $source_image = imagecreatefrompng($src);
        } elseif ($extension == "gif") {
            $source_image = imagecreatefromgif($src);
        } elseif ($extension == "bmp") {
            $source_image = imagecreatefromwbmp($src);
        }
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        //imagejpeg($source_image, $dest);//CRIA UM *.jpeg
        /* create a new, "virtual" image */
        if ($dest != NULL) {
            if (!file_exists($dest)) {
                $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
                /* copy source image at a resized size */
                imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
                /* create the physical thumbnail image to its destination */
                imagejpeg($virtual_image, $dest);
                ////
            }
            return $desired_height;
        } else {
            return $desired_height;
        }
    }

}
