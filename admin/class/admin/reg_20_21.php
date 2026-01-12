<?php

	function __get_league_parameter_20_21( $series_mw )
	{
		$param = array(
			'mw' => $series_mw,
			'team_num' => 4,
			'match_num' => 6,
			'match_info' => array(
                array( 0, 1 ), array( 0, 2 ), array( 0, 3 ), array( 1, 2 ), array( 1, 3 ), array( 2, 3 )
            ),
			'place_num' => 4,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5, 7 ), array( 2, 4, 6, 8 ) ),
			'group_num' => 4,
			'chart_match_info' => array( 0, 5, 1, 4, 3, 2 ),
			'chart_tbl' => array( array( 0,1,2,3 ), array( 1,0,4,5 ), array( 2,4,0,6 ), array( 3,5,6,0 ) ),
			//'chart_tbl' => array( array( 0,1,3,6 ), array( 1,0,5,4 ), array( 3,5,0,2 ), array( 6,4,2,0 ) ),
			'chart_team_tbl' => array( array( 0,1,1,1 ), array( 2,0,1,1 ), array( 2,2,0,1 ), array( 2,2,2,0 ) )
		);
		return $param;
	}

	function get_league_parameter_20()
	{
        return __get_league_parameter_20_21( 'm' );
	}

	function get_league_parameter_21()
	{
        return __get_league_parameter_20_21( 'w' );
	}

	function __get_tournament_parameter_20_21()
	{
		$param = array(
			'mw' => 'w',
			'team_num' => 8,
			'match_num' => 7,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 4,
			'place_num' => 4,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16
		);
		return $param;
	}

	function get_tournament_parameter_20()
	{
		__get_tournament_parameter_20_21();
	}

	function get_tournament_parameter_21()
	{
		__get_tournament_parameter_20_21();
	}

	function __get_entry_data_20_21_list_for_PDF( $series, $series_mw, $kaisai_rev )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
//print_r($list);
		$kaisai = 0;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['school_name'] = '';
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval( $fields['school_address_pref'] );
			$lv['pref_name'] = $c->get_pref_name( $preftbl, $pref );
			$lv['school_name'] = get_field_string( $fields, 'school_name' );
			$lv['introduction'] = get_field_string( $fields, 'introduction_'.$series_mw );
			$lv['insotu1_sei'] = get_field_string( $fields, 'insotu1_sei' );
			$lv['insotu1_mei'] = get_field_string( $fields, 'insotu1_mei' );
			$lv['photo'] = get_field_string( $fields, 'photo_'.$series_mw );
			$lv['entry_num'] = get_field_string( $fields, 'entry_num_'.$series_mw );
			for( $i1 = 1; $i1 <= 7; $i1++ ){
				$gakunen = get_field_string_number( $fields, 'dantai_gakunen_dan_'.$series_mw.$i1.'_gakunen', 0 );
				$lv['player'.$i1.'_gakunen'] = $c->get_grade_junior_name( $gakunentbl, $gakunen );
				$lv['player'.$i1.'_dan'] = get_field_string( $fields, 'dantai_gakunen_dan_'.$series_mw.$i1.'_dan' );
				$lv['player'.$i1.'_sei'] = get_field_string( $fields, 'dantai_'.$series_mw.$i1.'_sei' );
				$lv['player'.$i1.'_mei'] = get_field_string( $fields, 'dantai_'.$series_mw.$i1.'_mei' );
			}
			$prefpos = $c->get_pref_order( $pref );
			if( $prefpos == 47 ){
				if( $kaisai == 0 ){
					$kaisai = 1;
					if( $kaisai_rev == 1 ){ $prefpos++; }
				} else {
					if( $kaisai_rev == 0 ){ $prefpos++; }
				}
			}
			$data[$prefpos-1] = $lv;
		}
		db_close( $dbs );
		return $data;

