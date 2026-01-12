<?php
//-------------------------------------------------------------------
//
//-------------------------------------------------------------------
//---------------------------------------------------------------
//	携帯キャリアの判別
//
define( 'KEITAI_DOCOMO', '1' );
define( 'KEITAI_SOFTBANK', '2' );
define( 'KEITAI_AU', '3' );
define( 'KEITAI_OTHERS', '0' );

function GetKeitaiMode()
{
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	$host = $_SERVER{'REMOTE_HOST'};
//	if( ereg("^DoCoMo",$agent) && ereg(".+docomo\.ne\.jp$",$host) ){
	if( ereg("^DoCoMo",$agent) ){
		return( KEITAI_DOCOMO );
//	} else if( ereg("^J-PHONE|^Vodafone|^SoftBank", $agent) && ereg(".+jp-.\.ne\.jp$",$host) ){
	} else if( ereg("^J-PHONE|^Vodafone|^SoftBank", $agent) ){
		return( KEITAI_SOFTBANK );
//	} else if( ereg("^UP.Browser|^KDDI", $agent) && ereg(".+ezweb\.ne\.jp$",$host) ){
	} else if( ereg("^UP.Browser|^KDDI", $agent) ){
		return( KEITAI_AU );
	} else {
		return( KEITAI_OTHERS );
	}
}

