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

    $series = $argv[1];
    if( $series == 0 ){
        echo json_encode($ret);
        exit();
    }
    $year = $argv[2];
    if( $year == 0 ){
        echo json_encode($ret);
        exit();
    }

    $dump_file = 'kendo.' . date('YmdHis') . '.sql';
    $dump = 'mysqldump --single-transaction -h localhost -u keioffice_kendo -phprzjntc keioffice_kendo >' . $dump_file;
    exec($dump);

    $objPage = new form_page();
    $series_info = $objPage->get_series_list( $series );
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

    if( count($series_tbl['dantai_league']) > 0 ){
        $sql = 'SELECT * FROM `dantai_league`'
            . ' WHERE `series` in(' . implode(',', $series_tbl['dantai_league']) . ')'
            . ' AND `year` = ' . $year . ' AND `del`=0';
        $list = db_query_list( $dbs, $sql );
        if( count($list) > 0 ){
            foreach( $list as $lv ){
                $data = json_decode(json_encode($lv),true);
                $data['dantai_league_team'] = [];
                $sql = 'SELECT `l`.`series` as `series`,'
                    . '`l`.`no` as `league_no`,'
                    . '`t`.*,'
                    . '`e`.`disp_order` as `team_order`'
                    . 'FROM `dantai_league_team` as `t`'
                    . 'INNER JOIN `dantai_league` as `l` on `t`.`league`=`l`.`id`'
                    . 'INNER JOIN `entry_info` as `e` on `t`.`team`=`e`.`id`'
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
                    . ' `m`.*,'
                    . ' `e1`.`disp_order` as `team1_order`,'
                    . ' `e2`.`disp_order` as `team2_order`'
                    . ' FROM `dantai_match` as `m`'
                    . ' INNER JOIN `dantai_league_match` as `lm` on `lm`.`match`=`m`.`id`'
                    . ' INNER JOIN `dantai_league` as `l` on `lm`.`league`=`l`.`id`'
                    . ' INNER JOIN `entry_info` as `e1` on `m`.`team1`=`e1`.`id`'
                    . ' INNER JOIN `entry_info` as `e2` on `m`.`team2`=`e2`.`id`'
                    . ' WHERE `l`.`series`=' . $data['series']
                    . ' AND `l`.`year` = ' . $year
                    . ' AND `l`.`no` = ' . $data['no']
                     . ' AND `l`.`del`=0';
                $list2 = db_query_list( $dbs, $sql );
                if( count($list2) > 0 ){
                    foreach( $list2 as $lv2 ){
                        $lm = json_decode(json_encode($lv2),true);
                        $lm['team1'] = $lm['team1_order'];
                        $lm['team2'] = $lm['team2_order'];
                        for( $i1 = 1; $i1 <= 6; $i1++ ){
                            $sql = 'SELECT * from `one_match` where `id`=' . $lm['match'.$i1];
                            $list3 = db_query_list( $dbs, $sql );
                            if( count($list3) == 0 ){
                                $lm['match'.$i1] = null;
                            } else {
                                $lm['match'.$i1] = json_decode(json_encode($list3[0]),true);
                            }
                        }
                        $data['dantai_league_match'][] = $lm;
                    }
            	}
                $ret['dantai_league'][] = $data;
            }
    	}
    }


    if( count($series_tbl['dantai_tournament']) > 0 ){
        $sql = 'SELECT * FROM `dantai_tournament`'
            . ' WHERE `series` in(' . implode(',', $series_tbl['dantai_tournament']) . ')'
            . ' AND `year` = ' . $year . ' AND `del`=0';
        $list = db_query_list( $dbs, $sql );
        if( count($list) > 0 ){
            foreach( $list as $lv ){
                $data = json_decode(json_encode($lv),true);
                $data['dantai_tournament_team'] = [];
                $sql = 'SELECT `t`.`series` as `series`,'
                    . '`t`.`no` as `tournament`,'
                    . '`tm`.`tournament_team_index` as `tournament_team_index`,'
                    . '`e`.`disp_order` as `team`'
                    . 'FROM `dantai_tournament_team` as `tm`'
                    . 'INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
                    . 'LEFT JOIN `entry_info` as `e` on `tm`.`team`=`e`.`id`'
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
//                    . ' `m`.`place` as `place`,'
//                    . ' `m`.`place_match_no` as `place_match_no`'
//                    . ' `m`.`match1` as `match1`'
                    . ' `m`.*,'
                    . ' `e1`.`disp_order` as `team1_order`,'
                    . ' `e2`.`disp_order` as `team2_order`'
                    . ' FROM `dantai_match` as `m`'
                    . ' INNER JOIN `dantai_tournament_match` as `tm` on `tm`.`match`=`m`.`id`'
                    . ' INNER JOIN `dantai_tournament` as `t` on `tm`.`tournament`=`t`.`id`'
                    . ' INNER JOIN `entry_info` as `e1` on `m`.`team1`=`e1`.`id`'
                    . ' INNER JOIN `entry_info` as `e2` on `m`.`team2`=`e2`.`id`'
                    . ' WHERE `t`.`series`=' . $data['series']
                    . ' AND `t`.`year` = ' . $year . ' AND `t`.`del`=0';
                $list2 = db_query_list( $dbs, $sql );
                if( count($list2) > 0 ){
                    foreach( $list2 as $lv2 ){
                        $dm = json_decode(json_encode($lv2),true);
                        $dm['team1'] = $dm['team1_order'];
                        $dm['team2'] = $dm['team2_order'];
                        for( $i1 = 1; $i1 <= 6; $i1++ ){
                            $sql = 'SELECT * from `one_match` where `id`=' . $dm['match'.$i1];
                            $list3 = db_query_list( $dbs, $sql );
                            if( count($list3) == 0 ){
                                $dm['match'.$i1] = null;
                            } else {
                                $dm['match'.$i1] = json_decode(json_encode($list3[0]),true);
                            }
                        }
                        $data['dantai_tournament_match'][] = $dm;
                    }
	            }
                $ret['dantai_tournament'][] = $data;
            }
	    }
    }

    if( count($series_tbl['kojin_tournament']) > 0 ){
        $sql = 'SELECT * FROM `kojin_tournament`'
            . ' WHERE `series` in(' . implode(',', $series_tbl['kojin_tournament']) . ')'
            . ' AND `year` = ' . $year . ' AND `del`=0';
//echo $sql;
        $list = db_query_list( $dbs, $sql );
        if( count($list) > 0 ){
            foreach( $list as $lv ){
                $data = json_decode(json_encode($lv),true);
                $tournament_id = $lv['id'];
                $data['kojin_tournament_player'] = [];
                $sql = 'SELECT `t`.`series` as `series`,'
                    . ' `p`.`tournament_player_index` as `tournament_player_index`,'
                    . ' `t`.`no` as `tournament`,'
                    . ' `e`.`disp_order` as `team`,'
                    . ' `p`.`player` as `player`'
                    . ' FROM `kojin_tournament_player` as `p`'
                    . ' INNER JOIN `kojin_tournament` as `t` on `p`.`tournament`=`t`.`id`'
                    . ' LEFT JOIN `entry_info` as `e` on `p`.`team`=`e`.`id`'
                    . ' WHERE `t`.`id`=' . $tournament_id;
                $list2 = db_query_list( $dbs, $sql );
                if( count($list2) > 0 ){
                    foreach( $list2 as $lv2 ){
                        $data['kojin_tournament_player'][] = json_decode(json_encode($lv2),true);
                    }
    	        }

                $data['kojin_tournament_match'] = [];
                $sql = 'SELECT `tm`.`tournament_match_index` as `tournament_match_index`,'
                    . ' `m`.*'
                    . ' FROM `kojin_tournament_match` as `tm`'
                    . ' INNER JOIN `kojin_match` as `m` on `tm`.`match`=`m`.`id`'
                    . ' WHERE `tm`.`tournament`=' . $tournament_id
                    . ' AND `tm`.`del`=0';
                $list2 = db_query_list( $dbs, $sql );
                if( count($list2) > 0 ){
                    foreach( $list2 as $lv2 ){
                        $km = json_decode(json_encode($lv2),true);
                        $sql = 'SELECT `m`.*,'
                            . ' `e1`.`disp_order` as `player1_order`,'
                            . ' (`m`.`player1` % 256) as `player1_player`,'
                            . ' `e2`.`disp_order` as `player2_order`,'
                            . ' (`m`.`player2` % 256) as `player2_player`'
                            . ' from `one_match` as `m`'
                            . ' LEFT JOIN `entry_info` as `e1` on (`m`.`player1` DIV 256)=`e1`.`id`'
                            . ' LEFT JOIN `entry_info` as `e2` on (`m`.`player2` DIV 256)=`e2`.`id`'
                            . ' where `m`.`id`=' . $km['match'];
                        $list3 = db_query_list( $dbs, $sql );
                        if( count($list3) == 0 ){
                            $km['match'] = null;
                        } else {
                            $m = json_decode(json_encode($list3[0]),true);
                            $m['player1'] = $m['player1_order'];
                            $m['player2'] = $m['player2_order'];
                            $km['match'] = $m;
                        }
                        $data['kojin_tournament_match'][] = json_decode(json_encode($km),true);
                    }
            	}
                $ret['kojin_tournament'][] = $data;
            }
        }
	}

    echo json_encode($ret);