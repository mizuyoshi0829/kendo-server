<?php
/* Smarty version 3.1.30, created on 2023-10-29 08:01:10
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/referee_confirm.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_653d92b61cb142_34899672',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a57ffb40fde4b0cb27ee7093763fab9859a8bbfe' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/referee_confirm.html',
      1 => 1512615370,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_653d92b61cb142_34899672 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2>審判編集</h2>
    <br />
    <form action="referee.php?s=<?php echo $_SESSION['p']['series'];?>
" method="post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="exec">
      <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="2"><h1>審判編集</h1></td>
        </tr>
        <tr>
          <td colspan="2"><h2>審判入力</h2></td>
        </tr>
        <tr>
          <td class="td_left3">審判名</td>
          <td class="td_right"><?php echo $_SESSION['p']['sei'];?>
&nbsp;<?php echo $_SESSION['p']['mei'];?>
</td>
        </tr>
      </table>
      <br />
      <input type="submit" name="cancel" value="再編集">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
      <input type="submit" name="exec" value="登録">
<?php }?>
    </form>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
