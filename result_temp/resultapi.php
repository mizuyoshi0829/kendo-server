<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/navi.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/current_input_match_no.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_2b.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_3.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_kojin_tournament.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/result2.php';

    header("Access-Control-Allow-Origin: *");
    $no = get_field_string_number( $_GET, 'n', 0 );
    if( $no == 0 ){ return; }
    $navi_id = get_field_string_number( $_GET, 'v', 0 );
    if( $navi_id == 0 ){ return; }
    $place = get_field_string_number( $_GET, 'p', 0 );
    //$reverse = get_field_string_number( $_GET, 'r', 0 );
    $objPage = new form_page();

	$fp = fopen( dirname(__FILE__).'/log/'.date('Ymd').'.log', 'a' );
	fwrite( $fp, '['.date('Y/m/d H:i:s')."]--------------------------------------------------\n" );
	fwrite( $fp, 'post:'.print_r( $_POST, true ) );
	fwrite( $fp, 'get:'.print_r( $_GET, true ) );
	fwrite( $fp, 'session:'.print_r( $_SESSION, true )."\n" );
	fwrite( $fp, 'server:'.print_r( $_SERVER, true )."\n" );
	fwrite( $fp, 'files:'.print_r( $_FILES, true )."\n" );
	fclose( $fp );

    //if( $navi_id != 1 ){ return; }
    $url = 'http://49.212.133.48:3000/';
    $url2 = 'http://133.125.40.139/realtime/realtime_api.php';
    if( $no == 1 ){
        for( $pi = 1; $pi <= 14; $pi++ ){
            if( $place == 0 || $pi == $place ){
                $match = $objPage->get_navi_current_input_match_no( $navi_id, $pi );
                $player = $objPage->get_navi_current_input_match_player_no( $navi_id, $pi );
                if( $match == 0 ){ continue; }
                if( $match == -1 ){ break; }
                $file_write = true;
                if( $match >= 1000 ){
                    $html = output_realtime_html_for_one_board2( $navi_id, $pi, $match );
                } else {
                    if( $navi_id == 6 ){
                        if( $place == 0 ){
                            $html = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, false, 0 );
                            $html2 = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, false, 1 );
                            $html3 = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, false, 0 );
                        } else {
                            $html = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, true, 0 );
                            $html2 = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, true, 1 );
                            $html3 = output_realtime_html_for_one_board_11( $navi_id, $pi, $match, false, 0 );
                        }
                    } else {
                        $html = output_realtime_html_for_one_board( $navi_id, $pi, $match, $player );
                        $html2 = $html;
                    }
                }
                if( $file_write ){
                    $file = dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $pi ) . '.html';
                    $fp = fopen( $file, 'w' );
                    if( $navi_id == 6 ){
                        fwrite( $fp, $html3 );
                    } else {
                        fwrite( $fp, $html );
                    }
	    	        fclose( $fp );
                }
                //$data = array( 'pos' => $pi, 'value' => $html, 'value2' => $html2 );
                //$data = http_build_query( $data, "", "&" );
                //$options = array( 'http' => array( 'method' => 'POST', 'content' => $data ) );
                //$options = stream_context_create( $options );
                //$contents = file_get_contents( $url, false, $options );
