<?php
/* Smarty version 3.1.30, created on 2022-02-17 00:11:00
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_3_shumoku_dantai.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_620d1404863c90_46256929',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd7057425218610d341cf20f54d275ed13292fdd1' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_3_shumoku_dantai.html',
      1 => 1423915939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_620d1404863c90_46256929 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw180i">
<?php if ($_SESSION['p']['shumoku_dantai_taikai'] == '1') {?>大会参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_rensei_am'] == '1') {?>錬成会 午前参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_rensei_pm'] == '1') {?>錬成会 午後参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_opening'] == '1') {?>開会式参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_konshin'] == '1') {?>懇親会参加する(<?php echo $_SESSION['p']['shumoku_dantai_text'];?>
名)<?php }?>
      </div>
<?php }
}
