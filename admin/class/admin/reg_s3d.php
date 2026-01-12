<?php

	function get_league_parameter_2()
	{
		$param = array(
			'mw' => 'm',
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

	function get_tournament_parameter_2()
	{
		$param = array(
			'mw' => '',
			'team_num' => 128,
			'match_num' => 127,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 7,
			'place_num' => 12,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 1
		);
		return $param;
	}

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

	function get_entry_data_2_list_for_PDF_get_param( $fields, $org_array, $pref_array, $grade_junior_array, $mw )
	{
		$school_address_pref = get_field_string_number( $fields, 'school_address_pref', 0 );
		$pref_name = '';
		foreach( $pref_array as $pv ){
			if( $pv['value'] == $school_address_pref ){
				$pref_name = $pv['title'];
				break;
			}
		}
		$school_org = get_field_string_number( $fields, 'school_org', 0 );
		$school_org_name = get_field_string( $fields, 'school_org_school_name' );
		foreach( $org_array as $pv ){
			if( $pv['value'] == $school_org ){
				$school_org_name .= $pv['title'];
				break;
			}
		}
		$sdata = array(
			'name' => $pref_name . '　' . $school_org_name . get_field_string( $fields, 'school_name' ),
			'address' => $pref_name . ' ' . get_field_string( $fields, 'school_address' ),
			'tel' => mb_convert_kana( get_field_string( $fields, 'school_phone_tel' ), 'krn' ),
			'manager' => get_field_string( $fields, 'manager_'.$mw.'_sei' ) . ' ' . get_field_string( $fields, 'manager_'.$mw.'_mei' ),
			'captain' => get_field_string( $fields, 'captain_'.$mw.'_sei' ) . ' ' . get_field_string( $fields, 'captain_'.$mw.'_mei' ),
			'introduction' => get_field_string( $fields, 'introduction_'.$mw ),
			'main_results' => get_field_string( $fields, 'main_results_'.$mw )
		);
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$grade = get_field_string_number( $fields, 'player'.$i1.'_grade_'.$mw, 0 );
			$grade_name = '';
			foreach( $grade_junior_array as $gv ){
				if( $gv['value'] == $grade ){
					$grade_name = $gv['title'];
					break;
				}
			}
			$name = get_field_string( $fields, 'player'.$i1.'_'.$mw.'_sei' )
				 . ' ' . get_field_string( $fields, 'player'.$i1.'_'.$mw.'_mei' );
			$sdata['player'.$i1] = mb_convert_kana( $name, 'sk' ). ' ' . $grade_name;
		}
		return $sdata;
	}

	function get_entry_data_2_list_for_PDF( $org_array, $pref_array, $grade_junior_array, $filter )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=2 order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$ret = array( 'm' => array(), 'w' => array() );
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( $filter == '' || $filter == 'entry' || $filter == 'entry_m' ){
                $output = false;
	    		if( get_field_string_number( $fields, 'shumoku_dantai_m_taikai', 0 ) == 1 ){
                    $output = true;
			    } else if(
                    get_field_string_number( $fields, 'shumoku_dantai_m_rensei_am', 0 ) == 1
			        || get_field_string_number( $fields, 'shumoku_dantai_m_rensei_pm', 0 ) == 1
                ){
        			for( $i1 = 1; $i1 <= 7; $i1++ ){
		    			if(
                            get_field_string( $fields, 'player'.$i1.'_m_sei' ) != ''
                            || get_field_string( $fields, 'player'.$i1.'_m_mei' ) != ''
					    ){
                            $output = true;
                            break;
                        }
                    }
                }
    			if( $output ){
    				$ret['m'][] = get_entry_data_2_list_for_PDF_get_param( $fields, $org_array, $pref_array, $grade_junior_array, 'm' );
		    	}
            }
			if( $filter == '' || $filter == 'entry' || $filter == 'entry_w' ){
                $output = false;
	    		if( get_field_string_number( $fields, 'shumoku_dantai_w_taikai', 0 ) == 1 ){
                    $output = true;
			    } else if(
                    get_field_string_number( $fields, 'shumoku_dantai_w_rensei_am', 0 ) == 1
			        || get_field_string_number( $fields, 'shumoku_dantai_w_rensei_pm', 0 ) == 1
                ){
        			for( $i1 = 1; $i1 <= 7; $i1++ ){
		    			if(
                            get_field_string( $fields, 'player'.$i1.'_w_sei' ) != ''
                            || get_field_string( $fields, 'player'.$i1.'_w_mei' ) != ''
					    ){
                            $output = true;
                            break;
                        }
                    }
                }
    			if( $output ){
    				$ret['w'][] = get_entry_data_2_list_for_PDF_get_param( $fields, $org_array, $pref_array, $grade_junior_array, 'w' );
		    	}
            }
/*
			if(
                ( $filter == '' || $filter == 'entry' || $filter == 'entry_m' )
                && ( get_field_string_number( $fields, 'shumoku_dantai_m_taikai', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_m_rensei_am', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_m_rensei_pm', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_m_opening', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_m_konshin', 0 ) == 1
                )
            ){
				$ret['m'][] = get_entry_data_2_list_for_PDF_get_param( $fields, $org_array, $pref_array, $grade_junior_array, 'm' );
			}
			if(
                ( $filter == '' || $filter == 'entry' || $filter == 'entry_w' )
                && ( get_field_string_number( $fields, 'shumoku_dantai_w_taikai', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_w_rensei_am', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_w_rensei_pm', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_w_opening', 0 ) == 1
                    || get_field_string_number( $fields, 'shumoku_dantai_w_konshin', 0 ) == 1
                )
            ){
				$ret['w'][] = get_entry_data_2_list_for_PDF_get_param( $fields, $org_array, $pref_array, $grade_junior_array, 'w' );
			}
*/
		}
		return $ret;
	}

	function __get_entry_data_2_list_for_PDF( $org_array, $pref_array, $grade_junior_array )
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

	function get_entry_data_list2_2()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`series`=2 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		$sql = 'select * from `entry_field` where `field` in (\'shumoku_dantai_m_taikai\',\'shumoku_dantai_m_rensei_am\',\'shumoku_dantai_m_rensei_pm\',\'shumoku_dantai_m_opening\',\'shumoku_dantai_m_konshin\',\'shumoku_dantai_w_taikai\',\'shumoku_dantai_w_rensei_am\',\'shumoku_dantai_w_rensei_pm\',\'shumoku_dantai_w_opening\',\'shumoku_dantai_w_konshin\',\'school_name_ryaku\') and `year`='.$_SESSION['auth']['year'];
		$field_list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['join_m'] = 0;
			$lv['join_w'] = 0;
			foreach( $field_list as $fv ){
				$info = intval( $fv['info'] );
				if( $id == $info ){
                    if( $fv['field'] == 'school_name_ryaku' ){
	    				$lv['school_name_ryaku'] = $fv['data'];
                    } else {
    					if( intval( $fv['data'] ) == 1 ){
	    					$lv['join'] = 1;
		    				if( substr( $fv['field'], 15, 1 ) == 'm' ){
			    				$lv['join_m'] = 1;
				    		} else {
					    		$lv['join_w'] = 1;
						    }
    						if( $lv['join_m'] == 1 && $lv['join_w'] == 1 ){
	    						break;
    						}
						}
					}
				}
			}
		}

		db_close( $dbs );
		return $list;
	}


	function __output_tournament_2_for_PDF( $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
	//	$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
		$pdf = '' . "\n"
		//	. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
		//	. '<head>' . "\n"
		//	. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
		//	. '<title>試合結果速報</title>' . "\n"
		//	. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
		//	. '</head>' . "\n"
		//	. '<body>' . "\n"
			. '<style>' . "\n"
			. '.content {' . "\n"
		//	. '    position: relative;' . "\n"
			. '    width: 480px;' . "\n"
			. '    height: 980px;' . "\n"
			. '    font-size: 11px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 160px;' . "\n"
			. '    height: 16px;' . "\n"
			. '    float: left;' . "\n"
			. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name {' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: 80px;' . "\n"
			. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_pref {' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 80px;' . "\n"
			. '    float: left;' . "\n"
			. '    width: 60px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num {' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 140px;' . "\n"
			. '    float: left;' . "\n"
		//	. '    width: 10px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    width: 160px;' . "\n"
			. '    height: 16px;' . "\n"
			. '    float: left;' . "\n"
			. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '    height: 8px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_border_none {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ffffff;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
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
			. '<H1 lang="ja">中学校'.$mvstr.'トーナメント表</H1>' . "\n"
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
					'pos' => $team_pos * 2 + 1, 'name' => $name, 'pref' => $pref
				);
				$team_pos++;
				$match_no++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 2 + 1, 'name' => $name, 'pref' => $pref
					);
					$team_pos++;
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
		for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
			$trpos[] = 0;
			$trofs[] = 0;
		}
		$line = 0;
		$name_index = 1;
		for(;;){
		//	$pdf .= '      <div class="clearfix">' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						$pdf .= '<div class="div_border_none div_result_tournament_name"></div>';
						$pdf .= '<div class="div_border_none div_result_tournament">';
					}
					$pdf .= '<div class="div_border_none div_result_one_tournament"></div>';
					continue;
				}
			//	$cell_pos = 'top: ' . ($line*$tournament_height) . 'px; left: '.($level*$tournament_width+$tournament_name_width).'px;';
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
					//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: 0px;" lang="ja">'.$one_match_tbl['team1']['name'].'</div>' . "\n";
					//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: '.$tournament_name_pref_left.'px;">('.$one_match_tbl['team1']['pref'].')</div>' . "\n";
					//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: '.$tournament_name_num_left.'px;">'.$name_index.'</div>' . "\n";
						$pdf .= '<div class="div_border_none div_result_tournament_name">' . "\n";
						$pdf .= '<div class="div_result_tournament_name_name" lang="ja">'.$one_match_tbl['team1']['name'].'</div>' . "\n";
						$pdf .= '<div class="div_result_tournament_name_pref" lang="ja">('.$one_match_tbl['team1']['pref'].')</div>' . "\n";
						$pdf .= '<div class="div_result_tournament_name_num" lang="ja">'.$name_index.'</div>' . "\n";
						$pdf .= '</div>' . "\n";
						$pdf .= '<div class="div_border_none div_result_tournament">';
						$name_index++;
					}
					$pdf .= '<div class="div_border_b div_result_one_tournament" style="'.$cell_pos.'"></div>' . "\n";
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						$trofs[$level] = 1;
					//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="';
					//	$pdf .= 'top: ' . (intval(($one_match_tbl['team1']['pos']+$one_match_tbl['team2']['pos'])/2)*$tournament_height+$tournament_height2) . 'px; ';
					//	$pdf .= 'left: '.($level*$tournament_width+$tournament_name_width+10).'px;';
					//	$pdf .= '">'.$one_match_tbl['place'].'-'.$one_match_tbl['place_match_no'].'</div>' . "\n";
					}
				} else if( $trofs[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						if( $level == 0 ){
						//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: 0px;">'.$one_match_tbl['team2']['name'].'</div>' . "\n";
						//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: '.$tournament_name_pref_left.'px;">('.$one_match_tbl['team2']['pref'].')</div>' . "\n";
						//	$pdf .= '<div class="div_border_none div_result_tournament_name" style="top: '.($line*$tournament_height+$tournament_height2).'px; left: '.$tournament_name_num_left.'px;">'.$name_index.'</div>' . "\n";
							$pdf .= '<div class="div_border_none div_result_tournament_name">' . "\n";
							$pdf .= '<div class="div_result_tournament_name_name" lang="ja">'.$one_match_tbl['team2']['name'].'</div>' . "\n";
							$pdf .= '<div class="div_result_tournament_name_pref" lang="ja">('.$one_match_tbl['team2']['pref'].')</div>' . "\n";
							$pdf .= '<div class="div_result_tournament_name_num" lang="ja">'.$name_index.'</div>' . "\n";
							$pdf .= '</div>' . "\n";
							$pdf .= '<div class="div_border_none div_result_tournament">';
							$name_index++;
						}
						$pdf .= '<div class="div_border_br div_result_one_tournament" style="'.$cell_pos.'"></div>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							$pdf .= '<div class="div_border_none div_result_tournament_name"></div>';
							$pdf .= '<div class="div_border_none div_result_tournament">';
						}
						$pdf .= '<div class="div_border_r div_result_one_tournament" style="'.$cell_pos.'"></div>' . "\n";
					}
				} else {
					if( $level == 0 ){
						$pdf .= '<div class="div_border_none div_result_tournament_name"></div>';
						$pdf .= '<div class="div_border_none div_result_tournament">';
					}
					$pdf .= '<div class="div_border_none div_result_one_tournament"></div>';
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
		//	$pdf .= '<div style="width: 0px; height: 0px; float: none; clear: both;"></div>';
			$pdf .= "\n".'      </div>' . "\n";
if( $line == 300 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
/**/
		$pdf .= '    <div style="position: static;">' . "\n";
		$pdf .= '    <table id="ex_t" border="0" cellspacing="0" cellpadding="0">' . "\n";
		$pdf .= '      <tr>' . "\n";
		$pdf .= '        <td class="td_right" colspan="2">&nbsp;</td>' . "\n";
		$pdf .= '        <td class="td_right" colspan="4">&nbsp;</td>' . "\n";
		$pdf .= '      </tr>' . "\n";
		$trtbl = array();
		$team_index_no = 1;
		for( $tournament_team = 0; $tournament_team < count($tournament_data['team'])*2; $tournament_team++ ){
			$lineStart = 1;
			$lineHeight = 2;
			$lineStep = 4;
			$lineMatch = 1;
			for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $lineMatch *= 2; }
			$match_no = $lineMatch + intval( $tournament_team / $lineStep );
		//	$pdf .= '      <tr>' . "\n";
			$tdtbl = array();
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
					$tddata = '<td class="tb_result_tournament_name" rowspan="' . $span . '" >' . "\n";
					foreach( $entry_list as $ev ){
						if( intval($tournament_data['team'][$tournament_team/2]['id']) == intval($ev['id']) ){
							if( $ev['school_name_ryaku'] != '' ){
								$tddata .= $ev['school_name_ryaku'];
							} else {
								$tddata .= $ev['school_name'];
							}
						}
					}
					$tddata .=  '        </td>' . "\n";
					$tddata .=  '        <td class="tb_result_tournament_name_pref" rowspan="' . $span . '" >(' . $ev['school_address_pref_name'] . ')</td>' . "\n";
					$tddata .=  '        <td class="tb_result_tournament_name_num" rowspan="' . $span . '" >' . $team_index_no . '</td>' . "\n";
					$tdtbl[] = $tddata;
					$team_index_no++;
				}
			}
			for( $tournament_match_offset = 0; $tournament_match_offset <  $tournament_data['match_level']-1; $tournament_match_offset++ ){
				$lineOffset = $tournament_team % $lineStep;
				$match_no = $lineMatch + intval( $tournament_team / $lineStep );
				$player1 = $tournament_data['match'][$match_no-1]['team1'];
				$player2 = $tournament_data['match'][$match_no-1]['team2'];
				$winner = $tournament_data['match'][$match_no-1]['winner'];
				$place = $tournament_data['match'][$match_no-1]['place'];
//echo $lineOffset,':',$match_no,':',$tournament_match_offset,':',$place,"<br />\n";
			//	$color = '';
				$color = ' style="border:1px #aaaaaa solid"';
				if( $tournament_match_offset > 0 || $place != 'no_match' ){
					if( $tournament_team < count( $tournament_data['team'] ) ){
						$border_lr = 'border-right:';
					} else {
						$border_lr = 'border-left:';
					}
					if( $lineOffset == $lineStart ){
						$color = ' style="'.$border_lr.' solid 2px #000000"';
					} else if( $lineOffset > $lineStart && $lineOffset < ( $lineStart + $lineHeight / 2 ) ){
						$color = ' style="'.$border_lr.' solid 2px #000000"';
					} else if( $lineOffset >= ( $lineStart + $lineHeight / 2 )  && $lineOffset < ( $lineStart + $lineHeight ) ){
						$color = ' style="'.$border_lr.' solid 2px #000000"';
					} else if( $lineOffset == ( $lineStart - 1 ) ){
						$color = ' style="border-bottom: solid 2px #ff0000"';
					} else if( $lineOffset == ( $lineStart + $lineHeight ) ){
						$color = ' style="border-top: solid 2px #000000"';
					}
				} else {
					if( ( $tournament_team % 8 ) >= 4 && $lineOffset == ( $lineStart + 1 ) ){
						$color = ' style="border-top: solid 2px #000000"';
					} else if( ( $tournament_team % 8 ) < 4 && $lineOffset == ( $lineStart ) ){
						$color = ' style="border-bottom: solid 2px #ff0000"';
					}
				}
				$tdtbl[] = '        <td class="tb_result_tournament"'.$color.'>&nbsp;</td>' . "\n";
				$lineStart *= 2;
				$lineHeight *= 2;
				$lineStep *= 2;
				$lineMatch /= 2;
			}
			$trtbl[] = $tdtbl;
		}
		$ctr = count( $trtbl );
		$ctr2 = intval( $ctr / 2 );
		$ctr4 = intval( $ctr2 / 2 );
		for( $i1 = 0; $i1 < $ctr2; $i1++ ){
			$pdf .= '      <tr>' . "\n";
			foreach( $trtbl[$i1] as $tv ){
				$pdf .= $tv;
			}
			if( $i1 == $ctr4 ){
				$pdf .= '<td class="tb_result_tournament" style="border-bottom: solid 2px #000000; border-right: solid 2px #000000;">&nbsp;</td>' . "\n";
				$pdf .= '<td class="tb_result_tournament" style="border-bottom: solid 2px #000000;">&nbsp;</td>' . "\n";
			} else {
				$pdf .= '<td class="tb_result_tournament">&nbsp;</td>' . "\n";
				$pdf .= '<td class="tb_result_tournament">&nbsp;</td>' . "\n";
			}
			if( count( $trtbl[$i1+$ctr2] ) > 0 ){
				for( $i2 = count($trtbl[$i1+$ctr2]) - 1; $i2 >= 0; $i2-- ){
					$pdf .= $trtbl[$i1+$ctr2][$i2];
				}
			}
			$pdf .= '      </tr>' . "\n";
		}
