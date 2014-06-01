function RoleHelper()
{
	this.selectRole = new selectRole();
	this.checkRole = new checkRole();
	this.checkRoleValue = new checkRoleValue();
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

	else if ( role == 0 ) {
		$('.role-button').removeClass('active');
		$('.role-button-hyllyttaja').addClass('active');
	} 

}

function checkRoleValue(){
	$('.role-value').each(function(){
		var role = $(this).html();
		if(role == 1)
		{
			$(this).html("Hallinnoitsija");
		}
		else if(role == 0){
			$(this).html("Hyllyttäjä");
		}
	})
}

