$(document).on('ready', principal);

function principal()
{
	datepicker("#finicio");
	datepicker("#ffinal");

	$('#finicio').val( today_date(new Date()) );
	$('#ffinal' ).val( today_date(new Date()) );

	$('#form').on('submit',function()
	{
		event.preventDefault();
		var inicio = $('#finicio').val();
		var fin    = $('#ffinal').val();
		if( fin>=inicio)
		{
			$('.data').html('');

			$.getJSON('../public/general/'+inicio+'/'+fin,function(data){
				var users   = [];
				var products = [];
				var devices  = [];
				var places   = [];

				$.each(data.users,function(key,value){
					users.push(value);
				});
				$.each(data.products,function(key,value){
					products.push(value);
				});
				$.each(data.devices,function(key,value){
					devices.push(value);
				});
				$.each(data.places,function(key,value){
					places.push(value);
				});

				for(var i=0;i<users.length;i++)
				{
					$('.data').append(
							'<div class="col s12 m6"><div class="card blue-grey darken-1">'+
							'<div class="card-content white-text">'+
							'<span class="card-title yellow-text text-darken-2">'+users[i]+'</span>'+
							'<div class="card-action">'+
							'<p>Producto:'+products[i]+'</p>'+
							'<p>Dispositivo: '+devices[i]+'</p>'+
							'<p>Procedencia: '+places[i]+'</p>'+
							'</div>'+
							'</div>'+
							'</div></div>'
					);
				}
			});
		}
		else
			alert('La fecha de inicio no puede ser mayor que la fecha final');
	});
}

function datepicker(name)
{
	$(name).pickadate({
	    selectMonths: true,
	    selectYears: 15,
	    format: 'yyyy-mm-dd'
	});
}

function today_date(date)
{
	var day   = date.getDate()<10?('0'+date.getDate()):date.getDate();
	var month = date.getMonth()+1<10?('0'+(date.getMonth()+1)):date.getMonth()+1;
	var year  = date.getFullYear();
	return year+'-'+month+'-'+day;
}