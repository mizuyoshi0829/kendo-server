<?php
/* Smarty version 3.1.30, created on 2024-10-04 14:43:12
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/dantai_league.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_66ff807077de26_66461064',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b09caafd01d09ec2af0cd04ef25c7df8600d2b8c' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/dantai_league.html',
      1 => 1728018889,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66ff807077de26_66461064 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/keioffice/i-kendo.net/public_html/kendo/admin/Smarty/plugins/function.html_options.php';
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php if ($_smarty_tpl->tpl_vars['mw']->value == 'm') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'] == '') {?>
    <h2>団体(男子)リーグ</h2>
  <?php } else { ?>
    <h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
リーグ</h2>
  <?php }
}
if ($_smarty_tpl->tpl_vars['mw']->value == 'w') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'] == '') {?>
    <h2>団体(女子)リーグ</h2>
  <?php } else { ?>
    <h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
リーグ</h2>
  <?php }
}?>
      <div style="float: right;">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
      <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post" enctype="multipart/form-data">
        <input name="csv_file" type="file" value="" />
        <input type="hidden" name="mode" value="loadcsv" />
        <input type="submit" name="submit" value="csvデータ読み込み" />
      </form>
<?php } else { ?>
        <input name="csv_file" type="file" value="" />
        <input type="button" name="submit" value="csvデータ読み込み" />
<?php }?>
      </div>
    </h2>

<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['enable_clear'] == 1 && $_smarty_tpl->tpl_vars['seriesinfo']->value['enable_clear_dl'] == 1) {?>
    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="clear" />
      <input type="hidden" name="category" value="<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" />
      <input type="submit" name="submit" value="試合データクリア" />
    </form>
<?php }?>

    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output" />
      <input type="hidden" name="category" value="<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" />
      <input type="submit" name="submit" value="PDFファイル出力" />
    </form>
    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output_excel_chart" />
      <input type="submit" name="submit" value="リーグ成績表excel出力" />
    </form>
    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output_excel_result" />
      <input type="submit" name="submit" value="対戦詳細結果excel出力" />
    </form>
    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="update_result" />
      <input type="submit" name="submit" value="リザルト更新" />
    </form>
<?php if ($_SESSION['auth']['locked'] == 0) {?>
    <form action="dantai_league.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['mw']->value;?>
" method="post">
<?php }
$__section_league_data_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data'] : false;
$__section_league_data_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_league_data_0_total = $__section_league_data_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_league_data'] = new Smarty_Variable(array());
if ($__section_league_data_0_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] <= $__section_league_data_0_total; $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']++){
?>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="td_right2">
          <?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['name'];?>

        </td>
        <td class="td_right2">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
            <input type="hidden" name="mode" value="update">
            <input type="submit" name="edit" value="データ更新">
<?php } else { ?>
            <input type="button" name="edit" value="データ更新">
<?php }?>
        </td>
        <td class="td_right2" colspan="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num']+5;?>
">&nbsp;</td>
      </tr>
      <tr>
        <td class="td_right">対戦学校</td>
        <td class="td_right" colspan="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num'];?>
">試合
        <td class="td_right" rowspan="2">得点</td>
        <td class="td_right" rowspan="2">勝者数</td>
        <td class="td_right" rowspan="2">勝本数</td>
        <td class="td_right" rowspan="2">順位</td>
        <td class="td_right" rowspan="2"><input type="checkbox" name="extra_match_exists_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] : null);?>
" value="1" <?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['extra_match_exists'] == '1') {?>checked="checked" <?php }?>/>代表戦</td>
        <td class="td_right" rowspan="2">勝ち上がり</td>
        </td>
      </tr>
      <tr>
        <td class="td_right">----</td>
<?php
$__section_dantai_index_row_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] : false;
$__section_dantai_index_row_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num']) ? count($_loop) : max(0, (int) $_loop));
$__section_dantai_index_row_1_start = min(0, $__section_dantai_index_row_1_loop);
$__section_dantai_index_row_1_total = min(($__section_dantai_index_row_1_loop - $__section_dantai_index_row_1_start), $__section_dantai_index_row_1_loop);
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] = new Smarty_Variable(array());
if ($__section_dantai_index_row_1_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] = $__section_dantai_index_row_1_start; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] <= $__section_dantai_index_row_1_total; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']++){
?>
        <td class="td_right">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['entry_list']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['team'] == $_smarty_tpl->tpl_vars['k']->value) {
echo $_smarty_tpl->tpl_vars['v']->value;
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </td>
<?php
}
}
if ($__section_dantai_index_row_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] = $__section_dantai_index_row_1_saved;
}
?>
      </tr>
<?php $_smarty_tpl->_assignInScope('match_no', 1);
$_smarty_tpl->_assignInScope('match_no_index', 0);
$__section_dantai_index_row_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] : false;
$__section_dantai_index_row_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num']) ? count($_loop) : max(0, (int) $_loop));
$__section_dantai_index_row_2_start = min(0, $__section_dantai_index_row_2_loop);
$__section_dantai_index_row_2_total = min(($__section_dantai_index_row_2_loop - $__section_dantai_index_row_2_start), $__section_dantai_index_row_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] = new Smarty_Variable(array());
if ($__section_dantai_index_row_2_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] = $__section_dantai_index_row_2_start; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] <= $__section_dantai_index_row_2_total; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']++){
?>
      <tr>
        <td class="td_right">
          <?php echo smarty_function_html_options(array('name'=>"entry_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] : null))."_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] : null)),'options'=>$_smarty_tpl->tpl_vars['entry_list']->value,'selected'=>$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['team']),$_smarty_tpl);?>

        </td>
<?php
$__section_dantai_index_col_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col'] : false;
$__section_dantai_index_col_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num']) ? count($_loop) : max(0, (int) $_loop));
$__section_dantai_index_col_3_start = min(0, $__section_dantai_index_col_3_loop);
$__section_dantai_index_col_3_total = min(($__section_dantai_index_col_3_loop - $__section_dantai_index_col_3_start), $__section_dantai_index_col_3_loop);
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col'] = new Smarty_Variable(array());
if ($__section_dantai_index_col_3_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['index'] = $__section_dantai_index_col_3_start; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration'] <= $__section_dantai_index_col_3_total; $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['index']++){
if ((isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] : null) == (isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration'] : null)) {?>
        <td class="td_right">----</td>
<?php } elseif ((isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] : null) < (isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col']->value['iteration'] : null)) {?>
        <td class="td_right">
          <?php echo smarty_function_html_options(array('name'=>"place_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['match_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_array']->value,'selected'=>$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place']),$_smarty_tpl);?>

          <?php echo smarty_function_html_options(array('name'=>"place_match_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['match_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_match_no_array']->value,'selected'=>$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place_match_no']),$_smarty_tpl);?>

<?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place'] > 0 && $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place_match_no'] > 0) {?>
          <a href="../input/dantai_result.php?a=1&p=<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place'];?>
&m=<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place_match_no'];?>
&lg=1&v=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['navi_id'];?>
"><?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['winner'] == 1) {?>○<?php } elseif ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['winner'] == 2) {?>△<?php } else { ?>□<?php }?></a>
          &nbsp;<a href="/kendo/result/<?php ob_start();
echo $_SESSION['auth']['result_path_prefix'];
$_prefixVariable1=ob_get_clean();
echo $_prefixVariable1;?>
/pdf/match<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['match'];?>
.pdf" target="_blank">PDF</a>
<?php }?>
        </td>
<?php $_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['match_no']->value+1);
$_smarty_tpl->_assignInScope('match_no_index', $_smarty_tpl->tpl_vars['match_no_index']->value+1);
} else { ?>
        <td class="td_right"></td>
<?php }
}
}
if ($__section_dantai_index_col_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_col'] = $__section_dantai_index_col_3_saved;
}
?>
        <td class="td_right"> <?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['point']/2;?>
</td>
        <td class="td_right"> <?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['win'];?>
</td>
        <td class="td_right"> <?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['hon'];?>
</td>
        <td class="td_right" <?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['advanced'] == 1) {?>bgcolor="#ffbbbb"<?php }?>><?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['standing'];?>
</td>
<?php if ((isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] : null) == 1) {?>
        <td class="td_right" rowspan="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num'];?>
">
<?php $_smarty_tpl->_assignInScope('extra_no_index', $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match_num']);
$__section_extra_index_4_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_extra_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_extra_index'] : false;
$__section_extra_index_4_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['extra_match_num']) ? count($_loop) : max(0, (int) $_loop));
$__section_extra_index_4_start = min(0, $__section_extra_index_4_loop);
$__section_extra_index_4_total = min(($__section_extra_index_4_loop - $__section_extra_index_4_start), $__section_extra_index_4_loop);
$_smarty_tpl->tpl_vars['__smarty_section_extra_index'] = new Smarty_Variable(array());
if ($__section_extra_index_4_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['index'] = $__section_extra_index_4_start; $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration'] <= $__section_extra_index_4_total; $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['index']++){
?>
            <a href="../input/dantai_result2.php?a=1&p=1&m=<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration'] : null)+$_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['id']*1000;?>
&lg=1&v=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['navi_id'];?>
"><?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_extra_index']->value['iteration'] : null);?>
</a><br />
<?php $_smarty_tpl->_assignInScope('extra_no_index', $_smarty_tpl->tpl_vars['extra_no_index']->value+1);
}
}
if ($__section_extra_index_4_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_extra_index'] = $__section_extra_index_4_saved;
}
?>
        </td>
<?php }?>
        <td class="td_right"><input type="checkbox" name="advanced_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['iteration'] : null);?>
_<?php echo (isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['iteration'] : null);?>
" value="1" <?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['real_advanced'] == '1') {?>checked="checked" <?php }?>/></td>
      </tr>
<?php
}
}
if ($__section_dantai_index_row_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] = $__section_dantai_index_row_2_saved;
}
?>
      <tr>
        <td class="td_right" colspan="7">&nbsp;</td>
      </tr>
    </table>
<?php
}
}
if ($__section_league_data_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_league_data'] = $__section_league_data_0_saved;
}
if ($_SESSION['auth']['locked'] == 0) {?>
    </form>
<?php }?>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