//---------------------------------------------------------------
//
//
function get_mail( $host, $user, $pass, $imgdir )
{
	$mail_data = array();
	//接続
	$sock = fsockopen( $host, 110, $err, $errno, 10 );
	if( !$sock ){
		return $mail_data;
	}

	$buf = fgets( $sock, 512 );
	if( substr($buf, 0, 3) != '+OK'){
	//	$msg = $buf;
		return $mail_data;
	}
		
	//認証
	$buf = get_mail_sendcmd("USER " . $user, $sock);
	$buf = get_mail_sendcmd("PASS " . $pass, $sock);
		
	//STAT 件数とサイズ取得 ex) +OK 8 1234
	$data = get_mail_sendcmd("STAT", $sock);
	sscanf($data, '+OK %d %d', $num, $size);
	if( $num == "0" ){
		$buf = get_mail_sendcmd("QUIT", $sock);
		fclose($sock);
	//	$msg = '受信メールなし';
		return $mail_data;
	}
		
	//メール受信
	$dat = array();
	for( $i1 = 1; $i1 <= $num; $i1++ ){
		//RETR n -n番目のメッセージ取得（ヘッダ含）
		$line = get_mail_sendcmd( "RETR $i1", $sock );

		//EOFの.まで読む
		while( !ereg( "^\.\r\n", $line ) ){
			$line = fgets( $sock, 512 );
			$dat[$i1] .= $line;
		}

		//DELE n n番目のメッセージ削除
		$data = get_mail_sendcmd( "DELE $i1", $sock );
	}
		
	//切断
	$buf = get_mail_sendcmd( "QUIT", $sock );
	fclose( $sock );

	//メール読み込み
	for( $i1 = 1; $i1 <= $num; $i1++ ){
		$subject = $from = $mail_to = $text = $atta = $part = $attach = "";

		list( $head, $body ) = get_mail_mime_split( $dat[$i1] );

		// 日付の抽出
		eregi( "Date:[ \t]*([^\r\n]+)", $head, $datereg );
		$now = strtotime($datereg[1]);
		if( $now == -1 ){ $now = time(); }
	//	$head = ereg_replace("\r\n? ", "", $head);

		// サブジェクトの抽出
		if( eregi("\nSubject:[ \t]*([^\r\n]+)", $head, $subreg) ){
			$subject = $subreg[1];
			while (eregi("(.*)=\?iso-2022-jp\?B\?([^\?]+)\?=(.*)",$subject,$regs)){
				//MIME Bﾃﾞｺｰﾄﾞ
				$subject = $regs[1].base64_decode($regs[2]).$regs[3];
			}
			while (eregi("(.*)=\?iso-2022-jp\?Q\?([^\?]+)\?=(.*)",$subject,$regs)){
				//MIME Bﾃﾞｺｰﾄﾞ
				$subject = $regs[1].quoted_printable_decode($regs[2]).$regs[3];
			}
			$subject = htmlspecialchars( get_mail_convert($subject) );
		}

		// 送信者アドレスの抽出
		if(eregi("From:[ \t]*([^\r\n]+)", $head, $freg)){
			$from = get_mail_addr_search( $freg[1] );
		} elseif(eregi("Reply-To:[ \t]*([^\r\n]+)", $head, $freg)){
			$from = get_mail_addr_search( $freg[1] );
		} elseif(eregi("Return-Path:[ \t]*([^\r\n]+)", $head, $freg)){
			$from = get_mail_addr_search( $freg[1] );
		}

		// 送信者アドレスの抽出
		if( eregi( "\nTo:[ \t]*([^\r\n]+)", $head, $freg ) ){
			$mail_to = get_mail_addr_search( $freg[1] );
		}

		// マルチパートならばバウンダリに分割
		if( eregi( "\nContent-type:.*multipart/", $head ) ){
			eregi('boundary="([^"]+)"', $head, $boureg);
			$part = explode("--".$boureg[1],$body);
			if (eregi('boundary="([^"]+)"', $part[1], $boureg2)){
				//multipart/altanative
				$npart = explode("--".$boureg2[1],$part[1]);
				array_splice($part, 1, 1, $npart);
			}
		} else {
			// 普通のテキストメール
			$part[0] = $dat[$i1];
		}

		//画像用配列
		$filename = array();
		$tmp_name = array();
		$c = 0;
		foreach( $part as $multi ){
			list( $m_head, $m_body ) = get_mail_mime_split( $multi );
			$m_body = ereg_replace("\r\n\.\r\n$", "", $m_body);
			if( !eregi("Content-type: *([^;\n]+)", $m_head, $type) ){ continue; }
			list( $main, $sub ) = explode("/", $type[1]);

			// 本文をデコード
			if( strtolower($main) == "text" ){
				if( strtolower($sub) == "html" && $text != "" ){ continue; }
				if( eregi("Content-Transfer-Encoding:.*base64", $m_head)){
					$m_body = base64_decode( $m_body );
				}
				if(eregi("Content-Transfer-Encoding:.*quoted-printable", $m_head)){
					$m_body = quoted_printable_decode( $m_body );
				}
				$text = get_mail_convert($m_body);
				if (strtolower($sub) == "html") $text = strip_tags($text);
				// 電話番号削除
				$text = eregi_replace("([[:digit:]]{11})|([[:digit:]\-]{13})", "", $text);
				// 下線削除
				$text = eregi_replace("[_]{25,}", "", $text);
				// mac削除
				$text = ereg_replace("Content-type: multipart/appledouble;[[:space:]]boundary=(.*)","",$text);
				//改行変換
				$text = str_replace("\r\n", "\r",$text);
				$text = str_replace("\r", "\n",$text);
			}

			// ファイル名を抽出
			if (eregi("name=\"?([^\"\n]+)\"?",$m_head, $filereg)){
				$filename[$c] = ereg_replace("[\t\r\n]", "", $filereg[1]);
				while (eregi("(.*)=\?iso-2022-jp\?B\?([^\?]+)\?=(.*)",$filename[$c],$regs)){
					$filename[$c] = $regs[1].get_mail_base64_decode($regs[2]).$regs[3];
					$filename[$c] = get_mail_convert( $filename[$c] );
				}
			}

			// 添付データをデコード
			if( eregi("Content-Transfer-Encoding:.*base64", $m_head) ){
				$tmp = base64_decode( $m_body );
				$tmp_name[$c] = date('YmdHis') . substr( '000'.(int)(microtime()*1000), -3, 3 ) . '_' . $filename[$c];
				$fp = fopen( $imgdir.'/'.$tmp_name[$c], "w" );
				fputs( $fp, $tmp );
				fclose( $fp );
				chmod( $imgdir.'/'.$tmp_name[$c], 0666 );
				$c++;
			}
		}
		$mail_data[] = array(
			'subject'=>$subject, 'from'=>$from, 'to'=>$mail_to,
			'date'=>$now, 'text'=>$text, 'files'=>$tmp_name
		);
	}
	return $mail_data;
}

