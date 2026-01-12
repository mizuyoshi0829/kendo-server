<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_2b.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_3.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_4.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_5.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_6.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_9_10.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/admin/reg_14_15.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_kojin_entry.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_kojin_tournament.php';


    //define( '__HTTP_BASE__', 'http://www.i-kendo.net/kendo/');

    session_start();
    $admin = get_field_string_number( $_GET, 'a', 0 );
    $mode = get_field_string( $_POST, 'mode' );
    $objPage = new form_page();
    $objEntry = new form_page_kojin_entry( $objPage );
    $objTournament = new form_page_kojin_tournament( $objPage );

    if( $admin == 1 ){
        $login = get_field_string_number( $_GET, 'lg', 0 );
        if( $login == 1 ){
            $navi_id = get_field_string_number( $_GET, 'v', 0 );
            if( $navi_id == 0 ){ exit; }
            $place = get_field_string_number( $_GET, 'p', 0 );
            if( $place == 0 ){ exit; }
            $place_match_no = get_field_string_number( $_GET, 'm', 0 );
            if( $place_match_no == 0 ){ exit; }
            $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
            $match = $navi_info['match_id'];
            $series = $navi_info['series'];
            $_SESSION['auth_input']['login'] = 1;
            $_SESSION['auth_input']['navi_id'] = $navi_id;
            $_SESSION['auth_input']['series'] = $series;
            $_SESSION['auth_input']['place'] = $place;
            $_SESSION['auth_input']['admin'] = 1;
        } else {
            $navi_id = $_SESSION['auth_input']['navi_id'];
            $place = $_SESSION['auth_input']['place'];
            $series = $_SESSION['auth_input']['series'];
            $place_match_no = get_field_string_number( $_GET, 'm', 0 );
            $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
            $match = $navi_info['match_id'];
        }
    } else {
        if( !isset( $_SESSION['auth_input'] ) ){
            //$_SESSION['auth_input'] = array();
            //header( "Location: ".__HTTP_BASE__."input/");
            exit;
        }
        if( $mode == 'login' ){
            $_SESSION['auth_input']['admin'] = 0;
            if( isset($_POST['exectm']) ){
                $_SESSION['auth_input']['series'] = 9;
            } else if( isset($_POST['exectw']) ){
                $_SESSION['auth_input']['series'] = 10;
            } else {
                header( "Location: ".__HTTP_BASE__."input/");
                exit;
            }
            $pass = get_field_string( $_POST, 'pass' );
            $place = 1;
            $place_match_no = 1;
            foreach( $passtbl as $pv ){
                if( $pass == $pv['pass'] ){
                    $_SESSION['auth_input']['login'] = 1;
                    //$_SESSION['auth_input']['series'] = $pv['series'];
                    $_SESSION['auth_input']['place'] = $pv['place'];
                    $_SESSION['auth_input']['admin'] = 0;
                    $navi = $objPage->get_kojin_place_navi_data( 9, $_SESSION['auth_input']['place'] );
                    if( isset($_POST['execlm']) ){
                        $match = $navi['league_m'][0]['match'];
                        $navimode = 'league_m';
                        $navipos = 1;
                    } else if(isset($_POST['execlw']) ){
                        $match = $navi['league_w'][0]['match'];
                        $navimode = 'league_w';
                        $navipos = 1;
                    } else if( isset($_POST['exect']) ){
                        $match = $navi['tournament'][0]['match'];
                    }
                    $match = $navi[0]['match'];
                    break;
                }
                $place++;
            }
        } else {
            $navi_id = $_SESSION['auth_input']['navi_id'];
            $place = $_SESSION['auth_input']['place'];
            $series = $_SESSION['auth_input']['series'];
            if( isset($_POST['direct_move']) ){
                $match = get_field_string_number( $_POST, 'direct', 0 );
            } else {
                $place_match_no = get_field_string_number( $_GET, 'm', 0 );
                $navi_info = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no );
                $match = $navi_info['match_id'];
            }
            //$navi = $objPage->get_place_navi_data( $_SESSION['auth_input']['place'] );
        }
