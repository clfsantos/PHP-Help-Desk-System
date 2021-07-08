<?php include '../../../seguranca.php'; ?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/FollowupDAO.php';

        $assistencia_id = filter_input(INPUT_GET, "assistencia_id");
        $followup_id = filter_input(INPUT_GET, "followup_id");
        $op = filter_input(INPUT_GET, "op");

        if ($op === 'editar') {
            $conexao = new Conexao();
            $followupDAO = new FollowupDAO();
            $stmt = $followupDAO->listarFollowup($followup_id);
            $followup = $stmt->fetch(PDO::FETCH_ASSOC);
            $breadcrumb = 'Editar Followup';
        } else {
            $breadcrumb = 'Cadastrar Followup';
        }
        ?>

        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/assistencia/home">Assistência</a></li>
            <li><a href="<?php echo HOME_URI; ?>/assistencia/manutencao">Assistências</a></li>
            <li class="active"><?php echo $breadcrumb; ?></li>
        </ol>
        <div id="page-content">
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        <?php echo $breadcrumb; ?>
                    </h3>
                </div>
                <form role="form" name="fmFollowup" id="fmFollowup" method="post" action="">
                    <div class="bt-panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <label>ID</label>
                                    <input type="hidden" name="assistencia_id" value="<?php echo $assistencia_id; ?>"/>
                                    <input type="text" class="form-control" readonly="readonly" name="id_followup" value="<?php
                                    if (isset($followup['id_followup'])) {
                                        echo $followup['id_followup'];
                                    }
                                    ?>" style="width: 100%;" />
                                    <p id="hb-id-followup" class="help-block hb-erro"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Evento <i class="fa fa-info-circle fa-fw" id="info-evento"></i></label>
                                </div>
                                <div class="col-lg-2">
                                    <input type="text" class="easyui-textbox" name="id_evento" id="cbEventoFollowup" value="<?php
                                    if (isset($followup['id_evento'])) {
                                        echo $followup['id_evento'];
                                    }
                                    ?>" style="width: 100%;" />
                                </div>
                                <div class="col-lg-10">                   
                                    <input type="text" class="form-control" name="descricao_evento" id="descricao_evento" value="<?php
                                    if (isset($followup['descricao_evento'])) {
                                        echo $followup['descricao_evento'];
                                    }
                                    ?>" disabled />                  
                                    <p id="hb-eventof-cb" class="help-block hb-erro"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <label>Followup</label>
                                    <textarea class="form-control" name="followup_conteudo" id="followup_conteudo" rows="5"><?php
                                        if (isset($followup['followup_conteudo'])) {
                                            echo $followup['followup_conteudo'];
                                        }
                                        ?></textarea>
                                    <p id="hb-followup-m" class="help-block hb-erro"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>Enviar por E-mail?</label>
                                </div>
                                <div class="col-lg-12">
                                    <div class="checkbox">
                                        <input type="checkbox" name="enviar_email" id="enviar_email" /> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bt-panel-footer">
                        <?php if ($op === 'editar') { ?>
                            <button type="button" name="editar" class="btn btn-success load" onclick="editarFollowup();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                        <?php } else { ?>
                            <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarFollowup();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>

        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/followup.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
