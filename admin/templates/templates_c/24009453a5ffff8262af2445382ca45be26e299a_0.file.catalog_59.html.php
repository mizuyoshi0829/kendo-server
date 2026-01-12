<?php
/* Smarty version 3.1.30, created on 2024-07-26 12:34:17
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/catalog_59.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_66a31939529586_82793024',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '24009453a5ffff8262af2445382ca45be26e299a' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/catalog_59.html',
      1 => 1721964816,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66a31939529586_82793024 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>
  <?php $_smarty_tpl->_assignInScope("font-size", "9");
?>
  <?php $_smarty_tpl->_assignInScope("font-hight", "12");
?>
  <?php $_smarty_tpl->_assignInScope('font_line_height', "21");
?>
  <?php $_smarty_tpl->_assignInScope('font_line_height2', "22");
?>
  <?php $_smarty_tpl->_assignInScope('name_width', "122");
?>
  <?php $_smarty_tpl->_assignInScope('nen_width', "60");
?>
  <?php $_smarty_tpl->_assignInScope("one-hight", "108");
?>
  <?php $_smarty_tpl->_assignInScope("border-color", "cmyk(0,0,0,100)");
?>
  <?php $_smarty_tpl->_assignInScope("border-white-color", "cmyk(0,0,0,0)");
?>
  <?php $_smarty_tpl->_assignInScope("photo-width", "380");
?>
  
  html,body { font-family: ipa; font-size: 12pt; }
  p { text-align: center; margin: 0pt; padding:2.5pt; }
  p.p3 { text-align: center; margin: 0pt; padding: 2.5pt; }
  p.p3s { text-align: center; margin: 0pt; padding:2.5pt 1pt 2.5pt 1pt; }
  p.pk { text-align: left; margin: 0pt; padding:5pt; }
  p.pp { text-align: center; margin: 0pt; padding:2pt; font-size: 15pt; font-weight: bold; }
  p.ps { text-align: left; margin: 0pt; padding:2pt 2pt 2pt 8pt; font-size: 15pt; font-weight: bold; }
  span { padding-left: 12pt; }
  td { text-align: center; }
  
  .border_bt { border-top: none; border-right: none; border-bottom: solid 1pt cmyk(0,0,0,100); border-left: none; }
  .border_r { border-top: none; border-right: solid 1pt cmyk(0,0,0,100); border-bottom: none; border-left: none; }
  .border_none { border: none; }
  .border_all { border: solid 2pt cmyk(0,0,0,100); }
  .cell_div_ { display: inline; text-align: justify; margin: 0pt; padding:2pt; }
  .cell_div20_ { display: inline; text-align: justify; margin: 0pt; padding:2pt; width: 20px; }
  .cell_div30_ { display: inline; text-align: justify; margin: 0pt; padding:2pt; width: 26px; }
  .cell_div_grade_ { display: inline; text-align: justify; margin: 0pt; padding-left: 24pt;width: 26px; }
  .cell_div { text-align: justify; margin: 0pt; padding:2pt; float: left; }
  .cell_div20 { text-align: justify; margin: 0pt; padding:2pt; float: left; width: 20px; }
  .cell_div30 { text-align: justify; margin: 0pt; padding:2pt; float: left; width: 26px; }
  .cell_div_grade { text-align: justify; margin: 0pt; padding-left: 24pt; overflow:hidden; }
  .smallfont { font-size: 6pt; }
  .smallfont2 { font-size: 5pt; }
  .member { height: 20pt; text-align: justify; margin: 0pt; padding:2pt; }
  
  
  </style>
  
  <?php
$__section_datalist_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist'] : false;
$__section_datalist_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_datalist_0_total = $__section_datalist_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = new Smarty_Variable(array());
if ($__section_datalist_0_total != 0) {
for ($__section_datalist_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] = 0; $__section_datalist_0_iteration <= $__section_datalist_0_total; $__section_datalist_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']++){
?>
    <div style="width: 600pt; height: 230pt; padding: 2pt; margin: 0px; border: none;">
      <div class="border_all" style="width: 100%; height: 288px; margin: 0px; padding: 0px;">
        <div class="border_none clearfix" style="overflow:hidden; height: 216pt;">
          <div class="border_r" style="width: 290pt; height: 192pt; float: left; padding: 0pt;">
            <div class="border_bt" style="overflow:hidden; height: 20pt;">
              <div class="border_r" style="width: 25%; float: left;"><p lang="ja" class="pp"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['pref_name'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div style="float: left; border: none;"><p lang="ja" class="ps"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['school_name'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">選手</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">氏名</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">学年</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">段位</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">監督</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['insotu1_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['insotu1_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"></p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"></p></div>
            </div>
            <div class="border_bt" style="overflow:hidden; height: 20pt;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">先鋒</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player1_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player1_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player1_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player1_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">次鋒</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player2_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player2_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player2_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player2_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">中堅</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player3_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player3_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player3_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player3_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden; height: 20pt;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">副将</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player4_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player4_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player4_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player4_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">大将</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player5_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player5_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player5_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player5_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_bt" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3">補員</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player6_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player6_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player6_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player6_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
            <div class="border_none" style="overflow:hidden;">
              <div class="border_r" style="width: 45pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height2']->value;?>
pt;"><p lang="ja" class="p3">補員</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['name_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height2']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player7_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player7_mei'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_r" style="width: <?php echo $_smarty_tpl->tpl_vars['nen_width']->value;?>
pt; float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height2']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player7_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
              <div class="border_none" style="float: left; height: <?php echo $_smarty_tpl->tpl_vars['font_line_height2']->value;?>
pt;"><p lang="ja" class="p3"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['player7_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p></div>
            </div>
          </div>
          <div class="border_none" style="float: left; overflow: hidden;">
            <div style="text-align: center; padding: 0 0 0 0.5px;">
              <img src="/kendo/admin/upload/pdf/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['photo'], ENT_QUOTES, 'UTF-8', true);?>
_01.jpg" width="411" height="296">
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
}
}
if ($__section_datalist_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = $__section_datalist_0_saved;
}
?>
  <?php }
}
