$(function () {

});

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
