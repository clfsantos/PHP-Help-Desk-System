<?php include '../../../seguranca.php'; ?>
<div class="extractor">
    <div id="content-container">
        <?php
        include ABSPATH . '/modulo/assistencia/dao/ArquivoDAO.php';

        $assistencia_id = filter_input(INPUT_GET, "assistencia_id");
        $arquivo_id = filter_input(INPUT_GET, "arquivo_id");
        $op = filter_input(INPUT_GET, "op");

        if ($op === 'editar') {
            $conexao = new Conexao();
            $arquivoDAO = new ArquivoDAO();
            $stmt = $arquivoDAO->listarArquivo($arquivo_id);
            $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);
            $breadcrumb = 'Editar Arquivo';
        } else {
            $breadcrumb = 'Cadastrar Arquivo';
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

                <div class="bt-panel-body">
                    <div class="container-fluid">

                        <form role="form" name="fmArquivo" id="fmArquivo" method="post" action="" <?php
                        if ($op === 'cadastrar') {
                            echo 'class="dropzone"';
                        }
                        ?>>
                                  <?php if ($op === 'editar') { ?>
                                <div class="row">
                                    <div class="col-lg-2">                          
                                        <label>ID</label>
                                        <input type="hidden" name="assistencia_id" id="assistencia_id" value="<?php echo $assistencia_id; ?>"/>
                                        <input type="text" class="form-control" readonly="readonly" name="id_arquivo" value="<?php
                                        if (isset($arquivo['id_arquivo'])) {
                                            echo $arquivo['id_arquivo'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-arquivo-id" class="help-block hb-erro"></p>
                                    </div>
                                    <div class="col-lg-10">                          
                                        <label>Descrição</label>
                                        <input type="text" class="form-control" name="nome_arquivo" id="nome_arquivo" value="<?php
                                        if (isset($arquivo['nome_arquivo'])) {
                                            echo $arquivo['nome_arquivo'];
                                        }
                                        ?>" style="width: 100%;" />
                                        <p id="hb-nome-arquivo" class="help-block hb-erro"></p>
                                    </div>
                                </div>                     
                            <?php } else { ?>
                                <div class="dz-default dz-message">
                                    <div class="dz-icon icon-wrap icon-circle icon-wrap">
                                        <i class="fa fa-cloud-upload fa-3x"></i>
                                    </div>
                                    <div>
                                        <span class="dz-text">Arraste os arquivos para fazer upload</span>
                                        <p class="text-muted">ou clique para abrir o explorador</p>
                                    </div>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            <?php } ?>
                        </form>

                    </div>
                </div>

                <div class="bt-panel-footer">
                    <?php if ($op === 'editar') { ?>
                        <button type="button" name="editar" class="btn btn-success load" onclick="editarArquivo();"><span class="glyphicon glyphicon-ok"></span> Editar</button>
                    <?php } else { ?>
                        <p><b>OBS:</b> Os arquivos podem ser adicionados de um em um ou todos de uma só vez. Após adicionar um ou mais arquivos o upload irá iniciar automaticamente.</p>
                    <?php } ?>
                </div>

            </div>
        </div>

        <?php if ($op === 'cadastrar') { ?>
            <script>
                $(function () {

                    Dropzone.autoDiscover = false;

                    var myDropzone = new Dropzone("#fmArquivo", {
                        url: home_uri + "/modulo/assistencia/controller/ArquivoController.php",
                        maxFilesize: 8,
                        acceptedFiles: 'image/*,.txt,.zip,.rar',
                        success: function (file, response, action) {
                            var retorno = jQuery.parseJSON(response);
                            if (retorno.erro) {
                                emitirMensagemErro(retorno.erro);
                            }
                        },
                        error: function (file, response) {
                            emitirMensagemErro(response);
                        }
                    });

                    myDropzone.on("sending", function (file, xhr, formData) {
                        formData.append("op", "<?php echo $op; ?>");
                        formData.append("assistencia_id", <?php echo $assistencia_id; ?>);
                    });

                    myDropzone.on("queuecomplete", function () {
                        if ($("#mwArquivo").hasClass("window-body")) {
                            $("#mwArquivo").window('close');
                            $('#dgArquivo').datagrid('reload');
                        }
                    });

    //                    Dropzone.autoDiscover = false;
    //                    // Get the template HTML and remove it from the doument
    //                    var previewNode = document.querySelector("#template");
    //                    previewNode.id = "";
    //                    var previewTemplate = previewNode.parentNode.innerHTML;
    //                    previewNode.parentNode.removeChild(previewNode);
    //
    //                    var myDropzone = new Dropzone("#drop", {// definir um id para a área drop resolve o problema do dropzone already attached, ou tentar chamar o destroy
    //                        url: home_uri + "/assistencia/controller/ArquivoController.php", // Set the url
    //                        thumbnailWidth: 80,
    //                        thumbnailHeight: 80,
    //                        parallelUploads: 1,
    //                        maxFilesize: 8,
    //                        maxFiles: 1,
    //                        acceptedFiles: 'image/*,.txt,.zip,.rar',
    //                        previewTemplate: previewTemplate,
    //                        success: function (file, response, action) {
    //                            var retorno = jQuery.parseJSON(response);
    //                            if (retorno.sucesso) {
    //                                emitirMensagemSucesso(retorno.sucesso);
    //                                if ($("#mwArquivo").hasClass("window-body")) {
    //                                    $("#mwArquivo").window('close');
    //                                    $('#dgArquivo').datagrid('reload');
    //                                }
    //                            } else {
    //                                emitirMensagemErro(retorno.erro);
    //                            }
    //                        },
    //                        error: function (file, response) {
    //                            emitirMensagemErro(response);
    //                        },
    //                        autoQueue: false, // Make sure the files aren't queued until manually added
    //                        previewsContainer: "#previews", // Define the container to display the previews
    //                        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    //                    });
    //
    //                    myDropzone.on("addedfile", function (file) {
    //                        alert('addfile');
    //                        // Hookup the start button
    //                        file.previewElement.querySelector(".start").onclick = function () {
    //                            myDropzone.enqueueFile(file);
    //                        };
    //                    });
    //
    //                    // Update the total progress bar
    //                    myDropzone.on("totaluploadprogress", function (progress) {
    //                        document.querySelector(".progress-bar").style.width = progress + "%";
    //                        $(".progress-bar").html(progress + "%");
    //                    });
    //
    //                    myDropzone.on("sending", function (file, xhr, formData) {
    //                        formData.append("op", "<?php //echo $op;              ?>");
    //                        formData.append("assistencia_id", <?php //echo $assistencia_id;              ?>);
    //                        formData.append("nome_arquivo", $("#nome_arquivo").val());
    //                        // Show the total progress bar when upload starts
    //                        //document.querySelector("#total-progress").style.opacity = "1";
    //                        // And disable the start button
    //                        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    //                    });
    //
    //                    // Hide the total progress bar when nothing's uploading anymore
    //                    myDropzone.on("queuecomplete", function (progress) {
    //                        //alert('terminou');
    //                        document.querySelector(".progress-bar").style.opacity = "0";
    //                        //document.querySelector(".start").removeAttribute("disabled");
    //                        //document.querySelector("#total-progress").style.opacity = "0";
    //                    });

                });
            </script>
        <?php } ?>
        <?php echo '<script src="' . HOME_URI . '/modulo/assistencia/js/app/arquivo.app.js"></script>'; ?>

        <div id="mensagem"></div>
    </div>
</div><!--extractor-->
