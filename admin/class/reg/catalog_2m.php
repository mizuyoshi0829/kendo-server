<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_reg_catalog_2m extends form_page
{
	function init( $category )
	{
		parent::init( 2 );
		if( !isset($_SESSION['auth']) || $_SESSION['auth']['login'] != 1 ){
			exit;
		}

		$org_array = $this->get_org_array();
		$pref_array = $this->get_pref_array();
		$grade_junior_array = $this->get_grade_junior_array();
		$pref_name = $this->get_pref_name( $pref_array, get_field_string_number( $_SESSION['p'], 'school_address_pref', 0 ) );
		$this->smarty_assign['name'] = $pref_name . ' ' . get_field_string( $_SESSION['p'], 'school_name' );
		$this->smarty_assign['address'] = $pref_name . ' ' . get_field_string( $_SESSION['p'], 'comment' );
		$this->smarty_assign['tel'] = get_field_string( $_SESSION['p'], 'comment' );
		$this->smarty_assign['manager'] = get_field_string( $_SESSION['p'], 'manager_m_sei' ) . get_field_string( $_SESSION['p'], 'manager_m_mei' );
		$this->smarty_assign['captain'] = get_field_string( $_SESSION['p'], 'captain_m_sei' ) . get_field_string( $_SESSION['p'], 'captain_m_mei' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$this->smarty_assign['player'.$i1]
				= get_field_string( $_SESSION['p'], 'player'.$i1.'_m_sei' )
					. get_field_string( $_SESSION['p'], 'player'.$i1.'_m_mei' )
					. ' ' . $this->get_grade_junior_name( $grade_junior_array, get_field_string_number( $_SESSION['p'], 'player'.$i1.'_grade_m', 0 ) );
		}
		$this->smarty_assign['introduction'] = get_field_string( $_SESSION['p'], 'introduction_m' );
		$this->smarty_assign['main_results'] = get_field_string( $_SESSION['p'], 'main_results_m' );
		$this->template = 'reg' . DIRECTORY_SEPARATOR . 'catalog_2.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function InitPostDataArray()
	{
		$def = $this->get_field_def();
		$data = array();
		$data['id'] = 0;
		foreach( $def as $ld ){
			if( $ld['def'] == 'text' ){
				$data[$ld['field']] = '';
			} else if( $ld['def'] == 'int' ){
				$data[$ld['field']] = 0;
			}
		}
		return $data;
	}

	function InitPostData()
	{
		$_SESSION['p'] = InitPostDataArray();
		$_SESSION['e'] = InitPostDataArray();
	}

	function GetFormPostData()
	{
		$this->get_entry_post_data( $_SESSION['auth']['series'] );
		$this->add_entry_post_data_select_name( $_SESSION['auth']['series'] );
//print_r($_SESSION['p']);
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

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function InsertData()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update information set `disp_id`=`disp_id`+1';
		db_query( $dbs, $sql );

		$sql = 'insert into information set'
			. " `disp_id`=1,"
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
			. " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
			. " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
			. " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
			. " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
			. " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
			. " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
			. " `image_pos`='" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . "',"
			. ' `create_date`=NOW()';
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function UpdateData()
	{
		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update information set'
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
			. " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
			. " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
			. " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
			. " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
			. " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
			. " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
			. " `image_pos`=" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . ""
			. " where `id`=" . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}
}

?>
