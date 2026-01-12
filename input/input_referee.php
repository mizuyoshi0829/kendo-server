<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/common2.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_dantai_match.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_kojin_tournament.php';
    require_once dirname(dirname(__FILE__)).'/admin/class/page_referee_entry.php';

    session_start();
    $admin = get_field_string_number( $_GET, 'a', 0 );
    $mode = get_field_string( $_POST, 'mode' );
    if( isset( $_GET['p'] ) ){
        $_SESSION['auth_input']['place'] = intval( $_GET['p'] );
    }

    $objPage = new form_page();
    $objEntry = new form_page_referee_entry( $objPage );
    $objDantaiMatch = new form_page_dantai_match( $objPage );
    $objKojinTournament = new form_page_kojin_tournament( $objPage );

//print_r($_SESSION);
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
//echo $navi_id, $place, $place_match_no;
//print_r($navi_info);
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

    $series_info = $objPage->get_series_list( $series );
    $place_num = intval( $series_info['place_num'] );
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
    $navi_list = $objPage->get_series_place_all_navi_data( $navi_id, $place );

    if( !isset( $_SESSION['auth_input']['referee_filter'] ) ){
        $_SESSION['auth_input']['referee_filter'] = array(
            'name' => 1,
            'pref' => 1,
            'degree' => 0,
            'org_pref' => 1,
            'org_pref2' => 0,
            'school' => 1,
            'school2' => 0
        );
    }
    if( $mode == 'check_referee_filter' ){
        $_SESSION['auth_input']['referee_filter']['name'] = get_field_string_number( $_POST, 'filter_name', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['pref'] = get_field_string_number( $_POST, 'filter_pref', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['degree'] = get_field_string_number( $_POST, 'filter_degree', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['org_pref'] = get_field_string_number( $_POST, 'filter_org_pref', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['org_pref2'] = get_field_string_number( $_POST, 'filter_org_pref2', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['school'] = get_field_string_number( $_POST, 'filter_school', 0 ) == 1 ? 1 : 0;
        $_SESSION['auth_input']['referee_filter']['school2'] = get_field_string_number( $_POST, 'filter_school2', 0 ) == 1 ? 1 : 0;
    } else if( $mode == 'change_referee1' ){
        $referee1 = get_field_string_number( $_POST, 'referee1', 0 );
        if( $navi_info['series_lt'] == 'kt' ){
            $objKojinTournament->set_referee( $match, 1, $referee1 );
        } else {
            $objDantaiMatch->set_dantai_referee( $match, 1, $referee1 );
        }
    } else if( $mode == 'change_referee2' ){
        $referee2 = get_field_string_number( $_POST, 'referee2', 0 );
        if( $navi_info['series_lt'] == 'kt' ){
            $objKojinTournament->set_referee( $match, 2, $referee2 );
        } else {
            $objDantaiMatch->set_dantai_referee( $match, 2, $referee2 );
        }
    } else if( $mode == 'change_referee3' ){
        $referee3 = get_field_string_number( $_POST, 'referee3', 0 );
        if( $navi_info['series_lt'] == 'kt' ){
            $objKojinTournament->set_referee( $match, 3, $referee3 );
        } else {
            $objDantaiMatch->set_dantai_referee( $match, 3, $referee3 );
        }
    }

    if( $navi_info['series_lt'] == 'dl' ){
        $data = $objPage->get_dantai_league_one_result( $match );
        $school_address_pref1 = get_field_string_number( $data['entry1'], 'school_address_pref', 0 );
        $school_name1 = get_field_string( $data['entry1'], 'school_name' );
        $insotu1_sei = get_field_string( $data['entry1'], 'insotu1_sei' );
        $insotu1_mei = get_field_string( $data['entry1'], 'insotu1_mei' );
        $insotu1_college = get_field_string( $data['entry1'], 'insotu1_college' );
        $insotu1_org_pref = get_field_string_number( $data['entry1'], 'insotu1_org_pref', 0 );
        $school_address_pref2 = get_field_string_number( $data['entry2'], 'school_address_pref', 0 );
        $school_name2 = get_field_string( $data['entry2'], 'school_name' );
        $insotu2_sei = get_field_string( $data['entry2'], 'insotu1_sei' );
        $insotu2_mei = get_field_string( $data['entry2'], 'insotu1_mei' );
        $insotu2_college = get_field_string( $data['entry2'], 'insotu1_college' );
        $insotu2_org_pref = get_field_string_number( $data['entry2'], 'insotu1_org_pref', 0 );
        $referee1 = get_field_string_number( $data, 'referee1', 0 );
        $referee2 = get_field_string_number( $data, 'referee2', 0 );
        $referee3 = get_field_string_number( $data, 'referee3', 0 );
        $navimode = 'league_' . $series_mw;
    //    $navi = $objPage->get_dantai_league_match_navi( $match );
    } else if( $navi_info['series_lt'] == 'dt' ){
        $data = $objPage->get_dantai_tournament_one_result( $match );
        $school_address_pref1 = get_field_string_number( $data['entry1'], 'school_address_pref', 0 );
        $school_name1 = get_field_string( $data['entry1'], 'school_name' );
        $insotu1_sei = get_field_string( $data['entry1'], 'insotu1_sei' );
        $insotu1_mei = get_field_string( $data['entry1'], 'insotu1_mei' );
        $insotu1_college = get_field_string( $data['entry1'], 'insotu1_college' );
        $insotu1_org_pref = get_field_string_number( $data['entry1'], 'insotu1_org_pref', 0 );
        $school_address_pref2 = get_field_string_number( $data['entry2'], 'school_address_pref', 0 );
        $school_name2 = get_field_string( $data['entry2'], 'school_name' );
        $insotu2_sei = get_field_string( $data['entry2'], 'insotu1_sei' );
        $insotu2_mei = get_field_string( $data['entry2'], 'insotu1_mei' );
        $insotu2_college = get_field_string( $data['entry2'], 'insotu1_college' );
        $insotu2_org_pref = get_field_string_number( $data['entry2'], 'insotu1_org_pref', 0 );
        $referee1 = get_field_string_number( $data, 'referee1', 0 );
        $referee2 = get_field_string_number( $data, 'referee2', 0 );
        $referee3 = get_field_string_number( $data, 'referee3', 0 );
        $navimode = 'tournament';
    //    $navi = $objPage->get_dantai_tournament_match_navi( $match );
    } else if( $navi_info['series_lt'] == 'kt' ){
        $data = $objPage->get_kojin_tournament_one_result( $series, $series_mw, $match );
//print_r($data);
        $school_address_pref1 = get_field_string_number( $data['players'][1]['entry'], 'school_address_pref', 0 );
        $school_name1 = get_field_string( $data['players'][1]['entry'], 'school_name' ) . '&nbsp;(' . get_field_string( $data['players'][1], 'name_str2' ) . ')';
        $insotu1_sei = get_field_string( $data['players'][1]['entry'], 'insotu1_sei' );
        $insotu1_mei = get_field_string( $data['players'][1]['entry'], 'insotu1_mei' );
        $insotu1_college = get_field_string( $data['players'][1]['entry'], 'insotu1_college' );
        $insotu1_org_pref = get_field_string_number( $data['players'][1]['entry'], 'insotu1_org_pref', 0 );
        $school_address_pref2 = get_field_string_number( $data['players'][2]['entry'], 'school_address_pref', 0 );
        $school_name2 = get_field_string( $data['players'][2]['entry'], 'school_name' ) . '&nbsp;(' . get_field_string( $data['players'][2], 'name_str2' ) . ')';
        $insotu2_sei = get_field_string( $data['players'][2]['entry'], 'insotu1_sei' );
        $insotu2_mei = get_field_string( $data['players'][2]['entry'], 'insotu1_mei' );
        $insotu2_college = get_field_string( $data['players'][2]['entry'], 'insotu1_college' );
        $insotu2_org_pref = get_field_string_number( $data['players'][2]['entry'], 'insotu1_org_pref', 0 );
        $referee1 = get_field_string_number( $data, 'referee1', 0 );
        $referee2 = get_field_string_number( $data, 'referee2', 0 );
        $referee3 = get_field_string_number( $data, 'referee3', 0 );
        $navimode = 'kojin';
    } else {
        exit;
    }
    $referee1_data = $objEntry->get_entry_one_data( $referee1 );
    $referee2_data = $objEntry->get_entry_one_data( $referee2 );
    $referee3_data = $objEntry->get_entry_one_data( $referee3 );
	  $referee_degrees = $objEntry->get_degree_array();

    $filter = array();
    if( $_SESSION['auth_input']['referee_filter']['name'] == 1 && $insotu1_sei != '' ){
        $filter['sei1'] = $insotu1_sei;
    }
    if( $_SESSION['auth_input']['referee_filter']['name'] == 1 && $insotu1_mei != '' ){
        $filter['mei1'] = $insotu1_mei;
    }
    if( $_SESSION['auth_input']['referee_filter']['pref'] == 1 && $insotu1_org_pref != '' ){
        $filter['pref1'] = $insotu1_org_pref;
    }
    if( $_SESSION['auth_input']['referee_filter']['org_pref'] == 1 && $insotu1_org_pref != '' ){
        $filter['org_pref11'] = $insotu1_sei;
    }
    if( $_SESSION['auth_input']['referee_filter']['school'] == 1 && $insotu2_college != '' ){
        $filter['school11'] = $insotu1_college;
    }
    if( $_SESSION['auth_input']['referee_filter']['name'] == 1 && $insotu2_sei != '' ){
        $filter['sei2'] = $insotu2_sei;
    }
    if( $_SESSION['auth_input']['referee_filter']['name'] == 1 && $insotu2_mei != '' ){
        $filter['mei2'] = $insotu2_mei;
    }
    if( $_SESSION['auth_input']['referee_filter']['pref'] == 1 && $insotu2_org_pref != '' ){
        $filter['pref2'] = $insotu2_org_pref;
    }
    if( $_SESSION['auth_input']['referee_filter']['org_pref'] == 1 && $insotu2_org_pref != '' ){
        $filter['org_pref21'] = $insotu2_sei;
    }
    if( $_SESSION['auth_input']['referee_filter']['school'] == 1 && $insotu2_college != '' ){
        $filter['school21'] = $insotu2_college;
    }
    $referee_list = $objEntry->search_entry_data( $filter );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>審判員入力フォーム</title>
<link href="main__.css" rel="stylesheet" type="text/css" />
<link href="result02.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-3.0.0.min.js"></script>
<script type="text/javascript">
var update_flag = false;

function jump_direct()
{
    var addr = [
<?php foreach( $navi_list as $nl ): ?>
        'input_referee.php?a=<?php echo $admin; ?>&m=<?php echo $nl['place_match_no']; ?>',
<?php endforeach; ?>
    ];
    var obj1 = document.getElementById("direct");
    var match = new Number( obj1.value );
    window.location.href = addr[match-1];
 //'dantai_result.php?a=<?php echo $admin; ?>&m='+obj1.value;
}

function jump_place()
{
    var addr = [
<?php for( $i1 = 1; $i1 <= $place_num; $i1++ ): ?>
        'input_referee.php?a=<?php echo $admin; ?>&m=1&p=<?php echo $i1; ?>',
<?php endfor; ?>
    ];
    var obj1 = document.getElementById("place");
    var place = new Number( obj1.value );
    window.location.href = addr[place-1];
 //'dantai_result.php?a=<?php echo $admin; ?>&m='+obj1.value;
}

function check_update()
{
    if( update_flag ){
        return true;
    } else {
//        if( window.confirm('終了ボタンを押していませんが、移動してよろしいでしょうか？') ){
            return true;
//        } else {
//            return false;
//        }
    }
}

<?php if( isset( $_POST['end01'] ) ): ?>
window.onload = function () {
    alert( '終了しました。' );
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
-->
<div class="container">
  <div class="content">
    <h1 align="left" class="tx-h1"><?php echo $navi_info[$place_match_no]['match_name']; ?></h1>
    <h2 align="left" class="tx-h1">
      会場: <select name="place" id="place" onChange="jump_place();">
<?php for( $i1 = 1; $i1 <= $place_num; $i1++ ): ?>
        <option value="<?php echo $i1; ?>"<?php if( $i1 == $place ): ?> selected="selected"<?php endif; ?>>第<?php echo $i1; ?>試合場</option>
<?php endfor; ?>
      </select>
&nbsp;<?php if($admin!=1 && !is_null($navi_info['prev'])): ?><a href="input_referee.php?a=<?php echo $admin; ?>&m=<?php echo ($place_match_no-1); ?>" onClick="return check_update();">←前の試合</a>&nbsp;<?php endif; ?><?php echo $navi_info['place_match_no_name']; ?><?php if($admin!=1 && !is_null($navi_info['next'])): ?>&nbsp;<a href="input_referee.php?a=<?php echo $admin; ?>&m=<?php echo ($place_match_no+1); ?>" onClick="return check_update();">次の試合→</a><?php endif; ?><br />
      直接移動: <select name="direct" id="direct" onChange="jump_direct();">
<?php for( $i1 = 1; $i1 <= $navi_count; $i1++ ): ?>
          <option value="<?php echo $i1; ?>"<?php if( $place_match_no == $navi_list[$i1-1]['place_match_no'] ): ?> selected="selected"<?php endif; ?>><?php echo $navi_list[$i1-1]['place_match_no_name']; ?></option>
<?php endfor; ?>
      </select>
    </h2>
    <br />
    <div class="tbscorein">
    <table class="tb_score_in" width="960" border="0">
      <tr>
        <td class="tbprefname"></td>
        <td class="tbnamecolor tbprefnamehalf" colspan="2">学校名</td>
        <td class="tbnamecolor tbprefname" colspan="3"><span class="tb_srect">監督</span></td>
      </tr>
      <tr>
        <td class="tbprefname teamside1">赤</td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname">
            <?php echo $objPage->get_pref_name( null, $school_address_pref1 ); ?>
          </span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $school_name1; ?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $insotu1_sei,'&nbsp;',$insotu1_mei;?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $insotu1_college;?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname">
            <?php echo $objPage->get_pref_name( null, $insotu1_org_pref ); ?>
          </span>
        </td>
      </tr>
      <tr>
        <td class="tbprefname teamside2">白</td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname">
            <?php echo $objPage->get_pref_name( null, $school_address_pref2 ); ?>
          </span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $school_name2; ?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $insotu2_sei,'&nbsp;',$insotu2_mei; ?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname"><?php echo $insotu2_college; ?></span>
        </td>
        <td class="tbnamecolor tbprefnamehalf">
          <span class="tbprefname">
            <?php echo $objPage->get_pref_name( null, $insotu2_org_pref ); ?>
          </span>
        </td>
      </tr>
    </table>
    </div>

    <div class="tbscorein">
    <form action="input_referee.php?a=<?php echo $admin; ?>&p=<?php echo $place; ?>&m=<?php echo $place_match_no; ?>" method="post">
      <input name="mode" type="hidden" value="check_referee_filter">
      <table class="tb_score_in" width="960" border="0">
        <tr>
          <td class="tbnamecolor tbprefnamehalf">検索</td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_name" value="1" <?php if($_SESSION['auth_input']['referee_filter']['name']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />氏名
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_pref" value="1" <?php if($_SESSION['auth_input']['referee_filter']['pref']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />県名
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_degree" value="1" <?php if($_SESSION['auth_input']['referee_filter']['degree']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />段位
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_org_pref" value="1" <?php if($_SESSION['auth_input']['referee_filter']['org_pref']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />出身県
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_org_pref2" value="1" <?php if($_SESSION['auth_input']['referee_filter']['org_pref2']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />出身県2
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_school" value="1" <?php if($_SESSION['auth_input']['referee_filter']['school']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />出身大学
            </span>
          </td>
          <td class="tbnamecolor tbprefnamehalf">
            <span class="tbprefname">
              <input type="checkbox" name="filter_school2" value="1" <?php if($_SESSION['auth_input']['referee_filter']['school2']==1): ?>checked="checked" <?php endif; ?> onClick="submit();" />出身高校
            </span>
          </td>
        </tr>
      </table>
    </form>
    </div>

    <div class="tbscorein">
      <table class="tb_score_in" width="960" border="0">
          <td class="tbnamecolor tbprefnamehalf">&nbsp;</td>
          <td class="tbnamecolor tbprefnamehalf">氏名</td>
          <td class="tbnamecolor tbprefnamehalf">県名</td>
          <td class="tbnamecolor tbprefnamehalf">段位</td>
          <td class="tbnamecolor tbprefnamehalf">出身県</td>
          <td class="tbnamecolor tbprefnamehalf">出身県2</td>
          <td class="tbnamecolor tbprefnamehalf">出身大学</td>
          <td class="tbnamecolor tbprefnamehalf">出身高校</td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf">主審</td>
          <td class="tbnamecolor">
            <form action="input_referee.php?a=<?php echo $admin; ?>&p=<?php echo $place; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee1" />
              <select name="referee1" id="referee1" onChange="submit();">
                <option value="0">------------</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>"<?php if( $rv['id'] == $data['referee1'] ): ?> selected="selected"<?php endif; ?>><?php echo $rv['sei'],'&nbsp;',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee1_data,'pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo $objEntry->get_degree_name( $referee_degrees, get_field_string( $referee1_data,'degree') ); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee1_data,'org_pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee1_data,'org_pref2_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee1_data,'school'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee1_data,'school2'); ?></td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf">副審</td>
          <td class="tbnamecolor">
            <form action="input_referee.php?a=<?php echo $admin; ?>&p=<?php echo $place; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee2" />
              <select name="referee2" id="referee2" onChange="submit();">
                <option value="0">------------</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>"<?php if( $rv['id'] == $data['referee2'] ): ?> selected="selected"<?php endif; ?>><?php echo $rv['sei'],'&nbsp;',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee2_data,'pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo $objEntry->get_degree_name( $referee_degrees, get_field_string( $referee2_data,'degree') ); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee2_data,'org_pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee2_data,'org_pref2_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee2_data,'school'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee2_data,'school2'); ?></td>
        </tr>
        <tr>
          <td class="tbnamecolor tbprefnamehalf">副審</td>
          <td class="tbnamecolor">
            <form action="input_referee.php?a=<?php echo $admin; ?>&p=<?php echo $place; ?>&m=<?php echo $place_match_no; ?>" method="post">
              <input name="mode" type="hidden" value="change_referee3" />
              <select name="referee3" id="referee3" onChange="submit();">
                <option value="0">------------</option>
<?php foreach( $referee_list as $rv ): ?>
                <option value="<?php echo $rv['id']; ?>"<?php if( $rv['id'] == $data['referee3'] ): ?> selected="selected"<?php endif; ?>><?php echo $rv['sei'],'&nbsp;',$rv['mei']; ?></option>
<?php endforeach; ?>
              </select>
            </form>
          </td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee3_data,'pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo $objEntry->get_degree_name( $referee_degrees, get_field_string( $referee3_data,'degree') ); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee3_data,'org_pref_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee3_data,'org_pref2_name'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee3_data,'school'); ?></td>
          <td class="tbnamecolor tbprefnamehalf"><?php echo get_field_string( $referee3_data,'school2'); ?></td>
        </tr>
      </table>
    </div>
  </div>
  <!-- end .container --></div>
</body>
</html>
