<?php

	function get_league_parameter_3()
	{
		$param = array(
			'mw' => '',
			'team_num' => 3,
			'match_num' => 3,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'place_num' => 13,
			'place_group_num' => 1,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 1
		);
		return $param;
	}

	function get_tournament_parameter_3()
	{
		$param = array(
			'mw' => '',
			'team_num' => 32,
			'match_num' => 31,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 5,
			'place_num' => 12,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 3
		);
		return $param;
	}

	function init_entry_post_data_from_def_3_traffic( &$data, $def, $add1, $add2 )
	{
		$data['traffic'] = '';
		$data['traffic_mycar'] = '';
		$data['traffic_share'] = '';
		$data['traffic_other'] = '';
	}

	function get_entry_post_data_from_def_3_traffic( $def, $add1, $add2 )
	{
		$_SESSION['p']['traffic'] = get_field_string( $_POST, 'traffic' );
		$_SESSION['p']['traffic_mycar'] = get_field_string( $_POST, 'traffic_mycar' );
		$_SESSION['p']['traffic_share'] = get_field_string( $_POST, 'traffic_share' );
		$_SESSION['p']['traffic_other'] = get_field_string( $_POST, 'traffic_other' );
	}

	function get_entry_db_data_from_def_3_traffic( $data, $list, $def, $add1, $add2 )
	{
		$data['traffic'] = get_field_string( $list, 'traffic' );
		$data['traffic_mycar'] = get_field_string( $list, 'traffic_mycar' );
		$data['traffic_share'] = get_field_string( $list, 'traffic_share' );
		$data['traffic_other'] = get_field_string( $list, 'traffic_other' );
		return $data;
	}

	function update_entry_data_3_traffic( $def, $dbs )
	{
		$data = array(
			'traffic' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic' ) ),
			'traffic_mycar' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_mycar' ) ),
			'traffic_share' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_share' ) ),
			'traffic_other' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_other' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_3_shumoku_dantai( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = '';
		$data['shumoku_dantai_rensei_am'] = '';
		$data['shumoku_dantai_rensei_pm'] = '';
		$data['shumoku_dantai_opening'] = '';
		$data['shumoku_dantai_konshin'] = '';
		$data['shumoku_dantai_text'] = '';
	}

	function get_entry_post_data_from_def_3_shumoku_dantai( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_taikai'] = get_field_string( $_POST, 'shumoku_dantai_taikai' );
		$_SESSION['p']['shumoku_dantai_rensei_am'] = get_field_string( $_POST, 'shumoku_dantai_rensei_am' );
		$_SESSION['p']['shumoku_dantai_rensei_pm'] = get_field_string( $_POST, 'shumoku_dantai_rensei_pm' );
		$_SESSION['p']['shumoku_dantai_opening'] = get_field_string( $_POST, 'shumoku_dantai_opening' );
		$_SESSION['p']['shumoku_dantai_konshin'] = get_field_string( $_POST, 'shumoku_dantai_konshin' );
		$_SESSION['p']['shumoku_dantai_text'] = get_field_string( $_POST, 'shumoku_dantai_text' );
	}

	function get_entry_db_data_from_def_3_shumoku_dantai( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = get_field_string( $list, 'shumoku_dantai_taikai' );
		$data['shumoku_dantai_rensei_am'] = get_field_string( $list, 'shumoku_dantai_rensei_am' );
		$data['shumoku_dantai_rensei_pm'] = get_field_string( $list, 'shumoku_dantai_rensei_pm' );
		$data['shumoku_dantai_opening'] = get_field_string( $list, 'shumoku_dantai_opening' );
		$data['shumoku_dantai_konshin'] = get_field_string( $list, 'shumoku_dantai_konshin' );
		$data['shumoku_dantai_text'] = get_field_string( $list, 'shumoku_dantai_text' );
		return $data;
	}

	function update_entry_data_3_shumoku_dantai( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_taikai', 0 ),
			'shumoku_dantai_rensei_am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_am', 0 ),
			'shumoku_dantai_rensei_pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_pm', 0 ),
			'shumoku_dantai_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_opening', 0 ),
			'shumoku_dantai_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_konshin', 0 ),
			'shumoku_dantai_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_text' ) )
		);
		return $data;
	}

	function is_entry_data_3_join_shumoku_dantai( $data )
	{
		if( get_field_string_number( $data, 'shumoku_dantai_taikai', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_rensei_am', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_rensei_pm', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_opening', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_konshin', 0 ) == 1 ){ return true; }
		return false;
	}

	function get_entry_data_list2_3()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`series`=3 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		$sql = 'select * from `entry_field` where `field` in (\'shumoku_dantai_taikai\',\'shumoku_dantai_rensei_am\',\'shumoku_dantai_rensei_pm\',\'shumoku_dantai_opening\',\'shumoku_dantai_konshin\') and `year`='.$_SESSION['auth']['year'];
		$field_list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['join_m'] = 0;
			$lv['join_w'] = 0;
			foreach( $field_list as $fv ){
				$info = intval( $fv['info'] );
				if( $id == $info ){
					if( intval( $fv['data'] ) == 1 ){
						$lv['join'] = 1;
						break;
					}
				}
			}
		}

		db_close( $dbs );
		return $list;
	}

	function get_entry_data_3_list_for_PDF( $pref_array, $grade_elementary_array )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3 order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$ret = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
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
				'name' => $pref_name . '　' . get_field_string( $fields, 'school_name' ),
				'address' => $pref_name . ' ' . get_field_string( $fields, 'school_address' ),
				'tel' => get_field_string( $fields, 'school_phone_tel' )
			);

			if( get_field_string_number( $fields, 'shumoku_dantai_taikai', 0 ) != 1 ){
				continue;
			}
			$pdata = array(
				'name' => $sdata['name'],
				'address' => $sdata['address'],
				'tel' => mb_convert_kana( $sdata['tel'], 'krn' ),
				'manager' => get_field_string( $fields, 'manager_sei' ) . ' ' . get_field_string( $fields, 'manager_mei' ),
				'captain' => get_field_string( $fields, 'captain_sei' ) . ' ' . get_field_string( $fields, 'captain_mei' ),
				'introduction' => get_field_string( $fields, 'introduction' ),
				'main_results' => get_field_string( $fields, 'main_results' )
			);
			for( $i1 = 1; $i1 <= 7; $i1++ ){
				$grade = get_field_string_number( $fields, 'player'.$i1.'_grade', 0 );
				$grade_name = '';
				foreach( $grade_elementary_array as $gv ){
					if( $gv['value'] == $grade ){
						$grade_name = $gv['title'];
						break;
					}
				}
				$pdata['player'.$i1]
					= mb_convert_kana( get_field_string( $fields, 'player'.$i1.'_sei' )
						 . ' ' . get_field_string( $fields, 'player'.$i1.'_mei' ),
						'sk'
					). ' ' . $grade_name;
			}
			$ret[] = $pdata;
		}
		return $ret;
	}

	function get_entry_data_list_3_sql( $mw )
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
	}


	function output_one_tournament_3_for_PDF( $tournament_data, $entry_list, $tcpdf )
	{
//print_r($tournament_data);
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
			if( $tournament_team == 0 ){
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
					'pos' => $team_pos * 4, 'name' => $name, 'pref' => $pref, 'index' => $team_index
				);
				$team_pos++;
				$match_no++;
				$team_index++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				$match_line1[] = $one_match;
				$one_match = array();
			}
		}
		$match_no_top /= 2;

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		//$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){
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
                break;
			}
			$match_no_top /= 2;
		}
