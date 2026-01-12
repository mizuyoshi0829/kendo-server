<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_2b.php';
	//require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_7_8.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)) . '/page_dantai_tournament.php';
    require_once dirname(dirname(__FILE__)) . '/result2.php';

class form_page_admin_dantai_tournament_check_score extends form_page
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
		$this->smarty_assign['team_num'] = 8;
		$this->smarty_assign['tournament_level'] = 3;
		$this->smarty_assign['place_match_no_array'] = $this->get_place_match_no_array_for_smarty(null);
		$this->smarty_assign['dantai_league_array'] = $this->get_dantai_league_array_for_smarty( $series );
		$this->smarty_assign['dantai_league_standing_array'] = $this->get_league_standing_array_for_smarty( null );
		$this->smarty_assign['series'] = $series;
		$this->smarty_assign['series_mw'] = $series_mw;
		$this->smarty_assign['seriesinfo'] = $this->get_series_list( $series );
        if( $this->smarty_assign['seriesinfo']['advanced'] == 1 ){
    		$this->smarty_assign['entry_list'] = $this->get_advanced_entry_array_for_smarty( $series );
        } else {
		    $this->smarty_assign['entry_list'] = $this->get_entry_array_for_smarty( $series, $series_mw );
		}
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
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
		$tournament_data = $objTournament->get_dantai_tournament_data( $series, $series_mw );
		$this->smarty_assign['tournament_list'] = $tournament_data;
		$this->smarty_assign['list'] = $this->get_entry_data_list( $series, $series_mw );
		$this->smarty_assign['place_array'] = $this->get_place_array_for_smarty_with_no_match( null, $tournament_data );
//print_r($tournament_data);
		$_SESSION['p'] = array();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'dantai_tournament_check_score.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

}

?>
