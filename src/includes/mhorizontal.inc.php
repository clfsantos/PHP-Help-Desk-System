<?php
//include ABSPATH . '/dao/PainelDAO.php';
//$abertas = $painelDAO->assistenciasAbertas();
?>
<!--NAVBAR-->
<!--===================================================-->
<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="index.html" class="navbar-brand">
                <img src="<?php echo HOME_URI; ?>/images/tecsmart.png" alt="Tecsmart" class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">Tecsmart</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="pli-view-list"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                        <i class="pli-layout-grid"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-md bt-panel-default">

                        <ul class="head-list">
                            <li>
                                <a href="<?php echo HOME_URI; ?>/assistencia/home">
                                    <i class="pli-wrench icon-lg icon-fw"></i> Assistência
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo HOME_URI; ?>/suporte/chamado">
                                    <!--<span class="badge badge-danger pull-right">9</span>-->
                                    <i class="pli-support icon-lg icon-fw"></i> Chamados
                                </a>
                            </li>
                            <!--                            <li>
                                                            <a href="#">
                                                                <span class="label label-success pull-right">Novo</span>
                                                                <i class="pli-credit-card-2 icon-lg icon-fw"></i> Crachás
                                                            </a>
                                                        </li>-->
                            <li>
                                <a href="<?php echo HOME_URI; ?>/mkt/home">
                                    <i class="pli-mail icon-lg icon-fw"></i> Marketing
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo HOME_URI; ?>/home">
                                    <i class="pli-gear icon-lg icon-fw"></i> Geral
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


            </ul>
            <ul class="nav navbar-top-links pull-right">

                <li class="dropdown" id="notificacoes">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">
                        <i class="pli-bell"></i>
                        <span class="badge badge-header badge-danger"></span>
                    </a>


                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar" style="height: 265px;">
                            <div class="nano-content" tabindex="0" style="right: -17px;">
                                <ul class="head-list">

                                    <li>
                                        <a class="media" href="<?php echo HOME_URI; ?>/suporte/chamado">
                                            <span class="chamados_abertos"></span>
                                            <div class="media-left">
                                                <i class="demo-pli-speech-bubble-7 icon-2x"></i>
                                            </div>
                                            <div class="media-body">
                                                <p class="mar-no text-nowrap text-main text-semibold">Chamados em Aberto</p>
                                            </div>
                                        </a>
                                    </li>



                                </ul>
                            </div>
                            <div class="nano-pane" style="">
                                <div class="nano-slider" style="height: 170px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>


                    </div>
                </li>



                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right">
                            <img class="img-circle img-user media-object" src="<?php echo HOME_URI . '/images/perfil/' . $_SESSION['usuarioAvatar']; ?>" alt="Perfil">
                        </span>
                        <div class="username hidden-xs"><?php echo $_SESSION['usuarioNome']; ?></div>
                    </a>


                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right bt-panel-default">

                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
                                <a href="<?php echo HOME_URI; ?>/perfil-pessoal">
                                    <i class="pli-male icon-lg icon-fw"></i> Perfil
                                </a>
                            </li>
                            <!--                            <li>
                                <a href="#">
                                    <span class="badge badge-danger pull-right">9</span>
                                    <i class="pli-mail icon-lg icon-fw"></i> Mensagens
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success pull-right">New</span>
                                    <i class="pli-gear icon-lg icon-fw"></i> Configurações
                                </a>
                            </li>-->
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="<?php echo HOME_URI; ?>/sair.php" class="btn btn-primary">
                                <i class="pli-unlock"></i> Sair
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
<!--===================================================-->
<!--END NAVBAR-->