<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "autoload.php";
usuariosBO::checkExpireLogin();
usuariosBO::checkLogin();

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
    ),
    'pessoa_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);

$filterPostUser = array(
    'pessoa_id' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'login' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{1,255}$/")
    ),
    'password' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^[\w\W]{5,255}$/")
    ),
    'bloqueado' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'vender' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
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

$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    ),
    'pessoa_id' => array(
        'filter' => FILTER_VALIDATE_INT
    )
    ,
    'pgname' => array(
        'filter' => FILTER_SANITIZE_STRING
    )
);


//
$data_org = filter_input_array(INPUT_POST);
$datauser = filter_input_array(INPUT_POST, $filterPostUser);
$data = filter_input_array(INPUT_POST, $filterPostUserInfo);
$data_endereco = filter_input_array(INPUT_POST, $filterPostEndereco);
$dataGet = filter_input_array(INPUT_GET, $filterGET);

//
try {
    if ($data) {
        $response = array();
        if (empty($data['nome'])) {
            $response['error'][] = 'Preencher nome';
        } else if ($data['email'] == NULL) {
            $response['error'][] = 'E-mail Inválido!';
        } else if ($datauser['login'] == NULL) {
            $response['error'][] = 'Preencher login';
        } else if (empty($datauser['pessoa_id']) && empty($datauser['password'])) {
            $response['error'][] = 'Preencher senha corretamente!';
        }
        if ($data['tpPessoa'] == 'F' && empty($response['error'])) {
            if ($data['cpf'] == NULL) {
                $response['error'][] = 'Preencher CPF!';
            }
//            else if ($data['rg'] == NULL) {
//                $response['error'][] = 'Preencher RG!';
//            }
            else if ($data['data_nascimento'] == NULL) {
                $response['error'][] = 'Preencher Data Nascimento!';
            }
        } else if ($data['tpPessoa'] == 'J' && empty($response['error'])) {
            if ($data['razao_social'] == NULL) {
                $response['error'][] = 'Razão Social Inválida!';
            } else if ($data['cnpj'] == NULL) {
                $response['error'][] = 'CNPJ Inválido!';
            } else if ($data['data_fundacao'] == NULL) {
                $response['error'][] = 'Data Fundacao Inválida!';
            } else if ($data['inscricao_estadual'] == NULL) {
                $response['error'][] = 'Inscrição Estadual Inválida!';
            } else if ($data['inscricao_municipal'] == NULL) {
                $response['error'][] = 'Inscrição Municipal Inválida!';
            }
        }

        if (empty($response['error'])) {
            /**
             * 
             */
            if (!$dataGet['page']) {
                $page = 1;
            } else {
                $page = $data['page'];
            }
            unset($data['page']);
            if (!empty($datauser['password'])) {
                $datauser['password'] = FUNCOES::cryptografar($datauser['password']);
            } else {
                unset($datauser['password']);
            }

            if (empty($datauser['pessoa_id'])) {
                $checklogin = pessoasDAO::checkLogin($datauser['login']);
            } else {
                $checkLoginDiff = pessoasDAO::checkLoginDiff($datauser['login'], $datauser['pessoa_id']);
            }

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
                $checkcpfcnpj = pessoasBO::getCpfCnpj($data['cpf']);

                if (empty($datauser['pessoa_id']) && !empty($checklogin)) {
                    /**
                     * INSERT USUÁRIO F
                     */
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif (!empty($datauser['pessoa_id']) && !empty($datauser['login']) && $checkLoginDiff) {
                    /**
                     * UPDATE USUÁRIO F
                     */
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif (empty($datauser['pessoa_id']) && !empty($checkcpfcnpj)) {
                    /**
                     * INSERT USUÁRIO F
                     */
                    $response['error'][] = 'CPF do Cliente já cadastrado !!!';
                } elseif (!empty($datauser['pessoa_id']) && !empty($data['cpf']) && pessoasDAO::checkCpfDiff($data['cpf'], $datauser['pessoa_id'])) {
                    /**
                     * UPDATE USUÁRIO F
                     */
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
                $checkcpfcnpj = pessoasBO::getCpfCnpj($data['cnpj']);
                if (empty($datauser['pessoa_id']) && !empty($checklogin)) {
                    /**
                     * INSERT USUÁRIO F
                     */
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif (!empty($datauser['pessoa_id']) && !empty($datauser['login']) && $checkLoginDiff) {
                    /**
                     * UPDATE USUÁRIO F
                     */
                    $response['error'][] = 'Login de Cliente já cadastrado !!!';
                } elseif ((empty($datauser['pessoa_id'])) && !empty($checkcpfcnpj)) {
                    /**
                     * INSERT USUÁRIO J
                     */
                    $response['error'][] = 'CNPJ do Usuário  já cadastrada !!!';
                } elseif (!empty($datauser['pessoa_id']) && !empty($data['cnpj']) && pessoasBO::checkCnpjDiff($data['cnpj'], $datauser['pessoa_id'])) {
                    /**
                     * UPDATE USUÁRIO J
                     */
                    $response['error'][] = 'CNPJ do Usuário  já cadastrada !!!';
                }
//                
                $data['data_fundacao'] = FUNCOES::formatarDatatoMYSQL($data['data_fundacao']);
            }


            if (empty($response['error'])) {
                if ($datauser['pessoa_id']) {
                    /**
                     * (((((((((((((((((( atualizar usuario ))))))))))))))))))))))))))
                     */
                    $pessoa_id = ($datauser['pessoa_id']);
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
                } else {
                    /**
                     * (((((((((((((((((( inserir usuario  )))))))))))))))))))))))
                     */
                    $endereco = serialize($data_endereco);
                    $data['endereco'] = $endereco;
                    unset($data['pessoa_id']);
                    unset($datauser['pessoa_id']);
                    $datauser['comprar'] = 1;
                    $datauser['usuario_id'] = $_SESSION['admin'];
                    $pessoa_id = pessoasBO::salvar($datauser, 'pessoas');
                    $data['pessoa_id'] = $pessoa_id;
                    $data['usuario_id'] = $_SESSION['admin'];
                    pessoasBO::salvar($data, 'pessoas_informacao');
                    $response['success'][] = 'Cliente inserido com sucesso!!';
                }
                $response['link'] = 'javascript:history.go(-1)';
            }
        }
    }
    /**
     * Editar cliente
     */
    if ($dataGet['pessoa_id']) {
        try {
            $data = pessoasBO::getPessoa($dataGet['pessoa_id']);
            $endereco = unserialize($data['endereco']);
            $data['data_nascimento'] = FUNCOES::formatarDatatoHTML($data['data_nascimento']);
            $data['data_fundacao'] = FUNCOES::formatarDatatoHTML($data['data_fundacao']);
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
                <li><a href="pessoas"><?= PESSOAS ?> </a></li>
            </ol>
            <div class="well">
                <form role="form" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group form-group-lg">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control input-lg" name="nome" placeholder="" value="<?php echo $data['nome']; ?>" maxlength="100" >
                                <input type="hidden"  name="pessoa_id" value="<?php echo $dataGet['pessoa_id']; ?>">
                                <input type="hidden"  name="pessoa_id" value="<?php echo $dataGet['pessoa_id']; ?>">
                                <input type="hidden" name="page" value="<?php echo $dataGet['page']; ?>">
                                <input type="hidden" name="pgname" value="<?php echo $dataGet['pgname']; ?>">
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
                                                <div class="form-group col-sm-3">
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
                                                    <div class="form-group col-sm-3">
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
                                                    <div class="form-group col-sm-5">
                                                        <label for="razao_social">Razão social</label>
                                                        <input type="text" class="form-control" name="razao_social" placeholder="" value="<?php echo $data['razao_social']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="cnpj">CNPJ</label>
                                                        <input type="text" class="form-control" name="cnpj" placeholder="" value="<?php echo $data['cnpj']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="data_fundacao">Data Fundação</label>
                                                        <input type="text" class="form-control" name="data_fundacao" placeholder="" value="<?php echo $data['data_fundacao']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="inscricao_estadual">Inscrição Estadual <small>(Somente Numeros)</small></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="inscricao_estadual" placeholder="" value="<?php echo $data['inscricao_estadual']; ?>" <?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'readonly' : ''; ?>>
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-primary inscricao_estadual"><?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'NÃO ISENTO' : 'ISENTO'; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="inscricao_municipal">Inscrição Municipal <small>(Somente Numeros)</small></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="inscricao_municipal" placeholder="" value="<?php echo $data['inscricao_municipal']; ?>" <?php echo ($data['inscricao_municipal'] == 'ISENTO') ? 'readonly' : ''; ?>>
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-primary inscricao_municipal"><?php echo ($data['inscricao_municipal'] == 'ISENTO') ? 'NÃO ISENTO' : 'ISENTO'; ?></button>
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
                                            <a data-toggle="collapse" href="#campos_endereco"><span class="glyphicon glyphicon-circle-arrow-down"></span> Endereço</a> <small>(Opcional)</small>
                                        </h4>
                                    </div>

                                    <div id="campos_endereco" class="collapse 
                                    <?php
                                    echo $endereco['rua'] ||
                                    $endereco['numero'] ||
                                    $endereco['bairro'] ||
                                    $endereco['cidade'] ||
                                    $endereco['estado'] ||
                                    $endereco['cep'] ? 'in' : ''
                                    ?>"
                                         aria-labelledby="headingOne">

                                        <div class="panel-body">
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
                            <div class="form-group" style="margin-top:1.2em;">
                                <div class="checkbox pull-left">
                                    <label>
                                        <input type="checkbox" value="1"  name="bloqueado" <?= $data['bloqueado'] ? " checked" : "" ?>><span style="font-size: 14px;" class="label label-danger">Bloqueado</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:1.2em;">
                                <div class="checkbox pull-left">
                                    <label style="margin-left:1.2em;">
                                        <input type="checkbox" value="1"  name="vender" <?= $data['vender'] ? " checked" : "" ?>><span style="font-size: 14px;" class="label label-success">Vendedor</span>
                                    </label>
                                </div>
                            </div>

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
