<?php
    require_once dirname(dirname(dirname(__FILE__))).'/admin/common/common.php';
    require_once dirname(dirname(dirname(__FILE__))).'/admin/common/config.php';
    require_once dirname(dirname(dirname(__FILE__))).'/admin/class/admin/reg_s5d.php';
    require_once dirname(dirname(dirname(__FILE__))).'/admin/class/admin/reg_s5k.php';
    require_once dirname(dirname(dirname(__FILE__))).'/admin/class/page.php';
    define( '__NAVI_ID__', 10 );

    session_start();
    $_SESSION['auth_input'] = array( 'login' => 0 );
    $mode = get_field_string( $_POST, 'mode' );
    if( $mode == 'login' ){
        $pass = get_field_string( $_POST, 'pass' );
        $objPage = new form_page();
        $place = $objPage->login_navi( __NAVI_ID__, $pass );
        if( $place >= 1 ){
            $navi = $objPage->get_series_place_navi_data( __NAVI_ID__, $place, 1 );
            $_SESSION['auth_input']['login'] = 1;
        //$_SESSION['auth_input']['series'] = $pv['series'];
            $_SESSION['auth_input']['navi_id'] = __NAVI_ID__;
            $_SESSION['auth_input']['place'] = $navi['place_no'];
            $_SESSION['auth_input']['admin'] = 0;
            $_SESSION['auth'] = array( 'year' => $navi['year'] );
            if( isset($_POST['exec']) ){
                $_SESSION['auth_input']['series'] = $navi['series'];
                $_SESSION['auth_input']['series_info_id'] = $navi['series_info_id'];
                header( "Location: ".__HTTP_BASE__."input/".$navi['script']."?m=1" ); //.$navi_top[$pv['place']]['kojin_tournament_w'] );
                exit;
            }

        }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title>結果入力画面</title>
<link href="/kendo/input/css/style.css" rel="stylesheet" type="text/css" />
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
    <form action="input.php" method="post" name="f">
      <input type="hidden" name="mode" value="login">
      <input type="hidden" name="navi_id" value="<?php echo __NAVI_ID__; ?>">
      <p class="login_pass">パスワード：<input type="password" name="pass"></p>
      <input type="submit" name="exec" value="入力"><br />
    </form>
  </div>
</div>
<div id="footer"></div>
</body>
</html>
