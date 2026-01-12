<?php

	function __get_tournament_parameter_60_61()
	{
		$param = array(
			'mw' => $series_mw,
			'team_num' => 32,
			'match_num' => 31,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 5,
			'place_num' => 8,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16
		);
		return $param;
	}

	function get_tournament_parameter_60()
	{
		__get_tournament_parameter_60_61( 'm' );
	}

	function get_tournament_parameter_61()
	{
		__get_tournament_parameter_60_61( 'w' );
	}

	function __get_pref_order_60_61( $no )
	{
		$tbl = [
			0,
            0,
            0,  0,  0,  0,  0,  0,
            2, 1, 3, 4, 7, 5, 8,
			0, 0, 0, 0, 6, 0,
            0, 0, 0, 0,
            0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, 0,
            0, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 0
		];
			/*
            8,  9, 10, 11, 12, 13, 14, 19,
		array( 'value' => 8, 'title' => '茨城県' ),
		array( 'value' => 9, 'title' => '栃木県' ),
		array( 'value' => 10, 'title' => '群馬県' ),
		array( 'value' => 11, 'title' => '埼玉県' ),
		array( 'value' => 12, 'title' => '千葉県' ),
		array( 'value' => 13, 'title' => '東京都' ),
		array( 'value' => 14, 'title' => '神奈川県' ),
		array( 'value' => 19, 'title' => '山梨県' ),
			*/
		return $tbl[$no];
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_60_61_for_excel( $objPage, $series_info, $tournament_data, $entry_list, $mw )
    {
//print_r($tournament_data);
//print_r($entry_list);
//exit;

        if( $mw == 'm' ){
            $mwstr = '男子';
            $kmatch = 63;
            $level_num = 6;
        } else {
            $mwstr = '女子';
            $kmatch = 31;
            $level_num = 5;
        }
        require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
        require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
        $file_name = $series_info['reg_year'].'kantoKojinTournament_' . $mw . '.' . $ftime . '.xlsx';
        $file_path = $series_info['output_path'] . '/' . $file_name;
        $excel = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
        $excel = $reader->load(dirname(dirname(dirname(__FILE__))).'/templates/excel/kantoKojinTounamentResultsBase_'. $mw . '.' . $series_info['reg_year'] . '.xlsx');
        $excel->setActiveSheetIndex( 0 );        //何番目のシートに有効にするか
        $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        //$sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        //$sheet->getDefaultStyle()->getFont()->setSize(9);
        //$sheet->setCellValueByColumnAndRow( 0, 1, $mwstr.'個人戦トーナメント' );
        //$sheet->getStyle('A2')->getFont()->setSize(16);
        //$sheet->getRowDimension(1)->setRowHeight(12);
        //$sheet->getRowDimension(2)->setRowHeight(20);
        //$sheet->getRowDimension(3)->setRowHeight(12);
        //$sheet->getRowDimension(4)->setRowHeight(12);

        //$reader = PHPExcel_IOFactory::createReader('Excel2007');
        //$excel = $reader->load(dirname(__FILE__).'/H28shimoinaKojinTounamentResultsBase_'.$mv.'.xlsx');
        //$excel->setActiveSheetIndex( 0 );        //何番目のシートに有効にするか
        //$sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        //$sheet->setCellValue( 'AO6', $mvstr.' 個人戦 結果' );

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
        $match_level = intval( $tournament_data['data'][0]['match_level'] );
        $tournament_player_num = intval( $tournament_data['data'][0]['tournament_player_num'] );
        $tournament_player_num2 = intval( $tournament_data['data'][0]['tournament_player_num']/2 );
        $col = 2;
        $row = 6;
        $index = 1;
        for( $player = 0; $player < $tournament_player_num; $player++ ){
            if( $tournament_data['data'][0]['player'][$player]['info'] == 0 ){ continue; }
            $sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['data'][0]['player'][$player]['info'] == $entry_list[$i2]['id'] ){
					$sheet->setCellValueByColumnAndRow( $col+2, $row, $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
            $sheet->setCellValueByColumnAndRow( $col+4, $row, $tournament_data['data'][0]['player'][$player]['belonging_to_name'] );
            $row += 4;
            $index++;
        }

        $col1 = 8;
        $posTbl1 = array();
        $posTbl2 = array();
        $posTbl3 = array();
        $posTbl4 = array();
        $match_num = $tournament_player_num2;
        $match_num2 = intval( $tournament_player_num2 / 2 );
        for( $level = 0; $level < $match_level; $level++ ){
            $col = $col1;
            $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
            $colstr2 = PHPExcel_Cell::stringFromColumnIndex( $col+3 );
            $colstr3 = PHPExcel_Cell::stringFromColumnIndex( $col+4 );
            $colstr4 = PHPExcel_Cell::stringFromColumnIndex( $col+2 );
            $colstr_winner = PHPExcel_Cell::stringFromColumnIndex( $col+5 );
            if( $level == 0 ){
                $winner_name_hight = 3;
            } else if( $level <= 2 ){
                $winner_name_hight = 6;
            } else if( $level <= 4 ){
                $winner_name_hight = 7;
            }
            $row = 6;
            $pindex = 0;
            $match_no_top = $match_num - 1;
            for( $m = 0; $m < $match_num; $m++ ){
                $mup = intval( $m / 2 );
                $moffset = $m % 2;
                $match = $match_no_top + $m;
                if( $tournament_data['data'][0]['match'][$match]['place'] == 'no_match' ){
                    $up = intval( ( $match + 1 ) / 2 ) - 1;
                    if( $level > 0 ){
                        $r = $posTbl1[$m];
                    } else {
                        $r = $row + 2;
                    }
                    $red = 1;
                    if(
                        ( ( $match % 2 ) == 1 && $tournament_data['data'][0]['match'][$up]['winner'] == 1 )
                        || ( ( $match % 2 ) == 0 && $tournament_data['data'][0]['match'][$up]['winner'] == 2 )
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
                    $row += 4;
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
                    $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][$match] );
                    $winstr = '';
                    for( $wi = 0; $wi < 3; $wi++ ){
                        if( $winstrs[1][$wi] == '' ){
                            $winstr .= '　';
                        } else {
                            $winstr .= $winstrs[1][$wi];
                        }
                    }
                    $sheet->setCellValue( $colstr4.($r1-2), $winstr );
                    $sheet->getStyle($colstr4.($r1-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $sheet->getStyle($colstr4.($r1-2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['data'][0]['match'][$match]['winner'] == 1 ){
                        $sheet->getStyle( $colstr.$r1.':'.$colstr2.$r1 )->applyFromArray( $styleArrayHR );
                        $sheet->getStyle( $colstr2.$r1.':'.$colstr2.($r3-1) )->applyFromArray( $styleArrayVR );
                        $sheet->getStyle( $colstr3.$r3.':'.$colstr3.$r3 )->applyFromArray( $styleArrayHR );
                        $sheet->setCellValue( $colstr_winner.($r3-$winner_name_hight), $tournament_data['data'][0]['match'][$match]['player1_name'] );
                    }
                    if( $tournament_data['data'][0]['match'][$match]['winner'] == 2 ){
                        $sheet->getStyle( $colstr.$r2.':'.$colstr2.$r2 )->applyFromArray( $styleArrayHR );
                        $sheet->getStyle( $colstr2.$r3.':'.$colstr2.($r2-1) )->applyFromArray( $styleArrayVR );
                        $sheet->getStyle( $colstr3.$r3.':'.$colstr3.$r3 )->applyFromArray( $styleArrayHR );
                        $sheet->setCellValue( $colstr_winner.($r3-$winner_name_hight), $tournament_data['data'][0]['match'][$match]['player2_name'] );
                    }
                    $winstr = '';
                    for( $wi = 0; $wi < 3; $wi++ ){
                        if( $winstrs[2][$wi] == '' ){
                            $winstr .= '　';
                        } else {
                            $winstr .= $winstrs[2][$wi];
                        }
                    }
                    $sheet->setCellValue( $colstr4.($r2), $winstr );
                    $sheet->getStyle($colstr4.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $sheet->getStyle($colstr4.($r2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['data'][0]['match'][$match]['extra'] == 1 ){
                        $sheet->setCellValue( $colstr4.($r3-1), '延' );
                        //$sheet->getStyle($colstr2.($r3-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        //$sheet->getStyle($colstr2.($r3-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    }
                    $row += 8;
                }
            }
            $col1 += 6;
            $match_num = $match_num2;
            $match_num2 = intval( $match_num / 2 );
        }
        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
	}

	function output_tournament_60_for_excel( $objPage, $series_info, $tournament_data, $entry_list, $series_mw )
	{
		return __output_tournament_60_61_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_61_for_excel( $objPage, $series_info, $tournament_data, $entry_list, $series_mw )
	{
		return __output_tournament_60_61_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_60( $objPage, $path, $tournament_list, $entry_list, $mv )
	{
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mvstr.'団体決勝トーナメント結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果(一回戦)</h2>'."\n";
		for( $i1 = 1; $i1 <= 8; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;一回戦&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1+6], $entry_list, $mv );
		}
		$html .= $footer;
		$file = $path . '/tm'.$mv.'1.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );

		$html = $header . '    <h2>' . $mvstr . '団体決勝トーナメント結果(準々決勝～決勝)</h2>'."\n";
		for( $i1 = 1; $i1 <= 4; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準々決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1+2], $entry_list, $mv );
		}
		for( $i1 = 1; $i1 <= 2; $i1++ ){
			$html .= '<h3>団体決勝トーナメント&nbsp;準決勝&nbsp;第'.$i1.'試合</h3>';
			$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][$i1], $entry_list, $mv );
		}
		$html .= '<h3>団体決勝トーナメント&nbsp;決勝</h3>';
		$html .= $objPage->output_one_match_for_HTML2( $tournament_list['match'][0], $entry_list, $mv );
		$html .= $footer;
		$file = $path . '/tm'.$mv.'2.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_60_61_for_HTML( $path, $tournament_data, $entry_list, $mv )
	{
//echo '<!-- ';
//print_r($tournament_data);
//echo ' -->';
		$c = new common();
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		}
        $table_win_border_size = '1px';
        $table_normal_border_size = '1px';
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
			. '    width: 960px;' . "\n"
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
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
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
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
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
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
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
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
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
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_normal_border_size.' #000000;' . "\n"
			. '    border-right: none;' . "\n"
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
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">個人戦'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
//print_r($tournament_data);
//exit;
		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['data'][0]['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['data'][0]['player'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = $tournament_data['data'][0]['player'][$tournament_team]['sei'].' '.$tournament_data['data'][0]['player'][$tournament_team]['mei'];
            $pref = '';
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $tournament_data['data'][0]['player'][$tournament_team]['info'] == $entry_list[$i2]['id'] ){
                    $pref .= ( $entry_list[$i2]['school_address_pref_name'] . '・' );
					break;
				}
			}
			$pref .= $tournament_data['data'][0]['player'][$tournament_team]['school_name_ryaku'];
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['win1'] = $tournament_data['data'][0]['match'][$match_no-1]['win1'];
				$one_match['hon1'] = $tournament_data['data'][0]['match'][$match_no-1]['hon1'];
				$one_match['win2'] = $tournament_data['data'][0]['match'][$match_no-1]['win2'];
				$one_match['hon2'] = $tournament_data['data'][0]['match'][$match_no-1]['hon2'];
				$one_match['waza1_1'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_1'];
				$one_match['waza1_2'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_2'];
				$one_match['waza1_3'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_3'];
				$one_match['waza2_1'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_1'];
				$one_match['waza2_2'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_2'];
				$one_match['waza2_3'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_3'];
				$one_match['winner'] = $tournament_data['data'][0]['match'][$match_no-1]['winner'];
				$one_match['fusen'] = $tournament_data['data'][0]['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['data'][0]['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['place_match_no'];
				if( $one_match['place'] !== 'no_match' || $tournament_data['data'][0]['match'][$match_no-1]['player1'] != 0 ){
					$one_match['team1'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				//$match_no++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				} else {
					if( $tournament_data['data'][0]['match'][$match_no-1]['player2'] != 0 ){
						$one_match['team1'] = array(
							'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
						);
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
				$match_no++;
			}
		}
		$match_no_top /= 2;
//print_r($match_line1);

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['data'][0]['match_level']-1; $i1++ ){
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
						$one_match['match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['match'];
						$one_match['win1'] = $tournament_data['data'][0]['match'][$match_no-1]['win1'];
						$one_match['hon1'] = $tournament_data['data'][0]['match'][$match_no-1]['hon1'];
						$one_match['win2'] = $tournament_data['data'][0]['match'][$match_no-1]['win2'];
						$one_match['hon2'] = $tournament_data['data'][0]['match'][$match_no-1]['hon2'];
						$one_match['waza1_1'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_1'];
						$one_match['waza1_2'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_2'];
						$one_match['waza1_3'] = $tournament_data['data'][0]['match'][$match_no-1]['waza1_3'];
						$one_match['waza2_1'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_1'];
						$one_match['waza2_2'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_2'];
						$one_match['waza2_3'] = $tournament_data['data'][0]['match'][$match_no-1]['waza2_3'];
						$one_match['winner'] = $tournament_data['data'][0]['match'][$match_no-1]['winner'];
						$one_match['fusen'] = $tournament_data['data'][0]['match'][$match_no-1]['fusen'];
						$one_match['place'] = $tournament_data['data'][0]['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['place_match_no'];
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
		for( $level = 0; $level < $tournament_data['data'][0]['match_level']-1; $level++ ){
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
			for( $level = 0; $level < $tournament_data['data'][0]['match_level']-1; $level++ ){
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
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
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
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
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
							if( $level == $tournament_data['data'][0]['match_level']-2 ){
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
							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>' . "\n";
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
				if( $tournament_data['data'][0]['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 1 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament">';
				if( $tournament_data['data'][0]['match'][0]['fusen'] == 1 && $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
					$pdf .= '不戦勝';
				} else {
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_1'] );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_2'] );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_3'] );
				}
                $pdf .= '</td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament">';
				if( $tournament_data['data'][0]['match'][0]['fusen'] == 1 && $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
					$pdf .= '不戦勝';
				} else {
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_1'] );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_2'] );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_3'] );
				}
                $pdf .= '</td>';
			} else if( $line == $line2 + 2 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['data'][0]['match_level']-2; $level >= 0; $level-- ){
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
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
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
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
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
							if( $level == $tournament_data['data'][0]['match_level']-2 ){
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
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2"></td>' . "\n";
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

        $pdf .= '<div class="div_result_tournament_name_name">順位決定戦</div>' . "\n";
		$pdf .= '  <br /><br /><br />' . "\n";
		$pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		$pdf .= '<tr>' . "\n";
		$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['data'][0]['match'][31]['player1_name'] . '</td>' . "\n";
		$pdf .= '<td height="'.$table_height.'" class="div_border_b';
        if( $tournament_data['data'][0]['match'][31]['winner'] == 1 ){ $pdf .= '_win'; }
		$pdf .= ' div_result_one_tournament">';
		if( $tournament_data['data'][0]['match'][31]['fusen'] == 1 && $tournament_data['data'][0]['match'][31]['winner'] == 1 ){
			$pdf .= '不戦勝' . "\n";
		} else {
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza1_1'] );
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza1_2'] );
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza1_3'] );
		}
        $pdf .= '</td>' . "\n";
		$pdf .= '</tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
        if( $tournament_data['data'][0]['match'][31]['winner'] == 1 ){ $pdf .= '_win'; }
        $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
        if( $tournament_data['data'][0]['match'][31]['winner'] == 1 ){ $pdf .= '_win'; }
        $pdf .= ' div_result_one_tournament">';
        if( $tournament_data['data'][0]['match'][31]['winner'] != 0 ){ $pdf .= $tournament_data['data'][0]['match'][31]['win1'] . ' - ' . $tournament_data['data'][0]['match'][31]['win2']; }
        $pdf .= '&nbsp;&nbsp;</td><td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td><td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
        if( $tournament_data['data'][0]['match'][31]['winner'] == 1 ){
		    $pdf .= $tournament_data['data'][0]['match'][31]['player1_name'];
        } else if( $tournament_data['data'][0]['match'][31]['winner'] == 2 ){
		    $pdf .= $tournament_data['data'][0]['match'][31]['player2_name'];
        }
		$pdf .= '</td></tr>' . "\n";
		$pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td><td height="'.$table_height.'" class="div_border_r';
            if( $tournament_data['data'][0]['match'][31]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
		$pdf .= '<tr>' . "\n";
		$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['data'][0]['match'][31]['player2_name'] . '<td height="'.$table_height.'" class="div_border_br';
        if( $tournament_data['data'][0]['match'][31]['winner'] == 2 ){ $pdf .= '_win'; }
        $pdf .= ' div_result_one_tournament"></td>' . "\n";
		$pdf .= '</tr>' . "\n";
		$pdf .= '<tr><td class="div_result_one_tournament" height="'.$table_height.'" lang="ja">';
		if( $tournament_data['data'][0]['match'][31]['fusen'] == 1 && $tournament_data['data'][0]['match'][31]['winner'] == 2 ){
			$pdf .= '不戦勝' . "\n";
		} else {
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza2_1'] );
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza2_2'] );
			$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][31]['waza2_3'] );
		}
		$pdf .= '</td></tr>' . "\n";
		$pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";

		$pdf .= '  </table>' . "\n";
		$pdf .= '  <br /><br /><br />' . "\n";

		$pdf .=  '  </div>' . "\n";
		$pdf .= "\n";
		$pdf .= '<script>'."\n";
		$pdf .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$pdf .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$pdf .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$pdf .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$pdf .= "\n";
		$pdf .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$pdf .= '  ga(\'send\', \'pageview\');'."\n";
		$pdf .= "\n";
		$pdf .= '</script>'."\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

		$file = $path.'/k'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );
//echo $pdf;
//exit;
		//return $pdf;
	}

	function output_tournament_60_for_HTML( $path, $tournament_data, $entry_list )
	{
		//__output_tournament_60_61_for_HTML( $path, $tournament_data, $entry_list, 'm' );
        $objPage = new form_page();
        $objTournament = new form_page_kojin_tournament( $objPage );
        $objTournament->output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_61_for_HTML( $path, $tournament_data, $entry_list )
	{
		//__output_tournament_60_61_for_HTML( $path, $tournament_data, $entry_list, 'w' );
        $objPage = new form_page();
        $objTournament = new form_page_kojin_tournament( $objPage );
        $objTournament->output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel_60_61( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			. ' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			. ' and `disp_order`<=32'
			. ' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		$preftbl = $c->get_pref_array();
		$gradetbl = $c->get_grade_junior_array();
		$pos = $start_pos;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval( $fields['school_address_pref'] );
			if( $pref == 0 ){ continue; }

			$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
			$sheet->setCellValueByColumnAndRow( 1 , $pos, $series_name );
			$col = 2;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_email'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			if( $fields['insotu1_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_kana_sei'].' '.$fields['insotu1_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_mobile'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_college'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['insotu1_org_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			if( $fields['insotu2_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['reserve_catalog'] );

			for( $player = 1; $player <= 3; $player++ ){
				if( $player < 3 ){
					$yosen = intval($fields['player'.$player.'_yosen']);
					$sheet->setCellValueByColumnAndRow( $col++, $pos, ( $yosen != 0 ? $yosen : '' ) );
				}
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_sei'].' '.$fields['player'.$player.'_mei'] );
				if( $fields['player'.$player.'_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_kana_sei'].' '.$fields['player'.$player.'_kana_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['player'.$player.'_gakunen_dan_gakunen']) ) );
				$dan = $fields['player'.$player.'_gakunen_dan_dan'];
				$sheet->setCellValueByColumnAndRow( $col++, $pos, ( $dan != '0' ? $dan : '' ) );
			}
			$pos++;
		}
		db_close( $dbs );
		return $pos;
	}

	function output_entry_data_list_all_1_excel60( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel_60_61( $sheet, 60, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel_60_61( $sheet, 61, 'w', $pos, '個人戦女子' );
		return true;
	}

	function output_entry_data_list_all_1_excel61( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel_60_61( $sheet, 60, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel_60_61( $sheet, 61, 'w', $pos, '個人戦女子' );
		return true;
	}

	//--------------------------------------------------------------

	function __output_entry_data_list_all_2_excel_60_61( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			. ' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			. ' and `disp_order`<=32'
			. ' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		$preftbl = $c->get_pref_array();
		$gradetbl = $c->get_grade_junior_array();
		$pos = $start_pos;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval( $fields['school_address_pref'] );
			if( $pref == 0 ){ continue; }

			for( $player = 1; $player <= 3; $player++ ){
				if( $player <= 2 && intval($fields['player'.$player.'_yosen']) == 0 ){
					continue;
				}
				if( $fields['player'.$player.'_sei'] == '' ){
					continue;
				}
				$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
				$sheet->setCellValueByColumnAndRow( 1 , $pos, $series_name );
				if( $player <= 2 ){
					$sheet->setCellValueByColumnAndRow( 2 , $pos, '選手' );
				} else {
					$sheet->setCellValueByColumnAndRow( 2 , $pos, '稽古相手' );
				}
				$col = 3;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
				if( $player <= 2 ){
					$yosen = intval($fields['player'.$player.'_yosen']);
					$sheet->setCellValueByColumnAndRow( $col, $pos, ( $yosen != 0 ? $yosen : '' ) );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_sei'].' '.$fields['player'.$player.'_mei'] );
				if( $fields['player'.$player.'_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_kana_sei'].' '.$fields['player'.$player.'_kana_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['player'.$player.'_gakunen_dan_gakunen']) ) );
				$dan = $fields['player'.$player.'_gakunen_dan_dan'];
				$sheet->setCellValueByColumnAndRow( $col++, $pos, ( $dan != '0' ? $dan : '' ) );
				$pos++;
			}
			if( $fields['insotu1_sei'] != '' ){
				$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
				$sheet->setCellValueByColumnAndRow( 1 , $pos, $series_name );
				$sheet->setCellValueByColumnAndRow( 2 , $pos, '監督' );
				$col = 3;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
				if( $fields['insotu1_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_kana_sei'].' '.$fields['insotu1_kana_mei'] );
				$pos++;
			}
			if( $fields['insotu2_sei'] != '' ){
				$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
				$sheet->setCellValueByColumnAndRow( 1 , $pos, $series_name );
				$sheet->setCellValueByColumnAndRow( 2 , $pos, '引率者' );
				$col = 3;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
				if( $fields['insotu2_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
				$pos++;
			}
		}
		db_close( $dbs );
		return $pos;
	}

	function output_entry_data_list_all_2_excel60( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel_60_61( $sheet, 60, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel_60_61( $sheet, 61, 'w', $pos, '個人戦女子' );
		return false;
	}

	function output_entry_data_list_all_2_excel61( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel_60_61( $sheet, 60, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel_60_61( $sheet, 61, 'w', $pos, '個人戦女子' );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_60_61( $series, $series_mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$ret = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$lv['join'] = 1;
			$lv['school_name'] = '';
			$yosen1 = get_field_string_number( $fields, 'player1_yosen', 0 );
			$yosen2 = get_field_string_number( $fields, 'player2_yosen', 0 );
			if( $yosen1 != 0 ){
				$lv['school_name'] .= get_field_string( $fields, 'player1_sei' ) . ' ' . get_field_string( $fields, 'player1_mei' );
			}
			if( $yosen2 != 0 ){
				if( $yosen1 != 0 ){ $lv['school_name'] .= ' / '; }
				$lv['school_name'] .= get_field_string( $fields, 'player2_sei' ) . ' ' . get_field_string( $fields, 'player2_mei' );
			}
			$lv['school_name'] .= '(' . get_field_string( $fields, 'school_name' ) . ')';
			$ret[] = $lv;
		}
		db_close( $dbs );

		return array_merge( $ret );
	}

	function get_entry_data_list2_60()
	{
		return __get_entry_data_list2_60_61( 60, 'm' );
	}

	function get_entry_data_list2_61()
	{
		return __get_entry_data_list2_60_61( 61, 'w' );
	}

	//--------------------------------------------------------------

	function __get_entry_data_60_61_list_for_PDF( $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array2();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series
			.' and `year`='.$_SESSION['auth']['year']
			. ' and `disp_order`<=32'
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		for( $i1 = 0; $i1 < 8; $i1++ ){
			$data[$i1] = [ 'pref_name' => '', 'rank' => [] ];
			for( $i2 = 1; $i2 <= 4; $i2++ ){
				$data[$i1]['rank'][$i2] = [ 'id' => 0 ];
			}
		}
//echo $sql;
//print_r($list);
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['school_name'] = '';
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval( $fields['school_address_pref'] );
			if( $pref == 0 ){ continue; }
			$prefpos = __get_pref_order_60_61( $pref );
			if( $prefpos == 0){ continue; }
			$lv['pref_name'] = $c->get_pref_name( $preftbl, $pref );
			$lv['school_name'] = get_field_string( $fields, 'school_name' );
			$lv['insotu1_sei'] = get_field_string( $fields, 'insotu1_sei' );
			$lv['insotu1_mei'] = get_field_string( $fields, 'insotu1_mei' );
			$lv['rank'] = get_field_string_number( $fields, 'player1_yosen', 0 );
			if( $lv['rank'] > 0 ){
				$lv['photo'] = get_field_string( $fields, 'player1_photo' );
				$image = dirname(dirname(dirname(__FILE__))) . '/upload/pdf/' . $lv['photo'] . '_01.jpg';
				$image_size = getimagesize($image);
				$adv_width = $image_size[0] * 120 / $image_size[1];
				if( $adv_width > 110 ){
					$lv['photo_width'] = 110;
					$lv['photo_height'] = intval( $image_size[1] * 110 / $image_size[0] );
					$lv['photo_margin_x'] = 0;
					$lv['photo_margin_y'] = intval((120-$lv['photo_height'])/2);
				} else {
					$lv['photo_width'] = intval( $image_size[0] * 120 / $image_size[1] );
					$lv['photo_height'] = 120;
					$lv['photo_margin_x'] = intval((120-$lv['photo_width'])/2);
					$lv['photo_margin_y'] = 0;
				}
				$gakunen = get_field_string_number( $fields, 'player1_gakunen_dan_gakunen', 0 );
				$lv['player_gakunen'] = $c->get_grade_junior_name( $gakunentbl, $gakunen );
				$lv['player_dan'] = get_field_string( $fields, 'player1_gakunen_dan_dan' );
				$lv['player_sei'] = get_field_string( $fields, 'player1_sei' );
				$lv['player_mei'] = get_field_string( $fields, 'player1_mei' );
				if( $prefpos == 47 ){
					if( $lv['rank'] <= 2 ){
						$data[46]['pref_name'] = $lv['pref_name'] . '<br />&nbsp;１';
						$data[46]['rank'][$lv['rank']] = $lv;
					} else {
						$data[47]['pref_name'] = $lv['pref_name'] . '<br />&nbsp;２';
						$data[47]['rank'][$lv['rank']-2] = $lv;
					}
				} else {
					$data[$prefpos-1]['pref_name'] = $lv['pref_name'];
					$data[$prefpos-1]['rank'][$lv['rank']] = $lv;
				}
			}
			$lv['rank'] = get_field_string_number( $fields, 'player2_yosen', 0 );
			if( $lv['rank'] > 0 ){
				$lv['photo'] = get_field_string( $fields, 'player2_photo' );
				$image = dirname(dirname(dirname(__FILE__))) . '/upload/pdf/' . $lv['photo'] . '_01.jpg';
				$image_size = getimagesize($image);
				$adv_width = $image_size[0] * 120 / $image_size[1];
				if( $adv_width > 110 ){
					$lv['photo_width'] = 110;
					$lv['photo_height'] = intval( $image_size[1] * 110 / $image_size[0] );
					$lv['photo_margin_x'] = 0;
					$lv['photo_margin_y'] = intval((120-$lv['photo_height'])/2);
				} else {
					$lv['photo_width'] = intval( $image_size[0] * 120 / $image_size[1] );
					$lv['photo_height'] = 120;
					$lv['photo_margin_x'] = intval((120-$lv['photo_width'])/2);
					$lv['photo_margin_y'] = 0;
				}
				$gakunen = get_field_string_number( $fields, 'player2_gakunen_dan_gakunen', 0 );
				$lv['player_gakunen'] = $c->get_grade_junior_name( $gakunentbl, $gakunen );
				$lv['player_dan'] = get_field_string( $fields, 'player2_gakunen_dan_dan' );
				$lv['player_sei'] = get_field_string( $fields, 'player2_sei' );
				$lv['player_mei'] = get_field_string( $fields, 'player2_mei' );
				if( $prefpos == 47 ){
					if( $lv['rank'] <= 2 ){
						$data[46]['pref_name'] = $lv['pref_name'] . '<br />&nbsp;１';
						$data[46]['rank'][$lv['rank']] = $lv;
					} else {
						$data[47]['pref_name'] = $lv['pref_name'] . '<br />&nbsp;２';
						$data[47]['rank'][$lv['rank']-2] = $lv;
					}
				} else {
					$data[$prefpos-1]['pref_name'] = $lv['pref_name'];
					$data[$prefpos-1]['rank'][$lv['rank']] = $lv;
				}
			}
		}
		db_close( $dbs );
		return $data;
	}

	function get_entry_data_60_list_for_PDF()
	{
		return __get_entry_data_60_61_list_for_PDF( 60, 'm' );
	}

	function get_entry_data_61_list_for_PDF()
	{
		return __get_entry_data_60_61_list_for_PDF( 61, 'w' );
	}

	function __get_entry_data_60_61_list_for_ID_PDF( $series )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$data = [];
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series
			.' and `year`='.$_SESSION['auth']['year']
			. ' and `disp_order`<=32'
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['school_name'] = '';
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$pref = intval( $fields['school_address_pref'] );
			if( $pref == 0 ){ continue; }
			$lv['player1_yosen'] = get_field_string_number( $fields, 'player1_yosen', 0 );
			$lv['player2_yosen'] = get_field_string_number( $fields, 'player2_yosen', 0 );
			if( $lv['player1_yosen'] == 0 && $lv['player2_yosen'] == 0 ){ continue; }
			$lv['pref_name'] = $c->get_pref_name( $preftbl, $pref );
			$lv['school_name'] = get_field_string( $fields, 'school_name' );
			$lv['insotu1_sei'] = get_field_string( $fields, 'insotu1_sei' );
			$lv['insotu1_mei'] = get_field_string( $fields, 'insotu1_mei' );
			if( $lv['player1_yosen'] > 0 ){
				$lv['player1_photo'] = get_field_string( $fields, 'player1_photo' );
				$lv['player1_sei'] = get_field_string( $fields, 'player1_sei' );
				$lv['player1_mei'] = get_field_string( $fields, 'player1_mei' );
			}
			if( $lv['player2_yosen'] > 0 ){
				$lv['player2_photo'] = get_field_string( $fields, 'player2_photo' );
				$lv['player2_sei'] = get_field_string( $fields, 'player2_sei' );
				$lv['player2_mei'] = get_field_string( $fields, 'player2_mei' );
			}
			$lv['player3_sei'] = get_field_string( $fields, 'player3_sei' );
			$lv['player3_mei'] = get_field_string( $fields, 'player3_mei' );
			$data[] = $lv;
		}
		db_close( $dbs );
		return $data;
	}

	function __get_entry_data_60_61_for_ID_PDF( $list )
	{
		$xoffset = -28;
		$yoffset = -42;
		$clip_x_min = 40;
		$clip_y_min = 115;
		$clip_width_max = 103;
		$clip_height_max = 52;
		$pdata = [];
		$p2data = [];
		$idata = [];
		foreach( $list as $lv ){
			if( $lv['id'] == 0 ){ continue; }
			for( $i1 = 1; $i1 <= 2; $i1++ ){
				$pfield = 'player' . $i1;
				if( $lv[$pfield.'_yosen'] == 0 ){ continue; }
				if( $lv[$pfield.'_photo'] !== '' ){
					$image = dirname(dirname(dirname(__FILE__))) . '/upload/pdf/' . $lv[$pfield.'_photo'] . '_01.jpg';
					$image_size = getimagesize($image);
					$adv_width = $image_size[0] / $clip_width_max;
					$adv_height = $image_size[1] / $clip_height_max;
					if( $adv_width >= $adv_height ){
						$clip_width = $clip_width_max;
						$clip_height = intval( $image_size[1] / $adv_width );
						$clip_x = $clip_x_min;
						$clip_y = intval( $clip_y_min + ( $clip_height_max - $clip_height ) / 2 );
					} else {
						$clip_width = intval( $image_size[0] / $adv_height );
						$clip_height = $clip_height_max;
						$clip_x = intval( $clip_x_min + ( $clip_width_max - $clip_width ) / 2 );
						$clip_y = $clip_y_min;
					}
				}
				$data = [
					json_encode([
						'kind' => 'text',
						'x' => 45+$xoffset, 'y' => 96+$yoffset+1,
						'text' => $lv['pref_name'],
						'size' => 16,
					]),
					json_encode([
						'kind' => 'cell',
						'x' => 45+$xoffset, 'y' => 102+$yoffset+1,
						'width' => 92, 'height' => 10,
						'border' => 0, 'align' => 'L',
						'text' => $lv['school_name'],
						'size' => 22,
					]),
				];
				if( $lv[$pfield.'_photo'] != '' ){
					$data[] = json_encode([
						'kind' => 'jpeg',
						'x' => $clip_x+$xoffset, 'y' => $clip_y+$yoffset,
						'width' => $clip_width,
						'height' => $clip_height,
						'image' => $image,
					]);
				}
				$data[] = json_encode([
					'kind' => 'cell',
					'x' => 56+$xoffset, 'y' => 170+$yoffset-1,
					'width' => 70, 'height' => 10,
					'border' => 0, 'align' => 'C',
					'size' => 22,
					'text' => $lv[$pfield.'_sei'].'　'.$lv[$pfield.'_mei'],
				]);
				$data[] = json_encode([
					'kind' => 'text',
					'x' => 125+$xoffset, 'y' => 172.5+$yoffset-1,
					'width' => 16, 'height' => 7,
					'border' => 0, 'align' => 'R',
					'size' => 16,
					'text' => '選手',
				]);
				$pdata[] = $data;
			}
			for( $i1 = 3; $i1 <= 4; $i1++ ){
				if( $i1 == 3 && $lv['player3_sei'] == '' ){ continue; }
				$data = [
					json_encode([
						'kind' => 'text',
						'x' => 45+$xoffset, 'y' => 111+$yoffset,
						'text' => $lv['pref_name'],
						'size' => 16,
					]),
					json_encode([
						'kind' => 'cell',
						'x' => 45+$xoffset, 'y' => 117+$yoffset,
						'width' => 92, 'height' => 10,
						'border' => 0, 'align' => 'L',
						'text' => $lv['school_name'],
						'size' => 22,
					]),
				];
				$name = [
					'kind' => 'cell',
					'x' => 46+$xoffset, 'y' => 140+$yoffset,
					'width' => 70, 'height' => 10,
					'border' => 0, 'align' => 'C',
					'size' => 24,
				];
				$name2 = [
					'kind' => 'text',
					'x' => 115+$xoffset, 'y' => 142.5+$yoffset,
					'width' => 16, 'height' => 7,
					'border' => 0, 'align' => 'R',
					'size' => 18,
				];
				if( $i1 == 4 ){
					$name['text'] = $lv['insotu1_sei'].'　'.$lv['insotu1_mei'];
					$name2['text'] = '先生';
				} else {
					$name['text'] = $lv['player3_sei'].'　'.$lv['player3_mei'];
					$name2['text'] = '選手';
				}
				$data[] = json_encode( $name );
				$data[] = json_encode( $name2 );
				if( $i1 == 4 ){
					$idata[] = $data;
				} else {
					$p2data[] = $data;
				}
			}
		}
		return [
			'player' => $pdata,
			'player2' => $p2data,
			'insotu' => $idata
		];
	}

	function get_entry_data_60_for_catalog_PDF($objPage)
	{
		$list = __get_entry_data_60_61_list_for_PDF( 60, 'm' );
		$template = 'catalog_60';
		$fname = 'catalog_個人男子.' . date('YmdHis') . sprintf("%04d",microtime()*1000) . '.pdf';
		$objPage->fetch_template_for_pdf( $list, $template, $fname );
		return $fname;
	}

	function get_entry_data_61_for_catalog_PDF($objPage)
	{
		$list = __get_entry_data_60_61_list_for_PDF( 61, 'w' );
		$template = 'catalog_61';
		$fname = 'catalog_個人女子.' . date('YmdHis') . sprintf("%04d",microtime()*1000) . '.pdf';
		$objPage->fetch_template_for_pdf( $list, $template, $fname );
		return $fname;
	}

	function get_entry_data_60_for_ID_PDF($objPage)
	{
		$list = __get_entry_data_60_61_list_for_ID_PDF( 60 );
		$iddata = __get_entry_data_60_61_for_ID_PDF( $list );
		$edata = [
			[
				'template' => 'excel/ID_60_player.2024.pdf',
				'data' => $iddata['player'],
			],[
				'template' => 'excel/ID_60_player2.2024.pdf',
				'data' => $iddata['player2'],
			],[
				'template' => 'excel/ID_60_insotu.2024.pdf',
				'data' => $iddata['insotu'],
			],
		];
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
		$fname = 'IDカード_個人男子.' . $ftime . '.pdf';
		$path = $objPage->embed_data_for_PDF( $edata, $fname );
		return $fname;
	}

	function get_entry_data_61_for_ID_PDF($objPage)
	{
		$list = __get_entry_data_60_61_list_for_ID_PDF( 61 );
		$iddata = __get_entry_data_60_61_for_ID_PDF( $list );
		$edata = [
			[
				'template' => 'excel/ID_61_player.2024.pdf',
				'data' => $iddata['player'],
			],[
				'template' => 'excel/ID_61_player2.2024.pdf',
				'data' => $iddata['player2'],
			],[
				'template' => 'excel/ID_61_insotu.2024.pdf',
				'data' => $iddata['insotu'],
			],
		];
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
		$fname = 'IDカード_個人女子.' . $ftime . '.pdf';
		$path = $objPage->embed_data_for_PDF( $edata, $fname );
		return $fname;
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_60_61( $list, $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = array();
		foreach( $list as $lv ){
			if( $lv['join'] == 0 ){ continue; }
			$id = intval( $lv['id'] );
			$sql = 'select * from `entry_field` where `field` in ('
				. '\'school_address_pref\','
				. '\'school_name_ryaku\','
				. '\'kojin_yosen_'.$series_mw.'1\','
				. '\'kojin_'.$series_mw.'1_sei\','
				. '\'kojin_'.$series_mw.'1_mei\','
				. '\'kojin_yosen_'.$series_mw.'2\','
				. '\'kojin_'.$series_mw.'2_sei\','
				. '\'kojin_'.$series_mw.'2_mei\''
				. ') and `info`='.$id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$y1 = intval( $fields['kojin_yosen_'.$series_mw.'1'] );
			$y2 = intval( $fields['kojin_yosen_'.$series_mw.'2'] );
			$pref = intval( $fields['school_address_pref'] );
			$pref_name = $c->get_pref_name( $preftbl, $pref );
			$area = $c->get_pref_area( $pref );
			if( $y1 > 0 ){
				$one = array(
					'school_name_ryaku' => $fields['school_name_ryaku'],
					'name' => $fields['kojin_'.$series_mw.'1_sei'].' '.$fields['kojin_'.$series_mw.'1_mei'],
					'pref' => $pref,
					'pref_name' => $pref_name,
					'area' => $area,
					'rank' => $y1,
					'id' => $id
				);
				if( $y1 >= 3 ){
					$data[$y1-3] = $one;
				} else {
					$data[$pref*2+$y1-1] = $one;
				}
			}
			if( $y2 > 0 ){
				$one = array(
					'school_name_ryaku' => $fields['school_name_ryaku'],
					'name' => $fields['kojin_'.$series_mw.'2_sei'].' '.$fields['kojin_'.$series_mw.'2_mei'],
					'pref' => $pref,
					'pref_name' => $pref_name,
					'area' => $area,
					'rank' => $y2,
					'id' => $id
				);
				if( $y2 >= 3 ){
					$data[$y2-3] = $one;
				} else {
					$data[$pref*2+$y2-1] = $one;
				}
			}
		}
		db_close( $dbs );

		$ret = "名前,学校,都道府県,順位,地域,県番号,,\n";
		for( $i1 = 0; $i1 < 96; $i1++ ){
			$ret .= ( $data[$i1]['name'] . ','
				. $data[$i1]['school_name_ryaku'] . ','
				. $data[$i1]['pref_name'] . ','
				. $data[$i1]['rank'] . ','
				. $data[$i1]['area'] . ','
				. $data[$i1]['pref'] . ','
				. $data[$i1]['id'] . ",\n" );
		}
		return $ret;
	}

	function get_entry_data_for_draw_csv_60( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_60_61( $list, 18, 'm' ),
			'file' => 'kojin_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_61( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_60_61( $list, 19, 'w' ),
			'file' => 'kojin_w.csv'
		);
	}

	//--------------------------------------------------------------

	//--------------------------------------------------------------

	function __output_realtime_html_for_one_board_60_61( $place, $place_match_no )
	{
		global $navi_info;

		$objPage = new form_page();
		$hon1 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
		$hon2 = array( 1=>0, 2=>0, 3=>0, 4=>0, 5=>0 );
		$data = array( 'matches' => array(1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array()) );
		if( $place_match_no > 2 && $navi_info[$place][$place_match_no-2]['series'] >= 9 ){
			$data_prev2 = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no-2]['series'], $navi_info[$place][$place_match_no-2]['series_mw'], $navi_info[$place][$place_match_no-2]['match'] );
			$data['matches'][1] = $data_prev2['matches'];
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $data_prev2['matches']['waza1_'.$waza] != 0 ){
					$hon1[1]++;
				}
				if( $data_prev2['matches']['waza2_'.$waza] != 0 ){
					$hon2[1]++;
				}
			}
		} else {
			$data_prev2 = array();
		}
		if( $place_match_no > 1 && $navi_info[$place][$place_match_no-1]['series'] >= 9 ){
			$data_prev = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no-1]['series'], $navi_info[$place][$place_match_no-1]['series_mw'], $navi_info[$place][$place_match_no-1]['match'] );
			$data['matches'][2] = $data_prev['matches'];
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $data_prev['matches']['waza1_'.$waza] != 0 ){
					$hon1[2]++;
				}
				if( $data_prev['matches']['waza2_'.$waza] != 0 ){
					$hon2[2]++;
				}
			}
		} else {
			$data_prev = array();
		}

		$data_now = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no]['series'], $navi_info[$place][$place_match_no]['series_mw'], $navi_info[$place][$place_match_no]['match'] );
		$data['matches'][3] = $data_now['matches'];
		for( $waza = 1; $waza <= 3; $waza++ ){
			if( $data_now['matches']['waza1_'.$waza] != 0 ){
				$hon1[3]++;
			}
			if( $data_now['matches']['waza2_'.$waza] != 0 ){
				$hon2[3]++;
			}
		}
		if( $place_match_no < count($navi_info[$place]) && $navi_info[$place][$place_match_no+1]['series'] >= 9 ){
			$data_next = $objPage->get_kojin_tournament_one_result( $navi_info[$place][$place_match_no+1]['series'], $navi_info[$place][$place_match_no+1]['series_mw'], $navi_info[$place][$place_match_no+1]['match'] );
			$data['matches'][4] = $data_next['matches'];
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $data_next['matches']['waza1_'.$waza] != 0 ){
					$hon1[4]++;
				}
				if( $data_next['matches']['waza2_'.$waza] != 0 ){
					$hon2[4]++;
				}
			}
		} else {
			$data_next = array();
		}

		$html = '';
		$html .= '    <div align="center" class="tb_score_in">'."\n";
		$html .= '      <div class="tb_score_title">'.$navi_info[$place][$place_match_no]['place_name'].'</div>'."\n";
		$html .= '      <div class="clearfloat"></div>'."\n";
		for( $i1 = 1; $i1 <= 4; $i1++ ){
            $hon_num = 0;
			for( $i2 = 3; $i2 >= 1; $i2-- ){
				if( $data['matches'][$i1]['waza1_'.$i2] != 0 || $data['matches'][$i1]['waza2_'.$i2] != 0 ){
                    $hon_num = $i2;
                    break;
                }
            }
			if(
				$hon_num == 3 && (
					( $data['matches'][$i1]['waza1_2'] != 0 && $data['matches'][$i1]['waza1_3'] != 0 )
					|| ( $data['matches'][$i1]['waza2_2'] != 0 && $data['matches'][$i1]['waza2_3'] != 0 )
				)
			){
				$hon_num = 4;
			}

			$html .= '      <div class="tb_frame">'."\n";
			$html .= '        <div class="tb_frame_title tb_frame_bbottom">';
			if( $i1 == 1 ){
				$html .= '前々試合';
			} else if( $i1 == 2 ){
				$html .= '前試合';
			} else if( $i1 == 3 ){
			} else if( $i1 == 4 ){
				$html .= '次試合';
			}
			$html .= '</div>'."\n";
			$html .= '        <div class="tb_frame_content';
			$html .= '" id="player1_'.$i1.'">';
			if( $i1 == 1 ){
				$html .= string_insert_br( base64_decode($data_prev2['players'][1]['name_str2']) );
			} else if( $i1 == 2 ){
				$html .= string_insert_br( base64_decode($data_prev['players'][1]['name_str2']) );
			} else if( $i1 == 3 ){
				$html .= string_insert_br( base64_decode($data_now['players'][1]['name_str2']) );
			} else if( $i1 == 4 ){
				$html .= string_insert_br( base64_decode($data_next['players'][1]['name_str2']) );
			}
			if( $data['matches'][$i1]['end_match'] == 1 ){
				if( ( $hon1[$i1] == 1 && $hon2[$i1] == 0 ) || ( $hon1[$i1] == 0 && $hon2[$i1] == 1 ) ){
					if( $data['matches'][$i1]['extra'] != 1 ){
						$html .= '<div class="tb_frame_ippon">一本勝</div>';
					}
				} else if( $hon1[$i1] == $hon2[$i1] ){
					$html .= '<div class="tb_frame_draw">×</div>';
				}
			}
			$html .= '</div>'."\n";
			$html .= '        <div class="tb_frame_waza tb_frame_btop">'."\n";
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
					$html .= '          <div class="tb_frame_waza2">○</div>';
				} else if( $data['matches'][$i1]['waza1_'.$i2] != 0 ){
					$html .= '          <div class="tb_frame_waza'.$hon_num.'_'.$i2.'">';
					//if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
					if($data['matches'][$i1]['waza1_'.$i2]==1){ $html .= 'メ'; }
					if($data['matches'][$i1]['waza1_'.$i2]==2){ $html .= 'ド'; }
					if($data['matches'][$i1]['waza1_'.$i2]==3){ $html .= 'コ'; }
					if($data['matches'][$i1]['waza1_'.$i2]==4){ $html .= '反'; }
					//if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .= '○'; }
					if($data['matches'][$i1]['waza1_'.$i2]==6){ $html .= 'ツ'; }
	 				$html .= '</div>'."\n";
				}
			}
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_faul">'."\n";
			//if($data['matches'][$i1]['faul1_1']==2){ echo '指'; }
			if($data['matches'][$i1]['faul1_2']==1){ $html .= '▲'; }
			if($data['matches'][$i1]['extra']==1){
				$html .= '          <div class="tb_frame_faul_extra" id="extra_match<?php echo $i1; ?>">延長</div>'."\n";
			}
			$html .= '        </div>'."\n";
			$html .= '      </div>'."\n";
		}
		$html .= '      <div class="clearfloat"></div>'."\n";

		for( $i1 = 1; $i1 <= 4; $i1++ ){
            $hon_num = 0;
			for( $i2 = 3; $i2 >= 1; $i2-- ){
				if( $data['matches'][$i1]['waza1_'.$i2] != 0 || $data['matches'][$i1]['waza2_'.$i2] != 0 ){
                    $hon_num = $i2;
                    break;
                }
            }
			if(
				$hon_num == 3 && (
					( $data['matches'][$i1]['waza1_2'] != 0 && $data['matches'][$i1]['waza1_3'] != 0 )
					|| ( $data['matches'][$i1]['waza2_2'] != 0 && $data['matches'][$i1]['waza2_3'] != 0 )
				)
			){
				$hon_num = 4;
			}

			$html .= '      <div class="tb_frame">'."\n";
			$html .= '        <div class="tb_frame_faul">';
			//if($data['matches'][$i1]['faul2_1']==2){ echo '指'; }
			if($data['matches'][$i1]['faul2_2']==1){ $html .= '▲'; }
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_waza tb_frame_bbottom">'."\n";
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				if( $data['matches'][$i1]['waza2_'.$i2] == 5 ){
					$html .= '          <div class="tb_frame_waza2">○</div>';
				} else if( $data['matches'][$i1]['waza2_'.$i2] != 0 ){
					$html .= '          <div class="tb_frame_waza'.$hon_num.'_'.$i2.'">';
					//if($data['matches'][$i1]['waza1_'.$i2]==0){ $html .= '&nbsp;'; }
					if($data['matches'][$i1]['waza2_'.$i2]==1){ $html .= 'メ'; }
					if($data['matches'][$i1]['waza2_'.$i2]==2){ $html .= 'ド'; }
					if($data['matches'][$i1]['waza2_'.$i2]==3){ $html .= 'コ'; }
					if($data['matches'][$i1]['waza2_'.$i2]==4){ $html .= '反'; }
					//if($data['matches'][$i1]['waza1_'.$i2]==5){ $html .= '○'; }
					if($data['matches'][$i1]['waza2_'.$i2]==6){ $html .= 'ツ'; }
	 				$html .= '</div>'."\n";
				}
/*
				if($data['matches'][$i1]['waza2_'.$i2]==5){
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
	 			$html .= '</div>'."\n";
*/
			}
			$html .= '        </div>'."\n";
			$html .= '        <div class="tb_frame_content';
			$html .= '" id="player2_'.$i1.'">';
			if( $i1 == 1 ){
				$html .= string_insert_br( base64_decode($data_prev2['players'][2]['name_str2']) );
			} else if( $i1 == 2 ){
				$html .= string_insert_br( base64_decode($data_prev['players'][2]['name_str2']) );
			} else if( $i1 == 3 ){
				$html .= string_insert_br( base64_decode($data_now['players'][2]['name_str2']) );
			} else if( $i1 == 4 ){
				$html .= string_insert_br( base64_decode($data_next['players'][2]['name_str2']) );
			}
			$html .= '</div>'."\n";
			$html .= '      </div>'."\n";
		}
		$html .= '      <div class="clearfloat"></div>'."\n";
		$html .= '    </div>'."\n";
		$html .= '  </div>'."\n";
/*
		$url = 'http://49.212.133.48:3000/';
		$data = array(
    		'pos' => $place,
    		'value' => $html,
		);
		$data = http_build_query($data, "", "&");
		$options = array('http' => array(
		    'method' => 'POST',
    		'content' => $data,
		));
		$options = stream_context_create($options);
		$contents = file_get_contents($url, false, $options);
*/
		return $html;
	}

	function output_realtime_html_for_one_board_60( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_60_61( $place, $place_match_no );
	}

	function output_realtime_html_for_one_board_61( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_60_61( $place, $place_match_no );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_chart_60_61_for_HTML( $tournament_data, $entry_list )
	{
//echo '<!-- ';
//print_r($tournament_data);
//echo ' -->';
		$c = new common();
		$mv = $tournament_data['data']['series_mw'];
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		}
		$pdf = '  <div class="content">' . "\n";
//print_r($tournament_data);
		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['data']['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['data']['player'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = $tournament_data['data']['player'][$tournament_team]['sei'].' '.$tournament_data['data']['player'][$tournament_team]['mei'];
			$pref = $tournament_data['data']['player'][$tournament_team]['pref_name'];
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['win1'] = $tournament_data['data']['match'][$match_no-1]['win1'];
				$one_match['hon1'] = $tournament_data['data']['match'][$match_no-1]['hon1'];
				$one_match['win2'] = $tournament_data['data']['match'][$match_no-1]['win2'];
				$one_match['hon2'] = $tournament_data['data']['match'][$match_no-1]['hon2'];
				$one_match['waza1_1'] = $tournament_data['data']['match'][$match_no-1]['waza1_1'];
				$one_match['waza1_2'] = $tournament_data['data']['match'][$match_no-1]['waza1_2'];
				$one_match['waza1_3'] = $tournament_data['data']['match'][$match_no-1]['waza1_3'];
				$one_match['waza2_1'] = $tournament_data['data']['match'][$match_no-1]['waza2_1'];
				$one_match['waza2_2'] = $tournament_data['data']['match'][$match_no-1]['waza2_2'];
				$one_match['waza2_3'] = $tournament_data['data']['match'][$match_no-1]['waza2_3'];
				$one_match['winner'] = $tournament_data['data']['match'][$match_no-1]['winner'];
				$one_match['fusen'] = $tournament_data['data']['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['data']['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['data']['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['data']['match'][$match_no-1]['place_match_no'];
				if( $one_match['place'] !== 'no_match' || $tournament_data['data']['match'][$match_no-1]['player1'] != 0 ){
					$one_match['team1'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				//$match_no++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				} else {
					if( $tournament_data['data']['match'][$match_no-1]['player2'] != 0 ){
						$one_match['team1'] = array(
							'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
						);
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
				$match_no++;
			}
		}
		$match_no_top /= 2;
//print_r($match_line1);

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['data']['match_level']-1; $i1++ ){
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
						$one_match['match_no'] = $tournament_data['data']['match'][$match_no-1]['match'];
						$one_match['win1'] = $tournament_data['data']['match'][$match_no-1]['win1'];
						$one_match['hon1'] = $tournament_data['data']['match'][$match_no-1]['hon1'];
						$one_match['win2'] = $tournament_data['data']['match'][$match_no-1]['win2'];
						$one_match['hon2'] = $tournament_data['data']['match'][$match_no-1]['hon2'];
						$one_match['waza1_1'] = $tournament_data['data']['match'][$match_no-1]['waza1_1'];
						$one_match['waza1_2'] = $tournament_data['data']['match'][$match_no-1]['waza1_2'];
						$one_match['waza1_3'] = $tournament_data['data']['match'][$match_no-1]['waza1_3'];
						$one_match['waza2_1'] = $tournament_data['data']['match'][$match_no-1]['waza2_1'];
						$one_match['waza2_2'] = $tournament_data['data']['match'][$match_no-1]['waza2_2'];
						$one_match['waza2_3'] = $tournament_data['data']['match'][$match_no-1]['waza2_3'];
						$one_match['winner'] = $tournament_data['data']['match'][$match_no-1]['winner'];
						$one_match['fusen'] = $tournament_data['data']['match'][$match_no-1]['fusen'];
						$one_match['place'] = $tournament_data['data']['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['data']['match'][$match_no-1]['place_match_no'];
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
		for( $level = 0; $level < $tournament_data['data']['match_level']-1; $level++ ){
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
			for( $level = 0; $level < $tournament_data['data']['match_level']-1; $level++ ){
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
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
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
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
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
							if( $level == $tournament_data['data']['match_level']-2 ){
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
							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>' . "\n";
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
				if( $tournament_data['data']['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['data']['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['data']['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 2 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['data']['match_level']-2; $level >= 0; $level-- ){
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
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
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
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
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
							if( $level == $tournament_data['data']['match_level']-2 ){
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
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2"></td>' . "\n";
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

		$pdf .=  '    </table>' . "\n";
		$pdf .= '    </div>' . "\n";
//echo $pdf;
//exit;
		return $pdf;
	}

	function output_tournament_chart_60_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_60_61_for_HTML( $tournament_data, $entry_list );
	}

	function output_tournament_chart_61_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_60_61_for_HTML( $tournament_data, $entry_list );
	}

	//--------------------------------------------------------------
?>
