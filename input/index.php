<?php
	require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
	require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
	require_once dirname(dirname(__FILE__)).'/admin/common/navi.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_2b.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_3.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_4.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_5.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_6.php';
	require_once dirname(dirname(__FILE__)).'/admin/class/page.php';

	session_start();
	$_SESSION['auth_input'] = array( 'login' => 0 );
	$mode = get_field_string( $_POST, 'mode' );
	if( $mode == 'login' ){
		$pass = get_field_string( $_POST, 'pass' );
		$place = 1;
		foreach( $input_passtbl as $pv ){
			if( $pass == $pv['pass'] ){
				$_SESSION['auth_input']['login'] = 1;
				//$_SESSION['auth_input']['series'] = $pv['series'];
				$_SESSION['auth_input']['place'] = $pv['place'];
				$_SESSION['auth_input']['admin'] = 0;
				if( isset($_POST['exec']) ){
					$_SESSION['auth_input']['series'] = $pv['series'];
					header( "Location: ".__HTTP_BASE__."input/kojin_result.php?m=1"); //.$navi_top[$pv['place']]['kojin_tournament_w'] );
					exit;
				}
			}
		}
	}


	$objPage = new form_page();
	//$objPage->save_tournament_place_navi_data_tbl_file(
	//	7, 8, 7, 8, 9, 10,
	//	8, 'navi.php'
	//);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>結果入力画面</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/global.js"></script>
</head>
<body>
<div id="header">
  結果入力ログイン
</div>
<div id="pagebody">
  <div id="navi">
  </div>
  <div id="main">
    <h2>ログイン</h2>
    <form action="index.php" method="post" name="f">
      <input type="hidden" name="mode" value="login">
      <p class="login_pass">パスワード：<input type="password" name="pass"></p>
      <input type="submit" name="exec" value="入力"><br />
    </form>
  </div>
</div>
<div id="footer"></div>
</body>
</html>
