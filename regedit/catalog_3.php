<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'catalog_3.php';

	$objPage = new form_page_reg_catalog_3();
	if( $objPage != null ){
		$objPage->init(3);
		$objPage->dispatch();
	}
?>