//print_r($trtbl);
		$pdf .=  '    </table>' . "\n";
/**/
	//	$pdf .=  '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n";
	//	$pdf .=  '    <br />' . "\n";
	//	$pdf .=  '    <br />' . "\n";
	//	$pdf .=  '    </div>' . "\n";
	//	$pdf .=  '    </div>' . "\n";
	//	$pdf .=  '  </div>' . "\n";
		$pdf .=  '  </div>' . "\n";
	//	$pdf .=  '</body>' . "\n";
	//	$pdf .=  '</html>' . "\n";

//echo $pdf;
//exit;
		return $pdf;
	}

	function output_tournament_2_for_PDF( $tournament_list, $entry_list, $mv )
	{
        include( dirname(dirname(dirname(__FILE__)))."/tcpdf/tcpdf.php" );
        $tcpdf = new TCPDF("P", "mm", "B4", true, "UTF-8" ); // 250x353
        $tcpdf->setPrintHeader(false);
        $tcpdf->setPrintFooter(false);
        $tcpdf->setTextColor(0);
        $tcpdf->AddPage();
        $font = new TCPDF_FONTS();
        // フォント：IPAゴシック
        $font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipagp.ttf' );
        $tcpdf->SetFont($font_1 , '', 7,'',true);
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );

