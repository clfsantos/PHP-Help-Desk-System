$(function () {

    $('#dlgDatas').dialog({
        closed: true,
        title: 'Filtrar por datas',
        buttons: '#dlg-buttons-data',
        onOpen: function () {
            $(this).dialog('center');
        },
        onResize: function () {
            $(this).dialog('center');
        }
    });

    $('#data_inicial').datebox({
        formatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
        },
        parser: function (s) {
            if (!s)
                return new Date();
            var ss = s.split('/');
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(d, m - 1, y);
            } else {
                return new Date();
            }
        }
    }).datebox('textbox').mask("99/99/9999");

    $('#data_final').datebox({
        formatter: function (date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + '/' + (m < 10 ? ('0' + m) : m) + '/' + y;
        },
        parser: function (s) {
            if (!s)
                return new Date();
            var ss = s.split('/');
            var y = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var d = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(d, m - 1, y);
            } else {
                return new Date();
            }
        }
    }).datebox('textbox').mask("99/99/9999");

    $('#cbChamadoAno').combobox({
        url: home_uri + '/modulo/suporte/view/ChamadoAnoCombo.php',
        valueField: 'spchamado_dt_ano',
        textField: 'spchamado_dt_ano',
        editable: false,
        onSelect: function (row) {
            geraChamadosPorAno();
        }
    });

    $('#cbChamadosData').combobox({
        editable: false,
        onSelect: function (row) {
            if (row.value === 'dts') {
                $('#dlgDatas').css("display", "");
                $('#dlgDatas').dialog('open');
            } else {
                $('#dlgDatas').dialog('close');
                geraChamadosPorData(null, null);
                geraChamadoTecnico(null, null);
            }
        }
    });

//    var dt = $('#tbClientesRecorrentes').DataTable({
//        "dom": "<'row'<'col-sm-12'l>>" +
//                "<'row'<'col-sm-12'tr>>" +
//                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
//        "processing": true,
//        "serverSide": true,
//        "type": 'POST',
//        "order": [[3, 'desc']],
//        "ajax": {
//            "url": home_uri + "/suporte/relatorio/teste_datables_server.php",
//            "data": function (d) {
//                d.perfil_id = $('#cbPerfil').combobox('getValue');
//                d.busca = $('#busca').val();
//                d.comp = $('#cbComp').combobox('getValue');
//            }
//        },
//        "columns": [
//            {
//                "class": "details-control",
//                "orderable": false,
//                "data": null,
//                "defaultContent": ""
//            },
//            {"data": 'crcliente_razao'},
//            {"data": 'crcliente_fantasia'},
//            {"data": 'qtd'},
//        ],
//        "language": {
//            "search": "",
//            "searchPlaceholder": "Buscar",
//            "paginate": {
//                "previous": '<i class="fa fa-angle-left"></i>',
//                "next": '<i class="fa fa-angle-right"></i>'
//            }
//
//        }
//    });
//
//    var detailRows = [];
//
//    $('#tbClientesRecorrentes tbody').on('click', 'tr td.details-control', function () {
//        var tr = $(this).closest('tr');
//        var row = dt.row(tr);
//        var idx = $.inArray(tr.attr('id'), detailRows);
//
//        if (row.child.isShown()) {
//            tr.removeClass('details');
//            row.child.hide();
//
//            // Remove from the 'open' array
//            detailRows.splice(idx, 1);
//        } else {
//            $.ajax({
//                type: "POST",
//                url: home_uri + "/suporte/relatorio/clientes_recorrentes.rel.php",
//                dataType: "html",
//                data: {crcliente_id: row.data().crcliente_id},
//                success: function (retorno) {
//                    tr.addClass('details');
//                    row.child(retorno).show();
//                    // Add to the 'open' array
//                    if (idx === -1) {
//                        detailRows.push(tr.attr('id'));
//                    }
//                }
//            });
//        }
//    });
//
//    // On each draw, loop over the `detailRows` array and show any child rows
//    dt.on('draw', function () {
//        $.each(detailRows, function (i, id) {
//            $('#' + id + ' td.details-control').trigger('click');
//        });
//    });

    $('#cbPerfil').combobox({
        editable: false,
        onSelect: function (row) {
            dt.ajax.reload();
        }
    });
    
    $('#cbComp').combobox({
        editable: false,
        onSelect: function (row) {
            dt.ajax.reload();
        }
    });
    
    $('#busca').on('keyup', function () {
        dt.ajax.reload();
    });

    geraChamadosPorAno();
    geraChamadosPorData(null, null);
    geraChamadoTecnico(null, null);
});

