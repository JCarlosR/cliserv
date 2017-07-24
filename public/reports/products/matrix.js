var $form;
var $loading, $productsTop, $productsTable, $btnToExcel;

$(document).ready(function() {
    $form = $('#form');
    $loading = $('#loading');
    $productsTop = $('#productsTop');
    $productsTable = $('#productsTable');
    $btnToExcel = $('#btnToExcel');

    $form.on('submit', onSubmitMatrixForm);

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
    // tableToExcel('productsTable', 'Matriz de horas pico');
    var params = $form.serialize();
    location.href = '/excel/top/matriz?'+params;
}

function onSubmitMatrixForm() {
    event.preventDefault();

    $btnToExcel.removeAttr('disabled');

    $loading.slideDown('slow');
    $productsTable.hide();

    var params = $(this).serialize();

    $.getJSON('/top/horas/matriz', params, function (mt) {
        $loading.slideUp('slow');

        var htmlRows = '';
        // iterate the days for each hour interval
        for (var h=0; h<24; ++h) { // 24 hours
            htmlRows += '<tr>' +
                '<td>'+h+' - '+(h+1)+'</td>';
            for (var d=0; d<7; ++d) { // 7 days
                var cell = mt[d][h];
                var quantity = cell.q;
                var percentage = Math.round(cell.p*100)/100; // round to 2 decimals
                htmlRows += '<td>' + quantity + ' (' + percentage + ' %)</td>';
            }

            htmlRows += '</tr>';
        }

        $productsTop.html(htmlRows);
        $productsTable.show();
    });
}
