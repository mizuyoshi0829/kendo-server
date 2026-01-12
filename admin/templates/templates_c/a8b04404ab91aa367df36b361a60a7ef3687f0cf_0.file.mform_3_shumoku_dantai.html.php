<?php
/* Smarty version 3.1.30, created on 2022-02-14 09:56:04
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_3_shumoku_dantai.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6209a8a41cecc5_36537516',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8b04404ab91aa367df36b361a60a7ef3687f0cf' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_3_shumoku_dantai.html',
      1 => 1644799522,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6209a8a41cecc5_36537516 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw100">
<input type="checkbox" name="shumoku_dantai_taikai" value="1" <?php if ($_SESSION['p']['shumoku_dantai_taikai'] == '1') {?>checked="checked" <?php }?>/>大会参加&nbsp;
<input type="checkbox" name="shumoku_dantai_rensei_am" value="1" <?php if ($_SESSION['p']['shumoku_dantai_rensei_am'] == '1') {?>checked="checked" <?php }?>/>錬成会 午前参加&nbsp;
<input type="checkbox" name="shumoku_dantai_rensei_pm" value="1" <?php if ($_SESSION['p']['shumoku_dantai_rensei_pm'] == '1') {?>checked="checked" <?php }?>/>錬成会 午後参加
<input type="hidden" name="shumoku_dantai_opening" value="" />
<input type="hidden" name="shumoku_dantai_konshin" value="" />
<input type="hidden" name="shumoku_dantai_text" value="" />

      </div>
<?php }
}
