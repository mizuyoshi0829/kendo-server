<?php
    require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
//    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_2.php';
//    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
//    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_4.php';
//    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
//    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';

class form_page_reg_index extends form_page
{
    function init( $series, $edit )
    {
        parent::init( $series, $edit );
        $logout = get_field_string_number( $_GET, 'logout', 0 );
        if( $logout == 1 ){
            $_SESSION['auth']['login'] = 0;
        }
        $series_info = $this->get_series_list( $series );
        $this->smarty_assign['series_name'] = '';
        $edit_url = $series_info['entry_new_edit_url'];
        if( $series == $series_info['dantai_league_m'] || $series == $series_info['dantai_tournament_m'] || $series == $series_info['kojin_tournament_m'] ){
            $this->smarty_assign['series_name'] = $series_info['name_m'];
            $edit_url = $series_info['entry_new_edit_url_m'];
        } else if( $series == $series_info['dantai_league_w'] || $series == $series_info['dantai_tournament_w'] || $series == $series_info['kojin_tournament_w'] ){
            $this->smarty_assign['series_name'] = $series_info['name_w'];
            $edit_url = $series_info['entry_new_edit_url_w'];
        }
        if( $series == $series_info['kojin_tournament_m'] || $series == $series_info['kojin_tournament_w'] ){
            $inc = dirname(dirname(__FILE__)) . '/admin/reg_s' . $series_info['id'] . 'k.php';
        } else {
            $inc = dirname(dirname(__FILE__)) . '/admin/reg_s' . $series_info['id'] . 'd.php';
        }
        if( file_exists( $inc ) ){
            require_once $inc;
        }

        $this->smarty_assign['root_url'] = '../';
        if(
             isset($_SESSION['auth']) && $series != 0 && isset($_SESSION['auth']['series'])
             && $_SESSION['auth']['series'] != $series && $_SESSION['auth']['login'] == 1
        ){
            if( !$this->entry_user_login2( $_SESSION['auth']['id'], $series ) ){
                $_SESSION['auth']['login'] = 0;
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                return;
            }
        }
        $mode = get_field_string( $_POST, 'mode', '' );
        if( $mode == 'auth' ){
            $id = get_field_string( $_POST, 'username', '' );
            $pass = substr( '00'.get_field_string( $_POST, 'password', '' ), -8, 8 );
            if( $this->entry_user_login( $id, $pass, $series, $series_info['reg_year'] ) ){
                $_SESSION['auth']['year'] = $series_info['reg_year'];
                $mode = '';
            //    $_SESSION['auth']['series'] = __REG_SERIES__;
            //    $this->template = 'reg' . DIRECTORY_SEPARATOR . 'series.html';
            //    return;
            } else {
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                return;
            }
        } else {
            if(
                !isset( $_SESSION['auth'] )
                //|| ( ( $series == 2 || $series == 3 || $series == 4 || $series == 5 || $series == 6 ) && $edit == 0 )
                //|| ( ( $series == 2 || $series == 3 || $series == 4 || $series == 5 || $series == 6 ) && $edit == 1 && $_SESSION['auth']['login'] != 1 )
                //|| ( $series != 2 && $series != 3 && $series != 4 && $series != 5 && $series != 6 && $_SESSION['auth']['login'] != 1 )
                || ( $series_info['entry_new'] == 1 && $edit == 0 )
                || ( $series_info['entry_new'] == 1 && $edit == 1 && $_SESSION['auth']['login'] != 1 )
                || ( $series_info['entry_new'] != 1 && $_SESSION['auth']['login'] != 1 )
            ){
                $_SESSION['auth'] = array( 'login' => 0 );
                if( $series == 4 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 4;
                    $_SESSION['auth']['year'] = 2017;
                } else if( $series == 5 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 5;
                    $_SESSION['auth']['year'] = 2017;
                } else if( $series == 6 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 6;
                    $_SESSION['auth']['year'] = 2017;
/*
                } else if( $series == 3 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 3;
                    $_SESSION['auth']['year'] = 2018;
                } else if( $series == 2 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 2;
                    $_SESSION['auth']['year'] = 2018;
*/
                } else if( $series_info['entry_new'] == 1 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = $series;
                    $_SESSION['auth']['year'] = $series_info['reg_year'];
/*
                } else if( $series == 7 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 7;
                } else if( $series == 8 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 8;
                } else if( $series == 9 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 9;
                } else if( $series == 10 && $edit == 0 ){
                    $_SESSION['auth']['login'] = 2;
                    $_SESSION['auth']['series'] = 10;
*/
                } else {
                    $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                    return;
                }
            } else {
                if( $_SESSION['auth']['login'] == 1 && ( !isset($_SESSION['auth']['id']) || $_SESSION['auth']['id'] == 0 ) ){
                    $_SESSION['auth']['login'] = 0;
                    $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                    return;
                }
            }
        }

        $org_array = $this->get_org_array();
        $pref_array = $this->get_pref_array();
        $grade_junior_array = $this->get_grade_junior_array();
        $grade_elementary_array = $this->get_grade_elementary_array();
        $yosen_rank_array = $this->get_yosen_rank_array();
        $dan_array = $this->get_dan_array();
        $this->smarty_assign['org_array'] = $this->get_org_array_for_smarty( $org_array );
        $this->smarty_assign['pref_array'] = $this->get_pref_array_for_smarty( $pref_array );
        $this->smarty_assign['grade_junior_array'] = $this->get_grade_junior_array_for_smarty( $grade_junior_array );
        $this->smarty_assign['grade_elementary_array'] = $this->get_grade_elementary_array_for_smarty( $grade_elementary_array );
        $this->smarty_assign['yosen_rank_array'] = $this->get_yosen_rank_array_for_smarty( $yosen_rank_array );
        $this->smarty_assign['dan_array'] = $this->get_dan_array_for_smarty( $dan_array );
        $this->smarty_assign['birth_year_array'] = $this->get_birth_year_for_smarty( null );
        $this->smarty_assign['birth_year_array2'] = $this->get_birth_year_for_smarty2( null );
        $this->smarty_assign['month_array'] = $this->get_month_array_for_smarty( null );
        $this->smarty_assign['day_array'] = $this->get_day_array_for_smarty( null );
        $this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $_SESSION['auth']['series'], 1 );
        $this->smarty_assign['post_action'] = 'index.php';
        if( $_SESSION['auth']['series'] == 3 ){
            $this->smarty_assign['post_action'] = 'index2.php';
        }
        $this->smarty_assign['mform_msg'] = '';
        $this->smarty_assign['pdf_name'] = '';
        $this->smarty_assign['pdf_base64'] = '';
        $this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
        $this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
    //    $mode = get_field_string( $_POST, 'mode' );
//print_r($_POST);
//print_r($_SESSION);
//echo '<!-- ';
//print_r($this->smarty_assign['fields_info']);
//echo ' -->';
        if( $mode == '' ){
            if( $_SESSION['auth']['info'] == 0 ){
                $_SESSION['p'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
            } else {
                $_SESSION['p'] = $this->get_entry_one_data( $_SESSION['auth']['info'] );
                if(
                    $series_info['output_form_pdf'] == 1
                    && $series_info['output_form_pdf_field'] != ''
                ){
                    $pdf_file_name = get_field_string( $_SESSION['p'], $series_info['output_form_pdf_field'] );
                    if( $pdf_file_name == '' ){
                        $pdf_file_name = $this->makePDF();
                        $_SESSION['p'][$series_info['output_form_pdf_field']] = $pdf_file_name;
                        $this->update_entry_field_data( $_SESSION['auth']['info'], $series_info['output_form_pdf_field'], $pdf_file_name, null );
                    }
                }
            }
            $_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
            $this->smarty_assign['edit_title'] = '新規登録';
//print_r($_SESSION);
            $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
            return;
        } else if( $mode == 'edit' ){
            $id = get_field_string_number( $_POST, 'id', 0 );
            if( $id > 0 ){
                $_SESSION['p'] = $this->get_entry_one_data( $id );
                $_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
                $this->smarty_assign['edit_title'] = '編集';
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
                return;
            }
        } else if( $mode == 'confirm' ){
            if( isset( $_POST['exec'] ) ){
//print_r($_POST);
//print_r($_SESSION);
                if( $this->GetFormPostData() == 1 ){
//print_r($_SESSION);
                    $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
                    return;
                } else {
                    $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mconfirm.html';
                    return;
                }
            } else if( isset( $_POST['pdf_download'] ) ){
                if( $series_info['output_form_pdf'] != 1 ){ exit; }
                if( $series_info['output_form_pdf_field'] == '' ){ exit; }
                $pdf_name = get_field_string( $_SESSION['p'], $series_info['output_form_pdf_field'] );
                if( $pdf_name != '' ){
                    $pdf_path = dirname(dirname(dirname(__FILE__))).'/output/'.$pdf_name;
                    if( file_exists( $pdf_path ) ){
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment; filename="'.$pdf_name.'"');
                        readfile($pdf_path);
                        exit;
                    }
                }
                exit;
            } else {
                //$this->template = 'reg' . DIRECTORY_SEPARATOR . 'series.html';
                $_SESSION['auth']['login'] = 0;
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                return;
            }
        } else if( $mode == 'exec' ){
            if( isset( $_POST['exec'] ) ){
                $info_id = $this->update_entry_data( $_SESSION['auth']['series'] );
                $pid = get_field_string_number( $_SESSION['p'], 'id', 0 );
                if( $pid == 0 ){
                    if( $_SESSION['auth']['series'] == 4 || $_SESSION['auth']['series'] == 2 ){
                        $pass = $this->update_entry_user( $info_id );
                        $school_name = $_SESSION['p']['school_name'];
                        $school_email = $_SESSION['p']['responsible_email'];
                        mb_language("Japanese");
                        mb_internal_encoding("UTF-8");
                        $header_info = "From: ".mb_encode_mimeheader('松代藩文武学校旗争奪全国中学校選抜剣道大会 事務局')." <bunbu_ele@kendo-nagano.com>\n".
                            "Content-Type: text/plain;charset=ISO-2022-JP\n".
                            "X-Mailer: PHP/".phpversion();
                        $title = $school_name . "様 エントリーのお知らせ";
                        $body = $school_name . " 様\n\n"
                            . "この度はエントリーありがとうございます。\n"
                            . $school_name . "様のIDとパスワードをお知らせいたします。\n\n"
                            . 'ID: ' . $pass['user_name'] . "\n"
                            . 'パスワード: ' . $pass['user_pass'] . "\n\n"
                            . "エントリー内容の変更は ".$edit_url." から\n"
                            . "お知らせしましたIDとパスワードを入力して下さい。\n";
                        if( $school_email != '' ){
                            mb_send_mail( $school_email, $title, $body, $header_info );
                        }
                        mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                        mb_send_mail( 'iyasu@keioff.net', $title, $body, $header_info );
                    } else if( $_SESSION['auth']['series'] == 3 ){
                        $pass = $this->update_entry_user( $info_id );
                        $school_name = $_SESSION['p']['school_name'];
                        $school_email = $_SESSION['p']['responsible_email'];
                        mb_language("Japanese");
                        mb_internal_encoding("UTF-8");
                        $header_info = "From: ".mb_encode_mimeheader('松代藩文武学校剣道大会小学生大会事務局')." <bunbu_ele@kendo-nagano.com>\n".
                            "Content-Type: text/plain;charset=ISO-2022-JP\n".
                            "X-Mailer: PHP/".phpversion();
                        $title = $school_name . "様 エントリーのお知らせ";
                        $body = $school_name . " 様\n\n"
                            . "この度はエントリーありがとうございます。\n"
                            . $school_name . "様のIDとパスワードをお知らせいたします。\n\n"
                            . 'ID: ' . $pass['user_name'] . "\n"
                            . 'パスワード: ' . $pass['user_pass'] . "\n\n"
                            . "エントリー内容の変更は ".$edit_url." から\n"
                            . "お知らせしましたIDとパスワードを入力して下さい。\n";
                        if( $school_email != '' ){
                            mb_send_mail( $school_email, $title, $body, $header_info );
                        }
                        mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                        mb_send_mail( 'iyasu@keioff.net', $title, $body, $header_info );
                    } else if( $_SESSION['auth']['series'] == 5 || $_SESSION['auth']['series'] == 6 ){
                        $pass = $this->update_entry_user( $info_id );
                        $school_name = $_SESSION['p']['school_name'];
                        $school_email = $_SESSION['p']['school_email'];
                        mb_language("Japanese");
                        mb_internal_encoding("UTF-8");
                        $header_info = "From: ".mb_encode_mimeheader('松代藩文武学校旗争奪全国中学校選抜剣道大会 事務局')." <bunbu_ele@kendo-nagano.com>\n".
                            "Content-Type: text/plain;charset=ISO-2022-JP\n".
                            "X-Mailer: PHP/".phpversion();
                        $title = $school_name . "様 エントリーのお知らせ";
                        $body = $school_name . " 様\n\n"
                            . "この度はエントリーありがとうございます。\n"
                            . $school_name . "様のIDとパスワードをお知らせいたします。\n\n"
                            . 'ID: ' . $pass['user_name'] . "\n"
                            . 'パスワード: ' . $pass['user_pass'] . "\n\n"
                            . "エントリー内容の変更は ".$edit_url." から\n"
                            . "お知らせしましたIDとパスワードを入力して下さい。\n";
                        if( $school_email != '' ){
                            mb_send_mail( $school_email, $title, $body, $header_info );
                        }
                        mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                        mb_send_mail( 'iyasu@keioff.net', $title, $body, $header_info );
                    } else if( $series_info['entry_new'] == 1 ){
                        $pass = $this->update_entry_user( $info_id );
                        if( isset( $series_info['entry_new_email_field'] ) && $series_info['entry_new_email_field'] != '' ){
                            $school_name = '';
                            if( isset( $series_info['entry_new_name_field'] ) && $series_info['entry_new_name_field'] != '' ){
                                $school_name_fields = explode( ',', $series_info['entry_new_name_field'] );
                                if( count( $school_name_fields ) > 0 ){
                                    foreach( $school_name_fields as $f ){
                                        $school_name .= $_SESSION['p'][$f];
                                    }
                                }
                            }
                            $school_email = $_SESSION['p'][$series_info['entry_new_email_field']];
                            mb_language("Japanese");
                            mb_internal_encoding("UTF-8");
                            $header_info = "From: ".mb_encode_mimeheader($series_info['entry_new_sender'])." <".$series_info['entry_new_sender_email'].">\n".
                                "Content-Type: text/plain;charset=ISO-2022-JP\n".
                                "X-Mailer: PHP/".phpversion();
                            $title = $school_name . "様 エントリーのお知らせ";
                            $body = $school_name . " 様\n\n"
                                . "この度は".$this->smarty_assign['series_name']."にエントリーありがとうございます。\n"
                                . $school_name . "様のIDとパスワードをお知らせいたします。\n\n"
                                . 'ID: ' . $pass['user_name'] . "\n"
                                . 'パスワード: ' . $pass['user_pass'] . "\n\n"
                                . "エントリー内容の変更は ".$edit_url." から\n"
                                . "お知らせしましたIDとパスワードを入力して下さい。\n";
                            if( $school_email != '' ){
                                mb_send_mail( $school_email, $title, $body, $header_info );
                            }
                            mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                            mb_send_mail( 'iyasu@keioff.net', $title, $body, $header_info );
                        }
                    }
                    $this->smarty_assign['mform_msg'] = 'エントリーを受け付けました。';
                } else {
                    if( $series_info['entry_new'] == 1 ){
                        if( isset( $series_info['entry_new_email_field'] ) && $series_info['entry_new_email_field'] != '' ){
                            $school_name = '';
                            if( isset( $series_info['entry_new_name_field'] ) && $series_info['entry_new_name_field'] != '' ){
                                $school_name_fields = explode( ',', $series_info['entry_new_name_field'] );
                                if( count( $school_name_fields ) > 0 ){
                                    foreach( $school_name_fields as $f ){
                                        $school_name .= $_SESSION['p'][$f];
                                    }
                                }
                            }
                            $school_email = $_SESSION['p'][$series_info['entry_new_email_field']];
                            mb_language("Japanese");
                            mb_internal_encoding("UTF-8");
                            $header_info = "From: ".mb_encode_mimeheader($series_info['entry_new_sender'])." <".$series_info['entry_new_sender_email'].">\n".
                                "Content-Type: text/plain;charset=ISO-2022-JP\n".
                                "X-Mailer: PHP/".phpversion();
                            $title = $school_name . "様 エントリーのお知らせ";
                            $body = $school_name . " 様\n\n"
                                . "この度は".$this->smarty_assign['series_name']."にエントリーありがとうございます。\n"
                                . "エントリー内容の変更は ".$edit_url." から\n"
                                . "お知らせしましたIDとパスワードを入力して下さい。\n";
                            if( $school_email != '' ){
                                mb_send_mail( $school_email, $title, $body, $header_info );
                            }
                            mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                            mb_send_mail( 'iyasu@keioff.net', $title, $body, $header_info );
                        }
                    } else if( $_SESSION['auth']['series'] >= 58 && $_SESSION['auth']['series'] <= 61 ){
                        $pass = $this->update_entry_user( $info_id );
                        $pdf_file_name = $this->makePDF();
                        $_SESSION['p'][$series_info['output_form_pdf_field']] = $pdf_file_name;
                        $this->update_entry_field_data( $info_id, $series_info['output_form_pdf_field'], $pdf_file_name, null );
                        $school_name = $_SESSION['p']['school_name'];
                        $school_email = $_SESSION['p']['school_email'];
                        $boundary = '----=_Boundary_' . uniqid(rand(1000,9999) . '_') . '_';
                        mb_language("Japanese");
                        mb_internal_encoding("UTF-8");
                        $title = $school_name . "様 エントリーのお知らせ";
                        $message = $school_name . " 様\n\n"
                               . "この度はエントリーありがとうございます。\n\n";
                        if( $_SESSION['auth']['series'] == 58 ){
                               $message .= "エントリー内容の変更は https://www.i-kendo.net/kendo/reg/kanto/reg_dm.php から\n";
                        } else if( $_SESSION['auth']['series'] == 59 ){
                               $message .= "エントリー内容の変更は https://www.i-kendo.net/kendo/reg/kanto/reg_dw.php から\n";
                        } else if( $_SESSION['auth']['series'] == 60 ){
                               $message .= "エントリー内容の変更は https://www.i-kendo.net/kendo/reg/kanto/reg_km.php から\n";
                        } else if( $_SESSION['auth']['series'] == 61 ){
                               $message .= "エントリー内容の変更は https://www.i-kendo.net/kendo/reg/kanto/reg_kw.php から\n";
                        }
                        $message .= "お知らせしましたIDとパスワードを入力して下さい。\n";
                        $message .= "添付PDFを印刷してお使い下さい。\n";

                        $body_files = '';
                        $filename = $pdf_file_name;
                        $filename = "=?ISO-2022-JP?B?" . base64_encode( $filename ) . "?=";
                        $filebody = file_get_contents( dirname(dirname(dirname(__FILE__))).'/output/'.$pdf_file_name );
                        $f_encoded = chunk_split( base64_encode( $filebody ) );
                        $mime_type = 'application/pdf';
                        $onebody = '--' . $boundary . "\n"
                            . 'Content-Type: ' . $mime_type . '; name="' . $pdf_file_name . '"' . "\n"
                            . 'Content-Transfer-Encoding: base64' . "\n"
                            . 'Content-Disposition: attachment; filename="' . $pdf_file_name . '"'. "\n\n"
                            . $f_encoded . "\n\n";
                        $body_files .= $onebody;
                        $header_info = "From: ".mb_encode_mimeheader('関東大会申込受付担当')." <reg@kantokendo.net>\n"
                            . "X-Mailer: PHP/".phpversion()
                            . 'MIME-Version: 1.0' . "\n"
                            . 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . "\n"
                            . 'Content-Transfer-Encoding: 7bit';
                        $body = '--' . $boundary . "\n"
                            . 'Content-Type: text/plain; charset=ISO-2022-JP; Content-Transfer-Encoding: 7bit' . "\n"
                            . "\n"
                            . $message . "\n"
                            . "\n"
                            . $body_files;


                        if( $school_email != '' ){
                            mb_send_mail( $school_email, $title, $body, $header_info );
                        }
                        mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
                        mb_send_mail( 'reg@kantokendo.net', $title, $body, $header_info );
                        $this->smarty_assign['info_id'] = $info_id;
                        $this->smarty_assign['pdf_file_name'] = $pdf_file_name;
                        $this->smarty_assign['pdf_name'] = $pdf_file_name;
                        $this->smarty_assign['pdf_base64'] = base64_encode( $filebody );
                        //$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mpdf.html';
                        //return;
                    }
                    $this->smarty_assign['mform_msg'] = 'エントリー入力を受け付けました。';
                }
                $_SESSION['p'] = $this->get_entry_one_data( $info_id );
                $_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
                $this->smarty_assign['edit_title'] = '編集';
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
                return;
            } else {
                $_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
                $this->smarty_assign['edit_title'] = '編集';
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
                return;
            }
        } else if( $mode == 'pdf' ){
            $info_id = get_field_string_number( $_POST, 'info_id', 0 );
            if( $info_id == 0 ){
                $_SESSION['auth']['login'] = 0;
                $this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
                return;
            }
            $pdf_file_name = get_field_string( $_POST, 'pdf_file_name' );
            if( $pdf_file_name != '' ){
                $pdf_file_path = dirname(dirname(dirname(__FILE__))).'/output/'.$pdf_file_name;
                $filebody = file_get_contents( $pdf_file_path );
                $this->smarty_assign['pdf_base64'] = base64_encode( $filebody );
                /*
                header( 'Content-Type: application/octet-stream' );
                header( 'Content-Disposition: attachment; filename="'.$pdf_file_name.'"');
                header( 'Content-Length: '.filesize($pdf_file_path) );
                ob_end_clean();//ファイル破損エラー防止
                readfile( $pdf_file_path );
                */
            }
            $_SESSION['p'] = $this->get_entry_one_data( $info_id );
            $_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
            $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
            $this->smarty_assign['mform_msg'] = 'エントリー入力を受け付けました。';
            return;
        }
        $_SESSION['p'] = array();
    //    $this->smarty_assign['list'] = $this->GetRegDataList( $category );
        $this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
    }

