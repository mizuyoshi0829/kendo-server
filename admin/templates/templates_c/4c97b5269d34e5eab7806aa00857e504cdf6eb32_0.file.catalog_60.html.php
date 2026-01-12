<?php
/* Smarty version 3.1.30, created on 2024-07-23 03:03:58
  from "/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/catalog_60.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_669e9f0e211536_88101658',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4c97b5269d34e5eab7806aa00857e504cdf6eb32' => 
    array (
      0 => '/home/keioffice/i-kendo.net/public_html/kendo/admin/templates/templates/admin/catalog_60.html',
      1 => 1721671400,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_669e9f0e211536_88101658 (Smarty_Internal_Template $_smarty_tpl) {
?>
<style>
<?php $_smarty_tpl->_assignInScope("font-size", "9");
$_smarty_tpl->_assignInScope("font-hight", "12");
$_smarty_tpl->_assignInScope('font_line_height', "21.2");
$_smarty_tpl->_assignInScope('font_line_height2', "22");
$_smarty_tpl->_assignInScope("one-hight", "108");
?>

html,body { font-family: ipa; font-size: 11pt; }
p { text-align: center; margin: 0pt; padding:2pt; }
p.pref { text-align: justify; margin: 0pt; padding:3pt; word-wrap: break-word; }
p.pk { text-align: justify; margin: 0pt; padding:5pt; }
p.ps { text-align: center; margin: 0pt; padding:2pt; }
p.ps2 { text-align: center; margin: 0pt; padding:3pt 2pt 3pt 2pt; font-size: 9pt; }
p.ps3 { text-align: center; margin: 0pt; padding:3.5pt 2pt 3.5pt 2pt; font-size: 8pt; }
p.ps4 { text-align: center; margin: 0pt; padding:5pt 2pt 5pt 2pt; font-size: 6.5pt; }
p.ps5 { text-align: center; margin: 0pt; padding:6pt 2pt 6pt 2pt; font-size: 6pt; }
span { padding-left: 12pt; }
td { text-align: justify; }

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

  <div style="width: 310pt; height: 30pt; padding: 0pt; margin: auto; border: none; font-size: 22pt;">男子個人戦出場選手</div>
<?php
$__section_datalist_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist'] : false;
$__section_datalist_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['list']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_datalist_0_total = $__section_datalist_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = new Smarty_Variable(array());
if ($__section_datalist_0_total != 0) {
for ($__section_datalist_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] = 0; $__section_datalist_0_iteration <= $__section_datalist_0_total; $__section_datalist_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']++){
?>
  <div style="width: 620pt; height: 220pt; padding: 2pt; margin: 0px; border: none; float: left;">
    <div class="border_none" style="width: 36pt; height: 210pt; float: left; font-size: 22pt;">
      <p lang="ja" class="pref"><?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['pref_name'];?>
</p>
    </div>
<?php
$__section_rank_index_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index'] : false;
$_smarty_tpl->tpl_vars['__smarty_section_rank_index'] = new Smarty_Variable(array());
if (true) {
for ($__section_rank_index_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] = 1; $__section_rank_index_1_iteration <= 4; $__section_rank_index_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']++){
?>
    <div class="border_none" style="width: 130pt; height: 210pt; float: left;">
      <div class="border_none" style="width: 110pt; height: 120pt; ">
        <img src="upload/pdf/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['photo'], ENT_QUOTES, 'UTF-8', true);?>
_01.jpg" style="width: <?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['photo_width'];?>
pt; height: <?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['photo_height'];?>
pt; padding: 0 <?php echo $_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['photo_margin_x'];?>
px;">
      </div>
      <div class="border_bt" style="width: 110pt; height: 18pt; ">
        <p lang="ja"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['player_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['player_mei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;選手</p>
      </div>
      <div class="border_bt" style="width: 110pt; height: 18pt; ">
        <p lang="ja" class="ps<?php if (mb_strlen($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['school_name'],'UTF-8') >= 16) {?>5<?php } elseif (mb_strlen($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['school_name'],'UTF-8') >= 15) {?>4<?php } elseif (mb_strlen($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['school_name'],'UTF-8') >= 12) {?>3<?php } elseif (mb_strlen($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['school_name'],'UTF-8') >= 10) {?>2<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['school_name'], ENT_QUOTES, 'UTF-8', true);?>
</p>
      </div>
      <div class="border_bt" style="width: 110pt; height: 18pt; ">
        <p lang="ja"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['player_gakunen'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['player_dan'], ENT_QUOTES, 'UTF-8', true);?>
</p>
      </div>
      <div class="border_bt" style="width: 110pt; height: 18pt; ">
        <p lang="ja"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['insotu1_sei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['list']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_datalist']->value['index'] : null)]['rank'][(isset($_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_rank_index']->value['index'] : null)]['insotu1_mei'], ENT_QUOTES, 'UTF-8', true);?>
&nbsp;監督</p>
      </div>
    </div>
<?php
}
}
if ($__section_rank_index_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_rank_index'] = $__section_rank_index_1_saved;
}
?>
  </div>
<?php
}
}
if ($__section_datalist_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_datalist'] = $__section_datalist_0_saved;
}
}
}
