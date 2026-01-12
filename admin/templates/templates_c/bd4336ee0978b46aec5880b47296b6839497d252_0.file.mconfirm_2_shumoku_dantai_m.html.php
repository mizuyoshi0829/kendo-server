<?php
/* Smarty version 3.1.30, created on 2022-02-22 21:44:23
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_shumoku_dantai_m.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6214daa7c316e2_62920677',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd4336ee0978b46aec5880b47296b6839497d252' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm_2_shumoku_dantai_m.html',
      1 => 1423747311,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6214daa7c316e2_62920677 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw180i">
<?php if ($_SESSION['p']['shumoku_dantai_m_taikai'] == '1') {?>大会参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_m_rensei_am'] == '1') {?>錬成会 午前参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_m_rensei_pm'] == '1') {?>錬成会 午後参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_m_opening'] == '1') {?>開会式参加&nbsp;<?php }
if ($_SESSION['p']['shumoku_dantai_m_konshin'] == '1') {?>懇親会参加する(<?php echo $_SESSION['p']['shumoku_dantai_m_text'];?>
名)<?php }?>
      </div>
<?php }
}
