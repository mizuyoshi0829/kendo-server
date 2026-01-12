<?php
	$dbs = new mysqli( 'localhost', 'kendo-n', '95x9are5ze', 'kendo-n_kendo-n' );
	if( $dbs === false ){
		//接続失敗
		echo 'データベース接続に失敗しました。(1)';
		exit;
	}
	//データベース選択
	$dbs->set_charset( "utf8" );

	$sql = 'select max(`disp_order`) as `max_disp_order` from `entry_info` where `series`=7 and `year`=2016';
?>