//echo "<!--\n".$html."-->\n";
                //$data = [ 'mode' => 1, 'navi' => $navi_id, 'place' => $place, 'value' => $html ];
                //$data = http_build_query( $data, "", "&" );
                //$options = array( 'http' => array( 'method' => 'POST', 'content' => $data ) );
                //$options = stream_context_create( $options );
                //$contents = file_get_contents( $url2, false, $options );
                $data = [
                    'mode' => 1,
                    'navi' => $navi_id,
                    'place' => sprintf('%d',$pi),
                    'file' => dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $pi ) . '.html',
                ];
                $objPage->update_realtime_queue( $data );
            }
        }
    } else if( $no == 2 ){
        $match_id = get_field_string_number( $_GET, 'm', 0 );
        $match_no = get_field_string_number( $_GET, 'mn', 0 );
        $field = get_field_string( $_GET, 'fd' );
        $value = get_field_string_number( $_GET, 'va', 0 );
        if( $match_id != 0 && $field != '' ){
            $objPage->update_dantai_match_one_waza( $match_id, $match_no, $field, $value );
        }
        if( $place == 0 ){ return; }
        $match = $objPage->get_navi_current_input_match_no( $navi_id, $place );
        if( $match == 0 ){ return; }
        if( $match == -1 ){ return; }
        //$html = output_realtime_html_for_one_board( $navi_id, $place, $match );
        if( $match >= 1000 ){
            $html = output_realtime_html_for_one_board2( $navi_id, $place, $match );
        } else {
            if( $navi_id == 6 ){
                $html = output_realtime_html_for_one_board_11( $navi_id, $place, $match );
            } else {
                //$html = output_realtime_html_for_one_board2( $navi_id, $place, $match, $match_no );
                $html = output_realtime_html_for_one_board( $navi_id, $place, $match, $match_no );
            }
        }
        $file = dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $place ) . '.html';
        $fp = fopen( $file, 'w' );
        fwrite( $fp, $html );
        fclose( $fp );
        /*
        $data = array( 'pos' => $place, 'value' => $html, 'value2' => $html );
        $data = http_build_query( $data, "", "&" );
        $options = array( 'http' => array( 'method' => 'POST', 'content' => $data ) );
        $options = stream_context_create( $options );
        $contents = file_get_contents( $url, false, $options );
        $data = [ 'mode' => 1, 'navi' => $navi_id, 'place' => $place, 'value' => $html ];
        $data = http_build_query( $data, "", "&" );
        $options = array( 'http' => array( 'method' => 'POST', 'content' => $data ) );
        $options = stream_context_create( $options );
        $contents = file_get_contents( $url2, false, $options );
        */
        $data = [
            'mode' => 1,
            'navi' => $navi_id,
            'place' => sprintf('%d',$place),
            'file' => dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $place ) . '.html',
        ];
        $objPage->update_realtime_queue( $data );
    } else if( $no == 21 ){
        $tournament_data = $objPage->get_kojin_tournament_data( 11, 'w' );
        $entry_list = $objPage->get_entry_data_list3( 11, 'w' );
        $html = output_tournament_chart_11_for_HTML( $tournament_data, $entry_list );
        $url = 'http://49.212.133.48:3000/';
        $data = array(
            'pos' => 100,
            'value' => $html,
            'value2' => $html,
        );
        $data = http_build_query($data, "", "&");
        $options = array('http' => array(
            'method' => 'POST',
            'content' => $data,
        ));
        $options = stream_context_create($options);
        $contents = file_get_contents($url, false, $options);
    } else if( $no == 3 ){
        $match_id = get_field_string_number( $_GET, 'm', 0 );
        $field = get_field_string( $_GET, 'fd' );
        $value = get_field_string_number( $_GET, 'va', 0 );
        if( $match_id != 0 && $field != '' ){
            $objPage->update_kojin_tournament_one_waza( $match_id, $field, $value );
        }
        if( $place == 0 ){ return; }
        $match = $objPage->get_navi_current_input_match_no( $navi_id, $place );
        if( $match == 0 ){ return; }
        if( $match == -1 ){ return; }
        //$html = output_realtime_html_for_one_board( $navi_id, $place, $match );
        if( $navi_id == 6 ){
            $html = output_realtime_html_for_one_board_11( $navi_id, $place, $match, true, 0 );
            $html2 = output_realtime_html_for_one_board_11( $navi_id, $place, $match, true, 1 );
        } else {
            $html = output_realtime_html_for_one_board( $navi_id, $place, $match );
        }
        $file = dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $place ) . '.html';
        $fp = fopen( $file, 'w' );
        fwrite( $fp, $html );
        fclose( $fp );
        /*
        $data = array( 'pos' => $place, 'value' => $html );
        if( $navi_id == 6 ){
            $data['value2'] = $html2;
        } else {
            $data['value2'] = $html;
        }
        $data = http_build_query( $data, "", "&" );
        $options = array( 'http' => array( 'method' => 'POST', 'content' => $data ) );
        $options = stream_context_create( $options );
        $contents = file_get_contents( $url, false, $options );
        */
        $data = [
            'mode' => 1,
            'navi' => $navi_id,
            'place' => sprintf('%d',$place),
            'file' => dirname(__FILE__) . '/realtime/' . sprintf( '%04d_%02d', $navi_id, $place ) . '.html',
        ];
        $objPage->update_realtime_queue( $data );
    } else if( $no == 4 ){
        $m = get_field_string_number( $_GET, 'm', 0 );
        $f = get_field_string_number( $_GET, 'f', 0 );
        $v = get_field_string_number( $_GET, 'v', 0 );
        if( $m != 0 && $f != '' ){
            $objPage->update_kojin_tournament_one_waza( $m, $f, $v );
        }
        output_realtime_html_for_one_board_11( 2, $__current_input_match_no__[2] );
    }
