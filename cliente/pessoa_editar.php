<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
pessoasBO::checkExpireLogin();
pessoasBO::checkLogin();

$filterPostUserInfo = array(
    'nome' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{3,255}$/")
    ),
    'tpPessoa' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[F|J]$/")
    ),
    'cpf' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/")
    ),
    'rg' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[a-z0-9]{0,20}$/i")
    ),
    'data_nascimento' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/")
    ),
    'cnpj' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}-[0-9]{2}$/")
    ),
    'razao_social' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{5,255}$/")
    ),
    'inscricao_estadual' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^([0-9]{0,20}|ISENTO)$/")
    ),
    'inscricao_municipal' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^([0-9]{0,20}|ISENTO)$/")
    ),
    'data_fundacao' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/")
    ),
    'email' => array(
        'filter' => FILTER_VALIDATE_EMAIL,
    ),
    'observacao' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,1000}$/")
    )
);

$filterPostUser = array(
    'login' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,255}$/")
    ),
    'password' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{5,255}$/")
    )
);

$filterPostEndereco = array(
    'rua' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,1000}$/")
    ),
    'numero' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,20}$/")
    ),
    'complemento' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,500}$/")
    ),
    'bairro' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,500}$/")
    ),
    'cidade' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,500}$/")
    ),
    'bairro' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,500}$/")
    ),
    'cidade' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,500}$/")
    ),
    'estado' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,10}$/")
    ),
    'cep' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,10}$/")
    ),
    'telefone_fixo' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,20}$/")
    ),
    'telefone_celular' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,20}$/")
    )
);

$data_org = filter_input_array(INPUT_POST);
$datauser = filter_input_array(INPUT_POST, $filterPostUser);
$data = filter_input_array(INPUT_POST, $filterPostUserInfo);
$data_endereco = filter_input_array(INPUT_POST, $filterPostEndereco);

