<?php

    function output_realtime_html_for_one_board_get_dantai_player_name( $data, $seriesinfo, $match_info, $player, $match )
    {
        $player_field = 'player' . $player;
        $player_no = $data['matches'][$match][$player_field];
        if( $player_no == 0 ){
            $html = '&nbsp;';
        } if( $player_no == __PLAYER_NAME__ ){
            $html = string_insert_br( $data['matches'][$match][$player_field.'_change_name'] );
        } else {
            if( $match_info['series_mw'] === '' ){
                $f2 = $seriesinfo['dantai_m_field_head'];
            } else {
                $f2 = $seriesinfo['dantai_'.$match_info['series_mw'].'_field_head'];
            }
            //$f = $f2.$data['matches'][$match][$player_field];
            $f = sprintf( $f2, $player_no );
            if( $data['entry'.$player][$f.'_disp'] != '' ){
                $html = string_insert_br( $data['entry'.$player][$f.'_disp'] );
            } else {
                $name = $data['entry'.$player][$f.'_sei'];
                $html = string_insert_br( $name );
                for( $fi = 1; $fi <= 7; $fi++ ){
                    $f3 = sprintf( $f2, $fi );
                    $name2 = $data['entry'.$player][$f3.'_sei'];
                    if( $fi != $player_no && $name2 != '' && $name == $name2 ){
                        $add1 = mb_substr( $data['entry'.$player][$f.'_mei'], 0, 1 );
                        $add2 = mb_substr( $data['entry'.$player][$f3.'_mei'], 0, 1 );
                        if( $add1 == $add2 ){
                            $add1 = mb_substr( $data['entry'.$player][$f.'_mei'], 1, 1 );
                        }
                        $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                        break;
                    }
                }
            }
        }
        return $html;
    }

    function __output_realtime_html_for_one_board_sub( $navi_id, $place, $place_match_no, $place_match_player_no, $objPage, $match_info, $match, $series_info )
    {
        if( $match_info['series_lt'] == 'dl' || $match_info['series_lt'] == 'dt' ){
            if( $match_info['series_lt'] == 'dl' ){
                $data = $objPage->get_dantai_league_one_result( $match );
            } else {
                $data = $objPage->get_dantai_tournament_one_result( $match );
            }
//print_r($data);
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
                                    $winner = 2;
                                    break;
                                } else {
                                    if( $data['exist_match6'] == 1 ){
/*
                                        if( $data['matches'][6]['waza1_1'] != 0 ){
                                            $result1 = 1;
                                            $result1str = '○';
                                            $result2 = 0;
                                            $result2str = '△';
                                            $winner = 1;
                                            break;
                                        } else if( $data['matches'][6]['waza2_1'] != 0 ){
                                            $result1 = 0;
                                            $result1str = '△';
                                            $result2 = 1;
                                            $result2str = '○';
                                            $winner = 2;
                                            break;
                                        }
*/
                                    } else {
                                        $result1 = 0;
                                        $result1str = '□';
                                        $result2 = 0;
                                        $result2str = '□';
                                        $winner = 0;
                                        break;
                                    }
                                }
                            }
                            $match_end = 1;
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
/**/
                    if( $i1 == 6 ){
                        if( $data['exist_match6'] == 1 && $endnum == 5 && $data['matches'][6]['end_match'] == 1 ){
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
                            $match_end = 1;
                        }
                    }
/**/
                }
            }
        } else {
            $objTournament = new form_page_kojin_tournament( $objPage );
            $hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
            $data_prev = array();
            if( $place_match_no > 1 ){
                $match_info2 = $objPage->get_series_place_prev_navi_data( $navi_id, $place, $place_match_no-1 );
                if( $match_info2['series_lt'] == 'kt' ){
                    $data_prev = $objTournament->get_kojin_tournament_one_result(
                        $match_info2['series'],
                        $match_info2['series_mw'],
                        $match_info2['match_id']
                    );
                    $data['matches'][1] = $data_prev['matches'];
                    for( $waza = 1; $waza <= 3; $waza++ ){
                        if( $data_prev['matches']['waza1_'.$waza] != 0 ){
                            $hon1[1]++;
                        }
                        if( $data_prev['matches']['waza2_'.$waza] != 0 ){
                            $hon2[1]++;
                        }
                    }
                }
            }
            $data_now = $objTournament->get_kojin_tournament_one_result(
                $match_info['series'], $match_info['series_mw'], $match
            );
//print_r($data_now);
            $data['matches'][3] = $data_now['matches'];
            for( $waza = 1; $waza <= 3; $waza++ ){
                if( $data_now['matches']['waza1_'.$waza] != 0 ){
                    $hon1[3]++;
                }
                if( $data_now['matches']['waza2_'.$waza] != 0 ){
                    $hon2[3]++;
                }
            }
            $data_next = array();
            $match_info2 = $objPage->get_series_place_next_navi_data( $navi_id, $place, $place_match_no+1 );
            if( count( $match_info2 ) > 0 && $match_info2['series_lt'] == 'kt' ){
                $data_next = $objTournament->get_kojin_tournament_one_result(
                    $match_info2['series'],
                    $match_info2['series_mw'],
                    $match_info2['match_id']
                );
                $data['matches'][5] = $data_next['matches'];
                for( $waza = 1; $waza <= 3; $waza++ ){
                    if( $data_next['matches']['waza1_'.$waza] != 0 ){
                        $hon1[5]++;
                    }
                    if( $data_next['matches']['waza2_'.$waza] != 0 ){
                         $hon2[5]++;
                    }
                }
            }
        }
        $fontlen = mb_strlen( get_field_string($data['entry1'],'school_name_ryaku'),'UTF-8' );
        $fontlen2 = mb_strlen( get_field_string($data['entry2'],'school_name_ryaku'),'UTF-8' );
        if( $fontlen < $fontlen2 ){
            $fontlen = $fontlen2;
        }
        $html = '    <div align="center" id="result1" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        $html .= '      <div class="tb_score_title">第'.$match_info['place_match_no'].'試合</div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_title tb_frame_bbottom">'."\n";
        if( $match_info['series_lt'] != 'kt' ){ $html .= 'チーム名'; }
        $html .= '</div>'."\n";
        if( $fontlen >= 15 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont15" id="school_name1">'."\n";
        } else if( $fontlen > 5 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont'.$fontlen.'" id="school_name1">'."\n";
        } else {
            $html .= '        <div class="tb_frame_content2" id="school_name1">'."\n";
        }
        $html .= '          '.get_field_string_insert_br($data['entry1'],'school_name_ryaku')."\n";
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        for( $i1 = 1; $i1 <= 5; $i1++ ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '        <div class="tb_frame_title tb_frame_bbottom';
            if( $place_match_player_no > 0 && $place_match_player_no == $i1 ){
                $html .= ' tb_frame_current_match';
            }
            $html .= '">';
            if( $match_info['series_lt'] != 'kt' ){
                if( $i1 == 1 ){
                    $html .=  '先鋒';
                } else if( $i1 == 2 ){
                    $html .=  '次鋒';
                } else if( $i1 == 3 ){
                    $html .=  '中堅';
                } else if( $i1 == 4 ){
                    $html .=  '副将';
                } else if( $i1 == 5 ){
                    $html .=  '大将';
                }
            } else {
                if( $i1 == 1 ){
                    $html .=  '前試合';
                } else if( $i1 == 2 ){
                } else if( $i1 == 3 ){
                } else if( $i1 == 4 ){
                } else if( $i1 == 5 ){
                    $html .=  '次試合';
                }
            }
            $html .=  '</div>'."\n";
            $html .=  '        <div class="tb_frame_content';
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player1'] != 0 ){
                if(
                    ( $series_info['score_hoin_mode'] == 1 && $data['matches'][$i1]['player1'] != $i1 )
                    || ( $series_info['score_hoin_mode'] == 2 && $data['matches'][$i1]['player1'] >= 6 )
                ){
                    $html .=   ' tb_frame_hoin_player';
                }
            }
            if( $match_info['series_lt'] != 'kt' ){
                $name_html = output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 1, $i1 );
                //if( mb_strlen( $name_html,'UTF-8' ) > 4 ){
                $name_html_len = mb_strlen( $name_html,'UTF-8' );
                if( $name_html_len != 8 && $name_html_len != 15 && $name_html_len != 1 && $name_html_len != 50 ){
                    $html .=   ' tb_frame_content2_smallfont7';
                }
            }
            $html .=   '" id="player1_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
                $html .= $name_html;
                //$html .= mb_strlen( $name_html,'UTF-8' );
                //output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 1, $i1 );
