$(document).ready(function() {
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd/mm/yyyy'
    });

    $('#btnGO').on('click', mainFunction);

    $source_filter = $('#source_filter');
    $category_filter = $('#category_filter');

    $.getJSON('../clicks/all', function (data) {
        full_data = data;
        loadUrlsSource(full_data);
        loadCategoriesSource(full_data);
    });

    $.getJSON('../clicks/categories', function (data) {
        categoryProduct = data;
    });

    setupGraph();
});

var full_data;
var categoryProduct = [];
var $source_filter;
var $category_filter;

function loadCategoriesSource(data) {
    var categories = [];
    for (var i=0; i<data.length; ++i) {
        if (convertCategory(data[i].url) != '')
            categories.push(convertCategory(data[i].url));
    }
    //console.log(categories);
    var uniqueCategories = [];
    $.each(categories, function(i, el){
        if($.inArray(el, uniqueCategories) === -1) uniqueCategories.push(el);
    });
    console.log(uniqueCategories);
    $category_filter.append('<option value="0">Todos</option>');
    for (var j=0; j<uniqueCategories.length; ++j) {
        if (uniqueCategories[j] != '')
            $category_filter.append('<option value="'+uniqueCategories[j]+'">'+uniqueCategories[j]+'</option>');
    }
    $category_filter.material_select();
}
//Variable global del total de urls
var uniqueUrls;
var fixedUrls;
function loadUrlsSource(data) {
    var urls = [];
    for (var i=0; i<data.length; ++i) {
        if (convertUrl(data[i].referencia) != 'cliserv.esy.es')
            urls.push(convertUrl(data[i].referencia));
    }
    uniqueUrls = [];
    $.each(urls, function(i, el){
        if($.inArray(el, uniqueUrls) === -1) uniqueUrls.push(el);
    });
    //console.log(uniqueUrls);
    $source_filter.append('<option value="0">Todos</option>');
    for (var j=0; j<uniqueUrls.length; ++j) {
        if (uniqueUrls[j] != '')
            $source_filter.append('<option value="'+uniqueUrls[j]+'">'+uniqueUrls[j]+'</option>');
    }

    $source_filter.material_select();
}

function convertCategory(url) {
    
    var url_convert;
    url_convert = url.replace('http://cliserv.esy.es/es/', '');
    var pos = url_convert.indexOf('-');
    if (pos != -1)
        url_convert = url_convert.substr(pos+1, url_convert.length);
    //console.log(url_convert);

    if (url_convert.indexOf('/')==-1 && url_convert.indexOf('?')==-1 && url_convert.indexOf('html')==-1 && url_convert.indexOf('#')==-1 && url_convert.indexOf('pedido')==-1 && url_convert.indexOf('contraseña')==-1 && url_convert.indexOf('cuenta')==-1 && url_convert.indexOf('contactanos')==-1 && url_convert.indexOf('terminos')==-1) {
        return url_convert;
    }

    return '';
}

function convertUrl(url) {
    var url_convert;
    url_convert = url.replace('http://', '');
    url_convert = url_convert.replace('https://', '');
    var pos = url_convert.indexOf('/');
    if (pos != -1)
        url_convert = url_convert.substr(0, pos);
    return url_convert;

}

function mainFunction() {
    // Product dimension
    var filtered_data = filterByCategory(full_data);

    // Client dimension
    filtered_data = filterByGenre(filtered_data);
    filtered_data = filterByCountry(filtered_data);

    // Device dimension
    filtered_data = filterByDeviceType(filtered_data);

    // Source dimension
    filtered_data = filterByUrlSource(filtered_data);

    // Time dimension
    filtered_data = filterByHour(filtered_data);

    if ( $('ul.tabs a[href="#tab1"]').hasClass('active') ) {
        filtered_data = filterByYear(filtered_data);
        filtered_data = filterByMonth(filtered_data);
    } else if ( $('ul.tabs a[href="#tab3"]').hasClass('active') ) {
        filtered_data = filterByDayName(filtered_data);
    } else if ( $('ul.tabs a[href="#tab2"]').hasClass('active') ) {
        filtered_data = filterByRangeDate(filtered_data);
    }
    console.log(filtered_data);
    generateGraph(filtered_data);
}

