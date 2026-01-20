<?php

class form_page_dantai_tournament
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $this->__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_tournament_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `dantai_tournament_series` where `del`=0 and `series`='.$series;
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            return $serieslist[0];
        }
        $func = 'get_tournament_parameter_'.$series;
        return $func();
	}

	function make_new_dantai_tournament_list( $series, $mw )
	{
		//$func = 'get_tournament_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_tournament_parameter( $series );
        $series_mw = $param['mw'];
        if( $series_mw == '' ){ $series_mw = $mw; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
    		$sql = 'insert `dantai_tournament` (`series`,`year`,`series_mw`,`team_num`,`match_num`,`match_level`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$series_mw."',".$param['team_num'].','.$param['match_num'].','.$param['match_level'].','.$param['place_num'].',NOW(),NOW())';
	    	db_query( $dbs, $sql );
        }
	}

	function load_dantai_tournament_csvdata( $series, $series_mw, $filename )
	{
        if( $filename == '' ){ return; }
        $file = new SplFileObject($filename);
        $file->setFlags( SplFileObject::READ_CSV );
        $filedata = array();
        foreach( $file as $line ){
            $filedata[] = mb_convert_encoding( $line[0], 'UTF-8', 'SJIS' );
        }

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		$league_index = 1;
        $post = array();
        $file_index = 0;
        foreach( $list as $lv ){
            $league_id = intval( $lv['id'] );
            $team_num = intval( $lv['team_num'] );
            $match_num = intval( $lv['match_num'] );
            $extra_match_num = intval( $lv['extra_match_num'] );
            for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
   				$post['entry_'.$league_index.'_'.$team_index] = 0;
            }
            for( $match_index = 1; $match_index <= $match_num+$extra_match_num; $match_index++ ){
                $place = explode( '-', $filedata[$file_index] );
                $post['place_'.$league_index.'_'.$match_index] = intval( $place[0] );
                $post['place_match_'.$league_index.'_'.$match_index] = intval( $place[1] );
                $file_index++;
            }
            $league_index++;
        }
//print_r($post);
//exit;
        return $post;
    }

	function load_dantai_tournament_list_csv( $series, $mw, $file )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
        $series_mw = $param['mw'];
        if( $series_mw == '' ){ $series_mw = $mw; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$entry_list = $this->__pageObj->get_entry_data_list( $series, $mw );
//print_r($entry_list);
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );
        $file_index = 0;
        $school_names = array();
        foreach( $file as $line ){
            if( $file_index == $entry_num ){ break; }
            $school_names[] = mb_convert_encoding( $line[0], 'UTF-8', 'SJIS' );
            $file_index++;
        }

		$fp = fopen( $file, 'r' );
		$tournament_index = 1;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$team_num = intval( $lv['team_num'] );
			$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$id.' order by `id` asc';
			$team_id_list = array();
			$team_list = db_query_list( $dbs, $sql );
			for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
				$name = fgets( $fp );