/*
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=6 order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$ret = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.__REG_SERIES_YEAR__;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
//print_r($fields);
//exit;
			$school_address_pref = get_field_string_number( $fields, 'school_address_pref', 0 );
			$pref_name = '';
			foreach( $pref_array as $pv ){
				if( $pv['value'] == $school_address_pref ){
					$pref_name = $pv['title'];
					break;
				}
			}
			$sdata = array(
				'name' => $pref_name . '　' . get_field_string( $fields, 'school_name_org' ) . '立' . get_field_string( $fields, 'school_name' ),
				'address' => $pref_name . ' ' . get_field_string( $fields, 'school_address' ),
				'tel' => get_field_string( $fields, 'school_phone_tel' )
			);

			if( get_field_string_number( $fields, 'shumoku_dantai_w_taikai', 0 ) != 1 ){
				continue;
			}
			$pdata = array(
				'name' => $sdata['name'],
				'address' => $sdata['address'],
				'tel' => mb_convert_kana( $sdata['tel'], 'krn' ),
				'captain' => '',
				'introduction' => get_field_string( $fields, 'introduction_w' ),
				'main_results' => get_field_string( $fields, 'main_results_w' )
			);
			$pdata['manager'] = '';
			if( $fields['kantoku_w_tantou'] == '1' ){
				$pdata['manager'] = get_field_string( $fields, 'insotu1_sei' ).' '.get_field_string( $fields, 'insotu1_mei' );
			} else if( $fields['kantoku_w_tantou'] == '2' ){
				$pdata['manager'] = get_field_string( $fields, 'insotu2_sei' ).' '.get_field_string( $fields, 'insotu2_mei' );
			} else if( $fields['kantoku_w_tantou'] == '3' ){
				$pdata['manager'] = get_field_string( $fields, 'insotu3_sei' ).' '.get_field_string( $fields, 'insotu3_mei' );
			}
			for( $i1 = 1; $i1 <= 7; $i1++ ){
				$grade = get_field_string_number( $fields, 'dantai_gakunen_dan_w'.$i1.'_gakunen', 0 );
				$grade_name = '';
				foreach( $grade_junior_array as $gv ){
					if( $gv['value'] == $grade ){
						$grade_name = $gv['title'];
						break;
					}
				}
				$pdata['player'.$i1]
					= mb_convert_kana( get_field_string( $fields, 'dantai_w'.$i1.'_sei' )
						 . ' ' . get_field_string( $fields, 'dantai_w'.$i1.'_mei' ),
						'sk'
					). ' ' . $grade_name;
			}
			$ret[] = $pdata;
		}
		return $ret;
*/
	}

	function get_entry_data_20_list_for_PDF()
	{
		return __get_entry_data_20_21_list_for_PDF( 20, 'm', 1 );
	}

	function get_entry_data_21_list_for_PDF()
	{
		return __get_entry_data_20_21_list_for_PDF( 21, 'w', 1 );
	}


	function get_entry_data_list_20_sql( $mw )
	{
		$sql = 'select `entry_info`.`id` as `id`,'
			. ' `f1`.`data` as `school_name`,'
			. ' `f2`.`data` as `school_name_ryaku`,'
			. ' `f3`.`data` as `join`'
			. ' from `entry_info`'
			. ' inner join `entry_field` as `f1` on `f1`.`info`=`entry_info`.`id` and `f1`.`field`=\'school_name\''
			. ' inner join `entry_field` as `f2` on `f2`.`info`=`entry_info`.`id` and `f2`.`field`=\'school_name_ryaku\''
			. ' inner join `entry_field` as `f3` on `f3`.`info`=`entry_info`.`id` and `f3`.`field`=\'shumoku_dantai_' . $mw . '_taikai\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=3 and `f3`.`data`=\'1\' order by `disp_order` asc';
		return $sql;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_league_20_for_HTML_2( $league_list, $entry_list, $mv )
	{
//print_r($league_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$html .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$html .= '<head>'."\n";
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$html .= '<title>試合結果速報</title>'."\n";
		$html .= '<link href="../main.css" rel="stylesheet" type="text/css" />'."\n";
		$html .= '</head>'."\n";

		$html .= '<body>'."\n";
		$html .= '<!--'."\n";
		$html .= print_r($league_list,true) . "\n";
		$html .= print_r($entry_list,true) . "\n";
		$html .= '-->'."\n";
		$html .= '<?php //print_r($_POST); ?>'."\n";

		$html .= '<div class="container">'."\n";
		$html .= '  <div class="content">'."\n";
		$html .= '    <h2>団体戦' . $mvstr . '予選リーグ</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = array();
			$team_num = intval( $league_list[$league_data]['team_num'] );
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				$a = array();
				for( $i2 = 0; $i2 < $team_num; $i2++ ){ $a[] = 0; }
				$match_tbl[] = $a;
			}
			$index = 1;
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				for( $i2 = $i1 + 1; $i2 < $team_num; $i2++ ){
					$match_tbl[$i1][$i2] = $index;
					$match_tbl[$i2][$i1] = $index;
					$index++;
				}
			}
			//print_r($match_tbl);
			$html .= '    <table id="ex_t" border="1" cellspacing="1" cellpadding="2">'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_right2">'.$league_list[$league_data]['name'].'</td>'."\n";
			$html .= '        <td class="td_right2"></td>'."\n";
			$html .= '        <td class="td_right2" colspan="'.($league_list[$league_data]['team_num']+3).'">&nbsp;</td>'."\n";
			$html .= '      </tr>'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_right">対戦学校</td>'."\n";
			$html .= '        <td class="td_right" colspan="'.$league_list[$league_data]['team_num'].'">試合'."\n";
			$html .= '        <td class="td_right">得点</td>'."\n";
			$html .= '        <td class="td_right">勝者数</td>'."\n";
			$html .= '        <td class="td_right">勝本数</td>'."\n";
			$html .= '        <td class="td_right">順位</td>'."\n";
			$html .= '        </td>'."\n";
			$html .= '      </tr>'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_right">----</td>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '        <td class="td_right">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'];
					}
				}
				$html .= '        </td>'."\n";
			}
			$html .= '        <td class="td_right"></td>'."\n";
			$html .= '        <td class="td_right"></td>'."\n";
			$html .= '        <td class="td_right"></td>'."\n";
			$html .= '        <td class="td_right"></td>'."\n";
			$html .= '      </tr>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '      <tr>'."\n";
				$html .= '        <td class="td_right">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'];
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					if( $dantai_index_row == $dantai_index_col ){
						$html .= '        <td class="td_right">----</td>'."\n";
					} else if( $dantai_index_row < $dantai_index_col ){
						$html .= '        <td class="td_right">'."\n";
						$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
						if( $match_no_index > 0 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon1'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win1'].'</div>'."\n";
							$html .= '</div>'."\n";
							//$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon1'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win1'];
						}
						$html .= '        </td>'."\n";
					} else {
						$html .= '        <td class="td_right">'."\n";
						$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
						if( $match_no_index > 0 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==1 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
//							$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon2'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win2'];

							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon2'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win2'].'</div>'."\n";
							$html .= '</div>'."\n";


						}
						$html .= '        </td>'."\n";
					}
				}
				$html .= '        <td class="td_right">'.($league_list[$league_data]['team'][$dantai_index_row]['point']/2).'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['win'].'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['hon'].'</td>'."\n";
				$html .= '        <td class="td_right" ';
				if( $league_list[$league_data]['team'][$dantai_index_row]['advanced'] == 1){
					$html .= 'bgcolor="#ffbbbb"';
				}
				$html .= '>' . $league_list[$league_data]['team'][$dantai_index_row]['standing'] . '</td>'."\n";
				$html .= '      </tr>'."\n";
			}
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_right" colspan="7">&nbsp;</td>'."\n";
			$html .= '      </tr>'."\n";
			$html .= '    </table>'."\n";
			$html .= '    <br />'."\n";
			$html .= '    <br />'."\n";
		}
		$html .= '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>'."\n";
		$html .= '    <br />'."\n";
		$html .= '    <br />'."\n";
		$html .= '    </div>'."\n";
		$html .= '    <!-- end .content --></div>'."\n";
		$html .= '  </div>'."\n";
		$html .= '  <!-- end .container --></div>'."\n";
		$html .= '</body>'."\n";
		$html .= '</html>'."\n";
		return $html;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_20_21_for_HTML( $path, $league_param, $league_list, $entry_list, $mv )
	{
//echo $path;
//print_r($league_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mvstr.'団体リーグ表</title>'."\n";
		$header .= '<link href="../preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = '';
		$html .= $header . '    <h2>' . $mvstr . '団体リーグ表</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			$html .= '    <table class="match_t" border="1" cellspacing="0" cellpadding="2">'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_name">'.$league_list[$league_data]['name'].'</td>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '        <td class="td_match">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name'];
					}
				}
				$html .= '        </td>'."\n";
			}
			$html .= '        <td class="td_score">得点</td>'."\n";
			$html .= '        <td class="td_score">勝者数</td>'."\n";
			$html .= '        <td class="td_score">勝本数</td>'."\n";
			$html .= '        <td class="td_score">順位</td>'."\n";
			$html .= '        </td>'."\n";
			$html .= '      </tr>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '      <tr>'."\n";
				$html .= '        <td class="td_right">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name'];
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_no_index == 0 ){
						$html .= '        <td class="td_right">----</td>'."\n";
					} else if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon1'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win1'].'</div>'."\n";
							$html .= '</div>'."\n";
							//$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon1'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win1'];
						}
						$html .= '        </td>'."\n";
					} else {
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==1 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
//							$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon2'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win2'];

							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon2'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win2'].'</div>'."\n";
							$html .= '</div>'."\n";


						}
						$html .= '        </td>'."\n";
					}
				}
				$html .= '        <td class="td_right">'.($league_list[$league_data]['team'][$dantai_index_row]['point']/2).'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['win'].'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['hon'].'</td>'."\n";

				if( $league_list[$league_data]['end_match'] == $league_list[$league_data]['match_num'] ){
					$html .= '        <td class="td_right" ';
					if( $league_list[$league_data]['team'][$dantai_index_row]['advanced'] == 1){
						$html .= 'bgcolor="#ffbbbb"';
					}
					$html .= '>' . $league_list[$league_data]['team'][$dantai_index_row]['standing'] . '</td>'."\n";
				} else {
					$html .= '        <td class="td_right">&nbsp;</td>'."\n";
				}
				$html .= '      </tr>'."\n";
			}
			$html .= '    </table>'."\n";
			$html .= '    <br />'."\n";
			$html .= '    <br />'."\n";
		}
		$html .= $footer;
		$file = $path . '/dl'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_20_for_HTML( $path, $league_list, $entry_list )
	{
		__output_league_20_21_for_HTML( $path, get_league_parameter_20(), $league_list, $entry_list, 'm' );
	}

	function output_league_21_for_HTML( $path, $league_list, $entry_list )
	{
		__output_league_20_21_for_HTML( $path, get_league_parameter_21(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_20_21_for_Excel_one( $objPage, $sheet, $col, $row, $league_param, $league_list, $entry_list, $mv )
	{
//print_r($league_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}

		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3, $row+$dantai_index_row*2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2+1,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3, $row+$dantai_index_row*2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2+1,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
						}
					}
				}
				$colscore = $col + $league_list[$league_data]['team_num'] * 3 + 3;
				$sheet->setCellValueByColumnAndRow(
					$colscore, $row+$dantai_index_row*2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+2, $row+$dantai_index_row*2+1,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+2, $row+$dantai_index_row*2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+4, $row+$dantai_index_row*2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);
			}
		}
	}

	function __output_league_20_21_for_Excel( $objPage, $path, $league_param, $league_list, $entry_list, $mw )
	{
//print_r($league_list);
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

		$file_name = 'H28allnaganoLeagueResults_' . $mw . '.xls';
		$file_path = $path . '/' . $file_name;
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
        $sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　予選リーグ結果' );

        $border_style = array(
            'borders' => array(
                'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $border_style2 = array(
            'borders' => array(
                'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'diagonal' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN
            )
        );
        $col = 0;
		$team_num = intval( $league_list[0]['team_num'] );
        for( $i1 = 0; $i1 <= $team_num; $i1++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(2.29+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(4.57+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(2.29+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
        }
        for( $i1 = 0; $i1 < 3; $i1++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(4.57+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
        }

		$col = 0;
		$row = 4;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			$sheet->setCellValueByColumnAndRow(
				$col, $row, $league_list[$league_data]['name']
			);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+4) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			for( $dantai_index_row = 0; $dantai_index_row < $team_num; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*5+5, $row, $ev['school_name'] );
					}
				}
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_row*5+5) . $row;
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_row*5+5+4) . ($row+1);
//echo "1:",$mg_range1,':',$mg_range2,'<br />';
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			}
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5, $row, '勝点' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+4, $row, '総本数' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+4, $row+1, '総勝者数' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+6, $row, '順位' );

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+2) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+4);
            $sheet->getStyle($mg_range1.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
            $sheet->getStyle($mg_range1.$row)->getFont()->setSize(8);
            $sheet->getStyle($mg_range1.($row+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1.($row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $sheet->getStyle($mg_range1.($row+1))->getFont()->setSize(8);
            $sheet->getStyle($mg_range1.$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3+2) . ($row+1);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+6) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+6+2) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+2);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                            $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+3);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+2);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                            $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+3);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						}
					}
                    $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+5) . ($row+$dantai_index_row*2+2);
                    $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+5+4) . ($row+$dantai_index_row*2+2+1);
                    if( $dantai_index_col == $dantai_index_row ){
                        $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                        $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style2);
                    } else {
                        $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
                    }
				}
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+2, $ev['school_name'] );
					}
				}
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+4) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

				$colscore = $col + $league_list[$league_data]['team_num'] * 5 + 5;
				$sheet->setCellValueByColumnAndRow(
					$colscore, $row+$dantai_index_row*2+2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+3+1, $row+$dantai_index_row*2+3,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+3+1, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+6, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+2) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+4) . ($row+$dantai_index_row*2+2);
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+4) . ($row+$dantai_index_row*2+3);
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+3) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+3+2) . ($row+$dantai_index_row*2+3);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+6) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+6+2) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			}
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3*3-1) . ($row+$team_num*2+1);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			$row += 11;
		}
        for( $i1 = 1; $i1 <= $row; $i1++ ){
            $sheet->getRowDimension($i1)->setRowHeight(18);
        }

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_20_for_Excel( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_20_21_for_Excel( $objPage, $path, get_league_parameter_20(), $league_list, $entry_list, 'm' );
	}

	function output_league_21_for_Excel( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_20_21_for_Excel( $objPage, $path, get_league_parameter_21(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function __output_league_match_for_HTML2_20_21( $objPage, $path, $league_param, $league_list, $entry_list, $mv )
	{
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mvstr.'団体リーグ結果</title>'."\n";
		$header .= '<link href="../preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = '';
		$html = $header . '    <h2>' . $mvstr . '団体リーグ結果</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			for( $match_index = 0; $match_index < count( $league_list[$league_data]['match'] ); $match_index++ ){
				$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第'.($match_index+1).'試合</h3>';
				$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][$league_param['chart_match_info'][$match_index]], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][2], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][1], $entry_list, $mv );
			}
		}
		$html .= $footer;
		$file = $path . '/dlm'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_match_for_HTML2_20( $objPage, $path, $league_list, $entry_list )
	{
		__output_league_match_for_HTML2_20_21( $objPage, $path, get_league_parameter_20(), $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_HTML2_21( $objPage, $path, $league_list, $entry_list )
	{
		__output_league_match_for_HTML2_20_21( $objPage, $path, get_league_parameter_21(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_match_for_excel_20_21( $objPage, $path, $league_param, $league_list, $entry_list, $mw )
	{
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

//print_r($league_list);
//exit;
		$file_path = $path . '/H28allnaganoLeagueMatchResults_'.$mw.'.xls';
		$file_name = 'H28allnaganoLeagueMatchResults_'.$mw.'.xls';
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/dantaiLeagueMatchResultsBase.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦結果' );

		$col = 0;
		$row = 3;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$sheet->setCellValueByColumnAndRow(
				0, $row, $league_list[$league_data]['name']
			);
            $row++;
			for( $match = 0; $match < $league_list[$league_data]['match_num']; $match++ ){
    			$sheet->setCellValueByColumnAndRow(
	    			0, $row, '第'.($match+1).'試合'
		    	);
                $row++;
                if( $league_data == 0 && $match == 0 ){
                    $row += 5;
                    continue;
                }
                for( $r = 0; $r < 5; $r++ ) {
                    for( $c = 0; $c < 24; $c++ ){
                        // セルを取得
                        $cell = $sheet->getCellByColumnAndRow($c, $r+5);
                        // セルスタイルを取得
                        $style = $sheet->getStyleByColumnAndRow($c, $r+5);
                        // 数値から列文字列に変換する (0,1) → A1
                        $offsetCell = PHPExcel_Cell::stringFromColumnIndex($c) . (string)($row + $r);
                        // セル値をコピー
                        $sheet->setCellValue($offsetCell, $cell->getValue());
                        // スタイルをコピー
                        $sheet->duplicateStyle($style, $offsetCell);

                        $mg_range = 'B' . $row . ":D" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'E' . $row . ":G" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'H' . $row . ":J" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'K' . $row . ":M" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . $row . ":P" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Q' . $row . ":T" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'U' . $row . ":W" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'A' . ($row+1) . ":A" . ($row+2); 
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'B' . ($row+1) . ":D" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'E' . ($row+1) . ":G" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'H' . ($row+1) . ":J" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'K' . ($row+1) . ":M" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . ($row+1) . ":P" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Q' . ($row+1) . ":Q" . ($row+2);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'T' . ($row+1) . ":T" . ($row+2);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'U' . ($row+1) . ":W" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'A' . ($row+3) . ":A" . ($row+4); 
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'B' . ($row+4) . ":D" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'E' . ($row+4) . ":G" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'H' . ($row+4) . ":J" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'K' . ($row+4) . ":M" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . ($row+4) . ":P" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Q' . ($row+3) . ":Q" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'T' . ($row+3) . ":T" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'U' . ($row+4) . ":W" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+1) . ":S" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+2) . ":S" . ($row+2);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+3) . ":S" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+4) . ":S" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                    }
                }
                $row += 5;
            }
            $row++;
        }

		$col = 0;
		$row = 3;
		$colStr = 'Q';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$sheet->setCellValueByColumnAndRow(
				0, $row, $league_list[$league_data]['name']
			);
            $row++;
			for( $match = 0; $match < $league_list[$league_data]['match_num']; $match++ ){
    			$sheet->setCellValueByColumnAndRow(
	    			0, $row, '第'.($match+1).'試合'
		    	);
				$row += 2;
				$objPage->output_one_match_for_excel( $sheet, $col, $row, $league_list[$league_data]['match'][$league_param['chart_match_info'][$match]], $entry_list, $mw, 46, 46 );
				$row += 4;
			}
            $row++;
		}
        for( $i1 = 3; $i1 <= $row; $i1++ ){
            $sheet->getRowDimension($i1)->setRowHeight(18.6);
        }
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_match_for_excel_20( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_20_21( $objPage, $path, get_league_parameter_20(), $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_excel_21( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_20_21( $objPage, $path, get_league_parameter_21(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_match_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, $mw )
	{
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_name = 'H28allnaganoTournamentMatchResults_' . $mw . '.xls';
		$file_path = $path . '/' . $file_name;

		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/dantaiTournamentMatchResultsBase.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体決勝トーナメント結果' );

		$col = 0;
		$row = 4;

		for( $match = 1; $match <= 7; $match++ ){
            if( $match <= 4 ){
                $sheet->setCellValueByColumnAndRow( 0, $row, '準々決勝 第'.($match).'試合' );
            } else if( $match <= 6 ){
                $sheet->setCellValueByColumnAndRow( 0, $row, '準決勝 第'.($match-4).'試合' );
            } else if( $match == 7 ){
                $sheet->setCellValueByColumnAndRow( 0, $row, '決勝' );
            } else if( $match == 8 ){
                $sheet->setCellValueByColumnAndRow( 0, $row, '団体順位決定戦' );
            }
            $row++;
            for( $r = 0; $r < 5; $r++ ) {
                for( $c = 0; $c < 24; $c++ ){
                    // セルを取得
                    $cell = $sheet->getCellByColumnAndRow($c, $r+5);
                    // セルスタイルを取得
                    $style = $sheet->getStyleByColumnAndRow($c, $r+5);
                    // 数値から列文字列に変換する (0,1) → A1
                    $offsetCell = PHPExcel_Cell::stringFromColumnIndex($c) . (string)($row + $r);
                    // セル値をコピー
                    $sheet->setCellValue($offsetCell, $cell->getValue());
                    // スタイルをコピー
                    $sheet->duplicateStyle($style, $offsetCell);

                    $mg_range = 'B' . $row . ":D" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'E' . $row . ":G" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'H' . $row . ":J" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'K' . $row . ":M" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'N' . $row . ":P" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'Q' . $row . ":T" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'U' . $row . ":W" . $row;
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'A' . ($row+1) . ":A" . ($row+2); 
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'B' . ($row+1) . ":D" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'E' . ($row+1) . ":G" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'H' . ($row+1) . ":J" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'K' . ($row+1) . ":M" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'N' . ($row+1) . ":P" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'Q' . ($row+1) . ":Q" . ($row+2);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'T' . ($row+1) . ":T" . ($row+2);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'U' . ($row+1) . ":W" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'A' . ($row+3) . ":A" . ($row+4); 
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'B' . ($row+4) . ":D" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'E' . ($row+4) . ":G" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'H' . ($row+4) . ":J" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'K' . ($row+4) . ":M" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'N' . ($row+4) . ":P" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'Q' . ($row+3) . ":Q" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'T' . ($row+3) . ":T" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'U' . ($row+4) . ":W" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'R' . ($row+1) . ":S" . ($row+1);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'R' . ($row+2) . ":S" . ($row+2);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'R' . ($row+3) . ":S" . ($row+3);
                    $sheet->mergeCells( $mg_range );
                    $mg_range = 'R' . ($row+4) . ":S" . ($row+4);
                    $sheet->mergeCells( $mg_range );
                }
            }
            $row += 5;
        }

		$col = 0;
		$row = 6;
		for( $i1 = 1; $i1 <= 4; $i1++ ){
            $objPage->output_one_match_for_excel( $sheet, $col, $row, $tournament_data['match'][$i1+2], $entry_list, $mw, 46, 46 );
            $row += 6;
        }
		for( $i1 = 1; $i1 <= 2; $i1++ ){
            $objPage->output_one_match_for_excel( $sheet, $col, $row, $tournament_data['match'][$i1], $entry_list, $mw, 46, 46 );
            $row += 6;
        }
        $objPage->output_one_match_for_excel( $sheet, $col, $row, $tournament_data['match'][0], $entry_list, $mw, 46, 46 );
        $row += 6;
        //$objPage->output_one_match_for_excel( $sheet, $col, $row, $tournament_data['match'][7], $entry_list, $mw, 46, 46 );

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
    }

	function output_tournament_match_20_for_excel( $objPage, $path, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_match_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_match_21_for_excel( $objPage, $path, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_match_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, $mw )
	{
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
//print_r($tournament_data);
//exit;
        $file_name = 'H28allnaganoDantaiTounamentResults_' . $mw . '.xls';
        $file_path = $path . '/' . $file_name;
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex( 0 );        //何番目のシートに有効にするか
        $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦 決勝トーナメント結果' );
        $sheet->getStyle('A2')->getFont()->setSize(16);
        $sheet->getRowDimension(1)->setRowHeight(12);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(12);
        $sheet->getRowDimension(4)->setRowHeight(12);

        $styleArrayH = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayV = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayV2 = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayHR = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $styleArrayVR = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $styleArrayVR2 = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $match_level = intval( $tournament_data['match_level'] );
        $tournament_team_num = intval( $tournament_data['tournament_team_num'] );
        $tournament_team_num2 = intval( $tournament_data['tournament_team_num']/2 );
        $col = 0;
        $row = 5;
        $index = 1;
        for( $team = 0; $team < $tournament_team_num; $team++ ){
            if( $team == $tournament_team_num2 ){
                $col = ( $match_level + 1 ) * 2 + 2;
                $row = 5;
            }
            if( $team < $tournament_team_num2 ){
                $sheet->setCellValueByColumnAndRow( $col, $row, $index );
                $sheet->setCellValueByColumnAndRow( $col+1, $row, $tournament_data['team'][$team]['name'] );
            } else {
                $sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['team'][$team]['name'] );
                $sheet->setCellValueByColumnAndRow( $col+1, $row, $index );
            }
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col) . ($row+3);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+1) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+1) . ($row+3);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $row += 4;
            $index++;
        }

        $col1 = 3;
        $col2 = 3 + $match_level * 2 - 1;
        $posTbl1 = array();
        $posTbl2 = array();
        $posTbl3 = array();
        $posTbl4 = array();
        $match_num = $tournament_team_num2;
        $match_num2 = intval( $tournament_team_num2 / 2 );
        for( $level = 0; $level < $match_level-1; $level++ ){
            $col = $col1;
            $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
            $row = 5;
            $pindex = 0;
            $match_no_top = $match_num - 1;
            for( $m = 0; $m < $match_num; $m++ ){
                $mup = intval( $m / 2 );
                $moffset = $m % 2;
                if( $m == $match_num2 ){
                    $col = $col2;
                    $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
                    $row = 5;
                }
                $match = $match_no_top + $m;
                if( $tournament_data['match'][$match]['place'] == 'no_match' ){
                    $up = intval( ( $match + 1 ) / 2 ) - 1;
                    if( $level > 0 ){
                        $r = $posTbl1[$m];
                    } else {
                        $r = $row + 2;
                    }
                    $red = 1;
                    if(
                        ( ( $match % 2 ) == 1 && $tournament_data['match'][$up]['winner'] == 1 )
                        || ( ( $match % 2 ) == 0 && $tournament_data['match'][$up]['winner'] == 2 )
                    ){
                        $sheet->getStyle( $colstr.$r )->applyFromArray( $styleArrayHR );
                        $red = 0;
                    } else {
                        $sheet->getStyle( $colstr.$r )->applyFromArray( $styleArrayH );
                    }
                    if( $moffset == 0 ){
                        $posTbl1[$mup] = $r;
                        $posTbl3[$mup] = $red;
                    } else {
                        $posTbl2[$mup] = $r;
                        $posTbl4[$mup] = $red;
                    }
                    $row += 4;
                } else {
                    if( $level > 0 ){
                        $r1 = $posTbl1[$m];
                        $r2 = $posTbl2[$m];
                        $n1 = $posTbl3[$m];
                        $n2 = $posTbl4[$m];
                    } else {
                        $r1 = $row + 2;
                        $r2 = $row + 6;
                        $n1 = 0;
                        $n2 = 0;
                    }
                    $r3 = intval( ( $r1 + $r2 ) / 2 );
                    if( $moffset == 0 ){
                        $posTbl1[$mup] = $r3;
                        $posTbl3[$mup] = 0;
                    } else {
                        $posTbl2[$mup] = $r3;
                        $posTbl4[$mup] = 0;
                    }
                    $winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$match] );
                    $sheet->mergeCells( $colstr.($r1-2).':'.$colstr.($r1-1) );
                    if( $m >= $match_num2 ){
                        $sheet->setCellValue( $colstr.($r1-2), $winstr[1][2].' '.$winstr[1][1] );
                        $sheet->getStyle($colstr.($r1-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    } else {
                        $sheet->setCellValue( $colstr.($r1-2), $winstr[1][1].' '.$winstr[1][2] );
                        $sheet->getStyle($colstr.($r1-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->getStyle($colstr.($r1-2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['match'][$match]['winner'] == 1 ){
                        $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayHR );
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayVR2 );
                        } else {
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayVR );
                        }
                    } else {
                        if( $level > 0 && $n1 == 0 ){
                            $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayHR );
                        } else {
                            $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayH );
                        }
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayV2 );
                        } else {
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayV );
                        }
                    }
                    if( $tournament_data['match'][$match]['winner'] == 2 ){
                        $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayHR );
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayVR2 );
                        } else {
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayVR );
                        }
                    } else {
                        if( $level > 0 && $n2 == 0 ){
                            $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayHR );
                        } else {
                            $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayH );
                        }
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayV2 );
                        } else {
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayV );
                        }
                    }
                    $sheet->mergeCells( $colstr.($r2).':'.$colstr.($r2+1) );
                    if( $m >= $match_num2 ){
                        $sheet->setCellValue( $colstr.($r2), $winstr[2][2].' '.$winstr[2][1] );
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    } else {
                        $sheet->setCellValue( $colstr.($r2), $winstr[2][1].' '.$winstr[2][2] );
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->getStyle($colstr.($r2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $row += 8;
                }
            }
            $col1++;
            $col2--;
            $match_num = $match_num2;
            $match_num2 = intval( $match_num / 2 );
        }

        $col1 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 2 );
        $col2 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 3 );
        $row = $posTbl1[0];
        $winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][0] );
        $sheet->setCellValue( $col1.($row), $winstr[1][1].' '.$winstr[1][2] );
        $sheet->mergeCells( $col1.($row).':'.$col1.($row+1) );
        $sheet->getStyle($col1.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col1.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1.($row-2).':'.$col1.($row-1) )->applyFromArray( $styleArrayVR );
            $sheet->setCellValue( $col1.($row-4), $tournament_data['match'][0]['team1_name'] );
            $sheet->mergeCells( $col1.($row-4).':'.$col2.($row-3) );
            $sheet->getStyle($col1.($row-4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1.($row-4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.($row-2).':'.$col2.($row-1) )->applyFromArray( $styleArrayVR2 );
            $sheet->setCellValue( $col1.($row-4), $tournament_data['match'][0]['team2_name'] );
            $sheet->mergeCells( $col1.($row-4).':'.$col2.($row-3) );
            $sheet->getStyle($col1.($row-4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1.($row-4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else {
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1.($row-2).':'.$col1.($row-1) )->applyFromArray( $styleArrayV );
        }
        $sheet->setCellValue( $col2.($row), $winstr[2][2].' '.$winstr[2][1] );
        $sheet->mergeCells( $col2.($row).':'.$col2.($row+1) );
        $sheet->getStyle($col2.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col2.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        for( $row = 0; $row < $tournament_player_num2 * 4; $row++ ){
            $sheet->getRowDimension($row+5)->setRowHeight(8);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(2.5+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(12.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))->setWidth(2.5+0.71+0.17);
        for( $col = 0; $col < $match_level-1; $col++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+3))->setWidth(5.0+0.71+0.17);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level-2))->setWidth(6.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level-1))->setWidth(6.0+0.71+0.17);
        for( $col = 0; $col < $match_level-1; $col++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+4+$match_level))->setWidth(5.0+0.71+0.17);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2-1))->setWidth(2.5+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2))->setWidth(12.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2+1))->setWidth(2.5+0.71+0.17);

        $row = 4 * 4 + 5 + 2;
