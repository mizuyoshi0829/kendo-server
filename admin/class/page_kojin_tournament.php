<?php

class form_page_kojin_tournament
{
    var $__pageObj = null;

    function __construct( $pageObj ) {
        $this->__pageObj = $pageObj;
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

    function get_kojin_name_field_header( $seriesinfo, $series_mw, $player_no )
    {
        return sprintf( $seriesinfo['kojin_'.$series_mw.'_field_head'], $player_no );
    }

    function get_kojin_tournament_parameter( $series )
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `kojin_tournament_series` where `del`=0 and `series`='.$series;
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            return $serieslist[0];
        }
        $func = 'get_tournament_parameter_'.$series;
        return $func();
    }

    function get_kojin_tournament_entry_data( $series, $series_mw, $seriesinfo, $dbs )
    {
        $data = array();
        $sql = 'select * from `entry_info`'
            .' where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0'
            .' order by `disp_order` asc';
        $kojin_players = db_query_list( $dbs, $sql );
        foreach( $kojin_players as &$pv ){
            $info = intval( $pv['id'] );
            $sql = 'select * from `entry_field` where `year`='.$_SESSION['auth']['year'].' and `info`='.$info;
            $field_list = db_query_list( $dbs, $sql );
            $fields = array();
            foreach( $field_list as $fv ){
                $fields[$fv['field']] = $fv['data'];
            }
            if( $seriesinfo['player_field_mode'] == 3 ){
                $d = array(
                    'info' => $info,
                    'player' => 1,
                    'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' ),
                    'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' ),
                    //'sei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' )),
                    //'mei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' )),
                    'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'1_disp' ),
                    'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                    'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'kojin_address_pref', 0 ) ),
                );
                $d['admin_name'] = $d['sei'] . '(' . $d['pref_name'] . ')';
                $d['admin_player'] = '0_' . $info . '_1';
                $data[] = $d;
            } else if( $seriesinfo['player_field_mode'] == 1 ){
                $d = array(
                    'info' => $info,
                    'player' => 1,
                    'sei' => get_field_string( $fields, 'player_sei' ),
                    'mei' => get_field_string( $fields, 'player_mei' ),
                    'disp_name' => get_field_string( $fields, 'player_sei' ),
                    'school_name_ryaku' => get_field_string( $fields, 'school_name' ),
                    'pref_name' => ''
                );
                $d['admin_name'] = $d['sei'] . '(' . $d['school_name_ryaku'] . ')';
                $d['admin_player'] = '0_' . $info . '_1';
                $data[] = $d;
            } else if( $seriesinfo['player_field_mode'] == 2 ){
                $y1 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'1', 0 );
                if( $y1 > 0 ){
                    $d = array(
                        'info' => $info,
                        'player' => 1,
                        'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' ),
                        'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' ),
                        'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'1_disp' ),
                        'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                        'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
                    );
                    $d['admin_name'] = $d['sei'] . ' ' .$d['mei'];
                    if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
                    $d['admin_player'] = '0_' . $info . '_1';
                    $data[] = $d;
                }
                $y2 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'2', 0 );
                if( $y2 > 0 ){
                    $d = array(
                        'info' => $info,
                        'player' => 2,
                        'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'2_sei' ),
                        'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'2_mei' ),
                        'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'2_disp' ),
                        'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                        'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
                    );
                    $d['admin_name'] = $d['sei'] . ' ' . $d['mei'];
                    if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
                    $d['admin_player'] = '0_' . $info . '_2';
                    $data[] = $d;
                }
            }
        }
        return $data;
    }

    function get_kojin_tournament_data( $series, $series_mw, $seriesinfo )
    {
        $list = array(
            'data' => array(),
            'players' => array(),
            'players_for_smarty' => array()
        );
        $list['players_for_smarty']['0_0_0'] = '---';
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `kojin_tournament` where `del`=0 and `series`='.$series;
        if( $series_mw != '' ){ $sql .= " and `series_mw`='".$series_mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
        $list['data'] = db_query_list( $dbs, $sql );
        //$list['data'] = db_get_one_data( $dbs, 'kojin_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'] );

        $pref_array2 = $this->__pageObj->get_pref_array2();
        $sql = 'select * from `entry_info`'
            .' where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0'
            .' order by `disp_order` asc';
        $kojin_players = db_query_list( $dbs, $sql );
        foreach( $kojin_players as &$pv ){
            $info = intval( $pv['id'] );
            $sql = 'select * from `entry_field` where `year`='.$_SESSION['auth']['year'].' and `info`='.$info;
            $field_list = db_query_list( $dbs, $sql );
            $fields = array();
            foreach( $field_list as $fv ){
                $fields[$fv['field']] = $fv['data'];
            }
            $kojin_name_field_header = $this->get_kojin_name_field_header( $seriesinfo, $series_mw, 1 );
            $kojin_name_field_header2 = $this->get_kojin_name_field_header( $seriesinfo, $series_mw, 2 );
            /**/
            //$kojin_name_field_header = $this->get_kojin_name_field_header( $seriesinfo, $series_mw, 1 );
            $d = array(
                'info' => $info,
                'player' => 1,
                'sei' => get_field_string( $fields, $kojin_name_field_header.'_sei' ),
                'mei' => get_field_string( $fields, $kojin_name_field_header.'_mei' ),
                //'sei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' )),
                //'mei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' )),
                'disp_name' => get_field_string( $fields, $kojin_name_field_header.'_disp' ),
                'school_name_ryaku' => get_field_string( $fields, $seriesinfo['belonging_to_field'].'_ryaku' ),
            );
            if( $seriesinfo['belonging_to_field'] == 'pref_name' ){
                $d['belonging_to_name'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field'], 0 ) );
            } else if( $seriesinfo['belonging_to_field'] == 'school_pref' ){
                $d['belonging_to_name'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field'], 0 ) );
            } else if( $seriesinfo['belonging_to_field'] == 'kojin_address_pref' ){
                $d['belonging_to_name'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field'], 0 ) );
            } else {
                $d['belonging_to_name'] = get_field_string( $fields, $seriesinfo['belonging_to_field'] );
            }
            $name = $d['sei'] . ' ' . $d['mei'] . '(' . $d['belonging_to_name'];
            $d['belonging_to_name2'] = '';
            if( $seriesinfo['belonging_to_field2'] != '' ){
                if( $seriesinfo['belonging_to_field2'] == 'pref_name' ){
                    $d['belonging_to_name2'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field2'], 0 ) );
                } else if( $seriesinfo['belonging_to_field2'] == 'school_pref' ){
                    $d['belonging_to_name2'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field2'], 0 ) );
                } else if( $seriesinfo['belonging_to_field2'] == 'school_address_pref' ){
                    $d['belonging_to_name2'] = $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, $seriesinfo['belonging_to_field2'], 0 ) );
                } else {
                    $d['belonging_to_name2'] = get_field_string( $fields, $seriesinfo['belonging_to_field2'] );
                }
                $name .= ( '・' . $d['belonging_to_name2'] );
            }
            $name .= ')';
            $list['players_for_smarty']['0_'.$info.'_1'] = $name;
            $list['players'][] = $d;
/**/
/*
            if( $seriesinfo['player_field_mode'] == 3 ){
                $d = array(
                    'info' => $info,
                    'player' => 1,
                    'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' ),
                    'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' ),
                    //'sei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' )),
                    //'mei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' )),
                    'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'1_disp' ),
                    'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                    'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'kojin_address_pref', 0 ) )
                );
                $name = $d['sei'] . '(' . $d['pref_name'] . ')';
                $list['players_for_smarty']['0_'.$info.'_1'] = $name;
                $list['players'][] = $d;
            } else if( $seriesinfo['player_field_mode'] == 1 ){
                $d = array(
                    'info' => $info,
                    'player' => 1,
                    'sei' => get_field_string( $fields, 'player_sei' ),
                    'mei' => get_field_string( $fields, 'player_mei' ),
                    'disp_name' => get_field_string( $fields, 'player_sei' ),
                    'school_name_ryaku' => get_field_string( $fields, 'school_name' ),
                    'pref_name' => ''
                );
                $name = $d['sei'] . '(' . $d['school_name_ryaku'] . ')';
                $list['players_for_smarty']['0_'.$info.'_1'] = $name;
                $list['players'][] = $d;
            } else if( $seriesinfo['player_field_mode'] == 2 ){
                $y1 = get_field_string_number( $fields, 'player1_yosen', 0 );
                if( $y1 > 0 ){
                    $d = array(
                        'info' => $info,
                        'player' => 1,
                        'sei' => get_field_string( $fields, 'player1_sei' ),
                        'mei' => get_field_string( $fields, 'player1_mei' ),
                        'disp_name' => get_field_string( $fields, 'player1_disp' ),
                        'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                        'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
                    );
                    $name = $d['sei'] . ' ' .$d['mei'];
                    if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
                    $list['players_for_smarty']['0_'.$info.'_1'] = $name;
                    $list['players'][] = $d;
                }
                $y2 = get_field_string_number( $fields, 'player2_yosen', 0 );
                if( $y2 > 0 ){
                    $d = array(
                        'info' => $info,
                        'player' => 2,
                        'sei' => get_field_string( $fields, 'player2_sei' ),
                        'mei' => get_field_string( $fields, 'player2_mei' ),
                        'disp_name' => get_field_string( $fields, 'player2_disp' ),
                        'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
                        'pref_name' => $this->__pageObj->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
                    );
                    $name = $d['sei'] . ' ' . $d['mei'];
                    if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
                    $list['players_for_smarty']['0_'.$info.'_2'] = $name;
                    $list['players'][] = $d;
                }
            }
*/
        }

        for( $li = 0; $li < count($list['data']); $li++ ){
            $list['data'][$li]['player'] = array();
            $list['data'][$li]['players_for_smarty'] = array();
            $player_num = intval( $list['data'][$li]['player_num'] );
            $match_level = intval( $list['data'][$li]['match_level'] );
            $tournament_player_num = intval( $list['data'][$li]['tournament_player_num'] );
            $relative = intval( $list['data'][$li]['relative'] );
            $relative_start = intval( $list['data'][$li]['relative_start'] );
            $relative_num = intval( $list['data'][$li]['relative_num'] );
            if( $relative > 0 ){
                for( $i1 = 0; $i1 < $relative_num; $i1++ ){
                    $list['data'][$li]['players_for_smarty'][$relative.'_'.($relative_start+$i1).'_0'] = '【'.($relative_start+$i1).'】の敗者';
                }
            }
            foreach( $list['players_for_smarty'] as $k => $v ){
                $list['data'][$li]['players_for_smarty'][$k] = $v;
            }
            $pref_array = $this->__pageObj->get_pref_array();
            $pref_array2 = $this->__pageObj->get_pref_array2();

            for( $i1 = 0; $i1 < $tournament_player_num; $i1++ ){
                $list['data'][$li]['player'][] = array( 'info'=>0, 'player'=>0, 'relative'=>0, 'relative_match'=>0, 'sei'=>'', 'mei'=>'', 'disp_name'=>'' );
            }
            $sql = 'select * from `kojin_tournament_player`'
                . ' where `kojin_tournament_player`.`del`=0'
                    . ' and `kojin_tournament_player`.`tournament`='.intval($list['data'][$li]['id']);
            $players = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($players);
            foreach( $players as $pv ){
                $no = intval( $pv['tournament_player_index'] );
                if( $no <= 0 && $no > $player_num ){ continue; }
                $info = intval( $pv['team'] );
                //if( $info <= 0 ){ continue; }
                $rel = intval( $pv['relative'] );
                $rel_match = intval( $pv['relative_match'] );
                if( $rel > 0 ){
                    $d = array(
                        'info' => $info,
                        'player' => $rel.'_'.$rel_match.'_0',
                        'relative' => $rel,
                        'relative_match' => $rel_match,
                        'sei' => '',
                        'mei' => '',
                        'disp_name' => '',
                        'school_name_ryaku' => '',
                        'pref_name' => ''
                    );
                    $list['data'][$li]['player'][$no-1] = $d;
                } else {
                    foreach( $list['players'] as $player ){
                        if( $info == $player['info'] && $pv['player'] == $player['player'] ){
                            $d = array(
                                'info' => $info,
                                'player' => '0_'.$player['info'].'_'.$player['player'],
                                'relative' => 0,
                                'relative_match' => 0,
                                'sei' => $player['sei'],
                                'mei' => $player['mei'],
                                'disp_name' => $player['disp_name'],
                                'school_name_ryaku' => $player['school_name_ryaku'],
                                'belonging_to_name' => $player['belonging_to_name'],
                                'belonging_to_name2' => $player['belonging_to_name2']
                            );
                            $list['data'][$li]['player'][$no-1] = $d;
                            break;
                        }
                    }
                }
            }

            $list['data'][$li]['match'] = array();
            $match_num = intval( $list['data'][$li]['match_num'] );
            $extra_match_num = intval( $list['data'][$li]['extra_match_num'] );
            $tournament_match_num = $match_num + $extra_match_num;
            for( $i1 = 0; $i1 < $tournament_match_num; $i1++ ){
                $list['data'][$li]['match'][] = array(
                    'match' => 0,
                    'place' => '0',
                    'place_match_no' => 0, 
                    'player1_name' => '',
                    'player2_name' => '',
                );
            }
            $sql = 'select `kojin_tournament_match`.`match` as `match`,'
                . ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`,'
                . ' `kojin_match`.`place` as `place`,'
                . ' `kojin_match`.`place_match_no` as `place_match_no`'
                . ' from `kojin_tournament_match` join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
                . ' where `kojin_tournament_match`.`del`=0 and `kojin_tournament_match`.`tournament`='.intval($list['data'][$li]['id']);
            $match = db_query_list( $dbs, $sql );
            foreach( $match as $mv ){
                $no = intval( $mv['tournament_match_index'] );
                if( $no > 0 && $no <= $tournament_match_num ){
                    $list['data'][$li]['match'][$no-1]['match'] = intval( $mv['match'] );
                    $list['data'][$li]['match'][$no-1]['place'] = $mv['place'];
                    $list['data'][$li]['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
                    $list['data'][$li]['match'][$no-1]['player1'] = 0;
                    $list['data'][$li]['match'][$no-1]['player1_name'] = '';
                    $list['data'][$li]['match'][$no-1]['player2'] = 0;
                    $list['data'][$li]['match'][$no-1]['player2_name'] = '';
                    $list['data'][$li]['match'][$no-1]['winner'] = 0;
                    $list['data'][$li]['match'][$no-1]['extra'] = 0;
                    if( $list['data'][$li]['match'][$no-1]['match'] > 0 ){
                    //    $sql = 'select `one_match`.`player1` as `player1`, `one_match`.`player2` as `player2`,'
                    //        . ' `one_match`.`winner` as `winner`'
                    //        . ' from `kojin_match` join `one_match` on `kojin_match`.`match`=`one_match`.`id`'
                    //        . ' where `kojin_match`.`id`='.$list['data'][$li]['match'][$no-1]['match'];
                        $sql = 'select `one_match`.*'
                            . ' from `kojin_match` join `one_match` on `kojin_match`.`match`=`one_match`.`id`'
                            . ' where `kojin_match`.`id`='.$list['data'][$li]['match'][$no-1]['match'];
                        $kojin_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($kojin_match);
                        if( count($kojin_match) > 0 ){
                            $list['data'][$li]['match'][$no-1]['player1'] = get_field_string_number( $kojin_match[0], 'player1', 0 );
                            $list['data'][$li]['match'][$no-1]['player2'] = get_field_string_number( $kojin_match[0], 'player2', 0 );
                            $list['data'][$li]['match'][$no-1]['faul1_1'] = get_field_string_number( $kojin_match[0], 'faul1_1', 0 );
                            $list['data'][$li]['match'][$no-1]['faul1_2'] = get_field_string_number( $kojin_match[0], 'faul1_2', 0 );
                            $list['data'][$li]['match'][$no-1]['waza1_1'] = get_field_string_number( $kojin_match[0], 'waza1_1', 0 );
                            $list['data'][$li]['match'][$no-1]['waza1_2'] = get_field_string_number( $kojin_match[0], 'waza1_2', 0 );
                            $list['data'][$li]['match'][$no-1]['waza1_3'] = get_field_string_number( $kojin_match[0], 'waza1_3', 0 );
                            $list['data'][$li]['match'][$no-1]['faul2_1'] = get_field_string_number( $kojin_match[0], 'faul2_1', 0 );
                            $list['data'][$li]['match'][$no-1]['faul2_2'] = get_field_string_number( $kojin_match[0], 'faul2_2', 0 );
                            $list['data'][$li]['match'][$no-1]['waza2_1'] = get_field_string_number( $kojin_match[0], 'waza2_1', 0 );
                            $list['data'][$li]['match'][$no-1]['waza2_2'] = get_field_string_number( $kojin_match[0], 'waza2_2', 0 );
                            $list['data'][$li]['match'][$no-1]['waza2_3'] = get_field_string_number( $kojin_match[0], 'waza2_3', 0 );
                            $list['data'][$li]['match'][$no-1]['hon1'] = get_field_string_number( $kojin_match[0], 'hon1', 0 );
                            $list['data'][$li]['match'][$no-1]['hon2'] = get_field_string_number( $kojin_match[0], 'hon2', 0 );
                            $list['data'][$li]['match'][$no-1]['winner'] = get_field_string_number( $kojin_match[0], 'winner', 0 );
                            $list['data'][$li]['match'][$no-1]['extra'] = get_field_string_number( $kojin_match[0], 'extra', 0 );
                            $list['data'][$li]['match'][$no-1]['fusen'] = 0;
                            $player1 = get_field_string_number( $kojin_match[0], 'player1', 0 );
                            if( $player1 > 0 ){
                                foreach( $list['players'] as $player ){
                                    $p = $player['info'] * 0x100 + $player['player'];
                                    if( $p == $player1 ){
                                        if( $player['disp_name'] != '' ){
                                            $list['data'][$li]['match'][$no-1]['player1_disp_name'] = $player['disp_name'];
                                        } else {
                                            $list['data'][$li]['match'][$no-1]['player1_disp_name'] = $player['sei'];
                                        }
                                        $list['data'][$li]['match'][$no-1]['player1_name'] = $player['sei'] . ' ' . $player['mei'];
                                        $list['data'][$li]['match'][$no-1]['player1_school_name_ryaku'] = $player['school_name_ryaku'];
                                        $list['data'][$li]['match'][$no-1]['player1_belonging_to_name'] = $player['belonging_to_name'];
                                        $list['data'][$li]['match'][$no-1]['player1_belonging_to_name2'] = $player['belonging_to_name2'];
                                        break;
                                    }
                                }
                            }
                            $player2 = get_field_string_number( $kojin_match[0], 'player2', 0 );
                            if( $player2 > 0 ){
                                foreach( $list['players'] as $player ){
                                    $p = $player['info'] * 0x100 + $player['player'];
                                    if( $p == $player2 ){
                                        if( $player['disp_name'] != '' ){
                                            $list['data'][$li]['match'][$no-1]['player2_name'] = $player['disp_name'];
                                        } else {
                                            $list['data'][$li]['match'][$no-1]['player2_name'] = $player['sei'];
                                        }
                                        $list['data'][$li]['match'][$no-1]['player2_name'] = $player['sei'] . ' ' . $player['mei'];
                                        $list['data'][$li]['match'][$no-1]['player2_school_name_ryaku'] = $player['school_name_ryaku'];
                                        $list['data'][$li]['match'][$no-1]['player2_belonging_to_name'] = $player['belonging_to_name'];
                                        $list['data'][$li]['match'][$no-1]['player2_belonging_to_name2'] = $player['belonging_to_name2'];
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $offset = 1;
            $player_num2 = 1;
            $match_offset = array();
            for( $i1 = 1; $i1 <= $match_level; $i1++ ){
                $match_offset[$match_level-$i1] = $offset;
                $offset *= 2;
                $player_num2 *= 2;
            }
            $list['data'][$li]['match_array'] = array();
            for( $i1 = 0; $i1 < $player_num2; $i1++ ){
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
                $list['data'][$li]['match_array'][] = $match_row;
            }
            $list['data'][$li]['extra_name_array'] = explode( ',', $list['data'][$li]['extra_name'] );
//print_r($list['data']);
        }
        db_close( $dbs );
//print_r($list);
        return $list;
    }

    function update_kojin_tournament_data( $series, $series_mw, $post )
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `kojin_tournament` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'];
        $datalist = db_query_list( $dbs, $sql );
//print_r($datalist);
        $match_tbl = array();
        $data_index = 1;
        foreach( $datalist as $data ){
            $match_tbl[$data_index] = array();
            $tournament_id = intval( $data['id'] );
            $player_num = intval( $data['player_num'] );
            $tournament_player_num = intval( $data['tournament_player_num'] );
            $tournament_match_num = intval( $data['match_num'] );
            $tournament_extra_match_num = intval( $data['extra_match_num'] );
            $player_id_list = array();
            $sql = 'select * from `kojin_tournament_player` where `del`=0 and `tournament`='.$tournament_id;
            $kojin_tournament_player = db_query_list( $dbs, $sql );
//print_r($kojin_tournament_player);
            for( $player_index = 1; $player_index <= $tournament_player_num; $player_index++ ){
                $update = false;
//echo $data_index,'_',$player_index,':[',$post['entry_'.$data_index.'_'.$player_index],"]<br />\n";
                $player = explode( '_', $post['entry_'.$data_index.'_'.$player_index] );
                $relative = intval( $player[0] );
                if( $relative > 0 ){
                    $relative_match = intval( $player[1] );
                    $player_info = 0;
                    $player_no = 0;
                } else {
                    $player_info = intval( $player[1] );
                    $player_no = intval( $player[2] );
                    $relative_match = 0;
                }
//print_r($kojin_tournament_player);
                foreach( $kojin_tournament_player as $pv ){
                    $tournament_player_id = intval( $pv['id'] );
                    $tournament_player_index = intval( $pv['tournament_player_index'] );
                    if( $player_index == $tournament_player_index ){
                        $sql = 'update `kojin_tournament_player` set `team`='.$player_info.',`player`='.$player_no.',`relative`='.$relative.',`relative_match`='.$relative_match.' where `id`='.$tournament_player_id;
//echo $sql,"<br />";
                        db_query( $dbs, $sql );
                        $player_id_list[$player_index] = array( 'player_id'=>$player_info*0x100+$player_no, 'relative'=>$relative, 'relative_match'=>$relative_match );
                        $update = true;
                        break;
                    }
                }
                if( !$update ){
                    $sql = 'INSERT INTO `kojin_tournament_player` ( `tournament`,`tournament_player_index`,`team`,`player`,`relative`,`relative_match`,`create_date` ) VALUES ( '.$tournament_id.', '.$player_index.', '.$player_info.', '.$player_no.', '.$relative.', '.$relative_match.', NOW() )';
//echo $sql,"<br />";
                    db_query( $dbs, $sql );
                }
            }

            $match_num = intval( $data['match_num'] );
            $match_level = intval( $data['match_level'] );
            $macth1_level = 1;
            $i1 = 1;
            for(;;){
                if( $i1 == $match_level ){ break; }
                $macth1_level *= 2;
                $i1++;
            }
            $sql = 'select * from `kojin_tournament_match` where `del`=0 and `tournament`='.$tournament_id;
            $kojin_tournament_match = db_query_list( $dbs, $sql );
            for( $match_index = 1; $match_index <= $tournament_player_num-1+$tournament_extra_match_num; $match_index++ ){
                $match_tbl[$data_index][$match_index] = 0;
                $place = $post['place_'.$data_index.'_'.$match_index];
                $place_match_no = intval( $post['place_match_'.$data_index.'_'.$match_index] );
                $update = false;
                foreach( $kojin_tournament_match as $mv ){
                    $match_id = intval( $mv['match'] );
                    $tournament_match_index = intval( $mv['tournament_match_index'] );
                    if( $match_index == $tournament_match_index ){
                        $sql = 'select * from `kojin_match` where `id`='.$match_id;
                        $kojin_match = db_query_list( $dbs, $sql );
                        if( count($kojin_match) > 0 ){
/*
                            $sql = 'update `kojin_match`'
                                . ' set `place`=\''.$place.'\',`place_match_no`='.$place_match_no
                                . ' where `id`='.$match_id;
//echo $sql,"<br />";
                            db_query( $dbs, $sql );
*/
                            $win_match = 0;
                            $win_match_player_no = 0;

                            if( $match_index < $tournament_player_num ){

                                if( $match_index >= $macth1_level && $match_index < $tournament_player_num ){
                                    $player_pos = ( $match_index - $macth1_level ) * 2 + 1;
                                    $sql = 'update `one_match`'
                                        . ' set `player1`='.$player_id_list[$player_pos]['player_id'].','
                                        . ' `player2`='.$player_id_list[$player_pos+1]['player_id']
                                        . ' where `id`='.$kojin_match[0]['match'];
//echo $sql,"<br />";
                                    db_query( $dbs, $sql );
                                    if( $player_id_list[$player_pos]['relative'] > 0 ){
                                        $sql = 'update `kojin_match`'
                                            . ' set `lose_match`='.$kojin_match[0]['match'].', `lose_match_player_no`=1'
                                            . ' where `id`='.$match_tbl[$player_id_list[$player_pos]['relative']][$player_id_list[$player_pos]['relative_match']];
//echo $sql,"<br />";
                                        db_query( $dbs, $sql );
                                    }
                                    if( $player_id_list[$player_pos+1]['relative'] > 0 ){
                                        $sql = 'update `kojin_match`'
                                            . ' set `lose_match`='.$kojin_match[0]['match'].', `lose_match_player_no`=2'
                                            . ' where `id`='.$match_tbl[$player_id_list[$player_pos+1]['relative']][$player_id_list[$player_pos+1]['relative_match']];
//echo $sql,"<br />";
                                        db_query( $dbs, $sql );
                                    }
                                }
                                $match_tbl[$data_index][$match_index] = $match_id;
                                $t2 = intval( $tournament_match_index / 2 );
                                $t2ofs = ( $tournament_match_index % 2 ) + 1;
                                foreach( $kojin_tournament_match as $mv2 ){
                                    $match_id2 = intval( $mv2['match'] );
                                    $tournament_match_index2 = intval( $mv2['tournament_match_index'] );
                                    if( $t2 == $tournament_match_index2 ){
                                        $sql = 'select * from `kojin_match` where `id`='.$match_id2;
                                        $kojin_match2 = db_query_list( $dbs, $sql );
                                        if( count($kojin_match2) > 0 ){
                                            $win_match = $kojin_match2[0]['match'];
                                            $win_match_player_no = $t2ofs;
                                            if( $place == 'no_match' && $match_index >= $macth1_level && $match_index <= $tournament_match_num ){
                                                $sql = 'update `one_match` set ';
                                                if( $player_id_list[($match_index-$macth1_level)*2+1]['player_id'] != 0 ){
                                                    $sql .= '`player'.$t2ofs.'`='.$player_id_list[($match_index-$macth1_level)*2+1]['player_id'];
                                                } else {
                                                    $sql .= '`player'.$t2ofs.'`='.$player_id_list[($match_index-$macth1_level)*2+2]['player_id'];
                                                }
                                                $sql .= ' where `id`='.$kojin_match2[0]['match'];
//echo $sql,"<br />";
                                                db_query( $dbs, $sql );
                                            }
                                        }
                                    }
                                }
                            } else {
                                $sql = 'update `kojin_match`'
                                    . ' set `lose_match`='.$kojin_match[0]['match'].', `lose_match_player_no`=1'
                                    . ' where `id`='.$match_tbl[$data_index][2];
//echo $sql,"<br />";
                                db_query( $dbs, $sql );
                                $sql = 'update `kojin_match`'
                                    . ' set `lose_match`='.$kojin_match[0]['match'].', `lose_match_player_no`=2'
                                    . ' where `id`='.$match_tbl[$data_index][3];
//echo $sql,"<br />";
                                db_query( $dbs, $sql );
                            }
                            $sql = 'update `kojin_match`'
                                . ' set `place`=\''.$place.'\', `place_match_no`='.$place_match_no.','
                                . ' `win_match`='.$win_match.', `win_match_player_no`='.$win_match_player_no.','
                                . ' `lose_match`=0, `lose_match_player_no`=0'
                                . ' where `id`='.$match_id;
//echo $sql,"<br />";
                            db_query( $dbs, $sql );
                        }
                        $update = true;
                        break;
                    }
                }
                if( !$update ){
                    $sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
                    db_query( $dbs, $sql );
                    $matches = db_query_insert_id( $dbs );
                    $sql = 'insert `kojin_match`'
                        . ' set `place`=\''.$place.'\',`place_match_no`='.$place_match_no.','
                            . '`match`=' . $matches . ','
                            . '`create_date`=NOW()';
//echo $sql,"<br />";
                    db_query( $dbs, $sql );
                    $match_id = db_query_insert_id( $dbs );
                    $sql = 'INSERT INTO `kojin_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`create_date` ) VALUES ( '.$tournament_id.', '.$match_index.', '.$match_id.', NOW() )';
//echo $sql,"<br />";
                    db_query( $dbs, $sql );
                }
            }
            $data_index++;
        }
        db_close( $dbs );
//print_r($data);
        //return $data;
    }

    function load_kojin_tournament_csvdata( $series, $series_mw, $filename )
    {
        if( $filename == '' ){ return; }
        $file = new SplFileObject($filename);
        $file->setFlags( SplFileObject::READ_CSV );
        $filedata = array();
        $file_index = 0;
        foreach( $file as $line ){
            $filedata[$file_index] = [];
			if( count($line) <= 1 ){ continue; }
            foreach( $line as $lv ){
                //$filedata[$file_index][] = mb_convert_encoding( $lv, 'UTF-8', 'SJIS' );
                $filedata[$file_index][] = $lv;
            }
            $file_index++;
        }

        $series_info = $this->__pageObj->get_series_list( $series );
		if( $series_mw == 'm' ){
			$f_head = 'kojin_m';
		} else {
			$f_head = 'kojin_w';
		}
	    $fields = explode( ',', $series_info[$f_head.'_entry_field'] );
//print_r($fields);
        if( count( $fields ) == 0 ){ return; }
		$field_sei_index = 0;
		$field_mei_index = 0;
		foreach( $fields as $fi => $fv ){
			if( $fv == $series_info[$f_head.'_field_head'].'_sei' ){
				$field_sei_index = $fi;
			}
			if( $fv == $series_info[$f_head.'_field_head'].'_mei' ){
				$field_mei_index = $fi;
			}
		}

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $kojin_players = $this->get_kojin_tournament_entry_data( $series, $series_mw, $series_info, $dbs );
//print_r($kojin_players);
        $sql = 'select * from `kojin_tournament` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'];
        $datalist = db_query_list( $dbs, $sql );
        $post = array();
        $data_index = 1;
        $place_ofs = 0;
        foreach( $datalist as $data ){
            $tournament_id = intval( $data['id'] );
            $player_num = intval( $data['player_num'] );
            $tournament_player_num = intval( $data['tournament_player_num'] );
            $tournament_match_num = intval( $data['match_num'] );
            $tournament_extra_match_num = intval( $data['extra_match_num'] );
/*
            if( $data_index == 1 ){ $place_ofs += $tournament_player_num; }
            $tournament_match_index = intval( $tournament_player_num / 2 );
            for( $player_index = 1; $player_index <= $tournament_player_num; $player_index++ ){
//echo $filedata[$player_index-1],'<br />';
                if( $series_info['player_field_mode'] == 3 ){
                    foreach( $kojin_players as $pv ){
                        //if( mb_strpos( $filedata[$player_index-1], $pv['sei'] ) !== false ){
                        if( mb_strpos( $filedata[$player_index-1][1], $pv['sei'] ) !== false && mb_strpos( $filedata[$player_index-1][2], $pv['mei'] ) !== false ){
                            $post['entry_'.$data_index.'_'.$player_index] = $pv['admin_player'];
                            break;
                        }
                    }
                } else {
                    $post['entry_'.$data_index.'_'.$player_index] = 0;
                    $nomatch = true;
                    foreach( $kojin_players as $pv ){
                        //if( mb_strpos( $filedata[$player_index-1][0], $pv['sei'] ) !== false && mb_strpos( $filedata[$player_index-1][1], $pv['mei'] ) !== false ){
                        if( $filedata[$player_index-1][0] == $pv['sei'] && $filedata[$player_index-1][1] == $pv['mei'] ){
                            $post['entry_'.$data_index.'_'.$player_index] = $pv['admin_player'];
                            $nomatch = false;
                            break;
                        }
                    }
                    if( $nomatch ){
                        $post['place_'.$data_index.'_'.$tournament_match_index] = 'no_match';
                    }
                    if( ( $player_index % 2 ) == 0 ){
                        $tournament_match_index++;
                    }
                }
            }
*/
/**/
            for( $player_index = 1; $player_index <= $tournament_player_num; $player_index++ ){
                $post['entry_'.$data_index.'_'.$player_index] = 0;
                foreach( $kojin_players as $pv ){
                    if( $pv['sei'] == '' ){ continue; }
                    if(
                        mb_strpos( $filedata[$place_ofs][$field_sei_index], $pv['sei'] ) !== false
                        && mb_strpos( $filedata[$place_ofs][$field_mei_index], $pv['mei'] ) !== false
                    ){
                        $post['entry_'.$data_index.'_'.$player_index] = $pv['admin_player'];
                        break;
                    }
                }
                $place_ofs++;
            }
/**/
/**/
            for( $match_index = 1; $match_index <= $tournament_player_num - 1 + $tournament_extra_match_num; $match_index++ ){
				if( $filedata[$place_ofs][0] == '' ){
                    //$post['place_'.$data_index.'_'.$match_index] = 'no_match';
                    //$post['place_match_'.$data_index.'_'.$match_index] = 0;
			    } else {
                    $place = explode( '-', $filedata[$place_ofs][0] );
                    $post['place_'.$data_index.'_'.$match_index]
                        = $place[0] == 'no_match' ? 'no_match': intval( $place[0] );
                    $post['place_match_'.$data_index.'_'.$match_index] = intval( $place[1] );
                    //if( $post['place_match_'.$data_index.'_'.$match_index] != 0 ){
                    //    $post['place_match_'.$data_index.'_'.$match_index] += 50;
                    //}
                }
                $place_ofs++;
            }
/**/
            $data_index++;
        }
        db_close( $dbs );
//print_r($post);
//exit;
        return $post;
        //$this->update_kojin_tournament_data( $series, $series_mw, $post );
    }


    function get_kojin_tournament_one_result( $series, $series_mw, $id )
    {
        $series_info = $this->__pageObj->get_series_list( $series );
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );

        //$kojin_field = 'kojin_' . $series_mw;
        $data['matches'] = array();
        $data['players'] = array();
        $match_id = get_field_string_number( $data, 'match', 0 );
        if( $match_id != 0 ){
            $data['matches'] = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
            $player1_id = get_field_string_number( $data['matches'], 'player1', 0 );
            $player2_id = get_field_string_number( $data['matches'], 'player2', 0 );
            if( $player1_id != 0 ){
                $data['players'][1]['player_info'] = intval( $player1_id / 0x100 );
                $data['players'][1]['player_no'] = intval( $player1_id % 0x100 );
                $data['players'][1]['entry'] = $this->__pageObj->get_entry_one_data2( $data['players'][1]['player_info'] );
                $kojin_field = $this->get_kojin_name_field_header( $series_info, $series_mw, $data['players'][1]['player_no'] );
                $data['players'][1]['name_str'] = get_field_string( $data['players'][1]['entry'], $kojin_field.'_sei' ) .'&nbsp;'. get_field_string( $data['players'][1]['entry'], $kojin_field.'_mei' );
//echo $kojin_field;
//print_r( $data['players'][1]['entry'] );
                $name = get_field_string( $data['players'][1]['entry'], $kojin_field.'_disp' );
                if( $name == '' ){
                    $name = get_field_string( $data['players'][1]['entry'], $kojin_field.'_sei' );
                }
                $data['players'][1]['name_str2'] = $name;
                $name = get_field_string( $data['players'][1]['entry'], $series_info['belonging_to_field'].'_ryaku' );
                if( $name == '' ){
                    $name = get_field_string( $data['players'][1]['entry'], $series_info['belonging_to_field'] );
                }
                $data['players'][1]['belonging_to_name_str'] = $name;
            } else {
                $data['players'][1] = array();
                $data['players'][1]['name_str'] = '';
                $data['players'][1]['name_str2'] = '';
            }
            if( $player2_id != 0 ){
                $data['players'][2]['player_info'] = intval( $player2_id / 0x100 );
                $data['players'][2]['player_no'] = intval( $player2_id % 0x100 );
                $data['players'][2]['entry'] = $this->__pageObj->get_entry_one_data2( $data['players'][2]['player_info'] );
                $kojin_field = $this->get_kojin_name_field_header( $series_info, $series_mw, $data['players'][2]['player_no'] );
                $data['players'][2]['name_str'] = get_field_string( $data['players'][2]['entry'], $kojin_field.'_sei' ) .'&nbsp;'. get_field_string( $data['players'][2]['entry'], $kojin_field.'_mei' );
                $name = get_field_string( $data['players'][2]['entry'], $kojin_field.'_disp' );
                if( $name == '' ){
                    $name = get_field_string( $data['players'][2]['entry'], $kojin_field.'_sei' );
                }
                $data['players'][2]['name_str2'] = $name;
                $name = get_field_string( $data['players'][2]['entry'], $series_info['belonging_to_field'].'_ryaku' );
                if( $name == '' ){
                    $name = get_field_string( $data['players'][2]['entry'], $series_info['belonging_to_field'] );
                }
                $data['players'][2]['belonging_to_name_str'] = $name;
            } else {
                $data['players'][2] = array();
                $data['players'][2]['name_str'] = '';
            }
        } else {
            $data['players'][1] = array();
            $data['players'][1]['name_str'] = '';
            $data['players'][2] = array();
            $data['players'][2]['name_str'] = '';
        }
