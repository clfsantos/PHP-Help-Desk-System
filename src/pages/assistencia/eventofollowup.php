<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/EventoFollowupDAO.php';

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
                $eventoFollowupDAO = new EventoFollowupDAO();
                $stmt = $eventoFollowupDAO->listarEventoFollowup($pid);
                $eventoFollowup = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($action === 'editar') {
                $op = "Editar Evento de Followup";
            } else {
                $op = "Cadastrar Evento de Followup";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
                <li><a href="<?php echo HOME_URI; ?>/assistencia/eventofollowup">Eventos de Followup</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmEventoFollowup" id="fmEventoFollowup" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="id_evento" value="<?php
                                        if (isset($eventoFollowup['id_evento'])) {
                                            echo $eventoFollowup['id_evento'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-evento-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-8">                          
                                        <label>Descrição</label>
                                        <input type="text" class="form-control" name="descricao_evento" id="descricao_evento" value="<?php
                                        if (isset($eventoFollowup['descricao_evento'])) {
                                            echo $eventoFollowup['descricao_evento'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-descricao-evento" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-2">                          
                                        <label>SLA</label>
                                        <select class="easyui-combobox" name="prioridade_id" id="prioridade_id" data-options="editable:false,value:<?php
                                        if (isset($eventoFollowup['prioridade_id'])) {
                                            echo $eventoFollowup['prioridade_id'];
                                        } else {
                                            echo 1;
                                        }
                                        ?>" style="width:100%;">
                                            <option value="1">Nível 1 (3 Horas)</option>
                                            <option value="2">Nível 2 (1 Dia)</option>
                                            <option value="3">Nível 3 (2 Dias)</option>
                                            <option value="4">Nível 4 (3 Dias)</option>
                                            <option value="5">Nível 5 (7 Dias)</option>
                                        </select>
                                        <p id="hb-prioridade-id" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($action === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarEventoFollowup();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarEventoFollowup();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
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
                                    <button type="button" class="btn btn-success" onclick="cadastrarEventoFollowupPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarEventoFollowupPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirEventoFollowup();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarEventoFollowup();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgEventoFollowup" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/eventofollowup.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
