<?php
	require_once dirname(dirname(dirname(__FILE__))).'/admin/class/reg/index.php';

	$objPage = new form_page_reg_index();
	if( $objPage != null ){
		$objPage->init(50,0);
		$objPage->dispatch();
	}
?>
