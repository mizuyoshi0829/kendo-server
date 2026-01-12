<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'reg'.DIRECTORY_SEPARATOR.'index.php';

	$objPage = new form_page_reg_index();
	if( $objPage != null ){
		$objPage->init(3,1);
		$objPage->dispatch();
	}
?>
