<?php
/* Smarty version 3.1.30, created on 2023-07-07 22:58:01
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mpdf.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_64a819e97a6af1_72100802',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bf1106ff3f71e89f00d6f5aee6fc1d4e05df15ef' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mpdf.html',
      1 => 1688738178,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64a819e97a6af1_72100802 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
<meta name="viewport"
content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link media="only screen and (max-device-width:480px)" href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/mobile.css" type="text/css" rel="stylesheet" />
<link media="screen and (min-device-width:481px)" href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/style.css" type="text/css" rel="stylesheet" />
<!--[if IE]>
<link href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
design.css" type="text/css" rel="stylesheet" />
<![endif]-->
<meta charset="UTF-8">
<title>入力フォーム</title>
</head>
<body>
<div id="main">
  <div id="actindicator"><img src="../img/466.gif" width="48" height="48" alt="Loading..." /></div>
  <div id="actindicator_fade"></div>
  <form id="form_entry" name="form1" method="post" action="">
    申込書をダウンロードします。<br /><br />
    <input name="mode" type="hidden" value="pdf" />
    <input name="info_id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['info_id']->value;?>
" />
    <input name="pdf_file_name" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['pdf_file_name']->value;?>
" />
    <div class="button">
      <input name="exec" type="submit" value="ダウンロード">
    </div>
  </form>
</div>
</body>
</html>
<?php }
}