//print_r($data);
        db_close( $dbs );
        return $data;
    }

    function update_kojin_tournament_one_waza( $match, $field, $value )
    {
//print_r($p);

        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$match );
        $match_id = get_field_string_number( $data, 'match', 0 );
        if( $match_id != 0 ){
            $sql = 'update `one_match` set `'.$field.'`='.$value.' where `id`='.$match_id;
            db_query( $dbs, $sql );
//echo $sql;
        }
        db_close( $dbs );
        return $data;
    }

    function update_kojin_tournament_one_result( $series, $tournament, $id, $p )
    {
//print_r($p);

        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );
        $match_id = get_field_string_number( $data, 'match', 0 );
        $win_match = get_field_string_number( $data, 'win_match', 0 );
        $win_match_player_no = get_field_string_number( $data, 'win_match_player_no', 0 );
        $lose_match = get_field_string_number( $data, 'lose_match', 0 );
        $lose_match_player_no = get_field_string_number( $data, 'lose_match_player_no', 0 );
        if( $match_id != 0 ){
            if( !isset($p['winner']) ){
                $p['winner'] = 0;
            }
            $sql = 'update `one_match`'
                . ' set `faul1_1`='.$p['faul1_1'].','
                . '`faul1_2`='.$p['faul1_2'].','
                . '`waza1_1`='.$p['waza1_1'].','
                . '`waza1_2`='.$p['waza1_2'].','
                . '`waza1_3`='.$p['waza1_3'].','
                . '`faul2_1`='.$p['faul2_1'].','
                . '`faul2_2`='.$p['faul2_2'].','
                . '`waza2_1`='.$p['waza2_1'].','
                . '`waza2_2`='.$p['waza2_2'].','
                . '`waza2_3`='.$p['waza2_3'].','
                . '`end_match`='.$p['end_match'].','
                . '`match_time`=\''.$p['match_time'].'\','
                . '`extra`='.$p['extra'].','
                . '`hon1`='.$p['hon1'].','
                . '`hon2`='.$p['hon2'].','
                . '`winner`='.$p['winner']
                . ' where `id`='.$match_id;
            db_query( $dbs, $sql );
//echo $sql;
        }
