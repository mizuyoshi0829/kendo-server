<?php
/* Smarty version 3.1.30, created on 2023-10-18 19:21:15
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/referee_edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_652fb19b7d3a54_98446284',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53a11fcd5ed6537f945a2bd3a6e6b9d37d8a0bf0' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/referee_edit.html',
      1 => 1512614699,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_652fb19b7d3a54_98446284 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2>審判編集</h2>
    <br />
    <form action="referee.php?s=<?php echo $_SESSION['p']['series'];?>
" method="post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="confirm">
      <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="2"><h1>審判編集</h1></td>
        </tr>
        <tr>
          <td colspan="2"><h2>審判入力</h2></td>
        </tr>
        <tr>
          <td class="td_left3">審判名</td>
          <td class="td_right">
            <input id="sei" type="text" name="sei" value="<?php echo $_SESSION['p']['sei'];?>
" class="text" placeholder="姓" >
            <input id="mei" type="text" name="mei" value="<?php echo $_SESSION['p']['mei'];?>
" class="text" placeholder="名" >
          </td>
        </tr>

      </table>
      <br />
      <input type="submit" name="cancel" value="中止">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
      <input type="submit" name="exec" value="実行">
<?php }?>
    </form>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
