<?php
/* Smarty version 3.1.30, created on 2022-02-22 21:44:23
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_shumoku_dantai_w.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6214daa7c402a1_72829975',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '582f6d979ae2fb57d307a59e554710f6e17613bb' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_shumoku_dantai_w.html',
      1 => 1423747342,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6214daa7c402a1_72829975 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw180i">
<?php if ($_SESSION['p']['shumoku_dantai_w_taikai'] == '1') {?>大会参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_w_rensei_am'] == '1') {?>錬成会 午前参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_w_rensei_pm'] == '1') {?>錬成会 午後参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_w_opening'] == '1') {?>開会式参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_w_konshin'] == '1') {?>懇親会参加する(<?php echo $_SESSION['p']['shumoku_dantai_w_text'];?>
名)<?php }?>
      </div>
<?php }
}
