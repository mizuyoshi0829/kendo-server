<?php

class form_page_dantai_league
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $this->__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_league_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `dantai_league_series` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            $list = $serieslist[0];
/**/
            $p = $this->extract_dantai_league_parameter( $list, null );
            $list['team_num'] = $p['team_num'];
            $list['match_num'] = $p['match_num'];
            $list['match_info_array'] = $p['match_info_array'];
            $list['match_info'] = $p['match_info'];
            $list['place_match_info_array'] = $p['place_match_info_array'];
            $list['place_match_info'] = $p['place_match_info'];
            $list['chart_team_tbl_array'] = $p['chart_team_tbl_array'];
            $list['chart_team_tbl'] = $p['chart_team_tbl'];
            $list['chart_tbl_array'] = $p['chart_tbl_array'];
            $list['chart_tbl'] = $p['chart_tbl'];
/**/
            return $list;
        } else {
            return array();
        }
/*
        if( count( $serieslist ) > 0 ){
            $lv = $serieslist[0];
			$team_num = intval( $lv['team_num'] );
			$match_num = intval( $lv['match_num'] );
			$m = explode( ',', $lv['match_info_array'] );
            $lv['match_info'] = array();
            if( count( $m ) > 0 ){
                $mindex = 0;
                for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                    for( $i2 = $i1+1; $i2 < $team_num; $i2++ ){
                        $lv['match_info'][] = array( intval( $m[$mindex] ), intval( $m[$mindex+1] ) );
                        $mindex += 2;
                    }
                }
            } else {
                for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                    for( $i2 = $i1+1; $i2 < $team_num; $i2++ ){
                        $lv['match_info'][] = array( $i1, $i2 );
                    }
                }
            }
//print_r($lv['match_info']);
			//$lv['place_match_info'] = array( array( 1, 3, 5 ), array( 2, 4, 6 ) );
			$m = explode( ',', $lv['place_match_info_array'] );
			$lv['place_match_info'] = array();
            foreach( $m as $mv ){
    			$lv['place_match_info'][] = intval( $mv );
            }
			//$lv['chart_tbl'] = array( array( 0, 1, 2 ), array( 1, 0, 3 ), array( 2, 3, 0 ) );
			//$lv['chart_team_tbl'] = array( array( 0, 1, 1 ), array( 2, 0, 1 ), array( 2, 2, 0 ) );

			$lv['chart_team_tbl'] = array();
			$m = explode( ',', $lv['chart_team_tbl_array'] );
            $mindex = 0;
            for( $i1 = 0; $i1 < $team_num; $i1++ ){
 	    		$chart_team_tbl = array();
                for( $i2 = 0; $i2 < $team_num; $i2++ ){
                    if( count( $m ) > 0 ){
                        $chart_team_tbl[] = intval( $m[$mindex++] );
                    } else {
                        if( $i1 == $i2 ){
                            $chart_team_tbl[] = 0;
                        } else {
                            if( $i1 < $i2 ){
                                $chart_team_tbl[] = 1;
                            } else {
                                $chart_team_tbl[] = 2;
                            }
                        }
                    }
                }
  	    		$lv['chart_team_tbl'][] = $chart_team_tbl;
            }

			$lv['chart_tbl'] = array();
			$m = explode( ',', $lv['chart_tbl_array'] );
            if( count( $m ) > 0 ){
                $mindex = 0;
                for( $i1 = 0; $i1 < $team_num; $i1++ ){
 	        		$chart_tbl = array();
                    for( $i2 = 0; $i2 < $team_num; $i2++ ){
                        $chart_tbl[] = intval( $m[$mindex++] );
                    }
      	    		$lv['chart_tbl'][] = $chart_tbl;
                }
            } else {
                for( $i1 = 0; $i1 < $team_num; $i1++ ){
        			$chart_tbl = array();
                    for( $i2 = 0; $i2 < $team_num; $i2++ ){
                        $chart_tbl[] = 0;
                    }
    	    		$lv['chart_tbl'][] = $chart_tbl;
	    	    	$lv['chart_team_tbl'][] = $chart_team_tbl;
                }
                $index = 1;
                for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                    for( $i2 = $i1 + 1; $i2 < $team_num; $i2++ ){
                        $lv['chart_tbl'][$i1][$i2] = $index;
                        $lv['chart_tbl'][$i2][$i1] = $index;
                        $index++;
                    }
                }
            }
            return $lv;
        }
        $func = 'get_league_parameter_'.$series;
        return $func();
*/
	}

	function extract_dantai_league_parameter( $series_info, $league_info )
	{
        $lv = $series_info;
        if( !is_null( $league_info ) ){
            $lv['team_num'] = get_field_string( $league_info, 'team_num' );
            $lv['match_num'] = get_field_string( $league_info, 'match_num' );
        }
        $team_num = get_field_string_number( $lv, 'team_num', 0 );
        $match_num = get_field_string_number( $lv, 'match_num', 0 );

        $match_info_array = get_field_string( $series_info, 'match_info_array' );
        $match_info_array2 = get_field_string( $league_info, 'match_info_array' );
        $lv['match_info_array'] = ( $match_info_array2 != '' ) ? $match_info_array2 : $match_info_array;
        $m = explode( ',', $lv['match_info_array'] );
        $lv['match_info'] = array();
        if( count( $m ) > 0 ){
            $mindex = 0;
            for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                for( $i2 = $i1+1; $i2 < $team_num; $i2++ ){
                    $lv['match_info'][] = array( intval( $m[$mindex] ), intval( $m[$mindex+1] ) );
                    $mindex += 2;
                }
            }
        } else {
            for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                for( $i2 = $i1+1; $i2 < $team_num; $i2++ ){
                    $lv['match_info'][] = array( $i1, $i2 );
                }
            }
        }

        $place_match_info_array = get_field_string( $series_info, 'place_match_info_array' );
        $place_match_info_array2 = get_field_string( $league_info, 'place_match_info_array' );
        $lv['place_match_info_array'] = ( $place_match_info_array2 != '' ) ? $place_match_info_array2 : $place_match_info_array;
        $m = explode( ',', $lv['place_match_info_array'] );
        $lv['place_match_info'] = array();
        foreach( $m as $mv ){
            $lv['place_match_info'][] = intval( $mv );
        }

        $chart_team_tbl_array = get_field_string( $series_info, 'chart_team_tbl_array' );
        $chart_team_tbl_array2 = get_field_string( $league_info, 'chart_team_tbl_array' );
        $lv['chart_team_tbl_array'] = ( $place_match_info_array2 != '' ) ? $chart_team_tbl_array2 : $chart_team_tbl_array;
        $m = explode( ',', $lv['chart_team_tbl_array'] );
        $lv['chart_team_tbl'] = array();
        $mindex = 0;
        for( $i1 = 0; $i1 < $team_num; $i1++ ){
 	        $chart_team_tbl = array();
            for( $i2 = 0; $i2 < $team_num; $i2++ ){
                if( count( $m ) > 0 ){
                    $chart_team_tbl[] = intval( $m[$mindex++] );
                } else {
                    if( $i1 == $i2 ){
                        $chart_team_tbl[] = 0;
                    } else {
                        if( $i1 < $i2 ){
                            $chart_team_tbl[] = 1;
                        } else {
                            $chart_team_tbl[] = 2;
                        }
                    }
                }
            }
  	    	$lv['chart_team_tbl'][] = $chart_team_tbl;
        }

        $chart_tbl_array = get_field_string( $series_info, 'chart_tbl_array' );
        $chart_tbl_array2 = get_field_string( $league_info, 'chart_tbl_array' );
        $lv['chart_tbl_array'] = ( $chart_tbl_array2 != '' ) ? $chart_tbl_array2 : $chart_tbl_array;
		$m = explode( ',', $lv['chart_tbl_array'] );
		$lv['chart_tbl'] = array();
        if( count( $m ) > 0 ){
            $mindex = 0;
            for( $i1 = 0; $i1 < $team_num; $i1++ ){
                $chart_tbl = array();
                for( $i2 = 0; $i2 < $team_num; $i2++ ){
                    $chart_tbl[] = intval( $m[$mindex++] );
                }
      	        $lv['chart_tbl'][] = $chart_tbl;
            }
        } else {
            for( $i1 = 0; $i1 < $team_num; $i1++ ){
                $chart_tbl = array();
                for( $i2 = 0; $i2 < $team_num; $i2++ ){
                    $chart_tbl[] = 0;
                }
  	    		$lv['chart_tbl'][] = $chart_tbl;
    	    	$lv['chart_team_tbl'][] = $chart_team_tbl;
            }
            $index = 1;
            for( $i1 = 0; $i1 < $team_num - 1; $i1++ ){
                for( $i2 = $i1 + 1; $i2 < $team_num; $i2++ ){
                    $lv['chart_tbl'][$i1][$i2] = $index;
                    $lv['chart_tbl'][$i2][$i1] = $index;
                    $index++;
                } 
            }
        }
        return $lv;
	}

	function make_new_dantai_league_list( $series, $mw )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `dantai_league` (`series`,`year`,`series_mw`,`name`,`team_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['team_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
			db_query( $dbs, $sql );
		}
/*
		$group_place = 1;
		$group_place_offset = 0;
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `dantai_league` (`series`,`year`,`series_mw`,`name`,`team_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['team_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
echo $sql,"<br />\n";
$group_id = $group_index;
			//db_query( $dbs, $sql );
			//$group_id = db_query_insert_id( $dbs );

			$teams = array();
			for( $team_index = 1; $team_index <= $param['team_num']; $team_index++ ){
				$sql = 'INSERT INTO `dantai_league_team` ( `league`,`league_team_index`,`team`,`create_date`,`update_date` ) VALUES ( '.$group_id.', '.$team_index.', 0, NOW(), NOW() )';
echo $sql,"<br />\n";
$teams[] = 20 + $team_index;
					//db_query( $dbs, $sql );
					//$teams[] = db_query_insert_id( $dbs );
			}

			for( $group_match_index = 1; $group_match_index <= $param['match_num']; $group_match_index++ ){
				$matches = array();
				for( $match_index = 0; $match_index < 6; $match_index++ ){
					$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />\n";
$matches[] = 30 + $match_index;
						//db_query( $dbs, $sql );
						//$matches[] = db_query_insert_id( $dbs );
				}
				$sql = 'insert `dantai_match`'
					. ' set `team1`=0,'
					. '`team2`=0,'
					. '`place`='.$group_place.',`place_match_no`='.$param['place_match_info'][$group_place_offset][$group_match_index-1].','
					. '`match1`=' . $matches[0] . ','
					. '`match2`=' . $matches[1] . ','
					. '`match3`=' . $matches[2] . ','
					. '`match4`=' . $matches[3] . ','
					. '`match5`=' . $matches[4] . ','
					. '`match6`=' . $matches[5] . ','
					. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
$match_id = 40 + $group_index;
				//db_query( $dbs, $sql );
				//$match_id = db_query_insert_id( $dbs );

				$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$group_id.','.$group_match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
				//db_query( $dbs, $sql );
			}
			$group_place_offset = ( $group_place_offset + 1 ) % 2;
			if( $group_place_offset == 0 ){ $group_place++; }
		}
*/
	}

	function get_dantai_league_list_( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$lv['end_match'] = 0;
			$lv['team'] = array();
			$team_num = intval( $lv['team_num'] );
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				$lv['team'][] = array( 'team'=>0, 'point'=>0, 'advanced'=>0, 'standing'=>0 );
			}
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.intval($lv['id']);
			$team = db_query_list( $dbs, $sql );
			foreach( $team as $tv ){
				$no = intval( $tv['league_team_index'] );
				if( $no > 0 && $no <= $team_num ){
					$lv['team'][$no-1]['team'] = intval( $tv['team'] );
					$lv['team'][$no-1]['advanced'] = intval( $tv['advanced'] );
					$lv['team'][$no-1]['standing'] = intval( $tv['standing'] );
					$lv['team'][$no-1]['point'] = intval( $tv['point'] );
					$lv['team'][$no-1]['win'] = intval( $tv['win'] );
					$lv['team'][$no-1]['hon'] = intval( $tv['hon'] );
				}
			}

			$lv['match'] = array();
			$match_num = intval( $lv['match_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
				$lv['match'][] = array( 'match'=>0, 'place'=>0, 'place_match_no'=>0, 'end_match'=>0 );
			}
			$sql = 'select `dantai_league_match`.`match` as `match`,'
				. ' `dantai_league_match`.`league_match_index` as `league_match_index`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_match`.`team1` as `team1`,'
				. ' `dantai_match`.`team2` as `team2`,'
				. ' `dantai_match`.`win1` as `win1`,'
				. ' `dantai_match`.`win2` as `win2`,'
				. ' `dantai_match`.`hon1` as `hon1`,'
				. ' `dantai_match`.`hon2` as `hon2`,'
				. ' `dantai_match`.`match1` as `match1`,'
				. ' `dantai_match`.`match2` as `match2`,'
				. ' `dantai_match`.`match3` as `match3`,'
				. ' `dantai_match`.`match4` as `match4`,'
				. ' `dantai_match`.`match5` as `match5`,'
				. ' `dantai_match`.`match6` as `match6`,'
				. ' `dantai_match`.`fusen` as `fusen`,'
				. ' `dantai_match`.`winner` as `winner`'
				. ' from `dantai_league_match` join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_league_match`.`del`=0 and `dantai_league_match`.`league`='.intval($lv['id']);
			$match = db_query_list( $dbs, $sql );
			foreach( $match as $mv ){
				$no = intval( $mv['league_match_index'] );
				if( $no > 0 && $no <= $match_num+$extra_match_num ){
					$lv['match'][$no-1] = $mv;
					//$lv['match'][$no-1]['match'] = intval( $mv['match'] );
					//$lv['match'][$no-1]['place'] = intval( $mv['place'] );
					//$lv['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
					//$lv['match'][$no-1]['win1'] = intval( $mv['win1'] );
					//$lv['match'][$no-1]['win2'] = intval( $mv['win2'] );
					//$lv['match'][$no-1]['hon1'] = intval( $mv['hon1'] );
					//$lv['match'][$no-1]['hon2'] = intval( $mv['hon2'] );
					//$lv['match'][$no-1]['winner'] = intval( $mv['winner'] );
					$lv['match'][$no-1]['matches'] = array();
					$lv['match'][$no-1]['end_match'] = 0;
					for( $i1 = 1; $i1 <= 6; $i1++ ){
						$match_id = get_field_string_number( $mv, 'match'.$i1, 0 );
						if( $match_id != 0 ){
							$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
							if( $no <= $match_num && $i1 < 6 && $one_match['end_match'] == 1 ){
								$lv['match'][$no-1]['end_match']++;
							}
							if( $one_match['player1'] == 0 && $i1 < 6 ){
								$one_match['player1'] = $i1;
							}
/*
							$f = 'dantai_' . $mw . $one_match['player1'];
							$one_match['player1_name'] = $dantai_match['entry1'][$f.'_sei'] . ' '. $dantai_match['entry1'][$f.'_mei'];
							if( $dantai_match['entry1'][$f.'_disp'] != '' ){
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_disp'];
							} else {
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_sei'];
							}
*/
							if( $one_match['player2'] == 0 && $i1 < 6 ){
								$one_match['player2'] = $i1;
							}
/*
							$f = 'dantai_' . $series_mw . $one_match['player2'];
							$one_match['player2_name'] = $dantai_match['entry2'][$f.'_sei'] . ' '. $dantai_match['entry2'][$f.'_mei'];
							if( $dantai_match['entry2'][$f.'_disp'] != '' ){
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_disp'];
							} else {
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_sei'];
							}
*/
						} else {
							if( $i1 < 6 ){
								$one_match = array(
									'player1' => $i1,
									'player2' => $i1
								);
							} else {
								$one_match = array(
									'player1' => 0,
									'player2' => 0
								);
							}
						}
						$lv['match'][$no-1]['matches'][$i1] = $one_match;
					}
					if( $lv['match'][$no-1]['end_match'] == 5 ){
						$lv['end_match']++;
					}
				}
			}
			if( $lv['end_match'] < 3 ){
				for( $team = 0; $team < $team_num; $team++ ){
					$lv['team'][$team]['advanced'] = 0;
					$lv['team'][$team]['standing'] = 0;
					$lv['team'][$team]['point'] = 0;
					$lv['team'][$team]['win'] = 0;
					$lv['team'][$team]['hon'] = 0;
				}
				for( $i1 = 0; $i1 < $match_num; $i1++ ){
					if( $lv['match'][$i1]['end_match'] == 5 ){
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team1'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win1'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon1'];
								if( $lv['match'][$i1]['winner'] == 1 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
								break;
							}
						}
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team2'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win2'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon2'];
								if( $lv['match'][$i1]['winner'] == 2 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
								break;
							}
						}
					}
				}
			}
		}
		db_close( $dbs );
