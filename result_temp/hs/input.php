<?php
	require_once dirname(dirname(dirname(__FILE__))).'/admin/common/common.php';
	require_once dirname(dirname(dirname(__FILE__))).'/admin/common/config.php';
	require_once dirname(dirname(dirname(__FILE__))).'/admin/class/page.php';
    define( '__NAVI_ID__', 12 );

    session_start();
    $_SESSION['auth_input'] = array( 'login' => 0 );
    $mode = get_field_string( $_POST, 'mode' );
    if( $mode == 'login' ){
        $pass = get_field_string( $_POST, 'pass' );
        $objPage = new form_page();
        $place = $objPage->login_navi( __NAVI_ID__, $pass );
        if( $place >= 1 ){
            if( isset($_POST['execktw']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt', 'w' );
            } else if( isset($_POST['execktm']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt', 'm' );
            } else if( isset($_POST['execdlw']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dl', 'w' );
            } else if( isset($_POST['execdlm']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dl', 'm' );
            } else if( isset($_POST['execdtsubw']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dtsub', 'w' );
            } else if( isset($_POST['execdtsubm']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dtsub', 'm' );
            } else if( isset($_POST['execdtw']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dt', 'w' );
            } else if( isset($_POST['execdtm']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dt', 'm' );
            } else if( isset($_POST['execktw8']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt8', 'w' );
            } else if( isset($_POST['execktm8']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt8', 'm' );
            } else if( isset($_POST['execktw16']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt16', 'w' );
            } else if( isset($_POST['execktm16']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'kt16', 'm' );
            } else if( isset($_POST['execdtw8']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dt8', 'w' );
            } else if( isset($_POST['execdtm8']) ){
                $navi = $objPage->get_series_place_top_navi_data( __NAVI_ID__, $place, 'dt8', 'm' );
            } else if( isset($_POST['referee']) ){
                $navi = $objPage->get_series_place_navi_data( __NAVI_ID__, 1, 1 );
            } else {
                $navi = $objPage->get_series_place_navi_data( __NAVI_ID__, $place, 1 );
            }
            if( count( $navi ) == 0 ){ exit; }
            $_SESSION['auth_input']['login'] = 1;
        //$_SESSION['auth_input']['series'] = $pv['series'];
            $_SESSION['auth_input']['navi_id'] = __NAVI_ID__;
            $_SESSION['auth_input']['place'] = $navi['place_no'];
            $_SESSION['auth_input']['admin'] = 0;
            $_SESSION['auth_input']['series'] = $navi['series'];
            $_SESSION['auth_input']['series_info_id'] = $navi['series_info_id'];
            $_SESSION['auth'] = array( 'year' => $navi['year'], 'series_info_id' => $navi['series_info_id'] );
            if( isset($_POST['referee']) ){
                header( "Location: ".__HTTP_BASE__."input/input_referee.php?m=1" );
            } else {
                header( "Location: ".__HTTP_BASE__."input/".$navi['script']."?m=".$navi['place_match_no'] );
            }
            exit;
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
      <input type="hidden" name="navi_id" value="1">
      <p class="login_pass">パスワード：<input type="password" name="pass"></p>
      <input type="submit" name="" value="ログイン"><br />
<!--
      <input type="submit" name="execktw" value="個人戦女子"><br />
      <input type="submit" name="execktm" value="個人戦男子"><br />
      <input type="submit" name="execktw8" value="個人戦女子(ベスト8)"><br />
      <input type="submit" name="execktm8" value="個人戦男子(ベスト8)"><br />
      <input type="submit" name="execdlw" value="団体戦女子予選リーグ"><br />
      <input type="submit" name="execdlm" value="団体戦男子予選リーグ"><br />
      <input type="submit" name="execdtw" value="団体戦女子決勝トーナメント"><br />
      <input type="submit" name="execdtm" value="団体戦男子決勝トーナメント"><br />
-->
    </form>
  </div>
</div>
<div id="footer"></div>
</body>
</html>
