<?php
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/common.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/config.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/navi.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/current_input_match_no.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_2b.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_3.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_4.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_5.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_6.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/page.php';

	define( '__HTTP_BASE__', 'http://www.nagano-zenchu.jp/');

	session_start();
	$no = get_field_string_number( $_GET, 'n', 0 );
	$s = get_field_string( $_GET, 's' );
	$m1 = get_field_string_number( $_GET, 'm1', 0 );
	$m2 = get_field_string_number( $_GET, 'm2', 0 );
	$objPage = new form_page();
//	$navi = $objPage->get_place_navi_data( $place );

	$place_match_no = array();
	if( $m1 > 0 ){
		$place_match_no[1] = $m1;
		$place_match_no[2] = $m2;
	} else {
		$place_match_no[1] = $__current_input_match_no__[1];
		$place_match_no[2] = $__current_input_match_no__[2];
	}
	$match = array();
	$match_info = array();
	$navi = array();
	for( $place = 1; $place <= 2; $place++ ){
		$match_info[$place] = $navi_info[$place][$place_match_no[$place]];
		$match[$place] = $navi_info[$place][$place_match_no[$place]]['match'];
		$navi[$place] = array();
		if( $place_match_no[$place] > 0 ){
			$navi[$place]['prev'] = '<a href="result_realtime.php?';
			for( $place2 = 1; $place2 <= 2; $place2++ ){
				if( $place2 > 1 ){ $navi[$place]['prev'] .= '&'; }
				if( $place2 == $place ){
					$navi[$place]['prev'] .= 'm'.$place2.'='.($place_match_no[$place]-1);
				} else {
					$navi[$place]['prev'] .= 'm'.$place2.'='.$place_match_no[$place2];
				}
			}
			$navi[$place]['prev'] .= '">←前の試合</a>&nbsp;';
		} else {
			$navi[$place]['prev'] = '';
		}
		if( $place_match_no[$place] < count($navi_info[$place]) ){
			$navi[$place]['next'] = '&nbsp;<a href="result_realtime.php?';
			for( $place2 = 1; $place2 <= 2; $place2++ ){
				if( $place2 > 1 ){ $navi[$place]['next'] .= '&'; }
				if( $place2 == $place ){
					$navi[$place]['next'] .= 'm'.$place2.'='.($place_match_no[$place]+1);
				} else {
					$navi[$place]['next'] .= 'm'.$place2.'='.$place_match_no[$place2];
				}
			}
			$navi[$place]['next'] .= '">次の試合→</a>';
		} else {
			$navi[$place]['next'] = '';
		}
	}
	//$series = get_field_string_number( $match_info, 'series', 0 );
	//$series_mw = get_field_string( $match_info, 'series_mw' );
	//$league = get_field_string_number( $match_info, 'league', 0 );
	//$tournament = get_field_string_number( $match_info, 'tournament', 0 );

//print_r($_SESSION);
//echo $match;
//print_r($match_info);

//print_r($data['matches']);
//	$series_mw = $data['series_mw'];
//print_r($place_match_no);
//print_r($match);
//print_r($data);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Refresh" content="20">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>試合結果リアルタイム表示</title>
<link href="realtime.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php //print_r($data); ?>
<?php //print_r($_POST); ?>

