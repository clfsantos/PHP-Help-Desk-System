$(function () {
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/mkt/relatorio/status-envio.rel.php",
        dataType: "json",
        data: {envio: envio},
        success: function (msg) {
            Morris.Donut({
                element: 'morris-donut-chart',
                data: msg,
                resize: true,
                colors: ["#4CAF50", "#2196F3", "#F44336", "#444444", "#9C27B0"]
            }).on('click', function (i, row) {
                pesquisarStatus(row.label);
            });
        }
    });
});