function generateGraph(filtered_data) {
    // Swap config <-> results
    $('[data-config]').slideUp();
    $('[data-results]').slideDown();

    var new_labels;
    var new_datasets = [];

    if ( $('#presentation_device').is(':checked') ) {
        // New labels
        new_labels = ['By device'];

        // Generate my data
        var myData = getDeviceTypeData(filtered_data);

        // New dataSets
        var desktopDataSet = {
            label: 'Desktop',
            borderColor: randomColor(0.4),
            backgroundColor: randomColor(0.5),
            pointBorderColor: randomColor(0.7),
            pointBackgroundColor: randomColor(0.5),
            pointBorderWidth: 1,
            data: myData.desktop
        };
        var mobileDataSet = {
            label: 'Mobile',
            borderColor: randomColor(0.4),
            backgroundColor: randomColor(0.5),
            pointBorderColor: randomColor(0.7),
            pointBackgroundColor: randomColor(0.5),
            pointBorderWidth: 1,
            data: myData.mobile
        };

        new_datasets.push(desktopDataSet);
        new_datasets.push(mobileDataSet);
    } else if ( $('#presentation_genre').is(':checked') ) {
        new_labels = ['By genre'];

        // Generate my data
        var myData = getGenresData(filtered_data);

        // New dataSets
        var desktopDataSet = {
            label: 'Hombres',
            borderColor: randomColor(0.4),
            backgroundColor: randomColor(0.5),
            pointBorderColor: randomColor(0.7),
            pointBackgroundColor: randomColor(0.5),
            pointBorderWidth: 1,
            data: myData.male
        };
        var mobileDataSet = {
            label: 'Mujeres',
            borderColor: randomColor(0.4),
            backgroundColor: randomColor(0.5),
            pointBorderColor: randomColor(0.7),
            pointBackgroundColor: randomColor(0.5),
            pointBorderWidth: 1,
            data: myData.female
        };

        new_datasets.push(desktopDataSet);
        new_datasets.push(mobileDataSet);
    } else if ( $('#presentation_country').is(':checked')) {
        new_labels = ['By Country'];

        // Generate my data
        var myData = getCountryData(filtered_data);

        // New dataSets
        for(var i=0; i<myData.nombre.length; i++){
            var countryDataset = {
                label: myData.nombre[i],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [myData.cantidad[i]]
            };
            new_datasets.push(countryDataset);
        }
    } else if ( $('#presentation_origin').is(':checked') ) {
        // New labels
        fixedUrls = [];
        for (var u=0; u<uniqueUrls.length; ++u) {
            if (uniqueUrls[u] != '')
                fixedUrls.push(uniqueUrls[u]);
        }

        new_labels = ['By source of visits'];
        console.log(new_labels);
        // Generate my data
        var myData2 = getSourceTypeData(filtered_data);
        console.log(myData2);
        // New dataSets
        for (var i=0; i<myData2.length; ++i) {
            var source = 'sourceDataSet'+i;
            source = {
                label: fixedUrls[i],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [myData2[i]]
            };

            new_datasets.push(source);
        }

    } else if ( $('#presentation_product').is(':checked')) {
        new_labels = ['By Product'];

        // Generate my data
        var myData = getProductData(filtered_data);

        // New dataSets
        for (var i = 0; i < myData.nombre.length; i++) {
            var countryDataset = {
                label: myData.nombre[i],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [myData.cantidad[i]]
            };
            new_datasets.push(countryDataset);
        }
    } else if ( $('#presentation_category').is(':checked')) {
            new_labels = ['By Category'];

            // Generate my data
            var myData = getCategoryData(filtered_data);
            // New dataSets
            for (var i = 0; i < myData.nombre.length; i++) {

                var categoryDataset = {
                    label: getName(myData.nombre[i]),
                    borderColor: randomColor(0.4),
                    backgroundColor: randomColor(0.5),
                    pointBorderColor: randomColor(0.7),
                    pointBackgroundColor: randomColor(0.5),
                    pointBorderWidth: 1,
                    data: [myData.cantidad[i]]
                };
                new_datasets.push(categoryDataset);
        }

    } else if ( $('#presentation_month').is(':checked') ) {
        var new_labels1 = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre'
        ];

        new_labels = ['By month']

        console.log(new_labels);
        // Generate my data
        var myData3 = getMonthTypeData(filtered_data);
        console.log(myData3);
        // New dataSets
        for (var k=0; k<myData3.length; ++k) {
            var source1 = 'sourceDataSet'+k;
            source1 = {
                label: new_labels1[k],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [myData3[k]]
            };

            new_datasets.push(source1);
        }

    }else if ( $('#presentation_day').is(':checked') ) {
        var new_labels2 = [
            'Domingo',
            'Lunes',
            'Martes',
            'Miércoles',
            'Jueves',
            'Viernes',
            'Sabado'
        ];

        new_labels = ['By day']

        console.log(new_labels);
        // Generate my data
        var myData4 = getDayTypeData(filtered_data);
        console.log(myData4);
        // New dataSets
        for (var j=0; j<myData4.length; ++j) {
            var source2 = 'sourceDataSet'+j;
            source2 = {
                label: new_labels2[j],
                borderColor: randomColor(0.4),
                backgroundColor: randomColor(0.5),
                pointBorderColor: randomColor(0.7),
                pointBackgroundColor: randomColor(0.5),
                pointBorderWidth: 1,
                data: [myData4[j]]
            };
            new_datasets.push(source2);
        }
    }

    // Aquí arribita deben agregar un(os) radioButton c/u según la dimensión que les toque
    // Pondré de ejemplo la dimensión y el radioButton de cliente Género

    // Apply changes

    config.data.labels = new_labels;
    config.data.datasets = new_datasets;

    window.myLine.update();
}

