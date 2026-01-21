<?php
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_4.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_7_8.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_9_10.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_12_13.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)) . '/result.php';

class form_page_admin_dantai_league extends form_page
{
	function init( $series, $edit )
	{
        $objEntry = new form_page_dantai_entry( $this );
        $objMatch = new form_page_dantai_match( $this );
        $objLeague = new form_page_dantai_league( $this );
		$page = get_field_string_number( $_GET, 'p', 1 );
		$category = get_field_string_number( $_GET, 'c', 1 );
		$mw = get_field_string( $_GET, 'mw' );
		if( $mw == 'm' ){
			$series_mw_str = '男子';
		} else {
			$series_mw_str = '女子';
		}
		parent::init( $series, $edit );
		if( !isset( $_SESSION['auth'] ) || $_SESSION['auth']['login'] != 1 ){
			$_SESSION['auth'] = array( 'login' => 0 );
			header( "Location: ".__HTTP_BASE__."admin/login.php");
			exit;
		}
	//	if( $_SESSION['auth'] != 1 ){ exit; }
		if( !isset($_SESSION['auth']['series_info_id']) || $_SESSION['auth']['series_info_id'] == 0 ){ exit; }
        $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'd.php';
        if( file_exists( $inc ) ){
            require_once $inc;
        }
        $series_info = $this->get_series_info( $_SESSION['auth']['series_info_id'] );
//print_r($series_info);
		$league_param = $objLeague->get_dantai_league_parameter( $series );
		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$org_array = $this->get_org_array();
		$dantai_rank_array = $this->get_dantai_rank_array();
		$pref_array = $this->get_pref_array();
		$birth_year_array = $this->get_birth_year_array();
		$month_array = $this->get_month_array();
		$day_array = $this->get_day_array();
		$this->smarty_assign['org_array'] = $this->get_org_array_for_smarty( $org_array );
		$this->smarty_assign['dantai_rank_array'] = $dantai_rank_array;
		$this->smarty_assign['pref_array'] = $this->get_pref_array_for_smarty( $pref_array );
		$this->smarty_assign['birth_year_array'] = $this->get_birth_year_for_smarty(null);
		$this->smarty_assign['month_array'] = $this->get_month_array_for_smarty( $month_array );
		$this->smarty_assign['day_array'] = $this->get_day_array_for_smarty( $day_array );
		$this->smarty_assign['root_url'] = '../';
		$this->smarty_assign['post_action'] = 'info.php';
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$this->smarty_assign['entry_list'] = $this->get_entry_array_for_smarty( $series, $mw );
		$this->smarty_assign['team_num'] = 3;
		$this->smarty_assign['series'] = $series;
		$this->smarty_assign['mw'] = $mw;
		$this->smarty_assign['seriesinfo'] = $this->get_series_list( $series );

		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'new' ){
			$this->make_new_dantai_league_list( $series, $mw );
		} else if( $mode == 'clear' ){
            if( $series_info['enable_clear'] == 1 && $series_info['enable_clear_dl'] == 1 ){
    			$this->clear_match_info( $series );
	    		$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
		    	$entry_list = $this->get_entry_data_list3( $series, $mw );
			    //$league_param = $objLeague->get_dantai_league_parameter( $series );
			    $func = 'output_league_'.$series.'_for_HTML';
			    $func( $series_info, $league_param, $league_data, $entry_list, $mw );
			    $func = 'output_league_match_for_HTML2_'.$series;
			    $func( $series_info, $league_param, $league_data, $entry_list, $mw );
    			$tournament_data = $this->get_dantai_tournament_data( $series, $mw );
		    	$func = 'output_tournament_' . $series . '_for_HTML';
			    $html = $func( $series_info, $tournament_data, $entry_list, $mw );
			    $func = 'output_tournament_match_for_HTML2_'.$series;
			    $func( $series_info, $tournament_data, $entry_list, $mw );
            }
		} else if( $mode == 'edit_result' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
			//	$_SESSION['p'] = $this->get_entry_one_data( $id );
			//	$_SESSION['e'] = $this->init_entry_post_data();
			//	$this->smarty_assign['edit_title'] = 'エントリー編集';
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'dantai_result.html';
				return;
			}
		} else if( $mode == 'confirm' ){
			if( isset( $_POST['exec'] ) ){
				if( $this->GetFormPostData() == 0 ){
					$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mconfirm.html';
					return;
				} else {
					$this->smarty_assign['edit_title'] = 'エントリー編集';
					$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
					return;
				}
			}
		} else if( $mode == 'update' || $mode == 'loadcsv' ){
            if( $mode == 'update' ){
    			$objLeague->update_dantai_league_list( $series, $mw, $_POST );
    		} else if( $mode == 'loadcsv' ){
	    		$post = $objLeague->load_dantai_league_csvdata( $series, $mw, $_FILES["csv_file"]["tmp_name"] );
    			$objLeague->update_dantai_league_list( $series, $mw, $post );
		    }
			$this->update_series_place_navi_data( $series_info['navi_id'] );
			$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $mw );
			//$league_param = $objLeague->get_dantai_league_parameter( $series );
			$func = 'output_league_'.$series.'_for_HTML';
			$func( $series_info, $league_param, $league_data, $entry_list, $mw );
			$func = 'output_league_match_for_HTML2_'.$series;
			$func( $series_info, $league_param, $league_data, $entry_list, $mw );
			/*
            if( $series_info['output_match_result_pdf'] == 1 ){
                $allnavi = $this->get_series_place_all_navi_data( $series_info['navi_id'] );
                foreach( $allnavi as $nv ){
                    $objMatch->output_dantai_one_match_pdf( $series_info['navi_id'], $nv['place_no'], $nv['place_match_no'], $nv['match_id'] );
                }
            }
			*/
		} else if( $mode == 'delete' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
			//	$_SESSION['p'] = $this->GetOneData( $id );
			//	$this->template = 'admin' . DIRECTORY_SEPARATOR . 'delete.html';
				return;
			}
		} else if( $mode == 'exec_delete' ){
			if( isset( $_POST['exec'] ) ){
			//	$this->DeleteData();
			}
		} else if( $mode == 'exchange' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			$id2 = get_field_string_number( $_POST, 'id2', 0 );
			if( $id > 0 && $id2 > 0 ){
			//	$this->ExchangeData( $id, $id2 );
			}
//		} else if( $mode == 'loadcsv' ){
//			$post = $objLeague->load_dantai_league_csvdata( $series, $mw, $_FILES["csv_file"]["tmp_name"] );
		}
		$league_param = $objLeague->get_dantai_league_parameter( $series );
		$list = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
