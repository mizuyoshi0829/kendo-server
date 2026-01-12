<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_2b.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_3.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_4.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_5.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_6.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_7_8.php';
//    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_12_13.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_tournament.php';

//    define( '__HTTP_BASE__', 'http://www.i-kendo.net/kendo/');

    $passtbl = array(
        array( 'series' => 4, 'place' => 1, 'pass' => '11', 'top'=>303 ),
        array( 'series' => 4, 'place' => 2, 'pass' => '22', 'top'=>309 ),
        array( 'series' => 4, 'place' => 3, 'pass' => '33', 'top'=>315 ),
        array( 'series' => 4, 'place' => 4, 'pass' => '44', 'top'=>321 ),
        array( 'series' => 4, 'place' => 5, 'pass' => '55', 'top'=>327 ),
        array( 'series' => 4, 'place' => 6, 'pass' => '66', 'top'=>333 ),
        array( 'series' => 4, 'place' => 7, 'pass' => '77', 'top'=>339 ),
        array( 'series' => 4, 'place' => 8, 'pass' => '88', 'top'=>345 )
    );

//echo time()," 0--- <br />";
    session_start();
    $admin = get_field_string_number( $_GET, 'a', 0 );
    $mode = get_field_string( $_POST, 'mode' );
    $objPage = new form_page();
    $objEntry = new form_page_dantai_entry( $objPage );
    $objMatch = new form_page_dantai_match( $objPage );
    $objLeague = new form_page_dantai_league( $objPage );
    $objTournament = new form_page_dantai_tournament( $objPage );
    if( $admin == 1 ){
//$objPage->save_dantai_entry_data_tbl_file(7,8);
        $login = get_field_string_number( $_GET, 'lg', 0 );
        if( $login == 1 ){
            $navi_id = get_field_string_number( $_GET, 'v', 0 );
            if( $navi_id == 0 ){ exit; }
            $place = get_field_string_number( $_GET, 'p', 0 );
            if( $place == 0 ){ exit; }
            $place_match_no = get_field_string_number( $_GET, 'm', 0 );
            if( $place_match_no == 0 ){ exit; }
            $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
            $match = $navi_info['match_id'];
            $series = $navi_info['series'];
//print_r($navi_info);
            $_SESSION['auth_input']['login'] = 1;
            $_SESSION['auth_input']['navi_id'] = $navi_id;
            $_SESSION['auth_input']['series'] = $series;
            $_SESSION['auth_input']['place'] = $place;
            $_SESSION['auth_input']['admin'] = 1;
        } else {
            $navi_id = $_SESSION['auth_input']['navi_id'];
            $place = $_SESSION['auth_input']['place'];
            $series = $_SESSION['auth_input']['series'];
            $place_match_no = get_field_string_number( $_GET, 'm', 0 );
            $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
            $match = $navi_info['match_id'];
        }
    } else {
        if( !isset( $_SESSION['auth_input'] ) ){
            //header( "Location: ".__HTTP_BASE__."input/");
            exit;
        }
        if( $mode == 'login' ){
            $_SESSION['auth_input']['admin'] = 0;
            if( isset($_POST['execlm']) || isset($_POST['exect']) ){
                $_SESSION['auth_input']['series'] = 5;
            } else if( isset($_POST['execlw']) || isset($_POST['exect']) ){
                $_SESSION['auth_input']['series'] = 6;
            } else {
                header( "Location: ".__HTTP_BASE__."input/");
                exit;
            }
            $pass = get_field_string( $_POST, 'pass' );
            $place = 1;
            foreach( $passtbl as $pv ){
                if( $pass == $pv['pass'] ){
                    $_SESSION['auth_input']['login'] = 1;
                    //$_SESSION['auth_input']['series'] = $pv['series'];
                    $_SESSION['auth_input']['place'] = $pv['place'];
                    $_SESSION['auth_input']['admin'] = 0;
                    $navi = $objPage->get_place_navi_data( $_SESSION['auth_input']['place'] );
                    if( isset($_POST['execlm']) ){
                        $match = $navi['league_m'][0]['match'];
                        $navimode = 'league_m';
                        $navipos = 1;
                    } else if(isset($_POST['execlw']) ){
                        $match = $navi['league_w'][0]['match'];
                        $navimode = 'league_w';
                        $navipos = 1;
                    } else if( isset($_POST['exect']) ){
                        $match = $navi['tournament'][0]['match'];
                    }
                    //$match = $pv['top'];
                    break;
                }
                $place++;
            }
        } else {
            $navi_id = $_SESSION['auth_input']['navi_id'];
            $place = $_SESSION['auth_input']['place'];
            $series = $_SESSION['auth_input']['series'];
            if( isset($_POST['direct_move']) ){
                $match = get_field_string_number( $_POST, 'direct', 0 );
            } else {
                $place_match_no = get_field_string_number( $_GET, 'm', 0 );
                $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
                $match = $navi_info['match_id'];
            }
        //    $navi = $objPage->get_place_navi_data( $_SESSION['auth_input']['place'] );
        }
        if( $match == 0 || $_SESSION['auth_input']['login'] != 1 ){
            //header( "Location: ".__HTTP_BASE__."input/");
            exit;
        }
        $place = $_SESSION['auth_input']['place'];
        //$series = $_SESSION['auth_input']['series'];
//print_r($navi_info);
        $series = $navi_info['series'];
        /*
        $param = array(
            'dantai_league' => 1, //$league,
            'dantai_tournament' =>1, //$tournament,
            'kojin_league' => 0,
            'kojin_tournament' => 0
        );
        */
    //    $match = $top_match; //$objPage->get_place_top_match( $param, $place, $series );
    //    if( $match == 0 ){ exit; }
    }
    $inc = dirname(dirname(__FILE__)) . '/admin/class/admin/reg_s' . $navi_info['series_info_id'] . 'd.php';
    if( file_exists( $inc ) ){
        require_once $inc;
    }

    $navi_count = $objPage->get_series_place_navi_data_count( $navi_id, $place );
    $league = get_field_string_number( $_GET, 'l', 0 );
    $league = get_field_string_number( $_GET, 'l', 0 );
    $tournament = get_field_string_number( $_GET, 't', 0 );
    //$command = 'c='.$category;
    $ret = '';
    $match_info = $objPage->get_dantai_match_info( $match );
    $series = get_field_string_number( $match_info, 'series', 0 );
    $series_mw = get_field_string( $match_info, 'series_mw' );
    $league = get_field_string_number( $match_info, 'league', 0 );
    $tournament = get_field_string_number( $match_info, 'tournament', 0 );
    $match_num = get_field_string_number( $match_info, 'match_num', 0 );
    $advance_num = get_field_string_number( $match_info, 'advance_num', 0 );
    $series_info = $objPage->get_series_list( $series );

