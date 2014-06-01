$(function() {
	$('.role-button').click(function(){
		$('.role-button').removeClass('active');
		$(this).addClass('active');
		var rolevalue = $(this).attr('value');
		$('#role').val(rolevalue)
	});
});

$(function(){
	var role = $('#role').attr('value');

	if( role == 1)
	{
		$('.role-button').removeClass('active');
		$('.role-button-hallinnoitsija').addClass('active');
	}

	else {
		$('.role-button').removeClass('active');
		$('.role-button-hyllyttaja').addClass('active');
	}

});