/*
                if( $data['matches'][$i1]['player1'] == 0 ){
                    $html .=   '&nbsp;';
                } if( $data['matches'][$i1]['player1'] == __PLAYER_NAME__ ){
                    $html .= string_insert_br( $data['matches'][$i1]['player1_change_name'] );
                } else {
                    if( $match_info['series_mw'] === '' ){
                        $f = 'player'.$data['matches'][$i1]['player1'];
                        $f2 = 'player';
                    } else {
                        if( $series_info['player_field_mode'] == 3 ){
                            $f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                            $f2 = 'dantai_'.$match_info['series_mw'];
                        } else {
                           //$f = 'player'.$data['matches'][$i1]['player1'].'_'.$match_info['series_mw'];
                        //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                           $f = 'player'.$data['matches'][$i1]['player1'];
                           $f2 = 'player';
                        }
                    }
                    if( $data['entry1'][$f.'_disp'] != '' ){
                        $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
                    } else {
                        $name = $data['entry1'][$f.'_sei'];
                        $html .= string_insert_br( $name );
                        for( $fi = 1; $fi <= 7; $fi++ ){
                            //$name2 = $data['entry1'][$f2.$fi.'_'.$match_info['series_mw'].'_sei'];
                            $name2 = $data['entry1'][$f2.$fi.'_sei'];
                            if( $fi != $data['matches'][$i1]['player1'] && $name2 != '' && $name == $name2 ){
                                $add1 = mb_substr( $data['entry1'][$f.'_mei'], 0, 1 );
                                $add2 = mb_substr( $data['entry1'][$f2.$fi.'_mei'], 0, 1 );
                                if( $add1 == $add2 ){
                                    $add1 = mb_substr( $data['entry1'][$f.'_mei'], 1, 1 );
                                }
                                $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                                break;
                            }
                        }
                    }
                }
*/
            } else {
                if( $i1 == 1 ){
                    $html .= string_insert_br( $data_prev['players'][1]['name_str2'] );
                } else if( $i1 == 2 ){
                } else if( $i1 == 3 ){
                    $html .= string_insert_br( $data_now['players'][1]['name_str2'] );
                } else if( $i1 == 4 ){
                } else if( $i1 == 5 ){
                    $html .= string_insert_br( $data_next['players'][1]['name_str2'] );
                }
            }
            if( $data['matches'][$i1]['supporter1'] == 1 ){
                $html .= '<div class="tb_frame_supporter1">●</div>';
            }
            if( $data['matches'][$i1]['end_match'] == 1 ){
                $fusen = false;
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if( $data['matches'][$i1]['waza1_'.$i2] == 5 || $data['matches'][$i1]['waza2_'.$i2] == 5 ){
                        $fusen = true;
                        break;
                    }
                }
                if( !$fusen ){
                    if( ( $hon1[$i1] == 1 && $hon2[$i1] == 0 ) || ( $hon1[$i1] == 0 && $hon2[$i1] == 1 ) ){
                        if( $data['matches'][$i1]['extra'] == 0 ){
                            $html .=   '<div class="tb_frame_ippon">一本勝</div>';
                        }
                    } else if( $hon1[$i1] == $hon2[$i1] ){
                        $html .=   '<div class="tb_frame_draw">×</div>';
                    }
                }
            }
            $html .=   '</div>'."\n";
            $html .=   '        <div class="tb_frame_waza tb_frame_btop">'."\n";
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
                    $html .=   '          <div class="tb_frame_waza2">';
                } else {
                    $html .=   '          <div class="tb_frame_waza1">';
                }
                if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
                if($data['matches'][$i1]['waza1_'.$i2]==1){ $html .= 'メ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==2){ $html .= 'ド'; }
                if($data['matches'][$i1]['waza1_'.$i2]==3){ $html .= 'コ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==4){ $html .= '反'; }
                if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .= '○'; }
                if($data['matches'][$i1]['waza1_'.$i2]==6){ $html .= 'ツ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==7){ $html .= '判'; }
                $html .=   '</div>'."\n";
            }
            $html .=   '        </div>'."\n";
            $html .=   '        <div class="tb_frame_faul">'."\n";
            if( $data['matches'][$i1]['faul1_1'] == 2 ){ $html .=   '指'; }
            if( $data['matches'][$i1]['faul1_2'] == 1 ){ $html .=   '▲'; }
            if( $data['matches'][$i1]['extra'] == 1 ){
                $html .=   '          <div class="tb_frame_faul_extra" id="extra_match'.$i1.'">延長</div>'."\n";
            }
            $html .=   '        </div>'."\n";
            $html .=   '      </div>'."\n";
        }

        $html .= '        <div class="tb_frame">'."\n";
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        if( $match_info['series_lt'] != 'kt' ){ $html .= '結果'; }
        $html .= '</div>'."\n";
        $html .= '          <div class="tb_frame_result_content">'."\n";
        if( $match_info['series_lt'] != 'kt' ){
            if( $winner == 0 ){ //|| $data['exist_match6'] == 1 ){
                $html .= '           <span class="result-square"></span>'."\n";
            } else if( $winner == 1 ){
                $html .= '            <span class="result-circle"></span>'."\n";
            } else if( $winner == 2 ){
                $html .= '            <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            }
            $html .= '            <div class="tb_frame_result_hon">'.$hon1sum.'</div>'."\n";
            $html .= '            <div class="tb_frame_result_win">'.$win1sum.'</div>'."\n";
            if( $data['exist_match6'] == 1 && $winner == 1 ){
                $html .= '            <div class="tb_frame_result_win_dai">代</div>'."\n";
            }
        }
        $html .= '          </div>'."\n";
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame">'."\n";
        $html .= '          <div class="tb_frame_title tb_frame_bbottom';
        if( $place_match_player_no == 6 ){
            $html .= ' tb_frame_current_match';
        }
        $html .= '">';
        if( $match_info['series_lt'] != 'kt' ){ $html .= '代表戦'; }
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_content';
        if( $match_info['series_lt'] != 'kt' ){
            $name_html = output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 1, 6 );
            //if( mb_strlen( $name_html,'UTF-8' ) > 4 ){
            $name_html_len = mb_strlen( $name_html,'UTF-8' );
            if( $name_html_len != 8 && $name_html_len != 15 && $name_html_len != 1 && $name_html_len != 50 ){
                $html .=   ' tb_frame_content2_smallfont7';
            }
        }
        $html .= '" id="player1_6">';
        if( $match_info['series_lt'] != 'kt' ){
            $html .= $name_html;
        }
        //$html .= output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 1, 6 );
