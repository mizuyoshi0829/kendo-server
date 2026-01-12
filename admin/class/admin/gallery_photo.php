<?php
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_gallery_photo extends form_page
{
	function init()
	{
		$page = get_field_string_number( $_GET, 'p', 1 );
		parent::init();
		if( $_SESSION['auth'] != 1 ){ exit; }

		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';
		$mode = get_field_string( $_POST, 'mode' );
		if( $mode == 'new' ){
			$_SESSION['p'] = array(
				'id' => 0,
				'title' => '',
				'image' => '',
				'photo' => ''
			);
			$this->smarty_assign['edit_title'] = '写真登録';
			$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallery_photo.html';
			return;
		} else if( $mode == 'edit' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$_SESSION['p'] = $this->GetOneGalleryPhotoData( $id );
				$this->smarty_assign['edit_title'] = '写真登録';
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallery_photo.html';
				return;
			}
		} else if( $mode == 'confirm' ){
			if( isset( $_POST['exec'] ) ){
				$_SESSION['p']['title'] = get_field_string( $_POST, 'title' );
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'confirm_gallery_photo.html';
				return;
			} else if( $this->CheckUploadImage() ){
				$_SESSION['p']['title'] = get_field_string( $_POST, 'title' );
				$this->smarty_assign['edit_title'] = '写真登録';
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallery_photo.html';
				return;
			}
		} else if( $mode == 'exec' ){
			if( isset( $_POST['exec'] ) ){
				if( $_SESSION['p']['id'] == 0 ){
					$this->InsertData();
				} else {
					$this->UpdateData();
				}
			} else {
				$this->smarty_assign['edit_title'] = '写真登録';
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'edit_gallery_photo.html';
				return;
			}
		} else if( $mode == 'delete' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$_SESSION['p'] = $this->GetOneGalleryPhotoData( $id );
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'delete_gallery_photo.html';
				return;
			}
		} else if( $mode == 'exec_delete' ){
			if( isset( $_POST['exec'] ) ){
				$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
				$this->DeleteGalleryPhotoData( $id );
			}
		} else if( $mode == 'slideshowon' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$this->UpdateGalleryPhotoSlideShow( $id, 1 );
			}
		} else if( $mode == 'slideshowoff' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$this->UpdateGalleryPhotoSlideShow( $id, 0 );
			}
		}
		$_SESSION['p'] = array();
		$lnum = $this->GetGalleryPhotoDataListNum();
		if( $lnum == 0 ){
			$this->smarty_assign['pagenum'] = 0;
		} else {
			$this->smarty_assign['pagenum'] = ( $lnum - 1 ) / 10 + 1;
		}
		$this->smarty_assign['currpage'] = $page;
		$this->smarty_assign['list'] = $this->GetGalleryPhotoDataList( 10, $page );
		$this->smarty_assign['top_title'] = $this->GetTitle();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'gallery_photo.html';
	}

	function dispatch()
	{
		parent::dispatch();
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function CheckUploadImage()
	{
		$ret = false;
		if( isset( $_POST['upload_image'] ) ){
			if( $_FILES['image']['error'] == UPLOAD_ERR_OK ){
				$fname = sprintf( "%06d%012d", intval(microtime()*1000000), time() );
				$temp = dirname(dirname(dirname(__FILE__))).'/temp/'.$fname;
				move_uploaded_file( $_FILES['image']['tmp_name'], $temp );

				preg_match( "/(.*)\.(\w+)$/", $_FILES['image']['name'], $m );
				$fname = $m[1];
				if( file_exists( $this->configs['galleryimage_path'].'/'.$fname.'.jpg' ) ){
					for( $i1 = 1; $i1 < 1000; $i1++ ){
						$name = $fname . '_' . $i1;
						if( !file_exists( $this->configs['galleryimage_path'].'/'.$name.'.jpg' ) ){ break; }
					}
				} else {
					$name = $fname;
				}

				$im = imagecreatefromjpeg( $temp );
				if( !$im ){ return; }
				$width = imagesx( $im );
				$height = imagesy( $im );
				if( $width > $height ){
					if( $width < 640 ){
						$nwidth = $width;
						$nheight = $height;
					} else {
						$nwidth = 640;
						$nheight = intval( $height * 640 / $width );
					}
					$nwidth_t = 320;
					$nheight_t = intval( $height * 320 / $width );
				} else {
					if( $height < 640 ){
						$nwidth = $width;
						$nheight = $height;
					} else {
						$nheight = 640;
						$nwidth = intval( $width * 640 / $height );
					}
					$nheight_t = 320;
					$nwidth_t = intval( $width * 320 / $height );
				}
				$newim = imagecreatetruecolor( $nwidth, $nheight );
				imagecopyresampled( $newim, $im, 0, 0, 0, 0, $nwidth, $nheight, $width, $height );
				imagejpeg( $newim, $this->configs['galleryimage_path'].'/'.$name.'.jpg' );
				chmod( $this->configs['galleryimage_path'].'/'.$name.'.jpg', 0644 );
				$newim = imagecreatetruecolor( $nwidth_t, $nheight_t );
				imagecopyresampled( $newim, $im, 0, 0, 0, 0, $nwidth_t, $nheight_t, $width, $height );
				imagejpeg( $newim, $this->configs['galleryimage_path'].'/t/'.$name.'s.jpg' );
				chmod( $this->configs['galleryimage_path'].'/t/'.$name.'s.jpg', 0644 );
				$_SESSION['p']['org'] = $temp;
				$_SESSION['p']['org_w'] = $width;
				$_SESSION['p']['org_h'] = $height;
				$_SESSION['p']['image'] = $name;
				$_SESSION['p']['image_w'] = $nwidth;
				$_SESSION['p']['image_h'] = $nheight;
				$_SESSION['p']['image_w2'] = $nwidth_t;
				$_SESSION['p']['image_h2'] = $nheight_t;
			}
			$ret = true;
		}
		return $ret;
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------
	function InsertData()
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'insert into gellery_photo set'
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `image`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image'), $dbs ) . "',"
			. " `image_w`=" . get_field_string_number($_SESSION['p'],'image_w', 0) . ","
			. " `image_h`=" . get_field_string_number($_SESSION['p'],'image_h', 0) . ","
			. ' `create_date`=NOW()';
		db_query( $dbs, $sql );
		db_close( $dbs );
	}

	function UpdateData()
	{
		$id = get_field_string_number( $_SESSION['p'], 'id', 0 );
		if( $id == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'update gellery_photo set'
			. " `title`='" . mysql_real_escape_string( $_SESSION['p']['title'], $dbs ) . "',"
			. " `image`='" . mysql_real_escape_string( get_field_string($_SESSION['p'],'image'), $dbs ) . "',"
			. " `image_w`=" . get_field_string_number($_SESSION['p'],'image_w', 0) . ","
			. " `image_h`=" . get_field_string_number($_SESSION['p'],'image_h', 0)
			. " where `id`=" . $id;
		db_query( $dbs, $sql );
		db_close( $dbs );
	}
}

?>
