<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_reg2_index extends form_page
{
	function init($category)
	{
		parent::init($category);

		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'reg' . DIRECTORY_SEPARATOR . 'header2.html';
		$this->footer = 'reg' . DIRECTORY_SEPARATOR . 'footer2.html';

		$this->smarty_assign['prefTbl'] = $this->getPrefTbl();
		$this->smarty_assign['stayTbl'] = $this->getStayTbl();
		$this->smarty_assign['transportTBl'] = $this->getTransportTbl();
		$this->smarty_assign['category_name'] = $this->getCategoryName($category);
		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'confirm' ){
			if( $this->GetReg2FormPostData() == 1 ){
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'confirm2.html';
				return;
			}
		} else if( $mode == 'exec' ){
			if( isset( $_POST['exec'] ) ){
				if( $_SESSION['p']['id'] == 0 ){
					$this->InsertReg2Data();
				} else {
					$this->UpdateReg2Data();
				}
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'complete2.html';
				return;
			} else {
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'form2.html';
				return;
			}
		} else {
			$this->InitReg2PostData($category);
		}
		$this->template = 'reg' . DIRECTORY_SEPARATOR . 'form2.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function InitPostData()
	{
		$_SESSION['p']['id'] = 0;
		$_SESSION['p']['category'] = 0;
		$_SESSION['p']['pref'] = 0;
		$_SESSION['p']['name'] = '';
		$_SESSION['p']['address'] = '';
		$_SESSION['p']['tel'] = '';
		$_SESSION['p']['manager'] = '';
		$_SESSION['p']['referee'] = '';
		$_SESSION['p']['rank'] = '';
		$_SESSION['p']['refereeing_category'] = 0;
		$_SESSION['p']['captain'] = '';
		$_SESSION['p']['player1'] = '';
		$_SESSION['p']['player1_grade'] = '';
		$_SESSION['p']['player2'] = '';
		$_SESSION['p']['player2_grade'] = '';
		$_SESSION['p']['player3'] = '';
		$_SESSION['p']['player3_grade'] = '';
		$_SESSION['p']['player4'] = '';
		$_SESSION['p']['player4_grade'] = '';
		$_SESSION['p']['player5'] = '';
		$_SESSION['p']['player5_grade'] = '';
		$_SESSION['p']['introduction'] = '';
		$_SESSION['p']['main_results'] = '';
		$_SESSION['p']['transport'] = 0;
		$_SESSION['p']['transport_num'] = '';
		$_SESSION['p']['transport_other'] = '';
		$_SESSION['p']['lunch1'] = '';
		$_SESSION['p']['lunch2'] = '';
		$_SESSION['p']['comment'] = '';
		$_SESSION['p']['stay'] = 0;

		$_SESSION['e']['id'] = 0;
		$_SESSION['e']['category'] = 0;
		$_SESSION['e']['pref'] = 0;
		$_SESSION['e']['name'] = '';
		$_SESSION['e']['address'] = '';
		$_SESSION['e']['tel'] = '';
		$_SESSION['e']['manager'] = '';
		$_SESSION['e']['referee'] = '';
		$_SESSION['e']['rank'] = '';
		$_SESSION['e']['refereeing_category'] = 0;
		$_SESSION['e']['captain'] = '';
		$_SESSION['e']['player1'] = '';
		$_SESSION['e']['player1_grade'] = '';
		$_SESSION['e']['player2'] = '';
		$_SESSION['e']['player2_grade'] = '';
		$_SESSION['e']['player3'] = '';
		$_SESSION['e']['player3_grade'] = '';
		$_SESSION['e']['player4'] = '';
		$_SESSION['e']['player4_grade'] = '';
		$_SESSION['e']['player5'] = '';
		$_SESSION['e']['player5_grade'] = '';
		$_SESSION['e']['introduction'] = '';
		$_SESSION['e']['main_results'] = '';
		$_SESSION['e']['transport'] = 0;
		$_SESSION['e']['transport_num'] = '';
		$_SESSION['e']['transport_other'] = '';
		$_SESSION['e']['lunch1'] = '';
		$_SESSION['e']['lunch2'] = '';
		$_SESSION['e']['comment'] = '';
		$_SESSION['e']['stay'] = 0;
	}

	function GetFormPostData()
	{
		$_SESSION['p']['category'] = get_field_string( $_POST, 'category' );
		$_SESSION['p']['pref'] = get_field_string_number( $_POST, 'pref', 0 );
		$_SESSION['p']['pref_name'] = $this->getPrefName( $_SESSION['p']['pref'] );
		$_SESSION['p']['name'] = get_field_string( $_POST, 'name' );
		$_SESSION['p']['address'] = get_field_string( $_POST, 'address' );
		$_SESSION['p']['tel'] = get_field_string( $_POST, 'tel' );
		$_SESSION['p']['manager'] = get_field_string( $_POST, 'manager' );
		$_SESSION['p']['referee'] = get_field_string( $_POST, 'referee' );
		$_SESSION['p']['rank'] = get_field_string( $_POST, 'rank' );
		$_SESSION['p']['refereeing_category'] = get_field_string( $_POST, 'refereeing_category' );
		$_SESSION['p']['captain'] = get_field_string( $_POST, 'captain' );
		$_SESSION['p']['player1'] = get_field_string( $_POST, 'player1' );
		$_SESSION['p']['player1_grade'] = get_field_string( $_POST, 'player1_grade' );
		$_SESSION['p']['player2'] = get_field_string( $_POST, 'player2' );
		$_SESSION['p']['player2_grade'] = get_field_string( $_POST, 'player2_grade' );
		$_SESSION['p']['player3'] = get_field_string( $_POST, 'player3' );
		$_SESSION['p']['player3_grade'] = get_field_string( $_POST, 'player3_grade' );
		$_SESSION['p']['player4'] = get_field_string( $_POST, 'player4' );
		$_SESSION['p']['player4_grade'] = get_field_string( $_POST, 'player4_grade' );
		$_SESSION['p']['player5'] = get_field_string( $_POST, 'player5' );
		$_SESSION['p']['player5_grade'] = get_field_string( $_POST, 'player5_grade' );
		$_SESSION['p']['introduction'] = get_field_string( $_POST, 'introduction' );
		$_SESSION['p']['main_results'] = get_field_string( $_POST, 'main_results' );
		$_SESSION['p']['transport'] = get_field_string_number( $_POST, 'transport', 0 );
		$_SESSION['p']['transport_name'] = $this->getTransportName( $_SESSION['p']['transport'] );
		$_SESSION['p']['transport_num'] = get_field_string( $_POST, 'transport_num' );
		$_SESSION['p']['transport_other'] = get_field_string( $_POST, 'transport_other' );
		$_SESSION['p']['lunch1'] = get_field_string( $_POST, 'lunch1' );
		$_SESSION['p']['lunch2'] = get_field_string( $_POST, 'lunch2' );
		$_SESSION['p']['comment'] = get_field_string( $_POST, 'comment' );
		$_SESSION['p']['stay'] = get_field_string_number( $_POST, 'stay', 0 );
		$_SESSION['p']['stay_name'] = $this->getStayName( $_SESSION['p']['stay'] );

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