/*
        if( $data['matches'][6]['player1'] == 0 ){
            $html .= '&nbsp;';
        } if( $data['matches'][6]['player1'] == __PLAYER_NAME__ ){
            $html .= string_insert_br( $data['matches'][6]['player1_change_name'] );
        } else {
            if( $match_info['series_mw'] === '' ){
                $f = 'player'.$data['matches'][6]['player1'];
                $f2 = 'player';
            } else {
                if( $series_info['player_field_mode'] == 3 ){
                    $f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player1'];
                    $f2 = 'dantai_'.$match_info['series_mw'];
                } else {
                    //$f = 'player'.$data['matches'][6]['player1'].'_'.$match_info['series_mw'];
                    //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player1'];
                    $f = 'player'.$data['matches'][6]['player1'];
                    $f2 = 'player';
                }
            }
            if( $data['entry1'][$f.'_disp'] != '' ){
                $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
            } else {
                $name = $data['entry1'][$f.'_sei'];
                $html .= string_insert_br( $name );
                for( $fi = 1; $fi <= 7; $fi++ ){
                    $name2 = $data['entry1'][$f2.$fi.'_sei'];
                    if( $fi != $data['matches'][6]['player1'] && $name2 != '' && $name == $name2 ){
                        $add1 = mb_substr( $data['entry1'][$f.'_mei'], 0, 1 );
                        $add2 = mb_substr( $data['entry1'][$f2.$fi.'_mei'], 0, 1 );
                        if( $add1 == $add2 ){
                            $add1 = mb_substr( $data['entry1'][$f.'_mei'], 1, 1 );
                        }
                        $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                        break;
                    }
                }
            }
        }
*/
        if( $data['matches'][6]['supporter1'] == 1 ){
            $html .= '<div class="tb_frame_supporter1">●</div>';
        }
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_waza tb_frame_btop">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            $html .= '          <div class="tb_frame_waza1">';
            if($data['matches'][6]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
            if($data['matches'][6]['waza1_'.$i2]==1){ $html .= 'メ'; }
            if($data['matches'][6]['waza1_'.$i2]==2){ $html .= 'ド'; }
            if($data['matches'][6]['waza1_'.$i2]==3){ $html .= 'コ'; }
            if($data['matches'][6]['waza1_'.$i2]==4){ $html .= '反'; }
            if($data['matches'][6]['waza1_'.$i2]==5){ $html .= '○'; }
            if($data['matches'][6]['waza1_'.$i2]==6){ $html .= 'ツ'; }
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_faul">'."\n";
        if($data['matches'][6]['faul1_1']==2){ $html .= '指'; }
        if($data['matches'][6]['faul1_2']==1){ $html .= '▲'; }
        if($data['matches'][6]['extra']==1){
            $html .= '          <div class="tb_frame_faul_extra" id="extra_match<?php echo $i1; ?>">延長</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        if( $series_info['enable_referee'] != 0 ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '          <div class="tb_frame_title tb_frame_bbottom">主審</div>'."\n";
            $html .= '          <div class="tb_frame_referee">'.string_insert_br( $data['referee1_name'] ).'</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '            <div class="tb_frame">'."\n";
        if( $fontlen >= 15 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont15" id="school_name2">'."\n";
        } else if( $fontlen > 5 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont'.$fontlen.'" id="school_name2">'."\n";
        } else {
            $html .= '        <div class="tb_frame_content2" id="school_name2">'."\n";
        }
        $html .= get_field_string_insert_br($data['entry2'],'school_name_ryaku');
        $html .= '              </div>'."\n";
        $html .= '            </div>'."\n";
        for( $i1 = 1; $i1 <= 5; $i1++ ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '        <div class="tb_frame_faul">';
            if($data['matches'][$i1]['faul2_1']==2){ $html .= '指'; }
            if($data['matches'][$i1]['faul2_2']==1){ $html .= '▲'; }
            $html .= '        </div>'."\n";
            $html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if($data['matches'][$i1]['waza1_'.$i2]==5){
                    $html .= '          <div class="tb_frame_waza2">';
                } else {
                    $html .= '          <div class="tb_frame_waza1">';
                }
                if($data['matches'][$i1]['waza2_'.$i2]==0){ $html .= '&nbsp;'; }
                if($data['matches'][$i1]['waza2_'.$i2]==1){ $html .= 'メ'; }
                if($data['matches'][$i1]['waza2_'.$i2]==2){ $html .= 'ド'; }
                if($data['matches'][$i1]['waza2_'.$i2]==3){ $html .= 'コ'; }
                if($data['matches'][$i1]['waza2_'.$i2]==4){ $html .= '反'; }
                if($data['matches'][$i1]['waza2_'.$i2]==5){ $html .= '○'; }
                if($data['matches'][$i1]['waza2_'.$i2]==6){ $html .= 'ツ'; }
                if($data['matches'][$i1]['waza2_'.$i2]==7){ $html .= '判'; }
                $html .= '</div>'."\n";
            }
            $html .= '        </div>'."\n";
            $html .= '        <div class="tb_frame_content';
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player2'] != 0 ){
                if(
                    ( $series_info['score_hoin_mode'] == 1 && $data['matches'][$i1]['player2'] != $i1 )
                    || ( $series_info['score_hoin_mode'] == 2 && $data['matches'][$i1]['player2'] >= 6 )
                ){
                    $html .= ' tb_frame_hoin_player';
                }
            }
            if( $match_info['series_lt'] != 'kt' ){
                $name_html = output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 2, $i1 );
                $name_html_len = mb_strlen( $name_html,'UTF-8' );
                if( $name_html_len != 8 && $name_html_len != 15 && $name_html_len != 1 && $name_html_len != 50 ){
                    $html .=   ' tb_frame_content2_smallfont7';
                }
            }

            $html .= '" id="player2_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
                $html .= $name_html; //output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 2, $i1 );
                //$html .= mb_strlen( $name_html,'UTF-8' );