    function dispatch()
    {
        parent::dispatch();
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

    function InitPostDataArray()
    {
        $def = $this->get_field_def();
        $data = array();
        $data['id'] = 0;
        foreach( $def as $ld ){
            if( $ld['def'] == 'text' ){
                $data[$ld['field']] = '';
            } else if( $ld['def'] == 'int' ){
                $data[$ld['field']] = 0;
            }
        }
        return $data;
    }

    function InitPostData()
    {
        $_SESSION['p'] = InitPostDataArray();
        $_SESSION['e'] = InitPostDataArray();
    }

    function GetFormPostData()
    {
        $err = $this->get_entry_post_data( $_SESSION['auth']['series'] );
        $this->add_entry_post_data_select_name( $_SESSION['auth']['series'] );
//print_r($_SESSION['p']);
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

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------
    function __out_PDF_string_raw( $pdf, $x, $y, $size, $text )
    {
        $pdf->SetFont( 'kozminproregular', '', $size );
        $pdf->Text( $x, $y, $text );
    }

    function __out_PDF_string( $pdf, $tbl, $field, $text )
    {
        $this->__out_PDF_string_raw( $pdf, $tbl[$field]['x'], $tbl[$field]['y'], $tbl[$field]['size'], $text );
    }

    function __out_PDF_field_string( $pdf, $tbl )
    {
        if( $tbl['mode'] == 'name' ){
            $text = get_field_string( $_SESSION['p'], $tbl['field'].'_sei', '' ) . ' ' . get_field_string( $_SESSION['p'], $tbl['field'].'_mei', '' );
        } else if( $tbl['mode'] == 'gakunen' ){
            $text = get_field_string( $_SESSION['p'], $tbl['field'], '' );
            if( $text == '0' ){ $text = ''; }
        } else if( $tbl['mode'] == 'dan' ){
            $text = get_field_string( $_SESSION['p'], $tbl['field'], '' );
            if( $text == '0' ){ $text = ''; }
        } else {
            $text = get_field_string( $_SESSION['p'], $tbl['field'], '' );
        }
        $this->__out_PDF_string_raw( $pdf, $tbl['x'], $tbl['y'], $tbl['size'], $text );

//        echo $tbl['x'],':',$tbl['y'],':',$tbl['size'],':',$tbl['field'],':',$text,"<br />\n";
    }


    function makePDF()
    {
        require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/zenchu/admin/tcpdf/tcpdf.php';
        require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))).'/zenchu/admin/tcpdf/fpdi/autoload.php';
//print_r($_SESSION);

