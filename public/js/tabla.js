$(document).on('ready', principal);

function principal()
{
	datepicker("#finicio");
	datepicker("#ffinal");
	
	$('#finicio').val( today_date(new Date())    );
	$('#ffinal' ).val( tomorrow_date(new Date()) );
	
	show_cards( today_date(new Date()), tomorrow_date(new Date()) );

	$('form').on('submit', function(event) {
		event.preventDefault();

		var finicio = $('#finicio').val();
		var ffinal  = $('#ffinal').val();
		show_cards( finicio, ffinal );
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

function tomorrow_date(date)
{
	date.setDate(date.getDate()+1);
	return today_date( date );
}

function show_cards(start_date,end_date) 
{
	$('.data').html('');

	$.getJSON('../public/general/'+start_date+'/'+end_date,function(data){
        $.each(data,function(key,value)
        {
            $('.data').append(
            	'<div class="col s12 m6"><div class="card blue-grey darken-1">'+
					'<div class="card-content white-text">'+
						'<span class="card-title yellow-text text-darken-2">'+value.user_name+'</span>'+
							'<div class="card-action">'+
								'<p>Coordenada en X: ' + value.coordX +'</p>'+
		              			 '<p>Coordenada en Y: '+ value.coordY +'</p>'+
		              			 '<p>Url: '+value.url+'</p>'+
		              		'</div>'+
					'</div>'+
				'</div></div>'
            );
        });
	});
}