/*
                if( $data['matches'][$i1]['player2'] == 0 ){
                    $html .= '&nbsp;';
                } if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
                    $html .= string_insert_br( $data['matches'][$i1]['player2_change_name'] );
                } else {
                    if( $match_info['series_mw'] === '' ){
                        $f = 'player'.$data['matches'][$i1]['player2'];
                        $f2 = 'player';
                    } else {
                        if( $series_info['player_field_mode'] == 3 ){
                            $f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player2'];
                            $f2 = 'dantai_'.$match_info['series_mw'];
                        } else {
                            //$f = 'player'.$data['matches'][$i1]['player2'].'_'.$match_info['series_mw'];
                            //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player2'];
                            $f = 'player'.$data['matches'][$i1]['player2'];
                            $f2 = 'player';
                        }
                    }
                    if( $data['entry2'][$f.'_disp'] != '' ){
                        $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                    } else {
                        $name = $data['entry2'][$f.'_sei'];
                        $html .= string_insert_br( $name );
                        for( $fi = 1; $fi <= 7; $fi++ ){
                            $name2 = $data['entry2'][$f2.$fi.'_sei'];
                            if( $fi != $data['matches'][$i1]['player2'] && $name2 != '' && $name == $name2 ){
                                $add1 = mb_substr( $data['entry2'][$f.'_mei'], 0, 1 );
                                $add2 = mb_substr( $data['entry2'][$f2.$fi.'_mei'], 0, 1 );
                                if( $add1 == $add2 ){
                                    $add1 = mb_substr( $data['entry2'][$f.'_mei'], 1, 1 );
                                }
                                $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                                break;
                            }
                        }
                    }
                }
*/
                //if( $hon1[$i1] == 0 && $hon2[$i1] == 1 ){
                //    echo '<div class="tb_frame_ippon">一本勝</div>';
                //}
            } else {
                if( $i1 == 1 ){
                    $html .= string_insert_br( $data_prev['players'][2]['name_str2'] );
                } else if( $i1 == 2 ){
                } else if( $i1 == 3 ){
                    $html .= string_insert_br( $data_now['players'][2]['name_str2'] );
                } else if( $i1 == 4 ){
                } else if( $i1 == 5 ){
                    $html .= string_insert_br( $data_next['players'][2]['name_str2'] );
                }
            }
            if( $data['matches'][$i1]['supporter2'] == 1 ){
                $html .= '<div class="tb_frame_supporter2">●</div>';
            }
            $html .= '</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_result_content">'."\n";
        if( $match_info['series_lt'] != 'kt' ){
            if( $winner == 0 ){ // || $data['exist_match6'] == 1 ){
                $html .= '          <span class="result-square"></span>'."\n";
            } else if( $winner == 2 ){
                $html .= '          <span class="result-circle"></span>'."\n";
            } else if( $winner == 1 ){
                $html .= '          <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            }
            $html .= '          <div class="tb_frame_result_hon">'.$hon2sum.'</div>'."\n";
            $html .= '          <div class="tb_frame_result_win">'.$win2sum.'</div>'."\n";

            if( $data['exist_match6'] == 1 && $winner == 2 ){
                $html .= '          <div class="tb_frame_result_win_dai">代</div>'."\n";
            }
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";

        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_faul">';
        if( $match_info['series_lt'] != 'kt' ){
            if($data['matches'][6]['faul2_1']==2){ $html .= '指'; }
            if($data['matches'][6]['faul2_2']==1){ $html .= '▲'; }
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            $html .= '          <div class="tb_frame_waza1">';
            if( $match_info['series_lt'] != 'kt' ){
                if($data['matches'][6]['waza2_'.$i2]==0){ $html .= '&nbsp;'; }
                if($data['matches'][6]['waza2_'.$i2]==1){ $html .= 'メ'; }
                if($data['matches'][6]['waza2_'.$i2]==2){ $html .= 'ド'; }
                if($data['matches'][6]['waza2_'.$i2]==3){ $html .= 'コ'; }
                if($data['matches'][6]['waza2_'.$i2]==4){ $html .= '反'; }
                if($data['matches'][6]['waza2_'.$i2]==5){ $html .= '○'; }
                if($data['matches'][6]['waza2_'.$i2]==6){ $html .= 'ツ'; }
            }
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_content';
        if( $match_info['series_lt'] != 'kt' ){
            $name_html = output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 2, 6 );
            //if( mb_strlen( $name_html,'UTF-8' ) > 4 ){
            $name_html_len = mb_strlen( $name_html,'UTF-8' );
            if( $name_html_len != 8 && $name_html_len != 15 && $name_html_len != 1 && $name_html_len != 50 ){
                $html .=   ' tb_frame_content2_smallfont7';
            }
        }
        $html .= '" id="player2_6">';
        if( $match_info['series_lt'] != 'kt' ){
            $html .= $name_html; //output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 2, 6 );
/*
            if( $data['matches'][6]['player2'] == 0 ){
                $html .= '&nbsp;';
            } if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
                $html .= string_insert_br( $data['matches'][6]['player2_change_name'] );
            } else {
                if( $match_info['series_mw'] === '' ){
                    $f = 'player'.$data['matches'][6]['player2'];
                    $f2 = 'player';
                } else {
                    if( $series_info['player_field_mode'] == 3 ){
                        $f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player2'];
                        $f2 = 'dantai_'.$match_info['series_mw'];
                    } else {
                        //$f = 'player'.$data['matches'][6]['player2'].'_'.$match_info['series_mw'];
                        //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player2'];
                        $f = 'player'.$data['matches'][6]['player2'];
                        $f2 = 'player';
                    }
                }
                if( $data['entry2'][$f.'_disp'] != '' ){
                    $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                } else {
                    $name = $data['entry2'][$f.'_sei'];
                    $html .= string_insert_br( $name );
                    for( $fi = 1; $fi <= 7; $fi++ ){
                        $name2 = $data['entry2'][$f2.$fi.'_sei'];
                        if( $fi != $data['matches'][6]['player2'] && $name2 != '' && $name == $name2 ){
                            $add1 = mb_substr( $data['entry2'][$f.'_mei'], 0, 1 );
                            $add2 = mb_substr( $data['entry2'][$f2.$fi.'_mei'], 0, 1 );
                            if( $add1 == $add2 ){
                                $add1 = mb_substr( $data['entry2'][$f.'_mei'], 1, 1 );
                            }
                            $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                            break;
                        }
                    }
                }
            }
*/
        }
        if( $data['matches'][6]['supporter2'] == 1 ){
            $html .= '<div class="tb_frame_supporter2">●</div>';
        }
        $html .= '</div>'."\n";
        $html .= '      </div>'."\n";
        if( $series_info['enable_referee'] != 0 ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '          <div class="tb_frame_title tb_frame_bbottom">副審</div>'."\n";
            $html .= '          <div class="tb_frame_referee2">'.string_insert_br( $data['referee2_name'] ).'</div>'."\n";
            $html .= '          <div class="tb_frame_referee2">'.string_insert_br( $data['referee3_name'] ).'</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

    function __output_realtime_html_for_one_board_sub2( $navi_id, $place, $place_match_no, $objPage, $match_info, $match, $series_info )
    {
        $display_face = false;

        $objTournament = new form_page_kojin_tournament( $objPage );
        $data_now = $objTournament->get_kojin_tournament_one_result(
            $match_info['series'], $match_info['series_mw'], $match
        );
        $hon1 = 0;
        $hon2 = 0;
        for( $waza = 1; $waza <= 3; $waza++ ){
            if( $data_now['matches']['waza1_'.$waza] != 0 ){
                $hon1++;
            }
            if( $data_now['matches']['waza2_'.$waza] != 0 ){
                $hon2++;
            }
        }
//print_r($data_now);
        $pref_tbl = $objPage->get_pref_array();
        $html = '    <div align="center" id="result2" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        //$html .= '      <div class="tb_score_title">第'.$match_info['place_match_no_disp'].'試合</div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            //$html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][1]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        } else {
            $html .= '          <div class="name1">'.$data_now['players'][1]['name_str2']."</div>\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_red"></div>'."\n";
        $html .= '        <div class="pref1">('.$data_now['players'][1]['belonging_to_name_str'].')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name" id="player1">';
        if( $display_face ){
            $html .= string_insert_br( $data_now['players'][1]['name_str2'] );
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name2" id="player2">';
        if( $display_face ){
            $html .= string_insert_br( $data_now['players'][2]['name_str2'] );
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            //$html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][2]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        } else {
            $html .= '          <div class="name2">'.$data_now['players'][2]['name_str2']."</div>\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_white"></div>'."\n";
        $html .= '        <div class="pref2">('.$data_now['players'][2]['belonging_to_name_str'].')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data_now['matches']['waza1_'.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza1">';
            }
            if( $data_now['matches']['waza1_'.$i2] == 0 ){ $html .=   '&nbsp;'; }
            if( $data_now['matches']['waza1_'.$i2] == 1 ){ $html .=   'メ'; }
            if( $data_now['matches']['waza1_'.$i2] == 2 ){ $html .=   'ド'; }
            if( $data_now['matches']['waza1_'.$i2] == 3 ){ $html .=   'コ'; }
            if( $data_now['matches']['waza1_'.$i2] == 4 ){ $html .=   '反'; }
            if( $data_now['matches']['waza1_'.$i2] == 5 ){ $html .=   '○'; }
            if( $data_now['matches']['waza1_'.$i2] == 6 ){ $html .=   'ツ'; }
            if( $data_now['matches']['waza1_'.$i2] == 7 ){ $html .=   '判'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data_now['matches']['faul1_1'] == 2 ){ $html .=   '指'; }
        if( $data_now['matches']['faul1_2'] == 1 ){ $html .=   '▲'; }
        if( $data_now['matches']['extra'] == 1 ){
            $html .=   '          <div class="tb_frame_faul_extra" id="extra_match">延長</div>'."\n";
        }
        if( $data_now['matches']['end_match'] == 1 ){
            $fusen = false;
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if( $data_now['matches']['waza1_'.$i2] == 5 || $data_now['matches']['waza2_'.$i2] == 5 ){
                    $fusen = true;
                    break;
                }
            }
            if( !$fusen ){
                if( ( $hon1 == 1 && $hon2 == 0 ) || ( $hon1 == 0 && $hon2 == 1 ) ){
                    if( $data_now['matches']['extra'] == 0 ){
                        $html .=   '<div class="tb_frame_ippon">一本勝</div>';
                    }
                } else if( $hon1 == $hon2 ){
                    $html .=   '<div class="tb_frame_draw">×</div>';
                }
            }
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data_now['matches']['faul2_1'] == 2 ){ $html .=   '指'; }
        if( $data_now['matches']['faul2_2'] == 1 ){ $html .=   '▲'; }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data_now['matches']['waza2_'.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza2">';
            }
            if($data_now['matches']['waza2_'.$i2]==0){ $html .=   '&nbsp;'; }
            if($data_now['matches']['waza2_'.$i2]==1){ $html .=   'メ'; }
            if($data_now['matches']['waza2_'.$i2]==2){ $html .=   'ド'; }
            if($data_now['matches']['waza2_'.$i2]==3){ $html .=   'コ'; }
            if($data_now['matches']['waza2_'.$i2]==6){ $html .=   'ツ'; }
            if($data_now['matches']['waza2_'.$i2]==4){ $html .=   '反'; }
            if($data_now['matches']['waza2_'.$i2]==5){ $html .=   '○'; }
            if($data_now['matches']['waza2_'.$i2]==7){ $html .=   '判'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";

        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

    function __output_realtime_html_for_one_board_sub3( $navi_id, $place, $place_match_no, $match_no, $objPage, $match_info, $match, $series_info )
    {
        $display_face = false;
        $objMatch = new form_page_dantai_match( $objPage );
        if( $match_info['series_lt'] == 'dl' ){
            $data = $objPage->get_dantai_league_one_result( $match );
        } else {
            $data = $objPage->get_dantai_tournament_one_result( $match );
        }
        $hon1 = 0;
        $hon2 = 0;
        for( $waza = 1; $waza <= 3; $waza++ ){
            if( $data['matches'][$match_no]['waza1_'.$waza] != 0 ){
                $hon1++;
            }
            if( $data['matches'][$match_no]['waza2_'.$waza] != 0 ){
                $hon2++;
            }
        }

        $html = '    <div align="center" id="result2" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        $html .= '      <div class="tb_score_title">第'.$match_info['match_name'].'試合</div>'."\n";
        $html .= '      <div class="tb_score_title">';
        if( $match_no == 1 ){ $html .= '先鋒'; }
        if( $match_no == 2 ){ $html .= '次鋒'; }
        if( $match_no == 3 ){ $html .= '中堅'; }
        if( $match_no == 4 ){ $html .= '副将'; }
        if( $match_no == 5 ){ $html .= '大将'; }
        if( $match_no == 6 ){ $html .= '代表戦'; }
        $html .= '</div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            //$html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][1]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        } else {
            $r = $objMatch->get_dantai_entry_name( $series_info, $match_info['series_mw'], 1, $data['entry1'], $data['matches'][$match_no] );
            $html .= '          <div class="name1">'.$r['disp'];
            if( $r['disp_add'] != '' ){
                $html .= ( '(' . $r['disp_add'] . ')' );
            }
            $html .= "</div>\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_red"></div>'."\n";
        $html .= '        <div class="pref1">('.$data['entry1']['school_name_ryaku'].')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name" id="player1">';
        if( $display_face ){
            $html .= string_insert_br( $data['players'][1]['name_str2'] );
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name2" id="player2">';
        if( $display_face ){
            $html .= string_insert_br( $data['players'][2]['name_str2'] );
        }
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            //$html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][2]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        } else {
            $r = $objMatch->get_dantai_entry_name( $series_info, $match_info['series_mw'], 2, $data['entry2'], $data['matches'][$match_no] );
            $html .= '          <div class="name2">'.$r['disp'];
            if( $r['disp_add'] != '' ){
                $html .= ( '(' . $r['disp_add'] . ')' );
            }
            $html .= "</div>\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_white"></div>'."\n";
        $html .= '        <div class="pref2">('.$data['entry2']['school_name_ryaku'].')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data['matches'][$match_no]['waza1_'.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza1">';
            }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 0 ){ $html .=   '&nbsp;'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 1 ){ $html .=   'メ'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 2 ){ $html .=   'ド'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 3 ){ $html .=   'コ'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 4 ){ $html .=   '反'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 5 ){ $html .=   '○'; }
            if( $data['matches'][$match_no]['waza1_'.$i2] == 6 ){ $html .=   'ツ'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data['matches'][$match_no]['faul1_1'] == 2 ){ $html .=   '指'; }
        if( $data['matches'][$match_no]['faul1_2'] == 1 ){ $html .=   '▲'; }
        if( $data['matches'][$match_no]['extra'] == 1 ){
            $html .=   '          <div class="tb_frame_faul_extra" id="extra_match">延長</div>'."\n";
        }
        if( $data['matches'][$match_no]['end_match'] == 1 ){
            $fusen = false;
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if( $data['matches'][$match_no]['waza1_'.$i2] == 5 || $data['matches'][$match_no]['waza2_'.$i2] == 5 ){
                    $fusen = true;
                    break;
                }
            }
            if( !$fusen ){
                if( ( $hon1 == 1 && $hon2 == 0 ) || ( $hon1 == 0 && $hon2 == 1 ) ){
                    if( $data['matches'][$match_no]['extra'] == 0 ){
                        $html .=   '<div class="tb_frame_ippon">一本勝</div>';
                    }
                } else if( $hon1 == $hon2 ){
                    $html .=   '<div class="tb_frame_draw">×</div>';
                }
            }
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data['matches'][$match_no]['faul2_1'] == 2 ){ $html .=   '指'; }
        if( $data['matches'][$match_no]['faul2_2'] == 1 ){ $html .=   '▲'; }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data['matches'][$match_no]['waza2_'.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza2">';
            }
            if($data['matches'][$match_no]['waza2_'.$i2]==0){ $html .=   '&nbsp;'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==1){ $html .=   'メ'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==2){ $html .=   'ド'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==3){ $html .=   'コ'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==6){ $html .=   'ツ'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==4){ $html .=   '反'; }
            if($data['matches'][$match_no]['waza2_'.$i2]==5){ $html .=   '○'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";

        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

    function __output_realtime_html_for_one_board_sub4( $navi_id, $place, $place_match_no, $match_no, $objPage, $match_info, $match, $series_info )
    {
        if( $match_info['series_lt'] == 'dl' ){
            $data = $objPage->get_dantai_league_one_result( $match );
        } else {
            $data = $objPage->get_dantai_tournament_one_result( $match );
        }
//print_r($data);
        $hon1 = 0;
        $hon2 = 0;
        for( $waza = 1; $waza <= 3; $waza++ ){
            if( $data['matches'][$match_no]['waza1_'.$waza] != 0 ){
                $hon1++;
            }
            if( $data['matches'][$match_no]['waza2_'.$waza] != 0 ){
                $hon2++;
            }
        }

        $fontlen = mb_strlen( get_field_string($data['entry1'],'school_name_ryaku'),'UTF-8' );
        $fontlen2 = mb_strlen( get_field_string($data['entry2'],'school_name_ryaku'),'UTF-8' );
        if( $fontlen < $fontlen2 ){
            $fontlen = $fontlen2;
        }
        $html = '    <div align="center" id="result1" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['match_name'].'</div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_title tb_frame_bbottom">チーム名</div>'."\n";
        if( $fontlen >= 15 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont15" id="school_name1">'."\n";
        } else if( $fontlen > 5 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont'.$fontlen.'" id="school_name1">'."\n";
        } else {
            $html .= '        <div class="tb_frame_content2" id="school_name1">'."\n";
        }
        $html .= '          '.get_field_string_insert_br($data['entry1'],'school_name_ryaku')."\n";
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        for( $i1 = 1; $i1 <= 5; $i1++ ){
            $html .=  '      <div class="tb_frame">'."\n";
            $html .=  '        <div class="tb_frame_title tb_frame_bbottom">&nbsp;</div>'."\n";
            $html .=  '        <div class="tb_frame_content" id="player1_'.$i1.'">';
            if( $i1 == 3 ){
                $html .= output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 1, 1 );
            }
            $html .=   '</div>'."\n";
            $html .=   '        <div class="tb_frame_waza tb_frame_btop">'."\n";
            if( $i1 == 3 ){
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if( $data['matches'][1]['waza1_'.$i2] == 5 ){
                        $html .=   '          <div class="tb_frame_waza2">';
                    } else {
                        $html .=   '          <div class="tb_frame_waza1">';
                    }
                    if($data['matches'][1]['waza1_'.$i2]==0){ $html .=   '&nbsp;'; }
                    if($data['matches'][1]['waza1_'.$i2]==1){ $html .=   'メ'; }
                    if($data['matches'][1]['waza1_'.$i2]==2){ $html .=   'ド'; }
                    if($data['matches'][1]['waza1_'.$i2]==3){ $html .=   'コ'; }
                    if($data['matches'][1]['waza1_'.$i2]==4){ $html .=   '反'; }
                    if($data['matches'][1]['waza1_'.$i2]==5){ $html .=   '○'; }
                    if($data['matches'][1]['waza1_'.$i2]==6){ $html .=   'ツ'; }
                    $html .=   '</div>'."\n";
                }
            }
            $html .=   '        </div>'."\n";
            $html .=   '        <div class="tb_frame_faul">'."\n";
            if( $i1 == 3 ){
                if( $data['matches'][1]['faul1_1'] == 2 ){ $html .=   '指'; }
                if( $data['matches'][1]['faul1_2'] == 1 ){ $html .=   '▲'; }
                if( $data['matches'][1]['extra'] == 1 ){
                    $html .=   '          <div class="tb_frame_faul_extra" id="extra_match'.$i1.'">延長</div>'."\n";
                }
            }
            $html .=   '        </div>'."\n";
            $html .=   '      </div>'."\n";
        }
        $html .= '        <div class="tb_frame">'."\n";
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        $html .= '</div>'."\n";
        $html .= '          <div class="tb_frame_result_content">'."\n";
        $html .= '          </div>'."\n";
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame">'."\n";
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_content">';
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_waza tb_frame_btop">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            $html .= '          <div class="tb_frame_waza1">';
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_faul">'."\n";
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        if( $series_info['enable_referee'] != 0 ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '          <div class="tb_frame_title tb_frame_bbottom">主審</div>'."\n";
            $html .= '          <div class="tb_frame_referee">'.string_insert_br( $data['referee1_name'] ).'</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '            <div class="tb_frame">'."\n";
        if( $fontlen >= 15 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont15" id="school_name2">'."\n";
        } else if( $fontlen > 5 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont'.$fontlen.'" id="school_name2">'."\n";
        } else {
            $html .= '        <div class="tb_frame_content2" id="school_name2">'."\n";
        }
        $html .= get_field_string_insert_br($data['entry2'],'school_name_ryaku');
        $html .= '              </div>'."\n";
        $html .= '            </div>'."\n";
        for( $i1 = 1; $i1 <= 5; $i1++ ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '        <div class="tb_frame_faul">';
            if( $i1 == 3 ){
                if($data['matches'][1]['faul2_1']==2){ $html .= '指'; }
                if($data['matches'][1]['faul2_2']==1){ $html .= '▲'; }
            }
            $html .= '        </div>'."\n";
            $html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
            if( $i1 == 3 ){
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if($data['matches'][1]['waza1_'.$i2] == 5 ){
                        $html .= '          <div class="tb_frame_waza2">';
                    } else {
                        $html .= '          <div class="tb_frame_waza1">';
                    }
                    if($data['matches'][1]['waza2_'.$i2]==0){ $html .= '&nbsp;'; }
                    if($data['matches'][1]['waza2_'.$i2]==1){ $html .= 'メ'; }
                    if($data['matches'][1]['waza2_'.$i2]==2){ $html .= 'ド'; }
                    if($data['matches'][1]['waza2_'.$i2]==3){ $html .= 'コ'; }
                    if($data['matches'][1]['waza2_'.$i2]==4){ $html .= '反'; }
                    if($data['matches'][1]['waza2_'.$i2]==5){ $html .= '○'; }
                    if($data['matches'][1]['waza2_'.$i2]==6){ $html .= 'ツ'; }
                    $html .= '</div>'."\n";
                }
            }
            $html .= '        </div>'."\n";
            $html .= '        <div class="tb_frame_content';
            $html .= '" id="player2_'.$i1.'">';
            if( $i1 == 3 ){
                $html .= output_realtime_html_for_one_board_get_dantai_player_name( $data, $series_info, $match_info, 2, 1 );
            }
            $html .= '</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_result_content">'."\n";
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";

        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_faul">';
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_content" id="player2_'.$i1.'">';
        $html .= '</div>'."\n";
        $html .= '      </div>'."\n";
        if( $series_info['enable_referee'] != 0 ){
            $html .= '      <div class="tb_frame">'."\n";
            $html .= '          <div class="tb_frame_title tb_frame_bbottom">副審</div>'."\n";
            $html .= '          <div class="tb_frame_referee2">'.string_insert_br( $data['referee2_name'] ).'</div>'."\n";
            $html .= '          <div class="tb_frame_referee2">'.string_insert_br( $data['referee3_name'] ).'</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

    function output_realtime_html_for_one_board( $navi_id, $place, $place_match_no, $place_match_player_no )
    {
        //global $__current_input_match_no__, $navi_info;

        $objPage = new form_page();

//print_r($_SESSION);
//echo $place_match_no, $place_match_player_no;
//print_r($match_info);

//print_r($data['matches']);
//    $series_mw = $data['series_mw'];
//print_r($place_match_no);
//print_r($match);
//print_r($data);
        $match_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
//print_r($match_info);
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        //$match_info = $navi_info[$place][$place_match_no];
        //$match = $navi_info[$place][$place_match_no]['match'];
        $series_info = $objPage->get_series_list( $match_info['series'] );
        if( $match_info['series_lt'] == 'dl' || $match_info['series_lt'] == 'dt' || $series_info['realtime_kojin'] == 0 ){
            $html = __output_realtime_html_for_one_board_sub( $navi_id, $place, $place_match_no, $place_match_player_no, $objPage, $match_info, $match, $series_info );
        } else {
            $html = __output_realtime_html_for_one_board_sub2( $navi_id, $place, $place_match_no, $objPage, $match_info, $match, $series_info );
        }
        return $html;
    }

    function output_realtime_html_for_one_board2( $navi_id, $place, $place_match_no, $match_no )
    {
        $objPage = new form_page();
        $match_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        $series_info = $objPage->get_series_list( $match_info['series'] );
        if( $match_info['series_lt'] == 'dl' || $match_info['series_lt'] == 'dt' || $series_info['realtime_kojin'] == 0 ){
            $html = __output_realtime_html_for_one_board_sub4( $navi_id, $place, $place_match_no, $match_no, $objPage, $match_info, $match, $series_info );
        } else {
            $html = __output_realtime_html_for_one_board_sub2( $navi_id, $place, $place_match_no, $objPage, $match_info, $match, $series_info );
        }
        return $html;
    }

    function output_realtime_html_for_one_board_11(
        $navi_id, $place, $place_match_no, $enable_referee, $reverse=0
    ){
        $display_face = true;
        if( $reverse == 1 ){
            $member_left = 2;
            $side_left = 'tb_frame_side_white';
            $waza_field_left = 'waza2_';
            $faul_field_left = 'faul2_';
            $member_right = 1;
            $side_right = 'tb_frame_side_red';
            $waza_field_right = 'waza1_';
            $faul_field_right = 'faul1_';
        } else {
            $member_left = 1;
            $side_left = 'tb_frame_side_red';
            $waza_field_left = 'waza1_';
            $faul_field_left = 'faul1_';
            $member_right = 2;
            $side_right = 'tb_frame_side_white';
            $waza_field_right = 'waza2_';
            $faul_field_right = 'faul2_';
        }
        //global $__current_input_match_no__, $navi_info;

        $objPage = new form_page();

//print_r($_SESSION);
//echo $match;
//print_r($match_info);

//print_r($data['matches']);
//    $series_mw = $data['series_mw'];
//print_r($place_match_no);
//print_r($match);
//print_r($data);
        $match_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
//print_r($match_info);
        $series_info = $objPage->get_series_list( $match_info['series'] );
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        $data_now = $objPage->get_kojin_tournament_one_result(
            $match_info['series'], $match_info['series_mw'], $match
        );
        $hon1 = 0;
        $hon2 = 0;
        for( $waza = 1; $waza <= 3; $waza++ ){
            if( $data_now['matches']['waza1_'.$waza] != 0 ){
                $hon1++;
            }
            if( $data_now['matches']['waza2_'.$waza] != 0 ){
                $hon2++;
            }
        }
//print_r($data_now);
        $pref_tbl = $objPage->get_pref_array();
        $html = '    <div align="center" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        //$html .= '      <div class="tb_score_title">第'.$match_info['place_match_no_disp'].'試合</div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            $html .= '          <img class="photo" src="/alljapan/result/2021/upload/'.$data_now['players'][$member_left]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="' . $side_left . '"></div>'."\n";
        $html .= '        <div class="pref">('.$objPage->get_pref_name( $pref_tbl, $data_now['players'][$member_left]['entry']['kojin_address_pref'] ).')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name" id="player1">';
        $html .= string_insert_br( $data_now['players'][$member_left]['name_str2'] );
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name2" id="player2">';
        $html .= string_insert_br( $data_now['players'][$member_right]['name_str2'] );
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            $html .= '          <img class="photo" src="/alljapan/result/2021/upload/'.$data_now['players'][$member_right]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="' . $side_right . '"></div>'."\n";
        $html .= '        <div class="pref">('.$objPage->get_pref_name( $pref_tbl, $data_now['players'][$member_right]['entry']['kojin_address_pref'] ).')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data_now['matches'][$waza_field_left.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza1">';
            }
            if( $data_now['matches'][$waza_field_left.$i2] == 0 ){ $html .=   '&nbsp;'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 1 ){ $html .=   'メ'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 2 ){ $html .=   'ド'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 3 ){ $html .=   'コ'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 4 ){ $html .=   '反'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 5 ){ $html .=   '○'; }
            if( $data_now['matches'][$waza_field_left.$i2] == 6 ){ $html .=   'ツ'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data_now['matches'][$faul_field_left.'1'] == 2 ){ $html .=   '指'; }
        if( $data_now['matches'][$faul_field_left.'2'] == 1 ){ $html .=   '<span class="text-red">▲</span>'; }
        if( $data_now['matches']['extra'] == 1 ){
            $html .=   '          <div class="tb_frame_faul_extra" id="extra_match">延長</div>'."\n";
        }
        if( $data_now['matches']['end_match'] == 1 ){
            $fusen = false;
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if( $data_now['matches']['waza1_'.$i2] == 5 || $data_now['matches']['waza2_'.$i2] == 5 ){
                    $fusen = true;
                    break;
                }
            }
            if( !$fusen ){
                if( ( $hon1 == 1 && $hon2 == 0 ) || ( $hon1 == 0 && $hon2 == 1 ) ){
                    if( $data_now['matches']['extra'] == 0 ){
                        $html .=   '<div class="tb_frame_ippon">一本勝</div>';
                    }
                } else if( $hon1 == $hon2 ){
                    //$html .=   '<div class="tb_frame_draw">×</div>';
                }
            }
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_faul">'."\n";
        if( $data_now['matches'][$faul_field_right.'1'] == 2 ){ $html .=   '指'; }
        if( $data_now['matches'][$faul_field_right.'2'] == 1 ){ $html .=   '<span class="text-red">▲</span>'; }
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_waza">'."\n";
        for( $i2 = 1; $i2 <= 3; $i2++ ){
            if( $data_now['matches'][$waza_field_right.$i2] == 0 ){
                $html .=   '          <div class="waza0">';
            } else {
                $html .=   '          <div class="waza2">';
            }
            if($data_now['matches'][$waza_field_right.$i2]==0){ $html .=   '&nbsp;'; }
            if($data_now['matches'][$waza_field_right.$i2]==1){ $html .=   'メ'; }
            if($data_now['matches'][$waza_field_right.$i2]==2){ $html .=   'ド'; }
            if($data_now['matches'][$waza_field_right.$i2]==3){ $html .=   'コ'; }
            if($data_now['matches'][$waza_field_right.$i2]==6){ $html .=   'ツ'; }
            if($data_now['matches'][$waza_field_right.$i2]==4){ $html .=   '反'; }
            if($data_now['matches'][$waza_field_right.$i2]==5){ $html .=   '○'; }
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '    </div>'."\n";
        if( $series_info['enable_referee'] != 0 ){
            $html .= '      <div class="tb_frame_referee">'."\n";
            $html .= '        <div class="tb_frame_referee_title">'."主審".'</div>'."\n";
            $html .= '        <div class="tb_frame_referee_name">'.string_insert_br($data_now['referee1_name']).'</div>'."\n";
            $html .= '      </div>'."\n";
            $html .= '      <div class="tb_frame_referee2">'."\n";
            $html .= '        <div class="tb_frame_referee_title">'."副審".'</div>'."\n";
            $html .= '        <div class="tb_frame_referee_name2">'.string_insert_br($data_now['referee2_name']).'</div>'."\n";
            $html .= '        <div class="tb_frame_referee_name2">'.string_insert_br($data_now['referee3_name']).'</div>'."\n";
            $html .= '      </div>'."\n";
            $html .= '      <div class="clearfloat"></div>'."\n";
        }
//        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

