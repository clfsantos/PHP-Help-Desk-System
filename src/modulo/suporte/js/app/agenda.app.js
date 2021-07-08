$(function () {

    $('#cbUsuarioFiltro').combobox({
        url: home_uri + '/modulo/geral/view/UsuariosTecCombo.php?users=todos',
        valueField: 'id',
        textField: 'nome',
        editable: false,
        onSelect: function (row) {
            $('#calendar').fullCalendar('refetchEvents');
        }
    });

    $('#calendar').fullCalendar({
        customButtons: {
            atualizar: {
                text: 'Atualizar',
                click: function () {
                    $('#calendar').fullCalendar('refetchEvents');
                }
            }
        },
        header: {
            left: 'prev,next atualizar today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        businessHours: {
            start: '08:00', // a start time
            end: '19:00', // an end time
            dow: [1, 2, 3, 4, 5]
        },
        height: 'auto',
        defaultView: 'agendaWeek', //Visualiza a agenda semanal ao carregar calendário
        allDaySlot: false, //Desabilita eventos de dia todo
        hiddenDays: [0], //Esconde o domingo
        editable: false, //Faz permitir o drag drop se estiver true
        eventLimit: true, // allow "more" link when too many events
        minTime: '08:00:00', //Hora inicial da agenda
        maxTime: '20:00:00', //Hora final da agenda
        events: {
            url: home_uri + '/modulo/suporte/view/AgendaView.php',
            data: function () {
                return {
                    usuario: $('#cbUsuarioFiltro').combobox('getValue')
                };
            }
        },
        eventRender: function (event, element) {
            element.qtip({
                content: {
                    title: event.title,
                    text: "<b>Chamado:</b><br />" + event.chamado
                            + "<br /><br /><b>Descrição da Tarefa:</b><br />" + event.descricao
                            + "<br /><br /><b>Cliente:</b><br />" + event.cliente
                },
                position: {
                    my: 'top center',
                    at: 'bottom center'
                },
                style: {
                    classes: 'qtip-dark qtip-shadow'
                }
            });
        },
        eventClick: function (calEvent, jsEvent, view) {
            editarChamadoExterno(calEvent.chamado_id);
        },
        loading: function (bool) {
            if (bool)
                $("#mensagem").html("Carregando ...");
            else
                $("#mensagem").html("");
        }
    });

    $('#calendar button').click(function () {
        var view = $('#calendar').fullCalendar('getView');
        if (view.name === 'month') {
            $('#calendar').fullCalendar('option', 'height', '');
        } else {
            $('#calendar').fullCalendar('option', 'height', 'auto');
        }
    });

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
