<?php
/* Smarty version 3.1.30, created on 2023-10-26 16:08:53
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/dantai_league_check_score.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_653a1085a23cd4_61126665',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9591a08003542979f90de2701791e46a7fa6620a' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/dantai_league_check_score.html',
      1 => 1698303999,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_653a1085a23cd4_61126665 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php if ($_smarty_tpl->tpl_vars['mw']->value == 'm') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'] == '') {?>
    <h2>団体リーグスコアーチェック</h2>
  <?php } else { ?>
    <h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
リーグスコアーチェック</h2>
  <?php }
}
if ($_smarty_tpl->tpl_vars['mw']->value == 'w') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'] == '') {?>
    <h2>団体リーグスコアーチェック</h2>
  <?php } else { ?>
    <h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
リーグスコアーチェック</h2>
  <?php }
}?>
    </h2>
<?php
$__section_league_data_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data'] : false;
$__section_league_data_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['league_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_league_data_0_total = $__section_league_data_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_league_data'] = new Smarty_Variable(array());
if ($__section_league_data_0_total != 0) {
for ($__section_league_data_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] = 0; $__section_league_data_0_iteration <= $__section_league_data_0_total; $__section_league_data_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']++){
?>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0" style="width: 640px;">
      <tr>
        <td class="td_right">
          <?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['name'];?>

        </td>
        <td class="td_right" colspan="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num'];?>
">&nbsp;</td>
      </tr>
      <tr>
        <td class="td_right">対戦団体</td>
        <td class="td_right" colspan="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team_num'];?>
">試合
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
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['entry_list']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
          <?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row']->value['index'] : null)]['team'] == $_smarty_tpl->tpl_vars['k']->value) {
echo $_smarty_tpl->tpl_vars['v']->value;
}?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

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
<?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place'] > 0 && $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['place_match_no'] > 0) {?>
          <form action="dantai_league_check_score.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_league_m'];?>
&mw=m" method="post">
<?php if ($_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['approval'] == 1) {?>
            承認済み
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['match'];?>
">
            <input type="hidden" name="mode" value="unapproval">
            <input type="submit" name="submit" value="取り消し">
<?php } else { ?>
            未承認
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['league_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_league_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no_index']->value]['match'];?>
">
            <input type="hidden" name="mode" value="approval">
            <input type="submit" name="submit" value="承認">
<?php }?>
          </form>
          <a href="/kendo/result/<?php ob_start();
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
      </tr>
<?php
}
}
if ($__section_dantai_index_row_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_dantai_index_row'] = $__section_dantai_index_row_2_saved;
}
?>
    </table>
<?php
}
}
if ($__section_league_data_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_league_data'] = $__section_league_data_0_saved;
}
?>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
