<?php

	function init_entry_post_data_from_def_2_traffic( &$data, $def, $add1, $add2 )
	{
		$data['traffic'] = '';
		$data['traffic_mycar'] = '';
		$data['traffic_share'] = '';
		$data['traffic_other'] = '';
	}

	function get_entry_post_data_from_def_2_traffic( $def, $add1, $add2 )
	{
		$_SESSION['p']['traffic'] = get_field_string( $_POST, 'traffic' );
		$_SESSION['p']['traffic_mycar'] = get_field_string( $_POST, 'traffic_mycar' );
		$_SESSION['p']['traffic_share'] = get_field_string( $_POST, 'traffic_share' );
		$_SESSION['p']['traffic_other'] = get_field_string( $_POST, 'traffic_other' );
	}

	function get_entry_db_data_from_def_2_traffic( $data, $list, $def, $add1, $add2 )
	{
		$data['traffic'] = get_field_string( $list, 'traffic' );
		$data['traffic_mycar'] = get_field_string( $list, 'traffic_mycar' );
		$data['traffic_share'] = get_field_string( $list, 'traffic_share' );
		$data['traffic_other'] = get_field_string( $list, 'traffic_other' );
		return $data;
	}

	function update_entry_data_2_traffic( $def, $dbs )
	{
		$data = array(
			'traffic' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic' ) ),
			'traffic_mycar' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_mycar' ) ),
			'traffic_share' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_share' ) ),
			'traffic_other' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_other' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_2_shumoku_dantai_m( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = '';
		$data['shumoku_dantai_m_rensei_am'] = '';
		$data['shumoku_dantai_m_rensei_pm'] = '';
		$data['shumoku_dantai_m_opening'] = '';
		$data['shumoku_dantai_m_konshin'] = '';
		$data['shumoku_dantai_m_text'] = '';
	}

	function get_entry_post_data_from_def_2_shumoku_dantai_m( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_m_taikai'] = get_field_string( $_POST, 'shumoku_dantai_m_taikai' );
		$_SESSION['p']['shumoku_dantai_m_rensei_am'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_am' );
		$_SESSION['p']['shumoku_dantai_m_rensei_pm'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_pm' );
		$_SESSION['p']['shumoku_dantai_m_opening'] = get_field_string( $_POST, 'shumoku_dantai_m_opening' );
		$_SESSION['p']['shumoku_dantai_m_konshin'] = get_field_string( $_POST, 'shumoku_dantai_m_konshin' );
		$_SESSION['p']['shumoku_dantai_m_text'] = get_field_string( $_POST, 'shumoku_dantai_m_text' );
	}

	function get_entry_db_data_from_def_2_shumoku_dantai_m( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = get_field_string( $list, 'shumoku_dantai_m_taikai' );
		$data['shumoku_dantai_m_rensei_am'] = get_field_string( $list, 'shumoku_dantai_m_rensei_am' );
		$data['shumoku_dantai_m_rensei_pm'] = get_field_string( $list, 'shumoku_dantai_m_rensei_pm' );
		$data['shumoku_dantai_m_opening'] = get_field_string( $list, 'shumoku_dantai_m_opening' );
		$data['shumoku_dantai_m_konshin'] = get_field_string( $list, 'shumoku_dantai_m_konshin' );
		$data['shumoku_dantai_m_text'] = get_field_string( $list, 'shumoku_dantai_m_text' );
		return $data;
	}

	function update_entry_data_2_shumoku_dantai_m( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_m_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_taikai', 0 ),
			'shumoku_dantai_m_rensei_am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_am', 0 ),
			'shumoku_dantai_m_rensei_pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_pm', 0 ),
			'shumoku_dantai_m_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_opening', 0 ),
			'shumoku_dantai_m_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_konshin', 0 ),
			'shumoku_dantai_m_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_m_text' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_2_shumoku_dantai_w( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = '';
		$data['shumoku_dantai_w_rensei_am'] = '';
		$data['shumoku_dantai_w_rensei_pm'] = '';
		$data['shumoku_dantai_w_opening'] = '';
		$data['shumoku_dantai_w_konshin'] = '';
		$data['shumoku_dantai_w_text'] = '';
	}

	function get_entry_post_data_from_def_2_shumoku_dantai_w( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_w_taikai'] = get_field_string( $_POST, 'shumoku_dantai_w_taikai' );
		$_SESSION['p']['shumoku_dantai_w_rensei_am'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_am' );
		$_SESSION['p']['shumoku_dantai_w_rensei_pm'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_pm' );
		$_SESSION['p']['shumoku_dantai_w_opening'] = get_field_string( $_POST, 'shumoku_dantai_w_opening' );
		$_SESSION['p']['shumoku_dantai_w_konshin'] = get_field_string( $_POST, 'shumoku_dantai_w_konshin' );
		$_SESSION['p']['shumoku_dantai_w_text'] = get_field_string( $_POST, 'shumoku_dantai_w_text' );
	}

	function get_entry_db_data_from_def_2_shumoku_dantai_w( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = get_field_string( $list, 'shumoku_dantai_w_taikai' );
		$data['shumoku_dantai_w_rensei_am'] = get_field_string( $list, 'shumoku_dantai_w_rensei_am' );
		$data['shumoku_dantai_w_rensei_pm'] = get_field_string( $list, 'shumoku_dantai_w_rensei_pm' );
		$data['shumoku_dantai_w_opening'] = get_field_string( $list, 'shumoku_dantai_w_opening' );
		$data['shumoku_dantai_w_konshin'] = get_field_string( $list, 'shumoku_dantai_w_konshin' );
		$data['shumoku_dantai_w_text'] = get_field_string( $list, 'shumoku_dantai_w_text' );
		return $data;
	}

	function update_entry_data_2_shumoku_dantai_w( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_w_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_taikai', 0 ),
			'shumoku_dantai_w_rensei_am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_am', 0 ),
			'shumoku_dantai_w_rensei_pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_pm', 0 ),
			'shumoku_dantai_w_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_opening', 0 ),
			'shumoku_dantai_w_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_konshin', 0 ),
			'shumoku_dantai_w_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_w_text' ) )
		);
		return $data;
	}

	function is_entry_data_2_join_shumoku_dantai_m( $data )
	{
		if( get_field_string_number( $data, 'shumoku_dantai_m_taikai', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_m_rensei_am', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_m_rensei_pm', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_m_opening', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_m_konshin', 0 ) == 1 ){ return true; }
		return false;
	}

	function is_entry_data_2_join_shumoku_dantai_w( $data )
	{
		if( get_field_string_number( $data, 'shumoku_dantai_w_taikai', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_w_rensei_am', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_w_rensei_pm', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_w_opening', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_w_konshin', 0 ) == 1 ){ return true; }
		return false;
	}

	function get_entry_data_2_list_for_PDF( $org_array, $pref_array, $grade_junior_array )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=2';
		$list = db_query_list( $dbs, $sql );
		$ret = array( 'm' => array(), 'w' => array() );
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$school_address_pref = get_field_string_number( $fields, 'school_address_pref', 0 );
			$pref_name = '';
			foreach( $pref_array as $pv ){
				if( $pv['value'] == $school_address_pref ){
					$pref_name = $pv['title'];
					break;
				}
			}
			$sdata = array(
				'name' => $pref_name . ' ' . get_field_string( $fields, 'school_name' ),
				'address' => $pref_name . ' ' . get_field_string( $fields, 'school_address' ),
				'tel' => get_field_string( $fields, 'comment' )
			);

			if( is_entry_data_2_join_shumoku_dantai_m( $fields ) ){
				$pdata = array(
					'name' => $sdata['name'],
					'address' => $sdata['address'],
					'tel' => $sdata['tel'],
					'manager' => get_field_string( $fields, 'manager_m_sei' ) . get_field_string( $fields, 'manager_m_mei' ),
					'captain' => get_field_string( $fields, 'captain_m_sei' ) . get_field_string( $fields, 'captain_m_mei' ),
					'introduction' => get_field_string( $fields, 'introduction_m' ),
					'main_results' => get_field_string( $fields, 'main_results_m' )
				);
				for( $i1 = 1; $i1 <= 7; $i1++ ){
					$grade = get_field_string_number( $fields, 'player'.$i1.'_grade_m', 0 );
					$grade_name = '';
					foreach( $grade_junior_array as $gv ){
						if( $gv['value'] == $grade ){
							$grade_name = $gv['title'];
							break;
						}
					}
					$pdata['player'.$i1]
						= get_field_string( $fields, 'player'.$i1.'_m_sei' )
							. get_field_string( $fields, 'player'.$i1.'_m_mei' )
							. ' ' . $grade_name;
				}
				$ret['m'][] = $pdata;
			}
			if( is_entry_data_2_join_shumoku_dantai_w( $fields ) ){
				$pdata = array(
					'name' => $sdata['name'],
					'address' => $sdata['address'],
					'tel' => $sdata['tel'],
					'manager' => get_field_string( $fields, 'manager_w_sei' ) . get_field_string( $fields, 'manager_w_mei' ),
					'captain' => get_field_string( $fields, 'captain_w_sei' ) . get_field_string( $fields, 'captain_w_mei' ),
					'introduction' => get_field_string( $fields, 'introduction_w' ),
					'main_results' => get_field_string( $fields, 'main_results_w' )
				);
				for( $i1 = 1; $i1 <= 7; $i1++ ){
					$grade = get_field_string_number( $fields, 'player'.$i1.'_grade_w', 0 );
					$grade_name = '';
					foreach( $grade_junior_array as $gv ){
						if( $gv['value'] == $grade ){
							$grade_name = $gv['title'];
							break;
						}
					}
					$pdata['player'.$i1]
						= get_field_string( $fields, 'player'.$i1.'_w_sei' )
							. get_field_string( $fields, 'player'.$i1.'_w_mei' )
							. ' ' . $grade_name;
				}
				$ret['w'][] = $pdata;
			}
		}
		return $ret;
	}

	function get_entry_data_list_2_sql( $mv )
	{
		$sql = 'select `entry_info`.`id` as `id`,'
			. ' `f1`.`data` as `school_name`,'
			. ' `f2`.`data` as `school_name_ryaku`,'
			. ' `f3`.`data` as `join`,'
			. ' `f4`.`data` as `school_address_pref`'
			. ' from `entry_info`'
			. ' left join `entry_field` as `f1` on `f1`.`info`=`entry_info`.`id` and `f1`.`field`=\'school_name\''
			. ' left join `entry_field` as `f2` on `f2`.`info`=`entry_info`.`id` and `f2`.`field`=\'school_name_ryaku\''
			. ' left join `entry_field` as `f3` on `f3`.`info`=`entry_info`.`id` and `f3`.`field`=\'shumoku_dantai_' . $mv . '_taikai\''
			. ' left join `entry_field` as `f4` on `f4`.`info`=`entry_info`.`id` and `f4`.`field`=\'school_address_pref\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=2 and `f3`.`data`=\'1\' order by `disp_order` asc';
		return $sql;
	}

	function output_tournament_2_for_PDF( $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
			. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
			. '<style>' . "\n"
			. '.tb_result_tournament_name {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 80px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_pref {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 60px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_num {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '}' . "\n"
			. '</style>' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<H1>中学校'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n"
			. '    <table id="ex_t" border="0" cellspacing="0" cellpadding="0">' . "\n"
			. '      <tr>' . "\n"
			. '        <td class="td_right" colspan="2">&nbsp;</td>' . "\n"
			. '        <td class="td_right" colspan="4">&nbsp;</td>' . "\n"
			. '      </tr>' . "\n";
		$team_index_no = 1;
		for( $tournament_team = 0; $tournament_team < count($tournament_data['team'])*2; $tournament_team++ ){
			$lineStart = 1;
			$lineHeight = 2;
			$lineStep = 4;
			$lineMatch = 1;
			for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $lineMatch *= 2; }
			$match_no = $lineMatch + intval( $tournament_team / $lineStep );
			$pdf .= '      <tr>' . "\n";
			if( ( $tournament_team % 2 ) == 0 ){
				$span = 0;
				if( $tournament_data['match'][$match_no-1]['place'] == 'no_match' ){
					if( ( $tournament_team % 4 ) == 0 ){
						$span = 4;
					}
				} else {
					$span = 2;
				}
				if( $span != 0 ){
					$pdf .=  '        <td class="tb_result_tournament_name" rowspan="' . $span . '" >' . "\n";
					foreach( $entry_list as $ev ){
						if( intval($tournament_data['team'][$tournament_team/2]['id']) == intval($ev['id']) ){
							if( $ev['school_name_ryaku'] != '' ){
								$pdf .= $ev['school_name_ryaku'];
							} else {
								$pdf .= $ev['school_name'];
							}
						}
					}
					$pdf .=  '        </td>' . "\n";
					$pdf .=  '        <td class="tb_result_tournament_name_pref" rowspan="' . $span . '" >(' . $ev['school_address_pref_name'] . ')</td>' . "\n";
					$pdf .=  '        <td class="tb_result_tournament_name_num" rowspan="' . $span . '" >' . $team_index_no . '</td>' . "\n";
					$team_index_no++;
				}
			}
			for( $tournament_match_offset = 0; $tournament_match_offset <  $tournament_data['match_level']; $tournament_match_offset++ ){
				$lineOffset = $tournament_team % $lineStep;
				$match_no = $lineMatch + intval( $tournament_team / $lineStep );
				$player1 = $tournament_data['match'][$match_no-1]['team1'];
				$player2 = $tournament_data['match'][$match_no-1]['team2'];
				$winner = $tournament_data['match'][$match_no-1]['winner'];
				$place = $tournament_data['match'][$match_no-1]['place'];
//echo $lineOffset,':',$match_no,':',$tournament_match_offset,':',$place,"<br />\n";
				$color = '';
				if( $tournament_match_offset > 0 || $place != 'no_match' ){
					if( $lineOffset == $lineStart ){
						$color = ' style="border-right:2px #000000 solid"';
					} else if( $lineOffset > $lineStart && $lineOffset < ( $lineStart + $lineHeight / 2 ) ){
						$color = ' style="border-right:2px #000000 solid"';
					} else if( $lineOffset >= ( $lineStart + $lineHeight / 2 )  && $lineOffset < ( $lineStart + $lineHeight ) ){
						$color = ' style="border-right:2px #000000 solid"';
					} else if( $lineOffset == ( $lineStart - 1 ) ){
						$color = ' style="border-bottom:2px #ff0000 solid"';
					} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
						$color = ' style="border-top:2px #000000 solid"';
					}
				} else {
					if( ( $tournament_team % 8 ) >= 4 && $lineOffset == ( $lineStart + 1 ) ){
						$color = ' style="border-top:2px #000000 solid"';
					} else if( ( $tournament_team % 8 ) < 4 && $lineOffset == ( $lineStart ) ){
						$color = ' style="border-bottom:2px #ff0000 solid"';
					}
				}
