$(function () {
    $.ajax({
        type: "POST",
        url: home_uri + "/modulo/assistencia/relatorio/assistencia_periodo.rel.php?p=u7",
        dataType: "json",
        success: function (msg) {
            Morris.Line({
                element: 'painel-assistencia',
                data: msg.dias,
                xkey: 'dia',
                ykeys: ['value'],
                labels: ['Assistências'],
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
});