function filtrarDatas() {
    var dt1 = $('#data_inicial').textbox('textbox').val();
    var dt2 = $('#data_final').textbox('textbox').val();
    geraChamadosPorData(dt1, dt2);
    geraChamadoTecnico(dt1, dt2);
}

function geraChamadosPorAno() {
    $('#chamados-por-ano').empty();
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/suporte/relatorio/chamados_por_ano.rel.php",
        dataType: "json",
        data: {spchamado_dt_ano: $('#cbChamadoAno').combobox('getValue')},
        success: function (msg) {
            Morris.Bar({
                element: 'chamados-por-ano',
                data: msg.meses,
                xkey: 'label',
                ykeys: ['value'],
                labels: ['Chamados'],
                yLabelFormat: function (y) {
                    if (y !== Math.round(y)) {
                        return '';
                    } else {
                        return y;
                    }
                },
                resize: true,
                smooth: false,
                parseTime: false
            });
        }
    });
}

function geraChamadosPorData(dt1, dt2) {
    $('#chamados-mes').empty();
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/suporte/relatorio/chamados_mes.rel.php",
        dataType: "json",
        data: {f1: $('#cbChamadosData').combobox('getValue'), dt1: dt1, dt2: dt2},
        success: function (msg) {
            Morris.Line({
                element: 'chamados-mes',
                data: msg.dias,
                xkey: 'dia',
                ykeys: ['value'],
                labels: ['Chamados'],
                yLabelFormat: function (y) {
                    if (y !== Math.round(y)) {
                        return '';
                    } else {
                        return y;
                    }
                },
                resize: true,
                smooth: false,
                parseTime: false
            });
        }
    });
}

function geraChamadoTecnico(dt1, dt2) {
    $('#chamados-tecnico-mes').empty();
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/suporte/relatorio/chamados_tecnico_mes.rel.php",
        dataType: "json",
        data: {f1: $('#cbChamadosData').combobox('getValue'), dt1: dt1, dt2: dt2},
        success: function (msg) {
            Morris.Donut({
                element: 'chamados-tecnico-mes',
                data: msg.tecs,
                resize: true
            });
        }
    });
}

//function geraClientesRecorrentes() {
//    $.ajax({
//        type: "POST",
//        url: home_uri + "/suporte/relatorio/clientes_recorrentes.rel.php",
//        dataType: "html",
//        success: function (retorno) {
//            $('#clientes-recorrentes').html(retorno).promise().done(function () {
//                var table = $('#tbClientesRecorrentes').DataTable({
//                    "order": [[2, 'desc']],
//                    "serverSide": true,
//                    "ajax": home_uri + "/suporte/relatorio/teste_datables_server.php",
//                    "language": {
//                        "search": "",
//                        "searchPlaceholder": "Buscar",
//                        "lengthMenu": '<select class="form-control">' +
//                                '<option value="10">10</option>' +
//                                '<option value="20">20</option>' +
//                                '<option value="30">30</option>' +
//                                '<option value="40">40</option>' +
//                                '<option value="50">50</option>' +
//                                '<option value="-1">Tudo</option>' +
//                                '</select>'
//
//                    }
//                });
//            });
//        }
//    });
//}


