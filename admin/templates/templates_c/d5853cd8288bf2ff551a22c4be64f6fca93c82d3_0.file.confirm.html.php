<?php
/* Smarty version 3.1.30, created on 2025-06-19 23:22:32
  from "/var/www/html/admin/templates/templates/admin/confirm.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_68549bb86dcd14_22753935',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd5853cd8288bf2ff551a22c4be64f6fca93c82d3' => 
    array (
      0 => '/var/www/html/admin/templates/templates/admin/confirm.html',
      1 => 1721651296,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68549bb86dcd14_22753935 (Smarty_Internal_Template $_smarty_tpl) {
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2><?php echo $_smarty_tpl->tpl_vars['edit_title']->value;?>
</h2>
    <br />
    <form action="info.php?s=<?php echo $_SESSION['p']['series'];?>
" method="post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="exec">
      <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
        <tr>
<?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] != '' && $_smarty_tpl->tpl_vars['info']->value['kind'] != 'email2') {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title1') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h1><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h1></td>
<?php if ($_smarty_tpl->tpl_vars['mform_msg']->value != '') {?>
          <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['mform_msg']->value;?>
</td>
<?php }?>
    <div class="f_box">
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title2') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'data_title') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title1') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title2') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'discription') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box_end') {
$_smarty_tpl->_assignInScope('exist_edit_field', 0);
} else {
$_smarty_tpl->_assignInScope('exist_edit_field', 1);
?>
          <td class="td_left3"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</td>
<?php }
$_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
if ($_smarty_tpl->tpl_vars['exist_edit_field']->value == 1) {?>
          <td class="td_right">
<?php }
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'text') {?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'textarea') {?>
            <?php echo nl2br($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]);?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check_one') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'select' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'pref_select') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'radio') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'name_kana') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name3') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] != '') {?>(備考：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
)<?php }
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name4') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] != '') {?>(備考：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
)<?php }
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value] != '') {?>(表示名：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
)<?php }
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name5') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
          <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>&nbsp;(異体字あり)<?php }
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name6') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
          <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
(表示：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
)<?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>&nbsp;(異体字あり)<?php }
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel_fax') {
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
$_smarty_tpl->_assignInScope('edit_field_fax', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_fax");
?>
            TEL：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
 FAX：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_fax']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'mobile_tel') {
$_smarty_tpl->_assignInScope('edit_field_mobile', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mobile");
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
?>
            TEL：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mobile']->value];?>
 FAX：<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_org') {
$_smarty_tpl->_assignInScope('edit_field_school_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_school_name");
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_name']->value];?>

            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name') {
$_smarty_tpl->_assignInScope('edit_field_school_org', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_org");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_org']->value];?>
立&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name_kana') {?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address') {
$_smarty_tpl->_assignInScope('edit_field_zip1', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip1");
$_smarty_tpl->_assignInScope('edit_field_zip2', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip2");
$_smarty_tpl->_assignInScope('edit_field_pref_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_pref_name");
?>
            〒<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip1']->value];?>
-<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip2']->value];?>
&nbsp;
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_pref_name']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address_pref') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_j') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_e') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'gakunen_dan_j') {
$_smarty_tpl->_assignInScope('edit_field_gakunen', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_gakunen_name");
$_smarty_tpl->_assignInScope('edit_field_dan', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_dan");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_gakunen']->value];?>
/<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_dan']->value], ENT_QUOTES, 'UTF-8', true);?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email') {?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {
if (isset($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]) && $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
            <div style="margin: 5px;">
                <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" src="../admin/upload/pdf/<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
_01.jpg" width="240">
            </div>
<?php }
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'yosen_rank') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
            <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'hidden') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'include') {
$_smarty_tpl->_assignInScope('include_file', "reg/mconfirm_".((string)$_SESSION['auth']['series'])."_".((string)$_smarty_tpl->tpl_vars['info']->value['select_info']).".html");
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['include_file']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
if ($_smarty_tpl->tpl_vars['exist_edit_field']->value == 1) {?>
          </td>
<?php }?>
        </tr>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      </table>
      <br />
      <input type="submit" name="cancel" value="中止">
      <input type="submit" name="exec" value="実行">
    </form>
    <br />
    <br />
    <br />
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
