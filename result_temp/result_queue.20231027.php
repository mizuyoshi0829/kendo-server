<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_entry.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_league.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_tournament.php';
    require_once dirname(dirname(__FILE__)) .'/admin/class/admin/reg_s13d.php';

    /**
     * ライン出力
     * @var string|array
     */
    function line($msg) {
        if (is_array($msg)) {
            foreach ($msg as $item) {
                line($item);
            }
        } else {
            $now = time();
            $y = sprintf( '%04d', intval( date( 'Y', $now ) ) );
            $m = sprintf( '%02d', intval( date( 'm', $now ) ) );
            $d = sprintf( '%02d', intval( date( 'd', $now ) ) );
            if( !is_dir( dirname(__FILE__).'/log/'.$y ) ){
                mkdir( dirname(__FILE__).'/log/'.$y );
            }
            if( !is_dir( dirname(__FILE__).'/log/'.$y.'/'.$y.$m ) ){
                mkdir( dirname(__FILE__).'/log/'.$y.'/'.$y.$m );
            }
            $fp = fopen( dirname(__FILE__).'/log/'.$y.'/'.$y.$m.'/queue_'.$y.$m.$d.'.log', 'a' );
            fwrite( $fp, '['.date('Y/m/d H:i:s', $now).'] '.$msg."\n" );
            fclose( $fp );
        }
    }


    $sapi_type = php_sapi_name();
    if (substr($sapi_type, 0, 3) != 'cli') {
        line('CLI 版の PHP を使用していません');
        exit();
    }

    /**
     * 二重起動排除
     */
    // ロックファイルの確認
    // ファイルがあったら実際にプロセスがあるか確認。
    $lock_file = dirname(__FILE__) . '/result_queue_lock';
    if (is_file($lock_file)) {
        // 同じコマンドを起動しているかの確認
        // 他のプロセスを探し、2つ以上あった場合終了
        // 下記のps, grepも収集してしまうのでgerpを含む行は排除した数で調査
        exec('ps aux | grep "result_queue.php" | grep -v "grep"', $output, $result);
//print_r($output);
        foreach ($output as $key => $row) {
            if (strpos($row, 'grep') !== false) {
                unset($output[$key]);
            }
        }
        if (count($output) > 1) {
            line('二重起動と判定されました。この処理を終了します。');
            exit();
        }
    }
    // ロックファイル作成
    touch($lock_file);

    $url = 'http://133.125.40.139/realtime/realtime_api.php';
    $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
    for(;;){
        $sql = 'SELECT * FROM `result_queue` WHERE `deleted_at` is null ORDER BY `id` ASC';
        $list = db_query_list( $dbs, $sql );
        line('result queue ('.count($list).')');
        if( count($list) == 0 ){ break; }
        foreach( $list as $lv ){
            $series = get_field_string_number( $lv, 'series', 0 );
            $mw = get_field_string( $lv, 'mw' );
            $lt = get_field_string( $lv, 'lt' );
			$output_result = get_field_string_number( $lv, 'output_result', 0 );
			$output_match = get_field_string_number( $lv, 'output_match', 0 );
            if( $series != 0 ){
                $objPage = new form_page();
                $series_info = $objPage->get_series_list( $series );
                if( $lt == 'dl' ){
                    $objLeague = new form_page_dantai_league( $objPage );
                    $league_param = $objLeague->get_dantai_league_parameter( $series );
                    $league_data = $objLeague->get_dantai_league_list( $series, $mw, $league_param );
                    $entry_list = $objPage->get_entry_data_list3( $series, $mw );
                    if( $output_result == 1 ){
                        $func = 'output_league_'.$series.'_for_HTML';
                        $func( $series_info, $league_param, $league_data, $entry_list, $mw );
                    }
                    if( $output_match == 1 ){
                        $func = 'output_league_match_for_HTML2_'.$series;
                        $func( $series_info, $league_param, $league_data, $entry_list, $mw );
                    }
                } else if( $lt == 'dt' ){
                    $objTournament = new form_page_dantai_tournament( $objPage );
                    $tournament_list = $objPage->get_dantai_tournament_data( $series, $mw );
                    $entry_list = $objPage->get_entry_data_list3( $series, $mw );
                    if( $output_result == 1 ){
                        $func = 'output_tournament_' . $series . '_for_HTML';
                        $html = $func( $series_info, $tournament_list, $entry_list, $mw );
                    }
                    if( $output_match == 1 ){
                        $func = 'output_tournament_match_for_HTML2_'.$series;
                        $func( $series_info, $tournament_list, $entry_list, $mw );
                    }
                } else if( $lt == 'kl' ){
                } else if( $lt == 'kt' ){
                }
            }
            $sql = 'update `result_queue` set `deleted_at`=NOW() where `id`=' . $lv['id'];
            db_query( $dbs, $sql );
        }
    }
    db_close( $dbs );

    /**
     * 二重起動排除の終了処理
     */
    // ロックファイルの削除
    unlink($lock_file);
