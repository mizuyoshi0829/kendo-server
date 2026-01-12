<?php

class form_page_kojin_entry
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function clear_kojin_match_info( $series )
	{
		$fp = fopen( dirname(dirname(__FILE__)).'/log/clearback_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$fp2 = fopen( dirname(dirname(__FILE__)).'/log/clear_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );

		$sql = 'select * from `kojin_tournament` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$list = db_query_list( $dbs, $sql );
		$match_num = intval( $list[0]['match_num'] );
		$match_level = intval( $list[0]['match_level'] );
		$macth1_level = 1;
		$i1 = 1;
		for(;;){
			if( $i1 == $match_level ){ break; }
			$macth1_level *= 2;
			$i1++;
		}

		$t = intval( $list[0]['id'] );

		$sql = 'select `kojin_match`.*,`kojin_tournament_match`.`tournament` as `tournament`,'
            . ' `kojin_tournament_match`.`tournament_match_index` as `tournament_match_index`'
			. ' from `kojin_match`'
			. ' inner join `kojin_tournament_match` on `kojin_tournament_match`.`match`=`kojin_match`.`id`'
			. ' where `kojin_tournament_match`.`tournament`='.$t
            . ' order by `kojin_tournament_match`.`tournament_match_index` asc';
		$list = db_query_list( $dbs, $sql );
//echo $sql;
//print_r($list);
		foreach( $list as $lv ){
			$tournament_match_index = intval( $lv['tournament_match_index'] );
			$sql = 'select * from `one_match`'
				. ' where `id`='.$lv['match'].' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
            if( count( $list2 ) == 0 ){ continue; }
            $lv2 = $list2[0];
			$sql = 'update `one_match`'
    			. ' set `faul1_1`='.$lv2['faul1_1'].','
                . '`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
				. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
				. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
				. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
				. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
				. ' where `id`=' . $lv2['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `one_match`'
				. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
				. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
				. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0';
            if( $tournament_match_index < $macth1_level || $tournament_match_index > $match_num ){
				$sql .= ', `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\'';
            }
			$sql .= ' where `id`=' . $lv2['id'];
//echo $sql,";\n";
			fwrite( $fp2, $sql.";\n" );
			db_query( $dbs, $sql );
		}
//print_r($list);
//exit;
		foreach( $list as $lv ){
			$tournament_match_index = intval( $lv['tournament_match_index'] );
            if( $tournament_match_index >= $macth1_level && $tournament_match_index <= $match_num ){
                if( $lv['place'] == 'no_match' ){
					$t2 = intval( $tournament_match_index / 2 );
					$t2ofs = ( $tournament_match_index % 2 ) + 1;
                    $sql = 'select * from `one_match` where `id`=' . $lv['match'];
                    $list2 = db_query_list( $dbs, $sql );
                    if( count( $list2 ) == 0 ){ continue; }
                    foreach( $list as $lv2 ){
                        if( $lv2['tournament_match_index'] == $t2 ){
                            $sql = 'select * from `one_match` where `id`=' . $lv2['match'];
                            $list3 = db_query_list( $dbs, $sql );
                            $sql = 'update `one_match`'
                                . ' set `faul1_1`='.$list3[0]['faul1_1'] . ','
                                    . '`faul1_2`='.$list3[0]['faul1_2'] . ','
                                    . '`waza1_1`='.$list3[0]['waza1_1'] . ','
                                    . '`waza1_2`='.$list3[0]['waza1_2'] . ','
                                    . '`waza1_3`='.$list3[0]['waza1_3'] . ','
                                    . '`faul2_1`='.$list3[0]['faul2_1'] . ','
                                    . '`faul2_2`='.$list3[0]['faul2_2'] . ','
                                    . '`waza2_1`='.$list3[0]['waza2_1'] . ','
                                    . '`waza2_2`='.$list3[0]['waza2_2'] . ','
                                    . '`waza2_3`='.$list3[0]['waza2_3'] . ','
                                    . '`end_match`='.$list3[0]['end_match'] . ','
                                    . '`hon1`='.$list3[0]['hon1'] . ','
                                    . '`hon2`='.$list3[0]['hon2'] . ','
                                    . '`winner`='.$list3[0]['winner'] . ','
                                    . '`match_time`=\'\'' . ','
                                    . '`extra`='.$list3[0]['extra'] . ','
                                    . '`player1`='.$list3[0]['player1'] . ','
                                    . '`player2`='.$list3[0]['player2'] . ','
                                    . '`player1_change_name`=\''.$list3[0]['player1_change_name'].'\'' . ','
                                    . '`player2_change_name`=\''.$list3[0]['player2_change_name'].'\''
                                    . ' where `id`=' . $lv2['match'];
                            //fwrite( $fp, $sql.";\n" );
							$sql = 'update `one_match` set ';
							if( $list2[0]['player1'] != 0 ){
								$sql .= '`player'.$t2ofs.'`='.$list2[0]['player1'];
							} else {
								$sql .= '`player'.$t2ofs.'`='.$list2[0]['player2'];
							}
							$sql .= ', `update_date`=NOW()';
							$sql .= ' where `id`=' . $lv2['match'];
//echo $sql,"<br />";
                            fwrite( $fp2, $sql.";\n" );
							db_query( $dbs, $sql );
                        }
                    }
				}
			}
		}

		db_close( $dbs );
		fclose( $fp );
		fclose( $fp2 );
	}

    function load_kojin_tournament_entry_csv( $series, $mw, $name, $serieslist )
    {
        $entry_num = $serieslist['kojin_'.$mw.'_entry_num'];
        if( $entry_num == 0 ){ return; }
        $fields = explode( ',', $serieslist['kojin_'.$mw.'_entry_field'] );
        if( count( $fields ) == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );

        $sql = 'update `entry_info` set `del`=1 where `series`=' . $series . ' and `year`=' . $_SESSION['auth']['year'];
echo '<!-- ',$sql," --><br />\n";
        //db_query( $dbs, $sql );
        $sql = 'select `entry_info` where `series`=' . $series . ' and `year`=' . $_SESSION['auth']['year'] . ' order by `id` asc';
        $entry_list = db_query_list( $dbs, $sql );
        $entry_index = 0;

        $index = 0;
        $order = 1;
        $fields = array();
        foreach( $file as $line )
        {
//print_r($line);
            if( is_null( $line[0] ) ){
                continue;
            }

            if( $entry_index < count( $entry_list ) ){
                $id = get_field_string_number( $entry_list[$entry_index], 'id', 0 );
                $sql = 'update `entry_info` set `disp_order`=' . $order . ', `del`=0 where `id`=' . $id;
echo '<!-- ',$sql," --><br />\n";
                //db_query( $dbs, $sql );
                $entry_index++;
            } else {
                $sql = 'insert into `entry_info` set `series`='.$series.','
                    . ' `year`='.$_SESSION['auth']['year'].','
                    . ' `disp_order`='.$order.','
			        . ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
echo '<!-- ',$sql," --><br />\n";
                //db_query( $dbs, $sql );
                $id = db_query_insert_id( $dbs );
            }

            $pageObj->update_entry_field_data( $id, 'join', '1', $dbs );
            for( $findex = 0; $findex < count($fields); $findex++ ){
                if( $fields[$findex] !== '' ){
                    $this->update_entry_field_data( $id, $fields[$findex], $line[$findex], $dbs );
                }
            }
            if( $order >= $entry_num ){ break; }
            $order++;
        }
    }

}

