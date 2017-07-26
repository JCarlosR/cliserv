var $form;
var $loading, $productsTop, $productsTable, $btnToExcel, $btnToPdf;

$(document).ready(function() {
    $form = $('#form');
    $loading = $('#loading');
    $productsTop = $('#productsTop');
    $productsTable = $('#productsTable');
    $btnToExcel = $('#btnToExcel');
    $btnToPdf = $('#btnToPdf');

    $form.on('submit', onSubmitMatrixForm);

    $('.datepicker').pickadate({
        selectMonths: false, // Creates a dropdown to control month
        selectYears: 3, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
    $('.tooltipped').tooltip();

    // export table
    $btnToExcel.on('click', onClickToExcel);
    $btnToPdf.on('click', onClickToPdf);
});

function onClickToExcel() {
    // tableToExcel('productsTable', 'Matriz de horas pico');
    var params = $form.serialize();
    location.href = '/excel/top/matriz?'+params;
}

function onClickToPdf() {
    var params = $form.serialize();
    location.href = '/pdf/top/matriz?'+params;
}

function onSubmitMatrixForm() {
    event.preventDefault();

    $btnToExcel.removeAttr('disabled');
    $btnToPdf.removeAttr('disabled');

    $loading.slideDown('slow');
    $productsTable.hide();

    var params = $(this).serialize();

    $.getJSON('/top/horas/matriz', params, function (mt) {
        $loading.slideUp('slow');

        var higherValue = 0;
        var higherValueCell = { h:0, d:0 };

        var htmlRows = '';
        // iterate the days for each hour interval
        for (var h=0; h<24; ++h) { // 24 hours
            htmlRows += '<tr>' +
                '<td>'+h+' - '+(h+1)+'</td>';
            for (var d=0; d<7; ++d) { // 7 days
                var cell = mt[d][h];
                var quantity = cell.q;
                if (quantity > higherValue) {
                    higherValue = quantity;
                    higherValueCell.h = h;
                    higherValueCell.d = d;
                }
                var percentage = Math.round(cell.p*100)/100; // round to 2 decimals
                htmlRows += '<td>' + quantity + ' (' + percentage + ' %)</td>';
            }

            htmlRows += '</tr>';
        }

        $productsTop.html(htmlRows);
        $productsTable.show();
        fillWithBackground(higherValueCell, 'yellow');
    });
}

function fillWithBackground(cell, color) {
    var tr = $productsTable.find('tr')[cell.h +1];
    var td = $(tr).find('td')[cell.d +1];
    $(td).css('background', color);
}
