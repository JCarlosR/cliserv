$(document).on('ready', principal);

var $modal;

function principal()
{
    $modal = $('#modal');

    $('#product').on('click', mostrarProducto);
    $('#category').on('click', mostrarCategoria);
}

function mostrarProducto() {

    event.preventDefault();

    $.ajax({
            url: 'tendencia/producto/usuarios',
            dataType: "JSON",
            method: 'GET'
    })
     .done( function(data){
        if( data.error )
            alert('No existen datos');
        else {

            var name = []; var location = []; var gender = []; var email = []; var visits = [];

            $.each(data.name,function(key,value) { name.push(value); });
            $.each(data.location,function(key,value) { location.push(value); });
            $.each(data.gender,function(key,value) { gender.push(value); });
            $.each(data.email,function(key,value) { email.push(value); });
            $.each(data.visits,function(key,value) { visits.push(value); });

            $('#data').html('');

            for( var i=0; i< name.length; i++ )
            {
                $('#data').append('<tr>' + '<td>'+name[i]+'</td>'+
                                           '<td>'+location[i]+'</td>'+
                                           '<td>'+gender[i]+'</td>'+
                                           '<td>'+email[i]+'</td>'+
                                           '<td>'+visits[i]+'</td>'+
                    '</tr>');
            }
            $modal.openModal();
        }
    });
}
function mostrarCategoria() {

    event.preventDefault();

    $.ajax({
            url: 'tendencia/categorias/usuarios',
            dataType: "JSON",
            method: 'GET'
        })
        .done( function(data){
            if( data.error )
                alert('No existen datos');
            else {

                var name = []; var location = []; var gender = []; var email = []; var visits = [];

                $.each(data.name,function(key,value) { name.push(value); });
                $.each(data.location,function(key,value) { location.push(value); });
                $.each(data.gender,function(key,value) { gender.push(value); });
                $.each(data.email,function(key,value) { email.push(value); });
                $.each(data.visits,function(key,value) { visits.push(value); });

                $('#data').html('');

                for( var i=0; i< name.length; i++ )
                {
                    $('#data').append('<tr>' + '<td>'+name[i]+'</td>'+
                        '<td>'+location[i]+'</td>'+
                        '<td>'+gender[i]+'</td>'+
                        '<td>'+email[i]+'</td>'+
                        '<td>'+visits[i]+'</td>'+
                        '</tr>');
                }
                $modal.openModal();
            }
        });
}