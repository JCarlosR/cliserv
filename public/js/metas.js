$(document).on('ready', principal);

function principal()
{
	$('#form').on('submit',function()
	{
		event.preventDefault();
		var grade = $('#grade').val();
		var phone = $('#phone').val();

		if(!grade){
			alert('Ingrese la meta');
			return;
		}
		if(!phone){
			alert('Ingrese número de celular');
			return;
		}

		$.ajax({
			url:'../public/get_metas/'+grade+'/'+phone,
			method: 'get'
		}).done(function(data){
			if(!data.error)
			{
				alert(data.message);
				setTimeout(function(){
					location.reload();
				}, 2000);
			}
		});

	});
}
