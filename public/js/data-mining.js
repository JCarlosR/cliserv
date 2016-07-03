$(document).ready(function() {
    $('select').material_select();

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'dd/mm/yyyy'
    });

    $('#btnGO').on('click', mainFunction);
});

function mainFunction() {
    $.getJSON('../clicks/all', function (data) {

        var filtered_data = filterByDeviceType(data);
        filtered_data = filterByCountry(filtered_data);
        console.log(filtered_data);
    });
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
    if (selected_option==0)
        return data;

    var country;
    country = selected_option;

    var filtered = [];
    for (var i=0; i<data.length; ++i) {
        if (data[i].country == country)
            filtered.push(data[i]);
    }

    return filtered;
}