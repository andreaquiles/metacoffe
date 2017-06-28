<?php ?>
<div class="modal" id="loading2" tabindex="-1" role="dialog" aria-hidden="true">
    <div style="text-align: center; margin-top: 15%">
        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" style="font-size: 50px; color: #fff; font-weight: bold"></span>
    </div>
</div>
<div class="modal fade" id="myModal8" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Logout </h4>
            </div>
            <div class="modal-body">
                <p>Deseja realmente sair ?</p>
            </div>
            <form method="post" class="noAjax"  action="logout.php" name="login_form">
                <input type="hidden" name="sair" value="sair">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Sair</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-primary"><?= 'PDF   ' ?></span> <b class="caret"></b></a>

                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

