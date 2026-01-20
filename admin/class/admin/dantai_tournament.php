<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_2b.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_7_8.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_tournament.php';
    require_once dirname(dirname(__FILE__)) . '/result2.php';

class form_page_admin_dantai_tournament extends form_page
{
	function init( $series, $edit )
	{
        $objEntry = new form_page_dantai_entry( $this );
        $objMatch = new form_page_dantai_match( $this );
        $objLeague = new form_page_dantai_league( $this );
        $objTournament = new form_page_dantai_tournament( $this );
		$page = get_field_string_number( $_GET, 'p', 1 );
		$series = get_field_string_number( $_GET, 's', 1 );
		$series_mw = get_field_string( $_GET, 'mw', 'm' );
		parent::init( $series, $edit );
		if( $_SESSION['auth']['login'] != 1 ){ exit; }
		if( !isset($_SESSION['auth']['series_info_id']) || $_SESSION['auth']['series_info_id'] == 0 ){ exit; }

        $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'd.php';
        if( file_exists( $inc ) ){
            require_once $inc;
        }
        $series_info = $this->get_series_info( $_SESSION['auth']['series_info_id'] );
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
		$this->smarty_assign['birth_year_array'] = $this->get_birth_year_for_smarty( null );
		$this->smarty_assign['month_array'] = $this->get_month_array_for_smarty( $month_array );
		$this->smarty_assign['day_array'] = $this->get_day_array_for_smarty( $day_array );
		$this->smarty_assign['root_url'] = '../';
		$this->smarty_assign['post_action'] = 'info.php';
		$this->smarty_assign['team_num'] = 8;
		$this->smarty_assign['tournament_level'] = 3;
		$this->smarty_assign['place_match_no_array'] = $this->get_place_match_no_array_for_smarty(null);
		$this->smarty_assign['dantai_league_array'] = $this->get_dantai_league_array_for_smarty( $series );
		$this->smarty_assign['dantai_league_standing_array'] = $this->get_league_standing_array_for_smarty( null );
		$this->smarty_assign['series'] = $series;
		$this->smarty_assign['series_mw'] = $series_mw;
		$this->smarty_assign['seriesinfo'] = $this->get_series_list( $series );
        //if( $this->smarty_assign['seriesinfo']['advanced'] == 1 ){
    	//	$this->smarty_assign['entry_list'] = $this->get_advanced_entry_array_for_smarty( $series );
        //} else {
		    $this->smarty_assign['entry_list'] = $this->get_entry_array_for_smarty( $series, $series_mw );
		//}
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'new' ){
			//$this->make_new_dantai_tournament_list( $series, $series_mw );
			//$this->load_dantai_tournament_list_csv( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
		} else if( $mode == 'clear' ){
            if( $series_info['enable_clear'] == 1 && $series_info['enable_clear_dt'] == 1 ){
    			//$this->clear_match_info( $series );
				$objTournament->clear_dantai_tournament_match_info( $series );
	    		$league_data = $objLeague->get_dantai_league_list( $series, $series_mw, $league_param );
		    	$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			    //$league_param = $objLeague->get_dantai_league_parameter( $series );
			    $func = 'output_league_'.$series.'_for_HTML';
			    //$func( $series_info, $league_param, $league_data, $entry_list );
			    $func = 'output_league_match_for_HTML2_'.$series;
			    //$func( $series_info, $league_param, $league_data, $entry_list );
    			$tournament_data = $this->get_dantai_tournament_data( $series, $series_mw );
		    	$func = 'output_tournament_' . $series . '_for_HTML';
			    $html = $func( $series_info, $tournament_data, $entry_list, $series_mw );
			    $func = 'output_tournament_match_for_HTML2_'.$series;
			    $func( $series_info, $tournament_data, $entry_list, $series_mw );
            }
/*
			$this->clear_match_info( $series );
			$tournament_data = $this->get_dantai_tournament_data( $series, $series_mw );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list );
			$func = 'output_tournament_match_for_HTML2_'.$series;
			$func( $series_info, $tournament_data, $entry_list );
*/
		} else if( $mode == 'edit' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$_SESSION['p'] = $this->get_entry_one_data( $id );
				$_SESSION['e'] = $this->init_entry_post_data();
				$this->smarty_assign['edit_title'] = 'エントリー編集';
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
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
        } else if( $mode == 'update' || $mode == 'loadcsv' || $mode == 'get_league_advanced' ){
		    if( $mode == 'update' ){
    			$this->update_dantai_tournament_data( $series, $series_mw, $series_info['navi_id'], $_POST );
	    	} else if( $mode == 'loadcsv' ){
    			$post = $objTournament->load_dantai_tournament_csvdata( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
    			$this->update_dantai_tournament_data( $series, $series_mw, $series_info['navi_id'], $post );
	    	} else if( $mode == 'get_league_advanced' ){
    			$post = $objTournament->get_dantai_league_advanced_team( $series, $series_mw, $_POST );
				print_r( $post );
    			//$this->update_dantai_tournament_data( $series, $series_mw, $series_info['navi_id'], $post );
            }
			$this->update_series_place_navi_data( $series_info['navi_id'] );
			//$this->save_tournament_place_navi_data_tbl_file( 20, 21, 20, 21, 22, 23, 4 );
			$tournament_data = $this->get_dantai_tournament_data( $series, $series_mw );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
//print_r($tournament_data);
            //$this->output_dantai_tournament_for_HTML( $series_info, $tournament_data, $entry_list, $series_mw );
			//$this->output_tournament_match_for_HTML2( $this, $series_info, $tournament_data, $entry_list, $series_mw, $series_info['split_tournament_match_output'] );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list, $series_mw );
			$func = 'output_tournament_match_for_HTML2_'.$series;
			$func( $series_info, $tournament_data, $entry_list, $series_mw );
			/*
            if( $series_info['output_match_result_pdf'] == 1 ){
                $allnavi = $this->get_series_place_all_navi_data( $series_info['navi_id'] );
                foreach( $allnavi as $nv ){
                    $objMatch->output_dantai_one_match_pdf2( $series_info['navi_id'], $nv['place_no'], $nv['place_match_no'] ); //, $nv['match_id'] );
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
		}
		$tournament_data = $objTournament->get_dantai_tournament_data( $series, $series_mw );
		$this->smarty_assign['tournament_list'] = $tournament_data;
		$this->smarty_assign['list'] = $this->get_entry_data_list( $series, $series_mw );
//print_r($this->smarty_assign['list']);
		$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty_with_no_match( null, $tournament_data );
//print_r($tournament_data);
		if( $mode == 'output' ){
			$func = 'output_tournament_'.$series.'_for_PDF';
            $func( $series_info, $tournament_data, $this->smarty_assign['list'], $series_mw );
/*
			if( $series == 2 ){
				$pdf = output_tournament_2_for_PDF( $tournament_data[0], $this->smarty_assign['list'], $series_mw );
			} if( $series == 3 ){
				$pdf = output_tournament_2_for_PDF( $tournament_data, $this->smarty_assign['list'], $series_mw );
			}
//echo $pdf;
//exit;
			include( dirname(dirname(dirname(__FILE__)))."/mpdf60/mpdf.php" );
			$mpdf = new mPDF( 'ja+aCJK', 'B4', 5, 'ipa', 10, 10, 10, 10, 0, 0 ); 
			$mpdf->SetDisplayMode( 'fullpage' );

			// LOAD a stylesheet
		//	$stylesheet = file_get_contents( dirname(dirname(dirname(__FILE__))).'/css/mpdfstyleA4.css' );
		//	$mpdf->WriteHTML( $stylesheet, 1 );	// The parameter 1 tells that this is css/style only and no body/html/text

			$mpdf->autoLangToFont = true;
			$mpdf->WriteHTML( $pdf );
		//	header( 'Content-Type: application/octet-stream' );
		//	header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
		//	header( 'Content-Length: '.filesize($file_path) );
		//	ob_end_clean();//ファイル破損エラー防止
			$mpdf->Output( 'output.pdf', 'D' );
//echo $html;
			exit;
*/
		} else if( $mode == 'output_excel_result' ){
			//$func = 'get_tournament_parameter_'.$series;
			//$tournament_param = $func();
            $league_param = $objLeague->get_dantai_league_parameter( $series );
            $tournament_param = $this->get_dantai_tournament_parameter( $series );
			$league_data = $objLeague->get_dantai_league_list( $series, $series_mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );

$params = [
    'series_info'  => $series_info,
    'tournament_param' => $tournament_param,
    'tournament_data' => $tournament_data,
	'league_data' => $league_data, 
	'entry_list' => $entry_list, 
	'series_mw' => $series_mw,
	'lt' => 'dt',
	'mode' => 'output_tournament_match_for_excel',
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
			$func = 'output_tournament_match_'.$series.'_for_excel';
			//$func = 'output_tournament_5_for_excel';
			//$file_path = dirname(dirname(dirname(__FILE__))) . '/output';
			//$file_name = $this->output_dantai_tournament_match_for_excel( $this, $series_info, $tournament_param, $tournament_data, $entry_list );
			$file_name = $func( $this, $series_info, $tournament_param, $tournament_data, $league_data, $entry_list, $series_mw );
			if( $file_name != '' ){
	            $file_path = $series_info['output_path'] . '/' . $file_name;
    	        $ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
        	    $dname = $series_info['dantai_'.$series_mw.'_name'] . 'トーナメント詳細結果.' . $ftime . '.xlsx';

				header( 'Content-Type: application/octet-stream' );
				header( 'Content-Disposition: attachment; filename="'.$dname.'"');
				header( 'Content-Length: '.filesize($file_path) );
				ob_end_clean();//ファイル破損エラー防止
				readfile( $file_path );
				exit;
			}
*/
		} else if( $mode == 'output_excel_chart' ){
			//$func = 'get_tournament_parameter_'.$series;
			//$tournament_param = $func();
            $league_param = $objLeague->get_dantai_league_parameter( $series );
            $tournament_param = $this->get_dantai_tournament_parameter( $series );
			$league_data = $objLeague->get_dantai_league_list( $series, $series_mw, $league_param );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );

$params = [
    'series_info'  => $series_info,
    'tournament_param' => $tournament_param,
    'tournament_data' => $tournament_data,
	'league_data' => $league_data, 
	'entry_list' => $entry_list, 
	'series_mw' => $series_mw,
	'lt' => 'dt',
	'mode' => 'output_tournament_chart_for_excel',
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
			$func = 'output_tournament_chart_'.$series.'_for_excel';
			$file_name = $func( $this, $series_info, $tournament_param, $tournament_data, $league_data, $entry_list, $series_mw );
			if( $file_name != '' ){
	            $file_path = $series_info['output_path'] . '/' . $file_name;
    	        $ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
        	    $dname = $series_info['dantai_'.$series_mw.'_name'] . 'トーナメント表.' . $ftime . '.xlsx';
				//$file_path = dirname(dirname(dirname(__FILE__))) . '/output';
            	//$file_name = $this->output_dantai_tournament_for_excel( $this, $file_path, $series_info, $tournament_param, $tournament_data, $entry_list, $series_mw );
				header( 'Content-Type: application/octet-stream' );
				header( 'Content-Disposition: attachment; filename="'.$dname.'"');
				header( 'Content-Length: '.filesize($file_path) );
				ob_end_clean();//ファイル破損エラー防止
				readfile( $file_path );
				exit;
			}
*/
		} else if( $mode == 'output_excel_prize' ){
			$file_name = $this->output_prize_data_for_excel( $this, dirname(__FILE__), 7, 8, 9, 10 );
			$file_path = dirname(__FILE__) . '/' . $file_name;
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
			header( 'Content-Length: '.filesize($file_path) );
			ob_end_clean();//ファイル破損エラー防止
			readfile( $file_path );
			return;
		} else if( $mode == 'output_excel_prize8' ){
			$file_name = $this->output_prize8_data_for_excel( $this, dirname(__FILE__), 7, 8, 9, 10 );
			$file_path = dirname(__FILE__) . '/' . $file_name;
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
			header( 'Content-Length: '.filesize($file_path) );
			ob_end_clean();//ファイル破損エラー防止
			readfile( $file_path );
			return;
		} else if( $mode == 'update_result' ){
			$tournament_data = $this->get_dantai_tournament_data( $series, $series_mw );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list, $series_mw );
			$func = 'output_tournament_match_for_HTML2_'.$series;
			$func( $series_info, $tournament_data, $entry_list, $series_mw );
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
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'dantai_tournament.html';
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