//print_r($_SESSION);
//echo $match;
//print_r($match_info);

    $update_db = false;
    if( isset( $_POST['fusen1'] ) ){
        if( $match > 0 ){
            if( $mode == 'fusen_clear' ){
                $objPage->set_dantai_fusen( $match, 0, 0 );
            } else if( $mode == 'fusen' ){
                $objPage->set_dantai_fusen( $match, 1, 1 );
            }
            $update_db = true;
        }
    } else if( isset( $_POST['fusen2'] ) ){
        if( $match > 0 ){
            if( $mode == 'fusen_clear' ){
                $objPage->set_dantai_fusen( $match, 0, 0 );
            } else if( $mode == 'fusen' ){
                $objPage->set_dantai_fusen( $match, 1, 2 );
            }
            $update_db = true;
        }
    }
    if( $mode == 'check_exist_match6' ){
        $exist_match6 = get_field_string_number( $_POST, 'exist_match6', 0 );
        $objPage->set_dantai_exist_match6( $match, $exist_match6 );
    } else if( $mode == 'change_player' ){
        $team = get_field_string_number( $_POST, 'team', 0 );
        $player = get_field_string_number( $_POST, 'player', 0 );
        if( $team != 0 && $player != 0 && isset( $_POST['player'.$team.'_'.$player] ) ){
            $p = intval( $_POST['player'.$team.'_'.$player] );
            $n = $_POST['player'.$team.'_change_name_'.$player];
            $objMatch->set_dantai_player( $navi_id, $match, $team, $player, $p, $n, null, $league );
        }
    } else if( $mode == 'check_supporter' ){
        $team = get_field_string_number( $_POST, 'team', 0 );
        $player_index = get_field_string_number( $_POST, 'player_index', 0 );
        $player = get_field_string_number( $_POST, 'player', 0 );
        $player_change_name = get_field_string( $_POST, 'player_change_name' );
        $on = get_field_string_number( $_POST, 'player'.$team.'_supporter_'.$player_index, 0 );
        if( $team != 0 && $player_index != 0 ){
            $objMatch->set_dantai_player( $navi_id, $match, $team, $player, null, null, $on, $league );
            //$objMatch->set_dantai_player_supporter( $navi_id, $match, $team, $player_index, $player, $player_change_name, $on, $league );
        }
    } else if( $mode == 'exchane_flag' ){
        $objPage->set_dantai_exchane_flag( $match );
    } else if( $mode == 'change_referee' ){
        $no = get_field_string_number( $_POST, 'no', 0 );
        $id = get_field_string_number( $_POST, 'referee'.$no, 0 );
        $objMatch->set_dantai_referee( $match, $no, $id );
    }
    if( $league > 0 ){
        $data = $objPage->get_dantai_league_one_result( $match );
        $navimode = 'league_' . $series_mw;
    //    $navi = $objPage->get_dantai_league_match_navi( $match );
    } else if( $tournament > 0 ){
        $data = $objPage->get_dantai_tournament_one_result( $match );
        $navimode = 'tournament';
    //    $navi = $objPage->get_dantai_tournament_match_navi( $match );
//    } else {
//        exit;
    }
//    $place_match_no = intval( $data['place_match_no'] );
    $navi_list = $objPage->get_series_place_all_navi_data( $navi_id, $place );
    for( $i1 = 0; $i1 < $navi_count; $i1++ ){
        if( $place_match_no == $navi_list[$i1]['place_match_no'] ){
            if( $i1 > 0 ){
                $navi_info['prev'] = $objPage->get_series_place_navi_data( $navi_id, $place, $navi_list[$i1-1]['place_match_no'] );
            } else {
                $navi_info['prev'] = null;
            }
            if( $navi_count > 1 && $i1 < $navi_count - 1 ){
                $navi_info['next'] = $objPage->get_series_place_navi_data( $navi_id, $place, $navi_list[$i1+1]['place_match_no'] );
            } else {
                $navi_info['next'] = null;
            }
        }
    }
