<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';

    $ret = [
        'result' => false,
        'entry_info' => [],
        'dantai_league' => [],
        'dantai_league_team' => [],
        'dantai_league_match' => [],
        'dantai_tournament' => [],
        'dantai_tournament_team' => [],
        'dantai_tournament_match' => [],
        'kojin_tournament' => [],
        'kojin_tournament_player' => [],
        'kojin_tournament_match' => [],
    ];

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=utf-8");
    $series = get_field_string_number( $_GET, 's', 0 );
    if( $series == 0 ){ echo json_encode($ret); }
    $year = get_field_string_number( $_GET, 'y', 0 );
    if( $year == 0 ){ echo json_encode($ret); }

	$fp = fopen( dirname(__FILE__).'/log/setup_db_get.'.date('Ymd').'.log', 'a' );
	fwrite( $fp, '['.date('Y/m/d H:i:s')."]--------------------------------------------------\n" );
	fwrite( $fp, 'post:'.print_r( $_POST, true ) );
	fwrite( $fp, 'get:'.print_r( $_GET, true ) );
	fwrite( $fp, 'session:'.print_r( $_SESSION, true )."\n" );
	fwrite( $fp, 'server:'.print_r( $_SERVER, true )."\n" );
	fwrite( $fp, 'files:'.print_r( $_FILES, true )."\n" );
	fclose( $fp );

    $objPage = new form_page();
    $series_info = $objPage->get_series_list( $series );
    $ret['series'] = json_decode(json_encode($series_info),true);
    $ret['series']['name_m'] = $ret['series']['name'];
    $ret['series']['name_w'] = $ret['series']['name'];
    $series_tbl = [
        'all' => [],
        'dantai_league' => [],
        'dantai_tournament' => [],
        'kojin_tournament' => [],
    ];
    if( $series_info['dantai_league_m'] != 0 ){
        $series_tbl['all'][] = $series_info['dantai_league_m'];
        $series_tbl['dantai_league'][] = $series_info['dantai_league_m'];
    }
    if( $series_info['dantai_league_w'] != 0 ){
        $series_tbl['all'][] = $series_info['dantai_league_w'];
        $series_tbl['dantai_league'][] = $series_info['dantai_league_w'];
    }
    if( $series_info['dantai_tournament_m'] != 0 ){
        $series_tbl['all'][] = $series_info['dantai_tournament_m'];
        $series_tbl['dantai_tournament'][] = $series_info['dantai_tournament_m'];
    }
    if( $series_info['dantai_tournament_w'] != 0 ){
        $series_tbl['all'][] = $series_info['dantai_tournament_w'];
        $series_tbl['dantai_tournament'][] = $series_info['dantai_tournament_w'];
    }
    if( $series_info['kojin_tournament_m'] != 0 ){
        $series_tbl['all'][] = $series_info['kojin_tournament_m'];
        $series_tbl['kojin_tournament'][] = $series_info['kojin_tournament_m'];
    }
    if( $series_info['kojin_tournament_w'] != 0 ){
        $series_tbl['all'][] = $series_info['kojin_tournament_w'];
        $series_tbl['kojin_tournament'][] = $series_info['kojin_tournament_w'];
    }

    $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
    $sql = 'SELECT * FROM `entry_info`'
        . ' WHERE `series` in(' . implode(',', $series_tbl['all']) . ')'
        . ' AND `year` = ' . $year . ' AND `del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $one = [
                'series' => $lv['series'],
                'disp_order' => $lv['disp_order'],
                'fields' => [],
            ];
            $sql = 'SELECT * FROM `entry_field` WHERE `info`=' . $lv['id'];
            $list2 = db_query_list( $dbs, $sql );
    	    if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $f = [
                        'field' => $lv2['field'],
                        'data' => $lv2['data'],
                    ];
                    $one['fields'][] = $f;
                }
            }
            $ret['entry_info'][] = $one;
        }
	}

    $sql = 'SELECT * FROM `entry_field_def` WHERE `del`=0';
    $ret['entry_field_def'] = db_query_list( $dbs, $sql );

    $sql = 'SELECT * FROM `dantai_league`'
        . ' WHERE `series` in(' . implode(',', $series_tbl['dantai_league']) . ')'
        . ' AND `year` = ' . $year . ' AND `del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $data = json_decode(json_encode($lv),true);
            $data['display_place_offset'] = 0;
            $data['dantai_league_team'] = [];
            $sql = 'SELECT `l`.`series` as `series`,'
                . '`l`.`no` as `league`,'
                . '`t`.`league_team_index` as `league_team_index`,'
                . '`e`.`disp_order` as `team`'
                . 'FROM `dantai_league_team` as `t`'
                . 'INNER JOIN `dantai_league` as `l` on `t`.`league`=`l`.`id`'
                . 'LEFT JOIN `entry_info` as `e` on `t`.`team`=`e`.`id`'
                . ' WHERE `l`.`id`=' . $data['id'];
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['dantai_league_team'][] = json_decode(json_encode($lv2),true);
                }
	        }
            $data['dantai_league_match'] = [];
            $sql = 'SELECT `l`.`series` as `series`,'
                . ' `l`.`no` as `league`,'
                . ' `lm`.`league_match_index` as `league_match_index`,'
                . ' `m`.`place` as `place`,'
                . ' `m`.`place_match_no` as `place_match_no`'
                . ' FROM `dantai_match` as `m`'
                . ' INNER JOIN `dantai_league_match` as `lm` on `lm`.`match`=`m`.`id`'
                . ' INNER JOIN `dantai_league` as `l` on `lm`.`league`=`l`.`id`'
                . ' WHERE `l`.`series`=' . $data['series']
                . ' AND `l`.`year` = ' . $year_m
                . ' AND `l`.`no` = ' . $data['no']
                 . ' AND `l`.`del`=0';
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['dantai_league_match'][] = json_decode(json_encode($lv2),true);
                }
        	}
            $ret['dantai_league'][] = $data;
        }
	}
