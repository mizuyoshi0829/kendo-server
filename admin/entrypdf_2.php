<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'entrypdf_2.php';

	$objPage = new form_page_admin_entrypdf_2();
	if( $objPage != null ){
		$objPage->init(2);
		$objPage->dispatch();
	}
?>