//print_r($_POST);
//print_r($data);
/*
    if( $league > 0 ){
        if( $series_mw == 'w' ){
            $navipos = 0;
            foreach( $navi['league_w'] as $nv ){
                if( $nv['match'] == $match ){ break; }
                $navipos++;
            }
            if( $navipos > 0 ){
                $navi['prev'] = $navi['league_w'][$navipos-1]['match'];
            }
            if( $navipos >= count($navi['league_w'])-1 ){
                if( count($navi['league_m']) > 0 ){
                    $navi['next'] = $navi['league_m'][0]['match'];
                }
            } else {
                $navi['next'] = $navi['league_w'][$navipos+1]['match'];
            }
        } else if( $series_mw == 'm' ){
            $navipos = 0;
            foreach( $navi['league_m'] as $nv ){
                if( $nv['match'] == $match ){ break; }
                $navipos++;
            }
            if( $navipos == 0 ){
                if( count($navi['league_w']) > 0 ){
                    $navi['prev'] = $navi['league_w'][count($navi['league_w'])-1]['match'];
                }
            } else {
                $navi['prev'] = $navi['league_m'][$navipos-1]['match'];
            }
            if( $navipos >= count($navi['league_m'])-1 ){
                if( count($navi['tournament']) > 0 ){
                    $navi['next'] = $navi['tournament'][0]['match'];
                }
            } else {
                $navi['next'] = $navi['league_m'][$navipos+1]['match'];
            }
        }
    } else if( $tournament > 0 ){
            $navipos = 0;
            foreach( $navi['tournament'] as $nv ){
                if( $nv['match'] == $match ){ break; }
                $navipos++;
            }
        if( $navipos == 0 ){
            if( count($navi['league_m']) > 0 ){
                $navi['prev'] = $navi['league_m'][count($navi['league_m'])-1]['match'];
            }
        } else {
            $navi['prev'] = $navi['tournament'][$navipos-1]['match'];
        }
        if( $navipos < count($navi['tournament']) ){
            $navi['next'] = $navi['tournament'][$navipos+1]['match'];
        }
    }
*/
//print_r($data['matches']);
//    $series_mw = $data['series_mw'];
//    $update_db = false;
    $input_match_no = 0;
    $input_cancel = false;
    if( isset( $_POST['input_cancel'] ) ){
        $input_cancel = true;
    }
    if( isset( $_POST['input_update'] ) || isset( $_POST['input_update_noend'] ) ){
        $input_match_no = get_field_string_number( $_POST, 'input_match_no', 0 );
        if( $input_match_no > 0 ){
            $data['matches'][$input_match_no]['player1'] = get_field_string_number( $_POST, 'input_player1', 0 );
            $data['matches'][$input_match_no]['player1_change_name'] = get_field_string( $_POST, 'input_player1_change_name' );
            $data['matches'][$input_match_no]['faul1_1'] = get_field_string_number( $_POST, 'input_faul1_1', 0 );
            $data['matches'][$input_match_no]['faul1_2'] = get_field_string_number( $_POST, 'input_faul1_2', 0 );
            $data['matches'][$input_match_no]['waza1_1'] = get_field_string_number( $_POST, 'input_waza1_1', 0 );
            $data['matches'][$input_match_no]['waza1_2'] = get_field_string_number( $_POST, 'input_waza1_2', 0 );
            $data['matches'][$input_match_no]['waza1_3'] = get_field_string_number( $_POST, 'input_waza1_3', 0 );
            $data['matches'][$input_match_no]['player2'] = get_field_string_number( $_POST, 'input_player2', 0 );
            $data['matches'][$input_match_no]['player2_change_name'] = get_field_string( $_POST, 'input_player2_change_name' );
            $data['matches'][$input_match_no]['faul2_1'] = get_field_string_number( $_POST, 'input_faul2_1', 0 );
            $data['matches'][$input_match_no]['faul2_2'] = get_field_string_number( $_POST, 'input_faul2_2', 0 );
            $data['matches'][$input_match_no]['waza2_1'] = get_field_string_number( $_POST, 'input_waza2_1', 0 );
            $data['matches'][$input_match_no]['waza2_2'] = get_field_string_number( $_POST, 'input_waza2_2', 0 );
            $data['matches'][$input_match_no]['waza2_3'] = get_field_string_number( $_POST, 'input_waza2_3', 0 );
            $data['matches'][$input_match_no]['extra'] = get_field_string_number( $_POST, 'extra', 0 );
            $data['matches'][$input_match_no]['match_time_minute'] = get_field_string( $_POST, 'match_time_minute' );
            $data['matches'][$input_match_no]['match_time_second'] = get_field_string( $_POST, 'match_time_second' );
            if(
                $data['matches'][$input_match_no]['match_time_minute'] == ''
                && $data['matches'][$input_match_no]['match_time_second'] == ''
            ){
                $data['matches'][$input_match_no]['match_time'] = '';
            } else {
                $data['matches'][$input_match_no]['match_time'] = $data['matches'][$input_match_no]['match_time_minute'] . '分' . $data['matches'][$input_match_no]['match_time_second'] . '秒';
            }
            if( isset( $_POST['input_update'] ) ){
                $data['matches'][$input_match_no]['end_match'] = 1;
            }
            $update_db = true;
        }
    }
