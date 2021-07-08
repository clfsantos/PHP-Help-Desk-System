<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <div id="mensagem"></div>
        <?php
        include ABSPATH . '/modulo/geral/dao/CRClienteDAO.php';

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
                $crClienteDAO = new CRClienteDAO();
                $stmt = $crClienteDAO->listarCliente($pid);
                $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/home">Raíz</a></li>
                <li><a href="<?php echo HOME_URI; ?>/geral/cliente">Clientes</a></li>
                <li class="active">Cadastro de Cliente</li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            Cadastro de Cliente
                        </h3>
                    </div>
                    <form role="form" name="fmCliente" id="fmCliente" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-1">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="crcliente_id" value="<?php
                                        if (isset($cliente['crcliente_id'])) {
                                            echo $cliente['crcliente_id'];
                                        }
                                        ?>" style="width:100%;" />
                                        <p id="hb-cliente-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>CNPJ / CPF</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_cnpj" id="crcliente_cnpj" value="<?php
                                        if (isset($cliente['crcliente_cnpj'])) {
                                            echo $cliente['crcliente_cnpj'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-cnpj" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-6">
										<label>Contabilidade</label>
										<input type="text" class="form-control" name="contabilidade_id" id="cbContabilidade" value="<?php
										if (isset($cliente['contabilidade_id'])) {
											echo $cliente['contabilidade_id'];
										}
										?>" style="width: 100%;" />
										<p id="hb-cbcontabilidade" class="help-block hb-erro"></p>
									</div>
                                    <div class="col-lg-2">
                                        <label>Suporte Bloqueado</label>
                                        <select class="easyui-combobox crcliente_bloqueado" name="crcliente_bloqueado" data-options="editable:false,value:<?php
                                        if (isset($cliente['crcliente_bloqueado'])) {
                                            if ($cliente['crcliente_bloqueado'] === true) {
                                                echo 1;
                                            } else {
                                                echo 0;
                                            }
                                        } else {
                                            echo 0;
                                        }
                                        ?>" style="width:100%;">
                                            <option value="0">Não</option>
                                            <option value="1">Sim</option>
                                        </select>          
                                        <p class="help-block hb-erro hb-cliente-bloqueado"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">                          
                                        <label>Razão Social</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_razao" id="crcliente_razao" value="<?php
                                        if (isset($cliente['crcliente_razao'])) {
                                            echo $cliente['crcliente_razao'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-razao" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-6">                          
                                        <label>Nome Fantasia</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_fantasia" id="crcliente_fantasia" value="<?php
                                        if (isset($cliente['crcliente_fantasia'])) {
                                            echo $cliente['crcliente_fantasia'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-fantasia" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">                          
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_telefone" id="crcliente_telefone" value="<?php
                                        if (isset($cliente['crcliente_telefone'])) {
                                            echo $cliente['crcliente_telefone'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-telefone" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-3">                          
                                        <label>Celular / Whatsapp</label>
                                        <input type="text" class="form-control" name="rcliente_celular" id="rcliente_celular" value="<?php
                                        if (isset($cliente['rcliente_celular'])) {
                                            echo $cliente['rcliente_celular'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-celular" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>E-mail</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_email" id="crcliente_email" value="<?php
                                        if (isset($cliente['crcliente_email'])) {
                                            echo $cliente['crcliente_email'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-email" class="help-block hb-erro"></p>
                                    </div>
									<div class="col-lg-3">                          
                                        <label>E-mail RH</label>
                                        <input type="text" class="form-control" name="crcliente_email_rh" id="crcliente_email_rh" value="<?php
                                        if (isset($cliente['crcliente_email_rh'])) {
                                            echo $cliente['crcliente_email_rh'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-email-rh" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
									<div class="col-lg-4">                          
                                        <label>Contato</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_contato" id="crcliente_contato" value="<?php
                                        if (isset($cliente['crcliente_contato'])) {
                                            echo $cliente['crcliente_contato'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-contato" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-8">                          
                                        <label>Endereço</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_end_rua" id="crcliente_end_rua" value="<?php
                                        if (isset($cliente['crcliente_end_rua'])) {
                                            echo $cliente['crcliente_end_rua'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-endereco" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">                          
                                        <label>Número</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_end_num" id="crcliente_end_num" value="<?php
                                        if (isset($cliente['crcliente_end_num'])) {
                                            echo $cliente['crcliente_end_num'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-numero" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Bairro</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_end_bairo" id="crcliente_end_bairo" value="<?php
                                        if (isset($cliente['crcliente_end_bairo'])) {
                                            echo $cliente['crcliente_end_bairo'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-bairro" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_end_complemento" id="crcliente_end_complemento" value="<?php
                                        if (isset($cliente['crcliente_end_complemento'])) {
                                            echo $cliente['crcliente_end_complemento'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-complemento" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-3">                          
                                        <label>CEP</label>
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_end_cep" id="crcliente_end_cep" value="<?php
                                        if (isset($cliente['crcliente_end_cep'])) {
                                            echo $cliente['crcliente_end_cep'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-cep" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Cidade</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" disabled="disabled" name="cidade_id" id="cbCidade" value="<?php
                                        if (isset($cliente['cidade_id'])) {
                                            echo $cliente['cidade_id'];
                                        }
                                        ?>" style="width: 100%;" />
                                    </div>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="cidade_nome" id="cbcidade_nome" value="<?php
                                        if (isset($cliente['cidade_nome'])) {
                                            echo $cliente['cidade_nome'];
                                        }
                                        ?>" disabled="disabled" />   
                                        <p id="hb-cbcidade" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label>Observações</label>
                                        <textarea class="form-control" name="crcliente_obs" rows="10"><?php
                                            if (isset($cliente['crcliente_obs'])) {
                                                echo $cliente['crcliente_obs'];
                                            }
                                            ?></textarea>
                                        <p class="help-block hb-erro hb-ocorrencia-chamado"></p>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-lg-12">
                                        <label>Última atualização</label>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" disabled="disabled" name="crcliente_up_mail_or_cel" id="crcliente_up_mail_or_cel" value="<?php
                                        if (isset($cliente['crcliente_up_mail_or_cel'])) {
                                            echo $cliente['crcliente_up_mail_or_cel'];
                                        }
                                        ?>" style="width: 100%;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <button type="button" name="editar" class="btn btn-success load" onclick="editarCliente();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <br /><br /><b>OBS:</b> Não é possível cadastrar clientes diretamente por aqui. Novos clientes serão sincronizados do junsoft. 
                            Se precisar fazer alguma alteração em algum cliente já existente como e-mail, telefone, por exemplo, deverá ser solicitado
                            para modificar no Junsoft e após a modificação rodar a integração.
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
                    <div class="col-lg-12">
                        <div id="toolbar">
                            <div class="row">
                                <div class="col-sm-8">   
                                    <button type="button" class="btn btn-primary" onclick="editarClientePg();"><span class="glyphicon glyphicon-eye-open"></span> Ver Cadastro</button>
                                    <button type="button" class="btn btn-default" onclick="verEquipamentos();">Equipamentos</button>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarCliente();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgCliente" style="width:100%;height:369px;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="modal md-equipamentos" role="dialog" tabindex="-1" aria-labelledby="md-equipamentos-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Equipamentos do Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="equipamentos-conteudo">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="mwCidade" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/modulo/geral/js/app/crcliente.app.js"></script>'; ?>
    </div>
</div><!--extractor-->
