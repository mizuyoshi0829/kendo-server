<?php
/* Smarty version 3.1.30, created on 2025-10-17 20:54:39
  from "/var/www/html/admin/templates/templates/admin/dantai_tournament_check_score.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_68f2ad0fe66df6_56686011',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '78181a7a60db4d881bf27c4a33038dbb79fafe82' => 
    array (
      0 => '/var/www/html/admin/templates/templates/admin/dantai_tournament_check_score.html',
      1 => 1760734463,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68f2ad0fe66df6_56686011 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/var/www/html/admin/Smarty/plugins/function.html_options.php';
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php if ($_smarty_tpl->tpl_vars['series_mw']->value == 'm') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'] == '') {?>
<h2>団体トーナメントスコアーチェック</h2>
  <?php } else { ?>
<h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_m_name'];?>
トーナメントスコアーチェック</h2>
  <?php }
}
if ($_smarty_tpl->tpl_vars['series_mw']->value == 'w') {?>
  <?php if ($_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'] == '') {?>
  <h2>団体(女子)トーナメントスコアーチェック</h2>
  <?php } else { ?>
  <h2><?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_w_name'];?>
トーナメントスコアーチェック</h2>
  <?php }
}?>
    </h2>
<?php
$__section_tournament_data_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data'] : false;
$__section_tournament_data_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_data_0_total = $__section_tournament_data_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_tournament_data'] = new Smarty_Variable(array());
if ($__section_tournament_data_0_total != 0) {
for ($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] = 0; $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] <= $__section_tournament_data_0_total; $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']++){
?>
    <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="td_right" colspan="2">対戦チーム</td>
        <td class="td_right" colspan="3">試合
        </td>
      </tr>
<?php
$__section_tournament_team_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team'] : false;
$__section_tournament_team_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['team']) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_team_1_total = $__section_tournament_team_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_tournament_team'] = new Smarty_Variable(array());
if ($__section_tournament_team_1_total != 0) {
for ($__section_tournament_team_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] = 0; $__section_tournament_team_1_iteration <= $__section_tournament_team_1_total; $__section_tournament_team_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']++){
?>
      <tr>
        <td class="td_right" colspan="2">
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)]['id'] != 0) {?>
          <?php echo $_smarty_tpl->tpl_vars['entry_list']->value[$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['team'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)]['id']];?>

<?php } else { ?>
          &nbsp;
<?php }?>
        </td>
<?php
$__section_tournament_match_offset_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] : false;
$__section_tournament_match_offset_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_level']) ? count($_loop) : max(0, (int) $_loop));
$__section_tournament_match_offset_2_start = min(0, $__section_tournament_match_offset_2_loop);
$__section_tournament_match_offset_2_total = min(($__section_tournament_match_offset_2_loop - $__section_tournament_match_offset_2_start), $__section_tournament_match_offset_2_loop);
$_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] = new Smarty_Variable(array());
if ($__section_tournament_match_offset_2_total != 0) {
for ($__section_tournament_match_offset_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] = $__section_tournament_match_offset_2_start; $__section_tournament_match_offset_2_iteration <= $__section_tournament_match_offset_2_total; $__section_tournament_match_offset_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']++){
$_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]-1);
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] > 0) {
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] < 1000) {?>
        <td class="td_right" rowspan="2">
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place'] != 'no_match') {
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place'] != '0') {?>
          <form action="dantai_tournament_check_score.php?s=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['dantai_tournament_m'];?>
&mw=m" method="post">
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['approval'] == 1) {?>
            承認済み
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['match'];?>
">
            <input type="hidden" name="mode" value="unapproval">
            <input type="submit" name="submit" value="承認取り消し">
<?php } else { ?>
            未承認
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['match'];?>
">
            <input type="hidden" name="mode" value="approval">
            <input type="submit" name="submit" value="承認">
<?php }?>
          </form>
          <a href="/result/<?php ob_start();
echo $_SESSION['auth']['result_path_prefix'];
$_prefixVariable1=ob_get_clean();
echo $_prefixVariable1;?>
/pdf/match<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['match'];?>
.pdf" target="_blank">PDF</a>
<?php }
}?>
        </td>
<?php } elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] >= 2000) {
$_smarty_tpl->_assignInScope('name_offset', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]%1000);
$_smarty_tpl->_assignInScope('name_offset2', $_smarty_tpl->tpl_vars['name_offset']->value-1);
?>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['name_offset2']->value]['team2_name'];?>
</td>
<?php } elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] >= 1000) {
$_smarty_tpl->_assignInScope('name_offset', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)]%1000);
$_smarty_tpl->_assignInScope('name_offset2', $_smarty_tpl->tpl_vars['name_offset']->value-1);
?>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['name_offset2']->value]['team1_name'];?>
</td>
<?php } else { ?>
        <td class="td_right"></td>
<?php }
} elseif ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_array'][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_team']->value['index'] : null)][(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset']->value['index'] : null)] == 0) {?>
        <td class="td_right"></td>
<?php }
}
}
if ($__section_tournament_match_offset_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_match_offset'] = $__section_tournament_match_offset_2_saved;
}
}
}
if ($__section_tournament_team_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_tournament_team'] = $__section_tournament_team_1_saved;
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
$_smarty_tpl->_assignInScope('match_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_num']+'tournament_extra_match');
$_smarty_tpl->_assignInScope('place_no', $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match_num']+'tournament_extra_match'+1);
?>
      <tr>
        <td class="td_right" colspan="3">順位決定戦</td>
      </tr>
      <tr>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['team1_name'];?>
</td>
        <td class="td_right" rowspan="2">
          <?php echo smarty_function_html_options(array('name'=>"place_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['place_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place']),$_smarty_tpl);?>

          <?php echo smarty_function_html_options(array('name'=>"place_match_".((string)(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['iteration'] : null))."_".((string)$_smarty_tpl->tpl_vars['place_no']->value),'options'=>$_smarty_tpl->tpl_vars['place_match_no_array']->value,'selected'=>$_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no']),$_smarty_tpl);?>
<br />
          <a href="../input/dantai_result.php?a=1&p=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place'];?>
&m=<?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['place_match_no'];?>
&lg=1&v=<?php echo $_smarty_tpl->tpl_vars['seriesinfo']->value['navi_id'];?>
">結果</a>
        </td>
        <td class="td_right">
<?php if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['winner'] == 1) {?>
            <?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['team1_name'];?>

<?php }
if ($_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['winner'] == 2) {?>
            <?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['team2_name'];?>

<?php }?>
        </td>
      </tr>
      <tr>
        <td class="td_right"><?php echo $_smarty_tpl->tpl_vars['tournament_list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_tournament_data']->value['index'] : null)]['match'][$_smarty_tpl->tpl_vars['match_no']->value]['team2_name'];?>
</td>
        <td class="td_right"></td>
      </tr>
<?php
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