//print_r($navi_info);
        if( $match == 0 || $_SESSION['auth_input']['login'] != 1 ){
            //header( "Location: ".__HTTP_BASE__."input/");
            exit;
        }
        $place = $_SESSION['auth_input']['place'];
        //$series = $_SESSION['auth_input']['series'];
        $series = $navi_info['series'];
    }
    $place = $_SESSION['auth_input']['place'];
    //$series = $navi_info[$place][$place_match_no]['series'];
    //$series = $_SESSION['auth_input']['series'];
    $series_mw = $navi_info['series_mw'];
    $navi_count = $objPage->get_series_place_navi_data_count( $navi_id, $place );
    $inc = dirname(dirname(__FILE__)) . '/admin/class/admin/reg_s' . $navi_info['series_info_id'] . 'k.php';
    if( file_exists( $inc ) ){
        require_once $inc;
    }

    $series_info = $objPage->get_series_list( $series );
    //    $match = $top_match; //$objPage->get_place_top_match( $param, $place, $series );
    //    if( $match == 0 ){ exit; }

//    $objPage->save_tournament_place_navi_data_tbl_file(
//        7, 8, 7, 8, 9, 10,
//        8
//    );



    //$category = get_field_string_number( $_GET, 'c', 1 );
    //$tournament = get_field_string_number( $_GET, 't', 1 );
    //$match = get_field_string_number( $_GET, 'm', 1 );
    //$admin = get_field_string_number( $_GET, 'a', 0 );

