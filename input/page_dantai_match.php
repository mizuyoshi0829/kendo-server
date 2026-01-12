<?php

class form_page_dantai_match
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $this->__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_referee_list( $series )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `referee` where `series`='.$series.' order by `id` asc';
		return db_query_list( $dbs, $sql );
    }

	function set_dantai_referee( $match, $no, $id )
	{
		if( $match == 0 ){ return; }
		if( $no == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `dantai_match` set `referee'.$no.'`='.$id.' where `id`='.$match;
//echo $sql;
		db_query( $dbs, $sql );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function output_dantai_one_match_pdf( $navi_id, $place, $place_match_no, $match )
	{
        require_once dirname(dirname(__FILE__))."/mpdf60/mpdf.php";
        $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n"
            . '<html xmlns="http://www.w3.org/1999/xhtml">'."\n"
            . '<head>'."\n"
            . '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'."\n"
            . '<title>試合結果</title>'."\n"
            . '<style>'."\n"
            . 'body {'."\n"
            . '    font-family: ipa;'."\n"
            . '    font-size: 13pt;'."\n"
            . '    background-color: #ffffff;'."\n"
            . '    margin: 0;'."\n"
            . '    padding: 0;'."\n"
            . '    color: #000;'."\n"
            . '}'."\n"
            . 'ul, ol, dl { padding: 0; margin: 0; }'."\n"
            . 'h1, h2, h3, h4, h5, h6, p { margin-top: 0; padding-right: 15px; padding-left: 15px; }'."\n"
            . 'a img { border: none; }'."\n"
            . 'a:link { color:#414958; text-decoration: underline; }'."\n"
            . 'a:visited { color: #4E5869; text-decoration: underline; }'."\n"
            . '.container {'."\n"
            . '    width: 1100px;'."\n"
            . '    max-width: 1100px;'."\n"
            . '    min-width: 1100px;'."\n"
            . '    background-color: #FFF;'."\n"
            . '    margin: 32px;'."\n"
            . '    text-align: center;'."\n"
            . '}'."\n"
            . '.content { width: 1050px; padding: 10px 0; float: left; }'."\n"
            . '.content ul, .content ol { padding: 0 15px 15px 40px; }'."\n"
            . '.fltrt { float: right; margin-left: 8px; }'."\n"
            . '.fltlft { float: left; margin-right: 8px; }'."\n"
            . '.clearfloat { clear:both; height:0; font-size: 1px; line-height: 0px; }'."\n"
            . '.tb_score_in { font-family: ipa; text-align: center; width: 1000px; padding-left: 5px; border: none; }'."\n"
            . '.tb_score_title { font-size: 22px; font-weight: bold; text-align: left; width: 160px; padding-left: 5px; 	border: none; float: left; }'."\n"
            . '.tb_score_title2 { text-align: left; width: 440px; padding-left: 5px; border: none; float: left; }'."\n"
            . '.tb_srect { text-align: center; width: 40px; height: 320px; font-size: 24px; line-height: 110%; float: left; border: none; }'."\n"
            . '.tb_srect_content { margin: 5% 19% 0 19%; text-align: center; border: none; line-height: 110%; height: 100%; width: 60%; }'."\n"
            . '.tb_frame { text-align: center; width: 100px; height: 240px; float: left; border: 1px solid #000000; }'."\n"
            . '.tb_frame_title { text-align: center; height: 24px; border: none; }'."\n"
            . '.tb_frame_content { margin: 5% 19% 0 19%; text-align: center; border: none; font-size: 64px; line-height: 95%; height: 200px; width: 60%; position:relative; }'."\n"
            . '.tb_frame_content2 { margin: 5% 19% 0 19%; text-align: center; border: none; font-size: 58px; line-height: 95%; height: 220px; width: 60%; position:relative; }'."\n"
            . '.tb_frame_content2_smallfont6 { font-size: 46px; }'."\n"
            . '.tb_frame_content2_smallfont7 { font-size: 40px; }'."\n"
            . '.tb_frame_content2_smallfont8 { font-size: 37px; }'."\n"
            . '.tb_frame_content2_smallfont9 { font-size: 32px; }'."\n"
            . '.tb_frame_content2_smallfont10 { font-size: 29px; }'."\n"
            . '.tb_frame_content2_smallfont11 { font-size: 24px; }'."\n"
            . '.tb_frame_content2_smallfont12 { font-size: 22px; }'."\n"
            . '.tb_frame_content2_smallfont13 { font-size: 20px; }'."\n"
            . '.tb_frame_content2_smallfont14 { font-size: 18px; }'."\n"
            . '.tb_frame_content2_smallfont15 { font-size: 16px; }'."\n"
            . '.tb_frame_hoin_player { background-color: #ffaaaa; }'."\n"
            . '.tb_frame_result_content { margin: 50% 4% 0 4%; text-align: center; border: none; font-size: 40px; line-height: 105%; height: 30%; width: 90%; position:relative; }'."\n"
            . '.tb_frame_result_hon { position:absolute; top: 8%; left: 5%; text-align: center; border: none; width: 90%; }'."\n"
            . '.tb_frame_result_win { position:absolute; top: 51%; left: 5%; text-align: center; border-top: 2px solid #000000; width: 90%; }'."\n"
            . '.tb_frame_result_win_dai { position:absolute; top: 80%; left: 80%; text-align: center; border:none; font-size: 24px; }'."\n"
            . '.tb_frame_btop { border-top: 1px solid #000000; }'."\n"
            . '.tb_frame_bbottom { border-bottom: 1px solid #000000; }'."\n"
            . '.tb_frame_waza { text-align: center; height: 20px; }'."\n"
            . '.tb_frame_waza1 { text-align: center; color: #ff0000; border: none; font-size: 20px; width: 28px; height: 30px; float: left; margin-top: -4px; }'."\n"
            . '.tb_frame_waza2 { text-align: center; color: #ff0000; border: none; font-size: 20px; width: 32px; height: 34px; float: left; margin: -12px 0 0 -4px; }'."\n"
            . '.tb_frame_faul { text-align: center; border: none; height: 20px; position:relative; font-size: 36px; margin-top: -12px; padding-bottom: 8px; }'."\n"
            . '.tb_frame_faul1 { text-align: center; border: none; font-size: 16px; width: 30px; height: 20px; float: left; }'."\n"
            . '.tb_frame_faul_extra { text-align: center; border: 1px solid #000000; width: 24px; position:absolute; top: 12%; left: 60%; font-size: 18px; z-index: 10; }'."\n"
            . '.tb_frame_ippon { text-align: center; border: none; width: 24px; position:absolute; top: 260px; left: 75%; font-size: 18px; line-height: 105%; }'."\n"
            . '.tb_frame_draw { text-align: center; border: none; width: 60px; height: 60px; position:absolute; top: 260px; left: 0px; font-size: 88px; }'."\n"
            . '.tb_frame_name_add { margin-left: -24px; font-size: 48px; }'."\n"
            . '.tbprefnamehalf { text-align: center; width: 50px; float: left; }'."\n"
            . '.tx-h1 { font-family: ipa; font-size: large; color: #003; }'."\n"
            . '.tx-small { font-size: small; text-align: center; }'."\n"
            . '.rb-large { font-family: ipa; font-size: 18px; text-align: center; }'."\n"
            . '.tx-large { font-size: 36px; text-align: center; }'."\n"
            . '.tx-name { font-size: 24px; text-align: left; }'."\n"
            . '.result-circle { display: inline-block; width: 100%; height: 100%; background: #ffffff; -moz-border-radius: 100%; -webkit-border-radius: 100%; -o-border-radius: 100%; -ms-border-radius: 100%; border-radius: 100%; border: 1px solid #000000; }'."\n"
            . '.result-triangle { display: inline-block; width: 100%; height: 100%; }'."\n"
            . '.result-triangle .tri-image { width: 100%; height: 100%; }'."\n"
            . '.result-triangle__:before, .result-triangle__:after { content: ""; display: block; position: relative; width: 0; height: 0; top: 0px; }'."\n"
            . '.result-triangle__:before { border-bottom: 100px solid #000000; border-left: 50px solid transparent; border-right: 50px solid transparent; top: 0px; z-index: 5; }'."\n"
            . '.result-triangle__:after { border-bottom: 100px solid #CCCCCC; border-left: 50px solid transparent; border-right: 50px solid transparent; top: 0px; top: 1px; z-index: 10; }'."\n"
            . '.result-square { display: inline-block; width: 100%; height: 100%; background: #FFFFFF; border: 1px solid #000000; }'."\n"
            . '</style>'."\n"
            //. '<link href="realtime.css" rel="stylesheet" type="text/css" />'."\n"
            . '</head>'."\n"
            . ''."\n"
            . '<body>'."\n"
            . '<div class="container">'."\n"
            . '  <div class="content" id="score">'."\n"
            . output_realtime_html_for_one_board( $navi_id, $place, $place_match_no )
            . '</div>'."\n"
            . '</div>'."\n"
            . '</body>'."\n"
            . '</html>'."\n";
            $fdate = date('YmdHis') . sprintf("%04d",microtime()*1000);
            $fp = fopen( dirname(dirname(__FILE__)).'/log/output.'.$fdate.'.html', 'w' );
            fwrite( $fp, $html );
            fclose( $fp );

set_time_limit(600);
ini_set( 'memory_limit', '256M' );
        $JpFontName = 'ipapgothic';
        $mpdf = new mPDF( 'ja+aCJK', 'A4-L', 5, 'ipa', 10, 10, 10, 10, 0, 0 ); 
        $mpdf->SetDisplayMode( 'fullpage' );
        $mpdf->fontdata[$JpFontName] = array( 'R' => 'ipag.ttf' );
        $mpdf->available_unifonts[] = $JpFontName;
        $mpdf->default_available_fonts[] = $JpFontName;
        $mpdf->BMPonly[] = $JpFontName;
        $mpdf->SetDefaultFont($JpFontName);
        // LOAD a stylesheet
        //$stylesheet = file_get_contents( dirname(__FILE__).'/realtime.css' );
        //$mpdf->WriteHTML( $stylesheet, 1 );  // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->autoLangToFont = true;
        $mpdf->restrictColorSpace = 1;
        $mpdf->WriteHTML( $html );
        //    header( 'Content-Type: application/octet-stream' );
        //    header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
        //    header( 'Content-Length: '.filesize($file_path) );
        //    ob_end_clean();//ファイル破損エラー防止
        $mpdf->Output( dirname(dirname(__FILE__)).'/output/match'.$match.'.pdf', 'F' );


    }


	function output_dantai_one_match_pdf2( $navi_id, $place, $place_match_no )
    {
        require_once( dirname(dirname(__FILE__))."/tcpdf/tcpdf.php" );

        $match_info = $this->__pageObj->get_series_place_navi_data( $navi_id, $place, $place_match_no );
//print_r($match_info);
        $match = $match_info['match_id'];
        if( isset( $_SESSION['auth'] ) ){
            $_SESSION['auth']['year'] = $match_info['year'];
        } else {
            $_SESSION['auth'] = array( 'year' => $match_info['year'] );
        }
        if( $match_info['series_lt'] != 'dl' && $match_info['series_lt'] != 'dt' ){ return; }
        if( $match_info['series_lt'] == 'dl' ){
            $data = $this->__pageObj->get_dantai_league_one_result( $match );
        } else {
            $data = $this->__pageObj->get_dantai_tournament_one_result( $match );
        }
//print_r($data);
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
            $winner = -1;
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
                                if( $data['exist_match6'] == 0 ){
                                    $result1 = 0;
                                    $result1str = '□';
                                    $result2 = 0;
                                    $result2str = '□';
                                    $winner = 0;
                                    break;
                                }
                            }
                        }
                        $match_end = 1;
                    }
                }
                if( $i1 <= 5 ){
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
                    if( $data['matches'][$i1]['end_match'] == 1 ){
                        $endnum++;
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
                        $match_end = 1;
                    }
                }
            }
        }

        $pdf = new TCPDF("L", "mm", "A4", true, "UTF-8" ); // 297x210
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setTextColor(0);
        $pdf->AddPage();
        $font = new TCPDF_FONTS();
        // フォント：IPAゴシック
        $font_1 = $font->addTTFfont( dirname(dirname(__FILE__)).'/tcpdf/fonts/ttf/ipagp.ttf' );
        $b1 = array( 'width' => 0.15, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $b2 = array( 'width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0) );
        $title_x = 20;
        $title_xstep = 50;
        $title_y = 10;
        $lineheight = 5;
        $offset = 0;
        $score_x1 = 20;
        $score_xstep = 28;
        $score_xstep2 = 14;
        $score_xstep4 = 7;
        $score_xstep8 = 3;
        $score_x2 = $score_x1 + $score_xstep;
        $score_x3 = $score_x1 + $score_xstep * 2;
        $score_x4 = $score_x1 + $score_xstep * 3;
        $score_x5 = $score_x1 + $score_xstep * 4;
        $score_x6 = $score_x1 + $score_xstep * 5;
        $score_x7 = $score_x1 + $score_xstep * 6;
        $score_x8 = $score_x1 + $score_xstep * 7;
        $score_x9 = $score_x1 + $score_xstep * 8;
        $score_x10 = $score_x1 + $score_xstep * 9;
        $score_y1 = 30;
        $score_y2 = 40;
        $score_y3 = 90;
        $score_y4 = 115;
        $score_y5 = 125;
        $score_y6 = 140;
        $score_y7 = 190;
        $score_hon1_y = ( $score_y4 + $score_y2 ) / 2;
        $score_hon2_y = ( $score_y7 + $score_y4 ) / 2;

        $pdf->SetFont($font_1 , '', 24,'',true);
        $pdf->MultiCell( $title_xstep, 20, $match_info['place_name'], 0, 'L', false, 0, $title_x, $title_y, true, 0, false, false, 20, 'M', false );
        $pdf->MultiCell( $title_xstep, 20, '第'.$match_info['place_match_no'].'試合', 0, 'L', false, 0, $title_x+$title_xstep, $title_y, true, 0, false, false, 20, 'M', false );

        $pdf->SetLineStyle( $b1 );
        $pdf->Rect( $score_x1, $score_y1, $score_xstep*9, $score_y7-$score_y1, 'D', array('all' => $b2), array() );
        for( $i1 = 1; $i1 <= 8; $i1++ ){
            $pdf->Line( $score_x1+$score_xstep*$i1, $score_y1, $score_x1+$score_xstep*$i1, $score_y7, $b2 );
        }
        $pdf->Line( $score_x1, $score_y2, $score_x10, $score_y2, $b2 );
        $pdf->Line( $score_x2, $score_y3, $score_x7, $score_y3, $b2 );
        $pdf->Line( $score_x8, $score_y3, $score_x9, $score_y3, $b2 );
        $pdf->Line( $score_x1, $score_y4, $score_x10, $score_y4, $b2 );
        $pdf->Line( $score_x2, $score_y6, $score_x7, $score_y6, $b2 );
        $pdf->Line( $score_x8, $score_y6, $score_x9, $score_y6, $b2 );
        $pdf->Line( $score_x9, $score_y5, $score_x10, $score_y5, $b2 );

        $pdf->SetFont($font_1 , '', 15,'',true);
        $pdf->MultiCell( $score_xstep, 10, 'チーム名', 0, 'C', false, 0, $score_x1, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '先鋒', 0, 'C', false, 0, $score_x2, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '次鋒', 0, 'C', false, 0, $score_x3, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '中堅', 0, 'C', false, 0, $score_x4, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '副将', 0, 'C', false, 0, $score_x5, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '大将', 0, 'C', false, 0, $score_x6, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '結果', 0, 'C', false, 0, $score_x7, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '代表戦', 0, 'C', false, 0, $score_x8, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, 10, '主審', 0, 'C', false, 0, $score_x9, $score_y1, true, 0, false, false, 10, 'M', false );
        $pdf->MultiCell( $score_xstep, $score_y5-$score_y4, '副審', 0, 'C', false, 0, $score_x9, $score_y4, true, 0, false, false, $score_y5-$score_y4, 'M', false );

        $pdf->SetFont($font_1 , '', 42,'',true);
        $pdf->MultiCell( $score_xstep, $score_y4-$score_y2, get_field_string($data['entry1'],'school_name_ryaku'), 0, 'C', false, 0, $score_x1, $score_y2, true, 0, false, false, $score_y4-$score_y2, 'M', false );
        $pdf->MultiCell( $score_xstep, $score_y7-$score_y4, get_field_string($data['entry2'],'school_name_ryaku'), 0, 'C', false, 0, $score_x1, $score_y4, true, 0, false, false, $score_y7-$score_y4, 'M', false );
        for( $i1 = 1; $i1 <= 6; $i1++ ){
            if( $i1 == 6 ){
                $pos = $score_x8;
            } else {
                $pos = $score_x1 + $score_xstep * $i1;
            }
            if( $data['matches'][$i1]['player1'] == 0 ){
                $name = '';
            } if( $data['matches'][$i1]['player1'] == __PLAYER_NAME__ ){
                $name = $data['matches'][$i1]['player1_change_name'];
            } else {
                if( $match_info['series_mw'] === '' ){
                    $f = 'player'.$data['matches'][$i1]['player1'];
                    $f2 = 'player';
                } else {
                    //$f = 'player'.$data['matches'][$i1]['player1'].'_'.$match_info['series_mw'];
                    //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                    $f = 'player'.$data['matches'][$i1]['player1'];
                    $f2 = 'player';
                }
                if( $data['entry1'][$f.'_disp'] != '' ){
                    $name = $data['entry1'][$f.'_disp'];
                } else {
                    $name = $data['entry1'][$f.'_sei'];
                    for( $fi = 1; $fi <= 7; $fi++ ){
                        $name2 = $data['entry1'][$f2.$fi.'_sei'];
                        if( $fi != $data['matches'][$i1]['player1'] && $name2 != '' && $name == $name2 ){
                            $add1 = mb_substr( $data['entry1'][$f.'_mei'], 0, 1 );
                            $add2 = mb_substr( $data['entry1'][$f2.$fi.'_mei'], 0, 1 );
                            if( $add1 == $add2 ){
                                $add1 = mb_substr( $data['entry1'][$f.'_mei'], 1, 1 );
                            }
                            $name = ( '<br />(' . $add1 . ')' );
                            break;
                        }
                    }
                }
            }
            $pdf->MultiCell( $score_xstep, $score_y3-$score_y2, $name, 0, 'C', false, 0, $pos, $score_y2, true, 0, true, false, $score_y3-$score_y2, 'M', false );
            if( $data['matches'][$i1]['player2'] == 0 ){
                $name = '';
            } if( $data['matches'][$i1]['player2'] == __PLAYER_NAME__ ){
                $name = $data['matches'][$i1]['player2_change_name'];
            } else {
                if( $match_info['series_mw'] === '' ){
                    $f = 'player'.$data['matches'][$i1]['player2'];
                    $f2 = 'player';
                } else {
                    //$f = 'player'.$data['matches'][$i1]['player1'].'_'.$match_info['series_mw'];
                    //$f = 'dantai_'.$match_info['series_mw'].$data['matches'][$i1]['player1'];
                    $f = 'player'.$data['matches'][$i1]['player2'];
                    $f2 = 'player';
                }
                if( $data['entry2'][$f.'_disp'] != '' ){
                    $name = $data['entry2'][$f.'_disp'];
                } else {
                    $name = $data['entry2'][$f.'_sei'];
                    for( $fi = 1; $fi <= 7; $fi++ ){
                        $name2 = $data['entry2'][$f2.$fi.'_sei'];
                        if( $fi != $data['matches'][$i1]['player2'] && $name2 != '' && $name == $name2 ){
                            $add1 = mb_substr( $data['entry2'][$f.'_mei'], 0, 1 );
                            $add2 = mb_substr( $data['entry2'][$f2.$fi.'_mei'], 0, 1 );
                            if( $add1 == $add2 ){
                                $add1 = mb_substr( $data['entry2'][$f.'_mei'], 1, 1 );
                            }
                            $name = ( '<br />(' . $add1 . ')' );
                            break;
                        }
                    }
                }
            }
            $pdf->MultiCell( $score_xstep, $score_y7-$score_y6, $name, 0, 'C', false, 0, $pos, $score_y6, true, 0, true, false, $score_y7-$score_y6, 'M', false );

            if( $data['matches'][$i1]['end_match'] == 1 ){
                $fusen = false;
                for( $i2 = 1; $i2 <= 3; $i2++ ){
                    if( $data['matches'][$i1]['waza1_'.$i2] == 5 || $data['matches'][$i1]['waza2_'.$i2] == 5 ){
                        $fusen = true;
                        break;
                    }
                }
                if( !$fusen ){
                    if( ( $hon1[$i1] == 1 && $hon2[$i1] == 0 ) || ( $hon1[$i1] == 0 && $hon2[$i1] == 1 ) ){
                        if( $data['matches'][$i1]['extra'] == 0 ){
                            $pdf->MultiCell( $score_xstep2, $score_y6-$score_y3, '一本勝', 0, 'C', false, 0, $pos+$score_xstep2, $score_y3, true, 0, false, false, $score_y6-$score_y3, 'M', false );
                        }
                    } else if( $hon1[$i1] == $hon2[$i1] ){
                        $pdf->MultiCell( $score_xstep, $score_y6-$score_y3, '×', 0, 'C', false, 0, $pos, $score_y3, true, 0, false, false, $score_y6-$score_y3, 'M', false );
                    }
                }
            }
            $waza = '';
            for( $i2 = 1; $i2 <= 3; $i2++ ){
                if($data['matches'][$i1]['waza1_'.$i2]==0){ $waza .=   '　'; }
                if($data['matches'][$i1]['waza1_'.$i2]==1){ $waza .=   'メ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==2){ $waza .=   'ド'; }
                if($data['matches'][$i1]['waza1_'.$i2]==3){ $waza .=   'コ'; }
                if($data['matches'][$i1]['waza1_'.$i2]==4){ $waza .=   '反'; }
                if($data['matches'][$i1]['waza1_'.$i2]==5){ $waza .=   '○'; }
                if($data['matches'][$i1]['waza1_'.$i2]==6){ $waza .=   'ツ'; }
            }
            $pdf->MultiCell( $score_xstep, 15, $faul, 0, 'L', false, 0, $pos, $score_y3, true, 0, false, false, 15, 'M', false );
            $faul = '';
            if( $data['matches'][$i1]['faul1_1'] == 2 ){ $faul .=   '指'; }
            if( $data['matches'][$i1]['faul1_2'] == 1 ){ $faul .=   '▲'; }
            $pdf->MultiCell( $score_xstep, 15, $faul, 0, 'L', false, 0, $pos, $score_y4-15, true, 0, false, false, 15, 'M', false );
            if( $data['matches'][$i1]['extra'] == 1 ){
                $pdf->MultiCell( $score_xstep2, $score_y6-$score_y3, '延長', 0, 'C', false, 0, $pos+$score_xstep2, $score_y3, true, 0, false, false, $score_y6-$score_y3, 'M', false );
            }
        }
        $pdf->SetFont($font_1 , '', 24,'',true);
        $pdf->MultiCell( $score_xstep2, $score_y4-$score_y2, string_insert_br($data['referee1_name']), 0, 'C', false, 0, $score_x9+$score_xstep4, $score_y2, true, 0, true, false, $score_y4-$score_y2, 'M', false );
        $pdf->MultiCell( $score_xstep2, $score_y7-$score_y5, string_insert_br($data['referee2_name']), 0, 'C', false, 0, $score_x9, $score_y5, true, 0, true, false, $score_y7-$score_y5, 'M', false );
        $pdf->MultiCell( $score_xstep2, $score_y7-$score_y5, string_insert_br($data['referee3_name']), 0, 'C', false, 0, $score_x9+$score_xstep2, $score_y5, true, 0, true, false, $score_y7-$score_y5, 'M', false );

        $pdf->MultiCell( $score_xstep, 15, $hon1sum, 0, 'C', false, 0, $score_x7, $score_hon1_y-15, true, 0, false, false, 15, 'M', false );
        $pdf->MultiCell( $score_xstep, 15, $win1sum, 0, 'C', false, 0, $score_x7, $score_hon1_y, true, 0, false, false, 15, 'M', false );
        $pdf->Line( $score_x7+$score_xstep4, $score_hon1_y, $score_x8-$score_xstep4, $score_hon1_y, $b2 );
        $pdf->MultiCell( $score_xstep, 15, $hon2sum, 0, 'C', false, 0, $score_x7, $score_hon2_y-15, true, 0, false, false, 15, 'M', false );
        $pdf->MultiCell( $score_xstep, 15, $win2sum, 0, 'C', false, 0, $score_x7, $score_hon2_y, true, 0, false, false, 15, 'M', false );
        $pdf->Line( $score_x7+$score_xstep4, $score_hon2_y, $score_x8-$score_xstep4, $score_hon2_y, $b2 );
        if( $winner == 2 ){
            $pdf->Polygon(
                array(
                    $score_x7+$score_xstep8, $score_hon1_y+$score_xstep2,
                    $score_x7+$score_xstep2, $score_hon1_y-$score_xstep2,
                    $score_x8-$score_xstep8, $score_hon1_y+$score_xstep2
                ),
                'D', array('all' => $b2), array(), true
            );
            $pdf->Circle( $score_x7+$score_xstep2, $score_hon2_y, $score_xstep4+$score_xstep8, 0, 360, 'D', $b2, array(), 2 );
        } else if( $winner == 1 ){
            $pdf->Circle( $score_x7+$score_xstep2, $score_hon1_y, $score_xstep4+$score_xstep8, 0, 360, 'D', $b2, array(), 2 );
            $pdf->Polygon(
                array(
                    $score_x7+$score_xstep8, $score_hon2_y+$score_xstep2,
                    $score_x7+$score_xstep2, $score_hon2_y-$score_xstep2,
                    $score_x8-$score_xstep8, $score_hon2_y+$score_xstep2
                ),
                'D', array('all' => $b2), array(), true
            );
            //$html .= '          <span class="result-triangle"><img class="tri-image" src="tri.png" /></span>'."\n";
        } else if( $winner == 0 ){
            $pdf->Rect( $score_x7+$score_xstep8, $score_hon1_y-$score_xstep2, $score_xstep2+$score_xstep4, $score_xstep, 'D', array('all' => $b2), array() );
            $pdf->Rect( $score_x7+$score_xstep8, $score_hon2_y-$score_xstep2, $score_xstep2+$score_xstep4, $score_xstep, 'D', array('all' => $b2), array() );
        }


//        if( $data['exist_match6'] == 1 && $winner == 2 ){
//            $html .= '          <div class="tb_frame_result_win_dai">代</div>'."\n";
//        }


        $pdf->Output("output.pdf", "D");
return;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_dantai_match_info( $match )
	{
		if( $match == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_match`.*,'
			. ' `dantai_league`.`series` as `series`,'
			. ' `dantai_league`.`series_mw` as `series_mw`'
			. ' from `dantai_league_match` inner join `dantai_league` on `dantai_league`.`id`=`dantai_league_match`.`league` where `dantai_league_match`.`match`='.$match;
		$dantai_league_match = db_query_list( $dbs, $sql );
		if( count( $dantai_league_match ) > 0 ){
			return array(
				'series' => intval( $dantai_league_match[0]['series'] ),
				'series_mw' => $dantai_league_match[0]['series_mw'],
				'league' => intval( $dantai_league_match[0]['league'] )
			);
		}
		$sql = 'select `dantai_tournament_match`.*,'
			. ' `dantai_tournament`.`series` as `series`,'
			. ' `dantai_tournament`.`series_mw` as `series_mw`'
			. ' from `dantai_tournament_match` inner join `dantai_tournament` on `dantai_tournament`.`id`=`dantai_tournament_match`.`tournament` where `dantai_tournament_match`.`match`='.$match;
		$dantai_tournament_match = db_query_list( $dbs, $sql );
//print_r($dantai_tournament_match);
		if( count( $dantai_tournament_match ) > 0 ){
			return array(
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

	function set_dantai_team( $navi_id, $match, $team, $team_id )
	{
		if( $match == 0 ){ return; }
		if( $team == 0 ){ return; }
		//if( $team_id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update `dantai_match` set `team'.$team.'`='.$team_id.' where `id`='.$match;
		db_query( $dbs, $sql );
//echo $sql;
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
    		            $f = 'player'.$data['matches'][$i1]['player1'].'_'.$series_mw;
        				//$f = 'dantai_'.$series_mw.$data['matches'][$i1]['player1'];
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
   			    	$f = 'player'.$data['matches'][6]['player1'].'_'.$series_mw;
    			    //$f = 'dantai_'.$series_mw.$data['matches'][6]['player1'];
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
    			    	$f = 'player'.$data['matches'][$i1]['player2'].'_'.$series_mw;
    				    //$f = 'dantai_'.$series_mw.$data['matches'][$i1]['player2'];
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
   			        $f = 'player'.$data['matches'][6]['player2'].'_'.$series_mw;
    			    //$f = 'dantai_'.$series_mw.$data['matches'][6]['player2'];
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



}

