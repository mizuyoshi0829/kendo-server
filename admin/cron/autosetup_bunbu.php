<?php
    require_once dirname(dirname(__FILE__)).'/common/config.php';
    require_once dirname(dirname(__FILE__)).'/common/common.php';

    $now = time();
    $year = date('Y', $now);
    $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

    $series_year = $year;
    $result_path_prefix = 'bunbu/' . $series_year;
    $result_path = __RESULT_PATH_BASE__ . $result_path_prefix;
    for( $id = 2; $id <= 3; $id++ ){
        $sql = 'update `series` set'
            . ' `reg_year`=\'' . $series_year . '\','
            . ' `result_path_prefix`=\'' . $dbs->real_escape_string($result_path_prefix) . '\','
            . ' `result_path`=\'' . $dbs->real_escape_string($result_path) . '\','
            . ' `enable_clear`=1,'
            . ' `enable_clear_dl`=1,'
            . ' `enable_clear_dt`=1,'
            . ' `enable_clear_kl`=1,'
            . ' `enable_clear_kt`=1,'
            . ' `locked`=0'
            . ' where `id`=' . $id;
        echo $sql,"\n";
        db_query( $dbs, $sql );
    }
    $sql = 'select * from `series` where `id`=2';
    $serieslist2 = db_query_list( $dbs, $sql );
    if( count( $serieslist2 ) == 0 ){ return exit; }
    $sql = 'select * from `series` where `id`=3';
    $serieslist3 = db_query_list( $dbs, $sql );
    if( count( $serieslist3 ) == 0 ){ return exit; }

    $sql = 'INSERT INTO `dantai_tournament` (`series`, `year`, `series_mw`, `advanced`, `sub_league`, `team_num`, `tournament_team_num`, `match_num`, `extra_match_num`, `match_level`, `place_num`, `navi_index`, `match_offset`, `display_offset`, `create_date`, `update_date`, `del`) VALUES '
        . '(2, ' . $series_year . ', \'m\', 0, 0, 64, 64, 63, 0, 6, 8, 2, 0, 0, NOW(), NOW(), 0),'
        . '(2, ' . $series_year . ', \'w\', 0, 0, 64, 64, 63, 0, 6, 8, 2, 0, 0, NOW(), NOW(), 0)';
    echo $sql,"\n";
    db_query( $dbs, $sql );
    
    $sql = 'INSERT INTO `dantai_tournament` (`series`, `year`, `series_mw`, `advanced`, `sub_league`, `team_num`, `tournament_team_num`, `match_num`, `extra_match_num`, `match_level`, `place_num`, `navi_index`, `match_offset`, `display_offset`, `create_date`, `update_date`, `del`) VALUES '
        . '(3, ' . $series_year . ', \'m\', 1, 0, 32, 32, 31, 0, 5, 8, 0, 0, 0, NOW(), NOW(), 0),'
        . '(3, ' . $series_year . ', \'m\', 1, 0, 32, 32, 31, 0, 5, 8, 0, 0, 0, NOW(), NOW(), 0),'
        . '(3, ' . $series_year . ', \'m\', 1, 0, 32, 32, 31, 0, 5, 8, 0, 0, 0, NOW(), NOW(), 0)';
    echo $sql,"\n";
    db_query( $dbs, $sql );
        
    $sql = 'INSERT INTO `dantai_league` (`series`, `year`, `series_mw`, `name`, `team_num`, `extra_match_exists`, `match_num`, `extra_match_num`, `place_num`, `advance_num`, `match_offset`, `display_offset`, `place_match_info_array`, `match_info_array`, `chart_tbl_array`, `chart_team_tbl_array`, `create_date`, `update_date`, `del`) VALUES '
        . '(3, ' . $series_year . ', \'w\', \' \', 3, 0, 3, 0, 3, 1, 0, 0, \'0,2,1\', \'0,1,0,2,1,2\', \'0,1,2,1,0,3,2,3,0\', \'0,1,1,2,0,1,2,2,0\', NOW(), NOW(), 0)';
    echo $sql,"\n";
    db_query( $dbs, $sql );

    $result_path .= '/';
    if( file_exists( $result_path ) ){
        echo 'result path exists: ',$result_path,"\n";
    } else {
        echo 'result path create: ',$result_path,"\n";
        mkdir( $result_path, 0777, true );
    }
    shell_exec( 'cp -a ' . __RESULT_PATH_BASE__ . 'common/main.css ' . $result_path . 'main.css' );
    shell_exec( 'cp -a ' . __RESULT_PATH_BASE__ . 'common/preleague_m.css ' . $result_path . 'preleague_m.css' );
    shell_exec( 'cp -a ' . __RESULT_PATH_BASE__ . 'common/preleague_s.css ' . $result_path . 'preleague_s.css' );
    shell_exec( 'cp -a ' . __RESULT_PATH_BASE__ . 'common/tri.png ' . $result_path . 'tri.png' );

    $result_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . "\n"
        . '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja" dir="ltr">' . "\n"
        . '<head>' . "\n"
        . '  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . "\n"
        . '  <meta http-equiv="Content-Style-Type" content="text/css">' . "\n"
        . '  <meta http-equiv="Pragma" content="no-cache">' . "\n"
        . '  <meta http-equiv="Cache-Control" content="no-cache">' . "\n"
        . '  <title>' . $series_year . '年 松代藩文武学校剣道大会結果速報</title>' . "\n"
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
        . '    <h1>' . $series_year . '年 松代藩文武学校剣道大会<br />結果速報</h1>' . "\n"
        . '    <div class="cbuttons">' . "\n"
        . '      <a class="cbutton" href="index_ew.html">小学生結果</a>' . "\n"
        . '      <a class="cbutton" href="index_jm.html">中学校男子結果</a>' . "\n"
        . '      <a class="cbutton" href="index_jw.html">中学校女子結果</a>' . "\n"
        . '      <div class="clearfloat"></div>' . "\n"
        . '    </div>' . "\n"
        . '  </div>' . "\n";
    fwrite( $fp, $html );
    fwrite( $fp, $result_footer );
    fclose( $fp );
    chmod( $file, 0666 );
    echo 'result: ',$file,"\n";

    $file = $result_path . 'index_ew.html';
    $fp = fopen( $file, 'w' );
    fwrite( $fp, $result_header );
    $html = '  <div class="content">' . "\n"
      . '    <h1>' . $series_year . '年 松代藩文武学校剣道大会<br />結果速報</h1>' . "\n"
      . '    <h2>小学校団体戦&nbsp;トーナメント&nbsp;結果</h2>' . "\n"
      . '    <h3><a href="dtem1.html">トーナメント表(グループ1)</a></h3>' . "\n"
      . '    <h3><a href="dtem2.html">トーナメント表(グループ2)</a></h3>' . "\n"
      . '    <h3><a href="dtem3.html">トーナメント表(グループ3)</a></h3>' . "\n"
      . '    <br />' . "\n"
      . '    <h3><a href="dtmem1.html">トーナメント詳細結果(グループ1)</a></h3>' . "\n"
      . '    <h3><a href="dtmem2.html">トーナメント詳細結果(グループ2)</a></h3>' . "\n"
      . '    <h3><a href="dtmem3.html">トーナメント詳細結果(グループ3)</a></h3>' . "\n"
      . '    <br />' . "\n"
      . '    <br />' . "\n"
      . '    <br />' . "\n"
      . '    <h2>小学校団体戦&nbsp;決勝リーグ&nbsp;結果</h2>' . "\n"
      . '    <h3><a href="dl_ew1.html">リーグ結果</a></h3>' . "\n"
      . '    <h3><a href="dlm_ew1.html">リーグ詳細結果</a></h3>' . "\n"
      . '    <br />' . "\n"
      . '    <br />' . "\n"
      . '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n"
      . '  </div>' . "\n";
    fwrite( $fp, $html );
    fwrite( $fp, $result_footer );
    fclose( $fp );
    chmod( $file, 0666 );
    echo 'result: ',$file,"\n";

    $file = $result_path . 'index_jm.html';
    $fp = fopen( $file, 'w' );
    fwrite( $fp, $result_header );
    $html = '  <div class="content">' . "\n"
        . '    <h1>' . $series_year . '年 松代藩文武学校剣道大会<br />結果速報</h1>' . "\n"
        . '    <h2>中学校男子団体戦&nbsp;トーナメント&nbsp;結果</h2>' . "\n"
        . '    <h3><a href="dt_jm1.html">トーナメント表</a></h3>' . "\n"
        . '    <br />' . "\n"
        . '    <h3>トーナメント詳細結果：<a href="dtm_jm1_1.html">1回戦～4回戦</a>&nbsp;<a href="dtm_jm1_2.html">準々決勝～決勝</a></h3>' . "\n"
        . '    <br />' . "\n"
        . '    <br />' . "\n"
        . '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n"
        . '  </div>' . "\n";
    fwrite( $fp, $html );
    fwrite( $fp, $result_footer );
    fclose( $fp );
    chmod( $file, 0666 );
    echo 'result: ',$file,"\n";
  
    $file = $result_path . 'index_jw.html';
    $fp = fopen( $file, 'w' );
    fwrite( $fp, $result_header );
    $html = '  <div class="content">' . "\n"
        . '    <h1>' . $series_year . '年 松代藩文武学校剣道大会<br />結果速報</h1>' . "\n"
        . '    <h2>中学校女子団体戦&nbsp;トーナメント&nbsp;結果</h2>' . "\n"
        . '    <h3><a href="dt_jw1.html">トーナメント表</a></h3>' . "\n"
        . '    <br />' . "\n"
        . '    <h3>トーナメント詳細結果：<a href="dtm_jw1_1.html">1回戦～4回戦</a>&nbsp;<a href="dtm_jw1_2.html">準々決勝～決勝</a></h3>' . "\n"
        . '    <br />' . "\n"
        . '    <br />' . "\n"
        . '    <h2 align="left" class="tx-h1"><a href="index.html">←戻る</a></h2>' . "\n"
        . '  </div>' . "\n";
    fwrite( $fp, $html );
    fwrite( $fp, $result_footer );
    fclose( $fp );
    chmod( $file, 0666 );
    echo 'result: ',$file,"\n";

    $sql = 'update `navi_input_info` set `match`= 1 where `navi_id`=1';
    db_query( $dbs, $sql );
    echo $sql,"\n";
    $sql = 'select * from `navi_input_info` where `navi_id`=1 order by `place` asc';
    $inputlist = db_query_list( $dbs, $sql );

    $info = '    IDを持ってない団体の新規申し込み' . "\n"
        . '    中学校' . "\n"
        . '    http://www.i-kendo.net/kendo/reg/bunbu/index.php' . "\n"
        . '    小学校' . "\n"
        . '    http://www.i-kendo.net/kendo/reg/bunbu/index2.php' . "\n"
        . "\n"
        . '    既にIDを持っている団体の申し込み（新規・内容修正）' . "\n"
        . '    中学校' . "\n"
        . '    http://www.i-kendo.net/kendo/regedit/bunbu/index.php' . "\n"
        . '    小学校' . "\n"
        . '    http://www.i-kendo.net/kendo/regedit/bunbu/index2.php' . "\n"
        . "\n"
        . '    管理画面' . "\n"
        . '    https://www.i-kendo.net/kendo/admin/login.php' . "\n"
        . '    中学校: Gx8DWWqidk' . "\n"
        . '    小学校: tCTWlKr3CZ' . "\n"
        . "\n"
        . '    入力ページ' . "\n"
        . '    http://www.i-kendo.net/kendo/result/bunbu/input.php' . "\n"
        . "\n";
    $i1 = 1;
    foreach( $inputlist as $input ){
        $info .= '    第' . $input['place'] . '試合場　' . $input['password'] . "\n";
    }
    $info .= "\n";
    $info .= '    リザルト' . "\n";
    $info .= '    http://www.i-kendo.net/kendo/result/bunbu/' . $series_year . '/' . "\n";
    $info .= '    リザルト公開用' . "\n";
    $info .= '    https://www.i-kendo.info/bunbu/' . $series_year . '/' . "\n";
    $info .= '' . "\n";
    $info .= '    リアルタイム' . "\n";
    $info .= '    スコアーボード用' . "\n";
    foreach( $inputlist as $input ){
        $info .= '    https://www.i-kendo.info/realtime/bunbu/realtime' . $input['place'] . '.html' . "\n";
    }
    $info .= "\n";
    $info .= '    公開用' . "\n";
    $info .= '    小学' . "\n";
    $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime_e.html' . "\n";
    $info .= '    中学' . "\n";
    $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime_j.html' . "\n";
    $info .= "\n";
    foreach( $inputlist as $input ){
        $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime' . $input['place'] . '.html' . "\n";
    }
    $info .= "\n";
    $info .= '    公開用(リロード版)' . "\n";
    $info .= '    小学' . "\n";
    $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime_e.php' . "\n";
    $info .= '    中学' . "\n";
    $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime_j.php' . "\n";
    $info .= "\n";
    foreach( $inputlist as $input ){
        $info .= '    https://www.i-kendo.info/bunbu/realtime/realtime' . $input['place'] . '.php' . "\n";
    }
    $info .= "\n";
    $info .= "\n";
    mb_send_mail( 'mizu@pop01.odn.ne.jp', '松代藩文武学校剣道大会情報', $info );

    $dbs->close();
