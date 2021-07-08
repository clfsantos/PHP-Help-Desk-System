<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/dao/ProdutoDAO.php';

        $url[1] = (empty($url[1]) ? null : $url[1]);
        $url[2] = (empty($url[2]) ? null : $url[2]);

        if ($url[1] === 'editar' || $url[1] === 'cadastrar') {
            if ($url[1] === 'editar') {
                $conexao = new Conexao();
                $listaDAO = new ListaDAO();
                $stmt = $listaDAO->listarLista($url[2]);
                $lista = $stmt->fetch(PDO::FETCH_ASSOC);
            }

            if ($url[1] === 'editar') {
                $op = "Editar Lista";
            } else {
                $op = "Cadastrar Lista";
            }
            ?>

            <ol class="breadcrumb">
                <li><a href="<?php echo HOME_URI; ?>/mkt/home">MKT</a></li>
                <li><a href="<?php echo HOME_URI; ?>/mkt/lista">Listas</a></li>
                <li class="active"><?php echo $op; ?></li>
            </ol>
            <div id="page-content">
                <div class="bt-panel">
                    <div class="bt-panel-heading">
                        <h3 class="bt-panel-title">
                            <?php echo $op; ?>
                        </h3>
                    </div>
                    <form role="form" name="fmLista" id="fmLista" method="post" action="">
                        <div class="bt-panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="text" class="form-control" readonly="readonly" name="id" value="<?php
                                        if (isset($lista['id'])) {
                                            echo $lista['id'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-lista-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-10">                          
                                        <label>Descrição</label>
                                        <input type="text" class="form-control" name="descricao" id="descricao" value="<?php
                                        if (isset($lista['descricao'])) {
                                            echo $lista['descricao'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-lista-descricao" class="help-block hb-erro"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bt-panel-footer">
                            <?php if ($url[1] === 'editar') { ?>
                                <button type="button" name="editar" class="btn btn-success load" onclick="editarLista();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                            <?php } else { ?>
                                <button type="button" name="cadastrar" class="btn btn-success load" onclick="cadastrarLista();"><span class="glyphicon glyphicon-ok"></span> Cadastrar</button>
                            <?php } ?>
                            <button type="button" name="limpar" class="btn btn-warning" onclick="limparLista();"><i class="fa fa-refresh fa-fw"></i> Limpar</button>
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
                                <div class="col-sm-4">   
                                    <button type="button" class="btn btn-success" onclick="cadastrarListaPg();"><span class="glyphicon glyphicon-plus"></span> Cadastrar</button>
                                    <button type="button" class="btn btn-primary" onclick="editarListaPg();"><span class="glyphicon glyphicon-edit"></span> Editar</button>
                                    <button type="button" class="btn btn-danger" onclick="excluirLista();"><span class="glyphicon glyphicon-trash"></span> Excluir</button>                        
                                </div>
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="ctCategorias" id="ctCategorias">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="has-feedback">
                                                <input type="text" class="form-control" id="busca" onkeyup="pesquisarProdutos();" placeholder="Buscar...">
                                                <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table id="dgValores" style="width:100%;"></table>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div id="mwProdutoDetalhes" class="mw"></div>
        <?php echo '<script src="' . HOME_URI . '/vendas/js/app/valores.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