/*
        $sheet->getStyle('A'.($row))->getFont()->setSize(16);
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        $sheet->setCellValueByColumnAndRow( 0, $row, '順位決定戦' );
        $sheet->getStyle('A'.($row))->getFont()->setSize(16);
        $sheet->getRowDimension($row)->setRowHeight(20);
        $row++;
        $sheet->getStyle('A'.($row))->getFont()->setSize(16);
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        if( $tournament_data['match'][1]['winner'] == 1 ){
            $sheet->setCellValue( 'B'.$row, $tournament_data['match'][1]['team2_name'] );
        } else if( $tournament_data['match'][1]['winner'] == 2 ){
            $sheet->setCellValue( 'B'.$row, $tournament_data['match'][1]['team1_name'] );
        }
        if( $tournament_data['match'][2]['winner'] == 1 ){
            $sheet->setCellValue( 'B'.($row+4), $tournament_data['match'][2]['team2_name'] );
        } else if( $tournament_data['match'][2]['winner'] == 2 ){
            $sheet->setCellValue( 'B'.($row+4), $tournament_data['match'][2]['team1_name'] );
        }
        $sheet->mergeCells( 'B'.($row).':C'.($row+3) );
        $sheet->getStyle( 'B'.($row) )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle( 'B'.($row) )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->mergeCells( 'B'.($row+4).':C'.($row+7) );
        $sheet->getStyle( 'B'.($row+4) )->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle( 'B'.($row+4) )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['match'][$tournament_team_num-1]['winner'] == 1 ){
            $sheet->getStyle( 'E'.($row+2) )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'E'.($row+6) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'E'.($row+2).':E'.($row+3) )->applyFromArray( $styleArrayVR );
            $sheet->getStyle( 'E'.($row+4).':E'.($row+5) )->applyFromArray( $styleArrayV );
            $sheet->getStyle( 'F'.($row+4) )->applyFromArray( $styleArrayHR );
            $sheet->setCellValue( 'H'.($row+3), $tournament_data['match'][$tournament_team_num-1]['player1_name'] );
            $sheet->mergeCells( 'H'.($row+3).':'.'J'.($row+4) );
            $sheet->getStyle('H'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else if( $tournament_data['match'][$tournament_team_num-1]['winner'] == 2 ){
            $sheet->getStyle( 'E'.($row+2) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'E'.($row+6) )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'E'.($row+2).':E'.($row+3) )->applyFromArray( $styleArrayV );
            $sheet->getStyle( 'E'.($row+4).':E'.($row+5) )->applyFromArray( $styleArrayVR );
            $sheet->getStyle( 'F'.($row+4) )->applyFromArray( $styleArrayHR );
            $sheet->setCellValue( 'H'.($row+3), $tournament_data['match'][$tournament_team_num-1]['player2_name'] );
            $sheet->mergeCells( 'H'.($row+3).':'.'J'.($row+4) );
            $sheet->getStyle('H'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else {
            $sheet->getStyle( 'E'.($row+2) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'E'.($row+6) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'E'.($row+2).':E'.($row+5) )->applyFromArray( $styleArrayV );
            $sheet->getStyle( 'F'.($row+4) )->applyFromArray( $styleArrayH );
        }
        $winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$tournament_team_num-1] );
        $sheet->setCellValue( 'E'.($row), $winstr[1][1].' '.$winstr[1][2] );
        $sheet->mergeCells( 'E'.($row).':'.'E'.($row+1) );
        $sheet->getStyle('E'.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E'.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->setCellValue( 'E'.($row+6), $winstr[2][2].' '.$winstr[2][1] );
        $sheet->mergeCells( 'E'.($row+6).':'.'E'.($row+7) );
        $sheet->getStyle('E'.($row+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('E'.($row+6))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        for( $r1 = 0; $r1 < 8; $r1++ ){
            $sheet->getRowDimension($row+$r1)->setRowHeight(8);
        }

        $row = 4 * 4 + 5 + 2 + 3 + 8;
*/
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        $sheet->setCellValueByColumnAndRow( 0, $row, '順位' );
        $sheet->getStyle('A'.($row))->getFont()->setSize(16);
        $sheet->getRowDimension($row)->setRowHeight(20);
        $row++;
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '優勝' );
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team1_name'] );
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team2_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '準優勝' );
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team2_name'] );
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '３位' );
        if( $tournament_data['match'][1]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][1]['team2_name'] );
        } else if( $tournament_data['match'][1]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][1]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '３位' );
        if( $tournament_data['match'][2]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][2]['team2_name'] );
        } else if( $tournament_data['match'][2]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][2]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_tournament_20_for_excel( $objPage, $path, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_21_for_excel( $objPage, $path, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_20_21_for_excel( $objPage, $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_chart_20_21_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, $mv )
	{
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/dtc'.$mv.'.xlsx';
		$file_name = 'dtc' . $mv . '.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/dantaiTournamentChartBase.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValue( 'X4', $mvstr.'団体戦結果' );

		$styleArrayH = array(
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('argb' => 'FFFF0000')
				)
			)
		);
		$styleArrayV = array(
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('argb' => 'FFFF0000')
				)
			)
		);

		$row = 7;
		$chartRowLeagueName = 'B';
		$chartRowLeagueSchool = 'C';
		$chartRowLeaguePref = 'E';
		$chartRowName = 'I';
		$chartRowName2 = 'N';
		$chartRowStart = 'J';
		$chartRowEnd = 'L';
		$chartRowV = 'L';
		$chartRowStart2 = 'M';
		$chartRowEnd2 = 'M';
		$chartRowWin = 'K';
		$chartRowWin2 = 'L';
		for( $i1 = 7; $i1 <= 14; $i1++ ){
			foreach( $league_data as $lv ){
				for( $tn = 0; $tn < 3; $tn++ ){
					if( $lv['team'][$tn]['team'] == $tournament_data['match'][$i1]['team1'] ){
						$sheet->setCellValue( $chartRowLeagueName.$row, substr( $lv['name'], 0, 1 ) );
						for( $tn2 = 0; $tn2 < 3; $tn2++ ){
							for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
								if( $lv['team'][$tn2]['team'] == $entry_list[$i2]['id'] ){
									if( mb_strlen( $entry_list[$i2]['school_name'], 'UTF-8' ) > 13 ){
										$sheet->getStyle($chartRowLeagueSchool.($row+$tn2*2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
										$sheet->getStyle($chartRowLeagueSchool.($row+$tn2*2))->getAlignment()->setShrinkToFit(true);
									}
									$sheet->setCellValue( $chartRowLeagueSchool.($row+$tn2*2), $entry_list[$i2]['school_name'] );
									$sheet->setCellValue( $chartRowLeaguePref.($row+$tn2*2), $entry_list[$i2]['school_address_pref_name'] );
									break;
								}
							}
						}
						break;
					}
				}
			}
			$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$i1] );
			$sheet->setCellValue( $chartRowName.$row, $tournament_data['match'][$i1]['team1_name'] );
			$sheet->setCellValue( $chartRowWin.($row+1), $winstr[1][0] );
			$sheet->setCellValue( $chartRowWin.($row+2), $winstr[1][1] );
			$sheet->setCellValue( $chartRowWin2.($row+1), $winstr[1][2] );
			if( $tournament_data['match'][$i1]['winner'] == 1 ){
				$sheet->getStyle($chartRowStart.($row+3).':'.$chartRowEnd.($row+3))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.($row+3).':'.$chartRowV.($row+6))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row+7).':'.$chartRowEnd2.($row+7))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName2.($row+2), $tournament_data['match'][$i1]['team1_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team1'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName2.($row+8), $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$row += 8;
			foreach( $league_data as $lv ){
				for( $tn = 0; $tn < 3; $tn++ ){
					if( $lv['team'][$tn]['team'] == $tournament_data['match'][$i1]['team2'] ){
						$sheet->setCellValue( $chartRowLeagueName.$row, substr( $lv['name'], 0, 1 ) );
						for( $tn2 = 0; $tn2 < 3; $tn2++ ){
							for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
								if( $lv['team'][$tn2]['team'] == $entry_list[$i2]['id'] ){
									$sheet->setCellValue( $chartRowLeagueSchool.($row+$tn2*2), $entry_list[$i2]['school_name'] );
									$sheet->setCellValue( $chartRowLeaguePref.($row+$tn2*2), $entry_list[$i2]['school_address_pref_name'] );
									break;
								}
							}
						}
						break;
					}
				}
			}
			$sheet->setCellValue( $chartRowName.$row, $tournament_data['match'][$i1]['team2_name'] );
			$sheet->setCellValue( $chartRowWin.($row+3), $winstr[2][0] );
			$sheet->setCellValue( $chartRowWin.($row+4), $winstr[2][1] );
			$sheet->setCellValue( $chartRowWin2.($row+3), $winstr[2][2] );
			if( $tournament_data['match'][$i1]['winner'] == 2 ){
				$sheet->getStyle($chartRowStart.($row+3).':'.$chartRowEnd.($row+3))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.($row-1).':'.$chartRowV.($row+2))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row-1).':'.$chartRowEnd2.($row-1))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName2.($row-6), $tournament_data['match'][$i1]['team2_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team2'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName2.$row, $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$row += 8;
			if( $i1 == 10 ){
				$row = 7;
				$chartRowName = 'AY';
				$chartRowName2 = 'AT';
				$chartRowStart = 'AV';
				$chartRowEnd = 'AX';
				$chartRowWin = 'AW';
				$chartRowWin2 = 'AV';
				$chartRowV = 'AU';
				$chartRowStart2 = 'AU';
				$chartRowEnd2 = 'AU';
				$chartRowLeagueName = 'BB';
				$chartRowLeagueSchool = 'BC';
				$chartRowLeaguePref = 'BE';
			}
		}

		$row = 14;
		$chartRowName = 'S';
		$chartRowStart = 'O';
		$chartRowEnd = 'Q';
		$chartRowV = 'Q';
		$chartRowStart2 = 'R';
		$chartRowEnd2 = 'R';
		$chartRowWin = 'P';
		$chartRowWin2 = 'Q';
		for( $i1 = 3; $i1 <= 6; $i1++ ){
			$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$i1] );
			$sheet->setCellValue( $chartRowWin.($row-2), $winstr[1][0] );
			$sheet->setCellValue( $chartRowWin.($row-1), $winstr[1][1] );
			$sheet->setCellValue( $chartRowWin2.($row-2), $winstr[1][2] );
			if( $tournament_data['match'][$i1]['winner'] == 1 ){
				$sheet->getStyle($chartRowStart.$row.':'.$chartRowEnd.$row)->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.$row.':'.$chartRowV.($row+7))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row+8).':'.$chartRowEnd2.($row+8))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName.($row+3), $tournament_data['match'][$i1]['team1_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team1'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName.($row+9), $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$sheet->setCellValue( $chartRowWin.($row+16), $winstr[2][0] );
			$sheet->setCellValue( $chartRowWin.($row+17), $winstr[2][1] );
			$sheet->setCellValue( $chartRowWin2.($row+16), $winstr[2][2] );
			if( $tournament_data['match'][$i1]['winner'] == 2 ){
				$sheet->getStyle($chartRowStart.($row+16).':'.$chartRowEnd.($row+16))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.($row+8).':'.$chartRowV.($row+15))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row+8).':'.$chartRowEnd2.($row+8))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName.($row+3), $tournament_data['match'][$i1]['team2_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team2'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName.($row+9), $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$row += 32;
			if( $i1 == 4 ){
				$row = 14;
				$chartRowName = 'AO';
				$chartRowStart = 'AQ';
				$chartRowEnd = 'AS';
				$chartRowV = 'AP';
				$chartRowStart2 = 'AP';
				$chartRowEnd2 = 'AP';
				$chartRowWin = 'AR';
				$chartRowWin2 = 'AQ';
			}
		}

		$row = 22;
		$chartRowName = 'X';
		$chartRowStart = 'T';
		$chartRowEnd = 'V';
		$chartRowV = 'V';
		$chartRowStart2 = 'W';
		$chartRowEnd2 = 'W';
		$chartRowWin = 'U';
		$chartRowWin2 = 'V';
		for( $i1 = 1; $i1 <= 2; $i1++ ){
			$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$i1] );
			$sheet->setCellValue( $chartRowWin.($row-2), $winstr[1][0] );
			$sheet->setCellValue( $chartRowWin.($row-1), $winstr[1][1] );
			$sheet->setCellValue( $chartRowWin2.($row-2), $winstr[1][2] );
			if( $tournament_data['match'][$i1]['winner'] == 1 ){
				$sheet->getStyle($chartRowStart.$row.':'.$chartRowEnd.$row)->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.$row.':'.$chartRowV.($row+15))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row+16).':'.$chartRowEnd2.($row+16))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName.($row+11), $tournament_data['match'][$i1]['team1_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team1'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName.($row+17), $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$sheet->setCellValue( $chartRowWin.($row+32), $winstr[2][0] );
			$sheet->setCellValue( $chartRowWin.($row+33), $winstr[2][1] );
			$sheet->setCellValue( $chartRowWin2.($row+32), $winstr[2][2] );
			if( $tournament_data['match'][$i1]['winner'] == 2 ){
				$sheet->getStyle($chartRowStart.($row+32).':'.$chartRowEnd.($row+32))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRowV.($row+16).':'.$chartRowV.($row+31))->applyFromArray($styleArrayV);
				$sheet->getStyle($chartRowStart2.($row+16).':'.$chartRowEnd2.($row+16))->applyFromArray($styleArrayH);
				$sheet->setCellValue( $chartRowName.($row+11), $tournament_data['match'][$i1]['team2_name'] );
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $tournament_data['match'][$i1]['team2'] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue( $chartRowName.($row+17), $entry_list[$i2]['school_address_pref_name'] );
						break;
					}
				}
			}
			$row = 22;
			$chartRowName = 'AI';
			$chartRowStart = 'AK';
			$chartRowEnd = 'AN';
			$chartRowV = 'AJ';
			$chartRowStart2 = 'AJ';
			$chartRowEnd2 = 'AJ';
			$chartRowWin = 'AL';
			$chartRowWin2 = 'AK';
		}

		$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][0] );
		$sheet->setCellValue( 'Z36', $winstr[1][0] );
		$sheet->setCellValue( 'Z37', $winstr[1][1] );
		$sheet->setCellValue( 'AA36', $winstr[1][2] );
		if( $tournament_data['match'][0]['winner'] == 1 ){
			$sheet->getStyle( 'Y38:AC38' )->applyFromArray($styleArrayH);
			$sheet->getStyle( 'AC33:AC37' )->applyFromArray($styleArrayV);
			$sheet->setCellValue( 'AC19', $tournament_data['match'][0]['team1_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][0]['team1'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'AC29', $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}
		$sheet->setCellValue( 'AG36', $winstr[2][0] );
		$sheet->setCellValue( 'AG37', $winstr[2][1] );
		$sheet->setCellValue( 'AF36', $winstr[2][2] );
		if( $tournament_data['match'][0]['winner'] == 2 ){
			$sheet->getStyle( 'AD38:AH38' )->applyFromArray($styleArrayH);
			$sheet->getStyle( 'AC33:AC37' )->applyFromArray($styleArrayV);
			$sheet->setCellValue( 'AC19', $tournament_data['match'][0]['team2_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][0]['team2'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'AC29', $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		if( $tournament_data['match'][0]['winner'] != 0 ){
			if( $tournament_data['match'][0]['winner'] == 1 ){
				$team[0] = $tournament_data['match'][0]['team1'];
				$team[1] = $tournament_data['match'][0]['team2'];
			} else if( $tournament_data['match'][0]['winner'] == 2 ){
				$team[0] = $tournament_data['match'][0]['team2'];
				$team[1] = $tournament_data['match'][0]['team1'];
			}
			if( $tournament_data['match'][1]['team1'] == $team[0] ){
				$team[2] = $tournament_data['match'][1]['team2'];
				if( $tournament_data['match'][2]['winner'] == 1 ){
					$team[3] = $tournament_data['match'][2]['team2'];
				} else if( $tournament_data['match'][2]['winner'] == 2 ){
					$team[3] = $tournament_data['match'][2]['team1'];
				}
			} else if( $tournament_data['match'][1]['team2'] == $team[0] ){
				$team[2] = $tournament_data['match'][1]['team1'];
				if( $tournament_data['match'][2]['winner'] == 1 ){
					$team[3] = $tournament_data['match'][2]['team2'];
				} else if( $tournament_data['match'][2]['winner'] == 2 ){
					$team[3] = $tournament_data['match'][2]['team1'];
				}
			} else if( $tournament_data['match'][2]['team1'] == $team[0] ){
				$team[3] = $tournament_data['match'][2]['team2'];
				if( $tournament_data['match'][1]['winner'] == 1 ){
					$team[2] = $tournament_data['match'][1]['team2'];
				} else if( $tournament_data['match'][1]['winner'] == 2 ){
					$team[2] = $tournament_data['match'][1]['team1'];
				}
			} else if( $tournament_data['match'][2]['team2'] == $team[0] ){
				$team[3] = $tournament_data['match'][2]['team1'];
				if( $tournament_data['match'][1]['winner'] == 1 ){
					$team[2] = $tournament_data['match'][1]['team2'];
				} else if( $tournament_data['match'][1]['winner'] == 2 ){
					$team[2] = $tournament_data['match'][1]['team1'];
				}
			}
			for( $i1 = 0; $i1 <= 3; $i1++ ){
				for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
					if( $team[$i1] == $entry_list[$i2]['id'] ){
						$sheet->setCellValue(
							'Z'.(47+$i1),
							$entry_list[$i2]['school_name'].'（'.$entry_list[$i2]['school_address_pref_name'].'）'
						);
						break;
					}
				}
			}
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_tournament_chart_20_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, $mv )
	{
		return __output_tournament_chart_20_21_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, 'm' );
	}

	function output_tournament_chart_21_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, $mv )
	{
		return __output_tournament_chart_20_21_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_match_for_HTML2_20_21( $objPage, $path, $tournament_list, $entry_list, $mv )
	{
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mvstr.'団体決勝トーナメント結果</title>'."\n";
		$header .= '<link href="../preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";
		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果</h2>'."\n";

		for( $i1 = 1; $i1 <= 4; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準々決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1+2], $entry_list, $mv );
		}
		for( $i1 = 1; $i1 <= 2; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1], $entry_list, $mv );
		}
		$html .= '<h3>団体決勝トーナメント&nbsp;決勝</h3>';
		$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][0], $entry_list, $mv );