/* コマンドー送信 */
function get_mail_sendcmd( $cmd, $sock )
{
	fputs( $sock, $cmd."\r\n" );
	$buf = fgets( $sock, 512 );
	if( substr( $buf, 0, 3 ) == '+OK' ){
		return $buf;
	} else {
		die( $buf );
	}
	return false;
}

/* ヘッダと本文を分割する */
function get_mail_mime_split( $data )
{
	$part = split( "\r\n\r\n", $data, 2 );
	$part[1] = ereg_replace( "\r\n[\t ]+", " ", $part[1] );
	return $part;
}

/* メールアドレスを抽出する */
function get_mail_addr_search( $addr )
{
	if( eregi("[-!#$%&\'*+\\./0-9A-Z^_`a-z{|}~]+@[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+", $addr, $fromreg ) ){
		return $fromreg[0];
	} else {
		return false;
	}
}

/* 文字コードコンバートJIS→SJIS */
function get_mail_convert( $str )
{
	$enc = mb_detect_encoding( $str, 'JIS,SJIS,UTF-8' );
	$ret = mb_convert_encoding( $str, 'EUC-JP', $enc );
	return $ret;
}

//---------------------------------------------------------------
//
//---------------------------------------------------------------
//---------------------------------------------------------------
//
//
function send_form_mail( $configs, $InData, $code )
{
	$sender_name = '';
	$sender_email = '';
	$text = get_field_string( $configs, 'title' ) . "\n\n";
	$namelen = 0;
	foreach( $configs['fields'] as $f ){
		if( $f['send'] == 1 ){
			$l = mb_strwidth( $f['name'] );
			if( $l > $namelen ){ $namelen = $l; }
		}
	}
	foreach( $configs['fields'] as $f ){
		if( $f['sender_name'] == 1 ){
			$sender_name = mb_convert_encoding( $InData[$f['field']], 'UTF-8', $code );
		}
		if( $f['email'] == 1 ){
			$sender_email = $InData[$f['field']];
		}
		if( $f['send'] == 1 ){
			if( is_array($InData[$f['field']]) ){
				$top = 1;
				foreach( $InData[$f['field']] as $v ){
					if( $top == 1 ){
						$text .= ( mb_strimwidth( $f['name'].'                    ', 0, $namelen ) . ' : ' . mb_convert_encoding($v,'UTF-8',$code) . "\n" );
						$top = 0;
					} else {
						$text .= ( mb_strimwidth( '                               ', 0, $namelen ) . ' : ' . mb_convert_encoding($v,'UTF-8',$code) . "\n" );
					}
				}
			} else {
				$text .= ( mb_strimwidth( $f['name'].'                    ', 0, $namelen ) . ' : ' . mb_convert_encoding($InData[$f['field']],'UTF-8',$code) . "\n" );
			}
		}
	}

	//メール送信
	$head  = "X-Mailer: PHP Mail\n";
	$head .= 'From: "' . mb_encode_mimeheader($sender_name) . '" <' . $sender_email . '>';
	$body  = $text;
	$body .= "\n";
	$body .= "ホスト：" . gethostbyaddr($_SERVER['REMOTE_ADDR']) . "\n";
	foreach( explode(',', $configs['sendmail_address']) as $address ){
		$flag = mb_send_mail( $address, $configs['subject'], unify_input($body), $head);
		if (!$flag) {
			exit('メールの送信に失敗しました。');
		}
	//	echo mb_convert_encoding($address.$configs['subject'].unify_input($body).$head,'SJIS','UTF-8');
	}
}

//---------------------------------------------------------------
//
//---------------------------------------------------------------
//---------------------------------------------------------------
//
//
define( 'CRYPT_IV', '+I5r1ppZskQ=' );

function crypt_blowfish( $data, $key, $encode )
{
	if( $encode == 1 ){
		$cdata = base64_encode( $data );
	} else {
		$cdata = $data;
	}
	/**
	 * 初期化ベクトルを用意する
	 * Windowsの場合、MCRYPT_DEV_URANDOMの代わりにMCRYPT_RANDを使用する
	 */
//	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
	$iv = base64_decode(CRYPT_IV);

	// 事前処理
	$resource = mcrypt_module_open(MCRYPT_BLOWFISH, '',  MCRYPT_MODE_CBC, '');

	// 暗号化処理
	mcrypt_generic_init($resource, $key, $iv);
	$encrypted_data = mcrypt_generic($resource, $cdata);
	mcrypt_generic_deinit($resource);

	// モジュールを閉じる
	mcrypt_module_close($resource);

	return base64_encode($encrypted_data);
}