//echo '[',$name,"]<br />\n";
				$team = 0;
                if( $name !== '' ){
    				foreach( $entry_list as $ev ){
                        if( $ev['del'] == 1 ){ continue; }
//print_r($ev);
//echo "<br />\n";
		    			if( ( !is_null($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $name, $ev['school_name'] ) !== false )
                            || ( !is_null($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== "" && mb_strpos( $name, $ev['school_name_ryaku'] ) !== false ) ){
				    		$team = $ev['id'];
					    	break;
    					}
                    }
				}
				$team_id_list[$team_index] = $team;
				$update = false;
				foreach( $team_list as $tv ){
					$team_id = intval( $tv['id'] );
					$no = intval( $tv['tournament_team_index'] );
					if( $no == $team_index ){
						$sql = 'update `dantai_tournament_team` set `team`='.$team.' where `id`='.$team_id;
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `dantai_tournament_team`'
						. ' set `tournament`='.$id.',`tournament_team_index`='.$team_index.',`team`='.$team.',`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}

			$match_num = intval( $lv['match_num'] );
			$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
            $id_index = 1;
			for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
                if( $match_index >= $team_num / 2 ){
    				$team1_id = $team_id_list[$id_index++];
	    			$team2_id = $team_id_list[$id_index++];
                } else {
    				$team1_id = 0;
	    			$team2_id = 0;
                }
				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$tournament_match_index = intval( $mv['tournament_match_index'] );
					if( $match_index == $tournament_match_index ){
						$sql = 'select * from `dantai_match` where `id`='.$match_id;
						$dantai_match = db_query_list( $dbs, $sql );
						if( count($dantai_match) > 0 ){
							$sql = 'update `dantai_match`'
								. ' set `team1`='.$team1_id.','
								. '`team2`='.$team2_id
								. ' where `id`='.$match_id;
echo $sql,"<br />\n";
							db_query( $dbs, $sql );
						}
						$update = true;
						break;
					}
				}
				if( !$update ){
					$matches = array();
					for( $i1 = 0; $i1 < 6; $i1++ ){
						$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$matches[] = db_query_insert_id( $dbs );
					}
					$sql = 'insert `dantai_match`'
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
					$sql = 'INSERT INTO `dantai_tournament_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$league_index++;
		}
		db_close( $dbs );
		fclose( $fp );
exit;
	}

	function get_dantai_tournament_data( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		//$data = db_get_one_data( $dbs, 'dantai_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'] );

		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$data ){
    		$data['team'] = array();
	    	$team_num = intval( $data['team_num'] );
			$data['team_num'] = $team_num;
		    for( $i1 = 0; $i1 < $team_num; $i1++ ){
			    $data['team'][] = array( 'id'=>0, 'name'=>'' );
    		}
	    	$sql = 'select `dantai_tournament_team`.`team` as `team`,'
		    	. ' `dantai_tournament_team`.`tournament_team_index` as `tournament_team_index`,'
			    . ' `e1`.`data` as `school_name`,'
    			. ' `e2`.`data` as `school_name_ryaku`'
	    		. ' from `dantai_tournament_team` join `entry_field` as `e1` on `dantai_tournament_team`.`team`=`e1`.`info` and `e1`.`field`=\'school_name\''
		    	. ' left join `entry_field` as `e2` on `dantai_tournament_team`.`team`=`e2`.`info` and `e2`.`field`=\'school_name_ryaku\''
			    . ' where `dantai_tournament_team`.`del`=0'
				    . ' and `dantai_tournament_team`.`tournament`='.intval($data['id']);
		    $team = db_query_list( $dbs, $sql );
		    foreach( $team as $tv ){
			    $no = intval( $tv['tournament_team_index'] );
			    if( $no > 0 && $no <= $team_num ){
				    $data['team'][$no-1]['id'] = intval( $tv['team'] );
    				if( !is_null($tv['school_name_ryaku']) && $tv['school_name_ryaku'] != '' ){
	    				$data['team'][$no-1]['name'] = $tv['school_name_ryaku'];
		    		} else {
			    		$data['team'][$no-1]['name'] = $tv['school_name'];
				    }
    			}
	    	}

    		$data['match'] = array();
	    	$match_num = intval( $data['match_num'] );
		    $extra_match_num = intval( $data['extra_match_num'] );
	    	$data['match_num'] = $match_num;
	    	$data['extra_match_num'] = $extra_match_num;
    		for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
	    		$data['match'][] = array(
                    'match' => 0,
					'place' => 0,
					'place_match_no' => 0,
					'team1' => 0,
			    	'team1_name' => '',
				    'team2' => 0,
    				'team2_name' => '',
			    	'win1' => 0, 'hon1' => 0, 'win2' => 0, 'hon2' => 0, 
				    'winner' => 0, 'fusen' => 0, 'dantai_tournament_match_id' => 0
                );
	    	}
		    $sql = 'select `dantai_tournament_match`.`match` as `match`,'
    			. ' `dantai_tournament_match`.`tournament_match_index` as `tournament_match_index`,'
	    		. ' `dantai_tournament_match`.`no_match` as `no_match`,'
		    	. ' `dantai_tournament_match`.`id` as `dantai_tournament_match_id`,'
			    . ' `dantai_match`.`place` as `place`,'
    			. ' `dantai_match`.`place_match_no` as `place_match_no`'
	    		. ' from `dantai_tournament_match` join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
		    	. ' where `dantai_tournament_match`.`del`=0 and `dantai_tournament_match`.`tournament`='.intval($data['id']);
    		$match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($match);
	    	foreach( $match as $mv ){
		    	$no = intval( $mv['tournament_match_index'] );
			    if( $no > 0 && $no <= $match_num+$extra_match_num ){
				    $data['match'][$no-1]['match'] = intval( $mv['match'] );
    				if( intval( $mv['no_match'] ) == 1 ){
	    				$data['match'][$no-1]['place'] = 'no_match';
		    		} else {
			    		$data['match'][$no-1]['place'] = intval( $mv['place'] );
				    }
    				$data['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
	    			$data['match'][$no-1]['dantai_tournament_match_id'] = intval( $mv['dantai_tournament_match_id'] );
		    		$data['match'][$no-1]['team1'] = 0;
			    	$data['match'][$no-1]['team1_name'] = '';
				    $data['match'][$no-1]['team2'] = 0;
    				$data['match'][$no-1]['team2_name'] = '';
	    			$data['match'][$no-1]['winner'] = 0;
		    		$data['match'][$no-1]['win1'] = 0;
			    	$data['match'][$no-1]['win2'] = 0;
				    $data['match'][$no-1]['hon1'] = 0;
				    $data['match'][$no-1]['hon2'] = 0;
				    $data['match'][$no-1]['exist_match6'] = 0;
				    $data['match'][$no-1]['approval'] = 0;
				    if( $data['match'][$no-1]['match'] > 0 ){
					    $sql = 'select * from `dantai_match` where `id`='.$data['match'][$no-1]['match'];
					    $dantai_match = db_query_list( $dbs, $sql );
    					if( count($dantai_match) > 0 ){
						    $data['match'][$no-1]['team1'] = get_field_string_number( $dantai_match[0], 'team1', 0 );
    						$data['match'][$no-1]['team2'] = get_field_string_number( $dantai_match[0], 'team2', 0 );
    						$data['match'][$no-1]['winner'] = get_field_string_number( $dantai_match[0], 'winner', 0 );
    						$data['match'][$no-1]['win1'] = get_field_string_number( $dantai_match[0], 'win1', 0 );
    						$data['match'][$no-1]['win2'] = get_field_string_number( $dantai_match[0], 'win2', 0 );
    						$data['match'][$no-1]['hon1'] = get_field_string_number( $dantai_match[0], 'hon1', 0 );
    						$data['match'][$no-1]['hon2'] = get_field_string_number( $dantai_match[0], 'hon2', 0 );
    						$data['match'][$no-1]['fusen'] = get_field_string_number( $dantai_match[0], 'fusen', 0 );
    						$data['match'][$no-1]['exist_match6'] = get_field_string_number( $dantai_match[0], 'exist_match6', 0 );
							$data['match'][$no-1]['approval'] = get_field_string_number( $dantai_match[0], 'approval', 0 );
	    					$data['match'][$no-1]['matches'] = array();
    						for( $i1 = 1; $i1 <= 6; $i1++ ){
    							$match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
    							if( $match_id != 0 ){
    								$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
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
    							$data['match'][$no-1]['matches'][$i1] = $one_match;
    						}

    						$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
    						if( $team1 > 0 ){
    							foreach( $data['team'] as $tv ){
    								if( $tv['id'] == $team1 ){
    									$data['match'][$no-1]['team1_name'] = $tv['name'];
    									break;
    								}
    							}
    						}
    						$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
    						if( $team2 > 0 ){
    							foreach( $data['team'] as $tv ){
    								if( $tv['id'] == $team2 ){
    									$data['match'][$no-1]['team2_name'] = $tv['name'];
    									break;
    								}
    							}
    						}
    					}
    				}
    			}
    		}

    		$match_level = intval( $data['match_level'] );
    		$offset = 1;
    		$match_offset = array();
    		for( $i1 = 1; $i1 <= $match_level; $i1++ ){
    			$match_offset[$match_level-$i1] = $offset;
    			$offset *= 2;
    		}
    		$data['match_array'] = array();
    		for( $i1 = 0; $i1 < $team_num; $i1++ ){
    			$match_no = 2;
    			$match_row = array();
    			for( $i2 = 0; $i2 < $match_level; $i2++ ){
    				if( ( $i1 % $match_no ) == $match_no / 2 - 1 ){
    					$match_row[] = $match_offset[$i2];
    					$match_offset[$i2]++;
    				} else if( ( $i1 % $match_no ) == $match_no / 2 ){
    					$match_row[] = -1;
    				} else {
    					$value = 0;
    					if( $i2 > 0 ){
    						if( ( $i1 % $match_no ) == $match_no / 2 - 2 ){
    							$value = $match_offset[$i2] + 1000;
    						}
    						if( ( $i1 % $match_no ) == $match_no / 2 + 1 ){
    							$value = $match_offset[$i2] - 1 + 2000;
    						}
    					}
    					$match_row[] = $value;
    				}
    				$match_no *= 2;
    			}
    			$data['match_array'][] = $match_row;
    		}
        }
//print_r($list);
   		db_close( $dbs );
		return $list;
	}

	function update_dantai_tournament_one_data( $series, $part, $mw, $post, $data, $dbs )
	{
		global $__dantai_league_team_last_match__;

		$tournament_id = intval( $data['id'] );

		$team_num = intval( $data['team_num'] );
		$team_id_list = array();
		$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$tournament_id;
		$dantai_tournament_team = db_query_list( $dbs, $sql );
		for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
			$update = false;
			$team = intval( $post['entry_'.$part.'_'.$team_index] );
			foreach( $dantai_tournament_team as $tv ){
				$tournament_team_id = intval( $tv['id'] );
				$tournament_team_index = intval( $tv['tournament_team_index'] );
				if( $team_index == $tournament_team_index ){
					$sql = 'update `dantai_tournament_team` set `team`='.$team.' where `id`='.$tournament_team_id;
//echo ' 1:',$sql,"<br />\n";
					db_query( $dbs, $sql );
					$team_id_list[$team_index] = $team;
					$update = true;
					break;
				}
			}
			if( $update == false ){
				$sql = 'insert into `dantai_tournament_team`'
					.' set `tournament`='.$tournament_id.','
					.' `tournament_team_index`='.$team_index.','
					.' `team`='.$team.', `create_date`=NOW(), `update_date`=NOW()';
//echo '1:',$sql,"<br />\n";
				db_query( $dbs, $sql );
				$team_id_list[$team_index] = $team;
			}
		}

		$match_num = intval( $data['match_num'] );
		$extra_match_num = intval( $data['extra_match_num'] );
		$match_level = intval( $data['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}
        $last = $this->get_dantai_league_team_last_match_data( $series, $mw );
        $dantai_league_team_last_match = array();
		foreach( $last as $lav ){
			if( $lav['match_index'] == 1 ){
				$dantai_league_team_last_match[$lav['team1']] = array( $lav['match'], 1 );
				$dantai_league_team_last_match[$lav['team2']] = array( $lav['match'], 2 );
			} else if( $lav['match_index'] == 3 ){
				$dantai_league_team_last_match[$lav['team2']] = array( $lav['match'], 2 );
			}
		}
//print_r($dantai_league_team_last_match);

		$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$tournament_id;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		for( $match_index = 1; $match_index <= $match_num+$extra_match_num; $match_index++ ){
			if( $post['place_'.$part.'_'.$match_index] == 'no_match' ){
				$place = 0;
				$place_match_no = 0;
				$no_match = 1;
			} else {
				$place = intval( $post['place_'.$part.'_'.$match_index] );
				$place_match_no = intval( $post['place_match_'.$part.'_'.$match_index] );
				$no_match = 0;
			}
			if( $match_index >= $macth1_level && $match_index <= $match_num ){
				$team_sql = ', `team1`=' . $team_id_list[($match_index-$macth1_level)*2+1]
						. ', `team2`=' . $team_id_list[($match_index-$macth1_level)*2+2];
			} else {
				$team_sql = '';
			}
			$dantai_tournament_match_id = 0;
			$dantai_tournament_match_data = array();
			$match_id = 0;
			foreach( $dantai_tournament_match as $mv ){
				if( $match_index == intval( $mv['tournament_match_index'] ) ){
					$dantai_tournament_match_data = $mv;
					$dantai_tournament_match_id = intval( $mv['id'] );
					$match_id = intval( $mv['match'] );
					break;
				}
			}
			if( $match_id > 0 ){
				$sql = 'select * from `dantai_match` where `id`='.$match_id;
				$dantai_match = db_query_list( $dbs, $sql );
			}
			if( $match_id > 0 && count($dantai_match) > 0 ){
				$match_in_num = 0;
				$sql = '';
				$matches = array();
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$one_match_id = intval( $dantai_match[0]['match'.$i1] );
					if( $one_match_id > 0 ){
						$match_in_num++;
						if( $match_in_num > 1 ){ $sql .= ','; }
						$sql .= $one_match_id;
					} else {
						$matches['match'.$i1] = 0;
					}
				}
				$sql = 'select * from `one_match` where `id` in (' . $sql . ')';
				$dantai_one_matches = db_query_list( $dbs, $sql );
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$one_match_id = intval( $dantai_match[0]['match'.$i1] );
					$in_id = 0;
					foreach( $dantai_one_matches as $omv ){
						if( intval($omv['id']) == $one_match_id ){
							$in_id = 1;
							break;
						}
					}
					if( $in_id == 0 ){
						if( $i1 == 6 ){
							$matches['match'.$i1] = 0;
						} else {
							$matches['match'.$i1] = $i1;
						}
					}
				}
			} else {
				$matches = array();
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					if( $i1 == 6 ){
						$matches['match'.$i1] = 0;
					} else {
						$matches['match'.$i1] = $i1;
					}
				}
				$match_id = 0;
			}
			$match_sql = '';
			foreach( $matches as $k => $v ){
				$sql = 'insert into `one_match` ( `player1`,`player2`,`match_time`,`create_date`,`update_date` ) VALUES ( '.$v.', '.$v.', \'\', NOW(), NOW() )';
//echo print_r($matches,TRUE),"\n";
//echo $sql,"\n";
				db_query( $dbs, $sql );
				$matches[$k] = db_query_insert_id( $dbs );
				$match_sql .= ( ',' . $k . '=' . $matches[$k] );
			}
			if( $match_id > 0 ){
				$sql = 'update `dantai_match`'
					. ' set `place`='.$place.',`place_match_no`='.$place_match_no
					. ',`update_date`=NOW()'
					. $match_sql . $team_sql
					. ' where `id`='.$match_id;
//echo $sql,"\n";
				db_query( $dbs, $sql );
			} else {
				$sql = 'insert into `dantai_match`'
					. ' set `place`='.$place.',`place_match_no`='.$place_match_no.','
					. '`create_date`=NOW(),`update_date`=NOW()'
					. $match_sql . $team_sql;
//echo $sql,"\n";
				db_query( $dbs, $sql );
				$match_id = db_query_insert_id( $dbs );
			}

// 選手入れ替え対応
/**/
			if( $match_index >= $macth1_level ){
				$sql = 'select * from `dantai_match` where `id`='.$match_id;
				$dantai_match = db_query_list( $dbs, $sql );
				$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
				$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
//echo '<!-- ',print_r($dantai_match,TRUE)," -->\n";
				if( $team1 != 0 && $team2 != 0 ){
					$sql = 'select * from `dantai_match` where `id`='.$dantai_league_team_last_match[$team1][0];
					$dantai_match_team1 = db_query_list( $dbs, $sql );
//echo '<!-- ',$sql," -->\n";
//echo '<!-- ',print_r($dantai_match_team1,TRUE)," -->\n";
					$sql = 'select * from `dantai_match` where `id`='.$dantai_league_team_last_match[$team2][0];
					$dantai_match_team2 = db_query_list( $dbs, $sql );
//echo '<!-- ',$sql," -->\n";
//echo '<!-- ',print_r($dantai_match_team2,TRUE)," -->\n";
					for( $i1 = 1; $i1 <= 5; $i1++ ){
						$one_match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
						$one_match_id_team1 = get_field_string_number( $dantai_match_team1[0], 'match'.$i1, 0 );
						$one_match_id_team2 = get_field_string_number( $dantai_match_team2[0], 'match'.$i1, 0 );
						if( $one_match_id != 0 ){
							$sql = 'select * from `one_match` where `id`='.$one_match_id_team1;
							$one_match_team1 = db_query_list( $dbs, $sql );
							$sql = 'select * from `one_match` where `id`='.$one_match_id_team2;
							$one_match_team2 = db_query_list( $dbs, $sql );
							$sql = 'update `one_match`'
								. ' set `player1`='.$one_match_team1[0]['player'.$dantai_league_team_last_match[$team1][1]].','
								. "`player1_change_name`='".$one_match_team1[0]['player'.$dantai_league_team_last_match[$team1][1].'_change_name']."',"
								. '`player2`='.$one_match_team2[0]['player'.$dantai_league_team_last_match[$team2][1]].','
								. "`player2_change_name`='".$one_match_team2[0]['player'.$dantai_league_team_last_match[$team2][1].'_change_name']."',"
								. ' `update_date`=NOW() where `id`='.$one_match_id;
//echo '<!-- set:',$sql," -->\n";
							db_query( $dbs, $sql );
						}
					}
				}
			}
/**/
			if( $dantai_tournament_match_id == 0 ){
				$sql = 'insert into `dantai_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`no_match`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$match_index.', '.$match_id.', '.$no_match.', NOW(), NOW( ) )';
//echo '<!-- ',$sql," -->\n";
				db_query( $dbs, $sql );
			} else {
				$sql_param = array();
				if( intval( $dantai_tournament_match_data['tournament_match_index'] ) != $match_index ){
					$sql_param[] = '`tournament_match_index`=' . $match_index;
				}
				if( intval( $dantai_tournament_match_data['match'] ) != $match_id ){
					$sql_param[] = '`match`=' . $match_id;
				}
				if( intval( $dantai_tournament_match_data['no_match'] ) != $no_match ){
					$sql_param[] = '`no_match`=' . $no_match;
				}
				if( count( $sql_param ) > 0 ){
					$sql = 'update `dantai_tournament_match` set ' . implode( ',', $sql_param ) . ' where `id`=' . $dantai_tournament_match_id;
//echo '<!-- ',$sql," -->\n";
					db_query( $dbs, $sql );
				}
			}
		}
		// シードの処理
		$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$tournament_id . ' order by `tournament_match_index` asc';
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		foreach( $dantai_tournament_match as $mv ){
			if( intval( $mv['no_match'] ) == 1 ){
				$tournament_match_index = intval( $mv['tournament_match_index'] );
				if( $tournament_match_index == 1 ){ continue; }
				$dantai_match_id = intval( $mv['match'] );
				if( $dantai_match_id > 0 ){
					$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
					$winner = get_field_string_number( $dantai_match, 'team1', 0 );
					if( $winner == 0 ){
						$winner = get_field_string_number( $dantai_match, 'team2', 0 );
					}
					if( $winner > 0 ){
						$up = intval( $tournament_match_index / 2 );
						foreach( $dantai_tournament_match as $mv_up ){
							$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
							$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
							if( $tournament_up_match_index == $up ){
								if( ( $tournament_match_index % 2 ) == 0 ){
									$sql = 'update `dantai_match` set `team1`='.$winner.' where `id`='.$tournament_up_match_id;
//echo '<!-- ',$sql," -->\n";
									db_query( $dbs, $sql );
								} else if( ( $tournament_match_index % 2 ) == 1 ){
									$sql = 'update `dantai_match` set `team2`='.$winner.' where `id`='.$tournament_up_match_id;
//echo '<!-- ',$sql," -->\n";
									db_query( $dbs, $sql );
								}
								break;
							}
						}
					}
				}
			}

		}