function getDayTypeData(data) {
    var quantity = [];
    for (var d=0; d<7; ++d) {
        quantity.push(0);
        for (var i=0; i<data.length; ++i) {
            var fecha = new Date(data[i].fecha);
            if ( fecha.getDay() == d )
                ++quantity[d];
        }
    }
    return quantity;
}

function getMonthTypeData(data) {
    var quantity = [];
    for (var m=0; m<12; ++m) {
        quantity.push(0);
        for (var i=0; i<data.length; ++i) {
            var fecha = new Date(data[i].fecha);
            if ( fecha.getMonth() == m )
                ++quantity[m];
        }
    }

    return quantity;
}

function getSourceTypeData(data) {
    var quantity = [];
    for (var i=0; i<fixedUrls.length; ++i) {
        quantity.push(0);
        for (var j=0; j<data.length; ++j){
            if ( convertUrl(data[j].referencia) == fixedUrls[i] )
                ++quantity[i];
        }
    }
    return quantity;
}

function getDeviceTypeData(data) {
    var desktop = 0;
    var mobile = 0;

    for (var i=0; i<data.length; ++i) {
        if (data[i].dispositivo == 'desktop')
            ++desktop;
        else ++mobile;
    }

    return { desktop: [desktop], mobile: [mobile]};
}

function getGenresData(data){
    var male = 0;
    var female = 0;

    for (var i=0; i<data.length; ++i) {
        if (data[i].user == null)
            continue;
        if (data[i].user.id_gender == 1)
            ++male;
        else ++female;
    }

    return { male: [male], female: [female]};
}

function getCountryData(data){
    var country = [];
    var auxArray = [];
    var quantity = [];

    for (var i=0; i<data.length; ++i) {
        if (data[i].country == null)
            continue;
        else country.push(data[i].country);
    }
    var j;
    for (var i=0; i<country.length; ++i)
    {
        j = encontrado(country[i], auxArray);
        if(j != -1)
            quantity[j]++;
        else{
            auxArray.push(country[i]);
            quantity.push(1);
        }
    }
    var data = [];
    data['nombre'] = auxArray;
    data['cantidad'] = quantity;
    return data;
}