//print_r($match_tbl);
//exit;

        $tcpdf->AddPage();
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $left = 10;
        $top = 20;
		$name_height = 40;
		$pref_height = 15;
		$index_height = 6;
        $chart_height = 10;
        $chart_bottom = $top + ( $tournament_data['match_level'] + 1 ) * $chart_height;
        $right = $chart_right + $name_width + $pref_width + $index_width + 2;
		$width_unit = 1.8;
		$width_unit4 = 7.2;
		for( $i1 = 0; $i1 < $tournament_data['match_level']; $i1++ ){
            foreach( $match_tbl[0][$i1] as $mv ){
                if( $i1 == 0 ){
                    $tcpdf->MultiCell(
                        $width_unit4, $index_height, $mv['team1']['index'], 0, 'C', false, 0,
                        $left+($mv['team1']['pos'])*$width_unit, $chart_bottom,
                        true, 0, false, false, $index_height, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $width_unit4, $pref_height, string_insert_br($mv['team1']['pref']), 0, 'C', false, 0,
                        $left+$mv['team1']['pos']*$width_unit, $chart_bottom+$index_height,
                        true, 0, true, false, $pref_height, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $width_unit4, $name_height, string_insert_br( $mv['team1']['name'] ), 0, 'C', false, 0,
                        $left+$mv['team1']['pos']*$width_unit, $chart_bottom+$index_height+$pref_height,
                        true, 0, true, false, $name_height, 'M', false
                    );
                }
                if( $mv['place'] === 'no_match' ){
                    $tcpdf->Line(
                        $left+($mv['team1']['pos']+2)*$width_unit, $chart_bottom-($i1+1)*$chart_height,
                        $left+($mv['team1']['pos']+2)*$width_unit, $chart_bottom-($i1)*$chart_height, $b1 );
                } else {
                    if( $i1 == 0 ){
                        $tcpdf->MultiCell(
                            $width_unit4, $index_height, $mv['team2']['index'], 0, 'C', false, 0,
                            $left+($mv['team2']['pos'])*$width_unit, $chart_bottom,
                            true, 0, false, false, $index_height, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $width_unit4, $pref_height, string_insert_br($mv['team2']['pref']), 0, 'C', false, 0,
                            $left+$mv['team2']['pos']*$width_unit, $chart_bottom+$index_height,
                            true, 0, true, false, $pref_height, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $width_unit4, $name_height, string_insert_br( $mv['team2']['name'] ), 0, 'C', false, 0,
                            $left+$mv['team2']['pos']*$width_unit, $chart_bottom+$index_height+$pref_height,
                            true, 0, true, false, $name_height, 'M', false
                        );
                    }
                    $tcpdf->Rect(
                        $left+($mv['team1']['pos']+2)*$width_unit, $chart_bottom-($i1+1)*$chart_height,
                        ($mv['team2']['pos']-$mv['team1']['pos'])*$width_unit, $chart_height,
                        'D', array('T' => $b1,'R' => $b1,'L' => $b1), array() );
                    $tcpdf->MultiCell(
                        ($mv['team2']['pos']-$mv['team1']['pos'])*$width_unit, $height_unit4,
                        $mv['place'].'-'.$mv['place_match_no'], 0, 'C', false, 0,
                        $left+($mv['team1']['pos']+2)*$width_unit, $chart_bottom-($i1+1)*$chart_height,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    if( $i1 == $tournament_data['match_level']-1 ){
                        $tcpdf->Line(
                            $left+($mv['team1']['pos']+2+($mv['team2']['pos']-$mv['team1']['pos'])/2)*$width_unit,
                            $chart_bottom-($i1+2)*$chart_height,
                            $left+($mv['team1']['pos']+2+($mv['team2']['pos']-$mv['team1']['pos'])/2)*$width_unit,
                            $chart_bottom-($i1+1)*$chart_height, $b1 );
                    }
                }
            }
        }
	}


	function output_tournament_3_for_PDF( $tournament_list, $entry_list, $mv )
	{
        include( dirname(dirname(dirname(__FILE__)))."/tcpdf/tcpdf.php" );
        $tcpdf = new TCPDF("P", "mm", "B4", true, "UTF-8" ); // 250x353
        $tcpdf->setPrintHeader(false);
        $tcpdf->setPrintFooter(false);
        $tcpdf->setTextColor(0);
        $font = new TCPDF_FONTS();
        // フォント：IPAゴシック
        $font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipagp.ttf' );
        $tcpdf->SetFont($font_1 , '', 7,'',true);
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        foreach( $tournament_list as $lv ){
            output_one_tournament_3_for_PDF( $lv, $entry_list, $tcpdf );
        }
        $tcpdf->Output("output.pdf", "D");
	}

	function output_entry_data_list_all_1_excel3( $sheet )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=3 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		//$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3 order by `disp_order` asc';
	//	$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $c->get_pref_array();
		$orgtbl = $c->get_org_array();
		$shokumeitbl = $c->get_shokumei_array();
		$gradetbl = $c->get_grade_junior_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( $fields['shumoku_dantai_taikai'] != '1' 
				&& $fields['shumoku_dantai_rensei_am'] != '1'
				&& $fields['shumoku_dantai_rensei_pm'] != '1'
				&& $fields['shumoku_dantai_opening'] != '1'
				&& $fields['shumoku_dantai_konshin'] != '1'
			){
				continue;
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ).$fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_contact_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_contact_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_email'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu4_sei'].' '.$fields['insotu4_mei'] );
			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '' );
			}

			if( $fields['shumoku_dantai_taikai'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_pm'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+2, $pos, '○' );
			}
			if( $fields['shumoku_dantai_opening'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+3, $pos, '○' );
			}
			if( $fields['shumoku_dantai_konshin'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+4, $pos, '○ ('.$fields['shumoku_dantai_text'].'人参加)' );
			}
			$col += 5;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_sei'].' '.$fields['manager_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_add'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_sei'].' '.$fields['captain_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_add'] );
			for( $player = 1; $player <= 7; $player++ ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_sei'].' '.$fields['player'.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_add'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['player'.$player.'_grade']) ) );
			}
			$index++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['introduction'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['main_results'] );
			$pos++;
		}
		db_close( $dbs );
        return false;
	}

    function output_catalog_3_for_PDF( $pref_array, $grade_elementary_array )
    {
        include( dirname(dirname(dirname(__FILE__)))."/tcpdf/tcpdf.php" );

        $list = get_entry_data_3_list_for_PDF( $pref_array, $grade_elementary_array );
        $pdf = new TCPDF("P", "mm", "B4", true, "UTF-8" ); // 250x353
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setTextColor(0);
        $pdf->AddPage();
        $font = new TCPDF_FONTS();
        // フォント：IPAゴシック
        $font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipagp.ttf' );
        $pdf->SetFont($font_1 , '', 7,'',true);
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $b2 = array( 'width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $top = 10;
        $left = 10;
        $lineheight = 5;
        $offset = 0;
        $pdf->SetLineStyle( $b1 );
        foreach( $list as $lv ){
            $pdf->Rect( $left, $top, 100, $lineheight*12, 'D', array('all' => $b2), array() );
            $pdf->MultiCell( 60, $lineheight, $lv['name'], 0, 'L', false, 0, $left, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->SetLineStyle( $b1 );
            $pdf->MultiCell( 40, $lineheight, 'tel　'.$lv['tel'], 'L', 'L', false, 0, $left+60, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 100, $lineheight, '住所　'.$lv['address'], 'T', 'L', false, 0, $left, $top+$lineheight, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '監督　'.$lv['manager'], 'T', 'L', false, 0, $left, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '主将　'.$lv['captain'], 'TL', 'L', false, 0, $left+50, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '先鋒　'.$lv['player1'].'　'.$lv['player1_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '次鋒　'.$lv['player2'].'　'.$lv['player2_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '中堅　'.$lv['player3'].'　'.$lv['player3_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '副将　'.$lv['player4'].'　'.$lv['player4_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '大将　'.$lv['player5'].'　'.$lv['player5_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '補員　'.$lv['player6'].'　'.$lv['player6_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '補員　'.$lv['player7'].'　'.$lv['player7_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*5, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 67, $lineheight, '', 'TL', 'L', false, 0, $left+33, $top+$lineheight*5 );
            $pdf->MultiCell( 50, $lineheight*6, "チーム紹介\n".$lv['introduction'], 'T', 'L', false, 0, $left, $top+$lineheight*6 );
            $pdf->MultiCell( 50, $lineheight*6, "近年の主な戦績\n".$lv['main_results'], 'TL', 'L', false, 0, $left+50, $top+$lineheight*6 );
            if( ( $offset % 2 ) == 0 ){
                $left += 103;
                $offset++;
            } else {
                $left = 10;
                if( $offset == 9 ){
                    $offset = 0;
                    $top = 10;
                    $pdf->AddPage( 'P', 'B4' );
                } else {
                    $top += ( $lineheight * 12 + 3 );
                    $offset++;
                }
            }
        }

        $pdf->Output("output.pdf", "D");
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_3( $objPage, $path, $tournament_list, $entry_list, $mw )
	{
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>団体トーナメント結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
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

        

		$html = $header . '    <h2>' . $mvstr . '団体トーナメント結果(一回戦)</h2>'."\n";
		for( $i1 = 1; $i1 <= 8; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;一回戦&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1+6], $entry_list, $mv );
		}
		$html .= $footer;
		$file = $path . '/dtm'.$mv.'1.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );

		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果(準々決勝～決勝)</h2>'."\n";
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
		$html .= $footer;
		$file = $path . '/dtm'.$mv.'2.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

?>