//
try {
    if ($data) {
        $response = array();
        if (empty($data['nome'])) {
            $response['error_input'][] = 'nome';
            $response['error'][] = 'Preencher nome';
        } else if ($data['email'] == NULL) {
            $response['error_input'][] = 'email';
            $response['error'][] = 'E-mail Inválido!';
        } else if ($datauser['login'] == NULL) {
            $response['error_input'][] = 'login';
            $response['error'][] = 'Preencher login';
        } 
        if ($data['tpPessoa'] == 'F' && empty($response['error'])) {
            if ($data['cpf'] == NULL) {
                $response['error_input'][] = 'cpf';
                $response['error'][] = 'Preencher CPF!';
            } else if ($data['data_nascimento'] == NULL) {
                $response['error_input'][] = 'data_nascimento';
                $response['error'][] = 'Preencher Data Nascimento!';
            }
        } else if ($data['tpPessoa'] == 'J' && empty($response['error'])) {
            if ($data['razao_social'] == NULL) {
                $response['error_input'][] = 'razao_social';
                $response['error'][] = 'Razão Social Inválida!';
            } else if ($data['cnpj'] == NULL) {
                $response['error_input'][] = 'cnpj';
                $response['error'][] = 'CNPJ Inválido!';
            } else if ($data['inscricao_estadual'] == NULL) {
                $response['error_input'][] = 'inscricao_estadual';
                $response['error'][] = 'Inscrição Estadual Inválida!';
            }
        }
        if (empty($data_endereco['rua'])) {
            $response['error'][] = 'Preencher rua!';
            $response['error_input'][] = 'rua';
        } else if (empty($data_endereco['numero'])) {
            $response['error'][] = 'nº!';
            $response['error_input'][] = 'numero';
        } else if (empty($data_endereco['bairro'])) {
            $response['error'][] = 'bairro!';
            $response['error_input'][] = 'bairro';
        } else if (empty($data_endereco['cidade'])) {
            $response['error'][] = 'cidade!';
            $response['error_input'][] = 'cidade';
        } else if (empty($data_endereco['estado'])) {
            $response['error'][] = 'estado!';
            $response['error_input'][] = 'estado';
        } else if (empty($data_endereco['cep'])) {
            $response['error'][] = 'cep!';
            $response['error_input'][] = 'cep';
        }

        if (empty($response['error'])) {
            /**
             * 
             */
            if (!empty($datauser['password'])) {
                $datauser['password'] = FUNCOES::cryptografar($datauser['password']);
            } else {
                unset($datauser['password']);
            }
            $checkLoginDiff = pessoasDAO::checkLoginDiff($datauser['login'], $_SESSION['pessoa_id']);

            if ($data['tpPessoa'] == 'F') {
                /**
                 * ((((((((((((((((((PESSOA FISICA)))))))))))))))
                 */
                ($data['cnpj'] = NULL);
                ($data['razao_social'] = NULL);
                ($data['inscricao_estadual'] = NULL);
                ($data['inscricao_municipal'] = NULL);
                ($data['data_fundacao'] = NULL);

                /**
                 * verificações: cpf , login existente
                 */
                if (!empty($datauser['login']) && $checkLoginDiff) {
                    /**
                     * UPDATE USUÁRIO F
                     */
                    $response['error_input'][] = 'login';
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif (!empty($data['cpf']) && pessoasDAO::checkCpfDiff($data['cpf'], $_SESSION['pessoa_id'])) {
                    /**
                     * UPDATE USUÁRIO F
                     */
                    $response['error_input'][] = 'cpf';
                    $response['error'][] = 'CPF de Cliente já cadastrado !!!';
                }
                $data['data_nascimento'] = FUNCOES::formatarDatatoMYSQL($data['data_nascimento']);
            } else {
                /**
                 * ((((((((((((((((((((PESSOA JURIDICA))))))))))))))))))
                 */
                ($data['cpf'] = NULL);
                ($data['rg'] = NULL);
                ($data['data_nascimento'] = NULL);
                if (!empty($datauser['login']) && $checkLoginDiff) {
                    /**
                     * UPDATE USUÁRIO F
                     */
                    $response['error_input'][] = 'login';
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif (!empty($data['cnpj']) && pessoasBO::checkCnpjDiff($data['cnpj'], $_SESSION['pessoa_id'])) {
                    /**
                     * UPDATE USUÁRIO J
                     */
                    $response['error_input'][] = 'cnpj';
                    $response['error'][] = 'CNPJ do Usuário  já cadastrada !!!';
                }
            }

            if (empty($response['error'])) {
                /**
                 * (((((((((((((((((( atualizar usuario ))))))))))))))))))))))))))
                 */
                $pessoa_id = $_SESSION['pessoa_id'];
                $endereco = serialize($data_endereco);
                $data['endereco'] = $endereco;
                unset($data['pessoa_id']);
                pessoasBO::salvar($datauser, 'pessoas', $pessoa_id);
                /**
                 * 
                 */
                if ($pessoa_id) {
                    pessoasBO::salvar($data, 'pessoas_informacao', $pessoa_id);
                } else {
                    pessoasBO::salvar($data, 'pessoas_informacao');
                }

                $response['success'][] = 'Cliente atualizado com sucesso!!';
                //$response['link'] = 'javascript:history.go(-1)';
            }
        }
    } else {
        /**
         * Editar cliente
         */
        try {
            $data = pessoasBO::getPessoa($_SESSION['pessoa_id']);
            $endereco = unserialize($data['endereco']);
            $data['data_nascimento'] = FUNCOES::formatarDatatoHTML($data['data_nascimento']);
            if ($data['data_vencimento']) {
                $data['data_vencimento'] = FUNCOES::formatarDatatoHTML($data['data_vencimento']);
            }
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
                <li><a href="index.php">Home</a></li>
            </ol>
            <div class="well">
                <form role="form" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-lg">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control input-lg" name="nome" placeholder="" value="<?php echo $data['nome']; ?>" maxlength="100" >
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label for="razao_social">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="" value="<?php echo $data['email']; ?>" >
                                </div>
                                <div class="form-group col-sm-5">
                                    <label for="">Login</label>
                                    <input type="text" class="form-control" name="login" placeholder="" value="<?php echo $data['login']; ?>" >
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="cnpj">Senha</label>
                                    <input type="text" class="form-control" name="password" placeholder="" value="" >
                                </div>


                            </div>

                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse"  href="#campos_extras"><span class="glyphicon glyphicon-circle-arrow-up"></span> Informar Mais Campos</a>
                                        </h4>
                                    </div>

                                    <div id="campos_extras" class="collapse in
                                    <?php
//                                    echo $data['inscricao_estadual'] ||
//                                    $data['inscricao_municipal'] ||
//                                    $data['razao_social'] ||
//                                    $data['cnpj'] ||
//                                    $data['cpf'] ||
//                                    $data['rg'] ? 'in' : ''
                                    ?>"
                                         aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <div class="row">

                                                <?php
                                                /*
                                                 * Pessoa Física
                                                 */
                                                ?>
                                                <div class="form-group col-sm-2">
                                                    <label for="tpPessoa">Pessoa Tipo</label>
                                                    <select class="form-control" name="tpPessoa">
                                                        <option value="J" <?php echo $data['tpPessoa'] == 'J' ? 'selected' : ''; ?>>Jurídica</option>
                                                        <option value="F" <?php echo $data['tpPessoa'] == 'F' || empty($data['tpPessoa']) ? 'selected' : ''; ?>>Física</option>
                                                    </select>
                                                </div>
                                                <div class="pFisica">
                                                    <div class="form-group col-sm-3 ">
                                                        <label for="cpf">CPF</label>
                                                        <input type="text" class="form-control" name="cpf" placeholder="" value="<?php echo $data['cpf']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="razao_social">RG</label>
                                                        <input type="text" class="form-control" name="rg" placeholder="" value="<?php echo $data['rg']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="data_nascimento">Data nascimento</label>
                                                        <input type="text" class="form-control" name="data_nascimento" placeholder="" value="<?php echo $data['data_nascimento']; ?>">
                                                    </div>
                                                </div>

                                                <?php
                                                /*
                                                 * Pessoa Jurídica
                                                 */
                                                ?>
                                                <div class="pJuridica" style="display: none;">
                                                    <div class="form-group col-sm-3">
                                                        <label for="razao_social">Razão social</label>
                                                        <input type="text" class="form-control" name="razao_social" placeholder="" value="<?php echo $data['razao_social']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-2">
                                                        <label for="cnpj">CNPJ</label>
                                                        <input type="text" class="form-control" name="cnpj" placeholder="" value="<?php echo $data['cnpj']; ?>">
                                                    </div>
                                                    <!--                                                    <div class="form-group col-sm-2">
                                                                                                            <label for="data_fundacao">Data Fundação</label>
                                                                                                            <input type="text" class="form-control" name="data_fundacao" placeholder="" value="<?php echo $data['data_fundacao']; ?>">
                                                                                                        </div>-->
                                                    <div class="form-group col-sm-3">
                                                        <label for="inscricao_estadual">Inscrição Estadual <small>(Somente Numeros)</small></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="inscricao_estadual" placeholder="" value="<?php echo $data['inscricao_estadual']; ?>" <?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'readonly' : ''; ?>>
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-primary inscricao_estadual"><?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'NÃO ISENTO' : 'ISENTO'; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                /*
                                 * Endereço
                                 */
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne2">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#campos_endereco"><span class="glyphicon glyphicon-circle-arrow-down"></span> Endereço</a>
                                        </h4>
                                    </div>

                                    <div id="campos_endereco" class="collapse in"  aria-labelledby="headingOne">

                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group col-sm-5">
                                                    <label for="razao_social">Rua</label>
                                                    <input type="text" class="form-control" name="rua" placeholder="" value="<?php echo $endereco['rua']; ?>">
                                                </div>
                                                <div class="form-group col-sm-1">
                                                    <label for="razao_social">Número</label>
                                                    <input type="text" class="form-control" name="numero" placeholder="" value="<?php echo $endereco['numero']; ?>">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label for="razao_social">Complemento</label>
                                                    <input type="text" class="form-control" name="complemento" placeholder="" value="<?php echo $endereco['complemento']; ?>">
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label for="razao_social">Bairro</label>
                                                    <input type="text" class="form-control" name="bairro" placeholder="" value="<?php echo $endereco['bairro']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="razao_social">Cidade</label>
                                                    <input type="text" class="form-control" name="cidade" placeholder="" value="<?php echo $endereco['cidade']; ?>">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label for="razao_social">Estado</label>
                                                    <input type="text" class="form-control" name="estado" placeholder="" value="<?php echo $endereco['estado']; ?>">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label for="razao_social">Cep</label>
                                                    <input type="text" class="form-control" name="cep" placeholder="" value="<?php echo $endereco['cep']; ?>">
                                                </div>

                                                <div class="form-group col-sm-2">
                                                    <label for="razao_social">Telefone fixo</label>
                                                    <input type="text" class="form-control" name="telefone_fixo" placeholder="" value="<?php echo $endereco['telefone_fixo']; ?>">
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <label for="razao_social">Celular</label>
                                                    <input type="text" class="form-control" name="telefone_celular" placeholder="" value="<?php echo $endereco['telefone_celular']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                            <!--                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            
                                                            
                            
                                                        </div>-->
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
        <?php
        if ($data['tpPessoa'] == 'J') {
            echo '<script> $(\'.pFisica\').hide();$(\'.pJuridica\').show();</script>';
        } else {
            echo '<script> $(\'.pJuridica\').hide(); $(\'.pFisica\').show();</script>';
        }
        ?>
        <script src="assets/js/gerenciador.min.js"></script>


    </body>
</html>
