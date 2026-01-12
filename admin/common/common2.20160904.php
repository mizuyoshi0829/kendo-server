<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'config.php';

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

class common
{
	//---------------------------------------------------------------
	//
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

	function get_pref_array3()
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

	function get_pref_array2()
	{
		$tbl = array(
			array( 'value' => 1, 'title' => '北<br />海<br />道' ),
			array( 'value' => 2, 'title' => '青<br />森<br />県' ),
			array( 'value' => 3, 'title' => '岩<br />手<br />県' ),
			array( 'value' => 4, 'title' => '宮<br />城<br />県' ),
			array( 'value' => 5, 'title' => '秋<br />田<br />県' ),
			array( 'value' => 6, 'title' => '山<br />形<br />県' ),
			array( 'value' => 7, 'title' => '福<br />島<br />県' ),
			array( 'value' => 8, 'title' => '茨<br />城<br />県' ),
			array( 'value' => 9, 'title' => '栃<br />木<br />県' ),
			array( 'value' => 10, 'title' => '群<br />馬<br />県' ),
			array( 'value' => 11, 'title' => '埼<br />玉<br />県' ),
			array( 'value' => 12, 'title' => '千<br />葉<br />県' ),
			array( 'value' => 13, 'title' => '東<br />京<br />都' ),
			array( 'value' => 14, 'title' => '神<br />奈<br />川<br />県' ),
			array( 'value' => 15, 'title' => '新<br />潟<br />県' ),
			array( 'value' => 16, 'title' => '富<br />山<br />県' ),
			array( 'value' => 17, 'title' => '石<br />川<br />県' ),
			array( 'value' => 18, 'title' => '福<br />井<br />県' ),
			array( 'value' => 19, 'title' => '山<br />梨<br />県' ),
			array( 'value' => 20, 'title' => '長<br />野<br />県' ),
			array( 'value' => 21, 'title' => '岐<br />阜<br />県' ),
			array( 'value' => 22, 'title' => '静<br />岡<br />県' ),
			array( 'value' => 23, 'title' => '愛<br />知<br />県' ),
			array( 'value' => 24, 'title' => '三<br />重<br />県' ),
			array( 'value' => 25, 'title' => '滋<br />賀<br />県' ),
			array( 'value' => 26, 'title' => '京<br />都<br />府' ),
			array( 'value' => 27, 'title' => '大<br />阪<br />府' ),
			array( 'value' => 28, 'title' => '兵<br />庫<br />県' ),
			array( 'value' => 29, 'title' => '奈<br />良<br />県' ),
			array( 'value' => 30, 'title' => '和<br />歌<br />山<br />県' ),
			array( 'value' => 31, 'title' => '鳥<br />取<br />県' ),
			array( 'value' => 32, 'title' => '島<br />根<br />県' ),
			array( 'value' => 33, 'title' => '岡<br />山<br />県' ),
			array( 'value' => 34, 'title' => '広<br />島<br />県' ),
			array( 'value' => 35, 'title' => '山<br />口<br />県' ),
			array( 'value' => 36, 'title' => '徳<br />島<br />県' ),
			array( 'value' => 37, 'title' => '香<br />川<br />県' ),
			array( 'value' => 38, 'title' => '愛<br />媛<br />県' ),
			array( 'value' => 39, 'title' => '高<br />知<br />県' ),
			array( 'value' => 40, 'title' => '福<br />岡<br />県' ),
			array( 'value' => 41, 'title' => '佐<br />賀<br />県' ),
			array( 'value' => 42, 'title' => '長<br />崎<br />県' ),
			array( 'value' => 43, 'title' => '熊<br />本<br />県' ),
			array( 'value' => 44, 'title' => '大<br />分<br />県' ),
			array( 'value' => 45, 'title' => '宮<br />崎<br />県' ),
			array( 'value' => 46, 'title' => '鹿<br />児<br />島<br />県' ),
			array( 'value' => 47, 'title' => '沖<br />縄<br />県' )
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

	function get_pref_order( $no )
	{
		$tbl = array(
			0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
			11, 12, 13, 14, 16, 17, 18, 19, 15, 47,
			20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
			30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
			40, 41, 42, 43, 44, 45, 46
		);
		return $tbl[$no];
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
		for( $i1 = 1; $i1 <= $tournament_data['place_num']; $i1++ ){
			$tbl[] = array( 'value' => $i1, 'title' => '第'.$i1.'会場' );
		}
		return $tbl;
	}

	function get_place_array_with_no_match( $tournament_data )
	{
		$tbl = array();
		$tbl[] = array( 'value' => 'no_match', 'title' => 'シード' );
		for( $i1 = 1; $i1 <= $tournament_data['place_num']; $i1++ ){
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
		for( $i1 = 1; $i1 <= 20; $i1++ ){
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

	function get_kaisai_pref()
	{
		return 20;
	}

	//---------------------------------------------------------------

	function get_pref_area( $pref )
	{
		$tbl = array(
			1, 2, 2, 2, 2, 2, 2, 3, 3, 3,
			3, 3, 3, 3, 4, 4, 4, 4, 3, 4,
			5, 5, 5, 5, 6, 6, 6, 6, 6, 6,
			7, 7, 7, 7, 7, 8, 8, 8, 8, 9,
			9, 9, 9, 9, 9, 9, 9
		);

		if( $pref < 1 || $pref > 47 ){ return 0; }
		return $tbl[$pref-1];
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
}

?>