<div class="container">
<?php for( $place = 1; $place <= 2; $place++ ): ?>
<?php
	$hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
	$hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
	$data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
	if( $place_match_no[$place] > 2 && $navi_info[$place][$place_match_no[$place]-2]['series'] >= 9 ){
		$data_prev2 = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no[$place]-2]['series'], $navi_info[$place][$place_match_no[$place]-2]['series_mw'], $navi_info[$place][$place_match_no[$place]-2]['match'] );
		$data['matches'][1] = $data_prev2['matches'];
		for( $waza = 1; $waza <= 3; $waza++ ){
			if( $data_prev2['matches']['waza1_'.$waza] != 0 ){
				$hon1[1]++;
			}
			if( $data_prev2['matches']['waza2_'.$waza] != 0 ){
				$hon2[1]++;
			}
		}
	} else {
		$data_prev2 = array();
	}
	if( $place_match_no[$place] > 1 && $navi_info[$place][$place_match_no[$place]-1]['series'] >= 9 ){
		$data_prev = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no[$place]-1]['series'], $navi_info[$place][$place_match_no[$place]-1]['series_mw'], $navi_info[$place][$place_match_no[$place]-1]['match'] );
		$data['matches'][2] = $data_prev['matches'];
		for( $waza = 1; $waza <= 3; $waza++ ){
			if( $data_prev['matches']['waza1_'.$waza] != 0 ){
				$hon1[2]++;
			}
			if( $data_prev['matches']['waza2_'.$waza] != 0 ){
				$hon2[2]++;
			}
		}
	} else {
		$data_prev = array();
	}
	$data_now = $objPage->get_kojin_tournament_one_result( $match_info[$place]['series'], $match_info[$place]['series_mw'], $match[$place] );
	$data['matches'][3] = $data_now['matches'];
	for( $waza = 1; $waza <= 3; $waza++ ){
		if( $data_now['matches']['waza1_'.$waza] != 0 ){
			$hon1[3]++;
		}
		if( $data_now['matches']['waza2_'.$waza] != 0 ){
			$hon2[3]++;
		}
	}
	if( $place_match_no[$place] < count($navi_info[$place]) && $navi_info[$place][$place_match_no[$place]+1]['series'] >= 9 ){
		$data_next = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no[$place]+1]['series'], $navi_info[$place][$place_match_no[$place]+1]['series_mw'], $navi_info[$place][$place_match_no[$place]+1]['match'] );
		$data['matches'][4] = $data_next['matches'];
		for( $waza = 1; $waza <= 3; $waza++ ){
			if( $data_next['matches']['waza1_'.$waza] != 0 ){
				$hon1[4]++;
			}
			if( $data_next['matches']['waza2_'.$waza] != 0 ){
				$hon2[4]++;
			}
		}
	} else {
		$data_next = array();
	}
?>
  <div class="content">
    <div align="center" class="tb_score_in">
      <div class="tb_score_title"><?php echo $match_info[$place]['place_name']; ?></div>
      <div class="clearfloat"></div>
<?php
	for( $i1 = 1; $i1 <= 4; $i1++ ){
		echo '      <div class="tb_frame">'."\n";
		echo '        <div class="tb_frame_title tb_frame_bbottom">';
		if( $i1 == 1 ){
			echo '前々試合';
		} else if( $i1 == 2 ){
			echo '前試合';
		} else if( $i1 == 3 ){
		} else if( $i1 == 4 ){
			echo '次試合';
		}
		echo '</div>'."\n";
		echo '        <div class="tb_frame_content';
		if( $match_info[$place]['series'] <= 8 && $data['matches'][$i1]['player1'] != 0 && $data['matches'][$i1]['player1'] != $i1 ){
			echo ' tb_frame_hoin_player';
		}
		echo '" id="player1_'.$i1.'">';
		if( $i1 == 1 ){
			echo string_insert_br( base64_decode($data_prev2['players'][1]['name_str2']) );
		} else if( $i1 == 2 ){
			echo string_insert_br( base64_decode($data_prev['players'][1]['name_str2']) );
		} else if( $i1 == 3 ){
			echo string_insert_br( base64_decode($data_now['players'][1]['name_str2']) );
		} else if( $i1 == 4 ){
			echo string_insert_br( base64_decode($data_next['players'][1]['name_str2']) );
		}
		if( $data['matches'][$i1]['end_match'] == 1 ){
			if( ( $hon1[$i1] == 1 && $hon2[$i1] == 0 ) || ( $hon1[$i1] == 0 && $hon2[$i1] == 1 ) ){
				if($data['matches'][$i1]['extra']!=1){
					echo '<div class="tb_frame_ippon">一本勝</div>';
				}
			} else if( $hon1[$i1] == $hon2[$i1] ){
				echo '<div class="tb_frame_draw">×</div>';
			}
		}
		echo '</div>'."\n";
		echo '        <div class="tb_frame_waza tb_frame_btop">'."\n";
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			if($data['matches'][$i1]['waza1_'.$i2]==5){
				echo '          <div class="tb_frame_waza2">';
			} else {
				echo '          <div class="tb_frame_waza1">';
			}
			if($data['matches'][$i1]['waza1_'.$i2]==0){ echo '&nbsp;'; }
			if($data['matches'][$i1]['waza1_'.$i2]==1){ echo 'メ'; }
			if($data['matches'][$i1]['waza1_'.$i2]==2){ echo 'ド'; }
			if($data['matches'][$i1]['waza1_'.$i2]==3){ echo 'コ'; }
			if($data['matches'][$i1]['waza1_'.$i2]==4){ echo '反'; }
			if($data['matches'][$i1]['waza1_'.$i2]==5){ echo '○'; }
			if($data['matches'][$i1]['waza1_'.$i2]==6){ echo 'ツ'; }
 			echo '</div>'."\n";
		}
		echo '        </div>'."\n";
		echo '        <div class="tb_frame_faul">'."\n";
		//if($data['matches'][$i1]['faul1_1']==2){ echo '指'; }
		if($data['matches'][$i1]['faul1_2']==1){ echo '▲'; }
		if($data['matches'][$i1]['extra']==1){
			echo '          <div class="tb_frame_faul_extra" id="extra_match<?php echo $i1; ?>">延長</div>'."\n";
		}
		echo '        </div>'."\n";
		echo '      </div>'."\n";
	}