//print_r($data['matches']);
    $result1 = 0;
    $result1str = '';
    $result2 = 0;
    $result2str = '';
    $match_end = 0;
    if( $data['fusen'] == 1 ){
        if( $data['winner'] == 1 ){
            $result1 = 1;
            $result1str = '不戦勝';
        } else if( $data['winner'] == 2 ){
            $result2 = 1;
            $result2str = '不戦勝';
        }
        if( $update_db ){
            $hon1 = array(0,0,0,0,0,0);
            $hon2 = array(0,0,0,0,0,0);
            $win = array(0,0,0,0,0,0);
            $list = array(
                'p' => $data['matches'],
                'hon1' => $hon1,
                'hon2' => $hon2,
                'win' => $win,
                'win1sum' => 0,
                'win2sum' => 0,
                'hon1sum' => 0,
                'hon2sum' => 0,
                'winner' => $data['winner']
            );
            if( $league > 0 ){
                $objLeague->update_dantai_league_one_result( $series, $league, $match, $list, $advance_num );
            } else if( $tournament > 0 ){
                $objTournament->update_dantai_tournament_one_result( $tournament, $match, $input_match_no, $list, $match_num );
            }
        }
        $match_end = 1;
    } else {
        $win1 = array();
        $win1str = array();
        $win1sum = 0;
        $hon1 = array();
        $hon1sum = 0;
        $win2 = array();
        $win2str = array();
        $win2sum = 0;
        $hon2 = array();
        $hon2sum = 0;
        $endnum = 0;
        $win = array();
        $winner = -1;
        for( $i1 = 1; $i1 <= 6; $i1++ ){
            $win1[$i1] = 0;
            $win1str[$i1] = '';
            $hon1[$i1] = 0;
            $win2[$i1] = 0;
            $win2str[$i1] = '';
            $hon2[$i1] = 0;
            $win[$i1] = 0;
            if( $i1 == 6 ){
                if( $endnum == 5 ){
                    if( $win1sum > $win2sum ){
                        $result1 = 1;
                        $result1str = '○';
                        $result2 = 0;
                        $result2str = '△';
                        $winner = 1;
                        break;
                    } else if( $win1sum < $win2sum ){
                        $result1 = 0;
                        $result1str = '△';
                        $result2 = 1;
                        $result2str = '○';
                        $winner = 2;
                        break;
                    } else {
                        if( $hon1sum > $hon2sum ){
                            $result1 = 1;
                            $result1str = '○';
                            $result2 = 0;
                            $result2str = '△';
                            $winner = 1;
                            break;
                        } else if( $hon1sum < $hon2sum ){
                            $result1 = 0;
                            $result1str = '△';
                            $result2 = 1;
                            $result2str = '○';
                            $winner = 2;
                            break;
                        } else {
                            if( $data['exist_match6'] == 0 ){
                                $result1 = 0;
                                $result1str = '□';
                                $result2 = 0;
                                $result2str = '□';
                                $winner = 0;
                                break;
                            }
                        }
                    }
                }
            }
            if( $i1 <= 5 ){
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if( $data['matches'][$i1]['waza1_'.$i2] != 0 ){
                        $hon1[$i1]++;
                    }
                    if( $data['matches'][$i1]['waza2_'.$i2] != 0 ){
                        $hon2[$i1]++;
                    }
                }
                $hon1sum += $hon1[$i1];
                $hon2sum += $hon2[$i1];
                if( $data['matches'][$i1]['end_match'] == 1 ){
                    $endnum++;
                    if( $hon1[$i1] > $hon2[$i1] ){
                        $win1[$i1] = 1;
                        $win1str[$i1] = '○';
                        $win2str[$i1] = '△';
                        $win[$i1] = 1;
                        $win1sum++;
                    } else if( $hon1[$i1] < $hon2[$i1] ){
                        $win2[$i1] = 1;
                        $win1str[$i1] = '△';
                        $win2str[$i1] = '○';
                        $win[$i1] = 2;
                        $win2sum++;
                    } else {
                        $win1str[$i1] = '□';
                        $win2str[$i1] = '□';
                        $win[$i1] = 0;
                    }
                }
            }
            if( $i1 == 6 ){
                if( $data['exist_match6'] == 1 && $endnum == 5 ){
                    if( $data['matches'][6]['waza1_1'] != 0 ){
                        $result1 = 1;
                        $result1str = '○';
                        $result2 = 0;
                        $result2str = '△';
                        $winner = 1;
                    } else if( $data['matches'][6]['waza2_1'] != 0 ){
                        $result1 = 0;
                        $result1str = '△';
                        $result2 = 1;
                        $result2str = '○';
                        $winner = 2;
                    } else {
                        $result1 = 0;
                        $result1str = '□';
                        $result2 = 0;
                        $result2str = '□';
                        $winner = 0;
                    }
                }
            }
        }
        if( $update_db ){
            $list = array(
                'p' => $data['matches'],
                'hon1' => $hon1,
                'hon2' => $hon2,
                'win' => $win,
                'win1sum' => $win1sum,
                'win2sum' => $win2sum,
                'hon1sum' => $hon1sum,
                'hon2sum' => $hon2sum,
                'winner' => $winner
            );
//echo time()," 1<br />";
            if( $league > 0 ){
                $objLeague->update_dantai_league_one_result( $series, $league, $match, $list, $advance_num );
            } else if( $tournament > 0 ){
                $objTournament->update_dantai_tournament_one_result( $tournament, $match, $input_match_no, $list, $match_num );
            }
//echo time()," 2<br />";
        }
        if( $winner != -1 ){ $match_end = 1; }
    }
    if( $_SESSION['auth_input']['admin'] != 1 ){
        $objPage->update_navi_current_input_match_no( $navi_id, $place, $place_match_no, 0 );
    }
    $contents = file_get_contents(
        __HTTP_BASE__.'result/resultapi.php?n=1&p='.$place.'&v='.$navi_id
    );
    if( $match_end == 1 || $update_db || $input_cancel ){
        if( $league > 0 ){
//echo time()," 3 <br />";
			$league_param = $objLeague->get_dantai_league_parameter( $series );
            $league_data = $objLeague->get_dantai_league_list( $series, $series_mw, $league_param );
//echo time()," 4<br />";
            $entry_list = $objPage->get_entry_data_list3( $series, $series_mw );
//echo time()," 5<br />";
            $qdata = [
                'series' => $series,
                'mw' => $series_mw,
                'lt' => 'dl',
                'output_match' => 1,
            ];
            if( $match_end == 1 ){
                $qdata['output_result'] = 1;
                $func = 'output_league_'.$series.'_for_HTML';
	            $func( $series_info, $league_param, $league_data, $entry_list, $series_mw );
            } else {
                $qdata['output_result'] = 0;
            }
//echo time()," 6<br />";
			$func = 'output_league_match_for_HTML2_'.$series;
			$func( $series_info, $league_param, $league_data, $entry_list, $series_mw );
            //$objPage->update_result_queue( $qdata, true );
//echo time()," ---<br />";
        } else {
            $tournament_list = $objPage->get_dantai_tournament_data( $series, $series_mw );
            $entry_list = $objPage->get_entry_data_list3( $series, $series_mw );
            //$objPage->output_dantai_tournament_for_HTML( $navi_info, $tournament_list, $entry_list, $series_mw );
            //$objPage->output_tournament_match_for_HTML2( $objPage, $navi_info, $tournament_list, $entry_list, $series_mw, $navi_info['split_tournament_match_output'] );
            //$func = 'output_tournament_' . $series . '_for_HTML';
            //$html = $func( $navi_info['result_path'], $tournament_data, $entry_list );

            //$func = 'output_tournament_match_for_HTML2_'.$series;
            //$func( $objPage, $navi_info['result_path'], $tournament_list, $entry_list, $series_mw );

            if( $match_end == 1 ){
    			$func = 'output_tournament_' . $series . '_for_HTML';
	    		$html = $func( $series_info, $tournament_list, $entry_list, $series_mw );
            }
			$func = 'output_tournament_match_for_HTML2_'.$series;
			$func( $series_info, $tournament_list, $entry_list, $series_mw );


            //$html = $objPage->output_tournament_match_for_HTML( $match );
            //$file = __UPLOAD_RESULT_PATH__.'/d'.sprintf('%03d',$match).'.html';
            //$fp = fopen( $file, 'w' );
            //fwrite( $fp, $html );
            //fclose( $fp );
        }
        if( $match_end == 1 && $series_info['output_match_result_pdf'] == 1 ){
            $pdata = [
                'navi_id' => $navi_id,
                'place' => $place,
                'place_match_no' => $place_match_no,
            ];
            $objPage->update_pdf_queue( $pdata, true );
            //$objMatch->output_dantai_one_match_pdf2( $navi_id, $place, $place_match_no );
        }
    }
    $referee_list = $objMatch->get_referee_list( $series );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>試合結果入力フォーム</title>
<link href="result02.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function jump_direct()
{
    var addr = [
<?php foreach( $navi_list as $nl ): ?>
        '<?php echo $nl['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $nl['place_match_no']; ?>',
<?php endforeach; ?>
    ];
    var obj1 = document.getElementById("direct");
    var match = new Number( obj1.value );
    window.location.href = addr[match-1];
    //var obj1 = document.getElementById("direct");
    //window.location.href = 'dantai_result.php?a=<?php echo $admin; ?>&m='+obj1.value;
}
</script>
</head>

<body>
<!--
<?php //print_r($data); ?>
<?php //print_r($_POST); ?>
<?php //echo DATABASE_NAME; ?>
-->
<div>
  <div class="content">
    <h1 align="left" class="tx-h1"><?php echo $navi_info['match_name']; ?></h1>
    <h2 align="left" class="tx-h1"><?php echo $navi_info['place_name']; ?>&nbsp;<?php if($admin!=1 && !is_null($navi_info['prev'])): ?><a href="<?php echo $navi_info['prev']['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $navi_info['prev']['place_match_no']; ?>">←前の試合</a>&nbsp;<?php endif; ?><?php echo $navi_info['place_match_no_name']; ?><?php if($admin!=1 && !is_null($navi_info['next'])): ?>&nbsp;<a href="<?php echo $navi_info['next']['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $navi_info['next']['place_match_no']; ?>">次の試合→</a><?php endif; ?><br />
      直接移動: <select name="direct" id="direct" onChange="jump_direct();">
