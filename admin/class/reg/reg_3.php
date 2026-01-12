<?php

	function init_entry_post_data_from_def_3_traffic( &$data, $def, $add1, $add2 )
	{
		$data['traffic'] = '';
		$data['traffic_mycar'] = '';
		$data['traffic_share'] = '';
		$data['traffic_other'] = '';
	}

	function get_entry_post_data_from_def_3_traffic( $def, $add1, $add2 )
	{
		$_SESSION['p']['traffic'] = get_field_string( $_POST, 'traffic' );
		$_SESSION['p']['traffic_mycar'] = get_field_string( $_POST, 'traffic_mycar' );
		$_SESSION['p']['traffic_share'] = get_field_string( $_POST, 'traffic_share' );
		$_SESSION['p']['traffic_other'] = get_field_string( $_POST, 'traffic_other' );
	}

	function get_entry_db_data_from_def_3_traffic( $data, $list, $def, $add1, $add2 )
	{
		$data['traffic'] = get_field_string( $list, 'traffic' );
		$data['traffic_mycar'] = get_field_string( $list, 'traffic_mycar' );
		$data['traffic_share'] = get_field_string( $list, 'traffic_share' );
		$data['traffic_other'] = get_field_string( $list, 'traffic_other' );
		return $data;
	}

	function update_entry_data_3_traffic( $def, $dbs )
	{
		$data = array(
			'traffic' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic' ) ),
			'traffic_mycar' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_mycar' ) ),
			'traffic_share' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_share' ) ),
			'traffic_other' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'traffic_other' ) )
		);
		return $data;
	}

	function init_entry_post_data_from_def_3_shumoku_dantai( &$data, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = '';
		$data['shumoku_dantai_rensei_am'] = '';
		$data['shumoku_dantai_rensei_pm'] = '';
		$data['shumoku_dantai_opening'] = '';
		$data['shumoku_dantai_konshin'] = '';
		$data['shumoku_dantai_text'] = '';
	}

	function get_entry_post_data_from_def_3_shumoku_dantai( $def, $add1, $add2 )
	{
		$_SESSION['p']['shumoku_dantai_taikai'] = get_field_string( $_POST, 'shumoku_dantai_taikai' );
		$_SESSION['p']['shumoku_dantai_rensei_am'] = get_field_string( $_POST, 'shumoku_dantai_rensei_am' );
		$_SESSION['p']['shumoku_dantai_rensei_pm'] = get_field_string( $_POST, 'shumoku_dantai_rensei_pm' );
		$_SESSION['p']['shumoku_dantai_opening'] = get_field_string( $_POST, 'shumoku_dantai_opening' );
		$_SESSION['p']['shumoku_dantai_konshin'] = get_field_string( $_POST, 'shumoku_dantai_konshin' );
		$_SESSION['p']['shumoku_dantai_text'] = get_field_string( $_POST, 'shumoku_dantai_text' );
	}

	function get_entry_db_data_from_def_3_shumoku_dantai( $data, $list, $def, $add1, $add2 )
	{
		$data['shumoku_dantai_taikai'] = get_field_string( $list, 'shumoku_dantai_taikai' );
		$data['shumoku_dantai_rensei_am'] = get_field_string( $list, 'shumoku_dantai_rensei_am' );
		$data['shumoku_dantai_rensei_pm'] = get_field_string( $list, 'shumoku_dantai_rensei_pm' );
		$data['shumoku_dantai_opening'] = get_field_string( $list, 'shumoku_dantai_opening' );
		$data['shumoku_dantai_konshin'] = get_field_string( $list, 'shumoku_dantai_konshin' );
		$data['shumoku_dantai_text'] = get_field_string( $list, 'shumoku_dantai_text' );
		return $data;
	}

	function update_entry_data_3_shumoku_dantai( $def, $dbs )
	{
		$data = array(
			'shumoku_dantai_taikai' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_taikai', 0 ),
			'shumoku_dantai_rensei_am' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_am', 0 ),
			'shumoku_dantai_rensei_pm' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_rensei_pm', 0 ),
			'shumoku_dantai_opening' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_opening', 0 ),
			'shumoku_dantai_konshin' => get_field_string_number( $_SESSION['p'], 'shumoku_dantai_konshin', 0 ),
			'shumoku_dantai_text' => $dbs->real_escape_string( get_field_string( $_SESSION['p'], 'shumoku_dantai_text' ) )
		);
		return $data;
	}

?>
