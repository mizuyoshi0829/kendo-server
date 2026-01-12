<?php
	$dbs = new mysqli( 'mysql487.db.sakura.ne.jp', 'kendo-n', '95x9are5ze', 'kendo-n_kendo-n' );
	if( $dbs === false ){
		//接続失敗
		echo 'データベース接続に失敗しました。(1)';
		exit;
	}
	//データベース選択
	$dbs->set_charset( "utf8" );

	$sqlins1 = 'INSERT INTO `kojin_tournament_player` (`tournament`, `tournament_player_index`, `team`, `player`, `create_date`, `update_date`, `del`) VALUES ';
	$sqlins2 = 'INSERT INTO `kojin_tournament_player` (`tournament`, `tournament_player_index`, `team`, `player`, `create_date`, `update_date`, `del`) VALUES ';
	for( $i1 = 1; $i1 <= 96; $i1++ ){
		if( $i1 > 1 ){ $sqlins1 .= ','; }
		$sqlins1 .= ( '(8, ' . $i1 . ', 0, 0, NOW(), NOW(), 0)' );
		if( $i1 > 1 ){ $sqlins2 .= ','; }
		$sqlins2 .= ( '(9, ' . $i1 . ', 0, 0, NOW(), NOW(), 0)' );
	}
echo $sqlins1,"<br />";
echo $sqlins2;
	$dbs->query( $sqlins1 );
	$dbs->query( $sqlins2 );
/*
	$sql = 'select * from `entry_info` where `series`=9 and `year`=2016';
	$result = $dbs->query( $sql );
	$sqlins = 'INSERT INTO `kojin_tournament_player` (`tournament`, `tournament_player_index`, `team`, `player`, `create_date`, `update_date`, `del`) VALUES ';
	$index = 1;
	while( $row = $result->fetch_assoc() ){
//print_r($row);
		$id = intval( $row['id'] );
		if( $index > 1 ){ $sqlins .= ','; }
		$sqlins .= ( '(8, ' . $index . ', ' . $id . ', 1, NOW(), NOW(), 0),' );
		$index++;
		$sqlins .= ( '(8, ' . $index . ', ' . $id . ', 2, NOW(), NOW(), 0)' );
		$index++;
	}
	echo $sqlins,"<br />\n";
	$dbs->query( $sqlins );

	$sql = 'select * from `entry_info` where `series`=10 and `year`=2016';
	$result = $dbs->query( $sql );
	$sqlins = 'INSERT INTO `kojin_tournament_player` (`tournament`, `tournament_player_index`, `team`, `player`, `create_date`, `update_date`, `del`) VALUES ';
	$index = 1;
	while( $row = $result->fetch_assoc() ){
		$id = intval( $row['id'] );
		if( $index > 1 ){ $sqlins .= ','; }
		$sqlins .= ( '(9, ' . $index . ', ' . $id . ', 1, NOW(), NOW(), 0),' );
		$index++;
		$sqlins .= ( '(9, ' . $index . ', ' . $id . ', 2, NOW(), NOW(), 0)' );
		$index++;
	}
	echo $sqlins,"<br />\n";
	$dbs->query( $sqlins );
*/
?>