/*
		$html .= '<h3>団体順位決定戦</h3>';
		$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][7], $entry_list, $mv );
*/
		$html .= $footer;
		$file = $path . '/dtm'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_tournament_match_for_HTML2_20( $objPage, $path, $tournament_list, $entry_list )
	{
		__output_tournament_match_for_HTML2_20_21( $objPage, $path, $tournament_list, $entry_list, 'm' );
	}

	function output_tournament_match_for_HTML2_21( $objPage, $path, $tournament_list, $entry_list )
	{
		__output_tournament_match_for_HTML2_20_21( $objPage, $path, $tournament_list, $entry_list, 'w' );
	}


	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_21_for_PDF( $tournament_data, $entry_list, $mv )
	{
	}

	function output_tournament_20_for_PDF( $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$table_height = 6;
		$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
	//	$pdf = '' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
		//	. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<style>' . "\n"
			. 'body { font-family: \'DejaVu Sans Condensed\'; font-size: 5pt;  }'. "\n"
			. '.content {' . "\n"
		//	. '    position: relative;' . "\n"
			. '    width: 980px;' . "\n"
			. '    height: 980px;' . "\n"
			. '    font-size: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: 60px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//	. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_pref {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 80px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: 40px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 140px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: 10px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 40px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_border_none {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 1px 0 0 1px;' . "\n"
			. '}' . "\n"
			. '.div_border_none2 {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 0 1px 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_b {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_r {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_l {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
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
			. '.tb_result_tournament_name_num2 {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 2px 0 8px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '}' . "\n"
			. '.clearfix:after {' . "\n"
			. '  content: "";' . "\n"
			. '  clear: both;' . "\n"
			. '  display: block;' . "\n"
			. '}' . "\n"
			. '</style>' . "\n"
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja"小学校トーナメント表</H1>' . "\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";

		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['team'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = '';
			$pref = '';
			$id = intval( $tournament_data['team'][$tournament_team]['id'] );
			if( $id > 0 ){
				foreach( $entry_list as $ev ){
					if( $id == intval( $ev['id'] ) ){
						if( $ev['school_name_ryaku'] != '' ){
							$name = $ev['school_name_ryaku'];
						} else {
							$name = $ev['school_name'];
						}
						$pref = $ev['school_address_pref_name'];
						break;
					}
				}
			}
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
				$one_match['team1'] = array(
					'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
				);
				$team_pos++;
				$match_no++;
				$team_index++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				if( $tournament_team < $team_num2 ){
					$match_line1[] = $one_match;
				} else {
					$match_line2[] = $one_match;
				}
				$one_match = array();
			}
		}
		$match_no_top /= 2;

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['match_level']-1; $i1++ ){
			$match_no = $match_no_top;
			for( $line = 0; $line < 2; $line++ ){
				$match_line = array();
				$one_match = array();
				for( $i2 = 0; $i2 < count( $match_tbl[$line][$i1-1] ); $i2++ ){
					if( $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match' ){
						$pos = $match_tbl[$line][$i1-1][$i2]['team1']['pos'];
					} else {
						$pos = intval( ( $match_tbl[$line][$i1-1][$i2]['team1']['pos'] + $match_tbl[$line][$i1-1][$i2]['team2']['pos'] ) / 2 );
					}
					if( ( $i2 % 2 ) == 0 ){
						$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
						$one_match['team1']['pos'] = $pos;
						$match_no++;
					} else {
						$one_match['team2']['pos'] = $pos;
						$match_line[] = $one_match;
						$one_match = array();
					}
				}
				$match_tbl[$line][] = $match_line;
			}
			$match_no_top /= 2;
		}
