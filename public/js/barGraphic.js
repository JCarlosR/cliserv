$(document).on('ready', principal);

function principal()
{
    loadMonths();

    $('#graficar').click(function (event) {
        event.preventDefault();

        var year = $('#anio').val();
        var month  = $('#mes').val();

        loadCanvas(  year,month );
    })

}

function loadCanvas(year,month)
{
    var ctx = $("#canvas");
    $.getJSON('reporte-barras/'+year+'/'+month, function(data) {
        var myLabels =[];
        var myData =[];

        $.each(data.name,function(key,value)
        {
            myLabels.push(value);
        });

        $.each(data.quantity,function(key,value)
        {
            myData.push(value);
        });

        var data = {
            labels: myLabels,
            datasets: [
                {
                    label: "Cantidad de items",
                    backgroundColor: [
                        'rgba(145, 162, 235, 0.8)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 0.9)',
                        'rgba(55, 206, 86, 0.8)',
                        'rgba(195, 182, 10, 0.9)'

                    ],
                    borderColor: "rgba(255,99,132,1)",
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        'rgba(145, 162, 235, 0.6)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(55, 206, 86, 0.6)',
                        'rgba(195, 182, 10, 0.7)'
                    ],
                    hoverBorderColor: "rgba(255,99,132,1)",
                    data: myData
                }
            ]
        };

        var mychart = new Chart(ctx, {
            type: "horizontalBar",
            data: data,
            options: {
                scales: {
                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });

    });
}

function loadMonths()
{
    $('#anio').change(  function(){
        $year = $(this).val();

        $.getJSON('month/'+$year, function(data)
        {
            $('#mes').html('');
            $.each(data.name,function(key,value)
            {
                $("#mes").append(" <option value='" + convert_month_number(value)+"'>" + value + "</option> ");
            });
            $('#mes').material_select()
        });
    });
}

function convert_month_number($month_name )
{
    switch( $month_name ) {
        case 'Enero':      return 1;
        case 'Febrero':    return 2;
        case 'Marzo':      return 3;
        case 'Abril':      return 4;
        case 'Mayo':       return 5;
        case  'Junio':     return 6;
        case  'Julio':     return 7;
        case  'Agosto':    return 8;
        case  'Setiembre': return 9;
        case 'Octubre':    return 10;
        case  'Noviembre': return 11;
        case 'Diciembre':  return 12;
    }
}