<?php for( $i1 = 1; $i1 <= $navi_count; $i1++ ): ?>
          <option value="<?php echo $i1; ?>"<?php if( $place_match_no == $navi_list[$i1-1]['place_match_no'] ): ?> selected="selected"<?php endif; ?>><?php echo $navi_list[$i1-1]['place_match_no_name']; ?></option>
<?php endfor; ?>
      </select>

<?php if( $_SESSION['auth_input']['admin'] == 11 ): ?>
      <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
        <select name="direct">
<?php foreach( $navi['league_w'] as $nv ): ?>
          <option value="<?php echo $nv['match']; ?>"><?php echo $nv['match_name'],'&nbsp;',$nv['place_match_no']; ?></option>
<?php endforeach; ?>
<?php foreach( $navi['league_m'] as $nv ): ?>
          <option value="<?php echo $nv['match']; ?>"><?php echo $nv['match_name'],'&nbsp;',$nv['place_match_no']; ?></option>
<?php endforeach; ?>
<?php foreach( $navi['tournament'] as $nv ): ?>
          <option value="<?php echo $nv['match']; ?>"><?php echo $nv['match_name'],'&nbsp;',$nv['place_match_no']; ?></option>
<?php endforeach; ?>
        </select>
        <input name="direct_move" type="submit" class="" id="r-ab1" value="直接移動" />
      </form>
<?php endif; ?>
    </h2>
    <div align="center" class="tbscorein">
<!--    <form action="dantai_result_input.php?<?php echo $command; ?>&m=<?php echo $place_match_no; ?>" method="post" taregt="_blank"> -->
      <input name="check_end1" type="hidden" value="<?php echo $p['check_end1']; ?>" />
      <input name="check_end2" type="hidden" value="<?php echo $p['check_end2']; ?>" />
      <input name="check_end3" type="hidden" value="<?php echo $p['check_end3']; ?>" />
      <input name="check_end4" type="hidden" value="<?php echo $p['check_end4']; ?>" />
      <input name="check_end5" type="hidden" value="<?php echo $p['check_end5']; ?>" />
      <input name="check_end6" type="hidden" value="<?php echo $p['check_end6']; ?>" />
      <table class="tb_score_in" width="960" border="0">
        <tr>
          <td colspan="2" class="tbnamecolor">学校名</td>
          <td colspan="3" class="tbnamecolor"><span class="tb_srect">先鋒</span></td>
          <td colspan="3" class="tbnamecolor"><span class="tb_srect">次鋒</span></td>
          <td colspan="3" class="tbnamecolor"><span class="tb_srect">中堅</span></td>
          <td colspan="3" class="tbnamecolor"><span class="tb_srect">副将</span></td>
          <td colspan="3" class="tbnamecolor"><span class="tb_srect">大将</span></td>
          <td class="tbname01">&nbsp;</td>
          <td colspan="3" class="tbnamecolor">代表戦</td>
          <td class="tbname01">勝敗</td>
        </tr>
        <tr>
          <td colspan="2" class="tbnamecolor"><?php echo $objPage->get_pref_name(null,get_field_string($data['entry1'],'school_address_pref',0));?></td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbnamecolor2"><?php echo $win1str[$i1]; ?></td>
<?php endfor; ?>
          <td class="tbname01"><div align="center">本数</div></td>
          <td colspan="3" class="tbnamecolor2">&nbsp;</td>
          <td rowspan="4" class="tbname01 tx-large"><?php echo $result1str; ?></td>
        </tr>
        <tr>
          <td colspan="2" rowspan="3" class="tbnamecolor">
<?php
    $fontlen = mb_strlen( get_field_string($data['entry1'],'school_name_ryaku'),'UTF-8' );
    if( $fontlen >= 8 ){
        echo '            <span class="tbsmallfont9">';
    } else {
        echo '            <span>';
    }
?>
            <?php echo get_field_string($data['entry1'],'school_name_ryaku');?></span><br />
<?php if( $data['fusen'] == 1 && $data['winner'] == 1 ): ?>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="fusen1" type="submit" class="" id="r-ab1" value="不戦勝取り消し" />
              <input name="mode" type="hidden" value="fusen_clear" />
            </form>
<?php else: ?>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="fusen1" type="submit" class="" id="r-ab1" value="不戦勝" />
              <input name="mode" type="hidden" value="fusen" />
            </form>
