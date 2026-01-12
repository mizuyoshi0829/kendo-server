<?php
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/common.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/config.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/navi.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/common/current_input_match_no.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/admin/reg_11.php';
	require_once dirname(dirname(dirname(dirname(__FILE__)))).'/kendo/admin/class/page.php';

	$no = get_field_string_number( $_GET, 'n', 0 );
	$objPage = new form_page();

	if( $no == 1 ){
		output_realtime_html_for_one_board_11( 1, $__current_input_match_no__[1] );
		output_realtime_html_for_one_board_11( 2, $__current_input_match_no__[2] );
	} else if( $no == 2 ){
		$tournament_data = $objPage->get_kojin_tournament_data( 11, 'w' );
		$entry_list = $objPage->get_entry_data_list3( 11, 'w' );
		$html = output_tournament_chart_11_for_HTML( $tournament_data, $entry_list );
		$url = 'http://49.212.133.48:3000/';
		$data = array(
    		'pos' => 3,
    		'value' => $html,
		);
		$data = http_build_query($data, "", "&");
		$options = array('http' => array(
		    'method' => 'POST',
    		'content' => $data,
		));
		$options = stream_context_create($options);
		$contents = file_get_contents($url, false, $options);
	} else if( $no == 3 ){
		$m = get_field_string_number( $_GET, 'm', 0 );
		$f = get_field_string_number( $_GET, 'f' );
		$v = get_field_string_number( $_GET, 'v', 0 );
		if( $m != 0 && $f != '' ){
			$objPage->update_kojin_tournament_one_waza( $m, $f, $v );
		}
		output_realtime_html_for_one_board_11( 1, $__current_input_match_no__[1] );
	} else if( $no == 4 ){
		$m = get_field_string_number( $_GET, 'm', 0 );
		$f = get_field_string_number( $_GET, 'f' );
		$v = get_field_string_number( $_GET, 'v', 0 );
		if( $m != 0 && $f != '' ){
			$objPage->update_kojin_tournament_one_waza( $m, $f, $v );
		}
		output_realtime_html_for_one_board_11( 2, $__current_input_match_no__[2] );
	}
?>
1