function decrypt_blowfish( $data, $key, $encode )
{
	/**
	 * 初期化ベクトルを用意する
	 * Windowsの場合、MCRYPT_DEV_URANDOMの代わりにMCRYPT_RANDを使用する
	 */
//	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
	$iv = base64_decode(CRYPT_IV);

	// 事前処理
	$resource = mcrypt_module_open(MCRYPT_BLOWFISH, '',  MCRYPT_MODE_CBC, '');

	// 復号処理
	mcrypt_generic_init($resource, $key, $iv);
	$base64_decrypted_data = mdecrypt_generic($resource, base64_decode($data));
	mcrypt_generic_deinit($resource);

	// モジュールを閉じる
	mcrypt_module_close($resource);

	if( $encode == 1 ){
		return base64_decode( base64_decrypted_data );
	} else {
		return $base64_decrypted_data;
	}
}

//---------------------------------------------------------------
//
//---------------------------------------------------------------
//---------------------------------------------------------------
//
//
function join_array( $a, $d )
{
	$j = '';
	foreach( $a as $v ){
		if( $j !== '' ){ $j .= ','; }
		$j .= ( $d . $v . $d );
	}
	return $j;
}

function join_multiarray( $a, $f, $d )
{
	$j = '';
	foreach( $a as $v ){
		if( $j !== '' ){ $j .= ','; }
		$j .= ( $d . $v[$f] . $d );
	}
	return $j;
}

function get_field_string( $a, $key )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return $a[$key];
	} else {
		return "";
	}
}

function get_field_string_insert_br( $a, $key )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		$s = preg_split( "//u", $a[$key], -1, PREG_SPLIT_NO_EMPTY );
        $cs = count( $s );
        if( $cs > 0 ){
            for( $i1 = 0; $i1 < $cs; $i1++ ){
                if( $s[$i1] === 'ー' ){ $s[$i1] = '丨'; }
            }
        }
		return implode( '<br />', $s );
	} else {
		return "";
	}
}

function string_insert_br( $str )
{
	$s = preg_split( "//u", $str, -1, PREG_SPLIT_NO_EMPTY );
	return implode( '<br />', $s );
}

function get_field_string_number( $a, $key, $d )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return intval( $a[$key] );
	} else {
		return intval( $d );
	}
}

function get_field_array( $a, $key )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return $a[$key];
	} else {
		$r = array();
		return $r;
	}
}

function get_field_string_sanitize( $a, $key )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return sanitize_input( $a[$key] );
	} else {
		return "";
	}
}

function get_field_string_number_sanitize( $a, $key, $d )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return intval( sanitize_input( $a[$key] ) );
	} else {
		return intval( $d );
	}
}

function get_field_array_sanitize( $a, $key )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		return sanitize_input( $a[$key] );
	} else {
		$r = array();
		return $r;
	}
}

function get_field_string_encode( $a, $key, $t, $f )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		if( $f == $t ){ return $a[$key]; }
		return mb_convert_encoding( $a[$key], $t, $f );
	}
	return "";
}

function get_field_string_encode_sanitize( $a, $key, $t, $f )
{
	if( is_array( $a ) && isset( $a[$key] ) ){
		$s = sanitize_input( $a[$key] );
		if( $f == $t ){ return $s; }
		return mb_convert_encoding( $s, $t, $f );
	}
	return "";
}

function get_field_array_encode( $a, $key, $t, $f )
{
	$r = array();
	if( is_array( $a ) && isset( $a[$key] ) ){
		if( $f == $t ){ return $a[$key]; }
		foreach( $a[$key] as $s ){
			$r[] = mb_convert_encoding( $s, $t, $f );
		}
	}
	return $r;
}

function get_field_array_encode_sanitize( $a, $key, $t, $f )
{
	$r = array();
	if( is_array( $a ) && isset( $a[$key] ) ){
		$str = sanitize_input( $a[$key] );
		if( $f == $t ){ return $str; }
		foreach( $str as $s ){
			$r[] = mb_convert_encoding( $s, $t, $f );
		}
	}
	return $r;
}