//print_r($data);
		return $data;
	}

	function update_dantai_tournament_data( $series, $mw, $post )
	{
		global $__dantai_league_team_last_match__;

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		//$data = db_get_one_data( $dbs, 'dantai_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'] );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
        $part = 1;
		foreach( $list as $data ){
            $this->update_dantai_tournament_one_data( $series, $part, $mw, $post, $data, $dbs );
            $part++;
        }
		db_close( $dbs );
    }

	function get_dantai_league_advanced_team( $series, $mw, $post )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$tlist = db_query_list( $dbs, $sql );
        $part_tbl = [];
		foreach( $tlist as $tdata ){
			for( $i1 = 1; $i1 <= intval( $tdata['team_num'] ); $i1++ ){
	            $part_tbl[$i1] = intval( $tdata['no'] );
			}
        }

		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$lv['id'].' and `advanced`=1 order by `id` asc';
			$team_list = db_query_list( $dbs, $sql );
			foreach( $team_list as $tlv ){
				if( $tlv['advanced'] == 1 ){
					$post['entry_'.$part_tbl[$lv['no']].'_'.$lv['no']] = $tlv['id'];
					break;
				}
			}		
		}
		return $post;
    }

	function clear_dantai_tournament_match_info( $series )
	{
//return;
        $debug = false;
		$fp = fopen( dirname(dirname(__FILE__)).'/log/clearback_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$fp2 = fopen( dirname(dirname(__FILE__)).'/log/clear_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
/*
		$sql = 'select * from `dantai_league` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0 order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_league` set `extra_match_exists`='.$lv['extra_match_exists'].' where `id`='.$lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_league` set `extra_match_exists`=0 where `id`='.$lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		$sql = 'select `dantai_league_team`.*,`dantai_league`.`series` as `series`'
			. ' from `dantai_league` inner join `dantai_league_team`'
			. ' on `dantai_league_team`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_league_team`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`='.$lv['advanced'].',`standing`='.$lv['standing'].',`point`='.$lv['point'].',`win`='.$lv['win'].',`hon`='.$lv['hon']
				. ' where `id`='.$lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`=0,`standing`=0,`point`=0,`win`=0,`hon`=0,`update_date`=NOW()'
				. ' where `id`='.$lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		$sql = 'select `dantai_match`.*,`dantai_league_match`.`league` as `league`,`dantai_league`.`series` as `series`'
			. ' from `dantai_match`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' inner join `dantai_league` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_match`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_match`'
				. ' set `win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
				. ' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_match`'
			. ' set `win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		foreach( $list as $lv ){
			$sql = 'select * from `one_match`'
				. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
				. ' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $lv2 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
					. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
					. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
					. ' `player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
					. ' `player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\','
					. ' `supporter1`='.$lv2['supporter1'].',`supporter2`='.$lv2['supporter2']
					. ' where `id`=' . $lv2['id'];
				fwrite( $fp, $sql.";\n" );
				$sql = 'update `one_match`'
					. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
					. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
					. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
					. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\','
					. ' `supporter1`=0,`supporter2`=0'
					. ' where `id`=' . $lv2['id'];
                fwrite( $fp2, $sql.";\n" );
                if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
			}
		}
*/
		$sql = 'select * from `dantai_tournament` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$dantai_tournament_list = db_query_list( $dbs, $sql );
        foreach( $dantai_tournament_list as $dantai_tournament_data ){

			$t = intval( $dantai_tournament_data['id'] );
			$team_num = intval( $dantai_tournament_data['team_num'] );
			$match_num = intval( $dantai_tournament_data['match_num'] );
			$extra_match_num = intval( $dantai_tournament_data['extra_match_num'] );
			$match_level = intval( $dantai_tournament_data['match_level'] );
			$macth1_level = 1;
			$i1 = 1;
			for(;;){
				if( $i1 == $match_level ){ break; }
				$macth1_level *= 2;
				$i1++;
			}
	
			$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$t.' order by `tournament_team_index` asc';
			$list = db_query_list( $dbs, $sql );
			$dantai_tournament_team = array_column( $list, 'team', 'tournament_team_index' );
			foreach( $list as $lv ){
				$sql = 'update `dantai_tournament_team` set `team`='.$lv['team'].' where `id`=' . $lv['id'];
				fwrite( $fp, $sql.";\n" );
			}
			$sql = 'update `dantai_tournament_team` set `team`=0,`update_date`=NOW() where `tournament`='.$t;
	        fwrite( $fp2, $sql.";\n" );
    	    //if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }

			$sql = 'select `dantai_match`.*,'
				.'`dantai_tournament_match`.`tournament` as `tournament`,'
				.'`dantai_tournament_match`.`tournament_match_index` as `tournament_match_index`'
				. ' from `dantai_match`'
				. ' inner join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_tournament_match`.`tournament`='.$t.' order by `dantai_match`.`id` asc';
			$list = db_query_list( $dbs, $sql );
			foreach( $list as $lv ){
				$match_index = intval( $lv['tournament_match_index'] );
				$sql = 'update `dantai_match`'
					. ' set `team1`='.$lv['team1'].',`team2`='.$lv['team2'].',`win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
					. ' where `id`=' . $lv['id'];
				fwrite( $fp, $sql.";\n" );
				if( $match_index >= $macth1_level && $match_index <= $match_num ){
					$team_sql = '`team1`=' . $dantai_tournament_team[($match_index-$macth1_level)*2+1]
							. ', `team2`=' . $dantai_tournament_team[($match_index-$macth1_level)*2+2];
				} else {
					$team_sql = '`team1`=0,`team2`=0';
				}
				$sql = 'update `dantai_match`'
					. ' set ' . $team_sql . ',`win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
				fwrite( $fp2, $sql.";\n" );
	            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
			}

			foreach( $list as $lv ){
				$sql = 'select * from `one_match`'
					. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
					. ' order by `id` asc';
				$list2 = db_query_list( $dbs, $sql );
				foreach( $list2 as $lv2 ){
					$sql = 'update `one_match`'
						. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
						. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
						. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
						. ' `supporter1`='.$lv2['supporter1'].',`supporter2`='.$lv2['supporter2'].','
						. ' `player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
						. ' `player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
						. ' where `id`=' . $lv2['id'];
					fwrite( $fp, $sql.";\n" );
					$sql = 'update `one_match`'
						. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
						. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
						. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
						. ' `supporter1`=0,`supporter2`=0,'
						. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\''
						. ' where `id`=' . $lv2['id'];
    	            fwrite( $fp2, $sql.";\n" );
        	        if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
				}
			}

			// シードの処理
			$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$t . ' order by `tournament_match_index` asc';
			$dantai_tournament_match = db_query_list( $dbs, $sql );
			foreach( $dantai_tournament_match as $mv ){
				if( intval( $mv['no_match'] ) == 1 ){
					$tournament_match_index = intval( $mv['tournament_match_index'] );
					if( $tournament_match_index == 1 ){ continue; }
					$dantai_match_id = intval( $mv['match'] );
					if( $dantai_match_id > 0 ){
						$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
						$winner = get_field_string_number( $dantai_match, 'team1', 0 );
						if( $winner == 0 ){
							$winner = get_field_string_number( $dantai_match, 'team2', 0 );
						}
						if( $winner > 0 ){
							$up = intval( $tournament_match_index / 2 );
							foreach( $dantai_tournament_match as $mv_up ){
								$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
								$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
								if( $tournament_up_match_index == $up ){
									$dantai_match_up = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$tournament_up_match_id );
									if( ( $tournament_match_index % 2 ) == 0 ){
										$sql = 'update `dantai_match` set `team1`='.$dantai_match_up['team1'].' where `id`='.$tournament_up_match_id;
										fwrite( $fp, $sql.";\n" );
										$sql = 'update `dantai_match` set `team1`='.$winner.' where `id`='.$tournament_up_match_id;
										fwrite( $fp2, $sql.";\n" );
										if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
									} else if( ( $tournament_match_index % 2 ) == 1 ){
										$sql = 'update `dantai_match` set `team2`='.$dantai_match_up['team2'].' where `id`='.$tournament_up_match_id;
										fwrite( $fp, $sql.";\n" );
										$sql = 'update `dantai_match` set `team2`='.$winner.' where `id`='.$tournament_up_match_id;
										fwrite( $fp2, $sql.";\n" );
										if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
									}
									break;
								}
							}
						}
					}
				}
			}
		}

		db_close( $dbs );
		fclose( $fp );
		fclose( $fp2 );
	}

	function get_dantai_tournament_one_result__( $match )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$id );
		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.intval($dantai_tournament_match['match']) );
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );
		$dantai_match['tournament'] = $dantai_tournament_match['tournament'];
		if( $dantai_match['tournament'] == 1 ){
			$series_mw = 'm';
		} else {
			$series_mw = 'w';
		}

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
				$one_match['player1_name'] = $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_mei'];
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
				$one_match['player2_name'] = $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_mei'];
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei']
					);
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player2' => 0,
						'player2_name' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}

	function get_dantai_tournament_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament_match`.*,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`'
			. ' from `dantai_tournament_match` inner join `dantai_tournament` on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament` where `dantai_tournament_match`.`match`='.$match;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		$series = intval( $dantai_tournament_match[0]['series'] );
		$series_mw = $dantai_tournament_match[0]['series_mw'];
		$tournament = intval( $dantai_tournament_match[0]['tournament'] );

		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$dantai_match['entry1'] = $this->__pageObj->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->__pageObj->get_entry_one_data2( intval($dantai_match['team2']) );
		$dantai_match['tournament'] = $tournament;

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $one_match['player1'] == __PLAYER_NAME__ ){
                    $one_match['player1_name'] = $one_match['player1_change_name'];
                } else {
                    $one_match['player1_name'] = $dantai_match['entry1']['dantai_'.$series_mw.$one_match['player1'].'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$one_match['player1'].'_mei'];
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $one_match['player2'] == __PLAYER_NAME__ ){
                    $one_match['player2_name'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $dantai_match['entry2']['dantai_'.$series_mw.$one_match['player2'].'_sei'] . ' '. $dantai_match['entry2']['dantai_'.$series_mw.$one_match['player2'].'_mei'];
                }
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_mei']
					);
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player2' => 0,
						'player2_name' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}


	function set_dantai_tournament_fusen( $match, $fusen, $winner )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$match );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$sql = 'update `dantai_match` set `fusen`='.$fusen.',`winner`='.$winner.' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );
	}

	function set_dantai_tournament_exist_match6( $match, $exist )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$match );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$sql = 'update `dantai_match` set `exist_match6`='.$exist.' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );
	}

	function set_dantai_tournament_player( $id, $team, $match_no, $player, $name )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$id );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
		$one_match_id = get_field_string_number( $data, 'match'.$match_no, 0 );
		if( $one_match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `player' . $team . '`=' . $player . ',`player' . $team . '_change_name`=\'' . $name . '\''
				. ' where `id`='.$one_match_id;
			db_query( $dbs, $sql );
		}
	}

	function update_dantai_tournament_one_result( $tournament, $id, $match_no, $list, $match_num )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`match`='.$id );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$tournament = intval( $dantai_tournament_match['tournament'] );
		$tournament_info = db_get_one_data( $dbs, 'dantai_tournament', '*', '`id`='.$tournament );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
		$one_match_id = get_field_string_number( $data, 'match'.$match_no, 0 );
		if( $one_match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `faul1_1`='.$list['p'][$match_no]['faul1_1'].','
				. '`faul1_2`='.$list['p'][$match_no]['faul1_2'].','
				. '`waza1_1`='.$list['p'][$match_no]['waza1_1'].','
				. '`waza1_2`='.$list['p'][$match_no]['waza1_2'].','
				. '`waza1_3`='.$list['p'][$match_no]['waza1_3'].','
				. '`player1`='.$list['p'][$match_no]['player1'].','
				. '`player1_change_name`=\''.$list['p'][$match_no]['player1_change_name'].'\','
				. '`faul2_1`='.$list['p'][$match_no]['faul2_1'].','
				. '`faul2_2`='.$list['p'][$match_no]['faul2_2'].','
				. '`waza2_1`='.$list['p'][$match_no]['waza2_1'].','
				. '`waza2_2`='.$list['p'][$match_no]['waza2_2'].','
				. '`waza2_3`='.$list['p'][$match_no]['waza2_3'].','
				. '`player2`='.$list['p'][$match_no]['player2'].','
				. '`player2_change_name`=\''.$list['p'][$match_no]['player2_change_name'].'\','
				. '`end_match`='.$list['p'][$match_no]['end_match'].','
				. '`hon1`='.$list['hon1'][$match_no].','
				. '`hon2`='.$list['hon2'][$match_no].','
				. '`extra`='.$list['p'][$match_no]['extra'].','
				. '`match_time`=\''.$list['p'][$match_no]['match_time'].'\','
				. '`match_time_minute`=\''.$list['p'][$match_no]['match_time_minute'].'\','
				. '`match_time_second`=\''.$list['p'][$match_no]['match_time_second'].'\','
				. '`winner`='.$list['win'][$match_no]
				. ' where `id`='.$one_match_id;
//echo $sql;
			db_query( $dbs, $sql );
		}
		$sql = 'update `dantai_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner']
			. ' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );

		if( $list['winner'] == 1 ){
			$winner = $data['team1'];
			$loser = $data['team2'];
		} else if( $list['winner'] == 2 ){
			$winner = $data['team2'];
			$loser = $data['team1'];
		} else {
			$winner = 0;
		}

		$sql = 'select * from `dantai_tournament_match` where `tournament`='.$tournament.' order by `tournament_match_index` asc';
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		foreach( $dantai_tournament_match as $mv ){
			$tournament_match_id = get_field_string_number( $mv, 'match', 0 );
			$tournament_match_index = get_field_string_number( $mv, 'tournament_match_index', 0 );
			if( $tournament_match_id == $dantai_match_id ){
				if( $tournament_match_index == 1 ){ break; }
				if( $tournament_match_index <= $match_num ){
    				$up = intval( $tournament_match_index / 2 );
	    			foreach( $dantai_tournament_match as $mv_up ){
		    			$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
		    			$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
			    		if( $tournament_up_match_index == $up ){
				    		if( ( $tournament_match_index % 2 ) == 0 ){
					    		$sql = 'update `dantai_match` set `team1`='.$winner.' where `id`='.$tournament_up_match_id;
//echo $sql,"<br />\n";
						    	db_query( $dbs, $sql );

// 選手入れ替え対応
    							if( $winner != 0 ){
	    							$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
		    						$dantai_match_up = db_query_list( $dbs, $sql );
			    					for( $i1 = 1; $i1 <= 5; $i1++ ){
				    					$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
					    				if( $one_match_up_id != 0 ){
						    				$sql = 'update `one_match`'
							    				. ' set `player1`=' . $list['p'][$i1]['player'.$list['winner']] . ','
								    			. ' `player1_change_name`=\'' . $list['p'][$i1]['player'.$list['winner'].'_change_name'] . '\','
								    			. ' `supporter1`=' . $list['p'][$i1]['supporter'.$list['winner']] . ','
									    		. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
										    db_query( $dbs, $sql );
    									}
	    							}
		    					}
			    			} else if( ( $tournament_match_index % 2 ) == 1 ){
				    			$sql = 'update `dantai_match` set `team2`='.$winner.' where `id`='.$tournament_up_match_id;
//echo $sql,"<br />\n";
					    		db_query( $dbs, $sql );
// 選手入れ替え対応
						    	if( $winner != 0 ){
							    	$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
								    $dantai_match_up = db_query_list( $dbs, $sql );
    								for( $i1 = 1; $i1 <= 5; $i1++ ){
	    								$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
		    							if( $one_match_up_id != 0 ){
			    							$sql = 'update `one_match`'
				    							. ' set `player2`=' . $list['p'][$i1]['player'.$list['winner']] . ','
					    						. ' `player2_change_name`=\'' . $list['p'][$i1]['player'.$list['winner'].'_change_name'] . '\','
								    			. ' `supporter2`=' . $list['p'][$i1]['supporter'.$list['winner']] . ','
						    					. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
							    			db_query( $dbs, $sql );
								    	}
    								}
	    						}
		    				}
			    			break;
				    	}
    				}
                }
//print_r($tournament_info);
//echo $tournament_match_index,"<br />\n";
				if( $tournament_info['extra_match_num'] > 0 && ( $tournament_match_index == 2 || $tournament_match_index == 3 ) ){
					$up = $tournament_info['tournament_team_num'];
					foreach( $dantai_tournament_match as $mv_up ){
    					$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
	    				$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
						if( $tournament_up_match_index == $up ){
							if( $tournament_match_index == 2 ){
                                $sql = 'update `dantai_match` set `team1`='.$loser.' where `id`='.$tournament_up_match_id;
//echo $sql,"<br />\n";
								db_query( $dbs, $sql );
// 選手入れ替え対応
    							if( $winner != 0 ){
	    							$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
    								$dantai_match_up = db_query_list( $dbs, $sql );
	    							for( $i1 = 1; $i1 <= 5; $i1++ ){
		    							$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
			    						if( $one_match_up_id != 0 ){
				    						$sql = 'update `one_match`'
					    						. ' set `player1`=' . $list['p'][$i1]['player'.$list['loser']] . ','
    											. ' `player1_change_name`=\'' . $list['p'][$i1]['player'.$list['loser'].'_change_name'] . '\','
								    			. ' `supporter1`=' . $list['p'][$i1]['supporter'.$list['loser']] . ','
				    							. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
					    					db_query( $dbs, $sql );
						    			}
							    	}
    							}
							} else if( $tournament_match_index == 3 ){
                                $sql = 'update `dantai_match` set `team2`='.$loser.' where `id`='.$tournament_up_match_id;
								db_query( $dbs, $sql );
//echo $sql,"<br />\n";
                                // 選手入れ替え対応
		    					if( $winner != 0 ){
			    					$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
    								$dantai_match_up = db_query_list( $dbs, $sql );
	    							for( $i1 = 1; $i1 <= 5; $i1++ ){
		    							$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
			    						if( $one_match_up_id != 0 ){
				    						$sql = 'update `one_match`'
					    						. ' set `player2`=' . $list['p'][$i1]['player'.$list['loser']] . ','
    											. ' `player2_change_name`=\'' . $list['p'][$i1]['player'.$list['loser'].'_change_name'] . '\','
								    			. ' `supporter2`=' . $list['p'][$i1]['supporter'.$list['loser']] . ','
						    					. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
							    			db_query( $dbs, $sql );
								    	}
    								}
	    						}
							}
//echo $up,':',$sql;
							break;
						}
					}
				}

				break;
			}
		}
		db_close( $dbs );
		return $data;
	}

	function output_tournament_match_for_HTML( $match )
	{
		$data = $this->get_dantai_tournament_one_result( $match );
		return $this->__output_match_for_HTML( $data );
	}

	function get_tounament_chart_winstring_for_excel( $match )
	{
		$l = array( 1 => array('','',''), 2 => array('','','') );
		if( $match['fusen'] == 1 ){
			if( $match['winner'] == 1 ){
				$l[1][2] = '不戦勝';
			} else if( $match['winner'] == 2 ){
				$l[2][2] = '不戦勝';
			}
			return $l;
		}
		$l[1][0] = $match['hon1'];
		$l[2][0] = $match['hon2'];
		$l[1][1] = $match['win1'];
		$l[2][1] = $match['win2'];
		$add1 = '';
		$add2 = '';
		if( $match['win1'] == $match['win2'] ){
			if( $match['hon1'] > $match['hon2'] ){
				$l[1][2] = '本';
			} else if( $match['hon1'] < $match['hon2'] ){
				$l[2][2] = '本';
			} else {
				if( $match['winner'] == 1 ){
					$l[1][2] = '代';
				} else if( $match['winner'] == 2 ){
					$l[2][2] = '代';
				}
			}
		}
		return $l;
	}

	function get_kojin_tounament_chart_winstring_for_excel( $match )
	{
		$l = array( 1=>array( '','','' ), 2=>array( '','','' ) );
		if( $match['waza1_1'] == 5 ){
			$l[1][0] = '不';
			$l[1][1] = '戦';
			$l[1][2] = '勝';
		} else {
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $match['waza1_'.$waza] != 0 ){
					$l[1][$waza-1] = $this->get_waza_name( $match['waza1_'.$waza] );
				}
			}
		}
		if( $match['waza2_1'] == 5 ){
			$l[2][0] = '不';
			$l[2][1] = '戦';
			$l[2][2] = '勝';
		} else {
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $match['waza2_'.$waza] != 0 ){
					$l[2][$waza-1] = $this->get_waza_name( $match['waza2_'.$waza] );
				}
			}
		}
		return $l;
	}

	function output_prize_data_for_excel(
		$objPage, $path, 
		$series_dantai_m, $series_dantai_w, $series_kojin_m, $series_kojin_w
	){
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/prize.xlsx';
		$file_name = 'prize.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/prizeBase.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_w, 'w' );
		$team = array();
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
			$team[2] = $tournament_data['match'][2]['team2'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		} else if( $tournament_data['match'][2]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team1'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['match'][$m]['winner'] == 1 ){
				$team[$m+1] = $tournament_data['match'][$m]['team2'];
			} else if( $tournament_data['match'][$m]['winner'] == 2 ){
				$team[$m+1] = $tournament_data['match'][$m]['team1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+2), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+2), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+2), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_m, 'm' );
		$team = array();
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
			$team[2] = $tournament_data['match'][2]['team2'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		} else if( $tournament_data['match'][2]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team1'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['match'][$m]['winner'] == 1 ){
				$team[$m+1] = $tournament_data['match'][$m]['team2'];
			} else if( $tournament_data['match'][$m]['winner'] == 2 ){
				$team[$m+1] = $tournament_data['match'][$m]['team1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+12), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+12), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+12), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_w, 'w' );
		$id = array();
		$team = array();
		$player = array();
		if( $tournament_data['data']['match'][0]['winner'] == 1 ){
			$id[0] = $tournament_data['data']['match'][0]['player1'];
			$id[1] = $tournament_data['data']['match'][0]['player2'];
		} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
			$id[0] = $tournament_data['data']['match'][0]['player2'];
			$id[1] = $tournament_data['data']['match'][0]['player1'];
		}
		if( $tournament_data['data']['match'][1]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player2'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][1]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player1'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player2'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player1'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['data']['match'][$m]['winner'] == 1 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player2'];
			} else if( $tournament_data['data']['match'][$m]['winner'] == 2 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			$team[$m] = intval( $id[$m] / 0x100 );
			$player[$m] = $id[$m] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w1_sei'].' '.$entry_list[$i2]['kojin_w1_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w1_sei'].' '.$entry_list[$i2]['kojin_kana_w1_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w2_sei'].' '.$entry_list[$i2]['kojin_w2_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w2_sei'].' '.$entry_list[$i2]['kojin_kana_w2_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_m, 'm' );
		$team = array();
		$player = array();
		$id = array();
		$team = array();
		$player = array();
		if( $tournament_data['data']['match'][0]['winner'] == 1 ){
			$id[0] = $tournament_data['data']['match'][0]['player1'];
			$id[1] = $tournament_data['data']['match'][0]['player2'];
		} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
			$id[0] = $tournament_data['data']['match'][0]['player2'];
			$id[1] = $tournament_data['data']['match'][0]['player1'];
		}
		if( $tournament_data['data']['match'][1]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player2'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][1]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player1'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player2'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player1'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['data']['match'][$m]['winner'] == 1 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player2'];
			} else if( $tournament_data['data']['match'][$m]['winner'] == 2 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			$team[$m] = intval( $id[$m] / 0x100 );
			$player[$m] = $id[$m] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m1_sei'].' '.$entry_list[$i2]['kojin_m1_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m1_sei'].' '.$entry_list[$i2]['kojin_kana_m1_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m2_sei'].' '.$entry_list[$i2]['kojin_m2_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m2_sei'].' '.$entry_list[$i2]['kojin_kana_m2_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_prize8_data_for_excel(
		$objPage, $path, 
		$series_dantai_m, $series_dantai_w, $series_kojin_m, $series_kojin_w
	){
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/prize8.xlsx';
		$file_name = 'prize8.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/prizeBase8.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_w, 'w' );
		$team = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = $tournament_data['match'][$m+3]['team1'];
			$team[$m*2+1] = $tournament_data['match'][$m+3]['team2'];
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+2), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+2), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+2), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_m, 'm' );
		$team = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = $tournament_data['match'][$m+3]['team1'];
			$team[$m*2+1] = $tournament_data['match'][$m+3]['team2'];
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+12), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+12), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+12), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_w, 'w' );
		$team = array();
		$player = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = intval( $tournament_data['data']['match'][$m+3]['player1'] / 0x100 );
			$player[$m*2] = $tournament_data['data']['match'][$m+3]['player1'] % 0x100;
			$team[$m*2+1] = intval( $tournament_data['data']['match'][$m+3]['player2'] / 0x100 );
			$player[$m*2+1] = $tournament_data['data']['match'][$m+3]['player2'] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w1_sei'].' '.$entry_list[$i2]['kojin_w1_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w1_sei'].' '.$entry_list[$i2]['kojin_kana_w1_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w2_sei'].' '.$entry_list[$i2]['kojin_w2_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w2_sei'].' '.$entry_list[$i2]['kojin_kana_w2_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_m, 'm' );
		$team = array();
		$player = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = intval( $tournament_data['data']['match'][$m+3]['player1'] / 0x100 );
			$player[$m*2] = $tournament_data['data']['match'][$m+3]['player1'] % 0x100;
			$team[$m*2+1] = intval( $tournament_data['data']['match'][$m+3]['player2'] / 0x100 );
			$player[$m*2+1] = $tournament_data['data']['match'][$m+3]['player2'] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m1_sei'].' '.$entry_list[$i2]['kojin_m1_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m1_sei'].' '.$entry_list[$i2]['kojin_kana_m1_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m2_sei'].' '.$entry_list[$i2]['kojin_m2_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m2_sei'].' '.$entry_list[$i2]['kojin_kana_m2_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_dantai_tournament_for_HTML( $navi_info, $tournament_list, $entry_list, $mw, $cssparam=null )
	{
//print_r($tournament_data);
		if( $mw == 'm' ){
			$mwstr = '男子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
        } else if( $mw == 'w' ){
			$mwstr = '女子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		} else {
			$mwstr = '';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		}
		$break_html = null;
		$break_html_name = null;
        if( $cssparam != null ){
			$table_name_rowspan = $cssparam['table_name_rowspan'];
			$table_name_name_width = $cssparam['table_name_name_width'];
			$table_name_name_font_size = $cssparam['table_name_name_font_size'];
			$table_name_name_font_size2 = $cssparam['table_name_name_font_size2'];
			$table_name_pref_width = $cssparam['table_name_pref_width'];
			$table_height = $cssparam['table_height'];
			$table_font_size = $cssparam['table_font_size'];
			$table_place_font_size = $cssparam['table_place_font_size'];
			$table_cell_width = $cssparam['table_cell_width'];
            $return_path = get_field_string( $cssparam, 'return_path' );
			if( isset($cssparam['break_html']) ){
				$break_html = $cssparam['break_html'];
			}
			if( isset($cssparam['break_html_name']) ){
				$break_html_name = $cssparam['break_html_name'];
			}
        }
        if( $return_path == '' ){
            $return_path = 'index_' . $navi_info['result_prefix'] . $mw . '.html';
        }
		if( $break_html === null ){
			$break_html = [];
	        for( $tournament_index = 0; $tournament_index < count($tournament_data['data']); $tournament_index++ ){
				$break_html[] = true;
			}
		}
		if( $break_html_name === null ){
			$break_html_name = [];
	        for( $tournament_index = 1; $tournament_index <= count($tournament_data['data']); $tournament_index++ ){
				$break_html_name[] = 'k' . $mw . $tournament_index;
			}
		}


		$tournament_name_width = 180;
		$tournament_name_pref_width = 72;
		$tournament_name_num_width = 16;
		$tournament_name_name_width = $tournament_name_width - $tournament_name_pref_width - $tournament_name_num_width;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;

        $tindex = 1;
        foreach( $tournament_list as $tournament_index => $tournament_data ){

		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
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
			. '    width: '.$tournament_name_name_width.';' . "\n"
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
			. '    width: '.$tournament_name_pref_width.';' . "\n"
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
			. '    width: '.$tournament_name_num_width.';' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: '.$tournament_name_num_width.';' . "\n"
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
			. '</style>' . "\n";
		$footer = '    </div>' . "\n"
			. '    </table>' . "\n"
			. '  <br /><br /><br />' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="'.$return_path.'">←戻る</a></h2>'."\n"
			. '  </div>' . "\n"
			. '</body>' . "\n"
			. '</html>' . "\n";

		$html = $header . '<H1 style="border-bottom: solid 1px #000000;" lang="ja">'.$tournament_data['tournament_name'] . '&nbsp;結果</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="'.$return_path.'">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";

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
				$one_match['team1'] = array( 'id' => $id );
                $one_match['team1']['pos'] = $team_pos * 4 + 1;
                //if( $id > 0 ){
                    $one_match['team1']['name'] = $name;
                    $one_match['team1']['pref'] = $pref;
                    $one_match['team1']['index'] = $team_index;
                    $team_pos++;
                    $team_index++;
				//}
				$match_no++;
			} else {
			//	if( $one_match['place'] !== 'no_match' ){
                    $one_match['team2'] = array( 'id' => $id );
                    $one_match['team2']['pos'] = $team_pos * 4 + 1;
                    //if( $id > 0 ){
                        $one_match['team2']['name'] = $name;
                        $one_match['team2']['pref'] = $pref;
                        $one_match['team2']['index'] = $team_index;
                        $team_pos++;
                        $team_index++;
                    //}
			//	}
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
		$match_line = array();
		foreach( $match_tbl[0][0] as $mv ){
            if( $mv['place'] !== 'no_match' || $mv['team1']['id'] != 0 || $mv['team2']['id'] != 0 ){
                $match_line[] = $mv;
            }
        }
        $match_tbl[0][0] = $match_line;
		$match_line = array();
		foreach( $match_tbl[1][0] as $mv ){
            if( $mv['place'] !== 'no_match' || $mv['team1']['id'] != 0 || $mv['team2']['id'] != 0 ){
                $match_line[] = $mv;
            }
        }
        $match_tbl[1][0] = $match_line;

//print_r($match_line);
//print_r($match_tbl);
//exit;
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
		$html .=  '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		for(;;){
			$html .= '      <tr>' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
						$html .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$html .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$html .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$namespan = $table_name_rowspan - 1;
						$name_index++;
					}
					$html .= '<td height="'.$table_height.'" class="div_border_b';
					if( $one_match_tbl['winner'] == 1 ){
						$html .= '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$html .= '_up';
					}
					$html .= ' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$html .= '不戦勝' . "\n";
					}
					$html .= '</td>' . "\n";
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
							$html .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$html .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$html .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$namespan = $table_name_rowspan - 1;
							$name_index++;
						}
						$html .= '<td height="'.$table_height.'" class="div_border_br';
						if( $one_match_tbl['winner'] == 2 ){
							$html .= '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$html .= '_up';
						}
						$html .= ' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$html .= '不戦勝' . "\n";
						}
						$html .= '</td>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							if( $namespan > 0 ){
								$namespan--;
							} else {
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
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
							$html .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament">';
							if( $line == $trmatch[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								//$html .= '<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>　';
								$html .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
							}
							$html .= '</td>' . "\n";
						}
					}
				} else {
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
				}
				$allend = 0;
			}
			if( $line == $line2-1 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$html .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$html .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$html .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 2 ){
				if( $tournament_data['match'][0]['winner'] > 0 ){
					//$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;"><a href="r'.$mv.'01.html">'.$tournament_data['match'][0]['hon1'].' -'.'</a></td>';
					//$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"><a href="r'.$mv.'01.html"> '.$tournament_data['match'][0]['hon2'].'</a></td>';
					$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;">'.$tournament_data['match'][0]['hon1'].' -'.'</td>';
					$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"> '.$tournament_data['match'][0]['hon2'].'</td>';
	} else {
					$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				}
			} else {
				$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$html .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['match_level']-2; $level >= 0; $level-- ){
				if( $trpos2[$level] >= count( $match_tbl[1][$level] ) ){
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$html .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
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
					$html .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$html .= '不戦勝' . "\n";
					}
					$html .= '</td>' . "\n";
					if( $level == 0 ){
						$html .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$html .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$html .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
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
						$html .= '<td height="'.$table_height.'" class="div_border_bl'.$win.' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$html .= '不戦勝' . "\n";
						}
						$html .= '</td>' . "\n";
						if( $level == 0 ){
							$html .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$html .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$html .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
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
							$html .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2">';
							if( $line == $trmatch2[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								$html .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
								//$html .= '　<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>';
							}
							$html .= '</td>' . "\n";
						}
						if( $level == 0 ){
							if( $namespan2 > 0 ){
								$namespan2--;
							} else {
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							}
						}
					}
				} else {
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$html .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$html .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
			$html .= "\n".'      </tr>' . "\n";
if( $line == 300 ){ break; }
		}
		if( !$break_html[$tournament_index] ){
	    	$pdf .= '  <br /><br /><br />' . "\n";
			continue;
		}

		$html .= $footer;