//print_r($list);
		$this->smarty_assign['league_list'] = $list;
		$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty(null,$list);
		$this->smarty_assign['place_match_no_array'] = $this->get_place_match_no_array_for_smarty(null);
		$this->smarty_assign['place_match_rw_array'] = $this->get_place_match_rw_array_for_smarty(null);
//print_r($_POST);
//print_r($this->smarty_assign['league_list'] );

		if( $mode == 'output' ){
			$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $mw );
			$func = 'output_league_' . $series . '_for_PDF';
			$func( $series_info, $league_param, $league_data, $entry_list );
/*
			require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
			require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
			//include( dirname(dirname(dirname(__FILE__)))."/mpdf60/mpdf.php" );
			//require_once dirname(dirname(dirname(__FILE__))).'/tcpdf/tcpdf.php';
ini_set('memory_limit', '256M');
			//$objReader = new PHPExcel_Reader_Excel5();
			//$objPHPExcel = $objReader->load(dirname(__FILE__).DIRECTORY_SEPARATOR."Book1.xls");
			$objPHPExcel = PHPExcel_IOFactory::load(dirname(__FILE__).DIRECTORY_SEPARATOR."Book1.xlsx");
			$rendererName = PHPExcel_Settings::PDF_RENDERER_TCPDF;
			$rendererLibraryPath = dirname(dirname(dirname(__FILE__))).'/tcpdf';
			if(!PHPExcel_Settings::setPdfRenderer( $rendererName, $rendererLibraryPath )) {
				die( 'Please set the $rendererName and $rendererLibraryPath values' . PHP_EOL . ' as appropriate for your directory structure' );
			}
			$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
			$objWriter->save(dirname(__FILE__).DIRECTORY_SEPARATOR."test.pdf");
*/
/*
			$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
			$objWriter->save(dirname(__FILE__).DIRECTORY_SEPARATOR."test.html");
			$pdf = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."test.html");

			$tcpdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');  
			$tcpdf->setFontSubsetting(FALSE);
			$tcpdf->AddPage();
			$tcpdf->writeHTML($pdf);
			$tcpdf->Output(dirname(__FILE__).DIRECTORY_SEPARATOR."test.pdf",'F');
*/
/*
			$mpdf = new mPDF( '+aCJK', 'A4', '', '', 10, 10, 10, 10, 0, 0 ); 
			$mpdf->SetDisplayMode( 'fullpage' );
			$mpdf->autoLangToFont = true;
			$mpdf->WriteHTML( $pdf );
			$mpdf->Output( 'test.pdf', 'D' );
*/
/**/
//			return;
/*
			$category = get_field_string_number( $_POST, 'category', 1 );
			$list = $this->GetRegDataList( $category );
			$outdata = '';
			foreach( $list as $lv ){
				if( $lv['reg2'] == 1 ){
					$outdata .= $this->smarty_assign['prefTbl'][intval($lv['pref2'])-1].' '.$lv['name2']."\n";
					$outdata .= $lv['address2']."\n";
					$outdata .= $lv['tel2']."\n";
				} else if( $lv['reg1'] == 1 ){
					$outdata .= $this->smarty_assign['prefTbl'][intval($lv['pref'])-1].' '.$lv['name1']."\n";
					$outdata .= $lv['address']."\n";
					$outdata .= $lv['tel']."\n";
				} else {
					$outdata .= "\n\n\n";
				}
				if( $lv['reg2'] == 1 ){
					$outdata .= $lv['manager']."\n";
					$outdata .= $lv['captain']."\n";
					$outdata .= $lv['player1']."\n";
					$outdata .= $lv['player1_grade']."年\n";
					$outdata .= $lv['player2']."\n";
					$outdata .= $lv['player2_grade']."年\n";
					$outdata .= $lv['player3']."\n";
					$outdata .= $lv['player3_grade']."年\n";
					$outdata .= $lv['player4']."\n";
					$outdata .= $lv['player4_grade']."年\n";
					$outdata .= $lv['player5']."\n";
					$outdata .= $lv['player5_grade']."年\n";
					$outdata .= $lv['introduction']."\n";
					$outdata .= $lv['main_results']."\n";
				} else {
					$outdata .= "\n\n\n\n\n\n\n\n\n";
				}
				$outdata .= "\n";
			}
			header('Content-Disposition: inline; filename="output.txt"');
			header('Content-Length: '.strlen($outdata));
			header('Content-Type: application/octet-stream');
			echo $outdata;
			exit;
*/
		} else if( $mode == 'output_excel_chart' ){
			$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $mw );
			//$league_param = $objLeague->get_dantai_league_parameter( $series );

