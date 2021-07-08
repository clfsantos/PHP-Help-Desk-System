<nav id="mainnav-container">
    <div id="mainnav">

        <div id="mainnav-shortcut">
            
        </div>
     
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">

                        <li class="list-divider"></li>
                        
                        <?php if ($url[0] === 'geral' || $url[0] === 'home') { ?>

                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/home">
                                <i class="psi-home"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>

                        <li class="list-divider"></li>
                        
                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/geral/recados">
                                <i class="fa fa-pencil-square-o"></i>
                                <span class="menu-title">
                                    <strong>Recados</strong>
                                </span>
                            </a>
                        </li>

                        <li class="list-divider"></li>

                        <li>
                            <a href="#">
                                <i class="psi-split-vertical-2"></i>
                                <span class="menu-title">
                                    <strong>Cadastros Gerais</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>
                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/geral/cliente">Clientes</a></li>
								<li><a href="<?php echo HOME_URI; ?>/geral/contabilidade">Contabilidades</a></li>
                                <li class="list-divider"></li>
                                <li><a href="<?php echo HOME_URI; ?>/geral/cidade">Cidade</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/geral/estado">Estado</a></li>

                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="psi-gear-2"></i>
                                <span class="menu-title">
                                    <strong>Ferramentas</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>
                            <ul class="collapse">
							    <li><a href="<?php echo HOME_URI; ?>/geral/integracao-omie">Integração Omie - Rápida</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="psi-warning-window"></i>
                                <span class="menu-title">
                                    <strong>Ajuda</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>
                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/geral/release">Releases</a></li>
                            </ul>
                        </li>
                        
                        <?php } elseif ($url[0] === 'suporte') { ?>
                        
                        
                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/suporte/home">
                                <i class="psi-home"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>
                        
                        <li class="list-divider"></li>
                        
                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/suporte/planejamento">
                                 <i class="fa fa-calendar fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Agenda</strong>
                                </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fa fa-edit fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Cadastros</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/geral/cliente">Cliente</a></li>
                                <li class="list-divider"></li>
                                <li><a href="<?php echo HOME_URI; ?>/suporte/grupo">Grupos de Produto</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/suporte/sub-grupo">Sub-Grupos de Produto</a></li>
                                <li class="list-divider"></li>
                                <li><a href="<?php echo HOME_URI; ?>/suporte/release">Releases</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fa fa-support fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Chamados</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/suporte/fluxo-atendimento">Fluxo de Atendimento</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/suporte/fila-espera">Fila de Espera<span class="contagem-fila"></span></a></li>
                                <li><a href="<?php echo HOME_URI; ?>/suporte/chamado">Registro de Chamados</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fa fa-file-text fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Relatórios</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/suporte/chamados-por-empresa">Chamados por Empresa</a></li>
								<li><a href="<?php echo HOME_URI; ?>/suporte/chamados-por-release">Chamados por Releases</a></li>
                            </ul>
                        </li>
                        
                        <?php } elseif ($url[0] === 'mkt') { ?>
                        
                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/mkt/home">
                                <i class="psi-home"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>

                        <li class="list-divider"></li>

                        <li>
                            <a href="#">
                                <i class="fa fa-edit fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Cadastros</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/mkt/contato">Contato</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/mkt/lista">Lista</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fa fa-send fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Newsletter</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/mkt/envio">Envio</a></li>
                            </ul>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="fa fa-search fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Pesquisas</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/mkt/pesquisa-loja">Pesquisa Loja</a></li>
                            </ul>
                        </li>
                        
                        <?php } elseif ($url[0] === 'assistencia') { ?>
                        
                        <li class="sozinho">
                            <a href="<?php echo HOME_URI; ?>/assistencia/home">
                                <i class="psi-home"></i>
                                <span class="menu-title">
                                    <strong>Dashboard</strong>
                                </span>
                            </a>
                        </li>

                        <li class="list-divider"></li>

                        <li>
                            <a href="#">
                                <i class="fa fa-edit fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Cadastros</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/fabricante">Fabricante</a></li>
                                <li class="list-divider"></li>
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/modelo">Modelos</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/equipamento">Equipamentos</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/categoria">Categorias de Equipamentos</a></li>
                                <li class="list-divider"></li>
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/eventofollowup">Eventos de Followup</a></li>
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/problemamanutencao">Problemas de Manuteção</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-wrench fa-menu"></i>
                                <span class="menu-title">
                                    <strong>Assistência</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <ul class="collapse">
                                <li><a href="<?php echo HOME_URI; ?>/assistencia/manutencao">Registro de Manutenção</a></li>
                            </ul>
                        </li>
                        
                        <?php } ?>
                        
                    </ul>

                </div>
            </div>
        </div>
        
    </div>
</nav>