<?php endif; ?>
          </td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01 tb_srect">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_player" />
              <input name="team" type="hidden" value="1" />
              <input name="player" type="hidden" value="<?php echo $i1; ?>" />
              <select name="player1_<?php echo $i1; ?>" class="tb_srect" id="player1_<?php echo $i1; ?>" onChange="submit();">
                <option value="0"<?php if( $data['matches'][$i1]['player1'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php
    for( $i2 = 1; $i2 <= 7; $i2++ ){
        $dantai_name_field_header = $objMatch->get_dantai_name_field_header( $series_info, $series_mw, $i2 );
?>
                <option value="<?php echo $i2; ?>" <?php if( $data['matches'][$i1]['player1'] == $i2 ): ?>selected="selected"<?php endif; ?>>
<?php if( isset($data['entry1'][$dantai_name_field_header.'_disp']) && $data['entry1'][$dantai_name_field_header.'_disp'] !== '' ): ?>
                    <?php echo $data['entry1'][$dantai_name_field_header.'_disp']; ?>
<?php elseif( isset($data['entry1'][$dantai_name_field_header.'_sei']) && $data['entry1'][$dantai_name_field_header.'_sei'] !== '' ): ?>
                    <?php echo $data['entry1'][$dantai_name_field_header.'_sei'],' ',$data['entry1'][$dantai_name_field_header.'_mei']; ?>
<?php endif; ?>
                </option>
<?php
    }
?>
<!--
                <option value="8"<?php if( $data['matches'][$i1]['player1'] == 8 ): ?> selected="selected"<?php endif; ?>>補員3</option>
                <option value="9"<?php if( $data['matches'][$i1]['player1'] == 9 ): ?> selected="selected"<?php endif; ?>>補員4</option>
                <option value="10"<?php if( $data['matches'][$i1]['player1'] == 10 ): ?> selected="selected"<?php endif; ?>>補員5</option>
-->
                <option value="1000"<?php if( $data['matches'][$i1]['player1'] == 1000 ): ?> selected="selected"<?php endif; ?>>その他</option>
              </select><br />
              <input name="player1_change_name_<?php echo $i1; ?>" type="text" size="6" value="<?php echo $data['matches'][$i1]['player1_change_name']; ?>" />
              <input name="exec_player1_change_name_<?php echo $i1; ?>" type="submit" class="" id="exec_player1_change_name_<?php echo $i1; ?>" value="変更" />
            </form>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input type="checkbox" name="player1_supporter_<?php echo $i1; ?>" id="player1_supporter_<?php echo $i1; ?>" value="1" <?php if($data['matches'][$i1]['supporter1']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />サポーター
              <input name="mode" type="hidden" value="check_supporter" />
              <input name="team" type="hidden" value="1" />
              <input name="player_index" type="hidden" value="<?php echo $i1; ?>" />
              <input name="player" type="hidden" value="<?php echo $data['matches'][$i1]['player1']; ?>" />
              <input name="player_change_name" type="hidden" value="<?php echo $data['matches'][$i1]['player1_change_name']; ?>" />
            </form>
          </td>
<?php endfor; ?>
          <td class="tbname01"><div align="center"><?php echo $hon1sum; ?></div></td>
          <td colspan="3" class="tbname01 tb_srect">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_player" />
              <input name="team" type="hidden" value="1" />
              <input name="player" type="hidden" value="6" />
              <select name="player1_6" class="tb_srect" id="player1_6" onChange="submit();">
                <option value="0"<?php if( $data['matches'][6]['player1'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php
    for( $i2 = 1; $i2 <= 7; $i2++ ){
        $dantai_name_field_header = $objMatch->get_dantai_name_field_header( $series_info, $series_mw, $i2 );
?>
                <option value="<?php echo $i2; ?>" <?php if( $data['matches'][6]['player1'] == $i2 ): ?>selected="selected"<?php endif; ?>>
<?php if( isset($data['entry1'][$dantai_name_field_header.'_disp']) && $data['entry1'][$dantai_name_field_header.'_disp'] !== '' ): ?>
                  <?php echo $data['entry1'][$dantai_name_field_header.'_disp']; ?>
<?php elseif( isset($data['entry1'][$dantai_name_field_header.'_sei']) && $data['entry1'][$dantai_name_field_header.'_sei'] !== '' ): ?>
                  <?php echo $data['entry1'][$dantai_name_field_header.'_sei'],' ',$data['entry1'][$dantai_name_field_header.'_mei']; ?>
<?php endif; ?>
                </option>
<?php
    }
?>
                <option value="1000"<?php if( $data['matches'][6]['player1'] == 1000 ): ?> selected="selected"<?php endif; ?>>その他</option>
              </select><br />
              <input name="player1_change_name_6" type="text" size="6" value="<?php echo $data['matches'][6]['player1_change_name']; ?>" />
              <input name="exec_player1_change_name_6" type="submit" class="" id="exec_player1_change_name_6" value="変更" />
            </form>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input type="checkbox" name="player1_supporter_6" id="player1_supporter_6" value="1" <?php if($data['matches'][6]['supporter1']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />サポーター
              <input name="mode" type="hidden" value="check_supporter" />
              <input name="team" type="hidden" value="1" />
              <input name="player_index" type="hidden" value="6" />
              <input name="player" type="hidden" value="<?php echo $data['matches'][6]['player1']; ?>" />
              <input name="player_change_name" type="hidden" value="<?php echo $data['matches'][6]['player1_change_name']; ?>" />
            </form>
          </td>
        </tr>
        <tr>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][$i1]['faul1_1']==2): ?>指<?php endif; ?>
            <?php if($data['matches'][$i1]['faul1_2']==1): ?>▲<?php endif; ?>
          </td>
<?php endfor; ?>
          <td class="tbname01"><div align="center">勝数</div></td>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][6]['faul1_1']==2): ?>指<?php endif; ?>
            <?php if($data['matches'][6]['faul1_2']==1): ?>▲<?php endif; ?>
          </td>
        </tr>
        <tr>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
<?php for( $i2 = 1; $i2 <= 3; $i2++ ): ?>
          <td class="tbname01 tb_srect">
            <?php if($data['matches'][$i1]['waza1_'.$i2]==0): ?><?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==1): ?>メ<?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==2): ?>ド<?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==3): ?>コ<?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==4): ?>反<?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==5): ?>不戦勝<?php endif; ?>
            <?php if($data['matches'][$i1]['waza1_'.$i2]==6): ?>ツ<?php endif; ?>
          </td>
<?php endfor; ?>
<?php endfor; ?>
          <td class="tbname01"><div align="center"><?php echo $win1sum; ?></div></td>
<?php for( $i2 = 1; $i2 <= 3; $i2++ ): ?>
          <td class="tbname01 tb_srect">
            <?php if($data['matches'][6]['waza1_'.$i2]==0): ?><?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==1): ?>メ<?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==2): ?>ド<?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==3): ?>コ<?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==4): ?>反<?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==5): ?>不戦勝<?php endif; ?>
            <?php if($data['matches'][6]['waza1_'.$i2]==6): ?>ツ<?php endif; ?>
          </td>
<?php endfor; ?>
        </tr>
        <tr>
          <td colspan="2" class="tbnamecolor tb_srect">&nbsp;</td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][$i1]['extra']==1): ?>延<?php else: ?>&nbsp;<?php endif; ?>
          </td>
<?php endfor; ?>
          <td class="tbname01 tb_srect">&nbsp;</td>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][6]['extra']==1): ?>延<?php else: ?>&nbsp;<?php endif; ?>
          </td>
          <td class="tbname01 tb_srect">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="tbnamecolor tbprefname"><?php echo $objPage->get_pref_name(null,get_field_string_number($data['entry2'],'school_address_pref',0));?></td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
<?php for( $i2 = 1; $i2 <= 3; $i2++ ): ?>
          <td class="tbname01 tb_srect">
            <?php if($data['matches'][$i1]['waza2_'.$i2]==0): ?><?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==1): ?>メ<?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==2): ?>ド<?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==3): ?>コ<?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==6): ?>ツ<?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==4): ?>反<?php endif; ?>
            <?php if($data['matches'][$i1]['waza2_'.$i2]==5): ?>不戦勝<?php endif; ?>
          </td>
