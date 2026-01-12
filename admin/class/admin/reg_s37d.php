<?php
//--------------------------------------------------------------
    function __get_entry_data_list2_105_106( $series )
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `entry_info`'
            .' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
            .' order by `disp_order` asc';
        $list = db_query_list( $dbs, $sql );
        $sql = 'select * from `entry_field` where `field` in (\'school_name\',\'join\') and `year`='.$_SESSION['auth']['year'];
        $field_list = db_query_list( $dbs, $sql );

        $ret1 = array();
        $ret2 = array();
        foreach( $list as $lv ){
            $id = intval( $lv['id'] );
            $lv['join'] = 0;
            $lv['school_name'] = '';
            foreach( $field_list as $fv ){
                $info = intval( $fv['info'] );
                if( $id == $info ){
                    if( $fv['field'] == 'school_name' ){
                        $lv['school_name'] = $fv['data'];
                    } else if( $fv['field'] == 'join' ){
                        $lv['join'] = intval( $fv['data'] );
                    }
                }
            }
            if( $lv['join'] == 1 ){
                $ret1[] = $lv;
            } else {
                $ret2[] = $lv;
            }
        }
        db_close( $dbs );

        return array_merge( $ret1, $ret2 );
    }

    function get_entry_data_list2_105()
    {
        return __get_entry_data_list2_105_106( 105 );
    }

    function get_entry_data_list2_106()
    {
        return __get_entry_data_list2_105_106( 106 );
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

	function __output_tournament_105_for_HTML( $series_info, $tournament_list, $entry_list, $mv, $cssparam )
	{
        $objPage = new form_page();
		if( $mv == 'm' ){
			$mvstr = '男子';
			$table_name_rowspan = 3;
			$table_name_name_width = 148;
			$table_name_pref_width = 120;
			$table_height = 11; //6;
			$table_font_size = 18; //11;
			$table_place_font_size = 8; //6;
			$table_cell_width = 40; //30;
		} else {
			$mvstr = '女子';
			$table_name_rowspan = 3;
			$table_name_name_width = 120;
			$table_name_pref_width = 120;
			$table_height = 11;
			$table_font_size = 18; //11;
			$table_place_font_size = 8; //6;
			$table_cell_width = 40;
		}

		$break_html = null;
		$break_html_name = null;
        if( $cssparam != null ){
			$table_name_rowspan = $cssparam['table_name_rowspan'];
			$table_name_name_width = $cssparam['table_name_name_width'];
			$table_name_name_font_size = $cssparam['table_name_name_font_size'];
			$table_name_name_font_size2 = $cssparam['table_name_name_font_size2'];
			$table_name_pref_width = $cssparam['table_name_pref_width'];
			$table_height = $cssparam['table_height'];
			$table_font_size = $cssparam['table_font_size'];
			$table_place_font_size = $cssparam['table_place_font_size'];
			$table_cell_width = $cssparam['table_cell_width'];
            $return_path = get_field_string( $cssparam, 'return_path' );
			if( isset($cssparam['break_html']) ){
				$break_html = $cssparam['break_html'];
			}
			if( isset($cssparam['break_html_name']) ){
				$break_html_name = $cssparam['break_html_name'];
			}
        }
        if( $return_path == '' ){
            $return_path = 'index_' . $navi_info['result_prefix'] . $mw . '.html';
        }
		if( $break_html === null ){
			$break_html = [];
	        for( $tournament_index = 0; $tournament_index < count($tournament_data['data']); $tournament_index++ ){
				$break_html[] = true;
			}
		}
		if( $break_html_name === null ){
			$break_html_name = [];
	        for( $tournament_index = 1; $tournament_index <= count($tournament_data['data']); $tournament_index++ ){
				$break_html_name[] = 'k' . $mw . $tournament_index;
			}
		}

		$table_win_border_size = '2px';
        $table_normal_border_size = '1px';

		$pdf_header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n"
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
			. '    width: 980px;' . "\n"
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
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid 1px #ffffff;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_b2_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid 1px #ffffff;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid 1px #000000;' . "\n"
			. '    border-left: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '    border-left: none;' . "\n"
			. '}' . "\n"
			. '.div_border_br_final2 {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
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
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_r_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: none;' . "\n"
			. '    border-right: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_bl {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid 1px #000000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_win {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
			. '}' . "\n"
			. '.div_border_bl_up {' . "\n"
			. '    border-top: none;' . "\n"
			. '    border-bottom: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-left: solid 1px #000000;' . "\n"
			. '    border-right: none;' . "\n"
            . '    height: '.($table_height-1).'px;' . "\n"
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
			. '    border-left: solid '.$table_win_border_size.' #ff0000;' . "\n"
			. '    border-right: none;' . "\n"
			. '    padding: 0 0 1px 0;' . "\n"
            . '    width: '.($table_cell_width-1).'px;' . "\n"
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
			. '</style>' . "\n";

        $tindex = 1;
        $pdf = $pdf_header . '<H1 style="border-bottom: solid 1px #000000;" lang="ja">団体戦：小学生の部&nbsp;結果</H1>' . "\n"
            . '<h2 align="left" class="tx-h1"><a href="'.$return_path.'">←戻る</a></h2>'."\n"
			. '<div class="container">' . "\n"
			. '  <div class="content">' . "\n";
//$pdf .= "<!--\n";
//$pdf .= print_r($tournament_data,true);
//$pdf .= "-->\n";
        foreach( $tournament_list as $tournament_index => $tournament_data ){
    		$tournament_name_width = 150;
	    	$tournament_name_name_left = 0;
		    $tournament_name_pref_left = 80;
		    $tournament_name_num_left = 140;
		    $tournament_width = 40;
		    $tournament_height = 20;
		    $tournament_height2 = 11;
            if( $tournament_data['match_level'] == 1 ){
                $pdf .= '<div class="div_result_tournament_name_name">' . $tournament_data['tournament_name']. '</div>' . "\n";
                $pdf .= '  <br /><br /><br />' . "\n";
                $pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
                $pdf .= '<tr>' . "\n";
                $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['match'][0]['team1_name'] . '</td>' . "\n";
                $pdf .= '<td height="'.$table_height.'" class="div_border_b';
                if( $tournament_data['match'][0]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td>' . "\n";
                $pdf .= '</tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][0]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][0]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament">';
                if( $tournament_data['match'][0]['winner'] != 0 ){
                    $pdf .= $tournament_data['match'][0]['win1'] . ' - ' . $tournament_data['match'][0]['win2'];
                }
                $pdf .= '&nbsp;&nbsp;</td><td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td><td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
                if( $tournament_data['match'][0]['winner'] == 1 ){
                    $pdf .= $tournament_data['match'][0]['team1_name'];
                } else if( $tournament_data['match'][0]['winner'] == 2 ){
                    $pdf .= $tournament_data['match'][0]['team2_name'];
                }
                $pdf .= '</td></tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][0]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
                $pdf .= '<tr>' . "\n";
                $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'
                    . $tournament_data['match'][0]['team2_name']
                    . '<td height="'.$table_height.'" class="div_border_br';
                if( $tournament_data['match'][0]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td>' . "\n";
                $pdf .= '</tr>' . "\n";
                $pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
                $pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";

                $pdf .= '  </table>' . "\n";
                $pdf .= '  <br /><br /><br />' . "\n";
            } else {
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
        						$pref = ''; //$ev['school_address_pref_name'];
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
        				$one_match['team1'] = array(
        					'pos' => $team_pos * 4 + 1, 'id' => $id, 'name' => $name, 'pref' => $pref, 'index' => $team_index
        				);
        				$match_no++;
        				if( $one_match['place'] != 'no_match' || $id > 0 ){
                            $team_pos++;
                            $team_index++;
                        }
        			} else {
        				$one_match['team2'] = array(
        					'pos' => $team_pos * 4 + 1, 'id' => $id, 'name' => $name, 'pref' => $pref, 'index' => $team_index
        				);
        				if( $one_match['place'] != 'no_match' || $id > 0 ){
        					$team_pos++;
        					$team_index++;
        				}
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
        //$pdf .= print_r($match_tbl,true);
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
        					//	$one_match['match_no'] = $tournament_data['match'][$match_no-1]['dantai_tournament_match_id'];
        						$one_match['match_no'] = $tournament_data['match'][$match_no-1]['match'];
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
//$pdf .= print_r($match_tbl,true);

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
                                if( $one_match_tbl['place'] === 'no_match' && $one_match_tbl['team1']['id'] == 0 ){
                                    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
                                } else {
                                    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
                                }
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
        							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
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
        								$pdf .= $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '　';
        								//$pdf .= '<a href_="'.sprintf('%03d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>　';
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
        					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;">'.$tournament_data['match'][0]['win1'].' -'.'</td>';
        					$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"> '.$tournament_data['match'][0]['win2'].'</td>';
        					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: right;"><a href="'.sprintf('%03d',$one_match_tbl['match_no']-1).'.html">'.$tournament_data['match'][0]['win1'].' -'.'</a></td>';
        					//$pdf .= '<td height="'.$table_height.'" class="div_border_none div_result_one_tournament" style="text-align: left;"><a href="'.sprintf('%03d',$one_match_tbl['match_no']-1).'.html"> '.$tournament_data['match'][0]['win2'].'</a></td>';
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
                                if( $one_match_tbl['place'] === 'no_match' && $one_match_tbl['team1']['id'] == 0 ){
                                    $pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['index'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team2']['name'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
                                } else {
                                    $pdf .= '<td class="div_result_tournament_name_num" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['index'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">'.$one_match_tbl['team1']['name'].'</td>' . "\n";
                                    $pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
                                }
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
        							$pdf .= '<td class="div_result_tournament_name_pref" rowspan="'.$table_name_rowspan.'" lang="ja"></td>' . "\n";
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
        								$pdf .= '　' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'];
        								//$pdf .= '　<a href_="'.sprintf('%03d',$one_match_tbl['match_no']).'.html">' . $one_match_tbl['win1'] . ' - ' . $one_match_tbl['win2'] . '</a>';
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
        		$pdf .= '    </table>' . "\n";
        		$pdf .= '  <br /><br /><br /><br /><br /><br />' . "\n";
            }
            if( $tournament_data['extra_match_num'] > 0 ){
                $extra_match_index = $tournament_data['tournament_team_num'] - 1;
                $pdf .= '<div class="div_result_tournament_name_name">' . $tournament_data['extra_name']. '</div>' . "\n";
                $pdf .= '  <br /><br /><br />' . "\n";
                $pdf .= '  <table style="border-collapse: separate; border-spacing: 0;">' . "\n";
                $pdf .= '<tr>' . "\n";
                $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['match'][$extra_match_index]['team1_name'] . '</td>' . "\n";
                $pdf .= '<td height="'.$table_height.'" class="div_border_b';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td>' . "\n";
                $pdf .= '</tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td></tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 1 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament">';
                if( $tournament_data['match'][$extra_match_index]['winner'] != 0 ){ $pdf .= $tournament_data['match'][$extra_match_index]['win1'] . ' - ' . $tournament_data['match'][$extra_match_index]['win2']; }
                $pdf .= '&nbsp;&nbsp;</td><td height="'.$table_height.'" class="div_border_b_win div_result_one_tournament"></td><td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 1 ){
                    $pdf .= $tournament_data['match'][$extra_match_index]['team1_name'];
                } else if( $tournament_data['match'][$extra_match_index]['winner'] == 2 ){
                    $pdf .= $tournament_data['match'][$extra_match_index]['team2_name'];
                }
                $pdf .= '</td></tr>' . "\n";
                $pdf .= '<tr><td height="'.$table_height.'" class="div_result_tournament_name_name" lang="ja"></td><td height="'.$table_height.'" class="div_border_r';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></tr>' . "\n";
                $pdf .= '<tr>' . "\n";
                $pdf .= '<td class="div_result_tournament_name_name" rowspan="'.$table_name_rowspan.'" lang="ja">' . $tournament_data['match'][$extra_match_index]['team2_name'] . '<td height="'.$table_height.'" class="div_border_br';
                if( $tournament_data['match'][$extra_match_index]['winner'] == 2 ){ $pdf .= '_win'; }
                $pdf .= ' div_result_one_tournament"></td></td>' . "\n";
                $pdf .= '</tr>' . "\n";
                $pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
                $pdf .= '<tr><td class="div_result_tournament_name_name" height="'.$table_height.'" lang="ja"></td></tr>' . "\n";
    
                $pdf .= '  </table>' . "\n";
                $pdf .= '  <br /><br /><br />' . "\n";
            }
    		if( !$break_html[$tournament_index] ){
    			continue;
    		}
    
    		$pdf .= '<h2 align="left" class="tx-h1"><a href="'.$return_path.'">←戻る</a></h2>'."\n";
            $pdf .= '  <br /><br /><br />' . "\n";
    		$pdf .= '  </div>' . "\n";
    		$pdf .= "\n";
    		$pdf .= '<script>'."\n";
    		$pdf .= '  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){'."\n";
    		$pdf .= '  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'."\n";
    		$pdf .= '  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'."\n";
    		$pdf .= '  })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');'."\n";
    		$pdf .= "\n";
    		$pdf .= '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n";
    		$pdf .= '  ga(\'send\', \'pageview\');'."\n";
    		$pdf .= "\n";
    		$pdf .= '</script>'."\n";
    		$pdf .=  '</body>' . "\n";
    		$pdf .=  '</html>' . "\n";
    
//echo $pdf;
//exit;
            //$file = 'dt_' . $series_info['result_prefix'] . $mv . $tindex;
    		$file = $break_html_name[$tournament_index];
            $path = $series_info['result_path'] . '/' . $file . '.html';
    		$fp = fopen( $path, 'w' );
    		fwrite( $fp, $pdf );
    		fclose( $fp );
    		$data = [
    			'mode' => 2,
    			'navi' => $series_info['navi_id'],
    			'place' => $file,
    			'file' => $path,
    			'series' => $series_info['result_path_prefix'],
    		];
    		$objPage->update_realtime_queue( $data );

	        $pdf = $pdf_header . '<H1 style="border-bottom: solid 1px #000000;" lang="ja">団体戦：小学生の部&nbsp;結果</H1>' . "\n"
    	        . '<h2 align="left" class="tx-h1"><a href="'.$return_path.'">←戻る</a></h2>'."\n"
				. '<div class="container">' . "\n"
				. '  <div class="content">' . "\n";
			
    		$tindex++;
        }
	//	return $pdf;
	}

    function output_tournament_105_for_HTML( $series_info, $tournament_data, $entry_list )
    {
        $objPage = new form_page();
        $objTournament = new form_page_dantai_tournament( $objPage );
        $cssparam = [
			'table_name_rowspan' => 3,
			'table_name_name_width' => 104,
			'table_name_name_font_size' => 11,
			'table_name_name_font_size2' => 9,
			'table_name_pref_width' => 88,
			'table_height' => 11,
			'table_font_size' => 11,
			'table_place_font_size' => 6,
			'table_cell_width' => 30,
			'return_path' => 'index_e.html',
			'break_html' => [false,true,true,true],
			'break_html_name' => [
				'dt_e3','dt_e3','dt_e1','dt_e2'
			],
        ];
    	__output_tournament_105_for_HTML( $series_info, $tournament_data, $entry_list, 'w', $cssparam );
        //$objTournament->output_dantai_tournament_for_HTML( $series_info, $tournament_data, $entry_list, 'w', $cssparam );
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

    function __output_tournament_match_for_HTML2_105( $series_info, $tournament_list, $entry_list, $mw )
    {
        $objPage = new form_page();
        $header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n";
        $header .= '<html xmlns="http://www.w3.org/1999/xhtml">'."\n";
        $header .= '<head>'."\n";
        $header .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n";
        $header .= '<title>'.$series_info['dantai_m_name'].'結果</title>'."\n";
        $header .= '<link href="preleague_m.css" rel="stylesheet" type="text/css" />'."\n";
        $header .= '</head>'."\n";
        $header .= '<body>'."\n";
        //$header .= '<!--'."\n";
        //$header .= print_r($tournament_list[2],true) . "\n";
        //$header .= print_r($entry_list,true) . "\n";
        //$header .= '-->'."\n";
        $header .= '<div class="container">'."\n";
        $header .= '  <div class="content">'."\n";

        $footer = '     <h2 align="left" class="tx-h1"><a href="index_e.html">←戻る</a></h2>'."\n";
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
        $footer .= '  ga(\'create\', \'UA-67305136-4\', \'auto\');'."\n";
        $footer .= '  ga(\'send\', \'pageview\');'."\n";
        $footer .= "\n";
        $footer .= '</script>'."\n";
        $footer .= '</body>'."\n";
        $footer .= '</html>'."\n";

        $stbl = ['一回戦','二回戦','三回戦','四回戦','準々決勝','準決勝'];

        $objPage = new form_page();

        for( $lindex = 1; $lindex <= 2; $lindex++ ){
            $tindex = 1;
            $mofs = 32;
            $mnum = 32;
            $level = 0;
            $html = $header . '    <h2>' . $series_info['dantai_m_name'] . '&nbsp;結果</h2>'."\n";
            for(;;){
                $mno = 1;
                for( $i1 = 0; $i1 < $mnum; $i1++ ){
                    if( $tournament_list[$lindex+1]['match'][$mofs+$i1-1]['place'] != 'no_match' ){
                        $html .= '<h3>' . $tournament_list[$lindex+1]['tournament_name'] . '&nbsp;' . $stbl[$level] . '&nbsp;第' . $mno . "試合</h3>\n";
                        $html .= $objPage->output_one_match_for_HTML2( $series_info, $tournament_list[$lindex+1]['match'][$mofs+$i1-1], $entry_list, $mw );
                        $mno++;
                    }
                }
                $mofs /= 2;
                $mnum /= 2;
                if( $level == 1 || $level == 5 ){
                    $html .= $footer;
                    $file = 'dtm_e' . $lindex . '_' . $tindex;
                    $path = $series_info['result_path'] . '/' . $file . '.html';
                    $fp = fopen( $path, 'w' );
                    fwrite( $fp, $html );
                    fclose( $fp );
                    $data = [
                        'mode' => 2,
                        'navi' => $series_info['navi_id'],
                        'place' => $file,
                        'file' => $path,
                        'series' => $series_info['result_path_prefix'],
                    ];
                    $objPage->update_realtime_queue( $data );
                    $tindex++;
                    $html = $header . '    <h2>' . $tournament_list[$lindex+1]['tournament_name'] . '&nbsp;結果</h2>'."\n";
                }
                $level++;
                if( $level == 6 ){ break; }
            }
        }

        $html = $header . '    <h2>' . $series_info['dantai_m_name'] . '&nbsp;結果</h2>'."\n";
        $html .= '<h3>決勝</h3>';
        $html .= $objPage->output_one_match_for_HTML2( $series_info, $tournament_list[0]['match'][0], $entry_list, $mw );
        $html .= '<h3>三位決定戦</h3>';
        $html .= $objPage->output_one_match_for_HTML2( $series_info, $tournament_list[1]['match'][0], $entry_list, $mw );
        $html .= $footer;
        $file = 'dtm_e3';
        $path = $series_info['result_path'] . '/' . $file . '.html';
        $fp = fopen( $path, 'w' );
        fwrite( $fp, $html );
        fclose( $fp );
        $data = [
            'mode' => 2,
            'navi' => $series_info['navi_id'],
            'place' => $file,
            'file' => $path,
            'series' => $series_info['result_path_prefix'],
        ];
        $objPage->update_realtime_queue( $data );
    }

    function output_tournament_match_for_HTML2_105( $series_info, $tournament_list, $entry_list )
    {
        __output_tournament_match_for_HTML2_105( $series_info, $tournament_list, $entry_list, 'm' );
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