/*
        $sql = 'update `kojin_match`'
            . ' set `win1`='.$list['win1sum'].','
            . '`hon1`='.$list['hon1sum'].','
            . '`win2`='.$list['win2sum'].','
            . '`hon2`='.$list['hon2sum'].','
            . '`winner`='.$list['winner'].','
            . '`exist_match6`='.$list['exist_match6']
            . ' where `id`='.$id;
        db_query( $dbs, $sql );
*/
        if( $p['winner'] == 1 ){
            $winner = $p['player1_id'];
            $loser = $p['player2_id'];
        } else if( $p['winner'] == 2 ){
            $winner = $p['player2_id'];
            $loser = $p['player1_id'];
        } else {
            $winner = 0;
            $loser = 0;
        }
        if( $winner != 0 && $win_match != 0 && $win_match_player_no != 0 ){
            $sql = 'update `one_match` set `player'.$win_match_player_no.'`='.$winner.' where `id`='.$win_match;
            //echo $sql;
            db_query( $dbs, $sql );
        }
        if( $loser != 0 && $lose_match != 0 && $lose_match_player_no != 0 ){
            $sql = 'update `one_match` set `player'.$lose_match_player_no.'`='.$loser.' where `id`='.$lose_match;
            //echo $sql;
            db_query( $dbs, $sql );
        }

