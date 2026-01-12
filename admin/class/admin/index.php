<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_index extends form_page
{
	function init()
	{
		parent::init();
		$this->smarty_assign['list'] = $this->GetReg1DataList( 1 );
		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'index.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}
}

?>