//    $navi = $objPage->get_kojin_tournament_match_navi( $series, $tournament, $match );
/*
    if( $place_match_no > 0 ){
        $navi['prev'] = array( 'm'=>$navi_info[$place][$place_match_no-1]['match'] );
        if( $navi_info[$place][$place_match_no-1]['series'] >= 9 ){
            $navi['prev']['p'] = 'kojin_result.php';
        } else {
            $navi['prev']['p'] = 'dantai_result.php';
        }
    } else {
        $navi['prev'] = array( 'm'=>0, 'p'=>'' );
    }
    if( $place_match_no < count($navi_info[$place]) ){
        $navi['next'] = array( 'm'=>$navi_info[$place][$place_match_no+1]['match'] );
        if( $navi_info[$place][$place_match_no+1]['series'] >= 9 ){
            $navi['next']['p'] = 'kojin_result.php';
        } else {
            $navi['next']['p'] = 'dantai_result.php';
        }
    } else {
        $navi['next'] = array( 'm'=>0, 'p'=>'' );
    }
*/
/*
    if( $place_match_no > 1 ){
        $navi_info['prev'] = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no-1 );
    } else {
        $navi_info['prev'] = null;
    }
    if( $place_match_no < $objPage->get_series_place_navi_data_count( $navi_id, $place ) ){
        $navi_info['next'] = $objPage->get_series_place_navi_data( $navi_id, $place, $place_match_no+1 );
    } else {
        $navi_info['next'] = null;
    }
*/
    $navi_list = $objPage->get_series_place_all_navi_data( $navi_id, $place );
    for( $i1 = 0; $i1 < $navi_count; $i1++ ){
        if( $place_match_no == $navi_list[$i1]['place_match_no'] ){
            if( $i1 > 0 ){
                $navi_info['prev'] = $objPage->get_series_place_navi_data( $navi_id, $place, $navi_list[$i1-1]['place_match_no'] );
            } else {
                $navi_info['prev'] = null;
            }
            if( $navi_count > 1 && $i1 < $navi_count - 1 ){
                $navi_info['next'] = $objPage->get_series_place_navi_data( $navi_id, $place, $navi_list[$i1+1]['place_match_no'] );
            } else {
                $navi_info['next'] = null;
            }
        }
    }

    $data = $objTournament->get_kojin_tournament_one_result( $series, $series_mw, $match );
    $win1str = '';
    $win2str = '';
    if( isset( $_POST['end01'] ) ){
        $fp = fopen( dirname(__FILE__).'/log/'.date('Ymd').'.log', 'a' );
        fwrite( $fp, '['.date('Y/m/d H:i:s')."]--------------------------------------------------\n" );
        fwrite( $fp, 'post:'.print_r( $_POST, true ) );
        fwrite( $fp, 'get:'.print_r( $_GET, true ) );
        fwrite( $fp, 'session:'.print_r( $_SESSION, true )."\n" );
        fwrite( $fp, 'server:'.print_r( $_SERVER, true )."\n" );
        fclose( $fp );
    
        $p = array();
        $p['player1_id'] = get_field_string( $_POST, 'player1_id' );
        $p['player1_entry'] = get_field_string( $_POST, 'player1_entry' );
        $p['player1_name'] = get_field_string( $_POST, 'player1_name' );
        $p['supporter1'] = get_field_string_number( $_POST, 'supporter1', 0 );
        $p['faul1_1'] = get_field_string_number( $_POST, 'faul1_1', 0 );
        $p['faul1_2'] = get_field_string_number( $_POST, 'faul1_2', 0 );
        $p['waza1_1'] = get_field_string_number( $_POST, 'waza1_1', 0 );
        $p['waza1_2'] = get_field_string_number( $_POST, 'waza1_2', 0 );
        $p['waza1_3'] = get_field_string_number( $_POST, 'waza1_3', 0 );
        $p['player2_id'] = get_field_string( $_POST, 'player2_id' );
        $p['player2_entry'] = get_field_string( $_POST, 'player2_entry' );
        $p['player2_name'] = get_field_string( $_POST, 'player2_name' );
        $p['supporter2'] = get_field_string_number( $_POST, 'supporter2', 0 );
        $p['faul2_1'] = get_field_string_number( $_POST, 'faul2_1', 0 );
        $p['faul2_2'] = get_field_string_number( $_POST, 'faul2_2', 0 );
        $p['waza2_1'] = get_field_string_number( $_POST, 'waza2_1', 0 );
        $p['waza2_2'] = get_field_string_number( $_POST, 'waza2_2', 0 );
        $p['waza2_3'] = get_field_string_number( $_POST, 'waza2_3', 0 );
        $p['extra'] = get_field_string_number( $_POST, 'extra', 0 );
        $p['match_time'] = get_field_string( $_POST, 'match_time' );
        $p['end_match'] = 1;
        $p['hon1'] = 0;
        $p['hon2'] = 0;
        for( $i1 = 1; $i1 <= 3; $i1++ ){
            if( $p['waza1_'.$i1] != 0 ){ $p['hon1']++; }
            if( $p['waza2_'.$i1] != 0 ){ $p['hon2']++; }
        }
        if( $p['hon1'] > $p['hon2'] ){
            $win1str = '○';
            $win2str = '△';
            $p['winner'] = 1;
        } else if( $p['hon1'] < $p['hon2'] ){
            $win1str = '△';
            $win2str = '○';
            $p['winner'] = 2;
        } else {
            $win1str = '□';
            $win2str = '□';
        }
        $objTournament->update_kojin_tournament_one_result( $series, $navi_info['lt_id'], $match, $p );
        $tournament_data = $objTournament->get_kojin_tournament_data( $series, $series_mw, $series_info );
        $entry_list = $objPage->get_entry_data_list3( $series, $series_mw );
        $func = 'output_tournament_' . $series . '_for_HTML';
        $html = $func( $series_info, $tournament_data, $entry_list );
        //$func = 'output_tournament_chart_' . $series . '_for_HTML';
        //$html = $func( $tournament_data, $entry_list );
        //$post_url = 'http://49.212.133.48:3000/';
        //$post_data = array(
        //    'pos' => 3,
        //    'value' => $html,
        //);
        //$post_data = http_build_query($post_data, "", "&");
        //$post_options = array('http' => array(
        //    'method' => 'POST',
        //    'content' => $post_data,
        //));
        //$post_options = stream_context_create($post_options);
        //$post_contents = file_get_contents($post_url, false, $post_options);
    } else {
        $p['player1_id'] = get_field_string_number($data['players'][1],'player_info',0) * 0x100 + get_field_string_number($data['players'][1],'player_no',0);
        $p['player1_entry'] = get_field_string( $data['players'][1], 'entry' );
        $p['player1_name'] = get_field_string( $data['players'][1], 'name_str' );
        $p['supporter1'] = get_field_string_number( $data['matches'], 'supporter1', 0 );
        $p['faul1_1'] = get_field_string_number( $data['matches'], 'faul1_1', 0 );
        $p['faul1_2'] = get_field_string_number( $data['matches'], 'faul1_2', 0 );
        $p['waza1_1'] = get_field_string_number( $data['matches'], 'waza1_1', 0 );
        $p['waza1_2'] = get_field_string_number( $data['matches'], 'waza1_2', 0 );
        $p['waza1_3'] = get_field_string_number( $data['matches'], 'waza1_3', 0 );
        $p['player2_id'] = get_field_string_number($data['players'][2],'player_info',0) * 0x100 + get_field_string_number($data['players'][2],'player_no',0);
        $p['player2_entry'] = get_field_string( $data['players'][2], 'entry' );
        $p['player2_name'] = get_field_string( $data['players'][2], 'name_str' );
        $p['supporter2'] = get_field_string_number( $data['matches'], 'supporter2', 0 );
        $p['faul2_1'] = get_field_string_number( $data['matches'], 'faul2_1', 0 );
        $p['faul2_2'] = get_field_string_number( $data['matches'], 'faul2_2', 0 );
        $p['waza2_1'] = get_field_string_number( $data['matches'], 'waza2_1', 0 );
        $p['waza2_2'] = get_field_string_number( $data['matches'], 'waza2_2', 0 );
        $p['waza2_3'] = get_field_string_number( $data['matches'], 'waza2_3', 0 );
        $p['end_match'] = get_field_string_number( $data['matches'], 'end_match', 0 );
        $p['extra'] = get_field_string_number( $data['matches'], 'extra', 0 );
        $p['match_time'] = get_field_string( $data['matches'], 'match_time' );
        $p['winner'] = get_field_string_number( $data['matches'], 'winner', 0 );
        if( $p['winner'] == 1 ){
            $win1str = '○';
            $win2str = '△';
        } else if( $p['winner'] == 2 ){
            $win1str = '△';
            $win2str = '○';
        } else {
            $win1str = '□';
            $win2str = '□';
        }
    }
    //$func = 'output_realtime_html_for_one_board_' . $series;
    //$html = $func( $place, $place_match_no );
    if( $_SESSION['auth_input']['admin'] != 1 ){
        $objPage->update_navi_current_input_match_no( $navi_id, $place, $place_match_no, 0 );
    }
    $contents = file_get_contents(
        __HTTP_BASE__.'result/resultapi.php?n=1&p='.$place.'&v='.$navi_id
    );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>試合結果入力フォーム</title>
