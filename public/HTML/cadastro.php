<?php
require_once '../../autoload.php';
$filterGET = array(
    'nome' => array(
        'filter' => FILTER_SANITIZE_STRING
    ),
    'email' => array(
        'filter' => FILTER_VALIDATE_EMAIL
    ),
    'password' => array(
        'filter' => FILTER_SANITIZE_STRING
    )
);
$dataPost = filter_input_array(INPUT_POST, $filterGET);
try {
    if ($dataPost) {

        if (empty($dataPost['nome'])) {
            $response['error'][] = 'Preencha nome corretamente!';
            $response['error_input'][] = 'nome';
        } elseif (empty($dataPost['password'])) {
            $response['error_input'][] = 'password';
            $response['error'][] = 'Preencha senha corretamente!';
        } else {
            $response['success'][] = "aguarde...";
        }
    }
} catch (Exception $err) {
    $response['error'][] = $err->getMessage();
}
if (FUNCOES::isAjax()) {
    print json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>Auto Club</title>

        <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

        <link href="css/master.css" rel="stylesheet">

        <!-- SWITCHER -->

        <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color1.css" title="color1" media="all" data-default-color="true" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color2.css" title="color2" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color3.css" title="color3" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color4.css" title="color4" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color5.css" title="color5" media="all" />
        <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/color6.css" title="color6" media="all" />


        <!--[if lt IE 9]>
        <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="m-contacts" data-scrolling-animations="true" >

        <!-- Loader -->
        <div id="page-preloader"><span class="spinner"></span></div>
        <!-- Loader end -->
        <!-- Start Switcher -->
        <div class="switcher-wrapper">	
            <div class="demo_changer">
                <div class="demo-icon customBgColor"><i class="fa fa-cog fa-spin fa-2x"></i></div>
                <div class="form_holder">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="predefined_styles">
                                <div class="skin-theme-switcher">
                                    <h4>Color</h4>
                                    <a href="#" data-switchcolor="color1" class="styleswitch" style="background-color:#f76d2b;"> </a>
                                    <a href="#" data-switchcolor="color2" class="styleswitch" style="background-color:#de483d;"> </a>
                                    <a href="#" data-switchcolor="color3" class="styleswitch" style="background-color:#228dcb;"> </a>
                                    <a href="#" data-switchcolor="color4" class="styleswitch" style="background-color:#00bff3;"> </a>
                                    <a href="#" data-switchcolor="color5" class="styleswitch" style="background-color:#2dcc70;"> </a>
                                    <a href="#" data-switchcolor="color6" class="styleswitch" style="background-color:#6054c2;"> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Switcher -->

        <header class="b-topBar wow slideInDown" data-wow-delay="0.7s">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xs-6">
                        <div class="b-topBar__addr">
                            <span class="fa fa-map-marker"></span>
                            202 W 7TH ST, LOS ANGELES, CA 90014
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <div class="b-topBar__tel">
                            <span class="fa fa-phone"></span>
                            1-800- 624-5462
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <nav class="b-topBar__nav">
                            <ul>
                                <li><a href="#">Cart</a></li>
                                <li><a href="#">Register</a></li>
                                <li><a href="login"><?= $tl['menu']['m1'] ?></a></li>

                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <div class="b-topBar__lang">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle='dropdown'>Language</a>
                                <a class="m-langLink dropdown-toggle" data-toggle='dropdown' href="#"><span class="b-topBar__lang-flag m-en"></span>EN<span class="fa fa-caret-down"></span></a>
                                <ul class="dropdown-menu h-lang">
                                    <li><a class="m-langLink dropdown-toggle" data-toggle='dropdown' href="#"><span class="b-topBar__lang-flag m-en"></span>EN</a></li>
                                    <li><a class="m-langLink dropdown-toggle" data-toggle='dropdown' href="#"><span class="b-topBar__lang-flag m-es"></span>ES</a></li>
                                    <li><a class="m-langLink dropdown-toggle" data-toggle='dropdown' href="#"><span class="b-topBar__lang-flag m-de"></span>DE</a></li>
                                    <li><a class="m-langLink dropdown-toggle" data-toggle='dropdown' href="#"><span class="b-topBar__lang-flag m-fr"></span>FR</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header><!--b-topBar-->

        <nav class="b-nav">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-4">
                        <div class="b-nav__logo wow slideInLeft" data-wow-delay="0.3s">
                            <h3><a href="home.html">Auto<span>Club</span></a></h3>
                            <h2><a href="home.html">AUTO DEALER TEMPLATE</a></h2>
                        </div>
                    </div>
                    <div class="col-sm-9 col-xs-8">
                        <div class="b-nav__list wow slideInRight" data-wow-delay="0.3s">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="collapse navbar-collapse navbar-main-slide" id="nav">
                                <ul class="navbar-nav-menu">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle='dropdown' href="home.html">Home <span class="fa fa-caret-down"></span></a>
                                        <ul class="dropdown-menu h-nav">
                                            <li><a href="home.html">Home Page 1</a></li>
                                            <li><a href="home-2.html">Home Page 2</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle='dropdown' href="#">Grid <span class="fa fa-caret-down"></span></a>
                                        <ul class="dropdown-menu h-nav">
                                            <li><a href="listings.html">listing 1</a></li>
                                            <li><a href="listingsTwo.html">listing 2</a></li>
                                            <li><a href="listTable.html">listing 3</a></li>
                                            <li><a href="listTableTwo.html">listing 4</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="compare.html">compare</a></li>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="article.html">Services</a></li>
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle='dropdown' href="#">Blog <span class="fa fa-caret-down"></span></a>
                                        <ul class="dropdown-menu h-nav">
                                            <li><a href="blog.html">Blog 1</a></li>
                                            <li><a href="blogTwo.html">Blog 2</a></li>
                                            <li><a href="404.html">Page 404</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="submit1.html">Shop</a></li>
                                    <li><a href="contacts.html">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav><!--b-nav-->

        <section class="b-pageHeader">
            <div class="container">
                <h1 class=" wow zoomInLeft" data-wow-delay="0.5s"><?= $tl['menu']['m1'] ?></h1>
                <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
                    <h3>Get In Touch With Us Now</h3>
                </div>
            </div>
        </section><!--b-pageHeader-->

        <div class="b-breadCumbs s-shadow wow zoomInUp" data-wow-delay="0.5s">
            <div class="container">
                <a href="home.html" class="b-breadCumbs__page">Home</a><span class="fa fa-angle-right"></span><span class="b-breadCumbs__page"><?= $tl['menu']['m1'] ?></span>
            </div>
        </div><!--b-breadCumbs-->



        <section class="b-contacts s-shadow">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="b-contacts__form">
                            <header class="b-contacts__form-header s-lineDownLeft wow zoomInUp" data-wow-delay="0.5s">
                                <h2 class="s-titleDet">Cadastro</h2> 
                            </header>
                            <p class=" wow zoomInUp" data-wow-delay="0.5s">Para se cadastrar na MetaCoffee, basta preencher o formulário abaixo e clicar em Cadastrar.</p>
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
                            <div class="b-contacts__address-hours-main wow zoomInUp" style="background-color:#F5F5F5" data-wow-delay="0.5s">
                                <form role="form"  class="s-form wow zoomInUp" method="post">
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
                                                    <input type="text" name="email" class="form-control input-lg"  placeholder="" value="<?php echo $data['email']; ?>" >
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <label for="">Login</label>
                                                    <input type="text" name="login" class="form-control input-lg" placeholder="" value="<?php echo $data['login']; ?>" >
                                                </div>
                                                <div class="form-group col-sm-4">
                                                    <label for="cnpj">Senha</label>
                                                    <input type="text" name="password" class="form-control input-lg" placeholder="" value="" >
                                                </div>


                                            </div>
                                            <div class="row">

                                                <?php
                                                /*
                                                 * Pessoa Física
                                                 */
                                                ?>
                                                <div class="form-group col-sm-3">
                                                    <label for="tpPessoa">Pessoa Tipo</label>
                                                    <div class="s-relative">
                                                    <select  name="tpPessoa" class="m-select">
                                                        <option value="J" <?php echo $data['tpPessoa'] == 'J' ? 'selected' : ''; ?>>Jurídica</option>
                                                        <option value="F" <?php echo $data['tpPessoa'] == 'F' || empty($data['tpPessoa']) ? 'selected' : ''; ?>>Física</option>
                                                    </select>
                                                    <span class="fa fa-caret-down"></span>
                                                    </div>
                                                </div>
                                                <div class="pFisica">
                                                    <div class="form-group col-sm-3 ">
                                                        <label for="cpf">CPF</label>
                                                        <input type="text"  name="cpf" class="form-control input-lg" value="<?php echo $data['cpf']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="razao_social">RG</label>
                                                        <input type="text"  name="rg" class="form-control input-lg" value="<?php echo $data['rg']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-3">
                                                        <label for="data_nascimento">Data nascimento</label>
                                                        <input type="text"  name="data_nascimento" class="form-control input-lg" value="<?php echo $data['data_nascimento']; ?>">
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
                                                        <input type="text"  name="razao_social" class="form-control input-lg" value="<?php echo $data['razao_social']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="cnpj">CNPJ</label>
                                                        <input type="text"  name="cnpj" class="form-control input-lg" value="<?php echo $data['cnpj']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="data_fundacao">Data Fundação</label>
                                                        <input type="text"  name="data_fundacao" class="form-control input-lg" value="<?php echo $data['data_fundacao']; ?>">
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="inscricao_estadual">Inscrição Estadual <small>(Somente Numeros)</small></label>
                                                        <div class="input-group">
                                                            <input type="text"  name="inscricao_estadual" class="form-control input-lg" value="<?php echo $data['inscricao_estadual']; ?>" <?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'readonly' : ''; ?>>
                                                            <div class="input-group-btn">
                                                                <button type="button" style="margin-top:-11px;" class="btn btn-primary inscricao_estadual"><?php echo ($data['inscricao_estadual'] == 'ISENTO') ? 'NÃO ISENTO' : 'ISENTO '; ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-4">
                                                        <label for="inscricao_municipal">Inscrição Municipal <small>(Somente Numeros)</small></label>
                                                        <div class="input-group">
                                                            <input type="text"  name="inscricao_municipal" class="form-control input-lg" value="<?php echo $data['inscricao_municipal']; ?>" <?php echo ($data['inscricao_municipal'] == 'ISENTO') ? 'readonly' : ''; ?>>
                                                            <div class="input-group-btn">
                                                                <button type="button" style="margin-top:-11px;" class="btn btn-primary inscricao_municipal"><?php echo ($data['inscricao_municipal'] == 'ISENTO') ? 'NÃO ISENTO' : 'ISENTO '; ?></button>
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
                                            <div class="panel panel-default" style="margin-bottom: 2px">
                                                <div class="panel-heading" role="tab" id="headingOne2">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" href="#"><span class="glyphicon glyphicon-info-sign"></span> Endereço</a>
                                                    </h4>
                                                </div>

                                                <div id="campos_endereco" class="collapse in" aria-labelledby="headingOne">

                                                    <div class="panel-body">
                                                        <div class="form-group col-sm-4">
                                                            <label for="razao_social">Rua</label>
                                                            <input type="text"  name="rua" class="form-control input-lg" value="<?php echo $endereco['rua']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Número</label>
                                                            <input type="text"  name="numero" class="form-control input-lg" value="<?php echo $endereco['numero']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Complemento</label>
                                                            <input type="text"  name="complemento" class="form-control input-lg" value="<?php echo $endereco['complemento']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label for="razao_social">Bairro</label>
                                                            <input type="text"  name="bairro" class="form-control input-lg" value="<?php echo $endereco['bairro']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-4">
                                                            <label for="razao_social">Cidade</label>
                                                            <input type="text"  name="cidade" class="form-control input-lg" value="<?php echo $endereco['cidade']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Estado</label>
                                                            <input type="text"  name="estado" class="form-control input-lg" value="<?php echo $endereco['estado']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Cep</label>
                                                            <input type="text"  name="cep" class="form-control input-lg" value="<?php echo $endereco['cep']; ?>">
                                                        </div>

                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Telefone fixo</label>
                                                            <input type="text"  name="telefone_fixo" class="form-control input-lg" value="<?php echo $endereco['telefone_fixo']; ?>">
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <label for="razao_social">Celular</label>
                                                            <input type="text"  name="telefone_celular" class="form-control input-lg" value="<?php echo $endereco['telefone_celular']; ?>">
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
                                    </div>
                                    <div class="text-right">
<!--                                    <button type="reset" class="btn m-btn">Cancelar<span class="fa fa-angle-right"></span></button>-->
					<button type="submit" class="btn m-btn">Cadastrar<span class="fa fa-angle-right"></span></button>
                                    </div>
                                  </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section><!--b-contacts-->

    <div class="b-features">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-md-offset-3 col-xs-6 col-xs-offset-6">
                    <ul class="b-features__items">
                        <li class="wow zoomInUp" data-wow-delay="0.3s" data-wow-offset="100">Low Prices, No Haggling</li>
                        <li class="wow zoomInUp" data-wow-delay="0.3s" data-wow-offset="100">Largest Car Dealership</li>
                        <li class="wow zoomInUp" data-wow-delay="0.3s" data-wow-offset="100">Multipoint Safety Check</li>
                    </ul>
                </div>
            </div>
        </div>
    </div><!--b-features-->

    <div class="b-info">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <aside class="b-info__aside wow zoomInLeft" data-wow-delay="0.3s">
                        <article class="b-info__aside-article">
                            <h3>OPENING HOURS</h3>
                            <div class="b-info__aside-article-item">
                                <h6>Sales Department</h6>
                                <p>Mon-Sat : 8:00am - 5:00pm<br />
                                    Sunday is closed</p>
                            </div>
                            <div class="b-info__aside-article-item">
                                <h6>Service Department</h6>
                                <p>Mon-Sat : 8:00am - 5:00pm<br />
                                    Sunday is closed</p>
                            </div>
                        </article>
                        <article class="b-info__aside-article">
                            <h3>About us</h3>
                            <p>Vestibulum varius od lio eget conseq
                                uat blandit, lorem auglue comm lodo 
                                nisl non ultricies lectus nibh mas lsa 
                                Duis scelerisque aliquet. Ante donec
                                libero pede porttitor dacu msan esct
                                venenatis quis.</p>
                        </article>
                        <a href="about.html" class="btn m-btn">Read More<span class="fa fa-angle-right"></span></a>
                    </aside>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="b-info__latest">
                        <h3>LATEST AUTOS</h3>
                        <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__latest-article-photo m-audi"></div>
                            <div class="b-info__latest-article-info">
                                <h6><a href="detail.html">MERCEDES-AMG GT S</a></h6>
                                <p><span class="fa fa-tachometer"></span> 35,000 KM</p>
                            </div>
                        </div>
                        <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__latest-article-photo m-audiSpyder"></div>
                            <div class="b-info__latest-article-info">
                                <h6><a href="#">AUDI R8 SPYDER V-8</a></h6>
                                <p><span class="fa fa-tachometer"></span> 35,000 KM</p>
                            </div>
                        </div>
                        <div class="b-info__latest-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__latest-article-photo m-aston"></div>
                            <div class="b-info__latest-article-info">
                                <h6><a href="#">ASTON MARTIN VANTAGE</a></h6>
                                <p><span class="fa fa-tachometer"></span> 35,000 KM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="b-info__twitter">
                        <h3>from twitter</h3>
                        <div class="b-info__twitter-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__twitter-article-icon"><span class="fa fa-twitter"></span></div>
                            <div class="b-info__twitter-article-content">
                                <p>Duis scelerisque aliquet ante donec libero pede porttitor dacu</p>
                                <span>20 minutes ago</span>
                            </div>
                        </div>
                        <div class="b-info__twitter-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__twitter-article-icon"><span class="fa fa-twitter"></span></div>
                            <div class="b-info__twitter-article-content">
                                <p>Duis scelerisque aliquet ante donec libero pede porttitor dacu</p>
                                <span>20 minutes ago</span>
                            </div>
                        </div>
                        <div class="b-info__twitter-article wow zoomInUp" data-wow-delay="0.3s">
                            <div class="b-info__twitter-article-icon"><span class="fa fa-twitter"></span></div>
                            <div class="b-info__twitter-article-content">
                                <p>Duis scelerisque aliquet ante donec libero pede porttitor dacu</p>
                                <span>20 minutes ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <address class="b-info__contacts wow zoomInUp" data-wow-delay="0.3s">
                        <p><?= $tl['menu']['m1'] ?></p>
                        <div class="b-info__contacts-item">
                            <span class="fa fa-map-marker"></span>
                            <em>202 W 7th St, Suite 233 Los Angeles,
                                California 90014 USA</em>
                        </div>
                        <div class="b-info__contacts-item">
                            <span class="fa fa-phone"></span>
                            <em>Phone:  1-800- 624-5462</em>
                        </div>
                        <div class="b-info__contacts-item">
                            <span class="fa fa-fax"></span>
                            <em>FAX:  1-800- 624-5462</em>
                        </div>
                        <div class="b-info__contacts-item">
                            <span class="fa fa-envelope"></span>
                            <em>Email:  info@domain.com</em>
                        </div>
                    </address>
                    <address class="b-info__map">
                        <a href="contacts.html">Open Location Map</a>
                    </address>
                </div>
            </div>
        </div>
    </div><!--b-info-->

    <footer class="b-footer">
        <a id="to-top" href="#this-is-top"><i class="fa fa-chevron-up"></i></a>
        <div class="container">
            <div class="row">
                <div class="col-xs-4">
                    <div class="b-footer__company wow fadeInLeft" data-wow-delay="0.3s">
                        <div class="b-nav__logo">
                            <h3><a href="home.html">Auto<span>Club</span></a></h3>
                        </div>
                        <p>&copy; 2015 Designed by Templines &amp; Powered by WordPress.</p>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="b-footer__content wow fadeInRight" data-wow-delay="0.3s">
                        <div class="b-footer__content-social">
                            <a href="#"><span class="fa fa-facebook-square"></span></a>
                            <a href="#"><span class="fa fa-twitter-square"></span></a>
                            <a href="#"><span class="fa fa-google-plus-square"></span></a>
                            <a href="#"><span class="fa fa-instagram"></span></a>
                            <a href="#"><span class="fa fa-youtube-square"></span></a>
                            <a href="#"><span class="fa fa-skype"></span></a>
                        </div>
                        <nav class="b-footer__content-nav">
                            <ul>
                                <li><a href="home.html">Home</a></li>
                                <li><a href="404.html">Pages</a></li>
                                <li><a href="listings.html">Inventory</a></li>
                                <li><a href="about.html">About</a></li>
                                <li><a href="404.html">Services</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="listTable.html">Shop</a></li>
                                <li><a href="contacts.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer><!--b-footer-->
    <!--Main-->  
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="../../assets/js/jquery.forms/jquery.forms.js"></script>
    <script src="../../assets/js/manager.js"></script>
    <script src="../../assets/js/jquery.maskedinput.min.js"></script>
    <script src="../../assets/js/typeahead.js"></script>
    <script src="../../assets/js/tipo_pessoa.min.js"></script>

    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.custom.js"></script>

    <script src="assets/rendro-easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.easypiechart.min.js"></script>
    <script src="js/classie.js"></script>

    <!--Switcher-->
    <script src="assets/switcher/js/switcher.js"></script>
    <!--Owl Carousel-->
    <script src="assets/owl-carousel/owl.carousel.min.js"></script>
    <!--bxSlider-->
    <script src="assets/bxslider/jquery.bxslider.js"></script>
    <!-- jQuery UI Slider -->
    <script src="assets/slider/jquery.ui-slider.js"></script>
    <!--Contact form--> 
<!--        <script src="assets/contact/jqBootstrapValidation.js"></script> -->
<!--        <script src="assets/contact/contact_me.js"></script>-->
    <!--Theme-->
    <script src="js/jquery.smooth-scroll.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.placeholder.min.js"></script>
    <script src="js/theme.js"></script>
    <?php
        if ($data['tpPessoa'] == 'J') {
            echo '<script> $(\'.pFisica\').hide();$(\'.pJuridica\').show();</script>';
        } else {
            echo '<script> $(\'.pJuridica\').hide(); $(\'.pFisica\').show();</script>';
        }
//         $('input[name="produtos[' + index + '][preco]"]').css('border-color', function () {
//                    return '#f00';//*vermelho
//                });
        ?>
</body>
</html>