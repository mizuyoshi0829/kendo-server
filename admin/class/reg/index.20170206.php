<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_2.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_3.php';
//	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_4.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_5.php';
	require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'reg_6.php';

class form_page_reg_index extends form_page
{
	function init( $series, $edit )
	{
		parent::init( $series, $edit );
		$logout = get_field_string_number( $_GET, 'logout', 0 );
		if( $logout == 1 ){
			$_SESSION['auth']['login'] = 0;
		}
		if(
             isset($_SESSION['auth']) && $series != 0 && isset($_SESSION['auth']['series'])
             && $_SESSION['auth']['series'] != $series && $_SESSION['auth']['login'] == 1
        ){
			if( !$this->entry_user_login2( $_SESSION['auth']['id'], $series ) ){
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
				return;
			}
		}
		$mode = get_field_string( $_POST, 'mode', '' );
		if( $mode == 'auth' ){
			$id = get_field_string( $_POST, 'username', '' );
			$pass = substr( '00'.get_field_string( $_POST, 'password', '' ), -8, 8 );
			if( $this->entry_user_login( $id, $pass, $series ) ){
				$mode = '';
			//	$_SESSION['auth']['series'] = __REG_SERIES__;
			//	$this->template = 'reg' . DIRECTORY_SEPARATOR . 'series.html';
			//	return;
			} else {
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'login.html';
				return;
			}
		} else {
			if(
				!isset($_SESSION['auth'])
				//|| ( ( $series == 2 || $series == 3 || $series == 4 || $series == 5 || $series == 6 ) && $edit == 0 && $_SESSION['auth']['login'] != 2 )
				|| ( ( $series == 2 || $series == 3 || $series == 4 || $series == 5 || $series == 6 ) && $edit == 0 )
				|| ( ( $series == 2 || $series == 3 || $series == 4 || $series == 5 || $series == 6 ) && $edit == 1 && $_SESSION['auth']['login'] != 1 )
				|| ( $series != 2 && $series != 3 && $series != 4 && $series != 5 && $series != 6 && $_SESSION['auth']['login'] != 1 )
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
				} else if( $series == 3 && $edit == 0 ){
					$_SESSION['auth']['login'] = 2;
					$_SESSION['auth']['series'] = 3;
    				$_SESSION['auth']['year'] = 2017;
				} else if( $series == 2 && $edit == 0 ){
					$_SESSION['auth']['login'] = 2;
					$_SESSION['auth']['series'] = 2;
    				$_SESSION['auth']['year'] = 2017;
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
			}
		}

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
		$this->smarty_assign['fields_info'] = $this->get_entry_fields_info( $_SESSION['auth']['series'], 1 );
		$this->smarty_assign['root_url'] = '';
		$this->smarty_assign['post_action'] = 'index.php';
		if( $_SESSION['auth']['series'] == 3 ){
			$this->smarty_assign['post_action'] = 'index2.php';
		}
		$this->smarty_assign['mform_msg'] = '';
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
	//	$mode = get_field_string( $_POST, 'mode' );
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
				if( $this->GetFormPostData() != 1 ){
					$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mconfirm.html';
					return;
				}
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
							. "エントリー内容の変更は http://www.kendo-nagano.com/kendo/regedit/index.php から\n"
							. "お知らせしましたIDとパスワードを入力して下さい。\n";
						if( $school_email != '' ){
							mb_send_mail( $school_email, $title, $body, $header_info );
						}
						mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
						mb_send_mail( 'iyasu@j-ad.co.jp', $title, $body, $header_info );
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
							. "エントリー内容の変更は http://www.kendo-nagano.com/kendo/regedit/index2.php から\n"
							. "お知らせしましたIDとパスワードを入力して下さい。\n";
						if( $school_email != '' ){
							mb_send_mail( $school_email, $title, $body, $header_info );
						}
						mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
						mb_send_mail( 'iyasu@j-ad.co.jp', $title, $body, $header_info );
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
							. "エントリー内容の変更は http://www.kendo-nagano.com/kendo/regedit/index.php から\n"
							. "お知らせしましたIDとパスワードを入力して下さい。\n";
						if( $school_email != '' ){
							mb_send_mail( $school_email, $title, $body, $header_info );
						}
						mb_send_mail( 'mizu@pop01.odn.ne.jp', $title, $body, $header_info );
						mb_send_mail( 'iyasu@j-ad.co.jp', $title, $body, $header_info );
					}
					$this->smarty_assign['mform_msg'] = 'エントリーを受け付けました。';
				} else {
					$this->smarty_assign['mform_msg'] = 'エントリー入力を受け付けました。';
				}
				$_SESSION['p'] = $this->get_entry_one_data( $info_id );
				$_SESSION['e'] = $this->init_entry_post_data( $_SESSION['auth']['series'] );
				$this->smarty_assign['edit_title'] = '編集';
				//$this->template = 'reg' . DIRECTORY_SEPARATOR . 'series.html';
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
				return;
			} else {
				$this->smarty_assign['edit_title'] = '編集';
				$this->template = 'reg' . DIRECTORY_SEPARATOR . 'mform.html';
				return;
			}
		}
		$_SESSION['p'] = array();
	//	$this->smarty_assign['list'] = $this->GetRegDataList( $category );
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
		$this->get_entry_post_data( $_SESSION['auth']['series'] );
		$this->add_entry_post_data_select_name( $_SESSION['auth']['series'] );
//print_r($_SESSION['p']);
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