<link href="main__.css" rel="stylesheet" type="text/css" />
<link href="result02.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-3.0.0.min.js"></script>
<script type="text/javascript">
var update_flag = false;

function update_realtime( field, value )
{
    update_flag = true;
<?php if( $series_info['locked'] == 0 ): ?>
    $.get(
        "<?php echo __HTTP_BASE__; ?>result/resultapi.php",
        { n: 3, m:<?php echo $match; ?>, fd: field, va: value, p: <?php echo $place; ?>, v: <?php echo $navi_id; ?> }
    );
<?php endif; ?>
}

function change_extra()
{
    var obj1 = document.getElementById("extra");
    if( obj1.checked ){
        update_realtime( "extra", 1 );
    } else {
        update_realtime( "extra", 0 );
    }
}

function change_faul( team, no )
{
    var obj1_1 = document.getElementById("input_faul1_1");
    var obj1_2 = document.getElementById("input_faul1_2");
    var obj2_1 = document.getElementById("input_faul2_1");
    var obj2_2 = document.getElementById("input_faul2_2");
    if( team == 1 ){
        if( no == 1 ){
            update_realtime( "faul1_1", obj1_1.value );
        } else {
            update_realtime( "faul1_2", obj1_2.value );
        }
    } else {
        if( no == 1 ){
            update_realtime( "faul2_1", obj2_1.value );
        } else {
            update_realtime( "faul2_2", obj2_2.value );
        }
    }
}