<?php endfor; ?>
<?php endfor; ?>
          <td class="tbname01"><div align="center">本数</div></td>
<?php for( $i2 = 1; $i2 <= 3; $i2++ ): ?>
          <td class="tbname01 tb_srect">
            <?php if($data['matches'][6]['waza2_'.$i2]==0): ?><?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==1): ?>メ<?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==2): ?>ド<?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==3): ?>コ<?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==6): ?>ツ<?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==4): ?>反<?php endif; ?>
            <?php if($data['matches'][6]['waza2_'.$i2]==5): ?>不戦勝<?php endif; ?>
          </td>
<?php endfor; ?>
          <td rowspan="4" class="tbname01 tx-large"><?php echo $result2str; ?></td>
        </tr>
        <tr>
          <td colspan="2" rowspan="3" class="tbnamecolor">
<?php
    $fontlen = mb_strlen( get_field_string($data['entry2'],'school_name_ryaku'),'UTF-8' );
    if( $fontlen >= 8 ){
        echo '            <span class="tbsmallfont9">';
    } else {
        echo '            <span>';
    }
?>
<?php echo get_field_string($data['entry2'],'school_name_ryaku');?></span>
<?php if( $data['fusen'] == 1 && $data['winner'] == 2 ): ?>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="fusen2" type="submit" class="" id="r-ab1" value="不戦勝取り消し" />
              <input name="mode" type="hidden" value="fusen_clear" />
            </form>
<?php else: ?>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="fusen2" type="submit" class="" id="r-ab1" value="不戦勝" />
              <input name="mode" type="hidden" value="fusen" />
            </form>
<?php endif; ?>
          </td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][$i1]['faul2_1']==2): ?>指<?php endif; ?>
            <?php if($data['matches'][$i1]['faul2_2']==1): ?>▲<?php endif; ?>
          </td>