        $series_pos = [
            58 => [
                'src' => 'entry_58.2024.pdf',
                'pref' => [ 'x' => 39, 'y' => 33.5, 'size' => 16, 'field' => '' ],
                'pref_mode' => [
                    1 => [ 'x' => 71, 'y' => 35.3, 'size' => 2 ],
                    2 => [ 'x' => 80, 'y' => 35.3, 'size' => 2 ],
                    3 => [ 'x' => 71.5, 'y' => 36, 'size' => 2 ],
                    4 => [ 'x' => 71, 'y' => 40, 'size' => 2 ],
                ],
                'school_name_kana' => [ 'x' => 58, 'y' => 51, 'size' => 6, 'field' => 'school_name_kana' ],
                'school_name' => [ 'x' => 56.5, 'y' => 60.5, 'size' => 11, 'field' => 'school_name' ],
                'school_email' => [ 'x' => 120, 'y' => 61.5, 'size' => 9, 'field' => 'school_email' ],
                'member' => [
                    'x' => [ 51, 62, 85, 85 ],
                    'y' => [ 72, 83, 93, 104, 113, 123, 133 ],
                    'yofs' => [ 3, 3, 1, 5 ],
                    'size' => [ 12, 12, 6, 11 ],
                    'fields' => [ 'player%d_gakunen_dan_gakunen', 'player%d_gakunen_dan_dan', 'player%d_kana', 'player%d' ],
                    'modes' => [ 'gakunen', 'dan', 'name', 'name' ]
                ],
                'insotu' => [
                    'x' => [ 63, 63, 63, 63, 108, 115, 145 ],
                    'y' => [ 155.5, 159.5, 165.5, 171,  175, 179, 185, 190 ],
                    'size' => [ 6, 11, 9, 9, 2, 2, 2,  6, 11, 9, 9, 2, 2, 2 ],
                    'fields' => [ 'insotu%d_kana', 'insotu%d', 'insotu%d_keitai_mobile', 'insotu%d_keitai_tel', '' ],
                    'modes' => [ 'name', 'name', 'text', 'text', 'text' ]
                ],
                'yosen' => [
                    'x' => [ 85 ],
                    'y' => [ 216 ],
                    'size' => [ 11 ],
                    'field' => 'yosen_rank'
                ],
                'entry_num' => [ 'x' => 90, 'y' => 197.5, 'size' => 9, 'field' => 'entry_num_m' ],
            ],
            59 => [
                'src' => 'entry_59.2024.pdf',
                'pref' => [ 'x' => 39, 'y' => 33.5, 'size' => 16, 'field' => '' ],
                'pref_mode' => [
                    1 => [ 'x' => 71, 'y' => 35.3, 'size' => 2 ],
                    2 => [ 'x' => 80, 'y' => 35.3, 'size' => 2 ],
                    3 => [ 'x' => 71.5, 'y' => 36, 'size' => 2 ],
                    4 => [ 'x' => 71, 'y' => 40, 'size' => 2 ],
                ],
                'school_name_kana' => [ 'x' => 58, 'y' => 51, 'size' => 6, 'field' => 'school_name_kana' ],
                'school_name' => [ 'x' => 56.5, 'y' => 60.5, 'size' => 11, 'field' => 'school_name' ],
                'school_email' => [ 'x' => 120, 'y' => 61.5, 'size' => 9, 'field' => 'school_email' ],
                'member' => [
                    'x' => [ 51, 62, 85, 85 ],
                    'y' => [ 72, 83, 93, 104, 113, 123, 133 ],
                    'yofs' => [ 3, 3, 1, 5 ],
                    'size' => [ 12, 12, 6, 11 ],
                    'fields' => [ 'player%d_gakunen_dan_gakunen', 'player%d_gakunen_dan_dan', 'player%d_kana', 'player%d' ],
                    'modes' => [ 'gakunen', 'dan', 'name', 'name' ]
                ],
                'insotu' => [
                    'x' => [ 63, 63, 63, 63, 108, 115, 145 ],
                    'y' => [ 154, 158, 164, 169,  173, 177, 183, 188 ],
                    'size' => [ 6, 11, 9, 9, 2, 2, 2,  6, 11, 9, 9, 2, 2, 2 ],
                    'fields' => [ 'insotu%d_kana', 'insotu%d', 'insotu%d_keitai_mobile', 'insotu%d_keitai_tel', '' ],
                    'modes' => [ 'name', 'name', 'text', 'text', 'text' ]
                ],
                'yosen' => [
                    'x' => [ 85 ],
                    'y' => [ 216 ],
                    'size' => [ 11 ],
                    'field' => 'yosen_rank'
                ],
                'entry_num' => [ 'x' => 90, 'y' => 196, 'size' => 9, 'field' => 'entry_num_w' ],
            ],
            60 => [
                'src' => 'entry_60.2024.pdf',
                'pref' => [ 'x' => 45, 'y' => 30, 'size' => 16, 'field' => '' ],
                'pref_mode' => [
                    1 => [ 'x' => 74.3, 'y' => 31.5, 'size' => 2 ],
                    2 => [ 'x' => 80, 'y' => 35.3, 'size' => 2 ],
                    3 => [ 'x' => 71.5, 'y' => 36, 'size' => 2 ],
                    4 => [ 'x' => 74.3, 'y' => 36, 'size' => 2 ],
                ],
                'school_name_kana' => [ 'x' => 60, 'y' => 51, 'size' => 6, 'field' => 'school_name_kana' ],
                'school_name' => [ 'x' => 58.5, 'y' => 60.5, 'size' => 11, 'field' => 'school_name' ],
                'school_email' => [ 'x' => 125, 'y' => 62, 'size' => 9, 'field' => 'school_email' ],
                'yosen' => [
                    'x' => [ 33, 55, 66, 85, 85 ],
                    'y' => [ 78, 87, 100, 110, 115 ],
                    'yofs' => [ 0.5, 0, 0, 0, 0 ],
                    'size' => [ 10, 12, 12, 6, 11 ]
                ],
                'insotu' => [
                    'x' => [ 53, 108, 116, 155, 130 ],
                    'y' => [ 155.5, 160, 166.5, 172,  178, 182, 189, 195,  203, 208.5, 204, 210 ],
                    'size' => [ 6, 11, 9, 9, 2, 2, 2, 6, 11, 9, 9, 2, 2, 2,  6, 11, 9, 9 ]
                ],
            ],
            61 => [
                'src' => 'entry_61.2024.pdf',
                'pref' => [ 'x' => 45, 'y' => 30, 'size' => 16, 'field' => '' ],
                'pref_mode' => [
                    1 => [ 'x' => 74.3, 'y' => 31.5, 'size' => 2 ],
                    2 => [ 'x' => 80, 'y' => 35.3, 'size' => 2 ],
                    3 => [ 'x' => 71.5, 'y' => 36, 'size' => 2 ],
                    4 => [ 'x' => 74.3, 'y' => 36, 'size' => 2 ],
                ],
                'school_name_kana' => [ 'x' => 60, 'y' => 51, 'size' => 6, 'field' => 'school_name_kana' ],
                'school_name' => [ 'x' => 58.5, 'y' => 60.5, 'size' => 11, 'field' => 'school_name' ],
                'school_email' => [ 'x' => 125, 'y' => 62, 'size' => 9, 'field' => 'school_email' ],
                'yosen' => [
                    'x' => [ 33, 55, 66, 85, 85 ],
                    'y' => [ 78, 87, 100, 110, 115 ],
                    'yofs' => [ 0.5, 0, 0, 0, 0 ],
                    'size' => [ 10, 12, 12, 6, 11 ]
                ],
                'insotu' => [
                    'x' => [ 53, 108, 116, 155, 130 ],
                    'y' => [ 155.5, 160.5, 166.5, 172,  178, 182, 189, 195,  203, 208.5, 204, 210 ],
                    'size' => [ 6, 11, 9, 9, 2, 2, 2,  6, 11, 9, 9, 2, 2, 2,  6, 11, 9, 9 ]
                ],
            ],
        ];

