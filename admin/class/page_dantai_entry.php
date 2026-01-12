<?php

class form_page_dantai_entry
{
	var $__pageObj = null;

    function __construct( $pageObj ) {
        $__pageObj = $pageObj;
    }

	//---------------------------------------------------------------
	//
	//---------------------------------------------------------------

	function clear_dantai_match_info( $series )
	{
//return;
		$fp = fopen( dirname(dirname(__FILE__)).'/log/clearback_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$fp2 = fopen( dirname(dirname(__FILE__)).'/log/clear_'.$series.'.'.date('YmdHis').'.sql', 'w' );
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
		$sql = 'select `dantai_league_team`.*,`dantai_league`.`series` as `series`'
			. ' from `dantai_league` inner join `dantai_league_team`'
			. ' on `dantai_league_team`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_league_team`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`='.$lv['advanced'].',`standing`='.$lv['standing'].',`point`='.$lv['point'].',`win`='.$lv['win'].',`hon`='.$lv['hon']
				. ' where `id`='.$lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_league_team`'
				. ' set `advanced`=0,`standing`=0,`point`=0,`win`=0,`hon`=0,`update_date`=NOW()'
				. ' where `id`='.$lv['id'];
//echo $sql,";<br />\n";
			fwrite( $fp2, $sql.";\n" );
			db_query( $dbs, $sql );
		}

		$sql = 'select `dantai_match`.*,`dantai_league_match`.`league` as `league`,`dantai_league`.`series` as `series`'
			. ' from `dantai_match`'
			. ' inner join `dantai_league_match` on `dantai_league_match`.`match`=`dantai_match`.`id`'
			. ' inner join `dantai_league` on `dantai_league_match`.`league`=`dantai_league`.`id`'
			. ' where `dantai_league`.`series`='.$series.' and `dantai_league`.`year`='.$_SESSION['auth']['year'].' and `dantai_league`.`del`=0 order by `dantai_match`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_match`'
				. ' set `win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
				. ' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_match`'
			. ' set `win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
			fwrite( $fp2, $sql.";\n" );
//echo $sql,";<br />\n";
			db_query( $dbs, $sql );
		}

		foreach( $list as $lv ){
			$sql = 'select * from `one_match`'
				. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
				. ' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $lv2 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
					. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
					. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
					. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
					. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
					. ' where `id`=' . $lv2['id'];
				fwrite( $fp, $sql.";\n" );
				$sql = 'update `one_match`'
					. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
					. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
					. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
					. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\''
					. ' where `id`=' . $lv2['id'];
//echo $sql,";<br />\n";
                fwrite( $fp2, $sql.";\n" );
				db_query( $dbs, $sql );
			}
		}

		$sql = 'select * from `dantai_tournament` where `series`='.$series.' and `year`='.$_SESSION['auth']['year'];
		$dantai_tournament_list = db_query_list( $dbs, $sql );
        foreach( $dantai_tournament_list as $dantai_tournament_data ){

		$t = intval( $dantai_tournament_data['id'] );

		$sql = 'select * from `dantai_tournament_team` where `del`=0 and `tournament`='.$t.' order by `id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_tournament_team` set `team`='.$lv['team'].' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
		}
		$sql = 'update `dantai_tournament_team` set `team`=0,`update_date`=NOW() where `tournament`='.$t;
//echo $sql,";<br />\n";
		db_query( $dbs, $sql );

		$sql = 'select `dantai_match`.*,`dantai_tournament_match`.`tournament` as `tournament`'
			. ' from `dantai_match`'
			. ' inner join `dantai_tournament_match` on `dantai_tournament_match`.`match`=`dantai_match`.`id`'
			. ' where `dantai_tournament_match`.`tournament`='.$t.' order by `dantai_match`.`id` asc';
		$list = db_query_list( $dbs, $sql );
		foreach( $list as $lv ){
			$sql = 'update `dantai_match`'
				. ' set `team1`='.$lv['team1'].',`team2`='.$lv['team2'].',`win1`='.$lv['win1'].',`win2`='.$lv['win2'].',`hon1`='.$lv['hon1'].',`hon2`='.$lv['hon2'].',`exist_match6`='.$lv['exist_match6'].',`winner`='.$lv['winner'].',`fusen`='.$lv['fusen']
				. ' where `id`=' . $lv['id'];
			fwrite( $fp, $sql.";\n" );
			$sql = 'update `dantai_match`'
			. ' set `team1`=0,`team2`=0,`win1`=0,`win2`=0,`hon1`=0,`hon2`=0,`exist_match6`=0,`winner`=0,`fusen`=0,`update_date`=NOW() where `id`=' . $lv['id'];
//echo $sql,";<br />\n";
			fwrite( $fp2, $sql.";\n" );
			db_query( $dbs, $sql );
		}

