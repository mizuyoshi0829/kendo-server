<?php
/**=========================================================================
* 機能		:	フロントコントローラ起動
* ファイル	:	index.php
* 作成日付	:	2008/06/13
* 作成者	:	MIZUMACHI Yoshihide
**==========================================================================*/
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'Smarty'.DIRECTORY_SEPARATOR.'Smarty.class.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common2.php';
	//require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'config.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'dantai_match_player_info.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'navi.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'current_input_match_no.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'reg_2.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'reg_3.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'reg_4.php';
//-------------------------------------------------------------------
// マルチバイトモジュール設定
//-------------------------------------------------------------------
/*	エンコーディング	*/
	mb_internal_encoding("UTF-8");
/*	オーダー	*/
	mb_detect_order("UTF-8,EUC-JP,ASCII,SJIS,eucJP-win,SJIS-win,JIS,ISO-2022-JP ");
/*	言語	*/
	mb_language("Japanese");
	//date_default_timezone_set( 'Asia/Tokyo' );

//-------------------------------------------------------------------

class form_page
{
	var $configs = array();
	var $smarty = null;
	var $template = '';
	var $smarty_assign = array();
	var $header = '';
	var $footer = '';
	//
	//-- コンストラクタ
	//
	function init( $series, $edit )
	{
		//設定読み込み
		$this->config();
		//セッション開始
		$this->session();
		//データ正規化
		$_POST = convert_encode( $_POST, 'UTF-8', $this->configs['post_encode'] );
		$this->normalize();
		//テンプレート設定
		$this->smarty();

		$fp = fopen(
			dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'log'.DIRECTORY_SEPARATOR.date('Ymd').'.log',
			'a'
		);
		fwrite( $fp, '['.date('Y/m/d H:i:s')."]--------------------------------------------------\n" );
		fwrite( $fp, 'post:'.print_r( $_POST, true ) );
		fwrite( $fp, 'get:'.print_r( $_GET, true ) );
		fwrite( $fp, 'session:'.print_r( $_SESSION, true )."\n" );
		fwrite( $fp, 'server:'.print_r( $_SERVER, true )."\n" );
		fwrite( $fp, 'files:'.print_r( $_FILES, true )."\n" );
		fclose( $fp );

		if( $series == 0 ){
			$_SESSION['auth'] = array( 'login' => 0 );
		}
	}

	function __dispatch()
	{
		if( $this->template == '' ){ return; }
		$this->smarty->assign( 'configs', $this->configs );
		foreach( $this->smarty_assign as $k=>$v ){
			$this->smarty->assign( $k, $v );
		}
		if( $this->header != '' ){
			$this->smarty->assign( 'htmlheader', $this->smarty->fetch( $this->header ) );
		}
		if( $this->footer != '' ){
			$this->smarty->assign( 'htmlfooter', $this->smarty->fetch( $this->footer ) );
		}
	//	$this->smarty->display( $this->template );
	}

	function dispatch()
	{
		$this->__dispatch();
		$this->smarty->display( $this->template );
	}

	function fetch()
	{
		$this->__dispatch();
		return $this->smarty->fetch( $this->template );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	/* セッション開始 */
	function session()
	{
		if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off'){
			$info = parse_url( $this->configs['https_path'] );
		} else {
			$info = parse_url( $this->configs['http_path'] );
		}
	//	session_set_cookie_params( $this->configs['session_lifetime'], $info['path'] );
		session_start();
		return;
	}

	/* テンプレート設定 */
	function smarty()
	{
		$this->smarty = new Smarty();
		$this->smarty->template_dir = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'templates';
		$this->smarty->compile_dir  = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'templates_c';
		$this->smarty->default_modifiers = array('');
		$this->smarty->caching = 0;
	}

	/* データ正規化 */
	function normalize()
	{
		$_GET     = normalize_input( $_GET );
		$_POST    = normalize_input( $_POST );
		$_REQUEST = normalize_input( $_REQUEST );
		$_SERVER  = normalize_input( $_SERVER );
		$_COOKIE  = normalize_input( $_COOKIE );
		return;
	}

	/* 設定読み込み */
	function config()
	{
		$this->configs = array();
		$this->configs['http_path'] = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
		$this->configs['https_path'] = '';
		$this->configs['file_path'] = rtrim( dirname(__FILE__), '/\\' );
		$this->configs['rewrite_mode'] = 0;
		$this->configs['title'] = '';
		$this->configs['back_url'] = '';
		$this->configs['form_url'] = '';

		//スクリプトファイル名
		$this->configs['script_file'] = basename(__FILE__);
		//ダブルクォート変換文字列
		$this->configs['config_quote'] = '"';
		//テンプレート格納ディレクトリ
	//	$this->configs['template_dir'] = 'templates/';
		//コンパイル済みテンプレート格納ディレクトリ
	//	$this->configs['template_compile'] = 'templates_c/';
		$this->configs['form_encode'] = 'UTF-8';
		$this->configs['post_encode'] = 'UTF-8';

		$this->configs['cookie_expire'] = 60 * 60 * 24 * 30;
		//セッションCookieの有効期限
		$this->configs['session_lifetime'] = 0;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function get_dantai_league_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `dantai_league_series` where `del`=0 and `series`='.$series;
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            $lv = $serieslist[0];
			$match_num = intval( $lv['match_num'] );
            $lv['match_info'] = array();
            for( $i1 = 0; $i1 < $match_num - 1; $i1++ ){
                for( $i2 = $i1+1; $i2 < $match_num; $i2++ ){
                    $lv['match_info'][] = array( $i1, $i2 );
                }
            }
			//$lv['place_match_info'] = array( array( 1, 3, 5 ), array( 2, 4, 6 ) );
			$lv['place_match_info'] = array( 1, 2, 0 );
			$lv['chart_tbl'] = array( array( 0, 1, 2 ), array( 1, 0, 3 ), array( 2, 3, 0 ) );
			$lv['chart_team_tbl'] = array( array( 0, 1, 1 ), array( 2, 0, 1 ), array( 2, 2, 0 ) );
            return $lv;
        }
        $func = 'get_league_parameter_'.$series;
        return $func();
	}

	function get_dantai_tournament_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `dantai_tournament_series` where `del`=0 and `series`='.$series;
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            return $serieslist[0];
        }
        $func = 'get_tournament_parameter_'.$series;
        return $func();
	}

	function get_kojin_tournament_parameter( $series )
	{
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `kojin_tournament_series` where `del`=0 and `series`='.$series;
        $serieslist = db_query_list( $dbs, $sql );
        if( count( $serieslist ) > 0 ){
            return $serieslist[0];
        }
        $func = 'get_tournament_parameter_'.$series;
        return $func();
	}

	function get_series_list( $series )
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `series` where `deleted` is null and'
            . ' (`dantai_league_m`='.$series.' or `dantai_league_w`='.$series
            . ' or `dantai_tournament_m`='.$series.' or `dantai_tournament_w`='.$series
            . ' or `kojin_tournament_m`='.$series.' or `kojin_tournament_w`='.$series.')';
        $serieslist = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($serieslist);
        if( count( $serieslist ) == 0 ){ return false; }
        return $serieslist[0];
   }

	function get_series_info( $id )
    {
        if( $id == 0 ){ return array(); }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `series` where `deleted` is null and `id`=' . $id;
        $serieslist = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($serieslist);
        if( count( $serieslist ) == 0 ){ return array(); }
        return $serieslist[0];
   }

	function get_navi_current_input_match_no( $navi_id, $place )
    {
        if( $navi_id == 0 ){ return 0; }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `navi_input_info` where `navi_id`=' . $navi_id . ' and `place`=' . $place;
        $list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($serieslist);
        if( count( $list ) == 0 ){ return 0; }
        return $list[0]['match'];
   }

	function login_navi( $navi_id, $pass )
    {
        if( $navi_id == 0 ){ return 0; }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `navi_input_info` where `navi_id`=' . $navi_id . ' and `password`=' . $pass;
        $list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($serieslist);
        if( count( $list ) == 0 ){ return 0; }
        return $list[0]['place'];
   }

	function update_navi_current_input_match_no( $navi_id, $place, $match )
    {
        if( $navi_id == 0 ){ return -1; }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `navi_input_info` where `navi_id`=' . $navi_id . ' and `place`=' . $place;
        $list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($serieslist);
        if( count( $list ) == 0 ){
            $sql = 'insert into `navi_input_info` set `created`=NOW(),`modified`=NOW(),`navi_id`='.$navi_id.',`place`='.$place.',`match`='.$match;
        } else {
            $sql = 'update `navi_input_info` set `match`='.$match.' where `id`='.$list[0]['id'];
        }
        db_query( $dbs, $sql );
   }

	//---------------------------------------------------------------


	function get_array_for_smarty( $tbl, $top )
	{
		$data = array( 0 => $top );
		foreach( $tbl as $tv ){
			$data[$tv['value']] = $tv['title'];
		}
		return $data;
	}

	function get_name_from_array( $tbl, $no )
	{
		if( $tbl == null ){ return ''; }
		$n = intval($no);
		if( $n == 0 ){ return ''; }
		foreach( $tbl as $tv ){
			if( $tv['value'] == $n ){ return $tv['title']; }
		}
		return '';
	}

	//---------------------------------------------------------------

	function get_pref_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '北海道' ),
			array( 'value' => 2, 'title' => '青森県' ),
			array( 'value' => 3, 'title' => '岩手県' ),
			array( 'value' => 4, 'title' => '宮城県' ),
			array( 'value' => 5, 'title' => '秋田県' ),
			array( 'value' => 6, 'title' => '山形県' ),
			array( 'value' => 7, 'title' => '福島県' ),
			array( 'value' => 8, 'title' => '茨城県' ),
			array( 'value' => 9, 'title' => '栃木県' ),
			array( 'value' => 10, 'title' => '群馬県' ),
			array( 'value' => 11, 'title' => '埼玉県' ),
			array( 'value' => 12, 'title' => '千葉県' ),
			array( 'value' => 13, 'title' => '東京都' ),
			array( 'value' => 14, 'title' => '神奈川県' ),
			array( 'value' => 15, 'title' => '新潟県' ),
			array( 'value' => 16, 'title' => '富山県' ),
			array( 'value' => 17, 'title' => '石川県' ),
			array( 'value' => 18, 'title' => '福井県' ),
			array( 'value' => 19, 'title' => '山梨県' ),
			array( 'value' => 20, 'title' => '長野県' ),
			array( 'value' => 21, 'title' => '岐阜県' ),
			array( 'value' => 22, 'title' => '静岡県' ),
			array( 'value' => 23, 'title' => '愛知県' ),
			array( 'value' => 24, 'title' => '三重県' ),
			array( 'value' => 25, 'title' => '滋賀県' ),
			array( 'value' => 26, 'title' => '京都府' ),
			array( 'value' => 27, 'title' => '大阪府' ),
			array( 'value' => 28, 'title' => '兵庫県' ),
			array( 'value' => 29, 'title' => '奈良県' ),
			array( 'value' => 30, 'title' => '和歌山県' ),
			array( 'value' => 31, 'title' => '鳥取県' ),
			array( 'value' => 32, 'title' => '島根県' ),
			array( 'value' => 33, 'title' => '岡山県' ),
			array( 'value' => 34, 'title' => '広島県' ),
			array( 'value' => 35, 'title' => '山口県' ),
			array( 'value' => 36, 'title' => '徳島県' ),
			array( 'value' => 37, 'title' => '香川県' ),
			array( 'value' => 38, 'title' => '愛媛県' ),
			array( 'value' => 39, 'title' => '高知県' ),
			array( 'value' => 40, 'title' => '福岡県' ),
			array( 'value' => 41, 'title' => '佐賀県' ),
			array( 'value' => 42, 'title' => '長崎県' ),
			array( 'value' => 43, 'title' => '熊本県' ),
			array( 'value' => 44, 'title' => '大分県' ),
			array( 'value' => 45, 'title' => '宮崎県' ),
			array( 'value' => 46, 'title' => '鹿児島県' ),
			array( 'value' => 47, 'title' => '沖縄県' )
		);
		return $tbl;
	}

	function get_pref_array2()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '北海道' ),
			array( 'value' => 2, 'title' => '青森' ),
			array( 'value' => 3, 'title' => '岩手' ),
			array( 'value' => 4, 'title' => '宮城' ),
			array( 'value' => 5, 'title' => '秋田' ),
			array( 'value' => 6, 'title' => '山形' ),
			array( 'value' => 7, 'title' => '福島' ),
			array( 'value' => 8, 'title' => '茨城' ),
			array( 'value' => 9, 'title' => '栃木' ),
			array( 'value' => 10, 'title' => '群馬' ),
			array( 'value' => 11, 'title' => '埼玉' ),
			array( 'value' => 12, 'title' => '千葉' ),
			array( 'value' => 13, 'title' => '東京' ),
			array( 'value' => 14, 'title' => '神奈川' ),
			array( 'value' => 15, 'title' => '新潟' ),
			array( 'value' => 16, 'title' => '富山' ),
			array( 'value' => 17, 'title' => '石川' ),
			array( 'value' => 18, 'title' => '福井' ),
			array( 'value' => 19, 'title' => '山梨' ),
			array( 'value' => 20, 'title' => '長野' ),
			array( 'value' => 21, 'title' => '岐阜' ),
			array( 'value' => 22, 'title' => '静岡' ),
			array( 'value' => 23, 'title' => '愛知' ),
			array( 'value' => 24, 'title' => '三重' ),
			array( 'value' => 25, 'title' => '滋賀' ),
			array( 'value' => 26, 'title' => '京都' ),
			array( 'value' => 27, 'title' => '大阪' ),
			array( 'value' => 28, 'title' => '兵庫' ),
			array( 'value' => 29, 'title' => '奈良' ),
			array( 'value' => 30, 'title' => '和歌山' ),
			array( 'value' => 31, 'title' => '鳥取' ),
			array( 'value' => 32, 'title' => '島根' ),
			array( 'value' => 33, 'title' => '岡山' ),
			array( 'value' => 34, 'title' => '広島' ),
			array( 'value' => 35, 'title' => '山口' ),
			array( 'value' => 36, 'title' => '徳島' ),
			array( 'value' => 37, 'title' => '香川' ),
			array( 'value' => 38, 'title' => '愛媛' ),
			array( 'value' => 39, 'title' => '高知' ),
			array( 'value' => 40, 'title' => '福岡' ),
			array( 'value' => 41, 'title' => '佐賀' ),
			array( 'value' => 42, 'title' => '長崎' ),
			array( 'value' => 43, 'title' => '熊本' ),
			array( 'value' => 44, 'title' => '大分' ),
			array( 'value' => 45, 'title' => '宮崎' ),
			array( 'value' => 46, 'title' => '鹿児島' ),
			array( 'value' => 47, 'title' => '沖縄' )
		);
		return $tbl;
	}

	function get_pref_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_pref_array(); }
		return $this->get_array_for_smarty( $tbl, '都道府県名' );
	}

	function get_pref_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_pref_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_birth_year_array()
	{
		$tbl = array(
			array( 'value' => 2003, 'title' => '2003年' ),
			array( 'value' => 2002, 'title' => '2002年' ),
			array( 'value' => 2001, 'title' => '2001年' ),
			array( 'value' => 2000, 'title' => '2000年' ),
			array( 'value' => 1999, 'title' => '1999年' )
		);
		return $tbl;
	}

	function get_birth_year_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_birth_year_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_birth_year_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_birth_year_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_month_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '1月' ),
			array( 'value' => 2, 'title' => '2月' ),
			array( 'value' => 3, 'title' => '3月' ),
			array( 'value' => 4, 'title' => '4月' ),
			array( 'value' => 5, 'title' => '5月' ),
			array( 'value' => 6, 'title' => '6月' ),
			array( 'value' => 7, 'title' => '7月' ),
			array( 'value' => 8, 'title' => '8月' ),
			array( 'value' => 9, 'title' => '9月' ),
			array( 'value' => 10, 'title' => '10月' ),
			array( 'value' => 11, 'title' => '11月' ),
			array( 'value' => 12, 'title' => '12月' ),
		);
		return $tbl;
	}

	function get_month_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_month_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_month_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_month_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_day_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '1日' ),
			array( 'value' => 2, 'title' => '2日' ),
			array( 'value' => 3, 'title' => '3日' ),
			array( 'value' => 4, 'title' => '4日' ),
			array( 'value' => 5, 'title' => '5日' ),
			array( 'value' => 6, 'title' => '6日' ),
			array( 'value' => 7, 'title' => '7日' ),
			array( 'value' => 8, 'title' => '8日' ),
			array( 'value' => 9, 'title' => '9日' ),
			array( 'value' => 10, 'title' => '10日' ),
			array( 'value' => 11, 'title' => '11日' ),
			array( 'value' => 12, 'title' => '12日' ),
			array( 'value' => 13, 'title' => '13日' ),
			array( 'value' => 14, 'title' => '14日' ),
			array( 'value' => 15, 'title' => '15日' ),
			array( 'value' => 16, 'title' => '16日' ),
			array( 'value' => 17, 'title' => '17日' ),
			array( 'value' => 18, 'title' => '18日' ),
			array( 'value' => 19, 'title' => '19日' ),
			array( 'value' => 20, 'title' => '20日' ),
			array( 'value' => 21, 'title' => '21日' ),
			array( 'value' => 22, 'title' => '22日' ),
			array( 'value' => 23, 'title' => '23日' ),
			array( 'value' => 24, 'title' => '24日' ),
			array( 'value' => 25, 'title' => '25日' ),
			array( 'value' => 26, 'title' => '26日' ),
			array( 'value' => 27, 'title' => '27日' ),
			array( 'value' => 28, 'title' => '28日' ),
			array( 'value' => 29, 'title' => '29日' ),
			array( 'value' => 30, 'title' => '30日' ),
			array( 'value' => 31, 'title' => '31日' )
		);
		return $tbl;
	}

	function get_day_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_day_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_day_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_day_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_dantai_rank_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '先鋒' ),
			array( 'value' => 2, 'title' => '次鋒', ),
			array( 'value' => 3, 'title' => '中堅' ),
			array( 'value' => 4, 'title' => '副将' ),
			array( 'value' => 5, 'title' => '大将' ),
			array( 'value' => 6, 'title' => '補員1' ),
			array( 'value' => 7, 'title' => '補員2' )
		);
		return $tbl;
	}

	//---------------------------------------------------------------

	function get_org_array()
	{
		$tbl = array(
			array( 'value' => 5, 'title' => '村立' ),
			array( 'value' => 6, 'title' => '町立' ),
			array( 'value' => 1, 'title' => '市立' ),
			array( 'value' => 2, 'title' => '私立' ),
			array( 'value' => 3, 'title' => '県立' ),
			array( 'value' => 4, 'title' => '学校組合立' )
		);
		return $tbl;
	}

	function get_org_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_org_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_org_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_org_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_shokumei_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '教諭' ),
			array( 'value' => 2, 'title' => '専任監督' ),
			array( 'value' => 3, 'title' => '外部指導者' ),
		);
		return $tbl;
	}

	function get_shokumei_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_shokumei_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_shokumei_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_shokumei_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_place_array( $tournament_data )
	{
		$tbl = array();
		for( $i1 = 1; $i1 <= $tournament_data[0]['place_num']; $i1++ ){
			$tbl[] = array( 'value' => $i1, 'title' => '第'.$i1.'会場' );
		}
		return $tbl;
	}

	function get_place_array_with_no_match( $tournament_data )
	{
		$tbl = array();
		$tbl[] = array( 'value' => 'no_match', 'title' => 'シード' );
		for( $i1 = 1; $i1 <= $tournament_data[0]['place_num']; $i1++ ){
			$tbl[] = array( 'value' => $i1, 'title' => '第'.$i1.'会場' );
		}
		return $tbl;
	}

	function get_place_array_for_smarty( $tbl, $tournament_data )
	{
		if( $tbl == null ){ $tbl = $this->get_place_array( $tournament_data ); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_place_array_for_smarty_with_no_match( $tbl, $tournament_data )
	{
		if( $tbl == null ){ $tbl = $this->get_place_array_with_no_match( $tournament_data ); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_place_name( $tbl, $no, $tournament_data )
	{
		if( $tbl == null ){ $tbl = $this->get_place_array( $tournament_data ); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_place_match_no_array()
	{
		$tbl = array();
		for( $i1 = 1; $i1 <= 65; $i1++ ){
			$tbl[] = array( 'value' => $i1, 'title' => '第'.$i1.'試合' );
		}
		return $tbl;
	}

	function get_place_match_no_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_place_match_no_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_place_match_no_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_place_match_no_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_place_match_rw_array()
	{
		$tbl = array();
		$tbl[] = array( 'value' => 1, 'title' => '赤' );
		$tbl[] = array( 'value' => 2, 'title' => '白' );
		return $tbl;
	}

	function get_place_match_rw_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_place_match_rw_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_place_match_rw_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_place_match_rw_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_league_standing_array()
	{
		$tbl = array();
		for( $i1 = 1; $i1 <= 20; $i1++ ){
			$tbl[] = array( 'value' => $i1, 'title' => $i1.'位' );
		}
		return $tbl;
	}

	function get_league_standing_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_league_standing_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_league_standing_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_league_standing_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_grade_junior_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '1年' ),
			array( 'value' => 2, 'title' => '2年' ),
			array( 'value' => 3, 'title' => '3年' ),
		);
		return $tbl;
	}

	function get_grade_junior_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_grade_junior_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_grade_junior_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_grade_junior_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_grade_elementary_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '1年' ),
			array( 'value' => 2, 'title' => '2年' ),
			array( 'value' => 3, 'title' => '3年' ),
			array( 'value' => 4, 'title' => '4年' ),
			array( 'value' => 5, 'title' => '5年' ),
			array( 'value' => 6, 'title' => '6年' )
		);
		return $tbl;
	}

	function get_grade_elementary_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_grade_elementary_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_grade_elementary_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_grade_elementary_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}


	//---------------------------------------------------------------

	function get_league_groupe_name( $no )
	{
		$tbl = array(
			'グループA',
			'グループB',
			'グループC',
			'グループD',
			'グループE',
			'グループF',
			'グループG',
			'グループH',
			'グループI',
			'グループJ',
			'グループK',
			'グループL',
			'グループM',
			'グループN',
			'グループO',
			'グループP',
			'グループQ',
			'グループQ',
			'グループR'
		);
		return $tbl[$no-1];
	}

	//---------------------------------------------------------------

	function get_yosen_rank_array()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '1位' ),
			array( 'value' => 2, 'title' => '2位' ),
			array( 'value' => 3, 'title' => '3位' ),
			array( 'value' => 4, 'title' => '4位' )
		);
		return $tbl;
	}

	function get_yosen_rank_array_for_smarty( $tbl )
	{
		if( $tbl == null ){ $tbl = $this->get_yosen_rank_array(); }
		return $this->get_array_for_smarty( $tbl, '-' );
	}

	function get_yosen_rank_name( $tbl, $no )
	{
		if( $tbl == null ){ $tbl = $this->get_yosen_rank_array(); }
		return $this->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------

	function get_waza_name( $waza )
	{
		if( $waza == 1 ){
			return 'メ';
		} else if( $waza == 2 ){
			return 'ド';
		} else if( $waza == 3 ){
			return 'コ';
		} else if( $waza == 4 ){
			return '反';
		} else if( $waza == 5 ){
			return '不戦勝';
		} else if( $waza == 6 ){
			return 'ツ';
		}
		return '';
	}

	//-------------------------------------------------------------------
	//
	//-------------------------------------------------------------------

	function entry_user_login( $id, $pass, $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
	//	$sql = 'select * from `entry_users` where `user_name`=\''.$id.'\' and `user_pass`=SHA1(\'' . $pass . '\') and `series`='.$series;
		$sql = 'select * from `entry_users` where `user_name`=\''.$id.'\' and `user_pass`=SHA1(\'' . $pass . '\') and `series`='.$series;
		$list = db_query_list( $dbs, $sql );
		if( count($list) == 0 ){ return false; }
//echo $sql;
//print_r($list);
		$_SESSION['auth']['login'] = 1;
		$_SESSION['auth']['id'] = $list[0]['id'];
		$_SESSION['auth']['series'] = $list[0]['series'];
		$_SESSION['auth']['info'] = $list[0]['info'];
		$_SESSION['auth']['year'] = 2017;
		return true;
	}

	function entry_user_login2( $id, $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select * from `entry_users` where `id`='.$id;
		$list = db_query_list( $dbs, $sql );
		if( count($list) == 0 ){ return false; }

		$sql = 'select * from `entry_users` where `user_name`=\''.$list[0]['user_name'].'\' and `user_pass`=\''.$list[0]['user_pass'].'\' and `series`='.$series;
		$list = db_query_list( $dbs, $sql );
		if( count($list) == 0 ){ return false; }
//echo $sql;
//print_r($list);
		$_SESSION['auth']['login'] = 1;
		$_SESSION['auth']['id'] = $list[0]['id'];
		$_SESSION['auth']['series'] = $list[0]['series'];
		$_SESSION['auth']['info'] = $list[0]['info'];
		return true;
	}

	function get_entry_category_names( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = "select * from udb_select_def where `field`='big_category' and `language`='" . $lang . "'";
		$list = db_query_list( $dbs, $sql );
		if( count($list) == 0 ){ return array(); }
		$data = explode( '|', $list[0]['data'] );
		$cl = intval( count($data) / 2 );
		if( $cl == 0 ){ return array(); }
		$names = array();
		for( $i1 = 0; $i1 < $cl; $i1++ ){
			$names[intval($data[$i1*2+1])] = $data[$i1*2];
		}
		return $names;
	}

	function get_entry_fields_info( $series, $input )
	{
		$sql = 'select * from `entry_field_def`'
			. ' where (`series`=0 or `series`='.intval($series).') and `del`=0 order by `id` asc';
//echo '[',$sql,']';
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_query_list( $dbs, $sql );
//echo print_r($list,TRUE),"<br />\n";
		foreach( $list as &$lv ){
			if( is_null( $lv['select_info'] ) || $lv['select_info'] == '' ){
				$lv['sel'] = array();
			} else {
				if( $lv['kind'] == 'pref_select' ){
					$lv['sel'] = $this->get_pref_array_for_smarty(null);
				} else {
					$sel = explode( '|', $lv['select_info'] );
					$lv['sel'] = array();
					$cs = count( $sel );
					$ic = 0;
					for(;;){
						if( $cs < 2 ){ break; }
						if( $lv['kind'] == 'party' || $lv['kind'] == 'seating' ){
							$lv['sel'][$sel[$ic+1]] = explode( '0', $sel[$ic] );
						} else {
							$lv['sel'][$sel[$ic+1]] = $sel[$ic];
						}
						$cs -= 2;
						$ic += 2;
						if( $lv['kind'] == 'check_one' ){ break; }
					}
				}
			}
		}
//echo print_r($list,TRUE),"<br />\n";
		return $list;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_entry_player_field_def()
	{
/*
		$def = array(
			array( 'field'=>'sei',      'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'mei',      'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'bikou',    'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'dispname', 'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'sei_kana', 'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'mei_kana', 'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gakunen',  'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'dan',      'def'=>'text',    'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'b_year',   'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'b_month',  'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'b_day',    'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'age',      'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 )
		);
		return $def;
*/
		return array();
	}

	function get_entry_dantai_players_field_def()
	{
	//	$def = array(
	//		array( 'field'=>'kaisuu', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 )
	//	);
	//	return $def;
		return array();
	}

	function get_entry_field_def( $series )
	{
		$sql = 'select * from `entry_field_def`'
			. ' where (`series`=0 or `series`='.intval($series).') and `del`=0';
//echo '[',$sql,']';
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_query_list( $dbs, $sql );
//echo print_r($list,TRUE),"<br />\n";
		foreach( $list as &$lv ){
			if( is_null( $lv['select_info'] ) || $lv['select_info'] == '' ){
				$lv['sel'] = array();
			} else {
				if( $lv['kind'] == 'pref_select' ){
					$lv['sel'] = $this->get_pref_array_for_smarty(null);
				} else {
					$sel = explode( '|', $lv['select_info'] );
					$lv['sel'] = array();
					$cs = count( $sel );
					$ic = 0;
					for(;;){
						if( $cs < 2 ){ break; }
						if( $lv['kind'] == 'party' || $lv['kind'] == 'seating' ){
							$lv['sel'][$sel[$ic+1]] = explode( '0', $sel[$ic] );
						} else {
							$lv['sel'][$sel[$ic+1]] = $sel[$ic];
						}
						$cs -= 2;
						$ic += 2;
						if( $lv['kind'] == 'check_one' ){ break; }
					}
				}
			}
		}
//echo print_r($list,TRUE),"<br />\n";
		return $list;

/*
		$data = array(
			array( 'field'=>'s_org', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'org', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_name_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_name_ryaku', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_pref', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_zip', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_address', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_phone', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'s_fax', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kouchou_sei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kouchou_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'mousikomi_month', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'mousikomi_day', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'shumoku_dantai_m', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'shumoku_dantai_w', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'shumoku_kojin_m', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'shumoku_kojin_w', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_sei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_bikou', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_sei_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_name_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kanktoku_shokumei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_keitai', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_tel', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_email', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_pref', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_zip', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'kantoku_address', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_sei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotuu_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_bikou', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_sei_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_name_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_keitai', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_tel', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_pref', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_zip', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'insotu_address', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_sei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_bikou', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_sei_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_name_kana', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_keitai', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_tel', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_pref', 'def'=>'integer', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_zip', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'gaibu_address', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'chuutairen_sei', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'chuutairen_name', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 ),
			array( 'field'=>'chuutairen_bikou', 'def'=>'text', 'name'=>'', 'exist'=>true, 'len'=>0 )
		);
		return $data;
*/
	}

	function init_entry_post_data_from_def( $data, $def, $add1, $add2, $series )
	{
		foreach( $def as $dv ){
			$field = $add1 . $dv['field'] . $add2;
			if( $dv['kind'] == 'address' ){
				$data[$field.'_zip1'] = '';
				$data[$field.'_zip2'] = '';
				$data[$field.'_pref'] = '';
				$data[$field] = '';
			} else if( $dv['kind'] == 'name' || $dv['kind'] == 'name_kana' ){
				$data[$field.'_sei'] = '';
				$data[$field.'_mei'] = '';
			} else if( $dv['kind'] == 'name3' ){
				$data[$field.'_sei'] = '';
				$data[$field.'_mei'] = '';
				$data[$field.'_add'] = '';
			} else if( $dv['kind'] == 'name4' ){
				$data[$field.'_sei'] = '';
				$data[$field.'_mei'] = '';
				$data[$field.'_add'] = '';
				$data[$field.'_disp'] = '';
			} else if( $dv['kind'] == 'name5' ){
				$data[$field.'_sei'] = '';
				$data[$field.'_mei'] = '';
				$data[$field.'_add'] = 0;
			} else if( $dv['kind'] == 'name6' ){
				$data[$field.'_sei'] = '';
				$data[$field.'_mei'] = '';
				$data[$field.'_add'] = 0;
				$data[$field.'_disp'] = '';
			} else if( $dv['kind'] == 'tel_fax' ){
				$data[$field.'_tel'] = '';
				$data[$field.'_fax'] = '';
			} else if( $dv['kind'] == 'mobile_tel' ){
				$data[$field.'_mobile'] = '';
				$data[$field.'_tel'] = '';
			} else if( $dv['kind'] == 'school_org' ){
				$data[$field.'_school_name'] = '';
				$data[$field] = 0;
			} else if( $dv['kind'] == 'school_name' ){
				$data[$field.'_org'] = '';
				$data[$field] = '';
			} else if( $dv['kind'] == 'school_kana' ){
				$data[$field] = '';
			} else if( $dv['kind'] == 'gakunen_dan_j' ){
				$data[$field.'_gakunen'] = 0;
				$data[$field.'_dan'] = '';
			} else if( $dv['kind'] == 'photo' ){
				$data[$field] = '';
			} else if( $dv['kind'] == 'include' ){
				$func = 'init_entry_post_data_from_def_'.$series.'_'.$dv['field'];
				$func( $data, $dv, $add1, $add2 );
			} else {
				if( $dv['data'] == 'text' ){
					$data[$field] = '';
				} else if( $dv['data'] == 'integer' ){
					$data[$field] = 0;
				}
			}
		}
		return $data;
	}

	function get_entry_post_data_from_def( $def, $add1, $add2 )
	{
        $err = 0;
		foreach( $def as $dv ){
			$field = $add1 . $dv['field'] . $add2;
			if( $dv['kind'] == 'check' ){
				$_SESSION['p'][$field] = get_field_array( $_POST, $field );
			} else if( $dv['kind'] == 'address' ){
				$_SESSION['p'][$field.'_zip1'] = get_field_string( $_POST, $field.'_zip1' );
				$_SESSION['p'][$field.'_zip2'] = get_field_string( $_POST, $field.'_zip2' );
				$_SESSION['p'][$field.'_pref'] = get_field_string( $_POST, $field.'_pref' );
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
                if(
                    $dv['required'] == 1
                    && ( $_SESSION['p'][$field.'_zip1'] === ''
                    || $_SESSION['p'][$field.'_zip2'] === ''
                    || $_SESSION['p'][$field.'_pref'] === ''
                    || $_SESSION['p'][$field] === '' )
                ){
                    $_SESSION['e'][$field] = $dv['name'] . 'を入力してください。';
                    $err = 1;
                }
			} else if( $dv['kind'] == 'name' || $dv['kind'] == 'name_kana' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
			} else if( $dv['kind'] == 'name3' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
				$_SESSION['p'][$field.'_add'] = get_field_string( $_POST, $field.'_add' );
			} else if( $dv['kind'] == 'name4' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
				$_SESSION['p'][$field.'_add'] = get_field_string( $_POST, $field.'_add' );
				$_SESSION['p'][$field.'_disp'] = get_field_string( $_POST, $field.'_disp' );
			} else if( $dv['kind'] == 'name5' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
				$_SESSION['p'][$field.'_add'] = get_field_string_number( $_POST, $field.'_add', 0 );
			} else if( $dv['kind'] == 'name6' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
				$_SESSION['p'][$field.'_add'] = get_field_string_number( $_POST, $field.'_add', 0 );
				$_SESSION['p'][$field.'_disp'] = get_field_string( $_POST, $field.'_disp' );
			} else if( $dv['kind'] == 'tel_fax' ){
				$_SESSION['p'][$field.'_tel'] = get_field_string( $_POST, $field.'_tel' );
				$_SESSION['p'][$field.'_fax'] = get_field_string( $_POST, $field.'_fax' );
			} else if( $dv['kind'] == 'mobile_tel' ){
				$_SESSION['p'][$field.'_mobile'] = get_field_string( $_POST, $field.'_mobile' );
				$_SESSION['p'][$field.'_tel'] = get_field_string( $_POST, $field.'_tel' );
			} else if( $dv['kind'] == 'school_org' ){
				$_SESSION['p'][$field.'_school_name'] = get_field_string( $_POST, $field.'_school_name' );
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
			} else if( $dv['kind'] == 'school_name' ){
				$_SESSION['p'][$field.'_org'] = get_field_string( $_POST, $field.'_org' );
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
			} else if( $dv['kind'] == 'school_kana' ){
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
			} else if( $dv['kind'] == 'gakunen_dan_j' ){
				$_SESSION['p'][$field.'_gakunen'] = get_field_string_number( $_POST, $field.'_gakunen', 0 );
				$_SESSION['p'][$field.'_dan'] = get_field_string( $_POST, $field.'_dan' );
			} else if( $dv['kind'] == 'photo' ){
				$file = $this->get_entry_post_photo_data( $field.'_file', $_SESSION['p']['id'] );
				if( $file != '' ){
					$_SESSION['p'][$field] = $file;
				}
			} else if( $dv['kind'] == 'include' ){
				$func = 'get_entry_post_data_from_def_'.$_SESSION['auth']['series'].'_'.$dv['field'];
				$func( $dv, $add1, $add2 );
			} else {
				if( $dv['data'] == 'text' ){
					$_SESSION['p'][$field] = get_field_string( $_POST, $field );
                    if( $dv['required'] == 1 && $_SESSION['p'][$field] === '' ){
                        $_SESSION['e'][$field] = $dv['name'] . 'を入力してください。';
                        $err = 1;
                    }
				} else if( $dv['data'] == 'integer' ){
					$_SESSION['p'][$field] = get_field_string_number( $_POST, $field, 0 );
				}
			}
		}
        return $err;
	}

	function get_entry_db_data_from_def( $data, $list, $def, $add1, $add2, $series )
	{
		foreach( $def as $dv ){
			$field = $add1 . $dv['field'] . $add2;
			if( $dv['kind'] == 'check' ){
				$data[$field] = explode( '|', get_field_string( $list, $field ) );
			} else if( $dv['kind'] == 'address' ){
				$data[$field.'_zip1'] = get_field_string( $list, $field.'_zip1' );
				$data[$field.'_zip2'] = get_field_string( $list, $field.'_zip2' );
				$data[$field.'_pref'] = get_field_string( $list, $field.'_pref' );
				$data[$field] = get_field_string( $list, $field );
			} else if( $dv['kind'] == 'name' || $dv['kind'] == 'name_kana' ){
				$data[$field.'_sei'] = get_field_string( $list, $field.'_sei' );
				$data[$field.'_mei'] = get_field_string( $list, $field.'_mei' );
			} else if( $dv['kind'] == 'name3' ){
				$data[$field.'_sei'] = get_field_string( $list, $field.'_sei' );
				$data[$field.'_mei'] = get_field_string( $list, $field.'_mei' );
				$data[$field.'_add'] = get_field_string( $list, $field.'_add' );
			} else if( $dv['kind'] == 'name4' ){
				$data[$field.'_sei'] = get_field_string( $list, $field.'_sei' );
				$data[$field.'_mei'] = get_field_string( $list, $field.'_mei' );
				$data[$field.'_add'] = get_field_string( $list, $field.'_add' );
				$data[$field.'_disp'] = get_field_string( $list, $field.'_disp' );
			} else if( $dv['kind'] == 'name5' ){
				$data[$field.'_sei'] = get_field_string( $list, $field.'_sei' );
				$data[$field.'_mei'] = get_field_string( $list, $field.'_mei' );
				$data[$field.'_add'] = get_field_string_number( $list, $field.'_add', 0 );
			} else if( $dv['kind'] == 'name6' ){
				$data[$field.'_sei'] = get_field_string( $list, $field.'_sei' );
				$data[$field.'_mei'] = get_field_string( $list, $field.'_mei' );
				$data[$field.'_add'] = get_field_string_number( $list, $field.'_add', 0 );
				$data[$field.'_disp'] = get_field_string( $list, $field.'_disp' );
			} else if( $dv['kind'] == 'tel_fax' ){
				$data[$field.'_tel'] = get_field_string( $list, $field.'_tel' );
				$data[$field.'_fax'] = get_field_string( $list, $field.'_fax' );
			} else if( $dv['kind'] == 'mobile_tel' ){
				$data[$field.'_mobile'] = get_field_string( $list, $field.'_mobile' );
				$data[$field.'_tel'] = get_field_string( $list, $field.'_tel' );
			} else if( $dv['kind'] == 'school_org' ){
				$data[$field.'_school_name'] = get_field_string( $list, $field.'_school_name' );
				$data[$field] = get_field_string( $list, $field );
			} else if( $dv['kind'] == 'school_name' ){
				$data[$field.'_org'] = get_field_string( $list, $field.'_org' );
				$data[$field] = get_field_string( $list, $field );
			} else if( $dv['kind'] == 'school_kana' ){
				$data[$field] = get_field_string( $list, $field );
			} else if( $dv['kind'] == 'gakunen_dan_j' ){
				$data[$field.'_gakunen'] = get_field_string_number( $list, $field.'_gakunen', 0 );
				$data[$field.'_dan'] = get_field_string( $list, $field.'_dan' );
			} else if( $dv['kind'] == 'photo' ){
				$data[$field] = get_field_string( $list, $field );
			} else if( $dv['kind'] == 'include' ){
				$func = 'get_entry_db_data_from_def_'.$series.'_'.$dv['field'];
				$data = $func( $data, $list, $dv, $add1, $add2 );
			} else {
				if( $dv['data'] == 'text' ){
					$data[$field] = get_field_string( $list, $field );
				} else if( $dv['data'] == 'integer' ){
					$data[$field] = get_field_string_number( $list, $field, 0 );
				}
			}
		}
		return $data;
	}

	function init_entry_post_data( $series )
	{
		$field_def = $this->get_entry_field_def( $series );
		$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
		$player_field_def = $this->get_entry_player_field_def();

		$data = array();
		$data['id'] = 0;
		$data = $this->init_entry_post_data_from_def( $data, $field_def, '', '', $series );
/*
		$data = $this->init_entry_post_data_from_def( $data, $dantai_players_field_def, 'dantai_', '_m' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'dantai_', '_m'.$i1 );
		}
		$data = $this->init_entry_post_data_from_def( $data, $dantai_players_field_def, 'dantai_', '_w' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'dantai_', '_w'.$i1 );
		}
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'kojin_', '_m'.$i1 );
		}
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'kojin_', '_w'.$i1 );
		}
*/
		return $data;
	}

	function get_entry_post_data( $series )
	{
		$field_def = $this->get_entry_field_def( $series );
	//	$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
	//	$player_field_def = $this->get_entry_player_field_def();

		return $this->get_entry_post_data_from_def( $field_def, '', '' );
/*
		$this->get_entry_post_data_from_def( $dantai_players_field_def, 'dantai_', '_m' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$this->get_entry_post_data_from_def( $player_field_def, 'dantai_', '_m'.$i1 );
		}
		$this->get_entry_post_data_from_def( $dantai_players_field_def, 'dantai_', '_w' );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$this->get_entry_post_data_from_def( $player_field_def, 'dantai_', '_w'.$i1 );
		}
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$this->get_entry_post_data_from_def( $player_field_def, 'kojin_', '_m'.$i1 );
		}
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$this->get_entry_post_data_from_def( $player_field_def, 'kojin_', '_w'.$i1 );
		}
*/
	}

	function add_entry_post_data_select_name( $series )
	{
		$org_array = $this->get_org_array();
		$pref_array = $this->get_pref_array();
		$grade_junior_array = $this->get_grade_junior_array();
		$yosen_rank_array = $this->get_yosen_rank_array();

		$field_def = $this->get_entry_field_def( $series );
		foreach( $field_def as $lv ){
			if( $lv['kind'] == 'pref_select' ){
				$_SESSION['p'][$lv['field'].'_name'] = $this->get_pref_name( $pref_array, $_SESSION['p'][$lv['field']] );
			} else if( $lv['kind'] == 'check' ){
				$sel = explode( '|', $lv['select_info'] );
//print_r($_SESSION['p'][$lv['field']]);
//print_r($sel);
				$_SESSION['p'][$lv['field'].'_name'] = '';
				if( count( $sel ) >= 2 ){
					$i1 = 0;
					for(;;){
						if( $i1 >= count( $sel ) - 1 ){ break; }
						foreach( $_SESSION['p'][$lv['field']] as $dd ){
							if( $sel[$i1+1] == $dd ){
								if( $_SESSION['p'][$lv['field'].'_name'] != '' ){
									$_SESSION['p'][$lv['field'].'_name'] .= ' ';
								}
								$_SESSION['p'][$lv['field'].'_name'] .= $sel[$i1];
								break;
							}
						}
						$i1 += 2;
					}
				}
			} else if( $lv['kind'] == 'select' || $lv['kind'] == 'radio' || $lv['kind'] == 'check_one' ){
				$sel = explode( '|', $lv['select_info'] );
//print_r($_SESSION['p'][$lv['field']]);
//print_r($sel);
				$_SESSION['p'][$lv['field'].'_name'] = '';
				if( count( $sel ) >= 2 ){
					$i1 = 0;
					for(;;){
						if( $i1 >= count( $sel ) - 1 ){ break; }
						if( $sel[$i1+1] == $_SESSION['p'][$lv['field']] ){
							$_SESSION['p'][$lv['field'].'_name'] .= $sel[$i1];
							break;
						}
						$i1 += 2;
					}
				}
			} else if( $lv['kind'] == 'address_pref' ){
				$_SESSION['p'][$lv['field'].'_name'] = $this->get_pref_name( $pref_array, $_SESSION['p'][$lv['field']] );
			} else if( $lv['kind'] == 'address' ){
				$_SESSION['p'][$lv['field'].'_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p'][$lv['field'].'_pref'] );
			} else if( $lv['kind'] == 'grade_j' ){
				$_SESSION['p'][$lv['field'].'_name'] = $this->get_grade_junior_name( $grade_junior_array, $_SESSION['p'][$lv['field']] );
			} else if( $lv['kind'] == 'school_org' ){
				$_SESSION['p'][$lv['field'].'_name'] = $this->get_org_name( $org_array, $_SESSION['p'][$lv['field']] );
			} else if( $lv['kind'] == 'gakunen_dan_j' ){
				$_SESSION['p'][$lv['field'].'_gakunen_name'] = $this->get_grade_junior_name( $grade_junior_array, $_SESSION['p'][$lv['field'].'_gakunen'] );
			} else if( $lv['kind'] == 'yosen_rank' ){
				$_SESSION['p'][$lv['field'].'_name'] = $this->get_yosen_rank_name( $yosen_rank_array, $_SESSION['p'][$lv['field']] );
			}
		}

/*
		$_SESSION['p']['org_name'] = $this->get_org_name( $org_array, $_SESSION['p']['org'] );
		$_SESSION['p']['s_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p']['s_pref'] );
		$_SESSION['p']['mousikomi_month_name'] = $this->get_month_name( $month_array, $_SESSION['p']['mousikomi_month'] );
		$_SESSION['p']['mousikomi_day_name'] = $this->get_day_name( $day_array, $_SESSION['p']['mousikomi_day'] );
		$_SESSION['p']['kantoku_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p']['kantoku_pref'] );
		$_SESSION['p']['insotu_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p']['insotu_pref'] );
		$_SESSION['p']['gaibu_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p']['gaibu_pref'] );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$_SESSION['p']['dantai_b_year_m'.$i1.'_name'] = $this->get_birth_year_name( $birth_year_array, $_SESSION['p']['dantai_b_year_m'.$i1] );
			$_SESSION['p']['dantai_b_month_m'.$i1.'_name'] = $this->get_month_name( $month_array, $_SESSION['p']['dantai_b_month_m'.$i1] );
			$_SESSION['p']['dantai_b_day_m'.$i1.'_name'] = $this->get_day_name( $day_array, $_SESSION['p']['dantai_b_day_m'.$i1] );
			$_SESSION['p']['dantai_b_year_w'.$i1.'_name'] = $this->get_birth_year_name( $birth_year_array, $_SESSION['p']['dantai_b_year_w'.$i1] );
			$_SESSION['p']['dantai_b_month_w'.$i1.'_name'] = $this->get_month_name( $month_array, $_SESSION['p']['dantai_b_month_w'.$i1] );
			$_SESSION['p']['dantai_b_day_w'.$i1.'_name'] = $this->get_day_name( $day_array, $_SESSION['p']['dantai_b_day_w'.$i1] );
		}
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$_SESSION['p']['kojin_b_year_m'.$i1.'_name'] = $this->get_birth_year_name( $birth_year_array, $_SESSION['p']['kojin_b_year_m'.$i1] );
			$_SESSION['p']['kojin_b_month_m'.$i1.'_name'] = $this->get_month_name( $month_array, $_SESSION['p']['kojin_b_month_m'.$i1] );
			$_SESSION['p']['kojin_b_day_m'.$i1.'_name'] = $this->get_day_name( $day_array, $_SESSION['p']['kojin_b_day_m'.$i1] );
			$_SESSION['p']['kojin_b_year_w'.$i1.'_name'] = $this->get_birth_year_name( $birth_year_array, $_SESSION['p']['kojin_b_year_w'.$i1] );
			$_SESSION['p']['kojin_b_month_w'.$i1.'_name'] = $this->get_month_name( $month_array, $_SESSION['p']['kojin_b_month_w'.$i1] );
			$_SESSION['p']['kojin_b_day_w'.$i1.'_name'] = $this->get_day_name( $day_array, $_SESSION['p']['kojin_b_day_w'.$i1] );
		}
*/
	}


	function get_entry_post_photo_data( $field, $id )
	{
	//	ini_set( 'memory_limit', '80M' );
		if( !isset($_FILES[$field]['name']) ){ return ''; }
		if( $_FILES[$field]['name'] == '' ){ return ''; }
		if( !isset($_FILES[$field]['tmp_name']) ){ return ''; }
		if( !is_uploaded_file($_FILES[$field]['tmp_name']) ){ return ''; }

		$fname = sprintf("%05d",$id) . '_' .date('YmdHis') . sprintf("%04d",microtime()*1000);
		//拡張子の取得

		/*
		preg_match("/(.*)\.(\w+)$/", $_FILES[$field]['name'], $m );
		$ext = $m[2];
		if( preg_match("/^jpe?g$/i", $ext) ){
			$ext = 'jpg';
			$im = imagecreatefromjpeg( $_FILES[$field]['tmp_name'] );
		} else if( $ext == 'gif' ){
			$ext = 'gif';
			$im = imagecreatefromgif( $_FILES[$field]['tmp_name'] );
		} else {
			return '';
		}
		*/
		$ext = '';
		if( $_FILES[$field]['type'] == 'image/pjpeg' || $_FILES[$field]['type'] == 'image/jpeg' ){
			$ext = 'jpg';
			$im = imagecreatefromjpeg( $_FILES[$field]['tmp_name'] );
		} else if( $_FILES[$field]['type'] == 'image/gif' ){
			$ext = 'gif';
			$im = imagecreatefromgif( $_FILES[$field]['tmp_name'] );
		} else if( $_FILES[$field]['type'] == 'image/png' ){
			$ext = 'png';
			$im = imagecreatefrompng( $_FILES[$field]['tmp_name'] );
		}
		$name = __UPLOAD_ORG_PATH__ . $fname . '_' . rawurlencode($_FILES[$field]['name']);
		move_uploaded_file( $_FILES[$field]['tmp_name'], $name );
		chmod( $name, 0666 );
		if( $ext == '' ){ return; }
		$width = imagesx( $im );
		$height = imagesy( $im );

		if( $width > __THUMB1_WIDTH__ ){
			$n_width = __THUMB1_WIDTH__;
			$n_height = (int)( $height * __THUMB1_WIDTH__ / $width );
		} else {
			$n_width = $width;
			$n_height = $height;
		}
		$n_im = imagecreatetruecolor( $n_width, $n_height );
		imagecopyresampled( $n_im, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height );
		imagejpeg( $n_im, __UPLOAD_PATH__.$fname.'_01.jpg' );
		chmod( __UPLOAD_PATH__.$fname.'_01.jpg', 0666 );
		imagefilter( $n_im, IMG_FILTER_GRAYSCALE );
		imagejpeg( $n_im, __UPLOAD_PATH__.'trim/'.$fname.'_trim.jpg' );
		chmod( __UPLOAD_PATH__.'trim/'.$fname.'_trim.jpg', 0666 );

		if( $width > __THUMB2_WIDTH__ ){
			$n_width = __THUMB2_WIDTH__;
			$n_height = (int)( $height * __THUMB2_WIDTH__ / $width );
		} else {
			$n_width = $width;
			$n_height = $height;
		}
		$n_im = imagecreatetruecolor( $n_width, $n_height );
		imagecopyresampled( $n_im, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height );
		imagejpeg( $n_im, __UPLOAD_PATH__.$fname.'_02.jpg' );
		chmod( __UPLOAD_PATH__.$fname.'_02.jpg', 0666 );
		imagefilter( $n_im, IMG_FILTER_GRAYSCALE );
		imagejpeg( $n_im, __UPLOAD_PATH__.$fname.'_02_gray.jpg' );
		chmod( __UPLOAD_PATH__.$fname.'_02_gray.jpg', 0666 );

		//$name = __UPLOAD_ORG_PATH__ . $fname . '_' . rawurlencode($_FILES[$field]['name']);
		//move_uploaded_file( $_FILES[$field]['tmp_name'], $name );
		//chmod( $name, 0666 );

		imagefilter( $im, IMG_FILTER_GRAYSCALE );
		$name = __UPLOAD_ORG_PATH__ . $fname . '_gray.jpg';
		imagejpeg( $im, $name, 85 );
		chmod( $name, 0666 );

		return $fname;
	}


	function GetReg1FormPostData()
	{
		$_SESSION['p']['pref'] = get_field_string( $_POST, 'pref' );
		$_SESSION['p']['pref_name'] = $this->getPrefName( $_SESSION['p']['pref'] );
		$_SESSION['p']['name'] = get_field_string( $_POST, 'name' );
		$_SESSION['p']['address'] = get_field_string( $_POST, 'address' );
		$_SESSION['p']['tel'] = get_field_string( $_POST, 'tel' );
		$_SESSION['p']['responsible'] = get_field_string( $_POST, 'responsible' );
		$_SESSION['p']['contact'] = get_field_string( $_POST, 'contact' );
		$_SESSION['p']['email'] = get_field_string( $_POST, 'email' );
		$_SESSION['p']['rensei'] = get_field_string_number( $_POST, 'rensei', 0 );
		$_SESSION['p']['rensei_name'] = $this->getRenseiName( $_SESSION['p']['rensei'] );
		$_SESSION['p']['rensei_flag'] = get_field_string( $_POST, 'rensei_flag' );
		$_SESSION['p']['rensei_flag_name'] = $this->getRenseiFlagName( $_SESSION['p']['rensei_flag'] );
		$_SESSION['p']['comment'] = get_field_string( $_POST, 'comment' );
		$_SESSION['p']['stay'] = get_field_string( $_POST, 'stay' );
		$_SESSION['p']['stay_name'] = $this->getStayName( $_SESSION['p']['stay'] );

		$ret = 1;
/*
		if( $_SESSION['p']['pref'] == '' ){
			$_SESSION['e']['pref'] = '都道府県を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['name'] == '' ){
			$_SESSION['e']['name'] = '団体名を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['address'] == '' ){
			$_SESSION['e']['address'] = '住所を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['tel'] == '' ){
			$_SESSION['e']['tel'] = '電話番号を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['responsible'] == '' ){
			$_SESSION['e']['responsible'] = '記入責任者を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['rensei'] == '' ){
			$_SESSION['e']['rensei'] = '錬成会参加を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['stay'] == '' ){
			$_SESSION['e']['stay'] = '宿泊予定を選択して下さい。';
			$err = 1;
		}
*/
		return $ret;
	}

	//--------------------------------------------------------------
	//--------------------------------------------------------------

	function update_entry_field_data( $id, $field, $data, $dbs )
	{
		$sql = 'select `id` from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'].' and `field`=\''.$field.'\'';
		$list = db_query_list( $dbs, $sql );
		if( count($list) > 0 ){
			$sql = 'update `entry_field` set `data`=\''.$data.'\' where `info`='.$id.' and `field`=\''.$field.'\'';
//echo '<!-- ',$sql," --><br />\n";

			db_query( $dbs, $sql );
		} else {
			$sql = 'insert into `entry_field` set `info`='.$id.',`year`='.$_SESSION['auth']['year'].',`field`=\''.$field.'\',`data`=\''.$data.'\'';

//echo '<!-- ',$sql," --><br />\n";

			db_query( $dbs, $sql );
		}
	}


	function make_entry_sql_data_from_def( $sql, $def, $add1, $add2, $dbs )
	{
		foreach( $def as $dv ){
			if( $dv['def'] == 'text' ){
				$sql .= ( ' `' . $dv['field'] . "`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], $add1.$dv['field'].$add2, $dbs ) ) . "'," );
			} else if( $dv['def'] == 'integer' ){
				$sql .= ( ' `' . $dv['field'] . "`=" . get_field_string_number( $_SESSION['p'], $add1.$dv['field'].$add2, 0 ) . "," );
			}
		}
		return $sql;
	}

	function insert_entry_player_data( $add1, $add2, $dbs )
	{
		$player_field_def = $this->get_entry_player_field_def();
		$sql = 'insert into `player` set';
		$sql = $this->make_entry_sql_data_from_def( $sql, $player_field_def, $add1, $add2, $dbs );
		$sql .= ( ' `create_date`=NOW(), `update_date`=NOW(), `del`=0' );
		db_query( $dbs, $sql );
		return db_query_insert_id( $dbs );
	}

	function update_entry_player_data( $id, $add1, $add2, $dbs )
	{
		$player_field_def = $this->get_entry_player_field_def();
		$sql = 'update `player` set';
		$sql = $this->make_entry_sql_data_from_def( $sql, $player_field_def, $add1, $add2, $dbs );
		$sql .= ( ' `create_date`=NOW(), `update_date`=NOW() where `id`=' . $id );
		db_query( $dbs, $sql );
	}

	//----------------------------------------------------------------------------------------

	function insert_entry_dantai_data( $mw, $dbs )
	{
		$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
		$player_field_def = $this->get_entry_player_field_def();
		$players_id = array();
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$players_id[$i1] = $this->insert_entry_player_data( 'dantai_', '_'.$mw.$i1, $dbs );
		}
		$sql = 'insert into `dantai_players` set';
		$sql = $this->make_entry_sql_data_from_def( $sql, $dantai_players_field_def, 'dantai_', '_'.$mw, $dbs );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$sql .= ( '`player' . $i1 . '`=' . $players_id[$i1] . ',' );
		}
		$sql .= ' `create_date`=NOW(), `del`=0';
		db_query( $dbs, $sql );
		return db_query_insert_id( $dbs );
	}

	function insert_entry_kojin_data( $mw, $dbs )
	{
		$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
		$player_field_def = $this->get_entry_player_field_def();
		$players_id = array();
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$players_id[$i1] = $this->insert_entry_player_data( 'kojin_', '_'.$mw.$i1, $dbs );
		}
		$sql = 'insert into `kojin_players` set';
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$sql .= ( '`player' . $i1 . '`=' . $players_id[$i1] . ',' );
		}
		$sql .= ' `create_date`=NOW(), `del`=0';
		db_query( $dbs, $sql );
		return db_query_insert_id( $dbs );
	}

	function insert_entry_data()
	{
		$field_def = $this->get_entry_field_def();
		$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
		$player_field_def = $this->get_entry_player_field_def();

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

	//	$shumoku_dantai_m = get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m', 0 );
	//	if( $shumoku_dantai_m == 1 ){
	//		$shumoku_dantai_m_id = $this->insert_entry_dantai_data( 'm', $dbs );
	//	} else {
	//		$shumoku_dantai_m_id = 0;
	//	}
	//	$shumoku_dantai_w = get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w', 0 );
	//	if( $shumoku_dantai_w == 1 ){
	//		$shumoku_dantai_w_id = $this->insert_entry_dantai_data( 'w', $dbs );
	//	} else {
	//		$shumoku_dantai_w_id = 0;
	//	}
	//	$shumoku_kojin_m = get_field_string_number( $_SESSION['p'], 'shumoku_kojin_m', 0 );
	//	if( $shumoku_kojin_m == 1 ){
	//		$shumoku_kojin_m_id = $this->insert_entry_kojin_data( 'm', $dbs );
	//	} else {
	//		$shumoku_kojin_m_id = 0;
	//	}
	//	$shumoku_kojin_w = get_field_string_number( $_SESSION['p'], 'shumoku_kojin_w', 0 );
	//	if( $shumoku_kojin_w == 1 ){
	//		$shumoku_kojin_w_id = $this->insert_entry_kojin_data( 'w', $dbs );
	//	} else {
	//		$shumoku_kojin_w_id = 0;
	//	}

		$sql = 'insert into `entry` set';
		$sql = $this->make_entry_sql_data_from_def( $sql, $field_def, '', '', $dbs );
	//	$sql .= ( ' `dantai_m`=' . $shumoku_dantai_m_id . ',' );
	//	$sql .= ( ' `dantai_w`=' . $shumoku_dantai_w_id . ',' );
	//	$sql .= ( ' `kojin_m`=' . $shumoku_kojin_m_id . ',' );
	//	$sql .= ( ' `kojin_w`=' . $shumoku_kojin_w_id . ',' );
		$sql .= ( ' `create_date`=NOW(), `update_date`=NOW(), `del`=0' );
		db_query( $dbs, $sql );
		db_query_insert_id( $dbs );

		foreach( $def as $dv ){
			if( $dv['def'] == 'text' ){
//				$this->update_entry_field_data( $id, $field, $data, $dbs )

				$sql .= ( ' `' . $dv['field'] . "`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], $add1.$dv['field'].$add2, $dbs ) ) . "'," );
			} else if( $dv['def'] == 'integer' ){
				$sql .= ( ' `' . $dv['field'] . "`=" . get_field_string_number( $_SESSION['p'], $add1.$dv['field'].$add2, 0 ) . "," );
			}
		}

		db_close( $dbs );
	}

	//--------------------------------------------------------------

	function update_entry_dantai_data( $id, $mw, $dbs )
	{
		$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
		$dantai = db_get_one_data( $dbs, 'dantai_players', '*', '`id`='.$id );
		$players_id = array();
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$players_id[$i1] = get_field_string_number( $dantai, 'player'.$i1, 0 );
			if( $players_id[$i1] == 0 ){
				$players_id[$i1] = $this->insert_entry_player_data( 'dantai_', '_'.$mw.$i1, $dbs );
			} else {
				$this->update_entry_player_data( $players_id[$i1], 'dantai_', '_'.$mw.$i1, $dbs );
			}
		}
		$sql = 'update `dantai_players` set';
		$sql = $this->make_entry_sql_data_from_def( $sql, $dantai_players_field_def, 'dantai_', '_'.$mw, $dbs );
		for( $i1 = 1; $i1 <= 7; $i1++ ){
			$sql .= ( '`player' . $i1 . '`=' . $players_id[$i1] . ',' );
		}
		$sql .= ( ' `update_date`=NOW() where`id`='.$id );
		db_query( $dbs, $sql );
	}

	function update_entry_kojin_data( $id, $mw, $dbs )
	{
		$kojin = db_get_one_data( $dbs, 'kojin_players', '*', '`id`='.$id );
		$players_id = array();
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$players_id[$i1] = get_field_string_number( $kojin, 'player'.$i1, 0 );
			if( $players_id[$i1] == 0 ){
				$players_id[$i1] = $this->insert_entry_player_data( 'kojin_', '_'.$mw.$i1, $dbs );
			} else {
				$this->update_entry_player_data( $players_id[$i1], 'kojin_', '_'.$mw.$i1, $dbs );
			}
		}
		$sql = 'update `kojin_players` set';
		for( $i1 = 1; $i1 <= 3; $i1++ ){
			$sql .= ( '`player' . $i1 . '`=' . $players_id[$i1] . ',' );
		}
		$sql .= ( ' `update_date`=NOW() where`id`='.$id );
		db_query( $dbs, $sql );
	}

	function update_entry_data( $series )
	{
		$field_def = $this->get_entry_field_def( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
	//	$entry = db_get_one_data( $dbs, 'entry', '*', '`id`='.$_SESSION['p']['id'] );

	//	$shumoku_dantai_m = get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m', 0 );
	//	if( $shumoku_dantai_m == 1 ){
	//		$shumoku_dantai_m_id = get_field_string_number( $entry, 'dantai_m', 0 );
	//		if( $shumoku_dantai_m_id != 0 ){
	//			$this->update_entry_dantai_data( $shumoku_dantai_m_id, 'm', $dbs );
	//		} else {
	//			$shumoku_dantai_m_id = $this->insert_entry_dantai_data( 'm', $dbs );
	//		}
	//	} else {
	//		$shumoku_dantai_m_id = 0;
	//	}

	//	$shumoku_dantai_w = get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w', 0 );
	//	if( $shumoku_dantai_w == 1 ){
	//		$shumoku_dantai_w_id = get_field_string_number( $entry, 'dantai_w', 0 );
	//		if( $shumoku_dantai_w_id != 0 ){
	//			$this->update_entry_dantai_data( $shumoku_dantai_w_id, 'w', $dbs );
	//		} else {
	//			$shumoku_dantai_w_id = $this->insert_entry_dantai_data( 'w', $dbs );
	//		}
	//	} else {
	//		$shumoku_dantai_w_id = 0;
	//	}

	//	$shumoku_kojin_m = get_field_string_number( $_SESSION['p'], 'shumoku_kojin_m', 0 );
	//	if( $shumoku_kojin_m == 1 ){
	//		$shumoku_kojin_m_id = get_field_string_number( $entry, 'kojin_m', 0 );
	//		if( $shumoku_kojin_m_id != 0 ){
	//			$this->update_entry_kojin_data( $shumoku_kojin_m_id, 'm', $dbs );
	//		} else {
	//			$shumoku_kojin_m_id = $this->insert_entry_kojin_data( 'm', $dbs );
	//		}
	//	} else {
	//		$shumoku_kojin_m_id = 0;
	//	}

	//	$shumoku_kojin_w = get_field_string_number( $_SESSION['p'], 'shumoku_kojin_w', 0 );
	//	if( $shumoku_kojin_w == 1 ){
	//		$shumoku_kojin_w_id = get_field_string_number( $entry, 'kojin_w', 0 );
	//		if( $shumoku_kojin_w_id != 0 ){
	//			$this->update_entry_kojin_data( $shumoku_kojin_w_id, 'w', $dbs );
	//		} else {
	//			$shumoku_kojin_w_id = $this->insert_entry_kojin_data( 'w', $dbs );
	//		}
	//	} else {
	//		$shumoku_kojin_w_id = 0;
	//	}
//print_r($_SESSION['p']);

		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){
			$sql = 'insert into `entry_info` set `series`='.$_SESSION['auth']['series'].','
				. ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
			db_query( $dbs, $sql );
			$id = db_query_insert_id( $dbs );
		} else {
			$sql = 'update `entry_info` set `update_date`=NOW() where `id`='.$id;
			db_query( $dbs, $sql );
		}
		foreach( $field_def as $dv ){
			$datalist = array();
			if( $dv['kind'] == 'check' ){
//print_r($_SESSION['p'][$lv['field']]);
				$datalist = array( $dv['field'] => '' );
				foreach( $_SESSION['p'][$dv['field']] as $dd ){
					if( $datalist[$dv['field']] != '' ){
						$datalist[$dv['field']] .= '|';
					}
					$datalist[$dv['field']] .= $dd;
				}
			} else if( $dv['kind'] == 'address' ){
				$datalist = array(
					$dv['field'].'_zip1' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_zip1' ) ),
					$dv['field'].'_zip2' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_zip2' ) ),
					$dv['field'].'_pref' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_pref' ) ),
					$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
				);
			} else if( $dv['kind'] == 'name' || $dv['kind'] == 'name_kana' ){
				$datalist = array(
					$dv['field'].'_sei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_sei' ) ),
					$dv['field'].'_mei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mei' ) )
				);
			} else if( $dv['kind'] == 'name3' ){
				$datalist = array(
					$dv['field'].'_sei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_sei' ) ),
					$dv['field'].'_mei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mei' ) ),
					$dv['field'].'_add' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_add' ) )
				);
			} else if( $dv['kind'] == 'name4' ){
				$datalist = array(
					$dv['field'].'_sei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_sei' ) ),
					$dv['field'].'_mei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mei' ) ),
					$dv['field'].'_add' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_add' ) ),
					$dv['field'].'_disp' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_disp' ) )
				);
			} else if( $dv['kind'] == 'name5' ){
				$datalist = array(
					$dv['field'].'_sei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_sei' ) ),
					$dv['field'].'_mei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mei' ) ),
					$dv['field'].'_add' => get_field_string_number( $_SESSION['p'], $dv['field'].'_add', 0 )
				);
			} else if( $dv['kind'] == 'name6' ){
				$datalist = array(
					$dv['field'].'_sei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_sei' ) ),
					$dv['field'].'_mei' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mei' ) ),
					$dv['field'].'_add' => get_field_string_number( $_SESSION['p'], $dv['field'].'_add', 0 ),
					$dv['field'].'_disp' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_disp' ) )
				);
			} else if( $dv['kind'] == 'tel_fax' ){
				$datalist = array(
					$dv['field'].'_tel' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_tel' ) ),
					$dv['field'].'_fax' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_fax' ) )
				);
			} else if( $dv['kind'] == 'mobile_tel' ){
				$datalist = array(
					$dv['field'].'_mobile' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_mobile' ) ),
					$dv['field'].'_tel' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_tel' ) )
				);
			} else if( $dv['kind'] == 'school_org' ){
				$datalist = array(
					$dv['field'].'_school_name' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_school_name' ) ),
					$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
				);
			} else if( $dv['kind'] == 'school_name' ){
				$datalist = array(
					$dv['field'].'_org' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_org' ) ),
					$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
				);
			} else if( $dv['kind'] == 'school_name_kana' ){
				$datalist = array(
					$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
				);
			} else if( $dv['kind'] == 'gakunen_dan_j' ){
				$datalist = array(
					$dv['field'].'_gakunen' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_gakunen' ) ),
					$dv['field'].'_dan' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'].'_dan' ) )
				);
			} else if( $dv['kind'] == 'photo' ){
				$datalist = array(
					$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
				);
			} else if( $dv['kind'] == 'include' ){
				$func = 'update_entry_data_'.$_SESSION['auth']['series'].'_'.$dv['field'];
				$datalist = $func( $dv, $dbs );
			} else {
				if( $dv['data'] == 'text' ){
					$datalist = array(
						$dv['field'] => $dbs->real_escape_string( get_field_string( $_SESSION['p'], $dv['field'] ) )
					);
				} else if( $dv['data'] == 'integer' ){
					$datalist = array(
						$dv['field'] => get_field_string_number( $_SESSION['p'], $dv['field'], 0 )
					);
				}
			}
			$datalist['join'] = '1';
//print_r( $datalist );
			foreach( $datalist as $lvf => $lv ){
				$this->update_entry_field_data( $id, $lvf, $lv, $dbs );
			}
		}
		db_close( $dbs );
		return $id;
	}


	function update_entry_user( $id )
	{
		$user_name = generate_password( 8, '0123456789' );
		$user_pass = generate_password( 8, '0123456789' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $i1 = 0; $i1 < 100; $i1++ ){
			$sql = "select * from `entry_users` where `user_name`='" . $user_name . "' and `del`=0";
			db_query( $dbs, $sql );
			$list = db_query_list( $dbs, $sql );
//print_r($list);
			if( count( $list ) == 0 ){
				$sql = 'insert into `entry_users`'
					. ' set `series`=' . $_SESSION['auth']['series'] . ','
					. ' `info`=' . $id . ','
					. " `user_name`='" . $user_name . "',"
					. " `user_pass`=SHA1('" . $user_pass . "'),"
					. ' `del`=0, `create_date`=NOW(), `update_date`=NOW()';
//echo $sql."\n";
				db_query( $dbs, $sql );
				break;
			} else {
				$user_name = generate_password( 8, '0123456789' );
			}
		}
		return array( 'user_name' => $user_name, 'user_pass' => $user_pass );
	}

	//--------------------------------------------------------------

	function delete_entry_data( $id, $del )
	{
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `entry_info` set `del`=' . $del . ',`update_date`=NOW() where `id`=' . $id;
		$list = db_query( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	//--------------------------------------------------------------

	function get_entry_data_list( $series, $mw )
	{
		$preftbl = $this->get_pref_array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
	//	$func = 'get_entry_data_list_' . $series . '_sql';
//echo $func;
	//	$sql = get_entry_data_list_4_sql( $mw );

/*
		$sql = 'select `entry_info`.`id` as `id`,'
			. ' `f1`.`data` as `school_name`,'
			. ' `f2`.`data` as `school_name_ryaku`,'
			. ' `f3`.`data` as `school_address_pref`,'
			. ' `f4`.`data` as `join`'
			. ' from `entry_info`'
			. ' inner join `entry_field` as `f1` on `f1`.`info`=`entry_info`.`id` and `f1`.`field`=\'school_name\''
			. ' inner join `entry_field` as `f2` on `f2`.`info`=`entry_info`.`id` and `f2`.`field`=\'school_name_ryaku\''
			. ' inner join `entry_field` as `f3` on `f3`.`info`=`entry_info`.`id` and `f3`.`field`=\'school_address_pref\''
			. ' inner join `entry_field` as `f4` on `f4`.`info`=`entry_info`.`id` and `f4`.`field`=\'shumoku_dantai_' . $mw . '\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' order by `disp_order` asc';
*/
		$sql = 'select `entry_info`.`id` as `id`,`entry_info`.`disp_order` as `disp_order`,`entry_info`.`del` as `del`,'
			. ' `f1`.`data` as `school_name`,'
			. ' `f2`.`data` as `school_name_ryaku`,'
			. ' `f3`.`data` as `school_address_pref`'
			. ' from `entry_info`'
			. ' left join `entry_field` as `f1` on `f1`.`info`=`entry_info`.`id` and `f1`.`field`=\'school_name\''
			. ' left join `entry_field` as `f2` on `f2`.`info`=`entry_info`.`id` and `f2`.`field`=\'school_name_ryaku\''
			. ' left join `entry_field` as `f3` on `f3`.`info`=`entry_info`.`id` and `f3`.`field`=\'school_address_pref\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' and `f1`.`year`='.$_SESSION['auth']['year'] //.' and `f2`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';

		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list );

		foreach( $list as &$lv ){
			if( isset( $lv['school_address_pref'] ) ){
				$lv['school_address_pref_name'] = $this->get_pref_name( $preftbl, intval($lv['school_address_pref']) );
			}
		}

		db_close( $dbs );
		return $list;
	}

	function get_entry_data_list3( $series, $mw )
	{
		$preftbl = $this->get_pref_array2();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info` where `del`=0 and `series`='.$series.' order by `disp_order` asc';

		$list = db_query_list( $dbs, $sql );

//echo $sql;
//print_r($list );

		foreach( $list as &$lv ){
			$sql = 'select * from `entry_field` where `info`='.$lv['id'].' and `year`='.$_SESSION['auth']['year'];
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $fv ){
				$field = get_field_string( $fv, 'field' );
				if( $field != '' ){
					$lv[$field] = get_field_string( $fv, 'data' );
				}
			}
			if( isset( $lv['school_address_pref'] ) ){
				$lv['school_address_pref_name'] = $this->get_pref_name( $preftbl, intval($lv['school_address_pref']) );
			}
		}

		db_close( $dbs );
		return $list;
	}

	function get_entry_data_list2( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`series`='.$series.' and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		if( $series == 2 ){
			$sql = 'select * from `entry_field` where `field` in (\'shumoku_dantai_m_taikai\',\'shumoku_dantai_m_rensei_am\',\'shumoku_dantai_m_rensei_pm\',\'shumoku_dantai_m_opening\',\'shumoku_dantai_m_konshin\',\'shumoku_dantai_w_taikai\',\'shumoku_dantai_w_rensei_am\',\'shumoku_dantai_w_rensei_pm\',\'shumoku_dantai_w_opening\',\'shumoku_dantai_w_konshin\')';
			$field_list = db_query_list( $dbs, $sql );
			foreach( $list as &$lv ){
				$id = intval( $lv['id'] );
				$lv['join'] = 0;
				$lv['join_m'] = 0;
				$lv['join_w'] = 0;
				foreach( $field_list as $fv ){
					$info = intval( $fv['info'] );
					if( $id == $info ){
						if( intval( $fv['data'] ) == 1 ){
							$lv['join'] = 1;
							if( substr( $fv['field'], 15, 1 ) == 'm' ){
								$lv['join_m'] = 1;
							} else {
								$lv['join_w'] = 1;
							}
							if( $lv['join_m'] == 1 && $lv['join_w'] == 1 ){
								break;
							}
						}
					}
				}
			}
		} else {
			$sql = 'select * from `entry_field` where `field` in (\'shumoku_dantai_taikai\',\'shumoku_dantai_rensei_am\',\'shumoku_dantai_rensei_pm\',\'shumoku_dantai_opening\',\'shumoku_dantai_konshin\') and `year`='.$_SESSION['auth']['year'];
			$field_list = db_query_list( $dbs, $sql );
			foreach( $list as &$lv ){
				$id = intval( $lv['id'] );
				$lv['join'] = 0;
				$lv['join_m'] = 0;
				$lv['join_w'] = 0;
				foreach( $field_list as $fv ){
					$info = intval( $fv['info'] );
					if( $id == $info ){
						if( intval( $fv['data'] ) == 1 ){
							$lv['join'] = 1;
							break;
						}
					}
				}
			}
		}

		db_close( $dbs );
		return $list;
	}

	function reset_disp_order( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`series`='.$series.' and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
			//.' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
echo "<!-- \n";
		for( $i1 = 1; $i1 <= count($list); $i1++ ){
			$sql = 'update `entry_info` set `disp_order`=' . $i1 . ' where `id`=' . $list[$i1-1]['id'];
			//db_query( $dbs, $sql );
echo $sql,";\n";
		}
echo "-->\n";
	}

	function get_entry_data_list_for_PDF( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=2';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
		}
	}

	function output_entry_data_list_excel2( $sheet )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=2 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `entry_info`.`disp_order` asc';
		//$sql = 'select `entry_info`.*, `entry_field`.`year` as `year`'
        //    . ' from `entry_info`'
        //    . ' inner join `entry_field` on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\'''
        //    . ' where `entry_info`.`del`=0 and `entry_info`.`series`=2 and `entry_field`.`year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$sheet->setCellValueByColumnAndRow( 1, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( 2, $pos, $fields['school_org_school_name'].$this->get_org_name( $orgtbl, intval($fields['school_org']) ) );
			$sheet->setCellValueByColumnAndRow( 3, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( 4, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( 5, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( 6, $pos, $fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( 7, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( 8, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( 9, $pos, $fields['manager_m_sei'].$fields['manager_m_mei'] );
			$sheet->setCellValueByColumnAndRow( 10, $pos, $fields['manager_w_sei'].$fields['manager_w_mei'] );
			$sheet->setCellValueByColumnAndRow( 11, $pos, $fields['responsible_contact_mobile'] );
			$sheet->setCellValueByColumnAndRow( 12, $pos, $fields['referee_sei'].$fields['referee_mei'] );
			if( $fields['shumoku_dantai_m_taikai'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 13, $pos, '○' );
			}
			if( $fields['shumoku_dantai_m_rensei_am'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 14, $pos, '○' );
			}
			if( $fields['shumoku_dantai_m_rensei_pm'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 15, $pos, '○' );
			}
			if( $fields['shumoku_dantai_m_opening'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 16, $pos, '○' );
			}
			if( $fields['shumoku_dantai_m_konshin'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 17, $pos, '○('.$fields['shumoku_dantai_m_text'].'名)' );
			}
			if( $fields['shumoku_dantai_w_taikai'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 18, $pos, '○' );
			}
			if( $fields['shumoku_dantai_w_rensei_am'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 19, $pos, '○' );
			}
			if( $fields['shumoku_dantai_w_rensei_pm'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 20, $pos, '○' );
			}
			if( $fields['shumoku_dantai_w_opening'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 21, $pos, '○' );
			}
			if( $fields['shumoku_dantai_w_konshin'] == 1 ){ 
				$sheet->setCellValueByColumnAndRow( 22, $pos, '○('.$fields['shumoku_dantai_w_text'].'名)' );
			}
			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( 23, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( 23, $pos, 'その他('.$fields['traffic_other'].')' );
			}
			$index++;
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_excel4( $sheet )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=4 order by `disp_order` asc';
	//	$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$sheet->setCellValueByColumnAndRow( 1, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( 3, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( 4, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( 5, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( 6, $pos, $fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( 7, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( 8, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( 9, $pos, $fields['school_email'] );

			$sel = explode( '|', $fields['shumoku_dantai_m'] );
			foreach( $sel as $sv ){
				if( $sv == 'taikai' ){
					$sheet->setCellValueByColumnAndRow( 11, $pos, '○' );
				} else if( $sv == 'rensei' ){
					$sheet->setCellValueByColumnAndRow( 12, $pos, '○' );
				}
			}
			$tantou = intval( $fields['kantoku_m_tantou'] );
			if( $tantou == 0 ){
				$sheet->setCellValueByColumnAndRow( 13, $pos, $fields['kantoku_m_sei'].$fields['kantoku_m_mei'] );
				$sheet->setCellValueByColumnAndRow( 14, $pos, $fields['kantoku_m_keitai_tel'] );
			} else if( $tantou == 1 ){
				$sheet->setCellValueByColumnAndRow( 13, $pos, $fields['insotu1_sei'].$fields['insotu1_mei'] );
				$sheet->setCellValueByColumnAndRow( 14, $pos, $fields['insotu1_keitai_tel'] );
			} else if( $tantou == 2 ){
				$sheet->setCellValueByColumnAndRow( 13, $pos, $fields['insotu2_sei'].$fields['insotu2_mei'] );
				$sheet->setCellValueByColumnAndRow( 14, $pos, $fields['insotu2_keitai_tel'] );
			} else if( $tantou == 3 ){
				$sheet->setCellValueByColumnAndRow( 13, $pos, $fields['insotu3_sei'].$fields['insotu3_mei'] );
				$sheet->setCellValueByColumnAndRow( 14, $pos, $fields['insotu3_keitai_tel'] );
			}

			$sel = explode( '|', $fields['shumoku_dantai_w'] );
			foreach( $sel as $sv ){
				if( $sv == 'taikai' ){
					$sheet->setCellValueByColumnAndRow( 16, $pos, '○' );
				} else if( $sv == 'rensei' ){
					$sheet->setCellValueByColumnAndRow( 17, $pos, '○' );
				}
			}
			$tantou = intval( $fields['kantoku_w_tantou'] );
			if( $tantou == 0 ){
				$sheet->setCellValueByColumnAndRow( 18, $pos, $fields['kantoku_m_sei'].$fields['kantoku_m_mei'] );
				$sheet->setCellValueByColumnAndRow( 19, $pos, $fields['kantoku_m_keitai_tel'] );
			} else if( $tantou == 1 ){
				$sheet->setCellValueByColumnAndRow( 18, $pos, $fields['insotu1_sei'].$fields['insotu1_mei'] );
				$sheet->setCellValueByColumnAndRow( 19, $pos, $fields['insotu1_keitai_tel'] );
			} else if( $tantou == 2 ){
				$sheet->setCellValueByColumnAndRow( 18, $pos, $fields['insotu2_sei'].$fields['insotu2_mei'] );
				$sheet->setCellValueByColumnAndRow( 19, $pos, $fields['insotu2_keitai_tel'] );
			} else if( $tantou == 3 ){
				$sheet->setCellValueByColumnAndRow( 18, $pos, $fields['insotu3_sei'].$fields['insotu3_mei'] );
				$sheet->setCellValueByColumnAndRow( 19, $pos, $fields['insotu3_keitai_tel'] );
			}

			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( 21, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( 21, $pos, 'その他('.$fields['traffic_other'].')' );
			}
			$index++;
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_excel3( $sheet )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		//$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3 order by `disp_order` asc';
		$sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
			.' inner join `entry_field`'
			.' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
			.' where `entry_info`.`del`=0 and `entry_info`.`series`=3 and `entry_field`.`year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`=' . $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( $fields['shumoku_dantai_taikai'] != '1' 
				&& $fields['shumoku_dantai_rensei_am'] != '1'
				&& $fields['shumoku_dantai_rensei_pm'] != '1'
				&& $fields['shumoku_dantai_opening'] != '1'
				&& $fields['shumoku_dantai_konshin'] != '1'
			){
				continue;
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_contact_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_sei'].' '.$fields['manager_mei'] );

			if( $fields['shumoku_dantai_taikai'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_pm'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+2, $pos, '○' );
			}
			if( $fields['shumoku_dantai_opening'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+3, $pos, '○' );
			}
			if( $fields['shumoku_dantai_konshin'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+4, $pos, '○ ('.$fields['shumoku_dantai_text'].'人参加)' );
			}
			$col += 5;

			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '' );
			}
			$index++;
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_all_excel3( $sheet )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3 order by `disp_order` asc';
	//	$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$shokumeitbl = $this->get_shokumei_array();
		$gradetbl = $this->get_grade_junior_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( $fields['shumoku_dantai_taikai'] != '1' 
				&& $fields['shumoku_dantai_rensei_am'] != '1'
				&& $fields['shumoku_dantai_rensei_pm'] != '1'
				&& $fields['shumoku_dantai_opening'] != '1'
				&& $fields['shumoku_dantai_konshin'] != '1'
			){
				continue;
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ).$fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_contact_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_contact_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['responsible_email'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu4_sei'].' '.$fields['insotu4_mei'] );
			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '' );
			}

			if( $fields['shumoku_dantai_taikai'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
			}
			if( $fields['shumoku_dantai_rensei_pm'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+2, $pos, '○' );
			}
			if( $fields['shumoku_dantai_opening'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+3, $pos, '○' );
			}
			if( $fields['shumoku_dantai_konshin'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+4, $pos, '○ ('.$fields['shumoku_dantai_text'].'人参加)' );
			}
			$col += 5;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_sei'].' '.$fields['manager_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['manager_add'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_sei'].' '.$fields['captain_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['captain_add'] );
			for( $player = 1; $player <= 7; $player++ ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_sei'].' '.$fields['player'.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['player'.$player.'_add'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_grade_junior_name( $gradetbl, intval($fields['player'.$player.'_grade']) ) );
			}
			$index++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['introduction'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['main_results'] );
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_all_excel4( $sheet )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=4 order by `disp_order` asc';
	//	$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$shokumeitbl = $this->get_shokumei_array();
		$gradetbl = $this->get_grade_junior_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='.$id;
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_org_school_name'].$this->get_org_name( $get_org_name, intval($fields['school_org']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ).$fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_email'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_add'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_kana_sei'].' '.$fields['insotu1_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu1_shokumei']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_fax'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_add'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu2_shokumei']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_keitai_fax'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_add'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_kana_sei'].' '.$fields['insotu3_kana_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu3_shokumei']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_keitai_fax'] );

			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			}

			$mw = 'm';
			for( $sss = 0; $sss < 2; $sss++ ){
				$sel = explode( '|', $fields['shumoku_dantai_'.$mw] );
				foreach( $sel as $sv ){
					if( $sv == 'taikai' ){
						$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
					} else if( $sv == 'rensei' ){
						$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
					}
				}
				$col += 2;
				$tantou = intval( $fields['kantoku_'.$mw.'_tantou'] );
				if( $tantou == 0 ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['その他'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kantoku_'.$mw.'_sei'].' '.$fields['kantoku_'.$mw.'_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kantoku_'.$mw.'_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kantoku_'.$mw.'_kana_sei'].' '.$fields['kantoku_'.$mw.'_kana_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['kantoku_'.$mw.'_shokumei']) ) );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kantoku_'.$mw.'_keitai_tel'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['kantoku_'.$mw.'_keitai_fax'] );
				} else if( $tantou == 1 ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['引率者1'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_kana_sei'].' '.$fields['insotu1_kana_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu1_shokumei']) ) );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_tel'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_fax'] );
				} else if( $tantou == 2 ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['引率者2'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_kana_sei'].' '.$fields['insotu2_kana_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu2_shokumei']) ) );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_keitai_tel'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_keitai_fax'] );
				} else if( $tantou == 3 ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['引率者3'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_kana_sei'].' '.$fields['insotu3_kana_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_shokumei_name( $shokumeitbl, intval($fields['insotu3_shokumei']) ) );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_keitai_tel'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_keitai_fax'] );
				}
				for( $player = 1; $player <= 7; $player++ ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mw.$player.'_sei'].' '.$fields['dantai_'.$mw.$player.'_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mw.$player.'_add'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mw.$player.'_disp'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_kana_'.$mw.$player.'_sei'].' '.$fields['dantai_kana_'.$mw.$player.'_mei'] );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_grade_junior_name( $gradetbl, intval($fields['dantai_gakunen_dan_'.$mw.$player.'_gakunen']) ) );
					$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_gakunen_dan_'.$mw.$player.'_dan'] );
				}
				$mw = 'w';
			}

			$index++;
			$pos++;
		}
		db_close( $dbs );
	}

	function __output_entry_data_list_excel5_6( $sheet, $series )
	{
		if( $series == 5 ){
			$mv = "m";
		} else {
			$mv = "w";
		}

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`=' . $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_org'].'立'.$fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );

			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_keitai_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_keitai_tel'] );
			if( $fields['kantoku_'.$mv.'_tantou'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			} else if( $fields['kantoku_'.$mv.'_tantou'] == '2' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			} else if( $fields['kantoku_'.$mv.'_tantou'] == '3' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			} else {
				$col++;
			}

			if( $fields['shumoku_dantai_'.$mv.'_taikai'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_1am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_1pm'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+2, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_3am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+3, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_opening'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+4, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_konshin'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+5, $pos, '○ ('.$fields['shumoku_dantai_'.$mv.'_text'].'人参加)' );
			}
			$col += 6;

			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '' );
			}
			$index++;
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_excel5( $sheet )
	{
		$this->__output_entry_data_list_excel5_6( $sheet, 5 );
	}

	function output_entry_data_list_excel6( $sheet )
	{
		$this->__output_entry_data_list_excel5_6( $sheet, 6 );
	}

	function __output_entry_data_list_all_excel5_6( $sheet, $series )
	{
		if( $series == 5 ){
			$mv = "m";
		} else {
			$mv = "w";
		}

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`='.$series.' order by `disp_order` asc';
	//	$sql = 'select `entry_info`.* from `entry_info` where `entry_info`.`del`=0 and `entry_info`.`series`=3';
		$list = db_query_list( $dbs, $sql );

		$preftbl = $this->get_pref_array();
		$orgtbl = $this->get_org_array();
		$shokumeitbl = $this->get_shokumei_array();
		$gradetbl = $this->get_grade_junior_array();
		$index = 1;
		$pos = 4;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sheet->setCellValueByColumnAndRow( 0 , $pos, $index );
			$sql = 'select * from `entry_field` where `info`='. $id . ' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			if( count( $flist ) == 0 ){ continue; }
			$fields = array();
			foreach( $flist as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$col = 1;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ) );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_org'].'立'.$fields['school_name'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_kana'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_name_ryaku'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_address_zip1'].'-'.$fields['school_address_zip2'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_pref_name( $preftbl, intval($fields['school_address_pref']) ).$fields['school_address'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_tel'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_phone_fax'] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['school_email'] );

			for( $member = 1; $member <= 3; $member++ ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu'.$member.'_sei'].' '.$fields['insotu'.$member.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu'.$member.'_add'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu'.$member.'_kana_sei'].' '.$fields['insotu'.$member.'_kana_mei'] );
				if( $fields['insotu'.$member.'_shokumei'] == '1' ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, '教諭' );
				} else if( $fields['insotu'.$member.'_shokumei'] == '2' ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, '専任監督' );
				} else if( $fields['insotu'.$member.'_shokumei'] == '3' ){
					$sheet->setCellValueByColumnAndRow( $col++, $pos, '外部指導者' );
				} else {
					$col++;
				}
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu'.$member.'_keitai_tel'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu'.$member.'_keitai_fax'] );
			}
			if( $fields['traffic'] == 'mycar' ){ 
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '自家用車('.$fields['traffic_mycar'].'台)' );
			} else if( $fields['traffic'] == 'bus_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（大）' );
			} else if( $fields['traffic'] == 'bus_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（中）' );
			} else if( $fields['traffic'] == 'bus_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手あり（マイクロ）' );
			} else if( $fields['traffic'] == 'bus_non_l' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（大）' );
			} else if( $fields['traffic'] == 'bus_non_m' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（中）' );
			} else if( $fields['traffic'] == 'bus_non_s' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'バス運転手なし（マイクロ）' );
			} else if( $fields['traffic'] == 'share' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '他のチームに便乗('.$fields['traffic_share'].')' );
			} else if( $fields['traffic'] == 'train' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '電車' );
			} else if( $fields['traffic'] == 'other' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, 'その他('.$fields['traffic_other'].')' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col++, $pos, '' );
			}

			if( $fields['shumoku_dantai_'.$mv.'_taikai'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_1am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+1, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_1pm'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+2, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_rensei_3am'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+3, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_opening'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+4, $pos, '○' );
			}
			if( $fields['shumoku_dantai_'.$mv.'_konshin'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col+5, $pos, '○ ('.$fields['shumoku_dantai_'.$mv.'_text'].'人参加)' );
			}
			$col += 6;

			if( $fields['kantoku_'.$mv.'_tantou'] == '1' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu1_sei'].' '.$fields['insotu1_mei'] );
			} else if( $fields['kantoku_'.$mv.'_tantou'] == '2' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu2_sei'].' '.$fields['insotu2_mei'] );
			} else if( $fields['kantoku_'.$mv.'_tantou'] == '3' ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['insotu3_sei'].' '.$fields['insotu3_mei'] );
			} else {
				$col++;
			}

			for( $player = 1; $player <= 7; $player++ ){
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mv.$player.'_sei'].' '.$fields['dantai_'.$mv.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mv.$player.'_add'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_'.$mv.$player.'_disp'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_kana_'.$mv.$player.'_sei'].' '.$fields['dantai_kana_'.$mv.$player.'_mei'] );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $this->get_grade_junior_name( $gradetbl, intval($fields['dantai_gakunen_dan_'.$mv.$player.'_gakunen']) ) );
				$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['dantai_gakunen_dan_'.$mv.$player.'_dan'] );
			}
			$index++;
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['introduction_'.$mv] );
			$sheet->setCellValueByColumnAndRow( $col++, $pos, $fields['main_results_'.$mv] );
			$pos++;
		}
		db_close( $dbs );
	}

	function output_entry_data_list_all_excel5( $sheet )
	{
		$this->__output_entry_data_list_all_excel5_6( $sheet, 5 );
	}

	function output_entry_data_list_all_excel6( $sheet )
	{
		$this->__output_entry_data_list_all_excel5_6( $sheet, 6 );
	}

	function get_advanced_entry_data_list( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `entry_info`.`id` as `id`,'
			. ' `f1`.`data` as `school_name`,'
			. ' `f2`.`data` as `school_name_ryaku`'
			. ' from `dantai_league` inner join `dantai_league_team`'
			. ' on `dantai_league_team`.`league`=`dantai_league`.`id`'
			. ' inner join `entry_info` on `dantai_league_team`.`team`=`entry_info`.`id`'
			. ' inner join `entry_field` as `f1` on `f1`.`info`=`entry_info`.`id` and `f1`.`field`=\'school_name\''
			. ' inner join `entry_field` as `f2` on `f2`.`info`=`entry_info`.`id` and `f2`.`field`=\'school_name_ryaku\''
			.' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0'
			.' and `dantai_league_team`.`advanced`=1';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}


	function get_advanced_entry_array_for_smarty( $series )
	{
		$list = $this->get_advanced_entry_data_list( $series );
		$data = array( 0 => '-' );
		foreach( $list as $lv ){
			if( isset( $lv['school_name_ryaku'] ) && $lv['school_name_ryaku'] != '' ){
				$data[$lv['id']] = $lv['school_name_ryaku'];
			} else {
				$data[$lv['id']] = $lv['school_name'];
			}
		}
		return $data;
	}

	function get_entry_array_for_smarty( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info` where `del`=0 and `series`='.$series.' order by `disp_order` asc';
		//$sql = 'select * from `entry_info` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' order by `disp_order` asc';
		//$list = db_query_list( $dbs, $sql );

        $func = 'get_entry_data_list2_' . $series;
        $list = $func();

//echo $sql;
//print_r($list );
		$data = array( 0 => '-' );
		foreach( $list as $lv ){
			$id = get_field_string_number( $lv, 'id', 0 );
			if( $id == 0 ){ continue; }
			if( get_field_string_number( $lv, 'del', 1 ) == 1 ){ continue; }
            //if( $mw != '' ){
            //    if( get_field_string_number( $lv, 'join_'.$mw, 0 ) == 0 ){ continue; }
            //} else {
                if( get_field_string_number( $lv, 'join', 0 ) == 0 ){ continue; }
            //}
			$ryaku = get_field_string( $lv, 'school_name_ryaku' );
			if( $ryaku != '' ){
				$data[$id] = $ryaku;
			} else {
				$data[$id] = get_field_string( $lv, 'school_name' );
			}
/*
			$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
			$fields = array();
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $fv ){
				$field = get_field_string( $fv, 'field' );
				if( $field != '' ){
					$fields[$field] = get_field_string( $fv, 'data' );
				}
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			$ryaku = get_field_string( $fields, 'school_name_ryaku' );
			if( $ryaku != '' ){
				$data[$id] = $ryaku;
			} else {
				$data[$id] = get_field_string( $fields, 'school_name' );
			}
*/
		}
		db_close( $dbs );

/*
		$list = $this->get_entry_data_list( $series, $mw );
		$data = array( 0 => '-' );
		foreach( $list as $lv ){
			if( $lv['school_name_ryaku'] != '' ){
				$data[$lv['id']] = $lv['school_name_ryaku'];
			} else {
				$data[$lv['id']] = $lv['school_name'];
			}
		}
*/
		return $data;
	}

	function get_entry_one_dantai_data( $data, $dantai_id, $dbs, $mw, $dantai_players_field_def, $player_field_def )
	{
		if( $dantai_id == 0 ){
			$data = $this->init_entry_post_data_from_def( $data, $dantai_players_field_def, 'dantai_', '_'.$mw );
			for( $i1 = 1; $i1 <= 7; $i1++ ){
				$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'dantai_', '_'.$mw.$i1 );
			}
		} else {
			$dantai = db_get_one_data( $dbs, 'dantai_players', '*', '`id`='.$dantai_id );
			$data = $this->get_entry_db_data_from_def( $data, $dantai, $dantai_players_field_def, 'dantai_', '_'.$mw, $_SESSION['auth']['series'] );
			for( $i1 = 1; $i1 <= 7; $i1++ ){
				$player_id = get_field_string_number( $dantai, 'player'.$i1, 0 );
				if( $player_id == 0 ){
					$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'dantai_', '_'.$mw.$i1 );
				} else {
					$player = db_get_one_data( $dbs, 'player', '*', '`id`='.$player_id );
					$data = $this->get_entry_db_data_from_def( $data, $player, $player_field_def, 'dantai_', '_'.$mw.$i1, $_SESSION['auth']['series'] );
				}
			}
		}
		return $data;
	}

	function get_entry_one_kojin_data( $data, $kojin_id, $dbs, $mw, $player_field_def )
	{
		if( $kojin_id == 0 ){
			for( $i1 = 1; $i1 <= 3; $i1++ ){
				$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'kojin_', '_'.$mw.$i1 );
			}
		} else {
			$kojin = db_get_one_data( $dbs, 'kojin_players', '*', '`id`='.$kojin_id );
			for( $i1 = 1; $i1 <= 3; $i1++ ){
				$player_id = get_field_string_number( $kojin, 'player'.$i1, 0 );
				if( $player_id == 0 ){
					$data = $this->init_entry_post_data_from_def( $data, $player_field_def, 'kojin_', '_'.$mw.$i1 );
				} else {
					$player = db_get_one_data( $dbs, 'player', '*', '`id`='.$player_id );
					$data = $this->get_entry_db_data_from_def( $data, $player, $player_field_def, 'kojin_', '_'.$mw.$i1, $_SESSION['auth']['series'] );
				}
			}
		}
		return $data;
	}

	function get_entry_one_data( $id )
	{
        $serieslist = $this->get_series_list( $_SESSION['auth']['series'] );
		$field_def = $this->get_entry_field_def($_SESSION['auth']['series']);
	//	$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
	//	$player_field_def = $this->get_entry_player_field_def();
		$data = $this->init_entry_post_data( $_SESSION['auth']['series'] );
		$data['id'] = $id;

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info` where `id`=' . $id;
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		if( count( $list ) == 0 ){ return $data; }
		$series = get_field_string_number( $list[0], 'series', 0 );
		if( $series == 0 || $series != $_SESSION['auth']['series'] ){ return $data; }

		$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
		$list2 = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list2);
		$list3 = array();
		foreach( $list2 as $lv ){
			$field = get_field_string( $lv, 'field' );
			if( $field != '' ){
				$list3[$field] = get_field_string( $lv, 'data' );
			}
		}
        if( count( $list3 ) == 0 && $serieslist['entry_new_copy_last_year'] == 1 ){
            $copy_fields = explode( ',', $serieslist['entry_new_copy_last_year_fields'] );
            $year = $_SESSION['auth']['year'] - 1;
            for(;;){
                $sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$year;
                $list2 = db_query_list( $dbs, $sql );
                if( count( $list2 ) > 0 ){
                    foreach( $list2 as $lv ){
                        $field = get_field_string( $lv, 'field' );
                        if( $field != '' ){
                            foreach( $copy_fields as $cf ){
//echo $field,':',$cf,"<br />";
                                if( $field == $cf ){
                                    $list3[$field] = get_field_string( $lv, 'data' );
                                }
                            }
                        }
                    }
                    break;
    			}
                if( $year == 0 ){ break; }
                if( $year == 2016 ){ $year = 0; } else { $year--; }
	    	}
        }
print_r($list3);
        $data = $this->get_entry_db_data_from_def( $data, $list3, $field_def, '', '', $series );
		db_close( $dbs );
		return $data;
	}

	function get_entry_one_data2( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info` where `id`=' . $id;
		$list = db_query_list( $dbs, $sql );
		if( count( $list ) == 0 ){ return array(); }
		$series = get_field_string_number( $list[0], 'series', 0 );
		if( $series == 0 ){ return array(); }

		$field_def = $this->get_entry_field_def( $series );
	//	$dantai_players_field_def = $this->get_entry_dantai_players_field_def();
	//	$player_field_def = $this->get_entry_player_field_def();
		$data = $this->init_entry_post_data( $series );
		$data['id'] = $id;

		$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
		$list2 = db_query_list( $dbs, $sql );
		$list3 = array();
		foreach( $list2 as $lv ){
			$field = get_field_string( $lv, 'field' );
			if( $field != '' ){
				$list3[$field] = get_field_string( $lv, 'data' );
			}
		}

		$data = $this->get_entry_db_data_from_def( $data, $list3, $field_def, '', '', $series );
	//	$dantai_m = get_field_string_number( $list, 'dantai_m', 0 );
	//	$data = $this->get_entry_one_dantai_data( $data, $dantai_m, $dbs, 'm', $dantai_players_field_def, $player_field_def );
	//	$dantai_w = get_field_string_number( $list, 'dantai_w', 0 );
	//	$data = $this->get_entry_one_dantai_data( $data, $dantai_w, $dbs, 'w', $dantai_players_field_def, $player_field_def );
	//	$kojin_m = get_field_string_number( $list, 'kojin_m', 0 );
	//	$data = $this->get_entry_one_kojin_data( $data, $kojin_m, $dbs, 'm', $player_field_def );
	//	$kojin_w = get_field_string_number( $list, 'kojin_w', 0 );
	//	$data = $this->get_entry_one_kojin_data( $data, $kojin_w, $dbs, 'w', $player_field_def );
		if( !isset( $data['school_name_ryaku'] ) || $data['school_name_ryaku'] == '' ){
			$data['school_name_ryaku'] = $data['school_name'];
		}

		$data['series'] = $series;

		db_close( $dbs );
		return $data;
	}

	function save_dantai_match_player_data_tbl_file(
		$series_dantai_league_m, $series_dantai_league_w
	){
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$fp = fopen( dirname(dirname(__FILE__)).'/common/dantai_match_player_info.php', "w" );
		fwrite( $fp, "<?php\n\n" );
		fwrite( $fp, '    $dantai_match_player_info = array(' . "\n" );
		$sql = 'select * from `entry_info` where `series` in ('.$series_dantai_league_m.','.$series_dantai_league_w.') and `year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$id = get_field_string_number( $lv, 'id', 0 );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`='.$id.' and `year`='.$_SESSION['auth']['year'];
			$flist = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $flist as $flv ){
				$field = get_field_string( $flv, 'field' );
				if( $field != '' ){
					$fields[$field] = get_field_string( $flv, 'data' );
				}
			}
			if( get_field_string_number( $fields, 'join', 0 ) == 0 ){ continue; }
			fwrite( $fp, '        '.$id." => array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5 ),\n" );
		}
		fwrite( $fp, "    );\n" );
		fclose( $fp );
	}

	function save_current_input_match_no_file( $place, $no )
	{
		global $__current_input_match_no__;

		$__current_input_match_no__[$place] = $no;
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$fp = fopen( dirname(dirname(__FILE__)).'/common/current_input_match_no.php', "w" );
		fwrite( $fp, "<?php\n\n" );
		fwrite( $fp, '    $__current_input_match_no__ = array(' . "\n" );
		for( $i1 = 1; $i1 <= 8; $i1++ ){
			fwrite( $fp, '       '.$i1.' => '.$__current_input_match_no__[$i1].",\n" );
		}
		fwrite( $fp, "    );\n" );
		fclose( $fp );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function clear_match_info( $series )
	{
//return;
        $debug = false;
		$fp = fopen( dirname(dirname(__FILE__)).'/log/clearback_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$fp2 = fopen( dirname(dirname(__FILE__)).'/log/clear_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select * from `dantai_league` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0 order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_league` set `extra_match_exists`='.$lv['extra_match_exists'].' where `id`='.$lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_league` set `extra_match_exists`=0 where `id`='.$lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		$sql = 'select `dantai_league_team`.*,`dantai_league`.`series` as `series`'
			. ' from `dantai_league` inner join `dantai_league_team`'
			. ' on `dantai_league_team`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_league_team`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`='.$lv['advanced'].',`standing`='.$lv['standing'].',`point`='.$lv['point'].',`win`='.$lv['win'].',`hon`='.$lv['hon']
				. ' where `id`='.$lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`=0,`standing`=0,`point`=0,`win`=0,`hon`=0,`update_date`=NOW()'
				. ' where `id`='.$lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		$sql = 'select `dantai_match`.*,`dantai_league_match`.`league` as `league`,`dantai_league`.`series` as `series`'
			. ' from `dantai_match`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' inner join `dantai_league` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_match`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_match`'
				. ' set `win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
				. ' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_match`'
			. ' set `win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		foreach( $list as $lv ){
			$sql = 'select * from `one_match`'
				. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
				. ' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $lv2 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
					. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
					. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
					. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
					. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
					. ' where `id`=' . $lv2['id'];
				fwrite( $fp, $sql.";\n" );
				$sql = 'update `one_match`'
					. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
					. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
					. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
					. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\''
					. ' where `id`=' . $lv2['id'];
                fwrite( $fp2, $sql.";\n" );
                if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
			}
		}

		$sql = 'select * from `dantai_tournament` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$dantai_tournament_list = db_query_list( $dbs, $sql );
        foreach( $dantai_tournament_list as $dantai_tournament_data ){

		$t = intval( $dantai_tournament_data['id'] );

		$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$t.' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_tournament_team` set `team`='.$lv['team'].' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
		}
		$sql = 'update `dantai_tournament_team` set `team`=0,`update_date`=NOW() where `tournament`='.$t;
        fwrite( $fp2, $sql.";\n" );
        if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }

		$sql = 'select `dantai_match`.*,`dantai_tournament_match`.`tournament` as `tournament`'
			. ' from `dantai_match`'
			. ' inner join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament_match`.`tournament`='.$t.' order by `dantai_match`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_match`'
				. ' set `team1`='.$lv['team1'].',`team2`='.$lv['team2'].',`win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
				. ' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_match`'
			. ' set `team1`=0,`team2`=0,`win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}

		foreach( $list as $lv ){
			$sql = 'select * from `one_match`'
				. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
				. ' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $lv2 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
					. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
					. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
					. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
					. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
					. ' where `id`=' . $lv2['id'];
				fwrite( $fp, $sql.";\n" );
				$sql = 'update `one_match`'
					. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
					. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
					. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
					. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\''
					. ' where `id`=' . $lv2['id'];
                fwrite( $fp2, $sql.";\n" );
                if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
			}
		}

		}

		db_close( $dbs );
		fclose( $fp );
		fclose( $fp2 );
	}

	function clear_match_info2( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$league_id_list = array();
		$dantai_match_id_list = array();
		$match_id_list = array( array(), array(), array(), array(), array(), array() );


		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$league_id_list[] = intval($lv['id']);

			$sql = 'update `dantai_league_team`'
				. ' set `advanced`=0,`standing`=0,`point`=0,`win`=0,`hon`=0,`update_date`=NOW()'
				. ' where `league`='.intval($lv['id']);
echo $sql,"\n";
			//db_query( $dbs, $sql );

			$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.intval($lv['id']);
			$dantai_matchs = db_query_list( $dbs, $sql );
echo 'dantai_league_match:';
print_r($dantai_matchs);
			foreach( $dantai_matchs as $dmv ){
				$dantai_match_id_list[] = intval( $dmv['match'] );

				$sql = 'update `dantai_match`'
					. ' set `win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW()'
					. ' where `id`=' . intval( $dmv['match'] );
echo $sql,"\n";
			//db_query( $dbs, $sql );
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$match_id = get_field_string_number( $dmv, 'match'.$i1, 0 );
					if( $match_id > 0 ){


						$sql = 'update `one_match`'
							. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
							. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
							. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,';
						if( $i1 == 6 ){
							$sql .= '`player1`=0,`player2`=0,`player1_change_name`=\'\',`player2_change_name`=\'\',';
							$match_id_list[0][] = $match_id;
						} else {
							$sql .= '`player1`='.$i1.',`player2`='.$i1.',`player1_change_name`=\'\',`player2_change_name`=\'\',';
							$match_id_list[$i1][] = $match_id;
						}
						$sql .= '`update_date`=NOW() where `id`=' . $match_id;
echo $sql,"\n";
						//db_query( $dbs, $sql );
					}
				}
			}
		}

		$tdata = db_get_one_data( $dbs, 'dantai_tournament', '*', '`series`='.$series.' and `year`='.$_SESSION['auth']['year'] );
		$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.intval($tdata['id']);
		$dantai_matchs = db_query_list( $dbs, $sql );
		foreach( $dantai_matchs as $dmv ){
			$dantai_match_id_list[] = intval( $dmv['match'] );
			$sql = 'update `dantai_match`'
				. ' set `win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW()'
				. ' where `id`=' . intval( $dmv['match'] );
echo $sql,"\n";
		//db_query( $dbs, $sql );
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$match_id = get_field_string_number( $dmv, 'match'.$i1, 0 );
				if( $match_id > 0 ){
					$sql = 'update `one_match`'
						. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
						. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
						. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,';
					if( $i1 == 6 ){
						$sql .= '`player1`=0,`player2`=0,`player1_change_name`=\'\',`player2_change_name`=\'\',';
						$match_id_list[0][] = $match_id;
					} else {
						$sql .= '`player1`='.$i1.',`player2`='.$i1.',`player1_change_name`=\'\',`player2_change_name`=\'\',';
						$match_id_list[$i1][] = $match_id;
					}
					$sql .= '`update_date`=NOW() where `id`=' . $match_id;
echo $sql,"\n";
					//db_query( $dbs, $sql );
				}
			}
		}

print_r( $league_id_list );
print_r( $dantai_match_id_list );
print_r( $match_id_list );

		db_close( $dbs );
	}

	function clear_kojin_match_info( $series )
	{
        $debug = false;
		$fp = fopen( dirname(dirname(__FILE__)).'/log/clearback_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$fp2 = fopen( dirname(dirname(__FILE__)).'/log/clear_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select * from `kojin_tournament` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$tournament_list = db_query_list( $dbs, $sql );
        foreach( $tournament_list as $ltv ){

    	$match_num = intval( $ltv['match_num'] );
		$match_level = intval( $ltv['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}

		$t = intval( $ltv['id'] );

		$sql = 'select `kojin_match`.*,`kojin_tournament_match`.`tournament` as `tournament`,'
            . ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`'
			. ' from `kojin_match`'
			. ' inner join `kojin_tournament_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament_match`.`tournament`='.$t
            . ' order by `kojin_tournament_match`.`tournament_match_index` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		foreach( $list as $lv ){
			$tournament_match_index = intval( $lv['tournament_match_index'] );
			$sql = 'select * from `one_match`'
				. ' where `id`='.$lv['match'].' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
            if( count( $list2 ) == 0 ){ continue; }
            $lv2 = $list2[0];
			$sql = 'update `one_match`'
    			. ' set `faul1_1`='.$lv2['faul1_1'].','
                . '`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
				. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
				. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
				. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
				. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
				. ' where `id`=' . $lv2['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `one_match`'
				. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
				. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
				. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0';
            if( $tournament_match_index < $macth1_level || $tournament_match_index > $match_num ){
				$sql .= ', `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\'';
            }
			$sql .= ' where `id`=' . $lv2['id'];
			fwrite( $fp2, $sql.";\n" );
            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
		}
//print_r($list);
//exit;
		foreach( $list as $lv ){
			$tournament_match_index = intval( $lv['tournament_match_index'] );
            if( $tournament_match_index >= $macth1_level && $tournament_match_index <= $match_num ){
                if( $lv['place'] == 'no_match' ){
					$t2 = intval( $tournament_match_index / 2 );
					$t2ofs = ( $tournament_match_index % 2 ) + 1;
                    $sql = 'select * from `one_match` where `id`=' . $lv['match'];
                    $list2 = db_query_list( $dbs, $sql );
                    if( count( $list2 ) == 0 ){ continue; }
                    foreach( $list as $lv2 ){
                        if( $lv2['tournament_match_index'] == $t2 ){
                            $sql = 'select * from `one_match` where `id`=' . $lv2['match'];
                            $list3 = db_query_list( $dbs, $sql );
                            $sql = 'update `one_match`'
                                . ' set `faul1_1`='.$list3[0]['faul1_1'] . ','
                                    . '`faul1_2`='.$list3[0]['faul1_2'] . ','
                                    . '`waza1_1`='.$list3[0]['waza1_1'] . ','
                                    . '`waza1_2`='.$list3[0]['waza1_2'] . ','
                                    . '`waza1_3`='.$list3[0]['waza1_3'] . ','
                                    . '`faul2_1`='.$list3[0]['faul2_1'] . ','
                                    . '`faul2_2`='.$list3[0]['faul2_2'] . ','
                                    . '`waza2_1`='.$list3[0]['waza2_1'] . ','
                                    . '`waza2_2`='.$list3[0]['waza2_2'] . ','
                                    . '`waza2_3`='.$list3[0]['waza2_3'] . ','
                                    . '`end_match`='.$list3[0]['end_match'] . ','
                                    . '`hon1`='.$list3[0]['hon1'] . ','
                                    . '`hon2`='.$list3[0]['hon2'] . ','
                                    . '`winner`='.$list3[0]['winner'] . ','
                                    . '`match_time`=\'\'' . ','
                                    . '`extra`='.$list3[0]['extra'] . ','
                                    . '`player1`='.$list3[0]['player1'] . ','
                                    . '`player2`='.$list3[0]['player2'] . ','
                                    . '`player1_change_name`=\''.$list3[0]['player1_change_name'].'\'' . ','
                                    . '`player2_change_name`=\''.$list3[0]['player2_change_name'].'\''
                                    . ' where `id`=' . $lv2['match'];
                            fwrite( $fp, $sql.";\n" );
							$sql = 'update `one_match` set ';
							if( $list2[0]['player1'] != 0 ){
								$sql .= '`player'.$t2ofs.'`='.$list2[0]['player1'];
							} else {
								$sql .= '`player'.$t2ofs.'`='.$list2[0]['player2'];
							}
							$sql .= ', `update_date`=NOW()';
							$sql .= ' where `id`=' . $lv2['match'];
                            fwrite( $fp2, $sql.";\n" );
                            if( $debug ){ echo $sql,";<br />\n"; } else { db_query( $dbs, $sql ); }
                        }
                    }
				}
			}
		}
		}

		db_close( $dbs );
		fclose( $fp );
		fclose( $fp2 );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_match_info( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.*,'
			. ' `dantai_league`.`advance_num` as `advance_num`,'
			. ' `dantai_league`.`match_num` as `match_num`,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`'
			. ' from `dantai_league_match` inner join `dantai_league` on `dantai_league`.`id`=`dantai_league_match`.`league` where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
		if( count( $dantai_league_match ) > 0 ){
			return array(
                'league_match_index' => intval( $dantai_league_match[0]['league_match_index'] ),
				'advance_num' => intval( $dantai_league_match[0]['advance_num'] ),
				'match_num' => intval( $dantai_league_match[0]['match_num'] ),
				'series' => intval( $dantai_league_match[0]['series'] ),
				'series_mw' => $dantai_league_match[0]['series_mw'],
				'league' => intval( $dantai_league_match[0]['league'] )
			);
		}
		$sql = 'select `dantai_tournament_match`.*,'
			. ' `dantai_tournament`.`match_num` as `match_num`,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`'
			. ' from `dantai_tournament_match` inner join `dantai_tournament` on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament` where `dantai_tournament_match`.`match`='.$match;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
//print_r($dantai_tournament_match);
		if( count( $dantai_tournament_match ) > 0 ){
			return array(
				'match_num' => intval( $dantai_tournament_match[0]['match_num'] ),
				'series' => intval( $dantai_tournament_match[0]['series'] ),
				'series_mw' => $dantai_tournament_match[0]['series_mw'],
				'tournament' => intval( $dantai_tournament_match[0]['tournament'] )
			);
		}
		return array();
	}

	function get_dantai_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$info = $this->get_dantai_match_info( $match );
		$series = get_field_string_number( $info, 'series', 0 );
		$series_mw = get_field_string( $info, 'series_mw' );
		$league = get_field_string_number( $info, 'league', 0 );
		$tournament = get_field_string_number( $info, 'tournament', 0 );
		if( $series == 0 ){ return array(); }

		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$dantai_match['league'] = $league;
		$dantai_match['tournament'] = $tournament;
		$dantai_match['series'] = $series;
		$dantai_match['series_mw'] = $series_mw;
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $one_match['player1'] == __PLAYER_NAME__ ){
    				$one_match['player1_name'] = $one_match['player1_change_name'];
                } else {
    				$one_match['player1_name'] = $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_mei'];
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $one_match['player2'] != __PLAYER_NAME__ ){
    				$one_match['player2_name'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_mei'];
                }
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei']
					);
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player2' => 0,
						'player2_name' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}
/*
	function get_dantai_match_navi( $category, $league, $match )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league`.`category` as `category`,'
			. ' `dantai_league_match`.`league` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
			. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($dantai_league_match);
		if( count( $dantai_league_match ) == 0 ){ return $list; }
		$place = get_field_string_number( $dantai_league_match[0], 'place', 0 );
		if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $dantai_league_match[0], 'place_match_no', 0 );
		if( $place_match_no == 0 ){ return $list; }
		$category = get_field_string_number( $dantai_league_match[0], 'category', 0 );
		$league = get_field_string_number( $dantai_league_match[0], 'league', 0 );
//print_r($dantai_league_match);

		if( $category == 1 ){
			$list['category_name'] = '男子団体予選リーグ';
		} else {
			$list['category_name'] = '女子団体予選リーグ';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第五試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第六試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第七試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第八試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$category_prev = $category;
		$league_prev = $league;
		$place_match_no_prev = $place_match_no;
		$sql = '';
		if( $place_match_no > 1 ){
			if( $league > 0 ){
				$sql = 'select `dantai_league`.`series` as `series`,'
				. ' `dantai_league`.`series_mw` as `series_mw`,'
				. ' `dantai_league`.`id` as `league`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_league_match`.`match` as `match`'
				. ' from `dantai_league` join `dantai_league_match`'
					. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
					. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count( $data ) > 0 ){
				$category = get_field_string_number( $data[0], 'category', 0 );
				$league = get_field_string_number( $data[0], 'league', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
				}
			}
		} else {
			$sql = 'select max(`kojin_match`.`place_match_no`) as `last_place_match_no`'
				. ' from `kojin_tournament` join `kojin_tournament_match`'
					. ' on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
					. ' join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
				. ' where `kojin_match`.`place`='.$place
					. ' and `kojin_tournament`.`category`=2';
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count($data) > 0 ){
				$place_match_no_prev = get_field_string_number( $data[0], 'last_place_match_no', 0 );
				if( $place_match_no_prev > 0 ){
					$sql = 'select `kojin_tournament`.`category` as `category`,'
						. ' `kojin_tournament_match`.`tournament` as `tournament`,'
						. ' `kojin_match`.`place` as `place`,'
						. ' `kojin_match`.`place_match_no` as `place_match_no`,'
						. ' `kojin_tournament_match`.`match` as `match`'
						. ' from `kojin_tournament` join `kojin_tournament_match`'
							. ' on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
							. ' join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
						. ' where `kojin_match`.`place`='.$place
							. ' and `kojin_match`.`place_match_no`='.$place_match_no_prev
							. ' and `kojin_tournament`.`category`=2';
					$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
					if( count( $data ) > 0 ){
						$category = get_field_string_number( $data[0], 'category', 0 );
						$tournament = get_field_string_number( $data[0], 'tournament', 0 );
						$match = get_field_string_number( $data[0], 'match', 0 );
						if( $match > 0 ){
							$list['prev'] = 'kojin_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
						}
					}
				}
			}
		}

		$sql = 'select `dantai_league`.`category` as `category`,'
			. ' `dantai_league_match`.`league` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
				. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
		$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
		if( count( $data ) > 0 ){
			$category = get_field_string_number( $data[0], 'category', 0 );
			$league = get_field_string_number( $data[0], 'league', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
			}
		} else {
			$sql = 'select `dantai_tournament`.`category` as `category`,'
				. ' `dantai_tournament_match`.`tournament` as `tournament`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_tournament_match`.`match` as `match`'
				. ' from `dantai_tournament` join `dantai_tournament_match`'
					. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
					. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count( $data ) > 0 ){
				$category = get_field_string_number( $data[0], 'category', 0 );
				$tournament = get_field_string_number( $data[0], 'tournament', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['next'] = 'dantai_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
				}
			}
		}
		db_close( $dbs );
		return $list;
	}
*/

	function set_dantai_fusen( $match, $fusen, $winner )
	{
		if( $match == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `dantai_match` set `fusen`='.$fusen.',`winner`='.$winner.' where `id`='.$match;
		db_query( $dbs, $sql );
	}

	function set_dantai_exist_match6( $match, $exist )
	{
		if( $match == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `dantai_match` set `exist_match6`='.$exist.' where `id`='.$match;
//echo $sql;
		db_query( $dbs, $sql );
	}

	function set_dantai_player( $navi_id, $match, $team, $match_no, $player, $name, $lt )
	{
		global $dantai_match_player_info;
		if( $match == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
/**/
		if( $lt > 0 ){
			$ldata = db_get_one_data( $dbs, ' dantai_league_match', '*', '`match`='.$match );
			$league_id = get_field_string_number( $ldata, 'league', 0 );
			$league_match_index = get_field_string_number( $ldata, 'league_match_index', 0 );
			$team_id = get_field_string_number( $data, 'team'.$team, 0 );
			if( $team_id != 0 ){
                if( !isset( $dantai_match_player_info[$team_id] ) ){
    				$dantai_match_player_info[$team_id] = array( 1=>1, 2=>2, 3=>3, 4=>4, 5=>5 );
                }
   				$dantai_match_player_info[$team_id][$match_no] = $player;
				$fp = fopen( dirname(dirname(__FILE__)).'/common/dantai_match_player_info.php', "w" );
				fwrite( $fp, "<?php\n\n" );
				fwrite( $fp, '    $dantai_match_player_info = array(' . "\n" );
				foreach( $dantai_match_player_info as $k=>$pi ){
					fwrite( $fp, '        '.$k.' => array( 1=>'.$pi[1].', 2=>'.$pi[2].', 3=>'.$pi[3].', 4=>'.$pi[4].', 5=>'.$pi[5]." ),\n" );
				}
				fwrite( $fp, "    );\n" );
				fclose( $fp );
			}
            $next_matches = array();
			if( $league_match_index == 1 ){
                if( $team == 1 ){
                    $next_matches[] = array( 'index' => 2, 'team' => 1 );
                    $next_matches[] = array( 'index' => 3, 'team' => 1 );
                } else if( $team == 2 ){
                    $next_matches[] = array( 'index' => 4, 'team' => 1 );
                    $next_matches[] = array( 'index' => 5, 'team' => 1 );
                }
            } else if( $league_match_index == 2 ){
                if( $team == 1 ){
                    $next_matches[] = array( 'index' => 3, 'team' => 1 );
                } else if( $team == 2 ){
                    $next_matches[] = array( 'index' => 4, 'team' => 2 );
                }
            } else if( $league_match_index == 3 ){
                if( $team == 1 ){
                } else if( $team == 2 ){
                }
            } else if( $league_match_index == 4 ){
                if( $team == 1 ){
                } else if( $team == 2 ){
                }
            } else if( $league_match_index == 5 ){
                if( $team == 1 ){
                    $next_matches[] = array( 'index' => 4, 'team' => 1 );
                } else if( $team == 2 ){
                    $next_matches[] = array( 'index' => 3, 'team' => 2 );
                }
            } else if( $league_match_index == 6 ){
                if( $team == 1 ){
                    $next_matches[] = array( 'index' => 2, 'team' => 2 );
                    $next_matches[] = array( 'index' => 4, 'team' => 2 );
                } else if( $team == 2 ){
                    $next_matches[] = array( 'index' => 3, 'team' => 2 );
                    $next_matches[] = array( 'index' => 5, 'team' => 2 );
                }
            }
			if( count( $next_matches ) > 0 ){
                foreach( $next_matches as $mv ){
    				$ldata = db_get_one_data( $dbs, ' dantai_league_match', '*', '`league`='.$league_id.' and `league_match_index`='.$mv['index'] );
	    			$next_match = get_field_string_number( $ldata, 'match', 0 );
		    		if( $next_match != 0 ){
			    		$next_data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$next_match );
				    	$next_one_match_id = get_field_string_number( $next_data, 'match'.$match_no, 0 );
					    if( $next_one_match_id != 0 ){
						    $sql = 'update `one_match` set `player'.$mv['team'].'`='.$player.',`player'.$mv['team'].'_change_name`=\''.$name.'\''
                                .' where `id`='.$next_one_match_id;
    						db_query( $dbs, $sql );
//echo $sql;
    					}
					}
				}
			}
/*
			$next_match_index = 0;
			if( $league_match_index == 2 && $team == 1 ){
				$next_match_index = 1;
				$next_player = 1;
			} else if( $league_match_index == 2 && $team == 2 ){
				$next_match_index = 3;
				$next_player = 2;
			} else if( $league_match_index == 3 && $team == 1 ){
				$next_match_index = 1;
				$next_player = 2;
			}
			if( $next_match_index != 0 ){
				$ldata = db_get_one_data( $dbs, ' dantai_league_match', '*', '`league`='.$league_id.' and `league_match_index`='.$next_match_index );
				$next_match = get_field_string_number( $ldata, 'match', 0 );
				if( $next_match != 0 ){
					$next_data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$next_match );
					$next_one_match_id = get_field_string_number( $next_data, 'match'.$match_no, 0 );
					if( $next_one_match_id != 0 ){
						$sql = 'update `one_match` set `player'.$next_player.'`='.$player.',`player'.$next_player.'_change_name`=\''.$name.'\''
                            .' where `id`='.$next_one_match_id;
						db_query( $dbs, $sql );
//echo $sql;
					}
				}
			}
*/
		}
/**/
        $team_id = get_field_string_number( $data, 'team'.$team, 0 );
		$sql = 'select * from `dantai_match_player_info`'
            . ' where `del`=0 and `navi_id`=' . $navi_id . ' and `team`='.$team_id.' and `player_index`='.$match_no;
		$list = db_query_list( $dbs, $sql );
		if( count( $list ) > 0 ){
    	    $sql = 'update `dantai_match_player_info` set `player`=' . $player . ' where `id`=' . $list[0]['id'];
		} else {
            $sql = 'insert into `dantai_match_player_info` set `player`=' . $player . ','
                . '`del`=0,`created`=NOW(),`navi_id`='.$navi_id.',`team`='.$team_id.',`player_index`='.$match_no;
        }
//echo $sql;
		db_query( $dbs, $sql );
		$one_match_id = get_field_string_number( $data, 'match'.$match_no, 0 );
		if( $one_match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `player' . $team . '`=' . $player . ',`player' . $team . '_change_name`=\'' . $name . '\''
				. ' where `id`='.$one_match_id;
			db_query( $dbs, $sql );
//echo $sql;
		}
	}

	function set_dantai_exchane_flag( $match )
	{
		if( $match == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$team1 = get_field_string_number( $data, 'team1', 0 );
		$team2 = get_field_string_number( $data, 'team2', 0 );
		$sql = 'update `dantai_match` set `team1`='.$team2.',`team2`='.$team1.' where `id`='.$match;
		db_query( $dbs, $sql );
	}

	function get_place_match( $series, $place, $no )
	{
		if( $series == 0 ){ return 0; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_match` where `id`>=255 and `place`='.$place.' and `place_match_no`='.$no;
		$dantai_match = db_query_list( $dbs, $sql );
		if( count( $dantai_match ) > 0 ){
			return $dantai_match[0]['id'];
		}
		return 0;
	}


	function get_dantai_league_place_top_match( $place, $series )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select `dantai_league_match`.`id` as `id` from `dantai_league`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' inner join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `year`='.$_SESSION['auth']['year']
			. ' and `dantai_match`.`place`='.$place.' and `place_match_no`=1';

		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r( $list );
		if( count( $list ) == 0 ){ return 0; }
		return $list[0]['id'];
	}

	//---------------------------------------------------------------

	function get_dantai_league_place_navi_data( $place, $series, $series_mw )
	{
		$place_name = array(
			'第一試合場', '第ニ試合場', '第三試合場', '第四試合場',
			'第五試合場', '第六試合場', '第七試合場', '第八試合場'
		);

		$data = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.`id` as `id`,'
			. ' `dantai_league`.`id` as `lt_id`,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_match`.`place_match_no_disp` as `place_match_no_disp`,'
			. ' `dantai_league_match`.`league_match_index` as `match_index`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' inner join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year']
			. ' and `dantai_match`.`place`='.$place.' order by `dantai_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		foreach( $list as $lv ){
			if( $series_mw == 'm' ){
				$lv['match_name'] = '男子';
			} else {
				$lv['match_name'] = '女子';
			}
			$lv['match_name'] .= '団体リーグ';
			$lv['series_mw'] = $series_mw;
			$lv['series_lt'] = 'dl';
			$lv['place_name'] = $place_name[$place-1];
			$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
			$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
			$data[] = $lv;
		}
		return $data;
	}

	function get_dantai_league_team_last_match_data( $series, $series_mw )
	{
		$data = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.`id` as `id`,'
			. ' `dantai_league`.`id` as `lt_id`,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_match`.`team1` as `team1`,'
			. ' `dantai_match`.`team2` as `team2`,'
			. ' `dantai_league_match`.`league_match_index` as `match_index`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' inner join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		return $list;
	}

	function get_dantai_tournament_place_navi_data( $place, $series, $series_mw )
	{
		$place_name = array(
			'第一試合場', '第ニ試合場', '第三試合場', '第四試合場',
			'第五試合場', '第六試合場', '第七試合場', '第八試合場'
		);

		$data = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament_match`.`id` as `id`,'
			. ' `dantai_tournament`.`id` as `lt_id`,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_match`.`place_match_no_disp` as `place_match_no_disp`,'
			. ' `dantai_tournament_match`.`match` as `match`,'
			. ' `dantai_tournament_match`.`tournament_match_index` as `match_index`'
			. ' from `dantai_tournament`'
			. ' inner join `dantai_tournament_match` on `dantai_tournament_match`.`tournament`=`dantai_tournament`.`id`'
			. ' inner join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament`.`series`='.$series
			. ' and `dantai_tournament`.`year`='.$_SESSION['auth']['year']
			. ' and `dantai_match`.`place`='.$place
			. ' order by `dantai_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		foreach( $list as $lv ){
			if( $series_mw == 'm' ){
				$lv['match_name'] = '男子';
			} else {
				$lv['match_name'] = '女子';
			}
			$lv['match_name'] .= '団体決勝トーナメント';
			$lv['series_mw'] = $series_mw;
			$lv['series_lt'] = 'dt';
			$lv['place_name'] = $place_name[$place-1];
			$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
			$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
			$data[] = $lv;
		}
		return $data;
	}

	function get_kojin_tournament_place_navi_data( $place, $series, $series_mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$place_name = array(
			'第一試合場', '第ニ試合場', '第三試合場', '第四試合場',
			'第五試合場', '第六試合場', '第七試合場', '第八試合場'
		);

		$sql = 'select `kojin_tournament_match`.`id` as `id`,'
			. ' `kojin_tournament`.`id` as `lt_id`,'
			. ' `kojin_tournament`.`series` as `series`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`,'
			. ' `kojin_match`.`place_match_no_disp` as `place_match_no_disp`,'
			. ' `kojin_tournament_match`.`match` as `match`,'
			. ' `kojin_tournament_match`.`tournament_match_index` as `match_index`'
			. ' from `kojin_tournament`'
			. ' inner join `kojin_tournament_match` on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
			. ' inner join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament`.`series`='.$series.' and `kojin_tournament`.`year`='.$_SESSION['auth']['year']
			. ' and `kojin_match`.`place`='.$place.' order by `kojin_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		foreach( $list as $lv ){
			if( $series_mw == 'm' ){
				$lv['match_name'] = '男子';
			} else {
				$lv['match_name'] = '女子';
			}
			$lv['match_name'] .= '個人トーナメント';
			$lv['series_mw'] = $series_mw;
			$lv['series_lt'] = 'kt';
			$lv['place_name'] = $place_name[$place-1];
			$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
			$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
			$data[] = $lv;
		}

		db_close( $dbs );
		return $data;
	}

	function save_tournament_place_navi_data_tbl_file(
		$series_dantai_league_m, $series_dantai_league_w,
		$series_dantai_tournament_m, $series_dantai_tournament_w,
		$series_kojin_m, $series_kojin_w,
		$place_num
	){
		$fp = fopen( dirname(dirname(__FILE__)).'/common/navi.php', "w" );
		fwrite( $fp, "<?php\n\n" );
		fwrite( $fp, '    $navi_info = array(' . "\n" );
		$top_match = array();
		for( $place = 1; $place <= $place_num; $place++ ){
			$top_match[$place] = array();
			if( $place > 1 ){ fwrite( $fp, ",\n" ); }
			fwrite( $fp, '        '.$place.' => array('."\n" );
			$navi = array();
			if( $series_dantai_league_m != 0 ){
				$navi['dantai_league_m'] = $this->get_dantai_league_place_navi_data( $place, $series_dantai_league_m, 'm' );
			}
			if( $series_dantai_league_w != 0 ){
				$navi['dantai_league_w'] = $this->get_dantai_league_place_navi_data( $place, $series_dantai_league_w, 'w' );
			}
			if( $series_dantai_tournament_m != 0 ){
				$navi['dantai_tournament_m'] = $this->get_dantai_tournament_place_navi_data( $place, $series_dantai_tournament_m, 'm' );
			}
			if( $series_dantai_tournament_w != 0 ){
				$navi['dantai_tournament_w'] = $this->get_dantai_tournament_place_navi_data( $place, $series_dantai_tournament_w, 'w' );
			}
			if( $series_kojin_m != 0 ){
				$navi['kojin_tournament_m'] = $this->get_kojin_tournament_place_navi_data( $place, $series_kojin_m, 'm' );
			}
			if( $series_kojin_w != 0 ){
				$navi['kojin_tournament_w'] = $this->get_kojin_tournament_place_navi_data( $place, $series_kojin_w, 'w' );
			}

            $kojin_offset = 0;
            if( isset( $navi['kojin_tournament_m'] ) ){
                $kojin_offset += count( $navi['kojin_tournament_m'] );
                if( count($navi['kojin_tournament_m']) > 0 ){
    				$top_match[$place]['kojin_tournament_m'] = $navi['kojin_tournament_m'][0]['place_match_no'];
    				for( $i1 = 0; $i1 < count($navi['kojin_tournament_m']); $i1++ ){
	    				if( $navi['kojin_tournament_m'][$i1]['match_index'] < 8 ){
		    				$top_match[$place]['kojin_tournament_m8'] = $navi['kojin_tournament_m'][$i1]['place_match_no'];
    						break;
	    				}
		    		}
                } else {
    				$top_match[$place]['kojin_tournament_m'] = 0;
    				$top_match[$place]['kojin_tournament_m8'] = 0;
                }
            }
            if( isset( $navi['kojin_tournament_w'] ) ){
                $kojin_offset += count( $navi['kojin_tournament_w'] );
                if( count($navi['kojin_tournament_w']) > 0 ){
    				$top_match[$place]['kojin_tournament_w'] = $navi['kojin_tournament_w'][0]['place_match_no'];
    				for( $i1 = 0; $i1 < count($navi['kojin_tournament_w']); $i1++ ){
	    				if( $navi['kojin_tournament_w'][$i1]['match_index'] < 8 ){
		    				$top_match[$place]['kojin_tournament_w8'] = $navi['kojin_tournament_w'][$i1]['place_match_no'];
    						break;
	    				}
		    		}
                } else {
    				$top_match[$place]['kojin_tournament_w'] = 0;
    				$top_match[$place]['kojin_tournament_w8'] = 0;
                }
            }
            $kojin_offset = 0;
            if( isset( $navi['dantai_league_m'] ) ){
                if( count($navi['dantai_league_m']) > 0 ){
                    foreach( $navi['dantai_league_m'] as &$nv ){
                        $nv['place_match_no'] += $kojin_offset;
                    }
                    unset( $nv );
                    $top_match[$place]['dantai_league_m'] = $navi['dantai_league_m'][0]['place_match_no'];
                } else {
    				$top_match[$place]['dantai_league_m'] = 0;
                }
            }
            if( isset( $navi['dantai_league_w'] ) ){
                if( count($navi['dantai_league_w']) > 0 ){
                    foreach( $navi['dantai_league_w'] as &$nv ){
                        $nv['place_match_no'] += $kojin_offset;
                    }
                    unset( $nv );
                    $top_match[$place]['dantai_league_w'] = $navi['dantai_league_w'][0]['place_match_no'];
                } else {
    				$top_match[$place]['dantai_league_w'] = 0;
                }
            }
            if( isset( $navi['dantai_tournament_m'] ) ){
                if( count($navi['dantai_tournament_m']) > 0 ){
                    foreach( $navi['dantai_tournament_m'] as &$nv ){
                        $nv['place_match_no'] += $kojin_offset;
                    }
                    unset( $nv );
                    $top_match[$place]['dantai_tournament_m'] = $navi['dantai_tournament_m'][0]['place_match_no'];
                    for( $i1 = 0; $i1 < count($navi['dantai_tournament_m']); $i1++ ){
                        if( $navi['dantai_tournament_m'][$i1]['match_index'] < 8 ){
                            $top_match[$place]['dantai_tournament_m8'] = $navi['dantai_tournament_m'][$i1]['place_match_no'];
                            break;
                        }
                    }
                } else {
    				$top_match[$place]['dantai_tournament_m'] = 0;
    				$top_match[$place]['dantai_tournament_m8'] = 0;
                }
            }
            if( isset( $navi['dantai_tournament_w'] ) ){
                if( count($navi['dantai_tournament_w']) > 0 ){
                    foreach( $navi['dantai_tournament_w'] as &$nv ){
                        $nv['place_match_no'] += $kojin_offset;
                    }
                    unset( $nv );
                    $top_match[$place]['dantai_tournament_w'] = $navi['dantai_tournament_w'][0]['place_match_no'];
                    for( $i1 = 0; $i1 < count($navi['dantai_tournament_w']); $i1++ ){
                        if( $navi['dantai_tournament_w'][$i1]['match_index'] < 8 ){
                            $top_match[$place]['dantai_tournament_w8'] = $navi['dantai_tournament_w'][$i1]['place_match_no'];
                            break;
                        }
                    }
                } else {
    				$top_match[$place]['dantai_tournament_w'] = 0;
    				$top_match[$place]['dantai_tournament_w8'] = 0;
                }
            }

			$data = array();
			foreach( $navi as $onenavi ){
				foreach( $onenavi as $nv ){
					$data[$nv['place_match_no']] = $nv;
				}
			}
			$c = 0;
			foreach( $data as $dv ){
				if( $c > 0 ){ fwrite( $fp, ",\n" ); }
				fwrite( $fp, '            '.$dv['place_match_no']." => array(\n" );
				fwrite( $fp, '                \'id\' => '.$dv['id'].",\n" );
				fwrite( $fp, '                \'lt_id\' => '.$dv['lt_id'].",\n" );
				fwrite( $fp, '                \'series\' => '.$dv['series'].",\n" );
				fwrite( $fp, '                \'series_mw\' => \''.$dv['series_mw']."',\n" );
				fwrite( $fp, '                \'series_lt\' => \''.$dv['series_lt']."',\n" );
				fwrite( $fp, '                \'match_index\' => '.get_field_string_number($dv,'match_index',0).",\n" );
				fwrite( $fp, '                \'place_match_no\' => '.$dv['place_match_no'].",\n" );
				fwrite( $fp, '                \'place_match_no_disp\' => '.$dv['place_match_no_disp'].",\n" );
				fwrite( $fp, '                \'match\' => '.$dv['match'].",\n" );
				fwrite( $fp, '                \'match_name\' => \''.$dv['match_name']."',\n" );
				fwrite( $fp, '                \'place_name\' => \''.$dv['place_name']."',\n" );
				fwrite( $fp, '                \'place_match_no_name\' => \''.$dv['place_match_no_name']."',\n" );
				fwrite( $fp, '                \'place_match_no_name_disp\' => \''.$dv['place_match_no_name_disp']."'\n" );
				fwrite( $fp, '            )' );
				$c++;
			}
			fwrite( $fp, "\n        )" );
		}
		fwrite( $fp, "\n    );\n" );

		fwrite( $fp, '    $navi_top = array(' . "\n" );
		for( $place = 1; $place <= $place_num; $place++ ){
			if( $place > 1 ){ fwrite( $fp, ",\n" ); }
			fwrite( $fp, '        '.$place.' => array('."\n" );
			fwrite( $fp, '            \'dantai_league_m\' => '.get_field_string_number($top_match[$place],'dantai_league_m',0).','."\n" );
			fwrite( $fp, '            \'dantai_league_w\' => '.get_field_string_number($top_match[$place],'dantai_league_w',0).','."\n" );
			fwrite( $fp, '            \'dantai_tournament_m\' => '.get_field_string_number($top_match[$place],'dantai_tournament_m',0).','."\n" );
			fwrite( $fp, '            \'dantai_tournament_m8\' => '.get_field_string_number($top_match[$place],'dantai_tournament_m8',0).','."\n" );
			fwrite( $fp, '            \'dantai_tournament_w\' => '.get_field_string_number($top_match[$place],'dantai_tournament_w',0).','."\n" );
			fwrite( $fp, '            \'dantai_tournament_w8\' => '.get_field_string_number($top_match[$place],'dantai_tournament_w8',0).','."\n" );
			fwrite( $fp, '            \'kojin_tournament_m\' => '.get_field_string_number($top_match[$place],'kojin_tournament_m',0).','."\n" );
			fwrite( $fp, '            \'kojin_tournament_m8\' => '.get_field_string_number($top_match[$place],'kojin_tournament_m8',0).','."\n" );
			fwrite( $fp, '            \'kojin_tournament_w\' => '.get_field_string_number($top_match[$place],'kojin_tournament_w',0).','."\n" );
			fwrite( $fp, '            \'kojin_tournament_w8\' => '.get_field_string_number($top_match[$place],'kojin_tournament_w8',0)."\n" );
			fwrite( $fp, "\n        )" );
		}
		fwrite( $fp, "\n    );\n" );

		fwrite( $fp, '    $__dantai_league_team_last_match__ = array(' . "\n" );
		$list = $this->get_dantai_league_team_last_match_data( $series_dantai_league_m, 'm' );
		foreach( $list as $lv ){
			if( $lv['match_index'] == 2 ){
				fwrite( $fp, '        '.$lv['team1'].' => array( '.$lv['match'].", 1 ),\n" );
				fwrite( $fp, '        '.$lv['team2'].' => array( '.$lv['match'].", 2 ),\n" );
			} else if( $lv['match_index'] == 3 ){
				fwrite( $fp, '        '.$lv['team1'].' => array( '.$lv['match'].", 2 ),\n" );
			}
		}
		$list = $this->get_dantai_league_team_last_match_data( $series_dantai_league_w, 'w' );
		foreach( $list as $lv ){
			if( $lv['match_index'] == 2 ){
				fwrite( $fp, '        '.$lv['team1'].' => array( '.$lv['match'].", 1 ),\n" );
				fwrite( $fp, '        '.$lv['team2'].' => array( '.$lv['match'].", 2 ),\n" );
			} else if( $lv['match_index'] == 3 ){
				fwrite( $fp, '        '.$lv['team1'].' => array( '.$lv['match'].", 2 ),\n" );
			}
		}
		fwrite( $fp, "\n    );\n" );

		fclose( $fp );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function update_place_navi_data( $data, $navi_id, $dbs )
	{
        if( $data['place'] == 0 || $data['place_match_no'] == 0 ){ return; }

		$sql = 'select * from `navi_info` where `del`=1 and `navi_id`=' . $navi_id;
		$list = db_query_list( $dbs, $sql );
        $sqlset = '`place_no`=' . $data['place'] . ','
            . '`place_name`=\'' . $data['place_name'] . '\','
            . '`place_match_no`=' . $data['place_match_no'] . ','
            . '`place_match_no_disp`=' . $data['place_match_no_disp'] . ','
            . '`place_match_no_name`=\'' . $data['place_match_no_name'] . '\','
            . '`place_match_no_name_disp`=\'' . $data['place_match_no_name_disp'] . '\','
            . '`lt_id`=' . $data['lt_id'] . ','
            . '`series`=' . $data['series'] . ','
            . '`series_info_id`=' . $data['series_info_id'] . ','
            . '`series_mw`=\'' . $data['series_mw'] . '\','
            . '`series_lt`=\'' . $data['series_lt'] . '\','
            . '`match_index`=' . $data['match_index'] . ','
            . '`match_id`=' . $data['match'] . ','
            . '`match_name`=\'' . $data['match_name'] . '\','
            . '`year`=' . $data['year'] . ','
            . '`result_path`=\'' . $data['result_path'] . '\','
            . '`result_prefix`=\'' . $data['result_prefix'] . '\','
            . '`split_tournament_match_output`=' . $data['split_tournament_match_output'] . ','
            . '`del`=0';
        if( count( $list ) == 0 ){
            $sql = 'insert into `navi_info` set ' . $sqlset . ',`created`=NOW(),`navi_id`='.$navi_id;
        } else {
            $sql = 'update `navi_info` set ' . $sqlset . ' where `id`=' . $list[0]['id'];
        }
//print_r($data);
//echo $sql,"<br />\n";
		db_query( $dbs, $sql );
    }

	function update_dantai_league_place_navi_data( $series, $series_info, $navi_id, $dbs )
	{
		$sql = 'select `dantai_league_match`.`id` as `id`,'
			. ' `dantai_league`.`id` as `lt_id`,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`,'
			. ' `dantai_league`.`match_offset` as `match_offset`,'
			. ' `dantai_league`.`match_num` as `match_num`,'
			. ' `dantai_league`.`extra_match_num` as `extra_match_num`,'
			. ' `dantai_league`.`name` as `league_name`,'
			. ' `dantai_league`.`place_num` as `place_num`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_match`.`place_match_no_disp` as `place_match_no_disp`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_league_match`.`league_match_index` as `match_index`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' inner join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year']
			. ' order by `dantai_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
            $match_index = intval( $lv['match_index'] );
            $match_num = intval( $lv['match_num'] );
            $place_num = intval( $lv['place_num'] );
            $lt_id = intval( $lv['lt_id'] );
            if( $match_index <= $match_num ){
    			$lv['match_name'] .= '';
	    		if( $lv['series_mw'] == 'm' ){
		    		$lv['match_name'] = '男子';
			    } else if( $lv['series_mw'] == 'w' ){
				    $lv['match_name'] = '女子';
    			}
	    		$lv['match_name'] .= '団体リーグ';
		    	$lv['series_lt'] = 'dl';
				$lv['place_name'] = '第' . $lv['place'] . '試合場';
				$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
				$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
            	$lv['year'] = $_SESSION['auth']['year'];
            	$lv['series_info_id'] = $series_info['series_info_id'];
            	$lv['result_path'] = $series_info['result_path'];
            	$lv['result_prefix'] = $series_info['result_prefix'];
            	$lv['split_tournament_match_output'] = $series_info['split_tournament_match_output'];
				$this->update_place_navi_data( $lv, $navi_id, $dbs );
            } else {
    			$lv['match_name'] .= '';
	    		if( $lv['series_mw'] == 'm' ){
		    		$lv['match_name'] = '男子';
			    } else if( $lv['series_mw'] == 'w' ){
				    $lv['match_name'] = '女子';
    			}
	    		$lv['match_name'] .= $lv['league_name'];
		    	$lv['match_name'] .= '代表戦';
		    	$lv['series_lt'] = 'dl';
				$lv['place_name'] = '';
				$lv['place_match_no_name'] = $lv['match_name'] . '(' . ($match_index - $match_num) . ')';
				$lv['place_match_no_name_disp'] = '';
            	$lv['year'] = $_SESSION['auth']['year'];
            	$lv['series_info_id'] = $series_info['series_info_id'];
            	$lv['result_path'] = $series_info['result_path'];
            	$lv['result_prefix'] = $series_info['result_prefix'];
            	$lv['split_tournament_match_output'] = $series_info['split_tournament_match_output'];
                for( $i1 = 1; $i1 <= $place_num; $i1++ ){
    				$lv['place'] = $i1;
    				$lv['place_match_no'] = $lt_id * 1000 + $match_index - $match_num;
    				$this->update_place_navi_data( $lv, $navi_id, $dbs );
                }
            }
		}
	}

	function update_dantai_tournament_place_navi_data( $series, $series_info, $navi_id, $dbs )
	{
		$sql = 'select `dantai_tournament_match`.`id` as `id`,'
			. ' `dantai_tournament`.`id` as `lt_id`,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`,'
			. ' `dantai_tournament`.`match_offset` as `match_offset`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_match`.`place_match_no_disp` as `place_match_no_disp`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_tournament_match`.`match` as `match`,'
			. ' `dantai_tournament_match`.`tournament_match_index` as `match_index`'
			. ' from `dantai_tournament`'
			. ' inner join `dantai_tournament_match` on `dantai_tournament_match`.`tournament`=`dantai_tournament`.`id`'
			. ' inner join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament`.`series`='.$series
			. ' and `dantai_tournament`.`year`='.$_SESSION['auth']['year']
			. ' order by `dantai_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$lv['match_name'] .= '';
			if( $lv['series_mw'] == 'm' ){
				$lv['match_name'] = '男子';
			} else if( $lv['series_mw'] == 'w' ){
				$lv['match_name'] = '女子';
			}
			$lv['match_name'] .= '団体トーナメント';
			$lv['series_lt'] = 'dt';
			$lv['place_name'] = '第' . $lv['place'] . '試合場';
			$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
			$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
            $lv['year'] = $_SESSION['auth']['year'];
            $lv['series_info_id'] = $series_info['series_info_id'];
            $lv['result_path'] = $series_info['result_path'];
            $lv['result_prefix'] = $series_info['result_prefix'];
            $lv['split_tournament_match_output'] = $series_info['split_tournament_match_output'];
			$this->update_place_navi_data( $lv, $navi_id, $dbs );
		}
	}

	function update_kojin_tournament_place_navi_data( $series, $series_info, $navi_id, $dbs )
	{
		$sql = 'select `kojin_tournament_match`.`id` as `id`,'
			. ' `kojin_tournament`.`id` as `lt_id`,'
			. ' `kojin_tournament`.`series` as `series`,'
			. ' `kojin_tournament`.`series_mw` as `series_mw`,'
			. ' `kojin_tournament`.`match_offset` as `match_offset`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`,'
			. ' `kojin_match`.`place_match_no_disp` as `place_match_no_disp`,'
            . ' `kojin_match`.`place` as `place`,'
			. ' `kojin_tournament_match`.`match` as `match`,'
			. ' `kojin_tournament_match`.`tournament_match_index` as `match_index`'
			. ' from `kojin_tournament`'
			. ' inner join `kojin_tournament_match` on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
			. ' inner join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament`.`series`='.$series.' and `kojin_tournament`.`year`='.$_SESSION['auth']['year']
			. ' order by `kojin_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$lv['match_name'] .= '';
			if( $lv['series_mw'] == 'm' ){
				$lv['match_name'] = '男子';
			} else if( $lv['series_mw'] == 'w' ){
				$lv['match_name'] = '女子';
			}
			$lv['match_name'] .= '個人トーナメント';
			$lv['series_lt'] = 'kt';
			$lv['place_name'] = '第' . $lv['place'] . '試合場';
			$lv['place_match_no_name'] = '第'.$lv['place_match_no'].'試合';
			$lv['place_match_no_name_disp'] = '第'.$lv['place_match_no_disp'].'試合';
            $lv['year'] = $_SESSION['auth']['year'];
            $lv['series_info_id'] = $series_info['series_info_id'];
            $lv['result_path'] = $series_info['result_path'];
            $lv['result_prefix'] = $series_info['result_prefix'];
            $lv['split_tournament_match_output'] = $series_info['split_tournament_match_output'];
			$this->update_place_navi_data( $lv, $navi_id, $dbs );
		}
	}

	function update_series_place_navi_data( $navi_id )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'update `navi_info` set del=1 where `navi_id`=' . $navi_id;
		db_query( $dbs, $sql );
		$sql = 'select `series`.`dantai_league_m` as `dantai_league_m`,'
            . '`series`.`id` as `series_info_id`,'
            . '`series`.`dantai_tournament_m` as `dantai_tournament_m`,'
            . '`series`.`dantai_league_w` as `dantai_league_w`,'
            . '`series`.`dantai_tournament_w` as `dantai_tournament_w`,'
            . '`series`.`kojin_tournament_m` as `kojin_tournament_m`,'
            . '`series`.`kojin_tournament_w` as `kojin_tournament_w`,'
            . '`series`.`result_path` as `result_path`,'
            . '`series`.`result_prefix` as `result_prefix`,'
            . '`series`.`split_tournament_match_output` as `split_tournament_match_output`'
			. ' from `series`'
			. ' inner join `navi_series` on `navi_series`.`series`=`series`.`id`'
			. ' where `navi_series`.`navi_id`='.$navi_id.' and `navi_series`.`del`=0'
			. ' order by `navi_series`.`id` asc';
        $dl = array();
        $dt = array();
        $kt = array();
		$nlist = db_query_list( $dbs, $sql );
        foreach( $nlist as $nv ){
            if( $nv['dantai_league_m'] != 0 ){ $dl[$nv['dantai_league_m']] = $nv; }
            if( $nv['dantai_tournament_m'] != 0 ){ $dt[$nv['dantai_tournament_m']] = $nv; }
            if( $nv['dantai_league_w'] != 0 ){ $dl[$nv['dantai_league_w']] = $nv; }
            if( $nv['dantai_tournament_w'] != 0 ){ $dt[$nv['dantai_tournament_w']] = $nv; }
            if( $nv['kojin_tournament_m'] != 0 ){ $kt[$nv['kojin_tournament_m']] = $nv; }
            if( $nv['kojin_tournament_w'] != 0 ){ $kt[$nv['kojin_tournament_w']] = $nv; }
        }
        foreach( $dl as $k => $v ){
            $this->update_dantai_league_place_navi_data( $k, $v, $navi_id, $dbs );
        }
        foreach( $dt as $k => $v ){
            $this->update_dantai_tournament_place_navi_data( $k, $v, $navi_id, $dbs );
        }
        foreach( $kt as $k => $v ){
            $this->update_kojin_tournament_place_navi_data( $k, $v, $navi_id, $dbs );
        }
    }

	function get_series_place_navi_data( $navi_id, $place, $place_match_no )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `navi_info`'
            . ' where `del`=0 and `navi_id`=' . $navi_id
            . ' and `place_no`=' . $place . ' and `place_match_no`=' . $place_match_no;
		$nlist = db_query_list( $dbs, $sql );
        if( count( $nlist ) == 0 ){ return array(); }
        if( $nlist[0]['series_lt'] === 'dl' || $nlist[0]['series_lt'] === 'dt' ){
            if( $place_match_no >= 1000 ){
                $nlist[0]['script'] = 'dantai_result2.php';
            } else {
                $nlist[0]['script'] = 'dantai_result.php';
            }
        } else if( $nlist[0]['series_lt'] === 'kt' ){
            $nlist[0]['script'] = 'kojin_result.php';
        } else {
            $nlist[0]['script'] = '';
        }
        return $nlist[0];
    }

	function get_series_place_navi_data_count( $navi_id, $place )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `navi_info`'
            . ' where `del`=0 and `navi_id`=' . $navi_id . ' and `place_no`=' . $place ;
		$nlist = db_query_list( $dbs, $sql );
        if( count( $nlist ) == 0 ){ return 0; }
        return count( $nlist );
    }

	function get_series_place_all_navi_data( $navi_id, $place=0 )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `navi_info` where `del`=0 and `navi_id`=' . $navi_id;
        if( $place > 0 ){
            $sql .= ( ' and `place_no`=' . $place );
        }
        $sql .= ' order by `place_match_no` asc';
		$nlist = db_query_list( $dbs, $sql );
        if( count( $nlist ) == 0 ){ return array(); }
        foreach( $nlist as &$nv ){
            if( $nv['series_lt'] === 'dl' || $nv['series_lt'] === 'dt' ){
                if( intval($nv['place_match_no']) >= 1000 ){
                    $nv['script'] = 'dantai_result2.php';
                } else {
                    $nv['script'] = 'dantai_result.php';
                }
            } else if( $nv['series_lt'] === 'kt' ){
                $nv['script'] = 'kojin_result.php';
            } else {
                $nv['script'] = '';
            }
        }
//print_r($nlist);
        return $nlist;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function update_dantai_match_one_waza( $match_id, $match_no, $field, $value )
	{
//print_r($p);

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match_id );
		$match = get_field_string_number( $dantai_match, 'match'.$match_no, 0 );
		if( $match != 0 ){
			$sql = 'update `one_match` set `'.$field.'`='.$value.' where `id`='.$match;
			db_query( $dbs, $sql );
//echo $sql;
		}
		db_close( $dbs );
		return $data;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function make_new_dantai_league_list( $series, $mw )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `dantai_league` (`series`,`year`,`series_mw`,`name`,`team_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['team_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
			db_query( $dbs, $sql );
		}
/*
		$group_place = 1;
		$group_place_offset = 0;
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
			$sql = 'insert `dantai_league` (`series`,`year`,`series_mw`,`name`,`team_num`,`match_num`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$param['mw']."','".$this->get_league_groupe_name($group_index)."',".$param['team_num'].','.$param['match_num'].','.$param['place_num'].',NOW(),NOW())';
echo $sql,"<br />\n";
$group_id = $group_index;
			//db_query( $dbs, $sql );
			//$group_id = db_query_insert_id( $dbs );

			$teams = array();
			for( $team_index = 1; $team_index <= $param['team_num']; $team_index++ ){
				$sql = 'INSERT INTO `dantai_league_team` ( `league`,`league_team_index`,`team`,`create_date`,`update_date` ) VALUES ( '.$group_id.', '.$team_index.', 0, NOW(), NOW() )';
echo $sql,"<br />\n";
$teams[] = 20 + $team_index;
					//db_query( $dbs, $sql );
					//$teams[] = db_query_insert_id( $dbs );
			}

			for( $group_match_index = 1; $group_match_index <= $param['match_num']; $group_match_index++ ){
				$matches = array();
				for( $match_index = 0; $match_index < 6; $match_index++ ){
					$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />\n";
$matches[] = 30 + $match_index;
						//db_query( $dbs, $sql );
						//$matches[] = db_query_insert_id( $dbs );
				}
				$sql = 'insert `dantai_match`'
					. ' set `team1`=0,'
					. '`team2`=0,'
					. '`place`='.$group_place.',`place_match_no`='.$param['place_match_info'][$group_place_offset][$group_match_index-1].','
					. '`match1`=' . $matches[0] . ','
					. '`match2`=' . $matches[1] . ','
					. '`match3`=' . $matches[2] . ','
					. '`match4`=' . $matches[3] . ','
					. '`match5`=' . $matches[4] . ','
					. '`match6`=' . $matches[5] . ','
					. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
$match_id = 40 + $group_index;
				//db_query( $dbs, $sql );
				//$match_id = db_query_insert_id( $dbs );

				$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$group_id.','.$group_match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
				//db_query( $dbs, $sql );
			}
			$group_place_offset = ( $group_place_offset + 1 ) % 2;
			if( $group_place_offset == 0 ){ $group_place++; }
		}
*/
	}


	function get_dantai_league_list( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$lv ){
			$lv['end_match'] = 0;
			$lv['team'] = array();
			$team_num = intval( $lv['team_num'] );
			for( $i1 = 0; $i1 < $team_num; $i1++ ){
				$lv['team'][] = array( 'team'=>0, 'point'=>0, 'advanced'=>0, 'standing'=>0 );
			}
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.intval($lv['id']);
			$team = db_query_list( $dbs, $sql );
			foreach( $team as $tv ){
				$no = intval( $tv['league_team_index'] );
				if( $no > 0 && $no <= $team_num ){
					$lv['team'][$no-1]['team'] = intval( $tv['team'] );
					$lv['team'][$no-1]['advanced'] = intval( $tv['advanced'] );
					$lv['team'][$no-1]['standing'] = intval( $tv['standing'] );
					$lv['team'][$no-1]['point'] = intval( $tv['point'] );
					$lv['team'][$no-1]['win'] = intval( $tv['win'] );
					$lv['team'][$no-1]['hon'] = intval( $tv['hon'] );
				}
			}

			$lv['match'] = array();
			$match_num = intval( $lv['match_num'] );
			for( $i1 = 0; $i1 < $match_num; $i1++ ){
				$lv['match'][] = array( 'match'=>0, 'place'=>0, 'place_match_no'=>0, 'end_match'=>0 );
			}
			$sql = 'select `dantai_league_match`.`match` as `match`,'
				. ' `dantai_league_match`.`league_match_index` as `league_match_index`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_match`.`team1` as `team1`,'
				. ' `dantai_match`.`team2` as `team2`,'
				. ' `dantai_match`.`win1` as `win1`,'
				. ' `dantai_match`.`win2` as `win2`,'
				. ' `dantai_match`.`hon1` as `hon1`,'
				. ' `dantai_match`.`hon2` as `hon2`,'
				. ' `dantai_match`.`match1` as `match1`,'
				. ' `dantai_match`.`match2` as `match2`,'
				. ' `dantai_match`.`match3` as `match3`,'
				. ' `dantai_match`.`match4` as `match4`,'
				. ' `dantai_match`.`match5` as `match5`,'
				. ' `dantai_match`.`match6` as `match6`,'
				. ' `dantai_match`.`fusen` as `fusen`,'
				. ' `dantai_match`.`winner` as `winner`'
				. ' from `dantai_league_match` join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_league_match`.`del`=0 and `dantai_league_match`.`league`='.intval($lv['id']);
			$match = db_query_list( $dbs, $sql );
			foreach( $match as $mv ){
				$no = intval( $mv['league_match_index'] );
				if( $no > 0 && $no <= $match_num ){
					$lv['match'][$no-1] = $mv;
					//$lv['match'][$no-1]['match'] = intval( $mv['match'] );
					//$lv['match'][$no-1]['place'] = intval( $mv['place'] );
					//$lv['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
					//$lv['match'][$no-1]['win1'] = intval( $mv['win1'] );
					//$lv['match'][$no-1]['win2'] = intval( $mv['win2'] );
					//$lv['match'][$no-1]['hon1'] = intval( $mv['hon1'] );
					//$lv['match'][$no-1]['hon2'] = intval( $mv['hon2'] );
					//$lv['match'][$no-1]['winner'] = intval( $mv['winner'] );
					$lv['match'][$no-1]['matches'] = array();
					$lv['match'][$no-1]['end_match'] = 0;
					for( $i1 = 1; $i1 <= 6; $i1++ ){
						$match_id = get_field_string_number( $mv, 'match'.$i1, 0 );
						if( $match_id != 0 ){
							$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
							if( $i1 < 6 && $one_match['end_match'] == 1 ){
								$lv['match'][$no-1]['end_match']++;
							}
							if( $one_match['player1'] == 0 && $i1 < 6 ){
								$one_match['player1'] = $i1;
							}
/*
							$f = 'dantai_' . $mw . $one_match['player1'];
							$one_match['player1_name'] = $dantai_match['entry1'][$f.'_sei'] . ' '. $dantai_match['entry1'][$f.'_mei'];
							if( $dantai_match['entry1'][$f.'_disp'] != '' ){
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_disp'];
							} else {
								$one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_sei'];
							}
*/
							if( $one_match['player2'] == 0 && $i1 < 6 ){
								$one_match['player2'] = $i1;
							}
/*
							$f = 'dantai_' . $series_mw . $one_match['player2'];
							$one_match['player2_name'] = $dantai_match['entry2'][$f.'_sei'] . ' '. $dantai_match['entry2'][$f.'_mei'];
							if( $dantai_match['entry2'][$f.'_disp'] != '' ){
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_disp'];
							} else {
								$one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_sei'];
							}
*/
						} else {
							if( $i1 < 6 ){
								$one_match = array(
									'player1' => $i1,
									'player2' => $i1
								);
							} else {
								$one_match = array(
									'player1' => 0,
									'player2' => 0
								);
							}
						}
						$lv['match'][$no-1]['matches'][$i1] = $one_match;
					}
					if( $lv['match'][$no-1]['end_match'] == 5 ){
						$lv['end_match']++;
					}
				}
			}
			if( $lv['end_match'] < 3 ){
				for( $team = 0; $team < $team_num; $team++ ){
					$lv['team'][$team]['advanced'] = 0;
					$lv['team'][$team]['standing'] = 0;
					$lv['team'][$team]['point'] = 0;
					$lv['team'][$team]['win'] = 0;
					$lv['team'][$team]['hon'] = 0;
				}
				for( $i1 = 0; $i1 < $match_num; $i1++ ){
					if( $lv['match'][$i1]['end_match'] == 5 ){
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team1'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win1'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon1'];
								if( $lv['match'][$i1]['winner'] == 1 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
								break;
							}
						}
						for( $team = 0; $team < $team_num; $team++ ){
							if( $lv['team'][$team]['team'] == $lv['match'][$i1]['team2'] ){
								$lv['team'][$team]['win'] += $lv['match'][$i1]['win2'];
								$lv['team'][$team]['hon'] += $lv['match'][$i1]['hon2'];
								if( $lv['match'][$i1]['winner'] == 2 ){
									$lv['team'][$team]['point'] += 2;
								} else if( $lv['match'][$i1]['winner'] == 0 ){
									$lv['team'][$team]['point'] += 1;
								}
								break;
							}
						}
					}
				}
			}
		}
		db_close( $dbs );
		return $list;
	}

	function get_dantai_league_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'dantai_league', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	function get_dantai_league_array_for_smarty( $series )
	{
		$data = array( 0 => '-' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$data[$lv['id']] = $lv['name'];
		}
		return $data;
	}

	function update_dantai_league_list( $series, $mw, $post )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$entry_member_data = array();
		if( $series == 1 ){
			$entry_member_field = 'dantai_m';
		} else {
			$entry_member_field = 'dantai_w';
		}
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$league_index = 1;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$team_num = intval( $lv['team_num'] );
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$id.' order by `id` asc';
			$team_list = db_query_list( $dbs, $sql );
			for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
				$update = false;
				$team = intval( $post['entry_'.$league_index.'_'.$team_index] );
				foreach( $team_list as $tv ){
					$team_id = intval( $tv['id'] );
					$no = intval( $tv['league_team_index'] );
					if( $no == $team_index ){
						$sql = 'update `dantai_league_team` set `team`='.$team.' where `id`='.$team_id;
//echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `dantai_league_team`'
						. ' set `league`='.$id.',`league_team_index`='.$team_index.',`team`='.$team.',`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
/*
				$entry_member_one_data = array( 0, 0, 0, 0, 0 );
				if( $team > 0 ){
					$sql = 'select * from `entry` where `id`='.$team;
					$entry = db_query_list( $dbs, $sql );
					if( count($entry) >= 0 && get_field_string_number( $entry[0], $entry_member_field, 0 ) > 0 ){
						$sql = 'select * from `dantai_players` where `id`='.intval($entry[0][$entry_member_field]);
						$entry_member = db_query_list( $dbs, $sql );
						if( count($entry_member) > 0 ){
							$entry_member_one_data[0] = intval( $entry_member[0]['player1'] );
							$entry_member_one_data[1] = intval( $entry_member[0]['player2'] );
							$entry_member_one_data[2] = intval( $entry_member[0]['player3'] );
							$entry_member_one_data[3] = intval( $entry_member[0]['player4'] );
							$entry_member_one_data[4] = intval( $entry_member[0]['player5'] );
						}
					}
				}
				$entry_member_data[] = $entry_member_one_data;
*/
			}
			$match_num = intval( $lv['match_num'] );
			$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
			for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
				$place = intval( $post['place_'.$league_index.'_'.$match_index] );
				$place_match_no = intval( $post['place_match_'.$league_index.'_'.$match_index] );
				$team1 = $param['match_info'][$match_index-1][0] + 1;
				$team2 = $param['match_info'][$match_index-1][1] + 1;
/*
				$team1 = 1;
				$team2 = 2;
				$i1 = 1;
				for(;;){
					if( $i1 == $match_index ){ break; }
					$team2++;
					if( $team2 > $team_num ){
						$team1++;
						$team2 = $team1 + 1;
					}
					$i1++;
				}
*/
				$team1_id = intval( $post['entry_'.$league_index.'_'.$team1] );
				$team2_id = intval( $post['entry_'.$league_index.'_'.$team2] );

				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$league_match_index = intval( $mv['league_match_index'] );
					if( $match_index == $league_match_index ){
						$sql = 'select * from `dantai_match` where `id`='.$match_id;
						$dantai_match = db_query_list( $dbs, $sql );
						if( count($dantai_match) > 0 ){
							$sql = 'update `dantai_match`'
								. ' set `team1`='.$team1_id.','
								. '`team2`='.$team2_id.','
								. '`place`='.$place.',`place_match_no`='.$place_match_no
								. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
							db_query( $dbs, $sql );
/*
							for( $i1 = 1; $i1 <= 5; $i1++ ){
								$one_match = intval( $dantai_match[0]['match'.$i1] );
								if( $one_match > 0 ){
									$sql = 'update `one_match` set `player1`='.$entry_member_data[$team1-1][$i1-1].',`player2`='.$entry_member_data[$team2-1][$i1-1].',`update_date`=NOW() where `id`='.$one_match;
									db_query( $dbs, $sql );
								}
							}
*/
						}
						$update = true;
						break;
					}
				}
				if( !$update ){
					$matches = array();
					for( $i1 = 0; $i1 < 6; $i1++ ){
						$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`player1_change_name`,`player2_change_name`,`match_time`,`create_date`,`update_date` ) VALUES ( 0, 0, \'\', \'\', \'\', NOW(), NOW() )';
//echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$matches[] = db_query_insert_id( $dbs );
					}
					$sql = 'insert `dantai_match`'
						. ' set `team1`='.$team1_id.','
							. '`team2`='.$team2_id.','
							. '`place`='.$place.',`place_match_no`='.$place_match_no.','
							. '`match1`=' . $matches[0] . ','
							. '`match2`=' . $matches[1] . ','
							. '`match3`=' . $matches[2] . ','
							. '`match4`=' . $matches[3] . ','
							. '`match5`=' . $matches[4] . ','
							. '`match6`=' . $matches[5] . ','
							. '`create_date`=NOW(),`update_date`=NOW()';
/*
					$sql = 'insert `dantai_match`'
						. ' set `team1`='.intval( $post['entry_'.$league_index.'_'.$team1] ).','
							. '`team2`='.intval( $post['entry_'.$league_index.'_'.$team2] ).','
							. '`place`='.$place.',`place_match_no`='.$place_match_no.','
							. '`create_date`=NOW(),`update_date`=NOW()';
*/
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$match_id = db_query_insert_id( $dbs );
					$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
//echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$league_index++;
		}
		db_close( $dbs );
	}

	function load_dantai_league_list_csv( $series, $mw, $file )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$entry_list = $this->get_entry_data_list( $series, $mw );
//print_r($entry_list);
		$fp = fopen( $file, 'r' );
		$league_index = 1;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$team_num = intval( $lv['team_num'] );
			$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$id.' order by `id` asc';
			$team_id_list = array();
			$team_list = db_query_list( $dbs, $sql );
			for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
				$name = fgets( $fp );
				$team = 0;
				foreach( $entry_list as $ev ){
					if( mb_strpos( $name, $ev['school_name'] ) !== false || mb_strpos( $name, $ev['school_name_ryaku'] ) !== false ){
						$team = $ev['id'];
						break;
					}
				}
				$team_id_list[$team_index] = $team;
				$update = false;
				foreach( $team_list as $tv ){
					$team_id = intval( $tv['id'] );
					$no = intval( $tv['league_team_index'] );
					if( $no == $team_index ){
						$sql = 'update `dantai_league_team` set `team`='.$team.' where `id`='.$team_id;
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `dantai_league_team`'
						. ' set `league`='.$id.',`league_team_index`='.$team_index.',`team`='.$team.',`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$match_num = intval( $lv['match_num'] );
			$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
			for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
				$team1 = $param['match_info'][$match_index-1][0] + 1;
				$team2 = $param['match_info'][$match_index-1][1] + 1;
				$team1_id = $team_id_list[$team1];
				$team2_id = $team_id_list[$team2];
				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$league_match_index = intval( $mv['league_match_index'] );
					if( $match_index == $league_match_index ){
						$sql = 'select * from `dantai_match` where `id`='.$match_id;
						$dantai_match = db_query_list( $dbs, $sql );
						if( count($dantai_match) > 0 ){
							$sql = 'update `dantai_match`'
								. ' set `team1`='.$team1_id.','
								. '`team2`='.$team2_id
								. ' where `id`='.$match_id;
echo $sql,"<br />\n";
							db_query( $dbs, $sql );
						}
						$update = true;
						break;
					}
				}
				if( !$update ){
					$matches = array();
					for( $i1 = 0; $i1 < 6; $i1++ ){
						$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$matches[] = db_query_insert_id( $dbs );
					}
					$sql = 'insert `dantai_match`'
						. ' set `team1`='.$team1_id.','
							. '`team2`='.$team2_id.','
							. '`place`=0,`place_match_no`=0,'
							. '`match1`=' . $matches[0] . ','
							. '`match2`=' . $matches[1] . ','
							. '`match3`=' . $matches[2] . ','
							. '`match4`=' . $matches[3] . ','
							. '`match5`=' . $matches[4] . ','
							. '`match6`=' . $matches[5] . ','
							. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$match_id = db_query_insert_id( $dbs );
					$sql = 'INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$league_index++;
		}
		db_close( $dbs );
		fclose( $fp );
	}

	function __get_dantai_league_one_result( $series, $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = array();
		$data['entry1'] = $this->get_entry_one_data2( 139 );
		$data['entry2'] = $this->get_entry_one_data2( 140 );
		return $data;
	}

	function get_dantai_league_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.*,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`'
			. ' from `dantai_league_match` inner join `dantai_league` on `dantai_league`.`id`=`dantai_league_match`.`league` where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
		$series = intval( $dantai_league_match[0]['series'] );
		$series_mw = $dantai_league_match[0]['series_mw'];
		$league = intval( $dantai_league_match[0]['league'] );
        $series_info = $this->get_series_list( $series );

		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$dantai_match['league'] = $league;
		$dantai_match['series'] = $series;
		$dantai_match['series_mw'] = $series_mw;
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );

		$dantai_match['referee1_name'] = '';
		$dantai_match['referee2_name'] = '';
		$dantai_match['referee3_name'] = '';
		$sql = 'select * from `referee` where `series`='.$series.' order by `id` asc';
		$referee_list = db_query_list( $dbs, $sql );
        foreach( $referee_list as $rv ){
            if( $rv['id'] == $dantai_match['referee1'] ){
                $dantai_match['referee1_name'] = $rv['sei'] . ' ' . $rv['mei'];
            }
            if( $rv['id'] == $dantai_match['referee2'] ){
                $dantai_match['referee2_name'] = $rv['sei'] . ' ' . $rv['mei'];
            }
            if( $rv['id'] == $dantai_match['referee3'] ){
                $dantai_match['referee3_name'] = $rv['sei'] . ' ' . $rv['mei'];
            }
        }

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player1'];
                } else {
                    $f = 'dantai_' . $series_mw . $one_match['player1'];
                }
                if( $one_match['player1'] == __PLAYER_NAME__ ){
                    $one_match['player1_name'] = $one_match['player1_change_name'];
                    $one_match['player1_name_ryaku'] = $one_match['player1_change_name'];
                } else {
                    $one_match['player1_name'] = $dantai_match['entry1'][$f.'_sei'] . ' '. $dantai_match['entry1'][$f.'_mei'];
                    if( $dantai_match['entry1'][$f.'_disp'] != '' ){
                        $one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_disp'];
                    } else {
                        $one_match['player1_name_ryaku'] = $dantai_match['entry1'][$f.'_sei'];
                    }
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player' . $one_match['player2'];
                } else {
                    $f = 'dantai_' . $series_mw . $one_match['player2'];
                }
                if( $one_match['player2'] == __PLAYER_NAME__ ){
                    $one_match['player2_name'] = $one_match['player2_change_name'];
                    $one_match['player2_name_ryaku'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $dantai_match['entry2'][$f.'_sei'] . ' '. $dantai_match['entry2'][$f.'_mei'];
                    if( $dantai_match['entry2'][$f.'_disp'] != '' ){
                        $one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_disp'];
                    } else {
                        $one_match['player2_name_ryaku'] = $dantai_match['entry2'][$f.'_sei'];
                    }
				}
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei']
					);
					if( $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player1_name_ryaku'] = $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player1_name_ryaku'] = $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'];
					}
					if( $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_disp'] != '' ){
						$one_match['player2_name_ryaku'] = $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_disp'];
					} else {
						$one_match['player2_name_ryaku'] = $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'];
					}
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player1_name_ryaku' => '',
						'player2' => 0,
						'player2_name' => '',
						'player2_name_ryaku' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}

	function update_dantai_league_one_result( $series, $league, $id, $list )
	{
//print_r($list);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$id );
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $data, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$list['p'][$i1]['faul1_1'].','
					. '`faul1_2`='.$list['p'][$i1]['faul1_2'].','
					. '`waza1_1`='.$list['p'][$i1]['waza1_1'].','
					. '`waza1_2`='.$list['p'][$i1]['waza1_2'].','
					. '`waza1_3`='.$list['p'][$i1]['waza1_3'].','
    				. '`player1`='.$list['p'][$i1]['player1'].','
	    			. '`player1_change_name`=\''.$list['p'][$i1]['player1_change_name'].'\','
					. '`faul2_1`='.$list['p'][$i1]['faul2_1'].','
					. '`faul2_2`='.$list['p'][$i1]['faul2_2'].','
					. '`waza2_1`='.$list['p'][$i1]['waza2_1'].','
					. '`waza2_2`='.$list['p'][$i1]['waza2_2'].','
					. '`waza2_3`='.$list['p'][$i1]['waza2_3'].','
    				. '`player2`='.$list['p'][$i1]['player2'].','
	    			. '`player2_change_name`=\''.$list['p'][$i1]['player2_change_name'].'\','
					. '`end_match`='.$list['p'][$i1]['end_match'].','
					. '`hon1`='.$list['hon1'][$i1].','
					. '`hon2`='.$list['hon2'][$i1].','
					. '`extra`='.$list['p'][$i1]['extra'].','
					. '`match_time`=\''.$list['p'][$i1]['match_time'].'\','
					. '`winner`='.$list['win'][$i1]
					. ' where `id`='.$match_id;
//echo $sql,"<br />\n";
				db_query( $dbs, $sql );
			}
		}
		$sql = 'update `dantai_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner'].','
			. '`exist_match6`='.get_field_string_number( $list, 'exist_match6', 0 )
			. ' where `id`='.$id;
//echo $sql,"<br />\n";
		db_query( $dbs, $sql );

		$sql = 'select * from `dantai_league_team` where `del`=0 and `league`='.$league.' order by `id` asc';
		$team_list = db_query_list( $dbs, $sql );
		for( $i1 = 0; $i1 < count($team_list); $i1++ ){
			$team_list[$i1]['point'] = 0;
			$team_list[$i1]['win'] = 0;
			$team_list[$i1]['hon'] = 0;
			$team_list[$i1]['standing'] = $i1 + 1;
		}
		$exist_end = 0;
		$sql = 'select * from `dantai_league_match` where `del`=0 and `league`='.$league.' order by `id` asc';
		$match_list = db_query_list( $dbs, $sql );
		foreach( $match_list as $mv ){
			$match_id = intval( $mv['match'] );
			if( $match_id == 0 ){ continue; }
			$sql = 'select * from `dantai_match` where `id`='.$match_id;
			$dantai_match = db_query_list( $dbs, $sql );
			if( count($dantai_match) == 0 ){ continue; }

			$endnum = 0;
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
				if( $match_id == 0 ){ continue; }
				$sql = 'select * from `one_match` where `id`='.$match_id;
				$one_match = db_query_list( $dbs, $sql );
				if( count($one_match) == 0 ){ continue; }
				if( get_field_string_number( $one_match[0], 'end_match', 0 ) == 1 ){
					$endnum++;
				}
			}
			if( $endnum < 5 ){ continue; }

			$exist_end = 1;
			$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
			$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
			$win1 = get_field_string_number( $dantai_match[0], 'win1', 0 );
			$win2 = get_field_string_number( $dantai_match[0], 'win2', 0 );
			$hon1 = get_field_string_number( $dantai_match[0], 'hon1', 0 );
			$hon2 = get_field_string_number( $dantai_match[0], 'hon2', 0 );
			$winner = get_field_string_number( $dantai_match[0], 'winner', 0 );
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
				if( $team_list[$i1]['team'] == $team1 ){
					if( $winner == 1 ){
						$team_list[$i1]['point'] += 2;
					} else if( $winner == 0 ){
						$team_list[$i1]['point'] += 1;
					}
					$team_list[$i1]['win'] += $win1;
					$team_list[$i1]['hon'] += $hon1;
				}
				if( $team_list[$i1]['team'] == $team2 ){
					if( $winner == 2 ){
						$team_list[$i1]['point'] += 2;
					} else if( $winner == 0 ){
						$team_list[$i1]['point'] += 1;
					}
					$team_list[$i1]['win'] += $win2;
					$team_list[$i1]['hon'] += $hon2;
				}
			}
		}

		if( $exist_end == 1 ){
			$sortlist = array();
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
				$sortlist[] = array(
					'team' => $i1,
					'point' => $team_list[$i1]['point'] * 10000 + $team_list[$i1]['win'] * 100 + $team_list[$i1]['hon']
				);
			}
			for( $i1 = 0; $i1 < count($team_list)-1; $i1++ ){
				for( $i2 = count($team_list)-1; $i2 > $i1; $i2-- ){
					if( $sortlist[$i2]['point'] > $sortlist[$i2-1]['point'] ){
						$t = $sortlist[$i2-1]['team'];
						$p = $sortlist[$i2-1]['point'];
						$sortlist[$i2-1]['team'] = $sortlist[$i2]['team'];
						$sortlist[$i2-1]['point'] = $sortlist[$i2]['point'];
						$sortlist[$i2]['team'] = $t;
						$sortlist[$i2]['point'] = $p;
					}
				}
			}
			for( $i1 = 0; $i1 < count($team_list); $i1++ ){
				$team_list[$sortlist[$i1]['team']]['standing'] = $i1 + 1;
				if( $i1 < 2 ){
					$team_list[$sortlist[$i1]['team']]['advanced'] = 1;
				} else {
					$team_list[$sortlist[$i1]['team']]['advanced'] = 0;
				}
			}
			if( $sortlist[0]['point'] == $sortlist[1]['point'] && $sortlist[1]['point'] == $sortlist[2]['point'] ){ // 1-1-1
				$team_list[$sortlist[0]['team']]['standing'] = 1;
				$team_list[$sortlist[1]['team']]['standing'] = 1;
				$team_list[$sortlist[2]['team']]['standing'] = 1;
				$team_list[$sortlist[0]['team']]['advanced'] = 1;
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
				$team_list[$sortlist[2]['team']]['advanced'] = 1;
			} else if( $sortlist[0]['point'] == $sortlist[1]['point'] ){ // 1-1-3
				$team_list[$sortlist[0]['team']]['standing'] = 1;
				$team_list[$sortlist[1]['team']]['standing'] = 1;
				$team_list[$sortlist[0]['team']]['advanced'] = 1;
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
			} else if( $sortlist[1]['point'] == $sortlist[2]['point'] ){ // 1-2-2
				$team_list[$sortlist[2]['team']]['standing'] = $team_list[$sortlist[1]['team']]['standing'];
				$team_list[$sortlist[1]['team']]['advanced'] = 1;
				$team_list[$sortlist[2]['team']]['advanced'] = 1;
			}
		}

		for( $i1 = 0; $i1 < count($team_list); $i1++ ){
			$sql = 'update `dantai_league_team`'
				. ' set `point`='.$team_list[$i1]['point'].','
					. '`win`='.$team_list[$i1]['win'].','
					. '`standing`='.$team_list[$i1]['standing'].','
					. '`advanced`='.$team_list[$i1]['advanced'].','
					. '`hon`='.$team_list[$i1]['hon']
					. ' where `id`='.$team_list[$i1]['id'];
//echo $sql,"<br />\n";
			db_query( $dbs, $sql );
		}
		db_close( $dbs );
		return $data;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_league_team_list()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_league_team` where `del`=0';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	function get_dantai_league_team_one_data( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'dantai_league_team', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function make_new_dantai_tournament_list( $series, $mw )
	{
		//$func = 'get_tournament_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_tournament_parameter( $series );
        $series_mw = $param['mw'];
        if( $series_mw == '' ){ $series_mw = $mw; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		for( $group_index = 1; $group_index <= $param['group_num']; $group_index++ ){
    		$sql = 'insert `dantai_tournament` (`series`,`year`,`series_mw`,`team_num`,`match_num`,`match_level`,`place_num`,`create_date`,`update_date`) VALUES ('.$series.','.$_SESSION['auth']['year'].",'".$series_mw."',".$param['team_num'].','.$param['match_num'].','.$param['match_level'].','.$param['place_num'].',NOW(),NOW())';
	    	db_query( $dbs, $sql );
        }
	}

	function load_dantai_tournament_list_csv( $series, $mw, $file )
	{
		//$func = 'get_league_parameter_'.$series;
		//$param = $func( $series );
		$param = $this->get_dantai_league_parameter( $series );
        $series_mw = $param['mw'];
        if( $series_mw == '' ){ $series_mw = $mw; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		$entry_list = $this->get_entry_data_list( $series, $mw );
//print_r($entry_list);
		$fp = fopen( $file, 'r' );
		$tournament_index = 1;
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			$team_num = intval( $lv['team_num'] );
			$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$id.' order by `id` asc';
			$team_id_list = array();
			$team_list = db_query_list( $dbs, $sql );
			for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
				$name = fgets( $fp );
//echo '[',$name,"]<br />\n";
				$team = 0;
                if( $name !== '' ){
    				foreach( $entry_list as $ev ){
                        if( $ev['del'] == 1 ){ continue; }
//print_r($ev);
//echo "<br />\n";
		    			if( ( !is_null($ev['school_name']) && $ev['school_name'] !== '' && mb_strpos( $name, $ev['school_name'] ) !== false )
                            || ( !is_null($ev['school_name_ryaku']) && $ev['school_name_ryaku'] !== "" && mb_strpos( $name, $ev['school_name_ryaku'] ) !== false ) ){
				    		$team = $ev['id'];
					    	break;
    					}
                    }
				}
				$team_id_list[$team_index] = $team;
				$update = false;
				foreach( $team_list as $tv ){
					$team_id = intval( $tv['id'] );
					$no = intval( $tv['tournament_team_index'] );
					if( $no == $team_index ){
						$sql = 'update `dantai_tournament_team` set `team`='.$team.' where `id`='.$team_id;
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$update = true;
						break;
					}
				}
				if( !$update ){
					$sql = 'insert `dantai_tournament_team`'
						. ' set `tournament`='.$id.',`tournament_team_index`='.$team_index.',`team`='.$team.',`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}

			$match_num = intval( $lv['match_num'] );
			$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$id.' order by `id` asc';
			$match_list = db_query_list( $dbs, $sql );
            $id_index = 1;
			for( $match_index = 1; $match_index <= $match_num; $match_index++ ){
                if( $match_index >= $team_num / 2 ){
    				$team1_id = $team_id_list[$id_index++];
	    			$team2_id = $team_id_list[$id_index++];
                } else {
    				$team1_id = 0;
	    			$team2_id = 0;
                }
				$update = false;
				foreach( $match_list as $mv ){
					$match_id = intval( $mv['match'] );
					$tournament_match_index = intval( $mv['tournament_match_index'] );
					if( $match_index == $tournament_match_index ){
						$sql = 'select * from `dantai_match` where `id`='.$match_id;
						$dantai_match = db_query_list( $dbs, $sql );
						if( count($dantai_match) > 0 ){
							$sql = 'update `dantai_match`'
								. ' set `team1`='.$team1_id.','
								. '`team2`='.$team2_id
								. ' where `id`='.$match_id;
echo $sql,"<br />\n";
							db_query( $dbs, $sql );
						}
						$update = true;
						break;
					}
				}
				if( !$update ){
					$matches = array();
					for( $i1 = 0; $i1 < 6; $i1++ ){
						$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />\n";
						db_query( $dbs, $sql );
						$matches[] = db_query_insert_id( $dbs );
					}
					$sql = 'insert `dantai_match`'
						. ' set `team1`='.$team1_id.','
							. '`team2`='.$team2_id.','
							. '`place`=0,`place_match_no`=0,'
							. '`match1`=' . $matches[0] . ','
							. '`match2`=' . $matches[1] . ','
							. '`match3`=' . $matches[2] . ','
							. '`match4`=' . $matches[3] . ','
							. '`match5`=' . $matches[4] . ','
							. '`match6`=' . $matches[5] . ','
							. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
					$match_id = db_query_insert_id( $dbs );
					$sql = 'INSERT INTO `dantai_tournament_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$id.','.$match_index.','.$match_id.', NOW(), NOW() )';
echo $sql,"<br />\n";
					db_query( $dbs, $sql );
				}
			}
			$league_index++;
		}
		db_close( $dbs );
		fclose( $fp );
exit;
	}

	function get_dantai_tournament_data( $series, $mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		//$data = db_get_one_data( $dbs, 'dantai_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'] );

		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		foreach( $list as &$data ){
    		$data['team'] = array();
	    	$team_num = intval( $data['team_num'] );
		    for( $i1 = 0; $i1 < $team_num; $i1++ ){
			    $data['team'][] = array( 'id'=>0, 'name'=>'' );
    		}
	    	$sql = 'select `dantai_tournament_team`.`team` as `team`,'
		    	. ' `dantai_tournament_team`.`tournament_team_index` as `tournament_team_index`,'
			    . ' `e1`.`data` as `school_name`,'
    			. ' `e2`.`data` as `school_name_ryaku`'
	    		. ' from `dantai_tournament_team` join `entry_field` as `e1` on `dantai_tournament_team`.`team`=`e1`.`info` and `e1`.`field`=\'school_name\''
		    	. ' left join `entry_field` as `e2` on `dantai_tournament_team`.`team`=`e2`.`info` and `e2`.`field`=\'school_name_ryaku\''
			    . ' where `dantai_tournament_team`.`del`=0'
				    . ' and `dantai_tournament_team`.`tournament`='.intval($data['id']);
		    $team = db_query_list( $dbs, $sql );
		    foreach( $team as $tv ){
			    $no = intval( $tv['tournament_team_index'] );
			    if( $no > 0 && $no <= $team_num ){
				    $data['team'][$no-1]['id'] = intval( $tv['team'] );
    				if( !is_null($tv['school_name_ryaku']) && $tv['school_name_ryaku'] != '' ){
	    				$data['team'][$no-1]['name'] = $tv['school_name_ryaku'];
		    		} else {
			    		$data['team'][$no-1]['name'] = $tv['school_name'];
				    }
    			}
	    	}

    		$data['match'] = array();
	    	$match_num = intval( $data['match_num'] );
		    $extra_match_num = intval( $data['extra_match_num'] );
    		for( $i1 = 0; $i1 < $match_num+$extra_match_num; $i1++ ){
	    		$data['match'][] = array(
                    'match' => 0, 'place' => 0, 'place_match_no' => 0,
			    	'win1' => 0, 'hon1' => 0, 'win2' => 0, 'hon2' => 0, 
				    'winner' => 0, 'fusen' => 0, 'dantai_tournament_match_id' => 0
                );
	    	}
		    $sql = 'select `dantai_tournament_match`.`match` as `match`,'
    			. ' `dantai_tournament_match`.`tournament_match_index` as `tournament_match_index`,'
	    		. ' `dantai_tournament_match`.`no_match` as `no_match`,'
		    	. ' `dantai_tournament_match`.`id` as `dantai_tournament_match_id`,'
			    . ' `dantai_match`.`place` as `place`,'
    			. ' `dantai_match`.`place_match_no` as `place_match_no`'
	    		. ' from `dantai_tournament_match` join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
		    	. ' where `dantai_tournament_match`.`del`=0 and `dantai_tournament_match`.`tournament`='.intval($data['id']);
    		$match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($match);
	    	foreach( $match as $mv ){
		    	$no = intval( $mv['tournament_match_index'] );
			    if( $no > 0 && $no <= $match_num+$extra_match_num ){
				    $data['match'][$no-1]['match'] = intval( $mv['match'] );
    				if( intval( $mv['no_match'] ) == 1 ){
	    				$data['match'][$no-1]['place'] = 'no_match';
		    		} else {
			    		$data['match'][$no-1]['place'] = intval( $mv['place'] );
				    }
    				$data['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
	    			$data['match'][$no-1]['dantai_tournament_match_id'] = intval( $mv['dantai_tournament_match_id'] );
		    		$data['match'][$no-1]['team1'] = 0;
			    	$data['match'][$no-1]['team1_name'] = '';
				    $data['match'][$no-1]['team2'] = 0;
    				$data['match'][$no-1]['team2_name'] = '';
	    			$data['match'][$no-1]['winner'] = 0;
		    		$data['match'][$no-1]['win1'] = 0;
			    	$data['match'][$no-1]['win2'] = 0;
				    $data['match'][$no-1]['hon1'] = 0;
				    $data['match'][$no-1]['hon2'] = 0;
				    $data['match'][$no-1]['exist_match6'] = 0;
				    if( $data['match'][$no-1]['match'] > 0 ){
					    $sql = 'select * from `dantai_match` where `id`='.$data['match'][$no-1]['match'];
					    $dantai_match = db_query_list( $dbs, $sql );
    					if( count($dantai_match) > 0 ){
						$data['match'][$no-1]['team1'] = get_field_string_number( $dantai_match[0], 'team1', 0 );
    						$data['match'][$no-1]['team2'] = get_field_string_number( $dantai_match[0], 'team2', 0 );
    						$data['match'][$no-1]['winner'] = get_field_string_number( $dantai_match[0], 'winner', 0 );
    						$data['match'][$no-1]['win1'] = get_field_string_number( $dantai_match[0], 'win1', 0 );
    						$data['match'][$no-1]['win2'] = get_field_string_number( $dantai_match[0], 'win2', 0 );
    						$data['match'][$no-1]['hon1'] = get_field_string_number( $dantai_match[0], 'hon1', 0 );
    						$data['match'][$no-1]['hon2'] = get_field_string_number( $dantai_match[0], 'hon2', 0 );
    						$data['match'][$no-1]['fusen'] = get_field_string_number( $dantai_match[0], 'fusen', 0 );
    						$data['match'][$no-1]['exist_match6'] = get_field_string_number( $dantai_match[0], 'exist_match6', 0 );
	    					$data['match'][$no-1]['matches'] = array();
    						for( $i1 = 1; $i1 <= 6; $i1++ ){
    							$match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
    							if( $match_id != 0 ){
    								$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
    								if( $one_match['player1'] == 0 && $i1 < 6 ){
    									$one_match['player1'] = $i1;
    								}
    								if( $one_match['player2'] == 0 && $i1 < 6 ){
    									$one_match['player2'] = $i1;
    								}
    							} else {
    								if( $i1 < 6 ){
    									$one_match = array(
    										'player1' => $i1,
    										'player2' => $i1
    									);
    								} else {
    									$one_match = array(
    										'player1' => 0,
    										'player2' => 0
    									);
    								}
    							}
    							$data['match'][$no-1]['matches'][$i1] = $one_match;
    						}

    						$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
    						if( $team1 > 0 ){
    							foreach( $data['team'] as $tv ){
    								if( $tv['id'] == $team1 ){
    									$data['match'][$no-1]['team1_name'] = $tv['name'];
    									break;
    								}
    							}
    						}
    						$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
    						if( $team2 > 0 ){
    							foreach( $data['team'] as $tv ){
    								if( $tv['id'] == $team2 ){
    									$data['match'][$no-1]['team2_name'] = $tv['name'];
    									break;
    								}
    							}
    						}
    					}
    				}
    			}
    		}

    		$match_level = intval( $data['match_level'] );
    		$offset = 1;
    		$match_offset = array();
    		for( $i1 = 1; $i1 <= $match_level; $i1++ ){
    			$match_offset[$match_level-$i1] = $offset;
    			$offset *= 2;
    		}
    		$data['match_array'] = array();
    		for( $i1 = 0; $i1 < $team_num; $i1++ ){
    			$match_no = 2;
    			$match_row = array();
    			for( $i2 = 0; $i2 < $match_level; $i2++ ){
    				if( ( $i1 % $match_no ) == $match_no / 2 - 1 ){
    					$match_row[] = $match_offset[$i2];
    					$match_offset[$i2]++;
    				} else if( ( $i1 % $match_no ) == $match_no / 2 ){
    					$match_row[] = -1;
    				} else {
    					$value = 0;
    					if( $i2 > 0 ){
    						if( ( $i1 % $match_no ) == $match_no / 2 - 2 ){
    							$value = $match_offset[$i2] + 1000;
    						}
    						if( ( $i1 % $match_no ) == $match_no / 2 + 1 ){
    							$value = $match_offset[$i2] - 1 + 2000;
    						}
    					}
    					$match_row[] = $value;
    				}
    				$match_no *= 2;
    			}
    			$data['match_array'][] = $match_row;
    		}
        }
//print_r($list);
   		db_close( $dbs );
		return $list;
	}

	function update_dantai_tournament_one_data( $series, $part, $mw, $post, $data, $dbs )
	{
		global $__dantai_league_team_last_match__;

		$tournament_id = intval( $data['id'] );

		$team_num = intval( $data['team_num'] );
		$team_id_list = array();
		$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$tournament_id;
		$dantai_tournament_team = db_query_list( $dbs, $sql );
		for( $team_index = 1; $team_index <= $team_num; $team_index++ ){
			$update = false;
			$team = intval( $post['entry_'.$part.'_'.$team_index] );
			foreach( $dantai_tournament_team as $tv ){
				$tournament_team_id = intval( $tv['id'] );
				$tournament_team_index = intval( $tv['tournament_team_index'] );
				if( $team_index == $tournament_team_index ){
					$sql = 'update `dantai_tournament_team` set `team`='.$team.' where `id`='.$tournament_team_id;
//echo ' 1:',$sql,"<br />\n";
					db_query( $dbs, $sql );
					$team_id_list[$team_index] = $team;
					$update = true;
					break;
				}
			}
			if( $update == false ){
				$sql = 'insert into `dantai_tournament_team`'
					.' set `tournament`='.$tournament_id.','
					.' `tournament_team_index`='.$team_index.','
					.' `team`='.$team.', `create_date`=NOW(), `update_date`=NOW()';
//echo '1:',$sql,"<br />\n";
				db_query( $dbs, $sql );
				$team_id_list[$team_index] = $team;
			}
		}

		$match_num = intval( $data['match_num'] );
		$extra_match_num = intval( $data['extra_match_num'] );
		$match_level = intval( $data['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}
        $last = $this->get_dantai_league_team_last_match_data( $series, $mw );
        $dantai_league_team_last_match = array();
		foreach( $last as $lav ){
			if( $lav['match_index'] == 1 ){
				$dantai_league_team_last_match[$lav['team1']] = array( $lav['match'], 1 );
				$dantai_league_team_last_match[$lav['team2']] = array( $lav['match'], 2 );
			} else if( $lav['match_index'] == 3 ){
				$dantai_league_team_last_match[$lav['team2']] = array( $lav['match'], 2 );
			}
		}
//print_r($dantai_league_team_last_match);

		$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$tournament_id;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		for( $match_index = 1; $match_index <= $match_num+$extra_match_num; $match_index++ ){
			if( $post['place_'.$part.'_'.$match_index] == 'no_match' ){
				$place = 0;
				$place_match_no = 0;
				$no_match = 1;
			} else {
				$place = intval( $post['place_'.$part.'_'.$match_index] );
				$place_match_no = intval( $post['place_match_'.$part.'_'.$match_index] );
				$no_match = 0;
			}
			if( $match_index >= $macth1_level && $match_index <= $match_num ){
				$team_sql = ', `team1`=' . $team_id_list[($match_index-$macth1_level)*2+1]
						. ', `team2`=' . $team_id_list[($match_index-$macth1_level)*2+2];
			} else {
				$team_sql = '';
			}
			$dantai_tournament_match_id = 0;
			$dantai_tournament_match_data = array();
			$match_id = 0;
			foreach( $dantai_tournament_match as $mv ){
				if( $match_index == intval( $mv['tournament_match_index'] ) ){
					$dantai_tournament_match_data = $mv;
					$dantai_tournament_match_id = intval( $mv['id'] );
					$match_id = intval( $mv['match'] );
					break;
				}
			}
			if( $match_id > 0 ){
				$sql = 'select * from `dantai_match` where `id`='.$match_id;
				$dantai_match = db_query_list( $dbs, $sql );
			}
			if( $match_id > 0 && count($dantai_match) > 0 ){
				$match_in_num = 0;
				$sql = '';
				$matches = array();
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$one_match_id = intval( $dantai_match[0]['match'.$i1] );
					if( $one_match_id > 0 ){
						$match_in_num++;
						if( $match_in_num > 1 ){ $sql .= ','; }
						$sql .= $one_match_id;
					} else {
						$matches['match'.$i1] = 0;
					}
				}
				$sql = 'select * from `one_match` where `id` in (' . $sql . ')';
				$dantai_one_matches = db_query_list( $dbs, $sql );
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					$one_match_id = intval( $dantai_match[0]['match'.$i1] );
					$in_id = 0;
					foreach( $dantai_one_matches as $omv ){
						if( intval($omv['id']) == $one_match_id ){
							$in_id = 1;
							break;
						}
					}
					if( $in_id == 0 ){
						if( $i1 == 6 ){
							$matches['match'.$i1] = 0;
						} else {
							$matches['match'.$i1] = $i1;
						}
					}
				}
			} else {
				$matches = array();
				for( $i1 = 1; $i1 <= 6; $i1++ ){
					if( $i1 == 6 ){
						$matches['match'.$i1] = 0;
					} else {
						$matches['match'.$i1] = $i1;
					}
				}
				$match_id = 0;
			}
			$match_sql = '';
			foreach( $matches as $k => $v ){
				$sql = 'insert into `one_match` ( `player1`,`player2`,`match_time`,`create_date`,`update_date` ) VALUES ( '.$v.', '.$v.', \'\', NOW(), NOW() )';
//echo print_r($matches,TRUE),"\n";
//echo $sql,"\n";
				db_query( $dbs, $sql );
				$matches[$k] = db_query_insert_id( $dbs );
				$match_sql .= ( ',' . $k . '=' . $matches[$k] );
			}
			if( $match_id > 0 ){
				$sql = 'update `dantai_match`'
					. ' set `place`='.$place.',`place_match_no`='.$place_match_no
					. ',`update_date`=NOW()'
					. $match_sql . $team_sql
					. ' where `id`='.$match_id;
//echo $sql,"\n";
				db_query( $dbs, $sql );
			} else {
				$sql = 'insert into `dantai_match`'
					. ' set `place`='.$place.',`place_match_no`='.$place_match_no.','
					. '`create_date`=NOW(),`update_date`=NOW()'
					. $match_sql . $team_sql;
//echo $sql,"\n";
				db_query( $dbs, $sql );
				$match_id = db_query_insert_id( $dbs );
			}

// 選手入れ替え対応
/**/
			if( $match_index >= $macth1_level ){
				$sql = 'select * from `dantai_match` where `id`='.$match_id;
				$dantai_match = db_query_list( $dbs, $sql );
				$team1 = get_field_string_number( $dantai_match[0], 'team1', 0 );
				$team2 = get_field_string_number( $dantai_match[0], 'team2', 0 );
//echo '<!-- ',print_r($dantai_match,TRUE)," -->\n";
				if( $team1 != 0 && $team2 != 0 ){
					$sql = 'select * from `dantai_match` where `id`='.$dantai_league_team_last_match[$team1][0];
					$dantai_match_team1 = db_query_list( $dbs, $sql );
//echo '<!-- ',$sql," -->\n";
//echo '<!-- ',print_r($dantai_match_team1,TRUE)," -->\n";
					$sql = 'select * from `dantai_match` where `id`='.$dantai_league_team_last_match[$team2][0];
					$dantai_match_team2 = db_query_list( $dbs, $sql );
//echo '<!-- ',$sql," -->\n";
//echo '<!-- ',print_r($dantai_match_team2,TRUE)," -->\n";
					for( $i1 = 1; $i1 <= 5; $i1++ ){
						$one_match_id = get_field_string_number( $dantai_match[0], 'match'.$i1, 0 );
						$one_match_id_team1 = get_field_string_number( $dantai_match_team1[0], 'match'.$i1, 0 );
						$one_match_id_team2 = get_field_string_number( $dantai_match_team2[0], 'match'.$i1, 0 );
						if( $one_match_id != 0 ){
							$sql = 'select * from `one_match` where `id`='.$one_match_id_team1;
							$one_match_team1 = db_query_list( $dbs, $sql );
							$sql = 'select * from `one_match` where `id`='.$one_match_id_team2;
							$one_match_team2 = db_query_list( $dbs, $sql );
							$sql = 'update `one_match`'
								. ' set `player1`='.$one_match_team1[0]['player'.$dantai_league_team_last_match[$team1][1]].','
								. "`player1_change_name`='".$one_match_team1[0]['player'.$dantai_league_team_last_match[$team1][1].'_change_name']."',"
								. '`player2`='.$one_match_team2[0]['player'.$dantai_league_team_last_match[$team2][1]].','
								. "`player2_change_name`='".$one_match_team2[0]['player'.$dantai_league_team_last_match[$team2][1].'_change_name']."',"
								. ' `update_date`=NOW() where `id`='.$one_match_id;
//echo '<!-- set:',$sql," -->\n";
							db_query( $dbs, $sql );
						}
					}
				}
			}
/**/
			if( $dantai_tournament_match_id == 0 ){
				$sql = 'insert into `dantai_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`no_match`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$match_index.', '.$match_id.', '.$no_match.', NOW(), NOW( ) )';
//echo '<!-- ',$sql," -->\n";
				db_query( $dbs, $sql );
			} else {
				$sql_param = array();
				if( intval( $dantai_tournament_match_data['tournament_match_index'] ) != $match_index ){
					$sql_param[] = '`tournament_match_index`=' . $match_index;
				}
				if( intval( $dantai_tournament_match_data['match'] ) != $match_id ){
					$sql_param[] = '`match`=' . $match_id;
				}
				if( intval( $dantai_tournament_match_data['no_match'] ) != $no_match ){
					$sql_param[] = '`no_match`=' . $no_match;
				}
				if( count( $sql_param ) > 0 ){
					$sql = 'update `dantai_tournament_match` set ' . implode( ',', $sql_param ) . ' where `id`=' . $dantai_tournament_match_id;
//echo '<!-- ',$sql," -->\n";
					db_query( $dbs, $sql );
				}
			}
		}

		$sql = 'select * from `dantai_tournament_match` where `del`=0 and `tournament`='.$tournament_id . ' order by `tournament_match_index` asc';
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		foreach( $dantai_tournament_match as $mv ){
			if( intval( $mv['no_match'] ) == 1 ){
				$tournament_match_index = intval( $mv['tournament_match_index'] );
				if( $tournament_match_index == 1 ){ continue; }
				$dantai_match_id = intval( $mv['match'] );
				if( $dantai_match_id > 0 ){
					$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
					$winner = get_field_string_number( $dantai_match, 'team1', 0 );
					if( $winner == 0 ){
						$winner = get_field_string_number( $dantai_match, 'team2', 0 );
					}
					if( $winner > 0 ){
						$up = intval( $tournament_match_index / 2 );
						foreach( $dantai_tournament_match as $mv_up ){
							$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
							$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
							if( $tournament_up_match_index == $up ){
								if( ( $tournament_match_index % 2 ) == 0 ){
									$sql = 'update `dantai_match` set `team1`='.$winner.' where `id`='.$tournament_up_match_id;
//echo '<!-- ',$sql," -->\n";
									db_query( $dbs, $sql );
								} else if( ( $tournament_match_index % 2 ) == 1 ){
									$sql = 'update `dantai_match` set `team2`='.$winner.' where `id`='.$tournament_up_match_id;
//echo '<!-- ',$sql," -->\n";
									db_query( $dbs, $sql );
								}
								break;
							}
						}
					}
				}
			}

		}
//print_r($data);
		return $data;
	}

	function update_dantai_tournament_data( $series, $mw, $post )
	{
		global $__dantai_league_team_last_match__;

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		//$data = db_get_one_data( $dbs, 'dantai_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$mw.'\' and `year`='.$_SESSION['auth']['year'] );
		$sql = 'select * from `dantai_tournament` where `del`=0 and `series`='.$series;
        if( $mw != '' ){ $sql .= " and `series_mw`='".$mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
        $part = 1;
		foreach( $list as $data ){
            $this->update_dantai_tournament_one_data( $series, $part, $mw, $post, $data, $dbs );
            $part++;
        }
		db_close( $dbs );
    }

	function get_dantai_tournament_one_result__( $match )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$id );
		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.intval($dantai_tournament_match['match']) );
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );
		$dantai_match['tournament'] = $dantai_tournament_match['tournament'];
		if( $dantai_match['tournament'] == 1 ){
			$series_mw = 'm';
		} else {
			$series_mw = 'w';
		}

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
				$one_match['player1_name'] = $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$one_match['player1'].'_'.$series_mw.'_mei'];
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
				$one_match['player2_name'] = $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry2']['player'.$one_match['player2'].'_'.$series_mw.'_mei'];
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['player'.$i1.'_'.$series_mw.'_sei'] . ' '. $dantai_match['entry1']['player'.$i1.'_'.$series_mw.'_mei']
					);
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player2' => 0,
						'player2_name' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}

	function get_dantai_tournament_one_result( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament_match`.*,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`'
			. ' from `dantai_tournament_match` inner join `dantai_tournament` on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament` where `dantai_tournament_match`.`match`='.$match;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		$series = intval( $dantai_tournament_match[0]['series'] );
		$series_mw = $dantai_tournament_match[0]['series_mw'];
		$tournament = intval( $dantai_tournament_match[0]['tournament'] );

		$dantai_match = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$match );
		$dantai_match['entry1'] = $this->get_entry_one_data2( intval($dantai_match['team1']) );
		$dantai_match['entry2'] = $this->get_entry_one_data2( intval($dantai_match['team2']) );
		$dantai_match['tournament'] = $tournament;

		$dantai_match['matches'] = array();
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$match_id = get_field_string_number( $dantai_match, 'match'.$i1, 0 );
			if( $match_id != 0 ){
				$one_match = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
				if( $one_match['player1'] == 0 && $i1 < 6 ){
					$one_match['player1'] = $i1;
				}
                if( $one_match['player1'] == __PLAYER_NAME__ ){
                    $one_match['player1_name'] = $one_match['player1_change_name'];
                } else {
                    $one_match['player1_name'] = $dantai_match['entry1']['dantai_'.$series_mw.$one_match['player1'].'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$one_match['player1'].'_mei'];
                }
				if( $one_match['player2'] == 0 && $i1 < 6 ){
					$one_match['player2'] = $i1;
				}
                if( $one_match['player2'] == __PLAYER_NAME__ ){
                    $one_match['player2_name'] = $one_match['player2_change_name'];
                } else {
                    $one_match['player2_name'] = $dantai_match['entry2']['dantai_'.$series_mw.$one_match['player2'].'_sei'] . ' '. $dantai_match['entry2']['dantai_'.$series_mw.$one_match['player2'].'_mei'];
                }
			} else {
				if( $i1 < 6 ){
					$one_match = array(
						'player1' => $i1,
						'player1_name' => $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry1']['dantai_'.$series_mw.$i1.'_mei'],
						'player2' => $i1,
						'player2_name' => $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_sei'] . ' '. $dantai_match['entry2']['dantai_'.$series_mw.$i1.'_mei']
					);
				} else {
					$one_match = array(
						'player1' => 0,
						'player1_name' => '',
						'player2' => 0,
						'player2_name' => ''
					);
				}
			}
			$dantai_match['matches'][$i1] = $one_match;
		}
		db_close( $dbs );
//print_r($dantai_match);
		return $dantai_match;
	}

	function set_dantai_tournament_fusen( $match, $fusen, $winner )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$match );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$sql = 'update `dantai_match` set `fusen`='.$fusen.',`winner`='.$winner.' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );
	}

	function set_dantai_tournament_exist_match6( $match, $exist )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$match );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$sql = 'update `dantai_match` set `exist_match6`='.$exist.' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );
	}

	function set_dantai_tournament_player( $id, $team, $match_no, $player, $name )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`id`='.$id );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
		$one_match_id = get_field_string_number( $data, 'match'.$match_no, 0 );
		if( $one_match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `player' . $team . '`=' . $player . ',`player' . $team . '_change_name`=\'' . $name . '\''
				. ' where `id`='.$one_match_id;
			db_query( $dbs, $sql );
		}
	}

	function update_dantai_tournament_one_result( $tournament, $id, $match_no, $list )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$dantai_tournament_match = db_get_one_data( $dbs, 'dantai_tournament_match', '*', '`match`='.$id );
		$dantai_match_id = intval( $dantai_tournament_match['match'] );
		if( $dantai_match_id == 0 ){ return; }
		$tournament = intval( $dantai_tournament_match['tournament'] );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`id`='.$dantai_match_id );
		$one_match_id = get_field_string_number( $data, 'match'.$match_no, 0 );
		if( $one_match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `faul1_1`='.$list['p'][$match_no]['faul1_1'].','
				. '`faul1_2`='.$list['p'][$match_no]['faul1_2'].','
				. '`waza1_1`='.$list['p'][$match_no]['waza1_1'].','
				. '`waza1_2`='.$list['p'][$match_no]['waza1_2'].','
				. '`waza1_3`='.$list['p'][$match_no]['waza1_3'].','
				. '`player1`='.$list['p'][$match_no]['player1'].','
				. '`player1_change_name`=\''.$list['p'][$match_no]['player1_change_name'].'\','
				. '`faul2_1`='.$list['p'][$match_no]['faul2_1'].','
				. '`faul2_2`='.$list['p'][$match_no]['faul2_2'].','
				. '`waza2_1`='.$list['p'][$match_no]['waza2_1'].','
				. '`waza2_2`='.$list['p'][$match_no]['waza2_2'].','
				. '`waza2_3`='.$list['p'][$match_no]['waza2_3'].','
				. '`player2`='.$list['p'][$match_no]['player2'].','
				. '`player2_change_name`=\''.$list['p'][$match_no]['player2_change_name'].'\','
				. '`end_match`='.$list['p'][$match_no]['end_match'].','
				. '`hon1`='.$list['hon1'][$match_no].','
				. '`hon2`='.$list['hon2'][$match_no].','
				. '`extra`='.$list['p'][$match_no]['extra'].','
				. '`match_time`=\''.$list['p'][$match_no]['match_time'].'\','
				. '`winner`='.$list['win'][$match_no]
				. ' where `id`='.$one_match_id;
//echo $sql;
			db_query( $dbs, $sql );
		}
		$sql = 'update `dantai_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner']
			. ' where `id`='.$dantai_match_id;
		db_query( $dbs, $sql );

		if( $list['winner'] == 1 ){
			$winner = $data['team1'];
			$loser = $data['team2'];
		} else if( $list['winner'] == 2 ){
			$winner = $data['team2'];
			$loser = $data['team1'];
		} else {
			$winner = 0;
		}

		$sql = 'select * from `dantai_tournament_match` where `tournament`='.$tournament.' order by `tournament_match_index` asc';
		$dantai_tournament_match = db_query_list( $dbs, $sql );
		foreach( $dantai_tournament_match as $mv ){
			$tournament_match_id = get_field_string_number( $mv, 'match', 0 );
			$tournament_match_index = get_field_string_number( $mv, 'tournament_match_index', 0 );
			if( $tournament_match_id == $dantai_match_id ){
				if( $tournament_match_index == 1 ){ break; }
				$up = intval( $tournament_match_index / 2 );
				foreach( $dantai_tournament_match as $mv_up ){
					$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
					$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
					if( $tournament_up_match_index == $up ){
						if( ( $tournament_match_index % 2 ) == 0 ){
							$sql = 'update `dantai_match` set `team1`='.$winner.' where `id`='.$tournament_up_match_id;
//echo $sql,"<br />\n";
							db_query( $dbs, $sql );

// 選手入れ替え対応
							if( $winner != 0 ){
								$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
								$dantai_match_up = db_query_list( $dbs, $sql );
								for( $i1 = 1; $i1 <= 5; $i1++ ){
									$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
									if( $one_match_up_id != 0 ){
										$sql = 'update `one_match`'
											. ' set `player1`=' . $list['p'][$i1]['player'.$list['winner']] . ','
											. ' `player1_change_name`=\'' . $list['p'][$i1]['player'.$list['winner'].'_change_name'] . '\','
											. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
										db_query( $dbs, $sql );
									}
								}
							}
						} else if( ( $tournament_match_index % 2 ) == 1 ){
							$sql = 'update `dantai_match` set `team2`='.$winner.' where `id`='.$tournament_up_match_id;
//echo $sql,"<br />\n";
							db_query( $dbs, $sql );
// 選手入れ替え対応
							if( $winner != 0 ){
								$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
								$dantai_match_up = db_query_list( $dbs, $sql );
								for( $i1 = 1; $i1 <= 5; $i1++ ){
									$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
									if( $one_match_up_id != 0 ){
										$sql = 'update `one_match`'
											. ' set `player2`=' . $list['p'][$i1]['player'.$list['winner']] . ','
											. ' `player2_change_name`=\'' . $list['p'][$i1]['player'.$list['winner'].'_change_name'] . '\','
											. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
										db_query( $dbs, $sql );
									}
								}
							}
						}
						break;
					}
				}

				if( $tournament_match_index == 2 || $tournament_match_index == 3 ){
					$up = count( $dantai_tournament_match );
					foreach( $dantai_tournament_match as $mv_up ){
    					$tournament_up_match_id = get_field_string_number( $mv_up, 'match', 0 );
	    				$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
						if( $tournament_up_match_index == $up ){
							if( $tournament_match_index == 2 ){
                                $sql = 'update `dantai_match` set `team1`='.$loser.' where `id`='.$tournament_up_match_id;
								db_query( $dbs, $sql );
// 選手入れ替え対応
    							if( $winner != 0 ){
	    							$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
    								$dantai_match_up = db_query_list( $dbs, $sql );
	    							for( $i1 = 1; $i1 <= 5; $i1++ ){
		    							$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
			    						if( $one_match_up_id != 0 ){
				    						$sql = 'update `one_match`'
					    						. ' set `player1`=' . $list['p'][$i1]['player'.$list['loser']] . ','
    											. ' set `player1_change_name`=\'' . $list['p'][$i1]['player'.$list['loser'].'_change_name'] . '\','
				    							. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
					    					db_query( $dbs, $sql );
						    			}
							    	}
    							}
							} else if( $tournament_match_index == 3 ){
                                $sql = 'update `dantai_match` set `team2`='.$loser.' where `id`='.$tournament_up_match_id;
								db_query( $dbs, $sql );
                                // 選手入れ替え対応
		    					if( $winner != 0 ){
			    					$sql = 'select * from `dantai_match` where `id`='.$tournament_up_match_id;
    								$dantai_match_up = db_query_list( $dbs, $sql );
	    							for( $i1 = 1; $i1 <= 5; $i1++ ){
		    							$one_match_up_id = get_field_string_number( $dantai_match_up[0], 'match'.$i1, 0 );
			    						if( $one_match_up_id != 0 ){
				    						$sql = 'update `one_match`'
					    						. ' set `player2`=' . $list['p'][$i1]['player'.$list['loser']] . ','
    											. ' set `player2_change_name`=\'' . $list['p'][$i1]['player'.$list['loser'].'_change_name'] . '\','
						    					. ' `update_date`=NOW() where `id`='.$one_match_up_id;
//echo '<!-- ',print_r($list['p'],TRUE)," -->\n";
//echo $sql,"<br />\n";
							    			db_query( $dbs, $sql );
								    	}
    								}
	    						}
							}
//echo $up,':',$sql;
							break;
						}
					}
				}

				break;
			}
		}
		db_close( $dbs );
		return $data;
	}

	function get_place_top_match( $param, $place, $series )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = '';
		if( $param['dantai_league'] > 0 ){
			$sql = 'select `dantai_league_match`.`id` as `id`'
				. ' from `dantai_match` join `dantai_league_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`=' . $place . ' and `dantai_match`.`place_match_no`=1';
		} else if( $param['dantai_tournament'] > 0 ){
			$sql = 'select `dantai_tournament_match`.`id` as `id`'
				. ' from `dantai_match` join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`=' . $place . ' and `dantai_match`.`place_match_no`=1';
		} else if( $param['kojin_league'] > 0 ){
			$sql = 'select `dantai_tournament_match`.`id` as `id`'
				. ' from `dantai_match` join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`=' . $place . ' and `dantai_match`.`place_match_no`=1';
		} else if( $param['kojin_tournament'] > 0 ){
			$sql = 'select `dantai_tournament_match`.`id` as `id`'
				. ' from `dantai_match` join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`=' . $place . ' and `dantai_match`.`place_match_no`=1';
		}
		if( $sql == '' ){ return 0; }
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r( $list );
		if( count( $list ) == 0 ){ return 0; }
		return $list[0]['id'];
	}

	function get_dantai_tournament_place_top_match( $place )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament_match`.`id` as `id`'
			. ' from `dantai_match` join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_match`.`place`=' . $place . ' and `dantai_match`.`place_match_no`=1';
		$list = db_query_list( $dbs, $sql );

//echo $sql;
//print_r( $list );
		if( count( $list ) == 0 ){ return 0; }
		return $list[0]['id'];
	}

	function get_dantai_tournament_match_navi( $dantai_tournament_match_id )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`,'
			. ' `dantai_tournament`.`id` as `tournament`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_tournament_match`.`match` as `match`'
			. ' from `dantai_tournament` join `dantai_tournament_match`'
				. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
				. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament_match`.`match`='.$dantai_tournament_match_id;
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		if( count( $list ) == 0 ){ return $list; }
		$dantai_match = $list[0];
		$place = get_field_string_number( $dantai_match, 'place', 0 );
	//	if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $dantai_match, 'place_match_no', 0 );
	//	if( $place_match_no == 0 ){ return $list; }
		$tournament = get_field_string_number( $dantai_match, 'tournament', 0 );
	//	if( $tournament == 0 ){ return $list; }
		$series_mw = get_field_string( $dantai_match, 'series_mw' );
		$series = get_field_string_number( $dantai_match, 'series', 0 );

		if( $series_mw == 'm' ){
			$list['tournament_name'] = '男子トーナメント';
		} else {
			$list['tournament_name'] = '女子トーナメント';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		} else if( $place == 5 ){
			$list['place_name'] = '第五試合場';
		} else if( $place == 6 ){
			$list['place_name'] = '第六試合場';
		} else if( $place == 7 ){
			$list['place_name'] = '第七試合場';
		} else if( $place == 8 ){
			$list['place_name'] = '第八試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$list['prev'] = '';
		$list['next'] = '';
		if( $place_match_no > 1 ){
			$sql = 'select `dantai_tournament`.`series` as `series`,'
				. ' `dantai_tournament`.`series_mw` as `series_mw`,'
				. ' `dantai_tournament`.`id` as `tournament`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_tournament_match`.`match` as `match`'
				. ' from `dantai_tournament` join `dantai_tournament_match`'
					. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
					. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
//				. ' where `dantai_tournament`.`id`='.$tournament
				. ' where `dantai_tournament`.`series`='.$series
					. ' and `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
			$data = db_query_list( $dbs, $sql );
			if( count( $data ) > 0 ){
				$series = get_field_string_number( $data[0], 'series', 0 );
				$tournament = get_field_string_number( $data[0], 'tournament', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 's='.$series.'&t='.$tournament.'&m='.$match;
				}
			} else {
				$sql = 'select `dantai_league`.`series` as `series`,'
					. ' `dantai_league`.`series_mw` as `series_mw`,'
					. ' `dantai_league`.`id` as `league`,'
					. ' `dantai_match`.`place` as `place`,'
					. ' `dantai_match`.`place_match_no` as `place_match_no`,'
					. ' `dantai_league_match`.`match` as `match`'
					. ' from `dantai_league` join `dantai_league_match`'
						. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
						. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
					. ' where `dantai_league`.`series`='.$series
						. ' and `dantai_match`.`place`='.$place
						. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
				$data = db_query_list( $dbs, $sql );
				if( count( $data ) > 0 ){
					$series = get_field_string_number( $data[0], 'series', 0 );
					$league = get_field_string_number( $data[0], 'league', 0 );
					$match = get_field_string_number( $data[0], 'match', 0 );
					if( $match > 0 ){
						$list['prev'] = 's='.$series.'&l='.$league.'&m='.$match;
					}
				}
			}
		}
		$sql = 'select `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`,'
			. ' `dantai_tournament`.`id` as `tournament`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_tournament_match`.`match` as `match`'
			. ' from `dantai_tournament` join `dantai_tournament_match`'
				. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
				. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
//				. ' where `dantai_tournament`.`id`='.$tournament
			. ' where `dantai_tournament`.`series`='.$series
				. ' and `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
		$data = db_query_list( $dbs, $sql );
		if( count( $data ) > 0 ){
			$series = get_field_string_number( $data[0], 'series', 0 );
			$tournament = get_field_string_number( $data[0], 'tournament', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 's='.$series.'&t='.$tournament.'&m='.$match;
			}
		}
		return $list;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_kojin_tournament_data( $series, $series_mw, $seriesinfo )
	{
		$list = array(
			'data' => array(),
			'players' => array(),
			'players_for_smarty' => array( 0 => '---' )
		);
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `kojin_tournament` where `del`=0 and `series`='.$series;
        if( $series_mw != '' ){ $sql .= " and `series_mw`='".$series_mw."'"; }
        $sql .= ' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$list['data'] = db_query_list( $dbs, $sql );
		//$list['data'] = db_get_one_data( $dbs, 'kojin_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'] );

		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0'
			.' order by `disp_order` asc';
		$kojin_players = db_query_list( $dbs, $sql );
		foreach( $kojin_players as &$pv ){
			$info = intval( $pv['id'] );
			$sql = 'select * from `entry_field` where `year`='.$_SESSION['auth']['year'].' and `info`='.$info;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			if( $seriesinfo['player_field_mode'] == 3 ){
				$d = array(
					'info' => $info,
					'player' => 1,
					'sei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' )),
					'mei' => base64_decode(get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' )),
					'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'1_disp' ),
					'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
					'pref_name' => $this->get_pref_name( $pref_array2, get_field_string_number( $fields, 'kojin_address_pref', 0 ) )
				);
				$name = $d['sei'] . '(' . $d['pref_name'] . ')';
				$list['players_for_smarty'][$info*0x100+1] = $name;
				$list['players'][] = $d;
			} else if( $seriesinfo['player_field_mode'] == 1 ){
				$d = array(
					'info' => $info,
					'player' => 1,
					'sei' => get_field_string( $fields, 'player_sei' ),
					'mei' => get_field_string( $fields, 'player_mei' ),
					'disp_name' => get_field_string( $fields, 'player_sei' ),
					'school_name_ryaku' => get_field_string( $fields, 'school_name' ),
					'pref_name' => ''
				);
				$name = $d['sei'] . '(' . $d['school_name_ryaku'] . ')';
				$list['players_for_smarty'][$info*0x100+1] = $name;
				$list['players'][] = $d;
			} else if( $seriesinfo['player_field_mode'] == 2 ){
				$y1 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'1', 0 );
				if( $y1 > 0 ){
					$d = array(
						'info' => $info,
						'player' => 1,
						'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' ),
						'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' ),
						'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'1_disp' ),
						'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
						'pref_name' => $this->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
					);
					$name = $d['sei'] . ' ' .$d['mei'];
					if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
					$list['players_for_smarty'][$info*0x100+1] = $name;
					$list['players'][] = $d;
				}
				$y2 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'2', 0 );
				if( $y2 > 0 ){
					$d = array(
						'info' => $info,
						'player' => 2,
						'sei' => get_field_string( $fields, 'kojin_'.$series_mw.'2_sei' ),
						'mei' => get_field_string( $fields, 'kojin_'.$series_mw.'2_mei' ),
						'disp_name' => get_field_string( $fields, 'kojin_'.$series_mw.'2_disp' ),
						'school_name_ryaku' => get_field_string( $fields, 'school_name_ryaku' ),
						'pref_name' => $this->get_pref_name( $pref_array2, get_field_string_number( $fields, 'school_address_pref', 0 ) )
					);
					$name = $d['sei'] . ' ' . $d['mei'];
					if( $d['disp_name'] != '' ){ $name .= '(' . $d['disp_name'] . ')'; }
					$list['players_for_smarty'][$info*0x100+2] = $name;
					$list['players'][] = $d;
				}
			}
		}

        for( $li = 0; $li < count($list['data']); $li++ ){
            $list['data'][$li]['player'] = array();
    		$player_num = intval( $list['data'][$li]['player_num'] );
    		$match_level = intval( $list['data'][$li]['match_level'] );
	    	$tournament_player_num = intval( $list['data'][$li]['tournament_player_num'] );
		    $pref_array = $this->get_pref_array();
		    $pref_array2 = $this->get_pref_array2();

    		for( $i1 = 0; $i1 < $tournament_player_num; $i1++ ){
	    		$list['data'][$li]['player'][] = array( 'info'=>0, 'player'=>0, 'sei'=>'', 'mei'=>'', 'disp_name'=>'' );
		    }
    		$sql = 'select * from `kojin_tournament_player`'
	    		. ' where `kojin_tournament_player`.`del`=0'
		    		. ' and `kojin_tournament_player`.`tournament`='.intval($list['data'][$li]['id']);
		    $player = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($player);
    		foreach( $player as $pv ){
	    		$no = intval( $pv['tournament_player_index'] );
		    	if( $no <= 0 && $no > $player_num ){ continue; }
			    $info = intval( $pv['team'] );
			    if( $info <= 0 ){ continue; }
			    foreach( $list['players'] as $player ){
				    if( $info == $player['info'] && $pv['player'] == $player['player'] ){
					    $d = array(
					    	'info' => $info,
						    'player' => $player['info'] * 0x100 + $player['player'],
						    'sei' => $player['sei'],
						    'mei' => $player['mei'],
						    'disp_name' => $player['disp_name'],
						    'school_name_ryaku' => $player['school_name_ryaku'],
						    'pref_name' => $player['pref_name']
    					);
	    				$list['data'][$li]['player'][$no-1] = $d;
		    			break;
			    	}
    			}
	    	}

    		$list['data'][$li]['match'] = array();
	    	$match_num = intval( $list['data'][$li]['match_num'] );
		    $tournament_match_num = 127;
		    for( $i1 = 0; $i1 < $tournament_match_num; $i1++ ){
			    $list['data'][$li]['match'][] = array( 'match'=>0, 'place'=>'0', 'place_match_no'=>0 );
    		}
	    	$sql = 'select `kojin_tournament_match`.`match` as `match`,'
		    	. ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`,'
			    . ' `kojin_match`.`place` as `place`,'
			    . ' `kojin_match`.`place_match_no` as `place_match_no`'
			    . ' from `kojin_tournament_match` join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
    			. ' where `kojin_tournament_match`.`del`=0 and `kojin_tournament_match`.`tournament`='.intval($list['data'][$li]['id']);
	    	$match = db_query_list( $dbs, $sql );
		    foreach( $match as $mv ){
			    $no = intval( $mv['tournament_match_index'] );
			    if( $no > 0 && $no <= $tournament_match_num ){
				    $list['data'][$li]['match'][$no-1]['match'] = intval( $mv['match'] );
    				$list['data'][$li]['match'][$no-1]['place'] = $mv['place'];
	    			$list['data'][$li]['match'][$no-1]['place_match_no'] = intval( $mv['place_match_no'] );
		    		$list['data'][$li]['match'][$no-1]['player1'] = 0;
			    	$list['data'][$li]['match'][$no-1]['player1_name'] = '';
				    $list['data'][$li]['match'][$no-1]['player2'] = 0;
    				$list['data'][$li]['match'][$no-1]['player2_name'] = '';
	    			$list['data'][$li]['match'][$no-1]['winner'] = 0;
		    		$list['data'][$li]['match'][$no-1]['extra'] = 0;
			    	if( $list['data'][$li]['match'][$no-1]['match'] > 0 ){
				    //	$sql = 'select `one_match`.`player1` as `player1`, `one_match`.`player2` as `player2`,'
				    //		. ' `one_match`.`winner` as `winner`'
				    //		. ' from `kojin_match` join `one_match` on `kojin_match`.`match`=`one_match`.`id`'
				    //		. ' where `kojin_match`.`id`='.$list['data'][$li]['match'][$no-1]['match'];
					    $sql = 'select `one_match`.*'
						    . ' from `kojin_match` join `one_match` on `kojin_match`.`match`=`one_match`.`id`'
						    . ' where `kojin_match`.`id`='.$list['data'][$li]['match'][$no-1]['match'];
    					$kojin_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($kojin_match);
	    				if( count($kojin_match) > 0 ){
		    				$list['data'][$li]['match'][$no-1]['player1'] = get_field_string_number( $kojin_match[0], 'player1', 0 );
			    			$list['data'][$li]['match'][$no-1]['player2'] = get_field_string_number( $kojin_match[0], 'player2', 0 );
				    		$list['data'][$li]['match'][$no-1]['waza1_1'] = get_field_string_number( $kojin_match[0], 'waza1_1', 0 );
					    	$list['data'][$li]['match'][$no-1]['waza1_2'] = get_field_string_number( $kojin_match[0], 'waza1_2', 0 );
						    $list['data'][$li]['match'][$no-1]['waza1_3'] = get_field_string_number( $kojin_match[0], 'waza1_3', 0 );
    						$list['data'][$li]['match'][$no-1]['waza2_1'] = get_field_string_number( $kojin_match[0], 'waza2_1', 0 );
	    					$list['data'][$li]['match'][$no-1]['waza2_2'] = get_field_string_number( $kojin_match[0], 'waza2_2', 0 );
		    				$list['data'][$li]['match'][$no-1]['waza2_3'] = get_field_string_number( $kojin_match[0], 'waza2_3', 0 );
			    			$list['data'][$li]['match'][$no-1]['hon1'] = get_field_string_number( $kojin_match[0], 'hon1', 0 );
				    		$list['data'][$li]['match'][$no-1]['hon2'] = get_field_string_number( $kojin_match[0], 'hon2', 0 );
					    	$list['data'][$li]['match'][$no-1]['winner'] = get_field_string_number( $kojin_match[0], 'winner', 0 );
						    $list['data'][$li]['match'][$no-1]['extra'] = get_field_string_number( $kojin_match[0], 'extra', 0 );
    						$list['data'][$li]['match'][$no-1]['fusen'] = 0;
	    					$player1 = get_field_string_number( $kojin_match[0], 'player1', 0 );
		    				if( $player1 > 0 ){
			    				foreach( $list['players'] as $player ){
				    				$p = $player['info'] * 0x100 + $player['player'];
					    			if( $p == $player1 ){
						    			if( $player['disp_name'] != '' ){
							    			$list['data'][$li]['match'][$no-1]['player1_disp_name'] = $player['disp_name'];
								    	} else {
									    	$list['data'][$li]['match'][$no-1]['player1_disp_name'] = $player['sei'];
    									}
	    								$list['data'][$li]['match'][$no-1]['player1_name'] = $player['sei'] . ' ' . $player['mei'];
		    							$list['data'][$li]['match'][$no-1]['player1_school_name_ryaku'] = $player['school_name_ryaku'];
			    						$list['data'][$li]['match'][$no-1]['player1_pref_name'] = $player['pref_name'];
				    					break;
					    			}
						    	}
    						}
	    					$player2 = get_field_string_number( $kojin_match[0], 'player2', 0 );
		    				if( $player2 > 0 ){
			    				foreach( $list['players'] as $player ){
				    				$p = $player['info'] * 0x100 + $player['player'];
					    			if( $p == $player2 ){
						    			if( $player['disp_name'] != '' ){
							    			$list['data'][$li]['match'][$no-1]['player2_name'] = $player['disp_name'];
								    	} else {
									    	$list['data'][$li]['match'][$no-1]['player2_name'] = $player['sei'];
    									}
	    								$list['data'][$li]['match'][$no-1]['player2_name'] = $player['sei'] . ' ' . $player['mei'];
		    							$list['data'][$li]['match'][$no-1]['player2_school_name_ryaku'] = $player['school_name_ryaku'];
			    						$list['data'][$li]['match'][$no-1]['player2_pref_name'] = $player['pref_name'];
				    					break;
					    			}
						    	}
    						}
	    				}
		    		}
			    }
    		}

    		$offset = 1;
	    	$player_num2 = 1;
		    $match_offset = array();
		    for( $i1 = 1; $i1 <= $match_level; $i1++ ){
			    $match_offset[$match_level-$i1] = $offset;
    			$offset *= 2;
	    		$player_num2 *= 2;
		    }
    		$list['data'][$li]['match_array'] = array();
	    	for( $i1 = 0; $i1 < $player_num2; $i1++ ){
		    	$match_no = 2;
			    $match_row = array();
			    for( $i2 = 0; $i2 < $match_level; $i2++ ){
				    if( ( $i1 % $match_no ) == $match_no / 2 - 1 ){
					    $match_row[] = $match_offset[$i2];
    					$match_offset[$i2]++;
	    			} else if( ( $i1 % $match_no ) == $match_no / 2 ){
		    			$match_row[] = -1;
			    	} else {
				    	$value = 0;
					    if( $i2 > 0 ){
			    			if( ( $i1 % $match_no ) == $match_no / 2 - 2 ){
				    			$value = $match_offset[$i2] + 1000;
					    	}
						    if( ( $i1 % $match_no ) == $match_no / 2 + 1 ){
							    $value = $match_offset[$i2] - 1 + 2000;
    						}
	    				}
		    			$match_row[] = $value;
			    	}
				    $match_no *= 2;
    			}
	    		$list['data'][$li]['match_array'][] = $match_row;
		    }
//print_r($data);
        }
		db_close( $dbs );
//print_r($list);
		return $list;
	}

	function update_kojin_tournament_data( $series, $series_mw, $post )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'] );
		$tournament_id = intval( $data['id'] );
		$player_num = intval( $data['player_num'] );
		$tournament_player_num = intval( $data['tournament_player_num'] );
		$tournament_match_num = intval( $data['match_num'] );
		$tournament_extra_match_num = intval( $data['extra_match_num'] );
		$player_id_list = array();
		$sql = 'select * from `kojin_tournament_player` where `del`=0 and `tournament`='.$tournament_id;
		$kojin_tournament_player = db_query_list( $dbs, $sql );
		for( $player_index = 1; $player_index <= $tournament_player_num; $player_index++ ){
			$update = false;
			$player = intval( $post['entry_'.$player_index] );
			$player_info = intval( $player / 0x100 );
			$player_no = intval( $player % 0x100 );
			foreach( $kojin_tournament_player as $pv ){
				$tournament_player_id = intval( $pv['id'] );
				$tournament_player_index = intval( $pv['tournament_player_index'] );
				if( $player_index == $tournament_player_index ){
					$sql = 'update `kojin_tournament_player` set `team`='.$player_info.',`player`='.$player_no.' where `id`='.$tournament_player_id;
//echo $sql,"<br />";
					db_query( $dbs, $sql );
					$player_id_list[$player_index] = $player;
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'INSERT INTO `kojin_tournament_player` ( `tournament`,`tournament_player_index`,`team`,`player`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$player_index.', '.$player_info.', '.$player_no.', NOW(), NOW() )';
//echo $sql,"<br />";
				db_query( $dbs, $sql );
			}
		}

		$match_num = intval( $data['match_num'] );
		$match_level = intval( $data['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}
		$sql = 'select * from `kojin_tournament_match` where `del`=0 and `tournament`='.$tournament_id;
		$kojin_tournament_match = db_query_list( $dbs, $sql );
		for( $match_index = 1; $match_index <= $tournament_match_num+$tournament_extra_match_num; $match_index++ ){
			$place = $post['place_'.$match_index];
			$place_match_no = intval( $post['place_match_'.$match_index] );
			$update = false;
			foreach( $kojin_tournament_match as $mv ){
				$match_id = intval( $mv['match'] );
				$tournament_match_index = intval( $mv['tournament_match_index'] );
				if( $match_index == $tournament_match_index ){
					$sql = 'select * from `kojin_match` where `id`='.$match_id;
					$kojin_match = db_query_list( $dbs, $sql );
					if( count($kojin_match) > 0 ){
						$sql = 'update `kojin_match`'
							. ' set `place`=\''.$place.'\',`place_match_no`='.$place_match_no
							. ' where `id`='.$match_id;
//echo $sql,"<br />";
						db_query( $dbs, $sql );
						if( $match_index >= $macth1_level && $match_index <= $tournament_match_num ){
							$sql = 'update `one_match`'
								. ' set `player1`='.$player_id_list[($match_index-$macth1_level)*2+1].','
								. ' `player2`='.$player_id_list[($match_index-$macth1_level)*2+2].','
								. ' `update_date`=NOW()'
								. ' where `id`='.$kojin_match[0]['match'];
//echo $sql,"<br />";
							db_query( $dbs, $sql );
							if( $place == 'no_match' ){
								$t2 = intval( $tournament_match_index / 2 );
								$t2ofs = ( $tournament_match_index % 2 ) + 1;
								foreach( $kojin_tournament_match as $mv2 ){
									$match_id2 = intval( $mv2['match'] );
									$tournament_match_index2 = intval( $mv2['tournament_match_index'] );
									if( $t2 == $tournament_match_index2 ){
										$sql = 'select * from `kojin_match` where `id`='.$match_id2;
										$kojin_match2 = db_query_list( $dbs, $sql );
										if( count($kojin_match2) > 0 ){
											$sql = 'update `one_match` set ';
											if( $player_id_list[($match_index-$macth1_level)*2+1] != 0 ){
												$sql .= '`player'.$t2ofs.'`='.$player_id_list[($match_index-$macth1_level)*2+1];
											} else {
												$sql .= '`player'.$t2ofs.'`='.$player_id_list[($match_index-$macth1_level)*2+2];
											}
											$sql .= ', `update_date`=NOW()';
											$sql .= ' where `id`='.$kojin_match2[0]['match'];
//echo $sql,"<br />";
											db_query( $dbs, $sql );
										}
									}
								}
							}
						}
					}
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
				db_query( $dbs, $sql );
				$matches = db_query_insert_id( $dbs );
				$sql = 'insert `kojin_match`'
					. ' set `place`=\''.$place.'\',`place_match_no`='.$place_match_no.','
						. '`match`=' . $matches . ','
						. '`create_date`=NOW(),`update_date`=NOW()';
//echo $sql,"<br />";
				db_query( $dbs, $sql );
				$match_id = db_query_insert_id( $dbs );
				$sql = 'INSERT INTO `kojin_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$match_index.', '.$match_id.', NOW(), NOW( ) )';
//echo $sql,"<br />";
				db_query( $dbs, $sql );
			}
		}
		db_close( $dbs );
//print_r($data);
		return $data;
	}

	function load_kojin_tournament_csvdata( $series, $series_mw, $file )
	{
		if( $file == '' ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_tournament', '*', '`series`='.$series.' and `series_mw`=\''.$series_mw.'\' and `year`='.$_SESSION['auth']['year'] );
		$tournament_id = intval( $data['id'] );
		$player_num = intval( $data['player_num'] );
		$tournament_player_num = intval( $data['tournament_player_num'] );
		$tournament_match_num = 127;

		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' and `del`=0'
			.' order by `disp_order` asc';
		$kojin_players = array();
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $pv ){
			$info = intval( $pv['id'] );
			$sql = 'select * from `entry_field` where `year`='.$_SESSION['auth']['year'].' and `info`='.$info;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$y1 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'1', 0 );
			if( $y1 > 0 ){
				$d = array();
				$d['info'] = $info;
				$d['player'] = 1;
				$d['sei'] = get_field_string( $fields, 'kojin_'.$series_mw.'1_sei' );
				$d['mei'] = get_field_string( $fields, 'kojin_'.$series_mw.'1_mei' );
				$d['name'] = $d['sei'] . ' ' .$d['mei'];
				$d['id'] = $info * 0x100 + 1;
				$kojin_players[] = $d;
			}
			$y2 = get_field_string_number( $fields, 'kojin_yosen_'.$series_mw.'2', 0 );
			if( $y2 > 0 ){
				$d = array();
				$d['info'] = $info;
				$d['player'] = 2;
				$d['sei'] = get_field_string( $fields, 'kojin_'.$series_mw.'2_sei' );
				$d['mei'] = get_field_string( $fields, 'kojin_'.$series_mw.'2_mei' );
				$d['name'] = $d['sei'] . ' ' .$d['mei'];
				$d['id'] = $info * 0x100 + 2;
				$kojin_players[] = $d;
			}
		}

		$fp = fopen( $file, 'r' );
		$player_id_list = array();
		$sql = 'select * from `kojin_tournament_player` where `del`=0 and `tournament`='.$tournament_id;
		$kojin_tournament_player = db_query_list( $dbs, $sql );
		for( $player_index = 1; $player_index <= $tournament_player_num; $player_index++ ){
			$name = fgets( $fp );
			$player = 0;
			$player_info = 0;
			$player_no = 0;
echo $name,'<br />';
			foreach( $kojin_players as $pv ){
				if( mb_strpos( $name, $pv['sei'] ) !== false && mb_strpos( $name, $pv['mei'] ) !== false ){
					$player = $pv['id'];
					$player_info = $pv['info'];
					$player_no = $pv['player'];
					break;
				}
			}
			$update = false;
			foreach( $kojin_tournament_player as $pv ){
				$tournament_player_id = intval( $pv['id'] );
				$tournament_player_index = intval( $pv['tournament_player_index'] );
				if( $player_index == $tournament_player_index ){
					$sql = 'update `kojin_tournament_player` set `team`='.$player_info.',`player`='.$player_no.' where `id`='.$tournament_player_id;
echo $sql,"<br />";
					db_query( $dbs, $sql );
					$player_id_list[$player_index] = $player;
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'INSERT INTO `kojin_tournament_player` ( `tournament`,`tournament_player_index`,`team`,`player`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$player_index.', '.$player_info.', '.$player_no.', NOW(), NOW() )';
echo $sql,"<br />";
				db_query( $dbs, $sql );
			}
		}
		fclose( $fp );
//print_r($kojin_players);
//print_r($player_id_list);

		$match_num = intval( $data['match_num'] );
		$match_level = intval( $data['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}
		$sql = 'select * from `kojin_tournament_match` where `del`=0 and `tournament`='.$tournament_id;
		$kojin_tournament_match = db_query_list( $dbs, $sql );
		for( $match_index = 1; $match_index <= $tournament_match_num; $match_index++ ){
			$update = false;
			foreach( $kojin_tournament_match as $mv ){
				$match_id = intval( $mv['match'] );
				$tournament_match_index = intval( $mv['tournament_match_index'] );
				if( $match_index == $tournament_match_index ){
					$sql = 'select * from `kojin_match` where `id`='.$match_id;
					$kojin_match = db_query_list( $dbs, $sql );
					if( count($kojin_match) > 0 ){
						if( $match_index >= $macth1_level ){
//print_r($kojin_match);
							$place = $kojin_match[0]['place'];
							$sql = 'update `one_match`'
								. ' set `player1`='.$player_id_list[($match_index-$macth1_level)*2+1].','
								. ' `player2`='.$player_id_list[($match_index-$macth1_level)*2+2].','
								. ' `update_date`=NOW()'
								. ' where `id`='.$kojin_match[0]['match'];
echo $sql,"<br />";
							db_query( $dbs, $sql );
							if( $place == 'no_match' ){
								$t2 = intval( $tournament_match_index / 2 );
								foreach( $kojin_tournament_match as $mv2 ){
									$match_id2 = intval( $mv2['match'] );
									$tournament_match_index2 = intval( $mv2['tournament_match_index'] );
									if( $t2 == $tournament_match_index2 ){
										$sql = 'select * from `kojin_match` where `id`='.$match_id2;
										$kojin_match2 = db_query_list( $dbs, $sql );
										if( count($kojin_match2) > 0 ){
											$sql = 'update `one_match` set ';
											if( $player_id_list[($match_index-$macth1_level)*2+1] != 0 ){
												$sql .= '`player1`='.$player_id_list[($match_index-$macth1_level)*2+1];
											} else {
												$sql .= '`player2`='.$player_id_list[($match_index-$macth1_level)*2+2];
											}
											$sql .= ', `update_date`=NOW()';
											$sql .= ' where `id`='.$kojin_match2[0]['match'];
echo $sql,"<br />";
											db_query( $dbs, $sql );
										}
									}
								}
							}
						}
					}
					$update = true;
					break;
				}
			}
			if( !$update ){
				$sql = 'INSERT INTO `one_match` ( `player1`,`player2`,`create_date`,`update_date` ) VALUES ( 0, 0, NOW(), NOW() )';
echo $sql,"<br />";
				db_query( $dbs, $sql );
				$matches = db_query_insert_id( $dbs );
				$sql = 'insert `kojin_match`'
					. ' set `place`=\'0\',`place_match_no`=0,'
						. '`match`=' . $matches . ','
						. '`create_date`=NOW(),`update_date`=NOW()';
echo $sql,"<br />";
				db_query( $dbs, $sql );
				$match_id = db_query_insert_id( $dbs );
				$sql = 'INSERT INTO `kojin_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`create_date`,`update_date` ) VALUES ( '.$tournament_id.', '.$match_index.', '.$match_id.', NOW(), NOW( ) )';
echo $sql,"<br />";
				db_query( $dbs, $sql );
			}
		}
		db_close( $dbs );
	}

	function get_kojin_tournament_one_result( $series, $series_mw, $id )
	{
        $series_info = $this->get_series_list( $series );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );

		//$kojin_field = 'kojin_' . $series_mw;
		$data['matches'] = array();
		$data['players'] = array();
		$match_id = get_field_string_number( $data, 'match', 0 );
		if( $match_id != 0 ){
			$data['matches'] = db_get_one_data( $dbs, 'one_match', '*', '`id`='.$match_id );
			$player1_id = get_field_string_number( $data['matches'], 'player1', 0 );
			$player2_id = get_field_string_number( $data['matches'], 'player2', 0 );
			if( $player1_id != 0 ){
				$data['players'][1]['player_info'] = intval( $player1_id / 0x100 );
				$data['players'][1]['player_no'] = intval( $player1_id % 0x100 );
				$data['players'][1]['entry'] = $this->get_entry_one_data2( $data['players'][1]['player_info'] );
                if( $series_info['player_field_mode'] == 1 ){
                    $kojin_field = 'player';
                } else {
                    $kojin_field = 'kojin_' . $series_mw . $data['players'][1]['player_no'];
                }
				$data['players'][1]['name_str'] = get_field_string( $data['players'][1]['entry'], $kojin_field.'_sei' ) .'&nbsp;'. get_field_string( $data['players'][1]['entry'], $kojin_field.'_mei' );
				$name = get_field_string( $data['players'][1]['entry'], $kojin_field.'_disp' );
				if( $name == '' ){
					$name = get_field_string( $data['players'][1]['entry'], $kojin_field.'_sei' );
				}
				$data['players'][1]['name_str2'] = $name;
				$name = get_field_string( $data['players'][1]['entry'], 'school_name_ryaku' );
				if( $name == '' ){
					$name = get_field_string( $data['players'][1]['entry'], 'school_name' );
				}
				$data['players'][1]['school_name_str'] = $name;
			} else {
				$data['players'][1] = array();
			}
			if( $player2_id != 0 ){
				$data['players'][2]['player_info'] = intval( $player2_id / 0x100 );
				$data['players'][2]['player_no'] = intval( $player2_id % 0x100 );
				$data['players'][2]['entry'] = $this->get_entry_one_data2( $data['players'][2]['player_info'] );
                if( $series_info['player_field_mode'] == 1 ){
                    $kojin_field = 'player';
                } else {
                    $kojin_field = 'kojin_' . $series_mw . $data['players'][2]['player_no'];
                }
				$data['players'][2]['name_str'] = get_field_string( $data['players'][2]['entry'], $kojin_field.'_sei' ) .'&nbsp;'. get_field_string( $data['players'][2]['entry'], $kojin_field.'_mei' );
				$name = get_field_string( $data['players'][2]['entry'], $kojin_field.'_disp' );
				if( $name == '' ){
					$name = get_field_string( $data['players'][2]['entry'], $kojin_field.'_sei' );
				}
				$data['players'][2]['name_str2'] = $name;
				$name = get_field_string( $data['players'][2]['entry'], 'school_name_ryaku' );
				if( $name == '' ){
					$name = get_field_string( $data['players'][2]['entry'], 'school_name' );
				}
				$data['players'][2]['school_name_str'] = $name;
			} else {
				$data['players'][2] = array();
			}
		} else {
			$data['players'][1] = array();
			$data['players'][2] = array();
		}
//print_r($data);
		db_close( $dbs );
		return $data;
	}

	function update_kojin_tournament_one_waza( $match, $field, $value )
	{
//print_r($p);

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$match );
		$match_id = get_field_string_number( $data, 'match', 0 );
		if( $match_id != 0 ){
			$sql = 'update `one_match` set `'.$field.'`='.$value.' where `id`='.$match_id;
			db_query( $dbs, $sql );
//echo $sql;
		}
		db_close( $dbs );
		return $data;
	}

	function update_kojin_tournament_one_result( $series, $tournament, $id, $p )
	{
//print_r($p);

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'kojin_match', '*', '`id`='.$id );
		$match_id = get_field_string_number( $data, 'match', 0 );
		if( $match_id != 0 ){
			$sql = 'update `one_match`'
				. ' set `faul1_1`='.$p['faul1_1'].','
				. '`faul1_2`='.$p['faul1_2'].','
				. '`waza1_1`='.$p['waza1_1'].','
				. '`waza1_2`='.$p['waza1_2'].','
				. '`waza1_3`='.$p['waza1_3'].','
				. '`faul2_1`='.$p['faul2_1'].','
				. '`faul2_2`='.$p['faul2_2'].','
				. '`waza2_1`='.$p['waza2_1'].','
				. '`waza2_2`='.$p['waza2_2'].','
				. '`waza2_3`='.$p['waza2_3'].','
				. '`end_match`='.$p['end_match'].','
				. '`match_time`=\''.$p['match_time'].'\','
				. '`extra`='.$p['extra'].','
				. '`hon1`='.$p['hon1'].','
				. '`hon2`='.$p['hon2'].','
				. '`winner`='.$p['winner']
				. ' where `id`='.$match_id;
			db_query( $dbs, $sql );
//echo $sql;
		}
/*
		$sql = 'update `kojin_match`'
			. ' set `win1`='.$list['win1sum'].','
			. '`hon1`='.$list['hon1sum'].','
			. '`win2`='.$list['win2sum'].','
			. '`hon2`='.$list['hon2sum'].','
			. '`winner`='.$list['winner'].','
			. '`exist_match6`='.$list['exist_match6']
			. ' where `id`='.$id;
		db_query( $dbs, $sql );
*/
		if( $p['winner'] == 1 ){
			$winner = $p['player1_id'];
			$loser = $p['player2_id'];
		} else if( $p['winner'] == 2 ){
			$winner = $p['player2_id'];
			$loser = $p['player1_id'];
		} else {
			$winner = 0;
			$loser = 0;
		}

		$sql = 'select `kojin_match`.`match` as `one_match`,'
			. ' `kojin_match`.`id` as `match_id`,'
			. ' `kojin_tournament_match`.`id` as `tournament_match_id`,'
			. ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`'
			. ' from `kojin_tournament_match` join `kojin_match`'
				. ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament_match`.`tournament`='.$tournament
				. ' order by `kojin_tournament_match`.`tournament_match_index` asc';
		$kojin_tournament_match = db_query_list( $dbs, $sql );
//echo $id."<br />".$sql."\n";
//print_r($kojin_tournament_match);
		foreach( $kojin_tournament_match as $mv ){
			$tournament_match_id = get_field_string_number( $mv, 'match_id', 0 );
			//$tournament_one_match_id = get_field_string_number( $mv, 'match', 0 );
			$tournament_match_index = get_field_string_number( $mv, 'tournament_match_index', 0 );
			if( $tournament_match_id == $id ){
				if( $tournament_match_index == 1 ){ break; }
				$up = intval( $tournament_match_index / 2 );
				foreach( $kojin_tournament_match as $mv_up ){
					$tournament_up_match_id = get_field_string_number( $mv_up, 'one_match', 0 );
					$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
					if( $tournament_up_match_index == $up ){
						if( ( $tournament_match_index % 2 ) == 0 ){
							$sql = 'update `one_match` set `player1`='.$winner.' where `id`='.$tournament_up_match_id;
							db_query( $dbs, $sql );
						} else if( ( $tournament_match_index % 2 ) == 1 ){
							$sql = 'update `one_match` set `player2`='.$winner.' where `id`='.$tournament_up_match_id;
							db_query( $dbs, $sql );
						}
//echo $sql;
						break;
					}
				}
				if( $tournament_match_index == 2 || $tournament_match_index == 3 ){
					$up = count( $kojin_tournament_match );
					foreach( $kojin_tournament_match as $mv_up ){
						$tournament_up_match_id = get_field_string_number( $mv_up, 'one_match', 0 );
						$tournament_up_match_index = get_field_string_number( $mv_up, 'tournament_match_index', 0 );
						if( $tournament_up_match_index == $up ){
							if( $tournament_match_index == 2 ){
								$sql = 'update `one_match` set `player1`='.$loser.' where `id`='.$tournament_up_match_id;
								db_query( $dbs, $sql );
							} else if( $tournament_match_index == 3 ){
								$sql = 'update `one_match` set `player2`='.$loser.' where `id`='.$tournament_up_match_id;
								db_query( $dbs, $sql );
							}
//echo $up,':',$sql;
							break;
						}
					}
				}
				break;
			}
		}
		db_close( $dbs );
		return $data;
	}

	function get_kojin_place_navi_data( $series, $place )
	{
		$place_name = array(
			'第一試合場', '第ニ試合場', '第三試合場', '第四試合場',
			'第五試合場', '第六試合場', '第七試合場', '第八試合場'
		);

		$data = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select `kojin_tournament_match`.`id` as `id`,'
			. ' `kojin_tournament`.`series` as `series`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`,'
			. ' `kojin_tournament_match`.`match` as `match`'
			. ' from `kojin_tournament`'
			. ' inner join `kojin_tournament_match` on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
			. ' inner join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament`.`series`='.$series.' and `kojin_tournament`.`year`='.$_SESSION['auth']['year']
			. ' and `kojin_match`.`place`='.$place.' order by `kojin_match`.`place_match_no` asc';
		$list = db_query_list( $dbs, $sql );
		$data = array();
		foreach( $list as $lv ){
			$lv['match_name'] = 'トーナメント';
			$lv['place_name'] = $place_name[$place-1];
			$lv['place_match_no'] = '第'.$lv['place_match_no'].'試合';
			$data[] = $lv;
		}

		db_close( $dbs );
		return $data;
	}

	function get_kojin_tournament_match_navi( $series, $tournament, $match )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `kojin_match`.`place` as `place`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`'
			. ' from `kojin_tournament_match` join `kojin_match`'
				. ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament_match`.`match`='.$match;
		$kojin_tournament_match = db_query_list( $dbs, $sql );
		if( count( $kojin_tournament_match ) == 0 ){ return $list; }
		$place = get_field_string_number( $kojin_tournament_match[0], 'place', 0 );
		if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $kojin_tournament_match[0], 'place_match_no', 0 );
		if( $place_match_no == 0 ){ return $list; }
//print_r($kojin_tournament_match);

		if( $category == 1 ){
			$list['category_name'] = '男子個人戦';
		} else {
			$list['category_name'] = '女子個人戦';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$category_prev = $category;
		$tournament_prev = $tournament;
		$place_match_no_prev = $place_match_no;
		if( $place_match_no > 1 ){
			$place_match_no_prev--;
		} else {
			$place_match_no_prev = 0;
			if( $tournament == 2 ){
				$sql = 'select max(`kojin_match`.`place_match_no`) as `last_place_match_no`'
					. ' from `kojin_tournament_match` join `kojin_match`'
						. ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
					. ' where `kojin_match`.`place`='.$place
						. ' and `kojin_tournament_match`.`tournament`=1';
				$data = db_query_list( $dbs, $sql );
				if( count($data) > 0 ){
					$place_match_no_prev = get_field_string_number( $data[0], 'last_place_match_no', 0 );
				}
				$category_prev = $category - 1;
				$tournament_prev = $tournament - 1;
			}
		}
		if( $place_match_no_prev > 0 ){
			$sql = 'select `kojin_match`.`place` as `place`,'
				. ' `kojin_match`.`place_match_no` as `place_match_no`,'
				. ' `kojin_tournament_match`.`match` as `match`'
				. ' from `kojin_tournament_match` join `kojin_match`'
					. ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
				. ' where `kojin_match`.`place`='.$place
					. ' and `kojin_match`.`place_match_no`='.$place_match_no_prev
					. ' and `kojin_tournament_match`.`tournament`='.$tournament_prev;
			$data = db_query_list( $dbs, $sql );
			if( count( $data ) > 0 ){
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 'kojin_result.php?c='.$category_prev.'&t='.$tournament_prev.'&m='.$match;
				}
			}
		}

		$sql = 'select `kojin_match`.`place` as `place`,'
			. ' `kojin_match`.`place_match_no` as `place_match_no`,'
			. ' `kojin_tournament_match`.`match` as `match`'
			. ' from `kojin_tournament_match` join `kojin_match`'
				. ' on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_match`.`place`='.$place
				. ' and `kojin_match`.`place_match_no`='.($place_match_no+1)
				. ' and `kojin_tournament_match`.`tournament`='.$tournament;
		$data = db_query_list( $dbs, $sql );
		if( count( $data ) > 0 ){
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 'kojin_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
			}
		} else {
			if( $tournament == 1 ){
				$sql = 'select `kojin_tournament`.`category` as `category`,'
					. ' `kojin_tournament_match`.`tournament` as `tournament`,'
					. ' `kojin_match`.`place` as `place`,'
					. ' `kojin_match`.`place_match_no` as `place_match_no`,'
					. ' `kojin_tournament_match`.`match` as `match`'
					. ' from `kojin_tournament` join `kojin_tournament_match`'
						. ' on `kojin_tournament`.`id`=`kojin_tournament_match`.`tournament`'
						. ' join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
					. ' where `kojin_match`.`place`='.$place
						. ' and `kojin_match`.`place_match_no`=1'
						. ' and `kojin_tournament_match`.`tournament`=2';
				$data = db_query_list( $dbs, $sql );
				if( count( $data ) > 0 ){
					$match = get_field_string_number( $data[0], 'match', 0 );
					if( $match > 0 ){
						$list['next'] = 'kojin_result.php?c=2&t=2'.'&m='.$match;
					}
				}
			}
			if( $tournament == 2 ){
				$sql = 'select `dantai_league`.`category` as `category`,'
					. ' `dantai_league_match`.`league` as `league`,'
					. ' `dantai_match`.`place` as `place`,'
					. ' `dantai_match`.`place_match_no` as `place_match_no`,'
					. ' `dantai_league_match`.`match` as `match`'
					. ' from `dantai_league` join `dantai_league_match`'
						. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
						. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
					. ' where `dantai_match`.`place`='.$place
						. ' and `dantai_match`.`place_match_no`=1';
				$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
				if( count($data) > 0 ){
					$category = get_field_string_number( $data[0], 'category', 0 );
					$league = get_field_string_number( $data[0], 'league', 0 );
					$match = get_field_string_number( $data[0], 'match', 0 );
					if( $match > 0 ){
						$list['next'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
					}
				}
			}
		}

		db_close( $dbs );
		return $list;
	}

	function ___get_dantai_league_match_navi( $category, $league, $match )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list['category_name'] = '男子団体予選リーグ';
		$list['place_name'] = '第一試合場';
		$list['place_match_no'] = '第1試合';
		return $list;
	}

	function __get_dantai_league_match_navi( $category, $league, $match )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league`.`category` as `category`,'
			. ' `dantai_league_match`.`league` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
			. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($dantai_league_match);
		if( count( $dantai_league_match ) == 0 ){ return $list; }
		$place = get_field_string_number( $dantai_league_match[0], 'place', 0 );
		if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $dantai_league_match[0], 'place_match_no', 0 );
		if( $place_match_no == 0 ){ return $list; }
		$category = get_field_string_number( $dantai_league_match[0], 'category', 0 );
		$league = get_field_string_number( $dantai_league_match[0], 'league', 0 );
//print_r($dantai_league_match);

		if( $category == 1 ){
			$list['category_name'] = '男子団体予選リーグ';
		} else {
			$list['category_name'] = '女子団体予選リーグ';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$category_prev = $category;
		$league_prev = $league;
		$place_match_no_prev = $place_match_no;
		$sql = '';
		if( $place_match_no > 1 ){
			$sql = 'select `dantai_league`.`category` as `category`,'
				. ' `dantai_league_match`.`league` as `league`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_league_match`.`match` as `match`'
				. ' from `dantai_league` join `dantai_league_match`'
					. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
					. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count( $data ) > 0 ){
				$category = get_field_string_number( $data[0], 'category', 0 );
				$league = get_field_string_number( $data[0], 'league', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
				}
			}
		} else {
			$sql = 'select max(`kojin_match`.`place_match_no`) as `last_place_match_no`'
				. ' from `kojin_tournament` join `kojin_tournament_match`'
					. ' on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
					. ' join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
				. ' where `kojin_match`.`place`='.$place
					. ' and `kojin_tournament`.`category`=2';
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count($data) > 0 ){
				$place_match_no_prev = get_field_string_number( $data[0], 'last_place_match_no', 0 );
				if( $place_match_no_prev > 0 ){
					$sql = 'select `kojin_tournament`.`category` as `category`,'
						. ' `kojin_tournament_match`.`tournament` as `tournament`,'
						. ' `kojin_match`.`place` as `place`,'
						. ' `kojin_match`.`place_match_no` as `place_match_no`,'
						. ' `kojin_tournament_match`.`match` as `match`'
						. ' from `kojin_tournament` join `kojin_tournament_match`'
							. ' on `kojin_tournament_match`.`tournament`=`kojin_tournament`.`id`'
							. ' join `kojin_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
						. ' where `kojin_match`.`place`='.$place
							. ' and `kojin_match`.`place_match_no`='.$place_match_no_prev
							. ' and `kojin_tournament`.`category`=2';
					$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
					if( count( $data ) > 0 ){
						$category = get_field_string_number( $data[0], 'category', 0 );
						$tournament = get_field_string_number( $data[0], 'tournament', 0 );
						$match = get_field_string_number( $data[0], 'match', 0 );
						if( $match > 0 ){
							$list['prev'] = 'kojin_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
						}
					}
				}
			}
		}

		$sql = 'select `dantai_league`.`category` as `category`,'
			. ' `dantai_league_match`.`league` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
				. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
		$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
		if( count( $data ) > 0 ){
			$category = get_field_string_number( $data[0], 'category', 0 );
			$league = get_field_string_number( $data[0], 'league', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
			}
		} else {
			$sql = 'select `dantai_tournament`.`category` as `category`,'
				. ' `dantai_tournament_match`.`tournament` as `tournament`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_tournament_match`.`match` as `match`'
				. ' from `dantai_tournament` join `dantai_tournament_match`'
					. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
					. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count( $data ) > 0 ){
				$category = get_field_string_number( $data[0], 'category', 0 );
				$tournament = get_field_string_number( $data[0], 'tournament', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['next'] = 'dantai_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
				}
			}
		}
		db_close( $dbs );
		return $list;
	}

	function get_dantai_league_match_navi( $match )
	{
		$list = array( 'prev'=>'', 'next'=>'' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`,'
			. ' `dantai_league`.`id` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
				. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($dantai_league_match);
		if( count( $dantai_league_match ) == 0 ){ return $list; }
		$place = get_field_string_number( $dantai_league_match[0], 'place', 0 );
		if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $dantai_league_match[0], 'place_match_no', 0 );
		if( $place_match_no == 0 ){ return $list; }
		$series = get_field_string_number( $dantai_league_match[0], 'series', 0 );
		$series_mw = get_field_string( $dantai_league_match[0], 'series_mw' );

		if( $series_mw == 'm' ){
			$list['category_name'] = '男子団体予選リーグ';
		} else {
			$list['category_name'] = '女子団体予選リーグ';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		} else if( $place == 5 ){
			$list['place_name'] = '第五試合場';
		} else if( $place == 6 ){
			$list['place_name'] = '第六試合場';
		} else if( $place == 7 ){
			$list['place_name'] = '第七試合場';
		} else if( $place == 8 ){
			$list['place_name'] = '第八試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$category_prev = $category;
		$league_prev = $league;
		$place_match_no_prev = $place_match_no;
		$sql = '';
		if( $place_match_no > 1 ){
			$sql = 'select `dantai_league`.`series` as `series`,'
				. ' `dantai_league`.`series_mw` as `series_mw`,'
				. ' `dantai_league`.`id` as `league`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_league_match`.`match` as `match`'
				. ' from `dantai_league` join `dantai_league_match`'
					. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
					. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_league`.`series`='.$series
					. ' and `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
			$data = db_query_list( $dbs, $sql );
//echo $sql,"\n";
//print_r($data);
			if( count( $data ) > 0 ){
				$series = get_field_string_number( $data[0], 'series', 0 );
				$league = get_field_string_number( $data[0], 'league', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 's='.$series.'&l='.$league.'&m='.$match;
				}
			}
		}

		$sql = 'select `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`,'
			. ' `dantai_league`.`id` as `league`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_league_match`.`match` as `match`'
			. ' from `dantai_league` join `dantai_league_match`'
				. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
				. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_league`.`series`='.$series
				. ' and `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
		$data = db_query_list( $dbs, $sql );
//echo $sql,"\n";
//print_r($data);
		if( count( $data ) > 0 ){
			$series = get_field_string_number( $data[0], 'series', 0 );
			$league = get_field_string_number( $data[0], 'league', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 's='.$series.'&l='.$league.'&m='.$match;
			}
		} else {
			$sql = 'select `dantai_tournament`.`series` as `series`,'
				. ' `dantai_tournament_match`.`tournament` as `tournament`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_tournament_match`.`match` as `match`'
				. ' from `dantai_tournament` join `dantai_tournament_match`'
					. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
					. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_tournament`.`series`='.$series
					. ' and `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
			$data = db_query_list( $dbs, $sql );
//echo $sql,"\n";
//print_r($data);
			if( count( $data ) > 0 ){
				$series = get_field_string_number( $data[0], 'series', 0 );
				$tournament = get_field_string_number( $data[0], 'tournament', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['next'] = 's='.$series.'&t='.$tournament.'&m='.$match;
				}
			}
		}
		db_close( $dbs );
		return $list;
	}

	function get_dantai_tournament_match_navi__( $category, $league, $match )
	{
		$list = array();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_tournament`.`category` as `category`,'
			. ' `dantai_tournament_match`.`tournament` as `tournament`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`'
			. ' from `dantai_tournament` join `dantai_tournament_match`'
				. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
				. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament_match`.`match`='.$match;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($dantai_tournament_match);
		if( count( $dantai_tournament_match ) == 0 ){ return $list; }
		$place = get_field_string_number( $dantai_tournament_match[0], 'place', 0 );
		if( $place == 0 ){ return $list; }
		$place_match_no = get_field_string_number( $dantai_tournament_match[0], 'place_match_no', 0 );
		if( $place_match_no == 0 ){ return $list; }
		$category = get_field_string_number( $dantai_tournament_match[0], 'category', 0 );
		$tournament = get_field_string_number( $dantai_tournament_match[0], 'tournament', 0 );
//print_r($dantai_league_match);

		if( $category == 1 ){
			$list['category_name'] = '男子団体決勝トーナメント';
		} else {
			$list['category_name'] = '女子団体決勝トーナメント';
		}
		if( $place == 1 ){
			$list['place_name'] = '第一試合場';
		} else if( $place == 2 ){
			$list['place_name'] = '第ニ試合場';
		} else if( $place == 3 ){
			$list['place_name'] = '第三試合場';
		} else if( $place == 4 ){
			$list['place_name'] = '第四試合場';
		}
		$list['place_match_no'] = '第'.$place_match_no.'試合';

		$sql = 'select `dantai_tournament`.`category` as `category`,'
			. ' `dantai_tournament_match`.`tournament` as `tournament`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_tournament_match`.`match` as `match`'
			. ' from `dantai_tournament` join `dantai_tournament_match`'
				. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
				. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
		$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
		if( count( $data ) > 0 ){
			$category = get_field_string_number( $data[0], 'category', 0 );
			$tournament = get_field_string_number( $data[0], 'tournament', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['prev'] = 'dantai_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
			}
		} else {
			$sql = 'select `dantai_league`.`category` as `category`,'
				. ' `dantai_league_match`.`league` as `league`,'
				. ' `dantai_match`.`place` as `place`,'
				. ' `dantai_match`.`place_match_no` as `place_match_no`,'
				. ' `dantai_league_match`.`match` as `match`'
				. ' from `dantai_league` join `dantai_league_match`'
					. ' on `dantai_league`.`id`=`dantai_league_match`.`league`'
					. ' join `dantai_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
				. ' where `dantai_match`.`place`='.$place
					. ' and `dantai_match`.`place_match_no`='.($place_match_no-1);
			$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
			if( count($data) > 0 ){
				$category = get_field_string_number( $data[0], 'category', 0 );
				$league = get_field_string_number( $data[0], 'league', 0 );
				$match = get_field_string_number( $data[0], 'match', 0 );
				if( $match > 0 ){
					$list['prev'] = 'dantai_result.php?c='.$category.'&l='.$league.'&m='.$match;
				}
			}
		}

		$sql = 'select `dantai_tournament`.`category` as `category`,'
			. ' `dantai_tournament_match`.`tournament` as `tournament`,'
			. ' `dantai_match`.`place` as `place`,'
			. ' `dantai_match`.`place_match_no` as `place_match_no`,'
			. ' `dantai_tournament_match`.`match` as `match`'
			. ' from `dantai_tournament` join `dantai_tournament_match`'
				. ' on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament`'
				. ' join `dantai_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_match`.`place`='.$place
				. ' and `dantai_match`.`place_match_no`='.($place_match_no+1);
		$data = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($data);
		if( count( $data ) > 0 ){
			$category = get_field_string_number( $data[0], 'category', 0 );
			$tournament = get_field_string_number( $data[0], 'tournament', 0 );
			$match = get_field_string_number( $data[0], 'match', 0 );
			if( $match > 0 ){
				$list['next'] = 'dantai_result.php?c='.$category.'&t='.$tournament.'&m='.$match;
			}
		}
		db_close( $dbs );
		return $list;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------



	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_match_data_by_category( $category )
	{
	}

	function get_match_data_by_place( $place )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `match_info` where `del`=0 and `place`='.$place;
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	function get_match_one_data_by_place( $place, $no )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$data = db_get_one_data( $dbs, 'dantai_match', '*', '`del`=0 and `place`='.$place.' and `place_match_no`='.$no );
		db_close( $dbs );
		$data['entry1'] = $this->get_entry_one_data( intval($data['team1']) );
		$data['entry2'] = $this->get_entry_one_data( intval($data['team2']) );
		return $data;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function InitReg2PostData($category)
	{
		$_SESSION['p'] = array();
		$_SESSION['p']['id'] = 0;
		$_SESSION['p']['category'] = $category;
		$_SESSION['p']['pref'] = 0;
		$_SESSION['p']['name'] = '';
		$_SESSION['p']['address'] = '';
		$_SESSION['p']['tel'] = '';
		$_SESSION['p']['manager'] = '';
		$_SESSION['p']['referee'] = '';
		$_SESSION['p']['rank'] = '';
		$_SESSION['p']['refereeing_category'] = 0;
		$_SESSION['p']['captain'] = '';
		$_SESSION['p']['player1'] = '';
		$_SESSION['p']['player1_grade'] = '';
		$_SESSION['p']['player2'] = '';
		$_SESSION['p']['player2_grade'] = '';
		$_SESSION['p']['player3'] = '';
		$_SESSION['p']['player3_grade'] = '';
		$_SESSION['p']['player4'] = '';
		$_SESSION['p']['player4_grade'] = '';
		$_SESSION['p']['player5'] = '';
		$_SESSION['p']['player5_grade'] = '';
		$_SESSION['p']['introduction'] = '';
		$_SESSION['p']['main_results'] = '';
		$_SESSION['p']['transport'] = 0;
		$_SESSION['p']['transport_num'] = '';
		$_SESSION['p']['transport_other'] = '';
		$_SESSION['p']['lunch1'] = '';
		$_SESSION['p']['lunch2'] = '';
		$_SESSION['p']['comment'] = '';
		$_SESSION['p']['stay'] = 0;

		$_SESSION['e'] = array();
		$_SESSION['e']['id'] = 0;
		$_SESSION['e']['category'] = 0;
		$_SESSION['e']['pref'] = 0;
		$_SESSION['e']['name'] = '';
		$_SESSION['e']['address'] = '';
		$_SESSION['e']['tel'] = '';
		$_SESSION['e']['manager'] = '';
		$_SESSION['e']['referee'] = '';
		$_SESSION['e']['rank'] = '';
		$_SESSION['e']['refereeing_category'] = 0;
		$_SESSION['e']['captain'] = '';
		$_SESSION['e']['player1'] = '';
		$_SESSION['e']['player1_grade'] = '';
		$_SESSION['e']['player2'] = '';
		$_SESSION['e']['player2_grade'] = '';
		$_SESSION['e']['player3'] = '';
		$_SESSION['e']['player3_grade'] = '';
		$_SESSION['e']['player4'] = '';
		$_SESSION['e']['player4_grade'] = '';
		$_SESSION['e']['player5'] = '';
		$_SESSION['e']['player5_grade'] = '';
		$_SESSION['e']['introduction'] = '';
		$_SESSION['e']['main_results'] = '';
		$_SESSION['e']['transport'] = 0;
		$_SESSION['e']['transport_num'] = '';
		$_SESSION['e']['transport_other'] = '';
		$_SESSION['e']['lunch1'] = '';
		$_SESSION['e']['lunch2'] = '';
		$_SESSION['e']['comment'] = '';
		$_SESSION['e']['stay'] = 0;
	}

	function GetReg2FormPostData()
	{
	//	$_SESSION['p']['category'] = get_field_string( $_POST, 'category' );
		$_SESSION['p']['pref'] = get_field_string( $_POST, 'pref' );
		$_SESSION['p']['pref_name'] = $this->getPrefName( $_SESSION['p']['pref'] );
		$_SESSION['p']['name'] = get_field_string( $_POST, 'name' );
		$_SESSION['p']['address'] = get_field_string( $_POST, 'address' );
		$_SESSION['p']['tel'] = get_field_string( $_POST, 'tel' );
		$_SESSION['p']['manager'] = get_field_string( $_POST, 'manager' );
		$_SESSION['p']['referee'] = get_field_string( $_POST, 'referee' );
		$_SESSION['p']['rank'] = get_field_string( $_POST, 'rank' );
		$_SESSION['p']['refereeing_category'] = get_field_string_number( $_POST, 'refereeing_category', 0 );
		$_SESSION['p']['captain'] = get_field_string( $_POST, 'captain' );
		$_SESSION['p']['player1'] = get_field_string( $_POST, 'player1' );
		$_SESSION['p']['player1_grade'] = get_field_string( $_POST, 'player1_grade' );
		$_SESSION['p']['player2'] = get_field_string( $_POST, 'player2' );
		$_SESSION['p']['player2_grade'] = get_field_string( $_POST, 'player2_grade' );
		$_SESSION['p']['player3'] = get_field_string( $_POST, 'player3' );
		$_SESSION['p']['player3_grade'] = get_field_string( $_POST, 'player3_grade' );
		$_SESSION['p']['player4'] = get_field_string( $_POST, 'player4' );
		$_SESSION['p']['player4_grade'] = get_field_string( $_POST, 'player4_grade' );
		$_SESSION['p']['player5'] = get_field_string( $_POST, 'player5' );
		$_SESSION['p']['player5_grade'] = get_field_string( $_POST, 'player5_grade' );
		$_SESSION['p']['introduction'] = get_field_string( $_POST, 'introduction' );
		$_SESSION['p']['main_results'] = get_field_string( $_POST, 'main_results' );
		$_SESSION['p']['transport'] = get_field_string_number( $_POST, 'transport', 0 );
		$_SESSION['p']['transport_name'] = $this->getTransportName( $_SESSION['p']['transport'] );
		$_SESSION['p']['transport_num'] = get_field_string( $_POST, 'transport_num' );
		$_SESSION['p']['transport_other'] = get_field_string( $_POST, 'transport_other' );
		$_SESSION['p']['lunch1'] = get_field_string( $_POST, 'lunch1' );
		$_SESSION['p']['lunch2'] = get_field_string( $_POST, 'lunch2' );
		$_SESSION['p']['comment'] = get_field_string( $_POST, 'comment' );
		$_SESSION['p']['stay'] = get_field_string_number( $_POST, 'stay', 0 );
		$_SESSION['p']['stay_name'] = $this->getStayName( $_SESSION['p']['stay'] );

		$ret = 1;
/*
		if( $_SESSION['p']['pref'] == '' ){
			$_SESSION['e']['pref'] = '都道府県を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['name'] == '' ){
			$_SESSION['e']['name'] = '団体名を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['address'] == '' ){
			$_SESSION['e']['address'] = '住所を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['tel'] == '' ){
			$_SESSION['e']['tel'] = '電話番号を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['responsible'] == '' ){
			$_SESSION['e']['responsible'] = '記入責任者を入力して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['rensei'] == '' ){
			$_SESSION['e']['rensei'] = '錬成会参加を選択して下さい。';
			$err = 1;
		}
		if( $_SESSION['p']['stay'] == '' ){
			$_SESSION['e']['stay'] = '宿泊予定を選択して下さい。';
			$err = 1;
		}
*/
		return $ret;
	}

	function InsertReg2Data()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'insert into `reg02` set'
			. ' `category`=' . get_field_string_number( $_SESSION['p'], 'category', 0 ) . ","
			. " `pref`=" . get_field_string_number( $_SESSION['p'], 'pref', 0 ) . ","
			. " `name`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'name' ), $dbs ) . "',"
			. " `address`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'address' ), $dbs ) . "',"
			. " `tel`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'tel' ), $dbs ) . "',"
			. " `manager`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'manager' ), $dbs ) . "',"
			. " `referee`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'referee' ), $dbs ) . "',"
			. " `rank`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'rank' ), $dbs ) . "',"
			. " `refereeing_category`=" . get_field_string_number( $_SESSION['p'], 'refereeing_category', 0 ) . ","
			. " `captain`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'captain' ), $dbs ) . "',"
			. " `player1`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player1' ), $dbs ) . "',"
			. " `player1_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player1_grade' ), $dbs ) . "',"
			. " `player2`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player2' ), $dbs ) . "',"
			. " `player2_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player2_grade' ), $dbs ) . "',"
			. " `player3`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player3' ), $dbs ) . "',"
			. " `player3_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player3_grade' ), $dbs ) . "',"
			. " `player4`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player4' ), $dbs ) . "',"
			. " `player4_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player4_grade' ), $dbs ) . "',"
			. " `player5`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player5' ), $dbs ) . "',"
			. " `player5_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player5_grade' ), $dbs ) . "',"
			. " `introduction`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'introduction' ), $dbs ) . "',"
			. " `main_results`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'main_results' ), $dbs ) . "',"
			. " `transport`=" . get_field_string_number( $_SESSION['p'], 'transport', 0 ) . ","
			. " `transport_num`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'transport_num' ), $dbs ) . "',"
			. " `transport_other`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'transport_other' ), $dbs ) . "',"
			. " `lunch1`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'lunch1' ), $dbs ) . "',"
			. " `lunch2`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'lunch2' ), $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'comment' ), $dbs ) . "',"
			. " `stay`=" . get_field_string_number( $_SESSION['p'], 'stay', 0 ) . ","
			. " `create_date`=NOW(),"
			. ' `del`=0';
		db_query( $dbs, $sql );
		$newid = db_query_insert_id( $dbs );
		$sql = 'update `reg02` set `disp_order`='.$newid.' where `id`='.$newid;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function UpdateReg2Data()
	{
		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `reg02` set'
			. ' `category`=' . get_field_string_number( $_SESSION['p'], 'category', 0 ) . ","
			. " `pref`=" . get_field_string_number( $_SESSION['p'], 'pref', 0 ) . ","
			. " `name`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'name' ), $dbs ) . "',"
			. " `address`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'address' ), $dbs ) . "',"
			. " `tel`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'tel' ), $dbs ) . "',"
			. " `manager`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'manager' ), $dbs ) . "',"
			. " `referee`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'referee' ), $dbs ) . "',"
			. " `rank`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'rank' ), $dbs ) . "',"
			. " `refereeing_category`=" . get_field_string_number( $_SESSION['p'], 'refereeing_category', 0 ) . ","
			. " `captain`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'captain' ), $dbs ) . "',"
			. " `player1`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player1' ), $dbs ) . "',"
			. " `player1_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player1_grade' ), $dbs ) . "',"
			. " `player2`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player2' ), $dbs ) . "',"
			. " `player2_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player2_grade' ), $dbs ) . "',"
			. " `player3`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player3' ), $dbs ) . "',"
			. " `player3_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player3_grade' ), $dbs ) . "',"
			. " `player4`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player4' ), $dbs ) . "',"
			. " `player4_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player4_grade' ), $dbs ) . "',"
			. " `player5`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player5' ), $dbs ) . "',"
			. " `player5_grade`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'player5_grade' ), $dbs ) . "',"
			. " `introduction`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'introduction' ), $dbs ) . "',"
			. " `main_results`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'main_results' ), $dbs ) . "',"
			. " `transport`=" . get_field_string_number( $_SESSION['p'], 'transport', 0 ) . ","
			. " `transport_num`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'transport_num' ), $dbs ) . "',"
			. " `transport_other`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'transport_other' ), $dbs ) . "',"
			. " `lunch1`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'lunch1' ), $dbs ) . "',"
			. " `lunch2`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'lunch2' ), $dbs ) . "',"
			. " `comment`='" . mysql_real_escape_string( get_field_string( $_SESSION['p'], 'comment' ), $dbs ) . "',"
			. " `stay`=" . get_field_string_number( $_SESSION['p'], 'stay', 0 )
			. " where `id`=" . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function GetReg2DataList( $category )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `reg02` where `category`='.$category.' and `del`=0';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		return $list;
	}

	function GetReg2OneData( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'reg02', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function PreUploadImage( $field )
	{
		if( $_FILES[$field]['error'] == UPLOAD_ERR_OK ){ return false; }
		$tempPath = dirname(dirname(__FILE__)).'/temp/';
		$fname = sprintf( "%06d%012d", intval(microtime()*1000000), time() );
		move_uploaded_file( $_FILES[$field]['tmp_name'], $tempPath.$fname );
		return array(
			'temp' => $fname,
			'file' => $_FILES[$field]['name'],
			'exist' => file_exists( $tempPath.$_FILES[$field]['name'] )
		);
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function GetRegDataList( $category )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql1 = 'select `reg01`.`id` as `id1`,'
			.' `reg01`.`name` as `name1`,'
			.' `reg01`.`pref`,'
			.' `reg01`.`address`,'
			.' `reg01`.`tel`,'
			.' `reg02`.`id` as `id2`,'
			.' `reg02`.`name` as `name2`,'
			.' `reg02`.`pref` as `pref2`,'
			.' `reg02`.`address` as `address2`,'
			.' `reg02`.`tel` as `tel2`,'
			.' `reg02`.`manager`,'
			.' `reg02`.`captain`,'
			.' `reg02`.`player1`,'
			.' `reg02`.`player1_grade`,'
			.' `reg02`.`player2`,'
			.' `reg02`.`player2_grade`,'
			.' `reg02`.`player3`,'
			.' `reg02`.`player3_grade`,'
			.' `reg02`.`player4`,'
			.' `reg02`.`player4_grade`,'
			.' `reg02`.`player5`,'
			.' `reg02`.`player5_grade`,'
			.' `reg02`.`introduction`,'
			.' `reg02`.`main_results`';
		$sql2 = ' on `reg01`.`name`=`reg02`.`name` and `reg01`.`category`=`reg02`.`category`'
			.' where `reg01`.`category`='.$category.' and `reg01`.`del`=0';
		$sql3 = ' on `reg01`.`name`=`reg02`.`name` and `reg01`.`category`=`reg02`.`category`'
			.' where `reg02`.`category`='.$category.' and `reg02`.`del`=0';

/*
		$sql = $sql1 . ' from `reg01` inner join `reg02`' . $sql2 . ' order by `reg01`.`disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$sql = $sql1 . ' from `reg01` left join `reg02`' . $sql2;
		$list2 = db_query_list( $dbs, $sql );
		foreach( $list2 as $lv ){
			if( is_null($lv['id2']) ){
				$list[] = $lv;
			}
		}
		$sql = $sql1 . ' from `reg01` right join `reg02`' . $sql3 . ' order by `reg02`.`disp_order` asc';
		$list2 = db_query_list( $dbs, $sql );
		foreach( $list2 as $lv ){
			if( is_null($lv['id1']) ){
				$list[] = $lv;
			}
		}
*/
		$sql = $sql1 . ' from `reg01` right join `reg02`' . $sql3 . ' order by `reg02`.`disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$sql = $sql1 . ' from `reg01` left join `reg02`' . $sql2 . ' order by `reg02`.`disp_order` asc';
		$list2 = db_query_list( $dbs, $sql );
		foreach( $list2 as $lv ){
			if( is_null($lv['id2']) ){
				$list[] = $lv;
			}
		}
		db_close( $dbs );

		$ret = array();
		foreach( $list as &$lv ){
			if( !is_null($lv['id1']) ){
				$lv['reg1'] = 1;
				$lv['name'] = $lv['name1'];
			} else {
				$lv['reg1'] = 0;
			}
			if( !is_null($lv['id2']) ){
				$lv['reg2'] = 1;
				$lv['name'] = $lv['name2'];
			} else {
				$lv['reg2'] = 0;
			}
		}
		return $list;
	}
/*
	function GetRegDataList( $category )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `reg01`.`id` as `id1`,`reg01`.`name` as `name1`,'
			.' `reg02`.`id` as `id2`,`reg02`.`name` as `name2`'
			.' from `reg01` left join `reg02`'
			.' on `reg01`.`name`=`reg02`.`name` and `reg01`.`category`=`reg02`.`category`'
			.' where `reg01`.`category`='.$category.' and `reg01`.`del`=0'
			.' union'
			.' select `reg01`.`id` as `id1`,`reg01`.`name` as `name1`,'
			.' `reg02`.`id` as `id2`,`reg02`.`name` as `name2`'
			.' from `reg01` right join `reg02`'
			.' on `reg01`.`name`=`reg02`.`name` and `reg01`.`category`=`reg02`.`category`'
			.' where `reg02`.`category`='.$category.' and `reg02`.`del`=0';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );

		$ret = array();
		foreach( $list as &$lv ){
			if( !is_null($lv['id1']) ){
				$lv['reg1'] = 1;
				$lv['name'] = $lv['name1'];
			} else {
				$lv['reg1'] = 0;
			}
			if( !is_null($lv['id2']) ){
				$lv['reg2'] = 1;
				$lv['name'] = $lv['name2'];
			} else {
				$lv['reg2'] = 0;
			}
		}
		return $list;
	}
*/
	function GetOneData( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'information', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	function GetDispData( $data )
	{
		$pos = get_field_string_number( $data, 'image_pos', 0 );
		$image1 = get_field_string( $data, 'image1' );
		$image1w = get_field_string_number( $data, 'image1w', 0 );
		$image1h = get_field_string_number( $data, 'image1h', 0 );
		$width1 = '';
		$height1 = '';
		if( $image1 != '' && $image1w != 0 && $image1h != 0 ){
			if( $image1w > 212 ){
				$width1 = 'width: 212px;';
				$height1 = 'height: ' . intval($image1h*212/$image1w) . 'px;';
			} else {
				$width1 = 'width: ' . $image1w . 'px;';
				$height1 = 'height: ' . $image1h . 'px;';
			}
		}
		$image2 = get_field_string( $data, 'image2' );
		$image2w = get_field_string_number( $data, 'image2w', 0 );
		$image2h = get_field_string_number( $data, 'image2h', 0 );
		$width2 = '';
		$height2 = '';
		if( $image2 != '' && $image2w != 0 && $image2h != 0 ){
			if( $image2w > 212 ){
				$width2 = 'width: 212px;';
				$height2 = 'height: ' . intval($image2h*212/$image2w) . 'px;';
			} else {
				$width2 = 'width: ' . $image2w . 'px;';
				$height2 = 'height: ' . $image2h . 'px;';
			}
		}
		$disp = '';
		if( $pos == 3 && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></p>'."\n";
		} else if( $pos == 4 && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: right;" /></p>'."\n";
		} else if( ( $pos == 0 || $pos == 2 ) && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . '" /></p>'."\n";
		}
		if( $pos == 0 && $image2 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image2 . '" style="' . $width2 . ' ' . $height2 . '" /></p>'."\n";
		}
		$disp .= get_field_string( $data, 'comment' );
		if( $pos == 5 && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: left;" /></p>'."\n";
		} else if( $pos == 6 && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . ' float: right;" /></p>'."\n";
		} else if( $pos == 1 && $image1 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image1 . '" style="' . $width1 . ' ' . $height1 . '" /></p>'."\n";
		}
		if( ( $pos == 1 || $pos == 2 ) && $image2 != '' ){
			$disp .= '<p><img src="/infoimage/' . $image2 . '" style="' . $width2 . ' ' . $height2 . '" /></p>'."\n";
		}
		$disp .= '<div style="clear: both;"></div>'."\n";
		return $disp;
	}

	//---------------------------------------------------------------

	function GetTitle()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'config', '`data`', "`name`='information_title'" );
		db_close( $dbs );
		return get_field_string( $list, 'data' );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function InsertGalleryPhotoData( $p )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'insert into gellery_photo set'
			. " `title`='" . mysql_real_escape_string( get_field_string( $p, 'title' ), $dbs ) . "',"
			. " `org`='" . mysql_real_escape_string( get_field_string( $p, 'org' ), $dbs ) . "',"
			. " `org_w`=" . get_field_string_number( $p, 'org_w', 0 ) . ","
			. " `org_h`=" . get_field_string_number( $p, 'org_h', 0 ) . ","
			. " `image`='" . mysql_real_escape_string( get_field_string( $p, 'image' ), $dbs ) . "',"
			. " `image_w`=" . get_field_string_number( $p, 'image_w', 0 ) . ","
			. " `image_h`=" . get_field_string_number( $p, 'image_h', 0 ) . ","
			. " `image_w2`=" . get_field_string_number( $p, 'image_w2', 0 ) . ","
			. " `image_h2`=" . get_field_string_number( $p, 'image_h2', 0 ) . ","
			. ' `create_date`=NOW()';
		db_query( $dbs, $sql );
		$id = db_query_insert_id( $dbs );
		db_close( $dbs );
		return $id;
	}

	function UpdateGalleryPhotoData( $id, $p )
	{
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update gellery_photo set'
			. " `title`='" . mysql_real_escape_string( get_field_string( $p, 'title' ), $dbs ) . "',"
			. " `org`='" . mysql_real_escape_string( get_field_string( $p, 'org' ), $dbs ) . "',"
			. " `org_w`=" . get_field_string_number( $p, 'org_w', 0 ) . ","
			. " `org_h`=" . get_field_string_number( $p, 'org_h', 0 ) . ","
			. " `image`='" . mysql_real_escape_string( get_field_string( $p, 'image' ), $dbs ) . "',"
			. " `image_w`=" . get_field_string_number( $p, 'image_w', 0 ) . ","
			. " `image_h`=" . get_field_string_number( $p, 'image_h', 0 ) . ","
			. " `image_w2`=" . get_field_string_number( $p, 'image_w2', 0 ) . ","
			. " `image_h2`=" . get_field_string_number( $p, 'image_h2', 0 )
			. " where `id`=" . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function UpdateGalleryPhotoSlideShow( $id, $slideshow )
	{
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update gellery_photo set `slideshow`=' . $slideshow . ' where `id`=' . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function DeleteGalleryPhotoData( $id )
	{
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update gellery_photo set `del`=1 where `id`=' . $id;
		db_query( $dbs, $sql );
		$list = db_get_one_data( $dbs, 'gellery_photo', '*', '`id`='.$id );
		db_close( $dbs );
		$img = get_field_string( $list, 'org' );
		if( $img !== '' ){
			$file = dirname(dirname(__FILE__)).'/temp/'.$img.'.jpg';
			if( file_exists( $file ) ){ unlink( $file ); }
		}
		$img = get_field_string( $list, 'image' );
		if( $img !== '' ){
			$file = $this->configs['galleryimage_path'].'/'.$img.'.jpg';
			if( file_exists( $file ) ){ unlink( $file ); }
			$file = $this->configs['galleryimage_path'].'/t/'.$img.'s.jpg';
			if( file_exists( $file ) ){ unlink( $file ); }
		}
	}

	function GetGalleryPhotoDataListNum()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select count(*) as num from `gellery_photo` where `del`<>1';
		$list = db_query_list( $dbs, $sql );
		db_close( $dbs );
		if( count( $list ) == 0 ){ return 0; }
		return get_field_string_number( $list[0], 'num', 0 );
	}

	function GetGalleryPhotoDataList( $limit, $page )
	{
		$list = array();
		if( $page >= 1 ){
			$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
			$list = db_get_data_list( $dbs, 'gellery_photo', '*', '`del`<>1', $limit, $limit*($page-1), 'id asc' );
			db_close( $dbs );
		}
		return $list;
	}

	function GetOneGalleryPhotoData( $id )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'gellery_photo', '*', '`id`='.$id );
		db_close( $dbs );
		return $list;
	}

	function GetGalleryPhotoTitleList()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_data_list( $dbs, 'gellery_photo', '*', 'del=0', $limit, $page, 'id asc' );
		db_close( $dbs );
		$n = array();
		foreach( $list as $lv ){
			$n[$lv['id']] = $lv['title'];
		}
		return $n;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function GetGalleryDataList()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `gellery`.`id`,`gellery`.`photo_id`,'
		.'`gellery_photo`.`image`,`gellery_photo`.`image_w`,`gellery_photo`.`image_h`'
			.' from `gellery` join `gellery_photo`'
				.' on `gellery`.`photo_id` = `gellery_photo`.`id`'
			.' order by `gellery`.`id` asc ';
		$list = db_query_list( $dbs, $sql );
		return $list;
	}

	function SetGalleryData( $id, $photo )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `gellery` set `photo_id`='.$photo.' where `id`='.$id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	//---------------------------------------------------------------

	function SetGalleryTitle()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update config set'
			. " `data`='" . mysql_real_escape_string( $_SESSION['title'], $dbs ) . "'"
			. " where `name`='gallery_title'";
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function GetGalleryTitle()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$list = db_get_one_data( $dbs, 'config', '`data`', "`name`='gallery_title'" );
		db_close( $dbs );
		return get_field_string( $list, 'data' );
	}

	//---------------------------------------------------------------

	function get_match_status( $data )
	{
		$result1 = 0;
		$result1str = '';
		$result2 = 0;
		$result2str = '';
		$match_end = 0;
		if( $data['fusen'] == 1 ){
			if( $data['winner'] == 1 ){
				$result1 = 1;
				$result1str = '不戦勝';
			} else if( $data['winner'] == 2 ){
				$result2 = 1;
				$result2str = '不戦勝';
			}
			$match_end = 1;
		} else {
			$win1 = array();
			$win1str = array();
			$win1sum = 0;
			$hon1 = array();
			$hon1sum = 0;
			$win2 = array();
			$win2str = array();
			$win2sum = 0;
			$hon2 = array();
			$hon2sum = 0;
			$endnum = 0;
			$win = array();
			$winner = 0;
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$win1[$i1] = 0;
				$win1str[$i1] = '';
				$hon1[$i1] = 0;
				$win2[$i1] = 0;
				$win2str[$i1] = '';
				$hon2[$i1] = 0;
				$win[$i1] = 0;
				if( $i1 == 6 ){
					if( $endnum == 5 ){
						if( $win1sum > $win2sum ){
							$result1 = 1;
							$result1str = '○';
							$result2 = 0;
							$result2str = '△';
							$winner = 1;
							break;
						} else if( $win1sum < $win2sum ){
							$result1 = 0;
							$result1str = '△';
							$result2 = 1;
							$result2str = '○';
							$winner = 2;
							break;
						} else {
							if( $hon1sum > $hon2sum ){
								$result1 = 1;
								$result1str = '○';
								$result2 = 0;
								$result2str = '△';
								$winner = 1;
								break;
							} else if( $hon1sum < $hon2sum ){
								$result1 = 0;
								$result1str = '△';
								$result2 = 1;
								$result2str = '○';
								$winner = 2;
								break;
							} else {
							//	if( $p['r-ab6'] == 0 ){
							//		$result1 = 0;
							//		$result1str = '□';
							//		$result2 = 0;
							//		$result2str = '□';
							//		$winner = 0;
							//		break;
							//	}
							}
						}
					}
				}
				if( $data['matches'][$i1]['end_match'] == 1 && $i1 <= 5 ){
					$endnum++;
					for( $i2 = 1; $i2 <= 3; $i2++ ){
						if( $data['matches'][$i1]['waza1_'.$i2] != 0 ){
							$hon1[$i1]++;
						}
						if( $data['matches'][$i1]['waza2_'.$i2] != 0 ){
							$hon2[$i1]++;
						}
					}
					$hon1sum += $hon1[$i1];
					$hon2sum += $hon2[$i1];
					if( $hon1[$i1] > $hon2[$i1] ){
						$win1[$i1] = 1;
						$win1str[$i1] = '○';
						$win2str[$i1] = '△';
						$win[$i1] = 1;
						$win1sum++;
					} else if( $hon1[$i1] < $hon2[$i1] ){
						$win2[$i1] = 1;
						$win1str[$i1] = '△';
						$win2str[$i1] = '○';
						$win[$i1] = 2;
						$win2sum++;
					} else {
						$win1str[$i1] = '□';
						$win2str[$i1] = '□';
						$win[$i1] = 0;
					}
				}
				if( $i1 == 6 ){
					if( $data['exist_match6'] == 1 && $endnum == 5 ){
						if( $data['matches'][6]['waza1_1'] != 0 ){
							$result1 = 1;
							$result1str = '○';
							$result2 = 0;
							$result2str = '△';
							$winner = 1;
						} else if( $data['matches'][6]['waza2_1'] != 0 ){
							$result1 = 0;
							$result1str = '△';
							$result2 = 1;
							$result2str = '○';
							$winner = 2;
						} else {
							$result1 = 0;
							$result1str = '□';
							$result2 = 0;
							$result2str = '□';
							$winner = 0;
						}
					}
				}
			}
		}
		$r = array(
			'result1' => $result1,
			'result1str' => $result1str,
			'result2' => $result2,
			'result2str' => $result2str,
			'match_end' => $match_end,
			'winner' => $winner,
			'win1sum' => $win1sum,
			'hon1sum' => $hon1sum,
			'win2sum' => $win2sum,
			'hon2sum' => $hon2sum
		);
		return $r;
	}

	function output_league_match_for_HTML( $match )
	{
		$data = $this->get_dantai_league_one_result( $match );
		return $this->__output_match_for_HTML( $data );
	}

	function output_tournament_match_for_HTML( $match )
	{
		$data = $this->get_dantai_tournament_one_result( $match );
		return $this->__output_match_for_HTML( $data );
	}

	function __output_match_for_HTML( $data )
	{
//print_r($data);
		if( $data['tournament'] == 1 ){
			$series_mw = 'm';
		} else {
			$series_mw = 'w';
		}
		$result1 = 0;
		$result1str = '';
		$result2 = 0;
		$result2str = '';
		$match_end = 0;
		if( $data['fusen'] == 1 ){
			if( $data['winner'] == 1 ){
				$result1 = 1;
				$result1str = '不戦勝';
			} else if( $data['winner'] == 2 ){
				$result2 = 1;
				$result2str = '不戦勝';
			}
			$match_end = 1;
		} else {
			$win1 = array();
			$win1str = array();
			$win1sum = 0;
			$hon1 = array();
			$hon1sum = 0;
			$win2 = array();
			$win2str = array();
			$win2sum = 0;
			$hon2 = array();
			$hon2sum = 0;
			$endnum = 0;
			$win = array();
			$winner = 0;
			for( $i1 = 1; $i1 <= 6; $i1++ ){
				$win1[$i1] = 0;
				$win1str[$i1] = '';
				$hon1[$i1] = 0;
				$win2[$i1] = 0;
				$win2str[$i1] = '';
				$hon2[$i1] = 0;
				$win[$i1] = 0;
				if( $i1 == 6 ){
					if( $endnum == 5 ){
						if( $win1sum > $win2sum ){
							$result1 = 1;
							$result1str = '○';
							$result2 = 0;
							$result2str = '△';
							$winner = 1;
							break;
						} else if( $win1sum < $win2sum ){
							$result1 = 0;
							$result1str = '△';
							$result2 = 1;
							$result2str = '○';
							$winner = 2;
							break;
						} else {
							if( $hon1sum > $hon2sum ){
								$result1 = 1;
								$result1str = '○';
								$result2 = 0;
								$result2str = '△';
								$winner = 1;
								break;
							} else if( $hon1sum < $hon2sum ){
								$result1 = 0;
								$result1str = '△';
								$result2 = 1;
								$result2str = '○';
								$winner = 2;
								break;
							} else {
							//	if( $p['r-ab6'] == 0 ){
							//		$result1 = 0;
							//		$result1str = '□';
							//		$result2 = 0;
							//		$result2str = '□';
							//		$winner = 0;
							//		break;
							//	}
							}
						}
					}
				}
				if( $data['matches'][$i1]['end_match'] == 1 && $i1 <= 5 ){
					$endnum++;
					for( $i2 = 1; $i2 <= 3; $i2++ ){
						if( $data['matches'][$i1]['waza1_'.$i2] != 0 ){
							$hon1[$i1]++;
						}
						if( $data['matches'][$i1]['waza2_'.$i2] != 0 ){
							$hon2[$i1]++;
						}
					}
					$hon1sum += $hon1[$i1];
					$hon2sum += $hon2[$i1];
					if( $hon1[$i1] > $hon2[$i1] ){
						$win1[$i1] = 1;
						$win1str[$i1] = '○';
						$win2str[$i1] = '△';
						$win[$i1] = 1;
						$win1sum++;
					} else if( $hon1[$i1] < $hon2[$i1] ){
						$win2[$i1] = 1;
						$win1str[$i1] = '△';
						$win2str[$i1] = '○';
						$win[$i1] = 2;
						$win2sum++;
					} else {
						$win1str[$i1] = '□';
						$win2str[$i1] = '□';
						$win[$i1] = 0;
					}
				}
				if( $i1 == 6 ){
					if( $data['exist_match6'] == 1 && $endnum == 5 ){
						if( $data['matches'][6]['waza1_1'] != 0 ){
							$result1 = 1;
							$result1str = '○';
							$result2 = 0;
							$result2str = '△';
							$winner = 1;
						} else if( $data['matches'][6]['waza2_1'] != 0 ){
							$result1 = 0;
							$result1str = '△';
							$result2 = 1;
							$result2str = '○';
							$winner = 2;
						} else {
							$result1 = 0;
							$result1str = '□';
							$result2 = 0;
							$result2str = '□';
							$winner = 0;
						}
					}
				}
			}
		}
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$html .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$html .= '<head>'."\n";
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$html .= '<title>試合結果</title>'."\n";
		$html .= '<link href="result02.css" rel="stylesheet" type="text/css" />'."\n";
		$html .= '</head>'."\n";
		$html .= '<body>'."\n";
		$html .= '    <div align="center"">'."\n";
		$html .= '      <table class="tb_score_1" width="960" border="0">'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbnamecolor">学校名</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">先鋒</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">次鋒</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">中堅</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">副将</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">大将</td>'."\n";
		$html .= '          <td  class="tbname01">&nbsp;</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor">代表戦</td>'."\n";
		$html .= '          <td  class="tbname01">勝敗</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbnamecolor">' . $this->get_pref_name(null,get_field_string($data['entry1'],'school_address_pref',0)) . '</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbnamecolor2">'.$win1str[$i1].'</td>'."\n";
		}
		$html .= '          <td  class="tbname01">本数</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor2">'.$win1str[6].'</td>'."\n";
		$html .= '          <td rowspan="4"  class="tbname01">'.$result1str.'</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" rowspan="3" class="tbnamecolor">'."\n";
		$html .= '            '.get_field_string($data['entry1'],'school_name')."\n";
		$html .= '          </td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbname01">';
			if( $data['matches'][$i1]['player1'] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][$i1]['player1'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player1'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player1'] == 10 ){
				$html .= '補員5';
			} else {
				$html .= $data['matches'][$i1]['player1_name'];
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td  class="tbname01">'.$hon1sum.'</td>'."\n";
		$html .= '          <td colspan="3" class="tbname01">'."\n";
		if( $data['matches'][6]['player1'] == 0 ){
			$html .= '---';
		} else if( $data['matches'][6]['player1'] == 8 ){
			$html .= '補員3';
		} else if( $data['matches'][6]['player1'] == 9 ){
			$html .= '補員4';
		} else if( $data['matches'][6]['player1'] == 10 ){
			$html .= '補員5';
		} else {
			$html .= $data['matches'][6]['player1_name'];
		}
		$html .= '          </td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbname01">';
			if( $data['matches'][$i1]['faul1_1'] == 2 ){
				$html .= '指';
			}
			if( $data['matches'][$i1]['faul1_2'] == 1 ){
				$html .= '▲';
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td  class="tbname01">勝数</td>'."\n";
		$html .= '          <td colspan="3" class="tbname01">';
		if( $data['matches'][6]['faul1_1'] == 2 ){
			$html .= '指';
		}
		if( $data['matches'][6]['faul1_2'] == 1 ){
			$html .= '▲';
		}
		$html .= '</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				$html .= '          <td class="tbname01">';
				if( $data['matches'][$i1]['waza1_'.$i2] == 0 ){
					$html .= '&nbsp;';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 1 ){
					$html .= 'メ';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 2 ){
					$html .= 'ド';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 3 ){
					$html .= 'コ';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 4 ){
					$html .= '反';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
					$html .= '不戦勝';
				}
				$html .= '</td>'."\n";
			}
		}
		$html .= '          <td class="tbname01">'.$win1sum.'</td>'."\n";
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			$html .= '          <td class="tbname01">';
			if( $data['matches'][6]['waza1_'.$i2] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][6]['waza1_'.$i2] == 1 ){
				$html .= 'メ';
			} else if( $data['matches'][6]['waza1_'.$i2] == 2 ){
				$html .= 'ド';
			} else if( $data['matches'][6]['waza1_'.$i2] == 3 ){
				$html .= 'コ';
			} else if( $data['matches'][6]['waza1_'.$i2] == 4 ){
				$html .= '反';
			} else if( $data['matches'][6]['waza1_'.$i2] == 5 ){
				$html .= '不戦勝';
			}
			$html .= '</td>'."\n";
		}
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbnamecolor">&nbsp;</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbname01">';
			if( $data['matches'][$i1]['extra'] == 1 ){
				$html .= '延';
			} else {
				$html .= '&nbsp;';
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td  class="tbname01">&nbsp;</td>'."\n";
		$html .= '          <td colspan="3" class="tbname01">';
		if( $data['matches'][6]['extra'] == 1 ){
			$html .= '延';
		} else {
			$html .= '&nbsp;';
		}
		$html .= '</td>'."\n";
		$html .= '          <td class="tbname01">&nbsp;</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbnamecolor">'.$this->get_pref_name(null,get_field_string_number($data['entry2'],'school_address_pref',0)).'</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				$html .= '          <td class="tbname01">';
				if( $data['matches'][$i1]['waza2_'.$i2] == 0 ){
					$html .= '&nbsp;';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 1 ){
					$html .= 'メ';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 2 ){
					$html .= 'ド';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 3 ){
					$html .= 'コ';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 4 ){
					$html .= '反';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 5 ){
					$html .= '不戦勝';
				}
				$html .= '</td>'."\n";
			}
		}
		$html .= '          <td  class="tbname01">本数</td>'."\n";
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			$html .= '          <td class="tbname01">';
			if( $data['matches'][6]['waza2_'.$i2] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][6]['waza2_'.$i2] == 1 ){
				$html .= 'メ';
			} else if( $data['matches'][6]['waza2_'.$i2] == 2 ){
				$html .= 'ド';
			} else if( $data['matches'][6]['waza2_'.$i2] == 3 ){
				$html .= 'コ';
			} else if( $data['matches'][6]['waza2_'.$i2] == 4 ){
				$html .= '反';
			} else if( $data['matches'][6]['waza2_'.$i2] == 5 ){
				$html .= '不戦勝';
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td rowspan="4" class="tbname01">'.$result2str.'</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" rowspan="3" class="tbnamecolor">'.get_field_string($data['entry2'],'school_name').'</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbname01">';
			if( $data['matches'][$i1]['faul2_1'] == 2 ){
				$html .= '指';
			}
			if( $data['matches'][$i1]['faul2_2'] == 1 ){
				$html .= '▲';
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td  class="tbname01">'.$hon2sum.'</td>'."\n";
		$html .= '          <td colspan="3" class="tbname01">';
		if( $data['matches'][6]['faul2_1'] == 2 ){
			$html .= '指';
		}
		if( $data['matches'][6]['faul2_2'] == 1 ){
			$html .= '▲';
		}
		$html .= '</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbname01">';
			if( $data['matches'][$i1]['player2'] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][$i1]['player2'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player2'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player2'] == 10 ){
				$html .= '補員5';
			} else {
				$html .= $data['matches'][$i1]['player2_name'];
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td class="tbname01">勝数</td>'."\n";
		$html .= '          <td colspan="3" class="tbname01">'."\n";
		if( $data['matches'][6]['player2'] == 0 ){
			$html .= '&nbsp;';
		} else if( $data['matches'][6]['player2'] == 8 ){
			$html .= '補員3';
		} else if( $data['matches'][6]['player2'] == 9 ){
			$html .= '補員4';
		} else if( $data['matches'][6]['player2'] == 10 ){
			$html .= '補員5';
		} else {
			$html .= $data['matches'][6]['player2_name'];
		}
		$html .= '          </td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td colspan="3" class="tbnamecolor2">'.$win2str[$i1].'</td>'."\n";
		}
		$html .= '          <td  class="tbname01">'.$win2sum.'</td>'."\n";
		$html .= '          <td colspan="3" class="tbnamecolor2">'.$win2str[6].'</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '      </table>'."\n";
		$html .= '  </div>'."\n";
		$html .= '</body>'."\n";
		$html .= '</html>'."\n";

/*
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$html .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$html .= '<head>'."\n";
		$html .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$html .= '<title>試合結果</title>'."\n";
		$html .= '<link href="main.css" rel="stylesheet" type="text/css" />'."\n";
		$html .= '</head>'."\n";



		$html .= '<body>'."\n";

		$html .= '<div class="container">'."\n";
		$html .= '  <div class="content">'."\n";
		$html .= '    <div align="right">'."\n";
		$html .= '    </div>'."\n";
		$html .= '    <div align="center" class="tbscorein">'."\n";
		$html .= '      <table class="tb_score_in" width="960" border="1">'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbprefname">学校名</td>'."\n";
		$html .= '          <td class="tbprefname"><span class="tb_srect">先鋒</span></td>'."\n";
		$html .= '          <td class="tbprefname"><span class="tb_srect">次鋒</span></td>'."\n";
		$html .= '          <td class="tbprefname"><span class="tb_srect">中堅</span></td>'."\n";
		$html .= '          <td class="tbprefname"><span class="tb_srect">副将</span></td>'."\n";
		$html .= '          <td class="tbprefname"><span class="tb_srect">大将</span></td>'."\n";
		$html .= '          <td class="tbprefnamehalf">代表戦</td>'."\n";
		$html .= '          <td class="tbprefnamehalf">&nbsp;</td>'."\n";
		$html .= '          <td class="tbprefnamehalf">勝敗</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbprefname">' . $this->get_pref_name(null,get_field_string($data['entry1'],'school_address_pref',0)) . '</td>' . "\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tbprefname">'.$win1str[$i1].'</td>'."\n";
		}
		$html .= '          <td>&nbsp;</td>'."\n";
		$html .= '          <td><div align="center">本数</div></td>'."\n";
		$html .= '          <td rowspan="6" class="tx-large">'.$result1str.'</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" rowspan="5" class="tbprefname">'."\n";
		$html .= '            '.get_field_string($data['entry1'],'school_name').'<br />'."\n";
		$html .= '          </td>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect">';
			if( $data['matches'][$i1]['player1'] == 0 ){
				$html .= '---';
			} else if( $data['matches'][$i1]['player1'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player1'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player1'] == 10 ){
				$html .= '補員5';
			} else {
				$html .= $data['matches'][$i1]['player1_name'];
			}
			$html .= '</td>'."\n";
		}
		$html .= '          <td rowspan="2"><div align="center">'.$hon1sum.'</div></td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if( $data['matches'][$i1]['faul1_1'] == 0 ){
				$html .= '-';
			} else if( $data['matches'][$i1]['faul1_1'] == 2 ){
				$html .= '指';
			}
			$html .= '<br />'."\n";
			if( $data['matches'][$i1]['faul1_2'] == 0 ){
				$html .= '            -'."\n";
			} else if( $data['matches'][$i1]['faul1_2'] == 1 ){
				$html .= '            ▲'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect"';
			if( $i1 == 6 ){ $html .= 'rowspan="3"'; }
			$html .= '>'."\n";
			if( $data['matches'][$i1]['waza1_1'] == 0 ){
				$html .= '            -'."\n";
			} else if( $data['matches'][$i1]['waza1_1'] == 1 ){
				$html .= '            メ'."\n";
			} else if( $data['matches'][$i1]['waza1_1'] == 2 ){
				$html .= '            ド'."\n";
			} else if( $data['matches'][$i1]['waza1_1'] == 3 ){
				$html .= '            コ'."\n";
			} else if( $data['matches'][$i1]['waza1_1'] == 4 ){
				$html .= '            反'."\n";
			} else if( $data['matches'][$i1]['waza1_1'] == 5 ){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '          <td>'."\n";
		$html .= '          <div align="center">勝数</div>'."\n";
		$html .= '          </td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if($data['matches'][$i1]['waza1_2']==0){
				$html .= '            -'."\n";
			} else if($data['matches'][$i1]['waza1_2']==1){
				$html .= '            メ'."\n";
			} else if($data['matches'][$i1]['waza1_2']==2){
				$html .= '            ド'."\n";
			} else if($data['matches'][$i1]['waza1_2']==3){
				$html .= '            コ'."\n";
			} else if($data['matches'][$i1]['waza1_2']==4){
				$html .= '            反'."\n";
			} else if($data['matches'][$i1]['waza1_2']==5){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '          <td rowspan="2"><div align="center">'.$win1sum.'</div>'."\n";
		$html .= '          </td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if($data['matches'][$i1]['waza1_3']==0){
				$html .= '            -'."\n";
			} else if($data['matches'][$i1]['waza1_3']==1){
				$html .= '            メ'."\n";
			} else if($data['matches'][$i1]['waza1_3']==2){
				$html .= '            ド'."\n";
			} else if($data['matches'][$i1]['waza1_3']==3){
				$html .= '            コ'."\n";
			} else if($data['matches'][$i1]['waza1_3']==4){
				$html .= '            反'."\n";
			} else if($data['matches'][$i1]['waza1_3']==5){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" class="tbprefname">'.$this->get_pref_name(null,get_field_string_number($data['entry2'],'school_address_pref',0)).'</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tbprefname">'.$win2str[$i1].'</td>'."\n";
		}
		$html .= '          <td>'."\n";
		$html .= '          </td>'."\n";
		$html .= '          <td><div align="center">本数</div></td>'."\n";
		$html .= '          <td>&nbsp;</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		$html .= '          <td colspan="2" rowspan="5" class="tbprefnamehalf"><span class="tbprefname">'.get_field_string($data['entry2'],'school_name').'</span>'."\n";
		$html .= '          </td>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			$html .= '            ';
			if( $data['matches'][$i1]['player2'] == 0 ){
				$html .= '---';
			} else if( $data['matches'][$i1]['player2'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player2'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player2'] == 10 ){
				$html .= '補員5';
			} else {
				$html .= $data['matches'][$i1]['player2_name'];
			}
			$html .= '          </td>'."\n";
		}
		$html .= '          <td rowspan="2"><div align="center">'.$hon2sum.'</div></td>'."\n";
		$html .= '          <td rowspan="5" class="tx-large">'.$result2str.'</td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if( $data['matches'][$i1]['faul2_1'] == 0 ){
				$html .= '            -';
			} else if( $data['matches'][$i1]['faul2_1'] == 2 ){
				$html .= '            指';
			}
			$html .= '            <br />'."\n";
			if( $data['matches'][$i1]['faul2_2'] == 0 ){
				$html .= '            -';
			} else if( $data['matches'][$i1]['faul2_2'] == 1 ){
				$html .= '            ▲';
			}
			$html .= '          </td>'."\n";
		}
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 6; $i1++ ){
			$html .= '          <td class="tb_srect"';
			if( $i1 == 6 ){ $html .= ' rowspan="3"'; }
			$html .= '>'."\n";
			if($data['matches'][$i1]['waza2_1']==0){
				$html .= '            -'."\n";
			} else if($data['matches'][$i1]['waza2_1']==1){
				$html .= '            メ'."\n";
			} else if($data['matches'][$i1]['waza2_1']==2){
				$html .= '            ド'."\n";
			} else if($data['matches'][$i1]['waza2_1']==3){
				$html .= '            コ'."\n";
			} else if($data['matches'][$i1]['waza2_1']==4){
				$html .= '            反'."\n";
			} else if($data['matches'][$i1]['waza2_1']==5){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '          <td><div align="center">勝数</div></td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if($data['matches'][$i1]['waza2_2']==0){
				$html .= '            -'."\n";
			} else if($data['matches'][$i1]['waza2_2']==1){
				$html .= '            メ'."\n";
			} else if($data['matches'][$i1]['waza2_2']==2){
				$html .= '            ド'."\n";
			} else if($data['matches'][$i1]['waza2_2']==3){
				$html .= '            コ'."\n";
			} else if($data['matches'][$i1]['waza2_2']==4){
				$html .= '            反'."\n";
			} else if($data['matches'][$i1]['waza2_2']==5){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '          <td rowspan="2"><div align="center">'.$win2sum.'</div></td>'."\n";
		$html .= '        </tr>'."\n";
		$html .= '        <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '          <td class="tb_srect">'."\n";
			if($data['matches'][$i1]['waza2_3']==0){
				$html .= '            -'."\n";
			} else if($data['matches'][$i1]['waza2_3']==1){
				$html .= '            メ'."\n";
			} else if($data['matches'][$i1]['waza2_3']==2){
				$html .= '            ド'."\n";
			} else if($data['matches'][$i1]['waza2_3']==3){
				$html .= '            コ'."\n";
			} else if($data['matches'][$i1]['waza2_3']==4){
				$html .= '            反'."\n";
			} else if($data['matches'][$i1]['waza2_3']==5){
				$html .= '            不戦勝'."\n";
			}
			$html .= '          </td>'."\n";
		}
		$html .= '        </tr>'."\n";
		$html .= '      </table>'."\n";
		$html .= '    <!-- end .content --></div>'."\n";
		$html .= '  </div>'."\n";
		$html .= '  <!-- end .container --></div>'."\n";
		$html .= '</body>'."\n";
		$html .= '</html>'."\n";
*/
		return $html;
	}


	function output_one_league_match_for_HTML2( $match )
	{
echo $match.':'.date("H:i:s"),"\n";
		$data = $this->get_dantai_league_one_result( $match );
		return $this->output_one_match_for_HTML2( $data );
	}

	function output_one_tournament_match_for_HTML2( $match )
	{
		$data = $this->get_dantai_tournament_one_result( $match );
		return $this->output_one_match_for_HTML2( $data );
	}

	function output_one_match_for_HTML2( $series_info, $data, $entry_list, $series_mw )
	{
//print_r($data);
//print_r($entry_list);
//exit;
        if( $data['match'] == 0 ){ return ''; }
		$team1_index = -1;
		$team2_index = -1;
		for( $i1 = 0; $i1 < count($entry_list); $i1++ ){
			if( $team1_index >= 0 && $team2_index >= 0 ){ break; }
			if( $data['team1'] == $entry_list[$i1]['id'] ){
				$team1_index = $i1;
			} else if( $data['team2'] == $entry_list[$i1]['id'] ){
				$team2_index = $i1;
			}
		}
		$end_match = 0;
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			if( $data['matches'][$i1]['end_match'] == 1 ){
				$end_match++;
			}
		}

		$html = '<table class="match_t" border="1" cellspacing="0" cellpadding="2">'."\n";
		$html .= '  <tr>'."\n";
		$html .= '    <td class="td_name">学校名</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">先鋒</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">次鋒</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">中堅</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">副将</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">大将</td>'."\n";
		$html .= '    <td class="td_score">対戦結果</td>'."\n";
		$html .= '    <td colspan="3" class="td_match">代表戦</td>'."\n";
		$html .= '  </tr>'."\n";
		$html .= '  <tr>'."\n";
		//$html .= '    <td rowspan="2" class="tbnamecolor">'.$entry_list[$team1_index]['school_name_ryaku'] . '<br />(' . $entry_list[$team1_index]['school_address_pref_name'] . ')</td>'."\n";
		$html .= '    <td rowspan="2" class="tbnamecolor">';
        if( $team1_index >= 0 ){ $html .= $entry_list[$team1_index]['school_name']; }
        $html .= '</td>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '    <td colspan="3" class="tbname01">';
			if( $team1_index == -1 || $data['matches'][$i1]['player1'] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][$i1]['player1'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player1'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player1'] == 10 ){
				$html .= '補員5';
   			} else if( $data['matches'][$i1]['player1'] == __PLAYER_NAME__ ){
   				$html .= $data['matches'][$i1]['player1_change_name'];
			} else {
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player'.$data['matches'][$i1]['player1'];
                } else {
                    if( $series_mw === '' ){
                        $f = 'player'.$data['matches'][$i1]['player1'];
                    } else {
                        if( $series_info['player_field_mode'] == 3 ){
            				$f = 'dantai_'.$series_mw.$data['matches'][$i1]['player1'];
                        } else {
         		            $f = 'player'.$data['matches'][$i1]['player1'].'_'.$series_mw;
                        }
                    }
                }
				if( isset($entry_list[$team1_index][$f.'_disp']) && $entry_list[$team1_index][$f.'_disp'] !== '' ){
					$html .= $entry_list[$team1_index][$f.'_disp'];
				} else {
					$html .= $entry_list[$team1_index][$f.'_sei'];
				}
			}
		}
		$html .= '    <td rowspan="2" class="tbname01">';
		if( $end_match == 5 ){
			$html .= '      <div class="tb_frame_result_content">'."\n";
			if( $data['winner'] == 1 ){
				$html .= '        <span class="result-circle"></span>'."\n";
			} else if( $data['winner']==2 ){
				$html .= '        <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
			} else {
				$html .= '        <span class="result-square"></span>'."\n";
			}
			$html .= '        <div class="tb_frame_result_hon">'.$data['hon1'].'</div>'."\n";
			$html .= '        <div class="tb_frame_result_win">'.$data['win1'].'</div>'."\n";
			$html .= '      </div>'."\n";
		} else {
			$html .= '&nbsp;';
		}
		$html .= '    </td>'."\n";
		$html .= '    <td colspan="3" class="tbname01">'."\n";
		if( $team1_index == -1 || $data['matches'][6]['player1'] == 0 ){
			$html .= '&nbsp;';
		} else if( $data['matches'][6]['player1'] == 8 ){
			$html .= '補員3';
		} else if( $data['matches'][6]['player1'] == 9 ){
			$html .= '補員4';
		} else if( $data['matches'][6]['player1'] == 10 ){
			$html .= '補員5';
    	} else if( $data['matches'][6]['player1'] == __PLAYER_NAME__ ){
   			$html .= $data['matches'][6]['player1_change_name'];
		} else {
            if( $series_info['player_field_mode'] == 1 ){
                $f = 'player'.$data['matches'][6]['player1'];
            } else {
                if( $series_mw === '' ){
                    $f = 'player'.$data['matches'][6]['player1'];
                } else {
                    if( $series_info['player_field_mode'] == 3 ){
    			        $f = 'dantai_'.$series_mw.$data['matches'][6]['player1'];
                    } else {
     			    	$f = 'player'.$data['matches'][6]['player1'].'_'.$series_mw;
                    }
                }
            }
			if( isset($entry_list[$team1_index][$f.'_disp']) && $entry_list[$team1_index][$f.'_disp'] !== '' ){
				$html .= $entry_list[$team1_index][$f.'_disp'];
			} else {
				$html .= $entry_list[$team1_index][$f.'_sei'];
			}
		}
		$html .= '    </td>'."\n";
		$html .= '  </tr>'."\n";
		$html .= '  <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				$html .= '    <td class="td_waza">';
				if( $data['matches'][$i1]['waza1_'.$i2] == 0 ){
					$html .= '&nbsp;';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 1 ){
					$html .= 'メ';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 2 ){
					$html .= 'ド';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 3 ){
					$html .= 'コ';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 4 ){
					$html .= '反';
				} else if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
					$html .= '不戦勝';
				}
				$html .= '</td>'."\n";
			}
		}
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			$html .= '    <td class="td_waza">';
			if( $data['matches'][6]['waza1_'.$i2] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][6]['waza1_'.$i2] == 1 ){
				$html .= 'メ';
			} else if( $data['matches'][6]['waza1_'.$i2] == 2 ){
				$html .= 'ド';
			} else if( $data['matches'][6]['waza1_'.$i2] == 3 ){
				$html .= 'コ';
			} else if( $data['matches'][6]['waza1_'.$i2] == 4 ){
				$html .= '反';
			} else if( $data['matches'][6]['waza1_'.$i2] == 5 ){
				$html .= '不戦勝';
			}
			$html .= '</td>'."\n";
		}
		$html .= '  </tr>'."\n";

		$html .= '  <tr>'."\n";
		//$html .= '    <td rowspan="2" class="tbnamecolor">'.$entry_list[$team2_index]['school_name_ryaku'] . '<br />(' . $entry_list[$team2_index]['school_address_pref_name'] . ')</td>'."\n";
		$html .= '    <td rowspan="2" class="tbnamecolor">';
        if( $team2_index >= 0 ){ $html .= $entry_list[$team2_index]['school_name']; }
		$html .= "</td>\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				$html .= '    <td class="td_waza">';
				if( $data['matches'][$i1]['waza2_'.$i2] == 0 ){
					$html .= '&nbsp;';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 1 ){
					$html .= 'メ';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 2 ){
					$html .= 'ド';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 3 ){
					$html .= 'コ';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 4 ){
					$html .= '反';
				} else if( $data['matches'][$i1]['waza2_'.$i2] == 5 ){
					$html .= '不戦勝';
				}
				$html .= '</td>'."\n";
			}
		}
		$html .= '    <td rowspan="2" class="tbname01">';
		if( $end_match == 5 ){
			$html .= '      <div class="tb_frame_result_content">'."\n";
			if( $data['winner'] == 2 ){
				$html .= '        <span class="result-circle"></span>'."\n";
			} else if( $data['winner'] == 1 ){
				$html .= '        <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
			} else {
				$html .= '        <span class="result-square"></span>'."\n";
			}
			$html .= '        <div class="tb_frame_result_hon">'.$data['hon2'].'</div>'."\n";
			$html .= '        <div class="tb_frame_result_win">'.$data['win2'].'</div>'."\n";
			$html .= '      </div>'."\n";
		} else {
			$html .= '&nbsp;';
		}
		$html .= '</td>'."\n";
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			$html .= '    <td class="td_waza">';
			if( $data['matches'][6]['waza2_'.$i2] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][6]['waza2_'.$i2] == 1 ){
				$html .= 'メ';
			} else if( $data['matches'][6]['waza2_'.$i2] == 2 ){
				$html .= 'ド';
			} else if( $data['matches'][6]['waza2_'.$i2] == 3 ){
				$html .= 'コ';
			} else if( $data['matches'][6]['waza2_'.$i2] == 4 ){
				$html .= '反';
			} else if( $data['matches'][6]['waza2_'.$i2] == 5 ){
				$html .= '不戦勝';
			}
			$html .= '</td>'."\n";
		}
		$html .= '  </tr>'."\n";
		$html .= '  <tr>'."\n";
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$html .= '    <td colspan="3" class="tbname01">';
			if( $team2_index == -1 || $data['matches'][$i1]['player2'] == 0 ){
				$html .= '&nbsp;';
			} else if( $data['matches'][$i1]['player2'] == 8 ){
				$html .= '補員3';
			} else if( $data['matches'][$i1]['player2'] == 9 ){
				$html .= '補員4';
			} else if( $data['matches'][$i1]['player2'] == 10 ){
				$html .= '補員5';
        	} else if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
   	    		$html .= $data['matches'][$i1]['player2_change_name'];
			} else {
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player'.$data['matches'][$i1]['player2'];
                } else {
                    if( $series_mw === '' ){
                        $f = 'player'.$data['matches'][$i1]['player2'];
                    } else {
                        if( $series_info['player_field_mode'] == 3 ){
    	    			    $f = 'dantai_'.$series_mw.$data['matches'][$i1]['player2'];
                        } else {
        			    	$f = 'player'.$data['matches'][$i1]['player2'].'_'.$series_mw;
                        }
                    }
                }
				if( isset( $entry_list[$team2_index][$f.'_disp'] ) && $entry_list[$team2_index][$f.'_disp'] !== '' ){
					$html .= $entry_list[$team2_index][$f.'_disp'];
				} else {
					$html .= $entry_list[$team2_index][$f.'_sei'];
				}
			}
		}
		//$html .= '    <td rowspan="2" class="tbname01">'.$hon1sum.'<br />'.$win1sum.'</td>'."\n";
		$html .= '    <td colspan="3" class="tbname01">'."\n";
		if( $team2_index == -1 || $data['matches'][6]['player2'] == 0 ){
			$html .= '&nbsp;';
		} else if( $data['matches'][6]['player2'] == 8 ){
			$html .= '補員3';
		} else if( $data['matches'][6]['player2'] == 9 ){
			$html .= '補員4';
		} else if( $data['matches'][6]['player2'] == 10 ){
			$html .= '補員5';
       	} else if( $data['matches'][6]['player2'] == __PLAYER_NAME__ ){
    		$html .= $data['matches'][6]['player2_change_name'];
		} else {
            if( $series_info['player_field_mode'] == 1 ){
                $f = 'player'.$data['matches'][6]['player2'];
            } else {
                if( $series_mw === '' ){
                    $f = 'player'.$data['matches'][6]['player2'];
                } else {
                    if( $series_info['player_field_mode'] == 3 ){
        			    $f = 'dantai_'.$series_mw.$data['matches'][6]['player2'];
                    } else {
     			        $f = 'player'.$data['matches'][6]['player2'].'_'.$series_mw;
                    }
                }
            }
			if( isset( $entry_list[$team2_index][$f.'_disp'] ) && $entry_list[$team2_index][$f.'_disp'] !== '' ){
				$html .= $entry_list[$team2_index][$f.'_disp'];
			} else {
				$html .= $entry_list[$team2_index][$f.'_sei'];
			}
		}
		$html .= '    </td>'."\n";
		$html .= '  </tr>'."\n";
		$html .= '</table>'."\n";

		return $html;
	}

	function output_one_match_for_excel( $sheet, $col, $row, $series_info, $data, $entry_list, $series_mw, $result_width, $result_hight )
	{
		$result_size = $result_hight - 4;
		$result_x = 0; //intval( $result_width - $result_size ) / 3;  //=8
		$result_y = 5;
		$result_colStr = $col + 16;

		$team1_index = -1;
		$team2_index = -1;
		for( $i1 = 0; $i1 < count($entry_list); $i1++ ){
			if( $team1_index >= 0 && $team2_index >= 0 ){ break; }
			if( $data['team1'] == $entry_list[$i1]['id'] ){
				$team1_index = $i1;
			} else if( $data['team2'] == $entry_list[$i1]['id'] ){
				$team2_index = $i1;
			}
		}
		$end_match = 0;
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			if( $data['matches'][$i1]['end_match'] == 1 ){
				$end_match++;
			}
		}

        if( $team1_index >= 0 ){
	    	if( isset($entry_list[$team1_index]['school_name_ryaku']) && $entry_list[$team1_index]['school_name_ryaku'] != '' ){
                $sheet->setCellValueByColumnAndRow( $col, $row, $entry_list[$team1_index]['school_name_ryaku'] );
            } else {
                $sheet->setCellValueByColumnAndRow( $col, $row, $entry_list[$team1_index]['school_name'] );
            }
	    	if( $entry_list[$team1_index]['school_address_pref_name'] != '' ){
		    	$sheet->setCellValueByColumnAndRow( $col, $row+1, '('.$entry_list[$team1_index]['school_address_pref_name'].')' );
    		}
	    	for( $i1 = 1; $i1 <= 5; $i1++ ){
		    	$player = '';
			    if( $data['matches'][$i1]['player1'] == 0 ){
				    $player = '';
    			} else if( $data['matches'][$i1]['player1'] == 8 ){
    				$player = '補員3';
    			} else if( $data['matches'][$i1]['player1'] == 9 ){
    				$player = '補員4';
    			} else if( $data['matches'][$i1]['player1'] == 10 ){
    				$player = '補員5';
    			} else if( $data['matches'][$i1]['player1'] == __PLAYER_NAME__ ){
    				$player = $data['matches'][$i1]['player1_change_name'];
    			} else {
                    if( $series_info['player_field_mode'] == 1 ){
                        $f = 'player'.$data['matches'][$i1]['player1'];
                    } else {
                        if( $series_mw === '' ){
                            $f = 'player'.$data['matches'][$i1]['player1'];
                        } else {
    		                $f = 'player'.$data['matches'][$i1]['player1'].'_'.$series_mw;
                        }
                    }
    				//$f = 'dantai_'.$series_mw.$data['matches'][$i1]['player1'];
    				if( $entry_list[$team1_index][$f.'_disp'] != '' ){
    					$player = $entry_list[$team1_index][$f.'_disp'];
    				} else {
    					$player = $entry_list[$team1_index][$f.'_sei'];
    				}
    			}
    			$sheet->setCellValueByColumnAndRow( $col+$i1*3-2, $row, $player );
    		}
    		if( $end_match == 5 || $data['fusen'] == 1 ){
    			if( $data['winner'] == 1 ){
    				$objDrawing = new PHPExcel_Worksheet_Drawing();
    				$objDrawing->setName('result_'.$data['match'].'_1');
    				$objDrawing->setDescription('result_'.$data['match'].'_1');
    				$objDrawing->setPath(dirname(__FILE__).'/cir.png');
    				$objDrawing->setWidth($result_size);
    				$objDrawing->setHeight($result_size);
    				$objDrawing->setWorksheet($sheet);
    				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row) );
    				$objDrawing->setOffsetX($result_x);
    				$objDrawing->setOffsetY($result_y);
    			} else if( $data['winner']==2 ){
    				$objDrawing = new PHPExcel_Worksheet_Drawing();
    				$objDrawing->setName('result_'.$data['match'].'_1');
    				$objDrawing->setDescription('result_'.$data['match'].'_1');
    				$objDrawing->setPath(dirname(__FILE__).'/tri.png');
    				$objDrawing->setWidth($result_size);
    				$objDrawing->setHeight($result_size);
    				$objDrawing->setWorksheet($sheet);
    				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row) );
    				$objDrawing->setOffsetX($result_x);
    				$objDrawing->setOffsetY($result_y);
    			} else {
    				$objDrawing = new PHPExcel_Worksheet_Drawing();
    				$objDrawing->setName('result_'.$data['match'].'_1');
    				$objDrawing->setDescription('result_'.$data['match'].'_1');
    				$objDrawing->setPath(dirname(__FILE__).'/squ.png');
    				$objDrawing->setWidth($result_size);
    				$objDrawing->setHeight($result_size);
    				$objDrawing->setWorksheet($sheet);
    				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row) );
    				$objDrawing->setOffsetX($result_x);
    				$objDrawing->setOffsetY($result_y);
    			}
    			if( $data['fusen'] == 1 ){
    				$sheet->setCellValueByColumnAndRow( $col+17, $row, '' );
    				$sheet->setCellValueByColumnAndRow( $col+17, $row+1, '' );
    			} else {
    				$sheet->setCellValueByColumnAndRow( $col+17, $row, $data['hon1'] );
    				$sheet->setCellValueByColumnAndRow( $col+17, $row+1, $data['win1'] );
    			}
    		} else {
    			$sheet->setCellValueByColumnAndRow( $col+17, $row, '' );
    			$sheet->setCellValueByColumnAndRow( $col+17, $row+1, '' );
    		}
	    	if( $data['fusen'] == 1 ){
    			if( $data['winner'] == 1 ){
    				$player = '不戦勝';
    			} else {
    				$player = '';
    			}
    		} else {
    			if( $data['matches'][6]['player1'] == 0 ){
    				$player = '';
    			} else if( $data['matches'][6]['player1'] == 8 ){
    				$player = '補員3';
    			} else if( $data['matches'][6]['player1'] == 9 ){
    				$player = '補員4';
    			} else if( $data['matches'][6]['player1'] == 10 ){
    				$player = '補員5';
    			} else if( $data['matches'][6]['player1'] == __PLAYER_NAME__ ){
    				$player = $data['matches'][6]['player1_change_name'];
    			} else {
                    if( $series_info['player_field_mode'] == 1 ){
                        $f = 'player'.$data['matches'][6]['player1'];
                    } else {
                        if( $series_mw === '' ){
                            $f = 'player'.$data['matches'][6]['player1'];
                        } else {
    		                $f = 'player'.$data['matches'][6]['player1'].'_'.$series_mw;
                        }
                    }
    				//$f = 'dantai_'.$series_mw.$data['matches'][6]['player1'];
    				if( $entry_list[$team1_index][$f.'_disp'] != '' ){
    					$player = $entry_list[$team1_index][$f.'_disp'];
    				} else {
    					$player = $entry_list[$team1_index][$f.'_sei'];
    				}
    			}
    		}
    		$sheet->setCellValueByColumnAndRow( $col+20, $row, $player );

    		for( $i1 = 1; $i1 <= 5; $i1++ ){
    			for( $i2 = 1; $i2 <= 3; $i2++ ){
    				$waza = '';
    				if( $data['fusen'] != 1 ){
    					if( $data['matches'][$i1]['waza1_'.$i2] == 0 ){
    						$waza = '';
    					} else if( $data['matches'][$i1]['waza1_'.$i2] == 1 ){
    						$waza = 'メ';
    					} else if( $data['matches'][$i1]['waza1_'.$i2] == 2 ){
    						$waza = 'ド';
    					} else if( $data['matches'][$i1]['waza1_'.$i2] == 3 ){
    						$waza = 'コ';
    					} else if( $data['matches'][$i1]['waza1_'.$i2] == 4 ){
    						$waza = '反';
    					} else if( $data['matches'][$i1]['waza1_'.$i2] == 5 ){
    						$waza = '不戦勝';
    					}
    				}
    				$sheet->setCellValueByColumnAndRow( $col+($i1-1)*3+$i2, $row+1, $waza );
    			}
    		}
    		for( $i2 = 1; $i2 <= 3; $i2++ ){
    			$waza = '';
    			if( $data['fusen'] != 1 ){
	    			if( $data['matches'][6]['waza1_'.$i2] == 0 ){
	    				$waza = '';
	    			} else if( $data['matches'][6]['waza1_'.$i2] == 1 ){
	    				$waza = 'メ';
	    			} else if( $data['matches'][6]['waza1_'.$i2] == 2 ){
	    				$waza = 'ド';
	    			} else if( $data['matches'][6]['waza1_'.$i2] == 3 ){
	    				$waza = 'コ';
	    			} else if( $data['matches'][6]['waza1_'.$i2] == 4 ){
	    				$waza = '反';
	    			} else if( $data['matches'][6]['waza1_'.$i2] == 5 ){
	    				$waza = '不戦勝';
    				}
    			}
    			$sheet->setCellValueByColumnAndRow( $col+$i2+19, $row+1, $waza );
    		}
        }
        if( $team2_index >= 0 ){

    	if( isset($entry_list[$team2_index]['school_name_ryaku']) && $entry_list[$team2_index]['school_name_ryaku'] != '' ){
            $sheet->setCellValueByColumnAndRow( $col, $row+2, $entry_list[$team2_index]['school_name_ryaku'] );
        } else {
            $sheet->setCellValueByColumnAndRow( $col, $row+2, $entry_list[$team2_index]['school_name'] );
        }
		if( $entry_list[$team2_index]['school_address_pref_name'] != '' ){
			$sheet->setCellValueByColumnAndRow( $col, $row+3, '('.$entry_list[$team2_index]['school_address_pref_name'].')' );
		}
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			for( $i2 = 1; $i2 <= 3; $i2++ ){
				$waza = '';
				if( $data['fusen'] != 1 ){
					if( $data['matches'][$i1]['waza2_'.$i2] == 0 ){
						$waza = '';
					} else if( $data['matches'][$i1]['waza2_'.$i2] == 1 ){
						$waza = 'メ';
					} else if( $data['matches'][$i1]['waza2_'.$i2] == 2 ){
						$waza = 'ド';
					} else if( $data['matches'][$i1]['waza2_'.$i2] == 3 ){
						$waza = 'コ';
					} else if( $data['matches'][$i1]['waza2_'.$i2] == 4 ){
						$waza = '反';
					} else if( $data['matches'][$i1]['waza2_'.$i2] == 5 ){
						$waza = '不戦勝';
					}
				}
				$sheet->setCellValueByColumnAndRow( $col+($i1-1)*3+$i2, $row+2, $waza );
			}
		}
		for( $i2 = 1; $i2 <= 3; $i2++ ){
			$waza = '';
			if( $data['fusen'] != 1 ){
				if( $data['matches'][6]['waza2_'.$i2] == 0 ){
					$waza = '';
				} else if( $data['matches'][6]['waza2_'.$i2] == 1 ){
					$waza = 'メ';
				} else if( $data['matches'][6]['waza2_'.$i2] == 2 ){
					$waza = 'ド';
				} else if( $data['matches'][6]['waza2_'.$i2] == 3 ){
					$waza = 'コ';
				} else if( $data['matches'][6]['waza2_'.$i2] == 4 ){
					$waza = '反';
				} else if( $data['matches'][6]['waza2_'.$i2] == 5 ){
					$waza = '不戦勝';
				}
			}
			$sheet->setCellValueByColumnAndRow( $col+$i2+19, $row+2, $waza );
		}
		for( $i1 = 1; $i1 <= 5; $i1++ ){
			$player = '';
			if( $data['matches'][$i1]['player2'] == 0 ){
				$player = '';
			} else if( $data['matches'][$i1]['player2'] == 8 ){
				$player = '補員3';
			} else if( $data['matches'][$i1]['player2'] == 9 ){
				$player = '補員4';
			} else if( $data['matches'][$i1]['player2'] == 10 ){
				$player = '補員5';
  			} else if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
   				$player = $data['matches'][$i1]['player2_change_name'];
			} else {
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player'.$data['matches'][$i1]['player2'];
                } else {
                    if( $series_mw === '' ){
                        $f = 'player'.$data['matches'][$i1]['player2'];
                    } else {
                        $f = 'player'.$data['matches'][$i1]['player2'].'_'.$series_mw;
                    }
                }
				//$f = 'dantai_'.$series_mw.$data['matches'][$i1]['player2'];
				if( $entry_list[$team2_index][$f.'_disp'] != '' ){
					$player = $entry_list[$team2_index][$f.'_disp'];
				} else {
					$player = $entry_list[$team2_index][$f.'_sei'];
				}
			}
			$sheet->setCellValueByColumnAndRow( $col+$i1*3-2, $row+3, $player );
		}
		if( $end_match == 5 || $data['fusen'] == 1 ){
			if( $data['winner'] == 2 ){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('result_'.$data['match'].'_2');
				$objDrawing->setDescription('result_'.$data['match'].'_2');
				$objDrawing->setPath(dirname(__FILE__).'/cir.png');
				$objDrawing->setWidth($result_size);
				$objDrawing->setHeight($result_size);
				$objDrawing->setWorksheet($sheet);
				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row+2) );
				$objDrawing->setOffsetX($result_x);
				$objDrawing->setOffsetY($result_y);
			} else if( $data['winner']==1 ){
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('result_'.$data['match'].'_2');
				$objDrawing->setDescription('result_'.$data['match'].'_2');
				$objDrawing->setPath(dirname(__FILE__).'/tri.png');
				$objDrawing->setWidth($result_size);
				$objDrawing->setHeight($result_size);
				$objDrawing->setWorksheet($sheet);
				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row+2) );
				$objDrawing->setOffsetX($result_x);
				$objDrawing->setOffsetY($result_y);
			} else {
				$objDrawing = new PHPExcel_Worksheet_Drawing();
				$objDrawing->setName('result_'.$data['match'].'_2');
				$objDrawing->setDescription('result_'.$data['match'].'_2');
				$objDrawing->setPath(dirname(__FILE__).'/squ.png');
				$objDrawing->setWidth($result_size);
				$objDrawing->setHeight($result_size);
				$objDrawing->setWorksheet($sheet);
				$objDrawing->setCoordinates( $this->get_excel_coordinates($col+17,$row+2) );
				$objDrawing->setOffsetX($result_x);
				$objDrawing->setOffsetY($result_y);
			}
			if( $data['fusen'] == 1 ){
				$sheet->setCellValueByColumnAndRow( $col+17, $row+2, '' );
				$sheet->setCellValueByColumnAndRow( $col+17, $row+3, '' );
			} else {
				$sheet->setCellValueByColumnAndRow( $col+17, $row+2, $data['hon2'] );
				$sheet->setCellValueByColumnAndRow( $col+17, $row+3, $data['win2'] );
			}
		} else {
			$sheet->setCellValueByColumnAndRow( $col+17, $row+2, '' );
			$sheet->setCellValueByColumnAndRow( $col+17, $row+3, '' );
		}
		if( $data['fusen'] == 1 ){
			if( $data['winner'] == 2 ){
				$player = '不戦勝';
			} else {
				$player = '';
			}
		} else {
			if( $data['matches'][6]['player2'] == 0 ){
				$player = '';
			} else if( $data['matches'][6]['player2'] == 8 ){
				$player = '補員3';
			} else if( $data['matches'][6]['player2'] == 9 ){
				$player = '補員4';
			} else if( $data['matches'][6]['player2'] == 10 ){
				$player = '補員5';
   			} else if( $data['matches'][6]['player2'] == __PLAYER_NAME__ ){
   				$player = $data['matches'][6]['player2_change_name'];
			} else {
                if( $series_info['player_field_mode'] == 1 ){
                    $f = 'player'.$data['matches'][6]['player2'];
                } else {
                    if( $series_mw === '' ){
                        $f = 'player'.$data['matches'][6]['player2'];
                    } else {
                        $f = 'player'.$data['matches'][6]['player2'].'_'.$series_mw;
                    }
                }
				//$f = 'dantai_'.$series_mw.$data['matches'][6]['player2'];
				if( $entry_list[$team2_index][$f.'_disp'] != '' ){
					$player = $entry_list[$team2_index][$f.'_disp'];
				} else {
					$player = $entry_list[$team2_index][$f.'_sei'];
				}
			}
		}
		$sheet->setCellValueByColumnAndRow( $col+20, $row+3, $player );

        }
	}

	function get_excel_coordinates( $col, $row )
	{
		$etbl = array( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' );

		$c = intval( $col / count($etbl) );
		$cofs = $col % count($etbl);
		if( $c == 0 ){
			return $etbl[$cofs] . $row;
		} else {
			return $etbl[$c-1] . $etbl[$cofs] . $row;
		}
	}

	function get_tounament_chart_winstring_for_excel( $match )
	{
		$l = array( 1 => array('','',''), 2 => array('','','') );
		if( $match['fusen'] == 1 ){
			if( $match['winner'] == 1 ){
				$l[1][2] = '不戦勝';
			} else if( $match['winner'] == 2 ){
				$l[2][2] = '不戦勝';
			}
			return $l;
		}
		$l[1][0] = $match['hon1'];
		$l[2][0] = $match['hon2'];
		$l[1][1] = $match['win1'];
		$l[2][1] = $match['win2'];
		$add1 = '';
		$add2 = '';
		if( $match['win1'] == $match['win2'] ){
			if( $match['hon1'] > $match['hon2'] ){
				$l[1][2] = '本';
			} else if( $match['hon1'] < $match['hon2'] ){
				$l[2][2] = '本';
			} else {
				if( $match['winner'] == 1 ){
					$l[1][2] = '代';
				} else if( $match['winner'] == 2 ){
					$l[2][2] = '代';
				}
			}
		}
		return $l;
	}

	function get_kojin_tounament_chart_winstring_for_excel( $match )
	{
		$l = array( 1=>array( '','','' ), 2=>array( '','','' ) );
		if( $match['waza1_1'] == 5 ){
			$l[1][0] = '不';
			$l[1][1] = '戦';
			$l[1][2] = '勝';
		} else {
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $match['waza1_'.$waza] != 0 ){
					$l[1][$waza-1] = $this->get_waza_name( $match['waza1_'.$waza] );
				}
			}
		}
		if( $match['waza2_1'] == 5 ){
			$l[2][0] = '不';
			$l[2][1] = '戦';
			$l[2][2] = '勝';
		} else {
			for( $waza = 1; $waza <= 3; $waza++ ){
				if( $match['waza2_'.$waza] != 0 ){
					$l[2][$waza-1] = $this->get_waza_name( $match['waza2_'.$waza] );
				}
			}
		}
		return $l;
	}

	function output_prize_data_for_excel(
		$objPage, $path, 
		$series_dantai_m, $series_dantai_w, $series_kojin_m, $series_kojin_w
	){
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/prize.xlsx';
		$file_name = 'prize.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/prizeBase.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_w, 'w' );
		$team = array();
		if( $tournament_data['match'][0]['winner'] == 1 ){
			$team[0] = $tournament_data['match'][0]['team1'];
			$team[1] = $tournament_data['match'][0]['team2'];
		} else if( $tournament_data['match'][0]['winner'] == 2 ){
			$team[0] = $tournament_data['match'][0]['team2'];
			$team[1] = $tournament_data['match'][0]['team1'];
		}
		if( $tournament_data['match'][1]['team1'] == $team[0] ){
			$team[2] = $tournament_data['match'][1]['team2'];
			if( $tournament_data['match'][2]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][2]['team2'];
			} else if( $tournament_data['match'][2]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][2]['team1'];
			}
		} else if( $tournament_data['match'][1]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][1]['team1'];
			if( $tournament_data['match'][2]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][2]['team2'];
			} else if( $tournament_data['match'][2]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][2]['team1'];
			}
		} else if( $tournament_data['match'][2]['team1'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team2'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		} else if( $tournament_data['match'][2]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team1'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['match'][$m]['winner'] == 1 ){
				$team[$m+1] = $tournament_data['match'][$m]['team2'];
			} else if( $tournament_data['match'][$m]['winner'] == 2 ){
				$team[$m+1] = $tournament_data['match'][$m]['team1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+2), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+2), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+2), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_m, 'm' );
		$team = array();
		if( $tournament_data['match'][0]['winner'] == 1 ){
			$team[0] = $tournament_data['match'][0]['team1'];
			$team[1] = $tournament_data['match'][0]['team2'];
		} else if( $tournament_data['match'][0]['winner'] == 2 ){
			$team[0] = $tournament_data['match'][0]['team2'];
			$team[1] = $tournament_data['match'][0]['team1'];
		}
		if( $tournament_data['match'][1]['team1'] == $team[0] ){
			$team[2] = $tournament_data['match'][1]['team2'];
			if( $tournament_data['match'][2]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][2]['team2'];
			} else if( $tournament_data['match'][2]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][2]['team1'];
			}
		} else if( $tournament_data['match'][1]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][1]['team1'];
			if( $tournament_data['match'][2]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][2]['team2'];
			} else if( $tournament_data['match'][2]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][2]['team1'];
			}
		} else if( $tournament_data['match'][2]['team1'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team2'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		} else if( $tournament_data['match'][2]['team2'] == $team[0] ){
			$team[2] = $tournament_data['match'][2]['team1'];
			if( $tournament_data['match'][1]['winner'] == 1 ){
				$team[3] = $tournament_data['match'][1]['team2'];
			} else if( $tournament_data['match'][1]['winner'] == 2 ){
				$team[3] = $tournament_data['match'][1]['team1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['match'][$m]['winner'] == 1 ){
				$team[$m+1] = $tournament_data['match'][$m]['team2'];
			} else if( $tournament_data['match'][$m]['winner'] == 2 ){
				$team[$m+1] = $tournament_data['match'][$m]['team1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+12), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+12), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+12), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_w, 'w' );
		$id = array();
		$team = array();
		$player = array();
		if( $tournament_data['data']['match'][0]['winner'] == 1 ){
			$id[0] = $tournament_data['data']['match'][0]['player1'];
			$id[1] = $tournament_data['data']['match'][0]['player2'];
		} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
			$id[0] = $tournament_data['data']['match'][0]['player2'];
			$id[1] = $tournament_data['data']['match'][0]['player1'];
		}
		if( $tournament_data['data']['match'][1]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player2'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][1]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player1'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player2'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player1'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['data']['match'][$m]['winner'] == 1 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player2'];
			} else if( $tournament_data['data']['match'][$m]['winner'] == 2 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			$team[$m] = intval( $id[$m] / 0x100 );
			$player[$m] = $id[$m] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w1_sei'].' '.$entry_list[$i2]['kojin_w1_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w1_sei'].' '.$entry_list[$i2]['kojin_kana_w1_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w2_sei'].' '.$entry_list[$i2]['kojin_w2_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w2_sei'].' '.$entry_list[$i2]['kojin_kana_w2_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_m, 'm' );
		$team = array();
		$player = array();
		$id = array();
		$team = array();
		$player = array();
		if( $tournament_data['data']['match'][0]['winner'] == 1 ){
			$id[0] = $tournament_data['data']['match'][0]['player1'];
			$id[1] = $tournament_data['data']['match'][0]['player2'];
		} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
			$id[0] = $tournament_data['data']['match'][0]['player2'];
			$id[1] = $tournament_data['data']['match'][0]['player1'];
		}
		if( $tournament_data['data']['match'][1]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player2'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][1]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][1]['player1'];
			if( $tournament_data['data']['match'][2]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][2]['player2'];
			} else if( $tournament_data['data']['match'][2]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][2]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player1'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player2'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		} else if( $tournament_data['data']['match'][2]['player2'] == $id[0] ){
			$id[2] = $tournament_data['data']['match'][2]['player1'];
			if( $tournament_data['data']['match'][1]['winner'] == 1 ){
				$id[3] = $tournament_data['data']['match'][1]['player2'];
			} else if( $tournament_data['data']['match'][1]['winner'] == 2 ){
				$id[3] = $tournament_data['data']['match'][1]['player1'];
			}
		}
		for( $m = 3; $m <= 6; $m++ ){
			if( $tournament_data['data']['match'][$m]['winner'] == 1 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player2'];
			} else if( $tournament_data['data']['match'][$m]['winner'] == 2 ){
				$id[$m+1] = $tournament_data['data']['match'][$m]['player1'];
			}
		}
		for( $m = 0; $m <= 7; $m++ ){
			$team[$m] = intval( $id[$m] / 0x100 );
			$player[$m] = $id[$m] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m1_sei'].' '.$entry_list[$i2]['kojin_m1_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m1_sei'].' '.$entry_list[$i2]['kojin_kana_m1_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m2_sei'].' '.$entry_list[$i2]['kojin_m2_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m2_sei'].' '.$entry_list[$i2]['kojin_kana_m2_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_prize8_data_for_excel(
		$objPage, $path, 
		$series_dantai_m, $series_dantai_w, $series_kojin_m, $series_kojin_w
	){
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_path = $path . '/prize8.xlsx';
		$file_name = 'prize8.xlsx';
		$reader = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $reader->load(dirname(__FILE__).'/prizeBase8.xlsx');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_w, 'w' );
		$team = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = $tournament_data['match'][$m+3]['team1'];
			$team[$m*2+1] = $tournament_data['match'][$m+3]['team2'];
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+2), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+2), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+2), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_dantai_tournament_data( $series_dantai_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_dantai_m, 'm' );
		$team = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = $tournament_data['match'][$m+3]['team1'];
			$team[$m*2+1] = $tournament_data['match'][$m+3]['team2'];
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					$sheet->setCellValue( 'C'.($m+12), $entry_list[$i2]['school_name'] );
					$sheet->setCellValue( 'D'.($m+12), $entry_list[$i2]['school_name_kana'] );
					$sheet->setCellValue( 'E'.($m+12), $entry_list[$i2]['school_address_pref_name'] );
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_w, 'w' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_w, 'w' );
		$team = array();
		$player = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = intval( $tournament_data['data']['match'][$m+3]['player1'] / 0x100 );
			$player[$m*2] = $tournament_data['data']['match'][$m+3]['player1'] % 0x100;
			$team[$m*2+1] = intval( $tournament_data['data']['match'][$m+3]['player2'] / 0x100 );
			$player[$m*2+1] = $tournament_data['data']['match'][$m+3]['player2'] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w1_sei'].' '.$entry_list[$i2]['kojin_w1_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w1_sei'].' '.$entry_list[$i2]['kojin_kana_w1_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+22), $entry_list[$i2]['kojin_w2_sei'].' '.$entry_list[$i2]['kojin_w2_mei'] );
						$sheet->setCellValue( 'D'.($m+22), $entry_list[$i2]['kojin_kana_w2_sei'].' '.$entry_list[$i2]['kojin_kana_w2_mei'] );
						$sheet->setCellValue( 'E'.($m+22), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+22), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+22), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$tournament_data = $this->get_kojin_tournament_data( $series_kojin_m, 'm' );
		$entry_list = $this->get_entry_data_list3( $series_kojin_m, 'm' );
		$team = array();
		$player = array();
		for( $m = 0; $m <= 3; $m++ ){
			$team[$m*2] = intval( $tournament_data['data']['match'][$m+3]['player1'] / 0x100 );
			$player[$m*2] = $tournament_data['data']['match'][$m+3]['player1'] % 0x100;
			$team[$m*2+1] = intval( $tournament_data['data']['match'][$m+3]['player2'] / 0x100 );
			$player[$m*2+1] = $tournament_data['data']['match'][$m+3]['player2'] % 0x100;
		}
		for( $m = 0; $m <= 7; $m++ ){
			for( $i2 = 0; $i2 < count($entry_list); $i2++ ){
				if( $team[$m] == $entry_list[$i2]['id'] ){
					if( $player[$m] == 1 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m1_sei'].' '.$entry_list[$i2]['kojin_m1_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m1_sei'].' '.$entry_list[$i2]['kojin_kana_m1_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					} else if( $player[$m] == 2 ){
						$sheet->setCellValue( 'C'.($m+32), $entry_list[$i2]['kojin_m2_sei'].' '.$entry_list[$i2]['kojin_m2_mei'] );
						$sheet->setCellValue( 'D'.($m+32), $entry_list[$i2]['kojin_kana_m2_sei'].' '.$entry_list[$i2]['kojin_kana_m2_mei'] );
						$sheet->setCellValue( 'E'.($m+32), $entry_list[$i2]['school_address_pref_name'] );
						$sheet->setCellValue( 'F'.($m+32), $entry_list[$i2]['school_name'] );
						$sheet->setCellValue( 'G'.($m+32), $entry_list[$i2]['school_name_kana'] );
					}
					break;
				}
			}
		}

		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
		$writer->save( $file_path );
		return $file_name;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

    function load_entry_csv( $series, $file )
    {
        $serieslist = $this->get_series_list( $series );
        if( $serieslist === false ){ return; }
        if( $serieslist['dantai_league_m'] == $series || $serieslist['dantai_tournament_m'] == $series ){
            $f = 'dantai_m';
            //$this->load_dantai_league_entry_csv( $series, 'm', $file, $serieslist );
            //return;
        } else if( $serieslist['dantai_league_w'] == $series || $serieslist['dantai_tournament_w'] == $series ){
            $f = 'dantai_w';
            //$this->load_dantai_league_entry_csv( $series, 'w', $file, $serieslist );
            //return;
        } else if( $serieslist['kojin_tournament_m'] == $series ){
            $f = 'kojin_m';
            //$this->load_kojin_tournament_entry_csv( $series, 'm', $file, $serieslist );
        } else if( $serieslist['kojin_tournament_w'] == $series ){
            $f = 'kojin_w';
            //$this->load_kojin_tournament_entry_csv( $series, 'w', $file, $serieslist );
        } else {
            return;
        }
        $entry_num = $serieslist[$f.'_entry_num'];
        if( $entry_num == 0 ){ return; }
        $fields = explode( ',', $serieslist[$f.'_entry_field'] );
        if( count( $fields ) == 0 ){ return; }
        mb_internal_encoding("SJIS");
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($file);
        $file->setFlags( SplFileObject::READ_CSV );

        $sql = 'update `entry_info` set `del`=1 where `series`=' . $series . ' and `year`=' . $_SESSION['auth']['year'];
//echo '<!-- ',$sql," --><br />\n";
        db_query( $dbs, $sql );
        $sql = 'select * from `entry_info` where `series`=' . $series . ' and `year`=' . $_SESSION['auth']['year'] . ' order by `id` asc';
        $entry_list = db_query_list( $dbs, $sql );
        $entry_index = 0;

        $index = 0;
        $order = 1;
        foreach( $file as $line ){
//print_r($line);
            if( is_null( $line[0] ) ){
                continue;
            }

            if( $entry_index < count( $entry_list ) ){
                $id = get_field_string_number( $entry_list[$entry_index], 'id', 0 );
                $sql = 'update `entry_info` set `disp_order`=' . $order . ', `del`=0 where `id`=' . $id;
//echo '<!-- ',$sql," --><br />\n";
                db_query( $dbs, $sql );
                $entry_index++;
            } else {
                $sql = 'insert into `entry_info` set `series`='.$series.','
                    . ' `year`='.$_SESSION['auth']['year'].','
                    . ' `disp_order`='.$order.','
			        . ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
//echo '<!-- ',$sql," --><br />\n";
                db_query( $dbs, $sql );
                $id = db_query_insert_id( $dbs );
            }

            $pref_tbl = $this->get_pref_array2();
            $this->update_entry_field_data( $id, 'join', '1', $dbs );
            for( $findex = 0; $findex < count($fields); $findex++ ){
                if( $fields[$findex] !== '' ){
                    $value = mb_convert_encoding( $line[$findex], 'UTF-8', 'SJIS' );
                    if( $fields[$findex] == 'school_pref' || $fields[$findex] == 'kojin_address_pref' ){
                        foreach( $pref_tbl as $pv ){
                            if( mb_strpos( $value, $pv['title'] ) !== false ){
                                $this->update_entry_field_data( $id, $fields[$findex], $pv['value'], $dbs );
                                break;
                            }
                        }
                    } else {
                        $this->update_entry_field_data( $id, $fields[$findex], $value, $dbs );
                    }
                }
            }
            if( $order >= $entry_num ){ break; }
            $order++;
        }
        mb_internal_encoding("UTF-8");
//exit;
    }

    function load_dantai_league_entry_csv( $series, $mw, $name, $serieslist )
    {
        $entry_num = $serieslist['dantai_'.$mw.'_entry_num'];
        $fields = explode( ',', $serieslist['dantai_'.$mw.'_entry_field'] );
        if( $entry_num == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );

        $sql = 'select `entry_info` where `series`=' . $series . ', `year`=' . $_SESSION['auth']['year'] . ' order by `id` asc';
        $entry_list = db_query_list( $dbs, $sql );
        $entry_index = 0;

        $index = 0;
        $order = 1;
        foreach( $file as $line )
        {
//print_r($line);
            if( $index == 0 ){
                if( is_null( $line[0] ) ){ break; }
                if( count( $line ) == 0 ){ break; }
                $fields = $line;
                $index++;
                continue;
            }
            if( is_null( $line[0] ) ){
                $index++;
                continue;
            }

            if( $entry_index < count( $entry_list ) ){
                $id = get_field_string_number( $entry_list[$entry_index], 'id', 0 );
                $sql = 'update `entry_info` set `disp_order`=' . $order . ' where `id`=' . $id;
                db_query( $dbs, $sql );
                $entry_index++;
            } else {
                $sql = 'insert into `entry_info` set `series`='.$series.','
                    . ' `year`='.$_SESSION['auth']['year'].','
                    . ' `disp_order`='.$order.','
			        . ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
//echo $sql,"\n";
                db_query( $dbs, $sql );
                $id = db_query_insert_id( $dbs );
            }

            $this->update_entry_field_data( $id, 'join', '1', $dbs );
            for( $findex = 0; $findex < count($fields); $findex++ ){
                if( $fields[$findex] !== '' ){
                    $this->update_entry_field_data( $id, $fields[$findex], $line[$findex], $dbs );
                }
            }
            $order++;
        }
    }

    function load_kojin_tournament_entry_csv( $series, $mw, $name, $serieslist )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );
        $i1 = 1;
        foreach( $file as $line )
        {
            if( is_null( $line[0] ) ){ continue; }
            $sql = 'insert into `entry_info` set `series`='.$series.','
                . ' `year`='.$_SESSION['auth']['year'].','
                . ' `disp_order`='.$i1.','
			    . ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
echo '<!-- ',$sql," -->\n";
            db_query( $dbs, $sql );
            $id = db_query_insert_id( $dbs );

			$sql = 'insert into `entry_field` (`series`,`year`,`info`,`field`,`data`) VALUES '
               .'('.$series.','.$_SESSION['auth']['year'].','.$id.',\'join\',\'1\'),'
               .'('.$series.','.$_SESSION['auth']['year'].','.$id.',\'school_name\',\''.$line[2].'\'),'
               .'('.$series.','.$_SESSION['auth']['year'].','.$id.',\'kojin_'.$mw.'1_sei\',\''.$line[0].'\'),'
               .'('.$series.','.$_SESSION['auth']['year'].','.$id.',\'kojin_'.$mw.'1_mei\',\''.$line[1].'\')';
echo '<!-- ',$sql," -->\n";
			db_query( $dbs, $sql );
            $id++;
        }
    }

//-------------------------------------------------------------------

	function output_league_for_HTML( $navi_info, $league_param, $league_list, $entry_list, $mw, $disp_match )
	{
//echo $path;
//print_r($league_list);
		if( $mw == 'm' ){
			$mwstr = '男子';
        } else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'団体リーグ表</title>'."\n";
		$header .= '<link href="preleague_s.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$navi_info['result_prefix'].$mw.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = '';
        $tindex = 1;
		$html = $header . '    <h2>' . $mwstr . '団体リーグ表</h2>'."\n";
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $league_param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
//print_r($league_list[$league_data]);
			$html .= '    <table class="match_t" border="0" cellspacing="0" cellpadding="2">'."\n";
			$html .= '      <tr>'."\n";
			$html .= '        <td class="td_name">'.$league_list[$league_data]['name'].'</td>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '        <td class="td_match">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						//$html .= $ev['school_name_ryaku'] . '<br />(' . $ev['school_address_pref_name'] . ')';
						$html .= $ev['school_name'];
                        if( isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
					}
				}
				$html .= '        </td>'."\n";
			}
			$html .= '        <td class="td_score">得点</td>'."\n";
			$html .= '        <td class="td_score">勝者数</td>'."\n";
			$html .= '        <td class="td_score">勝本数</td>'."\n";
			$html .= '        <td class="td_score">順位</td>'."\n";
			$html .= '        <td class="tb_frame_white"></td>'."\n";
			$html .= '      </tr>'."\n";
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				$html .= '      <tr>'."\n";
				$html .= '        <td class="td_right">'."\n";
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						//$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						//$html .= $ev['school_name'].'<br />('.$ev['school_address_pref_name'].')';
						$html .= $ev['school_name'];
                        if( isset($ev['school_address_pref_name']) ){
                            $html .= '<br />(' . $ev['school_address_pref_name'] . ')';
                        }
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $league_param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_no_index == 0 ){
						$html .= '        <td class="td_right">----</td>'."\n";
					} else if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon1'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win1'].'</div>'."\n";
							$html .= '</div>'."\n";
							//$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon1'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win1'];
						}
						$html .= '        </td>'."\n";
					} else {
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$html .= '<div class="tb_frame_result_content">'."\n";
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$html .= '  <span class="result-circle"></span>'."\n";
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==1 ){
								$html .= '  <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
							} else {
								$html .= '  <span class="result-square"></span>'."\n";
							}
//							$html .= $league_list[$league_data]['match'][$match_no_index-1]['hon2'].'-'.$league_list[$league_data]['match'][$match_no_index-1]['win2'];

							$html .= '  <div class="tb_frame_result_hon">'.$league_list[$league_data]['match'][$match_no_index-1]['hon2'].'</div>'."\n";
							$html .= '  <div class="tb_frame_result_win">'.$league_list[$league_data]['match'][$match_no_index-1]['win2'].'</div>'."\n";
							$html .= '</div>'."\n";


						}
						$html .= '        </td>'."\n";
					}
				}
				$html .= '        <td class="td_right">'.($league_list[$league_data]['team'][$dantai_index_row]['point']/2).'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['win'].'</td>'."\n";
				$html .= '        <td class="td_right">'.$league_list[$league_data]['team'][$dantai_index_row]['hon'].'</td>'."\n";
				if( $league_list[$league_data]['end_match'] == $league_list[$league_data]['match_num'] ){
					$html .= '        <td class="td_right" ';
					if( $league_list[$league_data]['team'][$dantai_index_row]['advanced'] == 1){
						//$html .= 'bgcolor="#ffbbbb"';
					}
					$html .= '>' . $league_list[$league_data]['team'][$dantai_index_row]['standing'] . '</td>'."\n";
				} else {
					$html .= '        <td class="td_right">&nbsp;</td>'."\n";
				}
    			$html .= '        <td class="tb_frame_white">';
                if( $league_list[$league_data]['extra_match_exists'] == 1 && $dantai_index_row == 1 ){ $html .= '代'; }
    			$html .= '</td>'."\n";
				$html .= '      </tr>'."\n";
			}
			$html .= '    </table>'."\n";
			$html .= '    <br />'."\n";
			$html .= '    <br />'."\n";
		}
        if( $disp_match ){
            for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
				$html .= '    <h2>' . $mwstr . '団体リーグ結果</h2>'."\n";
    			$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第1試合</h3>';
	    		$html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][0], $entry_list, $mw );
		    	$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			    $html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][2], $entry_list, $mw );
			    $html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			    $html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][1], $entry_list, $mw );
    			$html .= '    <br />'."\n";
	    		$html .= '    <br />'."\n";
    		}
        }
		$html .= $footer;
        $file = $navi_info['result_path'] . '/dl_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
        $fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_league_match_for_HTML2( $navi_info, $league_param, $league_list, $entry_list, $mw )
	{
		if( $mw == 'm' ){
			$mwstr = '男子';
        } else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>'.$mwstr.'団体リーグ結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$mw.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

		$html = $header . '    <h2>' . $mwstr . '団体リーグ結果</h2>'."\n";
        $tindex = 1;
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_num = intval( $league_list[$league_data]['match_num'] );
			//for( $match_index = 0; $match_index < count( $league_list[$league_data]['match'] ); $match_index++ ){
			for( $match_index = 0; $match_index < $match_num; $match_index++ ){
				$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第'.($match_index+1).'試合</h3>';
				$html .= $this->output_one_match_for_HTML2( $navi_info, $league_list[$league_data]['match'][$league_param['place_match_info'][$match_index]], $entry_list, $mw );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第2試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][2], $entry_list, $mv );
			//$html .= '<h3>' . $league_list[$league_data]['name'] . '&nbsp;第3試合</h3>';
			//$html .= $objPage->output_one_match_for_HTML2( $league_list[$league_data]['match'][1], $entry_list, $mv );
			}
		}
		$html .= $footer;
        $file = $navi_info['result_path'] . '/dlm_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $html );
		fclose( $fp );
	}

	function output_dantai_tournament_for_HTML( $navi_info, $tournament_list, $entry_list, $mw )
	{
//print_r($tournament_data);
		if( $mw == 'm' ){
			$mwstr = '男子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
        } else if( $mw == 'w' ){
			$mwstr = '女子';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		} else {
			$mwstr = '';
			$table_name_rowspan = 3;
			$table_height = 6;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 30;
		}
		$tournament_name_width = 180;
		$tournament_name_pref_width = 72;
		$tournament_name_num_width = 16;
		$tournament_name_name_width = $tournament_name_width - $tournament_name_pref_width - $tournament_name_num_width;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;

        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

		$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
	//	$pdf = '' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
		//	. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<style>' . "\n"
			. 'body { font-family: \'DejaVu Sans Condensed\'; font-size: 5pt;  }'. "\n"
			. '.content {' . "\n"
		//	. '    position: relative;' . "\n"
			. '    width: 900px;' . "\n"
			. '    height: 980px;' . "\n"
			. '    font-size: 5px;' . "\n"
			. '    margin: 16px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: '.$tournament_name_name_width.';' . "\n"
		//	. '    height: 5px;' . "\n"
		//	. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_pref {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: left;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 80px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: '.$tournament_name_pref_width.';' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: right;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 140px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: '.$tournament_name_num_width.';' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: '.$tournament_name_num_width.';' . "\n"
			. '}' . "\n"
			. '.div_result_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_border_none {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 1px 0 0 1px;' . "\n"
			. '}' . "\n"
			. '.div_border_none2 {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 0 1px 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_b {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_r {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_l {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 80px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_pref {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 60px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_num {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_num2 {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 2px 0 8px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '}' . "\n"
			. '.clearfix:after {' . "\n"
			. '  content: "";' . "\n"
			. '  clear: both;' . "\n"
			. '  display: block;' . "\n"
			. '}' . "\n"
			. '</style>' . "\n"
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">団体'.$mwstr.'トーナメント表';
        if( count( $tournament_list ) > 1 ){
            $pdf .= '　グループ' . $tindex;
        }
        $pdf .= '</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$navi_info['result_prefix'].$mw.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";

		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['team'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = '';
			$pref = '';
			$id = intval( $tournament_data['team'][$tournament_team]['id'] );
			if( $id > 0 ){
				foreach( $entry_list as $ev ){
					if( $id == intval( $ev['id'] ) ){
						if( $ev['school_name_ryaku'] != '' ){
							$name = $ev['school_name_ryaku'];
						} else {
							$name = $ev['school_name'];
						}
						$pref = $ev['school_address_pref_name'];
						break;
					}
				}
			}
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['win1'] = $tournament_data['match'][$match_no-1]['win1'];
				$one_match['hon1'] = $tournament_data['match'][$match_no-1]['hon1'];
				$one_match['win2'] = $tournament_data['match'][$match_no-1]['win2'];
				$one_match['hon2'] = $tournament_data['match'][$match_no-1]['hon2'];
				$one_match['winner'] = $tournament_data['match'][$match_no-1]['winner'];
				$one_match['fusen'] = $tournament_data['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
				$one_match['team1'] = array( 'id' => $id );
                $one_match['team1']['pos'] = $team_pos * 4 + 1;
                //if( $id > 0 ){
                    $one_match['team1']['name'] = $name;
                    $one_match['team1']['pref'] = $pref;
                    $one_match['team1']['index'] = $team_index;
                    $team_pos++;
                    $team_index++;
				//}
				$match_no++;
			} else {
			//	if( $one_match['place'] !== 'no_match' ){
                    $one_match['team2'] = array( 'id' => $id );
                    $one_match['team2']['pos'] = $team_pos * 4 + 1;
                    //if( $id > 0 ){
                        $one_match['team2']['name'] = $name;
                        $one_match['team2']['pref'] = $pref;
                        $one_match['team2']['index'] = $team_index;
                        $team_pos++;
                        $team_index++;
                    //}
			//	}
				if( $tournament_team < $team_num2 ){
					$match_line1[] = $one_match;
				} else {
					$match_line2[] = $one_match;
				}
				$one_match = array();
			}
		}
		$match_no_top /= 2;

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['match_level']-1; $i1++ ){
			$match_no = $match_no_top;
			for( $line = 0; $line < 2; $line++ ){
				$match_line = array();
				$one_match = array();
				for( $i2 = 0; $i2 < count( $match_tbl[$line][$i1-1] ); $i2++ ){
					if( $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match' ){
						$pos = $match_tbl[$line][$i1-1][$i2]['team1']['pos'];
					} else {
						$pos = intval( ( $match_tbl[$line][$i1-1][$i2]['team1']['pos'] + $match_tbl[$line][$i1-1][$i2]['team2']['pos'] ) / 2 );
					}
					if( ( $i2 % 2 ) == 0 ){
						$one_match['up1'] = 0;
						$one_match['up2'] = 0;
					//	$one_match['match_no'] = $match_no;
						$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
						$one_match['win1'] = $tournament_data['match'][$match_no-1]['win1'];
						$one_match['hon1'] = $tournament_data['match'][$match_no-1]['hon1'];
						$one_match['win2'] = $tournament_data['match'][$match_no-1]['win2'];
						$one_match['hon2'] = $tournament_data['match'][$match_no-1]['hon2'];
						$one_match['winner'] = $tournament_data['match'][$match_no-1]['winner'];
						$one_match['fusen'] = $tournament_data['match'][$match_no-1]['fusen'];
						$one_match['place'] = $tournament_data['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['match'][$match_no-1]['place_match_no'];
						$one_match['team1']['pos'] = $pos;
						$match_no++;
					} else {
						$one_match['team2']['pos'] = $pos;
						if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $one_match['winner'] == 1 ){
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							} else if( $one_match['winner'] == 2 ){
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
								$one_match['up2'] = 1;
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
								$one_match['up1'] = 1;
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
							}
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
							}
						}
						$match_line[] = $one_match;
						$one_match = array();
					}
				}
				$match_tbl[$line][] = $match_line;
			}
			$match_no_top /= 2;
		}
		$match_line = array();
		foreach( $match_tbl[0][0] as $mv ){
            if( $mv['place'] !== 'no_match' || $mv['team1']['id'] != 0 || $mv['team2']['id'] != 0 ){
                $match_line[] = $mv;
            }
        }
        $match_tbl[0][0] = $match_line;
		$match_line = array();
		foreach( $match_tbl[1][0] as $mv ){
            if( $mv['place'] !== 'no_match' || $mv['team1']['id'] != 0 || $mv['team2']['id'] != 0 ){
                $match_line[] = $mv;
            }
        }
        $match_tbl[1][0] = $match_line;

//print_r($match_line);
//print_r($match_tbl);
//exit;
		$trpos = array();
		$trofs = array();
		$trspan = array();
		$trmatch = array();
		$trpos2 = array();
		$trofs2 = array();
		$trspan2 = array();
		$trmatch2 = array();
		for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
			$trpos[] = 0;
			$trofs[] = 0;
			$trspan[] = 0;
			$trmatch[] = 0;
			$trpos2[] = 0;
			$trofs2[] = 0;
			$trspan2[] = 0;
			$trmatch2[] = 0;
		}
		$namespan = 0;
		$namespan2 = 0;
		$line = 0;
		$name_index = 1;
		$line2 = $team_index;
		$pdf .=  '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		for(;;){
			$pdf .= '      <tr>' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$namespan = $table_name_rowspan - 1;
						$name_index++;
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b';
					if( $one_match_tbl['winner'] == 1 ){
						$pdf .= '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$pdf .= '_up';
					}
					$pdf .= ' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					}
					$pdf .= '</td>' . "\n";
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						$trofs[$level] = 1;
						$trmatch[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$namespan = $table_name_rowspan - 1;
							$name_index++;
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_br';
						if( $one_match_tbl['winner'] == 2 ){
							$pdf .= '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$pdf .= '_up';
						}
						$pdf .= ' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						}
						$pdf .= '</td>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							if( $namespan > 0 ){
								$namespan--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							}
						}
						if( $trspan[$level] > 0 ){
							$trspan[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament">';
							if( $line == $trmatch[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								//$pdf .= '<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>　';
								$pdf .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
							}
							$pdf .= '</td>' . "\n";
						}
					}
				} else {
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
				}
				$allend = 0;
			}
			if( $line == $line2-1 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 2 ){
				if( $tournament_data['match'][0]['winner'] > 0 ){
					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;"><a href="r'.$mv.'01.html">'.$tournament_data['match'][0]['hon1'].' -'.'</a></td>';
					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"><a href="r'.$mv.'01.html"> '.$tournament_data['match'][0]['hon2'].'</a></td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;">'.$tournament_data['match'][0]['hon1'].' -'.'</td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"> '.$tournament_data['match'][0]['hon2'].'</td>';
	} else {
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				}
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['match_level']-2; $level >= 0; $level-- ){
				if( $trpos2[$level] >= count( $match_tbl[1][$level] ) ){
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[1][$level][$trpos2[$level]];
				if( $trofs2[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					$win = '';
					if( $one_match_tbl['winner'] == 1 ){
						$win = '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$win = '_up';
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					}
					$pdf .= '</td>' . "\n";
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$namespan2 = $table_name_rowspan - 1;
						$name_index++;
					}
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						$trofs2[$level] = 1;
						$trmatch2[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs2[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						$win = '';
						if( $one_match_tbl['winner'] == 2 ){
							$win = '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$win = '_up';
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_bl'.$win.' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						}
						$pdf .= '</td>' . "\n";
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$namespan2 = $table_name_rowspan - 1;
							$name_index++;
						}
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						if( $trspan2[$level] > 0 ){
							$trspan2[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch2[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch2[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2">';
							if( $line == $trmatch2[$level] && $one_match_tbl['fusen'] == 0 && $one_match_tbl['winner'] != 0 ){
								$pdf .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
								//$pdf .= '　<a href="r'.$mv.sprintf('%02d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>';
							}
							$pdf .= '</td>' . "\n";
						}
						if( $level == 0 ){
							if( $namespan2 > 0 ){
								$namespan2--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							}
						}
					}
				} else {
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
			$pdf .= "\n".'      </tr>' . "\n";
if( $line == 300 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '  <br /><br /><br />' . "\n";
		$pdf .=  '  </div>' . "\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

//echo $pdf;
//exit;

        $file = $navi_info['result_path'] . '/dt_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
		$fp = fopen( $file, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );

            $tindex++;
        }
	}

	function output_tournament_match_for_HTML2( $objPage, $navi_info, $tournament_list, $entry_list, $mw, $split )
	{
        $levelstrtbl = array( '一', '二', '三', '四', '五' );

		if( $mw == 'm' ){
			$mwstr = '男子';
        } else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
		$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
		$header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
		$header .= '<head>'."\n";
		$header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
		$header .= '<title>団体トーナメント結果</title>'."\n";
		$header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
		$header .= '</head>'."\n";
		$header .= '<body>'."\n";
		//$header .= '<!--'."\n";
		//$header .= print_r($league_list,true) . "\n";
		//$header .= print_r($entry_list,true) . "\n";
		//$header .= '-->'."\n";
		$header .= '<div class="container">'."\n";
		$header .= '  <div class="content">'."\n";

		$footer = '     <h2 align="left" class="tx-h1"><a href="index_'.$navi_info['result_prefix'].$mw.'.html">←戻る</a></h2>'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    <br />'."\n";
		$footer .= '    </div>'."\n";
		$footer .= '    <!-- end .content --></div>'."\n";
		$footer .= '  </div>'."\n";
		$footer .= '  <!-- end .container --></div>'."\n";
		$footer .= "\n";
		$footer .= '<script>'."\n";
		$footer .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$footer .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$footer .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$footer .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$footer .= "\n";
		$footer .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$footer .= '  ga(\'send\', \'pageview\');'."\n";
		$footer .= "\n";
		$footer .= '</script>'."\n";
		$footer .= '</body>'."\n";
		$footer .= '</html>'."\n";

        $tindex = 1;
        foreach( $tournament_list as $tv ){
            $html = $header;
            if( count( $tournament_list ) > 1 ){
                 $html .= '    <h2>ブロック' . $tindex . '</h2>'."\n";
            }
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tv['match_level']; $i1++ ){ $match_no_top *= 2; }
            $level_offset = 0;
            for( $level = $tv['match_level']; $level >= 1; $level-- ){
                $nomatch = true;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tv['match'][$match_no_top+$i1-2]['place'] !== 'no_match' ){
                        $nomatch = false;
                        break;
                    }
                }
                if( $nomatch ){
                    $level_offset++;
                    $match_no_top /= 2;
                    continue;
                }
                if( $level >= 4 ){
                    $levelstr = $levelstrtbl[$tv['match_level']-$level-$level_offset] . '回戦';
                } else if( $level == 3 ){
                    $levelstr = '準々決勝';
                } else if( $level == 2 ){
                    $levelstr = '準決勝';
                } else if( $level == 1 ){
                    $levelstr = '決勝';
                }
                $html .= '    <h2>' . $mwstr . '団体トーナメント結果(' . $levelstr . ')</h2>' . "\n";
                $match_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tv['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){ continue; }
                    if( $level == 1 ){
                        $html .= '<h3>団体トーナメント&nbsp;' . $levelstr . '</h3>' . "\n";
                    } else {
                        $html .= '<h3>団体トーナメント&nbsp;' . $levelstr . '&nbsp;第'.$match_index.'試合</h3>' . "\n";
                    }
                    $html .= $objPage->output_one_match_for_HTML2( $navi_info, $tv['match'][$match_no_top+$i1-2], $entry_list, $mw );
                    $match_index++;
                }
                $match_no_top /= 2;
                if( $split == 1 ){
                    if( $level == 4 ){
                        $html .= $footer;
                        $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'_1.html';
                        $fp = fopen( $file, 'w' );
                        fwrite( $fp, $html );
                        fclose( $fp );
                        $html = $header;
                        if( count( $tournament_list ) > 1 ){
                            $html .= '    <h2>ブロック' . $tindex . '</h2>'."\n";
                        }
                    } else if( $level == 1 ){
                        $html .= $footer;
                        $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'_2.html';
                        $fp = fopen( $file, 'w' );
                        fwrite( $fp, $html );
                        fclose( $fp );
                    }
                }
            }
            if( $split == 0 ){
                $html .= $footer;
                $file = $navi_info['result_path'] . '/dtm_' . $navi_info['result_prefix'] . $mw . $tindex.'.html';
                $fp = fopen( $file, 'w' );
                fwrite( $fp, $html );
                fclose( $fp );
            }
            $tindex++;
        }
	}

	function output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, $mv )
	{
//echo '<!-- ';
//print_r($tournament_data);
//echo ' -->';
		$c = new common();
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 80;
			$table_height = 11;
			$table_font_size = 11;
			$table_place_font_size = 6;
			$table_cell_width = 35;
		}
		$pdf = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
	//	$pdf = '' . "\n"
			. '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n"
			. '<head>' . "\n"
			. '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . "\n"
			. '<title>試合結果速報</title>' . "\n"
		//	. '<link href="main.css" rel="stylesheet" type="text/css" />' . "\n"
			. '</head>' . "\n"
			. '<body>' . "\n"
			. '<style>' . "\n"
			. 'body { font-family: \'DejaVu Sans Condensed\'; font-size: 5pt;  }'. "\n"
			. '.content {' . "\n"
		//	. '    position: relative;' . "\n"
			. '    width: 960px;' . "\n"
			. '    height: 980px;' . "\n"
			. '    font-size: 5px;' . "\n"
			. '    margin: 16px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_name {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 0px;' . "\n"
			. '    width: '.$table_name_name_width.'px;' . "\n"
		//	. '    height: 5px;' . "\n"
		//	. '    float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_pref {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: left;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 80px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: '.$table_name_pref_width.'px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    vertical-align: top;' . "\n"
			. '    text-align: right;' . "\n"
			. '    font-size: '.$table_font_size.'pt;' . "\n"
		//	. '    position: absolute;' . "\n"
		//	. '    top: 11px;' . "\n"
		//	. '    left: 140px;' . "\n"
		//	. '    float: left;' . "\n"
			. '    width: 16px;' . "\n"
		//	. '    height: 5px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament_name_num2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 16px;' . "\n"
			. '}' . "\n"
			. '.div_result_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
		//	. '    width: 160px;' . "\n"
		//	. '    height: 8px;' . "\n"
		//	. '    float: left;' . "\n"
		//	. '    display: inline; text-align: justify;' . "\n"
		//	. '    display: inline; position: absolute;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_result_one_tournament2 {' . "\n"
			. '    margin: 0;' . "\n"
			. '    padding: 0;' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: '.$table_cell_width.'px;' . "\n"
			. '    font-size: '.$table_place_font_size.'pt;' . "\n"
		//	. '    height: 5px;' . "\n"
		//    . '    position: absolute;' . "\n"
			. '    display: inline; float: left;' . "\n"
			. '}' . "\n"
			. '.div_border_none {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 1px 0 0 1px;' . "\n"
			. '}' . "\n"
			. '.div_border_none2 {' . "\n"
			. '    border: none;' . "\n"
			. '    padding: 0 1px 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_b {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_r {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid 1px #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #ff0000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_l {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.div_border_l_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 80px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_pref {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 60px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_num {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 4px 0 4px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament_name_num2 {' . "\n"
			. '    text-align: left;' . "\n"
			. '    width: 10px;' . "\n"
			. '    padding: 0 2px 0 8px;' . "\n"
			. '}' . "\n"
			. '.tb_result_tournament {' . "\n"
			. '    text-align: right;' . "\n"
			. '    width: 40px;' . "\n"
			. '}' . "\n"
			. '.clearfix:after {' . "\n"
			. '  content: "";' . "\n"
			. '  clear: both;' . "\n"
			. '  display: block;' . "\n"
			. '}' . "\n"
			. '</style>' . "\n"
			. '<H1 style="border-bottom: solid 1px #000000;" lang="ja">個人戦'.$mvstr.'トーナメント表</H1>' . "\n"
			. '<h2 align="left" class="tx-h1"><a href="index_'.$mv.'.html">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
//print_r($tournament_data);
		$tournament_name_width = 150;
		$tournament_name_name_left = 0;
		$tournament_name_pref_left = 80;
		$tournament_name_num_left = 140;
		$tournament_width = 40;
		$tournament_height = 20;
		$tournament_height2 = 11;
		$match_no_top = 1;
		for( $i1 = 1; $i1 < $tournament_data['data']['match_level']; $i1++ ){ $match_no_top *= 2; }
		$match_no = $match_no_top;
		$match_line1 = array();
		$match_line2 = array();
		$one_match = array();
		$team_pos = 0;
		$team_num = count( $tournament_data['data']['player'] );
		$team_num2 = intval( $team_num / 2 );
		$team_index = 1;
		for( $tournament_team = 0; $tournament_team < $team_num; $tournament_team++ ){
			if( $tournament_team == 0 || $tournament_team == $team_num2 ){
				$team_pos = 0;
			}
			$name = $tournament_data['data']['player'][$tournament_team]['sei'].' '.$tournament_data['data']['player'][$tournament_team]['mei'];
			$pref = $tournament_data['data']['player'][$tournament_team]['pref_name'];
			if( ( $tournament_team % 2 ) == 0 ){
				$one_match['win1'] = $tournament_data['data']['match'][$match_no-1]['win1'];
				$one_match['hon1'] = $tournament_data['data']['match'][$match_no-1]['hon1'];
				$one_match['win2'] = $tournament_data['data']['match'][$match_no-1]['win2'];
				$one_match['hon2'] = $tournament_data['data']['match'][$match_no-1]['hon2'];
				$one_match['waza1_1'] = $tournament_data['data']['match'][$match_no-1]['waza1_1'];
				$one_match['waza1_2'] = $tournament_data['data']['match'][$match_no-1]['waza1_2'];
				$one_match['waza1_3'] = $tournament_data['data']['match'][$match_no-1]['waza1_3'];
				$one_match['waza2_1'] = $tournament_data['data']['match'][$match_no-1]['waza2_1'];
				$one_match['waza2_2'] = $tournament_data['data']['match'][$match_no-1]['waza2_2'];
				$one_match['waza2_3'] = $tournament_data['data']['match'][$match_no-1]['waza2_3'];
				$one_match['winner'] = $tournament_data['data']['match'][$match_no-1]['winner'];
				$one_match['fusen'] = $tournament_data['data']['match'][$match_no-1]['fusen'];
				$one_match['up1'] = 0;
				$one_match['up2'] = 0;
				$one_match['match_no'] = $tournament_data['data']['match'][$match_no-1]['dantai_tournament_match_id'];
				$one_match['place'] = $tournament_data['data']['match'][$match_no-1]['place'];
				$one_match['place_match_no'] = $tournament_data['data']['match'][$match_no-1]['place_match_no'];
				if( $one_match['place'] !== 'no_match' || $tournament_data['data']['match'][$match_no-1]['player1'] != 0 ){
					$one_match['team1'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				}
				//$match_no++;
			} else {
				if( $one_match['place'] !== 'no_match' ){
					$one_match['team2'] = array(
						'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
					);
					$team_pos++;
					$team_index++;
				} else {
					if( $tournament_data['data']['match'][$match_no-1]['player2'] != 0 ){
						$one_match['team1'] = array(
							'pos' => $team_pos * 4 + 1, 'name' => $name, 'pref' => $pref, 'index' => $team_index
						);
						$team_pos++;
						$team_index++;
					}
				}
				if( $tournament_team < $team_num2 ){
					$match_line1[] = $one_match;
				} else {
					$match_line2[] = $one_match;
				}
				$one_match = array();
				$match_no++;
			}
		}
		$match_no_top /= 2;
//print_r($match_line1);

		$match_tbl = array( array(), array() );
		$match_tbl[0][] = $match_line1;
		$match_tbl[1][] = $match_line2;
		for( $i1 = 1; $i1 < $tournament_data['data']['match_level']-1; $i1++ ){
			$match_no = $match_no_top;
			for( $line = 0; $line < 2; $line++ ){
				$match_line = array();
				$one_match = array();
				for( $i2 = 0; $i2 < count( $match_tbl[$line][$i1-1] ); $i2++ ){
					if( $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match' ){
						$pos = $match_tbl[$line][$i1-1][$i2]['team1']['pos'];
					} else {
						$pos = intval( ( $match_tbl[$line][$i1-1][$i2]['team1']['pos'] + $match_tbl[$line][$i1-1][$i2]['team2']['pos'] ) / 2 );
					}
					if( ( $i2 % 2 ) == 0 ){
						$one_match['up1'] = 0;
						$one_match['up2'] = 0;
					//	$one_match['match_no'] = $match_no;
					//	$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
						$one_match['match_no'] = $tournament_data['data']['match'][$match_no-1]['match'];
						$one_match['win1'] = $tournament_data['data']['match'][$match_no-1]['win1'];
						$one_match['hon1'] = $tournament_data['data']['match'][$match_no-1]['hon1'];
						$one_match['win2'] = $tournament_data['data']['match'][$match_no-1]['win2'];
						$one_match['hon2'] = $tournament_data['data']['match'][$match_no-1]['hon2'];
						$one_match['waza1_1'] = $tournament_data['data']['match'][$match_no-1]['waza1_1'];
						$one_match['waza1_2'] = $tournament_data['data']['match'][$match_no-1]['waza1_2'];
						$one_match['waza1_3'] = $tournament_data['data']['match'][$match_no-1]['waza1_3'];
						$one_match['waza2_1'] = $tournament_data['data']['match'][$match_no-1]['waza2_1'];
						$one_match['waza2_2'] = $tournament_data['data']['match'][$match_no-1]['waza2_2'];
						$one_match['waza2_3'] = $tournament_data['data']['match'][$match_no-1]['waza2_3'];
						$one_match['winner'] = $tournament_data['data']['match'][$match_no-1]['winner'];
						$one_match['fusen'] = $tournament_data['data']['match'][$match_no-1]['fusen'];
						$one_match['place'] = $tournament_data['data']['match'][$match_no-1]['place'];
						$one_match['place_match_no'] = $tournament_data['data']['match'][$match_no-1]['place_match_no'];
						$one_match['team1']['pos'] = $pos;
						$match_no++;
					} else {
						$one_match['team2']['pos'] = $pos;
						if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $one_match['winner'] == 1 ){
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							} else if( $one_match['winner'] == 2 ){
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] === 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
								$one_match['up2'] = 1;
								$match_tbl[$line][$i1-1][$i2]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] === 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
								$one_match['up1'] = 1;
								$match_tbl[$line][$i1-1][$i2-1]['up1'] = 1;
							}
						} else if(
							$match_tbl[$line][$i1-1][$i2-1]['place'] !== 'no_match'
							&& $match_tbl[$line][$i1-1][$i2]['place'] !== 'no_match'
						){
							if( $match_tbl[$line][$i1-1][$i2-1]['winner'] != 0 ){
								$one_match['up1'] = 1;
							}
							if( $match_tbl[$line][$i1-1][$i2]['winner'] != 0 ){
								$one_match['up2'] = 1;
							}
						}
						$match_line[] = $one_match;
						$one_match = array();
					}
				}
				$match_tbl[$line][] = $match_line;
			}
			$match_no_top /= 2;
		}
//print_r($match_tbl);

		$trpos = array();
		$trofs = array();
		$trspan = array();
		$trmatch = array();
		$trpos2 = array();
		$trofs2 = array();
		$trspan2 = array();
		$trmatch2 = array();
		for( $level = 0; $level < $tournament_data['data']['match_level']-1; $level++ ){
			$trpos[] = 0;
			$trofs[] = 0;
			$trspan[] = 0;
			$trmatch[] = 0;
			$trpos2[] = 0;
			$trofs2[] = 0;
			$trspan2[] = 0;
			$trmatch2[] = 0;
		}
		$namespan = 0;
		$namespan2 = 0;
		$line = 0;
		$name_index = 1;
		$line2 = $team_index;
		$pdf .=  '    <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
		for(;;){
			$pdf .= '      <tr>' . "\n";
			$allend = 1;
			for( $level = 0; $level < $tournament_data['data']['match_level']-1; $level++ ){
				if( $trpos[$level] >= count( $match_tbl[0][$level] ) ){
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[0][$level][$trpos[$level]];
				if( $trofs[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$namespan = $table_name_rowspan - 1;
						$name_index++;
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b';
					if( $one_match_tbl['winner'] == 1 ){
						$pdf .= '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$pdf .= '_up';
					}
					$pdf .= ' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
					}
					$pdf .= '</td>' . "\n";
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						$trofs[$level] = 1;
						$trmatch[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$namespan = $table_name_rowspan - 1;
							$name_index++;
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_br';
						if( $one_match_tbl['winner'] == 2 ){
							$pdf .= '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$pdf .= '_up';
						}
						$pdf .= ' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
						}
						$pdf .= '</td>' . "\n";
						$trpos[$level]++;
						$trofs[$level] = 0;
					} else {
						if( $level == 0 ){
							if( $namespan > 0 ){
								$namespan--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							}
						}
						if( $trspan[$level] > 0 ){
							$trspan[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['data']['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>' . "\n";
						}
					}
				} else {
					if( $level == 0 ){
						if( $namespan > 0 ){
							$namespan--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
						}
					}
					if( $trspan[$level] > 0 ){
						$trspan[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
					}
				}
				$allend = 0;
			}
			if( $line == $line2-1 ){
				$win = '';
				if( $tournament_data['data']['match'][0]['winner'] > 0 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_r'.$win.' div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else if( $line == $line2 ){
				$win = '';
				if( $tournament_data['data']['match'][0]['winner'] == 1 ){
					$win = '_final';
				} else if( $tournament_data['data']['match'][0]['winner'] == 2 ){
					$win = '_final2';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_br'.$win.' div_result_one_tournament"></td>';
				$win = '';
				if( $tournament_data['data']['match'][0]['winner'] == 2 ){
					$win = '_win';
				}
				$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament"></td>';
			} else if( $line == $line2 + 2 ){
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			} else {
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
				$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament"></td>';
			}
			for( $level = $tournament_data['data']['match_level']-2; $level >= 0; $level-- ){
				if( $trpos2[$level] >= count( $match_tbl[1][$level] ) ){
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
					continue;
				}
				$cell_pos = '';
				$one_match_tbl = $match_tbl[1][$level][$trpos2[$level]];
				if( $trofs2[$level] == 0 && $line == $one_match_tbl['team1']['pos'] ){
					$win = '';
					if( $one_match_tbl['winner'] == 1 ){
						$win = '_win';
					} else if( $one_match_tbl['up1'] == 1 ){
						$win = '_up';
					}
					$pdf .= '<td height="'.$table_height.'" class="div_border_b'.$win.' div_result_one_tournament">';
					if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 1 ){
						$pdf .= '不戦勝' . "\n";
					} else if( $one_match_tbl['place'] != 'no_match' ){
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_1'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_2'] );
						$pdf .= $c->get_waza_name( $one_match_tbl['waza1_3'] );
					}
					$pdf .= '</td>' . "\n";
					if( $level == 0 ){
						$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
						$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team1']['pref'].')</td>' . "\n";
						$namespan2 = $table_name_rowspan - 1;
						$name_index++;
					}
					if( $one_match_tbl['place'] === 'no_match' ){
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						$trofs2[$level] = 1;
						$trmatch2[$level] = intval( ( $one_match_tbl['team1']['pos'] + $one_match_tbl['team2']['pos'] ) / 2 );
					}
				} else if( $trofs2[$level] == 1 ){
					if( $line == $one_match_tbl['team2']['pos'] ){
						$win = '';
						if( $one_match_tbl['winner'] == 2 ){
							$win = '_win';
						} else if( $one_match_tbl['up2'] == 1 ){
							$win = '_up';
						}
						$pdf .= '<td height="'.$table_height.'" class="div_border_bl'.$win.' div_result_one_tournament">';
						if( $one_match_tbl['fusen'] == 1 && $one_match_tbl['winner'] == 2 ){
							$pdf .= '不戦勝' . "\n";
						} else if( $one_match_tbl['place'] != 'no_match' ){
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_1'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_2'] );
							$pdf .= $c->get_waza_name( $one_match_tbl['waza2_3'] );
						}
						$pdf .= '</td>' . "\n";
						if( $level == 0 ){
							$pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja">('.$one_match_tbl['team2']['pref'].')</td>' . "\n";
							$namespan2 = $table_name_rowspan - 1;
							$name_index++;
						}
						$trpos2[$level]++;
						$trofs2[$level] = 0;
					} else {
						if( $trspan2[$level] > 0 ){
							$trspan2[$level]--;
						} else {
							$win = '';
							if( $level == $tournament_data['data']['match_level']-2 ){
								if( ( $line <= $line2 && $one_match_tbl['winner'] == 1 )
									|| ( $line > $line2 && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							} else {
								if( ( $line <= $trmatch2[$level] && $one_match_tbl['winner'] == 1 )
									|| ( $line > $trmatch2[$level] && $one_match_tbl['winner'] == 2 )
								){
									$win = '_win';
								}
							}
							$pdf .= '<td height="'.$table_height.'" class="div_border_l'.$win.' div_result_one_tournament2"></td>' . "\n";
						}
						if( $level == 0 ){
							if( $namespan2 > 0 ){
								$namespan2--;
							} else {
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
								$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
							}
						}
					}
				} else {
					if( $trspan2[$level] > 0 ){
						$trspan2[$level]--;
					} else {
						$pdf .= '<td height="'.$table_height.'" class="div_border_none2 div_result_one_tournament"></td>';
					}
					if( $level == 0 ){
						if( $namespan2 > 0 ){
							$namespan2--;
						} else {
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_num" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td>' . "\n";
							$pdf .= '<td height="'.$table_height.'" class="div_result_tournament_name_pref" lang="ja"></td>' . "\n";
						}
					}
				}
				$allend = 0;
			}
			if( $allend == 1 ){ break; }
			$line++;
			$pdf .= "\n".'      </tr>' . "\n";
if( $line == 3000 ){ break; }
		}

		$pdf .= '    </div>' . "\n";
		$pdf .=  '    </table>' . "\n";
		$pdf .=  '  <br /><br /><br />' . "\n";
		$pdf .=  '  </div>' . "\n";
		$pdf .= "\n";
		$pdf .= '<script>'."\n";
		$pdf .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
		$pdf .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
		$pdf .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
		$pdf .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
		$pdf .= "\n";
		$pdf .= '  ga(\'create\', \'UA-67305136-1\', \'auto\');'."\n";
		$pdf .= '  ga(\'send\', \'pageview\');'."\n";
		$pdf .= "\n";
		$pdf .= '</script>'."\n";
		$pdf .=  '</body>' . "\n";
		$pdf .=  '</html>' . "\n";

		$fp = fopen( $path, 'w' );
		fwrite( $fp, $pdf );
		fclose( $fp );
//echo $pdf;
//exit;
		//return $pdf;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_league_for_Excel( $objPage, $path, $series_info, $league_list, $entry_list, $mw )
	{
//print_r($league_list);
        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_name = 'dl_' . $series_info['result_prefix'] . $mw . '.xls';
        $file_path = $path . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/leagueChartBase3.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '第13回 松代藩文武学校旗争奪全国中学校選抜剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　リーグ結果' );
		$col = 0;
		$row = 4;
		$colStr = 'Q';
		$param = get_league_parameter_5();
		$html = '';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$match_tbl = $param['chart_tbl'];
			$team_num = intval( $league_list[$league_data]['team_num'] );
			//print_r($match_tbl);
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*4+1, $row, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col+$dantai_index_row*4+1, $row+1, '('.$ev['school_address_pref_name'].')' );
					}
				}
			}
			for( $dantai_index_row=0; $dantai_index_row<$league_list[$league_data]['team_num']; $dantai_index_row++ ){
				foreach( $entry_list as $ev ){
					if( $league_list[$league_data]['team'][$dantai_index_row]['team'] == $ev['id'] ){
						$html .= $ev['school_name_ryaku'].'<br />('.$ev['school_address_pref_name'].')';
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+2, $ev['school_name'] );
						$sheet->setCellValueByColumnAndRow( $col, $row+$dantai_index_row*2+3, '('.$ev['school_address_pref_name'].')' );
					}
				}
				$html .= '        </td>'."\n";
				for( $dantai_index_col=0; $dantai_index_col<$league_list[$league_data]['team_num']; $dantai_index_col++ ){
					$match_no_index = $match_tbl[$dantai_index_row][$dantai_index_col];
					$match_team_index = $param['chart_team_tbl'][$dantai_index_row][$dantai_index_col];
					if( $match_team_index == 1 ){
						$html .= '        <td class="td_right">'."\n";
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/cir.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner']==2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/tri.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/squ.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon1']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win1']
							);
						}
					} else {
						if( $match_no_index > 0 && $league_list[$league_data]['match'][$match_no_index-1]['end_match'] == 5 ){
							$cord = $objPage->get_excel_coordinates( $col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2 );
							if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 2 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/cir.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else if( $league_list[$league_data]['match'][$match_no_index-1]['winner'] == 1 ){
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/tri.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							} else {
								$objDrawing = new PHPExcel_Worksheet_Drawing();
								$objDrawing->setName( $cord );
								$objDrawing->setDescription( $cord );
								$objDrawing->setPath(dirname(__FILE__).'/squ.png');
								$objDrawing->setWidth(42);
								$objDrawing->setHeight(42);
								$objDrawing->setWorksheet($sheet);
								$objDrawing->setCoordinates( $cord );
								$objDrawing->setOffsetX(4);
								$objDrawing->setOffsetY(10);
							}
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+2,
								$league_list[$league_data]['match'][$match_no_index-1]['hon2']
							);
							$sheet->setCellValueByColumnAndRow(
								$col+$dantai_index_col*4+2, $row+$dantai_index_row*2+3,
								$league_list[$league_data]['match'][$match_no_index-1]['win2']
							);
						}
					}
				}
				$sheet->setCellValueByColumnAndRow(
					$col+13, $row+$dantai_index_row*2+2,
					($league_list[$league_data]['team'][$dantai_index_row]['point']/2)
				);
				$sheet->setCellValueByColumnAndRow(
					$col+14, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['win']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+15, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['hon']
				);
				$sheet->setCellValueByColumnAndRow(
					$col+16, $row+$dantai_index_row*2+2,
					$league_list[$league_data]['team'][$dantai_index_row]['standing']
				);
			}
			if( ( $league_data % 4 ) == 3 ){
				$col += 18;
				$row = 4;
			} else {
				$row += 9;
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_league_match_for_excel( $objPage, $path, $series_info, $league_list, $entry_list, $mw )
	{
        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
		$file_name = 'dlm_' . $series_info['result_prefix'] . $mw . '.xls';
        $file_path = $path . '/' . $file_name;
		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/leagueResultsBase3.xls');
		$excel->setActiveSheetIndex( 0 );		//何番目のシートに有効にするか
		$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		//$sheet->setCellValueByColumnAndRow( 0, 1, '第13回 松代藩文武学校旗争奪全国中学校選抜剣道大会' );
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦　リーグ結果' );
		$col = 0;
		$row = 5;
		$colStr = 'Q';
		for( $league_data = 0; $league_data < count( $league_list ); $league_data++ ){
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][0], $entry_list, $mw, 46, 42 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][2], $entry_list, $mw, 46, 42 );
			$row += 6;
			$objPage->output_one_match_for_excel( $sheet, $col, $row, $series_info, $league_list[$league_data]['match'][1], $entry_list, $mw, 46, 42 );
			$row += 6;
			if( ( $league_data % 4 == 3 ) ){
				$col += 24;
				$row = 5;
				$ofs = intval( $league_data / 4 );
				if( $ofs == 0 ){
					$colStr = 'AO';
				} else if( $ofs == 1 ){
					$colStr = 'BM';
				} else if( $ofs == 2 ){
					$colStr = 'CK';
				}
			}
		}
		$writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
		$writer->save( $file_path );
		return $file_name;
	}

	function output_dantai_tournament_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_list, $entry_list, $mw )
    {
//print_r($tournament_list);
//exit;

        if( $mw == 'm' ){
            $mwstr = '男子';
        } else if( $mw == 'w' ){
            $mwstr = '女子';
        } else {
            $mwstr = '';
        }
        $kmatch = $tournament_param['match_num'];
        $level_num = $tournament_param['match_level'];

        require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
        require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
        $file_name = 'dt_' . $series_info['result_prefix'] . $mw . '.xlsx';
        $file_path = $path . '/' . $file_name;
        $excel = new PHPExcel();
        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

        if( $tindex > 1 ){
            $excel->createSheet();
        }
        $excel->setActiveSheetIndex( $tindex-1 );        //何番目のシートに有効にするか
        $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
        $sheet->setTitle( sprintf('%d',$tindex) );
        $sheet->getDefaultStyle()->getFont()->setName('ＭＳ Ｐゴシック');
        $sheet->getDefaultStyle()->getFont()->setSize(9);
		$sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体戦 トーナメント結果' );
        $sheet->getStyle('A2')->getFont()->setSize(16);
        $sheet->getRowDimension(1)->setRowHeight(12);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(12);
        $sheet->getRowDimension(4)->setRowHeight(12);

        $styleArrayH = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayV = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayV2 = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000')
                )
            )
        );
        $styleArrayHR = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $styleArrayVR = array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $styleArrayVR2 = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FFFF0000')
                )
            )
        );
        $match_level = intval( $tournament_data['match_level'] );
        $tournament_team_num = intval( $tournament_data['tournament_team_num'] );
        $tournament_team_num2 = intval( $tournament_data['tournament_team_num']/2 );
        $col = 0;
        $row = 5;
        $index = 1;
        for( $team = 0; $team < $tournament_team_num; $team++ ){
            if( $team == $tournament_team_num2 ){
                $col = ( $match_level + 1 ) * 2 + 2;
                $row = 5;
            }
            if( $tournament_data['team'][$team]['id'] == 0 ){ continue; }
            if( $team < $tournament_team_num2 ){
                $sheet->setCellValueByColumnAndRow( $col, $row, $index );
                $sheet->setCellValueByColumnAndRow( $col+1, $row, $tournament_data['team'][$team]['name'] );
            } else {
                $sheet->setCellValueByColumnAndRow( $col, $row, $tournament_data['team'][$team]['name'] );
                $sheet->setCellValueByColumnAndRow( $col+1, $row, $index );
            }
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col) . ($row+3);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $mg_range1 = PHPExcel_Cell::stringFromColumnIndex($col+1) . $row;
            $mg_range2 = PHPExcel_Cell::stringFromColumnIndex($col+1) . ($row+3);
            $sheet->mergeCells( $mg_range1 . ':' . $mg_range2 );
            $sheet->getStyle($mg_range1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($mg_range1)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $row += 4;
            $index++;
        }

        $col1 = 3;
        $col2 = 3 + $match_level * 2 - 1;
        $posTbl1 = array();
        $posTbl2 = array();
        $posTbl3 = array();
        $posTbl4 = array();
        $match_num = $tournament_team_num2;
        $match_num2 = intval( $tournament_team_num2 / 2 );
        for( $level = 0; $level < $match_level-1; $level++ ){
            $col = $col1;
            $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
            $row = 5;
            $pindex = 0;
            $match_no_top = $match_num - 1;
            for( $m = 0; $m < $match_num; $m++ ){
                $mup = intval( $m / 2 );
                $moffset = $m % 2;
                if( $m == $match_num2 ){
                    $col = $col2;
                    $colstr = PHPExcel_Cell::stringFromColumnIndex( $col );
                    $row = 5;
                }
                $match = $match_no_top + $m;
                if( $tournament_data['match'][$match]['place'] == 'no_match' ){
                    $up = intval( ( $match + 1 ) / 2 ) - 1;
                    if( $level > 0 ){
                        $r = $posTbl1[$m];
                    } else {
                        $r = $row + 2;
                    }
                    $red = 1;
                    if(
                        ( ( $match % 2 ) == 1 && $tournament_data['match'][$up]['winner'] == 1 )
                        || ( ( $match % 2 ) == 0 && $tournament_data['match'][$up]['winner'] == 2 )
                    ){
                        $sheet->getStyle( $colstr.$r )->applyFromArray( $styleArrayHR );
                        $red = 0;
                    } else {
                        $sheet->getStyle( $colstr.$r )->applyFromArray( $styleArrayH );
                    }
                    if( $moffset == 0 ){
                        $posTbl1[$mup] = $r;
                        $posTbl3[$mup] = $red;
                    } else {
                        $posTbl2[$mup] = $r;
                        $posTbl4[$mup] = $red;
                    }
                    if( $tournament_data['match'][$match]['team1'] != 0 || $tournament_data['match'][$match]['team2'] != 0 ){
                        $row += 4;
                    }
                } else {
                    if( $level > 0 ){
                        $r1 = $posTbl1[$m];
                        $r2 = $posTbl2[$m];
                        $n1 = $posTbl3[$m];
                        $n2 = $posTbl4[$m];
                    } else {
                        $r1 = $row + 2;
                        $r2 = $row + 6;
                        $n1 = 0;
                        $n2 = 0;
                    }
                    $r3 = intval( ( $r1 + $r2 ) / 2 );
                    if( $moffset == 0 ){
                        $posTbl1[$mup] = $r3;
                        $posTbl3[$mup] = 0;
                    } else {
                        $posTbl2[$mup] = $r3;
                        $posTbl4[$mup] = 0;
                    }
                    $winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][$match] );
                    $sheet->mergeCells( $colstr.($r1-2).':'.$colstr.($r1-1) );
                    if( $m >= $match_num2 ){
                        $sheet->setCellValue( $colstr.($r1-2), $winstr[1][2].' '.$winstr[1][1] );
                        $sheet->getStyle($colstr.($r1-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    } else {
                        $sheet->setCellValue( $colstr.($r1-2), $winstr[1][1].' '.$winstr[1][2] );
                        $sheet->getStyle($colstr.($r1-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->getStyle($colstr.($r1-2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    if( $tournament_data['match'][$match]['winner'] == 1 ){
                        $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayHR );
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayVR2 );
                        } else {
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayVR );
                        }
                    } else {
                        if( $level > 0 && $n1 == 0 ){
                            $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayHR );
                        } else {
                            $sheet->getStyle( $colstr.$r1 )->applyFromArray( $styleArrayH );
                        }
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayV2 );
                        } else {
                            $sheet->getStyle( $colstr.$r1.':'.$colstr.($r3-1) )->applyFromArray( $styleArrayV );
                        }
                    }
                    if( $tournament_data['match'][$match]['winner'] == 2 ){
                        $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayHR );
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayVR2 );
                        } else {
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayVR );
                        }
                    } else {
                        if( $level > 0 && $n2 == 0 ){
                            $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayHR );
                        } else {
                            $sheet->getStyle( $colstr.$r2 )->applyFromArray( $styleArrayH );
                        }
                        if( $m >= $match_num2 ){
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayV2 );
                        } else {
                            $sheet->getStyle( $colstr.$r3.':'.$colstr.($r2-1) )->applyFromArray( $styleArrayV );
                        }
                    }
                    $sheet->mergeCells( $colstr.($r2).':'.$colstr.($r2+1) );
                    if( $m >= $match_num2 ){
                        $sheet->setCellValue( $colstr.($r2), $winstr[2][2].' '.$winstr[2][1] );
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    } else {
                        $sheet->setCellValue( $colstr.($r2), $winstr[2][1].' '.$winstr[2][2] );
                        $sheet->getStyle($colstr.($r2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    }
                    $sheet->getStyle($colstr.($r2))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $row += 8;
                }
            }
            $col1++;
            $col2--;
            $match_num = $match_num2;
            $match_num2 = intval( $match_num / 2 );
        }

        $col1 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 2 );
        $col2 = PHPExcel_Cell::stringFromColumnIndex( $match_level + 3 );
        $row = $posTbl1[0];
        $winstr = $objPage->get_tounament_chart_winstring_for_excel( $tournament_data['match'][0] );
        $sheet->setCellValue( $col1.($row), $winstr[1][1].' '.$winstr[1][2] );
        $sheet->mergeCells( $col1.($row).':'.$col1.($row+1) );
        $sheet->getStyle($col1.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col1.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1.($row-2).':'.$col1.($row-1) )->applyFromArray( $styleArrayVR );
            $sheet->setCellValue( $col1.($row-4), $tournament_data['match'][0]['team1_name'] );
            $sheet->mergeCells( $col1.($row-4).':'.$col2.($row-3) );
            $sheet->getStyle($col1.($row-4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1.($row-4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayHR );
            $sheet->getStyle( $col2.($row-2).':'.$col2.($row-1) )->applyFromArray( $styleArrayVR2 );
            $sheet->setCellValue( $col1.($row-4), $tournament_data['match'][0]['team2_name'] );
            $sheet->mergeCells( $col1.($row-4).':'.$col2.($row-3) );
            $sheet->getStyle($col1.($row-4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col1.($row-4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        } else {
            $sheet->getStyle( $col1.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col2.$row )->applyFromArray( $styleArrayH );
            $sheet->getStyle( $col1.($row-2).':'.$col1.($row-1) )->applyFromArray( $styleArrayV );
        }
        $sheet->setCellValue( $col2.($row), $winstr[2][2].' '.$winstr[2][1] );
        $sheet->mergeCells( $col2.($row).':'.$col2.($row+1) );
        $sheet->getStyle($col2.($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($col2.($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        for( $row = 0; $row < $tournament_player_num2 * 4; $row++ ){
            $sheet->getRowDimension($row+5)->setRowHeight(8);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(0))->setWidth(2.5+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(1))->setWidth(12.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(2))->setWidth(2.5+0.71+0.17);
        for( $col = 0; $col < $match_level-1; $col++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+3))->setWidth(5.0+0.71+0.17);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level-2))->setWidth(6.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level-1))->setWidth(6.0+0.71+0.17);
        for( $col = 0; $col < $match_level-1; $col++ ){
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+4+$match_level))->setWidth(5.0+0.71+0.17);
        }
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2-1))->setWidth(2.5+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2))->setWidth(12.0+0.71+0.17);
        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex(4+$match_level*2+1))->setWidth(2.5+0.71+0.17);

        $row = $tournament_team_num2 * 4 + 5 + 2;

        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        $sheet->setCellValueByColumnAndRow( 0, $row, '順位' );
        $sheet->getStyle('A'.($row))->getFont()->setSize(16);
        $sheet->getRowDimension($row)->setRowHeight(20);
        $row++;
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '優勝' );
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team1_name'] );
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team2_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '準優勝' );
        if( $tournament_data['match'][0]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team2_name'] );
        } else if( $tournament_data['match'][0]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][0]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '３位' );
        if( $tournament_data['match'][1]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][1]['team2_name'] );
        } else if( $tournament_data['match'][1]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][1]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);
        $row++;
        $sheet->setCellValueByColumnAndRow( 1, $row, '３位' );
        if( $tournament_data['match'][2]['winner'] == 1 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][2]['team2_name'] );
        } else if( $tournament_data['match'][2]['winner'] == 2 ){
            $sheet->setCellValueByColumnAndRow( 2, $row, $tournament_data['match'][2]['team1_name'] );
        }
        $sheet->getStyle('A'.($row).':F'.$row)->getFont()->setSize(12);
        $sheet->getRowDimension($row)->setRowHeight(16);

            $tindex++;
        }

        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
	}

	function output_dantai_tournament_match_for_excel( $objPage, $path, $series_info, $tournament_param, $tournament_list, $entry_list, $mw )
	{
        $levelstrtbl = array( '一', '二', '三', '四', '五' );

		if( $mw == 'm' ){
			$mwstr = '男子';
		} else if( $mw == 'w' ){
			$mwstr = '女子';
		} else {
			$mwstr = '';
		}
        $kmatch = $tournament_param['match_num'];
        $level_num = $tournament_param['match_level'];
        if( $level_num <= 4 ){
            $colnum = 1;
            $rownum = 16;
        } else if( $level_num == 5 ){
            $colnum = 2;
            $rownum = 16;
        } else if( $level_num == 6 ){
            $colnum = 2;
            $rownum = 32;
        } else if( $level_num == 7 ){
            $colnum = 4;
            $rownum = 32;
        }

		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/phpExcel/Classes/PHPExcel/IOFactory.php';
        $file_name = 'dtm_' . $series_info['result_prefix'] . $mw . '.xlsx';
        $file_path = $path . '/' . $file_name;

		$reader = PHPExcel_IOFactory::createReader('Excel5');
		$excel = $reader->load(dirname(__FILE__).'/admin/dantaiTournamentMatchResultsBase.xls');
        $tindex = 1;
        foreach( $tournament_list as $tournament_data ){

    		$excel->setActiveSheetIndex( $tindex-1 );		//何番目のシートに有効にするか
	    	$sheet = $excel->getActiveSheet();	//有効になっているシートを取得
		    $sheet->setCellValueByColumnAndRow( 0, 2, $mwstr.'団体トーナメント結果' );

    		$col = 0;
	    	$row = 4;
            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col))->setWidth(10.0);
            for( $i1 = 1; $i1 < 26; $i1++ ){
                $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+$i1))->setWidth(2.33);
            }
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
            $match_index = 1;
            for( $level = $tournament_data['match_level']; $level >= 1; $level-- ){
                if( $level >= 4 ){
                    $levelstr = $levelstrtbl[$tournament_data['match_level']-$level] . '回戦';
                } else if( $level == 3 ){
                    $levelstr = '準々決勝';
                } else if( $level == 2 ){
                    $levelstr = '準決勝';
                } else if( $level == 1 ){
                    $levelstr = '決勝';
                }

//print_r($entry_list);
//print_r($tournament_data);
//exit;
                $match_level_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tournament_data['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){
                        continue;
                    }
                    if( $level == 1 ){
                        $sheet->setCellValueByColumnAndRow( $col, $row, $levelstr );
                    } else {
                        $sheet->setCellValueByColumnAndRow( $col, $row, $levelstr. ' 第'.$match_level_index.'試合' );
                    }
                    $row++;
                    for( $r = 0; $r < 5; $r++ ) {
                        for( $c = 0; $c < 24; $c++ ){
                            // セルを取得
                            $cell = $sheet->getCellByColumnAndRow($c, $r+5);
                            // セルスタイルを取得
                            $style = $sheet->getStyleByColumnAndRow($c, $r+5);
                            // 数値から列文字列に変換する (0,1) → A1
                            $offsetCell = PHPExcel_Cell::stringFromColumnIndex($col+$c) . (string)($row + $r);
                            // セル値をコピー
                            $sheet->setCellValue($offsetCell, $cell->getValue());
                            // スタイルをコピー
                            $sheet->duplicateStyle($style, $offsetCell);

                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+1).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+3).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+4).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+6).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+7).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+9).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+10).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+12).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+13).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+15).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+16).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+19).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+20).$row.':'.PHPExcel_Cell::stringFromColumnIndex($col+22).$row;
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col).($row+2);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+1).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+3).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+4).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+6).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+7).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+9).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+10).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+12).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+13).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+15).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+16).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+16).($row+2);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+19).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+19).($row+2);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+20).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+22).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col).($row+3).':'.PHPExcel_Cell::stringFromColumnIndex($col).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+1).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+3).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+4).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+6).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+7).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+9).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+10).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+12).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+13).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+15).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+16).($row+3).':'.PHPExcel_Cell::stringFromColumnIndex($col+16).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+19).($row+3).':'.PHPExcel_Cell::stringFromColumnIndex($col+19).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+20).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+22).($row+4);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+17).($row+1).':'.PHPExcel_Cell::stringFromColumnIndex($col+18).($row+1);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+17).($row+2).':'.PHPExcel_Cell::stringFromColumnIndex($col+18).($row+2);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+17).($row+3).':'.PHPExcel_Cell::stringFromColumnIndex($col+18).($row+3);
                            $sheet->mergeCells( $mg_range );
                            $mg_range = PHPExcel_Cell::stringFromColumnIndex($col+17).($row+4).':'.PHPExcel_Cell::stringFromColumnIndex($col+18).($row+4);
                            $sheet->mergeCells( $mg_range );
                        }
                    }
                    $row += 5;
                    $match_level_index++;
                    if( ( $match_index % $rownum ) == 0 ){
                        $col += 26;
                        $row = 4;
                        $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col))->setWidth(10.0);
                        for( $i2 = 1; $i2 < 26; $i2++ ){
                            $sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($col+$i2))->setWidth(2.33);
                        }
                    }
                    $match_index++;
                }
                $match_no_top /= 2;
            }
    		$col = 0;
	    	$row = 5;
            $match_no_top = 1;
            for( $i1 = 1; $i1 < $tournament_data['match_level']; $i1++ ){ $match_no_top *= 2; }
            $match_index = 1;
            for( $level = $tournament_data['match_level']; $level >= 1; $level-- ){
                $match_level_index = 1;
                for( $i1 = 1; $i1 <= $match_no_top; $i1++ ){
                    if( $tournament_data['match'][$match_no_top+$i1-2]['place'] === 'no_match' ){
                        continue;
                    }
                    $this->output_one_match_for_excel( $sheet, $col, $row+1, $series_info, $tournament_data['match'][$match_no_top+$i1-2], $entry_list, $mw, 46, 46 );
                    $row += 6;
                    $match_level_index++;
                    if( ( $match_index % $rownum ) == 0 ){
                        $col += 26;
                        $row = 5;
break;
                    }
                    $match_index++;
                }
                $match_no_top /= 2;
            }
            $tindex++;
        }

        $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel2007' );
        $writer->save( $file_path );
        return $file_name;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

}
?>