        $pos_tbl = $series_pos[$_SESSION['auth']['series']];
        $pdf = new setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->setPrintHeader( false );
        $pdf->setSourceFile(dirname(dirname(dirname(__FILE__))).'/templates/excel/'.$pos_tbl['src']);
        $pdf->AddPage();
        $tpl = $pdf->importPage(1);
        $pdf->useTemplate($tpl);

        $pref = intval($_SESSION['p']['school_address_pref']);
        $prefs = $this->get_pref_array2();
        $pref_name = '';
        $pref_name2 = '';
        $pref_mode = 4;
        foreach( $prefs as $p ){
            if( $p['value'] == $pref ){
                $pref_name = isset($p['title2']) ? $p['title2'] : $p['title'];
                $pref_name2 = $p['title'];
                $pref_mode = $p['mode'];
                break;
            }
        }
        $this->__out_PDF_string( $pdf, $pos_tbl, 'pref', $pref_name );
        $pdf->Circle(
            $pos_tbl['pref_mode'][$pref_mode]['x'],
            $pos_tbl['pref_mode'][$pref_mode]['y'],
            $pos_tbl['pref_mode'][$pref_mode]['size'], 0, 360, '', [ 'width' => 0.5 ]
        );
        $this->__out_PDF_string( $pdf, $pos_tbl, 'school_name_kana', get_field_string( $_SESSION['p'], 'school_name_kana', '' ) );
        $school_name = get_field_string( $_SESSION['p'], 'school_name', '' );
        if( mb_strlen( $school_name ) > 12 ){
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['school_name']['x'], $pos_tbl['school_name']['y']-3,
                $pos_tbl['school_name']['size'], mb_substr($school_name, 0, 12, 'UTF-8')
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['school_name']['x'], $pos_tbl['school_name']['y']+3,
                $pos_tbl['school_name']['size'], mb_substr($school_name, 12, mb_strlen( $school_name )-12, 'UTF-8')
            );
        } else {
            $this->__out_PDF_string( $pdf, $pos_tbl, 'school_name', $school_name );
        }
        $this->__out_PDF_string( $pdf, $pos_tbl, 'school_email', get_field_string( $_SESSION['p'], 'school_email', '' ) );

        $text_tbl = [];
        if( $_SESSION['auth']['series'] == 58 ){
            $text_tbl[] = $pos_tbl['entry_num'];
            for( $i1 = 0; $i1 < 7; $i1++ ){
                for( $i2 = 0; $i2 < 4; $i2++ ){
                    $text_tbl[] = [
                        'x' => $pos_tbl['member']['x'][$i2],
                        'y' => $pos_tbl['member']['y'][$i1] + $pos_tbl['member']['yofs'][$i2],
                        'size' => $pos_tbl['member']['size'][$i2],
                        'field' => sprintf( $pos_tbl['member']['fields'][$i2], $i1+1 ),
                        'mode' => $pos_tbl['member']['modes'][$i2],
                    ];
                }
            }
            /*
            for( $i1 = 0; $i1 < 2; $i1++ ){
                for( $i2 = 0; $i2 < 4; $i2++ ){
                    $text_tbl[] = [
                        'x' => $pos_tbl['insotu']['x'][$i2],
                        'y' => $pos_tbl['insotu']['y'][$i1*4+$i2],
                        'size' => $pos_tbl['insotu']['size'][$i2],
                        'field' => sprintf( $pos_tbl['insotu']['fields'][$i2], $i1+1 ),
                        'mode' => $pos_tbl['insotu']['modes'][$i2],
                    ];
                }
                $position = get_field_string_number( $_SESSION['p'], 'insotu'.($i1+1).'_position', 0 );
                if( $position > 0 ){
                    $pdf->Circle(
                        $pos_tbl['insotu']['x'][$position+3],
                        $pos_tbl['insotu']['y'][$i1*4]+1.5,
                        $pos_tbl['insotu']['size'][$position+3], 0, 360, '', [ 'width' => 0.5 ]
                    );
                }
            }
            */
            $text_tbl[] = [
                'x' => $pos_tbl['yosen']['x'][0],
                'y' => $pos_tbl['yosen']['y'][0],
                'size' => $pos_tbl['yosen']['size'][0],
                'field' => $pos_tbl['yosen']['field'],
                'mode' => 'text',
            ];
            foreach( $text_tbl as $t ){
                $this->__out_PDF_field_string( $pdf, $t );
            }
        } else if( $_SESSION['auth']['series'] == 59 ){
            $text_tbl[] = $pos_tbl['entry_num'];
            for( $i1 = 0; $i1 < 7; $i1++ ){
                for( $i2 = 0; $i2 < 4; $i2++ ){
                    $text_tbl[] = [
                        'x' => $pos_tbl['member']['x'][$i2],
                        'y' => $pos_tbl['member']['y'][$i1] + $pos_tbl['member']['yofs'][$i2],
                        'size' => $pos_tbl['member']['size'][$i2],
                        'field' => sprintf( $pos_tbl['member']['fields'][$i2], $i1+1 ),
                        'mode' => $pos_tbl['member']['modes'][$i2],
                    ];
                }
            }
            /*
            for( $i1 = 0; $i1 < 2; $i1++ ){
                for( $i2 = 0; $i2 < 4; $i2++ ){
                    $text_tbl[] = [
                        'x' => $pos_tbl['insotu']['x'][$i2],
                        'y' => $pos_tbl['insotu']['y'][$i1*4+$i2],
                        'size' => $pos_tbl['insotu']['size'][$i2],
                        'field' => sprintf( $pos_tbl['insotu']['fields'][$i2], $i1+1 ),
                        'mode' => $pos_tbl['insotu']['modes'][$i2],
                    ];
                }
                $position = get_field_string_number( $_SESSION['p'], 'insotu'.($i1+1).'_position', 0 );
                if( $position > 0 ){
                    $pdf->Circle(
                        $pos_tbl['insotu']['x'][$position+3],
                        $pos_tbl['insotu']['y'][$i1*4]+1.5,
                        $pos_tbl['insotu']['size'][$position+3], 0, 360, '', [ 'width' => 0.5 ]
                    );
                }
            }
            */
            $text_tbl[] = [
                'x' => $pos_tbl['yosen']['x'][0],
                'y' => $pos_tbl['yosen']['y'][0],
                'size' => $pos_tbl['yosen']['size'][0],
                'field' => $pos_tbl['yosen']['field'],
                'mode' => 'text',
            ];
            foreach( $text_tbl as $t ){
                $this->__out_PDF_field_string( $pdf, $t );
            }
        } else if( $_SESSION['auth']['series'] == 60 || $_SESSION['auth']['series'] == 61 ){
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['yosen']['x'][0],
                $pos_tbl['yosen']['y'][0]+$pos_tbl['yosen']['yofs'][0],
                $pos_tbl['yosen']['size'][0],
                $pref_name2.get_field_string( $_SESSION['p'], 'player1_yosen' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['yosen']['x'][1], $pos_tbl['yosen']['y'][0], $pos_tbl['yosen']['size'][1],
                get_field_string( $_SESSION['p'], 'player1_gakunen_dan_gakunen' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['yosen']['x'][2], $pos_tbl['yosen']['y'][0], $pos_tbl['yosen']['size'][2],
                get_field_string( $_SESSION['p'], 'player1_gakunen_dan_dan' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['yosen']['x'][3], $pos_tbl['yosen']['y'][0]-2, $pos_tbl['yosen']['size'][3],
                get_field_string( $_SESSION['p'], 'player1_kana_sei' ).' '.get_field_string( $_SESSION['p'], 'player1_kana_mei' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['yosen']['x'][4], $pos_tbl['yosen']['y'][0]+1.5, $pos_tbl['yosen']['size'][4],
                get_field_string( $_SESSION['p'], 'player1_sei' ).' '.get_field_string( $_SESSION['p'], 'player1_mei' )
            );
            if( get_field_string( $_SESSION['p'], 'player2_sei', '' ) != '' ){
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][0],
                    $pos_tbl['yosen']['y'][1]+$pos_tbl['yosen']['yofs'][0],
                    $pos_tbl['yosen']['size'][0],
                    $pref_name2.get_field_string( $_SESSION['p'], 'player2_yosen' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][1], $pos_tbl['yosen']['y'][1], $pos_tbl['yosen']['size'][1],
                    get_field_string( $_SESSION['p'], 'player2_gakunen_dan_gakunen' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][2], $pos_tbl['yosen']['y'][1], $pos_tbl['yosen']['size'][2],
                    get_field_string( $_SESSION['p'], 'player2_gakunen_dan_dan' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][3], $pos_tbl['yosen']['y'][1]-2, $pos_tbl['yosen']['size'][3],
                    get_field_string( $_SESSION['p'], 'player2_kana_sei' ).' '.get_field_string( $_SESSION['p'], 'player2_kana_mei' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][4], $pos_tbl['yosen']['y'][1]+1.5, $pos_tbl['yosen']['size'][4],
                    get_field_string( $_SESSION['p'], 'player2_sei' ).' '.get_field_string( $_SESSION['p'], 'player2_mei' )
                );
            }
            if( get_field_string( $_SESSION['p'], 'player3_sei' ) != '' ){
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][1], $pos_tbl['yosen']['y'][4], $pos_tbl['yosen']['size'][1],
                    get_field_string( $_SESSION['p'], 'player3_gakunen_dan_gakunen' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][2], $pos_tbl['yosen']['y'][4], $pos_tbl['yosen']['size'][2],
                    get_field_string( $_SESSION['p'], 'player3_gakunen_dan_dan' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][3], $pos_tbl['yosen']['y'][4]-2, $pos_tbl['yosen']['size'][3],
                    get_field_string( $_SESSION['p'], 'player3_kana_sei' ).' '.get_field_string( $_SESSION['p'], 'player3_kana_mei' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['yosen']['x'][4], $pos_tbl['yosen']['y'][4]+1.5, $pos_tbl['yosen']['size'][4],
                    get_field_string( $_SESSION['p'], 'player3_sei' ).' '.get_field_string( $_SESSION['p'], 'player3_mei' )
                );
            }
        }
        /*
        if( $_SESSION['auth']['series'] == 58 || $_SESSION['auth']['series'] == 59 ){
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][0], $pos_tbl['insotu']['size'][0],
                get_field_string( $_SESSION['p'], 'insotu1_kana_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu1_kana_mei', '' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][1], $pos_tbl['insotu']['size'][1],
                get_field_string( $_SESSION['p'], 'insotu1_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu1_mei', '' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][2], $pos_tbl['insotu']['size'][2],
                get_field_string( $_SESSION['p'], 'insotu1_keitai_mobile', '' )
            );
            $this->__out_PDF_string_raw(
                $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][3], $pos_tbl['insotu']['size'][3],
                get_field_string( $_SESSION['p'], 'insotu1_keitai_tel', '' )
            );
            $position = get_field_string_number( $_SESSION['p'], 'insotu1_position', 0 );
            if( $position > 0 ){
                $pdf->Circle(
                    $pos_tbl['insotu']['x'][$position],
                    $pos_tbl['insotu']['y'][0]+1,
                    $pos_tbl['insotu']['size'][$position+3], 0, 360, '', [ 'width' => 0.5 ]
                );
            }

            $position = get_field_string_number( $_SESSION['p'], 'insotu2_position', 0 );
            if( $position == 5 ){
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][8], $pos_tbl['insotu']['size'][14],
                    get_field_string( $_SESSION['p'], 'insotu2_kana_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu2_kana_mei', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][9], $pos_tbl['insotu']['size'][15],
                    get_field_string( $_SESSION['p'], 'insotu2_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu2_mei', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][4], $pos_tbl['insotu']['y'][10], $pos_tbl['insotu']['size'][16],
                    get_field_string( $_SESSION['p'], 'insotu2_keitai_mobile', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][4], $pos_tbl['insotu']['y'][11], $pos_tbl['insotu']['size'][17],
                    get_field_string( $_SESSION['p'], 'insotu2_keitai_tel', '' )
                );
            } else {
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][4], $pos_tbl['insotu']['size'][0],
                    get_field_string( $_SESSION['p'], 'insotu2_kana_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu2_kana_mei', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][5], $pos_tbl['insotu']['size'][1],
                    get_field_string( $_SESSION['p'], 'insotu2_sei', '' ).' '.get_field_string( $_SESSION['p'], 'insotu2_mei', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][6], $pos_tbl['insotu']['size'][2],
                    get_field_string( $_SESSION['p'], 'insotu2_keitai_mobile', '' )
                );
                $this->__out_PDF_string_raw(
                    $pdf, $pos_tbl['insotu']['x'][0], $pos_tbl['insotu']['y'][7], $pos_tbl['insotu']['size'][3],
                    get_field_string( $_SESSION['p'], 'insotu2_keitai_tel', '' )
                );
                if( $position == 3 ){ $position = 0; }
                if( $position == 4 ){ $position = 3; }
                if( $position > 0 && $position < 5 ){
                    $pdf->Circle(
                        $pos_tbl['insotu']['x'][$position],
                        $pos_tbl['insotu']['y'][4]+1,
                        $pos_tbl['insotu']['size'][$position+3], 0, 360, '', [ 'width' => 0.5 ]
                    );
                }
            }
        }
        */
        
        //$pdf->Output(出力時のファイル名, 出力モード);
        $filename = sprintf( '%06d_', $_SESSION['auth']['id'] ) . date('YmdHis') . '.pdf';
        $pdf->Output(dirname(dirname(dirname(__FILE__))).'/output/'.$filename, "F");

        return $filename;
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------
    function InsertData()
    {
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'update information set `disp_id`=`disp_id`+1';
        db_query( $dbs, $sql );

        $sql = 'insert into information set'
            . " `disp_id`=1,"
            . " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
            . " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
            . " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
            . " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
            . " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
            . " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
            . " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
            . " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
            . " `image_pos`='" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . "',"
            . ' `create_date`=NOW()';
        db_query( $dbs, $sql );
        db_close( $dbs );
    }

    function UpdateData()
    {
        $id = get_field_string_number( $_SESSION['p'], 'id', 0 );
        if( $id == 0 ){ return; }
        $dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'update information set'
            . " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
            . " `comment`='" . mysql_real_escape_string( $_SESSION['p']['comment'], $dbs ) . "',"
            . " `image1`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image1'), $dbs ) . "',"
            . " `image1w`=" . get_field_string_number($_SESSION['p'],'image1w', 0) . ","
            . " `image1h`=" . get_field_string_number($_SESSION['p'],'image1h', 0) . ","
            . " `image2`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image2'), $dbs ) . "',"
            . " `image2w`=" . get_field_string_number($_SESSION['p'],'image2w', 0) . ","
            . " `image2h`=" . get_field_string_number($_SESSION['p'],'image2h', 0) . ","
            . " `image_pos`=" . mysql_real_escape_string( $_SESSION['p']['image_pos'], $dbs ) . ""
            . " where `id`=" . $id;
        db_query( $dbs, $sql );
        db_close( $dbs );
    }
}

?>