//print_r($match_tbl);

		$trpos = array();
		$trofs = array();
		$trspan = array();
		$trmatch = array();
		$trpos2 = array();
		$trofs2 = array();
		$trspan2 = array();
		$trmatch2 = array();
		for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
			$trpos[] = 0;
			$trofs[] = 0;
			$trspan[] = 0;
			$trmatch[] = 0;
			$trpos2[] = 0;
			$trofs2[] = 0;
			$trspan2[] = 0;
			$trmatch2[] = 0;
		}
		$namespan = 0;
		$namespan2 = 0;
		$line = 0;
		$name_index = 1;
		$line2 = $team_index;
		$pdf .=  '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		for(;;){
			$pdf .= '      <tr>' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="2" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="2" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="2" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$namespan = 1;
						$name_index++;
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b div_result_one_tournament"></td>' . "\n";
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						$trofs[$level] = 1;
						$trmatch[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="2" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="2" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="2" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
							$namespan = 1;
							$name_index++;
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_br div_result_one_tournament"></td>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							if( $namespan > 0 ){
								$namespan--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							}
						}
						if( $trspan[$level] > 0 ){
							$trspan[$level]--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_border_r div_result_one_tournament">';
							if( $line == $trmatch[$level] ){
								$pdf .= $one_match_tbl['place'].'-'.$one_match_tbl['place_match_no'] . '&nbsp;';
							}
							$pdf .= '</td>' . "\n";
						}
					}
				} else {
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
				}
				$allend = 0;
			}
			if( $line == $line2-1 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_r div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_br div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_b div_result_one_tournament"></td>';
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['match_level']-2; $level >= 0; $level-- ){
				if( $trpos2[$level] >= count( $match_tbl[1][$level] ) ){
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[1][$level][$trpos2[$level]];
				if( $trofs2[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					$pdf .= '<td height="'.$table_height.'" class="div_border_b div_result_one_tournament"></td>' . "\n";
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="2" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="2" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="2" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$namespan2 = 1;
						$name_index++;
					}
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						$trofs2[$level] = 1;
						$trmatch2[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs2[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						$pdf .= '<td height="'.$table_height.'" class="div_border_bl div_result_one_tournament"></td>' . "\n";
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="2" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="2" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="2" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$namespan2 = 1;
							$name_index++;
						}
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						if( $trspan2[$level] > 0 ){
							$trspan2[$level]--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_border_l div_result_one_tournament2">';
							if( $line == $trmatch2[$level] ){
								$pdf .= '&nbsp;' . $one_match_tbl['place'].'-'.$one_match_tbl['place_match_no'];
							}
							$pdf .= '</td>' . "\n";
						}
						if( $level == 0 ){
							if( $namespan2 > 0 ){
								$namespan2--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							}
						}
					}
				} else {
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
			$pdf .= "\n".'      </tr>' . "\n";
if( $line == 300 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '  </div>' . "\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

echo $pdf;
exit;
		return $pdf;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_20_21_for_HTML( $path, $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
//print_r($entry_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 148;
			$table_name_pref_width = 120;
			$table_height = 11; //6;
			$table_font_size = 18; //11;
			$table_place_font_size = 10; //6;
			$table_cell_width = 40; //30;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 120;
			$table_height = 11;
			$table_font_size = 18; //11;
			$table_place_font_size = 10; //6;
			$table_cell_width = 40;
		}
		$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
	//	$pdf = '' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
		//	. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<style>' . "\n"
			. 'body { font-family: \'DejaVu Sans Condensed\'; font-size: 5pt;  }'. "\n"
			. '.content {' . "\n"
		//	. '    position: relative;' . "\n"
			. '    width: 980px;' . "\n"
			. '    height: 980px;' . "\n"
			. '    font-size: 5px;' . "\n"
			. '    margin: 16px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: '.$table_name_name_width.'px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//	. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_pref {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: left;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 80px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: '.$table_name_pref_width.'px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: right;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 140px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: 16px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 16px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_border_none {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 1px 0 0 1px;' . "\n"
			. '}' . "\n"
			. '.div_border_none2 {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 0 1px 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_b {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_r {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_l {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
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
			. '.tb_result_tournament_name_num2 {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 2px 0 8px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '}' . "\n"
			. '.clearfix:after {' . "\n"
			. '  content: "";' . "\n"
			. '  clear: both;' . "\n"
			. '  display: block;' . "\n"
			. '}' . "\n"
			. '</style>' . "\n"
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
//print_r($tournament_data);
		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['team'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( count( $tournament_data['match'] ) == 0 ){ continue; }
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = '';
			$pref = '';
			$id = intval( $tournament_data['team'][$tournament_team]['id'] );
			if( $id > 0 ){
				foreach( $entry_list as $ev ){
					if( $id == intval( $ev['id'] ) ){
						if( $ev['school_name_ryaku'] != '' ){
							$name = $ev['school_name_ryaku'];
						} else {
							$name = $ev['school_name'];
						}
						$pref = $ev['school_address_pref_name'];
						break;
					}
				}
			}
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['win1'] = $tournament_data['match'][$match_no-1]['win1'];
				$one_match['hon1'] = $tournament_data['match'][$match_no-1]['hon1'];
				$one_match['win2'] = $tournament_data['match'][$match_no-1]['win2'];
				$one_match['hon2'] = $tournament_data['match'][$match_no-1]['hon2'];
				$one_match['winner'] = $tournament_data['match'][$match_no-1]['winner'];
				$one_match['fusen'] = $tournament_data['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
				$one_match['team1'] = array(
					'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
				);
				$team_pos++;
				$match_no++;
				$team_index++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				if( $tournament_team < $team_num2 ){
					$match_line1[] = $one_match;
				} else {
					$match_line2[] = $one_match;
				}
				$one_match = array();
			}
		}
		$match_no_top /= 2;

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['match_level']-1; $i1++ ){
			$match_no = $match_no_top;
			for( $line = 0; $line < 2; $line++ ){
				$match_line = array();
				$one_match = array();
				for( $i2 = 0; $i2 < count( $match_tbl[$line][$i1-1] ); $i2++ ){
					if( $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match' ){
						$pos = $match_tbl[$line][$i1-1][$i2]['team1']['pos'];
					} else {
						$pos = intval( ( $match_tbl[$line][$i1-1][$i2]['team1']['pos'] + $match_tbl[$line][$i1-1][$i2]['team2']['pos'] ) / 2 );
					}
					if( ( $i2 % 2 ) == 0 ){
						$one_match['up1'] = 0;
						$one_match['up2'] = 0;
					//	$one_match['match_no'] = $match_no;
					//	$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
						$one_match['match_no'] = $tournament_data['match'][$match_no-1]['match'];
						$one_match['win1'] = $tournament_data['match'][$match_no-1]['win1'];
						$one_match['hon1'] = $tournament_data['match'][$match_no-1]['hon1'];
						$one_match['win2'] = $tournament_data['match'][$match_no-1]['win2'];
						$one_match['hon2'] = $tournament_data['match'][$match_no-1]['hon2'];
						$one_match['winner'] = $tournament_data['match'][$match_no-1]['winner'];
						$one_match['fusen'] = $tournament_data['match'][$match_no-1]['fusen'];
						$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
						$one_match['team1']['pos'] = $pos;
						$match_no++;
					} else {
						$one_match['team2']['pos'] = $pos;
						if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $one_match['winner'] == 1 ){
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							} else if( $one_match['winner'] == 2 ){
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
								$one_match['up2'] = 1;
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
								$one_match['up1'] = 1;
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
							}
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
							}
						}
						$match_line[] = $one_match;
						$one_match = array();
					}
				}
				$match_tbl[$line][] = $match_line;
			}
			$match_no_top /= 2;
		}
