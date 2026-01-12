<?php

	function __get_tournament_parameter_9_10()
	{
		$param = array(
			'mw' => 'w',
			'team_num' => 16,
			'match_num' => 15,
			'match_info' => array( array( 0, 1 ), array( 1, 2 ), array( 2, 0 ) ),
			'match_level' => 4,
			'place_num' => 8,
			'place_group_num' => 2,
			'place_match_info' => array( array( 1, 3, 5 ), array( 2, 4, 6 ) ),
			'group_num' => 16
		);
		return $param;
	}

	function get_tournament_parameter_9()
	{
		__get_tournament_parameter_9_10();
	}

	function get_tournament_parameter_10()
	{
		__get_tournament_parameter_9_10();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_9_10_for_excel( $objPage, $series_info, $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
//exit;

		if( $mv == 'm' ){
			$mvstr = '男子';
            $templete = 'kojinTounamentResultsBase9_';
		} else {
			$mvstr = '女子';
            $templete = 'kojinTounamentResultsBase10_';
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
		$file_name = 'kojinTournamentResults_' . $mv . '_' . $ftime . '.xlsx';
		$file_path = $series_info['output_path'] . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(dirname(dirname(__FILE__))).'/templates/excel/'.$templete.$series_info['reg_year'].'.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		$sheet->setCellValue( 'AO6', $mvstr.' 個人戦 結果' );

		$col = 0;
		$row = 5;
		$colStr = 'Q';

		$row = 3;
		$col1 = 'E';
		$col2 = 'D';
		$col3 = 'C';
		$player = 0;
		for( $i1 = 0; $i1 < 16; $i1++ ){
			if( $i1 == 8 ){
				$row = 3;
				$col1 = 'CX';
				$col2 = 'CW';
				$col3 = 'CV';
			}
            if( $tournament_data['data'][0]['player'][$player]['info'] != 0 ){
    			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
                if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                    $sheet->getStyle($col1.$row)->getFont()->setSize(20);
                }
	    		$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
		    	$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
            }
			$player++;
            if( $tournament_data['data'][0]['player'][$player]['info'] != 0 ){
    			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
                if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                    $sheet->getStyle($col1.$row)->getFont()->setSize(20);
                }
	    		$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
		    	$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
            }
			$row += 4;
			$player++;
			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
            if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                $sheet->getStyle($col1.$row)->getFont()->setSize(20);
            }
			$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
			$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
			$row += 4;
			$player++;
			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
            if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                $sheet->getStyle($col1.$row)->getFont()->setSize(20);
            }
			$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
			$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
			$row += 6;
			$player++;
			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
            if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                $sheet->getStyle($col1.$row)->getFont()->setSize(20);
            }
			$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
			$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
			$row += 4;
			$player++;
			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
            if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                $sheet->getStyle($col1.$row)->getFont()->setSize(20);
            }
			$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
			$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
			$row += 4;
			$player++;
            if( $tournament_data['data'][0]['player'][$player]['info'] != 0 ){
    			$sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
                if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                    $sheet->getStyle($col1.$row)->getFont()->setSize(20);
                }
	    		$sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
		    	$sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
            }
			$player++;
            if( $tournament_data['data'][0]['player'][$player]['info'] != 0 ){
			    $sheet->setCellValue( $col1.$row, $tournament_data['data'][0]['player'][$player]['pref_name'] );
                if( mb_strlen( $tournament_data['data'][0]['player'][$player]['pref_name'] ) > 3 ){
                    $sheet->getStyle($col1.$row)->getFont()->setSize(20);
                }
			    $sheet->setCellValue( $col2.$row, $tournament_data['data'][0]['player'][$player]['school_name_ryaku'] );
			    $sheet->setCellValue( $col3.$row, $tournament_data['data'][0]['player'][$player]['sei'].' '.$tournament_data['data'][0]['player'][$player]['mei'] );
            }
			$row += 6;
			$player++;
		}

		$styleArrayH = array(
			'borders' => array(
				'top' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('argb' => 'FFFF0000')
				)
			)
		);
		$styleArrayV = array(
			'borders' => array(
				'right' => array(
					'style' => PHPExcel_Style_Border::BORDER_THICK,
					'color' => array('argb' => 'FFFF0000')
				)
			)
		);
		$chartRow = array(
			1 => array(
				'match_top' => 63, 'match_num' => 32, 'match_num2' => 16, 'vwin' => array( 2, 0 ),
				'l' => array(
					'hstart' => 'G', 'hend' => 'K', 'hwin' => array('I','J','K'), 'v' => 'K', 'extra' => 'J'
				),
				'r' => array(
					'hstart' => 'CP', 'hend' => 'CT', 'hwin' => array('CP','CQ','CR'), 'v' => 'CO', 'extra' => 'GP'
				),
				'y' => array(
						array(9,13),array(19,23),array(37,41), array(47,51),
						array(65,69),array(75,79),array(93,97), array(103,107),
						array(121,125),array(131,135),array(149,153),array(159,163),
						array(177,181),array(187,191),array(205,209),array(215,219),
						array(9,13),array(19,23),array(37,41), array(47,51),
						array(65,69),array(75,79),array(93,97), array(103,107),
						array(121,125),array(131,135),array(149,153),array(159,163),
						array(177,181),array(187,191),array(205,209),array(215,219)
					)
			),
			2 => array(
				'match_top' => 31, 'match_num' => 32, 'match_num2' => 16, 'vwin' => array( 2, 0 ),
				'l' => array(
					'hstart' => 'L', 'hend' => 'Q', 'hwin' => array('O','P','Q'), 'v' => 'Q', 'extra' => 'P'
				),
				'r' => array(
					'hstart' => 'CJ', 'hend' => 'CO', 'hwin' => array('CJ','CK','CL'), 'v' => 'CI', 'extra' => 'CJ'
				),
				'y' => array(
					array(5,11,7),array(21,27,23),array(33,39,35), array(49,55,51),
					array(61,67,63),array(77,83,79),array(89,95,91), array(105,111,107),
					array(117,123,119),array(133,139,135),array(145,151,147), array(161,167,163),
					array(173,179,175),array(189,195,191),array(201,207,203), array(217,223,219),
					array(5,11,7),array(21,27,23),array(33,39,35), array(49,55,51),
					array(61,67,63),array(77,83,79),array(89,95,91), array(105,111,107),
					array(117,123,119),array(133,139,135),array(145,151,147), array(161,167,163),
					array(173,179,175),array(189,195,191),array(201,207,203), array(217,223,219)
				)
			),
			3 => array(
				'match_top' => 15, 'match_num' => 16, 'match_num2' => 8, 'vwin' => array( 2, 0 ),
				'l' => array(
					'hstart' => 'R', 'hend' => 'W', 'hwin' => array('U','V','W'), 'v' => 'W', 'extra' => 'V'
				),
				'r' => array(
					'hstart' => 'CD', 'hend' => 'CI', 'hwin' => array('CD','CE','CF'), 'v' => 'CC', 'extra' => 'CD'
				),
				'y' => array(
					array(8,24,15),array(36,52,43),array(64,80,71), array(92,108,99),
					array(120,136,127),array(148,164,155),array(176,192,183), array(204,220,211),
					array(8,24,14),array(36,52,42),array(64,80,70), array(92,108,98),
					array(120,136,126),array(148,164,154),array(176,192,182), array(204,220,210)
				)
			),
			4 => array(
				'match_top' => 7, 'match_num' => 8, 'match_num2' => 4, 'vwin' => array( 3, 0 ),
				'l' => array(
					'hstart' => 'X', 'hend' => 'AC', 'hwin' => array('AA','AB','AC'), 'v' => 'AC',
					'hstart2' => 'AD', 'hend2' => 'AF', 'extra' => 'AB'
				),
				'r' => array(
					'hstart' => 'BX', 'hend' => 'CC', 'hwin' => array('BX','BY','BZ'), 'v' => 'BW',
					'hstart2' => 'BU', 'hend2' => 'BW', 'extra' => 'BX'
				),
				'y' => array(
					array(17,44,29),array(73,100,85),array(129,156,141), array(185,212,197),
					array(16,44,28),array(72,100,84),array(128,156,140), array(184,212,196)
				)
			),
			5 => array(
				'match_top' => 3, 'match_num' => 4, 'match_num2' => 2, 'vwin' => array( 3, 0 ),
				'l' => array(
					'hstart' => 'AD', 'hend' => 'AJ',
					'hstart1' => 'AD', 'hend1' => 'AF', 'hstart2' => 'AI', 
					'hend2' => 'AJ', 'hwin' => array('AI','AJ','AK'), 'v' => 'AJ', 'extra' => 'AI'
				),
				'r' => array(
					'hstart' => 'BQ', 'hend' => 'BW',
					'hstart1' => 'BU', 'hend1' => 'BW', 'hstart2' => 'BQ',
					'hend2' => 'BR', 'hwin' => array('BP','BQ','BR'), 'v' => 'BP', 'extra' => 'BQ'
				),
				'y' => array(
					array(31,86,56),array(142,198,168),
					array(30,86,56),array(142,198,168)
				)
			),
			6 => array(
				'match_top' => 1, 'match_num' => 2, 'match_num2' => 1, 'vwin' => array( 3, 0 ),
				'l' => array(
					'hstart' => 'AK', 'hend' => 'AQ',
					'hstart1' => 'AK', 'hend1' => 'AL', 'hstart2' => 'AO',
					'hend2' => 'AQ', 'hwin' => array('AO','AP','AQ'), 'v' => 'AQ', 'extra' => 'AP'
				),
				'r' => array(
					'hstart' => 'BJ', 'hend' => 'BP',
					'hstart1' => 'BO', 'hend1' => 'BP', 'hstart2' => 'BJ',
					'hend2' => 'BL', 'hwin' => array('BJ','BK','BL'), 'v' => 'BI', 'extra' => 'BJ'
				),
				'y' => array(
					array(58,170,115),
					array(58,170,115)
				)
			),
			7 => array(
				'match_top' => 0, 'match_num' => 1, 'match_num2' => 1, 'name' => 'AZ45', 'vwin' => array( 2, 0 ),
				'l' => array(
					'hstart' => 'AR', 'hend' => 'AZ', 'hwin' => array('AW','AX','AY'), 'v' => 'AZ', 'extra' => 'AZ'
				),
				'r' => array(
					'hstart' => 'BA', 'hend' => 'BI', 'hwin' => array('BB','BC','BD'), 'v' => 'AZ', 'extra' => 'AZ'
				),
				'y' => array(
					array(116,116)
				)
			)
		);

		$chartRow_ofs = 'l';
		$match_no = $chartRow[1]['match_top'];
		for( $match_ofs = 0; $match_ofs < $chartRow[1]['match_num']; $match_ofs++ ){
			if( $match_ofs == $chartRow[1]['match_num2'] ){
				$chartRow_ofs = 'r';
			}
			if( ( $match_ofs % 2 ) == 0 ){
				$match_no++;
				$vmid = $chartRow[2]['y'][$match_ofs][1];
			} else {
				$vmid = $chartRow[2]['y'][$match_ofs][0];
			}
			$winstr = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][$match_no] );
			for( $wi = 0; $wi < 3; $wi++ ){
				$sheet->setCellValue(
					$chartRow[1][$chartRow_ofs]['hwin'][$wi].($chartRow[1]['y'][$match_ofs][0]-$chartRow[1]['vwin'][0]),
					$winstr[1][$wi]
				);
			}
			if( $tournament_data['data'][0]['match'][$match_no]['winner'] == 1 ){
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[1]['y'][$match_ofs][0]
					.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[1]['y'][$match_ofs][0]
				)->applyFromArray( $styleArrayH );
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['v'].$chartRow[1]['y'][$match_ofs][0]
					.':'.$chartRow[1][$chartRow_ofs]['v'].($vmid-1)
				)->applyFromArray( $styleArrayV );
			}
			if( $tournament_data['data'][0]['match'][$match_no]['winner'] == 2 ){
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[1]['y'][$match_ofs][1]
					.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[1]['y'][$match_ofs][1]
				)->applyFromArray( $styleArrayH );
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['v'].$vmid
					.':'.$chartRow[1][$chartRow_ofs]['v'].($chartRow[1]['y'][$match_ofs][1]-1)
				)->applyFromArray( $styleArrayV );
			}
			for( $wi = 0; $wi < 3; $wi++ ){
				$sheet->setCellValue(
					$chartRow[1][$chartRow_ofs]['hwin'][$wi].($chartRow[1]['y'][$match_ofs][1]+$chartRow[1]['vwin'][1]),
					$winstr[2][$wi]
				);
			}
