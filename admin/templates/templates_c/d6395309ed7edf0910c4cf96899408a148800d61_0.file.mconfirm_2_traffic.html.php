<?php
/* Smarty version 3.1.30, created on 2022-02-22 21:44:23
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_traffic.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6214daa7c55351_61363360',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd6395309ed7edf0910c4cf96899408a148800d61' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_traffic.html',
      1 => 1423744701,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6214daa7c55351_61363360 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw100i">
<?php if ($_SESSION['p']['traffic'] == 'mycar') {?>自家用車(<?php echo $_SESSION['p']['traffic_mycar'];?>
台)<?php }
if ($_SESSION['p']['traffic'] == 'bus_l') {?>バス運転手あり(大)<?php }
if ($_SESSION['p']['traffic'] == 'bus_m') {?>バス運転手あり(中)<?php }
if ($_SESSION['p']['traffic'] == 'bus_s') {?>バス運転手あり(マイクロ)<?php }
if ($_SESSION['p']['traffic'] == 'bus_non_l') {?>バス運転手なし(大)<?php }
if ($_SESSION['p']['traffic'] == 'bus_non_m') {?>バス運転手なし(中)<?php }
if ($_SESSION['p']['traffic'] == 'bus_non_s') {?>バス運転手なし(マイクロ)<?php }
if ($_SESSION['p']['traffic'] == 'share') {?>他のチームに便乗(<?php echo $_SESSION['p']['traffic_share'];?>
)<?php }
if ($_SESSION['p']['traffic'] == 'train') {?>電車<?php }
if ($_SESSION['p']['traffic'] == 'other') {?>その他(<?php echo $_SESSION['p']['traffic_other'];?>
)<?php }?>
      </div>
<?php }
}
