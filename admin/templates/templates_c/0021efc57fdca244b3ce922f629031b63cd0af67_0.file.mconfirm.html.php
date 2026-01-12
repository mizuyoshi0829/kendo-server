<?php
/* Smarty version 3.1.30, created on 2023-06-26 13:57:54
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_64991ad26e35d9_96559782',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0021efc57fdca244b3ce922f629031b63cd0af67' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mconfirm.html',
      1 => 1687707468,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_64991ad26e35d9_96559782 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
<meta name="viewport"
content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link media="only screen and (max-device-width:480px)"
href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/mobile.css" type="text/css" rel="stylesheet" />
<link media="screen and (min-device-width:481px)" href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/style.css"
type="text/css" rel="stylesheet" />
<!--[if IE]>
<link href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
design.css" type="text/css" rel="stylesheet" />
<![endif]-->

<meta charset="UTF-8">
<title>入力フォーム</title>
</head>

<body>
<div id="main">
  <form id="form" name="form1" method="post" action="">
    <input name="mode" type="hidden" value="exec" />
    <div class="titlename">
      <h1>入力フォーム</h1>
    </div>
    <div class="discription">以下の内容で応募します。</div>
    <div class="f_box">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] != '' && $_smarty_tpl->tpl_vars['info']->value['kind'] != 'email2') {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title2') {?>
    <div class="titlename2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title1') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'data_title') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title1') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title2') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'discription') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box_end') {
} else { ?>
  <?php if ($_smarty_tpl->tpl_vars['info']->value['float_left'] == 0 && $_smarty_tpl->tpl_vars['info']->value['span_next'] == 0) {?>
      <div class="midasi"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</div>
  <?php }
}
if ($_smarty_tpl->tpl_vars['info']->value['span_next'] == 1) {?><br /><?php }
$_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'text') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
"><?php if ($_smarty_tpl->tpl_vars['info']->value['leader'] != '') {?>&nbsp;<?php echo $_smarty_tpl->tpl_vars['info']->value['leader'];
}
echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value], ENT_QUOTES, 'UTF-8', true);
if ($_smarty_tpl->tpl_vars['info']->value['tail'] != '') {?>&nbsp;<?php echo $_smarty_tpl->tpl_vars['info']->value['tail'];
}?></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'textarea') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
"><?php echo nl2br(htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value], ENT_QUOTES, 'UTF-8', true));?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'check_one' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'select' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'pref_select' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'radio') {
$_smarty_tpl->_assignInScope('field_name', ((string)$_smarty_tpl->tpl_vars['info']->value['field'])."_name");
?>
      <div class="f_radio"><?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['field_name']->value], ENT_QUOTES, 'UTF-8', true);?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'zip') {
$_smarty_tpl->_assignInScope('edit_field2', ((string)$_smarty_tpl->tpl_vars['info']->value['field'])."2");
?>
            <input id="<?php echo $_smarty_tpl->tpl_vars['ref_field']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['ref_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['ref_field']->value];?>
" class="text zip">
            -<input id="<?php echo $_smarty_tpl->tpl_vars['ref_field2']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['ref_field2']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['ref_field2']->value];?>
" class="text zip">
            <input id="<?php echo $_smarty_tpl->tpl_vars['info']->value['field'];?>
_input" type="button" name="<?php echo $_smarty_tpl->tpl_vars['info']->value['field'];?>
_input" value="住所自動入力" class="" onClick="zip_search();">
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel') {
$_smarty_tpl->_assignInScope('ref_field2', "ref_".((string)$_smarty_tpl->tpl_vars['info']->value['field'])."2");
?>
            +81(0)<input id="kanri_eng" type="text" name="<?php echo $_smarty_tpl->tpl_vars['ref_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['ref_field']->value];?>
" class="text">

<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
<?php if (isset($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]) && $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
            <div style="margin: 5px;">
                <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" src="../../admin/upload/<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
_01.jpg" width="240">
            </div>
<?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'name_kana') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name3') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
&nbsp;(<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
)
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name4') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
&nbsp;(<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
)<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name5') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>&nbsp;(異体字あり)<?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name6') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>&nbsp;(異体字あり)<?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel_fax') {
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
$_smarty_tpl->_assignInScope('edit_field_fax', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_fax");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
／<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_fax']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'mobile_tel') {
$_smarty_tpl->_assignInScope('edit_field_mobile', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mobile");
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mobile']->value];?>
／<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_org') {
$_smarty_tpl->_assignInScope('edit_field_school_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_school_name");
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_name']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name') {
$_smarty_tpl->_assignInScope('edit_field_school_org', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_org");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_org']->value];?>
立&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name_kana') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address') {
$_smarty_tpl->_assignInScope('edit_field_zip1', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip1");
$_smarty_tpl->_assignInScope('edit_field_zip2', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip2");
$_smarty_tpl->_assignInScope('edit_field_pref_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_pref_name");
?>
      <div class="tw8">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip1']->value];?>
-<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip2']->value];?>
&nbsp;<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_pref_name']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address_pref') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
      <div class="tw8">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_j') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'gakunen_dan_j') {
$_smarty_tpl->_assignInScope('gakuen_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_gakunen_name");
$_smarty_tpl->_assignInScope('dan_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_dan");
?>
      <div class="f_radio"><?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['gakuen_name']->value], ENT_QUOTES, 'UTF-8', true);?>
／<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['dan_name']->value], ENT_QUOTES, 'UTF-8', true);?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'gakunen_dan_e') {
$_smarty_tpl->_assignInScope('gakuen_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_gakunen_name");
$_smarty_tpl->_assignInScope('dan_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_dan");
?>
      <div class="f_radio"><?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['gakuen_name']->value], ENT_QUOTES, 'UTF-8', true);?>
／<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['dan_name']->value], ENT_QUOTES, 'UTF-8', true);?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'yosen_rank') {
$_smarty_tpl->_assignInScope('edit_field_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_name");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_name']->value];?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'date') {
$_smarty_tpl->_assignInScope('edit_field_year', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_year_name");
$_smarty_tpl->_assignInScope('edit_field_month', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_month");
$_smarty_tpl->_assignInScope('edit_field_day', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_day");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_year']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_month']->value];?>
月<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_day']->value];?>
日
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'year_month') {
$_smarty_tpl->_assignInScope('edit_field_year', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_year_name");
$_smarty_tpl->_assignInScope('edit_field_month', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_month");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_year']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_month']->value];?>
月
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'year_month2') {
$_smarty_tpl->_assignInScope('edit_field_year', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_year_name");
$_smarty_tpl->_assignInScope('edit_field_month', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_month");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_year']->value];
echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_month']->value];?>
月
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'hidden') {
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'include') {
$_smarty_tpl->_assignInScope('include_file', "reg/mconfirm_".((string)$_SESSION['auth']['series'])."_".((string)$_smarty_tpl->tpl_vars['info']->value['select_info']).".html");
$_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['include_file']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

<?php }
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      <div class="clear_fix"></div>
    </div>
    <div class="clear_fix"></div>
    <div class="button">
      <input name="exec" type="submit" value="応募">
      <input name="reinput" type="submit" value="再入力">
    </div>
  </form>
</div>
<footer>
  <div class="jump"><a href="#main">このページのトップへ</a>
    <div class="clear_fix"></div>
  </div>
</footer>
</body>
</html>
<?php }
}
