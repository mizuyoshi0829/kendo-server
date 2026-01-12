<?php
    require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'page.php';

class form_page_admin_referee extends form_page
{
    function init( $series, $edit )
    {
		$page = get_field_string_number( $_GET, 'p', 1 );
		$series = get_field_string_number( $_GET, 's', 1 );
		$series_mw = get_field_string( $_GET, 'mw', 'm' );
		parent::init( $series, $edit );
		if( $_SESSION['auth']['login'] != 1 ){ exit; }
		if( !isset($_SESSION['auth']['series_info_id']) || $_SESSION['auth']['series_info_id'] == 0 ){ exit; }

        $inc = dirname(__FILE__) . '/reg_s' . $_SESSION['auth']['series_info_id'] . 'd.php';
        if( file_exists( $inc ) ){
            require_once $inc;
        }
        $series_info = $this->get_series_info( $_SESSION['auth']['series_info_id'] );
		$this->smarty_assign['display_navi'] = 1;
		$this->header = 'admin' . DIRECTORY_SEPARATOR . 'header.html';
		$this->footer = 'admin' . DIRECTORY_SEPARATOR . 'footer.html';

		$this->smarty_assign['root_url'] = '../';
		$this->smarty_assign['post_action'] = 'referee.php';
		$this->smarty_assign['series'] = $series;
		$this->smarty_assign['series_mw'] = $series_mw;
		$this->smarty_assign['seriesinfo'] = $this->get_series_list( $series );
        $this->smarty_assign['list'] = $this->getRefereeList( $series );

		$mode = get_field_string( $_POST, 'mode' );
        if( $mode == 'new' ){
            $_SESSION['p'] = $this->initRefereeData( $series );
            $this->template = 'admin' . DIRECTORY_SEPARATOR . 'referee_edit.html';
            return;
		} else if( $mode == 'clear' ){
/*
			//$this->clear_match_info( $series );
			$tournament_data = $this->get_dantai_tournament_data( $series, $series_mw );
			$entry_list = $this->get_entry_data_list3( $series, $series_mw );
			$func = 'output_tournament_' . $series . '_for_HTML';
			$html = $func( $series_info, $tournament_data, $entry_list );
			$func = 'output_tournament_match_for_HTML2_'.$series;
			$func( $series_info, $tournament_data, $entry_list );
*/
		} else if( $mode == 'edit' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
				$_SESSION['p'] = $this->getRefereeData( $id );
				$this->smarty_assign['edit_title'] = '審判編集';
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'referee_edit.html';
				return;
			}
		} else if( $mode == 'confirm' ){
			if( isset( $_POST['exec'] ) ){
                $this->getRefereePostData();
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'referee_confirm.html';
                return;
            }
		} else if( $mode == 'exec' ){
			if( isset( $_POST['exec'] ) ){
                $this->updateRefereeData( $_SESSION['p'] );
            } else {
				$this->template = 'admin' . DIRECTORY_SEPARATOR . 'referee_edit.html';
				return;
            }
		} else if( $mode == 'loadcsv' ){
    		$this->loadRefereeCSV( $series, $series_mw, $_FILES["csv_file"]["tmp_name"] );
		} else if( $mode == 'delete' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
			    $this->deleteRefereeData( $id, 1 );
			}
		} else if( $mode == 'undelete' ){
			$id = get_field_string_number( $_POST, 'id', 0 );
			if( $id > 0 ){
			    $this->deleteRefereeData( $id, 0 );
			}
		}

        $this->smarty_assign['list'] = $this->getRefereeList( $series );
		$_SESSION['p'] = array();
		$this->template = 'admin' . DIRECTORY_SEPARATOR . 'referee.html';
    }

    function dispatch()
    {
        parent::dispatch();
    }

    //---------------------------------------------------------------
    //
    //---------------------------------------------------------------

    function getRefereeList( $series )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$referee_sql = 'select * from `referee` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'].' order by `id` asc';
		$referee_list = db_query_list( $dbs, $referee_sql );
        return $referee_list;
    }

    function initRefereeData( $series )
    {
        $data = array(
            'series' => $series,
            'year' => $_SESSION['auth']['year'],
            'sei' => '',
            'mei' => ''
        );
        return $data;
    }

    function getRefereeData( $id )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$referee_sql = 'select * from `referee` where `id`='.$id.' and `del`=0';
		$referee_list = db_query_list( $dbs, $referee_sql );
        if( count( $referee_list ) > 0 ){
            return $referee_list[0];
        }
        return array();
    }

    function getRefereePostData()
    {
        $_SESSION['p']['sei'] = get_field_string( $_POST, 'sei' );
        $_SESSION['p']['mei'] = get_field_string( $_POST, 'mei' );
    }

    function updateRefereeData( $data )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $id = get_field_string_number( $data, 'id', 0 );
        if( $id == 0 ){
            $sql = 'insert into `referee` set'
                . ' `series`=' . get_field_string_number( $data, 'series', 0 )
                . ',`year`=' . get_field_string_number( $data, 'year', 0 )
                . ',`sei`=\'' . get_field_string( $data, 'sei' ) . '\''
                . ',`mei`=\'' . get_field_string( $data, 'mei' ) . '\''
                . ',`del`=0,`created`=NOW(),`modified`=NOW()';
        } else {
            $sql = 'update `referee` set'
                . ' `sei`=\'' . get_field_string( $data, 'sei' ) . '\''
                . ',`mei`=\'' . get_field_string( $data, 'mei' ) . '\''
                . ' where `id`='.$id;
        }
        db_query( $dbs, $sql );
    }

    function deleteRefereeData( $id, $delete )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $sql = 'update `referee` set `del`=' . intval( $delete ) . ' where `id`=' . $id;
        db_query( $dbs, $sql );
    }

    function loadRefereeCSV( $series, $series_mw, $filename )
    {
        if( $filename == '' ){ return; }
        $serieslist = $this->get_series_list( $series );
        if( $serieslist === false ){ return; }
        $file = new SplFileObject($filename);
        $file->setFlags( SplFileObject::READ_CSV );
        $filedata = array();
        $file_index = 0;
        foreach( $file as $line ){
            $filedata[$file_index] = array();
            foreach( $line as $lv ){
                $filedata[$file_index][] = $lv;
            }
            $file_index++;
        }
        if( count( $filedata ) < 1 ){ return; }
        $entry_field = [ 'sei', 'mei' ];
        if( !is_null( $serieslist['referee_entry_field'] ) ){
            $entry_field = explode( ',', $serieslist['referee_entry_field'] );
        }

		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        foreach( $filedata as $fd ){
            if( count( $fd ) < count( $entry_field ) ){ continue; }
            $entry = array();
            for( $i1 = 0; $i1 < count($entry_field); $i1++ ){
                $entry[] = '`' . $entry_field[$i1] . '`=\'' . $fd[$i1] . '\'';
            }
            $sql = 'insert into `referee` set'
                . ' `series`=' . $series
                . ',`year`=' . $_SESSION['auth']['year']
                . ',' . implode( ',', $entry )
                . ',`del`=0,`created`=NOW(),`modified`=NOW()';
            db_query( $dbs, $sql );
        }
        db_close( $dbs );
    }

}
