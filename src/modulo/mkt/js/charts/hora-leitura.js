$(function () {
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/mkt/relatorio/hora-leitura.rel.php",
        dataType: "json",
        data: {envio: envio},
        success: function (msg) {
            Morris.Line({
                element: 'morris-line-chart',
                data: msg,
                xkey: 'hora',
                ykeys: ['value'],
                labels: ['Leituras'],
                resize: true,
                smooth: false,
                parseTime: false
            }).on('click', function (i, row) {
                pesquisarEstatisticas(row.hora);
            });
        }
    });
});