		foreach( $list as $lv ){
			$sql = 'select * from `one_match`'
				. ' where `id` in ('.$lv['match1'].','.$lv['match2'].','.$lv['match3'].','.$lv['match4'].','.$lv['match5'].','.$lv['match6'].')'
				. ' order by `id` asc';
			$list2 = db_query_list( $dbs, $sql );
			foreach( $list2 as $lv2 ){
				$sql = 'update `one_match`'
					. ' set `faul1_1`='.$lv2['faul1_1'].',`faul1_2`='.$lv2['faul1_2'].',`waza1_1`='.$lv2['waza1_1'].',`waza1_2`='.$lv2['waza1_2'].',`waza1_3`='.$lv2['waza1_3'].','
					. ' `faul2_1`='.$lv2['faul2_1'].',`faul2_2`='.$lv2['faul2_2'].',`waza2_1`='.$lv2['waza2_1'].',`waza2_2`='.$lv2['waza2_2'].',`waza2_3`='.$lv2['waza2_3'].','
					. ' `end_match`='.$lv2['end_match'].',`hon1`='.$lv2['hon1'].',`hon2`='.$lv2['hon2'].',`winner`='.$lv2['winner'].',`match_time`=\'\',`extra`='.$lv2['extra'].','
					. '`player1`='.$lv2['player1'].',`player2`='.$lv2['player2'].','
					. '`player1_change_name`=\''.$lv2['player1_change_name'].'\',`player2_change_name`=\''.$lv2['player2_change_name'].'\''
					. ' where `id`=' . $lv2['id'];
				fwrite( $fp, $sql.";\n" );
				$sql = 'update `one_match`'
					. ' set `faul1_1`=0,`faul1_2`=0,`waza1_1`=0,`waza1_2`=0,`waza1_3`=0,'
					. ' `faul2_1`=0,`faul2_2`=0,`waza2_1`=0,`waza2_2`=0,`waza2_3`=0,'
					. ' `end_match`=0,`hon1`=0,`hon2`=0,`winner`=0,`match_time`=\'\',`extra`=0,'
					. ' `player1`=0,`player1_change_name`=\'\',`player2`=0,`player2_change_name`=\'\''
					. ' where `id`=' . $lv2['id'];
//echo $sql,";<br />\n";
                fwrite( $fp2, $sql.";\n" );
				db_query( $dbs, $sql );
			}
		}

		}

		db_close( $dbs );
		fclose( $fp );
		fclose( $fp2 );
	}

    function load_dantai_league_entry_csv( $series, $mw, $name, $serieslist )
    {
        $entry_num = $serieslist['dantai_'.$mw.'_entry_num'];
        if( $entry_num == 0 ){ return; }
		$dbs = db_connect( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
        $file = new SplFileObject($name);
        $file->setFlags( SplFileObject::READ_CSV );

        $sql = 'select `entry_info` where `series`=' . $series . ', `year`=' . $_SESSION['auth']['year'] . ' order by `id` asc';
        $entry_list = db_query_list( $dbs, $sql );
        $entry_index = 0;

        $index = 0;
        $order = 1;
        $fields = array();
        foreach( $file as $line )
        {
//print_r($line);
            if( $index == 0 ){
                if( is_null( $line[0] ) ){ break; }
                if( count( $line ) == 0 ){ break; }
                $fields = $line;
                $index++;
                continue;
            }
            if( is_null( $line[0] ) ){
                $index++;
                continue;
            }

            if( $entry_index < count( $entry_list ) ){
                $id = get_field_string_number( $entry_list[$entry_index], 'id', 0 );
                $sql = 'update `entry_info` set `disp_order`=' . $order . ' where `id`=' . $id;
                db_query( $dbs, $sql );
                $entry_index++;
            } else {
                $sql = 'insert into `entry_info` set `series`='.$series.','
                    . ' `year`='.$_SESSION['auth']['year'].','
                    . ' `disp_order`='.$order.','
			        . ' `create_date`=NOW(), `update_date`=NOW(), `del`=0';
//echo $sql,"\n";
                db_query( $dbs, $sql );
                $id = db_query_insert_id( $dbs );
            }

            $this->update_entry_field_data( $id, 'join', '1', $dbs );
            for( $findex = 0; $findex < count($fields); $findex++ ){
                if( $fields[$findex] !== '' ){
                    $this->update_entry_field_data( $id, $fields[$findex], $line[$findex], $dbs );
                }
            }
            $order++;
        }
    }


}

