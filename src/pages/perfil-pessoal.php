<?php
if (!defined('ABSPATH')) {
    exit;
}
include ABSPATH . '/modulo/geral/dao/UsuarioConfigDAO.php';
$conexao = new Conexao();
$usuarioConfigDAO = new UsuarioConfigDAO();
$id = $_SESSION['usuarioID'];
$stmt = $usuarioConfigDAO->listarUsuario($id);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="extractor">
    <div id="content-container">
        <ol class="breadcrumb">
            <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
            <li class="active">Perfil Pessoal</li>
        </ol>
        <div id="page-content">
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        Trocar Senha
                    </h3>
                </div>
                <form role="form" name="fmUsuarioConfig" id="fmUsuarioConfig" method="post" action="">
                    <div class="bt-panel-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <label>Senha Atual</label>
                                    <input type="password" class="form-control" name="senha_atual" id="senha_atual" />
                                    <p id="hb-senha-atual" class="help-block hb-erro"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <label>Nova Senha</label>
                                    <input type="password" class="form-control" name="nova_senha_1" id="nova_senha_1" />
                                    <p id="hb-nova-senha-1" class="help-block hb-erro"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">                          
                                    <label>Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" name="nova_senha_2" id="nova_senha_2" />
                                    <p id="hb-nova-senha-2" class="help-block hb-erro"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bt-panel-footer">
                        <button type="button" id="trocar-senha" class="btn btn-primary btn-labeled fa fa-save">Trocar Senha</button>
                    </div>
                </form>
            </div>
            <div class="bt-panel">
                <div class="bt-panel-heading">
                    <h3 class="bt-panel-title">
                        Foto de Perfil
                    </h3>
                </div>
                <div class="bt-panel-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img alt="Avatar" class="img-lg img-circle img-border mar-btm" src="<?php echo HOME_URI . '/images/perfil/' . $usuario['avatar']; ?>">
                                <h4 class="mar-no"><?php echo $usuario['nome']; ?></h4>
                            </div>
                            <div class="col-md-9"> 
                                <form role="form" name="fmFotoPerfil" id="fmFotoPerfil" method="post" action="" class="dropzone">
                                    <div class="dz-default dz-message">
                                        <div class="dz-icon icon-wrap icon-circle icon-wrap">
                                            <i class="fa fa-cloud-upload fa-3x"></i>
                                        </div>
                                        <div>
                                            <span class="dz-text">Arraste o arquivo para fazer upload</span>
                                            <p class="text-muted">ou clique para abrir o explorador</p>
                                        </div>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bt-panel-footer">
                    <p><b>Dica:</b> Envie fotos quadradas, fotos retangulares podem ficar retorcidas. Tamanho máximo: 1mb. Extensções aceitas: .png ou .jpg</p>
                </div>
            </div>
        </div>

        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/usuario-config.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