$params = [
    'series_info'  => $series_info,
    'league_param' => $league_param,
	'league_data' => $league_data, 
	'entry_list' => $entry_list, 
	'series_mw' => $mw,
	'lt' => 'dl',
	'mode' => 'output_league_for_Excel',
];
$json_params = json_encode($params);
$headers = [
    'Content-Type: application/json',
    'Accept-Charset: UTF-8',
];
if( $series_info['navi_id'] == 1004 ){
	$base_url = 'https://www.i-kendo.net/zenchu/result/resultexcelapi.php';
} else {
	$base_url = 'https://www.i-kendo.net/kendo/result/resultexcelapi.php';
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_exec($ch);
curl_close($ch);

/*
			$func = 'output_league_' . $series . '_for_Excel';
			$file_name = $func( $this, $series_info, $league_param, $league_data, $entry_list, $mw );
            $file_path = $series_info['output_path'] . '/' . $file_name;
            $ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
            $dname = $series_info['dantai_'.$mw.'_name'] . 'リーグ成績表.' . $ftime . '.xlsx';

			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename="'.$dname.'"');
			header( 'Content-Length: '.filesize($file_path) );
			ob_end_clean();//ファイル破損エラー防止
			readfile( $file_path );
			exit;
*/
		} else if( $mode == 'output_excel_result' ){
			$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $mw );