//print_r($tournament_data['data'][0]['match'][$match_no]);
			if( $tournament_data['data'][0]['match'][$match_no]['extra'] == 1 ){
				$sheet->setCellValue(
					$chartRow[1][$chartRow_ofs]['extra'].($chartRow[1]['y'][$match_ofs][0]+1),
					'延'
				);
			}
			$match_no++;
			if( ( $match_ofs % 2 ) == 1 ){
				$match_no++;
			}
		}
//exit;
		for( $level = 2; $level <= 6; $level++ ){
			$chartRow_ofs = 'l';
			$match_no = $chartRow[$level]['match_top'];
			for( $match_ofs = 0; $match_ofs < $chartRow[$level]['match_num']; $match_ofs++ ){
				if( $match_ofs == $chartRow[$level]['match_num2'] ){
					$chartRow_ofs = 'r';
				}
				$vmid = $chartRow[$level+1]['y'][intval($match_ofs/2)][$match_ofs%2];
				$winstr = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][$match_no] );
				for( $wi = 0; $wi < 3; $wi++ ){
					$sheet->setCellValue(
						$chartRow[$level][$chartRow_ofs]['hwin'][$wi].($chartRow[$level]['y'][$match_ofs][0]-$chartRow[$level]['vwin'][0]),
						$winstr[1][$wi]
					);
				}
				if( $tournament_data['data'][0]['match'][$match_no]['winner'] == 1 ){
					if( $level == 2 && ( $match_ofs % 2 ) == 0 ){
						if( $chartRow_ofs == 'l' ){
							$sheet->getStyle(
								$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[2]['y'][$match_ofs][0]
								.':'.$chartRow[2][$chartRow_ofs]['hend'].$chartRow[2]['y'][$match_ofs][0]
							)->applyFromArray( $styleArrayH );
						} else {
							$sheet->getStyle(
								$chartRow[2][$chartRow_ofs]['hstart'].$chartRow[2]['y'][$match_ofs][0]
								.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[2]['y'][$match_ofs][0]
							)->applyFromArray( $styleArrayH );
						}
					} else {
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart'].$chartRow[$level]['y'][$match_ofs][0]
							.':'.$chartRow[$level][$chartRow_ofs]['hend'].$chartRow[$level]['y'][$match_ofs][0]
						)->applyFromArray( $styleArrayH );
					}
					if( $level != 2 || ( $match_ofs % 2 ) == 0 ){
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart'].$chartRow[$level]['y'][$match_ofs][1]
							.':'.$chartRow[$level][$chartRow_ofs]['hend'].$chartRow[$level]['y'][$match_ofs][1]
						)->applyFromArray( $styleArrayH );
					}
					$sheet->getStyle(
						$chartRow[$level][$chartRow_ofs]['v'].$chartRow[$level]['y'][$match_ofs][0]
						.':'.$chartRow[$level][$chartRow_ofs]['v'].($vmid-1)
					)->applyFromArray( $styleArrayV );
					if( $level == 4 ){
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart2'].$vmid
							.':'.$chartRow[$level][$chartRow_ofs]['hend2'].$vmid
						)->applyFromArray( $styleArrayH );
					}
				}
				if( $tournament_data['data'][0]['match'][$match_no]['winner'] == 2 ){
					if( $level == 2 && ( $match_ofs % 2 ) == 1 ){
						if( $chartRow_ofs == 'l' ){
							$sheet->getStyle(
								$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[2]['y'][$match_ofs][1]
								.':'.$chartRow[2][$chartRow_ofs]['hend'].$chartRow[2]['y'][$match_ofs][1]
							)->applyFromArray( $styleArrayH );
						} else {
							$sheet->getStyle(
								$chartRow[2][$chartRow_ofs]['hstart'].$chartRow[2]['y'][$match_ofs][1]
								.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[2]['y'][$match_ofs][1]
							)->applyFromArray( $styleArrayH );
						}
					} else {
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart'].$chartRow[$level]['y'][$match_ofs][1]
							.':'.$chartRow[$level][$chartRow_ofs]['hend'].$chartRow[$level]['y'][$match_ofs][1]
						)->applyFromArray( $styleArrayH );
					}
					if( $level != 2 || ( $match_ofs % 2 ) == 1 ){
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart'].$chartRow[$level]['y'][$match_ofs][0]
							.':'.$chartRow[$level][$chartRow_ofs]['hend'].$chartRow[$level]['y'][$match_ofs][0]
						)->applyFromArray( $styleArrayH );
					}
					$sheet->getStyle(
						$chartRow[$level][$chartRow_ofs]['v'].$vmid
						.':'.$chartRow[$level][$chartRow_ofs]['v'].($chartRow[$level]['y'][$match_ofs][1]-1)
					)->applyFromArray( $styleArrayV );
					if( $level == 4 ){
						$sheet->getStyle(
							$chartRow[$level][$chartRow_ofs]['hstart2'].$vmid
							.':'.$chartRow[$level][$chartRow_ofs]['hend2'].$vmid
						)->applyFromArray( $styleArrayH );
					}
				}
				for( $wi = 0; $wi < 3; $wi++ ){
					$sheet->setCellValue(
						$chartRow[$level][$chartRow_ofs]['hwin'][$wi].($chartRow[$level]['y'][$match_ofs][1]+$chartRow[$level]['vwin'][1]),
						$winstr[2][$wi]
					);
				}
				if( $tournament_data['data'][0]['match'][$match_no]['extra'] == 1 ){
					$sheet->setCellValue(
						$chartRow[$level][$chartRow_ofs]['extra'].($chartRow[$level]['y'][$match_ofs][2]),
						'延'
					);
				}
				$match_no++;
			}
		}

		$winstr = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data'][0]['match'][0] );
		$sheet->setCellValue( 'AW116', $winstr[1][0] );
		$sheet->setCellValue( 'AX116', $winstr[1][1] );
		$sheet->setCellValue( 'AY116', $winstr[1][2] );
		if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
			$sheet->getStyle(
				$chartRow[7]['l']['hstart'].$chartRow[7]['y'][0][0]
				.':'.$chartRow[7]['l']['hend'].$chartRow[7]['y'][0][0]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[7]['name'],
				$tournament_data['data'][0]['match'][0]['player1_name']
					. '(' . $tournament_data['data'][0]['match'][0]['player1_school_name_ryaku']
					. '・' . $tournament_data['data'][0]['match'][0]['player1_pref_name'] . ')'
			);
		} else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
			$sheet->getStyle(
				$chartRow[7]['r']['hstart'].$chartRow[7]['y'][0][1]
				.':'.$chartRow[7]['r']['hend'].$chartRow[7]['y'][0][1]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[7]['name'],
				$tournament_data['data'][0]['match'][0]['player2_name']
					. '(' . $tournament_data['data'][0]['match'][0]['player2_school_name_ryaku']
					. '・' . $tournament_data['data'][0]['match'][0]['player2_pref_name'] . ')'
			);
		}
		if( $tournament_data['data'][0]['match'][0]['winner'] != 0 ){
		//	$sheet->setCellValue( 'BB112',$winstr[2] );
			$sheet->getStyle(
				$chartRow[7]['l']['v'].($chartRow[7]['y'][0][0]-6)
				.':'.$chartRow[7]['l']['v'].($chartRow[7]['y'][0][0]-1)
			)->applyFromArray( $styleArrayV );
		}
		$sheet->setCellValue( 'BB116', $winstr[2][0] );
		$sheet->setCellValue( 'BC116', $winstr[2][1] );
		$sheet->setCellValue( 'BD116', $winstr[2][2] );
		if( $tournament_data['data'][0]['match'][0]['extra'] == 1 ){
			$sheet->setCellValue( 'AZ116', '延' );
		}

		$name_match = array(
			array( 'AT88', 'BF88' ), array( 'AM32', 'AM143' ),
			array( 'BM31', 'BM143' ), array( 'AG4', 'AG61' ),
			array( 'AG116', 'AG173' ), array( 'BS4', 'BS61' ),
			array( 'BS116', 'BS173' )
		);

		for( $match = 0; $match <= 6; $match++ ){
			if( $tournament_data['data'][0]['match'][$match]['player1'] != 0 ){
				$sheet->setCellValue(
					$name_match[$match][0],
					$tournament_data['data'][0]['match'][$match]['player1_name']
						. '(' . $tournament_data['data'][0]['match'][$match]['player1_school_name_ryaku']
						. '・' . $tournament_data['data'][0]['match'][$match]['player1_pref_name'] . ')'
				);
			}
			if( $tournament_data['data'][0]['match'][$match]['player2'] != 0 ){
				$sheet->setCellValue(
					$name_match[$match][1],
					$tournament_data['data'][0]['match'][$match]['player2_name']
						. '(' . $tournament_data['data'][0]['match'][$match]['player2_school_name_ryaku']
						. '・' . $tournament_data['data'][0]['match'][$match]['player2_pref_name'] . ')'
				);
			}
		}
		if( $tournament_data['data'][0]['match'][0]['winner'] != 0 ){
			$field = array();
			$match = array();
			if( $tournament_data['data'][0]['match'][0]['winner'] == 1 ){
				$field[0] = 'player1';
				$field[1] = 'player2';
				$match[0] = 0;
				$match[1] = 0;
				$id0 = $tournament_data['data'][0]['match'][0]['player1'];
			} else if( $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
				$id0 = $tournament_data['data'][0]['match'][0]['player2'];
				$field[0] = 'player2';
				$field[1] = 'player1';
				$match[0] = 0;
				$match[1] = 0;
			}
			if( $tournament_data['data'][0]['match'][1]['player1'] == $id0 ){
				$field[2] = 'player2';
				$match[2] = 1;
				$match[3] = 2;
				if( $tournament_data['data'][0]['match'][2]['winner'] == 1 ){
					$field[3] = 'player2';
				} else if( $tournament_data['data'][0]['match'][2]['winner'] == 2 ){
					$field[3] = 'player1';
				}
			} else if( $tournament_data['data'][0]['match'][1]['player2'] == $id0 ){
				$field[2] = 'player1';
				$match[2] = 1;
				$match[3] = 2;
				if( $tournament_data['data'][0]['match'][2]['winner'] == 1 ){
					$field[3] = 'player2';
				} else if( $tournament_data['data'][0]['match'][2]['winner'] == 2 ){
					$field[3] = 'player1';
				}
			} else if( $tournament_data['data'][0]['match'][2]['player1'] == $id0 ){
				$field[2] = 'player2';
				$match[2] = 2;
				$match[3] = 1;
				if( $tournament_data['data'][0]['match'][1]['winner'] == 1 ){
					$field[3] = 'player2';
				} else if( $tournament_data['data'][0]['match'][1]['winner'] == 2 ){
					$field[3] = 'player1';
				}
			} else if( $tournament_data['data'][0]['match'][2]['player2'] == $id0 ){
				$field[2] = 'player1';
				$match[2] = 2;
				$match[3] = 1;
				if( $tournament_data['data'][0]['match'][1]['winner'] == 1 ){
					$field[3] = 'player2';
				} else if( $tournament_data['data'][0]['match'][1]['winner'] == 2 ){
					$field[3] = 'player1';
				}
			}
//print_r($tournament_data);
//print_r($entry_list);
			$school_name = '';
			$id = intval( $tournament_data['data'][0]['match'][0][$field[0]] / 0x100 );
			foreach( $entry_list as $ev ){
				if( $id == intval( $ev['id'] ) ){
					$school_name = $ev['school_name'];
					break;
				}
			}
			$sheet->setCellValue(
				'AV173',
				$tournament_data['data'][0]['match'][0][$field[0].'_name']
					. '(' . $school_name
					. '・' . $tournament_data['data'][0]['match'][0][$field[0].'_pref_name'] . ')'
			);
			$school_name = '';
			$id = intval( $tournament_data['data'][0]['match'][0][$field[1]] / 0x100 );
			foreach( $entry_list as $ev ){
				if( $id == intval( $ev['id'] ) ){
					$school_name = $ev['school_name'];
					break;
				}
			}
			$sheet->setCellValue(
				'AV176',
				$tournament_data['data'][0]['match'][0][$field[1].'_name']
					. '(' . $school_name
					. '・' . $tournament_data['data'][0]['match'][0][$field[1].'_pref_name'] . ')'
			);
			$school_name = '';
			$id = intval( $tournament_data['data'][0]['match'][$match[2]][$field[2]] / 0x100 );
			foreach( $entry_list as $ev ){
				if( $id == intval( $ev['id'] ) ){
					$school_name = $ev['school_name'];
					break;
				}
			}
			$sheet->setCellValue(
				'AV179',
				$tournament_data['data'][0]['match'][$match[2]][$field[2].'_name']
					. '(' . $school_name
					. '・' . $tournament_data['data'][0]['match'][$match[2]][$field[2].'_pref_name'] . ')'
			);
			$school_name = '';
			$id = intval( $tournament_data['data'][0]['match'][$match[3]][$field[3]] / 0x100 );
			foreach( $entry_list as $ev ){
				if( $id == intval( $ev['id'] ) ){
					$school_name = $ev['school_name'];
					break;
				}
			}
			$sheet->setCellValue(
				'AV182',
				$tournament_data['data'][0]['match'][$match[3]][$field[3].'_name']
					. '(' . $school_name
					. '・' . $tournament_data['data'][0]['match'][$match[3]][$field[3].'_pref_name'] . ')'
			);
			//$sheet->setCellValue( 'AU176', $name[1] );
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
//exit;
		return $file_name;
	}

	function output_tournament_9_for_excel( $objPage, $series_info, $tournament_data, $entry_list )
	{
		return __output_tournament_9_10_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_10_for_excel( $objPage, $series_info, $tournament_data, $entry_list )
	{
		return __output_tournament_9_10_for_excel( $objPage, $series_info, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_9( $objPage, $path, $tournament_list, $entry_list, $mv )
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

	function __output_tournament_9_10_for_HTML( $series_info, $tournament_data, $entry_list, $mv )
	{
//echo '<!-- ';
//print_r($tournament_data);
//echo ' -->';
		$c = new common();
        $objPage = new form_page();
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
        $table_win_border_size = '2px';
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
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">個人戦'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
//nl2br( print_r($tournament_data) );
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
			$pref = $tournament_data['data'][0]['player'][$tournament_team]['pref_name'];
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
				$one_match['extra'] = $tournament_data['data'][0]['match'][$match_no-1]['extra'];
				$one_match['fusen'] = $tournament_data['data'][0]['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['data'][0]['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['data'][0]['match'][$match_no-1]['place_match_no'];
				if( $one_match['place'] !== 'no_match' ){ //|| $tournament_data['data'][0]['match'][$match_no-1]['player1'] != 0 ){
					$one_match['team1'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				} else {
					$one_match['team1'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
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
                    }
						$team_pos++;
						$team_index++;
					//}
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
						$one_match['extra'] = $tournament_data['data'][0]['match'][$match_no-1]['extra'];
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
//nl2br(print_r($match_tbl));
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
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'],true );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'],true );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'],true );
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
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'],true );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'],true );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'],true );
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
							if( $level == $tournament_data['data'][0]['match_level']-2 ){
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
							$pdf .= "</td>\n";
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
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_1'],true );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_2'],true );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza1_3'],true );
                    if( $tournament_data['data'][0]['match'][0]['extra'] == 1 ){
                        $pdf .= '&nbsp;延';
                    }
                }
                $pdf .= '</td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament">';
				if( $tournament_data['data'][0]['match'][0]['fusen'] == 1 && $tournament_data['data'][0]['match'][0]['winner'] == 2 ){
					$pdf .= '不戦勝';
				} else {
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_1'],true );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_2'],true );
					$pdf .= $c->get_waza_name( $tournament_data['data'][0]['match'][0]['waza2_3'],true );
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
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'],true );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'],true );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'],true );
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
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'],true );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'],true );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'],true );
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
							$extra = '';
							if( $level == $tournament_data['data'][0]['match_level']-2 ){
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
								if( $line == $trmatch2[$level] && $one_match_tbl['extra'] == 1 ){
									$extra = '<span class="text_extra">延</span>';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2">';
							$pdf .= $extra;
							$pdf .= "</td>\n";
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
if( $line == 400 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '  <br /><br /><br />' . "\n";
		$pdf .=  '  </div>' . "\n";
		$pdf .= "\n";
		$pdf .= '<script>'."\n";
		$pdf .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$pdf .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$pdf .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$pdf .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$pdf .= "\n";
		$pdf .= '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n";
		$pdf .= '  ga(\'send\', \'pageview\');'."\n";
		$pdf .= "\n";
		$pdf .= '</script>'."\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

		$file = 'k' . $mv;
		$path = $series_info['result_path'] . '/' . $file . '.html';
		$fp = fopen( $path, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );

		$data = [
			'mode' => 2,
			'navi' => $series_info['navi_id'],
			'place' => $file,
			'file' => $path,
			'series' => $series_info['result_path_prefix'],
		];
		$objPage->update_realtime_queue( $data );
//echo $pdf;
//exit;
		//return $pdf;
	}

	function output_tournament_9_for_HTML( $series_info, $tournament_data, $entry_list )
	{
		__output_tournament_9_10_for_HTML( $series_info, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_10_for_HTML( $series_info, $tournament_data, $entry_list )
	{
		__output_tournament_9_10_for_HTML( $series_info, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel9_10( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `entry_info`.`del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year']
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
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_college'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $c->get_pref_name( $preftbl, intval($fields['insotu1_org_pref']) ) );
			$yaku = intval($fields['insotu1_position']);
			if($yaku == 1){
				$yaku = '当校校長';
			} else if($yaku == 2){
				$yaku = '当校教員';
			} else if($yaku == 3){
				$yaku = '部活動指導員';
			} else if($yaku == 4){
				$yaku = '外部指導者(コーチ)';
			} else if($yaku == 5){
				$yaku = '地域スポーツ団体等（地域クラブ活動）指導者';
			} else {
				$yaku = '';
			}
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $yaku );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			if( $fields['insotu2_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
			$yaku = intval($fields['insotu2_position']);
			if($yaku == 1){
				$yaku = '当校校長';
			} else if($yaku == 2){
				$yaku = '当校教員';
			} else if($yaku == 3){
				$yaku = '部活動指導員';
			} else if($yaku == 4){
				$yaku = '外部指導者(コーチ)';
			} else if($yaku == 5){
				$yaku = '地域スポーツ団体等（地域クラブ活動）指導者';
			} else {
				$yaku = '';
			}
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $yaku );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			if( $fields['insotu3_add'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, 'あり' );
			}
			$col++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_kana_sei'].' '.$fields['insotu3_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['reserve_catalog'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['traffic'] );

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

	function output_entry_data_list_all_1_excel9( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel9_10( $sheet, 9, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel9_10( $sheet, 10, 'w', $pos, '個人戦女子' );
		return true;
	}

	function output_entry_data_list_all_1_excel10( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel9_10( $sheet, 9, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel9_10( $sheet, 10, 'w', $pos, '個人戦女子' );
		return true;
	}

	//--------------------------------------------------------------

	function __output_entry_data_list_all_2_excel9_10( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year']
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

	function output_entry_data_list_all_2_excel9( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel9_10( $sheet, 9, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel9_10( $sheet, 10, 'w', $pos, '個人戦女子' );
		return false;
	}

	function output_entry_data_list_all_2_excel10( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel9_10( $sheet, 9, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel9_10( $sheet, 10, 'w', $pos, '個人戦女子' );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_9_10( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$sql = 'select * from `entry_field` where `field` in (\'school_name\',\'join\') and `year`='.$_SESSION['auth']['year'];
		$field_list = db_query_list( $dbs, $sql );

		$ret1 = array();
		$ret2 = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$lv['join'] = 0;
			$lv['school_name'] = '';
			foreach( $field_list as $fv ){
				$info = intval( $fv['info'] );
				if( $id == $info ){
					if( $fv['field'] == 'school_name' ){
						$lv['school_name'] = $fv['data'];
					} else if( $fv['field'] == 'join' ){
						$lv['join'] = intval( $fv['data'] );
					}
				}
			}
/*
if( $lv['school_name'] == '' ){
	$sql = 'select `id` from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'].' and `field`=\'join\'';
	$list = db_query_list( $dbs, $sql );
	if( count($list) > 0 ){
		$sql = 'update `entry_field` set `data`=\'0\' where `info`='.$id.' and `field`=\'join\'';
echo $sql,";<br />\n";

//		db_query( $dbs, $sql );
	} else {
		$sql = 'insert into `entry_field` set `info`='.$id.',`year`='.$_SESSION['auth']['year'].',`field`=\'join\',`data`=\'0\'';

echo $sql,";<br />\n";

//		db_query( $dbs, $sql );
	}
}
*/
			if( $lv['join'] == 1 ){
				$ret1[] = $lv;
			} else {
				$ret2[] = $lv;
			}
		}
		db_close( $dbs );

		return array_merge( $ret1, $ret2 );
	}

	function get_entry_data_list2_9()
	{
		return __get_entry_data_list2_9_10( 9 );
	}

	function get_entry_data_list2_10()
	{
		return __get_entry_data_list2_9_10( 10 );
	}

	//--------------------------------------------------------------

	function __get_entry_data_9_10_list_for_PDF( $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array2();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year']
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
			if( $lv['school_name'] == '' ){ continue; }
			$lv['insotu1_sei'] = get_field_string( $fields, 'insotu1_sei' );
			$lv['insotu1_mei'] = get_field_string( $fields, 'insotu1_mei' );
			$lv['rank'] = get_field_string_number( $fields, 'player1_yosen', 0 );
			if( $lv['rank'] > 0 ){
				$lv['photo'] = get_field_string( $fields, 'player1_photo' );
				$gakunen = get_field_string_number( $fields, 'player1_gakunen', 0 );
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
				$gakunen = get_field_string_number( $fields, 'player2_gakunen', 0 );
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

	function get_entry_data_9_list_for_PDF()
	{
		return __get_entry_data_9_10_list_for_PDF( 9, 'm' );
	}

	function get_entry_data_10_list_for_PDF()
	{
		return __get_entry_data_9_10_list_for_PDF( 10, 'w' );
	}

	function __get_entry_data_9_10_list_for_ID_PDF( $series )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$data = [];
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series
			.' and `year`='.$_SESSION['auth']['year']
			. ' and `disp_order`<=96'
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

	function __get_entry_data_9_10_for_ID_PDF( $list )
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
					$image = dirname(dirname(dirname(__FILE__))) . '/upload/trim/' . $lv[$pfield.'_photo'] . '_01.jpg';
					if( !file_exists($image) ){
						$image = dirname(dirname(dirname(__FILE__))) . '/upload/' . $lv[$pfield.'_photo'] . '_01.jpg';
					}
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

	function get_entry_data_9_for_catalog_PDF($objPage)
	{
		$list = __get_entry_data_9_10_list_for_PDF( 9, 'm' );
		$template = 'catalog_9';
		$fname = 'catalog_個人男子.' . date('YmdHis') . sprintf("%04d",microtime()*1000) . '.pdf';
		$objPage->fetch_template_for_pdf( $list, $template, $fname );
		return $fname;
	}

	function get_entry_data_10_for_catalog_PDF($objPage)
	{
		$list = __get_entry_data_9_10_list_for_PDF( 10, 'w' );
		$template = 'catalog_10';
		$fname = 'catalog_個人女子.' . date('YmdHis') . sprintf("%04d",microtime()*1000) . '.pdf';
		$objPage->fetch_template_for_pdf( $list, $template, $fname );
		return $fname;
	}

	function get_entry_data_9_for_ID_PDF($objPage)
	{
		$list = __get_entry_data_9_10_list_for_ID_PDF( 9 );
		$iddata = __get_entry_data_9_10_for_ID_PDF( $list );
		$edata = [
			[
				'template' => 'excel/ID_9_player.2024.pdf',
				'data' => $iddata['player'],
			],[
				'template' => 'excel/ID_9_player2.2024.pdf',
				'data' => $iddata['player2'],
			],[
				'template' => 'excel/ID_9_insotu.2024.pdf',
				'data' => $iddata['insotu'],
			],
		];
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
		$fname = 'IDカード_個人男子.' . $ftime . '.pdf';
		$path = $objPage->embed_data_for_PDF( $edata, $fname );
		return $fname;
	}

	function get_entry_data_10_for_ID_PDF($objPage)
	{
		$list = __get_entry_data_9_10_list_for_ID_PDF( 10 );
		$iddata = __get_entry_data_9_10_for_ID_PDF( $list );
		$edata = [
			[
				'template' => 'excel/ID_10_player.2024.pdf',
				'data' => $iddata['player'],
			],[
				'template' => 'excel/ID_10_player2.2024.pdf',
				'data' => $iddata['player2'],
			],[
				'template' => 'excel/ID_10_insotu.2024.pdf',
				'data' => $iddata['insotu'],
			],
		];
		$ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
		$fname = 'IDカード_個人女子.' . $ftime . '.pdf';
		$path = $objPage->embed_data_for_PDF( $edata, $fname );
		return $fname;
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_9_10( $list, $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = array();
        $pref = $c->get_kaisai_pref();
        $rank = 3;
		$pref_name = $c->get_pref_name( $preftbl, $pref );
		$area = $c->get_pref_area( $pref );
		for( $i1 = 0; $i1 < 96; $i1++ ){
			$data[$i1]['name'] = $pref_name . $rank . '位';
			$data[$i1]['school_name_ryaku'] = $pref_name . $rank . '位';
			$data[$i1]['pref_name'] = $pref_name;
			$data[$i1]['rank'] = $rank;
			$data[$i1]['area'] = $area;
			$data[$i1]['pref'] = $pref;
			$data[$i1]['id'] = 0;
            $rank++;
            if( $i1 == 1 ){
                $pref = 1;
                $rank = 1;
                $pref_name = $c->get_pref_name( $preftbl, $pref );
                $area = $c->get_pref_area( $pref );
            } else if( $i1 >= 2 && $rank == 3 ){
                $pref++;
                $rank = 1;
                $pref_name = $c->get_pref_name( $preftbl, $pref );
                $area = $c->get_pref_area( $pref );
            }
		}
		foreach( $list as $lv ){
			if( $lv['del'] != 0 ){ continue; }
			if( $lv['join'] == 0 ){ continue; }
			$id = intval( $lv['id'] );
			$sql = 'select * from `entry_field` where `field` in ('
				. '\'school_address_pref\','
				. '\'school_name_ryaku\','
				. '\'player1_yosen\','
				. '\'player1_sei\','
				. '\'player1_mei\','
				. '\'player2_yosen\','
				. '\'player2_sei\','
				. '\'player2_mei\''
				. ') and `info`='.$id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$y1 = intval( $fields['player1_yosen'] );
			$y2 = intval( $fields['player2_yosen'] );
			$pref = intval( $fields['school_address_pref'] );
			$pref_name = $c->get_pref_name( $preftbl, $pref );
			$area = $c->get_pref_area( $pref );
			if( $y1 > 0 ){
				$one = array(
					'school_name_ryaku' => $fields['school_name_ryaku'],
					'name' => $fields['player1_sei'].' '.$fields['player1_mei'],
					'pref' => $pref,
					'pref_name' => $pref_name,
					'area' => $area,
					'rank' => $y1,
					'id' => $id
				);
//print_r($one);
				if( $y1 >= 3 ){
					$data[$y1-3] = $one;
				} else {
					$data[$pref*2+$y1-1] = $one;
				}
			}
			if( $y2 > 0 ){
				$one = array(
					'school_name_ryaku' => $fields['school_name_ryaku'],
					'name' => $fields['player2_sei'].' '.$fields['player2_mei'],
					'pref' => $pref,
					'pref_name' => $pref_name,
					'area' => $area,
					'rank' => $y2,
					'id' => $id
				);
//print_r($one);
				if( $y2 >= 3 ){
					$data[$y2-3] = $one;
				} else {
					$data[$pref*2+$y2-1] = $one;
				}
			}
		}
		db_close( $dbs );
//print_r($data);
//exit;

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

	function get_entry_data_for_draw_csv_9( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_9_10( $list, 9, 'm' ),
			'file' => 'kojin_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_10( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_9_10( $list, 10, 'w' ),
			'file' => 'kojin_w.csv'
		);
	}

	//--------------------------------------------------------------

?>