function convert_encode( $data, $t, $f )
{
	if( is_array( $data ) ){
		$a = array();
		foreach( $data as $k => $d ){
			$a[$k] = convert_encode( $d, $t, $f );
		}
		return $a;
	}
	if( $f == $t ){ return $data; }
	return mb_convert_encoding( $data, $t, $f );
}

//---------------------------------------------------------------
// 不正データ削除
//
function sanitize_input( $data )
{
	if( is_array( $data ) ){
		return array_map( 'sanitize_input', $data );
	}
//	$d = trim( $data );
	$d = strip_tags( $data );
	if( get_magic_quotes_gpc() ){ $d = stripslashes( $d ); }
	$d = preg_replace("/\r?\n/", "\r", $d);
	$d = preg_replace("/\r/", "\n", $d);
	$d = mysql_real_escape_string( $d );
	return str_replace( "\0", '', $d );
}

function sanitize_input_enabletags( $data )
{
	if( is_array( $data ) ){
		return array_map( 'sanitize_input_enabletags', $data );
	}
	$d = trim( $data );
//	$d = strip_tags( $d );
	if( get_magic_quotes_gpc() ){ $d = stripslashes( $d ); }
	$d = preg_replace("/\r?\n/", "\r", $d);
	$d = preg_replace("/\r/", "\n", $d);
	$d = mysql_escape_string( $d );
	return str_replace( "\0", '', $d );
}

function unescape_input_db( $data )
{
	if( is_array( $data ) ){
		return array_map( 'unescape_input_db', $data );
	}
	return str_replace( '\n', "\n", $data );
}

function unescape_input_db_br( $data )
{
	return str_replace( '\n', "<br />", $data );
}

function convert_nl_br( $data )
{
	return str_replace( "\n", "<br />", $data );
}

//---------------------------------------------------------------
// 改行コード統一
//
function unify_input( $data )
{
	if( is_array( $data ) ){
		return array_map('unify_input', $data);
	}
	$data = preg_replace("/\r?\n/", "\r", $data);
	$data = preg_replace("/\r/", "\n", $data);
	return $data;
}

//---------------------------------------------------------------
// データ正規化
//
function normalize_input( $data )
{
//	return sanitize_input( $data );
//	$d = sanitize_input( $data );
//	return unify_input( $d );
	return $data;
}

function convert_encode_input( $data, $e )
{
	if( is_array( $data ) ){
		$a = array();
		foreach( $data as $k => $d ){
			$a[$k] = convert_encode_input( $d, $e );
		}
		return $a;
	}
	convert_encode( $data, 'UTF-8', $e );
	return $data;
}

/******************************************************************************
	イメージ作成
******************************************************************************/
function make_img( &$img, $field, $imginfo, $path, $namemode, $id )
{
	if( !isset($_FILES[$field]['name']) || $_FILES[$field]['name'] == '' ){
		return;
	}

	//拡張子の取得
	preg_match("/(.*)\.(\w+)$/", $_FILES[$field]['name'], $m );
	$ext = $m[2];
	if( preg_match("/^jpe?g$/i", $ext) ){
		$ext = 'jpg';
	} else if( $ext == 'gif' ){
		$ext = 'gif';
	} else {
		return;
	}

	//サムネイル作成
	if( $namemode == 0 ){
		$fname = 'img' . date('YmdHis') . (int)(microtime()*1000);
	} else if( $namemode == 1 ){
		$fname = 'img' . $id;
	} else if( $namemode == 2 ){
		$fname = 'img';
	} else {
		return;
	}
	foreach( $imginfo as $iv ){
		make_thumb( $img, $field, $fname, $iv, $path, $ext );
	}
	if( file_exists( $path.'org' ) ){
		if( isset($_FILES[$field]['tmp_name']) && is_uploaded_file($_FILES[$field]['tmp_name']) ){
			copy( $_FILES[$field]['tmp_name'], $path.'org/'.$fname.'.'.$ext );
		}
	}

	return;
}
//amke_img

