<?php
	session_start();
	$_SESSION['auth_input'] = array( 'login' => 0 );
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
    <form action="dantai_result.php" method="post" name="f">
      <input type="hidden" name="mode" value="login">
      <p class="login_pass">パスワード：<input type="password" name="pass"></p>
      <input type="submit" name="exec" value="ログイン">
    </form>
    <script>document.f._password.focus();</script>
  </div>
</div>
<div id="footer"></div>
</body>
</html>
