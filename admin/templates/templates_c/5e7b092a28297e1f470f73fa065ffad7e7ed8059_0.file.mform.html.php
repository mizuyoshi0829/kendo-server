<?php
/* Smarty version 3.1.30, created on 2024-07-22 13:11:47
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_669ddc034e8d25_39482500',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5e7b092a28297e1f470f73fa065ffad7e7ed8059' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/reg/mform.html',
      1 => 1721621469,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669ddc034e8d25_39482500 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_html_checkboxes')) require_once '/home/keioffice/i-kendo.net/public_html/kendo/admin/Smarty/plugins/function.html_checkboxes.php';
if (!is_callable('smarty_function_html_options')) require_once '/home/keioffice/i-kendo.net/public_html/kendo/admin/Smarty/plugins/function.html_options.php';
if (!is_callable('smarty_function_html_radios')) require_once '/home/keioffice/i-kendo.net/public_html/kendo/admin/Smarty/plugins/function.html_radios.php';
?>
<!doctype html>
<html>
<head>
<meta name="viewport"
content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<link media="only screen and (max-device-width:480px)" href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/mobile.css" type="text/css" rel="stylesheet" />
<link media="screen and (min-device-width:481px)" href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
css/style.css" type="text/css" rel="stylesheet" />
<!--[if IE]>
<link href="<?php echo $_smarty_tpl->tpl_vars['root_url']->value;?>
design.css" type="text/css" rel="stylesheet" />
<![endif]-->
<link  href="../css/cropper.css" rel="stylesheet">

<meta charset="UTF-8">
<title>入力フォーム</title>
<?php if ($_smarty_tpl->tpl_vars['mform_msg']->value != '') {
echo '<script'; ?>
 type="text/javascript">

window.onload = function(){

    alert( "<?php echo $_smarty_tpl->tpl_vars['mform_msg']->value;?>
" );
<?php if ($_smarty_tpl->tpl_vars['pdf_name']->value != '') {?>
    alert( "PDF申込書をダウンロードします。" );
    pdf_download();
<?php }?>

};

<?php echo '</script'; ?>
>
<?php }?>

<?php echo '<script'; ?>
 type="text/javascript" src="../js/jquery-3.0.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="../js/cropper.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
<!--
<?php if ($_smarty_tpl->tpl_vars['pdf_name']->value != '') {?>
let pdf_base64 = "<?php echo $_smarty_tpl->tpl_vars['pdf_base64']->value;?>
";
let pdf_name = "<?php echo $_smarty_tpl->tpl_vars['pdf_name']->value;?>
";

function pdf_download()
{
    let element = document.createElement('a');
    element.href = 'data:image/pdf;base64,' + encodeURI(pdf_base64);
    element.download = pdf_name;
    element.target = '_blank';
    element.click();
}
<?php }?>

let cropper = [ null, null ];
let zoom = [ 0, 0 ];
let brightness = [100,100];

function showActiveIndicator()
{
	$('#actindicator').show();
	$('#actindicator_fade').css("opacity", "0.3").show();
}

function hideActiveIndicator()
{
    $('#actindicator').hide();
    $('#actindicator_fade').hide();
}

// ファイルのアップロード
function previewImage(field,imageUrl,width,field_index)
{
    const img = $('#'+field+'_file_preview_image').eq(0);
    const img_effect = $("input[name='"+field+"_effect']").val();
    let data = null;
    if( img_effect != '' ){
        let jdata = JSON.parse(img_effect);
        data = jdata.crop;
        brightness[field_index] = jdata.brightness == 0 ? 100: jdata.brightness;
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

-->

<?php echo '</script'; ?>
>

</head>
<body>
<div id="main">
  <div id="actindicator"><img src="../img/466.gif" width="48" height="48" alt="Loading..." /></div>
  <div id="actindicator_fade"></div>
  <form id="form_entry" name="form1" method="post" action="" enctype="multipart/form-data">
    <input name="mode" type="hidden" value="confirm" />
    <input type="hidden" name="imageupload" value="0">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'hidden') {?>
    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['info']->value['field'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >
<?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

<?php $_smarty_tpl->_assignInScope('photo_index', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] != '' && $_smarty_tpl->tpl_vars['info']->value['kind'] != 'hidden') {
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title1') {?>
    <div <?php if ($_smarty_tpl->tpl_vars['info']->value['field'] != '') {?>id="<?php echo $_smarty_tpl->tpl_vars['info']->value['field'];?>
" <?php }?>class="titlename"><h1><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];
if ($_smarty_tpl->tpl_vars['info']->value['placeholder'] != '') {?>&nbsp;<a <?php echo $_smarty_tpl->tpl_vars['info']->value['select_info'];?>
 ><?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
</a><?php }?></h1></div>
<?php if ($_smarty_tpl->tpl_vars['mform_msg']->value != '') {?>
    <div class="discription"><?php echo $_smarty_tpl->tpl_vars['mform_msg']->value;?>
</div>
<?php }?>
    <div class="f_box">
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'title2') {?>
      <div <?php if ($_smarty_tpl->tpl_vars['info']->value['field'] != '') {?>id="<?php echo $_smarty_tpl->tpl_vars['info']->value['field'];?>
" <?php }?>class="titlename2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];
echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];
echo $_smarty_tpl->tpl_vars['info']->value['select_info'];?>
</h2></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'data_title') {?>
      <div class="data_title"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title1') {?>
      <div class="dantai_title1"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'dantai_title2') {?>
      <div class="dantai_title2"><h2><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</h2></div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'discription') {?>
      <div class="discription"><?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box') {?>
    <div class="f_box">
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'f_box_end') {?>
      <div class="clear_fix"></div>
    </div>
<?php } else { ?>
  <?php if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name_kana' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'name_kana') {?>
      <div class="midasi"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
(全角)</div>
  <?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'email2' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel_fax' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'mobile_tel' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'address') {?>
      <div class="midasi"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
(半角)</div>
  <?php } else { ?>
      <div class="midasi"><?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
</div>
  <?php }
}
$_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'text') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >
        <?php echo $_smarty_tpl->tpl_vars['info']->value['tail'];?>

        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'textarea') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <textarea name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" cols="40" rows="3" maxlength="100" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" ><?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</textarea>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check') {?>
      <div class="f_radio">
        <?php echo smarty_function_html_checkboxes(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'&nbsp;'),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'check_one') {?>
      <div class="f_radio">
        <?php echo smarty_function_html_checkboxes(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'&nbsp;'),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'select' || $_smarty_tpl->tpl_vars['info']->value['kind'] == 'pref_select') {?>
      <div class="f_select">
        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'radio') {?>
      <div class="f_radio">
        <?php echo smarty_function_html_radios(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['info']->value['sel'],'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value],'separator'=>'&nbsp;'),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {
$_smarty_tpl->_assignInScope('edit_field_effect', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_effect");
$_smarty_tpl->_assignInScope('edit_field_rotate', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_rotate");
?>
      <div class="tw200">
<?php if ($_smarty_tpl->tpl_vars['info']->value['text_width'] == 1) {?>
        <div id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview" class="photo_preview">
<?php } else { ?>
        <div id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview" class="photo_preview2">
<?php }
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
          <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview_image" src="/kendo/admin/upload/org/<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
.jpg" />
        </div>

<?php } else { ?>
          <img id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_preview_image" src="" />
        </div>

<?php }?>
        <div class="photo_preview_sample">
          <?php echo $_smarty_tpl->tpl_vars['info']->value['tail'];?>
<br />
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
        </div>
        <div class="clear_fix"></div>
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file_op" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_file" type="file" value="" onchange="updateImage('<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
',<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
,<?php echo $_smarty_tpl->tpl_vars['photo_index']->value;?>
);" />
        <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
">
        <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
_effect" value="<?php echo htmlspecialchars($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_effect']->value], ENT_QUOTES, 'UTF-8', true);?>
">
      </div>
<?php $_smarty_tpl->_assignInScope('photo_index', 1);
} elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="8" class="text" placeholder="名字" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name_kana') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" class="text" placeholder="名字(全角)" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前(全角)" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name3') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="8" class="text" placeholder="名字" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
" class="text" placeholder="備考：異体字など" style="width: 8em;" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name4') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="8" class="text" placeholder="名字" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value];?>
" class="text" placeholder="備考：異体字など" style="width: 8em;" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
" class="text" placeholder="表示名" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name5') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="8" class="text" placeholder="名字" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="1" class="text" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>checked="checked" <?php }?> style="width: 1em;">異体字あり
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'name6') {
$_smarty_tpl->_assignInScope('edit_field_sei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_sei");
$_smarty_tpl->_assignInScope('edit_field_mei', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mei");
$_smarty_tpl->_assignInScope('edit_field_add', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_add");
$_smarty_tpl->_assignInScope('edit_field_disp', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_disp");
?>
      <div class="tw5 name_font">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_sei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_sei']->value];?>
" maxlength="8" class="text" placeholder="名字" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mei']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mei']->value];?>
" class="text" placeholder="名前" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_add']->value;?>
" value="1" class="text" <?php if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_add']->value] == 1) {?>checked="checked" <?php }?> style="width: 1em;">異体字あり
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_disp']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_disp']->value];?>
"  >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'tel_fax') {
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
$_smarty_tpl->_assignInScope('edit_field_fax', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_fax");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
" class="text" placeholder="電話番号(半角)" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_fax']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_fax']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_fax']->value];?>
" class="text" placeholder="FAX番号(半角)" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'mobile_tel') {
$_smarty_tpl->_assignInScope('edit_field_mobile', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_mobile");
$_smarty_tpl->_assignInScope('edit_field_tel', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_tel");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_mobile']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_mobile']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_mobile']->value];?>
" class="text" placeholder="携帯番号(半角)" >
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_tel']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_tel']->value];?>
" class="text" placeholder="電話番号(半角)" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_org') {
$_smarty_tpl->_assignInScope('edit_field_school_name', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_school_name");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_name']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_name']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_name']->value];?>
" class="text" placeholder="○○立" >

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name') {
$_smarty_tpl->_assignInScope('edit_field_school_org', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_org");
?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_org']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_school_org']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_school_org']->value];?>
" class="text" placeholder="○○" >立
        <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'school_name_kana') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
(全角)" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address') {
$_smarty_tpl->_assignInScope('edit_field_zip1', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip1");
$_smarty_tpl->_assignInScope('edit_field_zip2', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_zip2");
$_smarty_tpl->_assignInScope('edit_field_pref', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_pref");
?>
      <div class="tw8">
        <input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip1']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip1']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip1']->value];?>
" class="text" placeholder="郵便番号" >
        -<input id="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip2']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field_zip2']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_zip2']->value];?>
" class="text" placeholder="郵便番号"><br />

        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field_pref']->value,'options'=>$_smarty_tpl->tpl_vars['pref_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_pref']->value]),$_smarty_tpl);?>

        <input style="width: 400px;" id="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="住所" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'address_pref') {?>
      <div class="tw8">
        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['pref_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_j') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['grade_junior_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'grade_e') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['grade_elementary_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
(半角)" >
        <?php if ($_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?><br /><div class="f_error"><?php echo $_SESSION['e'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
</div><?php }?>
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'email2') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
" class="text" placeholder="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
(半角)" >
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'gakunen_dan_j') {?>
      <div class="f_radio_2">
<?php $_smarty_tpl->_assignInScope('edit_field_gakunen', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_gakunen");
?>
          <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field_gakunen']->value,'options'=>$_smarty_tpl->tpl_vars['grade_junior_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_gakunen']->value]),$_smarty_tpl);?>


      </div>
      <div class="tw6">
<?php $_smarty_tpl->_assignInScope('edit_field_dan', ((string)$_smarty_tpl->tpl_vars['edit_field']->value)."_dan");
?>
          <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field_dan']->value,'options'=>$_smarty_tpl->tpl_vars['dan_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field_dan']->value]),$_smarty_tpl);?>


      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'yosen_rank') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
        <?php echo smarty_function_html_options(array('name'=>$_smarty_tpl->tpl_vars['edit_field']->value,'options'=>$_smarty_tpl->tpl_vars['yosen_rank_array']->value,'selected'=>$_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value]),$_smarty_tpl);?>

      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'form_pdf') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
">
          <input name="pdf_download" type="submit" value="PDF申込書ダウンロード">
          <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value];?>
">
      </div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'hidden') {?>
      <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['edit_field']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
" >
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'literal') {?>
      <div class="tw<?php echo $_smarty_tpl->tpl_vars['info']->value['text_width'];?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value['placeholder'];?>
</div>
<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'include') {
$_smarty_tpl->_assignInScope('include_file', "reg/mform_".((string)$_SESSION['auth']['series'])."_".((string)$_smarty_tpl->tpl_vars['info']->value['select_info']).".html");
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
      <input name="exec" type="submit" value="確認">
      <input name="cancel" type="submit" value="戻る">
    </div>
  </form>
</div>
<footer>
  <div class="jump"><a href="#main">このページのトップへ</a>
    <div class="clear_fix"></div>
  </div>
</footer>
<?php echo '<script'; ?>
 type="text/javascript">

<!--


<?php $_smarty_tpl->_assignInScope('photo_index', 0);
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['fields_info']->value, 'info', false, NULL, 'fields', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['info']->value) {
$_smarty_tpl->_assignInScope('edit_field', $_smarty_tpl->tpl_vars['info']->value['field']);
if ($_smarty_tpl->tpl_vars['info']->value['kind'] == 'photo') {
if ($_SESSION['p'][$_smarty_tpl->tpl_vars['edit_field']->value] != '') {?>
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

<?php $_smarty_tpl->_assignInScope('photo_index', 1);
}
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>



-->

<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
