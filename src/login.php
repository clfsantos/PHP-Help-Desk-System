<!DOCTYPE html>
<html lang="pt-BR">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login SGSTI | Tecsmart Sistemas</title>

        <link rel="icon" href="images/favicon.ico" type="image/x-icon"/>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/nifty.min.css" rel="stylesheet">
        <link href="css/nifty-demo-icons.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
    </head>

    <body>
        <div id="container" class="cls-container">
            <div id="bg-overlay" class="bg-img" style="background-image:url('images/login_bg_<?php echo mt_rand(1, 9); ?>.jpg')"></div>
            <div class="cls-header cls-header-lg">
                <div class="cls-brand">
                    <a class="box-inline" href="index.html">
                        <img alt="Nifty Admin" src="images/tecsmart_login.png" class="brand-icon">
                    </a>
                </div>
            </div>
            <div class="cls-content">
                <div class="cls-content-sm bt-panel">
                    <div class="bt-panel-body">
                        <form role="form" method="post" action="valida.php">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                    <input type="text" class="form-control" placeholder="Usuário" id="usuario" name="usuario" autofocus="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                                    <input type="password" class="form-control" placeholder="Senha" id="senha" name="senha">
                                </div>
                            </div>						
                            <button class="btn btn-primary btn-lg btn-block" type="submit">
                                <i class="fa fa-sign-in fa-fw"></i> Entrar
                            </button>
                        </form>
                        <?php if (filter_input(INPUT_GET, "erro")) { ?>
                            <div class="alert alert-danger media fade in" style="margin-bottom:0;">
                                <strong>Erro!</strong> Usuário ou senha incorretos.
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="js/jquery-2.2.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="plugins/fast-click/fastclick.min.js"></script>
        <script src="js/nifty.min.js"></script>

    </body>
</html>
