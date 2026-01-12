<?php

	function __get_tournament_parameter_14_15()
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

	function get_tournament_parameter_14()
	{
		__get_tournament_parameter_14_15();
	}

	function get_tournament_parameter_15()
	{
		__get_tournament_parameter_14_15();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_14_15_for_excel( $objPage, $path, $tournament_data, $entry_list, $mv )
	{
//print_r($tournament_data);
//exit;

		if( $mv == 'm' ){
			$mvstr = '男子';
			$kmatch = 63;
			$level_num = 6;
		} else {
			$mvstr = '女子';
			$kmatch = 31;
			$level_num = 5;
		}
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/H28shimoinaKojinTounamentResults_'.$mv.'.xlsx';
		$file_name = 'H28shimoinaKojinTounamentResults_' . $mv . '.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/H28shimoinaKojinTounamentResultsBase_'.$mv.'.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValue( 'AO6', $mvstr.' 個人戦 結果' );

		$col = 0;
		$row = 5;
		$colStr = 'Q';

		$row = 3;
		$col1 = 'E';
		$col2 = 'D';
		$col3 = 'C';

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
		if( $mv == 'm' ){
			$chartRow = array(
				0 => array(
					'match_top' => 0, 'match_num' => 1, 'match_num2' => 1, 'name' => 'M41', 'vwin' => array( 2, 0 ),
					'l' => array(
						'hstart' => 'M', 'hend' => 'M', 'hwin' => array('M','M','M'), 'v' => 'L', 'extra' => 'M'
					),
					'r' => array(
						'hstart' => 'P', 'hend' => 'P', 'hwin' => array('P','P','P'), 'v' => 'P', 'extra' => 'P'
					),
					'y' => array(
						array(43,43)
					)
				),
				1 => array(
					'match_top' => 31, 'match_num' => 32, 'match_num2' => 16, 'vwin' => array( 1, 0 ),
					'l' => array(
						'hstart' => 'H', 'hend' => 'H', 'hwin' => array('H','H','H'), 'v' => 'H', 'extra' => 'H'
					),
					'r' => array(
						'hstart' => 'U', 'hend' => 'U', 'hwin' => array('U','U','U'), 'v' => 'T', 'extra' => 'U'
					),
					'y' => array(
							array(6,6),array(8,10),array(12,12), array(14,14),
							array(16,16),array(18,20),array(22,24), array(26,26),
							array(28,28),array(30,32),array(34,34),array(36,36),
							array(38,38),array(40,40),array(42,44),array(46,46),
							array(6,6),array(8,10),array(12,12), array(14,14),
							array(16,16),array(18,18),array(20,22), array(24,24),
							array(26,26),array(28,30),array(32,32),array(34,34),
							array(36,36),array(38,38),array(40,42),array(44,44)
						)
				),
				2 => array(
					'match_top' => 15, 'match_num' => 16, 'match_num2' => 8, 'vwin' => array( 2, 0 ),
					'l' => array(
						'hstart' => 'I', 'hend' => 'I', 'hwin' => array('I','I','I'), 'v' => 'I', 'extra' => 'I'
					),
					'r' => array(
						'hstart' => 'T', 'hend' => 'T', 'hwin' => array('T','T','T'), 'v' => 'S', 'extra' => 'T'
					),
					'y' => array(
						array(6,9,7),array(12,14,13),array(16,19,17), array(23,26,25),
						array(28,31,29),array(34,36,35),array(38,40,39), array(43,46,45),
						array(6,9,4),array(12,14,13),array(16,18,17), array(21,24,23),
						array(26,29,27),array(32,34,33),array(36,38,37), array(41,44,43)
					)
				),
				3 => array(
					'match_top' => 7, 'match_num' => 8, 'match_num2' => 4, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'J', 'hend' => 'J', 'hwin' => array('J','J','J'), 'v' => 'J',
						'hstart2' => 'J', 'hend2' => 'J', 'extra' => 'J'
					),
					'r' => array(
						'hstart' => 'S', 'hend' => 'S', 'hwin' => array('S','S','S'), 'v' => 'R',
						'hstart2' => 'S', 'hend2' => 'S', 'extra' => 'S'
					),
					'y' => array(
						array(7,13,10),array(17,25,21),array(29,35,32), array(39,45,42),
						array(7,13,10),array(17,23,20),array(27,33,30), array(37,43,40)
					)
				),
				4 => array(
					'match_top' => 3, 'match_num' => 4, 'match_num2' => 2, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'K', 'hend' => 'K',
						'hstart1' => 'K', 'hend1' => 'K', 'hstart2' => 'K', 
						'hend2' => 'K', 'hwin' => array('K','K','K'), 'v' => 'K', 'extra' => 'K'
					),
					'r' => array(
						'hstart' => 'R', 'hend' => 'R',
						'hstart1' => 'R', 'hend1' => 'R', 'hstart2' => 'R',
						'hend2' => 'R', 'hwin' => array('R','R','R'), 'v' => 'Q', 'extra' => 'R'
					),
					'y' => array(
						array(10,21,15),array(32,42,37),
						array(10,20,15),array(30,40,35)
					)
				),
				5 => array(
					'match_top' => 1, 'match_num' => 2, 'match_num2' => 1, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'L', 'hend' => 'L',
						'hstart1' => 'L', 'hend1' => 'L', 'hstart2' => 'L',
						'hend2' => 'L', 'hwin' => array('L','L','L'), 'v' => 'L', 'extra' => 'L'
					),
					'r' => array(
						'hstart' => 'Q', 'hend' => 'Q',
						'hstart1' => 'Q', 'hend1' => 'Q', 'hstart2' => 'Q',
						'hend2' => 'Q', 'hwin' => array('Q','Q','Q'), 'v' => 'P', 'extra' => 'Q'
					),
					'y' => array(
						array(15,37,26),
						array(15,35,26)
					)
				),
				6 => array(
					'match_top' => 0, 'match_num' => 1, 'match_num2' => 1, 'name' => 'M24', 'vwin' => array( 2, 0 ),
					'l' => array(
						'hstart' => 'M', 'hend' => 'M', 'hwin' => array('M','M','M'), 'v' => 'M', 'extra' => 'M'
					),
					'r' => array(
						'hstart' => 'P', 'hend' => 'P', 'hwin' => array('P','P','P'), 'v' => 'O', 'extra' => 'P'
					),
					'y' => array(
					array(26,26)
					)
				)
			);
		} else {
			$chartRow = array(
				0 => array(
					'match_top' => 0, 'match_num' => 1, 'match_num2' => 1, 'name' => 'L36', 'vwin' => array( 2, 0 ),
					'l' => array(
						'hstart' => 'L', 'hend' => 'L', 'hwin' => array('L','L','L'), 'v' => 'K', 'extra' => 'L'
					),
					'r' => array(
						'hstart' => 'Q', 'hend' => 'Q', 'hwin' => array('Q','Q','Q'), 'v' => 'Q', 'extra' => 'Q'
					),
					'y' => array(
						array(38,38)
					)
				),
				1 => array(
					'match_top' => 15, 'match_num' => 16, 'match_num2' => 8, 'vwin' => array( 1, 0 ),
					'l' => array(
						'hstart' => 'H', 'hend' => 'H', 'hwin' => array('H','H','H'), 'v' => 'H', 'extra' => 'H'
					),
					'r' => array(
						'hstart' => 'U', 'hend' => 'U', 'hwin' => array('U','U','U'), 'v' => 'T', 'extra' => 'U'
					),
					'y' => array(
							array(6,6),array(8,10),array(12,14), array(16,18),
							array(20,22),array(24,26),array(28,30), array(32,34),
							array(6,8),array(10,12),array(14,16), array(18,20),
							array(22,24),array(26,28),array(30,32), array(34,36)
						)
				),
				2 => array(
					'match_top' => 7, 'match_num' => 8, 'match_num2' => 4, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'I', 'hend' => 'I', 'hwin' => array('I','I','I'), 'v' => 'I',
						'hstart2' => 'I', 'hend2' => 'I', 'extra' => 'I'
					),
					'r' => array(
						'hstart' => 'T', 'hend' => 'T', 'hwin' => array('T','T','T'), 'v' => 'S',
						'hstart2' => 'T', 'hend2' => 'T', 'extra' => 'T'
					),
					'y' => array(
						array(6,9,7),array(13,17,15),array(21,25,23), array(29,33,31),
						array(7,11,9),array(15,19,17),array(23,27,25), array(31,35,33)
					)
				),
				3 => array(
					'match_top' => 3, 'match_num' => 4, 'match_num2' => 2, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'J', 'hend' => 'J',
						'hstart1' => 'J', 'hend1' => 'J', 'hstart2' => 'J', 
						'hend2' => 'J', 'hwin' => array('J','J','J'), 'v' => 'J', 'extra' => 'J'
					),
					'r' => array(
						'hstart' => 'S', 'hend' => 'S',
						'hstart1' => 'S', 'hend1' => 'S', 'hstart2' => 'S',
						'hend2' => 'S', 'hwin' => array('S','S','S'), 'v' => 'R', 'extra' => 'S'
					),
					'y' => array(
						array(7,15,11),array(23,31,27),
						array(9,17,13),array(25,33,29)
					)
				),
				4 => array(
					'match_top' => 1, 'match_num' => 2, 'match_num2' => 1, 'vwin' => array( 3, 0 ),
					'l' => array(
						'hstart' => 'K', 'hend' => 'K',
						'hstart1' => 'K', 'hend1' => 'K', 'hstart2' => 'K',
						'hend2' => 'K', 'hwin' => array('K','K','K'), 'v' => 'K', 'extra' => 'K'
					),
					'r' => array(
						'hstart' => 'R', 'hend' => 'R',
						'hstart1' => 'R', 'hend1' => 'R', 'hstart2' => 'R',
						'hend2' => 'R', 'hwin' => array('R','R','R'), 'v' => 'Q', 'extra' => 'R'
					),
					'y' => array(
						array(11,27,19),
						array(13,29,19)
					)
				),
				5 => array(
					'match_top' => 0, 'match_num' => 1, 'match_num2' => 1, 'name' => 'L17', 'vwin' => array( 2, 0 ),
					'l' => array(
						'hstart' => 'L', 'hend' => 'L', 'hwin' => array('L','L','L'), 'v' => 'L', 'extra' => 'L'
					),
					'r' => array(
						'hstart' => 'Q', 'hend' => 'Q', 'hwin' => array('Q','Q','Q'), 'v' => 'P', 'extra' => 'Q'
					),
					'y' => array(
					array(19,19)
					)
				)
			);
		}
		$chartRow_ofs = 'l';
		$match_no = $chartRow[1]['match_top'];
		for( $match_ofs = 0; $match_ofs < $chartRow[1]['match_num']; $match_ofs++ ){
			if( $match_ofs == $chartRow[1]['match_num2'] ){
				$chartRow_ofs = 'r';
			}
			$match_ofs2 = intval( $match_ofs / 2 );
			if( ( $match_ofs % 2 ) == 0 ){
			//	$match_no++;
				$vmid = $chartRow[2]['y'][$match_ofs2][0];
			} else {
				$vmid = $chartRow[2]['y'][$match_ofs2][1];
			}
			$winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data']['match'][$match_no] );
			$winstr = '';
			for( $wi = 0; $wi < 3; $wi++ ){
				if( $winstrs[1][$wi] == '' ){
					$winstr .= '　';
				} else {
					$winstr .= $winstrs[1][$wi];
				}
			}
			$sheet->setCellValue(
				$chartRow[1][$chartRow_ofs]['hwin'][0].($chartRow[1]['y'][$match_ofs][0]-$chartRow[1]['vwin'][0]),
				$winstr
			);
			if( $tournament_data['data']['match'][$match_no]['winner'] == 1 ){
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[1]['y'][$match_ofs][0]
					.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[1]['y'][$match_ofs][0]
				)->applyFromArray( $styleArrayH );
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['v'].$chartRow[1]['y'][$match_ofs][0]
					.':'.$chartRow[1][$chartRow_ofs]['v'].($vmid-1)
				)->applyFromArray( $styleArrayV );
			}
			if( $tournament_data['data']['match'][$match_no]['winner'] == 2 ){
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['hstart'].$chartRow[1]['y'][$match_ofs][1]
					.':'.$chartRow[1][$chartRow_ofs]['hend'].$chartRow[1]['y'][$match_ofs][1]
				)->applyFromArray( $styleArrayH );
				$sheet->getStyle(
					$chartRow[1][$chartRow_ofs]['v'].$vmid
					.':'.$chartRow[1][$chartRow_ofs]['v'].($chartRow[1]['y'][$match_ofs][1]-1)
				)->applyFromArray( $styleArrayV );
			}
			$winstr = '';
			for( $wi = 0; $wi < 3; $wi++ ){
				if( $winstrs[2][$wi] == '' ){
					$winstr .= '　';
				} else {
					$winstr .= $winstrs[2][$wi];
				}
			}
			$sheet->setCellValue(
				$chartRow[1][$chartRow_ofs]['hwin'][0].($chartRow[1]['y'][$match_ofs][1]+$chartRow[1]['vwin'][1]),
				$winstr
			);