<?php endfor; ?>
          <td class="tbname01"><div align="center"><?php echo $hon2sum; ?></div></td>
          <td colspan="3" class="tbname01 tb_srect">
            <?php if($data['matches'][6]['faul2_1']==2): ?>指<?php endif; ?>
            <?php if($data['matches'][6]['faul2_2']==1): ?>▲<?php endif; ?>
          </td>
        </tr>
        <tr>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01 tb_srect">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_player" />
              <input name="team" type="hidden" value="2" />
              <input name="player" type="hidden" value="<?php echo $i1; ?>" />
              <select name="player2_<?php echo $i1; ?>" class="tb_srect" id="player2_<?php echo $i1; ?>" onChange="submit();">
                <option value="0"<?php if( $data['matches'][$i1]['player2'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php
    for( $i2 = 1; $i2 <= 7; $i2++ ){
        $dantai_name_field_header = $objMatch->get_dantai_name_field_header( $series_info, $series_mw, $i2 );
?>
                <option value="<?php echo $i2; ?>" <?php if( $data['matches'][$i1]['player2'] == $i2 ): ?>selected="selected"<?php endif; ?>>
<?php if( isset($data['entry2'][$dantai_name_field_header.'_disp']) && $data['entry2'][$dantai_name_field_header.'_disp'] !== '' ): ?>
                    <?php echo $data['entry2'][$dantai_name_field_header.'_disp']; ?>
<?php elseif( isset($data['entry2'][$dantai_name_field_header.'_sei']) && $data['entry2'][$dantai_name_field_header.'_sei'] !== '' ): ?>
                    <?php echo $data['entry2'][$dantai_name_field_header.'_sei'],' ',$data['entry2'][$dantai_name_field_header.'_mei']; ?>
<?php endif; ?>
                </option>
<?php
    }
?>
<!--
                <option value="8"<?php if( $data['matches'][$i1]['player2'] == 8 ): ?> selected="selected"<?php endif; ?>>補員3</option>
                <option value="9"<?php if( $data['matches'][$i1]['player2'] == 9 ): ?> selected="selected"<?php endif; ?>>補員4</option>
                <option value="10"<?php if( $data['matches'][$i1]['player2'] == 10 ): ?> selected="selected"<?php endif; ?>>補員5</option>
-->
                <option value="1000"<?php if( $data['matches'][$i1]['player2'] == 1000 ): ?> selected="selected"<?php endif; ?>>その他</option>
              </select><br />
              <input name="player2_change_name_<?php echo $i1; ?>" type="text" size="6" value="<?php echo $data['matches'][$i1]['player2_change_name']; ?>" />
              <input name="exec_player2_change_name_<?php echo $i1; ?>" type="submit" class="" id="exec_player2_change_name_<?php echo $i1; ?>" value="変更" />
            </form>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input type="checkbox" name="player2_supporter_<?php echo $i1; ?>" id="player2_supporter_<?php echo $i1; ?>" value="1" <?php if($data['matches'][$i1]['supporter2']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />サポーター
              <input name="mode" type="hidden" value="check_supporter" />
              <input name="team" type="hidden" value="2" />
              <input name="player_index" type="hidden" value="<?php echo $i1; ?>" />
              <input name="player" type="hidden" value="<?php echo $data['matches'][$i1]['player2']; ?>" />
              <input name="player_change_name" type="hidden" value="<?php echo $data['matches'][$i1]['player2_change_name']; ?>" />
            </form>
          </td>
<?php endfor; ?>
          <td class="tbname01"><div align="center">勝数</div></td>
          <td colspan="3" class="tbname01 tb_srect">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_player" />
              <input name="team" type="hidden" value="2" />
              <input name="player" type="hidden" value="6" />
              <select name="player2_6" class="tb_srect" id="player2_6" onChange="submit();">
                <option value="0"<?php if( $data['matches'][6]['player2'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php
    for( $i2 = 1; $i2 <= 7; $i2++ ){
        $dantai_name_field_header = $objMatch->get_dantai_name_field_header( $series_info, $series_mw, $i2 );
?>
                <option value="<?php echo $i2; ?>" <?php if( $data['matches'][6]['player2'] == $i2 ): ?>selected="selected"<?php endif; ?>>
<?php if( isset($data['entry2'][$dantai_name_field_header.'_disp']) && $data['entry2'][$dantai_name_field_header.'_disp'] !== '' ): ?>
                  <?php echo $data['entry2'][$dantai_name_field_header.'_disp']; ?>
<?php elseif( isset($data['entry2'][$dantai_name_field_header.'_sei']) && $data['entry2'][$dantai_name_field_header.'_sei'] !== '' ): ?>
                  <?php echo $data['entry2'][$dantai_name_field_header.'_sei'],' ',$data['entry2'][$dantai_name_field_header.'_mei']; ?>
<?php endif; ?>
                </option>
<?php
    }
?>
                <option value="1000"<?php if( $data['matches'][6]['player2'] == 1000 ): ?> selected="selected"<?php endif; ?>>その他</option>
              </select><br />
              <input name="player2_change_name_6" type="text" size="6" value="<?php echo $data['matches'][6]['player2_change_name']; ?>" />
              <input name="exec_player2_change_name_6" type="submit" class="" id="exec_player2_change_name_6" value="変更" />
            </form>
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input type="checkbox" name="player2_supporter_6" id="player2_supporter_6" value="1" <?php if($data['matches'][6]['supporter2']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />サポーター
              <input name="mode" type="hidden" value="check_supporter" />
              <input name="team" type="hidden" value="2" />
              <input name="player_index" type="hidden" value="6" />
              <input name="player" type="hidden" value="<?php echo $data['matches'][6]['player2']; ?>" />
              <input name="player_change_name" type="hidden" value="<?php echo $data['matches'][6]['player2_change_name']; ?>" />
            </form>
          </td>
        </tr>
        <tr>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbnamecolor2"><?php echo $win2str[$i1]; ?></td>
<?php endfor; ?>
          <td class="tbname01"><div align="center"><?php echo $win2sum; ?></div></td>
          <td colspan="3" class="tbnamecolor2"><?php echo $win2str[6]; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="tbnamecolor">試合時間</td>
<?php for( $i1 = 1; $i1 <= 5; $i1++ ): ?>
          <td colspan="3" class="tbname01"><?php echo $data['matches'][$i1]['match_time']; ?></td>
<?php endfor; ?>
          <td class="tbname01">&nbsp;</div></td>
          <td colspan="3" class="tbname01"><?php echo $data['matches'][6]['match_time']; ?></td>
          <td class="tbname01">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="tbprefname">&nbsp;</td>
          <td colspan="3">
            <div align="center" class="tbprefname">
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab2" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tournament" type="hidden" value="<?php echo $tournament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="1" />
              </form>
            </div>
          </td>
          <td colspan="3">
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab3" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tournament" type="hidden" value="<?php echo $tournament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="2" />
              </form>
          </td>
          <td colspan="3">
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab4" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tournament" type="hidden" value="<?php echo $tounament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="3" />
              </form>
          </td>
          <td colspan="3">
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab5" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tounament" type="hidden" value="<?php echo $tounament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="4" />
              </form>
          </td>
          <td colspan="3">
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab6" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tounament" type="hidden" value="<?php echo $tounament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="5" />
              </form>
          </td>
          <td>&nbsp;</td> 
          <td colspan="3">
            <div align="center" class="tbprefname">
              <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tounament; ?>&m=<?php echo $place_match_no; ?>" method="post">
                <input type="checkbox" name="exist_match6" id="exist_match6" value="1" <?php if($data['exist_match6']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />代表有
                <input name="mode" type="hidden" value="check_exist_match6" />
              </form>
            </div>
              <form action="dantai_result_input.php" method="post">
                <input name="r-ab1" type="submit" class="" id="r-ab7" value="結果入力" />
                <input name="place" type="hidden" value="<?php echo $place; ?>" />
                <input name="navi_id" type="hidden" value="<?php echo $navi_id; ?>" />
                <input name="match_id" type="hidden" value="<?php echo $match; ?>" />
                <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
                <input name="admin" type="hidden" value="<?php echo $admin; ?>" />
                <input name="series" type="hidden" value="<?php echo $series; ?>" />
                <input name="league" type="hidden" value="<?php echo $league; ?>" />
                <input name="tournament" type="hidden" value="<?php echo $tournament; ?>" />
                <input name="series_info_id" type="hidden" value="<?php echo $navi_info['series_info_id']; ?>" />
                <input name="match_no" type="hidden" value="6" />
              </form>
          </td>
          <td>&nbsp;</td> 
        </tr>
<?php if( $series_info['enable_referee'] != 0 ): ?>
        <tr>
          <td colspan="2" class="tbnamecolor">&nbsp;</td>
          <td colspan="3" class="tbnamecolor">主審</td>
          <td colspan="3" class="tbname01">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee" />
              <input name="no" type="hidden" value="1" />
              <select name="referee1" class="tb_srect" id="referee1" onChange="submit();">
                <option value="0"<?php if( $data['referee1'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>" <?php if( $data['referee1'] == $rv['id'] ): ?>selected="selected"<?php endif; ?>><?php echo $rv['sei'],' ',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td colspan="3" class="tbnamecolor">副審</td>
          <td colspan="3" class="tbname01">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee" />
              <input name="no" type="hidden" value="2" />
              <select name="referee2" class="tb_srect" id="referee2" onChange="submit();">
                <option value="0"<?php if( $data['referee2'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>" <?php if( $data['referee2'] == $rv['id'] ): ?>selected="selected"<?php endif; ?>><?php echo $rv['sei'],' ',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td colspan="3" class="tbname01">
            <form action="dantai_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&l=<?php echo $league; ?>&t=<?php echo $tournament; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee" />
              <input name="no" type="hidden" value="3" />
              <select name="referee3" class="tb_srect" id="referee3" onChange="submit();">
                <option value="0"<?php if( $data['referee3'] == 0 ): ?> selected="selected"<?php endif; ?>>---</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>" <?php if( $data['referee3'] == $rv['id'] ): ?>selected="selected"<?php endif; ?>><?php echo $rv['sei'],' ',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td class="tbname01">&nbsp;</td> 
          <td colspan="3" class="tbname01">&nbsp;</td>
          <td class="tbname01">&nbsp;</td> 
        </tr>
<?php endif; ?>
      </table>
<!--      </form> -->
<?php if( $admin == 1 && $_SESSION['auth_input']['admin'] == 1 ): ?>
<?php if( $league > 0 ): ?>
      <h2 align="left" class="tx-h1"><a href="../admin/dantai_league.php?s=<?php echo $series; ?>&mw=<?php echo $series_mw; ?>">←管理画面に戻る</a></h2>
<?php else: ?>
      <h2 align="left" class="tx-h1"><a href="../admin/dantai_tournament.php?s=<?php echo $series; ?>&mw=<?php echo $series_mw; ?>">←管理画面に戻る</a></h2>
<?php endif; ?>
<?php endif; ?>
    <!-- end .content --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
