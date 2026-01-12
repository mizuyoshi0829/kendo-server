<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_catalog_3 extends form_page
{
	function init( $category )
	{
		parent::init( 3 );
		if( !isset($_SESSION['auth']) || $_SESSION['auth']['login'] != 1 ){
			exit;
		}

		$org_array = $this->get_org_array();
		$pref_array = $this->get_pref_array();
		$grade_elementary_array = $this->get_grade_elementary_array();
		$pref_name = $this->get_pref_name( $pref_array, get_field_string_number( $_SESSION['p'], 'school_address_pref', 0 ) );
		$this->smarty_assign['name'] = $pref_name . ' ' . get_field_string( $_SESSION['p'], 'school_name' );
		$this->smarty_assign['address'] = $pref_name . ' ' . get_field_string( $_SESSION['p'], 'comment' );
		$this->smarty_assign['tel'] = get_field_string( $_SESSION['p'], 'comment' );
		$this->smarty_assign['manager'] = get_field_string( $_SESSION['p'], 'manager_m_sei' ) . get_field_string( $_SESSION['p'], 'manager_m_mei' );
		$this->smarty_assign['captain'] = get_field_string( $_SESSION['p'], 'captain_m_sei' ) . get_field_string( $_SESSION['p'], 'captain_m_mei' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$this->smarty_assign['player'.$i1]
				= get_field_string( $_SESSION['p'], 'player'.$i1.'_sei' )
					. get_field_string( $_SESSION['p'], 'player'.$i1.'_mei' )
					. ' ' . $this->get_grade_elementary_name( $grade_elementary_array, get_field_string_number( $_SESSION['p'], 'player'.$i1.'_grade', 0 ) );
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
}
?>