function getProductData(data){
    var product = [];
    var auxArray = [];
    var quantity = [];

    for (var i=0; i<data.length; ++i) {
        if (data[i].product == null)
            continue;
        else product.push(data[i].product.name);
    }
    var j;
    for (var i=0; i<product.length; ++i)
    {
        j = encontrado(product[i], auxArray);
        if(j != -1)
            quantity[j]++;
        else{
            auxArray.push(product[i]);
            quantity.push(1);
        }
    }
    var data = [];
    data['nombre'] = auxArray;
    data['cantidad'] = quantity;
    return data;
}

function getCategoryData(data){
    var product = [];
    var auxArray = [];
    var quantity = [];

    for (var i=0; i<data.length; ++i) {
        if (data[i].product == null)
            continue;
        else product.push(data[i].product_id);
    }
    console.log(product);
    var j;
    for (var i=0; i<product.length; ++i)
    {
        j = encontrado(product[i], auxArray);
        if(j != -1)
            quantity[j]++;
        else{
            auxArray.push(product[i]);
            quantity.push(1);
        }
    }

    var data = [];
    data['nombre'] = auxArray;
    data['cantidad'] = quantity;
    return data;
}

function getName(element) {
    for(var i=0; i<categoryProduct.length; i++)
        if(categoryProduct[i].id_product == element)
            return categoryProduct[i].reference;
}

function getNameCountry(element) {
    for(var i=0; i<categoryProduct.length; i++)
        if(categoryProduct[i].id_product == element)
            return categoryProduct[i].reference;
}

function encontrado(page, dom){
    for (var i=0; i<dom.length; ++i)
        if(dom[i] == page)
            return i;
    return -1;
}

function filterByRangeDate(data) {
    var filtered = [];
    var date_start = convertDate($('#start_date').val());
    var date_end = convertDate($('#end_date').val());

    for (var i=0; i<data.length; ++i) {
        console.log('Date inicial '+ date_start);
        console.log('Date actual '+ new Date(data[i].fecha));
        console.log('Date final '+ date_end);
        console.log('===============================');

        if( new Date(date_start).getTime() <= new Date(data[i].fecha).getTime() && new Date(data[i].fecha).getTime() <= new Date(date_end).getTime() )
            filtered.push(data[i]);
    }

    return filtered;
}

function convertDate(fecha) {
    var y;
    var m;
    var d;

    var pos1 = fecha.indexOf('/');
    d = fecha.substr(0, pos1);
    fecha = fecha.slice(pos1+1, fecha.length);
    var pos2 = fecha.indexOf('/');
    m = fecha.substr(0, pos2);
    fecha = fecha.slice(pos2+1, fecha.length);
    y = fecha;

    var date = new Date(y+"-"+m+"-"+d);
    date.setDate(date.getDate() + 1);
    return date;
}

function filterByDayName(data) {
    var filtered = [];
    var selected_option = $('#day_filter').val();
    if (selected_option == 9)
        return data;
    if (selected_option > 0 && selected_option < 6) {
        for (var i=0; i<data.length; ++i) {
            var d = new Date(data[i].fecha);
            var n = d.getDay();
            if (n == selected_option)
                filtered.push(data[i]);
        }
        return filtered;
    }
    if (selected_option == 7) {
        for (var j=0; j<data.length; ++j) {
            var dd = new Date(data[j].fecha);
            var nn = dd.getDay();
            if (nn > 0 && nn < 6)
                filtered.push(data[j]);
        }
        return filtered;
    }
    if (selected_option == 8) {
        for (var k=0; k<data.length; ++k) {
            var ddd = new Date(data[k].fecha);
            var nnn = ddd.getDay();
            if (nnn == 0 || nnn == 6)
                filtered.push(data[k]);
        }
        return filtered;
    }
}

function filterByDeviceType(data) {
    var selected_option = $('#device_filter').val();

    if (selected_option==0)
        return data;

    var device_type;
    if (selected_option==1)
        device_type = 'desktop';
    else device_type = 'movil'; // 2

    var filtered = [];
    for (var i=0; i<data.length; ++i) {
        if (data[i].dispositivo == device_type)
            filtered.push(data[i]);
    }

    return filtered;
}

