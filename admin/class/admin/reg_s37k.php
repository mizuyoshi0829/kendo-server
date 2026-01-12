<?php
	//--------------------------------------------------------------

	function __get_entry_data_list2_107_108( $series, $series_mw )
	{
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select * from `entry_info`'
			.' where `series`='.$series.' and `year`='.$_SESSION['auth']['year']
			.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		$ret = array();
		foreach( $list as $lv ){
			$id = intval( $lv['id'] );
			if( $id == 0 ){ continue; }
			$sql = 'select * from `entry_field` where `info`=' . $id;
			$field_list = db_query_list( $dbs, $sql );
			$fields = array();
			foreach( $field_list as $fv ){
				$fields[$fv['field']] = $fv['data'];
			}
			$lv['join'] = 1;
			$lv['school_name'] = get_field_string( $fields, 'player_sei' )
				. ' ' . get_field_string( $fields, 'player_mei' ) 
				. '(' . get_field_string( $fields, 'school_name' ) . ')';
			$ret[] = $lv;
		}
		db_close( $dbs );

		return array_merge( $ret );
	}

	function get_entry_data_list2_107()
	{
		return __get_entry_data_list2_107_108( 107, 'm' );
	}

	function get_entry_data_list2_108()
	{
		return __get_entry_data_list2_107_108( 108, 'w' );
	}

	//--------------------------------------------------------------

	function output_tournament_107_for_HTML( $path, $tournament_data, $entry_list )
	{
		//__output_tournament_76_77_for_HTML( $path, $tournament_data, $entry_list, 'm' );
        $objPage = new form_page();
        $objTournament = new form_page_kojin_tournament( $objPage );
        $cssparam = [
			'table_name_rowspan' => 3,
			'table_name_name_width' => 100,
			'table_name_name_font_size' => 11,
			'table_name_name_font_size2' => 9,
			'table_name_pref_width' => 108,
			'table_height' => 11,
			'table_font_size' => 11,
			'table_place_font_size' => 6,
			'table_cell_width' => 30,
			'return_path' => 'index_e.html',
			'break_html' => [false,true,true,true],
			'break_html_name' => [
				'kt_e3','kt_e3','kt_e1','kt_e2'
			],
        ];
        $objTournament->output_kojin_tournament_for_HTML( $path, $tournament_data, $entry_list, 'm', $cssparam );
	}

	//--------------------------------------------------------------
