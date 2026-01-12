<?php
//    require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
    require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
    //require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_2b.php';
    //require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_4.php';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_12_13.php';
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_14_15.php';

class form_page_admin_info extends form_page
{
    function init( $series, $edit )
    {
        parent::init( $series, $edit );
    //    $series = get_field_string_number( $_GET, 's', 4 );
        $page = get_field_string_number( $_GET, 'p', 1 );
//$this->save_tournament_place_navi_data_tbl_file( 7, 8, 7, 8, 9, 10, 8 );

        $filter = get_field_string( $_GET, 'f' );
        $mode = get_field_string( $_POST, 'mode' );
        if( $mode == 'auth' ){
/*
            if( $_POST['pass'] == __ADMIN_PASSWORD__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = 2017;
                $series = 3;
            } else if( $_POST['pass'] == __ADMIN_PASSWORD2__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 1;
                $_SESSION['auth']['year'] = 2017;
                $series = 3;
            } else if( $_POST['pass'] == __ADMIN_PASSWORD_2_1__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 1;
                $_SESSION['auth']['year'] = 2017;
                $series = 2;
            } else if( $_POST['pass'] == __ADMIN_PASSWORD_2_2__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = 2017;
                $series = 2;
            } else 
*/
            if( $_POST['pass'] == __ADMIN_PASSWORD_11__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = 2016;
                $series = 11;
            } else if( $_POST['pass'] == __ADMIN_PASSWORD_12__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = 2016;
                $series = 12;
            } else if( $_POST['pass'] == __ADMIN_PASSWORD_16__ ){
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = 2016;
                $series = 16;
            } else {
                $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
                $sql = 'select * from `series` where `deleted` is null and `adminpass`=\''.$_POST['pass'].'\'';
                $sl = db_query_list( $dbs, $sql );
                if( count( $sl ) == 0 ){
                    header( "Location: ".__HTTP_BASE__."admin/login.php");
                    exit;
                }
                $_SESSION['auth']['login'] = 1;
                $_SESSION['auth']['level'] = 2;
                $_SESSION['auth']['year'] = $sl[0]['reg_year'];
                $_SESSION['auth']['series_info_id'] = $sl[0]['id'];
                $_SESSION['auth']['dantai_m_name'] = $sl[0]['dantai_m_name'];
                $_SESSION['auth']['dantai_league_m'] = $sl[0]['dantai_league_m'];
                $_SESSION['auth']['dantai_tournament_m'] = $sl[0]['dantai_tournament_m'];
                $_SESSION['auth']['dantai_w_name'] = $sl[0]['dantai_w_name'];
                $_SESSION['auth']['dantai_league_w'] = $sl[0]['dantai_league_w'];
                $_SESSION['auth']['dantai_tournament_w'] = $sl[0]['dantai_tournament_w'];
                $_SESSION['auth']['kojin_m_name'] = $sl[0]['kojin_m_name'];
                $_SESSION['auth']['kojin_league_m'] = $sl[0]['kojin_league_m'];
                $_SESSION['auth']['kojin_tournament_m'] = $sl[0]['kojin_tournament_m'];
                $_SESSION['auth']['kojin_w_name'] = $sl[0]['kojin_w_name'];
                $_SESSION['auth']['kojin_league_w'] = $sl[0]['kojin_league_w'];
                $_SESSION['auth']['kojin_tournament_w'] = $sl[0]['kojin_tournament_w'];
                $_SESSION['auth']['locked'] = $sl[0]['locked'];
                $_SESSION['auth']['navi_id'] = $sl[0]['navi_id'];
                if( $sl[0]['dantai_league_m'] != 0 ){
                    $series = $sl[0]['dantai_league_m'];
                } else if( $sl[0]['dantai_tournament_m'] != 0 ){
                    $series = $sl[0]['dantai_tournament_m'];
                } else if( $sl[0]['dantai_league_w'] != 0 ){
                    $series = $sl[0]['dantai_league_w'];
                } else if( $sl[0]['dantai_tournament_w'] != 0 ){
                    $series = $sl[0]['dantai_tournament_w'];
                } else if( $sl[0]['kojin_league_m'] != 0 ){
                    $series = $sl[0]['kojin_league_m'];
                } else if( $sl[0]['kojin_tournament_m'] != 0 ){
                    $series = $sl[0]['kojin_tournament_m'];
                } else if( $sl[0]['kojin_league_w'] != 0 ){
                    $series = $sl[0]['kojin_league_w'];
                } else if( $sl[0]['kojin_tournament_w'] != 0 ){
                    $series = $sl[0]['kojin_tournament_w'];
                }
                $serieslist = $sl[0];
            }
        } else {
            if( !isset( $_SESSION['auth'] ) || $_SESSION['auth']['login'] != 1 ){
                $_SESSION['auth'] = array( 'login' => 0 );
                header( "Location: ".__HTTP_BASE__."admin/login.php");
                exit;
            }
            if( $series == 0 ){ $series = $_SESSION['auth']['series']; }
        }
//print_r($serieslist);
        if(
            $series == $_SESSION['auth']['kojin_league_m']
            || $series == $_SESSION['auth']['kojin_tournament_m']
            || $series == $_SESSION['auth']['kojin_league_w']
            || $series == $_SESSION['auth']['kojin_tournament_w']
        ){
            if( $series == $_SESSION['auth']['kojin_league_m'] || $series == $_SESSION['auth']['kojin_tournament_m'] ){
                $this->smarty_assign['category_name'] = $_SESSION['auth']['kojin_m_name'];
            } else {
                $this->smarty_assign['category_name'] = $_SESSION['auth']['kojin_w_name'];
            }
            require_once dirname(dirname(__FILE__)) . '/page_kojin_entry.php';
            require_once dirname(dirname(__FILE__)) . '/page_kojin_tournament.php';
            $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'k.php';
        } else {
            if( $series == $_SESSION['auth']['dantai_league_m'] || $series == $_SESSION['auth']['dantai_tournament_m'] ){
                $this->smarty_assign['category_name'] = $_SESSION['auth']['dantai_m_name'];
            } else {
                $this->smarty_assign['category_name'] = $_SESSION['auth']['dantai_w_name'];
            }
            require_once dirname(dirname(__FILE__)) . '/page_dantai_entry.php';
            require_once dirname(dirname(__FILE__)) . '/page_dantai_match.php';
            require_once dirname(dirname(__FILE__)) . '/page_dantai_league.php';
            require_once dirname(dirname(__FILE__)) . '/page_dantai_tournament.php';
            $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'd.php';
        }
        if( file_exists( $inc ) ){
            require_once $inc;
        }
        $this->smarty_assign['display_navi'] = 1;
        $this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
        $this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
        $org_array = $this->get_org_array();
        $pref_array = $this->get_pref_array();
        $grade_junior_array = $this->get_grade_junior_array();
        $grade_elementary_array = $this->get_grade_elementary_array();
        $yosen_rank_array = $this->get_yosen_rank_array();
        $this->smarty_assign['org_array'] = $this->get_org_array_for_smarty( $org_array );
        $this->smarty_assign['pref_array'] = $this->get_pref_array_for_smarty( $pref_array );
        $this->smarty_assign['grade_junior_array'] = $this->get_grade_junior_array_for_smarty( $grade_junior_array );
        $this->smarty_assign['grade_elementary_array'] = $this->get_grade_elementary_array_for_smarty( $grade_elementary_array );
        $this->smarty_assign['yosen_rank_array'] = $this->get_yosen_rank_array_for_smarty( $yosen_rank_array );
        $this->smarty_assign['root_url'] = '../';
        $this->smarty_assign['post_action'] = 'info.php';
        $this->smarty_assign['filter'] = $filter;
        $this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
        $this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
        if( $mode == 'new' ){
            $_SESSION['p'] = $this->init_entry_post_data();
            $_SESSION['e'] = $this->init_entry_post_data();
            $this->smarty_assign['edit_title'] = '新規登録';
            $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
            return;
        } else if( $mode == 'edit' ){
            $id = get_field_string_number( $_POST, 'id', 0 );
            if( $id > 0 ){
                $_SESSION['p'] = $this->get_entry_one_data2( $id );
                $series = get_field_string_number( $_SESSION['p'], 'series', 7 );
                $serieslist = $this->get_series_list( $series );
                $_SESSION['e'] = $this->init_entry_post_data($series);
                $this->smarty_assign['edit_title'] = 'エントリー編集';
                $this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit.html';
                $this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $series, 1 );
                $this->smarty_assign['seriesinfo'] = $serieslist;
                return;
            }
        } else if( $mode == 'confirm' ){
            if( isset( $_POST['exec'] ) ){
                if( $this->GetFormPostData() != 1 ){
//print_r($_POST);
//print_r($_SESSION);
                    $series = get_field_string_number( $_SESSION['p'], 'series', 7 );
                    $serieslist = $this->get_series_list( $series );
                    $this->smarty_assign['edit_title'] = 'エントリー編集';
                    $this->template = 'admin' . DIRECTORY_SEPARATOR . 'confirm.html';
                    $this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $series, 1 );
                    $this->smarty_assign['seriesinfo'] = $serieslist;
                    return;
                }
            }
            $series = get_field_string_number( $_SESSION['p'], 'series', 7 );
        } else if( $mode == 'exec' ){
            if( isset( $_POST['exec'] ) ){
                if( $_SESSION['auth']['locked'] == 0 ){
                    $this->update_entry_data( $_SESSION['auth']['series'] );
                }
                $this->smarty_assign['mform_msg'] = '内容を登録しました。';
                $series = get_field_string_number( $_SESSION['p'], 'series', 7 );
            } else {
                $series = get_field_string_number( $_SESSION['p'], 'series', 7 );
                $serieslist = $this->get_series_list( $series );
                $this->smarty_assign['edit_title'] = 'エントリー編集';
                $this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit.html';
                $this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $series, 1 );
                $this->smarty_assign['seriesinfo'] = $serieslist;
                return;
            }
        } else if( $mode == 'delete' ){
            if( $_SESSION['auth']['locked'] == 0 ){
                $id = get_field_string_number( $_POST, 'id', 0 );
                if( $id > 0 ){
                    $this->delete_entry_data( $id, 1 );
                }
            }
        } else if( $mode == 'undelete' ){
            if( $_SESSION['auth']['locked'] == 0 ){
                $id = get_field_string_number( $_POST, 'id', 0 );
                if( $id > 0 ){
                    $this->delete_entry_data( $id, 0 );
                }
            }
        } else if( $mode == 'exchange' ){
            if( $_SESSION['auth']['locked'] == 0 ){
                $id = get_field_string_number( $_POST, 'id', 0 );
                $id2 = get_field_string_number( $_POST, 'id2', 0 );
                if( $id > 0 && $id2 > 0 ){
                    $this->ExchangeData( $id, $id2 );
                }
            }
        } else if( $mode == 'sort' ){
            if( $_SESSION['auth']['locked'] == 0 ){
                $this->SortData($series);
            }
        } else if( $mode == 'display' ){
            $id = get_field_string_number( $_POST, 'id', 0 );
            if( $id > 0 ){
                $_SESSION['p'] = $this->get_entry_one_data2( $id );
                $series = get_field_string_number( $_SESSION['p'], 'series', 2 );
                $this->smarty_assign['edit_title'] = '内容表示';
                $this->template = 'admin' . DIRECTORY_SEPARATOR . 'display.html';
                $this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $series, 1 );
                $this->smarty_assign['seriesinfo'] = $serieslist;
                return;
            }
        } else if( $mode == 'loadcsv' ){
            if( $_SESSION['auth']['locked'] == 0 ){
                $this->load_entry_csv( $series, $_FILES["csv_file"]["tmp_name"] );
            }
        }
        $_SESSION['auth']['series'] = $series;
        $serieslist = $this->get_series_list( $series );
        if( $serieslist === false ){
            header( "Location: ".__HTTP_BASE__."admin/login.php");
            exit;
        }
        //$this->smarty_assign['list'] = $this->get_entry_data_list2( $series );
        $func = 'get_entry_data_list2_' . $series;
        $infolist = $func();
        $this->smarty_assign['list'] = $infolist;
        $this->smarty_assign['seriesinfo'] = $serieslist;
        $this->smarty_assign['admin_title'] = $serieslist['name'];
        if( $mode == 'output' ){
//$this->reset_disp_order($series);
//return;
            require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
            require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
            $file_name = 'list' . '_' .date('YmdHis') . sprintf("%04d",microtime()*1000) . '.xls';
            $file_path = $serieslist['output_path'] . '/' . $file_name;
            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $excel = $reader->load(dirname(__FILE__).'/listbase'.$series.'.xls');
            $excel->setActiveSheetIndex( 0 );        //何番目のシートに有効にするか
            $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
            if( $series == 2 ){
                $this->output_entry_data_list_excel2( $sheet );
            } else if( $series == 3 ){
                $this->output_entry_data_list_excel3( $sheet );
            } else if( $series == 4 ){
                $this->output_entry_data_list_excel4( $sheet );
            } else if( $series == 5 ){
                $this->output_entry_data_list_excel5( $sheet );
            } else if( $series == 6 ){
                $this->output_entry_data_list_excel6( $sheet );
            }
            $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
            $writer->save( $file_path );
            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
            header( 'Content-Length: '.filesize($file_path) );
            ob_end_clean();//ファイル破損エラー防止
            readfile( $file_path );
            return;
        }
        if( $mode == 'outputall' ){
            require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel.php';
            require_once dirname(dirname(dirname(__FILE__))).'/phpExcel/Classes/PHPExcel/IOFactory.php';
            $file_name = 'listall' . '_' .date('YmdHis') . sprintf("%04d",microtime()*1000) . '.xls';
            $file_path = $serieslist['output_path'] . '/' . $file_name;
            $temp_path = dirname(__FILE__) . '/listallbase' . $series . '.xls';
            if( file_exists( $temp_path ) ){
                $reader = PHPExcel_IOFactory::createReader( 'Excel5' );
                $excel = $reader->load( $temp_path );
            } else {
                $excel = new PHPExcel();
            }
            $sno = 1;
            for(;;){
                $excel->setActiveSheetIndex( $sno-1 );        //何番目のシートに有効にするか
                $sheet = $excel->getActiveSheet();    //有効になっているシートを取得
/*
            if( $series == 2 ){
                $this->output_entry_data_list_excel2( $sheet );
            } else if( $series == 3 ){
                $this->output_entry_data_list_all_excel3( $sheet );
            } else if( $series == 4 ){
                $this->output_entry_data_list_all_excel4( $sheet );
            } else if( $series == 5 ){
                $this->output_entry_data_list_all_excel5( $sheet );
            } else if( $series == 6 ){
                $this->output_entry_data_list_all_excel6( $sheet );
            }
*/
                $func = 'output_entry_data_list_all_'.$sno.'_excel' . $series;
                if( $func( $sheet ) == false ){ break; }
                $sno++;
            }
            $writer = PHPExcel_IOFactory::createWriter( $excel, 'Excel5' );
            $writer->save( $file_path );
            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
            header( 'Content-Length: '.filesize($file_path) );
            ob_end_clean();//ファイル破損エラー防止
            readfile( $file_path );
            return;
        }
        if( $mode == 'output_pdf' ){
            //include( dirname(dirname(dirname(__FILE__)))."/tcpdf/tcpdf.php" );
            include( dirname(dirname(dirname(__FILE__)))."/mpdf60/mpdf.php" );
            if( $series == 2 ){
                output_catalog_2_for_PDF( $org_array, $pref_array, $grade_junior_array, $filter );
                exit;
                //$list = get_entry_data_2_list_for_PDF( $org_array, $pref_array, $grade_junior_array, $filter );
            } if( $series == 3 ){
                output_catalog_3_for_PDF( $pref_array, $grade_elementary_array );
                exit;
                //$list = get_entry_data_3_list_for_PDF( $pref_array, $grade_elementary_array );
            } if( $series == 5 ){
                $list = get_entry_data_5_list_for_PDF( $pref_array, $grade_junior_array );
            } if( $series == 6 ){
                $list = get_entry_data_6_list_for_PDF( $pref_array, $grade_junior_array );
            }
            //$func = 'get_entry_data_'.$series.'_list_for_PDF';
            //$list = $func();
//print_r($list);
//exit;
            $this->template = 'admin' . DIRECTORY_SEPARATOR . 'catalog_'.$series.'.html';
            $this->smarty_assign['list'] = $list;
            $html = parent::fetch();
//header( 'Content-Type: application/octet-stream' );
//header( 'Content-Disposition: attachment; filename="test.html"');
//header( 'Content-Length: '.strlen($html) );
//ob_end_clean();
//echo $html;
//exit;
            $fdate = date('YmdHis') . sprintf("%04d",microtime()*1000);
            $fp = fopen( dirname(dirname(dirname(__FILE__))).'/log/output.'.$fdate.'.html', 'w' );
            fwrite( $fp, $html );
            fclose( $fp );

set_time_limit(600);
ini_set( 'memory_limit', '256M' );
/**/
define('_MPDF_SYSTEM_TTFONTS', dirname(dirname(dirname(__FILE__)))."/mpdf60/ttfonts/");
$JpFontName = 'ipapgothic';

            $mpdf = new mPDF( 'ja+aCJK', 'B4', 5, 'ipa', 10, 10, 10, 10, 0, 0 ); 
            $mpdf->SetDisplayMode( 'fullpage' );

$mpdf->fontdata[$JpFontName] = array(
    'R' => 'ipag.ttf',
);
$mpdf->available_unifonts[] = $JpFontName;
$mpdf->default_available_fonts[] = $JpFontName;
$mpdf->BMPonly[] = $JpFontName;
$mpdf->SetDefaultFont($JpFontName);
        // LOAD a stylesheet
        //    $stylesheet = file_get_contents( dirname(dirname(dirname(__FILE__))).'/css/mpdfstyleA4.css' );
        //    $mpdf->WriteHTML( $stylesheet, 1 );    // The parameter 1 tells that this is css/style only and no body/html/text

            $mpdf->autoLangToFont = true;
            $mpdf->restrictColorSpace = 1;
            $mpdf->WriteHTML( $html );
        //    header( 'Content-Type: application/octet-stream' );
        //    header( 'Content-Disposition: attachment; filename="'.$file_name.'"');
        //    header( 'Content-Length: '.filesize($file_path) );
        //    ob_end_clean();//ファイル破損エラー防止
            $mpdf->Output( 'output.'.$fdate.'.pdf', 'D' );
/**/
/*
$pdf = new TCPDF("L", "mm", "B4", true, "UTF-8" );
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$font = new TCPDF_FONTS();
// フォント：helvetica
$font_0 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/helvetica.php' );
$pdf->SetFont($font_0 , '', 32,'',true);
//$pdf->Text(0, 0, "alphabetica ABCDEFG" );
// フォント：IPAゴシック
$font_1 = $font->addTTFfont( dirname(dirname(dirname(__FILE__))).'/tcpdf/fonts/ttf/ipagp.ttf' );
$pdf->SetFont($font_1 , '', 32,'',true);
$pdf->WriteHTML($html, true, 0, false, true, 'L');
$pdf->Output("test.pdf", "I");
*/
//echo $html;
            exit;
        }
        if( $mode == 'output_draw_csv' ){
            $func = 'get_entry_data_for_draw_csv_' . $series;
            $csv = $func( $this->smarty_assign['list'] );
            $c = mb_convert_encoding( $csv['csv'], 'SJIS', 'UTF-8' );
            //mb_internal_encoding("SJIS");
            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Disposition: attachment; filename="'.$csv['file'].'"');
            header( 'Content-Length: '.strlen($c) );
            ob_end_clean();//ファイル破損エラー防止
            echo ( $c );
            //mb_internal_encoding("UTF-8");
            return;
        }
        if( $mode == 'output_draw' ){
            $func = 'draw_entry_data_list_' . $series;
            $csv = $func( $serieslist );
/*
            //mb_internal_encoding("SJIS");
            header( 'Content-Type: application/octet-stream' );
            header( 'Content-Disposition: attachment; filename="'.$csv['file'].'"');
            header( 'Content-Length: '.strlen($c) );
            ob_end_clean();//ファイル破損エラー防止
            echo ( $c );
            //mb_internal_encoding("UTF-8");
*/
            return;
        }
        $_SESSION['p'] = array();
        $this->template = 'admin' . DIRECTORY_SEPARATOR . 'info.html';
    }

    function dispatch()
    {
        parent::dispatch();
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------
    function ExchangeData( $id1, $id2 )
    {
        if( $id1 == 0 || $id2 == 0 ){ return; }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select * from `entry_info` where `id`='.$id1;
        $list = db_query_list( $dbs, $sql );
        if( count($list) == 0 ){ return; }
        $sql = 'select * from `entry_info` where `id`='.$id2;
        $list2 = db_query_list( $dbs, $sql );
        if( count($list2) == 0 ){ return; }
        $sql = 'update `entry_info` set `disp_order`='.$list2[0]['disp_order'].' where `id`='.$id1;
//echo $sql;
        db_query( $dbs, $sql );
        $sql = 'update `entry_info` set `disp_order`='.$list[0]['disp_order'].' where `id`='.$id2;
//echo $sql;
        db_query( $dbs, $sql );
        db_close( $dbs );
    }

    function SortData( $series )
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'select `entry_info`.*,`entry_field`.`data` as `school_name` from `entry_info`'
            .' inner join `entry_field`'
            .' on `entry_field`.`info`=`entry_info`.`id` and `entry_field`.`field`=\'school_name\''
            .' where `entry_info`.`series`='.$series.' and `entry_field`.`year`='.$_SESSION['auth']['year']
            .' order by `entry_info`.`id` desc';
        $list = db_query_list( $dbs, $sql );

        $sql = 'select * from `entry_field` where `field` in (\'shumoku_dantai_taikai\',\'shumoku_dantai_rensei_am\',\'shumoku_dantai_rensei_pm\',\'shumoku_dantai_opening\',\'shumoku_dantai_konshin\') and `year`='.$_SESSION['auth']['year'];
        $field_list = db_query_list( $dbs, $sql );
        foreach( $list as &$lv ){
            $id = intval( $lv['id'] );
            $lv['join'] = 0;
            $lv['join_m'] = 0;
            $lv['join_w'] = 0;
            $lv['order'] = 0;
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
        unset( $lv );

        foreach( $list as &$lv ){
            $lv['order'] = get_field_string_number( $_POST, 'id_'.$lv['id'], 0 );
        }
        unset( $lv );

        //抜けがある時の対処
        $realorder = 1;
        for( $order = 1; $order <= count($list); $order++ ){
            foreach( $list as &$lv ){
                if( $lv['order'] == $order ){
                    $lv['order'] = $realorder;
                    $realorder++;
                    break;
                }
            }
            unset( $lv );
        }
        if( $series == 3 ){
            foreach( $list as &$lv ){
                if( $lv['del'] != 1 && $lv['join'] == 1 && $lv['order'] == 0 ){
                    $lv['order'] = $realorder;
                    $realorder++;
                }
            }
            unset( $lv );
            foreach( $list as &$lv ){
                if( $lv['del'] != 1 && $lv['join'] == 0 ){
                    $lv['order'] = $realorder;
                    $realorder++;
                }
            }
            unset( $lv );
        } else {
            foreach( $list as &$lv ){
                if( $lv['del'] != 1 && $lv['order'] == 0 ){
                    $lv['order'] = $realorder;
                    $realorder++;
                }
            }
            unset( $lv );
        }
        foreach( $list as &$lv ){
            if( $lv['del'] == 1 ){
                $lv['order'] = $realorder;
                $realorder++;
            }
        }
        unset( $lv );

//echo "<!-- \n";
//print_r($list);

        foreach( $list as $lv ){
            $sql = 'update `entry_info` set `disp_order`='.$lv['order'].' where `id`='.$lv['id'];
//echo $sql,"<br />\n";
            db_query( $dbs, $sql );

        }

//echo "-->\n";

        db_close( $dbs );
    }

    function GetFormPostData()
    {
        $this->get_entry_post_data( $_SESSION['auth']['series'] );
        $this->add_entry_post_data_select_name( $_SESSION['auth']['series'] );

        $err = 0;
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
        return $err;
    }

}

?>
