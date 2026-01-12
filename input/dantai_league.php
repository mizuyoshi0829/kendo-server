<?php 
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'config.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'page.php';

	$objPage = new form_page();
	$category = get_field_string_number( $_GET, 'c', 1 );
	$entry_list = $objPage->get_entry_array_for_smarty($category);
	$place_array = $objPage->get_place_array_for_smarty(null);
	$place_match_no_array = $objPage->get_place_match_no_array_for_smarty(null);
	$league_list = $objPage->get_dantai_league_list($category);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>試合結果入力フォーム</title>
<link href="main.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php //print_r($data); ?>
<?php //print_r($_POST); ?>

<div class="container">
  <div class="content">
    <h2>団体戦<?php if($category==1): ?>男子<?php else: ?>女子<?php endif; ?>予選リーグ</h2>
<?php for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ): ?>
    <table id="ex_t" border="1" cellspacing="1" cellpadding="2">
      <tr>
        <td class="td_right2">
          <?php echo $league_list[$league_data]['name']; ?>
        </td>
        <td class="td_right2"></td>
        <td class="td_right2" colspan="<?php echo ($league_list[$league_data]['team_num']+3); ?>">&nbsp;</td>
      </tr>
      <tr>
        <td class="td_right">対戦学校</td>
        <td class="td_right" colspan="<?php echo $league_list[$league_data]['team_num']; ?>">試合
        <td class="td_right">得点</td>
        <td class="td_right">勝者数</td>
        <td class="td_right">勝本数</td>
        <td class="td_right">順位</td>
        </td>
      </tr>
      <tr>
        <td class="td_right">----</td>
<?php for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ): ?>
        <td class="td_right">
<?php foreach( $entry_list as $k => $v ): ?>
<?php if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $k ){ echo $v; } ?>
<?php endforeach; ?>
        </td>
<?php endfor; ?>
        <td class="td_right"></td>
        <td class="td_right"></td>
        <td class="td_right"></td>
        <td class="td_right"></td>
      </tr>
<?php $match_no = 1; ?>
<?php $match_no_index = 0; ?>
<?php for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ): ?>
      <tr>
        <td class="td_right">
<?php foreach( $entry_list as $k => $v ){ if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $k ){ echo $v; } } ?>
        </td>
<?php for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ): ?>
<?php if( $dantai_index_row == $dantai_index_col ): ?>
        <td class="td_right">----</td>
<?php elseif( $dantai_index_row < $dantai_index_col ): ?>
        <td class="td_right">
<?php foreach( $place_array as $k=>$v ){ if( $league_list[$league_data]['match'][$match_no_index]['place'] == $k ){ echo $v; } } ?>
<?php foreach( $place_match_no_array as $k=>$v ){ if( $league_list[$league_data]['match'][$match_no_index]['place_match_no'] == $k ){ echo $v; } } ?>
          <a href="dantai_result.php?c=<?php echo $category; ?>&l=<?php echo $league_list[$league_data]['id']; ?>&m=<?php echo $league_list[$league_data]['match'][$match_no_index]['match']; ?>"><?php if( $league_list[$league_data]['match'][$match_no_index]['winner']==1 ){ echo '○'; } elseif( $league_list[$league_data]['match'][$match_no_index]['winner']==2 ){ echo '△'; } else { echo '□'; } ?></a>
        </td>
<?php $match_no++; ?>
<?php $match_no_index++; ?>
<?php else: ?>
        <td class="td_right"></td>
<?php endif; ?>
<?php endfor; ?>
        <td class="td_right"><?php echo $league_list[$league_data]['team'][$dantai_index_row]['point']/2; ?></td>
        <td class="td_right"><?php echo $league_list[$league_data]['team'][$dantai_index_row]['win']; ?></td>
        <td class="td_right"><?php echo $league_list[$league_data]['team'][$dantai_index_row]['hon']; ?></td>
        <td class="td_right" <?php if( $league_list[$league_data]['team'][$dantai_index_row]['advanced'] == 1): ?>bgcolor="#ffbbbb"<?php endif; ?>><?php echo $league_list[$league_data]['team'][$dantai_index_row]['standing']; ?></td>
      </tr>
<?php endfor; ?>
      <tr>
        <td class="td_right" colspan="7">&nbsp;</td>
      </tr>
    </table>
    <br />
    <br />
<?php endfor; ?>
    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>
    <br />
    <br />
    </div>
    <!-- end .content --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