$params = [
    'series_info'  => $series_info,
    'league_param' => $league_param,
	'league_data' => $league_data, 
	'entry_list' => $entry_list, 
	'series_mw' => $mw,
	'lt' => 'dl',
	'mode' => 'output_league_match_for_excel',
];
$json_params = json_encode($params);
$headers = [
    'Content-Type: application/json',
    'Accept-Charset: UTF-8',
];
if( $series_info['navi_id'] == 1004 ){
	$base_url = 'https://www.i-kendo.net/zenchu/result/resultexcelapi.php';
} else {
	$base_url = 'https://www.i-kendo.net/kendo/result/resultexcelapi.php';
}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
echo curl_exec($ch);
curl_close($ch);

/*
			//$league_param = $objLeague->get_dantai_league_parameter( $series );
			$func = 'output_league_match_for_excel_'.$series;
			$file_name = $func( $this, $series_info, $league_param, $league_data, $entry_list );
			if( $file_name != '' ){
				$file_path = $series_info['output_path'] . '/' . $file_name;
    	        $ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
        	    $dname = $series_info['dantai_'.$mw.'_name'] . '対戦詳細結果.' . $ftime . '.xlsx';

				header( 'Content-Type: application/octet-stream' );
				header( 'Content-Disposition: attachment; filename="'.$dname.'"');
				header( 'Content-Length: '.filesize($file_path) );
				ob_end_clean();//ファイル破損エラー防止
				readfile( $file_path );
				exit;
			}
*/
		} else if( $mode == 'update_result' ){
			$league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $mw );
			$func = 'output_league_'.$series.'_for_HTML';
			$func( $series_info, $league_param, $league_data, $entry_list, $mw );
			$func = 'output_league_match_for_HTML2_'.$series;
			$func( $series_info, $league_param, $league_data, $entry_list, $mw );
            if( $series_info['output_match_result_pdf'] == 1 ){
                $allnavi = $this->get_series_place_all_navi_data( $series_info['navi_id'] );
                foreach( $allnavi as $nv ){
					$data = [
						'navi_id' => $series_info['navi_id'],
						'place' => $nv['place_no'],
						'place_match_no' => $nv['place_match_no'],
					];
                    $this->update_pdf_queue( $data, false );
                }
				$this->update_pdf_queue( null, true );
            }
		}
		$_SESSION['p'] = array();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'dantai_league.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function ExchangeData( $id1, $id2 )
	{
		if( $id1 == 0 || $id2 == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `reg02` where `id`='.$id1;
		$list = db_query_list( $dbs, $sql );
		if( count($list) == 0 ){ return; }
		$sql = 'select * from `reg02` where `id`='.$id2;
		$list2 = db_query_list( $dbs, $sql );
		if( count($list2) == 0 ){ return; }
		$sql = 'update `reg02` set `disp_order`='.$list2[0]['disp_order'].' where `id`='.$id1;
		db_query( $dbs, $sql );
		$sql = 'update `reg02` set `disp_order`='.$list[0]['disp_order'].' where `id`='.$id2;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function GetFormPostData()
	{
		$this->get_entry_post_data();
		$this->add_entry_post_data_select_name();

		$err = 0;
/*
		if( $_SESSION['p']['pref'] == '' ){
			$_SESSION['e']['pref'] = '都道府県を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['name'] == '' ){
			$_SESSION['e']['name'] = '団体名を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['address'] == '' ){
			$_SESSION['e']['address'] = '住所を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['tel'] == '' ){
			$_SESSION['e']['tel'] = '電話番号を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['responsible'] == '' ){
			$_SESSION['e']['responsible'] = '記入責任者を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['rensei'] == '' ){
			$_SESSION['e']['rensei'] = '錬成会参加を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['stay'] == '' ){
			$_SESSION['e']['stay'] = '宿泊予定を選択して下さい。';
			$err = 1;
		}
*/
		return $err;
	}
}

?>
