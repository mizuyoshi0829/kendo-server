<?php
	require_once dirname(__FILE__).'/common/config.php';
	require_once dirname(__FILE__).'/class/admin/info.php';

	$objPage = new form_page_admin_info();
	if( $objPage != null ){
		$series = get_field_string_number( $_GET, 's', 12 );
		$objPage->init( $series, 0 );
		$objPage->dispatch();
	}
?>
