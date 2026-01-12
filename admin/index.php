<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'info.php';

	$objPage = new form_page_admin_info();
	if( $objPage != null ){
		$objPage->init(0);
		$objPage->dispatch();
	}
?>
