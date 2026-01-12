var set = 0;
function nido_osi()
{
	if( set == 0 ){
		set = 1;
	} else {
		alert( "処理中です。もうしばらくお待ちください。" );
		return false;
	}
}

function imgSet(field)
{
	var fid = document.getElementById(field);
	fid.src = 'file:///' + document.getElementById(field+'_input').value;
}

function popJump( to, selOBJ)
{
	n = selOBJ.selectedIndex;
	location.href = to + selOBJ.options[n].value;
}

function auto_check( dist )
{
	var fid = document.getElementById(dist);
	fid.checked = true;
}

function auto_check_radio( id )
{
	var fid = document.getElementsByName('isch_' + id);
	if( fid != null ){
		fid[0].checked = false;
		fid[1].checked = true;
	}
}

function imgChange( id )
{
	imgSet(id);
	auto_check_radio(id);
}

function imgPreviewChange()
{
	var fid = document.getElementById('img');
	fid.src = 'file:///' + document.getElementById('_img').value;
}

function submitForm( index, a )
{
	var fid = document.forms[index];
	fid.action = a;
	fid.submit();
}
