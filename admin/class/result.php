<?php

/*
	function __output_league_20_21_for_HTML( $path, $league_param, $league_list, $entry_list, $mv )
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
		$header .= '<link href="../preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
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
		$html .= $header . '    <h2>' . $mvstr . '団体リーグ表</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
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
						$html .= $ev['school_name'];
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
						$html .= $ev['school_name'];
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

				if( $league_list[$league_data]['end_match'] == $league_list[$league_data]['match_num'] ){
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
		$html .= $footer;
		$file = $path . '/dl'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}
*/

	function output_realtime_html_for_one_board( $navi_id, $place, $place_match_no )
	{
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
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        //$match_info = $navi_info[$place][$place_match_no];
        //$match = $navi_info[$place][$place_match_no]['match'];
        $series_info = $objPage->get_series_list( $match_info['series'] );
        if( $match_info['series_lt'] == 'dl' || $match_info['series_lt'] == 'dt' ){
            if( $match_info['series_lt'] == 'dl' ){
                $data = $objPage->get_dantai_league_one_result( $match );
            } else {
                $data = $objPage->get_dantai_tournament_one_result( $match );
            }
print_r($data);
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
                            $match_end = 1;
                        }
                    }
                }
            }
        } else {
            $hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
            $data_prev = array();
            if( $place_match_no > 1 ){
                $match_info2 = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no-1 );
                if( $match_info2['series_lt'] == 'kt' ){
                    $data_prev = $objPage->get_kojin_tournament_one_result(
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
            $data_now = $objPage->get_kojin_tournament_one_result(
                $match_info['series'], $match_info['series_mw'], $match
            );
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
            $match_info2 = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no+1 );
            if( count( $match_info2 ) > 0 && $match_info2['series_lt'] == 'kt' ){
                $data_next = $objPage->get_kojin_tournament_one_result(
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
        $html = '    <div align="center" class="tb_score_in">'."\n";
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
            $html .=  '      <div class="tb_frame">'."\n";
            $html .=  '        <div class="tb_frame_title tb_frame_bbottom">';
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
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player1'] != 0 && $data['matches'][$i1]['player1'] != $i1 ){
                $html .=   ' tb_frame_hoin_player';
            }
            $html .=   '" id="player1_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
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
                           $f = 'player'.$data['matches'][$i1]['player1'].'_'.$match_info['series_mw'];
                        //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                           //$f = 'player'.$data['matches'][$i1]['player1'];
                           $f2 = 'player';
                        }
                    }
                    if( $data['entry1'][$f.'_disp'] != '' ){
                        $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
                    } else {
                        $name = $data['entry1'][$f.'_sei'];
                        $html .= string_insert_br( $name );
                        for( $fi = 1; $fi <= 7; $fi++ ){
                            $name2 = $data['entry1'][$f2.$fi.'_'.$match_info['series_mw'].'_sei'];
                            if( $fi != $data['matches'][$i1]['player1'] && $name2 != '' && $name == $name2 ){
                                $add1 = mb_substr( $data['entry1'][$f.'_mei'], 0, 1 );
                                $add2 = mb_substr( $data['entry1'][$f2.$fi.'_'.$match_info['series_mw'].'_mei'], 0, 1 );
                                if( $add1 == $add2 ){
                                    $add1 = mb_substr( $data['entry1'][$f.'_mei'], 1, 1 );
                                }
                                $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                                break;
                            }
                        }
                    }
                }
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
                if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .=   '&nbsp;'; }
                if($data['matches'][$i1]['waza1_'.$i2]==1){ $html .=   'メ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==2){ $html .=   'ド'; }
                if($data['matches'][$i1]['waza1_'.$i2]==3){ $html .=   'コ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==4){ $html .=   '反'; }
                if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .=   '○'; }
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
            if( $winner == 1 ){
                $html .= '            <span class="result-circle"></span>'."\n";
            } else if( $winner == 2 ){
                $html .= '            <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            } else if( $winner == 0 ){
                $html .= '           <span class="result-square"></span>'."\n";
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
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        if( $match_info['series_lt'] != 'kt' ){ $html .= '代表戦'; }
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_content">';
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
                    $f = 'player'.$data['matches'][6]['player1'].'_'.$match_info['series_mw'];
                    //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player1'];
                    //$f = 'player'.$data['matches'][6]['player1'];
                    $f2 = 'player';
                }
            }
            if( $data['entry1'][$f.'_disp'] != '' ){
                $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
            } else {
                $name = $data['entry1'][$f.'_sei'];
                $html .= string_insert_br( $name );
                for( $fi = 1; $fi <= 7; $fi++ ){
                    $name2 = $data['entry1'][$f2.$fi.'_'.$match_info['series_mw'].'_sei'];
                    if( $fi != $data['matches'][6]['player1'] && $name2 != '' && $name == $name2 ){
                        $add1 = mb_substr( $data['entry1'][$f.'_mei'], 0, 1 );
                        $add2 = mb_substr( $data['entry1'][$f2.$fi.'_'.$match_info['series_mw'].'_mei'], 0, 1 );
                        if( $add1 == $add2 ){
                            $add1 = mb_substr( $data['entry1'][$f.'_mei'], 1, 1 );
                        }
                        $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                        break;
                    }
                }
            }
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
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_faul">'."\n";
        if($data['matches'][6]['faul1_1']==2){ $html .= '指'; }
        if($data['matches'][6]['faul1_2']==1){ $html .= '▲'; }
        if($data['matches'][$i1]['extra']==1){
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
                $html .= '</div>'."\n";
            }
            $html .= '        </div>'."\n";
            $html .= '        <div class="tb_frame_content';
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player2'] != 0 && $data['matches'][$i1]['player2'] != $i1 ){
                $html .= ' tb_frame_hoin_player';
            }
            $html .= '" id="player2_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
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
                            $f = 'player'.$data['matches'][$i1]['player2'].'_'.$match_info['series_mw'];
                            //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player2'];
                            //$f = 'player'.$data['matches'][$i1]['player2'];
                            $f2 = 'player';
                        }
                    }
                    if( $data['entry2'][$f.'_disp'] != '' ){
                        $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                    } else {
                        $name = $data['entry2'][$f.'_sei'];
                        $html .= string_insert_br( $name );
                        for( $fi = 1; $fi <= 7; $fi++ ){
                            $name2 = $data['entry2'][$f2.$fi.'_'.$match_info['series_mw'].'_sei'];
                            if( $fi != $data['matches'][$i1]['player2'] && $name2 != '' && $name == $name2 ){
                                $add1 = mb_substr( $data['entry2'][$f.'_mei'], 0, 1 );
                                $add2 = mb_substr( $data['entry2'][$f2.$fi.'_'.$match_info['series_mw'].'_mei'], 0, 1 );
                                if( $add1 == $add2 ){
                                    $add1 = mb_substr( $data['entry2'][$f.'_mei'], 1, 1 );
                                }
                                $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                                break;
                            }
                        }
                    }
                }
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
            $html .= '</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_result_content">'."\n";
        if( $match_info['series_lt'] != 'kt' ){
            if( $winner == 2 ){
                $html .= '          <span class="result-circle"></span>'."\n";
            } else if( $winner == 1 ){
                $html .= '          <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            } else if( $winner == 0 ){
                $html .= '          <span class="result-square"></span>'."\n";
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
            }
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_content" id="player2_'.$i1.'">';
        if( $match_info['series_lt'] != 'kt' ){
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
                        $f = 'player'.$data['matches'][6]['player2'].'_'.$match_info['series_mw'];
                        //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player2'];
                        //$f = 'player'.$data['matches'][6]['player2'];
                        $f2 = 'player';
                    }
                }
                if( $data['entry2'][$f.'_disp'] != '' ){
                    $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                } else {
                    $name = $data['entry2'][$f.'_sei'];
                    $html .= string_insert_br( $name );
                    for( $fi = 1; $fi <= 7; $fi++ ){
                        $name2 = $data['entry2'][$f2.$fi.'_'.$match_info['series_mw'].'_sei'];
                        if( $fi != $data['matches'][6]['player2'] && $name2 != '' && $name == $name2 ){
                            $add1 = mb_substr( $data['entry2'][$f.'_mei'], 0, 1 );
                            $add2 = mb_substr( $data['entry2'][$f2.$fi.'_'.$match_info['series_mw'].'_mei'], 0, 1 );
                            if( $add1 == $add2 ){
                                $add1 = mb_substr( $data['entry2'][$f.'_mei'], 1, 1 );
                            }
                            $html .= ( '<br /><p class="tb_frame_name_add">(' . $add1 . ')</p>' );
                            break;
                        }
                    }
                }
            }
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

	function output_realtime_html_for_one_board2( $navi_id, $place, $place_match_no )
	{
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
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        //$match_info = $navi_info[$place][$place_match_no];
        //$match = $navi_info[$place][$place_match_no]['match'];
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
                for( $i1 = 1; $i1 <= 2; $i1++ ){
                    $win1[$i1] = 0;
                    $win1str[$i1] = '';
                    $hon1[$i1] = 0;
                    $win2[$i1] = 0;
                    $win2str[$i1] = '';
                    $hon2[$i1] = 0;
                    $win[$i1] = 0;
                    if( $i1 == 2 ){
                        if( $endnum == 1 ){
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
                            $match_end = 1;
                        }
                    }
                    if( $i1 <= 1 ){
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
                }
            }
        } else {
            $hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
            $data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
            $data_prev = array();
            if( $place_match_no > 1 ){
                $match_info2 = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no-1 );
                if( $match_info2['series_lt'] == 'kt' ){
                    $data_prev = $objPage->get_kojin_tournament_one_result(
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
            $data_now = $objPage->get_kojin_tournament_one_result(
                $match_info['series'], $match_info['series_mw'], $match
            );
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
            $match_info2 = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no+1 );
            if( count( $match_info2 ) > 0 && $match_info2['series_lt'] == 'kt' ){
                $data_next = $objPage->get_kojin_tournament_one_result(
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
        $html = '    <div align="center" class="tb_score_in">'."\n";
        $html .= '      <div class="tb_score_title">'.$match_info['place_name'].'</div>'."\n";
        //$html .= '      <div class="tb_score_title">第'.$match_info['place_match_no_disp'].'試合</div>'."\n";
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
            $html .=  '      <div class="tb_frame">'."\n";
            $html .=  '        <div class="tb_frame_title tb_frame_bbottom">';
            if( $match_info['series_lt'] != 'kt' ){
                if( $i1 == 1 ){
                    $html .=  '';
                } else if( $i1 == 2 ){
                    $html .=  '';
                } else if( $i1 == 3 ){
                    $html .=  '代表';
                } else if( $i1 == 4 ){
                    $html .=  '';
                } else if( $i1 == 5 ){
                    $html .=  '';
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
            $html .=  '        </div>'."\n";
            $html .=  '        <div class="tb_frame_content';
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player1'] != 0 && $data['matches'][$i1]['player1'] != $i1 ){
                //$html .=   ' tb_frame_hoin_player';
            }
            $html .=   '" id="player1_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
                if( $i1 == 3 ){
                    if( $data['matches'][1]['player1'] == 0 ){
                        $html .=   '&nbsp;';
                    } if( $data['matches'][1]['player1'] == __PLAYER_NAME__ ){
                        $html .= string_insert_br( $data['matches'][1]['player1_change_name'] );
                    } else {
                        if( $match_info['series_mw'] === '' ){
                            $f = 'player'.$data['matches'][1]['player1'];
                        } else {
                            //$f = 'player'.$data['matches'][$i1]['player1'].'_'.$match_info['series_mw'];
                            //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                            $f = 'player'.$data['matches'][1]['player1'];
                        }
                        if( $data['entry1'][$f.'_disp'] != '' ){
                            $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
                        } else {
                            $html .= string_insert_br( $data['entry1'][$f.'_sei'] );
                        }
                    }
                }
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
            if( $i1 == 3 ){
                if( $data['matches'][1]['end_match'] == 1 ){
                    $fusen = false;
                    for( $i2 = 1; $i2 <= 3; $i2++ ){
                        if( $data['matches'][1]['waza1_'.$i2] == 5 || $data['matches'][1]['waza2_'.$i2] == 5 ){
                            $fusen = true;
                            break;
                        }
                    }
                    if( !$fusen ){
                        if( ( $hon1[1] == 1 && $hon2[1] == 0 ) || ( $hon1[1] == 0 && $hon2[1] == 1 ) ){
                            if( $data['matches'][1]['extra'] == 0 ){
                                //$html .=   '<div class="tb_frame_ippon">一本勝</div>';
                            }
                        } else if( $hon1[1] == $hon2[1] ){
                            $html .=   '<div class="tb_frame_draw">×</div>';
                        }
                    }
                }
            }
            $html .=   '</div>'."\n";
            if( $i1 == 3 ){
                $html .=   '        <div class="tb_frame_waza tb_frame_btop">'."\n";
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
                    $html .=   '</div>'."\n";
                }
                $html .=   '        </div>'."\n";
                $html .=   '        <div class="tb_frame_faul">'."\n";
                if( $data['matches'][1]['faul1_1'] == 2 ){ $html .=   '指'; }
                if( $data['matches'][1]['faul1_2'] == 1 ){ $html .=   '▲'; }
                if( $data['matches'][1]['extra'] == 1 ){
                    $html .=   '          <div class="tb_frame_faul_extra" id="extra_match'.$i1.'">延長</div>'."\n";
                }
                $html .=   '        </div>'."\n";
            }
            $html .=   '      </div>'."\n";
        }

        $html .= '        <div class="tb_frame">'."\n";
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        if( $match_info['series_lt'] != 'kt' ){ $html .= '結果'; }
        $html .= '</div>'."\n";
        $html .= '          <div class="tb_frame_result_content">'."\n";
        if( $match_info['series_lt'] != 'kt' ){
            if( $winner == 1 ){
                $html .= '            <span class="result-circle"></span>'."\n";
            } else if( $winner == 2 ){
                $html .= '            <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            } else if( $winner == 0 ){
                $html .= '           <span class="result-square"></span>'."\n";
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
        $html .= '          <div class="tb_frame_title tb_frame_bbottom">';
        if( $match_info['series_lt'] != 'kt' ){ $html .= ''; }
        $html .= '</div>'."\n";
        $html .= '        <div class="tb_frame_content">';
        if( $data['matches'][6]['player1'] == 0 ){
            $html .= '&nbsp;';
        } if( $data['matches'][6]['player1'] == __PLAYER_NAME__ ){
            $html .= string_insert_br( $data['matches'][6]['player1_change_name'] );
        } else {
            if( $match_info['series_mw'] === '' ){
                $f = 'player'.$data['matches'][6]['player1'];
            } else {
                //$f = 'player'.$data['matches'][6]['player1'].'_'.$match_info['series_mw'];
                //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player1'];
                $f = 'player'.$data['matches'][6]['player1'];
            }
            if( $data['entry1'][$f.'_disp'] != '' ){
                $html .= string_insert_br( $data['entry1'][$f.'_disp'] );
            } else {
                $html .= string_insert_br( $data['entry1'][$f.'_sei'] );
            }
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
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '      <div class="tb_frame">'."\n";
        if( $fontlen >= 15 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont15" id="school_name2">'."\n";
        } else if( $fontlen > 5 ){
            $html .= '        <div class="tb_frame_content2 tb_frame_content2_smallfont'.$fontlen.'" id="school_name2">'."\n";
        } else {
            $html .= '        <div class="tb_frame_content2" id="school_name2">'."\n";
        }
        $html .= get_field_string_insert_br($data['entry2'],'school_name_ryaku');
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        for( $i1 = 1; $i1 <= 5; $i1++ ){
            $html .= '      <div class="tb_frame">'."\n";
            if( $i1 == 3 ){
                $html .= '        <div class="tb_frame_faul">';
                if($data['matches'][1]['faul2_1']==2){ $html .= '指'; }
                if($data['matches'][1]['faul2_2']==1){ $html .= '▲'; }
                $html .= '        </div>'."\n";
                $html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if($data['matches'][1]['waza1_'.$i2]==5){
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
                    $html .= '</div>'."\n";
                }
                $html .= '        </div>'."\n";
            }
            $html .= '        <div class="tb_frame_content';
            if( $match_info['series_lt'] != 'kt' && $data['matches'][$i1]['player2'] != 0 && $data['matches'][$i1]['player2'] != $i1 ){
                //$html .= ' tb_frame_hoin_player';
            }
            $html .= '" id="player2_'.$i1.'">';
            if( $match_info['series_lt'] != 'kt' ){
                if( $i1 == 3 ){
                    if( $data['matches'][1]['player2'] == 0 ){
                        $html .= '&nbsp;';
                    } if( $data['matches'][1]['player2'] == __PLAYER_NAME__ ){
                        $html .= string_insert_br( $data['matches'][1]['player2_change_name'] );
                    } else {
                        if( $match_info['series_mw'] === '' ){
                            $f = 'player'.$data['matches'][1]['player2'];
                        } else {
                            //$f = 'player'.$data['matches'][$i1]['player2'].'_'.$match_info['series_mw'];
                            //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player2'];
                            $f = 'player'.$data['matches'][1]['player2'];
                        }
                        if( $data['entry2'][$f.'_disp'] != '' ){
                            $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                        } else {
                            $html .= string_insert_br( $data['entry2'][$f.'_sei'] );
                        }
                    }
                }
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
            $html .= '</div>'."\n";
            $html .= '      </div>'."\n";
        }
        $html .= '      <div class="tb_frame">'."\n";
        $html .= '        <div class="tb_frame_result_content">'."\n";
        if( $match_info['series_lt'] != 'kt' ){
            if( $winner == 2 ){
                $html .= '          <span class="result-circle"></span>'."\n";
            } else if( $winner == 1 ){
                $html .= '          <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
            } else if( $winner == 0 ){
                $html .= '          <span class="result-square"></span>'."\n";
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
            }
            $html .= '</div>'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_content" id="player2_'.$i1.'">';
        if( $match_info['series_lt'] != 'kt' ){
            if( $data['matches'][6]['player2'] == 0 ){
                $html .= '&nbsp;';
            } if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
                $html .= string_insert_br( $data['matches'][6]['player2_change_name'] );
            } else {
                if( $match_info['series_mw'] === '' ){
                    $f = 'player'.$data['matches'][6]['player2'];
                } else {
                    //$f = 'player'.$data['matches'][6]['player2'].'_'.$match_info['series_mw'];
                    //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][6]['player2'];
                    $f = 'player'.$data['matches'][6]['player2'];
                }
                if( $data['entry2'][$f.'_disp'] != '' ){
                    $html .= string_insert_br( $data['entry2'][$f.'_disp'] );
                } else {
                    $html .= string_insert_br( $data['entry2'][$f.'_sei'] );
                }
            }
        }
        $html .= '</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";
        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }


	function output_realtime_html_for_one_board_11( $navi_id, $place, $place_match_no )
	{
        $display_face = false;
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
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        $data_now = $objPage->get_kojin_tournament_one_result(
            $match_info['series'], $match_info['series_mw'], $match
        );
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
            $html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][1]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_red"></div>'."\n";
        $html .= '        <div class="pref">('.$objPage->get_pref_name( $pref_tbl, $data_now['players'][1]['entry']['kojin_address_pref'] ).')</div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name" id="player1">';
        $html .= string_insert_br( $data_now['players'][1]['name_str2'] );
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_name">'."\n";
        $html .= '        <div class="name2" id="player2">';
        $html .= string_insert_br( $data_now['players'][2]['name_str2'] );
        $html .= '        </div>'."\n";
        $html .= '      </div>'."\n";
        $html .= '      <div class="tb_frame_face">'."\n";
        $html .= '        <div class="frame">'."\n";
        if( $display_face ){
            $html .= '          <img class="photo" src="/ajw/result/2017/upload/'.$data_now['players'][2]['entry']['kojin_photo'].'_01.jpg" />'."\n";
        }
        $html .= '        </div>'."\n";
        $html .= '        <div class="tb_frame_side_white"></div>'."\n";
        $html .= '        <div class="pref">('.$objPage->get_pref_name( $pref_tbl, $data_now['players'][2]['entry']['kojin_address_pref'] ).')</div>'."\n";
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
            $html .= '</div>'."\n";
        }
        $html .= '      </div>'."\n";
        $html .= '      <div class="clearfloat"></div>'."\n";

        $html .= '    </div>'."\n";
        $html .= '  </div>'."\n";
        return $html;
    }