function change_waza( team, no )
{
    var obj1 = document.getElementById("input_waza1_"+no);
    var obj2 = document.getElementById("input_waza2_"+no);
    if( team == 1 ){
        update_realtime( "waza1_"+no, obj1.value );
    } else {
        update_realtime( "waza2_"+no, obj2.value );
    }
    if( obj1.selectedIndex == 0 && obj2.selectedIndex == 0 ){
        obj1.disabled = false;
        obj2.disabled = false;
        return;
    }
    if( team == 1 ){
        if( obj1.selectedIndex == 0 ){
            obj2.disabled = false;
        } else {
            obj2.disabled = true;
        }
    } else {
        if( obj2.selectedIndex == 0 ){
            obj1.disabled = false;
        } else {
            obj1.disabled = true;
        }
    }
}

function change_supporter( team )
{
    if( team == 1 ){
        var obj = document.getElementById("player1_supporter");
        if( obj.checked ){
            update_realtime( "supporter1", 1 );
        } else {
            update_realtime( "supporter1", 0 );
        }
    } else {
        var obj = document.getElementById( "player2_supporter" );
        if( obj.checked ){
            update_realtime( "supporter2", 1 );
        } else {
            update_realtime( "supporter2", 0 );
        }
    }
}

function jump_direct()
{
    var addr = [
<?php foreach( $navi_list as $nl ): ?>
        '<?php echo $nl['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $nl['place_match_no']; ?>',
<?php endforeach; ?>
    ];
    var obj1 = document.getElementById("direct");
    var match = new Number( obj1.value );
    window.location.href = addr[match-1];
 //'dantai_result.php?a=<?php echo $admin; ?>&m='+obj1.value;
}

function check_update()
{
    if( update_flag ){
        return true;
    } else {
        if( window.confirm('対戦終了ボタンを押していませんが、移動してよろしいでしょうか？') ){
            return true;
        } else {
            return false;
        }
    }
}

<?php if( isset( $_POST['end01'] ) ): ?>
window.onload = function () {
    alert( '対戦終了しました。' );
    update_flag = true;
};
<?php endif; ?>
</script>

</head>

<body>
<!--
<?php //echo $sql2; ?>
<?php //echo $sql3; ?>
<?php //print_r($navi_info); ?>
<?php //print_r($data); ?>
<?php //echo DATABASE_NAME; ?>
-->
<div class="container">
  <div class="content">
    <br />
    <br />
    <br />
    <h1 align="left" class="tx-h1"><?php echo $navi_info['match_name']; ?></h1>
    <h2 align="left" class="tx-h1"><?php echo $navi_info['place_name']; ?>&nbsp;<?php if($admin!=1 && !is_null($navi_info['prev'])): ?><a href="<?php echo $navi_info['prev']['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $navi_info['prev']['place_match_no']; ?>" onClick="return check_update();">←前の試合</a>&nbsp;<?php endif; ?><?php echo $navi_info['place_match_no_name']; ?><?php if($admin!=1 && !is_null($navi_info['next'])): ?>&nbsp;<a href="<?php echo $navi_info['next']['script']; ?>?a=<?php echo $admin; ?>&m=<?php echo $navi_info['next']['place_match_no']; ?>" onClick="return check_update();">次の試合→</a><?php endif; ?><br />
      直接移動: <select name="direct" id="direct" onChange="jump_direct();">
<?php for( $i1 = 1; $i1 <= $navi_count; $i1++ ): ?>
          <option value="<?php echo $i1; ?>"<?php if( $place_match_no == $navi_list[$i1-1]['place_match_no'] ): ?> selected="selected"<?php endif; ?>><?php echo $navi_list[$i1-1]['place_match_no_name']; ?></option>
<?php endfor; ?>
      </select>
    </h2>
    <br />
    <div align="right">
