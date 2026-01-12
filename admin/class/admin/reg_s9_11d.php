<?php
	function __draw_entry_data_list_init_sheet_36_40( $sheet, $series_name, $sheet_no, $dan_str )
    {
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(11);
        $sheet->setTitle( $series_name.'(No'.$sheet_no.')' );
		$sheet->setCellValueByColumnAndRow( 1, 1, $series_name.'(No'.$sheet_no.')' );
        __draw_entry_data_list_cell_assign_center_36_40( $sheet, 1, 1, false );
        for( $row = 1; $row <= 34; $row++ ){
            $sheet->getRowDimension($row)->setRowHeight(24);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(4.0);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(36.0);
		for( $player = 0; $player < 5; $player++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2+$player*2))->setWidth(12);
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2+$player*2+1))->setWidth(8);
        }
		$sheet->setCellValueByColumnAndRow( 0, 2, '番号' );
		$sheet->setCellValueByColumnAndRow( 1, 2, 'チーム名' );
		$sheet->setCellValueByColumnAndRow( 2, 2, '先鋒' );
		$sheet->setCellValueByColumnAndRow( 3, 2, $dan_str );
		$sheet->setCellValueByColumnAndRow( 4, 2, '次鋒' );
		$sheet->setCellValueByColumnAndRow( 5, 2, $dan_str );
		$sheet->setCellValueByColumnAndRow( 6, 2, '中堅' );
		$sheet->setCellValueByColumnAndRow( 7, 2, $dan_str );
		$sheet->setCellValueByColumnAndRow( 8, 2, '副将' );
		$sheet->setCellValueByColumnAndRow( 9, 2, $dan_str );
		$sheet->setCellValueByColumnAndRow( 10, 2, '大将' );
		$sheet->setCellValueByColumnAndRow( 11, 2, $dan_str );
        for( $i1 = 0; $i1 <= 11; $i1++ ){
            $sheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i1).'2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i1).'2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        }
    }

	function __draw_entry_data_list_cell_assign_center_36_40( $sheet, $col, $row, $hori )
    {
        $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
        if( $hori ){
            $sheet->getStyle($colstr.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $sheet->getStyle($colstr.$row)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    }

	function __draw_entry_data_list_update_cell_border_36_40( $sheet, $rownum )
    {
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
        for( $row = 0; $row <= $rownum+1; $row++ ){
            $sheet->getStyle( 'A'.($row+2).':L'.($row+2) )->applyFromArray( $styleArrayH );
        }
        for( $col = 0; $col < 12; $col++ ){
            $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
            $sheet->getStyle( $colstr.'2:'.$colstr.($rownum+2) )->applyFromArray( $styleArrayV2 );
        }
        $sheet->getStyle( 'L2:L'.($rownum+2) )->applyFromArray( $styleArrayV );
    }

	function __draw_entry_data_list_36_40( $excel, $sheet_index, $series, $start_pos, $series_name, $dan_str, $rejectFile )
	{
		$c = new common();
        if( $sheet_index > 0 ){
            $excel->createSheet();
        }
        $excel->setActiveSheetIndex( $sheet_index );
        $sheet = $excel->getActiveSheet();
        $sheet_no = 1;
        __draw_entry_data_list_init_sheet_36_40( $sheet, $series_name, $sheet_no, $dan_str );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
        $teams = array();
        $team_ids = array();
        $index = 0;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			foreach( $flist as $fv ){
				$lv[$fv['field']] = $fv['data'];
			}
			if( get_field_string_number( $lv, 'join', 0 ) == 0 ){ continue; }
            $teams[] = $lv;
            $team_ids[] = $index++;
        }
        $max = $index;
        $id_count = count( $team_ids );
        //$bytes = openssl_random_pseudo_bytes( 200 );
        $file = new SplFileObject(dirname(__FILE__).'/'.$rejectFile);
        $file->setFlags( SplFileObject::READ_CSV );
        for( $i1 = 0; $i1 < 100; $i1++ ){
            for( $i2 = 0; $i2 < 100; $i2++ ){
                $src1 = mt_rand( 0, $max-1 ); //intval( $bytes[$i1*2] * $index / 256 );
                $src2 = mt_rand( 0, $max-1 ); //intval( $bytes[$i1*2+1] * $index / 256 );
                $d = $team_ids[$src1];
                $team_ids[$src1] = $team_ids[$src2];
                $team_ids[$src2] = $d;
            }
            $end = true;
            for( $i2 = 0; $i2 < $id_count; $i2++ ){
                foreach( $file as $line ){
                    if( is_null( $line[0] ) ){ continue; }
                    if( mb_strstr( $teams[$team_ids[$i2]]['school_name'], $line[0] ) !== false ){
                        if( $i2 > 0 && mb_strstr( $teams[$team_ids[$i2-1]]['school_name'], $line[1] ) !== false ){
                            $end = false;
                        } else if( $i2 < $id_count-1 && mb_strstr( $teams[$team_ids[$i2+1]]['school_name'], $line[1] ) !== false ){
                            $end = false;
                        }
//echo $teams[$team_ids[$i2]]['school_name'],':',$teams[$team_ids[$i2-1]]['school_name'],':',$teams[$team_ids[$i2+1]]['school_name'],':',$line[0],':',$line[1],'[',$end,"<br />\n";
                    }
                    if( mb_strstr( $teams[$team_ids[$i2]]['school_name'], $line[1] ) !== false ){
                        if( $i2 > 0 && mb_strstr( $teams[$team_ids[$i2-1]]['school_name'], $line[0] ) !== false ){
                            $end = false;
                        } else if( $i2 < $id_count-1 && mb_strstr( $teams[$team_ids[$i2+1]]['school_name'], $line[0] ) !== false ){
                            $end = false;
                        }
//echo $teams[$team_ids[$i2]]['school_name'],':',$teams[$team_ids[$i2-1]]['school_name'],':',$teams[$team_ids[$i2+1]]['school_name'],':',$line[0],':',$line[1],'[',$end,"<br />\n";
                    }
                    if( !$end ){ break; }
                }
                if( !$end ){ break; }
            }
            if( $end ){ break; }
        }
//echo $i1;
//exit;
        $sheet->setCellValueByColumnAndRow( 13, 1, $i1 );
        if( !$end ){
            $sheet->setCellValueByColumnAndRow( 14, 1, 'xxxxx' );
        }

        $pos = $start_pos;
        $team_no = 1;
		foreach( $team_ids as $index ){
			$col = 0;
            __draw_entry_data_list_cell_assign_center_36_40( $sheet, $col, $pos, true );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $team_no );
            __draw_entry_data_list_cell_assign_center_36_40( $sheet, $col, $pos, false );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $teams[$index]['school_name'] );
			for( $player = 1; $player <= 7; $player++ ){
                __draw_entry_data_list_cell_assign_center_36_40( $sheet, $col, $pos, true );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $teams[$index]['player'.$player.'_sei'].' '.$teams[$index]['player'.$player.'_mei'] );
                __draw_entry_data_list_cell_assign_center_36_40( $sheet, $col, $pos, true );
 				$sheet->setCellValueByColumnAndRow( $col++, $pos, $teams[$index]['player'.$player.'_dan'] );
			}
			$pos++;
            if( ( $team_no % 32 ) == 0 && $team_no < $id_count ){
                __draw_entry_data_list_update_cell_border_36_40( $sheet, 32 );
                $excel->createSheet();
                $sheet_index++;
                $excel->setActiveSheetIndex( $sheet_index );
                $sheet = $excel->getActiveSheet();
                $pos = $start_pos;
                $sheet_no++;
                __draw_entry_data_list_init_sheet_36_40( $sheet, $series_name, $sheet_no, $dan_str );
            }
            $team_no++;
		}
        if( ( ($team_no-1) % 32 ) != 0 ){
            __draw_entry_data_list_update_cell_border_36_40( $sheet, ($team_no-1) % 32 );
        }
		db_close( $dbs );
		return $sheet_index + 1;
	}

