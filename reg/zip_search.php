<?php
    require_once dirname(dirname(__FILE__)).'/admin/common/common.php';
    require_once dirname(dirname(__FILE__)).'/admin/common/config.php';

    $ret = array();
    $zip1 = get_field_string_number( $_POST, 'zip1', 0 );
    $zip2 = get_field_string_number( $_POST, 'zip2', 0 );
    if( $zip1 != 0 && $zip2 != 0 ){
       $ret = search_zipcode( $zip1, $zip2 );
    }
    header("Access-Control-Allow-Origin: *");
    echo json_encode( $ret );

