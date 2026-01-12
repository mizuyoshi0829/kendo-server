<?php

	function __get_tournament_parameter_72_73()
	{
		$param = array(
			'mw' => $series_mw,
			'team_num' => 32,
			'match_num' => 64,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 5,
			'place_num' => 8,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16
		);
		return $param;
	}

	function get_tournament_parameter_72()
	{
		__get_tournament_parameter_72_73( 'm' );
	}

	function get_tournament_parameter_73()
	{
		__get_tournament_parameter_72_73( 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_72_73_for_excel( $objPage, $series_info, $tournament_data, $entry_list, $mw )
    {
//print_r($tournament_data);
//exit;

        if( $mw == 'm' ){
            $mwstr = '男子';
            $kmatch = 63;
            $level_num = 6;
        } else {
            $mwstr = '女子';
            $kmatch = 64;
            $level_num = 5;
        }
        require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
        require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

        $file_name = $series_info['reg_year'] . 'hsKojinTournament_' . $mw . '.xlsx';
        //$file_name = $series_info['reg_year'] . 'nanshinJuniorKojinTounamentResults_' . $mw . '.xlsx';
        $file_path = $series_info['output_path'] . '/' . $file_name;
        $excel = new PHPExcel();
        $reader = PHPExcel_IOFactory::createReader('Excel2007');
        $excel = $reader->load(dirname(__FILE__).'/allnaganoJuniorKojinTournament.xlsx');
        $excel->setActiveSheetIndex( 0 );        //何番目のシートに有効にするか
        $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
        $sheet->setCellValueByColumnAndRow( 0, 1, $mwstr.'個人戦トーナメント' );
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
        $col = 0;
        $row = 3;
        $index = 1;
        for( $player = 0; $player < $tournament_player_num; $player++ ){
            if( $player == $tournament_player_num2 ){
                $col = ( $match_level + 1 ) * 2 + 5;
                $row = 3;
            }
            if( $tournament_data['data'][0]['player'][$player]['info'] == 0 ){ continue; }
            if( $player < $tournament_player_num2 ){
                $sheet->setCellValueByColumnAndRow( $col+4, $row, $index );
                $sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
                $sheet->setCellValueByColumnAndRow( $col+2, $row, $tournament_data['data'][0]['player'][$player]['belonging_to_name'] );
            } else {
                $sheet->setCellValueByColumnAndRow( $col+1, $row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
                $sheet->setCellValueByColumnAndRow( $col+3, $row, $tournament_data['data'][0]['player'][$player]['belonging_to_name'] );
                $sheet->setCellValueByColumnAndRow( $col, $row, $index );
            }
            //$mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            //$mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col) . ($row+3);
            //$sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            //$sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+1) . $row;
            //mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+1) . ($row+3);
            //$sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            //$sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            //$mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+2) . $row;
            //$mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+2) . ($row+3);
            //$sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            //$sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //$sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $row += 4;
            $index++;
        }

        $col1 = 5;
        $col2 = 5 + $match_level * 2 + 1;
        $posTbl1 = array();
        $posTbl2 = array();
        $posTbl3 = array();
        $posTbl4 = array();
        $match_num = $tournament_player_num2;
        $match_num2 = intval( $tournament_player_num2 / 2 );
        for( $level = 0; $level < $match_level-1; $level++ ){
            $col = $col1;
            $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
            $row = 2;
            $pindex = 0;
            $match_no_top = $match_num - 1;
            for( $m = 0; $m < $match_num; $m++ ){
                $mup = intval( $m / 2 );
                $moffset = $m % 2;
                if( $m == $match_num2 ){
                    $col = $col2;
                    $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
                    $row = 2;
                }
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
                    $sheet->setCellValue( $colstr.($r1-1), $winstr );
                    //$sheet->mergeCells( $colstr.($r1-2).':'.$colstr.($r1-1) );
                    if( $m >= $match_num2 ){
                        $sheet->getStyle($colstr.($r1-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    } else {
                        $sheet->getStyle($colstr.($r1-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    }
                    $sheet->getStyle($colstr.($r1-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['data'][0]['match'][$match]['winner'] == 1 ){
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
                    if( $tournament_data['data'][0]['match'][$match]['winner'] == 2 ){
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
                    $winstr = '';
                    for( $wi = 0; $wi < 3; $wi++ ){
                        if( $winstrs[2][$wi] == '' ){
                            $winstr .= '　';
                        } else {
                            $winstr .= $winstrs[2][$wi];
                        }
                    }
                    $sheet->setCellValue( $colstr.($r2), $winstr );
                    //$sheet->mergeCells( $colstr.($r2).':'.$colstr.($r2+1) );
                    if( $m >= $match_num2 ){
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    } else {
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->getStyle($colstr.($r2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['data'][0]['match'][$match]['extra'] == 1 ){
                        $sheet->setCellValue( $colstr.($r3-1), '延' );
                        $sheet->mergeCells( $colstr.($r3-1).':'.$colstr.($r3) );
                        if( $m >= $match_num2 ){
                            $sheet->getStyle($colstr.($r3-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        } else {
                            $sheet->getStyle($colstr.($r3-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        }
                        $sheet->getStyle($colstr.($r3-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    }
                    $row += 8;
                }
            }
            $col1++;
            $col2--;
            $match_num = $match_num2;
            $match_num2 = intval( $match_num / 2 );
        }

        $col1 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 4 );
        $col1b = PHPExcel_Cell::stringFromColumnIndex( $match_level + 5 );
        $col2 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 6 );
        $col2b = PHPExcel_Cell::stringFromColumnIndex( $match_level + 7 );
        $row = $posTbl1[0];
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][0] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( $col1.($row), $winstr );
        $sheet->mergeCells( $col1.($row).':'.$col1b.($row+1) );
        $sheet->getStyle($col1.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col1.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->setCellValue( $col1.($row-2), '１２３' );
        $sheet->mergeCells( $col1.($row-2).':'.$col1b.($row-1) );
        $sheet->getStyle($col1.($row-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col1.($row-2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
            $sheet->getStyle( $col1.$row.':'.$col1b.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.$row.':'.$col2b.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1b.($row-3).':'.$col1b.($row-1) )->applyFromArray( $styleArrayVR );
            $sheet->setCellValue( 'K4', $tournament_data['data'][0]['match'][0]['player1_name'].'('.$tournament_data['data'][0]['match'][0]['player1_belonging_to_name'].')' );
        } else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
            $sheet->getStyle( $col1.$row.':'.$col1b.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row.':'.$col2b.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.($row-3).':'.$col2.($row-1) )->applyFromArray( $styleArrayVR2 );
            $sheet->setCellValue( 'K4', $tournament_data['data'][0]['match'][0]['player2_name'].'('.$tournament_data['data'][0]['match'][0]['player2_belonging_to_name'].')' );
        } else {
            $sheet->getStyle( $col1.$row.':'.$col1b.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row.':'.$col2b.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1.($row-2).':'.$col1.($row-1) )->applyFromArray( $styleArrayV );
        }
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( $col2.($row), $winstr );
        $sheet->mergeCells( $col2.($row).':'.$col2b.($row+1) );
        $sheet->getStyle($col2.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col2.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $sheet->setCellValue( $col2.($row-2), '１２３' );
        $sheet->mergeCells( $col2.($row-2).':'.$col2b.($row-1) );
        $sheet->getStyle($col2.($row-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col2.($row-2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['data'][0]['match'][0]['extra'] == 1 ){
            $sheet->setCellValue( $col1.($row+2), '延' );
            $sheet->mergeCells( $col1.($row+2).':'.$col2b.($row+3) );
            $sheet->getStyle($col1.($row+2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1.($row+2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        if( $tournament_data['data'][0]['match'][1]['winner'] == 1 ){
            $sheet->setCellValue( 'J55', $tournament_data['data'][0]['match'][1]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][1]['winner'] == 2 ){
            $sheet->setCellValue( 'J55', $tournament_data['data'][0]['match'][1]['player1_name'] );
        }
        if( $tournament_data['data'][0]['match'][2]['winner'] == 1 ){
            $sheet->setCellValue( 'L55', $tournament_data['data'][0]['match'][2]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][2]['winner'] == 2 ){
            $sheet->setCellValue( 'L55', $tournament_data['data'][0]['match'][2]['player1_name'] );
        }
        if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 1 ){
            $sheet->getStyle( 'K53' )->applyFromArray( $styleArrayHR );
            //$sheet->getStyle( 'E'.($row+6) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'J53:J54' )->applyFromArray( $styleArrayVR );
            //$sheet->getStyle( 'E'.($row+4).':E'.($row+5) )->applyFromArray( $styleArrayV );
            $sheet->getStyle( 'K51:K52' )->applyFromArray( $styleArrayVR );
            //$sheet->setCellValue( 'H'.($row+3), $tournament_data['data'][0]['match'][$tournament_player_num-1]['player1_name'] );
            //$sheet->mergeCells( 'H'.($row+3).':'.'J'.($row+4) );
            //$sheet->getStyle('H'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            //$sheet->getStyle('H'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 2 ){
            //$sheet->getStyle( 'E'.($row+2) )->applyFromArray( $styleArrayH );
            $sheet->getStyle( 'L53' )->applyFromArray( $styleArrayHR );
            //$sheet->getStyle( 'E'.($row+2).':E'.($row+3) )->applyFromArray( $styleArrayV );
            $sheet->getStyle( 'L53:L54' )->applyFromArray( $styleArrayVR );
            $sheet->getStyle( 'K51:K52' )->applyFromArray( $styleArrayVR );
            //$sheet->setCellValue( 'H'.($row+3), $tournament_data['data'][0]['match'][$tournament_player_num-1]['player2_name'] );
            //$sheet->mergeCells( 'H'.($row+3).':'.'J'.($row+4) );
            //$sheet->getStyle('H'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            //$sheet->getStyle('H'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else {
            //$sheet->getStyle( 'E'.($row+2) )->applyFromArray( $styleArrayH );
            //$sheet->getStyle( 'E'.($row+6) )->applyFromArray( $styleArrayH );
            //$sheet->getStyle( 'E'.($row+2).':E'.($row+5) )->applyFromArray( $styleArrayV );
            //$sheet->getStyle( 'F'.($row+4) )->applyFromArray( $styleArrayH );
        }
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][$tournament_player_num-1] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( 'K52', $winstr );
        //$sheet->getStyle('J52')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //$sheet->getStyle('J52')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( 'L52', $winstr );
        //$sheet->mergeCells( 'E'.($row+6).':'.'E'.($row+7) );
        //$sheet->getStyle('E'.($row+6))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        //$sheet->getStyle('E'.($row+6))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['extra'] == 1 ){
            $sheet->setCellValue( 'L53', '延' );
            //$sheet->mergeCells( 'E'.($row+3).':'.'E'.($row+4) );
            //$sheet->getStyle('E'.($row+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            //$sheet->getStyle('E'.($row+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }

        if( $tournament_data['data'][0]['match'][3]['winner'] == 1 ){
            $sheet->setCellValue( 'G67', $tournament_data['data'][0]['match'][3]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][3]['winner'] == 2 ){
            $sheet->setCellValue( 'G67', $tournament_data['data'][0]['match'][3]['player1_name'] );
        }
        if( $tournament_data['data'][0]['match'][4]['winner'] == 1 ){
            $sheet->setCellValue( 'G71', $tournament_data['data'][0]['match'][4]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][4]['winner'] == 2 ){
            $sheet->setCellValue( 'G71', $tournament_data['data'][0]['match'][4]['player1_name'] );
        }
        if( $tournament_data['data'][1]['match'][1]['winner'] == 1 ){
            $sheet->getStyle( 'I68' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'I68:I69' )->applyFromArray( $styleArrayVR );
        } else if( $tournament_data['data'][1]['match'][1]['winner'] == 2 ){
            $sheet->getStyle( 'I72' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'I70:I71' )->applyFromArray( $styleArrayVR );
        }
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][1]['match'][1] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( 'I67', $winstr );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( 'I72', $winstr );
        if( $tournament_data['data'][1]['match'][1]['extra'] == 1 ){
            $sheet->setCellValue( 'I69', '延' );
        }

        if( $tournament_data['data'][0]['match'][5]['winner'] == 1 ){
            $sheet->setCellValue( 'O67', $tournament_data['data'][0]['match'][5]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][5]['winner'] == 2 ){
            $sheet->setCellValue( 'O67', $tournament_data['data'][0]['match'][5]['player1_name'] );
        }
        if( $tournament_data['data'][0]['match'][6]['winner'] == 1 ){
            $sheet->setCellValue( 'O71', $tournament_data['data'][0]['match'][6]['player2_name'] );
        } else if( $tournament_data['data'][0]['match'][6]['winner'] == 2 ){
            $sheet->setCellValue( 'O71', $tournament_data['data'][0]['match'][6]['player1_name'] );
        }
        if( $tournament_data['data'][1]['match'][2]['winner'] == 1 ){
            $sheet->getStyle( 'N68' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'M68:M69' )->applyFromArray( $styleArrayVR );
        } else if( $tournament_data['data'][1]['match'][2]['winner'] == 2 ){
            $sheet->getStyle( 'N72' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'M70:M71' )->applyFromArray( $styleArrayVR );
        }
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][1]['match'][2] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( 'N67', $winstr );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( 'N72', $winstr );
        if( $tournament_data['data'][1]['match'][2]['extra'] == 1 ){
            $sheet->setCellValue( 'N69', '延' );
        }

        if( $tournament_data['data'][1]['match'][0]['winner'] == 1 ){
            $sheet->getStyle( 'J70:K70' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'K68:K69' )->applyFromArray( $styleArrayVR );
        } else if( $tournament_data['data'][1]['match'][0]['winner'] == 2 ){
            $sheet->getStyle( 'L70:M70' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'K68:K69' )->applyFromArray( $styleArrayVR );
        }
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][1]['match'][0] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( 'J70', $winstr );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( 'L70', $winstr );
        if( $tournament_data['data'][1]['match'][0]['extra'] == 1 ){
            $sheet->setCellValue( 'L71', '延' );
        }

        if( $tournament_data['data'][1]['match'][1]['winner'] == 1 ){
            $sheet->setCellValue( 'J82', $tournament_data['data'][1]['match'][1]['player2_name'] );
        } else if( $tournament_data['data'][1]['match'][1]['winner'] == 2 ){
            $sheet->setCellValue( 'J82', $tournament_data['data'][1]['match'][1]['player1_name'] );
        }
        if( $tournament_data['data'][1]['match'][2]['winner'] == 1 ){
            $sheet->setCellValue( 'L82', $tournament_data['data'][1]['match'][2]['player2_name'] );
        } else if( $tournament_data['data'][1]['match'][2]['winner'] == 2 ){
            $sheet->setCellValue( 'L82', $tournament_data['data'][1]['match'][2]['player1_name'] );
        }
        if( $tournament_data['data'][1]['match'][3]['winner'] == 1 ){
            $sheet->getStyle( 'K80' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'J80:J81' )->applyFromArray( $styleArrayVR );
            $sheet->getStyle( 'K78:K79' )->applyFromArray( $styleArrayVR );
        } else if( $tournament_data['data'][1]['match'][3]['winner'] == 2 ){
            $sheet->getStyle( 'L80' )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( 'L80:L81' )->applyFromArray( $styleArrayVR );
            $sheet->getStyle( 'K78:K79' )->applyFromArray( $styleArrayVR );
        }
        $winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][1]['match'][3] );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[1][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[1][$wi];
            }
        }
        $sheet->setCellValue( 'K79', $winstr );
        $winstr = '';
        for( $wi = 0; $wi < 3; $wi++ ){
            if( $winstrs[2][$wi] == '' ){
                $winstr .= '　';
            } else {
                $winstr .= $winstrs[2][$wi];
            }
        }
        $sheet->setCellValue( 'L79', $winstr );
        if( $tournament_data['data'][1]['match'][3]['extra'] == 1 ){
            $sheet->setCellValue( 'L80', '延' );
        }

        if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
            $sheet->setCellValue( 'A94', $tournament_data['data'][0]['match'][0]['player1_name'].'('.$tournament_data['data'][0]['match'][0]['player1_belonging_to_name'].')' );
        } else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
            $sheet->setCellValue( 'A94', $tournament_data['data'][0]['match'][0]['player2_name'].'('.$tournament_data['data'][0]['match'][0]['player2_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
            $sheet->setCellValue( 'F94', $tournament_data['data'][0]['match'][0]['player2_name'].'('.$tournament_data['data'][0]['match'][0]['player2_belonging_to_name'].')' );
        } else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
            $sheet->setCellValue( 'F94', $tournament_data['data'][0]['match'][0]['player1_name'].'('.$tournament_data['data'][0]['match'][0]['player1_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 1 ){
            $sheet->setCellValue( 'L94', $tournament_data['data'][0]['match'][$tournament_player_num-1]['player1_name'].'('.$tournament_data['data'][0]['match'][$tournament_player_num-1]['player1_belonging_to_name'].')' );
        } else if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 2 ){
            $sheet->setCellValue( 'L94', $tournament_data['data'][0]['match'][$tournament_player_num-1]['player2_name'].'('.$tournament_data['data'][0]['match'][$tournament_player_num-1]['player2_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 1 ){
            $sheet->setCellValue( 'R94', $tournament_data['data'][0]['match'][$tournament_player_num-1]['player2_name'].'('.$tournament_data['data'][0]['match'][$tournament_player_num-1]['player2_belonging_to_name'].')' );
        } else if( $tournament_data['data'][0]['match'][$tournament_player_num-1]['winner'] == 2 ){
            $sheet->setCellValue( 'R94', $tournament_data['data'][0]['match'][$tournament_player_num-1]['player1_name'].'('.$tournament_data['data'][0]['match'][$tournament_player_num-1]['player1_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][1]['match'][0]['winner'] == 1 ){
            $sheet->setCellValue( 'A98', $tournament_data['data'][1]['match'][0]['player1_name'].'('.$tournament_data['data'][1]['match'][0]['player1_belonging_to_name'].')' );
        } else if( $tournament_data['data'][1]['match'][0]['winner'] == 2 ){
            $sheet->setCellValue( 'A98', $tournament_data['data'][1]['match'][0]['player2_name'].'('.$tournament_data['data'][1]['match'][0]['player2_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][1]['match'][0]['winner'] == 1 ){
            $sheet->setCellValue( 'F98', $tournament_data['data'][1]['match'][0]['player2_name'].'('.$tournament_data['data'][1]['match'][0]['player2_belonging_to_name'].')' );
        } else if( $tournament_data['data'][1]['match'][0]['winner'] == 2 ){
            $sheet->setCellValue( 'F98', $tournament_data['data'][1]['match'][0]['player1_name'].'('.$tournament_data['data'][1]['match'][0]['player1_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][1]['match'][3]['winner'] == 1 ){
            $sheet->setCellValue( 'L98', $tournament_data['data'][1]['match'][3]['player1_name'].'('.$tournament_data['data'][1]['match'][3]['player1_belonging_to_name'].')' );
        } else if( $tournament_data['data'][1]['match'][3]['winner'] == 2 ){
            $sheet->setCellValue( 'L98', $tournament_data['data'][1]['match'][3]['player2_name'].'('.$tournament_data['data'][1]['match'][3]['player2_belonging_to_name'].')' );
        }
        if( $tournament_data['data'][1]['match'][3]['winner'] == 1 ){
            $sheet->setCellValue( 'R98', $tournament_data['data'][1]['match'][3]['player2_name'].'('.$tournament_data['data'][1]['match'][3]['player2_belonging_to_name'].')' );
        } else if( $tournament_data['data'][1]['match'][3]['winner'] == 2 ){
            $sheet->setCellValue( 'R98', $tournament_data['data'][1]['match'][3]['player1_name'].'('.$tournament_data['data'][1]['match'][3]['player1_belonging_to_name'].')' );
        }

        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
	}

	function output_tournament_72_for_excel( $objPage, $series_info, $tournament_data, $entry_list )
	{
		return __output_tournament_72_73_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_73_for_excel( $objPage, $series_info, $tournament_data, $entry_list )
	{
		return __output_tournament_72_73_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_72( $objPage, $path, $tournament_list, $entry_list, $mv )
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

	function __output_tournament_72_73_for_HTML( $path, $tournament_data, $entry_list, $mv )
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
			$table_cell_width = 26;
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
			. '<h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>'."\n"
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
			$pref = $tournament_data['data'][0]['player'][$tournament_team]['school_name_ryaku'];
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

	function output_tournament_72_for_HTML( $path, $tournament_data, $entry_list )
	{
		//__output_tournament_72_73_for_HTML( $path, $tournament_data, $entry_list, 'm' );
        $objPage = new form_page();
        $objTournament = new form_page_kojin_tournament( $objPage );
        $cssparam = [
			'table_name_rowspan' => 3,
			'table_name_name_width' => 100,
			'table_name_name_font_size' => 11,
			'table_name_name_font_size2' => 9,
			'table_name_pref_width' => 88,
			'table_height' => 11,
			'table_font_size' => 11,
			'table_place_font_size' => 6,
			'table_cell_width' => 30,
			'return_path' => 'index.html',
        ];
        $objTournament->output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, 'm', $cssparam );
	}

	function output_tournament_73_for_HTML( $path, $tournament_data, $entry_list )
	{
		//__output_tournament_72_73_for_HTML( $path, $tournament_data, $entry_list, 'w' );
        $objPage = new form_page();
        $objTournament = new form_page_kojin_tournament( $objPage );
        $cssparam = [
			'table_name_rowspan' => 3,
			'table_name_name_width' => 100,
			'table_name_name_font_size' => 11,
			'table_name_name_font_size2' => 9,
			'table_name_pref_width' => 88,
			'table_height' => 11,
			'table_font_size' => 11,
			'table_place_font_size' => 6,
			'table_cell_width' => 32,
			'return_path' => 'index.html',
        ];
        $objTournament->output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, 'w', $cssparam );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel_72_73( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
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
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			if( $fields['insotu2_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			if( $fields['insotu3_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_kana_sei'].' '.$fields['insotu3_kana_mei'] );

			for( $player = 1; $player <= 3; $player++ ){
				if( $player < 3 ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_yosen_'.$series_mw.$player] );
				}
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_'.$series_mw.$player.'_sei'].' '.$fields['kojin_'.$series_mw.$player.'_mei'] );
				if( $fields['kojin_'.$series_mw.$player.'_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_'.$series_mw.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_kana_'.$series_mw.$player.'_sei'].' '.$fields['kojin_kana_'.$series_mw.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['kojin_gakunen_dan_'.$series_mw.$player.'_gakunen']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_gakunen_dan_'.$series_mw.$player.'_dan'] );
			}
			$pos++;
		}
		db_close( $dbs );
		return $pos;
	}

	function output_entry_data_list_all_1_excel_72( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel72_73( $sheet, 72, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel72_73( $sheet, 73, 'w', $pos, '個人戦女子' );
		return true;
	}

	function output_entry_data_list_all_1_excel_73( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel_72_73( $sheet, 72, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel_72_73( $sheet, 73, 'w', $pos, '個人戦女子' );
		return true;
	}

	//--------------------------------------------------------------

	function __output_entry_data_list_all_2_excel_72_73( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
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
				if( $player <= 2 && intval($fields['kojin_yosen_'.$series_mw.$player]) == 0 ){
					continue;
				}
				if( $fields['kojin_'.$series_mw.$player.'_sei'] == '' ){
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
					$sheet->setCellValueByColumnAndRow( $col, $pos, $fields['kojin_yosen_'.$series_mw.$player] );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_'.$series_mw.$player.'_sei'].' '.$fields['kojin_'.$series_mw.$player.'_mei'] );
				if( $fields['kojin_'.$series_mw.$player.'_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_'.$series_mw.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_kana_'.$series_mw.$player.'_sei'].' '.$fields['kojin_kana_'.$series_mw.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_grade_junior_name( $gradetbl, intval($fields['kojin_gakunen_dan_'.$series_mw.$player.'_gakunen']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kojin_gakunen_dan_'.$series_mw.$player.'_dan'] );
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
			if( $fields['insotu3_sei'] != '' ){
				$sheet->setCellValueByColumnAndRow( 0 , $pos, $id );
				$sheet->setCellValueByColumnAndRow( 1 , $pos, $series_name );
				$sheet->setCellValueByColumnAndRow( 2 , $pos, '外部指導者' );
				$col = 3;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
				if( $fields['insotu3_add'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
				}
				$col++;
				$col++;
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_kana_sei'].' '.$fields['insotu3_kana_mei'] );
				$pos++;
			}
		}
		db_close( $dbs );
		return $pos;
	}

	function output_entry_data_list_all_2_excel_72( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel_72_73( $sheet, 72, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel18_73( $sheet, 73, 'w', $pos, '個人戦女子' );
		return false;
	}

	function output_entry_data_list_all_2_excel_73( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel_72_73( $sheet, 72, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel18_73( $sheet, 73, 'w', $pos, '個人戦女子' );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_72_73( $series, $series_mw )
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
			$lv['school_name'] = get_field_string( $fields, 'player_sei' )
				. ' ' . get_field_string( $fields, 'player_mei' ) 
				. '(' . get_field_string( $fields, 'school_name' ) . ')';
			$ret[] = $lv;
		}
		db_close( $dbs );

		return array_merge( $ret );
	}

	function get_entry_data_list2_72()
	{
		return __get_entry_data_list2_72_73( 72, 'm' );
	}

	function get_entry_data_list2_73()
	{
		return __get_entry_data_list2_72_73( 73, 'w' );
	}

	//--------------------------------------------------------------

	function __get_entry_data_72_73_list_for_PDF( $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array2();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		for( $i1 = 0; $i1 < 48; $i1++ ){
			$data[$i1] = array( 'pref_name'=>'', 'rank'=>array() );
		}
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
			$prefpos = $c->get_pref_order( $pref );
			$lv['pref_name'] = $c->get_pref_name( $preftbl, $pref );
			$lv['school_name'] = get_field_string( $fields, 'school_name' );
			$lv['insotu1_sei'] = get_field_string( $fields, 'insotu1_sei' );
			$lv['insotu1_mei'] = get_field_string( $fields, 'insotu1_mei' );
			$lv['rank'] = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'1', 0 );
			if( $lv['rank'] > 0 ){
				$lv['photo'] = get_field_string( $fields, 'photo_'.$series_mw.'1' );
				$gakunen = get_field_string_number( $fields, 'kojin_gakunen_dan_'.$series_mw.'1_gakunen', 0 );
				$lv['player_gakunen'] = $c->get_grade_junior_name( $gakunentbl, $gakunen );
				$lv['player_dan'] = get_field_string( $fields, 'kojin_gakunen_dan_'.$series_mw.'1_dan' );
				$lv['player_sei'] = get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' );
				$lv['player_mei'] = get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' );
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
			$lv['rank'] = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'2', 0 );
			if( $lv['rank'] > 0 ){
				$lv['photo'] = get_field_string( $fields, 'photo_'.$series_mw.'2' );
				$gakunen = get_field_string_number( $fields, 'kojin_gakunen_dan_'.$series_mw.'2_gakunen', 0 );
				$lv['player_gakunen'] = $c->get_grade_junior_name( $gakunentbl, $gakunen );
				$lv['player_dan'] = get_field_string( $fields, 'kojin_gakunen_dan_'.$series_mw.'2_dan' );
				$lv['player_sei'] = get_field_string( $fields, 'kojin_'.$series_mw.'2_sei' );
				$lv['player_mei'] = get_field_string( $fields, 'kojin_'.$series_mw.'2_mei' );
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

	function get_entry_data_72_list_for_PDF()
	{
		return __get_entry_data_72_73_list_for_PDF( 18, 'm' );
	}

	function get_entry_data_73_list_for_PDF()
	{
		return __get_entry_data_72_73_list_for_PDF( 19, 'w' );
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_72_73( $list, $series, $series_mw )
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

	function get_entry_data_for_draw_csv_72( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_72_73( $list, 18, 'm' ),
			'file' => 'kojin_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_73( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_72_73( $list, 19, 'w' ),
			'file' => 'kojin_w.csv'
		);
	}

	//--------------------------------------------------------------

	//--------------------------------------------------------------

	function __output_realtime_html_for_one_board_72_73( $place, $place_match_no )
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

	function output_realtime_html_for_one_board_72( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_72_73( $place, $place_match_no );
	}

	function output_realtime_html_for_one_board_73( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_72_73( $place, $place_match_no );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_62_72_for_HTML( $navi_info, $league_param, $league_list, $entry_list, $mw )
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
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

        $tindex = 1;
		$html = '';
		$html .= $header . '    <h2>' . $mwstr . '団体リーグ表</h2>'."\n";
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
        $file = $navi_info['result_path'] . '/dl_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_62_for_HTML( $navi_info, $league_param, $league_list, $entry_list )
	{
        $objPage = new form_page();
//print_r($league_list);
        $objPage->output_league_for_HTML( $navi_info, $league_param, $league_list, $entry_list, 'm', false );
		//__output_league_62_72_for_HTML( $path, get_league_parameter_62(), $league_list, $entry_list, 'm' );
	}

	function output_league_72_for_HTML( $navi_info, $league_param, $league_list, $entry_list )
	{
        $objPage = new form_page();
        $objPage->output_league_for_HTML( $navi_info, $league_param, $league_list, $entry_list, 'w', false );
		//__output_league_62_72_for_HTML( $path, get_league_parameter_72(), $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_62_72_for_Excel_one( $objPage, $sheet, $col, $row, $league_param, $league_list, $entry_list, $mv )
	{
//print_r($league_list);
		if( $mv == 'm' ){
			$mvstr = '男子';
		} else {
			$mvstr = '女子';
		}

		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3, $row+$dantai_index_row*2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2+1,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*3, $row+$dantai_index_row*2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(3);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(56);
								$objDrawing->setHeight(56);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*3+1, $row+$dantai_index_row*2+1,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
						}
					}
				}
				$colscore = $col + $league_list[$league_data]['team_num'] * 3 + 3;
				$sheet->setCellValueByColumnAndRow(
					$colscore, $row+$dantai_index_row*2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+2, $row+$dantai_index_row*2+1,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+2, $row+$dantai_index_row*2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+4, $row+$dantai_index_row*2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);
			}
		}
	}

	function __output_league_62_72_for_Excel( $objPage, $series_info, $league_param, $league_list, $entry_list, $mw )
	{
//print_r($league_list);
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

		$file_name = $series_info['reg_year'] . 'allnaganoJuniorDantaiLeagueResults_' . $mw . '.xls';
		$file_path = $series_info['output_path'] . '/' . $file_name;
		$excel = new PHPExcel();
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
        $sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　予選リーグ結果' );

        $border_style = array(
            'borders' => array(
                'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN)
            )
        );
        $border_style2 = array(
            'borders' => array(
                'top'     => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'bottom'  => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'left'    => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'   => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'diagonal' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'diagonaldirection' => PHPExcel_Style_Borders::DIAGONAL_DOWN
            )
        );
        $col = 0;
		$team_num = intval( $league_list[0]['team_num'] );
        for( $i1 = 0; $i1 <= $team_num; $i1++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(2.63+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(4.57+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(2.63+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
        }
        for( $i1 = 0; $i1 < 3; $i1++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(4.57+0.71);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col++))->setWidth(1.14+0.71);
        }

		$col = 0;
		$row = 4;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			$sheet->setCellValueByColumnAndRow(
				$col, $row, $league_list[$league_data]['name']
			);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+4) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			for( $dantai_index_row = 0; $dantai_index_row < $team_num; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*5+5, $row, $ev['school_name'] );
					}
				}
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_row*5+5) . $row;
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_row*5+5+4) . ($row+1);
//echo "1:",$mg_range1,':',$mg_range2,'<br />';
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			}
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5, $row, '勝点' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+4, $row, '総本数' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+4, $row+1, '総勝者数' );
			$sheet->setCellValueByColumnAndRow( $col+$team_num*5+5+6, $row, '順位' );

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+2) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+4);
            $sheet->getStyle($mg_range1.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
            $sheet->getStyle($mg_range1.$row)->getFont()->setSize(8);
            $sheet->getStyle($mg_range1.($row+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1.($row+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $sheet->getStyle($mg_range1.($row+1))->getFont()->setSize(8);
            $sheet->getStyle($mg_range1.$row)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3+2) . ($row+1);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+6) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+6+2) . ($row+1);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+2);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                            $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+3);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/cir.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/tri.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(dirname(__FILE__)).'/squ.png');
								$objDrawing->setWidth(32);
								$objDrawing->setHeight(32);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(0);
								$objDrawing->setOffsetY(8);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*5+7, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+2);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                            $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+7) . ($row+$dantai_index_row*2+3);
                            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
						}
					}
                    $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+5) . ($row+$dantai_index_row*2+2);
                    $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$dantai_index_col*5+5+4) . ($row+$dantai_index_row*2+2+1);
                    if( $dantai_index_col == $dantai_index_row ){
                        $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                        $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style2);
                    } else {
                        $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
                    }
				}
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+2, $ev['school_name'] );
					}
				}
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+4) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

				$colscore = $col + $league_list[$league_data]['team_num'] * 5 + 5;
				$sheet->setCellValueByColumnAndRow(
					$colscore, $row+$dantai_index_row*2+2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+3+1, $row+$dantai_index_row*2+3,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+3+1, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$colscore+6, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+2) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+4) . ($row+$dantai_index_row*2+2);
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                $sheet->getStyle($mg_range1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+4) . ($row+$dantai_index_row*2+3);
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+3) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+3+2) . ($row+$dantai_index_row*2+3);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);

                $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($colscore+6) . ($row+$dantai_index_row*2+2);
                $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($colscore+6+2) . ($row+$dantai_index_row*2+3);
                $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
                $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			}
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+$team_num*5+5+3*3-1) . ($row+$team_num*2+1);
            $sheet->getStyle($mg_range1.':'.$mg_range2)->applyFromArray($border_style);
			$row += ( $team_num + 2 ) * 2;
		}
        for( $i1 = 1; $i1 <= $row; $i1++ ){
            $sheet->getRowDimension($i1)->setRowHeight(18);
        }

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_62_for_Excel( $objPage, $series_info, $league_param, $league_list, $entry_list )
	{
		return __output_league_62_72_for_Excel( $objPage, $series_info, $league_param, $league_list, $entry_list, 'm' );
	}

	function output_league_72_for_Excel( $objPage, $series_info, $league_param, $league_list, $entry_list )
	{
		return __output_league_62_72_for_Excel( $objPage, $series_info, $league_param, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function __output_league_match_for_HTML2_62_72( $objPage, $path, $league_list, $entry_list, $mv )
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
		$header .= '<title>'.$mvstr.'団体リーグ結果</title>'."\n";
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
		$html = $header . '    <h2>' . $mvstr . '団体リーグ結果</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			for( $match_index = 0; $match_index < count( $league_list[$league_data]['match'] ); $match_index++ ){
				$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第'.($match_index+1).'試合</h3>';
				$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][$match_index], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][2], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][1], $entry_list, $mv );
			}
		}
		$html .= $footer;
		$file = $path . '/dlm'.$mv.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_match_for_HTML2_62( $navi_info, $league_param, $league_list, $entry_list )
	{
		//__output_league_match_for_HTML2_62_72( $objPage, $path, $league_list, $entry_list, 'm' );
        $objPage = new form_page();
        $objLeague = new form_page_dantai_league( $objPage );
        $objLeague->output_league_match_for_HTML2( $navi_info, $league_param, $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_HTML2_72( $navi_info, $league_param, $league_list, $entry_list )
	{
		//__output_league_match_for_HTML2_62_72( $objPage, $path, $league_list, $entry_list, 'w' );
        $objPage = new form_page();
        $objLeague = new form_page_dantai_league( $objPage );
        $objLeague->output_league_match_for_HTML2( $navi_info, $league_param, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_league_match_for_excel_62_72( $objPage, $series_info, $league_param, $league_list, $entry_list, $mw )
	{
		if( $mw == 'm' ){
			$mwstr = '男子';
		} else {
			$mwstr = '女子';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';

//print_r($league_list);
//exit;
		$file_name = $series_info['reg_year'] . 'allnaganoJuniorDantaiLeagueMatchResults_'.$mw.'.xls';
		$file_path = $series_info['output_path'] . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/dantaiLeagueMatchResultsBase.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦結果' );

		$col = 0;
		$row = 3;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$sheet->setCellValueByColumnAndRow(
				0, $row, $league_list[$league_data]['name']
			);
            $row++;
			for( $match = 0; $match < $league_list[$league_data]['match_num']; $match++ ){
    			$sheet->setCellValueByColumnAndRow(
	    			0, $row, '第'.($match+1).'試合'
		    	);
                $row++;
                if( $league_data == 0 && $match == 0 ){
                    $row += 5;
                    continue;
                }
                for( $r = 0; $r < 5; $r++ ) {
                    for( $c = 0; $c < 62; $c++ ){
                        // セルを取得
                        $cell = $sheet->getCellByColumnAndRow($c, $r+5);
                        // セルスタイルを取得
                        $style = $sheet->getStyleByColumnAndRow($c, $r+5);
                        // 数値から列文字列に変換する (0,1) → A1
                        $offsetCell = PHPExcel_Cell::stringFromColumnIndex($c) . (string)($row + $r);
                        // セル値をコピー
                        $sheet->setCellValue($offsetCell, $cell->getValue());
                        // スタイルをコピー
                        $sheet->duplicateStyle($style, $offsetCell);

                        $mg_range = 'B' . $row . ":E" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'F' . $row . ":I" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'J' . $row . ":M" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . $row . ":Q" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . $row . ":U" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'V' . $row . ":Y" . $row;
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Z' . $row . ":AB" . $row;
                        $sheet->mergeCells( $mg_range );

                        $mg_range = 'A' . ($row+1) . ":A" . ($row+2); 
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'B' . ($row+1) . ":E" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'F' . ($row+1) . ":I" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'J' . ($row+1) . ":M" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . ($row+1) . ":Q" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+1) . ":U" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'V' . ($row+1) . ":V" . ($row+2);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'W' . ($row+1) . ":X" . ($row+1);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Y' . ($row+1) . ":Y" . ($row+2);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Z' . ($row+1) . ":AB" . ($row+1);
                        $sheet->mergeCells( $mg_range );

                        $mg_range = 'E' . ($row+2) . ":E" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'I' . ($row+2) . ":I" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'M' . ($row+2) . ":M" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Q' . ($row+2) . ":Q" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'U' . ($row+2) . ":U" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'W' . ($row+2) . ":X" . ($row+2);
                        $sheet->mergeCells( $mg_range );

                        $mg_range = 'A' . ($row+3) . ":A" . ($row+4); 
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'V' . ($row+3) . ":V" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'W' . ($row+3) . ":X" . ($row+3);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Y' . ($row+3) . ":Y" . ($row+4);
                        $sheet->mergeCells( $mg_range );

                        $mg_range = 'B' . ($row+4) . ":E" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'F' . ($row+4) . ":I" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'J' . ($row+4) . ":M" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'N' . ($row+4) . ":Q" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'R' . ($row+4) . ":U" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'W' . ($row+4) . ":X" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                        $mg_range = 'Z' . ($row+4) . ":AB" . ($row+4);
                        $sheet->mergeCells( $mg_range );
                    }
                }
                $row += 5;
            }
        }
        for( $i1 = 1; $i1 <= $row; $i1++ ){
            $sheet->getRowDimension($i1)->setRowHeight(18.8);
        }

		$col = 0;
		$row = 3;
		$colStr = 'Q';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$sheet->setCellValueByColumnAndRow(
				0, $row, $league_list[$league_data]['name']
			);
            $row++;
			for( $match = 0; $match < $league_list[$league_data]['match_num']; $match++ ){
    			$sheet->setCellValueByColumnAndRow(
	    			0, $row, '第'.($match+1).'試合'
		    	);
				$row += 2;
				$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][$league_param['place_match_info'][$match]], $entry_list, $mv, 46, 46 );
				$row += 4;
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_match_for_excel_62( $objPage, $series_info, $league_param, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_62_72( $objPage, $series_info, $league_param, $league_list, $entry_list, 'm' );
	}

	function output_league_match_for_excel_72( $objPage, $series_info, $league_param, $league_list, $entry_list )
	{
		return __output_league_match_for_excel_62_72( $objPage, $series_info, $league_param, $league_list, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_chart_72_73_for_HTML( $tournament_data, $entry_list )
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

	function output_tournament_chart_72_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_72_73_for_HTML( $tournament_data, $entry_list );
	}

	function output_tournament_chart_73_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_72_73_for_HTML( $tournament_data, $entry_list );
	}

	//--------------------------------------------------------------
?>
