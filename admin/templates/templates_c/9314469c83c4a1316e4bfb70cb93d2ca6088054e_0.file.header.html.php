<?php
/* Smarty version 3.1.30, created on 2025-06-17 15:28:01
  from "/var/www/html/admin/templates/templates/admin/header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_685189817745a6_58321346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9314469c83c4a1316e4bfb70cb93d2ca6088054e' => 
    array (
      0 => '/var/www/html/admin/templates/templates/admin/header.html',
      1 => 1728010306,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_685189817745a6_58321346 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<title><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['name'];?>
 管理画面</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/actindicator.css" rel="stylesheet" type="text/css" />
<link href="css/cropper.css" rel="stylesheet">
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-3.0.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/cropper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/global.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/actindicator.js"><?php echo '</script'; ?>
>
</head>
<body>
<div id="actindicator"><img src="js/images/712.gif" width="64" height="64" alt="Loading..." /></div>
<div id="actindicator_fade"></div>
<div id="header">
  <?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['name'];?>
管理画面
</div>
<div id="pagebody">
<?php if ($_smarty_tpl->tpl_vars['display_navi']->value == 1) {?>
  <div id="navi">
 <?php if ($_SESSION['auth']['series'] == 5 || $_SESSION['auth']['series'] == 6) {?>
    <p><a href="info.php?s=5">男子エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=5&mw=m">団体(男子)リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=5&mw=m">団体(男子)トーナメント</a></p>
    <p><a href="info.php?s=6">女子エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=6&mw=w">団体(女子)リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=6&mw=w">団体(女子)トーナメント</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 7 || $_SESSION['auth']['series'] == 8 || $_SESSION['auth']['series'] == 9 || $_SESSION['auth']['series'] == 10) {?>
    <p><a href="info.php?s=7">男子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=7&mw=m">男子団体リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=7&mw=m">男子団体トーナメント</a></p>
    <p><a href="info.php?s=9">男子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=9&mw=m">男子個人トーナメント</a></p>
    <p><a href="info.php?s=8">女子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=8&mw=w">女子団体リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=8&mw=w">女子団体トーナメント</a></p>
    <p><a href="info.php?s=10">女子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=10&mw=w">女子個人トーナメント</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 11 || $_SESSION['auth']['series'] == 65) {?>
    <p><a href="info.php?s=65">男子エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=65&mw=m">男子トーナメント</a></p>
    <p><a href="referee.php?s=65">男子審判登録</a></p>
    <p><a href="info.php?s=11">女子エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=11&mw=w">女子トーナメント</a></p>
    <p><a href="referee.php?s=11">女子審判登録</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 12 || $_SESSION['auth']['series'] == 13 || $_SESSION['auth']['series'] == 14 || $_SESSION['auth']['series'] == 15) {?>
    <p><a href="info.php?s=12">男子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=12&mw=m">男子団体リーグ戦</a></p>
    <p><a href="info.php?s=14">男子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=14&mw=m">男子個人トーナメント</a></p>
    <p><a href="info.php?s=13">女子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=13&mw=w">女子団体リーグ戦</a></p>
    <p><a href="info.php?s=15">女子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=15&mw=w">女子個人トーナメント</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 16 || $_SESSION['auth']['series'] == 17 || $_SESSION['auth']['series'] == 18 || $_SESSION['auth']['series'] == 19) {?>
    <p><a href="info.php?s=16">男子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=16&mw=m">男子団体リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=16&mw=m">男子団体トーナメント</a></p>
    <p><a href="info.php?s=18">男子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=18&mw=m">男子個人トーナメント</a></p>
    <p><a href="info.php?s=17">女子団体エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=17&mw=w">女子団体リーグ戦</a></p>
    <p><a href="dantai_tournament.php?s=17&mw=w">女子団体トーナメント</a></p>
    <p><a href="info.php?s=19">女子個人エントリー一覧</a></p>
    <p><a href="kojin_tournament.php?s=19&mw=w">女子個人トーナメント</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 2) {?>
    <p><a href="info.php?s=2">エントリー一覧</a></p>
    <p><a href="dantai_tournament.php?s=2&mw=m">男子団体トーナメント</a></p>
    <p><a href="dantai_tournament.php?s=2&mw=w">女子団体トーナメント</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] == 3) {?>
    <p><a href="info.php?s=3">小学校エントリー一覧</a></p>
    <p><a href="dantai_league.php?s=3&mw=m">リーグ</a></p>
    <p><a href="dantai_tournament.php?s=3&mw=m">トーナメント</a></p>
    <p><a href="dantai_league.php?s=3&mw=w">決勝リーグ</a></p>
 <?php }?>
 <?php if ($_SESSION['auth']['series'] >= 20 && $_SESSION['auth']['series'] != 65) {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'] != 0 || $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'] != 0) {?>
    <p><a href="info.php?s=<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'] != 0) {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'];
} else {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'];
}?>"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
エントリー一覧</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'] != 0) {?>
    <p><a href="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'];?>
&mw=m"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
リーグ戦</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'] != 0) {?>
    <p><a href="dantai_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'];?>
&mw=m"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
トーナメント</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_m'] != 0 || $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_m'] != 0) {?>
    <p><a href="info.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_m'];?>
"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_m_name'];?>
エントリー一覧</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_m'] != 0) {?>
    <p><a href="kojin_league.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_m'];?>
&mw=m"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_m_name'];?>
リーグ戦</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_m'] != 0) {?>
    <p><a href="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_m'];?>
&mw=m"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_m_name'];?>
トーナメント</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_w'] != 0 || $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_w'] != 0) {?>
    <p><a href="info.php?s=<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_w'] != 0) {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_w'];
} else {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_w'];
}?>"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
エントリー一覧</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_w'] != 0) {?>
    <p><a href="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_w'];?>
&mw=w"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
リーグ戦</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_w'] != 0) {?>
    <p><a href="dantai_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_w'];?>
&mw=w"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
トーナメント</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_w'] != 0 || $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_w'] != 0) {?>
    <p><a href="info.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_w'];?>
"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_w_name'];?>
エントリー一覧</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_w'] != 0) {?>
    <p><a href="kojin_league.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_league_w'];?>
&mw=w"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_w_name'];?>
リーグ戦</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_w'] != 0) {?>
    <p><a href="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_tournament_w'];?>
&mw=w"><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['kojin_w_name'];?>
トーナメント</a></p>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['enable_referee'] != 0) {?>
    <p><a href="referee.php?s=<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'] != 0) {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'];
} else {
echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'];
}?>">審判登録</a></p>
  <?php }?>
 <?php }?>


<?php if ($_SESSION['auth']['series'] == 41) {?>
    <p><a href="dantai_league_check_score.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'];?>
&mw=m" target="_blank">スコアーチェック(リーグ戦)</a></p>
    <p><a href="dantai_tournament_check_score.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'];?>
&mw=m" target="_blank">スコアーチェック(トーナメント)</a></p>
    <p><a href="/kendo/result/nenrin/2024/pdf/match_all.pdf" target="_blank">全試合PDFダウンロード</a></p>
<?php }?>
    <p><a href="login.php">ログアウト</a></p>
  </div>
<?php } else { ?>


<?php }?>
  <div id="main">
<?php }
}
