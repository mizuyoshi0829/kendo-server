<?php 
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'config.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'page.php';

	$objPage = new form_page();
	$category = get_field_string_number( $_GET, 'c', 1 );
	$entry_list = $objPage->get_entry_array_for_smarty($category);
	$place_array = $objPage->get_place_array_for_smarty(null);
	$place_match_no_array = $objPage->get_place_match_no_array_for_smarty(null);
//print_r($list);
	$dantai_league_array = $objPage->get_dantai_league_array_for_smarty($category);
	$dantai_league_standing_array = $objPage->get_league_standing_array_for_smarty(null);
	$list = $objPage->get_entry_data_list( $category );
	$tournament_data = $objPage->get_dantai_tournament_data($category);
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

    <h2>団体戦<?php if($category==1): ?>男子<?php else: ?>女子<?php endif; ?>決勝トーナメント</h2>
    <table id="ex_t" border="1" cellspacing="1" cellpadding="2">
      <tr>
        <td class="td_right" colspan="2">対戦学校</td>
        <td class="td_right" colspan="3">試合
        </td>
      </tr>
<?php for( $tournament_team=0; $tournament_team < count($tournament_data['team']); $tournament_team++ ): ?>
      <tr>
        <td class="td_right" colspan="2">
<?php foreach($entry_list as $k => $v){ if($tournament_data['team'][$tournament_team]['team']==$k){ echo $v; } } ?>
        </td>
<?php for( $tournament_match_offset=0; $tournament_match_offset<$tournament_data['match_level']; $tournament_match_offset++ ): ?>
<?php $match_no = $tournament_data['match_array'][$tournament_team][$tournament_match_offset]-1; ?>
<?php if( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] > 0 ): ?>
<?php if( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] < 1000 ): ?>
        <td class="td_right" rowspan="2">
          <?php foreach( $place_array as $k => $v ){ if( $tournament_data['match'][$match_no]['place']==$k ){ echo $v; } } ?>
          <?php foreach( $place_match_no_array as $k => $v ){ if( $tournament_data['match'][$match_no]['place_match_no']==$k ){ echo $v; } } ?>
          <a href="dantai_result.php?c=<?php echo $category; ?>&t=<?php echo $tournament_data['id']; ?>&m=<?php echo $tournament_data['match'][$match_no]['match']; ?>">結果</a>
        </td>
<?php elseif( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] >= 2000 ): ?>
<?php $name_offset = ( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] % 1000 ) - 1; ?>
        <td class="td_right"><?php echo $tournament_data['match'][$name_offset]['team2_name']; ?></td>
<?php elseif( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] >= 1000 ): ?>
<?php $name_offset = ( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] % 1000 ) - 1; ?>
        <td class="td_right"><?php echo $tournament_data['match'][$name_offset]['team1_name']; ?></td>
<?php else: ?>
        <td class="td_right"></td>
<?php endif; ?>
<?php elseif( $tournament_data['match_array'][$tournament_team][$tournament_match_offset] == 0 ): ?>
        <td class="td_right"></td>
<?php endif; ?>
<?php endfor; ?>
<?php endfor; ?>
    </table>
    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>
    <br />
    <br />
    </div>
    <!-- end .content --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
