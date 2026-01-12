<?php
/* Smarty version 3.1.30, created on 2023-08-03 02:22:14
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/info.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_64ca90c6192241_71432698',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '60a34e874133add23f123fa781568b3045ad1eda' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/info.html',
      1 => 1690996330,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64ca90c6192241_71432698 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2><?php echo $_smarty_tpl->tpl_vars['category_name']->value;?>
登録情報一覧
      <div style="float: right;">
<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['input_entry_csv'] == 1) {
if ($_SESSION['auth']['locked'] == 0) {?>
      <form action="info.php?s=<?php echo $_SESSION['auth']['series'];?>
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
<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_entry'] == 1) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];?>
&f=entry" method="post">
      <input type="hidden" name="mode" value="" />
      <input type="submit" name="submit" value="参加校だけ表示" />
    </form>
<?php }
if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_entry'] == 2) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];?>
&f=entry_m" method="post">
      <input type="hidden" name="mode" value="" />
      <input type="submit" name="submit" value="男子参加校だけ表示" />
    </form>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];?>
&f=entry_w" method="post">
      <input type="hidden" name="mode" value="" />
      <input type="submit" name="submit" value="女子参加校だけ表示" />
    </form>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_entry_list'] == 1) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output" />
      <input type="submit" name="submit" value="ファイル出力" />
    </form>
<?php }
if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_entry_listall'] == 1) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="outputall" />
      <input type="submit" name="submit" value="全項目ファイル出力" />
    </form>
<?php }
if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_entry_pdf'] == 1) {
if ($_SESSION['auth']['series'] == 58 || $_SESSION['auth']['series'] == 59 || $_SESSION['auth']['series'] == 60 || $_SESSION['auth']['series'] == 61) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_catalog_pdf" />
      <input type="submit" name="submit" value="PDF出力(カタログ)" />
    </form>
<?php if ($_SESSION['auth']['series'] == 58 || $_SESSION['auth']['series'] == 59) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_catalog_pdf2" />
      <input type="submit" name="submit" value="PDF出力(カタログ後半)" />
    </form>
<?php }?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_ID_pdf" />
      <input type="submit" name="submit" value="PDF出力(IDカード)" />
    </form>
<?php } else { ?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_pdf" />
      <input type="submit" name="submit" value="PDF出力" />
    </form>
<?php }
}
if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_draw_csv'] == 1) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_draw_csv" />
      <input type="submit" name="submit" value="抽選用CSV出力" />
    </form>
<?php }
if ($_smarty_tpl->tpl_vars['seriesinfo']->value['output_draw'] == 1) {?>
    <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
      <input type="hidden" name="mode" value="output_draw" />
      <input type="submit" name="submit" value="抽選出力" />
    </form>
<?php }?>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="td_left">&nbsp;</td>
        <td class="td_right2">ID</td>
        <td class="td_right">名前</td>
<?php if ($_SESSION['auth']['series'] == 2) {?>
        <td class="td_right" colspan="2">参加</td>
<?php }
if ($_SESSION['auth']['series'] == 3) {?>
        <td class="td_right2">参加</td>
<?php }
if ($_SESSION['auth']['level'] == 2) {?>
        <td class="td_right" colspan="3">並び替え

<?php echo '<script'; ?>
>
function sort_submit()
{
	var f = document.form_sort;
	var text1;

<?php
$__section_datalist_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist'] : false;
$__section_datalist_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_datalist_0_total = $__section_datalist_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = new Smarty_Variable(array());
if ($__section_datalist_0_total != 0) {
for ($__section_datalist_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] = 0; $__section_datalist_0_iteration <= $__section_datalist_0_total; $__section_datalist_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['last'] = ($__section_datalist_0_iteration == $__section_datalist_0_total);
if ($_smarty_tpl->tpl_vars['filter']->value == '' || ($_smarty_tpl->tpl_vars['filter']->value == 'entry' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join'] == '1') || ($_smarty_tpl->tpl_vars['filter']->value == 'entry_m' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_m'] == '1') || ($_smarty_tpl->tpl_vars['filter']->value == 'entry_w' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_w'] == '1')) {
if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] != '1') {
if ($_SESSION['auth']['series'] == 3) {
if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join'] == '1') {?>
	text1 = document.createElement("input");
	text1.type = "hidden";
	text1.name = "id_<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
";
	text1.value = document.getElementById("sort<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
").value;
	f.appendChild(text1);
<?php }
} else { ?>
	text1 = document.createElement("input");
	text1.type = "hidden";
	text1.name = "id_<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
";
	text1.value = document.getElementById("sort<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
").value;
	f.appendChild(text1);
<?php }
}
}
}
}
if ($__section_datalist_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = $__section_datalist_0_saved;
}
?>

}
<?php echo '</script'; ?>
>

<?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post" name="form_sort" onSubmit="sort_submit(); return true;">
            <input type="hidden" name="mode" value="sort" />

            <input type="submit" name="submit" value="番号を入力してソート" />
          </form>
<?php } else { ?>
            <input type="button" name="submit" value="番号を入力してソート" />
<?php }?>
        </td>
        <td class="td_right2">編集</td>
        <td class="td_right2">削除</td>
<?php }
if ($_SESSION['auth']['level'] == 1) {?>
        <td class="td_right2">表示</td>
<?php }?>
      </tr>
<?php $_smarty_tpl->_assignInScope('prev_list_index', 0);
$_smarty_tpl->_assignInScope('list_index', 1);
$_smarty_tpl->_assignInScope('list_prev_id', 0);
$__section_datalist_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist'] : false;
$__section_datalist_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_datalist_1_total = $__section_datalist_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = new Smarty_Variable(array());
if ($__section_datalist_1_total != 0) {
for ($__section_datalist_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] = 0; $__section_datalist_1_iteration <= $__section_datalist_1_total; $__section_datalist_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']++){
$_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['last'] = ($__section_datalist_1_iteration == $__section_datalist_1_total);
if ($_smarty_tpl->tpl_vars['filter']->value == '' || ($_smarty_tpl->tpl_vars['filter']->value == 'entry' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join'] == '1') || ($_smarty_tpl->tpl_vars['filter']->value == 'entry_m' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_m'] == '1') || ($_smarty_tpl->tpl_vars['filter']->value == 'entry_w' && $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_w'] == '1')) {?>

<?php if ($_SESSION['auth']['level'] == 2) {
if ($_smarty_tpl->tpl_vars['list_index']->value > 1) {?>

        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
<?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="mode" value="exchange" />
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" />
            <input type="hidden" name="id2" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
" />
            <input type="submit" name="submit" value="↓" />
          </form>
<?php } else { ?>
            <input type="button" name="submit" value="↓" />
<?php }?>
        </td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
<?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>
            &nbsp;
<?php } else { ?>
            <input id="sort<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" type="text" name="sort<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" value="" size="4" />
<?php }?>
        </td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
">
            <input type="hidden" name="mode" value="edit">
            <input type="submit" name="edit" value="編集">
          </form>
        </td>
<?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>
        <td class="td_right2" bgcolor="#ffbbbb">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            削除済み
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
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
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
">
            <input type="hidden" name="mode" value="delete">
            <input type="submit" name="submit" value="削除">
          </form>
<?php } else { ?>
            <input type="button" name="submit" value="削除">
<?php }?>
        </td>
<?php }?>
      </tr>
<?php }?>

<?php }?>

      <tr>
        <td class="td_left" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php echo $_smarty_tpl->tpl_vars['list_index']->value;?>
</td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
</td>
        <td class="td_right" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['school_name_ryaku'] != '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['school_name'], ENT_QUOTES, 'UTF-8', true);
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['school_name'], ENT_QUOTES, 'UTF-8', true);
}?></td>
<?php if ($_SESSION['auth']['series'] == 2) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_m'] == '1') {?>男子<?php } else { ?>&nbsp;<?php }?></td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join_w'] == '1') {?>女子<?php } else { ?>&nbsp;<?php }?></td>
<?php }
if ($_SESSION['auth']['series'] == 3) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>><?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['join'] == '1') {?>参加<?php } else { ?>&nbsp;<?php }?></td>
<?php }
if ($_SESSION['auth']['level'] == 2) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
<?php if ($_smarty_tpl->tpl_vars['list_index']->value > 1) {
if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="mode" value="exchange" />
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
" />
            <input type="hidden" name="id2" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" />
            <input type="submit" name="submit" value="↑" />
          </form>
<?php } else { ?>
            <input type="button" name="submit" value="↑" />
<?php }
}?>
        </td>



<?php }?>

<?php if ($_SESSION['auth']['level'] == 1) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
          <form action="info.php" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id'];?>
">
            <input type="hidden" name="mode" value="display">
            <input type="submit" name="edit" value="内容表示">
          </form>
        </td>
      </tr>
<?php }?>

<?php $_smarty_tpl->_assignInScope('prev_list_index', $_smarty_tpl->tpl_vars['list_index']->value-1);
$_smarty_tpl->_assignInScope('list_index', $_smarty_tpl->tpl_vars['list_index']->value+1);
$_smarty_tpl->_assignInScope('list_prev_id', $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['id']);
}
}
}
if ($__section_datalist_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = $__section_datalist_1_saved;
}
?>

<?php if ($_SESSION['auth']['level'] == 2) {
if ($_smarty_tpl->tpl_vars['list_index']->value > 1) {?>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
        </td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
<?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index'] : null)]['del'] == '1') {?>
            &nbsp;
<?php } else { ?>
            <input id="sort<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" type="text" name="sort<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
" value="" size="4" />
<?php }?>
        </td>
        <td class="td_right2" <?php if ($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_prev_list_index']->value['index'] : null)]['del'] == '1') {?>bgcolor="#ffbbbb"<?php }?>>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
">
            <input type="hidden" name="mode" value="edit">
            <input type="submit" name="edit" value="編集">
          </form>
        </td>
<?php if ($_smarty_tpl->tpl_vars['list']->value[$_smarty_tpl->tpl_vars['prev_list_index']->value]['del'] == '1') {?>
        <td class="td_right2" bgcolor="#ffbbbb">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            削除済み
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
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
          <form action="info.php?s=<?php echo $_SESSION['auth']['series'];
if ($_smarty_tpl->tpl_vars['filter']->value != '') {?>&f=<?php echo $_smarty_tpl->tpl_vars['filter']->value;
}?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['list_prev_id']->value;?>
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
<?php }?>

    </table>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
