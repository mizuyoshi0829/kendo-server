<?php
/* Smarty version 3.1.30, created on 2022-10-07 15:14:11
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/kojin_tournament.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_633fc3b356cd28_50648583',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '292e2239c92c62c7b4a5d5c47dcc1252498b5fc9' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/kojin_tournament.html',
      1 => 1665121917,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633fc3b356cd28_50648583 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/home/keioffice/i-kendo.net/public_html/kendo/admin/Smarty/plugins/function.html_options.php';
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2>個人(<?php if ($_smarty_tpl->tpl_vars['series_mw']->value == 'm') {?>男子<?php }
if ($_smarty_tpl->tpl_vars['series_mw']->value == 'w') {?>女子<?php }?>)トーナメント
      <div style="float: right;">
      <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post" enctype="multipart/form-data">
        <input name="csv_file" type="file" value="" />
        <input type="hidden" name="mode" value="loadcsv" />
        <input type="submit" name="submit" value="csvデータ読み込み" />
      </form></div>
    </h2>

<?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['enable_clear'] == 1 && $_smarty_tpl->tpl_vars['seriesinfo']->value['enable_clear_kt'] == 1) {?>
    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="clear" />
      <input type="submit" name="submit" value="試合データクリア" />
    </form>
<?php }?>

    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output_excel_result" />
      <input type="submit" name="submit" value="トーナメント結果excel出力" />
    </form>
    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="update_result" />
      <input type="submit" name="submit" value="リザルト更新" />
    </form>
<!--
    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output_excel_prize" />
      <input type="submit" name="submit" value="表彰用テキスト出力" />
    </form>
-->
<!--
    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="output_excel_prize8" />
      <input type="submit" name="submit" value="ベスト８テキスト出力" />
    </form>
-->
<?php if ($_SESSION['auth']['locked'] == 0) {?>
    <form action="kojin_tournament.php?s=<?php echo $_smarty_tpl->tpl_vars['series']->value;?>
&mw=<?php echo $_smarty_tpl->tpl_vars['series_mw']->value;?>
" method="post">
      <input type="hidden" name="mode" value="update" />
      <input type="submit" name="submit" value="更新" />
<?php } else { ?>
      <input type="button" name="submit" value="更新" />
<?php }?>
<!--
    <form action="info.php" method="post">
      <input type="hidden" name="mode" value="output" />
      <input type="hidden" name="category" value="<?php echo $_smarty_tpl->tpl_vars['category']->value;?>
" />
      <input type="submit" name="submit" value="ファイル出力" />
    </form>
-->
<?php
$__section_tournament_data_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data'] : false;
$__section_tournament_data_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_data_0_total = $__section_tournament_data_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_tournament_data'] = new Smarty_Variable(array());
if ($__section_tournament_data_0_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] <= $__section_tournament_data_0_total; $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']++){
?>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['tournament_name'] != '') {?>
      <tr>
        <td class="td_right" colspan="3"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['tournament_name'];?>
</td>
      </tr>
<?php }?>
      <tr>
        <td class="td_right" colspan="2">氏名</td>
        <td class="td_right" colspan="3">試合
        </td>
      </tr>
<?php
$__section_tournament_player_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player'] : false;
$__section_tournament_player_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['player']) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_player_1_total = $__section_tournament_player_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_tournament_player'] = new Smarty_Variable(array());
if ($__section_tournament_player_1_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['iteration'] <= $__section_tournament_player_1_total; $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']++){
?>
      <tr>
        <td class="td_right" colspan="2">
          <?php echo smarty_function_html_options(array('name'=>"entry_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['iteration'] : null)),'options'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['players_for_smarty'],'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['player'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)]['player']),$_smarty_tpl);?>

<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['player'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)]['relative'] > 0) {?>
  <?php if (((isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)%2) == 0) {
$_smarty_tpl->_assignInScope('relative_match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][0]-1);
echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['relative_match_no']->value]['player1_name'];?>

  <?php } else {
$_smarty_tpl->_assignInScope('relative_index', (isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)-1);
$_smarty_tpl->_assignInScope('relative_match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][$_smarty_tpl->tpl_vars['relative_index']->value][0]-1);
echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['relative_match_no']->value]['player2_name'];?>

  <?php }
}?>
        </td>
<?php
$__section_tournament_match_offset_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] : false;
$__section_tournament_match_offset_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_level']) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_match_offset_2_start = min(0, $__section_tournament_match_offset_2_loop);
$__section_tournament_match_offset_2_total = min(($__section_tournament_match_offset_2_loop - $__section_tournament_match_offset_2_start), $__section_tournament_match_offset_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] = new Smarty_Variable(array());
if ($__section_tournament_match_offset_2_total != 0) {
for ($__section_tournament_match_offset_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] = $__section_tournament_match_offset_2_start; $__section_tournament_match_offset_2_iteration <= $__section_tournament_match_offset_2_total; $__section_tournament_match_offset_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']++){
$_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]-1);
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] > 0) {
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] < 1000) {?>
        <td class="td_right" rowspan="2">
          【<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)];?>
】<?php echo smarty_function_html_options(array('name'=>"place_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]),'options'=>$_smarty_tpl->tpl_vars['place_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place']),$_smarty_tpl);?>

          <?php echo smarty_function_html_options(array('name'=>"place_match_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]),'options'=>$_smarty_tpl->tpl_vars['place_match_no_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no']),$_smarty_tpl);?>
<br />
          <a href="../input/kojin_result.php?a=1&p=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place'];?>
&m=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no'];?>
&lg=1&v=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['navi_id'];?>
">結果</a>
        </td>
<?php } elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] >= 2000) {
$_smarty_tpl->_assignInScope('name_offset', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]%1000);
$_smarty_tpl->_assignInScope('name_offset2', $_smarty_tpl->tpl_vars['name_offset']->value-1);
?>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['name_offset2']->value]['player2_name'];?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] >= 1000) {
$_smarty_tpl->_assignInScope('name_offset', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]%1000);
$_smarty_tpl->_assignInScope('name_offset2', $_smarty_tpl->tpl_vars['name_offset']->value-1);
?>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['name_offset2']->value]['player1_name'];?>
</td>
<?php } else { ?>
        <td class="td_right"></td>
<?php }
} elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_player']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] == 0) {?>
        <td class="td_right"></td>
<?php }
}
}
if ($__section_tournament_match_offset_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] = $__section_tournament_match_offset_2_saved;
}
}
}
if ($__section_tournament_player_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_player'] = $__section_tournament_player_1_saved;
}
?>
    </table>
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['extra_match_num'] > 0) {?>
    <table>
<?php
$__section_tournament_extra_match_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match'] : false;
$__section_tournament_extra_match_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['extra_match_num']) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_extra_match_3_start = min(0, $__section_tournament_extra_match_3_loop);
$__section_tournament_extra_match_3_total = min(($__section_tournament_extra_match_3_loop - $__section_tournament_extra_match_3_start), $__section_tournament_extra_match_3_loop);
$_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match'] = new Smarty_Variable(array());
if ($__section_tournament_extra_match_3_total != 0) {
for ($__section_tournament_extra_match_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index'] = $__section_tournament_extra_match_3_start; $__section_tournament_extra_match_3_iteration <= $__section_tournament_extra_match_3_total; $__section_tournament_extra_match_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index']++){
$_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_num']+(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index'] : null));
$_smarty_tpl->_assignInScope('place_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_num']+(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index'] : null)+1);
?>
      <tr>
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['extra_name_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index'] : null)] != '') {?>
        <td class="td_right" colspan="3"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['extra_name_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match']->value['index'] : null)];?>
</td>
<?php } else { ?>
        <td class="td_right" colspan="3">順位決定戦</td>
<?php }?>
      </tr>
      <tr>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['player1_name'];?>
</td>
        <td class="td_right" rowspan="2">
          <?php echo smarty_function_html_options(array('name'=>"place_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['place_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place']),$_smarty_tpl);?>

          <?php echo smarty_function_html_options(array('name'=>"place_match_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['place_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_match_no_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no']),$_smarty_tpl);?>
<br />
          <a href="../input/kojin_result.php?a=1&p=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place'];?>
&m=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no'];?>
&lg=1&v=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['navi_id'];?>
">結果</a>
        </td>
        <td class="td_right">
            <?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['winner'] == 1) {?>
            <?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['player1_name'];?>

            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['winner'] == 2) {?>
            <?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['player2_name'];?>

            <?php }?>
        </td>
      </tr>
      <tr>
        <td class="td_right">
            <?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['player2_name'];?>

        </td>
        <td class="td_right"></td>
      </tr>
<?php $_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['match_no']->value+1);
$_smarty_tpl->_assignInScope('place_no', $_smarty_tpl->tpl_vars['place_no']->value+1);
}
}
if ($__section_tournament_extra_match_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_extra_match'] = $__section_tournament_extra_match_3_saved;
}
?>
    </table>
<?php }
}
}
if ($__section_tournament_data_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_data'] = $__section_tournament_data_0_saved;
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
