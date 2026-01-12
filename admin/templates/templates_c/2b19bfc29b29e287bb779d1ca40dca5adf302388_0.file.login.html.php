<?php
/* Smarty version 3.1.30, created on 2025-06-17 15:28:01
  from "/var/www/html/admin/templates/templates/admin/login.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_685189817852e7_45991414',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b19bfc29b29e287bb779d1ca40dca5adf302388' => 
    array (
      0 => '/var/www/html/admin/templates/templates/admin/login.html',
      1 => 1504162218,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_685189817852e7_45991414 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2>ログイン</h2>
    <form action="info.php" method="post" name="f">
      <p class="login_pass">パスワード：<input type="password" name="pass"></p>
      <input type="hidden" name="mode" value="auth">
      <input type="submit" name="exec" value="ログイン">
    </form>
    <?php echo '<script'; ?>
>document.f._password.focus();<?php echo '</script'; ?>
>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
