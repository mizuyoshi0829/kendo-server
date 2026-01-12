<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_14_15.php';
    require_once dirname(dirname(__FILE__)) . '/page_kojin_entry.php';
    require_once dirname(dirname(__FILE__)) . '/page_kojin_tournament.php';

class form_page_admin_kojin_tournament extends form_page
{
	function init( $series, $edit )
	{
        $objEntry = new form_page_kojin_entry( $this );
        $objTournament = new form_page_kojin_tournament( $this );

		$page = get_field_string_number( $_GET, 'p', 1 );
		//$series = get_field_string_number( $_GET, 's', 1 );
		$series_mw = get_field_string( $_GET, 'mw', 'm' );
		parent::init( $series, $edit );
		if( $_SESSION['auth']['login'] != 1 ){ exit; }
		if( !isset($_SESSION['auth']['series_info_id']) || $_SESSION['auth']['series_info_id'] == 0 ){ exit; }

        $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'k.php';
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
		//$this->smarty_assign['entry_list'] = $this->get_entry_array_for_smarty( $series, $mw );
		//$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty(null);
		$this->smarty_assign['place_match_no_array'] = $this->get_place_match_no_array_for_smarty(null);
		$this->smarty_assign['series'] = $series;
		$this->smarty_assign['series_mw'] = $series_mw;
		$this->smarty_assign['seriesinfo'] = $series_info; //$this->get_series_list( $series );

		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'new' ){
			$_SESSION['p'] = $this->init_entry_post_data();
			$_SESSION['e'] = $this->init_entry_post_data();
			$this->smarty_assign['edit_title'] = '新規登録';
			$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
			return;
		} else if( $mode == 'clear' ){
            if( $series_info['enable_clear'] == 1 && $series_info['enable_clear_kt'] == 1 ){
    			$this->clear_kojin_match_info( $series );
	    		$tournament_data = $objTournament->get_kojin_tournament_data( $series, $series_mw, $series_info );
		    	$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			    $func = 'output_tournament_' . $series . '_for_HTML';
			    $html = $func( $series_info, $tournament_data, $entry_list );
            }
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
		} else if( $mode == 'update' || $mode == 'loadcsv' ){
		    if( $mode == 'update' ){
		    	$objTournament->update_kojin_tournament_data( $series, $series_mw, $_POST );
	    	} else if( $mode == 'loadcsv' ){
    			$post = $objTournament->load_kojin_tournament_csvdata( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
		    	$objTournament->update_kojin_tournament_data( $series, $series_mw, $post );
            }
			$this->update_series_place_navi_data( $series_info['navi_id'] );
			//$this->save_tournament_place_navi_data_tbl_file( 20, 21, 20, 21, 22, 23, 4 );
			$tournament_data = $objTournament->get_kojin_tournament_data( $series, $series_mw, $series_info );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list );
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
		//} else if( $mode == 'loadcsv' ){
		//	$objTournament->load_kojin_tournament_csvdata( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
		}
		$tournament_data = $objTournament->get_kojin_tournament_data( $series, $series_mw, $this->smarty_assign['seriesinfo'] );
		$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty_with_no_match( null, $tournament_data['data'] );
//print_r($tournament_data);
		$this->smarty_assign['tournament_list'] = $tournament_data['data'];
		$this->smarty_assign['tournament_players'] = $tournament_data['players_for_smarty'];
		if( $mode == 'output' ){
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
			return;
		} else if( $mode == 'output_excel_result' ){
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_'.$series.'_for_excel';

$params = [
    'series_info'  => $series_info,
    'tournament_data' => $tournament_data,
	'entry_list' => $entry_list, 
	'series_mw' => $series_mw,
	'lt' => 'kt',
	'mode' => 'output_tournament_for_excel',
];
$json_params = json_encode($params);
$headers = [
    'Content-Type: application/json',
    'Accept-Charset: UTF-8',
];
$base_url = 'https://www.i-kendo.net/kendo/result/resultexcelapi.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_params);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
echo curl_exec($ch);
curl_close($ch);

/*
			$file_name = $func( $this, $series_info, $tournament_data, $entry_list, $series_mw );
            $file_path = $series_info['output_path'] . '/' . $file_name;
            $ftime = date('YmdHis') . sprintf("%04d",microtime()*1000);
            $dname = $series_info['kojin_'.$series_mw.'_name'] . '結果.' . $ftime . '.xlsx';

			ob_end_clean();//ファイル破損エラー防止
			header( 'Content-Type: application/octet-stream' );
			header( 'Content-Disposition: attachment; filename="'.$dname.'"');
			header( 'Content-Length: '.filesize($file_path) );
			readfile( $file_path );
			exit;
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
			$tournament_data = $objTournament->get_kojin_tournament_data( $series, $series_mw, $series_info );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list );
		    $contents = file_get_contents(
		        __HTTP_BASE__.'result/resultapi.php?n=1&p=0&v='.$series_info['navi_id']
		    );
		}
		$_SESSION['p'] = array();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'kojin_tournament.html';
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
