<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/geral/dao/ContabilidadeDAO.php';

        $uri = $_SERVER["REQUEST_URI"];
        $getVars = explode('?', $uri);
        if (!empty($getVars[1])) {
            parse_str($getVars[1]);
            if (isset($pop)) {
                $pop = $pop;
            }
        } else {
            $pop = '';
        }

        if ($contagem > 1) {
            $action = (empty($url[2]) ? null : $url[2]);
            $pid = (empty($url[3]) ? null : $url[3]);
        } else {
            $action = (empty($url[1]) ? null : $url[1]);
            $pid = (empty($url[2]) ? null : $url[2]);
        }

        if ($action === 'editar' || $action === 'cadastrar') {
            if ($action === 'editar') {
                $conexao = new Conexao();
                $contabilidadeDAO = new ContabilidadeDAO();
                $stmt = $contabilidadeDAO->listarContabilidade($pid);
                $contabilidade = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Contabilidade";
            } else {
                $op = "Cadastrar Contabilidade";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
                <li><a href="<?php echo HOME_URI; ?>/geral/contabilidade">Contabilidades</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmContabilidade" id="fmContabilidade" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="contabilidade_id" value="<?php
                                        if (isset($contabilidade['contabilidade_id'])) {
                                            echo $contabilidade['contabilidade_id'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-id" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-2">                          
                                        <label>CNPJ / CPF</label>
                                        <input type="text" class="form-control" name="contabilidade_cnpj" id="contabilidade_cnpj" value="<?php
                                        if (isset($contabilidade['contabilidade_cnpj'])) {
                                            echo $contabilidade['contabilidade_cnpj'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-cnpj" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-8">                          
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="contabilidade_nome" id="contabilidade_nome" value="<?php
                                        if (isset($contabilidade['contabilidade_nome'])) {
                                            echo $contabilidade['contabilidade_nome'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-nome" class="help-block hb-erro"></p>
                                    </div>
								</div>
							    <div class="row">
									<div class="col-lg-4">                          
                                        <label>Contato</label>
                                        <input type="text" class="form-control" name="contabilidade_contato" id="contabilidade_contato" value="<?php
                                        if (isset($contabilidade['contabilidade_contato'])) {
                                            echo $contabilidade['contabilidade_contato'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-contato" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-4">                          
                                        <label>E-Mail</label>
                                        <input type="text" class="form-control" name="contabilidade_email" id="contabilidade_email" value="<?php
                                        if (isset($contabilidade['contabilidade_email'])) {
                                            echo $contabilidade['contabilidade_email'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-email" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-4">                          
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" name="contabilidade_telefone" id="contabilidade_telefone" value="<?php
                                        if (isset($contabilidade['contabilidade_telefone'])) {
                                            echo $contabilidade['contabilidade_telefone'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contabilidade-telefone" class="help-block hb-erro"></p>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-lg-12">
                                        <label>Observações</label>
                                        <textarea class="form-control" name="contabilidade_obs" rows="10"><?php
                                            if (isset($contabilidade['contabilidade_obs'])) {
                                                echo $contabilidade['contabilidade_obs'];
                                            }
                                            ?></textarea>
                                        <p id="hb-contabilidade-obs" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarContabilidade();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarContabilidade();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>

        <?php } else { ?>

            <div id="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div style="height: 37px;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12" style="padding-bottom:13px;">
                        <div id="toolbar">
                            <div class="row">
                                <div class="col-sm-8">   
                                    <button type="button" class="btn btn-success" onclick="cadastrarContabilidadePg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarContabilidadePg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirContabilidade();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarContabilidade();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgContabilidade" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div id="mwEstado" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/contabilidade.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
