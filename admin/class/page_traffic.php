<?php

	function init_entry_post_data_from_def( $data, $def, $add1, $add2 )
	{
		foreach( $def as $dv ){
			if( $dv['data'] == 'text' ){
				$data[$add1.$dv['field'].$add2] = '';
			} else if( $dv['data'] == 'integer' ){
				$data[$add1.$dv['field'].$add2] = 0;
			}
		}
		return $data;
	}

	function get_entry_post_data_from_def( $def, $add1, $add2 )
	{
		foreach( $def as $dv ){
			$field = $add1 . $dv['field'] . $add2;
			if( $dv['kind'] == 'address' ){
				$_SESSION['p'][$field.'_zip1'] = get_field_string( $_POST, $field.'_zip1' );
				$_SESSION['p'][$field.'_zip2'] = get_field_string( $_POST, $field.'_zip2' );
				$_SESSION['p'][$field.'_pref'] = get_field_string( $_POST, $field.'_pref' );
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
			} else if( $dv['kind'] == 'name' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
			} else if( $dv['kind'] == 'name2' ){
				$_SESSION['p'][$field.'_sei'] = get_field_string( $_POST, $field.'_sei' );
				$_SESSION['p'][$field.'_mei'] = get_field_string( $_POST, $field.'_mei' );
				$_SESSION['p'][$field.'_add'] = get_field_string( $_POST, $field.'_add' );
			} else if( $dv['kind'] == 'tel_fax' ){
				$_SESSION['p'][$field.'_tel'] = get_field_string( $_POST, $field.'_tel' );
				$_SESSION['p'][$field.'_fax'] = get_field_string( $_POST, $field.'_fax' );
			} else if( $dv['kind'] == 'mobile_tel' ){
				$_SESSION['p'][$field.'_mobile'] = get_field_string( $_POST, $field.'_mobile' );
				$_SESSION['p'][$field.'_tel'] = get_field_string( $_POST, $field.'_tel' );
			} else if( $dv['kind'] == 'school_org' ){
				$_SESSION['p'][$field.'_school_name'] = get_field_string( $_POST, $field.'_school_name' );
				$_SESSION['p'][$field] = get_field_string( $_POST, $field );
			} else {
				if( $dv['data'] == 'text' ){
					$_SESSION['p'][$field] = get_field_string( $_POST, $field );
				} else if( $dv['data'] == 'integer' ){
					$_SESSION['p'][$field] = get_field_string_number( $_POST, $field, 0 );
				}
			}
		}
	}

	function get_entry_db_data_from_def( $data, $list, $def, $add1, $add2 )
	{
		foreach( $def as $dv ){
			if( $dv['kind'] == 'address' ){
				$_SESSION['p'][$lv['field'].'_pref_name'] = $this->get_pref_name( $pref_array, $_SESSION['p'][$lv['field'].'_pref'] );
			} else if( $dv['kind'] == 'address' ){
			} else {
				if( $dv['def'] == 'text' ){
					$data[$add1.$dv['field'].$add2] = get_field_string( $list, $dv['field'] );
				} else if( $dv['def'] == 'integer' ){
					$data[$add1.$dv['field'].$add2] = get_field_string_number( $list, $dv['field'], 0 );
				}
			}
		}
		return $data;
	}

?>
