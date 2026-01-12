<?php
/* Smarty version 3.1.30, created on 2022-02-14 09:56:04
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_3_traffic.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6209a8a41fb4c6_33080296',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '77a6c1b9139355054d87c21a29a455136ad4d088' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_3_traffic.html',
      1 => 1454398608,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6209a8a41fb4c6_33080296 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw100">
<input type="radio" name="traffic" value="mycar" <?php if ($_SESSION['p']['traffic'] == 'mycar') {?>checked="checked" <?php }?>/>自家用車(<input id="traffic_mycar" type="text" name="traffic_mycar" value="<?php echo $_SESSION['p']['traffic_mycar'];?>
" class="textw4">台)<br />
<input type="radio" name="traffic" value="bus_l" <?php if ($_SESSION['p']['traffic'] == 'bus_l') {?>checked="checked" <?php }?>/>バス運転手あり（大）<br />
<input type="radio" name="traffic" value="bus_m" <?php if ($_SESSION['p']['traffic'] == 'bus_m') {?>checked="checked" <?php }?>/>バス運転手あり（中）<br />
<input type="radio" name="traffic" value="bus_s" <?php if ($_SESSION['p']['traffic'] == 'bus_s') {?>checked="checked" <?php }?>/>バス運転手あり（マイクロ）<br />
<input type="radio" name="traffic" value="bus_non_l" <?php if ($_SESSION['p']['traffic'] == 'bus_non_l') {?>checked="checked" <?php }?>/>バス運転手なし（大）<br />
<input type="radio" name="traffic" value="bus_non_m" <?php if ($_SESSION['p']['traffic'] == 'bus_non_m') {?>checked="checked" <?php }?>/>バス運転手なし（中）<br />
<input type="radio" name="traffic" value="bus_non_s" <?php if ($_SESSION['p']['traffic'] == 'bus_non_s') {?>checked="checked" <?php }?>/>バス運転手なし（マイクロ）<br />
<input type="radio" name="traffic" value="share" <?php if ($_SESSION['p']['traffic'] == 'share') {?>checked="checked" <?php }?>/>他のチームに便乗(<input id="traffic_share" type="text" name="traffic_share" value="<?php echo $_SESSION['p']['traffic_share'];?>
" class="text">)<br />
<input type="radio" name="traffic" value="train" <?php if ($_SESSION['p']['traffic'] == 'train') {?>checked="checked" <?php }?>/>電車<br />
<input type="radio" name="traffic" value="other" <?php if ($_SESSION['p']['traffic'] == 'other') {?>checked="checked" <?php }?>/>その他(<input id="traffic_other" type="text" name="traffic_other" value="<?php echo $_SESSION['p']['traffic_other'];?>
" class="text">)<br />
        </div>
<?php }
}