/*
    $sql = 'SELECT `l`.`series` as `series`,'
        . '`l`.`no` as `league`,'
        . '`t`.`league_team_index` as `league_team_index`,'
        . '`e`.`disp_order` as `team`'
        . 'FROM `dantai_league_team` as `t`'
        . 'INNER JOIN `dantai_league` as `l` on `t`.`league`=`l`.`id`'
        . 'INNER JOIN `entry_info` as `e` on `t`.`team`=`e`.`id`'
        . ' WHERE `l`.`series` in(' . implode(',', $series_tbl['dantai_league']) . ')'
        . ' AND `l`.`year` = ' . $year . ' AND `l`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['dantai_league_team'][] = json_decode(json_encode($lv));
        }
	}

    $sql = 'SELECT `l`.`series` as `series`,'
        . ' `l`.`no` as `league`,'
        . ' `lm`.`league_match_index` as `league_match_index`,'
        . ' `m`.`place` as `place`,'
        . ' `m`.`place_match_no` as `place_match_no`'
        . ' FROM `dantai_match` as `m`'
        . ' INNER JOIN `dantai_league_match` as `lm` on `lm`.`match`=`m`.`id`'
        . ' INNER JOIN `dantai_league` as `l` on `lm`.`league`=`l`.`id`'
        . ' WHERE `l`.`series` in(' . implode(',', $series_tbl['dantai_league']) . ')'
        . ' AND `l`.`year` = ' . $year_m . ' AND `l`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['dantai_league_match'][] = json_decode(json_encode($lv));
        }
	}
*/
    $sql = 'SELECT * FROM `dantai_tournament`'
        . ' WHERE `series` in(' . implode(',', $series_tbl['dantai_league']) . ')'
        . ' AND `year` = ' . $year . ' AND `del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $data = json_decode(json_encode($lv),true);
            $data['display_place_offset'] = 0;
            $data['dantai_tournament_team'] = [];
            $sql = 'SELECT `t`.`series` as `series`,'
                . '`t`.`no` as `tournament`,'
                . '`tm`.`tournament_team_index` as `tournament_team_index`,'
                . '`e`.`disp_order` as `team`'
                . ' FROM `dantai_tournament_team` as `tm`'
                . ' INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
                . ' LEFT JOIN `entry_info` as `e` on `tm`.`team`=`e`.`id`'
                . ' WHERE `t`.`id`=' . $data['id'];
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['dantai_tournament_team'][] = json_decode(json_encode($lv2),true);
                }
	        }
            $data['dantai_tournament_match'] = [];
            $sql = 'SELECT `t`.`series` as `series`,'
                . ' `t`.`no` as `tournament`,'
                . ' `tm`.`tournament_match_index` as `tournament_match_index`,'
                . ' `m`.`place` as `place`,'
                . ' `m`.`place_match_no` as `place_match_no`'
                . ' FROM `dantai_match` as `m`'
                . ' INNER JOIN `dantai_tournament_match` as `tm` on `tm`.`match`=`m`.`id`'
                . ' INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
                . ' WHERE `t`.`series`=' . $data['series']
                . ' AND `t`.`year` = ' . $year_m . ' AND `t`.`del`=0';
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['dantai_tournament_match'][] = json_decode(json_encode($lv2),true);
                }
	        }
            $ret['dantai_tournament'][] = $data;
        }
	}
