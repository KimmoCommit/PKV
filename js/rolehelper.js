function RoleHelper()
{
	this.selectRole = new selectRole();
	this.checkRole = new checkRole();
}


function selectRole() {
	$('.role-button').click(function(){
		$('.role-button').removeClass('active');
		$(this).addClass('active');
		var rolevalue = $(this).attr('value');
		$('#role').val(rolevalue)
	});
}


function checkRole(){
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

}
