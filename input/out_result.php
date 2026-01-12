<?php
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/common/common.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/common/config.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/class/admin/reg_2b.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/class/admin/reg_3.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/class/admin/reg_4.php';
	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/kendo/admin/class/page.php';

	define( '__HTTP_BASE__', 'http://www.nagano-zenchu.jp/');

	$objPage = new form_page();
	$entry_list = $objPage->get_entry_data_list( 4, 'm' );

	echo "男子リーグ戦出力";
	$league_data = $objPage->get_dantai_league_list( 4, 'm' );
	$html = output_league_4_for_HTML( $league_data, $entry_list, 'm' );
	$fp = fopen( 'lm.html', 'w' );
	fwrite( $fp, $html );
	fclose( $fp );

	echo "男子トーナメント出力";
	$tournament_data = $objPage->get_dantai_tournament_data( 4, 'm' );
	$html = output_tournament_4_for_HTML( $tournament_data, $entry_list, 'm' );
	$fp = fopen( 'tm.html', 'w' );
	fwrite( $fp, $html );
	fclose( $fp );

	$entry_list = $objPage->get_entry_data_list( 4, 'w' );
	echo "女子リーグ戦出力";
	$league_data = $objPage->get_dantai_league_list( 4, 'w' );
	$html = output_league_4_for_HTML( $league_data, $entry_list, 'w' );
	$fp = fopen( 'lw.html', 'w' );
	fwrite( $fp, $html );
	fclose( $fp );

	echo "女子トーナメント出力";
	$tournament_data = $objPage->get_dantai_tournament_data( 4, 'w' );
	$html = output_tournament_4_for_HTML( $tournament_data, $entry_list, 'w' );
	$fp = fopen( 'tw.html', 'w' );
	fwrite( $fp, $html );
	fclose( $fp );
?>