/*
    $sql = 'SELECT `t`.`series` as `series`,'
        . '`t`.`no` as `tournament`,'
        . '`tm`.`tournament_team_index` as `tournament_team_index`,'
        . '`e`.`disp_order` as `team`'
        . 'FROM `dantai_tournament_team` as `tm`'
        . 'INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
        . 'INNER JOIN `entry_info` as `e` on `t`.`team`=`e`.`id`'
        . ' WHERE `t`.`series` in(' . implode(',', $series_tbl['dantai_tournament']) . ')'
        . ' AND `t`.`year` = ' . $year . ' AND `t`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['dantai_tournament_team'][] = json_decode(json_encode($lv));
        }
	}

    $sql = 'SELECT `t`.`series` as `series`,'
        . ' `t`.`no` as `tournament`,'
        . ' `tm`.`tournament_match_index` as `tournament_match_index`,'
        . ' `m`.`place` as `place`,'
        . ' `m`.`place_match_no` as `place_match_no`'
        . ' FROM `dantai_match` as `m`'
        . ' INNER JOIN `dantai_tournament_match` as `tm` on `tm`.`match`=`m`.`id`'
        . ' INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
        . ' WHERE `t`.`series` in(' . implode(',', $series_tbl['dantai_tournament']) . ')'
        . ' AND `t`.`year` = ' . $year_m . ' AND `t`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['dantai_tournament_match'][] = json_decode(json_encode($lv));
        }
	}
*/
    $sql = 'SELECT * FROM `kojin_tournament`'
        . ' WHERE `series` in(' . implode(',', $series_tbl['kojin_tournament']) . ')'
        . ' AND `year` = ' . $year . ' AND `del`=0';
//echo $sql;
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $data = json_decode(json_encode($lv),true);
            $data['display_place_offset'] = 0;
            $data['kojin_tournament_player'] = [];
            $sql = 'SELECT `t`.`series` as `series`,'
                . ' `p`.`tournament_player_index` as `tournament_player_index`,'
                . ' `t`.`no` as `tournament`,'
                . ' `e`.`disp_order` as `team`,'
                . ' `p`.`player` as `player`'
                . ' FROM `kojin_tournament_player` as `p`'
                . ' INNER JOIN `kojin_tournament` as `t` on `p`.`tournament`=`t`.`id`'
                . ' LEFT JOIN `entry_info` as `e` on `p`.`team`=`e`.`id`'
                . ' WHERE `t`.`id`=' . $data['id'];
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['kojin_tournament_player'][] = json_decode(json_encode($lv2),true);
                }
	        }

            $data['kojin_tournament_match'] = [];
            $sql = 'SELECT `t`.`series` as `series`,'
                . ' `t`.`no` as `tournament`,'
                . ' `tm`.`tournament_match_index` as `tournament_match_index`,'
                . ' `m`.`place` as `place`,'
                . ' `m`.`place_match_no` as `place_match_no`'
                . ' FROM `kojin_match` as `m`'
                . ' INNER JOIN `kojin_tournament_match` as `tm` on `tm`.`match`=`m`.`id`'
                . ' INNER JOIN `kojin_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
                . ' WHERE `t`.`series`=' . $data['series']
                . ' AND `t`.`year` = ' . $year_m . ' AND `t`.`del`=0';
            $list2 = db_query_list( $dbs, $sql );
            if( count($list2) > 0 ){
                foreach( $list2 as $lv2 ){
                    $data['kojin_tournament_match'][] = json_decode(json_encode($lv2),true);
                }
        	}
            $ret['kojin_tournament'][] = $data;
        }
	}
/*
    $sql = 'SELECT `t`.`series` as `series`,'
        . ' `p`.`tournament_player_index` as `tournament_player_index`,'
        . ' `t`.`no` as `tournament`,'
        . ' `e`.`disp_order` as `team`,'
        . ' `p`.`player` as `player`'
        . ' FROM `kojin_tournament_player` as `p`'
        . ' INNER JOIN `kojin_tournament` as `t` on `p`.`tournament`=`t`.`id`'
        . ' INNER JOIN `entry_info` as `e` on `p`.`team`=`e`.`id`'
        . ' WHERE `t`.`series` in(' . implode(',', $series_tbl['kojin_tournament']) . ')'
        . ' AND `t`.`year` = ' . $year . ' AND `t`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['kojin_tournament_player'][] = json_decode(json_encode($lv));
        }
	}

    $sql = 'SELECT `t`.`series` as `series`,'
        . ' `t`.`no` as `tournament`,'
        . ' `tm`.`tournament_match_index` as `tournament_match_index`,'
        . ' `m`.`place` as `place`,'
        . ' `m`.`place_match_no` as `place_match_no`'
        . ' FROM `kojin_match` as `m`'
        . ' INNER JOIN `kojin_tournament_match` as `tm` on `tm`.`match`=`m`.`id`'
        . ' INNER JOIN `kojin_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
        . ' WHERE `t`.`series` in(' . implode(',', $series_tbl['kojin_tournament']) . ')'
        . ' AND `t`.`year` = ' . $year_m . ' AND `t`.`del`=0';
    $list = db_query_list( $dbs, $sql );
    if( count($list) > 0 ){
        foreach( $list as $lv ){
            $ret['kojin_tournament_match'][] = json_decode(json_encode($lv));
        }
	}
*/
    echo json_encode($ret);