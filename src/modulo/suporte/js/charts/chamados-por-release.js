$(function () {
    geraChamadosPorEmpresaGrade();
    $('#cbProduto').combobox({
        url: home_uri + '/modulo/suporte/view/ProdutoChamadoCombo.php',
        valueField: 'spchamado_produto_id',
        textField: 'spchamado_produto_desc',
        editable: false,
        multiple: false,
		onSelect: function(dt){
			$('#cbRelease').combobox('clear');
			console.log(dt.spchamado_produto_id);
            var url = home_uri + '/modulo/suporte/view/ReleaseCombo.php?produtoid='+dt.spchamado_produto_id;
			console.log(url);
            $('#cbRelease').combobox('reload', url);
        }
    });
    $('#cbRelease').combobox({
        url: home_uri + '/modulo/suporte/view/ReleaseCombo.php',
        valueField: 'spchamado_release_id',
        textField: 'spchamado_release_num',
        editable: false,
        multiple: true
    });
});

function geraChamadosPorEmpresaGrade() {
    var dados = $("#fmFiltroChamados").serialize();
    console.log(dados);
    $('#gradeChamados').html("carregando...");
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/suporte/relatorio/chamados-por-release.php",
        dataType: 'html',
        data: dados
    }).done(function (retorno) {
        $('#gradeChamados').html(retorno);
    });
}

function editarChamadoExterno(spchamado_id) {
    $('#mwChamado').window({
        href: home_uri + "/suporte/chamado/editar/" + spchamado_id + "?pop=1",
        title: 'Editar Chamado',
        modal: false,
        maximized: true,
        minimizable: false,
        maximizable: false,
        collapsible: false,
        extractor: function (data) {
            data = $.fn.panel.defaults.extractor(data);
            var tmp = $('<div></div>').html(data);
            data = tmp.find('.extractor').html();
            tmp.remove();
            return data;
        }
    });
}