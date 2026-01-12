<?php
	require_once dirname(__FILE__).'/common/config.php';
	require_once dirname(dirname(dirname(__FILE__))).'/kendo/admin/class/admin/kojin_league.php';

	$objPage = new form_page_admin_kojin_league();
	if( $objPage != null ){
		$series = get_field_string_number( $_GET, 's', 64 );
		$objPage->init($series,0);
		$objPage->dispatch();
	}
?>
