<?php
	require_once dirname(__FILE__).'/common/config.php';
	require_once dirname(__FILE__).'/class/admin/kojin_tournament.php';

	$objPage = new form_page_admin_kojin_tournament();
	if( $objPage != null ){
		$series = get_field_string_number( $_GET, 's', 14 );
		$objPage->init($series,0);
		$objPage->dispatch();
	}
?>