//print_r($match_tbl);

		$trpos = array();
		$trofs = array();
		$trspan = array();
		$trmatch = array();
		$trpos2 = array();
		$trofs2 = array();
		$trspan2 = array();
		$trmatch2 = array();
		for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
			$trpos[] = 0;
			$trofs[] = 0;
			$trspan[] = 0;
			$trmatch[] = 0;
			$trpos2[] = 0;
			$trofs2[] = 0;
			$trspan2[] = 0;
			$trmatch2[] = 0;
		}
		$namespan = 0;
		$namespan2 = 0;
		$line = 0;
		$name_index = 1;
		$line2 = $team_index;
		$pdf .=  '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		for(;;){
			$pdf .= '      <tr>' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$namespan = $table_name_rowspan - 1;
						$name_index++;
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b';
					if( $one_match_tbl['winner'] == 1 ){
						$pdf .= '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$pdf .= '_up';
					}
					$pdf .= ' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					}
					$pdf .= '</td>' . "\n";
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						$trofs[$level] = 1;
						$trmatch[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$namespan = $table_name_rowspan - 1;
							$name_index++;
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_br';
						if( $one_match_tbl['winner'] == 2 ){
							$pdf .= '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$pdf .= '_up';
						}
						$pdf .= ' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						}
						$pdf .= '</td>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							if( $namespan > 0 ){
								$namespan--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							}
						}
						if( $trspan[$level] > 0 ){
							$trspan[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament">';
							if( $line == $trmatch[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								$pdf .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '　';
								//$pdf .= '<a href_="'.sprintf('%03d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>　';
							}
							$pdf .= '</td>' . "\n";
						}
					}
				} else {
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
				}
				$allend = 0;
			}
			if( $line == $line2-1 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 2 ){
				if( $tournament_data['match'][0]['winner'] > 0 ){
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;">'.$tournament_data['match'][0]['win1'].' -'.'</td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"> '.$tournament_data['match'][0]['win2'].'</td>';
					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;"><a href="'.sprintf('%03d',$one_match_tbl['match_no']-1).'.html">'.$tournament_data['match'][0]['win1'].' -'.'</a></td>';
					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"><a href="'.sprintf('%03d',$one_match_tbl['match_no']-1).'.html"> '.$tournament_data['match'][0]['win2'].'</a></td>';
				} else {
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				}
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['match_level']-2; $level >= 0; $level-- ){
				if( $trpos2[$level] >= count( $match_tbl[1][$level] ) ){
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[1][$level][$trpos2[$level]];
				if( $trofs2[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					$win = '';
					if( $one_match_tbl['winner'] == 1 ){
						$win = '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$win = '_up';
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					}
					$pdf .= '</td>' . "\n";
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
						$namespan2 = $table_name_rowspan - 1;
						$name_index++;
					}
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						$trofs2[$level] = 1;
						$trmatch2[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs2[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						$win = '';
						if( $one_match_tbl['winner'] == 2 ){
							$win = '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$win = '_up';
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_bl'.$win.' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						}
						$pdf .= '</td>' . "\n";
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
							$namespan2 = $table_name_rowspan - 1;
							$name_index++;
						}
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						if( $trspan2[$level] > 0 ){
							$trspan2[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch2[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch2[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2">';
							if( $line == $trmatch2[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								$pdf .= '　' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
								//$pdf .= '　<a href_="'.sprintf('%03d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>';
							}
							$pdf .= '</td>' . "\n";
						}
						if( $level == 0 ){
							if( $namespan2 > 0 ){
								$namespan2--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							}
						}
					}
				} else {
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
			$pdf .= "\n".'      </tr>' . "\n";
if( $line == 300 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
		$pdf .= '    </table>' . "\n";
		$pdf .= '  <br /><br /><br /><br /><br /><br />' . "\n";
/*
        $pdf .= '<div class="div_result_tournament_name_name">順位決定戦</div>' . "\n";
		$pdf .= '  <br /><br /><br />' . "\n";
		$pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		$pdf .= '<tr>' . "\n";
		$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['match'][7]['team1_name'] . '</td>' . "\n";
		$pdf .= '<td height="'.$table_height.'" class="div_border_b';
            if( $tournament_data['match'][7]['winner'] == 1 ){ $pdf .= '_win'; }
		        $pdf .= ' div_result_one_tournament"></td>' . "\n";
		$pdf .= '</tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
            if( $tournament_data['match'][7]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
            if( $tournament_data['match'][7]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament">';
            if( $tournament_data['match'][7]['winner'] != 0 ){ $pdf .= $tournament_data['match'][7]['win1'] . ' - ' . $tournament_data['match'][7]['win2']; }
                $pdf .= '&nbsp;&nbsp;</td><td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td><td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
        if( $tournament_data['match'][7]['winner'] == 1 ){
		    $pdf .= $tournament_data['match'][7]['team1_name'];
        } else if( $tournament_data['match'][7]['winner'] == 2 ){
		    $pdf .= $tournament_data['match'][7]['team2_name'];
        }
		$pdf .= '</td></tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td><td height="'.$table_height.'" class="div_border_r';
            if( $tournament_data['match'][7]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
		$pdf .= '<tr>' . "\n";
		$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['match'][7]['team2_name'] . '<td height="'.$table_height.'" class="div_border_br';
            if( $tournament_data['match'][7]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td>' . "\n";
		$pdf .= '</tr>' . "\n";
		$pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
		$pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";

		$pdf .= '  </table>' . "\n";
		$pdf .= '  <br /><br /><br />' . "\n";
		$pdf .= '  </div>' . "\n";
*/
		$pdf .= "\n";
		$pdf .= '<script>'."\n";
		$pdf .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$pdf .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$pdf .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$pdf .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$pdf .= "\n";
		$pdf .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$pdf .= '  ga(\'send\', \'pageview\');'."\n";
		$pdf .= "\n";
		$pdf .= '</script>'."\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

//echo $pdf;
//exit;
		$file = $path.'/dt'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );
	//	return $pdf;
	}

	function output_tournament_20_for_HTML( $path, $tournament_data, $entry_list )
	{
		__output_tournament_20_21_for_HTML( $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_21_for_HTML( $path, $tournament_data, $entry_list )
	{
		__output_tournament_20_21_for_HTML( $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel20_21( $sheet, $series, $mv, $start_pos, $series_name, $kaisai_rev )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $c->get_pref_array();
		$orgtbl = $c->get_org_array();
		$shokumeitbl = $c->get_shokumei_array();
		$gradetbl = $c->get_grade_junior_array();
		$kaisai = 0;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.__REG_SERIES_YEAR__;
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval($fields['school_address_pref']);
			if( $pref == 0 ){ continue; }
			$pos = $c->get_pref_order( $pref );
			if( $pos == 47 ){
				if( $kaisai == 0 ){
					$kaisai = 1;
					if( $kaisai_rev == 1 ){ $pos++; }
				} else {
					if( $kaisai_rev == 0 ){ $pos++; }
				}
			}
			$pos = $start_pos + $pos - 1;
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $series_name );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_email'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			if( $fields['insotu1_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_kana_sei'].' '.$fields['insotu1_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_mobile'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			if( $fields['insotu2_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );

			for( $player = 1; $player <= 7; $player++ ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mv.$player.'_sei'].' '.$fields['dantai_'.$mv.$player.'_mei'] );
				if( $fields['dantai_'.$mv.$player.'_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mv.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_kana_'.$mv.$player.'_sei'].' '.$fields['dantai_kana_'.$mv.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['dantai_gakunen_dan_'.$mv.$player.'_gakunen']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_gakunen_dan_'.$mv.$player.'_dan'] );
			}
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['entry_num_'.$mv] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['introduction_'.$mv] );
			$pos++;
		}
		db_close( $dbs );
		return $pos;
	}

	function output_entry_data_list_all_1_excel20( $sheet )
	{
		__output_entry_data_list_all_1_excel20_21( $sheet, 20, 'm', 4, '団体戦男子', 1 );
		__output_entry_data_list_all_1_excel20_21( $sheet, 21, 'w', 4+48, '団体戦女子', 1 );
		return false;
	}

	function output_entry_data_list_all_1_excel21( $sheet )
	{
		__output_entry_data_list_all_1_excel20_21( $sheet, 20, 'm', 4, '団体戦男子', 1 );
		__output_entry_data_list_all_1_excel20_21( $sheet, 21, 'w', 4+48, '団体戦女子', 1 );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_20_21( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$sql = 'select * from `entry_field` where `field` in (\'school_name\',\'join\') and `year`='.__REG_SERIES_YEAR__;
		$field_list = db_query_list( $dbs, $sql );
		$ret1 = array();
		$ret2 = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['school_name'] = '';
			foreach( $field_list as $fv ){
				$info = intval( $fv['info'] );
				if( $id == $info ){
					if( $fv['field'] == 'school_name' ){
						$lv['school_name'] = $fv['data'];
					} else if( $fv['field'] == 'join' ){
						$lv['join'] = intval( $fv['data'] );
					}
				}
			}
			if( $lv['join'] == 1 ){
				$ret1[] = $lv;
			} else {
				$ret2[] = $lv;
			}
		}
		db_close( $dbs );

		return array_merge( $ret1, $ret2 );
	}

	function get_entry_data_list2_20()
	{
		return __get_entry_data_list2_20_21( 20 );
	}

	function get_entry_data_list2_21()
	{
		return __get_entry_data_list2_20_21( 21 );
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_20_21( $list, $series )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_field` where `field` in (\'school_address_pref\',\'school_name_ryaku\') and `year`='.__REG_SERIES_YEAR__;
		$field_list = db_query_list( $dbs, $sql );
		db_close( $dbs );

		$kaisai_num = 0;
		$data = array();
		foreach( $list as $lv ){
			if( $lv['join'] == 0 ){ continue; }
			$id = intval( $lv['id'] );
			foreach( $field_list as $fv ){
				$info = intval( $fv['info'] );
				if( $id == $info ){
					if( $fv['field'] == 'school_address_pref' ){
						$lv['pref'] = intval( $fv['data'] );
						$lv['pref_name'] = $c->get_pref_name( $tbl, $lv['pref'] );
						$lv['area'] = $c->get_pref_area( $lv['pref'] );
					} else if( $fv['field'] == 'school_name_ryaku' ){
						$lv['school_name_ryaku'] = $fv['data'];
					}
				}
			}
			if( $lv['pref'] == $c->get_kaisai_pref() && $kaisai_num == 0 ){
				$lv['rank'] = 2;
				$data[0] = $lv;
				$kaisai_num = 1;
			} else {
				$lv['rank'] = 1;
				$data[$lv['pref']] = $lv;
			}
		}

		$ret = "学校,都道府県,順位,地域,県番号,,\n";
		for( $i1 = 0; $i1 <= 47; $i1++ ){
			$ret .= ( $data[$i1]['school_name_ryaku'] . ','
				. $data[$i1]['pref_name'] . ','
				. $data[$i1]['rank'] . ','
				. $data[$i1]['area'] . ','
				. $data[$i1]['pref'] . ','
				. $data[$i1]['id'] . ",\n" );
		}
		return $ret;
	}

	function get_entry_data_for_draw_csv_20( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_20_21( $list, 20 ),
			'file' => 'dantai_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_21( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_20_21( $list, 21 ),
			'file' => 'dantai_w.csv'
		);
	}

	//--------------------------------------------------------------

	//--------------------------------------------------------------

	function __output_realtime_html_for_one_board_20_21( $place, $place_match_no )
	{
		global $navi_info;

		$objPage = new form_page();
		$hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
		$hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
		$data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
		if( $place_match_no > 2 && $navi_info[$place][$place_match_no-2]['series'] >= 9 ){
			$data_prev2 = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no-2]['series'], $navi_info[$place][$place_match_no-2]['series_mw'], $navi_info[$place][$place_match_no-2]['match'] );
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
		if( $place_match_no > 1 && $navi_info[$place][$place_match_no-1]['series'] >= 9 ){
			$data_prev = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no-1]['series'], $navi_info[$place][$place_match_no-1]['series_mw'], $navi_info[$place][$place_match_no-1]['match'] );
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

		$data_now = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no]['series'], $navi_info[$place][$place_match_no]['series_mw'], $navi_info[$place][$place_match_no]['match'] );
		$data['matches'][3] = $data_now['matches'];
		for( $waza = 1; $waza <= 3; $waza++ ){
			if( $data_now['matches']['waza1_'.$waza] != 0 ){
				$hon1[3]++;
			}
			if( $data_now['matches']['waza2_'.$waza] != 0 ){
				$hon2[3]++;
			}
		}
		if( $place_match_no < count($navi_info[$place]) && $navi_info[$place][$place_match_no+1]['series'] >= 9 ){
			$data_next = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no+1]['series'], $navi_info[$place][$place_match_no+1]['series_mw'], $navi_info[$place][$place_match_no+1]['match'] );
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

		$html = '';
		$html .= '    <div align="center" class="tb_score_in">'."\n";
		$html .= '      <div class="tb_score_title">'.$navi_info[$place][$place_match_no]['place_name'].'</div>'."\n";
		$html .= '      <div class="clearfloat"></div>'."\n";
		for( $i1 = 1; $i1 <= 4; $i1++ ){
            $hon_num = 0;
			for( $i2 = 3; $i2 >= 1; $i2-- ){
				if( $data['matches'][$i1]['waza1_'.$i2] != 0 || $data['matches'][$i1]['waza2_'.$i2] != 0 ){
                    $hon_num = $i2;
                    break;
                }
            }
			if(
				$hon_num == 3 && (
					( $data['matches'][$i1]['waza1_2'] != 0 && $data['matches'][$i1]['waza1_3'] != 0 )
					|| ( $data['matches'][$i1]['waza2_2'] != 0 && $data['matches'][$i1]['waza2_3'] != 0 )
				)
			){
				$hon_num = 4;
			}

			$html .= '      <div class="tb_frame">'."\n";
			$html .= '        <div class="tb_frame_title tb_frame_bbottom">';
			if( $i1 == 1 ){
				$html .= '前々試合';
			} else if( $i1 == 2 ){
				$html .= '前試合';
			} else if( $i1 == 3 ){
			} else if( $i1 == 4 ){
				$html .= '次試合';
			}
			$html .= '</div>'."\n";
			$html .= '        <div class="tb_frame_content';
			$html .= '" id="player1_'.$i1.'">';
			if( $i1 == 1 ){
				$html .= string_insert_br( base64_decode($data_prev2['players'][1]['name_str2']) );
			} else if( $i1 == 2 ){
				$html .= string_insert_br( base64_decode($data_prev['players'][1]['name_str2']) );
			} else if( $i1 == 3 ){
				$html .= string_insert_br( base64_decode($data_now['players'][1]['name_str2']) );
			} else if( $i1 == 4 ){
				$html .= string_insert_br( base64_decode($data_next['players'][1]['name_str2']) );
			}
			if( $data['matches'][$i1]['end_match'] == 1 ){
				if( ( $hon1[$i1] == 1 && $hon2[$i1] == 0 ) || ( $hon1[$i1] == 0 && $hon2[$i1] == 1 ) ){
					if( $data['matches'][$i1]['extra'] != 1 ){
						$html .= '<div class="tb_frame_ippon">一本勝</div>';
					}
				} else if( $hon1[$i1] == $hon2[$i1] ){
					$html .= '<div class="tb_frame_draw">×</div>';
				}
			}
			$html .= '</div>'."\n";
			$html .= '        <div class="tb_frame_waza tb_frame_btop">'."\n";
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
					$html .= '          <div class="tb_frame_waza2">○</div>';
				} else if( $data['matches'][$i1]['waza1_'.$i2] != 0 ){
					$html .= '          <div class="tb_frame_waza'.$hon_num.'_'.$i2.'">';
					//if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
					if($data['matches'][$i1]['waza1_'.$i2]==1){ $html .= 'メ'; }
					if($data['matches'][$i1]['waza1_'.$i2]==2){ $html .= 'ド'; }
					if($data['matches'][$i1]['waza1_'.$i2]==3){ $html .= 'コ'; }
					if($data['matches'][$i1]['waza1_'.$i2]==4){ $html .= '反'; }
					//if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .= '○'; }
					if($data['matches'][$i1]['waza1_'.$i2]==6){ $html .= 'ツ'; }
	 				$html .= '</div>'."\n";
				}
			}
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_faul">'."\n";
			//if($data['matches'][$i1]['faul1_1']==2){ echo '指'; }
			if($data['matches'][$i1]['faul1_2']==1){ $html .= '▲'; }
			if($data['matches'][$i1]['extra']==1){
				$html .= '          <div class="tb_frame_faul_extra" id="extra_match<?php echo $i1; ?>">延長</div>'."\n";
			}
			$html .= '        </div>'."\n";
			$html .= '      </div>'."\n";
		}
		$html .= '      <div class="clearfloat"></div>'."\n";

		for( $i1 = 1; $i1 <= 4; $i1++ ){
            $hon_num = 0;
			for( $i2 = 3; $i2 >= 1; $i2-- ){
				if( $data['matches'][$i1]['waza1_'.$i2] != 0 || $data['matches'][$i1]['waza2_'.$i2] != 0 ){
                    $hon_num = $i2;
                    break;
                }
            }
			if(
				$hon_num == 3 && (
					( $data['matches'][$i1]['waza1_2'] != 0 && $data['matches'][$i1]['waza1_3'] != 0 )
					|| ( $data['matches'][$i1]['waza2_2'] != 0 && $data['matches'][$i1]['waza2_3'] != 0 )
				)
			){
				$hon_num = 4;
			}

			$html .= '      <div class="tb_frame">'."\n";
			$html .= '        <div class="tb_frame_faul">';
			//if($data['matches'][$i1]['faul2_1']==2){ echo '指'; }
			if($data['matches'][$i1]['faul2_2']==1){ $html .= '▲'; }
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				if( $data['matches'][$i1]['waza2_'.$i2] == 5 ){
					$html .= '          <div class="tb_frame_waza2">○</div>';
				} else if( $data['matches'][$i1]['waza2_'.$i2] != 0 ){
					$html .= '          <div class="tb_frame_waza'.$hon_num.'_'.$i2.'">';
					//if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
					if($data['matches'][$i1]['waza2_'.$i2]==1){ $html .= 'メ'; }
					if($data['matches'][$i1]['waza2_'.$i2]==2){ $html .= 'ド'; }
					if($data['matches'][$i1]['waza2_'.$i2]==3){ $html .= 'コ'; }
					if($data['matches'][$i1]['waza2_'.$i2]==4){ $html .= '反'; }
					//if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .= '○'; }
					if($data['matches'][$i1]['waza2_'.$i2]==6){ $html .= 'ツ'; }
	 				$html .= '</div>'."\n";
				}
/*
				if($data['matches'][$i1]['waza2_'.$i2]==5){
					$html .= '          <div class="tb_frame_waza2">';
				} else {
					$html .= '          <div class="tb_frame_waza1">';
				}
				if($data['matches'][$i1]['waza2_'.$i2]==0){ $html .= '&nbsp;'; }
				if($data['matches'][$i1]['waza2_'.$i2]==1){ $html .= 'メ'; }
				if($data['matches'][$i1]['waza2_'.$i2]==2){ $html .= 'ド'; }
				if($data['matches'][$i1]['waza2_'.$i2]==3){ $html .= 'コ'; }
				if($data['matches'][$i1]['waza2_'.$i2]==4){ $html .= '反'; }
				if($data['matches'][$i1]['waza2_'.$i2]==5){ $html .= '○'; }
				if($data['matches'][$i1]['waza2_'.$i2]==6){ $html .= 'ツ'; }
	 			$html .= '</div>'."\n";
*/
			}
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_content';
			$html .= '" id="player2_'.$i1.'">';
			if( $i1 == 1 ){
				$html .= string_insert_br( base64_decode($data_prev2['players'][2]['name_str2']) );
			} else if( $i1 == 2 ){
				$html .= string_insert_br( base64_decode($data_prev['players'][2]['name_str2']) );
			} else if( $i1 == 3 ){
				$html .= string_insert_br( base64_decode($data_now['players'][2]['name_str2']) );
			} else if( $i1 == 4 ){
				$html .= string_insert_br( base64_decode($data_next['players'][2]['name_str2']) );
			}
			$html .= '</div>'."\n";
			$html .= '      </div>'."\n";
		}
		$html .= '      <div class="clearfloat"></div>'."\n";
		$html .= '    </div>'."\n";
		$html .= '  </div>'."\n";
/*
		$url = 'http://49.212.133.48:3000/';
		$data = array(
    		'pos' => $place,
    		'value' => $html,
		);
		$data = http_build_query($data, "", "&");
		$options = array('http' => array(
		    'method' => 'POST',
    		'content' => $data,
		));
		$options = stream_context_create($options);
		$contents = file_get_contents($url, false, $options);
*/
		return $html;
	}

	function output_realtime_html_for_one_board_20( $place, $place_match_no )
	{
		//return __output_realtime_html_for_one_board_20_21( $place, $place_match_no );
		return '';
	}

	function output_realtime_html_for_one_board_21( $place, $place_match_no )
	{
		//return __output_realtime_html_for_one_board_20_21( $place, $place_match_no );
		return '';
	}

	//--------------------------------------------------------------

?>
