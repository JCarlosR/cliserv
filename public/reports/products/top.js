var $form;
var $loading, $productsTop, $productsTable, $btnToExcel;

$(document).ready(function() {
    $form = $('#form');
    $loading = $('#loading');
    $productsTop = $('#productsTop');
    $productsTable = $('#productsTable');
    $btnToExcel = $('#btnToExcel');

    $form.on('submit', onSubmitFormReport);

    $('.datepicker').pickadate({
        selectMonths: false, // Creates a dropdown to control month
        selectYears: 3, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
    $('.tooltipped').tooltip();

    // export table to excel
    $btnToExcel.on('click', onClickToExcel);
});

function onClickToExcel() {
    // tableToExcel('productsTable', 'Top de productos');
    var params = $form.serialize();
    location.href = '/excel/top/productos?'+params;
}

function onSubmitFormReport() {
    event.preventDefault();

    $btnToExcel.removeAttr('disabled');

    $loading.slideDown('slow');
    $productsTable.hide();

    var params = $(this).serialize();
    $.getJSON('/top/productos/data', params, function(data) {
        $loading.slideUp('slow');

        var htmlRows = '';
        var pairs = data.pairs;
        for (var i=0; i<pairs.length; ++i) {
            htmlRows += '<tr>' +
                '<td>'+pairs[i].product+'</td>' +
                '<td>'+pairs[i].quantity+'</td>' +
                '<td>'+pairs[i].percent+'</td>' +
                '</tr>';
        }
        $productsTop.html(htmlRows);
        $productsTable.show();
        // console.log(data);
    });

    $.getJSON('/top/horas/data', params, function (data) {
        drawLineChart(data);
        // console.log(data);
    });
}

function drawLineChart(peaksHour) {
    var ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',

        data: {
            labels: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sáb"], // dom is ZERO (Carbon PHP library)
            datasets: [{
                label: "Horas pico",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: peaksHour,
                fill: false
            }]
        },

        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Horas de mayor tráfico en cada día'
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Día de la semana'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Hora pico'
                    }
                }]
            }
        }
    });
}