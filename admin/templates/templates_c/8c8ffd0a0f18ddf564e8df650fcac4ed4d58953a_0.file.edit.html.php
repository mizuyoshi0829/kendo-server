<?php
/* Smarty version 3.1.30, created on 2025-06-10 18:28:00
  from "C:\xampp\htdocs\admin\templates\templates\admin\edit.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_68485d100efd09_86425126',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8c8ffd0a0f18ddf564e8df650fcac4ed4d58953a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\admin\\templates\\templates\\admin\\edit.html',
      1 => 1721636402,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_68485d100efd09_86425126 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_checkboxes')) require_once 'C:\\xampp\\htdocs\\admin\\Smarty\\plugins\\function.html_checkboxes.php';
if (!is_callable('smarty_function_html_options')) require_once 'C:\\xampp\\htdocs\\admin\\Smarty\\plugins\\function.html_options.php';
if (!is_callable('smarty_function_html_radios')) require_once 'C:\\xampp\\htdocs\\admin\\Smarty\\plugins\\function.html_radios.php';
echo (($tmp = @$_smarty_tpl->tpl_vars['htmlheader']->value)===null||$tmp==='' ? '' : $tmp);?>

    <h2><?php echo $_smarty_tpl->tpl_vars['edit_title']->value;?>
</h2>
    <br />
    <form action="info.php?s=<?php echo $_SESSION['p']['series'];?>
" method="post" enctype="multipart/form-data">
      <input type="hidden" name="mode" value="confirm">
      <table id="ex_t" border="0" cellspacing="1" cellpadding="0">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
        <tr>
 <?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] != '') {?>
  <?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title1') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h1><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];
if ($_smarty_tpl->tpl_vars['info']->value['placeholder'] != '') {?>&nbsp;<a <?php echo $_smarty_tpl->tpl_vars['info']->value['select_info'];?>
 ><?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
</a><?php }?></h1></td>
   <?php if ($_smarty_tpl->tpl_vars['mform_msg']->value != '') {?>
          <td colspan="2"><?php echo $_smarty_tpl->tpl_vars['mform_msg']->value;?>
</td>
   <?php }?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title2') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];
if ($_smarty_tpl->tpl_vars['info']->value['placeholder'] != '') {?>&nbsp;<a <?php echo $_smarty_tpl->tpl_vars['info']->value['select_info'];?>
 ><?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
</a><?php }?></h2></td>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'data_title') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title1') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title2') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
          <td colspan="2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></td>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'discription') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box_end') {?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 0);
?>
  <?php } else { ?>
   <?php $_smarty_tpl->_assignInScope('exist_edit_field', 1);
?>
          <td class="td_left3"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</td>
  <?php }?>

  <?php $_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
?>
  <?php if ($_smarty_tpl->tpl_vars['exist_edit_field']->value == 1) {?>
          <td class="td_right">
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'text') {?>
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'textarea') {?>
            <textarea name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" cols="40" rows="3" maxlength="100" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" ><?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</textarea>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check') {?>
            <?php echo smarty_function_html_checkboxes(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'<br />'),$_smarty_tpl);?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check_one') {?>
            <?php echo smarty_function_html_checkboxes(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'<br />'),$_smarty_tpl);?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'select' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'pref_select') {?>
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'radio') {?>
            <?php echo smarty_function_html_radios(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'<br />'),$_smarty_tpl);?>

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_effect', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_effect");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_rotate', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_rotate");
?>
   <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
            <div id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview" style="width: 400px; height: 300px;">
              <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview_image" src="../admin/upload/org/<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
.jpg" width="400" />
            </div>
            画像回転：
            <input type="number" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate_text" max="180" min="-180" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_rotate']->value];?>
">
            <input type="range" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate" max="180" min="-180" step="1" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_rotate']->value];?>
"><br />
            画像ズーム：
            <input type="number" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom_text" max="5" min="-5" step="0.05" value="0">
            <input type="range" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom" max="5" min="-5" step="0.05" value="0">
   <?php } else { ?>
            <div>
              <img src="img/white.jpg" />
            </div>
   <?php }?>
            <br />
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_op" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file" type="file" value="" onchange_="updateImage('<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
');" />
            <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
">
            <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect" value="<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_effect']->value], ENT_QUOTES, 'UTF-8', true);?>
">
   <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
            <div style="margin-top: 8px;">
              <div style="float: left; padding: 8px;">
                カラー：<br />
                <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect_image" src="../admin/upload/<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
_01.jpg" width="300" style="filter: brightness(100%);" /><br />
                明るさ：
                <input type="number" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness_text" max="200" min="1" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_rotate']->value];?>
">
                <input type="range" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness" max="200" min="1" step="1" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_rotate']->value];?>
"><br />
              </div>

            </div>
   <?php }?>
          </div>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'name_kana') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" class="text" placeholder="姓" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名" >
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name3') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" class="text" placeholder="姓" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
" class="text" placeholder="備考：異体字など" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name4') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" class="text" placeholder="姓" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
" class="text" placeholder="備考：異体字など" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
" class="text" placeholder="表示名" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name5') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="4" class="text" placeholder="名字" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="1" class="text" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>checked="checked" <?php }?> style="width: 1em;">異体字あり

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name6') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="4" class="text" placeholder="名字" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="1" class="text" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>checked="checked" <?php }?> style="width: 1em;">異体字あり
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
" class="text" placeholder="表示名" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel_fax') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_fax', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_fax");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
" class="text" placeholder="電話番号" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_fax']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_fax']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_fax']->value];?>
" class="text" placeholder="FAX番号" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'mobile_tel') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_mobile', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mobile");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mobile']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mobile']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mobile']->value];?>
" class="text" placeholder="携帯番号" >
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
" class="text" placeholder="電話番号" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_org') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_school_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_school_name");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_name']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_name']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_name']->value];?>
" class="text" placeholder="○○" >
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['org_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_school_org', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_org");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_org']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_org']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_org']->value];?>
" class="text" placeholder="○○" >立
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name_kana') {?>
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_zip1', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip1");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_zip2', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip2");
?>
   <?php $_smarty_tpl->_assignInScope('edit_field_pref', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_pref");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip1']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip1']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip1']->value];?>
" class="text" placeholder="郵便番号" >
            -<input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip2']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip2']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip2']->value];?>
" class="text" placeholder="郵便番号">
            <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_input" type="button" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_input" value="住所自動入力" class="" onClick="zip_search();"><br />
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field_pref']->value,'options'=>$_smarty_tpl->tpl_vars['pref_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_pref']->value]),$_smarty_tpl);?>

            <input style="width: 400px;" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="住所" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address_pref') {?>
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['pref_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_j') {?>
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['grade_junior_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_e') {?>
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['grade_elementary_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email') {?>
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'gakunen_dan_j') {?>
   <?php $_smarty_tpl->_assignInScope('edit_field_gakunen', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_gakunen");
?>
            <input name="<?php echo $_smarty_tpl->tpl_vars['edit_field_gakunen']->value;?>
" type="radio" value="1" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_gakunen']->value] == 1) {?>checked="checked"<?php }?>>
            １年
            <input name="<?php echo $_smarty_tpl->tpl_vars['edit_field_gakunen']->value;?>
" type="radio" value="2" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_gakunen']->value] == 2) {?>checked="checked"<?php }?>>
            ２年
            <input name="<?php echo $_smarty_tpl->tpl_vars['edit_field_gakunen']->value;?>
" type="radio" value="3" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_gakunen']->value] == 3) {?>checked="checked"<?php }?>>
            ３年
   <?php $_smarty_tpl->_assignInScope('edit_field_dan', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_dan");
?>
            <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_dan']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['edit_field_dan']->value;?>
" value="<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_dan']->value], ENT_QUOTES, 'UTF-8', true);?>
" placeholder="段位">

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'yosen_rank') {?>
            <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['yosen_rank_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'hidden') {?>
            <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" >

  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'literal') {?>
            <?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>


  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'include') {?>
   <?php $_smarty_tpl->_assignInScope('include_file', "reg/mform_".((string)$_SESSION['auth']['series'])."_".((string)$_smarty_tpl->tpl_vars['info']->value['select_info']).".html");
?>
            <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['include_file']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

  <?php }?>
 <?php }?>
          </td>
 <?php if ($_smarty_tpl->tpl_vars['exist_edit_field']->value == 1) {?>
        </tr>
 <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      </table>
      <br />
      <input type="submit" name="cancel" value="中止">
<?php if ($_SESSION['auth']['locked'] == 0) {?>
      <input type="submit" name="exec" value="実行">
<?php }?>
    </form>
    <br />
    <br />
    <br />
<?php echo '<script'; ?>
 type="text/javascript">

<!--

    let cropper = [ null, null ];
    let zoom = [ 0, 0 ];
    let brightness = [ 100, 100 ];
      
    // ファイルのアップロード
    function previewImage(field,imageUrl,width,field_index)
    {
        const img = $('#'+field+'_file_preview_image').eq(0);
        const img_effect = $("input[name='"+field+"_effect']").val();
        let data = null;
        if( img_effect != '' ){
            let jdata = JSON.parse(img_effect);
            data = jdata.crop;
            brightness[field_index] = jdata.brightness;
            $('#'+field+'_file_brightness').val(jdata.brightness);
            $('#'+field+'_file_brightness_text').val(jdata.brightness);
            $('#'+field+'_effect_image').css('filter', 'brightness(' + jdata.brightness + '%)');
        }
        if( imageUrl != null ){
            img.attr('src',imageUrl); // 画像のURLをimg要素にセット
        }
        if( cropper[field_index] != null ){
            cropper[field_index].destroy();
            cropper[field_index] = null;
        }
        cropper[field_index] = new Cropper(
            img.get(0),
            {
                viewMode: 0,
                checkOrientation: true,
                zoomOnwheel: false,
                zoomOntouch: false,            
                data: data,
                background: false,
                autoCropArea: 1,
                movable: true,
                rotatable: true,
                scalable: false,
                zoomable: true,
                crop(event) {
                    let d = JSON.stringify(event.detail);
                    const img_effect = '{ "crop":' + d + ',' + '"brightness": ' + brightness[field_index] + ' }';
                    $("input[name='"+field+"_effect']").val(img_effect);
                }
            }
        );
    }
      
    function previewFile(file,field,width,field_index)
    {
        const preview = $('#'+field+'_file_preview');
        const reader = new FileReader();
        reader.onload = function (e) {
            const imageUrl = e.target.result; // 画像のURLはevent.target.resultで呼び出せる
            $("input[name='"+field+"_effect']").val('');
            previewImage(field,imageUrl,width,field_index);
        }
        reader.readAsDataURL(file);
    }
      
    function updateImage( field, width, field_index )
    {
        const fileInput = document.getElementById(field+'_file_op');
        const files = fileInput.files;
        for (let i = 0; i < files.length; i++) {
            previewFile(files[i],field,width,field_index);
        }
        return;
     
        showActiveIndicator();
        // FormData の作成
        $("#form_entry [name='imageupload']").val(field);
        var form = $('#form_entry').get()[0];
        var formData = new FormData(form);
        // FormData を送信
        $.ajax({
            url: "uploadimage.php",
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            dataType: 'text',
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                hideActiveIndicator();
                console.log('error');
            //	alert(XMLHttpRequest.status+":"+textStatus+":"+errorThrown.message);
            },
            success: function(data, dataType) {
                hideActiveIndicator();
                console.log('success');
                if( data != '' ){
                    $("#"+field+"_preview img:eq(0)").attr( 'src', 'upload/'+data+'_02.jpg' ).css("width","200px");
                    $("#"+field+"_file_del").css("display","inline");
                    $("#form_entry [name='"+field+"']").val(data);
                    $("#form_entry [name='"+field+"_file']").val('');
                }
                //	alert( data );
            }
        });
    }
      
    // ファイルのアップロード
    function deleteImage( field )
    {
        if( !window.confirm('画像を削除してよろしいでしょうか？') ){ return false; }
        $("#"+field+"_preview img:eq(0)").attr( 'src', 'img/white.jpg' ).css("width","16px");
        $("#"+field+"_file_del1").css("display","none");
        $("#form_entry [name='"+field+"']").val('');
        $("#form_entry [name='"+field+"_file']").val('');
    }

<?php $_smarty_tpl->_assignInScope('photo_index', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info', false, NULL, 'fields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
?>
 <?php $_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
?>
 <?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {?>
  <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
    previewImage('<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
',null,<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
,<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
);
  <?php }?>

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate_text').val(val);
        let d = JSON.parse($("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val());
        let prev_val = d.crop.rotate * -1;
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].rotate(prev_val);
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].rotate(val);
    });

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate_text').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_rotate').val(val);
        let d = JSON.parse($("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val());
        let prev_val = d.crop.rotate * -1;
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].rotate(prev_val);
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].rotate(val);
    });

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom_text').val(val);
        let prev_val = zoom[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] * -1;
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].zoom(prev_val);
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].zoom(val);
        zoom[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] = val;
    });

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom_text').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_zoom').val(val);
        let prev_val = zoom[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] * -1;
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].zoom(prev_val);
        cropper[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
].zoom(val);
        zoom[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] = val;
    });

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness_text').val(val);
        brightness[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] = parseInt(val);
        let d = JSON.parse($("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val());
        d.brightness = val;
        $("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val(JSON.stringify(d));
        $("#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect_image").css('filter', 'brightness(' + val + '%)');
    });

    $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness_text').on('input', function () {
        let val = $(this).val();
        $('#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_brightness').val(val);
        brightness[<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
] = parseInt(val);
        let d = JSON.parse($("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val());
        d.brightness = val;
        $("input[name='<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect']").val(JSON.stringify(d));
        $("#<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect_image").css('filter', 'brightness(' + val + '%)');
    });

  <?php $_smarty_tpl->_assignInScope('photo_index', 1);
?>
 <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


-->

<?php echo '</script'; ?>
>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['htmlfooter']->value)===null||$tmp==='' ? '' : $tmp);?>

<?php }
}
