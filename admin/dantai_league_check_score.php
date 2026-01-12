<?php
	require_once dirname(__FILE__).'/common/config.php';
	require_once dirname(dirname(dirname(__FILE__))).'/html/admin/class/admin/dantai_league_check_score.php';

	$objPage = new form_page_admin_dantai_league_check_score();
	if( $objPage != null ){
		$series = get_field_string_number( $_GET, 's', 12 );
		$objPage->init($series,0);
		$objPage->dispatch();
	}
?>