print_r($list);
		return $list;
	}

	function get_dantai_league_list( $series, $mw, $league_param )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
            $p = $this->extract_dantai_league_parameter( $league_param, $lv );
            $lv['match_info'] = $p['match_info'];
            $lv['place_match_info'] = $p['place_match_info'];
            $lv['chart_team_tbl'] = $p['chart_team_tbl'];
            $lv['chart_tbl'] = $p['chart_tbl'];
			$lv['end_match'] = 0;
			$lv['team'] = array();
			$team_num = intval( $lv['team_num'] );
			$match_num = intval( $lv['match_num'] );
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				$lv['team'][] = array( 'team'=>0, 'point'=>0, 'advanced'=>0, 'real_advanced'=>0, 'standing'=>0 );
			}
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.intval($lv['id']);
			$team = db_query_list( $dbs, $sql );
			foreach( $team as $tv ){
				$no = intval( $tv['league_team_index'] );
				if( $no > 0 && $no <= $team_num ){
					$lv['team'][$no-1]['team'] = intval( $tv['team'] );
					$lv['team'][$no-1]['advanced'] = intval( $tv['advanced'] );
					$lv['team'][$no-1]['real_advanced'] = intval( $tv['real_advanced'] );
					$lv['team'][$no-1]['standing'] = intval( $tv['standing'] );
					$lv['team'][$no-1]['point'] = intval( $tv['point'] );
					$lv['team'][$no-1]['win_match'] = intval( $tv['win_match'] );
					$lv['team'][$no-1]['lost_match'] = intval( $tv['lost_match'] );
					$lv['team'][$no-1]['win'] = intval( $tv['win'] );
					$lv['team'][$no-1]['lost'] = intval( $tv['lost'] );
					$lv['team'][$no-1]['hon'] = intval( $tv['hon'] );
				}
			}

			$lv['match'] = array();
			$match_num = intval( $lv['match_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
				$lv['match'][] = array( 'match'=>0, 'place'=>0, 'place_match_no'=>0, 'end_match'=>0 );
			}
			$sql = 'select `dantai_league_match`.`match` as `match`,'
				. ' `dantai_league_match`.`league_match_index` as `league_match_index`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_match`.`team1` as `team1`,'
				. ' `dantai_match`.`team2` as `team2`,'
				. ' `dantai_match`.`win1` as `win1`,'
				. ' `dantai_match`.`win2` as `win2`,'
				. ' `dantai_match`.`hon1` as `hon1`,'
				. ' `dantai_match`.`hon2` as `hon2`,'
				. ' `dantai_match`.`match1` as `match1`,'
				. ' `dantai_match`.`match2` as `match2`,'
				. ' `dantai_match`.`match3` as `match3`,'
				. ' `dantai_match`.`match4` as `match4`,'
				. ' `dantai_match`.`match5` as `match5`,'
				. ' `dantai_match`.`match6` as `match6`,'
				. ' `dantai_match`.`fusen` as `fusen`,'
				. ' `dantai_match`.`winner` as `winner`,'
				. ' `dantai_match`.`approval` as `approval`'
				. ' from `dantai_league_match` join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_league_match`.`del`=0 and `dantai_league_match`.`league`='.intval($lv['id']);
			$match = db_query_list( $dbs, $sql );
			foreach( $match as $mv ){
				$no = intval( $mv['league_match_index'] );
				if( $no > 0 && $no <= $match_num+$extra_match_num ){
					$lv['match'][$no-1] = $mv;
					//$lv['match'][$no-1]['match'] = intval( $mv['match'] );
					//$lv['match'][$no-1]['place'] = intval( $mv['place'] );
					//$lv['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
					//$lv['match'][$no-1]['win1'] = intval( $mv['win1'] );
					//$lv['match'][$no-1]['win2'] = intval( $mv['win2'] );
					//$lv['match'][$no-1]['hon1'] = intval( $mv['hon1'] );
					//$lv['match'][$no-1]['hon2'] = intval( $mv['hon2'] );
					//$lv['match'][$no-1]['winner'] = intval( $mv['winner'] );
					$lv['match'][$no-1]['matches'] = array();
					$lv['match'][$no-1]['end_match'] = 0;
					for( $i1 = 1; $i1 <= 6; $i1++ ){
						$match_id = get_field_string_number( $mv, 'match'.$i1, 0 );
						if( $match_id != 0 ){
							$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
							if( $i1 < 6 && $one_match['end_match'] == 1 ){
								$lv['match'][$no-1]['end_match']++;
							}
							if( $one_match['player1'] == 0 && $i1 < 6 ){
								$one_match['player1'] = $i1;
							}
/*
							$f = 'dantai_' . $mw . $one_match['player1'];
							$one_match['player1_name'] = $dantai_match['entry1'][$f.'_sei'] . ' '. $dantai_match['entry1'][$f.'_mei'];
							if( $dantai_match['entry1'][$f.'_disp'] != '' ){
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_disp'];
							} else {
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_sei'];
							}
*/
							if( $one_match['player2'] == 0 && $i1 < 6 ){
								$one_match['player2'] = $i1;
							}
/*
							$f = 'dantai_' . $series_mw . $one_match['player2'];
							$one_match['player2_name'] = $dantai_match['entry2'][$f.'_sei'] . ' '. $dantai_match['entry2'][$f.'_mei'];
							if( $dantai_match['entry2'][$f.'_disp'] != '' ){
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_disp'];
							} else {
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_sei'];
							}
*/
						} else {
							if( $i1 < 6 ){
								$one_match = array(
									'player1' => $i1,
									'player2' => $i1
								);
							} else {
								$one_match = array(
									'player1' => 0,
									'player2' => 0
								);
							}
						}
						$lv['match'][$no-1]['matches'][$i1] = $one_match;
					}
					if( $lv['match'][$no-1]['end_match'] == 5 ){
						$lv['end_match']++;
					}
				}
			}
			if( $lv['end_match'] < 3 ){
				for( $team = 0; $team < $team_num; $team++ ){
					$lv['team'][$team]['advanced'] = 0;
					$lv['team'][$team]['standing'] = 0;
					$lv['team'][$team]['point'] = 0;
					$lv['team'][$team]['win'] = 0;
					$lv['team'][$team]['hon'] = 0;
				}
				for( $i1 = 0; $i1 < $match_num; $i1++ ){
					if( $lv['match'][$i1]['end_match'] == 5 ){
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team1'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win1'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon1'];
								if( $lv['match'][$i1]['winner'] == 1 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
								break;
							}
						}
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team2'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win2'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon2'];
								if( $lv['match'][$i1]['winner'] == 2 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
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

	function get_dantai_league_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `id`='.$id;
//echo $sql;
		$list = db_query_list( $dbs, $sql );
        if( count( $list ) == 0 ){ return array(); }
        $lv = $list[0];
		$lv['end_match'] = 0;
		$lv['team'] = array();
		$team_num = intval( $lv['team_num'] );
		for( $i1 = 0; $i1 < $team_num; $i1++ ){
			$lv['team'][] = array( 'team'=>0, 'point'=>0, 'advanced'=>0, 'real_advanced'=>0, 'standing'=>0 );
		}
		$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.intval($lv['id']);
		$team = db_query_list( $dbs, $sql );
		foreach( $team as $tv ){
			$no = intval( $tv['league_team_index'] );
			if( $no > 0 && $no <= $team_num ){
				$lv['team'][$no-1]['team'] = intval( $tv['team'] );
				$lv['team'][$no-1]['advanced'] = intval( $tv['advanced'] );
				$lv['team'][$no-1]['real_advanced'] = intval( $tv['real_advanced'] );
				$lv['team'][$no-1]['standing'] = intval( $tv['standing'] );
				$lv['team'][$no-1]['point'] = intval( $tv['point'] );
				$lv['team'][$no-1]['win'] = intval( $tv['win'] );
				$lv['team'][$no-1]['hon'] = intval( $tv['hon'] );
			}
		}

		$lv['match'] = array();
		$match_num = intval( $lv['match_num'] );
		$extra_match_num = intval( $lv['extra_match_num'] );
		for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
			$lv['match'][] = array( 'match'=>0, 'place'=>0, 'place_match_no'=>0, 'end_match'=>0 );
		}
		$sql = 'select `dantai_league_match`.`match` as `match`,'
			. ' `dantai_league_match`.`league_match_index` as `league_match_index`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_match`.`team1` as `team1`,'
			. ' `dantai_match`.`team2` as `team2`,'
			. ' `dantai_match`.`win1` as `win1`,'
			. ' `dantai_match`.`win2` as `win2`,'
			. ' `dantai_match`.`hon1` as `hon1`,'
			. ' `dantai_match`.`hon2` as `hon2`,'
			. ' `dantai_match`.`match1` as `match1`,'
			. ' `dantai_match`.`match2` as `match2`,'
			. ' `dantai_match`.`match3` as `match3`,'
			. ' `dantai_match`.`match4` as `match4`,'
			. ' `dantai_match`.`match5` as `match5`,'
			. ' `dantai_match`.`match6` as `match6`,'
			. ' `dantai_match`.`fusen` as `fusen`,'
			. ' `dantai_match`.`winner` as `winner`'
			. ' from `dantai_league_match` join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league_match`.`del`=0 and `dantai_league_match`.`league`='.intval($lv['id']);
		$match = db_query_list( $dbs, $sql );
		foreach( $match as $mv ){
			$no = intval( $mv['league_match_index'] );
			if( $no > 0 && $no <= $match_num+$extra_match_num ){
				$lv['match'][$no-1] = $mv;
				$lv['match'][$no-1]['matches'] = array();
				$lv['match'][$no-1]['end_match'] = 0;
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$match_id = get_field_string_number( $mv, 'match'.$i1, 0 );
					if( $match_id != 0 ){
						$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
						if( $i1 < 6 && $one_match['end_match'] == 1 ){
							$lv['match'][$no-1]['end_match']++;
						}
						if( $one_match['player1'] == 0 && $i1 < 6 ){
							$one_match['player1'] = $i1;
						}
						if( $one_match['player2'] == 0 && $i1 < 6 ){
							$one_match['player2'] = $i1;
						}
					} else {
						if( $i1 < 6 ){
							$one_match = array(
								'player1' => $i1,
								'player2' => $i1
							);
						} else {
							$one_match = array(
								'player1' => 0,
								'player2' => 0
							);
						}
					}
					$lv['match'][$no-1]['matches'][$i1] = $one_match;
				}
				if( $lv['match'][$no-1]['end_match'] == 5 ){
					$lv['end_match']++;
				}
			}
		}
		if( $lv['end_match'] < 3 ){
			for( $team = 0; $team < $team_num; $team++ ){
				$lv['team'][$team]['advanced'] = 0;
				$lv['team'][$team]['standing'] = 0;
				$lv['team'][$team]['point'] = 0;
				$lv['team'][$team]['win'] = 0;
				$lv['team'][$team]['hon'] = 0;
			}
			for( $i1 = 0; $i1 < $match_num; $i1++ ){
				if( $lv['match'][$i1]['end_match'] == 5 ){
					for( $team = 0; $team < $team_num; $team++ ){
						if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team1'] ){
							$lv['team'][$team]['win'] += $lv['match'][$i1]['win1'];
							$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon1'];
							if( $lv['match'][$i1]['winner'] == 1 ){
								$lv['team'][$team]['point'] += 2;
							} else if( $lv['match'][$i1]['winner'] == 0 ){
								$lv['team'][$team]['point'] += 1;
							}
							break;
						}
					}
					for( $team = 0; $team < $team_num; $team++ ){
						if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team2'] ){
							$lv['team'][$team]['win'] += $lv['match'][$i1]['win2'];
							$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon2'];
							if( $lv['match'][$i1]['winner'] == 2 ){
								$lv['team'][$team]['point'] += 2;
							} else if( $lv['match'][$i1]['winner'] == 0 ){
								$lv['team'][$team]['point'] += 1;
							}
							break;
						}
					}
				}
			}
		}
		db_close( $dbs );
		return $lv;
	}

	function get_dantai_league_array_for_smarty( $series )
	{
		$data = array( 0 => '-' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$data[$lv['id']] = $lv['name'];
		}
		return $data;
	}

	function update_dantai_league_list( $series, $mw, $post )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$series_info = $this->get_dantai_league_parameter( $series );
