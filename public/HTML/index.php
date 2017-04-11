<?php
require_once '../../autoload.php';
$filterGET = array(
    'action' => array(
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => array("regexp" => "/^(excluir|imprimir|not_vendedor|vendedor)$/")
    ),
    'page' => array(
        'filter' => FILTER_VALIDATE_INT
    )
);
$dataGet = filter_input_array(INPUT_GET, $filterGET);
if (!$dataGet['page']) {
    $dataGet['page'] = 1;
}
try {
    $paginador = new paginadorHTML($dataGet['page'], 1, 9, '');
    $dados = amostrasDAO::getListaAmostrasHtml($paginador->getPage());
} catch (Exception $err) {
    $response['error'][] = $err->getMessage();
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
    <body class="m-listTableTwo" data-scrolling-animations="true" data-equal-height=".b-items__cell">
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

        <section class="b-modal">
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Video</h4>
                        </div>
                        <div class="modal-body">
                            <iframe width="560" height="315" src="https://www.youtube.com/embed/a_ugz7GoHwY" allowfullscreen></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--b-modal-->
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
                <h1 class="wow zoomInLeft" data-wow-delay="0.5s">Auto Listings</h1>
                <div class="b-pageHeader__search wow zoomInRight" data-wow-delay="0.5s">
                    <h3>Your search returned 28 results</h3>
                </div>
            </div>
        </section><!--b-pageHeader-->

        <div class="b-breadCumbs s-shadow">
            <div class="container wow zoomInUp" data-wow-delay="0.5s">
                <a href="home.html" class="b-breadCumbs__page">Home</a><span class="fa fa-angle-right"></span><a href="listTableTwo.html" class="b-breadCumbs__page m-active">Search Results</a>
            </div>
        </div><!--b-breadCumbs-->

        <div class="b-infoBar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                        <div class="b-infoBar__compare wow zoomInUp" data-wow-delay="0.5s">
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle b-infoBar__compare-item" data-toggle='dropdown'><span class="fa fa-clock-o"></span>RECENTLY VIEWED<span class="fa fa-caret-down"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Item</a></li>
                                    <li><a href="#">Item</a></li>
                                    <li><a href="#">Item</a></li>
                                    <li><a href="#">Item</a></li>
                                </ul>
                            </div>
                            <a href="#" class="b-infoBar__compare-item"><span class="fa fa-compress"></span>COMPARE VEHICLES: 2</a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="b-infoBar__select wow zoomInUp" data-wow-delay="0.5s">
                            <form method="post" action="/">
                                <div class="b-infoBar__select-one">
                                    <span class="b-infoBar__select-one-title">SELECT VIEW</span>
                                    <a href="listings.html" class="m-list"><span class="fa fa-list"></span></a>
                                    <a href="listTableTwo.html" class="m-table m-active"><span class="fa fa-table"></span></a>
                                </div>
                                <div class="b-infoBar__select-one">
                                    <span class="b-infoBar__select-one-title">SHOW ON PAGE</span>
                                    <select name="select1" class="m-select">
                                        <option value="" selected="">10 items</option>
                                    </select>
                                    <span class="fa fa-caret-down"></span>
                                </div>
                                <div class="b-infoBar__select-one">
                                    <span class="b-infoBar__select-one-title">SORT BY</span>
                                    <select name="select2" class="m-select">
                                        <option value="" selected="">Last Added</option>
                                    </select>
                                    <span class="fa fa-caret-down"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--b-infoBar-->

        <div class="b-items">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-4 col-xs-12">
                        <aside class="b-items__aside">
                            <h2 class="s-title wow zoomInUp" data-wow-delay="0.5s">Filtrar Busca</h2>
                            <div class="b-items__aside-main wow zoomInUp" data-wow-delay="0.5s">
                                <form>
                                    <div class="b-items__aside-main-body">
                                        <div class="b-items__aside-main-body-item">
                                            <label>SELECT A MAKE</label>
                                            <div>
                                                <select name="select1" class="m-select">
                                                    <option value="" selected="">Any Make</option>
                                                </select>
                                                <span class="fa fa-caret-down"></span>
                                            </div>
                                        </div>
                                        <div class="b-items__aside-main-body-item">
                                            <label>SELECT A MODEL</label>
                                            <div>
                                                <select name="select1" class="m-select">
                                                    <option value="" selected="">Any Make</option>
                                                </select>
                                                <span class="fa fa-caret-down"></span>
                                            </div>
                                        </div>
                                        <div class="b-items__aside-main-body-item">
                                            <label>PRICE RANGE</label>
                                            <div class="slider"></div>
                                            <input type="hidden" name="min" value="100" class="j-min" />
                                            <input type="hidden" name="max" value="1000" class="j-max" />
                                        </div>
                                        <div class="b-items__aside-main-body-item">
                                            <label>VEHICLE TYPE</label>
                                            <div>
                                                <select name="select1" class="m-select">
                                                    <option value="" selected="">Any Type</option>
                                                </select>
                                                <span class="fa fa-caret-down"></span>
                                            </div>
                                        </div>
                                        <div class="b-items__aside-main-body-item">
                                            <label>VEHICLE STATUS</label>
                                            <div>
                                                <select name="select1" class="m-select">
                                                    <option value="" selected="">Any Status</option>
                                                </select>
                                                <span class="fa fa-caret-down"></span>
                                            </div>
                                        </div>
                                        <div class="b-items__aside-main-body-item">
                                            <label>FUEL TYPE</label>
                                            <div>
                                                <select name="select1" class="m-select">
                                                    <option value="" selected="">All Fuel Types</option>
                                                </select>
                                                <span class="fa fa-caret-down"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="b-items__aside-main-footer">
                                        <button type="submit" class="btn m-btn">FILTER VEHICLES<span class="fa fa-angle-right"></span></button><br />
                                        <a href="">RESET ALL FILTERS</a>
                                    </footer>
                                </form>
                            </div>
                            <div class="b-items__aside-sell wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__aside-sell-img">
                                    <h3>SELL YOUR CAR</h3>
                                </div>
                                <div class="b-items__aside-sell-info">
                                    <p>
                                        Nam tellus enimds eleifend dignis lsim
                                        biben edum tristique sed metus fusce
                                        Maecenas lobortis.
                                    </p>
                                    <a href="submit1.html" class="btn m-btn">REGISTER NOW<span class="fa fa-angle-right"></span></a>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-xs-12">
                        <div class="row m-border">
                            <?php
                            if (is_array($dados)) {
                                foreach ($dados as $dado) {
                                    
                                }
                                ?>
                                <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                    <div class="b-items__cell">
                                        <div class="b-items__cars-one-img">
                                            <img class='img-responsive' src="../../upload/<?= $dado['foto'] ?>" alt='chevrolet'/>
                                            <a href="#" data-toggle="modal" data-target="#myModal" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                            <span class="b-items__cars-one-img-type m-premium">PREMIUM</span>
                                            <form action="/" method="post">
    <!--                                            <input type="checkbox" name="check1" id='check1'/>-->
    <!--                                            <label for="check1" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>-->
                                            </form>
                                        </div>
                                        <div class="b-items__cell-info">
                                            <div class="s-lineDownLeft b-items__cell-info-title">
                                                <h2 class=""><a href="detail.php?amostra_id=<?= $dado['amostra_id'] ?>">Lote <?= $dado['n_lote'] ?></a></h2>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                            <div>
                                                <div class="row m-smallPadding">
                                                    <div class="col-xs-5">
                                                        <span class="b-items__cars-one-info-title">Body Style:</span>
                                                        <span class="b-items__cars-one-info-title">Mileage:</span>
                                                        <span class="b-items__cars-one-info-title">Transmission:</span>
                                                        <span class="b-items__cars-one-info-title">Specs:</span>
                                                    </div>
                                                    <div class="col-xs-7">
                                                        <span class="b-items__cars-one-info-value">Sedan</span>
                                                        <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                        <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                        <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/ferrariTable.jpg" alt='ferrari'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-listing">NE LISTING</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check2" id='check2'/>
                                            <label for="check2" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">2015 Ferrari LaFerrar</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/maximaTable.jpg" alt='maxima'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-premium">PREMIUM</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check3" id='check3'/>
                                            <label for="check3" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Nissan Maxima SV</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/mersTable.jpg" alt='mers'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check4" id='check4'/>
                                            <label for="check4" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Mercedes-Benz GL63 AMG</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/audiTable.jpg" alt='audi'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-listing">NEW LISTING</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check5" id='check5'/>
                                            <label for="check5" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Audi S4 3.0L V6 Turbo</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/toyotaTable.jpg" alt='toyota'/>
                                        <a href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-premium">PREMIUM</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check6" id='check6'/>
                                            <label for="check6" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Toyota RAV4 A Class</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/jaguarTable.jpg" alt='jaguar'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-owner">1 OWNER</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check7" id='check7'/>
                                            <label for="check7" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Jaugar XF 250</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/mercTable.jpg" alt='merc'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check8" id='check8'/>
                                            <label for="check8" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Mercedes Benz GL Class</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-xs-12 wow zoomInUp" data-wow-delay="0.5s">
                                <div class="b-items__cell">
                                    <div class="b-items__cars-one-img">
                                        <img class='img-responsive' src="media/260x230/lexusTable.jpg" alt='lexus'/>
                                        <a data-toggle="modal" data-target="#myModal" href="#" class="b-items__cars-one-img-video"><span class="fa fa-film"></span>VIDEO</a>
                                        <span class="b-items__cars-one-img-type m-listing">NEW LISTING</span>
                                        <form action="/" method="post">
                                            <input type="checkbox" name="check9" id='check9'/>
                                            <label for="check9" class="b-items__cars-one-img-check"><span class="fa fa-check"></span></label>
                                        </form>
                                    </div>
                                    <div class="b-items__cell-info">
                                        <div class="s-lineDownLeft b-items__cell-info-title">
                                            <h2 class=""><a href="detail.html">Lexus LS460F Sport</a></h2>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consec let radipisicing elit, sed do eiusmod  ...</p>
                                        <div>
                                            <div class="row m-smallPadding">
                                                <div class="col-xs-5">
                                                    <span class="b-items__cars-one-info-title">Body Style:</span>
                                                    <span class="b-items__cars-one-info-title">Mileage:</span>
                                                    <span class="b-items__cars-one-info-title">Transmission:</span>
                                                    <span class="b-items__cars-one-info-title">Specs:</span>
                                                </div>
                                                <div class="col-xs-7">
                                                    <span class="b-items__cars-one-info-value">Sedan</span>
                                                    <span class="b-items__cars-one-info-value">35,000 KM</span>
                                                    <span class="b-items__cars-one-info-value">6-Speed Auto</span>
                                                    <span class="b-items__cars-one-info-value">2-Passenger, 2-Door</span>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="b-items__cell-info-price"><span>Price:</span>$29,415</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="b-items__pagination">
                                                    <div class="b-items__pagination-main wow zoomInUp" data-wow-delay="0.5s">
                                                        <a data-toggle="modal" data-target="#myModal" href="#" class="m-left"><span class="fa fa-angle-left"></span></a>
                                                        <span class="m-active"><a href="#">1</a></span>
                                                        <span><a href="#">2</a></span>
                                                        <span><a href="#">3</a></span>
                                                        <span><a href="#">4</a></span>
                                                        <a href="#" class="m-right"><span class="fa fa-angle-right"></span></a>    
                                                    </div>
                                                </div>-->
                        <div class="b-items__pagination" id="paginador_clientes">
                            <?php
                            echo $paginador->getPagi();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--b-items-->

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
                            <p>contact us</p>
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

        <!--Theme-->
        <script src="js/jquery.smooth-scroll.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/jquery.placeholder.min.js"></script>
        <script src="js/theme.js"></script>
    </body>
</html>