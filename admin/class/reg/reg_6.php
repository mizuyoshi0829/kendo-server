<?php

	function init_entry_post_data_from_def_6_traffic( &$data, $def, $add1, $add2 )
	{
		$data['traffic'] = '';
		$data['traffic_mycar'] = '';
		$data['traffic_share'] = '';
		$data['traffic_other'] = '';
	}

	function get_entry_post_data_from_def_6_traffic( $def, $add1, $add2 )
	{
		$_SESSION['p']['traffic'] = get_field_string( $_POST, 'traffic' );
		$_SESSION['p']['traffic_mycar'] = get_field_string( $_POST, 'traffic_mycar' );
		$_SESSION['p']['traffic_share'] = get_field_string( $_POST, 'traffic_share' );
		$_SESSION['p']['traffic_other'] = get_field_string( $_POST, 'traffic_other' );
	}

	function get_entry_db_data_from_def_6_traffic( $data, $list, $def, $add1, $add2 )
	{
		$data['traffic'] = get_field_string( $list, 'traffic' );
		$data['traffic_mycar'] = get_field_string( $list, 'traffic_mycar' );
		$data['traffic_share'] = get_field_string( $list, 'traffic_share' );
		$data['traffic_other'] = get_field_string( $list, 'traffic_other' );
		return $data;
	}

	function update_entry_data_6_traffic( $def, $dbs )
	{
		$data = array(
			'traffic' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic' ) ),
			'traffic_mycar' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_mycar' ) ),
			'traffic_share' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_share' ) ),
			'traffic_other' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_other' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_6_shumoku_dantai_m( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = '';
		$data['shumoku_dantai_m_rensei_1am'] = '';
		$data['shumoku_dantai_m_rensei_1pm'] = '';
		$data['shumoku_dantai_m_rensei_3am'] = '';
		$data['shumoku_dantai_m_opening'] = '';
		$data['shumoku_dantai_m_konshin'] = '';
		$data['shumoku_dantai_m_text'] = '';
	}

	function get_entry_post_data_from_def_6_shumoku_dantai_m( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_m_taikai'] = get_field_string( $_POST, 'shumoku_dantai_m_taikai' );
		$_SESSION['p']['shumoku_dantai_m_rensei_1am'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_1am' );
		$_SESSION['p']['shumoku_dantai_m_rensei_1pm'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_1pm' );
		$_SESSION['p']['shumoku_dantai_m_rensei_3am'] = get_field_string( $_POST, 'shumoku_dantai_m_rensei_3am' );
		$_SESSION['p']['shumoku_dantai_m_opening'] = get_field_string( $_POST, 'shumoku_dantai_m_opening' );
		$_SESSION['p']['shumoku_dantai_m_konshin'] = get_field_string( $_POST, 'shumoku_dantai_m_konshin' );
		$_SESSION['p']['shumoku_dantai_m_text'] = get_field_string( $_POST, 'shumoku_dantai_m_text' );
	}

	function get_entry_db_data_from_def_6_shumoku_dantai_m( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_m_taikai'] = get_field_string( $list, 'shumoku_dantai_m_taikai' );
		$data['shumoku_dantai_m_rensei_1am'] = get_field_string( $list, 'shumoku_dantai_m_rensei_1am' );
		$data['shumoku_dantai_m_rensei_1pm'] = get_field_string( $list, 'shumoku_dantai_m_rensei_1pm' );
		$data['shumoku_dantai_m_rensei_3am'] = get_field_string( $list, 'shumoku_dantai_m_rensei_3am' );
		$data['shumoku_dantai_m_opening'] = get_field_string( $list, 'shumoku_dantai_m_opening' );
		$data['shumoku_dantai_m_konshin'] = get_field_string( $list, 'shumoku_dantai_m_konshin' );
		$data['shumoku_dantai_m_text'] = get_field_string( $list, 'shumoku_dantai_m_text' );
		return $data;
	}

	function update_entry_data_6_shumoku_dantai_m( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_m_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_taikai', 0 ),
			'shumoku_dantai_m_rensei_1am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_1am', 0 ),
			'shumoku_dantai_m_rensei_1pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_1pm', 0 ),
			'shumoku_dantai_m_rensei_3am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_rensei_3am', 0 ),
			'shumoku_dantai_m_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_opening', 0 ),
			'shumoku_dantai_m_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_m_konshin', 0 ),
			'shumoku_dantai_m_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_m_text' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_6_shumoku_dantai_w( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = '';
		$data['shumoku_dantai_w_rensei_1am'] = '';
		$data['shumoku_dantai_w_rensei_1pm'] = '';
		$data['shumoku_dantai_w_rensei_3am'] = '';
		$data['shumoku_dantai_w_opening'] = '';
		$data['shumoku_dantai_w_konshin'] = '';
		$data['shumoku_dantai_w_text'] = '';
	}

	function get_entry_post_data_from_def_6_shumoku_dantai_w( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_w_taikai'] = get_field_string( $_POST, 'shumoku_dantai_w_taikai' );
		$_SESSION['p']['shumoku_dantai_w_rensei_1am'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_1am' );
		$_SESSION['p']['shumoku_dantai_w_rensei_1pm'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_1pm' );
		$_SESSION['p']['shumoku_dantai_w_rensei_3am'] = get_field_string( $_POST, 'shumoku_dantai_w_rensei_3am' );
		$_SESSION['p']['shumoku_dantai_w_opening'] = get_field_string( $_POST, 'shumoku_dantai_w_opening' );
		$_SESSION['p']['shumoku_dantai_w_konshin'] = get_field_string( $_POST, 'shumoku_dantai_w_konshin' );
		$_SESSION['p']['shumoku_dantai_w_text'] = get_field_string( $_POST, 'shumoku_dantai_w_text' );
	}

	function get_entry_db_data_from_def_6_shumoku_dantai_w( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_w_taikai'] = get_field_string( $list, 'shumoku_dantai_w_taikai' );
		$data['shumoku_dantai_w_rensei_1am'] = get_field_string( $list, 'shumoku_dantai_w_rensei_1am' );
		$data['shumoku_dantai_w_rensei_1pm'] = get_field_string( $list, 'shumoku_dantai_w_rensei_1pm' );
		$data['shumoku_dantai_w_rensei_3am'] = get_field_string( $list, 'shumoku_dantai_w_rensei_3am' );
		$data['shumoku_dantai_w_opening'] = get_field_string( $list, 'shumoku_dantai_w_opening' );
		$data['shumoku_dantai_w_konshin'] = get_field_string( $list, 'shumoku_dantai_w_konshin' );
		$data['shumoku_dantai_w_text'] = get_field_string( $list, 'shumoku_dantai_w_text' );
		return $data;
	}

	function update_entry_data_6_shumoku_dantai_w( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_w_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_taikai', 0 ),
			'shumoku_dantai_w_rensei_1am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_1am', 0 ),
			'shumoku_dantai_w_rensei_1pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_1pm', 0 ),
			'shumoku_dantai_w_rensei_3am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_rensei_3am', 0 ),
			'shumoku_dantai_w_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_opening', 0 ),
			'shumoku_dantai_w_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_w_konshin', 0 ),
			'shumoku_dantai_w_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_w_text' ) )
		);
		return $data;
	}

?>