<!--      <input name="edit01" type="button" value="編集" /> -->
    </div>
    <div align="center" class="tbscorein">
    <form action="kojin_result.php?a=<?php echo $admin; ?>&s=<?php echo $series; ?>&t=<?php echo $navi_info['lt_id']; ?>&m=<?php echo $place_match_no; ?>" method="post">
      <input name="place_match_no" type="hidden" value="<?php echo $place_match_no; ?>" />
      <input name="mode" type="hidden" value="update_match" />
      <input name="end_match" type="hidden" value="<?php echo $p['end_match']; ?>" />
      <input name="player1_id" type="hidden" value="<?php echo $p['player1_id']; ?>" />
      <input name="player2_id" type="hidden" value="<?php echo $p['player2_id']; ?>" />
      <table class="tb_score_in" width="960" border="0">
        <tr>
          <td class="tbprefname">学校名</td>
          <td class="tbprefname"><span class="tb_srect">氏名</span></td>
          <td class="tbprefname"><span class="tb_srect">&nbsp</span></td>
          <td class="tbprefname" colspan="3"><span class="tb_srect">&nbsp</span></td>
          <td class="tbprefnamehalf">勝敗</td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf"><span class="tbprefname"><?php echo get_field_string($data['players'][1],'belonging_to_name_str');?></span></td>
          <td class="tbname01 tb_srect"><?php echo $data['players'][1]['name_str'];?></td>
          <td class="tbname01 tb_srect">
<?php if( $series_info['enable_shidou'] == 0 ): ?>
            <input name="faul1_1" type="hidden" value="0" />
<?php else: ?>
            <select name="faul1_1" class="tb_srect" id="input_faul1_1" onChange="change_faul(1,1);">
              <option value="0" <?php if($p['faul1_1']==0): ?>selected="selected"<?php endif; ?>>-</option>
              <option value="2" <?php if($p['faul1_1']==2): ?>selected="selected"<?php endif; ?>>指</option>
            </select>
<?php endif; ?>
            <select name="faul1_2" class="tb_srect" id="input_faul1_2" onChange="change_faul(1,2);">
              <option value="0" <?php if($p['faul1_2']==0): ?>selected="selected"<?php endif; ?>>-</option>
              <option value="1" <?php if($p['faul1_2']==1): ?>selected="selected"<?php endif; ?>>▲</option>
            </select>
          </td>
<?php for( $i1 = 1; $i1 <= 3; $i1++ ): ?>
          <td class="tbname01 tb_srect">
            <select name="waza1_<?php echo $i1; ?>" class="tb_srect" id="input_waza1_<?php echo $i1; ?>"<?php if($p['waza1_'.$i1]==0 && $p['waza2_'.$i1]!=0): ?> disabled="disabled"<?php endif; ?> onChange="change_waza(1,<?php echo $i1; ?>);">
              <option value="0"<?php if($p['waza1_'.$i1]==0): ?> selected="selected"<?php endif; ?>>-</option>
              <option value="1"<?php if($p['waza1_'.$i1]==1): ?> selected="selected"<?php endif; ?>>メ</option>
              <option value="2"<?php if($p['waza1_'.$i1]==2): ?> selected="selected"<?php endif; ?>>ド</option>
              <option value="3"<?php if($p['waza1_'.$i1]==3): ?> selected="selected"<?php endif; ?>>コ</option>
<?php if( $series_info['enable_tsuki'] == 1 ): ?>
              <option value="6"<?php if($p['waza1_'.$i1]==6): ?> selected="selected"<?php endif; ?>>ツ</option>
<?php endif; ?>
              <option value="4"<?php if($p['waza1_'.$i1]==4): ?> selected="selected"<?php endif; ?>>反</option>
              <option value="5"<?php if($p['waza1_'.$i1]==5): ?> selected="selected"<?php endif; ?>>不戦勝</option>
              <option value="7"<?php if($p['waza1_'.$i1]==7): ?> selected="selected"<?php endif; ?>>判</option>
            </select>
          </td>
<?php endfor; ?>
          <td class="tbname01 tb_srect"><div align="center"><?php echo $win1str; ?></div></td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf"><span class="tbprefname"><?php echo get_field_string($data['players'][2],'belonging_to_name_str');?></span></td>
          <td class="tbname01 tb_srect"><?php echo $data['players'][2]['name_str'];?></td>
          <td class="tbname01 tb_srect">