/******************************************************************************
	サムネイル作成
******************************************************************************/
function make_thumb( &$img, $field, $fname, $info, $path, $ext )
{
	if( !isset($_FILES[$field]['tmp_name']) ){
		return;
	}
	if( !is_uploaded_file($_FILES[$field]['tmp_name']) ){
		return;
	}

	//GDモジュール判定
	if( !extension_loaded('gd') ){
		return;
	}

	ini_set( 'memory_limit', '60M' );
	if( $ext == 'jpg' ){
		$im = imagecreatefromjpeg( $_FILES[$field]['tmp_name'] );
	} else if( $ext == 'gif' ){
		$im = imagecreatefromgif( $_FILES[$field]['tmp_name'] );
	} else {
		return;
	}
	if( !$im ){ return; }

	//サイズ取得
	$width = imagesx( $im );
	$height = imagesy( $im );

	if( $width > $info['width'] || $height > $info['height'] ){
		$th = $info['height'] / $height;
		$tw = $info['width'] / $width;
		$flag = ($th < $tw) ? $th : $tw;
		$n_height = (int)( $height * $flag );
		$n_width  = (int)( $width * $flag );
	} else {
		$n_width = $width;
		$n_height = $height;
	}

	//リサイズ
	$n_im = imagecreatetruecolor( $n_width, $n_height );
	imagecopyresampled( $n_im, $im, 0, 0, 0, 0, $n_width, $n_height, $width, $height );
	
	//ファイル名
	$new_name = $fname . '_' . $info['thumbnail'] . ".jpg";
	
	$f = $info['photo'].'_'.$info['thumbnail'];
	$c = count( $img );
	if( $c > 0 ){
		for( $i1 = 0; $i1 < $c; $i1++ ){
			if( isset($img[$i1][$f]) ){
				$of = $path . $img[$i1][$f];
				if( file_exists($of) ){ unlink($of); }
				$img[$i1][$f] = $new_name;
				$img[$i1]['width'] = $n_width;
				$img[$i1]['height'] = $n_height;
				break;
			}
		}
	}
	if( $c == 0 || $i1 == $c ){
		$r = array();
		$r[$f] = $new_name;
		$r['width'] = $n_width;
		$r['height'] = $n_height;
		$img[] = $r;
	}

	//ファイル書込み
	imagejpeg( $n_im, $path.$new_name );
	chmod( $path.$new_name, 0666 );

	return;
}
//make_thumb

//-------------------------------------------------------------------
//
//
function search_zipcode( $zip1, $zip2 )
{
	$r = array();
	if( $zip1 === '' ){
		return $r;
	} else {
		$z1 = $zip1;
		$z2 = $zip2;
	}
	$r = array();
	$dbs = mysql_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD );
	if( $dbs === false ){ return $r; }
	if( mysql_select_db( DATABASE_NAME, $dbs ) === false ){
		//失敗
		mysql_close( $dbs );
		return $r;
	}
	mysql_query( "set character set utf8", $dbs );
	$sql = sprintf( "select * from zip_table where zip='%03d%04d'", $z1, $z2 );
	$rs = mysql_query( $sql, $dbs );
	if( $rs !== false && mysql_num_rows($rs) > 0 ){
		$r = mysql_fetch_assoc($rs);
	}
	mysql_close( $dbs );
	return $r;
}

//-------------------------------------------------------------------
//
//-------------------------------------------------------------------
function db_connect( $host, $user, $pass, $name )
{
//データベース接続
//接続
	$dbs = new mysqli( $host, $user, $pass, $name );
	if( $dbs === false ){
		//接続失敗
		echo 'データベース接続に失敗しました。(1)';
		exit;
	}
	//データベース選択
	$dbs->set_charset( "utf8" );
	return $dbs;
}

function db_close( $dbs )
{
	$dbs->close();
}

function db_query( $dbs, $sql )
{
//echo $sql,"<br>\n";
	return $dbs->query( $sql );
}

function db_query_list( $dbs, $sql )
{
	$line = array();
	$rs = $dbs->query( $sql );
	if( $rs !== false ){
		while( $row = $rs->fetch_assoc() ){
			$line[] = $row;
		}
	}
	return $line;
}

