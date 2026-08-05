<?php
	require_once dirname(__FILE__).'/class/admin/login.php';
	require_once dirname(__FILE__).'/common/config.php';


	$objPage = new form_page_admin_login();
	if( $objPage != null ){
		$objPage->init(58,0);
		$objPage->dispatch();
	}
?>