//echo $html;
//exit;
		$file = $break_html_name[$tournament_index];
        $path = $navi_info['result_path'] . '/' . $file . '.html';
		$fp = fopen( $path, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
		$data = [
			'mode' => 2,
			'navi' => $navi_info['navi_id'],
			'place' => $file,
			'file' => $path,
			'series' => $navi_info['result_path_prefix'], // . '/' . $navi_info['reg_year'],
		];
		$this->__pageObj->update_realtime_queue( $data );

		$html = $header;

		}
	}

	function output_tournament_match_for_HTML2( $objPage, $navi_info, $tournament_list, $entry_list, $mw, $split )
	{
        $levelstrtbl = array( '一', '二', '三', '四', '五' );

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

        $tindex = 1;
        foreach( $tournament_list as $tv ){
            $html = $header;
            if( count( $tournament_list ) > 1 ){
                 $html .= '    <h2>ブロック' . $tindex . '</h2>'."\n";
            }
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tv['match_level']; $i1++ ){ $match_no_top *= 2; }
            $level_offset = 0;
            for( $level = $tv['match_level']; $level >= 1; $level-- ){
                $nomatch = true;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tv['match'][$match_no_top+$i1-2]['place'] !== 'no_match' ){
                        $nomatch = false;
                        break;
                    }
                }
                if( $nomatch ){
                    $level_offset++;
                    $match_no_top /= 2;
                    continue;
                }
                if( $level >= 4 ){
                    $levelstr = $levelstrtbl[$tv['match_level']-$level-$level_offset] . '回戦';
                } else if( $level == 3 ){
                    $levelstr = '準々決勝';
                } else if( $level == 2 ){
                    $levelstr = '準決勝';
                } else if( $level == 1 ){
                    $levelstr = '決勝';
                }
                $html .= '    <h2>' . $mwstr . '団体トーナメント結果(' . $levelstr . ')</h2>' . "\n";
                $match_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tv['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){ continue; }
                    if( $level == 1 ){
                        $html .= '<h3>団体トーナメント&nbsp;' . $levelstr . '</h3>' . "\n";
                    } else {
                        $html .= '<h3>団体トーナメント&nbsp;' . $levelstr . '&nbsp;第'.$match_index.'試合</h3>' . "\n";
                    }
                    $html .= $objPage->output_one_match_for_HTML2( $navi_info, $tv['match'][$match_no_top+$i1-2], $entry_list, $mw );
                    $match_index++;
                }
                $match_no_top /= 2;
                if( $split == 1 ){
                    if( $level == 4 ){
                        $html .= $footer;
                        $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'_1.html';
                        $fp = fopen( $file, 'w' );
                        fwrite( $fp, $html );
                        fclose( $fp );
                        $html = $header;
                        if( count( $tournament_list ) > 1 ){
                            $html .= '    <h2>ブロック' . $tindex . '</h2>'."\n";
                        }
                    } else if( $level == 1 ){
                        $html .= $footer;
                        $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'_2.html';
                        $fp = fopen( $file, 'w' );
                        fwrite( $fp, $html );
                        fclose( $fp );
                    }
                }
            }
            if( $split == 0 ){
                $html .= $footer;
                $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
                $fp = fopen( $file, 'w' );
                fwrite( $fp, $html );
                fclose( $fp );
            }
            $tindex++;
        }
	}

	function output_dantai_tournament_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_list, $entry_list, $mw )
    {
//print_r($tournament_list);
//exit;

        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
        $kmatch = $tournament_param['match_num'];
        $level_num = $tournament_param['match_level'];

        require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
        require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
        $file_name = 'dt_' . $series_info['result_prefix'] . $mw . '.' . $ftime . '.xlsx';
        $file_path = $path . '/' . $file_name;
        $excel = new PHPExcel();
        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

        if( $tindex > 1 ){
            $excel->createSheet();
        }
        $excel->setActiveSheetIndex( $tindex-1 );        //何番目のシートに有効にするか
        $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        $sheet->setTitle( sprintf('%d',$tindex) );
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
		$sheet->setCellValueByColumnAndRow( 0, 2, 'トーナメント結果' );
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
            if( $tournament_data['team'][$team]['id'] == 0 ){ continue; }
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
                    if( $tournament_data['match'][$match]['team1'] != 0 || $tournament_data['match'][$match]['team2'] != 0 ){
                        $row += 4;
                    }
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

        $row = $tournament_team_num2 * 4 + 5 + 2;

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

            $tindex++;
        }

        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
	}

	function output_dantai_tournament_match_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_list, $entry_list, $mw )
	{
        $levelstrtbl = array( '一', '二', '三', '四', '五' );

		if( $mw == 'm' ){
			$mwstr = '男子';
		} else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
        $kmatch = $tournament_param['match_num'];
        $level_num = $tournament_param['match_level'];
        if( $level_num <= 4 ){
            $colnum = 1;
            $rownum = 16;
        } else if( $level_num == 5 ){
            $colnum = 2;
            $rownum = 16;
        } else if( $level_num == 6 ){
            $colnum = 2;
            $rownum = 32;
        } else if( $level_num == 7 ){
            $colnum = 4;
            $rownum = 32;
        }

		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
        $file_name = 'bunbu' . $series_info['reg_year'] . '_dtm_' . $series_info['result_prefix'] . $mw . '.xlsx';
        $file_path = $path . '/' . $file_name;

		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/dantaiTournamentMatchResultsBase.xls');
        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

    		$excel->setActiveSheetIndex( $tindex-1 );		//何番目のシートに有効にするか
	    	$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		    $sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体トーナメント結果' );

    		$col = 0;
	    	$row = 4;
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col))->setWidth(10.0);
            for( $i1 = 1; $i1 < 30; $i1++ ){
                $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+$i1))->setWidth(2.33);
            }
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
            $match_index = 1;
            for( $level = $tournament_data['match_level']; $level >= 1; $level-- ){
                if( $level >= 4 ){
                    $levelstr = $levelstrtbl[$tournament_data['match_level']-$level] . '回戦';
                } else if( $level == 3 ){
                    $levelstr = '準々決勝';
                } else if( $level == 2 ){
                    $levelstr = '準決勝';
                } else if( $level == 1 ){
                    $levelstr = '決勝';
                }

//print_r($entry_list);
//print_r($tournament_data);
//exit;
                $match_level_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tournament_data['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){
                        continue;
                    }
                    if( $level == 1 ){
                        $sheet->setCellValueByColumnAndRow( $col, $row, $levelstr );
                    } else {
                        $sheet->setCellValueByColumnAndRow( $col, $row, $levelstr. ' 第'.$match_level_index.'試合' );
                    }
                    $row++;
                    for( $r = 0; $r < 5; $r++ ) {
                        for( $c = 0; $c < 28; $c++ ){
                            // セルを取得
                            $cell = $sheet->getCellByColumnAndRow($c, $r+5);
                            // セルスタイルを取得
                            $style = $sheet->getStyleByColumnAndRow($c, $r+5);
                            // 数値から列文字列に変換する (0,1) → A1
                            $offsetCell = PHPExcel_Cell::stringFromColumnIndex($col+$c) . (string)($row + $r);
                            // セル値をコピー
                            $sheet->setCellValue($offsetCell, $cell->getValue());
                            // スタイルをコピー
                            $sheet->duplicateStyle($style, $offsetCell);

                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col).($row+2);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col).($row+3).':'.PHPExcel_Cell::stringFromColumnIndex($col).($row+4);
                            $sheet->mergeCells( $mg_range );
                            for( $ofs = 0; $ofs < 5; $ofs++ ){
                                $cpos = $col + 1 + $ofs * 4;
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).$row.':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).$row;
                                $sheet->mergeCells( $mg_range );
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+1);
                                $sheet->mergeCells( $mg_range );
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+2).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+3);
                                $sheet->mergeCells( $mg_range );
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+4);
                                $sheet->mergeCells( $mg_range );
                            }

                            $cpos = $col + 1 + 5 * 4;
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).$row.':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).$row;
                            $sheet->mergeCells( $mg_range );
                            for( $ofs = 0; $ofs < 2; $ofs++ ){
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+1+$ofs*2).':'.PHPExcel_Cell::stringFromColumnIndex($cpos).($row+2+$ofs*2);
                                $sheet->mergeCells( $mg_range );
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+1+$ofs*2).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+3).($row+2+$ofs*2);
                                $sheet->mergeCells( $mg_range );
                            }
                            $cpos = $col + 1 + 5 * 4 + 1;
                            for( $ofs = 0; $ofs < 4; $ofs++ ){
                                $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+1+$ofs).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+1).($row+1+$ofs);
                                $sheet->mergeCells( $mg_range );
                            }

                            $cpos = $col + 1 + 6 * 4;
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).$row.':'.PHPExcel_Cell::stringFromColumnIndex($cpos+2).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+2).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($cpos).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($cpos+2).($row+4);
                            $sheet->mergeCells( $mg_range );

                        }
                    }
                    $row += 5;
                    $match_level_index++;
                    if( ( $match_index % $rownum ) == 0 ){
                        $col += 30;
                        $row = 4;
                        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col))->setWidth(10.0);
                        for( $i2 = 1; $i2 < 30; $i2++ ){
                            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+$i2))->setWidth(2.33);
                        }
                    }
                    $match_index++;
                }
                $match_no_top /= 2;
            }
    		$col = 0;
	    	$row = 5;
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
            $match_index = 1;
            for( $level = $tournament_data['match_level']; $level >= 1; $level-- ){
                $match_level_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tournament_data['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){
                        continue;
                    }
                    $objPage->output_one_match_for_excel( $sheet, $col, $row+1, $series_info, $tournament_data['match'][$match_no_top+$i1-2], $entry_list, $mw, 46, 46 );
                    $row += 6;
                    $match_level_index++;
                    if( ( $match_index % $rownum ) == 0 ){
                        $col += 30;
                        $row = 5;
                    }
                    $match_index++;
                }
                $match_no_top /= 2;
            }
            $tindex++;
        }

        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
    }

}

