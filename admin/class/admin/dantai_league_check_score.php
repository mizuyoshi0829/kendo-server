<?php
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_4.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_7_8.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_9_10.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_12_13.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)) . '/result.php';

class form_page_admin_dantai_league_check_score extends form_page
{
	function init( $series, $edit )
	{
        $objEntry = new form_page_dantai_entry( $this );
        $objMatch = new form_page_dantai_match( $this );
        $objLeague = new form_page_dantai_league( $this );
		$page = get_field_string_number( $_GET, 'p', 1 );
		$category = get_field_string_number( $_GET, 'c', 1 );
		$mw = get_field_string( $_GET, 'mw' );
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
		$this->smarty_assign['display_navi'] = 0;
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
		$this->smarty_assign['birth_year_array'] = $this->get_birth_year_for_smarty( $birth_year_array );
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
		if( $mode == 'approval' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$objMatch->approve_match( $id, 1 );
			}
			//$this->make_new_dantai_tournament_list( $series, $series_mw );
			//$this->load_dantai_tournament_list_csv( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
		} else if( $mode == 'unapproval' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$objMatch->approve_match( $id, 0 );
			}
		}
		$list = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
//print_r($list);
		$this->smarty_assign['league_list'] = $list;
		$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty(null,$list);
		$this->smarty_assign['place_match_no_array'] = $this->get_place_match_no_array_for_smarty(null);
		$this->smarty_assign['place_match_rw_array'] = $this->get_place_match_rw_array_for_smarty(null);
		$_SESSION['p'] = array();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'dantai_league_check_score.html';
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
