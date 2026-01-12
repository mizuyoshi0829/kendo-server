<?php
require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_login extends form_page
{
	function init( $series, $edit )
	{
		parent::init( $series, $edit );

		$_SESSION['auth'] = array( 'login' => 0 );
		if( isset( $_POST['exec'] ) ){
			if( $_POST['pass'] == __ADMIN_PASSWORD__ ){
				$_SESSION['auth']['login'] = 1;
				$_SESSION['auth']['level'] = 2;
//print_r($_SESSION);
//echo __HTTP_BASE__;
				header( "Location: ".__HTTP_BASE__."admin/info.php");
				exit;
			} else if( $_POST['pass'] == __ADMIN_PASSWORD2__ ){
				$_SESSION['auth']['login'] = 1;
				$_SESSION['auth']['level'] = 1;
				header( "Location: ".__HTTP_BASE__."admin/info.php");
				exit;
			}
		}
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'login.html';
		$this->smarty_assign['display_navi'] = 0;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$this->smarty_assign['seriesinfo'] = $this->get_series_list( $series );
	}

	function dispatch()
	{
		parent::dispatch();
	}
}

?>
