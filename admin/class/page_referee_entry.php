<?php

class form_page_referee_entry
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function get_degree_array()
	{
        $degree_array = array(
			array( 'value' => 1, 'title' => '初段' ),
			array( 'value' => 2, 'title' => '2段' ),
			array( 'value' => 3, 'title' => '3段' ),
			array( 'value' => 4, 'title' => '4段' ),
			array( 'value' => 5, 'title' => '5段' ),
			array( 'value' => 6, 'title' => '6段' )
        );
        return $degree_array;
    }

	function get_degree_array_for_smarty( $tbl )
	{
        $c = new common();
		if( $tbl == null ){ $tbl = $this->get_degree_array(); }
		return $c->get_array_for_smarty( $tbl, '段位' );
	}

	function get_degree_name( $tbl, $no )
	{
        if( $no == 0 ){ return ''; }
        $c = new common();
		if( $tbl == null ){ $tbl = $this->get_degree_array(); }
		return $c->get_name_from_array( $tbl, $no );
	}

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

    function init_entry_post_data()
    {
        return array(
            'id' => 0,
            'sei' => '',
            'mei' => '',
            'pref' => 0,
            'degree' => 0,
            'org_pref' => 0,
            'org_pref2' => 0,
            'school' => '',
            'school2' => ''
        );
    }

    function get_entry_post_data()
    {
        $c = new common();
		$pref_array = $c->get_pref_array();
        $degree_array = $this->get_degree_array();
        $_SESSION['p']['sei'] = get_field_string( $_POST, 'sei' );
        $_SESSION['p']['mei'] = get_field_string( $_POST, 'mei' );
        $_SESSION['p']['pref'] = get_field_string_number( $_POST, 'pref', 0 );
        $_SESSION['p']['pref_name'] = $c->get_pref_name( $pref_array, $_SESSION['p']['pref'] );
        $_SESSION['p']['degree'] = get_field_string_number( $_POST, 'degree', 0 );
        $_SESSION['p']['degree_name'] = $this->get_degree_name( $degree_array, $_SESSION['p']['degree'] );
        $_SESSION['p']['org_pref'] = get_field_string_number( $_POST, 'org_pref', 0 );
        $_SESSION['p']['org_pref_name'] = $c->get_pref_name( $pref_array, $_SESSION['p']['org_pref'] );
        $_SESSION['p']['org_pref2'] = get_field_string_number( $_POST, 'org_pref2', 0 );
        $_SESSION['p']['org_pref2_name'] = $c->get_pref_name( $pref_array, $_SESSION['p']['org_pref2'] );
        $_SESSION['p']['school'] = get_field_string( $_POST, 'school' );
        $_SESSION['p']['school2'] = get_field_string( $_POST, 'school2' );
        return 1;
    }

    function update_entry_data()
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        if( $_SESSION['p']['id'] == 0 ){
            $sql = 'select `*` from `referee` where `del`=1';
            $list = db_query_list( $dbs, $sql );
            if( count( $list ) > 0 ){
                $sql = 'update `referee` set `del`=0,'
                    . ' `series_info_id`=' . $_SESSION['auth']['series_info_id'] . ','
                    . ' `year`=' . $_SESSION['auth']['year'] . ','
                    . ' `sei`=\'' . $dbs->real_escape_string( $_SESSION['p']['sei'] ) . '\','
                    . ' `mei`=\'' . $dbs->real_escape_string( $_SESSION['p']['mei'] ) . '\','
                    . ' `pref`=' . $_SESSION['p']['pref'] . ','
                    . ' `degree`=' . $_SESSION['p']['degree'] . ','
                    . ' `org_pref`=' . $_SESSION['p']['org_pref'] . ','
                    . ' `org_pref2`=' . $_SESSION['p']['org_pref2'] . ','
                    . ' `school`=\'' . $dbs->real_escape_string( $_SESSION['p']['school'] ) . '\','
                    . ' `school2`=\'' . $dbs->real_escape_string( $_SESSION['p']['school2'] ) . '\''
                    . ' where `id`=' . $list[0]['id'];
            } else {
                $sql = 'insert into `referee` set `del`=0,'
                    . ' `sei`=\'' . $dbs->real_escape_string( $_SESSION['p']['sei'] ) . '\','
                    . ' `mei`=\'' . $dbs->real_escape_string( $_SESSION['p']['mei'] ) . '\','
                    . ' `pref`=' . $_SESSION['p']['pref'] . ','
                    . ' `degree`=' . $_SESSION['p']['degree'] . ','
                    . ' `org_pref`=' . $_SESSION['p']['org_pref'] . ','
                    . ' `org_pref2`=' . $_SESSION['p']['org_pref2'] . ','
                    . ' `school`=\'' . $dbs->real_escape_string( $_SESSION['p']['school'] ) . '\','
                    . ' `school2`=\'' . $dbs->real_escape_string( $_SESSION['p']['school2'] ) . '\'';
            }
        } else {
            $sql = 'update `referee` set `del`=0,'
                . ' `sei`=\'' . $dbs->real_escape_string( $_SESSION['p']['sei'] ) . '\','
                . ' `mei`=\'' . $dbs->real_escape_string( $_SESSION['p']['mei'] ) . '\','
                . ' `pref`=' . $_SESSION['p']['pref'] . ','
                . ' `degree`=' . $_SESSION['p']['degree'] . ','
                . ' `org_pref`=' . $_SESSION['p']['org_pref'] . ','
                . ' `org_pref2`=' . $_SESSION['p']['org_pref2'] . ','
                . ' `school`=\'' . $dbs->real_escape_string( $_SESSION['p']['school'] ) . '\','
                . ' `school2`=\'' . $dbs->real_escape_string( $_SESSION['p']['school2'] ) . '\''
                . ' where `id`=' . $_SESSION['p']['id'];
        }