//print_r($tournament_data['data']['match'][$match_no]);
			if( $tournament_data['data']['match'][$match_no]['extra'] == 1 ){
				$sheet->setCellValue(
					$chartRow[1][$chartRow_ofs]['extra'].$chartRow[1]['y'][$match_ofs][0],
					'延'
				);
			}
			$match_no++;
		}
		for( $level = 2; $level < $level_num; $level++ ){
			$chartRow_ofs = 'l';
			$match_no = $chartRow[$level]['match_top'];
			for( $match_ofs = 0; $match_ofs < $chartRow[$level]['match_num']; $match_ofs++ ){
				if( $match_ofs == $chartRow[$level]['match_num2'] ){
					$chartRow_ofs = 'r';
				}
				$vmid = $chartRow[$level+1]['y'][intval($match_ofs/2)][$match_ofs%2];
				$winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data']['match'][$match_no] );
				$winstr1 = '';
				$winstr2 = '';
				for( $wi = 0; $wi < 3; $wi++ ){
					if( $winstrs[1][$wi] == '' ){
						$winstr1 .= '　';
					} else {
						$winstr1 .= $winstrs[1][$wi];
					}
					if( $winstrs[2][$wi] == '' ){
						$winstr2 .= '　';
					} else {
						$winstr2 .= $winstrs[2][$wi];
					}
				}
				$sheet->setCellValue(
					$chartRow[$level][$chartRow_ofs]['hwin'][0].($chartRow[$level]['y'][$match_ofs][0]-1),
					$winstr1
				);
				if( $tournament_data['data']['match'][$match_no]['winner'] == 1 ){
					if( $level == 2 && $chartRow[1]['y'][$match_ofs*2][0] == $chartRow[1]['y'][$match_ofs*2][1] ){
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
					if( $level != 2 || $chartRow[1]['y'][$match_ofs*2+1][0] != $chartRow[1]['y'][$match_ofs*2+1][1] ){
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
				if( $tournament_data['data']['match'][$match_no]['winner'] == 2 ){
					if( $level == 2 && $chartRow[1]['y'][$match_ofs*2+1][0] == $chartRow[1]['y'][$match_ofs*2+1][1] ){
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
					if( $level != 2 || $chartRow[1]['y'][$match_ofs*2][0] != $chartRow[1]['y'][$match_ofs*2][1] ){
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
				$sheet->setCellValue(
					$chartRow[$level][$chartRow_ofs]['hwin'][0].$chartRow[$level]['y'][$match_ofs][1],
					$winstr2
				);
				if( $tournament_data['data']['match'][$match_no]['extra'] == 1 ){
					$sheet->setCellValue(
						$chartRow[$level][$chartRow_ofs]['extra'].($chartRow[$level]['y'][$match_ofs][2]-1),
						'延'
					);
				}
				$match_no++;
			}
		}
		$winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data']['match'][0] );
		$winstr1 = '';
		$winstr2 = '';
		for( $wi = 0; $wi < 3; $wi++ ){
			if( $winstrs[1][$wi] == '' ){
				$winstr1 .= '　';
			} else {
				$winstr1 .= $winstrs[1][$wi];
			}
			if( $winstrs[2][$wi] == '' ){
				$winstr2 .= '　';
			} else {
				$winstr2 .= $winstrs[2][$wi];
			}
		}
		$sheet->setCellValue(
			$chartRow[$level_num]['l']['hwin'][0].($chartRow[$level_num]['y'][0][0]-1),
			$winstr1
		);
		$sheet->setCellValue(
			$chartRow[$level_num]['r']['hwin'][0].($chartRow[$level_num]['y'][0][1]-1),
			$winstr2
		);
		if( $tournament_data['data']['match'][0]['winner'] == 1 ){
			$sheet->getStyle(
				$chartRow[$level_num]['l']['hstart'].$chartRow[$level_num]['y'][0][0]
				.':'.$chartRow[$level_num]['l']['hend'].$chartRow[$level_num]['y'][0][0]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[$level_num]['name'],
				$tournament_data['data']['match'][0]['player1_name']
			);
		} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
			$sheet->getStyle(
				$chartRow[$level_num]['r']['hstart'].$chartRow[$level_num]['y'][0][1]
				.':'.$chartRow[$level_num]['r']['hend'].$chartRow[$level_num]['y'][0][1]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[$level_num]['name'],
				$tournament_data['data']['match'][0]['player2_name']
			);
		}
		if( $tournament_data['data']['match'][0]['winner'] != 0 ){
		//	$sheet->setCellValue( 'BB112',$winstr[2] );
			$sheet->getStyle(
				$chartRow[$level_num]['l']['hstart'].($chartRow[$level_num]['y'][0][0]-1)
			)->applyFromArray( $styleArrayV );
		}
		if( $tournament_data['data']['match'][0]['extra'] == 1 ){
			$sheet->setCellValue(
				$chartRow[$level_num]['l']['hstart'].$chartRow[$level_num]['y'][0][0], '延'
			);
		}

		$winstrs = $objPage->get_kojin_tounament_chart_winstring_for_excel( $tournament_data['data']['match'][$kmatch] );
		$winstr1 = '';
		$winstr2 = '';
		for( $wi = 0; $wi < 3; $wi++ ){
			if( $winstrs[1][$wi] == '' ){
				$winstr1 .= '　';
			} else {
				$winstr1 .= $winstrs[1][$wi];
			}
			if( $winstrs[2][$wi] == '' ){
				$winstr2 .= '　';
			} else {
				$winstr2 .= $winstrs[2][$wi];
			}
		}
		$sheet->setCellValue(
			$chartRow[0]['l']['hwin'][0].($chartRow[0]['y'][0][0]-1),
			$winstr1
		);
		$sheet->setCellValue(
			$chartRow[0]['r']['hwin'][0].($chartRow[0]['y'][0][1]-1),
			$winstr2
		);
		if( $tournament_data['data']['match'][$kmatch]['winner'] == 1 ){
			$sheet->getStyle(
				$chartRow[0]['l']['v'].$chartRow[0]['y'][0][0]
			)->applyFromArray( $styleArrayV );
			$sheet->getStyle(
				$chartRow[0]['l']['hstart'].$chartRow[0]['y'][0][0]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[0]['name'],
				$tournament_data['data']['match'][$kmatch]['player1_name']
			);
		} else if( $tournament_data['data']['match'][$kmatch]['winner'] == 2 ){
			$sheet->getStyle(
				$chartRow[0]['r']['v'].$chartRow[0]['y'][0][0]
			)->applyFromArray( $styleArrayV );
			$sheet->getStyle(
				$chartRow[0]['r']['hstart'].$chartRow[0]['y'][0][1]
			)->applyFromArray( $styleArrayH );
			$sheet->setCellValue(
				$chartRow[0]['name'],
				$tournament_data['data']['match'][$kmatch]['player2_name']
			);
		}
		if( $tournament_data['data']['match'][$kmatch]['winner'] != 0 ){
		//	$sheet->setCellValue( 'BB112',$winstr[2] );
			$sheet->getStyle(
				$chartRow[0]['l']['hstart'].($chartRow[0]['y'][0][0]-1)
			)->applyFromArray( $styleArrayV );
			$sheet->setCellValue(
				$chartRow[0]['l']['v'].($chartRow[0]['y'][0][0]+1),
				$tournament_data['data']['match'][$kmatch]['player1_name']
			);
			$sheet->setCellValue(
				$chartRow[0]['r']['v'].($chartRow[0]['y'][0][0]+1),
				$tournament_data['data']['match'][$kmatch]['player2_name']
			);
		}
		if( $tournament_data['data']['match'][$kmatch]['extra'] == 1 ){
			$sheet->setCellValue(
				$chartRow[0]['l']['hstart'].$chartRow[0]['y'][0][0], '延'
			);
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
//exit;
		return $file_name;
	}

	function output_tournament_14_for_excel( $objPage, $path, $tournament_data, $entry_list )
	{
		return __output_tournament_14_15_for_excel( $objPage, $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_15_for_excel( $objPage, $path, $tournament_data, $entry_list )
	{
		return __output_tournament_14_15_for_excel( $objPage, $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_tournament_match_for_HTML2_14( $objPage, $path, $tournament_list, $entry_list, $mv )
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

	function __output_tournament_14_15_for_HTML( $path, $tournament_data, $entry_list, $mv )
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
			. '</style>' . "\n"
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">個人戦'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
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
			$pref = $tournament_data['data']['player'][$tournament_team]['school_name_ryaku'];
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

	function output_tournament_14_for_HTML( $path, $tournament_data, $entry_list )
	{
		__output_tournament_14_15_for_HTML( $path, $tournament_data, $entry_list, 'm' );
	}

	function output_tournament_15_for_HTML( $path, $tournament_data, $entry_list )
	{
		__output_tournament_14_15_for_HTML( $path, $tournament_data, $entry_list, 'w' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_entry_data_list_all_1_excel14_15( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
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

	function output_entry_data_list_all_1_excel14( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel14_15( $sheet, 14, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel14_15( $sheet, 15, 'w', $pos, '個人戦女子' );
		return true;
	}

	function output_entry_data_list_all_1_excel15( $sheet )
	{
		$pos = __output_entry_data_list_all_1_excel14_15( $sheet, 14, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_1_excel14_15( $sheet, 15, 'w', $pos, '個人戦女子' );
		return true;
	}

	//--------------------------------------------------------------

	function __output_entry_data_list_all_2_excel14_15( $sheet, $series, $series_mw, $start_pos, $series_name )
	{
		$c = new common();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
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

	function output_entry_data_list_all_2_excel14( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel14_15( $sheet, 14, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel14_15( $sheet, 15, 'w', $pos, '個人戦女子' );
		return false;
	}

	function output_entry_data_list_all_2_excel15( $sheet )
	{
		$pos = __output_entry_data_list_all_2_excel14_15( $sheet, 14, 'm', 4, '個人戦男子' );
		__output_entry_data_list_all_2_excel14_15( $sheet, 15, 'w', $pos, '個人戦女子' );
		return false;
	}

	//--------------------------------------------------------------

	function __get_entry_data_list2_14_15( $series, $series_mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
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
			$lv['school_name'] = get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' )
				. ' ' . get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' ) 
				. '(' . get_field_string( $fields, 'school_name' ) . ')';
			$ret[] = $lv;
		}
		db_close( $dbs );

		return array_merge( $ret );
	}

	function get_entry_data_list2_14()
	{
		return __get_entry_data_list2_14_15( 14, 'm' );
	}

	function get_entry_data_list2_15()
	{
		return __get_entry_data_list2_14_15( 15, 'w' );
	}

	//--------------------------------------------------------------

	function __get_entry_data_14_15_list_for_PDF( $series, $series_mw )
	{
		$c = new common();
		$preftbl = $c->get_pref_array2();
		$gakunentbl = $c->get_grade_junior_array();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.__REG_SERIES_YEAR__
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

	function get_entry_data_14_list_for_PDF()
	{
		return __get_entry_data_14_15_list_for_PDF( 14, 'm' );
	}

	function get_entry_data_15_list_for_PDF()
	{
		return __get_entry_data_14_15_list_for_PDF( 15, 'w' );
	}

	//--------------------------------------------------------------

	function __get_entry_data_for_draw_csv_14_15( $list, $series, $series_mw )
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

	function get_entry_data_for_draw_csv_14( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_14_15( $list, 14, 'm' ),
			'file' => 'kojin_m.csv'
		);
	}

	function get_entry_data_for_draw_csv_15( $list )
	{
		return array(
			'csv' => __get_entry_data_for_draw_csv_14_15( $list, 15, 'w' ),
			'file' => 'kojin_w.csv'
		);
	}

	//--------------------------------------------------------------

	//--------------------------------------------------------------

	function __output_realtime_html_for_one_board_14_15( $place, $place_match_no )
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

	function output_realtime_html_for_one_board_14( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_14_15( $place, $place_match_no );
	}

	function output_realtime_html_for_one_board_15( $place, $place_match_no )
	{
		return __output_realtime_html_for_one_board_14_15( $place, $place_match_no );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function __output_tournament_chart_14_15_for_HTML( $tournament_data, $entry_list )
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

	function output_tournament_chart_14_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_14_15_for_HTML( $tournament_data, $entry_list );
	}

	function output_tournament_chart_15_for_HTML( $tournament_data, $entry_list )
	{
		return __output_tournament_chart_14_15_for_HTML( $tournament_data, $entry_list );
	}

	//--------------------------------------------------------------
?>