function db_query_list_assoc( $dbs, $sql, $field )
{
	$line = array();
	$rs = mysql_query( $sql, $dbs );
	if( $rs !== false ){
		while( $row = mysql_fetch_assoc( $rs ) ){
			$f = get_field_string( $row, $field );
			if( $f === '' ){
				$line[] = $row;
			} else {
				$line[$f] = $row;
			}
		}
	}
	return $line;
}

function db_query_list_assoc_int( $dbs, $sql, $field )
{
	$line = array();
	$rs = mysql_query( $sql, $dbs );
	if( $rs !== false ){
		while( $row = mysql_fetch_assoc( $rs ) ){
			if( isset( $row[$field] ) ){
				$n = intval( $row[$field] );
				$line[$n] = $row;
			}
		}
	}
	return $line;
}

function db_query_one_data( $dbs, $sql )
{
	$rs = $dbs->query( $dbs );
	if( $rs === false ){
		//失敗
		$dbs->close();
echo 'db_query_one_data( '.$sql;
		echo 'データベース接続に失敗しました。(3)';
		exit;
	}
	$line = $rs->fetch_assoc();
	if( $line === false ){
		//失敗
		echo 'データベース接続に失敗しました。(4)';
		exit;
	}
	return $line;
}

function db_get_data_list( $dbs, $table, $col, $where, $limit, $offset, $order )
{
	$line = array();
	$sql = 'select '.$col.' from `'.$table.'`';
	if( $where !== '' ){ $sql .= ( ' where ' . $where ); }
	if( $order !== '' ){ $sql .= ( ' order by ' . $order ); }
	if( $limit != 0 ){
		$sql .= ( ' limit ' . $offset . ','. $limit );
	}
	$rs = mysql_query( $sql, $dbs );
	if( $rs !== false ){
		while( $row = mysql_fetch_assoc( $rs ) ){
			$line[] = $row;
		}
	}
	return $line;
}

function db_get_one_data( $dbs, $table, $col, $where )
{
	$sql = 'select '.$col.' from '.$table;
	if( $where !== '' ){ $sql .= ( ' where ' . $where ); }
	$rs = $dbs->query( $sql );
	if( $rs === false ){
		//失敗
		$dbs->close();
echo 'db_get_one_data( '.$sql;
		echo 'データベース接続に失敗しました。(3)';
		exit;
	}
	$line = $rs->fetch_assoc();
	if( $line === false ){
		//失敗
		echo 'データベース接続に失敗しました。(4)';
		exit;
	}
	return $line;
}

function db_query_insert_id( $dbs )
{
	return $dbs->insert_id;
}

//-------------------------------------------------------------------
//
//-------------------------------------------------------------------

function get_pref_table()
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

//-------------------------------------------------------------------
//
//
/**
 * 文字列
 * @param unknown $str
 */
function checkString( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	return true;
}
/**
 * 整数値
 * @param unknown $str
 */
