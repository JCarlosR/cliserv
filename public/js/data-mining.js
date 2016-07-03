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

});

var full_data;
var $source_filter;
var $category_filter;

function loadCategoriesSource(data) {
    var categories = [];
    for (var i=0; i<data.length; ++i) {
        if (convertCategory(data[i].url) != '')
            categories.push(convertCategory(data[i].referencia));
    }
    //console.log(categories);
    var uniqueCategories = [];
    $.each(categories, function(i, el){
        if($.inArray(el, uniqueCategories) === -1) uniqueCategories.push(el);
    });
    //console.log(uniqueCategories);
    $category_filter.append('<option value="0">Todos</option>');
    for (var j=0; j<uniqueCategories.length; ++j) {
        if (uniqueCategories[j] != '')
            $category_filter.append('<option value="'+uniqueCategories[j]+'">'+uniqueCategories[j]+'</option>');
    }
    $category_filter.material_select();
}

function loadUrlsSource(data) {
    var urls = [];
    for (var i=0; i<data.length; ++i) {
        if (convertUrl(data[i].referencia) != 'cliserv.esy.es')
            urls.push(convertUrl(data[i].referencia));
    }
    var uniqueUrls = [];
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

    if (url_convert.indexOf('/')==-1)
        return url_convert;
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
    var filtered_data = filterByDeviceType(full_data);
    //console.log(filtered_data);
    filtered_data = filterByUrlSource(filtered_data);
    //console.log(filtered_data);
    filtered_data = filterByCategory(filtered_data);
    //console.log(filtered_data);
    if ( $('ul.tabs a[href="#tab3"]').hasClass('active') ) {
        filtered_data = filterByDayName(filtered_data);
    }
    //console.log(filtered_data);
    filtered_data = filterByCountry(filtered_data);
    //console.log(filtered_data);
    if ( $('ul.tabs a[href="#tab2"]').hasClass('active') ) {
        filtered_data = filterByRangeDate(filtered_data);
    }
    console.log(filtered_data);
    filtered_data = filterByGenre(filtered_data);
    console.log(filtered_data);
    filtered_data = filterByYear(filtered_data);
    console.log(filtered_data);
    filtered_data = filterByMonth(filtered_data);
    console.log(filtered_data);
    filtered_data = filterByHour(filtered_data);
    console.log(filtered_data);
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