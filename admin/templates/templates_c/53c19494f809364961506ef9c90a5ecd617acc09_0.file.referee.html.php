<?php
/* Smarty version 3.1.30, created on 2025-10-13 15:36:14
  from "/var/www/html/admin/templates/templates/admin/referee.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_68ed1c6ef20117_86735495',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53c19494f809364961506ef9c90a5ecd617acc09' => 
    array (
      0 => '/var/www/html/admin/templates/templates/admin/referee.html',
      1 => 1512619256,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68ed1c6ef20117_86735495 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2>審判登録
      <div style="float: right;">
<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['input_entry_csv'] == 1) {
if ($_SESSION['auth']['locked'] == 0) {?>
      <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post" enctype="multipart/form-data">
        <input name="csv_file" type="file" value="" />
        <input type="hidden" name="mode" value="loadcsv" />
        <input type="submit" name="submit" value="csvデータ読み込み" />
      </form>
<?php } else { ?>
        <input name="csv_file" type="file" value="" />
        <input type="button" name="submit" value="csvデータ読み込み" />
<?php }
}?>
      </div>
    </h2>
    <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="new" />
      <input type="submit" name="submit" value="新規登録" />
    </form>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="td_right2">ID</td>
        <td class="td_right">名前</td>
<?php if ($_SESSION['auth']['level'] == 2) {?>
        <td class="td_right2">編集</td>
        <td class="td_right2">削除</td>
<?php }
if ($_SESSION['auth']['level'] == 1) {?>
        <td class="td_right2">表示</td>
<?php }?>
      </tr>
<?php
$__section_datalist_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist'] : false;
$__section_datalist_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_datalist_0_total = $__section_datalist_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = new Smarty_Variable(array());
if ($__section_datalist_0_total != 0) {
for ($__section_datalist_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] = 0; $__section_datalist_0_iteration <= $__section_datalist_0_total; $__section_datalist_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']++){
?>
      <tr>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
</td>
        <td class="td_right" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['mei'], ENT_QUOTES, 'UTF-8', true);?>
</td>

<?php if ($_SESSION['auth']['level'] == 1) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
          <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
          <form action="referee.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
">
            <input type="hidden" name="mode" value="display">
            <input type="submit" name="edit" value="内容表示">
          </form>
        </td>
<?php }
if ($_SESSION['auth']['level'] == 2) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
          <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
">
            <input type="hidden" name="mode" value="edit">
            <input type="submit" name="edit" value="編集">
          </form>
        </td>
 <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>
        <td class="td_right2" bgcolor="#ffbbbb">
  <?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            削除済み
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
">
            <input type="hidden" name="mode" value="undelete">
            <input type="submit" name="submit" value="削除取り消し">
          </form>
  <?php } else { ?>
            <input type="button" name="submit" value="削除取り消し">
  <?php }?>
        </td>
 <?php } else { ?>
        <td class="td_right">
  <?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="referee.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
">
            <input type="hidden" name="mode" value="delete">
            <input type="submit" name="submit" value="削除">
          </form>
  <?php } else { ?>
            <input type="button" name="submit" value="削除">
  <?php }?>
        </td>
 <?php }
}?>
      </tr>
<?php
}
}
if ($__section_datalist_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = $__section_datalist_0_saved;
}
?>

    </table>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