function checkInteger( &$sess, $sessField, $req, $reqField, $name, $exist, $len, $zero )
{
	$sess['e'][$sessField] = '';
	$str = get_field_string( $req, $reqField, '' );
	if( $exist && $str == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $str ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	$sess['p'][$sessField] = intval( $str );
	if( $zero && $sess['p'][$sessField] === 0 ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	return true;
}
/**
 * 数字
 * @param unknown $str
 */
function checkDigits( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	if( $sess['p'][$sessField] !== '' && !$this->_vdigits->isValid( $sess['p'][$sessField] ) ){
		$sess['e'][$sessField] = $name . "には数字を入力してください。";
		return false;
	}
	return true;
}
/**
 * フリガナ
 * @param unknown $str
 */
function checkKana( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	if( $sess['p'][$sessField] !== '' && !preg_match( "/^[ァ-ヾ]+$/u", $sess['p'][$sessField] ) ){
		$sess['e'][$sessField] = $name."にはカタカナを入力してください。";
		return false;
	}
	return true;
}
/**
 * 半角英数字記号
 * @param unknown $str
 */
function checkAlnumkigou( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	if( $sess['p'][$sessField] !== '' && !preg_match( "/^[ -~]+$/u", $sess['p'][$sessField] ) ){
		$sess['e'][$sessField] = $name . "には半角英数字記号を入力してください。";
		return false;
	}
	return true;
}
/**
 * 小数
 * @param unknown $str
 */
function checkFloat( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
//	if( $len > 0 && strlen( bin2hex( $sess['p'][$sessField] ) ) / 2 > $len ){
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
	if( $sess['p'][$sessField] !== '' && !$this->_vfloat->isValid( $sess['p'][$sessField] ) ){
		$sess['e'][$sessField] = $name . "には数字を入力してください。";
		return false;
	}
	return true;
}
/**
 * E-mail
 * @param unknown $str
 */
function checkEmail( &$sess, $sessField, $req, $reqField, $reqFieldCheck, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return false;
	}
	if( $len > 0 && mb_strlen( $sess['p'][$sessField] ) / 3 > $len ){
		$sess['e'][$sessField] = $name . "は" . $len . "文字までです。";
		return false;
	}
//	if( $sess['p'][$sessField] !== '' && !isEmailAddress( $str ) ){
	//	$sess['e'][$sessField] = $name . "を正しく入力して下さい。";
	//	return false;
//	}
	$check = get_field_string( $req, $reqFieldCheck, '' );
	if( $check == '' || $check != $sess['p'][$sessField] ){
		$sess['e'][$sessField] = $name . "の入力内容をご確認下さい。";
		return false;
	}
	return true;
}
/**
 * 日付
 * @param unknown $str
 */
function checkDate_( &$sess, $sessField, $req, $reqField, $name, $exist, $len )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return '';
	}
	if( preg_match( '/^([0-9]{4})[年]([0-9]{1,2})[月]([0-9]{1,2})[日]$/u', $sess['p'][$sessField], $m ) === 1 ){
		$visit_day = $m[1] . '-' . $m[2] . '-' . $m[3];
	} else {
		$sess['e'][$sessField] = $name . "の日付が間違っています。";
		return '';
	}
	if( checkdate( $m[2], $m[3], $m[1] ) === false ){
		$sess['e'][$sessField] = "存在しない日付です。";
		return '';
	}
	return $visit_day;
}
/**
 * 郵便番号
 * @param unknown $str
 */
function checkZip( &$sess, $sessField, $req, $reqField, $name, $exist )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return '';
	}
	if( $sess['p'][$sessField] != '' ){
		if( preg_match( '/^([0-9]{7})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^([0-9]{3})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		$sess['e'][$sessField] = $name . "を正しく入力して下さい。";
		return false;
	}
	return true;
}
/**
 * 電話番号
 * @param unknown $str
 */
function checkTel( &$sess, $sessField, $req, $reqField, $name, $exist )
{
	$sess['p'][$sessField] = get_field_string( $req, $reqField, '' );
	$sess['e'][$sessField] = '';
	if( $exist && $sess['p'][$sessField] == '' ){
		$sess['e'][$sessField] = $name . "を入力してください。";
		return '';
	}
	if( $sess['p'][$sessField] != '' ){
		if( preg_match( '/^0([0-9]{9,10})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^0([0-9]{2})-([0-9]{4})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^0([0-9]{1})-([0-9]{4})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^0([0-9]{2})-([0-9]{3})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^0([0-9]{3})-([0-9]{2})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		if( preg_match( '/^0([0-9]{4})-([0-9]{1})-([0-9]{4})$/u', $sess['p'][$sessField], $m ) === 1 ){ return true; }
		$sess['e'][$sessField] = $name . "を正しく入力して下さい。";
		return false;
	}
	return true;
}
/**
 * E-mail
 * @param unknown $str
 */
function isEmailAddress( $str )
{
	if( preg_match( '/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $str ) === 1 ){
		return true;
	}
	return false;
}

//-------------------------------------------------------------------
//
//-------------------------------------------------------------------
// パスワードに使っても良い文字集合
//$password_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//$password_chars_count = strlen($password_chars);

// $sizeに指定された長さのパスワードを生成
function generate_password( $size, $password_chars )
{
	$password_chars_count = strlen( $password_chars );
	$data = mcrypt_create_iv( $size, MCRYPT_DEV_URANDOM );
	$pin = '';
	for( $n = 0; $n < $size; $n++ ){
		$pin .= substr( $password_chars, ord( substr( $data, $n, 1 ) ) % $password_chars_count, 1 );
	}
	return $pin;
}
//-------------------------------------------------------------------
//
//-------------------------------------------------------------------
?>
