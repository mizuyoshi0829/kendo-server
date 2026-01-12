<?php
	require_once dirname(__FILE__).'/common/config.php';
	require_once dirname(__FILE__).'/class/admin/dantai_tournament.php';

	$objPage = new form_page_admin_dantai_tournament();
	if( $objPage != null ){
		$series = get_field_string_number( $_GET, 's', 16 );
		$objPage->init($series,0);
		$objPage->dispatch();
	}
?>
