<?php
/* Smarty version 3.1.30, created on 2022-02-14 10:13:50
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_2_shumoku_dantai_w.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6209acce7894f2_75423779',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2541ec90ea1f22fab1aff3f0d8fb9085da360920' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform_2_shumoku_dantai_w.html',
      1 => 1644800950,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6209acce7894f2_75423779 (Smarty_Internal_Template $_smarty_tpl) {
?>
      <div class="tw100">
<input type="checkbox" name="shumoku_dantai_w_taikai" value="1" <?php if ($_SESSION['p']['shumoku_dantai_w_taikai'] == '1') {?>checked="checked" <?php }?>/>大会参加&nbsp;
<input type="checkbox" name="shumoku_dantai_w_rensei_am" value="1" <?php if ($_SESSION['p']['shumoku_dantai_w_rensei_am'] == '1') {?>checked="checked" <?php }?>/>錬成会 午前参加&nbsp;
<input type="checkbox" name="shumoku_dantai_w_rensei_pm" value="1" <?php if ($_SESSION['p']['shumoku_dantai_w_rensei_pm'] == '1') {?>checked="checked" <?php }?>/>錬成会 午後参加
<input type="hidden" name="shumoku_dantai_w_opening" value="" />
<input type="hidden" name="shumoku_dantai_w_konshin" value="" />
<input type="hidden" name="shumoku_dantai_w_text" value="" />

      </div>
<?php }
}
