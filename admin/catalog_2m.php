<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'catalog_2m.php';

	$objPage = new form_page_admin_catalog_2m();
	if( $objPage != null ){
		$objPage->init(2);
		$objPage->dispatch();
	}
?>
