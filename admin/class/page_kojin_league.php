<?php

class form_page_kojin_league
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $this->__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_kojin_league_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `kojin_league_series` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            $list = $serieslist[0];
/**/
            $p = $this->extract_kojin_league_parameter( $list, null );
            $list['player_num'] = $p['player_num'];
            $list['match_num'] = $p['match_num'];
            $list['match_info_array'] = $p['match_info_array'];
            $list['match_info'] = $p['match_info'];
            $list['place_match_info_array'] = $p['place_match_info_array'];
            $list['place_match_info'] = $p['place_match_info'];
            $list['chart_player_tbl_array'] = $p['chart_player_tbl_array'];
            $list['chart_player_tbl'] = $p['chart_player_tbl'];
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

	function extract_kojin_league_parameter( $series_info, $league_info )
	{
        $lv = $series_info;
        if( !is_null( $league_info ) ){
            $lv['player_num'] = get_field_string( $league_info, 'player_num' );
            $lv['match_num'] = get_field_string( $league_info, 'match_num' );
        }
        $player_num = get_field_string_number( $lv, 'player_num', 0 );
        $match_num = get_field_string_number( $lv, 'match_num', 0 );

        $match_info_array = get_field_string( $series_info, 'match_info_array' );
        $match_info_array2 = get_field_string( $league_info, 'match_info_array' );
        $lv['match_info_array'] = ( $match_info_array2 != '' ) ? $match_info_array2 : $match_info_array;
        $m = explode( ',', $lv['match_info_array'] );
        $lv['match_info'] = array();
        if( count( $m ) > 0 ){
            $mindex = 0;
            for( $i1 = 0; $i1 < $player_num - 1; $i1++ ){
                for( $i2 = $i1+1; $i2 < $player_num; $i2++ ){
                    $lv['match_info'][] = array( intval( $m[$mindex] ), intval( $m[$mindex+1] ) );
                    $mindex += 2;
                }
            }
        } else {
            for( $i1 = 0; $i1 < $player_num - 1; $i1++ ){
                for( $i2 = $i1+1; $i2 < $player_num; $i2++ ){
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

        $chart_player_tbl_array = get_field_string( $series_info, 'chart_player_tbl_array' );
        $chart_player_tbl_array2 = get_field_string( $league_info, 'chart_player_tbl_array' );
        $lv['chart_player_tbl_array'] = ( $place_match_info_array2 != '' ) ? $chart_player_tbl_array2 : $chart_player_tbl_array;
        $m = explode( ',', $lv['chart_player_tbl_array'] );
        $lv['chart_player_tbl'] = array();
        $mindex = 0;
        for( $i1 = 0; $i1 < $player_num; $i1++ ){
 	        $chart_player_tbl = array();
            for( $i2 = 0; $i2 < $player_num; $i2++ ){
                if( count( $m ) > 0 ){
                    $chart_player_tbl[] = intval( $m[$mindex++] );
                } else {
                    if( $i1 == $i2 ){
                        $chart_player_tbl[] = 0;
                    } else {
                        if( $i1 < $i2 ){
                            $chart_player_tbl[] = 1;
                        } else {
                            $chart_player_tbl[] = 2;
                        }
                    }
                }
            }
  	    	$lv['chart_player_tbl'][] = $chart_player_tbl;
        }

        $chart_tbl_array = get_field_string( $series_info, 'chart_tbl_array' );
        $chart_tbl_array2 = get_field_string( $league_info, 'chart_tbl_array' );
        $lv['chart_tbl_array'] = ( $chart_tbl_array2 != '' ) ? $chart_tbl_array2 : $chart_tbl_array;
		$m = explode( ',', $lv['chart_tbl_array'] );
		$lv['chart_tbl'] = array();
        if( count( $m ) > 0 ){
            $mindex = 0;
            for( $i1 = 0; $i1 < $player_num; $i1++ ){
                $chart_tbl = array();
                for( $i2 = 0; $i2 < $player_num; $i2++ ){
                    $chart_tbl[] = intval( $m[$mindex++] );
                }
      	        $lv['chart_tbl'][] = $chart_tbl;
            }
        } else {
            for( $i1 = 0; $i1 < $player_num; $i1++ ){
                $chart_tbl = array();
                for( $i2 = 0; $i2 < $player_num; $i2++ ){
                    $chart_tbl[] = 0;
                }
  	    		$lv['chart_tbl'][] = $chart_tbl;
    	    	$lv['chart_player_tbl'][] = $chart_player_tbl;
            }
            $index = 1;
            for( $i1 = 0; $i1 < $player_num - 1; $i1++ ){
                for( $i2 = $i1 + 1; $i2 < $player_num; $i2++ ){
                    $lv['chart_tbl'][$i1][$i2] = $index;
                    $lv['chart_tbl'][$i2][$i1] = $index;
                    $index++;
                } 
            }
        }
        return $lv;
	}

	function make_new_kojin_league_list( $series, $mw )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_kojin_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `kojin_league` (`series`,`year`,`series_mw`,`name`,`player_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['player_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
			db_query( $dbs, $sql );
		}
/*
		$group_place = 1;
		$group_place_offset = 0;
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `kojin_league` (`series`,`year`,`series_mw`,`name`,`team_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['team_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
echo $sql,"<br />\n";
$group_id = $group_index;
			//db_query( $dbs, $sql );
			//$group_id = db_query_insert_id( $dbs );

			$teams = array();
			for( $team_index = 1; $team_index <= $param['team_num']; $team_index++ ){
				$sql = 'INSERT INTO `kojin_league_team` ( `league`,`league_team_index`,`team`,`create_date`,`update_date` ) VALUES ( '.$group_id.', '.$team_index.', 0, NOW(), NOW() )';
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
				$sql = 'insert `kojin_match`'
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

				$sql = 'INSERT INTO `kojin_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$group_id.','.$group_match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
				//db_query( $dbs, $sql );
			}
			$group_place_offset = ( $group_place_offset + 1 ) % 2;
			if( $group_place_offset == 0 ){ $group_place++; }
		}
*/
	}

	function get_kojin_league_list_( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$lv['end_match'] = 0;
			$lv['team'] = array();
			$team_num = intval( $lv['team_num'] );
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				$lv['team'][] = array( 'team'=>0, 'point'=>0, 'advanced'=>0, 'standing'=>0 );
			}
			$sql = 'select * from `kojin_league_player` where `del`=0 and `league`='.intval($lv['id']);
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
			$sql = 'select `kojin_league_match`.`match` as `match`,'
				. ' `kojin_league_match`.`league_match_index` as `league_match_index`,'
				. ' `kojin_match`.`place` as `place`,'
				. ' `kojin_match`.`place_match_no` as `place_match_no`,'
				. ' `kojin_match`.`team1` as `team1`,'
				. ' `kojin_match`.`team2` as `team2`,'
				. ' `kojin_match`.`win1` as `win1`,'
				. ' `kojin_match`.`win2` as `win2`,'
				. ' `kojin_match`.`hon1` as `hon1`,'
				. ' `kojin_match`.`hon2` as `hon2`,'
				. ' `kojin_match`.`match1` as `match1`,'
				. ' `kojin_match`.`match2` as `match2`,'
				. ' `kojin_match`.`match3` as `match3`,'
				. ' `kojin_match`.`match4` as `match4`,'
				. ' `kojin_match`.`match5` as `match5`,'
				. ' `kojin_match`.`match6` as `match6`,'
				. ' `kojin_match`.`fusen` as `fusen`,'
				. ' `kojin_match`.`winner` as `winner`'
				. ' from `kojin_league_match` join `kojin_match` on `kojin_league_match`.`match`=`kojin_match`.`id`'
				. ' where `kojin_league_match`.`del`=0 and `kojin_league_match`.`league`='.intval($lv['id']);
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
							$f = 'kojin_' . $mw . $one_match['player1'];
							$one_match['player1_name'] = $kojin_match['entry1'][$f.'_sei'] . ' '. $kojin_match['entry1'][$f.'_mei'];
							if( $kojin_match['entry1'][$f.'_disp'] != '' ){
								$one_match['player1_name_ryaku'] = $kojin_match['entry1'][$f.'_disp'];
							} else {
								$one_match['player1_name_ryaku'] = $kojin_match['entry1'][$f.'_sei'];
							}
*/
							if( $one_match['player2'] == 0 && $i1 < 6 ){
								$one_match['player2'] = $i1;
							}
/*
							$f = 'kojin_' . $series_mw . $one_match['player2'];
							$one_match['player2_name'] = $kojin_match['entry2'][$f.'_sei'] . ' '. $kojin_match['entry2'][$f.'_mei'];
							if( $kojin_match['entry2'][$f.'_disp'] != '' ){
								$one_match['player2_name_ryaku'] = $kojin_match['entry2'][$f.'_disp'];
							} else {
								$one_match['player2_name_ryaku'] = $kojin_match['entry2'][$f.'_sei'];
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

	function get_kojin_league_list( $series, $mw, $league_param )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
            $p = $this->extract_kojin_league_parameter( $league_param, $lv );
            $lv['match_info'] = $p['match_info'];
            $lv['place_match_info'] = $p['place_match_info'];
            $lv['chart_player_tbl'] = $p['chart_player_tbl'];
            $lv['chart_tbl'] = $p['chart_tbl'];
			$lv['end_match'] = 0;
			$lv['player'] = array();
			$player_num = intval( $lv['player_num'] );
			$match_num = intval( $lv['match_num'] );
			for( $i1 = 0; $i1 < $player_num; $i1++ ){
				$lv['player'][] = array( 'player'=>0, 'point'=>0, 'advanced'=>0, 'real_advanced'=>0, 'standing'=>0 );
			}
			$sql = 'select * from `kojin_league_player` where `del`=0 and `league`='.intval($lv['id']);
			$player = db_query_list( $dbs, $sql );
			foreach( $player as $tv ){
				$no = intval( $tv['league_player_index'] );
				if( $no > 0 && $no <= $player_num ){
					$lv['player'][$no-1]['player'] = intval( $tv['player'] );
					$lv['player'][$no-1]['advanced'] = intval( $tv['advanced'] );
					$lv['player'][$no-1]['real_advanced'] = intval( $tv['real_advanced'] );
					$lv['player'][$no-1]['standing'] = intval( $tv['standing'] );
					$lv['player'][$no-1]['point'] = intval( $tv['point'] );
					$lv['player'][$no-1]['win'] = intval( $tv['win'] );
					$lv['player'][$no-1]['hon'] = intval( $tv['hon'] );
				}
			}

			$lv['match'] = array();
			$match_num = intval( $lv['match_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
				$lv['match'][] = array( 'match'=>0, 'place'=>0, 'place_match_no'=>0, 'end_match'=>0 );
			}
			$sql = 'select `kojin_league_match`.`match` as `match`,'
				. ' `kojin_league_match`.`league_match_index` as `league_match_index`,'
				. ' `kojin_match`.`place` as `place`,'
				. ' `kojin_match`.`place_match_no` as `place_match_no`,'
				. ' `kojin_match`.`match` as `match`'
				. ' from `kojin_league_match` join `kojin_match` on `kojin_league_match`.`match`=`kojin_match`.`id`'
				. ' where `kojin_league_match`.`del`=0 and `kojin_league_match`.`league`='.intval($lv['id']);
			$match = db_query_list( $dbs, $sql );
			foreach( $match as $mv ){
				$no = intval( $mv['league_match_index'] );
				if( $no > 0 && $no <= $match_num+$extra_match_num ){
					$lv['match'][$no-1] = $mv;
					$lv['match'][$no-1]['match'] = array();
                    $match_id = get_field_string_number( $mv, 'match', 0 );
					if( $match_id != 0 ){
						$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
						$lv['match'][$no-1]['end_match'] = $one_match['end_match'];
					}
					$lv['match'][$no-1]['matche'] = $one_match;
                    if( $lv['match'][$no-1]['end_match'] == 1 ){
						$lv['end_match']++;
					}
				}
			}
			if( $lv['end_match'] < 3 ){
				for( $player = 0; $player < $player_num; $player++ ){
					$lv['player'][$player]['advanced'] = 0;
					$lv['player'][$player]['standing'] = 0;
					$lv['player'][$player]['point'] = 0;
					$lv['player'][$player]['win'] = 0;
					$lv['player'][$player]['hon'] = 0;
				}
				for( $i1 = 0; $i1 < $match_num; $i1++ ){
					if( $lv['match'][$i1]['end_match'] == 1 ){
						for( $player = 0; $player < $player_num; $player++ ){
							if( $lv['player'][$player]['player'] == $lv['match'][$i1]['player1'] ){
								$lv['player'][$player]['win'] += $lv['match'][$i1]['win1'];
								$lv['player'][$player]['hon'] += $lv['match'][$i1]['hon1'];
								if( $lv['match'][$i1]['winner'] == 1 ){
									$lv['player'][$player]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['player'][$player]['point'] += 1;
								}
								break;
							}
						}
						for( $player = 0; $player < $player_num; $player++ ){
							if( $lv['player'][$player]['player'] == $lv['match'][$i1]['player2'] ){
								$lv['player'][$player]['win'] += $lv['match'][$i1]['win2'];
								$lv['player'][$player]['hon'] += $lv['match'][$i1]['hon2'];
								if( $lv['match'][$i1]['winner'] == 2 ){
									$lv['player'][$player]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['player'][$player]['point'] += 1;
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

	function get_kojin_league_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `id`='.$id;
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
		$sql = 'select * from `kojin_league_team` where `del`=0 and `league`='.intval($lv['id']);
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
		$sql = 'select `kojin_league_match`.`match` as `match`,'
			. ' `kojin_league_match`.`league_match_index` as `league_match_index`,'
			. ' `kojin_match`.`place` as `place`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`,'
			. ' `kojin_match`.`team1` as `team1`,'
			. ' `kojin_match`.`team2` as `team2`,'
			. ' `kojin_match`.`win1` as `win1`,'
			. ' `kojin_match`.`win2` as `win2`,'
			. ' `kojin_match`.`hon1` as `hon1`,'
			. ' `kojin_match`.`hon2` as `hon2`,'
			. ' `kojin_match`.`match1` as `match1`,'
			. ' `kojin_match`.`match2` as `match2`,'
			. ' `kojin_match`.`match3` as `match3`,'
			. ' `kojin_match`.`match4` as `match4`,'
			. ' `kojin_match`.`match5` as `match5`,'
			. ' `kojin_match`.`match6` as `match6`,'
			. ' `kojin_match`.`fusen` as `fusen`,'
			. ' `kojin_match`.`winner` as `winner`'
			. ' from `kojin_league_match` join `kojin_match` on `kojin_league_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_league_match`.`del`=0 and `kojin_league_match`.`league`='.intval($lv['id']);
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

	function get_kojin_league_array_for_smarty( $series )
	{
		$data = array( 0 => '-' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$data[$lv['id']] = $lv['name'];
		}
		return $data;
	}

	function update_kojin_league_list( $series, $mw, $post )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$series_info = $this->get_kojin_league_parameter( $series );
//print_r($param);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$entry_member_data = array();
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$league_index = 1;
		foreach( $list as $lv ){
            $param = $this->extract_kojin_league_parameter( $series_info, $lv );
			$id = intval( $lv['id'] );
			$player_num = intval( $lv['player_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			$sql = 'select * from `kojin_league_player` where `del`=0 and `league`='.$id.' order by `id` asc';
			$player_list = db_query_list( $dbs, $sql );
			for( $player_index = 1; $player_index <= $player_num; $player_index++ ){
				$update = false;
				$player = intval( $post['entry_'.$league_index.'_'.$player_index] );
				$advanced = intval( $post['advanced_'.$league_index.'_'.$player_index] );
				foreach( $player_list as $tv ){
					$player_id = intval( $tv['id'] );
					$no = intval( $tv['league_player_index'] );
					if( $no == $player_index ){
						$sql = 'update `kojin_league_player` set `player`='.$player.',`real_advanced`='.$advanced.' where `id`='.$player_id;
//echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `kojin_league_player`'
						. ' set `league`='.$id.',`league_player_index`='.$player_index.',`player`='.$player.',`real_advanced`='.$advanced.',`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$match_num = intval( $lv['match_num'] );
			$extra_match_num = intval( $lv['extra_match_num'] );
			$sql = 'select * from `kojin_league_match` where `del`=0 and `league`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
			for( $match_index = 1; $match_index <= $match_num+$extra_match_num; $match_index++ ){
                if( $match_index <= $match_num ){
    				$place = intval( $post['place_'.$league_index.'_'.$match_index] );
	    			$place_match_no = intval( $post['place_match_'.$league_index.'_'.$match_index] );
		    		$player1 = $param['match_info'][$match_index-1][0] + 1;
			    	$player2 = $param['match_info'][$match_index-1][1] + 1;
				    $player1_id = intval( $post['entry_'.$league_index.'_'.$player1] );
				    $player2_id = intval( $post['entry_'.$league_index.'_'.$player2] );
                } else {
    				$place = 0;
	    			$place_match_no = 0;
		    		$player1 = 0;
			    	$player2 = 0;
				    $player1_id = 0;
				    $player2_id = 0;
                }
				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$league_match_index = intval( $mv['league_match_index'] );
					if( $match_index == $league_match_index ){
                        if( $match_index <= $match_num ){
		    				$sql = 'select * from `kojin_match` where `id`='.$match_id;
			    			$kojin_match = db_query_list( $dbs, $sql );
				    		if( count($kojin_match) > 0 ){
					    		$sql = 'update `kojin_match`'
						    		. ' set `place`='.$place.',`place_match_no`='.$place_match_no
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
					$matche = 0;
   					$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`player1_change_name`,`player2_change_name`,`match_time`,`create_date`,`update_date` ) VALUES ( 0, 0, \'\', \'\', \'\', NOW(), NOW() )';
//echo $sql,"<br />\n";
   					db_query( $dbs, $sql );
    				$match = db_query_insert_id( $dbs );
					$sql = 'insert `kojin_match`'
						. ' set `place`='.$place.',`place_match_no`='.$place_match_no.','
							. '`match`=' . $match . ','
							. '`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$match_id = db_query_insert_id( $dbs );
					$sql = 'INSERT INTO `kojin_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$sql = 'update `kojin_league` set `extra_match_exists`='.intval($post['extra_match_exists_'.$league_index]).' where `id`='.$id;
//echo $sql,"<br />\n";
			db_query( $dbs, $sql );
			$league_index++;
		}
		db_close( $dbs );
	}

    function load_kojin_league_csvdata( $series, $series_mw, $filename )
    {
        if( $filename == '' ){ return; }
        $file = new SplFileObject($filename);
        $file->setFlags( SplFileObject::READ_CSV );
        $filedata = array();
        $file_index = 0;
        foreach( $file as $line ){
            $filedata[$file_index] = array();
            foreach( $line as $lv ){
                $filedata[$file_index][] = mb_convert_encoding( $lv, 'UTF-8', 'SJIS' );
            }
            $file_index++;
        }

        $serieslist = $this->__pageObj->get_series_list( $series );
        if( $serieslist === false ){ return; }
        if( $serieslist['kojin_league_m'] == $series || $serieslist['kojin_tournament_m'] == $series ){
            $f = 'kojin_m';
            //$this->load_kojin_league_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['kojin_league_w'] == $series || $serieslist['kojin_tournament_w'] == $series ){
            $f = 'kojin_w';
            //$this->load_kojin_league_entry_csv( $series, 'w', $file, $serieslist );
        } else {
            return;
        }
        $entry_num = $serieslist[$f.'_entry_num'];
        if( $entry_num == 0 ){ return; }
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		//$param = $this->get_kojin_league_parameter( $series );
		$entry_list = $this->__pageObj->get_entry_data_list( $series, $series_mw );
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$league_list = db_query_list( $dbs, $sql );
		$league_index = 1;
        $post = array();
        $file_index = 0;
        $player_name = array();
        foreach( $league_list as $lv ){
            $league_id = intval( $lv['id'] );
            $league_player_num = intval( $lv['player_num'] );
            $league_match_num = intval( $lv['match_num'] );
            $player_name[$league_index] = array();
            for( $league_player_index = 1; $league_player_index <= $league_player_num; $league_player_index++ ){
                $player_name[$player_index] = '';
   				$post['entry_'.$league_index.'_'.$league_player_index] = 0;
                foreach( $entry_list as $ev ){
				    if(
                        ( isset($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $ev['school_name'], $filedata[$file_index][0] ) !== false )
                        || ( isset($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== '' && mb_strpos( $ev['school_name_ryaku'], $filedata[$file_index][0] ) !== false )
                    ){
	    				$post['entry_'.$league_index.'_'.$league_player_index] = $ev['id'];
                        $player_name[$league_index][$league_player_index] = $filedata[$file_index][0];
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

	function load_kojin_league_list_csv( $series, $mw, $name )
	{
        $serieslist = $this->__pageObj->get_series_list( $series );
        if( $serieslist === false ){ return; }
        if( $serieslist['kojin_league_m'] == $series || $serieslist['kojin_tournament_m'] == $series ){
            $f = 'kojin_m';
            //$this->load_kojin_league_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['kojin_league_w'] == $series || $serieslist['kojin_tournament_w'] == $series ){
            $f = 'kojin_w';
            //$this->load_kojin_league_entry_csv( $series, 'w', $file, $serieslist );
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
		$param = $this->get_kojin_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$entry_list = $this->__pageObj->get_entry_data_list( $series, $mw );
//print_r($entry_list);
		$league_index = 0;
		$league_id = intval( $list[$league_index]['id'] );
		$league_player_num = intval( $list[$league_index]['player_num'] );
        $league_player_index = 1;

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
            if( $league_player_index == 1 ){
                $sql = 'select * from `kojin_league_player` where `del`=0 and `league`='.$league_id.' order by `id` asc';
                $player_id_list = array();
                $player_list = db_query_list( $dbs, $sql );
            }
			$player = 0;
			foreach( $entry_list as $ev ){
				if(
                    ( isset($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $ev['school_name'], $school_name ) !== false )
                    || ( isset($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== '' && mb_strpos( $ev['school_name_ryaku'], $school_name ) !== false )
                ){
					$player = $ev['id'];
					break;
				}
			}
			$player_id_list[$league_player_index] = $player;
			$update = false;
			foreach( $player_list as $tv ){
				$player_id = intval( $tv['id'] );
				$no = intval( $tv['league_player_index'] );
				if( $no == $league_player_index ){
					$sql = 'update `kojin_league_player` set `player`='.$player.' where `id`='.$player_id;
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'insert into `kojin_league_player`'
					. ' set `league`='.$league_id.',`league_player_index`='.$league_player_index.',`player`='.$player.',`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
            if( $league_player_index == $league_player_num ){
    			$match_num = intval( $list[$league_index]['match_num'] );
	    		$sql = 'select * from `kojin_league_match` where `del`=0 and `league`='.$league_id.' order by `id` asc';
		    	$match_list = db_query_list( $dbs, $sql );
			    for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
				    $player1 = $param['match_info'][$match_index-1][0] + 1;
				    $player2 = $param['match_info'][$match_index-1][1] + 1;
				    $player1_id = $player_id_list[$player1];
				    $player2_id = $player_id_list[$player2];
				    $update = false;
				    foreach( $match_list as $mv ){
 					    $match_id = intval( $mv['match'] );
					    $league_match_index = intval( $mv['league_match_index'] );
					    if( $match_index == $league_match_index ){
						    $sql = 'select * from `kojin_match` where `id`='.$match_id;
						    $kojin_match = db_query_list( $dbs, $sql );
						    if( count($kojin_match) > 0 ){
							    $sql = 'update `kojin_match`'
								    . ' set `player1`='.$player1_id.','
								    . '`player2`='.$player2_id
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
			    		$sql = 'insert into `kojin_match`'
				    		. ' set `player1`='.$player1_id.','
					    		. '`player2`='.$player2_id.','
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
		    			$sql = 'INSERT INTO `kojin_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$league_id.','.$match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
			    		db_query( $dbs, $sql );
				    }
			    }
                $league_index++;
                if( $league_index == count( $list ) ){ break; }
                $league_id = intval( $list[$league_index]['id'] );
                $league_player_num = intval( $list[$league_index]['player_num'] );
                $league_player_index = 1;
            } else {
                $league_player_index++;
            }
            $file_index++;
		}
		db_close( $dbs );
	}

	function __get_kojin_league_one_result( $series, $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = array();
		$data['entry1'] = $this->get_entry_one_data2( 139 );
		$data['entry2'] = $this->get_entry_one_data2( 140 );
		return $data;
	}

	function get_kojin_league_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `kojin_league_match`.*,'
			. ' `kojin_league`.`series` as `series`,'
			. ' `kojin_league`.`series_mw` as `series_mw`'
			. ' from `kojin_league_match` inner join `kojin_league` on `kojin_league`.`id`=`kojin_league_match`.`league` where `kojin_league_match`.`match`='.$match;
		$kojin_league_match = db_query_list( $dbs, $sql );
		$series = intval( $kojin_league_match[0]['series'] );
		$series_mw = $kojin_league_match[0]['series_mw'];
		$league = intval( $kojin_league_match[0]['league'] );
        $series_info = $this->get_series_list( $series );

		$kojin_match = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$match );
		$kojin_match['league'] = $league;
		$kojin_match['series'] = $series;
		$kojin_match['series_mw'] = $series_mw;
		$kojin_match['entry1'] = $this->get_entry_one_data2( intval($kojin_match['player1']) );
		$kojin_match['entry2'] = $this->get_entry_one_data2( intval($kojin_match['player2']) );

		$kojin_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $kojin_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player1'];
                } else {
                    $f = 'kojin_' . $series_mw . $one_match['player1'];
                }
                if( $one_match['player1'] == __PLAYER_NAME__ ){
                    $one_match['player1_name'] = $one_match['player1_change_name'];
                    $one_match['player1_name_ryaku'] = $one_match['player1_change_name'];
                } else {
                    $one_match['player1_name'] = $kojin_match['entry1'][$f.'_sei'] . ' '. $kojin_match['entry1'][$f.'_mei'];
                    if( $kojin_match['entry1'][$f.'_disp'] != '' ){
                        $one_match['player1_name_ryaku'] = $kojin_match['entry1'][$f.'_disp'];
                    } else {
                        $one_match['player1_name_ryaku'] = $kojin_match['entry1'][$f.'_sei'];
                    }
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player2'];
                } else {
                    $f = 'kojin_' . $series_mw . $one_match['player2'];
                }
                if( $one_match['player2'] == __PLAYER_NAME__ ){
                    $one_match['player2_name'] = $one_match['player2_change_name'];
                    $one_match['player2_name_ryaku'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $kojin_match['entry2'][$f.'_sei'] . ' '. $kojin_match['entry2'][$f.'_mei'];
                    if( $kojin_match['entry2'][$f.'_disp'] != '' ){
                        $one_match['player2_name_ryaku'] = $kojin_match['entry2'][$f.'_disp'];
                    } else {
                        $one_match['player2_name_ryaku'] = $kojin_match['entry2'][$f.'_sei'];
                    }
				}
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_sei'] . ' '. $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_mei'],
						'player2' => $i1,
						'player2_name' => $kojin_match['entry2']['kojin_'.$series_mw.$i1.'_sei'] . ' '. $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_mei']
					);
					if( $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player1_name_ryaku'] = $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player1_name_ryaku'] = $kojin_match['entry1']['kojin_'.$series_mw.$i1.'_sei'];
					}
					if( $kojin_match['entry2']['kojin_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player2_name_ryaku'] = $kojin_match['entry2']['kojin_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player2_name_ryaku'] = $kojin_match['entry2']['kojin_'.$series_mw.$i1.'_sei'];
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
			$kojin_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($kojin_match);
		return $kojin_match;
	}

	function update_kojin_league_one_result( $series, $league, $id, $list, $advance_num )
	{
//print_r($list);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );
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
					. '`winner`='.$list['win'][$i1]
					. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
		}
		$sql = 'update `kojin_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner'].','
			. '`exist_match6`='.get_field_string_number( $list, 'exist_match6', 0 )
			. ' where `id`='.$id;
//echo $sql,"<br />\n";
		db_query( $dbs, $sql );

		$sql = 'select * from `kojin_league_player` where `del`=0 and `league`='.$league.' order by `id` asc';
		$player_list = db_query_list( $dbs, $sql );
		for( $i1 = 0; $i1 < count($player_list); $i1++ ){
			$player_list[$i1]['point'] = 0;
			$player_list[$i1]['win'] = 0;
			$player_list[$i1]['hon'] = 0;
			$player_list[$i1]['standing'] = $i1 + 1;
		}
		$exist_end = 0;
		$sql = 'select * from `kojin_league_match` where `del`=0 and `league`='.$league.' order by `id` asc';
		$match_list = db_query_list( $dbs, $sql );
		foreach( $match_list as $mv ){
			$match_id = intval( $mv['match'] );
			if( $match_id == 0 ){ continue; }
			$sql = 'select * from `kojin_match` where `id`='.$match_id;
			$kojin_match = db_query_list( $dbs, $sql );
			if( count($kojin_match) == 0 ){ continue; }

			$endnum = 0;
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$match_id = get_field_string_number( $kojin_match[0], 'match'.$i1, 0 );
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
			$player1 = get_field_string_number( $kojin_match[0], 'player1', 0 );
			$player2 = get_field_string_number( $kojin_match[0], 'player2', 0 );
			$win1 = get_field_string_number( $kojin_match[0], 'win1', 0 );
			$win2 = get_field_string_number( $kojin_match[0], 'win2', 0 );
			$hon1 = get_field_string_number( $kojin_match[0], 'hon1', 0 );
			$hon2 = get_field_string_number( $kojin_match[0], 'hon2', 0 );
			$winner = get_field_string_number( $kojin_match[0], 'winner', 0 );
			for( $i1 = 0; $i1 < count($player_list); $i1++ ){
				if( $player_list[$i1]['player'] == $player1 ){
					if( $winner == 1 ){
						$player_list[$i1]['point'] += 2;
					} else if( $winner == 0 ){
						$player_list[$i1]['point'] += 1;
					}
					$player_list[$i1]['win'] += $win1;
					$player_list[$i1]['hon'] += $hon1;
				}
				if( $player_list[$i1]['player'] == $player2 ){
					if( $winner == 2 ){
						$player_list[$i1]['point'] += 2;
					} else if( $winner == 0 ){
						$player_list[$i1]['point'] += 1;
					}
					$player_list[$i1]['win'] += $win2;
					$player_list[$i1]['hon'] += $hon2;
				}
			}
		}

		if( $exist_end == 1 ){
			$sortlist = array();
			for( $i1 = 0; $i1 < count($player_list); $i1++ ){
				$sortlist[] = array(
					'player' => $i1,
					'point' => $player_list[$i1]['point'] * 10000 + $player_list[$i1]['win'] * 100 + $player_list[$i1]['hon']
				);
			}
			for( $i1 = 0; $i1 < count($player_list)-1; $i1++ ){
				for( $i2 = count($player_list)-1; $i2 > $i1; $i2-- ){
					if( $sortlist[$i2]['point'] > $sortlist[$i2-1]['point'] ){
						$t = $sortlist[$i2-1]['player'];
						$p = $sortlist[$i2-1]['point'];
						$sortlist[$i2-1]['player'] = $sortlist[$i2]['player'];
						$sortlist[$i2-1]['point'] = $sortlist[$i2]['point'];
						$sortlist[$i2]['player'] = $t;
						$sortlist[$i2]['point'] = $p;
					}
				}
			}
//print_r($sortlist);
            $last_standing = 1;
            $last_point = 0;
			for( $i1 = 0; $i1 < count($player_list); $i1++ ){
                if( $i1 == 0 ){
                    $last_point = $sortlist[$i1]['point'];
                    $last_standing = 1;
		    		$player_list[$sortlist[$i1]['player']]['standing'] = 1;
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
	    		$player_list[$sortlist[$i1]['player']]['standing'] = $standing;
				if( $standing <= $advance_num ){
					$player_list[$sortlist[$i1]['player']]['advanced'] = 1;
				} else {
					$player_list[$sortlist[$i1]['player']]['advanced'] = 0;
				}
			}
/*
			if( $sortlist[0]['point'] == $sortlist[1]['point'] && $sortlist[1]['point'] == $sortlist[2]['point'] ){ // 1-1-1
				$player_list[$sortlist[0]['team']]['standing'] = 1;
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

		for( $i1 = 0; $i1 < count($player_list); $i1++ ){
			$sql = 'update `kojin_league_player`'
				. ' set `point`='.$player_list[$i1]['point'].','
					. '`win`='.$player_list[$i1]['win'].','
					. '`standing`='.$player_list[$i1]['standing'].','
					. '`advanced`='.$player_list[$i1]['advanced'].','
					. '`real_advanced`='.$player_list[$i1]['advanced'].','
					. '`hon`='.$player_list[$i1]['hon']
					. ' where `id`='.$player_list[$i1]['id'];
//echo $sql,"<br />\n";
			db_query( $dbs, $sql );
		}
		db_close( $dbs );
		return $data;
	}

	function update_kojin_league_one_result2( $series, $league, $id, $list, $advance_num )
	{
//print_r($list);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );
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
		$sql = 'update `kojin_match`'
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

	function get_kojin_league_player_list()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_league_player` where `del`=0';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	function get_kojin_league_player_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'kojin_league_player', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	function output_league_match_for_HTML( $match )
	{
		$data = $this->get_kojin_league_one_result( $match );
		return $this->__output_match_for_HTML( $data );
	}

	function output_one_league_match_for_HTML2( $match )
	{
echo $match.':'.date("H:i:s"),"\n";
		$data = $this->get_kojin_league_one_result( $match );
		return $this->output_one_match_for_HTML2( $data );
	}

//-------------------------------------------------------------------

	function output_league_for_HTML( $navi_info, $league_param, $league_list, $entry_list, $mw, $disp_match )
	{
//echo $path;
//print_r($league_list);
		if( $mw == 'm' ){
			$mwstr = '男子';
        } else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'団体リーグ表</title>'."\n";
		$header .= '<link href="preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$navi_info['result_prefix'].$mw.'.html">←戻る</a></h2>'."\n";
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
        $tindex = 1;
		$html = $header . '    <h2>' . $mwstr . '団体リーグ表</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_list[$league_data]['chart_tbl'];
			$player_num = intval( $league_list[$league_data]['player_num'] );
			$match_num = intval( $league_list[$league_data]['match_num'] );
			//print_r($match_tbl);
			$html .= '    <table class="match_t" border="1" cellspacing="0" cellpadding="2">'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_name">'.$league_list[$league_data]['name'].'</td>'."\n";
			for( $kojin_index_row=0; $kojin_index_row<$league_list[$league_data]['player_num']; $kojin_index_row++ ){
				$html .= '        <td class="td_match">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['player'][$kojin_index_row]['player'] == $ev['id'] ){
						//$html .= $ev['school_name_ryaku'] . '<br />(' . $ev['school_address_pref_name'] . ')';
						$html .= $ev['school_name'];
                        if( isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
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
			for( $kojin_index_row=0; $kojin_index_row<$league_list[$league_data]['player_num']; $kojin_index_row++ ){
				$html .= '      <tr>'."\n";
				$html .= '        <td class="td_right">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['player'][$kojin_index_row]['player'] == $ev['id'] ){
						//$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						//$html .= $ev['school_name'].'<br />('.$ev['school_address_pref_name'].')';
						$html .= $ev['school_name'];
                        if( isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
					}
				}
				$html .= '        </td>'."\n";
				for( $kojin_index_col=0; $kojin_index_col<$league_list[$league_data]['player_num']; $kojin_index_col++ ){
					$match_no_index = $match_tbl[$kojin_index_row][$kojin_index_col];
					$match_player_index = $league_list[$league_data]['chart_player_tbl'][$kojin_index_row][$kojin_index_col];
					if( $match_no_index == 0 ){
						$html .= '        <td class="td_right">----</td>'."\n";
					} else if( $match_player_index == 1 ){
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
				$html .= '        <td class="td_right">'.($league_list[$league_data]['player'][$kojin_index_row]['point']/2).'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['player'][$kojin_index_row]['win'].'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['player'][$kojin_index_row]['hon'].'</td>'."\n";
				if( $league_list[$league_data]['end_match'] == $match_num ){
					$html .= '        <td class="td_right" ';
					if( $league_list[$league_data]['player'][$kojin_index_row]['advanced'] == 1){
						$html .= 'bgcolor="#ffbbbb"';
					}
					$html .= '>' . $league_list[$league_data]['player'][$kojin_index_row]['standing'] . '</td>'."\n";
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
        $file = $navi_info['result_path'] . '/dl_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
        $fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_match_for_HTML2( $navi_info, $league_param, $league_list, $entry_list, $mw )
	{
        $objMatch = new form_page_kojin_match( $this->__pageObj );
		if( $mw == 'm' ){
			$mwstr = '男子';
        } else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'団体リーグ結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$mw.'.html">←戻る</a></h2>'."\n";
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

		$html = $header . '    <h2>' . $mwstr . '団体リーグ結果</h2>'."\n";
        $tindex = 1;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_num = intval( $league_list[$league_data]['match_num'] );
			//for( $match_index = 0; $match_index < count( $league_list[$league_data]['match'] ); $match_index++ ){
			for( $match_index = 0; $match_index < $match_num; $match_index++ ){
				$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第'.($match_index+1).'試合</h3>';
				$html .= $this->__pageObj->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][$league_list[$league_data]['place_match_info'][$match_index]], $entry_list, $mw );
				//$html .= $objMatch->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][$league_list[$league_data]['place_match_info'][$match_index]], $entry_list, $mw );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][2], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][1], $entry_list, $mv );
			}
		}
		$html .= $footer;
        $file = $navi_info['result_path'] . '/dlm_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
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
			$player_num = intval( $league_list[$league_data]['player_num'] );
			//print_r($match_tbl);
			for( $kojin_index_row=0; $kojin_index_row<$league_list[$league_data]['player_num']; $kojin_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['player'][$kojin_index_row]['player'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$kojin_index_row*4+1, $row, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col+$kojin_index_row*4+1, $row+1, '('.$ev['school_address_pref_name'].')' );
					}
				}
			}
			for( $kojin_index_row=0; $kojin_index_row<$league_list[$league_data]['player_num']; $kojin_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['player'][$kojin_index_row]['player'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						$sheet->setCellValueByColumnAndRow( $col, $row+$kojin_index_row*2+2, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col, $row+$kojin_index_row*2+3, '('.$ev['school_address_pref_name'].')' );
					}
				}
				$html .= '        </td>'."\n";
				for( $kojin_index_col=0; $kojin_index_col<$league_list[$league_data]['player_num']; $kojin_index_col++ ){
					$match_no_index = $match_tbl[$kojin_index_row][$kojin_index_col];
					$match_player_index = $param['chart_player_tbl'][$kojin_index_row][$kojin_index_col];
					if( $match_player_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$kojin_index_col*4+2, $row+$kojin_index_row*2+2 );
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
								$col+$kojin_index_col*4+2, $row+$kojin_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$kojin_index_col*4+2, $row+$kojin_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$kojin_index_col*4+2, $row+$kojin_index_row*2+2 );
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
								$col+$kojin_index_col*4+2, $row+$kojin_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$kojin_index_col*4+2, $row+$kojin_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
						}
					}
				}
				$sheet->setCellValueByColumnAndRow(
					$col+13, $row+$kojin_index_row*2+2,
					($league_list[$league_data]['player'][$kojin_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$col+14, $row+$kojin_index_row*2+2,
					$league_list[$league_data]['player'][$kojin_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+15, $row+$kojin_index_row*2+2,
					$league_list[$league_data]['player'][$kojin_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+16, $row+$kojin_index_row*2+2,
					$league_list[$league_data]['player'][$kojin_index_row]['standing']
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

