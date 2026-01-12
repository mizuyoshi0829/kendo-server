<?php
/* Smarty version 3.1.30, created on 2022-02-15 13:04:39
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_620b26577ce6f6_22884072',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '08a80d0656341c095f3ce13655b311de0700627a' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/login.html',
      1 => 1507555382,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620b26577ce6f6_22884072 (Smarty_Internal_Template $_smarty_tpl) {
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
<title><?php echo $_smarty_tpl->tpl_vars['series_name']->value;?>
エントリー編集フォームログイン</title>
</head>

<body>
<div id="main">
  <form id="form" name="form1" method="post" action="">
    <input type="hidden" name="mode" value="auth" />
    <div class="titlename">
      <h1><?php echo $_smarty_tpl->tpl_vars['series_name']->value;?>
エントリー編集フォームログイン</h1>
    </div>
    <p class="login_pass">ID：<input type="text" name="username"></p>
    <p class="login_pass">パスワード：<input type="password" name="password"></p>
    <input type="submit" name="exec" value="ログイン">
  </form>
  <?php echo '<script'; ?>
>document.form1.password.focus();<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