//print_r($tournament_data);
        $tournament_data = $tournament_list[0];
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
				$one_match['team1'] = array( 'id' => $id );
                if( $id > 0 ){
                    $one_match['team1']['pos'] = $team_pos * 4;
                    $one_match['team1']['name'] = $name;
                    $one_match['team1']['pref'] = $pref;
                    $one_match['team1']['index'] = $team_index;
                    $team_pos++;
                    $team_index++;
				}
				$match_no++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
                    $one_match['team2'] = array( 'id' => $id );
                    if( $id > 0 ){
                        $one_match['team2']['pos'] = $team_pos * 4;
                        $one_match['team2']['name'] = $name;
                        $one_match['team2']['pref'] = $pref;
                        $one_match['team2']['index'] = $team_index;
                        $team_pos++;
                        $team_index++;
                    }
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
//print_r($match_tbl);
//exit;

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

        $left = 10;
        $top = 10;
		$name_width = 20;
		$pref_width = 15;
		$index_width = 6;
        $chart_width = 8;
        $chart_left = $left + $name_width + $pref_width + $index_width + 2;
        $chart_right = $chart_left + $tournament_data['match_level'] * 2 * $chart_width;
        $right = $chart_right + $name_width + $pref_width + $index_width + 2;
		$height_unit = 1.2;
		$height_unit4 = 4.8;
        $min_y = 99999;
        $max_y = 0;
		for( $i1 = 0; $i1 < $tournament_data['match_level']-1; $i1++ ){
            foreach( $match_tbl[0][$i1] as $mv ){
                if( $i1 == 0 ){
                    $tcpdf->MultiCell(
                        $name_width, $height_unit4, $mv['team1']['name'], 0, 'L', false, 0,
                        $left, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $pref_width, $height_unit4, '('.$mv['team1']['pref'].')', 0, 'L', false, 0,
                        $left+$name_width, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $index_width, $height_unit4, $mv['team1']['index'], 0, 'R', false, 0,
                        $left+$name_width+$pref_width, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                }
                if( $mv['place'] === 'no_match' ){
                    $tcpdf->Line( $chart_left+$chart_width*$i1, $top+($mv['team1']['pos']+2)*$height_unit, $chart_left+$chart_width*($i1+1), $top+($mv['team1']['pos']+2)*$height_unit, $b1 );
                    if( $min_y > $top+($mv['team1']['pos']+2)*$height_unit ){
                        $min_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                    if( $max_y < $top+($mv['team1']['pos']+2)*$height_unit ){
                        $max_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                } else {
                    if( $i1 == 0 ){
                        $tcpdf->MultiCell(
                            $name_width, $height_unit4, $mv['team2']['name'], 0, 'L', false, 0,
                            $left, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $pref_width, $height_unit4, '('.$mv['team2']['pref'].')', 0, 'L', false, 0,
                            $left+$name_width, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $index_width, $height_unit4, $mv['team2']['index'], 0, 'R', false, 0,
                            $left+$name_width+$pref_width, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                    }
                    $tcpdf->Rect( $chart_left+$chart_width*$i1, $top+($mv['team1']['pos']+2)*$height_unit, $chart_width, ($mv['team2']['pos']-$mv['team1']['pos'])*$height_unit, 'D', array('T' => $b1,'R' => $b1,'B' => $b1), array() );
                    $tcpdf->MultiCell(
                        $chart_width, $height_unit4,
                        $mv['place'].'-'.$mv['place_match_no'], 0, 'R', false, 0,
                        $chart_left+$chart_width*$i1, $top+($mv['team1']['pos']+($mv['team2']['pos']-$mv['team1']['pos'])/2)*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    if( $min_y > $top+($mv['team1']['pos']+2)*$height_unit ){
                        $min_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                    if( $max_y < $top+($mv['team2']['pos']+2)*$height_unit ){
                        $max_y = $top + ( $mv['team2']['pos'] + 2 ) * $height_unit;
                    }
                }
            }
            foreach( $match_tbl[1][$i1] as $mv ){
                if( $i1 == 0 ){
                    $tcpdf->MultiCell(
                        $index_width, $height_unit4, $mv['team1']['index'], 0, 'R', false, 0,
                        $right-$name_width-$pref_width-$index_width, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $name_width, $height_unit4, $mv['team1']['name'], 0, 'L', false, 0,
                        $right-$name_width-$pref_width, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    $tcpdf->MultiCell(
                        $pref_width, $height_unit4, '('.$mv['team1']['pref'].')', 0, 'L', false, 0,
                        $right-$pref_width, $top+$mv['team1']['pos']*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                }
                if( $mv['place'] === 'no_match' ){
                    $tcpdf->Line( $chart_right-($i1+1)*$chart_width, $top+($mv['team1']['pos']+2)*$height_unit, $chart_right-$chart_width*$i1, $top+($mv['team1']['pos']+2)*$height_unit, $b1 );
                    if( $min_y > $top+($mv['team1']['pos']+2)*$height_unit ){
                        $min_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                    if( $max_y < $top+($mv['team1']['pos']+2)*$height_unit ){
                        $max_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                } else {
                    if( $i1 == 0 ){
                        $tcpdf->MultiCell(
                            $index_width, $height_unit4, $mv['team2']['index'], 0, 'R', false, 0,
                            $right-$name_width-$pref_width-$index_width, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $name_width, $height_unit4, $mv['team2']['name'], 0, 'L', false, 0,
                            $right-$name_width-$pref_width, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                        $tcpdf->MultiCell(
                            $pref_width, $height_unit4, '('.$mv['team2']['pref'].')', 0, 'L', false, 0,
                            $right-$pref_width, $top+$mv['team2']['pos']*$height_unit,
                            true, 0, false, false, $height_unit4, 'M', false
                        );
                    }
                    $tcpdf->Rect( $chart_right-($i1+1)*$chart_width, $top+($mv['team1']['pos']+2)*$height_unit, $chart_width, ($mv['team2']['pos']-$mv['team1']['pos'])*$height_unit, 'D', array('T' => $b1,'L' => $b1,'B' => $b1), array() );
                    $tcpdf->MultiCell(
                        $chart_width, $height_unit4,
                        $mv['place'].'-'.$mv['place_match_no'], 0, 'L', false, 0,
                        $chart_right-($i1+1)*$chart_width, $top+($mv['team1']['pos']+($mv['team2']['pos']-$mv['team1']['pos'])/2)*$height_unit,
                        true, 0, false, false, $height_unit4, 'M', false
                    );
                    if( $min_y > $top+($mv['team1']['pos']+2)*$height_unit ){
                        $min_y = $top + ( $mv['team1']['pos'] + 2 ) * $height_unit;
                    }
                    if( $max_y < $top+($mv['team2']['pos']+2)*$height_unit ){
                        $max_y = $top + ( $mv['team2']['pos'] + 2 ) * $height_unit;
                    }
                }
            }
        }
        $tcpdf->Line(
            $chart_left+$chart_width*$tournament_data['match_level'], ($max_y+$min_y)/2-$height_unit4,
            $chart_left+$chart_width*$tournament_data['match_level'], ($max_y+$min_y)/2, $b1 );
        $tcpdf->Line(
            $chart_left+$chart_width*($tournament_data['match_level']-1), ($max_y+$min_y)/2,
            $chart_left+$chart_width*($tournament_data['match_level']+1), ($max_y+$min_y)/2, $b1 );
        $tcpdf->MultiCell(
            $chart_width*2, $height_unit4,
            $tournament_data['match'][0]['place'].'-'.$tournament_data['match'][0]['place_match_no'], 0, 'C', false, 0,
            $chart_left+$chart_width*($tournament_data['match_level']-1), ($max_y+$min_y)/2+$height_unit,
            true, 0, false, false, $height_unit4, 'M', false
        );
        $tcpdf->Output("output.pdf", "D");
	}


	function output_tournament_2_for_HTML( $series_info, $tournament_list, $entry_list, $mv )
	{
//print_r($tournament_data);
		$objPage = new form_page();
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		}

        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

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
			. '    width: 900px;' . "\n"
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
			. '    width: 96px;' . "\n"
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
			. '    width: 72px;' . "\n"
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
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">中学校'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_' . $series_info['result_prefix'] . $mv . '.html">←戻る</a></h2>'."\n"
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
						$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
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
								//$pdf .= '<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>　';
								$pdf .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '　';
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
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;"><a href="r'.$mv.'01.html">'.$tournament_data['match'][0]['hon1'].' -'.'</a></td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"><a href="r'.$mv.'01.html"> '.$tournament_data['match'][0]['hon2'].'</a></td>';
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
								//$pdf .= '　<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>';
								$pdf .= '　' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
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
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

//echo $pdf;
//exit;
        $file = 'dt_' . $series_info['result_prefix'] . $mv . $tindex;
        $path = $series_info['result_path'] . '/' . $file . '.html';
		$fp = fopen( $path, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );
		$data = [
			'mode' => 2,
			'navi' => $series_info['navi_id'],
			'place' => $file,
			'file' => $path,
			'series' => $series_info['result_path_prefix'], // . '/' . $navi_info['reg_year'],
		];
		$objPage->update_realtime_queue( $data );

            $tindex++;
        }

		//return $pdf;
	}


	function output_entry_data_list_all_1_excel2( $sheet )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=2 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `entry_info`.`disp_order` asc';
		//$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=2 order by `disp_order` asc';
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
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_org_school_name'].$c->get_org_name( $get_org_name, intval($fields['school_org']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ).$fields['school_address'] );
            $sheet->getCellByColumnAndRow( $col++, $pos )->setValueExplicit( $fields['school_phone_tel'], PHPExcel_Cell_DataType::TYPE_STRING );
            $sheet->getCellByColumnAndRow( $col++, $pos )->setValueExplicit( $fields['school_phone_fax'], PHPExcel_Cell_DataType::TYPE_STRING );
			//$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			//$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_email'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu4_sei'].' '.$fields['insotu4_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['referee_sei'].' '.$fields['referee_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['referee_rank'] );
			$sel = explode( '|', $fields['refereeing_category'] );
            $refereeing_category = '';
			foreach( $sel as $sv ){
				if( $sv == 'm' ){
                    if( $refereeing_category != '' ){ $refereeing_category .= '/'; }
                    $refereeing_category .= '男子';
				} else if( $sv == 'w' ){
                    if( $refereeing_category != '' ){ $refereeing_category .= '/'; }
                    $refereeing_category .= '女子';
				}
			}
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $refereeing_category );

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
			}

			$mw = 'm';
			for( $sss = 0; $sss < 2; $sss++ ){
                if( $fields['shumoku_dantai_'.$mw.'_taikai'] == 1 ){ 
    				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
	    		}
                $col++;
		    	if( $fields['shumoku_dantai_'.$mw.'_rensei_am'] == 1 ){ 
			    	$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
    			}
                $col++;
	    		if( $fields['shumoku_dantai_'.$mw.'_rensei_pm'] == 1 ){ 
		    		$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			    }
                $col++;
    			if( $fields['shumoku_dantai_'.$mw.'_opening'] == 1 ){ 
	    			$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
		    	}
                $col++;
			    if( $fields['shumoku_dantai_'.$mw.'_konshin'] == 1 ){ 
				    $sheet->setCellValueByColumnAndRow( $col, $pos, '○('.$fields['shumoku_dantai_'.$mw.'_text'].'名)' );
    			}
                $col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_'.$mw.'_sei'].' '.$fields['manager_'.$mw.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_'.$mw.'_add'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_'.$mw.'_sei'].' '.$fields['captain_'.$mw.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_'.$mw.'_add'] );
				for( $player = 1; $player <= 7; $player++ ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_'.$mw.'_sei'].' '.$fields['player'.$player.'_'.$mw.'_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_'.$mw.'_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_grade_'.$mw] );
				}
    			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['introduction_'.$mw] );
	    		$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['main_results_'.$mw] );
				$mw = 'w';
			}

			$index++;
			$pos++;
		}
		db_close( $dbs );
        return false;
	}

    function output_catalog_2_for_PDF( $org_array, $pref_array, $grade_junior_array, $filter )
    {
        include( dirname(dirname(dirname(__FILE__)))."/tcpdf/tcpdf.php" );

        $list = get_entry_data_2_list_for_PDF( $org_array, $pref_array, $grade_junior_array, $filter );
        $pdf = new TCPDF("P", "mm", "B4", true, "UTF-8" ); // 250x353
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setTextColor(0);
		$pdf->setFontSubsetting(false);
        $pdf->AddPage();
        $font = new TCPDF_FONTS();
        // フォント：IPAゴシック
        //$font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipagp.ttf' );
        //$font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipamjm.ttf' );
        //$pdf->SetFont($font_1, '', 7,'',true);
        $pdf->SetFont('ipamjm', '', 7,'');
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $b2 = array( 'width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $top = 10;
        $left = 10;
        $lineheight = 5;
        $offset = 0;
        $pdf->SetLineStyle( $b1 );
        foreach( $list['m'] as $lv ){
            $pdf->Rect( $left, $top, 100, $lineheight*12, 'D', array('all' => $b2), array() );
            $pdf->MultiCell( 60, $lineheight, $lv['name'], 0, 'L', false, 0, $left, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->SetLineStyle( $b1 );
            $pdf->MultiCell( 40, $lineheight, 'tel　'.$lv['tel'], 'L', 'L', false, 0, $left+60, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 100, $lineheight, '住所　'.$lv['address'], 'T', 'L', false, 0, $left, $top+$lineheight, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '監督　'.$lv['manager'], 'T', 'L', false, 0, $left, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '主将　'.$lv['captain'], 'TL', 'L', false, 0, $left+50, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '１　'.$lv['player1'].'　'.$lv['player1_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '２　'.$lv['player2'].'　'.$lv['player2_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '３　'.$lv['player3'].'　'.$lv['player3_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '４　'.$lv['player4'].'　'.$lv['player4_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '５　'.$lv['player5'].'　'.$lv['player5_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '６　'.$lv['player6'].'　'.$lv['player6_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '７　'.$lv['player7'].'　'.$lv['player7_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*5, true, 0, false, false, $lineheight, 'M', false );
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
        if( $offset > 0 ){
            $offset = 0;
            $top = 10;
            $left = 10;
            $pdf->AddPage( 'P', 'B4' );
        }
        foreach( $list['w'] as $lv ){
            $pdf->Rect( $left, $top, 100, $lineheight*12, 'D', array('all' => $b2), array() );
            $pdf->MultiCell( 60, $lineheight, $lv['name'], 0, 'L', false, 0, $left, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->SetLineStyle( $b1 );
            $pdf->MultiCell( 40, $lineheight, 'tel　'.$lv['tel'], 'L', 'L', false, 0, $left+60, $top, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 100, $lineheight, '住所　'.$lv['address'], 'T', 'L', false, 0, $left, $top+$lineheight, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '監督　'.$lv['manager'], 'T', 'L', false, 0, $left, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 50, $lineheight, '主将　'.$lv['captain'], 'TL', 'L', false, 0, $left+50, $top+$lineheight*2, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '１　'.$lv['player1'].'　'.$lv['player1_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '２　'.$lv['player2'].'　'.$lv['player2_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '３　'.$lv['player3'].'　'.$lv['player3_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*3, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '４　'.$lv['player4'].'　'.$lv['player4_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '５　'.$lv['player5'].'　'.$lv['player5_grade'], 'TLR', 'L', false, 0, $left+33, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 34, $lineheight, '６　'.$lv['player6'].'　'.$lv['player6_grade'], 'T', 'L', false, 0, $left+66, $top+$lineheight*4, true, 0, false, false, $lineheight, 'M', false );
            $pdf->MultiCell( 33, $lineheight, '７　'.$lv['player7'].'　'.$lv['player7_grade'], 'T', 'L', false, 0, $left, $top+$lineheight*5, true, 0, false, false, $lineheight, 'M', false );
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

        $file_name = 'catalog_' .date('YmdHis') . sprintf("%04d",microtime()*1000) . '.pdf';
        $pdf->Output( $file_name, "D" );
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_2( $series_info, $tournament_list, $entry_list, $mw )
	{
		$objPage = new form_page();
        $objPage->output_tournament_match_for_HTML2( $objPage, $series_info, $tournament_list, $entry_list, $mw, $series_info['split_tournament_match_output'] );
	}

	function output_tournament_chart_2_for_excel( $objPage, $series_info, $tournament_param, $tournament_data, $league_data, $entry_list, $mw )
	{
        $objTournament = new form_page_dantai_tournament( $objPage );
        return $objTournament->output_dantai_tournament_for_excel( $objPage, $series_info['output_path'], $series_info, $tournament_param, $tournament_data, $entry_list, $mw );
	}

	function output_tournament_match_2_for_excel( $objPage, $series_info, $tournament_param, $tournament_data, $league_data, $entry_list, $mw )
	{
        $objTournament = new form_page_dantai_tournament( $objPage );
        return $objTournament->output_dantai_tournament_match_for_excel( $objPage, $series_info['output_path'], $series_info, $tournament_param, $tournament_data, $entry_list, $mw );
	}

?>