//echo $sql,"<br />\n";
        db_query( $dbs, $sql );
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

    function get_entry_one_data( $id )
    {
        if( $id == 0 ){ return array(); }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `r`.`*`, `p1`.`name` as `pref_name`,'
            . ' `p2`.`name` as `org_pref_name`, `p3`.`name` as `org_pref2_name`'
            . ' from `referee` as `r`'
            . ' left join `prefs` as `p1` on `r`.`pref`=`p1`.`id`'
            . ' left join `prefs` as `p2` on `r`.`org_pref`=`p2`.`id`'
            . ' left join `prefs` as `p3` on `r`.`org_pref2`=`p3`.`id`'
			. ' where `r`.`id`='.$id;
		$list = db_query_list( $dbs, $sql );
        if( count( $list ) == 0 ){
            return array();
        }
		return $list[0];
    }

    function get_entry_data_list()
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `r`.`*`, `p1`.`name` as `pref_name`, `p2`.`name` as `org_pref_name`, `p3`.`name` as `org_pref2_name`'
            . ' from `referee` as `r`'
            . ' left join `prefs` as `p1` on `r`.`pref`=`p1`.`id`'
            . ' left join `prefs` as `p2` on `r`.`org_pref`=`p2`.`id`'
            . ' left join `prefs` as `p3` on `r`.`org_pref2`=`p3`.`id`'
			. ' where `series_info_id`='.$_SESSION['auth']['series_info_id'].' and `year`='.$_SESSION['auth']['year']
            . ' and `del`=0';
			//.' order by `disp_order` asc';
		$list = db_query_list( $dbs, $sql );
		return $list;
    }

    function search_entry_data( $p )
    {
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `*` from `referee`'
			. ' where `series_info_id`='.$_SESSION['auth_input']['series_info_id'].' and `year`='.$_SESSION['auth_input']['year']
            . ' and `del`=0';
			//.' order by `disp_order` asc';
        $sei1 = get_field_string( $p, 'sei1' );
        $sei2 = get_field_string( $p, 'sei2' );
        $mei1 = get_field_string( $p, 'mei1' );
        $mei2 = get_field_string( $p, 'mei2' );
        $pref1 = get_field_string_number( $p, 'pref1', 0 );
        $pref2 = get_field_string_number( $p, 'pref2', 0 );
        $degree1 = get_field_string_number( $p, 'degree1', 0 );
        $degree2 = get_field_string_number( $p, 'degree2', 0 );
        $org_pref11 = get_field_string_number( $p, 'org_pref11', 0 );
        $org_pref12 = get_field_string_number( $p, 'org_pref12', 0 );
        $org_pref21 = get_field_string_number( $p, 'org_pref21', 0 );
        $org_pref22 = get_field_string_number( $p, 'org_pref22', 0 );
        $school11 = get_field_string( $p, 'school11' );
        $school12 = get_field_string( $p, 'school12' );
        $school21 = get_field_string( $p, 'school21' );
        $school22 = get_field_string( $p, 'school22' );
        if( $sei1 != '' ){ $sql .= ' and `sei` not like \'' . $sei1 . '\''; }
        if( $sei2 != '' ){ $sql .= ' and `sei` not like \'' . $sei2 . '\''; }
        if( $mei1 != '' ){ $sql .= ' and `mei` not like \'' . $mei1 . '\''; }
        if( $mei2 != '' ){ $sql .= ' and `mei` not like \'' . $mei2 . '\''; }
        if( $pref1 != 0 ){ $sql .= ' and `pref`<>' . $pref1; }
        if( $pref2 != 0 ){ $sql .= ' and `pref`<>' . $pref2; }
        if( $degree1 != 0 ){ $sql .= ' and `degree`<>' . $degree1; }
        if( $degree2 != 0 ){ $sql .= ' and `degree`<>' . $degree2; }
        if( $org_pref11 != 0 ){ $sql .= ' and `org_pref`<>' . $org_pref11; }
        if( $org_pref12 != 0 ){ $sql .= ' and `org_pref`<>' . $org_pref12; }
        if( $org_pref21 != 0 ){ $sql .= ' and `org_pref2`<>' . $org_pref21; }
        if( $org_pref22 != 0 ){ $sql .= ' and `org_pref2`<>' . $org_pref22; }
        if( $school11 != '' ){ $sql .= ' and `school` not like \'' . $school11 . '\''; }
        if( $school12 != '' ){ $sql .= ' and `school` not like \'' . $school12 . '\''; }
        if( $school21 != '' ){ $sql .= ' and `school2` not like \'' . $school21 . '\''; }
        if( $school22 != '' ){ $sql .= ' and `school2` not like \'' . $school22 . '\''; }
//echo $sql;
		$list = db_query_list( $dbs, $sql );
		return $list;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

    function load_entry_csv( $name )
    {
        $c = new common();
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );
        $pref_array = $c->get_pref_array();
        $sql = 'update `referee` set `del`=1 where `series_info_id`=' . $_SESSION['auth']['series_info_id'] . ' and `year`=' . $_SESSION['auth']['year'];
//echo $sql,"<br />\n";
        db_query( $dbs, $sql );
        $sql = 'select * from `referee` where `series_info_id`=' . $_SESSION['auth']['series_info_id'] . ' and `year`=' . $_SESSION['auth']['year'] . ' order by `id` asc';
        $entry_list = db_query_list( $dbs, $sql );
        $entry_index = 0;
        $index = 0;
        $order = 1;
        $fields = array();
        foreach( $file as $line )
        {
//print_r($line);
            if( $index == 0 ){
                $index++;
                continue;
            }
            $index++;
            if( is_null( $line[0] ) || $line[0] == '' ){
                continue;
            }
            $pref = $c->get_title_value_from_array( $pref_array, mb_convert_encoding( $line[2], 'UTF-8', 'SJIS' ) );
            $degree = intval( $line[3] );
            $org_pref = $c->get_title_value_from_array( $pref_array, mb_convert_encoding( $line[4], 'UTF-8', 'SJIS' ) );
            $org_pref2 = $c->get_title_value_from_array( $pref_array, mb_convert_encoding( $line[5], 'UTF-8', 'SJIS' ) );
            $sei = mb_convert_encoding( $line[0], 'UTF-8', 'SJIS' );
            $mei = mb_convert_encoding( $line[1], 'UTF-8', 'SJIS' );
            $school = mb_convert_encoding( $line[6], 'UTF-8', 'SJIS' );
            $school2 = mb_convert_encoding( $line[7], 'UTF-8', 'SJIS' );

            if( $entry_index < count( $entry_list ) ){
                $id = get_field_string_number( $entry_list[$entry_index], 'id', 0 );
                $sql = 'update `referee` set `del`=0,'
                    . ' `sei`=\'' . $dbs->real_escape_string( $sei ) . '\','
                    . ' `mei`=\'' . $dbs->real_escape_string( $mei ) . '\','
                    . ' `pref`=' . $pref . ','
                    . ' `degree`=' . $degree . ','
                    . ' `org_pref`=' . $org_pref . ','
                    . ' `org_pref2`=' . $org_pref2 . ','
                    . ' `school`=\'' . $dbs->real_escape_string( $school ) . '\','
                    . ' `school2`=\'' . $dbs->real_escape_string( $school2 ) . '\''
                    . ' where `id`=' . $id;
//echo $sql,"<br />\n";
                db_query( $dbs, $sql );
                $entry_index++;
            } else {
                $sql = 'insert into `referee` set `created`=NOW(), `modified`=NOW(), `del`=0,'
                    . ' `series_info_id`=' . $_SESSION['auth']['series_info_id'] . ','
                    . ' `year`='.$_SESSION['auth']['year'].','
                    . ' `sei`=\'' . $dbs->real_escape_string( $sei ) . '\','
                    . ' `mei`=\'' . $dbs->real_escape_string( $mei ) . '\','
                    . ' `pref`=' . $pref . ','
                    . ' `degree`=' . $degree . ','
                    . ' `org_pref`=' . $org_pref . ','
                    . ' `org_pref2`=' . $org_pref2 . ','
                    . ' `school`=\'' . $dbs->real_escape_string( $school ) . '\','
                    . ' `school2`=\'' . $dbs->real_escape_string( $school2 ) . '\'';
//echo $sql,"<br />\n";
                db_query( $dbs, $sql );
                $id = db_query_insert_id( $dbs );
            }
            $order++;
        }
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

}