<?php if( $series_info['enable_shidou'] == 0 ): ?>
            <input name="faul2_1" type="hidden" value="0" />
<?php else: ?>
            <select name="faul2_1" class="tb_srect" id="input_faul2_1" onChange="change_faul(2,1);">
              <option value="0" <?php if($p['faul2_1']==0): ?>selected="selected"<?php endif; ?>>-</option>
              <option value="2" <?php if($p['faul2_1']==2): ?>selected="selected"<?php endif; ?>>指</option>
            </select>
<?php endif; ?>
            <select name="faul2_2" class="tb_srect" id="input_faul2_2" onChange="change_faul(2,2);">
              <option value="0" <?php if($p['faul2_2']==0): ?>selected="selected"<?php endif; ?>>-</option>
              <option value="1" <?php if($p['faul2_2']==1): ?>selected="selected"<?php endif; ?>>▲</option>
            </select>
          </td>
<?php for( $i1 = 1; $i1 <= 3; $i1++ ): ?>
          <td class="tbname01 tb_srect">
            <select name="waza2_<?php echo $i1; ?>" class="tb_srect" id="input_waza2_<?php echo $i1; ?>"<?php if($p['waza2_'.$i1]==0 && $p['waza1_'.$i1]!=0): ?> disabled="disabled"<?php endif; ?> onChange="change_waza(2,<?php echo $i1; ?>);">
              <option value="0"<?php if($p['waza2_'.$i1]==0): ?> selected="selected"<?php endif; ?>>-</option>
              <option value="1"<?php if($p['waza2_'.$i1]==1): ?> selected="selected"<?php endif; ?>>メ</option>
              <option value="2"<?php if($p['waza2_'.$i1]==2): ?> selected="selected"<?php endif; ?>>ド</option>
              <option value="3"<?php if($p['waza2_'.$i1]==3): ?> selected="selected"<?php endif; ?>>コ</option>
<?php if( $series_info['enable_tsuki'] == 1 ): ?>
              <option value="6"<?php if($p['waza2_'.$i1]==6): ?> selected="selected"<?php endif; ?>>ツ</option>
<?php endif; ?>
              <option value="4"<?php if($p['waza2_'.$i1]==4): ?> selected="selected"<?php endif; ?>>反</option>
              <option value="5"<?php if($p['waza2_'.$i1]==5): ?> selected="selected"<?php endif; ?>>不戦勝</option>
              <option value="7"<?php if($p['waza2_'.$i1]==7): ?> selected="selected"<?php endif; ?>>判</option>
            </select>
          </td>
<?php endfor; ?>
          <td class="tbname01 tb_srect"><div align="center"><?php echo $win2str; ?></div></td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf">&nbsp;</td>
          <td class="tbname01"><input type="checkbox" name="extra" id="extra" value="1" <?php if($p['extra']==1): ?>checked="checked" <?php endif; ?> onChange="change_extra();" />延長</td>
          <td class="tbname01" colspan="4">
            試合時間：<input name="match_time" type="text" class="" value="<?php echo $p['match_time']; ?>" />
          </td>
          <td class="tbname01 tb_srect">&nbsp;</td>
        </tr>
      </table>
      <br />
<!--      <input name="update_noend" type="submit" class="" id="input_update" value="更新" /> -->
      <br />
      <br />
      <br />
<?php if( $series_info['locked'] == 0 ): ?>
      <input name="end01" type="submit" class="" id="input_update" value="対戦終了" />
<?php endif; ?>
<!--      <input name="input_cancel" type="submit" class="" id="input_cancel" value="中断" /> -->
      </form>
<?php if( $admin == 1 && $_SESSION['auth_input']['admin'] == 1 ): ?>
      <h2 align="left" class="tx-h1"><a href="../admin/kojin_tournament.php?s=<?php echo $series; ?>&mw=<?php echo $series_mw; ?>">←管理画面に戻る</a></h2>
<?php endif; ?>
    <!-- end .content --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
