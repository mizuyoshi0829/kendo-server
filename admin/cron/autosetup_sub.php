<?php
    require_once dirname(dirname(__FILE__)).'/common/config.php';
    require_once dirname(dirname(__FILE__)).'/common/common.php';
    define( '__DATABASE_UPDATE__', false );

    function get_result_header( $seriesinfo )
    {
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n"
            . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">' . "\n"
            . '<head>' . "\n"
            . '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n"
            . '  <meta http-equiv="Content-Style-Type" content="text/css">' . "\n"
            . '  <meta http-equiv="Pragma" content="no-cache">' . "\n"
            . '  <meta http-equiv="Cache-Control" content="no-cache">' . "\n"
            . '  <title>' . $seriesinfo['name'] . ' 結果速報</title>' . "\n"
            . '  <link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
            . '</head>' . "\n"
            . '<body>' . "\n"
            . '<div class="container">' . "\n";
        return $html;
    }

    function get_result_footer( $seriesinfo )
    {
        $html = '</div>' . "\n"
            . "\n"
            . '<script>' . "\n"
            . '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){' . "\n"
            . '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),' . "\n"
            . '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)' . "\n"
            . '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');' . "\n"
            . "\n"
            . '  ga(\'create\', \'UA-67305136-4\', \'auto\');' . "\n"
            . '  ga(\'send\', \'pageview\');' . "\n"
            . "\n"
            . '</script>' . "\n"
            . "\n"
            . '</body>' . "\n"
            . '</html>' . "\n";
        return $html;
    }
    function setup( $series, $entry )
    {
        $now = time();
        $year = date('Y', $now);
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `series` where `id`=' . $series['series_id'] . ' limit 1';
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) == 0 ){ return false; }
        $index = -1;
        $last_time = 0;
        for( $i1 = 0; $i1 < count($series['series']); $i1++ ){
            $time = strtotime( $year.'-'.$series['series'][$i1]['update_date'] );
            if( $now >= $time ){
                if( $index == -1 || $time > $last_time ){
                    $last_time = $time;
                    $index = $i1;
                }
            }
        }
        if( $index == -1 ){ return false; }
        $series_year = $year;
        if( $series['series'][$index]['index'] != 1 ){
            $series_year .= sprintf( '%02d', $series['series'][$index]['index'] );
        };
        echo 'Series: ',$series['series_id'],' : ',$serieslist[0]['reg_year'],' : ',$series_year,"\n";
        if( $serieslist[0]['reg_year'] == $series_year ){ return false; }
        setup_series( $series, $serieslist, $series_year, $index, $year, $dbs );
        if( $entry != null){
            setup_entry( $entry, $series_year, $dbs );
        }
    }

    function setup_series( $series, $serieslist, $series_year, $index, $year, $dbs )
    {
        $result_path = __RESULT_PATH_BASE__ . $series['result_path'] . '/' . $series_year . '/';
        if( file_exists( $result_path ) ){
            echo 'result path exists: ',$result_path,"\n";
        } else {
            echo 'result path create: ',$result_path,"\n";
            mkdir( $result_path, 0777, true );
        }
        $result_files = [];
        copy( __RESULT_PATH_BASE__.'common/main.css', $result_path.'main.css' );
        copy( __RESULT_PATH_BASE__.'common/preleague_m.css', $result_path.'preleague_m.css' );
        copy( __RESULT_PATH_BASE__.'common/preleague_s.css', $result_path.'preleague_s.css' );
        copy( __RESULT_PATH_BASE__.'common/tri.png', $result_path.'tri.png' );
        $result_files = [
            'year' => $series_year,
            'files' => [
                'main.css',
                'preleague_m.css',
                'preleague_s.css',
                'tri.png'
            ]
        ];
        $name_year = intval($year);
        if( $series['series'][$index]['year_mode'] == 'g' ){
            $name_year -= 2018;
        }
        $sql = 'update `series` set'
            . ' `reg_year`=\'' . $series_year . '\','
            . ' `name`=\'' . $dbs->real_escape_string(sprintf($series['series'][$index]['name'],$name_year)) . '\','
            . ' `name_m`=\'' . $dbs->real_escape_string(sprintf($series['series'][$index]['name_m'],$name_year)) . '\','
            . ' `name_w`=\'' . $dbs->real_escape_string(sprintf($series['series'][$index]['name_w'],$name_year)) . '\','
            . ' `result_path`=\'' . $dbs->real_escape_string(__RESULT_PATH_BASE__ . $series['result_path'] . '/' . $series_year) . '/\','
            . ' `enable_clear`=1,'
            . ' `enable_clear_dl`=1,'
            . ' `enable_clear_dt`=1,'
            . ' `enable_clear_kl`=1,'
            . ' `enable_clear_kt`=1,'
            . ' `locked`=0'
            . ' where `id`=' . $series['series_id'];
        echo $sql,"\n";
        if( __DATABASE_UPDATE__ ){
            db_query( $dbs, $sql );
        }
        $sql = 'select * from `series` where `id`=' . $series['series_id'] . ' limit 1';
        $serieslist_new = db_query_list( $dbs, $sql );

        $result_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n"
            . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">' . "\n"
            . '<head>' . "\n"
            . '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n"
            . '  <meta http-equiv="Content-Style-Type" content="text/css">' . "\n"
            . '  <meta http-equiv="Pragma" content="no-cache">' . "\n"
            . '  <meta http-equiv="Cache-Control" content="no-cache">' . "\n"
            . '  <title>' . $serieslist_new[0]['name'] . ' 結果速報</title>' . "\n"
            . '  <link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
            . '</head>' . "\n"
            . '<body>' . "\n"
            . '<div class="container">' . "\n";
        $result_footer = '</div>' . "\n"
            . "\n"
            . '<script>' . "\n"
            . '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){' . "\n"
            . '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),' . "\n"
            . '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)' . "\n"
            . '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');' . "\n"
            . "\n"
            . '  ga(\'create\', \'UA-67305136-4\', \'auto\');' . "\n"
            . '  ga(\'send\', \'pageview\');' . "\n"
            . "\n"
            . '</script>' . "\n"
            . "\n"
            . '</body>' . "\n"
            . '</html>' . "\n";

        $file = $result_path . 'index.html';
        $fp = fopen( $file, 'w' );
        fwrite( $fp, $result_header );
        $html = '  <div class="content" style="height: 600px;">' . "\n"
            . '    <h1>' . sprintf($series['series'][$index]['name'],$name_year) . '<br />結果速報</h1>' . "\n"
            . '    <a class="abutton" href="index_m.html">男子結果</a>' . "\n"
            . '    <a class="bbutton" href="index_w.html">女子結果</a>' . "\n"
            . '  </div>' . "\n";
        fwrite( $fp, $html );
        fwrite( $fp, $result_footer );
        fclose( $fp );
        chmod( $file, 0666 );
        echo 'result: ',$file,"\n";
        $result_files['files'][] = 'index.html';

        $result_html = [];
        foreach( $series['series'][$index]['kojin'] as $kojin ){
            $mw = $kojin['mw'];
            $league_id = $serieslist_new[0]['kojin_league_'.$mw];
            $tournament_id = $serieslist_new[0]['kojin_tournament_'.$mw];
            if( $league_id == 0 && $tournament_id == 0 ){ continue; }
            if( !isset($result_html[$mw]) ){
                $result_html[$mw] = '';
            }
            $result_html[$mw] .= '    <h2>' . $serieslist_new[0]['kojin_'.$mw.'_name'] .'戦&nbsp;結果</h2>' . "\n";
            if( $league_id > 0 ){
                $result_html[$mw] .= '    <h3><a href="dl_' . $mw . '1.html">リーグ成績表</a></h3>' . "\n";
                foreach( $kojin['league'] as $league ){
/*
                    $match_mum = $league['team_num'] * ($league['team_num'] - 1) / 2;
                    $place_match_info_array = [];
                    $match_info_array = [];
                    $chart_tbl_index = 1;
                    $chart_tbl_index2 = 1;
                    $chart_tbl_array = [];
                    $chart_team_tbl_array = [];
                    for( $i1 = 0; $i1 < $match_mum; $i1++ ){
                        $place_match_info_array[] = sprintf('%d',$i1);
                    }
                    for( $i1 = 0; $i1 < $league['team_num']; $i1++ ){
                        for( $i2 = 0; $i2 < $league['team_num']; $i2++ ){
                            if( $i2 > $i1 ){
                                $match_info_array[] = sprintf('%d',$i1);
                                $match_info_array[] = sprintf('%d',$i2);
                            }
                            if( $i1 > $i2 ){
                                $i3 = $i2 * $league['team_num'] + $i1;
                                $chart_tbl_array[] = $chart_tbl_array[$i3];
                                $chart_team_tbl_array[] = '2';
                            } else if( $i1 == $i2 ){
                                $chart_tbl_array[] = '0';
                                $chart_team_tbl_array[] = '0';
                            } else {
                                $chart_tbl_array[] = sprintf('%d',$chart_tbl_index++);
                                $chart_team_tbl_array[] = '1';
                            }
                        }
                    }
                    $sql = 'INSERT INTO `dantai_league` set '
                        . '`series`=' . $id . ','
                        .' `year`=\'' . $series_year . '\','
                        .' `series_mw`=\'' . $dantai['mw'] . '\','
                        .' `name`=\'' . $dbs->real_escape_string($league['name']) . '\','
                        .' `team_num`=' . $league['team_num'] . ','
                        .' `extra_match_exists`=0,'
                        .' `match_num`=' . $match_mum . ','
                        .' `extra_match_num`=' . $match_mum . ','
                        .' `place_num`=' . $series['series'][$index]['place_num'] . ','
                        .' `advance_num`=' . $league['advance'] . ','
                        .' `match_offset`=0,'
                        .' `display_offset`=0,'
                        .' `place_match_info_array`=\'' . implode(',',$place_match_info_array) . '\','
                        .' `match_info_array`=\'' . implode(',',$match_info_array) . '\','
                        .' `chart_tbl_array`=\'' . implode(',',$chart_tbl_array) . '\','
                        .' `chart_team_tbl_array`=\'' . implode(',',$chart_team_tbl_array) . '\','
                        .' `create_date`=NOW(),'
                        .' `update_date`=NOW(),'
                        .' `del`=0';
                    echo $sql,"\n";
*/
                }
            }
            if( $tournament_id > 0 && isset($kojin['tournament']) ){
                foreach( $kojin['tournament'] as $tournament ){
                    if( $tournament['player_num'] < 2 ){ continue; }
                    $level = 0;
                    for( $i1 = $tournament['player_num']; $i1 > 1; $i1 /= 2 ){
                        $level++;
                    }
                    $sql = 'INSERT INTO `kojin_tournament` set '
                        . '`series`=' . $tournament_id . ','
                        .' `year`=\'' . $series_year . '\','
                        .' `series_mw`=\'' . $mw . '\','
                        .' `no`=' . $tournament['index'] . ','
                        .' `player_num`=' . $tournament['player_num'] . ','
                        .' `tournament_player_num`=' . $tournament['player_num'] . ','
                        .' `match_num`=' . ($tournament['player_num']-1) . ','
                        .' `extra_match_num`=' . $tournament['extra_match_num'] . ','
                        .' `match_level`=' . $level . ','
                        .' `place_num`=' . $series['series'][$index]['place_num'] . ','
                        .' `tournament_name`=\'' . $dbs->real_escape_string($tournament['name']) . '\','
                        .' `extra_name`=\'' . $dbs->real_escape_string($tournament['extra_name']) . '\','
                        .' `relative`=' . $tournament['relative'] . ','
                        .' `relative_start`=' . $tournament['relative_start'] . ','
                        .' `relative_num`=' . $tournament['relative_num'] . ','
                        .' `match_offset`=0,'
                        .' `display_offset`=0,'
                        .' `create_date`=NOW(),'
                        .' `update_date`=NOW(),'
                        .' `del`=0';
                    echo $sql,"\n";
                    if( __DATABASE_UPDATE__ ){
                        db_query( $dbs, $sql );
                    }
                    $result_html[$mw] .= '    <h3><a href="k' . $mw . $tournament['index'] . '.html">トーナメント表';
                    if( $tournament['name'] != '' ){
                        $result_html[$mw] .= '(' . $tournament['name'] . ')';
                    }
                    $result_html[$mw] .= '</a></h3>' . "\n";
                }
                $result_html[$mw] .= '    <br />' . "\n";
                $result_html[$mw] .= '    <br />' . "\n";
            }
        }

        foreach( $series['series'][$index]['dantai'] as $dantai ){
            $mw = $dantai['mw'];
            $league_id = $serieslist_new[0]['dantai_league_'.$mw];
            $tournament_id = $serieslist_new[0]['dantai_tournament_'.$mw];
            if( $league_id == 0 && $tournament_id == 0 ){ continue; }
            if( !isset($result_html[$mw]) ){
                $result_html[$mw] = '';
            }
            $result_html[$mw] .= '    <h2>' . $serieslist_new[0]['dantai_'.$mw.'_name'] .'戦&nbsp;結果</h2>' . "\n";
            if( $league_id > 0 ){
                $result_html[$mw] .= '    <h3><a href="dl_' . $mw . '1.html">リーグ成績表</a></h3>' . "\n";
                foreach( $dantai['league'] as $league ){
                    $match_mum = $league['team_num'] * ($league['team_num'] - 1) / 2;
                    $place_match_info_array = [];
                    $match_info_array = [];
                    $chart_tbl_index = 1;
                    $chart_tbl_index2 = 1;
                    $chart_tbl_array = [];
                    $chart_team_tbl_array = [];
                    for( $i1 = 0; $i1 < $match_mum; $i1++ ){
                        $place_match_info_array[] = sprintf('%d',$i1);
                    }
                    for( $i1 = 0; $i1 < $league['team_num']; $i1++ ){
                        for( $i2 = 0; $i2 < $league['team_num']; $i2++ ){
                            if( $i2 > $i1 ){
                                $match_info_array[] = sprintf('%d',$i1);
                                $match_info_array[] = sprintf('%d',$i2);
                            }
                            if( $i1 > $i2 ){
                                $i3 = $i2 * $league['team_num'] + $i1;
                                $chart_tbl_array[] = $chart_tbl_array[$i3];
                                $chart_team_tbl_array[] = '2';
                            } else if( $i1 == $i2 ){
                                $chart_tbl_array[] = '0';
                                $chart_team_tbl_array[] = '0';
                            } else {
                                $chart_tbl_array[] = sprintf('%d',$chart_tbl_index++);
                                $chart_team_tbl_array[] = '1';
                            }
                        }
                    }
                    $sql = 'INSERT INTO `dantai_league` set '
                        . '`series`=' . $league_id . ','
                        .' `year`=\'' . $series_year . '\','
                        .' `series_mw`=\'' . $mw . '\','
                        .' `no`=' . $league['index'] . ','
                        .' `name`=\'' . $dbs->real_escape_string($league['name']) . '\','
                        .' `team_num`=' . $league['team_num'] . ','
                        .' `extra_match_exists`=0,'
                        .' `match_num`=' . $match_mum . ','
                        .' `extra_match_num`=' . $match_mum . ','
                        .' `place_num`=' . $series['series'][$index]['place_num'] . ','
                        .' `advance_num`=' . $league['advance'] . ','
                        .' `match_offset`=0,'
                        .' `display_offset`=0,'
                        .' `place_match_info_array`=\'' . implode(',',$place_match_info_array) . '\','
                        .' `match_info_array`=\'' . implode(',',$match_info_array) . '\','
                        .' `chart_tbl_array`=\'' . implode(',',$chart_tbl_array) . '\','
                        .' `chart_team_tbl_array`=\'' . implode(',',$chart_team_tbl_array) . '\','
                        .' `create_date`=NOW(),'
                        .' `update_date`=NOW(),'
                        .' `del`=0';
                    echo $sql,"\n";
                    if( __DATABASE_UPDATE__ ){
                        db_query( $dbs, $sql );
                    }
                    $result_html[$mw] .= '    <h3><a href="dlm_' . $mw . $league['index'] . '.html">対戦詳細結果(' . $league['name'] . ')</a></h3>' . "\n";
                }
                $result_html[$mw] .= '    <br />' . "\n";
            }
            if( $tournament_id > 0 ){
                foreach( $dantai['tournament'] as $tournament ){
                    if( $tournament['team_num'] < 2 ){ continue; }
                    $level = 0;
                    for( $i1 = $tournament['team_num']; $i1 > 1; $i1 /= 2 ){
                        $level++;
                    }
                    $sql = 'INSERT INTO `dantai_tournament` set '
                        . '`series`=' . $tournament_id . ','
                        .' `year`=\'' . $series_year . '\','
                        .' `series_mw`=\'' . $mw . '\','
                        .' `no`=' . $tournament['index'] . ','
                        .' `advanced`=0,'
                        .' `sub_league`=1,'
                        .' `team_num`=' . $tournament['team_num'] . ','
                        .' `tournament_team_num`=' . $tournament['team_num'] . ','
                        .' `match_num`=' . ($tournament['team_num']-1) . ','
                        .' `extra_match_num`=' . $tournament['extra_match_num'] . ','
                        .' `extra_name`=\'' . $dbs->real_escape_string($tournament['extra_name']) . '\','
                        .' `match_level`=' . $level . ','
                        .' `place_num`=' . $series['series'][$index]['place_num'] . ','
                        .' `navi_index`=' . $serieslist_new[0]['navi_id'] . ','
                        .' `match_offset`=0,'
                        .' `display_offset`=0,'
                        .' `create_date`=NOW(),'
                        .' `update_date`=NOW(),'
                        .' `del`=0';
                    echo $sql,"\n";
                    if( __DATABASE_UPDATE__ ){
                        db_query( $dbs, $sql );
                    }
                    $result_html[$mw] .= '    <h3><a href="dt_' . $mw . $tournament['index'] . '.html">決勝トーナメント表';
                    if( $tournament['name'] != '' ){
                        $result_html[$mw] .= '(' . $tournament['name'] . ')';
                    }
                    $result_html[$mw] .= '</a>';
                    $result_html[$mw] .= '&nbsp;&nbsp;&nbsp;&nbsp;<a href="dtm_' . $mw . $tournament['index'] . '.html">詳細結果';
                    if( $tournament['name'] != '' ){
                        $result_html[$mw] .= '(' . $tournament['name'] . ')';
                    }
                    $result_html[$mw] .= '</a></h3>' . "\n";
                }
                $result_html[$mw] .= '    <br />' . "\n";
            }
        }

        foreach( $result_html as $mw => $html ){
            $file = 'index_' . $mw . '.html';
            $path = $result_path . $file;
            $fp = fopen( $path, 'w' );
            fwrite( $fp, $result_header );
            fwrite( $fp, '  <div class="content">' . "\n" );
            fwrite( $fp, '    <h1>' . $serieslist_new[0]['name'] . '<br />結果速報</h1>' . "\n" );
            fwrite( $fp, $html );
            fwrite( $fp, '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n" );
            fwrite( $fp, '  </div>' . "\n" );
            fwrite( $fp, $result_footer );
            fclose( $fp );
            chmod( $path, 0666 );
            echo 'result: ',$path,"\n";
            $result_files['files'][] = $file;
        }
        $json = json_encode( $result_files );
        $path = __RESULT_PATH_BASE__ . $series['result_path'] . '/result_files.json';
        $fp = fopen( $path, 'w' );
        fwrite( $fp, $json );
        fclose( $fp );
        chmod( $path, 0666 );
        echo 'result: ',$path,"\n";

        $sql = 'update `navi_input_info` set `match`= 1 where `navi_id`=' . $serieslist_new[0]['navi_id'];
        db_query( $dbs, $sql );
        echo $sql,"\n";
        $sql = 'select * from `navi_input_info` where `navi_id`=' . $serieslist_new[0]['navi_id'] . ' order by `place` asc';
        $inputlist = db_query_list( $dbs, $sql );

        $result = '管理画面'."\n";
        $result .= 'https://www.i-kendo.net/kendo/admin/login.php' . "\n";
        $result .= $serieslist_new[0]['adminpass'] . "\n";
        $result .= "\n";
        $result .= '入力ページ' . "\n";
        $result .= 'https://www.i-kendo.net/kendo/result/' . $series['result_path'] . '/input.php' . "\n";
        $result .= "\n";
        for( $i1 = 1; $i1 <= $series['series'][$index]['place_num']; $i1++ ){
            $result .= '第' . $i1 . '試合場　' . $inputlist[$i1-1]['password'] . "\n";
        }
        $result .= "\n";
        $result .= 'リザルト' . "\n";
        $result .= 'https://i-kendo.info/' . $series['result_path'] . '/' . $series_year . '/' . "\n";
        $result .= '' . "\n";
        $result .= 'リアルタイム' . "\n";
        $result .= 'スコアーボード用' . "\n";
        for( $i1 = 1; $i1 <= $series['series'][$index]['place_num']; $i1++ ){
            $result .= 'https://www.i-kendo.info/realtime/' . $series['result_path'] . '/realtime' . $i1 . '.html' . "\n";
        }
        $result .= '' . "\n";
        $result .= '公開用' . "\n";
        $result .= 'https://www.i-kendo.info/' . $series['result_path'] . '/realtime/realtime.html' . "\n";
        $result .= '' . "\n";
        for( $i1 = 1; $i1 <= $series['series'][$index]['place_num']; $i1++ ){
            $result .= 'https://www.i-kendo.info/' . $series['result_path'] . '/realtime/realtime' . $i1 . '.html' . "\n";
        }
        $result .= '' . "\n";
        $result .= '公開用(リロード版)' . "\n";
        $result .= 'https://www.i-kendo.info/' . $series['result_path'] . '/realtime/realtime.php' . "\n";
        $result .= '' . "\n";
        for( $i1 = 1; $i1 <= $series['series'][$index]['place_num']; $i1++ ){
            $result .= 'https://www.i-kendo.info/' . $series['result_path'] . '/realtime/realtime' . $i1 . '.php' . "\n";
        }
        echo $result;

        mb_language("Japanese");
        mb_internal_encoding("UTF-8");
        $header_info = "From: mizu@pop01.odn.ne.jp\n".
            "Content-Type: text/plain;charset=ISO-2022-JP\n".
            "X-Mailer: PHP/".phpversion();
        $title = $serieslist_new[0]['name'];
        mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $result, $header_info );

        return true;
    }

    function setup_entry( $entry, $series_year, $dbs )
    {
        $disp = [ 58 => 1, 59 => 1, 60 => 1, 61 => 1 ];
        foreach( $entry as $pv )
        {
            $series = $pv[3];
            $d = 0;
            if( $series != 0 ){
                if( isset($disp[$series]) ){
                    $d = $disp[$series]++;
                } else {
                    $d = 1;
                    $disp[$series] = 2;
                }
            }
            $sql = 'INSERT INTO `entry_info` (`series`, `year`, `disp_order`, `create_date`, `update_date`, `del`) VALUES ('.$series.', '.$series_year.', '.$d.', NOW(), NOW(), 0)';
            echo $sql,"\n";
            if( __DATABASE_UPDATE__ ){
                $dbs->query( $sql );
                $id = $dbs->insert_id;
            } else {
                $id = 1230;
            }

            $pref = ( $pv[2] < 50 ) ? $pv[2] : 0;
            $sql = 'INSERT INTO `entry_field` (`series`, `year`, `info`, `field`, `data`) VALUES ( '.$series.', '.$series_year.', '.$id.', \'school_address_pref\', \''.$pref.'\')';
            echo $sql,"\n";
            if( __DATABASE_UPDATE__ ){
                $dbs->query( $sql );
            }

            $sql = 'INSERT INTO `entry_users` (`series`, `info`, `user_name`, `user_pass`, `del`, `create_date`, `update_date`) VALUES ('.$series.', '.$id.', \''.$pv[0].'\', SHA1(\''.$pv[1].'\'), 0, NOW(), NOW())';
            echo $sql,"\n";
            if( __DATABASE_UPDATE__ ){
                $dbs->query( $sql );
            }
        }
    }
    
