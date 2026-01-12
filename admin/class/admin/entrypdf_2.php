<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
	include( dirname(dirname(dirname(__FILE__)))."/mpdf60/mpdf.php" );


class form_page_admin_entrypdf_2 extends form_page
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

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=2';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as &$lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			foreach( $flist as $fv ){
				$lv[$fv['field']] = $fv['data'];
			}
		}


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
		$html = parent::fetch();
		$mpdf = new mPDF( '+aCJK', 'A4', '', '', 32, 25, 27, 25, 16, 13 ); 
		$mpdf->SetDisplayMode( 'fullpage' );

		// LOAD a stylesheet
		$stylesheet = file_get_contents( dirname(dirname(dirname(__FILE__))).'/css/style.css' );
		$mpdf->WriteHTML( $stylesheet, 1 );	// The parameter 1 tells that this is css/style only and no body/html/text

		$mpdf->autoLangToFont = true;
		$mpdf->WriteHTML( $html );
		$mpdf->Output();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

}

?>
