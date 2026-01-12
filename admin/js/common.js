/*********************************************************************

  グローバル変数定義

*********************************************************************/

var sendFlag = false;
var editFlag = false;

/*********************************************************************

  入力内容チェック

*********************************************************************/

function checkForm(form)
{
	if (form.subj && !form.subj.value) {
		alert('件名が入力されていません。');
		return false;
	}
	if (form.name && !form.name.value) {
		alert('名前が入力されていません。');
		return false;
	}
	if (form.mail && !form.mail.value) {
		alert('メールアドレスが入力されていません。');
		return false;
	}
	if (form.text && !form.text.value) {
		alert('メッセージが入力されていません。');
		return false;
	}

	if (sendFlag == true) {
		alert('二重送信は禁止です。');
		return false;
	} else {
		sendFlag = true;
	}

	return true;
}

/*********************************************************************

  処理開始

*********************************************************************/

window.onload = function()
{
	var nodeMailForm  = document.getElementById('mail_form');
	var nodeLoginForm = document.getElementById('login_form');

	if (nodeMailForm) {
		//入力内容チェック
		nodeMailForm.onsubmit = function()
		{
			return checkForm(nodeMailForm);
		};
		nodeMailForm.text.onkeyup = function()
		{
			if (!editFlag) {
				editFlag = true;
			}
			return;
		};
	}

	if (nodeLoginForm) {
		//フォーカス設定
		nodeLoginForm.pwd.focus();
	}

	return;
};
window.onbeforeunload = function()
{
	if (!sendFlag && editFlag) {
		return 'ページを移動した場合、編集中のテキストは破棄されます。';
	}

	return;
};

/*********************************************************************/

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

