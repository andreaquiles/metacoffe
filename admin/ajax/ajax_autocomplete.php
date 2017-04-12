<?php
require_once dirname(dirname(__DIR__)).DIRECTORY_SEPARATOR."autoload.php";
$request = trim(filter_input(INPUT_GET, 'request'));
$action = filter_input(INPUT_GET, 'action');

switch ($action) {
   
        
        case 'nome' :
        try {
            $dados = pessoasBO::ajax_autocomplete($action,$request);
            if ($dados) {
                foreach ($dados as $campo) {
                    $id = $campo->pessoa_id;
                    $nome = filter_var($campo->nome,FILTER_SANITIZE_STRING);
                    ?>
                    <li onselect="this.setText('<?php echo $nome; ?>', '<?php echo $nome; ?>').setValue('<?php echo $nome; ?>', '')">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $nome); ?>
                    </li> 
                    <?php 
                }

                if (!$dados){
                    ?>
                    <li onselect="this.setText('<?php echo $request; ?>', '');">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                       <span style="color: red;font-weight: bold;font-style: italic;" >nome não encontrado </span>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li onselect="this.setText('<?php echo $request; ?>', '');"> 
                    <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                    <span style="color: red;font-weight: normal;font-style: italic;" >nome não encontrado </span>
                </li>
                <?php
            }
        } catch (Exception $ex) {
            ?>
            <li onselect="this.setText('', 'erro');">
                <span style="color: red;font-weight: bold;font-style: italic;" >
                    Erro: <?= substr(" erro no Mysql !!! )" . $ex->getMessage(), 0, 50); ?> 
                </span>
                <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
            </li>
            <?php
        }
        break;
        
        
        case 'email' :
        try {
            $dados = pessoasBO::ajax_autocomplete($action,$request);
            if ($dados) {
                foreach ($dados as $campo) {
                    $email = filter_var($campo->email,FILTER_SANITIZE_STRING);
                    ?>
                    <li onselect="this.setText('<?php echo $email; ?>', '<?php echo $email; ?>').setValue('<?php echo $email; ?>', '')">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $email); ?>
                    </li> 
                    <?php 
                }

                if (!$dados){
                    ?>
                    <li onselect="this.setText('<?php echo $request; ?>', '');">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                       <span style="color: red;font-weight: bold;font-style: italic;" >nome não encontrado </span>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li onselect="this.setText('<?php echo $request; ?>', '');"> 
                    <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                    <span style="color: red;font-weight: bold;font-style: italic;" >nome não encontrado </span>
                </li>
                <?php
            }
        } catch (Exception $ex) {
            ?>
            <li onselect="this.setText('', 'erro');">
                <span style="color: red;font-weight: bold;font-style: italic;" >
                    Erro: <?= substr(" erro no Mysql !!! )" . $ex->getMessage(), 0, 50); ?> 
                </span>
                <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
            </li>
            <?php
        }
        break;
        
        
        
        case 'bebida' :
        try {
            $dados = amostrasBO::ajax_autocomplete($action,$request);
            if ($dados) {
                foreach ($dados as $campo) {
                    //$id = $campo->pessoa_id;
                    $field = filter_var($campo->bebida,FILTER_SANITIZE_STRING);
                    ?>
                    <li onselect="this.setText('<?php echo $field; ?>', '<?php echo $field; ?>').setValue('<?php echo $field; ?>', '')">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $field); ?>
                    </li> 
                    <?php 
                }

                if (!$dados){
                    ?>
                    <li onselect="this.setText('<?php echo $request; ?>', '');">
                        <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                       <span style="color: red;font-weight: bold;font-style: italic;" >nome não encontrado </span>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li onselect="this.setText('<?php echo $request; ?>', '');"> 
                    <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
                    <span style="color: red;font-weight: normal;font-style: italic;" >nome não encontrado </span>
                </li>
                <?php
            }
        } catch (Exception $ex) {
            ?>
            <li onselect="this.setText('', 'erro');">
                <span style="color: red;font-weight: bold;font-style: italic;" >
                    Erro: <?= substr(" erro no Mysql !!! )" . $ex->getMessage(), 0, 50); ?> 
                </span>
                <?php echo str_ireplace($request, '<strong>' . $request . '</strong>', $request); ?>
            </li>
            <?php
        }
        break;
}
