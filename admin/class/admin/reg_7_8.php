<?php

	function __get_league_parameter_7_8( $series_mw )
	{
		$param = array(
			'mw' => $series_mw,
			'team_num' => 3,
			'match_num' => 3,
			'match_info' => array( array( 0, 1 ), array( 2, 0 ), array( 1, 2 ) ),
			'place_num' => 8,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16,
			'chart_tbl' => array( array( 0, 1, 2 ), array( 1, 0, 3 ), array( 2, 3, 0 ) ),
			'chart_team_tbl' => array( array( 0, 1, 2 ), array( 2, 0, 1 ), array( 1, 2, 0 ) )
		);
		return $param;
	}

	function get_league_parameter_7()
	{
		return __get_league_parameter_7_8( 'm' );
	}

	function get_league_parameter_8()
	{
		return __get_league_parameter_7_8( 'w' );
	}

	function __get_tournament_parameter_7_8()
	{
		$param = array(
			'mw' => 'w',
			'team_num' => 16,
			'match_num' => 15,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 4,
			'place_num' => 8,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16
		);
		return $param;
	}

	function get_tournament_parameter_7()
	{
		__get_tournament_parameter_7_8();
	}

	function get_tournament_parameter_8()
	{
		__get_tournament_parameter_7_8();
	}

	function init_entry_post_data_from_def_7_shumoku_dantai_m( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = '';
		$data['shumoku_dantai_m_rensei_1am'] = '';
		$data['shumoku_dantai_m_rensei_1pm'] = '';
		$data['shumoku_dantai_m_rensei_3am'] = '';
		$data['shumoku_dantai_m_opening'] = '';
		$data['shumoku_dantai_m_konshin'] = '';
		$data['shumoku_dantai_m_text'] = '';
	}

	function get_entry_post_data_from_def_7_shumoku_dantai_m( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_m_taikai'] = get_field_string( $_POST, 'shumoku_dantai_m_taikai' );
		$_SESSION['p']['shumoku_dantai_m_rensei_1am'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_1am' );
		$_SESSION['p']['shumoku_dantai_m_rensei_1pm'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_1pm' );
		$_SESSION['p']['shumoku_dantai_m_rensei_3am'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_3am' );
		$_SESSION['p']['shumoku_dantai_m_opening'] = get_field_string( $_POST, 'shumoku_dantai_m_opening' );
		$_SESSION['p']['shumoku_dantai_m_konshin'] = get_field_string( $_POST, 'shumoku_dantai_m_konshin' );
		$_SESSION['p']['shumoku_dantai_m_text'] = get_field_string( $_POST, 'shumoku_dantai_m_text' );
	}

	function get_entry_db_data_from_def_7_shumoku_dantai_m( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = get_field_string( $list, 'shumoku_dantai_m_taikai' );
		$data['shumoku_dantai_m_rensei_1am'] = get_field_string( $list, 'shumoku_dantai_m_rensei_1am' );
		$data['shumoku_dantai_m_rensei_1pm'] = get_field_string( $list, 'shumoku_dantai_m_rensei_1pm' );
		$data['shumoku_dantai_m_rensei_3am'] = get_field_string( $list, 'shumoku_dantai_m_rensei_3am' );
		$data['shumoku_dantai_m_opening'] = get_field_string( $list, 'shumoku_dantai_m_opening' );
		$data['shumoku_dantai_m_konshin'] = get_field_string( $list, 'shumoku_dantai_m_konshin' );
		$data['shumoku_dantai_m_text'] = get_field_string( $list, 'shumoku_dantai_m_text' );
		return $data;
	}

	function update_entry_data_7_shumoku_dantai_m( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_m_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_taikai', 0 ),
			'shumoku_dantai_m_rensei_1am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_1am', 0 ),
			'shumoku_dantai_m_rensei_1pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_1pm', 0 ),
			'shumoku_dantai_m_rensei_3am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_3am', 0 ),
			'shumoku_dantai_m_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_opening', 0 ),
			'shumoku_dantai_m_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_konshin', 0 ),
			'shumoku_dantai_m_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_m_text' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_7_shumoku_dantai_w( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = '';
		$data['shumoku_dantai_w_rensei_1am'] = '';
		$data['shumoku_dantai_w_rensei_1pm'] = '';
		$data['shumoku_dantai_w_rensei_3am'] = '';
		$data['shumoku_dantai_w_opening'] = '';
		$data['shumoku_dantai_w_konshin'] = '';
		$data['shumoku_dantai_w_text'] = '';
	}

	function get_entry_post_data_from_def_7_shumoku_dantai_w( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_w_taikai'] = get_field_string( $_POST, 'shumoku_dantai_w_taikai' );
		$_SESSION['p']['shumoku_dantai_w_rensei_1am'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_1am' );
		$_SESSION['p']['shumoku_dantai_w_rensei_1pm'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_1pm' );
		$_SESSION['p']['shumoku_dantai_w_rensei_3am'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_3am' );
		$_SESSION['p']['shumoku_dantai_w_opening'] = get_field_string( $_POST, 'shumoku_dantai_w_opening' );
		$_SESSION['p']['shumoku_dantai_w_konshin'] = get_field_string( $_POST, 'shumoku_dantai_w_konshin' );
		$_SESSION['p']['shumoku_dantai_w_text'] = get_field_string( $_POST, 'shumoku_dantai_w_text' );
	}

	function get_entry_db_data_from_def_7_shumoku_dantai_w( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = get_field_string( $list, 'shumoku_dantai_w_taikai' );
		$data['shumoku_dantai_w_rensei_1am'] = get_field_string( $list, 'shumoku_dantai_w_rensei_1am' );
		$data['shumoku_dantai_w_rensei_1pm'] = get_field_string( $list, 'shumoku_dantai_w_rensei_1pm' );
		$data['shumoku_dantai_w_rensei_3am'] = get_field_string( $list, 'shumoku_dantai_w_rensei_3am' );
		$data['shumoku_dantai_w_opening'] = get_field_string( $list, 'shumoku_dantai_w_opening' );
		$data['shumoku_dantai_w_konshin'] = get_field_string( $list, 'shumoku_dantai_w_konshin' );
		$data['shumoku_dantai_w_text'] = get_field_string( $list, 'shumoku_dantai_w_text' );
		return $data;
	}

	function update_entry_data_7_shumoku_dantai_w( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_w_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_taikai', 0 ),
			'shumoku_dantai_w_rensei_1am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_1am', 0 ),
			'shumoku_dantai_w_rensei_1pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_1pm', 0 ),
			'shumoku_dantai_w_rensei_3am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_3am', 0 ),
			'shumoku_dantai_w_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_opening', 0 ),
			'shumoku_dantai_w_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_konshin', 0 ),
			'shumoku_dantai_w_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_w_text' ) )
		);
		return $data;
	}



	function init_entry_post_data_from_def_7_shumoku_dantai( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = '';
		$data['shumoku_dantai_rensei_1am'] = '';
		$data['shumoku_dantai_rensei_1pm'] = '';
		$data['shumoku_dantai_rensei_3am'] = '';
		$data['shumoku_dantai_opening'] = '';
		$data['shumoku_dantai_konshin'] = '';
		$data['shumoku_dantai_text'] = '';
	}

	function get_entry_post_data_from_def_7_shumoku_dantai( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_taikai'] = get_field_string( $_POST, 'shumoku_dantai_taikai' );
		$_SESSION['p']['shumoku_dantai_rensei_1am'] = get_field_string( $_POST, 'shumoku_dantai_rensei_1am' );
		$_SESSION['p']['shumoku_dantai_rensei_1pm'] = get_field_string( $_POST, 'shumoku_dantai_rensei_1pm' );
		$_SESSION['p']['shumoku_dantai_rensei_3am'] = get_field_string( $_POST, 'shumoku_dantai_rensei_3am' );
		$_SESSION['p']['shumoku_dantai_opening'] = get_field_string( $_POST, 'shumoku_dantai_opening' );
		$_SESSION['p']['shumoku_dantai_konshin'] = get_field_string( $_POST, 'shumoku_dantai_konshin' );
		$_SESSION['p']['shumoku_dantai_text'] = get_field_string( $_POST, 'shumoku_dantai_text' );
	}

	function get_entry_db_data_from_def_7_shumoku_dantai( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = get_field_string( $list, 'shumoku_dantai_taikai' );
		$data['shumoku_dantai_rensei_1am'] = get_field_string( $list, 'shumoku_dantai_rensei_1am' );
		$data['shumoku_dantai_rensei_1pm'] = get_field_string( $list, 'shumoku_dantai_rensei_1pm' );
		$data['shumoku_dantai_rensei_3am'] = get_field_string( $list, 'shumoku_dantai_rensei_3am' );
		$data['shumoku_dantai_opening'] = get_field_string( $list, 'shumoku_dantai_opening' );
		$data['shumoku_dantai_konshin'] = get_field_string( $list, 'shumoku_dantai_konshin' );
		$data['shumoku_dantai_text'] = get_field_string( $list, 'shumoku_dantai_text' );
		return $data;
	}

	function update_entry_data_7_shumoku_dantai( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_taikai', 0 ),
			'shumoku_dantai_rensei_1am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_1am', 0 ),
			'shumoku_dantai_rensei_1pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_1pm', 0 ),
			'shumoku_dantai_rensei_3am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_3am', 0 ),
			'shumoku_dantai_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_opening', 0 ),
			'shumoku_dantai_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_konshin', 0 ),
			'shumoku_dantai_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_text' ) )
		);
		return $data;
	}

	function is_entry_data_7_join_shumoku_dantai( $data )
	{
		if( get_field_string_number( $data, 'shumoku_dantai_taikai', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_rensei_1am', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_rensei_3pm', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_rensei_3pm', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_opening', 0 ) == 1 ){ return true; }
		if( get_field_string_number( $data, 'shumoku_dantai_konshin', 0 ) == 1 ){ return true; }
		return false;
	}

	function __get_entry_data_7_8_list_for_PDF( $series, $series_mw, $kaisai_rev )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
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

	function get_entry_data_7_list_for_PDF()
	{
		return __get_entry_data_7_8_list_for_PDF( 7, 'm', 1 );
	}

	function get_entry_data_8_list_for_PDF()
	{
		return __get_entry_data_7_8_list_for_PDF( 8, 'w', 1 );
	}


	function get_entry_data_list_7_sql( $mw )
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

	function output_league_7_for_HTML_2( $league_list, $entry_list, $mv )
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
		$html .= '<link href="main.css" rel="stylesheet" type="text/css" />'."\n";
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

	function __output_league_7_8_for_HTML( $navi_info, $league_param, $league_list, $entry_list, $mv )
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
		$header .= '<link href="preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
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
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			if( ( $league_data % 4 ) == 0 ){
				$html = $header . '    <h2>' . $mvstr . '団体予選リーグ表';
				if( $league_data == 0 ){
					$html .= '(A-D)';
				} else if( $league_data == 4 ){
					$html .= '(E-H)';
				} else if( $league_data == 8 ){
					$html .= '(I-L)';
				} else if( $league_data == 12 ){
					$html .= '(M-P)';
				}
				$html .= '</h2>'."\n";
			}
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
						$html .= $ev['school_name_ryaku'] . '<br />(' . $ev['school_address_pref_name'] . ')';
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
						$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
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
				if( $league_list[$league_data]['end_match'] == 3 ){
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
			if( ( $league_data % 4 ) == 3 ){
				$html .= $footer;
				if( $league_data == 3 ){
					$file = $navi_info['result_path'] . '/dl'.$mv.'a.html';
				} else if( $league_data == 7 ){
					$file = $navi_info['result_path'] . '/dl'.$mv.'e.html';
				} else if( $league_data == 11 ){
					$file = $navi_info['result_path'] . '/dl'.$mv.'i.html';
				} else if( $league_data == 15 ){
					$file = $navi_info['result_path'] . '/dl'.$mv.'m.html';
				}
				$fp = fopen( $file, 'w' );
				fwrite( $fp, $html );
				fclose( $fp );
			}
		}
	}

	function output_league_7_for_HTML( $navi_info, $league_param, $league_list, $entry_list )
	{
		__output_league_7_8_for_HTML( $navi_info, $league_param, $league_list, $entry_list, 'm' );
	}

	function output_league_8_for_HTML( $navi_info, $league_param, $league_list, $entry_list )
	{
		__output_league_7_8_for_HTML( $navi_info, $league_param, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_7_8_for_Excel( $objPage, $path, $league_param, $league_list, $entry_list, $mv )
	{
//print_r($league_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/l'.$mv.'.xls';
		$file_name = 'l' . $mv . '.xls';
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/dantaiLeagueChartBase_'.$mv.'.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '平成29年度全国中学校体育大会 第47回全国中学校剣道大会' );
		//$sheet->setCellValueByColumnAndRow( 0, 2, $mvstr.'団体戦　予選リーグ結果' );
		$col = 1;
		$row = 3;
		$colStr = 'Q';
		$html = '';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*3+4, $row, $ev['school_name_ryaku'] );
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*3+4, $row+1, '('.$ev['school_address_pref_name'].')' );
					}
				}
			}
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+2, $ev['school_name_ryaku'] );
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+3, '('.$ev['school_address_pref_name'].')' );
					}
				}

				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3+4, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(76);
								$objDrawing->setHeight(76);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(12);
								$objDrawing->setOffsetY(16);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(76);
								$objDrawing->setHeight(76);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(12);
								$objDrawing->setOffsetY(16);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(72);
								$objDrawing->setHeight(72);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(16);
								$objDrawing->setOffsetY(16);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+5, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+5, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3+4, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(76);
								$objDrawing->setHeight(76);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(12);
								$objDrawing->setOffsetY(16);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(76);
								$objDrawing->setHeight(76);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(12);
								$objDrawing->setOffsetY(16);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(72);
								$objDrawing->setHeight(72);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(16);
								$objDrawing->setOffsetY(16);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+5, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+5, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
						}
					}
				}
				$sheet->setCellValueByColumnAndRow(
					$col+13, $row+$dantai_index_row*2+2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$col+14, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+15, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+16, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);

			}
			if( ( $league_data % 4 ) == 3 ){
				$col += 19;
				$row = 3;
			} else {
				$row += 10;
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_7_for_Excel( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_7_8_for_Excel( $objPage, $path, get_league_parameter_7(), $league_list, $entry_list, 'm' );
	}

	function output_league_8_for_Excel( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_7_8_for_Excel( $objPage, $path, get_league_parameter_8(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function __output_league_match_for_HTML2_7_8( $objPage, $navi_info, $league_list, $entry_list, $mv )
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

		$html = '';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			if( ( $league_data % 4 ) == 0 ){
				$html = $header . '    <h2>' . $mvstr . '団体予選リーグ結果';
				if( $league_data == 0 ){
					$html .= '(A-D)';
				} else if( $league_data == 4 ){
					$html .= '(E-H)';
				} else if( $league_data == 8 ){
					$html .= '(I-L)';
				} else if( $league_data == 12 ){
					$html .= '(M-P)';
				}
				$html .= '</h2>'."\n";
			}
			$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第1試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][0], $entry_list, $mv );
			$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][2], $entry_list, $mv );
			$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][1], $entry_list, $mv );
			if( ( $league_data % 4 ) == 3 ){
				$html .= $footer;
				if( $league_data == 3 ){
					$file = $navi_info['result_path'] . '/dlm'.$mv.'a.html';
				} else if( $league_data == 7 ){
					$file = $navi_info['result_path'] . '/dlm'.$mv.'e.html';
				} else if( $league_data == 11 ){
					$file = $navi_info['result_path'] . '/dlm'.$mv.'i.html';
				} else if( $league_data == 15 ){
					$file = $navi_info['result_path'] . '/dlm'.$mv.'m.html';
				}
				$fp = fopen( $file, 'w' );
				fwrite( $fp, $html );
				fclose( $fp );
			}
		}
	}

	function output_league_match_for_HTML2_7( $navi_info, $league_param, $league_list, $entry_list )
	{
        $objPage = new form_page();
		__output_league_match_for_HTML2_7_8( $objPage, $navi_info, $league_param, $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_HTML2_8( $navi_info, $league_param, $league_list, $entry_list )
	{
        $objPage = new form_page();
		__output_league_match_for_HTML2_7_8( $objPage, $navi_info, $league_param, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_match_for_excel_7_8( $objPage, $path, $league_list, $entry_list, $mv )
	{
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/lm'.$mv.'.xls';
		$file_name = 'lm' . $mv . '.xls';
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/leagueResultsBase.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '平成29年度全国中学校体育大会 第47回全国中学校剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 1, '第47回全国中学校剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mvstr.'団体戦　予選リーグ結果' );
		$col = 0;
		$row = 5;
		$colStr = 'Q';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $league_list[$league_data]['match'][0], $entry_list, $mv, 46, 26 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $league_list[$league_data]['match'][2], $entry_list, $mv, 46, 26 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $league_list[$league_data]['match'][1], $entry_list, $mv, 46, 26 );
			$row += 6;
			if( ( $league_data % 4 == 3 ) ){
				$col += 24;
				$row = 5;
				$ofs = intval( $league_data / 4 );
				if( $ofs == 0 ){
					$colStr = 'AO';
				} else if( $ofs == 1 ){
					$colStr = 'BM';
				} else if( $ofs == 2 ){
					$colStr = 'CK';
				}
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_match_for_excel_7( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_7_8( $objPage, $path, $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_excel_8( $objPage, $path, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_7_8( $objPage, $path, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_7_8_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_list, $entry_list, $mv )
	{
        $tournament_data = $tournament_list[0];
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/dt'.$mv.'.xls';
		$file_name = 'dt' . $mv . '.xls';
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/dantaiTounamentResultsBase2.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValueByColumnAndRow( 0, 1, '第47回全国中学校剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mvstr.'団体戦　決勝トーナメント結果' );
		$col = 0;
		$row = 5;
		$colStr = 'Q';

		$objPage->output_one_match_for_excel( $sheet, 0, 53, $tournament_data['match'][7], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 0, 59, $tournament_data['match'][8], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 0, 65, $tournament_data['match'][9], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 0, 71, $tournament_data['match'][10], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 0, 77, $tournament_data['match'][11], $entry_list, $mv, 46, 36 );

		$objPage->output_one_match_for_excel( $sheet, 24, 53, $tournament_data['match'][12], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 24, 59, $tournament_data['match'][13], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 24, 65, $tournament_data['match'][14], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 24, 71, $tournament_data['match'][3], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 24, 77, $tournament_data['match'][4], $entry_list, $mv, 46, 36 );

		$objPage->output_one_match_for_excel( $sheet, 48, 53, $tournament_data['match'][5], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 48, 59, $tournament_data['match'][6], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 48, 65, $tournament_data['match'][1], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 48, 71, $tournament_data['match'][2], $entry_list, $mv, 46, 36 );
		$objPage->output_one_match_for_excel( $sheet, 48, 77, $tournament_data['match'][0], $entry_list, $mv, 46, 36 );

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
		$col = 0;
		$row = 4;
		$wincolofs = 3;
		$mode1 = 'l';
		$mode2 = 'l';
		$chartRow1 = 'B';
		$chartRow2 = 'D';
		$chartRow3 = 'D';
		$chartRow4 = 'E';
		$chartRow5 = 'G';
		for( $i1 = 7; $i1 <= 14; $i1++ ){
			$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$i1], $mode1, $mode2 );
			$sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['match'][$i1]['team1_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][$i1]['team1'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValueByColumnAndRow( $col, $row+2, '('.$entry_list[$i2]['school_address_pref_name'].')' );
					break;
				}
			}
			if( $tournament_data['match'][$i1]['winner'] != 0 ){
				$sheet->getStyle($chartRow4.($row+5).':'.$chartRow5.($row+5))->applyFromArray($styleArrayH);
				if( $i1 >= 11 ){
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row, $winstr[1][2].' '.$winstr[1][1] );
				} else {
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row, $winstr[1][1].' '.$winstr[1][2] );
				}
			}
			if( $tournament_data['match'][$i1]['winner'] == 1 ){
				$sheet->getStyle($chartRow1.($row+2).':'.$chartRow2.($row+2))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRow3.($row+2).':'.$chartRow3.($row+4))->applyFromArray($styleArrayV);
			}
			$row += 6;
			$sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['match'][$i1]['team2_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][$i1]['team2'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValueByColumnAndRow( $col, $row+2, '('.$entry_list[$i2]['school_address_pref_name'].')' );
					break;
				}
			}
			if( $tournament_data['match'][$i1]['winner'] != 0 ){
				if( $i1 >= 11 ){
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row+2, $winstr[2][2].' '.$winstr[2][1] );
				} else {
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row+2, $winstr[2][1].' '.$winstr[2][2] );
				}
			}
			if( $tournament_data['match'][$i1]['winner'] == 2 ){
				$sheet->getStyle($chartRow1.($row+2).':'.$chartRow2.($row+2))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRow3.($row-1).':'.$chartRow3.($row+1))->applyFromArray($styleArrayV);
			}
			$row += 6;
			if( $i1 == 10 ){
				$row = 4;
				$col = 66;
				$wincolofs = -4;
				$mode1 = 'r';
				$mode2 = 'r';
				$chartRow1 = 'BL';
				$chartRow2 = 'BN';
				$chartRow3 = 'BK';
				$chartRow4 = 'BI';
				$chartRow5 = 'BK';
			}
		}

		$col = 7;
		$row = 7;
		$wincolofs = 7;
		$mode1 = 'l';
		$mode2 = 'l';
		$chartRow1 = 'M';
		$chartRow2 = 'O';
		$chartRow3 = 'O';
		$chartRow4 = 'P';
		$chartRow5 = 'R';
		for( $i1 = 3; $i1 <= 6; $i1++ ){
			$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$i1], $mode1, $mode2 );
			if( $tournament_data['match'][$i1]['winner'] != 0 ){
				$sheet->getStyle($chartRow4.($row+8).':'.$chartRow5.($row+8))->applyFromArray($styleArrayH);
				if( $i1 >= 5 ){
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row, $winstr[1][2].' '.$winstr[1][1] );
				} else {
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row, $winstr[1][1].' '.$winstr[1][2] );
				}
			}
			$sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['match'][$i1]['team1_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][$i1]['team1'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValueByColumnAndRow( $col, $row+2, '('.$entry_list[$i2]['school_address_pref_name'].')' );
					break;
				}
			}
			if( $tournament_data['match'][$i1]['winner'] == 1 ){
				$sheet->getStyle($chartRow1.($row+2).':'.$chartRow2.($row+2))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRow3.($row+2).':'.$chartRow3.($row+7))->applyFromArray($styleArrayV);
			}
			$row += 12;

			$sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['match'][$i1]['team2_name'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['match'][$i1]['team2'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValueByColumnAndRow( $col, $row+2, '('.$entry_list[$i2]['school_address_pref_name'].')' );
					break;
				}
			}
			if( $tournament_data['match'][$i1]['winner'] != 0 ){
				if( $i1 >= 5 ){
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row+2, $winstr[2][2].' '.$winstr[2][1] );
				} else {
					$sheet->setCellValueByColumnAndRow( $col+$wincolofs, $row+2, $winstr[2][1].' '.$winstr[2][2] );
				}
			}
			if( $tournament_data['match'][$i1]['winner'] == 2 ){
				$sheet->getStyle($chartRow1.($row+2).':'.$chartRow2.($row+2))->applyFromArray($styleArrayH);
				$sheet->getStyle($chartRow3.($row-4).':'.$chartRow3.($row+1))->applyFromArray($styleArrayV);
			}
			$row += 12;
			if( $i1 == 4 ){
				$row = 7;
				$col = 55;
				$wincolofs = -4;
				$mode1 = 'r';
				$mode2 = 'r';
				$chartRow1 = 'BA';
				$chartRow2 = 'BC';
				$chartRow3 = 'AZ';
				$chartRow4 = 'AX';
				$chartRow5 = 'AZ';
			}
		}

		$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][1], 'l', 'l' );
		if( $tournament_data['match'][1]['winner'] != 0 ){
			$sheet->getStyle('Y27')->applyFromArray($styleArrayH);
			$sheet->setCellValueByColumnAndRow( 24, 13, $winstr[1][1].' '.$winstr[1][2] );
			$sheet->setCellValueByColumnAndRow( 24, 39, $winstr[2][1].' '.$winstr[2][2] );
		}
		$sheet->setCellValueByColumnAndRow( 18, 13, $tournament_data['match'][1]['team1_name'] );
		for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
			if( $tournament_data['match'][1]['team1'] == $entry_list[$i2]['id'] ){
				$sheet->setCellValueByColumnAndRow( 18, 15, '('.$entry_list[$i2]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][1]['winner'] == 1 ){
			$sheet->getStyle('X15')->applyFromArray($styleArrayH);
			$sheet->getStyle('X15:X26')->applyFromArray($styleArrayV);
		}
		$sheet->setCellValueByColumnAndRow( 18, 37, $tournament_data['match'][1]['team2_name'] );
		for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
			if( $tournament_data['match'][1]['team2'] == $entry_list[$i2]['id'] ){
				$sheet->setCellValueByColumnAndRow( 18, 39, '('.$entry_list[$i2]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][1]['winner'] == 2 ){
			$sheet->getStyle('X39')->applyFromArray($styleArrayH);
			$sheet->getStyle('X27:X38')->applyFromArray($styleArrayV);
		}

		$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][2], 'r', 'r' );
		if( $tournament_data['match'][2]['winner'] != 0 ){
			$sheet->getStyle('AS27:AT27')->applyFromArray($styleArrayH);
			$sheet->setCellValueByColumnAndRow( 45, 13, $winstr[1][2].' '.$winstr[1][1] );
			$sheet->setCellValueByColumnAndRow( 45, 39, $winstr[2][2].' '.$winstr[2][1] );
		}
		$sheet->setCellValueByColumnAndRow( 48, 13, $tournament_data['match'][2]['team1_name'] );
		for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
			if( $tournament_data['match'][2]['team1'] == $entry_list[$i2]['id'] ){
				$sheet->setCellValueByColumnAndRow( 48, 15, '('.$entry_list[$i2]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][2]['winner'] == 1 ){
			$sheet->getStyle('AU15:AV15')->applyFromArray($styleArrayH);
			$sheet->getStyle('AT15:AT26')->applyFromArray($styleArrayV);
		}
		$sheet->setCellValueByColumnAndRow( 48, 37, $tournament_data['match'][2]['team2_name'] );
		for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
			if( $tournament_data['match'][2]['team2'] == $entry_list[$i2]['id'] ){
				$sheet->setCellValueByColumnAndRow( 48, 39, '('.$entry_list[$i2]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][2]['winner'] == 2 ){
			$sheet->getStyle('AU39:AV39')->applyFromArray($styleArrayH);
			$sheet->getStyle('AT27:AT38')->applyFromArray($styleArrayV);
		}

		$winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][0], 'l', 'r' );
		if( $tournament_data['match'][0]['winner'] != 0 ){
			$sheet->getStyle('AH22:AH26')->applyFromArray($styleArrayV);
			$sheet->setCellValueByColumnAndRow( 31, 25, $winstr[1][1].' '.$winstr[1][2] );
			$sheet->setCellValueByColumnAndRow( 35, 25, $winstr[2][2].' '.$winstr[2][1] );
		}
		$sheet->setCellValueByColumnAndRow( 25, 25, $tournament_data['match'][0]['team1_name'] );
		for( $team1_index = 0; $team1_index < count($entry_list); $team1_index++ ){
			if( $tournament_data['match'][0]['team1'] == $entry_list[$team1_index]['id'] ){
				$sheet->setCellValueByColumnAndRow( 25, 27, '('.$entry_list[$team1_index]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][0]['winner'] == 1 ){
			$sheet->getStyle('AE27:AH27')->applyFromArray($styleArrayH);
		}
		$sheet->setCellValueByColumnAndRow( 38, 25, $tournament_data['match'][0]['team2_name'] );
		for( $team2_index = 0; $team2_index < count($entry_list); $team2_index++ ){
			if( $tournament_data['match'][0]['team2'] == $entry_list[$team2_index]['id'] ){
				$sheet->setCellValueByColumnAndRow( 38, 27, '('.$entry_list[$team2_index]['school_address_pref_name'].')' );
				break;
			}
		}
		if( $tournament_data['match'][0]['winner'] == 2 ){
			$sheet->getStyle('AI27:AL27')->applyFromArray($styleArrayH);
		}

		if( $tournament_data['match'][0]['winner'] == 1 ){
			$sheet->setCellValueByColumnAndRow( 31, 18, $tournament_data['match'][0]['team1_name'] );
			$sheet->setCellValueByColumnAndRow( 31, 20, '('.$entry_list[$team1_index]['school_address_pref_name'].')' );
		} else if( $tournament_data['match'][0]['winner'] == 2 ){
			$sheet->setCellValueByColumnAndRow( 31, 18, $tournament_data['match'][0]['team2_name'] );
			$sheet->setCellValueByColumnAndRow( 31, 20, '('.$entry_list[$team2_index]['school_address_pref_name'].')' );
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_tournament_7_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_7_8_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_8_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_data, $entry_list, $mv )
	{
		return __output_tournament_7_8_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_chart_7_8_for_excel( $objPage, $path, $tournament_list, $league_data, $entry_list, $mv )
	{
        $tournament_data = $tournament_list[0];
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

	function output_tournament_chart_7_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, $mv )
	{
		return __output_tournament_chart_7_8_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, 'm' );
	}

	function output_tournament_chart_8_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, $mv )
	{
		return __output_tournament_chart_7_8_for_excel( $objPage, $path, $tournament_data, $league_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_match_for_HTML2_7_8( $objPage, $navi_info, $tournament_list, $entry_list, $mv )
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

		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果(一回戦)</h2>'."\n";
		for( $i1 = 1; $i1 <= 8; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;一回戦&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $tournament_list['match'][$i1+6], $entry_list, $mv );
		}
		$html .= $footer;
		$file = $navi_info['result_path'] . '/dtm'.$mv.'1.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );

		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果(準々決勝～決勝)</h2>'."\n";
		for( $i1 = 1; $i1 <= 4; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準々決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $tournament_list['match'][$i1+2], $entry_list, $mv );
		}
		for( $i1 = 1; $i1 <= 2; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $navi_info, $tournament_list['match'][$i1], $entry_list, $mv );
		}
		$html .= '<h3>団体決勝トーナメント&nbsp;決勝</h3>';
		$html .= $objPage->output_one_match_for_HTML2( $navi_info, $tournament_list['match'][0], $entry_list, $mv );
		$html .= $footer;
		$file = $navi_info['result_path'] . '/dtm'.$mv.'2.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_tournament_match_for_HTML2_7( $navi_info, $tournament_list, $entry_list )
	{
        $objPage = new form_page();
		__output_tournament_match_for_HTML2_7_8( $objPage, $navi_info, $tournament_list, $entry_list, 'm' );
	}

	function output_tournament_match_for_HTML2_8( $navi_info, $tournament_list, $entry_list )
	{
        $objPage = new form_page();
		__output_tournament_match_for_HTML2_7_8( $objPage, $navi_info, $tournament_list, $entry_list, 'w' );
	}


	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_8_for_PDF( $tournament_data, $entry_list, $mv )
	{
	}

	function output_tournament_7_for_PDF( $tournament_data, $entry_list, $mv )
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

	function __output_tournament_7_8_for_HTML( $navi_info, $tournament_data, $entry_list, $mv )
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
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
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
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
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
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
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
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
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
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '  <br /><br /><br />' . "\n";
		$pdf .=  '  </div>' . "\n";
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
		$file = $navi_info['result_path'].'/dt'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );
	//	return $pdf;
	}

	function output_tournament_7_for_HTML( $navi_info, $tournament_data, $entry_list )
	{
		__output_tournament_7_8_for_HTML( $navi_info, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_8_for_HTML( $navi_info, $tournament_data, $entry_list )
	{
		__output_tournament_7_8_for_HTML( $navi_info, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel7_8( $sheet, $series, $mv, $start_pos, $series_name, $kaisai_rev )
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
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.$_SESSION['auth']['year'];
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

	function output_entry_data_list_all_1_excel7( $sheet )
	{
		__output_entry_data_list_all_1_excel7_8( $sheet, 7, 'm', 4, '団体戦男子', 1 );
		__output_entry_data_list_all_1_excel7_8( $sheet, 8, 'w', 4+48, '団体戦女子', 1 );
		return false;
	}

	function output_entry_data_list_all_1_excel8( $sheet )
	{
		__output_entry_data_list_all_1_excel7_8( $sheet, 7, 'm', 4, '団体戦男子', 1 );
		__output_entry_data_list_all_1_excel7_8( $sheet, 8, 'w', 4+48, '団体戦女子', 1 );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_7_8( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$sql = 'select * from `entry_field` where `field` in (\'school_name\',\'school_name_ryaku\',\'join\') and `year`='.$_SESSION['auth']['year'];
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
					} else if( $fv['field'] == 'school_name_ryaku' ){
						$lv['school_name_ryaku'] = $fv['data'];
					} else if( $fv['field'] == 'join' ){
						$lv['join'] = intval( $fv['data'] );
					}
				}
			}
			if( $lv['join'] == 1 ){
				$ret1[] = $lv;
			} else {
				//$ret2[] = $lv;
			}
		}
		db_close( $dbs );
		return array_merge( $ret1, $ret2 );
	}

	function get_entry_data_list2_7()
	{
		return __get_entry_data_list2_7_8( 7 );
	}

	function get_entry_data_list2_8()
	{
		return __get_entry_data_list2_7_8( 8 );
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_7_8( $list, $series )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_field` where `field` in (\'school_address_pref\',\'school_name_ryaku\') and `year`='.$_SESSION['auth']['year'];
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

	function get_entry_data_for_draw_csv_7( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_7_8( $list, 7 ),
			'file' => 'dantai_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_8( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_7_8( $list, 8 ),
			'file' => 'dantai_w.csv'
		);
	}

	//--------------------------------------------------------------

?>