//print_r($param);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$entry_member_data = array();
		if( $series == 1 ){
			$entry_member_field = 'dantai_m';
		} else {
			$entry_member_field = 'dantai_w';
		}
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$league_index = 1;
		foreach( $list as $lv ){
            $param = $this->extract_dantai_league_parameter( $series_info, $lv );
			$id = intval( $lv['id'] );
			$team_num = intval( $lv['team_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$id.' order by `id` asc';
			$team_list = db_query_list( $dbs, $sql );
			for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
				$update = false;
				$team = intval( $post['entry_'.$league_index.'_'.$team_index] );
				$advanced = 0;
				if( isset($post['advanced_'.$league_index.'_'.$team_index]) ){
					$advanced = intval( $post['advanced_'.$league_index.'_'.$team_index] );
				}
				foreach( $team_list as $tv ){
					$team_id = intval( $tv['id'] );
					$no = intval( $tv['league_team_index'] );
					if( $no == $team_index ){
						$sql = 'update `dantai_league_team` set `team`='.$team.',`real_advanced`='.$advanced.' where `id`='.$team_id;
//echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `dantai_league_team`'
						. ' set `league`='.$id.',`league_team_index`='.$team_index.',`team`='.$team.',`real_advanced`='.$advanced.',`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
/*
				$entry_member_one_data = array( 0, 0, 0, 0, 0 );
				if( $team > 0 ){
					$sql = 'select * from `entry` where `id`='.$team;
					$entry = db_query_list( $dbs, $sql );
					if( count($entry) >= 0 && get_field_string_number( $entry[0], $entry_member_field, 0 ) > 0 ){
						$sql = 'select * from `dantai_players` where `id`='.intval($entry[0][$entry_member_field]);
						$entry_member = db_query_list( $dbs, $sql );
						if( count($entry_member) > 0 ){
							$entry_member_one_data[0] = intval( $entry_member[0]['player1'] );
							$entry_member_one_data[1] = intval( $entry_member[0]['player2'] );
							$entry_member_one_data[2] = intval( $entry_member[0]['player3'] );
							$entry_member_one_data[3] = intval( $entry_member[0]['player4'] );
							$entry_member_one_data[4] = intval( $entry_member[0]['player5'] );
						}
					}
				}
				$entry_member_data[] = $entry_member_one_data;
*/
			}
			$match_num = intval( $lv['match_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
			for( $match_index = 1; $match_index <= $match_num+$extra_match_num; $match_index++ ){
                if( $match_index <= $match_num ){
    				$place = intval( $post['place_'.$league_index.'_'.$match_index] );
	    			$place_match_no = intval( $post['place_match_'.$league_index.'_'.$match_index] );
		    		$team1 = $param['match_info'][$match_index-1][0] + 1;
			    	$team2 = $param['match_info'][$match_index-1][1] + 1;
				    $team1_id = intval( $post['entry_'.$league_index.'_'.$team1] );
				    $team2_id = intval( $post['entry_'.$league_index.'_'.$team2] );
                } else {
    				$place = 0;
	    			$place_match_no = 0;
		    		$team1 = 0;
			    	$team2 = 0;
				    $team1_id = 0;
				    $team2_id = 0;
                }
				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$league_match_index = intval( $mv['league_match_index'] );
					if( $match_index == $league_match_index ){
                        if( $match_index <= $match_num ){
		    				$sql = 'select * from `dantai_match` where `id`='.$match_id;
			    			$dantai_match = db_query_list( $dbs, $sql );
				    		if( count($dantai_match) > 0 ){
					    		$sql = 'update `dantai_match`'
						    		. ' set `team1`='.$team1_id.','
							    	. '`team2`='.$team2_id.','
								    . '`place`='.$place.',`place_match_no`='.$place_match_no
    								. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
	    						db_query( $dbs, $sql );
    						}
                        }
						$update = true;
						break;
					}
				}
				if( !$update ){
					$matches = array();
					for( $i1 = 0; $i1 < 6; $i1++ ){
                        if( $i1 == 0 || $match_index <= $match_num ){
    						$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`player1_change_name`,`player2_change_name`,`match_time`,`create_date`,`update_date` ) VALUES ( 0, 0, \'\', \'\', \'\', NOW(), NOW() )';
//echo $sql,"<br />\n";
    						db_query( $dbs, $sql );
	    					$matches[] = db_query_insert_id( $dbs );
                        } else {
	    					$matches[] = 0;
                        }
					}
					$sql = 'insert `dantai_match`'
						. ' set `team1`='.$team1_id.','
							. '`team2`='.$team2_id.','
							. '`place`='.$place.',`place_match_no`='.$place_match_no.','
							. '`match1`=' . $matches[0] . ','
							. '`match2`=' . $matches[1] . ','
							. '`match3`=' . $matches[2] . ','
							. '`match4`=' . $matches[3] . ','
							. '`match5`=' . $matches[4] . ','
							. '`match6`=' . $matches[5] . ','
							. '`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$match_id = db_query_insert_id( $dbs );
					$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$extra_match_exists = get_field_string_number($post, 'extra_match_exists_'.$league_index, 0);
			$sql = 'update `dantai_league` set `extra_match_exists`=' . $extra_match_exists . ' where `id`=' . $id;
//echo $sql,"<br />\n";
			db_query( $dbs, $sql );
			$league_index++;
		}
		db_close( $dbs );
	}

    function load_dantai_league_csvdata( $series, $series_mw, $filename )
    {
        if( $filename == '' ){ return; }
        $file = new SplFileObject($filename);
        $file->setFlags( SplFileObject::READ_CSV );
        $filedata = array();
        $file_index = 0;
        foreach( $file as $line ){
            $filedata[$file_index] = array();
            foreach( $line as $lv ){
                $filedata[$file_index][] = $lv;
                //$filedata[$file_index][] = mb_convert_encoding( $lv, 'UTF-8', 'SJIS' );
            }
            $file_index++;
        }

        $serieslist = $this->__pageObj->get_series_list( $series );
        if( $serieslist === false ){ return; }
        if( $serieslist['dantai_league_m'] == $series || $serieslist['dantai_tournament_m'] == $series ){
            $f = 'dantai_m';
            //$this->load_dantai_league_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['dantai_league_w'] == $series || $serieslist['dantai_tournament_w'] == $series ){
            $f = 'dantai_w';
            //$this->load_dantai_league_entry_csv( $series, 'w', $file, $serieslist );
        } else {
            return;
        }
        $entry_num = $serieslist[$f.'_entry_num'];
        if( $entry_num == 0 ){ return; }
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		//$param = $this->get_dantai_league_parameter( $series );
		$entry_list = $this->__pageObj->get_entry_data_list( $series, $series_mw );
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$league_list = db_query_list( $dbs, $sql );
		$league_index = 1;
        $post = array();
        $file_index = 0;
        $team_name = array();
        foreach( $league_list as $lv ){
            $league_id = intval( $lv['id'] );
            $league_team_num = intval( $lv['team_num'] );
            $league_match_num = intval( $lv['match_num'] );
            $team_name[$league_index] = array();
            for( $league_team_index = 1; $league_team_index <= $league_team_num; $league_team_index++ ){
                $team_name[$league_index][$league_team_index] = '';
   				$post['entry_'.$league_index.'_'.$league_team_index] = 0;
                foreach( $entry_list as $ev ){
/*
				    if(
                        ( isset($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $ev['school_name'], $filedata[$file_index][0] ) !== false )
                        || ( isset($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== '' && mb_strpos( $ev['school_name_ryaku'], $filedata[$file_index][0] ) !== false )
                    ){
*/
				    if(
                        ( isset($ev['school_name']) && $ev['school_name'] !== '' && $ev['school_name'] == $filedata[$file_index][0] )
                        || ( isset($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== '' && $ev['school_name_ryaku'] == $filedata[$file_index][0] )
                    ){
	    				$post['entry_'.$league_index.'_'.$league_team_index] = $ev['id'];
                        $team_name[$league_index][$league_team_index] = $filedata[$file_index][0];
		    			break;
			    	}
                }
                $file_index++;
			}
            $league_index++;
        }
/*
		$league_index = 1;
        foreach( $league_list as $lv ){
            $league_team_num = intval( $lv['team_num'] );
            $league_match_num = intval( $lv['match_num'] );
            $match = 1;
            $match_tbl = array();
            for( $i1 = 1; $i1 < $league_team_num; $i1++ ){
                $match_tbl[$i1] = $match;
                $match += ( $league_team_num - $i1 );
            }
            for( $match_index = 1; $match_index <= $league_match_num; $match_index++ ){
                $post['place_'.$league_index.'_'.$match_index] = 0;
                $post['place_match_'.$league_index.'_'.$match_index] = 0;
            }
            for( $match_index = 1; $match_index <= $league_match_num; $match_index++ ){
                $team1 = 0;
                $team2 = 0;
                for( $league_team_index = 1; $league_team_index <= $league_team_num; $league_team_index++ ){
                    if( mb_strpos( $team_name[$league_index][$league_team_index], $filedata[$file_index][1] ) !== false ){
                        $team1 = $league_team_index;
                    } else if( mb_strpos( $team_name[$league_index][$league_team_index], $filedata[$file_index][2] ) !== false ){
                        $team2 = $league_team_index;
                    }
                    if( $team1 != 0 && $team2 != 0 ){ break; }
                }
                if( $team1 != 0 && $team2 != 0 ){
                    if( $team1 > $team2 ){
                        $i1 = $team1;
                        $team1 = $team2;
                        $team2 = $i1;
                    }
                    $match = $match_tbl[$team1] + ( $team2 - $team1 - 1 );
                    $place = explode( '-', $filedata[$file_index][0] );
                    $post['place_'.$league_index.'_'.$match] = intval( $place[0] );
                    $post['place_match_'.$league_index.'_'.$match] = intval( $place[1] );
                }
                $file_index++;
            }
            $league_index++;
            $team_index += $league_team_index;
        }
*/
//print_r($post);
//exit;
        return $post;
    }

	function load_dantai_league_list_csv( $series, $mw, $name )
	{
        $serieslist = $this->__pageObj->get_series_list( $series );
        if( $serieslist === false ){ return; }
        if( $serieslist['dantai_league_m'] == $series || $serieslist['dantai_tournament_m'] == $series ){
            $f = 'dantai_m';
            //$this->load_dantai_league_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['dantai_league_w'] == $series || $serieslist['dantai_tournament_w'] == $series ){
            $f = 'dantai_w';
            //$this->load_dantai_league_entry_csv( $series, 'w', $file, $serieslist );
        } else if( $serieslist['kojin_tournament_m'] == $series ){
            $f = 'kojin_m';
            //$this->load_kojin_tournament_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['kojin_tournament_w'] == $series ){
            $f = 'kojin_w';
            //$this->load_kojin_tournament_entry_csv( $series, 'w', $file, $serieslist );
        } else {
            return;
        }
        $entry_num = $serieslist[$f.'_entry_num'];
        if( $entry_num == 0 ){ return; }
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$entry_list = $this->__pageObj->get_entry_data_list( $series, $mw );
//print_r($entry_list);
		$league_index = 0;
		$league_id = intval( $list[$league_index]['id'] );
		$league_team_num = intval( $list[$league_index]['team_num'] );
        $league_team_index = 1;

        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );
        $file_index = 0;
        $school_names = array();
        foreach( $file as $line ){
            if( $file_index == $entry_num ){ break; }
            $school_names[] = mb_convert_encoding( $line[0], 'UTF-8', 'SJIS' );
            $file_index++;
        }
        foreach( $school_names as $school_name ){
            if( $league_team_index == 1 ){
                $sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$league_id.' order by `id` asc';
                $team_id_list = array();
                $team_list = db_query_list( $dbs, $sql );
            }
			$team = 0;
			foreach( $entry_list as $ev ){
				if(
                    ( isset($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $ev['school_name'], $school_name ) !== false )
                    || ( isset($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== '' && mb_strpos( $ev['school_name_ryaku'], $school_name ) !== false )
                ){
					$team = $ev['id'];
					break;
				}
			}
			$team_id_list[$league_team_index] = $team;
			$update = false;
			foreach( $team_list as $tv ){
				$team_id = intval( $tv['id'] );
				$no = intval( $tv['league_team_index'] );
				if( $no == $league_team_index ){
					$sql = 'update `dantai_league_team` set `team`='.$team.' where `id`='.$team_id;
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'insert into `dantai_league_team`'
					. ' set `league`='.$league_id.',`league_team_index`='.$league_team_index.',`team`='.$team.',`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
            if( $league_team_index == $league_team_num ){
    			$match_num = intval( $list[$league_index]['match_num'] );
	    		$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$league_id.' order by `id` asc';
		    	$match_list = db_query_list( $dbs, $sql );
			    for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
				    $team1 = $param['match_info'][$match_index-1][0] + 1;
				    $team2 = $param['match_info'][$match_index-1][1] + 1;
				    $team1_id = $team_id_list[$team1];
				    $team2_id = $team_id_list[$team2];
				    $update = false;
				    foreach( $match_list as $mv ){
 					    $match_id = intval( $mv['match'] );
					    $league_match_index = intval( $mv['league_match_index'] );
					    if( $match_index == $league_match_index ){
						    $sql = 'select * from `dantai_match` where `id`='.$match_id;
						    $dantai_match = db_query_list( $dbs, $sql );
						    if( count($dantai_match) > 0 ){
							    $sql = 'update `dantai_match`'
								    . ' set `team1`='.$team1_id.','
								    . '`team2`='.$team2_id
								    . ' where `id`='.$match_id;
echo $sql,"<br />\n";
							    db_query( $dbs, $sql );
        						$update = true;
						    }
	    					break;
		    			}
			    	}
				    if( !$update ){
					    $matches = array();
					    for( $i1 = 1; $i1 <= 6; $i1++ ){
                            if( $i1 == 6 ){
    						    $sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
                            } else {
    						    $sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( '.$i1.', '.$i1.', NOW(), NOW() )';
                            }
echo $sql,"<br />\n";
    						db_query( $dbs, $sql );
	    					$matches[] = db_query_insert_id( $dbs );
		    			}
			    		$sql = 'insert into `dantai_match`'
				    		. ' set `team1`='.$team1_id.','
					    		. '`team2`='.$team2_id.','
						    	. '`place`=0,`place_match_no`=0,'
    							. '`match1`=' . $matches[0] . ','
	    						. '`match2`=' . $matches[1] . ','
		    					. '`match3`=' . $matches[2] . ','
			    				. '`match4`=' . $matches[3] . ','
				    			. '`match5`=' . $matches[4] . ','
					    		. '`match6`=' . $matches[5] . ','
						    	. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
    					db_query( $dbs, $sql );
	    				$match_id = db_query_insert_id( $dbs );
		    			$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$league_id.','.$match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
			    		db_query( $dbs, $sql );
				    }
			    }
                $league_index++;
                if( $league_index == count( $list ) ){ break; }
                $league_id = intval( $list[$league_index]['id'] );
                $league_team_num = intval( $list[$league_index]['team_num'] );
                $league_team_index = 1;
            } else {
                $league_team_index++;
            }
            $file_index++;
		}
		db_close( $dbs );
	}

	function __get_dantai_league_one_result( $series, $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = array();
		$data['entry1'] = $this->get_entry_one_data2( 139 );
		$data['entry2'] = $this->get_entry_one_data2( 140 );
		return $data;
	}

	function get_dantai_league_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.*,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`'
			. ' from `dantai_league_match` inner join `dantai_league` on `dantai_league`.`id`=`dantai_league_match`.`league` where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
		$series = intval( $dantai_league_match[0]['series'] );
		$series_mw = $dantai_league_match[0]['series_mw'];
		$league = intval( $dantai_league_match[0]['league'] );
        $series_info = $this->get_series_list( $series );

		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$dantai_match['league'] = $league;
		$dantai_match['series'] = $series;
		$dantai_match['series_mw'] = $series_mw;
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player1'];
                } else {
                    $f = 'dantai_' . $series_mw . $one_match['player1'];
                }
                if( $one_match['player1'] == __PLAYER_NAME__ ){
                    $one_match['player1_name'] = $one_match['player1_change_name'];
                    $one_match['player1_name_ryaku'] = $one_match['player1_change_name'];
                } else {
                    $one_match['player1_name'] = $dantai_match['entry1'][$f.'_sei'] . ' '. $dantai_match['entry1'][$f.'_mei'];
                    if( $dantai_match['entry1'][$f.'_disp'] != '' ){
                        $one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_disp'];
                    } else {
                        $one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_sei'];
                    }
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player2'];
                } else {
                    $f = 'dantai_' . $series_mw . $one_match['player2'];
                }
                if( $one_match['player2'] == __PLAYER_NAME__ ){
                    $one_match['player2_name'] = $one_match['player2_change_name'];
                    $one_match['player2_name_ryaku'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $dantai_match['entry2'][$f.'_sei'] . ' '. $dantai_match['entry2'][$f.'_mei'];
                    if( $dantai_match['entry2'][$f.'_disp'] != '' ){
                        $one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_disp'];
                    } else {
                        $one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_sei'];
                    }
				}
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei']
					);
					if( $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player1_name_ryaku'] = $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player1_name_ryaku'] = $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'];
					}
					if( $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player2_name_ryaku'] = $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player2_name_ryaku'] = $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'];
					}
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player1_name_ryaku' => '',
						'player2' => 0,
						'player2_name' => '',
						'player2_name_ryaku' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}

	function update_dantai_league_one_result( $series, $league, $id, $list, $advance_num )
	{
//print_r($list);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$id );
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $data, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$list['p'][$i1]['faul1_1'].','
					. '`faul1_2`='.$list['p'][$i1]['faul1_2'].','
					. '`waza1_1`='.$list['p'][$i1]['waza1_1'].','
					. '`waza1_2`='.$list['p'][$i1]['waza1_2'].','
					. '`waza1_3`='.$list['p'][$i1]['waza1_3'].','
    				. '`player1`='.$list['p'][$i1]['player1'].','
	    			. '`player1_change_name`=\''.$list['p'][$i1]['player1_change_name'].'\','
					. '`faul2_1`='.$list['p'][$i1]['faul2_1'].','
					. '`faul2_2`='.$list['p'][$i1]['faul2_2'].','
					. '`waza2_1`='.$list['p'][$i1]['waza2_1'].','
					. '`waza2_2`='.$list['p'][$i1]['waza2_2'].','
					. '`waza2_3`='.$list['p'][$i1]['waza2_3'].','
    				. '`player2`='.$list['p'][$i1]['player2'].','
	    			. '`player2_change_name`=\''.$list['p'][$i1]['player2_change_name'].'\','
					. '`end_match`='.$list['p'][$i1]['end_match'].','
					. '`hon1`='.$list['hon1'][$i1].','
					. '`hon2`='.$list['hon2'][$i1].','
					. '`extra`='.$list['p'][$i1]['extra'].','
					. '`match_time`=\''.$list['p'][$i1]['match_time'].'\','
					. '`match_time_minute`=\''.$list['p'][$i1]['match_time_minute'].'\','
					. '`match_time_second`=\''.$list['p'][$i1]['match_time_second'].'\','
					. '`winner`='.$list['win'][$i1]
					. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
		}
		$sql = 'update `dantai_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner'].','
			. '`exist_match6`='.get_field_string_number( $list, 'exist_match6', 0 )
			. ' where `id`='.$id;
//echo $sql,"<br />\n";
		db_query( $dbs, $sql );

		$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$league.' order by `id` asc';
		$team_list = db_query_list( $dbs, $sql );
		for( $i1 = 0; $i1 < count($team_list); $i1++ ){
			$team_list[$i1]['point'] = 0;
			$team_list[$i1]['win_match'] = 0;
			$team_list[$i1]['lost_match'] = 0;
			$team_list[$i1]['draw_match'] = 0;
			$team_list[$i1]['win'] = 0;
			$team_list[$i1]['lost'] = 0;
			$team_list[$i1]['hon'] = 0;
			$team_list[$i1]['standing'] = $i1 + 1;
		}
		$exist_end = 0;
		$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$league.' order by `id` asc';
		$match_list = db_query_list( $dbs, $sql );
		foreach( $match_list as $mv ){
			$match_id = intval( $mv['match'] );
			if( $match_id == 0 ){ continue; }
			$sql = 'select * from `dantai_match` where `id`='.$match_id;
			$dantai_match = db_query_list( $dbs, $sql );
			if( count($dantai_match) == 0 ){ continue; }

			$endnum = 0;
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
				if( $match_id == 0 ){ continue; }
				$sql = 'select * from `one_match` where `id`='.$match_id;
				$one_match = db_query_list( $dbs, $sql );
				if( count($one_match) == 0 ){ continue; }
				if( get_field_string_number( $one_match[0], 'end_match', 0 ) == 1 ){
					$endnum++;
				}
			}
			if( $endnum < 5 ){ continue; }

			$exist_end = 1;
			$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
			$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
			$win1 = get_field_string_number( $dantai_match[0], 'win1', 0 );
			$win2 = get_field_string_number( $dantai_match[0], 'win2', 0 );
			$hon1 = get_field_string_number( $dantai_match[0], 'hon1', 0 );
			$hon2 = get_field_string_number( $dantai_match[0], 'hon2', 0 );
			$winner = get_field_string_number( $dantai_match[0], 'winner', 0 );
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
				if( $team_list[$i1]['team'] == $team1 ){
					if( $winner == 1 ){
						$team_list[$i1]['point'] += 2;
						$team_list[$i1]['win_match']++;
					} else if( $winner == 2 ){
						$team_list[$i1]['lost_match']++;
					} else if( $winner == 0 ){
						$team_list[$i1]['point'] += 1;
						$team_list[$i1]['draw_match']++;
					}
					$team_list[$i1]['win'] += $win1;
					$team_list[$i1]['lost'] += $win2;
					$team_list[$i1]['hon'] += $hon1;
				}
				if( $team_list[$i1]['team'] == $team2 ){
					if( $winner == 2 ){
						$team_list[$i1]['point'] += 2;
						$team_list[$i1]['win_match']++;
					} else if( $winner == 1 ){
						$team_list[$i1]['lost_match']++;
					} else if( $winner == 0 ){
						$team_list[$i1]['point'] += 1;
						$team_list[$i1]['draw_match']++;
					}
					$team_list[$i1]['win'] += $win2;
					$team_list[$i1]['lost'] += $win1;
					$team_list[$i1]['hon'] += $hon2;
				}
			}
		}

		if( $exist_end == 1 ){
			// 勝ち抜けチームの決定
			$sortlist = array();
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
				$sortlist[] = array(
					'team' => $i1,
					'point' => $team_list[$i1]['point'] * 10000 + $team_list[$i1]['win'] * 100 + $team_list[$i1]['hon']
				);
			}
			for( $i1 = 0; $i1 < count($team_list)-1; $i1++ ){
				for( $i2 = count($team_list)-1; $i2 > $i1; $i2-- ){
					if( $sortlist[$i2]['point'] > $sortlist[$i2-1]['point'] ){
						$t = $sortlist[$i2-1]['team'];
						$p = $sortlist[$i2-1]['point'];
						$sortlist[$i2-1]['team'] = $sortlist[$i2]['team'];
						$sortlist[$i2-1]['point'] = $sortlist[$i2]['point'];
						$sortlist[$i2]['team'] = $t;
						$sortlist[$i2]['point'] = $p;
					}
				}
			}
//print_r($sortlist);
            $last_standing = 1;
            $last_point = 0;
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
                if( $i1 == 0 ){
                    $last_point = $sortlist[$i1]['point'];
                    $last_standing = 1;
		    		$team_list[$sortlist[$i1]['team']]['standing'] = 1;
                    $standing = 1;
                } else {
                    if( $last_point == $sortlist[$i1]['point'] ){
    		    		$standing = $last_standing;
                    } else {
    		    		$standing = $i1 + 1;
                        $last_point = $sortlist[$i1]['point'];
                        $last_standing = $i1 + 1;
                    }
                }
	    		$team_list[$sortlist[$i1]['team']]['standing'] = $standing;
				if( $standing <= $advance_num ){
					$team_list[$sortlist[$i1]['team']]['advanced'] = 1;
				} else {
					$team_list[$sortlist[$i1]['team']]['advanced'] = 0;
				}
			}
/*
			if( $sortlist[0]['point'] == $sortlist[1]['point'] && $sortlist[1]['point'] == $sortlist[2]['point'] ){ // 1-1-1
				$team_list[$sortlist[0]['team']]['standing'] = 1;
				$team_list[$sortlist[1]['team']]['standing'] = 1;
				$team_list[$sortlist[2]['team']]['standing'] = 1;
				$team_list[$sortlist[0]['team']]['advanced'] = 1;
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
				$team_list[$sortlist[2]['team']]['advanced'] = 1;
			} else if( $sortlist[0]['point'] == $sortlist[1]['point'] ){ // 1-1-3
				$team_list[$sortlist[0]['team']]['standing'] = 1;
				$team_list[$sortlist[1]['team']]['standing'] = 1;
				$team_list[$sortlist[0]['team']]['advanced'] = 1;
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
			} else if( $sortlist[1]['point'] == $sortlist[2]['point'] ){ // 1-2-2
				$team_list[$sortlist[2]['team']]['standing'] = $team_list[$sortlist[1]['team']]['standing'];
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
				$team_list[$sortlist[2]['team']]['advanced'] = 1;
			}
*/
		}

		for( $i1 = 0; $i1 < count($team_list); $i1++ ){
			$sql = 'update `dantai_league_team`'
				. ' set `point`='.$team_list[$i1]['point'].','
					. '`win_match`='.$team_list[$i1]['win_match'].','
					. '`lost_match`='.$team_list[$i1]['lost_match'].','
					. '`draw_match`='.$team_list[$i1]['draw_match'].','
					. '`win`='.$team_list[$i1]['win'].','
					. '`lost`='.$team_list[$i1]['lost'].','
					. '`standing`='.$team_list[$i1]['standing'].','
					. '`advanced`='.$team_list[$i1]['advanced'].','
					. '`real_advanced`='.$team_list[$i1]['advanced'].','
					. '`hon`='.$team_list[$i1]['hon']
					. ' where `id`='.$team_list[$i1]['id'];
//echo $sql,"<br />\n";
			db_query( $dbs, $sql );
		}
		db_close( $dbs );
		return $data;
	}

	function update_dantai_league_one_result2( $series, $league, $id, $list, $advance_num )
	{
//print_r($list);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$id );
		for( $i1 = 1; $i1 <= 1; $i1++ ){
			$match_id = get_field_string_number( $data, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$list['p'][$i1]['faul1_1'].','
					. '`faul1_2`='.$list['p'][$i1]['faul1_2'].','
					. '`waza1_1`='.$list['p'][$i1]['waza1_1'].','
					. '`waza1_2`='.$list['p'][$i1]['waza1_2'].','
					. '`waza1_3`='.$list['p'][$i1]['waza1_3'].','
    				. '`player1`='.$list['p'][$i1]['player1'].','
	    			. '`player1_change_name`=\''.$list['p'][$i1]['player1_change_name'].'\','
					. '`faul2_1`='.$list['p'][$i1]['faul2_1'].','
					. '`faul2_2`='.$list['p'][$i1]['faul2_2'].','
					. '`waza2_1`='.$list['p'][$i1]['waza2_1'].','
					. '`waza2_2`='.$list['p'][$i1]['waza2_2'].','
					. '`waza2_3`='.$list['p'][$i1]['waza2_3'].','
    				. '`player2`='.$list['p'][$i1]['player2'].','
	    			. '`player2_change_name`=\''.$list['p'][$i1]['player2_change_name'].'\','
					. '`end_match`='.$list['p'][$i1]['end_match'].','
					. '`hon1`='.$list['hon1'][$i1].','
					. '`hon2`='.$list['hon2'][$i1].','
					. '`extra`='.$list['p'][$i1]['extra'].','
					. '`match_time`=\''.$list['p'][$i1]['match_time'].'\','
					. '`winner`='.$list['win'][$i1]
					. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
		}
		$sql = 'update `dantai_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner'].','
			. '`exist_match6`='.get_field_string_number( $list, 'exist_match6', 0 )
			. ' where `id`='.$id;
//echo $sql,"<br />\n";
		db_query( $dbs, $sql );

		db_close( $dbs );
		return $data;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_league_team_list()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league_team` where `del`=0';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	function get_dantai_league_team_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'dantai_league_team', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	function output_league_match_for_HTML( $match )
	{
		$data = $this->get_dantai_league_one_result( $match );
		return $this->__output_match_for_HTML( $data );
	}

	function output_one_league_match_for_HTML2( $match )
	{
echo $match.':'.date("H:i:s"),"\n";
		$data = $this->get_dantai_league_one_result( $match );
		return $this->output_one_match_for_HTML2( $data );
	}

//-------------------------------------------------------------------

	function output_league_for_HTML( $navi_info, $league_param, $league_list, $entry_list, $mw, $disp_match, $disp_pref=true, $return_path='index_%s%s', $disp_point=true )
	{
//echo $path;
//print_r($league_list);
        $mwstr = $navi_info['dantai_'.$mw.'_name'];
        if( $mwstr == '' ){
			if( $mw == 'm' ){
				$mwstr = '男子';
			} else if( $mw == 'w' ){
				$mwstr = '女子';
			} else {
				$mwstr = '';
			}
        }
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'リーグ表</title>'."\n";
		$header .= '<link href="preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		/*
		$header .= '<!--'."\n";
		$header .= print_r($league_list,true) . "\n";
		$header .= print_r($entry_list,true) . "\n";
		$header .= '-->'."\n";
		*/
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="'.sprintf($return_path,$navi_info['result_prefix'],$mw).'.html">←戻る</a></h2>'."\n";
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
		$footer .= '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = '';
        $tindex = 1;
		$html = $header . '    <h2>' . $mwstr . 'リーグ表</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_list[$league_data]['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			$match_num = intval( $league_list[$league_data]['match_num'] );
			$end_match_num = 0;
			for( $match_index=0; $match_index<$match_num; $match_index++ ){
				if(
					$league_list[$league_data]['match'][$match_index]['end_match'] >= 5
					|| $league_list[$league_data]['match'][$match_index]['fusen'] == 1
					|| $league_list[$league_data]['match'][$match_index]['place'] == 0
				){
					$end_match_num++;
				}
			}
//print_r($league_list);
			$html .= '    <table class="match_t" border="1" cellspacing="0" cellpadding="2">'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_name">'.$league_list[$league_data]['name'].'</td>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '        <td class="td_match">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						if( isset( $ev['school_name_ryaku'] ) ){
							$html .= $ev['school_name_ryaku'];
						} else if( isset( $ev['school_name'] ) ){
							$html .= $ev['school_name'];
						}
                        if( $disp_pref && isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
					}
				}
				$html .= '        </td>'."\n";
			}
			if( $disp_point ){
				$html .= '        <td class="td_score">得点</td>'."\n";
			} else {
				$html .= '        <td class="td_score">勝数</td>'."\n";
				$html .= '        <td class="td_score">負数</td>'."\n";
			}
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
						if( isset( $ev['school_name_ryaku'] ) ){
							$html .= $ev['school_name_ryaku'];
						} else if( isset( $ev['school_name'] ) ){
							$html .= $ev['school_name'];
						}
						if( $disp_pref && isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_list[$league_data]['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_no_index == 0 ){
						$html .= '        <td class="td_right">----</td>'."\n";
					} else if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if(
							$match_no_index > 0
							&& (
								$league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5
								|| $league_list[$league_data]['match'][$match_no_index-1]['fusen'] == 1
							)
						){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['fusen'] == 0 ){
								if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
									$html .= '  <span class="result-circle"></span>'."\n";
								} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
									$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
								} else {
									$html .= '  <span class="result-square"></span>'."\n";
								}
								$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon1'].'</div>'."\n";
								$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win1'].'</div>'."\n";
							}
							$html .= '</div>'."\n";
							//$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon1'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win1'];
						} else {
							$html .= '----';
						}
						$html .= '        </td>'."\n";
					} else {
						$html .= '        <td class="td_right">'."\n";
						if(
							$match_no_index > 0
							&& (
								$league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5
								|| $league_list[$league_data]['match'][$match_no_index-1]['fusen'] == 1
							)
						){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['fusen'] == 0 ){
								if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
									$html .= '  <span class="result-circle"></span>'."\n";
								} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==1 ){
									$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
								} else {
									$html .= '  <span class="result-square"></span>'."\n";
								}
//								$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon2'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win2'];
								$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon2'].'</div>'."\n";
								$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win2'].'</div>'."\n";
							}
							$html .= '</div>'."\n";
						} else {
							$html .= '----';
						}
						$html .= '        </td>'."\n";
					}
				}
				if( $disp_point ){
					$html .= '        <td class="td_right">'.($league_list[$league_data]['team'][$dantai_index_row]['point']/2).'</td>'."\n";
				} else {
					$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['win_match'].'</td>'."\n";
					$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['lost_match'].'</td>'."\n";
				}
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['win'].'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['hon'].'</td>'."\n";
				if( $end_match_num == $match_num ){
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
        if( $disp_match ){
            for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
				$html .= '    <h2>' . $mwstr . '団体リーグ結果</h2>'."\n";
    			$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第1試合</h3>';
	    		$html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][0], $entry_list, $mw );
		    	$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			    $html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][2], $entry_list, $mw );
			    $html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			    $html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][1], $entry_list, $mw );
    			$html .= '    <br />'."\n";
	    		$html .= '    <br />'."\n";
    		}
        }
		$html .= $footer;
        $file = 'dl_' . $navi_info['result_prefix'] . $mw . $tindex;
        $path = $navi_info['result_path'] . '/' . $file . '.html';
        $fp = fopen( $path, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
		$data = [
			'mode' => 2,
			'navi' => $navi_info['navi_id'],
			'place' => $file,
			'file' => $path,
			'series' => $navi_info['result_path_prefix'],
		];
		$this->__pageObj->update_realtime_queue( $data );
	}

	function output_league_match_for_HTML2( $navi_info, $league_param, $league_list, $entry_list, $mw, $div=false, $disp_time=false, $return_path='index_%s%s' )
	{
        $objMatch = new form_page_dantai_match( $this->__pageObj );
		$mwstr = $navi_info['dantai_'.$mw.'_name'];
		if( $mwstr == '' ){
		    if( $mw == 'm' ){
			    $mwstr = '男子';
            } else if( $mw == 'w' ){
			    $mwstr = '女子';
		    } else {
			    $mwstr = '';
		    }
	    }
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'リーグ結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="'.sprintf($return_path,$navi_info['result_prefix'],$mw).'.html">←戻る</a></h2>'."\n";
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
		$footer .= '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = $header . '    <h2>' . $mwstr . 'リーグ戦結果</h2>'."\n";
        $tindex = 1;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_num = intval( $league_list[$league_data]['match_num'] );
			$place_match_info_num = count( $league_list[$league_data]['place_match_info'] );
			//for( $match_index = 0; $match_index < count( $league_list[$league_data]['match'] ); $match_index++ ){
			for( $match_index = 0; $match_index < $match_num; $match_index++ ){
				if( $match_index >= $place_match_info_num ){ break; }
				$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第'.($match_index+1).'試合</h3>';
				//$html .= $this->__pageObj->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][$league_list[$league_data]['place_match_info'][$match_index]], $entry_list, $mw );
				$html .= $objMatch->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][$league_list[$league_data]['place_match_info'][$match_index]], $entry_list, $mw, 0, $disp_time );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][2], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][1], $entry_list, $mv );
			}
            if( $div ){
                $html .= $footer;
                $file = 'dlm_' . $navi_info['result_prefix'] . $mw . ($league_data+1);
                $path = $navi_info['result_path'] . '/' . $file . '.html';
		        $fp = fopen( $path, 'w' );
		        fwrite( $fp, $html );
		        fclose( $fp );
				$data = [
					'mode' => 2,
					'navi' => $navi_info['navi_id'],
					'place' => $file,
					'file' => $path,
					'series' => $navi_info['result_path_prefix'],
				];
				$this->__pageObj->update_realtime_queue( $data );
                $html = $header . '    <h2>' . $mwstr . 'リーグ戦結果</h2>'."\n";
            }
		}
        if( !$div ){
            $html .= $footer;
            $file = 'dlm_' . $navi_info['result_prefix'] . $mw . $tindex;
            $path = $navi_info['result_path'] . '/' . $file . '.html';
		    $fp = fopen( $path, 'w' );
		    fwrite( $fp, $html );
		    fclose( $fp );
			$data = [
				'mode' => 2,
				'navi' => $navi_info['navi_id'],
				'place' => $file,
				'file' => $path,
				'series' => $navi_info['result_path_prefix'],
			];
			$this->__pageObj->update_realtime_queue( $data );
		}
	}

	function output_league_for_Excel( $objPage, $path, $series_info, $league_list, $entry_list, $mw )
	{
//print_r($league_list);
        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_name = 'dl_' . $series_info['result_prefix'] . $mw . '.xls';
        $file_path = $path . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/leagueChartBase3.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '第13回 松代藩文武学校旗争奪全国中学校選抜剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　リーグ結果' );
		$col = 0;
		$row = 4;
		$colStr = 'Q';
		$param = get_league_parameter_5();
		$html = '';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*4+1, $row, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*4+1, $row+1, '('.$ev['school_address_pref_name'].')' );
					}
				}
			}
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+2, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+3, '('.$ev['school_address_pref_name'].')' );
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/cir.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/tri.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/squ.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/cir.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/tri.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/squ.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+3,
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
				$col += 18;
				$row = 4;
			} else {
				$row += 9;
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_match_for_excel( $objPage, $path, $series_info, $league_list, $entry_list, $mw )
	{
        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_name = 'dlm_' . $series_info['result_prefix'] . $mw . '.xls';
        $file_path = $path . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/leagueResultsBase3.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '第13回 松代藩文武学校旗争奪全国中学校選抜剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　リーグ結果' );
		$col = 0;
		$row = 5;
		$colStr = 'Q';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][0], $entry_list, $mw, 46, 42 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][2], $entry_list, $mw, 46, 42 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][1], $entry_list, $mw, 46, 42 );
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


}