?>
      <div class="clearfloat"></div>
<?php
	for( $i1 = 1; $i1 <= 4; $i1++ ){
		echo '      <div class="tb_frame">'."\n";
		echo '        <div class="tb_frame_faul">';
		//if($data['matches'][$i1]['faul2_1']==2){ echo '指'; }
		if($data['matches'][$i1]['faul2_2']==1){ echo '▲'; }
		echo '        </div>'."\n";
		echo '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			if($data['matches'][$i1]['waza1_'.$i2]==5){
				echo '          <div class="tb_frame_waza2">';
			} else {
				echo '          <div class="tb_frame_waza1">';
			}
			if($data['matches'][$i1]['waza2_'.$i2]==0){ echo '&nbsp;'; }
			if($data['matches'][$i1]['waza2_'.$i2]==1){ echo 'メ'; }
			if($data['matches'][$i1]['waza2_'.$i2]==2){ echo 'ド'; }
			if($data['matches'][$i1]['waza2_'.$i2]==3){ echo 'コ'; }
			if($data['matches'][$i1]['waza2_'.$i2]==4){ echo '反'; }
			if($data['matches'][$i1]['waza2_'.$i2]==5){ echo '○'; }
			if($data['matches'][$i1]['waza2_'.$i2]==6){ echo 'ツ'; }
 			echo '</div>'."\n";
		}
		echo '        </div>'."\n";
		echo '        <div class="tb_frame_content';
		if( $match_info[$place]['series'] <= 8 && $data['matches'][$i1]['player2'] != 0 && $data['matches'][$i1]['player2'] != $i1 ){
			echo ' tb_frame_hoin_player';
		}
		echo '" id="player2_'.$i1.'">';
			if( $i1 == 1 ){
				echo string_insert_br( base64_decode($data_prev2['players'][2]['name_str2']) );
			} else if( $i1 == 2 ){
				echo string_insert_br( base64_decode($data_prev['players'][2]['name_str2']) );
			} else if( $i1 == 3 ){
				echo string_insert_br( base64_decode($data_now['players'][2]['name_str2']) );
			} else if( $i1 == 4 ){
				echo string_insert_br( base64_decode($data_next['players'][2]['name_str2']) );
			}
		echo '</div>'."\n";
		echo '      </div>'."\n";
	}
?>
      <div class="clearfloat"></div>
    </div>
    <!-- end .content -->
  </div>
  <!-- end .container -->
<?php endfor; ?>
</div>
</body>
</html>