/*
				} else if( $lineOffset == ( $lineStart - 1 ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #ff0000 solid">&nbsp;</td>' . "\n";
				} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-top:2px #000000 solid">&nbsp;</td>' . "\n";
*/
/*
				} else if( $tournament_match_offset > 0 || $place != 'no_match' ){
					if( $lineOffset == ( $lineStart - 1 ) ){
						$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #ff0000 solid">&nbsp;</td>' . "\n";
					} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
						$pdf .=  '        <td class="tb_result_tournament" style="border-top:2px #000000 solid">&nbsp;</td>' . "\n";
					}
*/
/*
				} else if( $tournament_match_offset == 0 && $place == 'no_match' && $lineOffset == 1 ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #00ff00 solid">&nbsp;</td>' . "\n";
*/
/*
				} else if( $lineOffset > ( $lineStart + $lineHeight ) ){
					$pdf .=  '        <td class="tb_result_tournament">&nbsp;</td>' . "\n";
				} else if( $lineOffset < ( $lineStart - 1 ) ){
					$pdf .=  '        <td class="tb_result_tournament">&nbsp;</td>' . "\n";
				}
*/
				$pdf .=  '        <td class="tb_result_tournament"'.$color.'>&nbsp;</td>' . "\n";

/*
				if( $lineOffset == $lineStart ){
					$pdf .= '         <td class="tb_result_tournament" style="border-right:2px #000000 solid">&nbsp;</td>' . "\n";
				} else if( $lineOffset > $lineStart && $lineOffset < ( $lineStart + $lineHeight / 2 ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-right:2px #000000 solid">&nbsp;</td>' . "\n";
				} else if( $lineOffset >= ( $lineStart + $lineHeight / 2 )  && $lineOffset < ( $lineStart + $lineHeight ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-right:2px #000000 solid">&nbsp;</td>' . "\n";
*/
/*
				} else if( $lineOffset == ( $lineStart - 1 ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #ff0000 solid">&nbsp;</td>' . "\n";
				} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-top:2px #000000 solid">&nbsp;</td>' . "\n";
*/
/*
				} else if( $tournament_match_offset > 0 || $place != 'no_match' ){
					if( $lineOffset == ( $lineStart - 1 ) ){
						$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #ff0000 solid">&nbsp;</td>' . "\n";
					} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
						$pdf .=  '        <td class="tb_result_tournament" style="border-top:2px #000000 solid">&nbsp;</td>' . "\n";
					}
*/
/*
				} else if( $tournament_match_offset == 0 && $place == 'no_match' && $lineOffset == 1 ){
					$pdf .=  '        <td class="tb_result_tournament" style="border-bottom:2px #00ff00 solid">&nbsp;</td>' . "\n";
*/
/*
				} else if( $lineOffset > ( $lineStart + $lineHeight ) ){
					$pdf .=  '        <td class="tb_result_tournament">&nbsp;</td>' . "\n";
				} else if( $lineOffset < ( $lineStart - 1 ) ){
					$pdf .=  '        <td class="tb_result_tournament">&nbsp;</td>' . "\n";
				}
*/
				$lineStart *= 2;
				$lineHeight *= 2;
				$lineStep *= 2;
				$lineMatch /= 2;
			}
			$pdf .=  '      </tr>' . "\n";
		}
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n";
		$pdf .=  '    <br />' . "\n";
		$pdf .=  '    <br />' . "\n";
		$pdf .=  '    </div>' . "\n";
		$pdf .=  '    <!-- end .content --></div>' . "\n";
		$pdf .=  '  </div>' . "\n";
		$pdf .=  '  <!-- end .container --></div>' . "\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";
		return $pdf;
	}
?>