/*
        $sql = 'select `kojin_match`.`match` as `one_match`,'
            . ' `kojin_match`.`id` as `match_id`,'
            . ' `kojin_tournament_match`.`id` as `tournament_match_id`,'
            . ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`'
            . ' from `kojin_tournament_match` join `kojin_match`'
                . ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
            . ' where `kojin_tournament_match`.`tournament`='.$tournament
                . ' order by `kojin_tournament_match`.`tournament_match_index` asc';
        $kojin_tournament_match = db_query_list( $dbs, $sql );
//echo $id."<br />".$sql."\n";
//print_r($kojin_tournament_match);
        foreach( $kojin_tournament_match as $mv ){
            $tournament_match_id = get_field_string_number( $mv, 'match_id', 0 );
            //$tournament_one_match_id = get_field_string_number( $mv, 'match', 0 );
            $tournament_match_index = get_field_string_number( $mv, 'tournament_match_index', 0 );
            if( $tournament_match_id == $id ){
                if( $tournament_match_index == 1 ){ break; }
                $up = intval( $tournament_match_index / 2 );
                foreach( $kojin_tournament_match as $mv_up ){
                    $tournament_up_match_id = get_field_string_number( $mv_up, 'one_match', 0 );
                    $tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
                    if( $tournament_up_match_index == $up ){
                        if( ( $tournament_match_index % 2 ) == 0 ){
                            $sql = 'update `one_match` set `player1`='.$winner.' where `id`='.$tournament_up_match_id;
                            db_query( $dbs, $sql );
                        } else if( ( $tournament_match_index % 2 ) == 1 ){
                            $sql = 'update `one_match` set `player2`='.$winner.' where `id`='.$tournament_up_match_id;
                            db_query( $dbs, $sql );
                        }
//echo $sql;
                        break;
                    }
                }
                if( $tournament_match_index == 2 || $tournament_match_index == 3 ){
                    $up = count( $kojin_tournament_match );
                    foreach( $kojin_tournament_match as $mv_up ){
                        $tournament_up_match_id = get_field_string_number( $mv_up, 'one_match', 0 );
                        $tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
                        if( $tournament_up_match_index == $up ){
                            if( $tournament_match_index == 2 ){
                                $sql = 'update `one_match` set `player1`='.$loser.' where `id`='.$tournament_up_match_id;
                                db_query( $dbs, $sql );
                            } else if( $tournament_match_index == 3 ){
                                $sql = 'update `one_match` set `player2`='.$loser.' where `id`='.$tournament_up_match_id;
                                db_query( $dbs, $sql );
                            }
//echo $up,':',$sql;
                            break;
                        }
                    }
                }
                break;
            }
        }
*/
        db_close( $dbs );
        return $data;
    }

    function output_kojin_tournament_for_HTML( $navi_info, $tournament_data, $entry_list, $mw, $cssparam=null )
	{
//echo '<!-- ';
//print_r($tournament_data);
//echo ' -->';
		$c = new common();
		if( $mw == 'm' ){
			$mwstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 100;
			$table_name_name_font_size = 11;
			$table_name_name_font_size2 = 9;
			$table_name_pref_width = 160;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		} else {
			$mwstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 100;
			$table_name_name_font_size = 11;
			$table_name_name_font_size2 = 9;
			$table_name_pref_width = 160;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
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
            $return_path = 'index_%s.html';
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

        $table_win_border_size = '2px';
        $table_normal_border_size = '1px';
		$pdf_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
	//	$pdf = '' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
			. '<link href="kt.css" rel="stylesheet" type="text/css" />' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<style>' . "\n"
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
			. '    font-size: '.$table_name_name_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: '.$table_name_name_width.'px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//	. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    font-size: '.$table_name_name_font_size2.'pt;' . "\n"
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
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_r {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_l {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_l_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #000000;' . "\n"
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
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">' . $navi_info['kojin_'.$mw.'_name'] . '&nbsp;結果</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="' . sprintf($return_path,$mw) . '">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
        $pdf_footer = '  </div>' . "\n"
    		.  '  </div>' . "\n"
    		. "\n"
    		//$pdf .= $objPage->get_google_analytics_script();
    		. '<script>'."\n"
    		. '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n"
    		. '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n"
    		. '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n"
    		. '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n"
    		. "\n"
    		. '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n"
    		. '  ga(\'send\', \'pageview\');'."\n"
    		. "\n"
    		. '</script>'."\n"
    		.  '</body>' . "\n"
    		.  '</html>' . "\n";
//print_r($tournament_data);
//exit;
		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$pdf = $pdf_header;
        for( $tournament_index = 0; $tournament_index < count($tournament_data['data']); $tournament_index++ ){
            $one_tounament = $tournament_data['data'][$tournament_index];
//print_r($one_tounament);
            if( $one_tounament['match_level'] == 1 ){
                $extra_index = $one_tounament['tournament_player_num'] - 1;
                $pdf .= '<div class="">'.$one_tounament['tournament_name'].'</div>' . "\n";
	        	$pdf .= '  <br />' . "\n";
		        $pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
    		    $pdf .= '<tr>' . "\n";
	    	    $pdf .= '<td class="div_result_tournament_name_name" rowspan="' . $table_name_rowspan . '" lang="ja">';
                $pdf .= $one_tounament['match'][0]['player1_name'];
                $pdf .= '</td>' . "\n";
             	$pdf .= '<td class="div_result_tournament_name_pref" rowspan="' . $table_name_rowspan . '" lang="ja">';
    			if( $one_tounament['match'][0]['player1'] != 0 ){
                    $pdf .= '(' . $one_tounament['match'][0]['player1_belonging_to_name'] . ')';
                }
                $pdf .= '</td>' . "\n";
                $pdf .= '<td height="'.$table_height.'" class="div_border_b';
                if( $one_tounament['match'][0]['winner'] == 1 ){
                    $pdf .= '_win';
                }
    		    $pdf .= ' div_result_one_tournament">';
	    	    if( $one_tounament['match'][0]['fusen'] == 1 && $one_tounament['match'][0]['winner'] == 1 ){
	    		    $pdf .= '不戦勝' . "\n";
		        } else {
			        $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_1'] );
			        $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_2'] );
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_3'] );
        		}
                $pdf .= '</td>' . "\n";
	    	    $pdf .= '</tr>' . "\n";
		        $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][0]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
	    	    $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][0]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament">';
                if( $one_tounament['match'][0]['winner'] != 0 ){
                //    $pdf .= $one_tounament['match'][0]['win1'] . ' - ' . $one_tounament['match'][0]['win2'];
                }
                $pdf .= '&nbsp;';
                if( $one_tounament['match'][0]['extra'] == 1 ){
                    $pdf .= '延';
                }
                $pdf .= '&nbsp;</td>';
                $pdf .= '<td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td>';
                $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
                if( $one_tounament['match'][0]['winner'] == 1 ){
		            $pdf .= $one_tounament['match'][0]['player1_name'];
                } else if( $one_tounament['match'][0]['winner'] == 2 ){
		            $pdf .= $one_tounament['match'][0]['player2_name'];
                }
    	    	$pdf .= '</td></tr>' . "\n";
	    	    $pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>';
	    	    $pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>';
                $pdf .= '<td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][0]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
    		    $pdf .= '<tr>' . "\n";
	    	    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
                $pdf .= $one_tounament['match'][0]['player2_name'];
                $pdf .= '</td>' . "\n";
             	$pdf .= '<td class="div_result_tournament_name_pref" rowspan="' . $table_name_rowspan . '" lang="ja">';
    			if( $one_tounament['match'][0]['player2'] != 0 ){
                    $pdf .= '(' . $one_tounament['match'][0]['player2_belonging_to_name'] . ')';
                }
                $pdf .= '</td>' . "\n";
                $pdf .= '<td height="'.$table_height.'" class="div_border_br';
                if( $one_tounament['match'][0]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td>' . "\n";
    		    $pdf .= '</tr>' . "\n";
	    	    $pdf .= '<tr><td class="div_result_one_tournament" height="'.$table_height.'" lang="ja">';
		        if( $one_tounament['match'][0]['fusen'] == 1 && $one_tounament['match'][0]['winner'] == 2 ){
			        $pdf .= '不戦勝' . "\n";
    		    } else {
	    		    $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_1'] );
		    	    $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_2'] );
			        $pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_3'] );
		        }
        		$pdf .= '</td></tr>' . "\n";
	        	$pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
    	    	$pdf .= '  </table>' . "\n";
            } else {
    		    $match_no_top = 1;
	    	    for( $i1 = 1; $i1 < $one_tounament['match_level']; $i1++ ){ $match_no_top *= 2; }
    		    $match_no = $match_no_top;
	    	    $match_line1 = array();
		        $match_line2 = array();
        		$one_match = array();
        		$team_pos = 0;
		        $team_num = count( $one_tounament['player'] );
        		$team_num2 = intval( $team_num / 2 );
        		$team_index = 1;
                $max_team_pos = 0;
        		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
        			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
        				$team_pos = 0;
        			}
        			//$name = $one_tounament['player'][$tournament_team]['sei'].' '.$one_tounament['player'][$tournament_team]['mei'];
        			//$pref = $one_tounament['player'][$tournament_team]['school_name_ryaku'];
        			if( ( $tournament_team % 2 ) == 0 ){
        			    $name = $one_tounament['match'][$match_no-1]['player1_name'];
        			    if( $one_tounament['match'][$match_no-1]['player1_belonging_to_name2'] != '' ){
            			    $pref = $one_tounament['match'][$match_no-1]['player1_belonging_to_name2'] . '・' . $one_tounament['match'][$match_no-1]['player1_belonging_to_name'];
                        } else {
            			    $pref = $one_tounament['match'][$match_no-1]['player1_belonging_to_name'];
                        }
        				//$one_match['win1'] = $one_tounament['match'][$match_no-1]['win1'];
        				$one_match['hon1'] = $one_tounament['match'][$match_no-1]['hon1'];
        				//$one_match['win2'] = $one_tounament['match'][$match_no-1]['win2'];
        				$one_match['hon2'] = $one_tounament['match'][$match_no-1]['hon2'];
        				$one_match['waza1_1'] = $one_tounament['match'][$match_no-1]['waza1_1'];
        				$one_match['waza1_2'] = $one_tounament['match'][$match_no-1]['waza1_2'];
        				$one_match['waza1_3'] = $one_tounament['match'][$match_no-1]['waza1_3'];
        				$one_match['waza2_1'] = $one_tounament['match'][$match_no-1]['waza2_1'];
        				$one_match['waza2_2'] = $one_tounament['match'][$match_no-1]['waza2_2'];
        				$one_match['waza2_3'] = $one_tounament['match'][$match_no-1]['waza2_3'];
        				$one_match['winner'] = $one_tounament['match'][$match_no-1]['winner'];
        				$one_match['fusen'] = $one_tounament['match'][$match_no-1]['fusen'];
                        $one_match['extra'] = $one_tounament['match'][$match_no-1]['extra'];
        				$one_match['up1'] = 0;
        				$one_match['up2'] = 0;
        				//$one_match['match_no'] = $one_tounament['match'][$match_no-1]['dantai_tournament_match_id'];
        				$one_match['place'] = $one_tounament['match'][$match_no-1]['place'];
        				$one_match['place_match_no'] = $one_tounament['match'][$match_no-1]['place_match_no'];
        				if( $one_match['place'] !== 'no_match' || $one_tounament['match'][$match_no-1]['player1'] != 0 ){
        					$one_match['team1'] = array(
        						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
        					);
                            if( $max_team_pos < $team_pos ){ $max_team_pos = $team_pos; }
        					$team_pos++;
        					$team_index++;
        				}
        				//$match_no++;
        			} else {
        			    $name = $one_tounament['match'][$match_no-1]['player2_name'];
       					if( $one_tounament['match'][$match_no-1]['player2'] != 0 ){
            			    if( $one_tounament['match'][$match_no-1]['player2_belonging_to_name2'] != '' ){
                			    $pref = $one_tounament['match'][$match_no-1]['player2_belonging_to_name2'] . '・' . $one_tounament['match'][$match_no-1]['player2_belonging_to_name'];
                            } else {
                			    $pref = $one_tounament['match'][$match_no-1]['player2_belonging_to_name'];
                            }
                        } else {
                            $pref = '';
                        }
        				if( $one_match['place'] !== 'no_match' ){
        					$one_match['team2'] = array(
        						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
        					);
        					$team_pos++;
        					$team_index++;
        				} else {
        					if( $one_tounament['match'][$match_no-1]['player2'] != 0 ){
        						$one_match['team2'] = array(
        							'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
        						);
                                if( $max_team_pos < $team_pos ){ $max_team_pos = $team_pos; }
        						$team_pos++;
        						$team_index++;
        					}
        				}
        				if( $tournament_team == 1 || $tournament_team < $team_num2 ){
        					$match_line1[] = $one_match;
        				} else {
        					$match_line2[] = $one_match;
        				}
        				$one_match = array();
        				$match_no++;
        			}
        		}
        		$match_no_top /= 2;
//nl2br(print_r($match_line1,true));
//echo "<br />\n";
//nl2br(print_r($match_line2,true));
//echo "<br />\n";

        		$match_tbl = array( array(), array() );
        		$match_tbl[0][] = $match_line1;
        		$match_tbl[1][] = $match_line2;
        		for( $i1 = 1; $i1 < $one_tounament['match_level']-1; $i1++ ){
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
        						$one_match['match_no'] = $one_tounament['match'][$match_no-1]['match'];
        						//$one_match['win1'] = $one_tounament['match'][$match_no-1]['win1'];
        						$one_match['hon1'] = $one_tounament['match'][$match_no-1]['hon1'];
        						//$one_match['win2'] = $one_tounament['match'][$match_no-1]['win2'];
        						$one_match['hon2'] = $one_tounament['match'][$match_no-1]['hon2'];
        						$one_match['waza1_1'] = $one_tounament['match'][$match_no-1]['waza1_1'];
        						$one_match['waza1_2'] = $one_tounament['match'][$match_no-1]['waza1_2'];
        						$one_match['waza1_3'] = $one_tounament['match'][$match_no-1]['waza1_3'];
        						$one_match['waza2_1'] = $one_tounament['match'][$match_no-1]['waza2_1'];
        						$one_match['waza2_2'] = $one_tounament['match'][$match_no-1]['waza2_2'];
        						$one_match['waza2_3'] = $one_tounament['match'][$match_no-1]['waza2_3'];
        						$one_match['winner'] = $one_tounament['match'][$match_no-1]['winner'];
        						$one_match['fusen'] = $one_tounament['match'][$match_no-1]['fusen'];
        						$one_match['extra'] = $one_tounament['match'][$match_no-1]['extra'];
        						$one_match['place'] = $one_tounament['match'][$match_no-1]['place'];
        						$one_match['place_match_no'] = $one_tounament['match'][$match_no-1]['place_match_no'];
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
        		for( $level = 0; $level < $one_tounament['match_level']-1; $level++ ){
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
        		$line2 = ( $max_team_pos + 1 ) * 2 + 1;
                $pdf .= '    <div class="div_result_tournament_name_name_">'.$one_tounament['tournament_name'].'</div>' . "\n";
        		$pdf .= '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
        		for(;;){
        			$pdf .= '      <tr>' . "\n";
        			$allend = 1;
        			for( $level = 0; $level < $one_tounament['match_level']-1; $level++ ){
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
                                $pdf .= '<td class="';
                                if( mb_strlen( $one_match_tbl['team1']['name'] ) > 6 ){
        						    $pdf .= 'div_result_tournament_name_name2';
                                } else {
        						    $pdf .= 'div_result_tournament_name_name';
                                }
                                $pdf .= '" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
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
        					} else if( $one_match_tbl['place'] != 'no_match' ){
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
                                //if( $one_match_tbl['winner'] == 1 && $one_match_tbl['extra'] == 1 ){
                                //    $pdf .= '(延)';
                                //}
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
        							$pdf .= '<td class="';
                                    if( mb_strlen( $one_match_tbl['team2']['name'] ) > 6 ){
        	    					    $pdf .= 'div_result_tournament_name_name2';
                                    } else {
        			    			    $pdf .= 'div_result_tournament_name_name';
                                    }
                                    $pdf .= '" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
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
        						} else if( $one_match_tbl['place'] != 'no_match' ){
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
                                    if( $one_match_tbl['winner'] == 2 && $one_match_tbl['extra'] == 1 ){
                                    //    $pdf .= '(延)';
                                    }
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
                                    $extra = '';
        							if( $level == $one_tounament['match_level']-2 ){
        								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
        									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
        								){
        									$win = '_win';
        								}
        								if( $line == $line2 && $one_match_tbl['extra'] == 1 ){
        									$extra = '<span class="text_extra">延</span>';
        								}
        							} else {
        								if( ( $line <= $trmatch[$level] && $one_match_tbl['winner'] == 1 )
        									|| ( $line > $trmatch[$level] && $one_match_tbl['winner'] == 2 )
        								){
        									$win = '_win';
        								}
        								if( $line == $trmatch[$level] && $one_match_tbl['extra'] == 1 ){
        									$extra = '<span class="text_extra">延</span>';
        								}
        							}
        							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament">';
                                    $pdf .= $extra;
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
        				if( $one_tounament['match'][0]['winner'] > 0 ){
        					$win = '_win';
        				}
        				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
        			} else if( $line == $line2 ){
        				$win = '';
        				if( $one_tounament['match'][0]['winner'] == 1 ){
        					$win = '_final';
        				} else if( $one_tounament['match'][0]['winner'] == 2 ){
        					$win = '_final2';
        				}
        				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
        				$win = '';
        				if( $one_tounament['match'][0]['winner'] == 2 ){
        					$win = '_win';
        				}
        				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
        			} else if( $line == $line2 + 1 ){
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament2">';
        				if( $one_tounament['match'][0]['fusen'] == 1 && $one_tounament['match'][0]['winner'] == 1 ){
        					$pdf .= '不戦勝';
        				} else {
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_1'] );
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_2'] );
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza1_3'] );
                            if( $one_tounament['match'][0]['extra'] == 1 ){
                                //$pdf .= '&nbsp;延';
                            }
                        }
                        $pdf .= '</td>';
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament">';
        				if( $one_tounament['match'][0]['fusen'] == 1 && $one_tounament['match'][0]['winner'] == 2 ){
        					$pdf .= '不戦勝';
        				} else {
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_1'] );
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_2'] );
        					$pdf .= $c->get_waza_name( $one_tounament['match'][0]['waza2_3'] );
                            if( $one_tounament['match'][0]['winner'] == 2 && $one_tounament['match'][0]['extra'] == 1 ){
                                //$pdf .= '(延)';
                            }
        				}
                        $pdf .= '</td>';
        			} else if( $line == $line2 + 2 ){
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament">';
                        if( $one_tounament['match'][0]['extra'] == 1 ){
                            $pdf .= '延';
                        }
                        $pdf .= '</td>';
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
        			} else {
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
        				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
        			}
        			for( $level = $one_tounament['match_level']-2; $level >= 0; $level-- ){
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
        					$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament2">';
        					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
        						$pdf .= '不戦勝' . "\n";
        					} else if( $one_match_tbl['place'] != 'no_match' ){
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
        						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
                                if( $one_match_tbl['winner'] == 1 && $one_match_tbl['extra'] == 1 ){
                                    //$pdf .= '(延)';
                                }
                            }
        					$pdf .= '</td>' . "\n";
        					if( $level == 0 ){
        						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
        						$pdf .= '<td class="';
                                if( mb_strlen( $one_match_tbl['team1']['name'] ) > 6 ){
            					    $pdf .= 'div_result_tournament_name_name2';
                                } else {
        		    			    $pdf .= 'div_result_tournament_name_name';
                                }
                                $pdf .= '" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
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
        						$pdf .= '<td height="'.$table_height.'" class="div_border_bl'.$win.' div_result_one_tournament2">';
        						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
        							$pdf .= '不戦勝' . "\n";
        						} else if( $one_match_tbl['place'] != 'no_match' ){
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
        							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
                                    if( $one_match_tbl['winner'] == 2 && $one_match_tbl['extra'] == 1 ){
                                        //$pdf .= '(延)';
                                    }
        						}
        						$pdf .= '</td>' . "\n";
        						if( $level == 0 ){
        							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
        							$pdf .= '<td class="';
                                    if( mb_strlen( $one_match_tbl['team2']['name'] ) > 6 ){
        	    					    $pdf .= 'div_result_tournament_name_name2';
                                    } else {
        			    			    $pdf .= 'div_result_tournament_name_name';
                                    }
                                    $pdf .= '" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
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
        							$extra = '';
        							if( $level == $one_tounament['match_level']-2 ){
        								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
        									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
        								){
        									$win = '_win';
        								}
        								if( $line == $line2 && $one_match_tbl['extra'] == 1 ){
        									$extra = '<span class="text_extra">延</span>';
        								}
        							} else {
        								if( ( $line <= $trmatch2[$level] && $one_match_tbl['winner'] == 1 )
        									|| ( $line > $trmatch2[$level] && $one_match_tbl['winner'] == 2 )
        								){
        									$win = '_win';
        								}
        								if( $line == $trmatch[$level] && $one_match_tbl['extra'] == 1 ){
        									$extra = '<span class="text_extra">延</span>';
        								}
        							}
        							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2">';
                                    $pdf .= $extra;
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
        if( $line == 3000 ){ break; }
        		}
        
        		$pdf .= '    </div>' . "\n";
        		$pdf .=  '    </table>' . "\n";
        		$pdf .=  '  <br /><br /><br /><br /><br /><br />' . "\n";
            }
            if( $one_tounament['extra_match_num'] > 0 ){
                $extra_index = $one_tounament['tournament_player_num'] - 1;
                $pdf .= '<div class="div_result_tournament_name_name">'.$one_tounament['extra_name'].'</div>' . "\n";
	    	    $pdf .= '  <br /><br /><br />' . "\n";
    		    $pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
	    	    $pdf .= '<tr>' . "\n";
		        $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $one_tounament['match'][$extra_index]['player1_name'] . '</td>' . "\n";
		        $pdf .= '<td height="'.$table_height.'" class="div_border_b';
                if( $one_tounament['match'][$extra_index]['winner'] == 1 ){ $pdf .= '_win'; }
	    	    $pdf .= ' div_result_one_tournament">';
		        if( $one_tounament['match'][$extra_index]['fusen'] == 1 && $one_tounament['match'][$extra_index]['winner'] == 1 ){
			        $pdf .= '不戦勝' . "\n";
    		    } else {
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza1_1'] );
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza1_2'] );
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza1_3'] );
        		}
                $pdf .= '</td>' . "\n";
    		    $pdf .= '</tr>' . "\n";
    		    $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][$extra_index]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
    		    $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][$extra_index]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament">';
                if( $one_tounament['match'][$extra_index]['winner'] != 0 ){ $pdf .= $one_tounament['match'][$extra_index]['win1'] . ' - ' . $one_tounament['match'][$extra_index]['win2']; }
                $pdf .= '&nbsp;';
                if( $one_tounament['match'][$extra_index]['extra'] == 1 ){
                    $pdf .= '延';
                }
                $pdf .= '&nbsp;</td><td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td><td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
                if( $one_tounament['match'][$extra_index]['winner'] == 1 ){
    		        $pdf .= $one_tounament['match'][$extra_index]['player1_name'];
                } else if( $one_tounament['match'][$extra_index]['winner'] == 2 ){
    		        $pdf .= $one_tounament['match'][$extra_index]['player2_name'];
                }
    	    	$pdf .= '</td></tr>' . "\n";
    		    $pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td><td height="'.$table_height.'" class="div_border_r';
                if( $one_tounament['match'][$extra_index]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
    		    $pdf .= '<tr>' . "\n";
    		    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $one_tounament['match'][$extra_index]['player2_name'] . '<td height="'.$table_height.'" class="div_border_br';
                if( $one_tounament['match'][$extra_index]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td>' . "\n";
    		    $pdf .= '</tr>' . "\n";
    		    $pdf .= '<tr><td class="div_result_one_tournament" height="'.$table_height.'" lang="ja">';
    		    if( $one_tounament['match'][$extra_index]['fusen'] == 1 && $one_tounament['match'][$extra_index]['winner'] == 2 ){
    			    $pdf .= '不戦勝' . "\n";
    		    } else {
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza2_1'] );
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza2_2'] );
    			    $pdf .= $c->get_waza_name( $one_tounament['match'][$extra_index]['waza2_3'] );
    		    }
        		$pdf .= '</td></tr>' . "\n";
    	    	$pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
        		$pdf .= '  </table>' . "\n";
    	    	$pdf .= '  <br /><br /><br />' . "\n";
            }
    		if( !$break_html[$tournament_index] ){
    	    	$pdf .= '  <br /><br /><br />' . "\n";
    			continue;
    		}
//$pdf .= '<!--'."\n";
//$pdf .= print_r($one_tounament,true);
//$pdf .= '-->'."\n";
            $pdf .=  $pdf_footer;

    		$file = $break_html_name[$tournament_index];
            $path = $navi_info['result_path'] . '/' . $file . '.html';
    		$fp = fopen( $path, 'w' );
    		fwrite( $fp, $pdf );
    		fclose( $fp );
    		$data = [
    			'mode' => 2,
    			'navi' => $navi_info['navi_id'],
    			'place' => $file,
    			'file' => $path,
    			'series' => $navi_info['result_path_prefix'], // . '/' . $navi_info['reg_year'],
    		];
    		$this->__pageObj->update_realtime_queue( $data );

    		$pdf = $pdf_header;
        }
    }

	function set_referee( $match, $referee_no, $referee_id )
	{
		if( $match == 0 ){ return; }
		if( $referee_no == 0 ){ return; }
		if( $referee_id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `kojin_match` set `referee' . $referee_no . '`='.$referee_id.' where `id`='.$match;
//echo $sql;
		db_query( $dbs, $sql );
	}

}