function filterByCountry(data) {
    var selected_option = $('#cbopaises').val();
    if (selected_option == 0)
        return data;

    var country;
    country = selected_option;

    var filtered = [];
    for (var i = 0; i < data.length; ++i) {
        if (data[i].country == country)
            filtered.push(data[i]);
    }

    return filtered;
}

function filterByUrlSource(data) {
    var selected_option = $('#source_filter').val();
    if (selected_option==0)
        return data;

    var filtered = [];
    for (var i=0; i<data.length; ++i) {
        if (convertUrl(data[i].referencia) == selected_option)
            filtered.push(data[i]);
    }
    return filtered;
}

function filterByCategory(data) {
    var selected_option = $('#category_filter').val();
    if (selected_option==0)
        return data;

    var filtered = [];
    for (var i=0; i<data.length; ++i) {
        if (convertCategory(data[i].url) == selected_option)
            filtered.push(data[i]);
    }
    return filtered;
}

function filterByGenre(data) {
    var selected_option = $('#cboGenre').val();

    if (selected_option==3)
        return data;

    var filtered = [];
    if (selected_option==2) {
        for (var i=0; i<data.length; ++i) {
            if (data[i].user == null)
                filtered.push(data[i]);
        }
    }
    else{
        for (var i=0; i<data.length; ++i) {
            if (data[i].user == null)
                continue;
            if (data[i].user.id_gender == selected_option)
                filtered.push(data[i]);
        }
    }

    return filtered;
}

function filterByYear(data) {

    var selected_option = $('#cboYear').val();
    if (selected_option == 0)
        return data;

    var filtered = [];

    for (var i=0; i<data.length; ++i) {
        var d = new Date(data[i].fecha);
        var year = d.getFullYear();
        if (year == selected_option)
            filtered.push(data[i]);
    }

    return filtered;
}

function filterByMonth(data) {
    var selected_option = $('#cboMonth').val();
    if (selected_option == 13)
        return data;

    var filtered = [];

    for (var i=0; i<data.length; ++i) {
        var d = new Date(data[i].fecha);
        var month = d.getMonth();
        if (month == selected_option)
            filtered.push(data[i]);
    }
    return filtered;
}

function filterByHour(data) {
    var start = $('#start_hour').val();
    var end = $('#end_hour').val();
    if (start == '' || end == '')
        return data;

    var filtered = [];

    for (var i=0; i<data.length; ++i) {
        var d = new Date(data[i].fecha);
        var hour = d.getHours();
        console.log(hour);
        if (hour>= start && hour<=end)
            filtered.push(data[i]);
    }
    return filtered;
}

// Random color
function randomColorFactor() {
    return Math.round(Math.random() * 255);
}
function randomColor(opacity) {
    return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
}

// Graphic configuration
var config;

function setupGraph() {
    // Variables
    var BAR_NAMES = ["Bar 0", "Bar 1", "Bar 2", "Bar 3", "Bar 4", "Bar 5", "Bar 6"];
    var LABELS = ["Datos 1", "Datos 2"];

    config = {
        type: 'bar',
        data: {
            labels: BAR_NAMES,
            datasets: [{
                label: LABELS[0],
                data: [], // [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderDash: [5, 5]
            }, {
                label: LABELS[1],
                data: [] // [45, 89, 20, 91, 26, 65, 30]
            }]
        },
        options: {
            title:{
                display: true,
                text: "DATA MINING"
            },
            animation: {
                duration: 2000
            },
            tooltips: {
                mode: 'label'
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        show: true,
                        labelString: 'Bar'
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        show: true,
                        labelString: 'Value'
                    },
                    ticks: {
                        suggestedMin: 0 // minimum will be 0, unless there is a lower value.
                    }
                }]
            }
        }
    };

    /* $.each(config.data.datasets, function(i, dataset) {
        dataset.borderColor = randomColor(0.4);
        dataset.backgroundColor = randomColor(0.5);
        dataset.pointBorderColor = randomColor(0.7);
        dataset.pointBackgroundColor = randomColor(0.5);
        dataset.pointBorderWidth = 1;
    });*/

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = new Chart(ctx, config);
    };

}
