<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-script-type" content="text/javascript" />
<title>kendo entry</title>
</head>
<body>
<?php 
	require_once dirname(__FILE__).'/config.php';

	$userdef = array(
		array( '保土ヶ谷', 'hodogaya', 'rZy4omZd' ),
		array( '六角橋', 'rokukakubashi', 'VqL6eLRa' ),
		array( '本宿', 'honjuku', 'YQzh7Kg7' ),
		array( '戸塚', 'totsuka', 'Y17wJa8c' ),
		array( '都田', 'tsuda', 'x8LJev1c' ),
		array( '潮田', 'ushioda', 'CqsjzAc1' ),
		array( '笹下', 'sasashita', 'XfTebqN3' ),
		array( '石鳥谷', 'ishidoriya', 'XRM2pADX' ),
		array( '花巻北', 'hanamakikita', 'cg5HRcqS' ),
		array( '平第二', 'tairani', '6oYXx5rD' ),
		array( '福島第一', 'fukushimaichi', '4ARPXcdq' ),
		array( '芝東', 'shibahigashi', 'MAI9vHT8' ),
		array( '大沼', 'oonuma', '4xo1JfKt' ),
		array( '大増', 'oomashi', 'LY8ts4Dg' ),
		array( '吉見', 'yoshimi', 'JkoJd53B' ),
		array( '光ヶ丘', 'hikarigaoka', 'oWdT1yiX' ),
		array( '逆井', 'sakasai', 'BKUocbV4' ),
		array( '幕張本郷', 'makuharihongo', 'IxnWXvo9' ),
		array( '千葉国際', 'chibakokusai', 'TQxkc8UD' ),
		array( '二宮', 'ninomiya', 'vJeTgP9j' ),
		array( '戸頭', 'togashira', '28zuAh33' ),
		array( '結城東', 'yukihigashi', 'GXBrWvp4' ),
		array( '水海道西', 'mitsukaidonishi', 'UWI8gGjo' ),
		array( '総和', 'sowa', 'jv4WP6aB' ),
		array( '桂萱', 'kaigaya', 'AYhNV38f' ),
		array( '笠懸', 'kasagake', 'JoL2DVeq' ),
		array( '南橘', 'nankitsu', '1FpYonnR' ),
		array( '榛東', 'shinto', 'dSkNw1dn' ),
		array( '倉賀野', 'kuragano', 'MgZ3RirB' ),
		array( '玉穂', 'tamaho', 'My7oss4w' ),
		array( '城南', 'jonan', 'KasEAu7g' ),
		array( '小池', 'koike', 'aQ8mqoLt' ),
		array( '燕', 'tsubame', 'wCFY5juv' ),
		array( '吉田', 'yoshida', 'BU8nEisk' ),
		array( '春日', 'kasuga', 'R8mQ4vip' ),
		array( '本丸', 'honmaru', 'jZL3Zdon' ),
		array( '中之島', 'nakanoshima', 'eD3kH317' ),
		array( '五十嵐', 'igarashi', 'epLE3JI2' ),
		array( '白根第一', 'shiraneichi', '9NNVfNwH' ),
		array( '吉川', 'yoshikawa', 'TJ2shmE1' ),
		array( '小針', 'kobari', '4sk57S9X' ),
		array( '北辰', 'hokushin', 'UXapk1sm' ),
		array( '堀川', 'horikawa', 'Zkcx5oj5' ),
		array( '奥田', 'okuda', 'VF18Ts8i' ),
		array( '山室', 'yamamuro', '97mHS3Ah' ),
		array( '庄川', 'shogawa', 'w8Zj82FX' ),
		array( '速星', 'hayahoshi', 'BxW9UVhE' ),
		array( '射北', 'ihoku', 'TPSMkdx8' ),
		array( '宇ノ気', 'unoke', 'GYH6stTv' ),
		array( '羽咋', 'hakui', 'n9XFpo7x' ),
		array( '御祓', 'misogi', '4ATjhRnC' ),
		array( '丸岡', 'maruoka', 'g18DgIFU' ),
		array( '松陵', 'shoryo', 'ogsK6rac' ),
		array( '鶴城', 'tsurushiro', '4v2TDCaz' ),
		array( '平坂', 'heisaka', 'BGL31yiv' ),
		array( '福地', 'hukuchi', 'EnmI2L6t' ),
		array( '清見', 'kiyomi', 'h7TLHvc8' ),
		array( '大和', 'yamato', 'p69Z78Fh' ),
		array( '高鷲', 'takawashi', 'HnwR7Ea6' ),
		array( '積志', 'sekishi', 'Ww4YvYdN' ),
		array( '中部', 'hamamatsuchubu', 'YfkHyg94' ),
		array( '南部', 'hamamatsunanbu', 'W3YxA7Yx' ),
		array( '西部', 'hamamatsuseibu', 'U8t9G7pa' ),
		array( '第一', 'iwatadaiichi', 'pQUohbe4' ),
		array( '御前崎', 'omaezaki', 'dQ45u3Mc' ),
		array( '東海大翔洋', 'shoyo', 'tE9o2ZIa' ),
		array( '西朝明', 'nishiasake', 'Cd4Kzw5k' ),
		array( '山手', 'yamate', 't2yP1RpJ' ),
		array( '住吉第一', 'sumiyoshiichi', 'vCDFF2GC' ),
		array( '三国', 'mikuni', 'I7L6VAKa' ),
		array( '久御山', 'kumiyama', 'YwLZ4cJr' ),
		array( '那賀川', 'nakagawa', 'AeAStwu7' ),
		array( '戸倉上山田', 'togami', 'HdoLa7pk' ),
		array( '更埴西', 'koshokunishi', 'YTK6Voyt' ),
		array( '坂城', 'sakaki', 'w6KSS5hj' ),
		array( '柳町', 'yanagimachi', '7S252WQd' ),
		array( '豊野', 'toyono', 'r11BMr8p' ),
		array( '篠ノ井西', 'shinonoinishi', 'WGdw61Mc' ),
		array( '篠ノ井東', 'shinonoihigashi', 'kBZ9Lx89' ),
		array( '若穂', 'wakaho', 'Xt8R99dY' ),
		array( '川中島', 'kawanakajima', 'sZPrZ8cn' ),
		array( '裾花', 'susobana', 'ER1Lk1oQ' ),
		array( '長野東部', 'naganotobu', '1r7tas1G' ),
		array( '犀陵', 'sairyo', 'mUvx6zyL' ),
		array( '長野北部', 'naganohokubu', '2gHobwoT' ),
		array( '浅間', 'asama', 'o38zmRp8' ),
		array( '上田第二', 'uedani', 'bX8ebr5k' ),
		array( '上田第三', 'uedasan', '56GcsJ9N' ),
		array( '上田第六', 'uedaroku', 'KEWTm4fN' ),
		array( '軽井沢', 'karuizawa', 'SvoITno6' ),
		array( '東御東部', 'tobu', 'NLe5DFRd' ),
		array( '佐久長聖', 'sakuchosei', 'wojg97Yo' ),
		array( '広陵', 'koryo', '17zowoqI' ),
		array( '塩尻西部', 'shiojiriseibu', 'GkQqxm5U' ),
		array( '丘', 'oka', 'z2qGvCiK' ),
		array( '穂高西', 'hotakanishi', 'VBf5GLk3' ),
		array( '穂高東', 'hotakahigashi', '9JUTmRto' ),
		array( '筑北', 'chikuhoku', 'BQSmV54j' ),
		array( '鉢盛', 'hachimori', 'HroHcM6z' ),
		array( '下條', 'shimojo', 'mNDgqI4H' ),
		array( '松川', 'matsukawa', 'nrUVI9S6' ),
		array( '伊那東部', 'inatobu', 'WJaTYKs7' ),
		array( '岡谷西部', 'okayaseibu', '3BLTsk4J' ),
		array( '高遠', 'takato', 'ZLmQ1AU4' ),
		array( '竜峡', 'ryukyo', 'HF8qJtQp' ),
		array( '緑ヶ丘', 'midorigaoka', 'R2MRvtQB' ),
		array( '松代', 'matsushiro', 'S18obNyx' )
	);

	$dbs = new mysqli( DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME );
	$dbs->set_charset( "utf8" );

	$field_def = array();
	$sql = 'select * from `entry_field_def`';
	$rs = $dbs->query( $sql );
	if( $rs !== false ){
		while( $lv = $rs->fetch_assoc() ){
			$field_def[] = $lv;
		}
	}

	$uindex = 1;
	foreach( $userdef as $uv ){
		$sql = 'insert into `entry_info` (`series`, `disp_order`, `create_date` ) values (2, '.$uindex.', NOW())';
echo $sql;
echo "<br />\n";
		$dbs->query( $sql );
		$newid = $dbs->insert_id;
		foreach( 

		$uv[0]
		}
		$uindex++;
	}

(2, 'school_org',			'学校種別',			'text',		'school_org',	'学校種別', 		14,'' ),
(2, 'school_name',			'学校名',			'text', 	'text',			'学校名', 			100,'' ),
(2, 'school_name_kana',		'学校名フリガナ',	'text', 	'text',			'学校名フリガナ',	100,'' ),
(2, 'school_name_ryaku',	'学校名略称',		'text', 	'text',			'学校名略称',		100,'' ),
(2, 'school_address',		'学校住所',			'text', 	'address',		'学校住所',			14,'' ),
(2, 'school_phone',			'電話番号／FAX番号','text', 	'tel_fax',		'電話番号／FAX番号',14,	'' ),
(2, 'responsible',			'記入責任者',		'text', 	'text',			'記入責任者',		14,	'' ),
(2, 'responsible_contact',	'連絡先',			'text', 	'mobile_tel',	'連絡先',			14,	'' ),
(2, 'responsible_email',	'E-mail',			'text', 	'email',		'E-mail',			90,	'' ),
(2, 'referee',				'協力審判員',		'text', 	'name',			'協力審判員',		14,	'' ),
(2, 'referee_rank',			'段位',				'text', 	'text',			'',					8,	'' ),
(2, 'refereeing_category',	'審判希望部門',		'text', 	'check',		'',					0,	'男子|m|女子|w' ),
(2, 'insotu1',				'引率者1氏名',		'text', 	'name',			'引率者1氏名',		14,	'' ),
(2, 'insotu2',				'引率者2氏名',		'text', 	'name',			'引率者2氏名',		14,	'' ),
(2, 'insotu3',				'引率者3氏名',		'text', 	'name',			'引率者3氏名',		14,	'' ),
(2, 'insotu4',				'引率者4氏名',		'text', 	'name',			'引率者4氏名',		14,	'' ),
(2, '',						'男子団体',			'', 		'title2',		'カタログ出力見本',	0,	'href="#" onClick="window.open(''catalog_m.php'',''catalog sample'',''toolbar=no,scrollbar=auto,width=800,height=400''); return false;"' ),
(2, 'shumoku_dantai_m',		'男子団体',			'integer',	'check_one',	'',					0,	'参加|1|不参加|0' ),
(2, 'manager_m',			'男子監督氏名',		'text', 	'name2',		'男子監督氏名',		14,	'' ),
(2, 'captain_m',			'男子主将氏名',		'text', 	'name2',		'男子主将氏名',		14,	'' ),
(2, 'player1_m',			'男子先鋒氏名',		'text', 	'name2',		'男子先鋒氏名',		14,	'' ),
(2, 'player1_grade_m',		'男子先鋒学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player2_m',			'男子次峰氏名',		'text', 	'name2',		'男子次峰氏名',		14,	'' ),
(2, 'player2_grade_m',		'男子次峰学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player3_m',			'男子中堅氏名',		'text', 	'name2',		'男子中堅氏名',		14,	'' ),
(2, 'player3_grade_m',		'男子中堅学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player4_m',			'男子副将氏名',		'text', 	'name2',		'男子副将氏名',		14,	'' ),
(2, 'player4_grade_m',		'男子副将学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player5_m',			'男子大将氏名',		'text', 	'name2',		'男子大将氏名',		14,	'' ),
(2, 'player5_grade_m',		'男子大将学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player6_m',			'男子補員１氏名',	'text', 	'name2',		'男子補員１氏名',	14,	'' ),
(2, 'player6_grade_m',		'男子補員１学年',	'integer',	'grade_j',		'',					8,	'' ),
(2, 'introduction_m',		'男子チーム紹介',	'text', 	'textarea',		'男子チーム紹介',	100,'' ),
(2, 'main_results_m',		'男子主な戦績',		'text', 	'textarea',		'男子主な戦績',		100,'' ),
(2, '',						'女子団体',			'', 		'title2',		'カタログ出力見本',	0,	'href="#" onClick="window.open(''catalog_w.php'',''catalog sample'',''toolbar=no,scrollbar=auto,width=800,height=400''); return false;"' ),
(2, 'shumoku_dantai_w',		'女子団体',			'integer',	'check_one',	'',					0,	'参加|1|不参加|0' ),
(2, 'manager_w',			'女子監督氏名',		'text', 	'name2',		'女子監督氏名',		14,	'' ),
(2, 'captain_w',			'女子主将氏名',		'text', 	'name2',		'女子主将氏名',		14,	'' ),
(2, 'player1_w',			'女子先鋒氏名',		'text', 	'name2',		'女子先鋒氏名',		14,	'' ),
(2, 'player1_grade_w',		'女子先鋒学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player2_w',			'女子次峰氏名',		'text', 	'name2',		'女子次峰氏名',		14,	'' ),
(2, 'player2_grade_w',		'女子次峰学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player3_w',			'女子中堅氏名',		'text', 	'name2',		'女子中堅氏名',		14,	'' ),
(2, 'player3_grade_w',		'女子中堅学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player4_w',			'女子副将氏名',		'text', 	'name2',		'女子副将氏名',		14,	'' ),
(2, 'player4_grade_w',		'女子副将学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player5_w',			'女子大将氏名',		'text', 	'name2',		'女子大将氏名',		14,	'' ),
(2, 'player5_grade_w',		'女子大将学年',		'integer',	'grade_j',		'',					8,	'' ),
(2, 'player6_w',			'女子補員１氏名',	'text', 	'name2',		'女子補員１氏名',	14,	'' ),
(2, 'player6_grade_w',		'女子補員１学年',	'integer',	'grade_j',		'',					8,	'' ),
(2, 'introduction_w',		'女子チーム紹介',	'text', 	'textarea',		'女子チーム紹介',	100,'' ),
(2, 'main_results_w',		'女子主な戦績',		'text', 	'textarea',		'女子主な戦績',		100,'' );



INSERT INTO `entry_field_def` (`series`, `field`, `name`, `kind`, `placeholder`, `text_width`, `select_info` ) VALUES 
(2, 'school_name',		'学校名',	'text',	'学校名', 100, '' ),
(2, 'school_name_kana',		'学校名フリガナ',	'text',	'学校名フリガナ',100, '' ),
(2, 'school_name_ryaku',	'学校名略称',		'text',	'学校名略称',100, '' ),
(2, 'school_zip',			'郵便番号','text',	'郵便番号',14,'' ),
(2, 'school_pref',			'都道府県','pref_select','都道府県',	0,'address_pref' ),
(2, 'school_address',		'住所',	'text',	'住所',100, '' ),
(2, 'school_phone',			'電話番号','text',	'電話番号',14,'' ),
(2, 'responsible',			'記入責任者','text',	'記入責任者',14,'' ),
(2, 'contact',				'連絡先','text',	'連絡先',14,'' ),
(2, 'email',			'E-mail','text',	'E-mail',90,'' ),
(2, 'manager',			'監督名','text',	'監督名',14,'' ),
(2, 'referee',			'協力審判員','text',	'協力審判員',14,'' ),
(2, 'referee_rank',		'段位',	'text',	'',8,'' ),
(2, 'refereeing_category','審判希望部門',				'check',	'',0,'中学男子|m|中学女子|w' ),
(2, '',		'男子団体',		'title2',	'',0,'' ),
(2, 'shumoku_dantai_m',		'男子団体',		'check_one',	'',0,'参加|1|不参加|0' ),
(2, 'captain_m',			'男子主将','text',	'男子主将',14,'' ),
(2, 'player1_m',			'男子選手氏名1','text',	'男子選手氏名1',14,'' ),
(2, 'player1_grade_m',		'男子学年1',	'text',	'',8,'' ),
(2, 'player2_m',			'男子選手氏名2','text',	'男子選手氏名2',14,'' ),
(2, 'player2_grade_m',		'男子学年2',	'text',	'',8,'' ),
(2, 'player3_m',			'男子選手氏名3','text',	'男子選手氏名3',14,'' ),
(2, 'player3_grade_m',		'男子学年3',	'text',	'',8,'' ),
(2, 'player4_m',			'男子選手氏名4','text',	'男子選手氏名4',14,'' ),
(2, 'player4_grade_m',		'男子学年4',	'text',	'',8,'' ),
(2, 'player5_m',			'男子選手氏名5','text',	'男子選手氏名5',14,'' ),
(2, 'player5_grade_m',		'男子学年5',	'text',	'',8,'' ),
(2, 'introduction_m',		'男子チーム紹介',	'textarea',	'男子チーム紹介',100,'' ),
(2, 'main_results_m',		'男子主な戦績',	'textarea',	'男子主な戦績',100,'' ),
(2, '',		'女子団体',		'title2',	'',0,'' ),
(2, 'shumoku_dantai_w',		'女子団体',		'check_one',	'',0,'参加|1|不参加|0' ),
(2, 'captain_w',			'女子主将','text',	'女子主将',14,'' ),
(2, 'player1_w',			'女子選手氏名1','text',	'女子選手氏名1',14,'' ),
(2, 'player1_grade_w',		'女子学年1',	'text',	'',8,'' ),
(2, 'player2_w',			'女子選手氏名2','text',	'女子選手氏名2',14,'' ),
(2, 'player2_grade_w',		'女子学年2',	'text',	'',8,'' ),
(2, 'player3_w',			'女子選手氏名3','text',	'女子選手氏名3',14,'' ),
(2, 'player3_grade_w',		'女子学年3',	'text',	'',8,'' ),
(2, 'player4_w',			'女子選手氏名4','text',	'女子選手氏名4',14,'' ),
(2, 'player4_grade_w',		'女子学年4',	'text',	'',8,'' ),
(2, 'player5_w',			'女子選手氏名5','text',	'女子選手氏名5',14,'' ),
(2, 'player5_grade_w',		'女子学年5',	'text',	'',8,'' ),
(2, 'introduction_w',		'女子チーム紹介',	'textarea',	'女子チーム紹介',100,'' ),
(2, 'main_results_w',		'女子主な戦績',	'textarea',	'女子主な戦績',100,'' );

-- --------------------------------------------------------

drop table if exists `entry_field_name`;
create table `entry_field_name` (
	`id` int unsigned not null auto_increment,
	`series` int unsigned not null default 0,
	`field` varchar(128) NOT NULL,
	`name` text NOT NULL,
	primary key ( `id` )
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `entry_field_name` (`series`, `field`, `name` ) VALUES 
(2, 'category',			'部門' ),
(2, 'school_name',		'学校名' ),
(2, 'school_name_kana',	'学校名フリガナ' ),
(2, 'school_name_ryaku','学校名略称' ),
(2, 'school_zip',		'郵便番号' ),
(2, 'school_pref',		'都道府県' ),
(2, 'school_address',	'住所' ),
(2, 'school_phone',		'電話番号' ),
(2, 'responsible',		'記入責任者' ),
(2, 'contact',			'連絡先' ),
(2, 'email',			'E-mail' ),
(2, 'manager',			'監督名' ),
(2, 'referee',			'協力審判員' ),
(2, 'referee_rank',		'段位' ),
(2, 'refereeing_category',	'審判希望部門' ),
(2, 'captain_m',			'男子主将' ),
(2, 'player1_m',			'男子選手氏名1' ),
(2, 'player1_grade_m',	'男子学年1' ),
(2, 'player2_m',			'男子選手氏名2' ),
(2, 'player2_grade_m',	'男子学年2' ),
(2, 'player3_m',			'男子選手氏名3' ),
(2, 'player3_grade_m',	'男子学年3' ),
(2, 'player4_m',			'男子選手氏名4' ),
(2, 'player4_grade_m',	'男子学年4' ),
(2, 'player5_m',			'男子選手氏名5' ),
(2, 'player5_grade_m',	'男子学年5' ),
(2, 'introduction_m',	'男子チーム紹介' ),
(2, 'main_results_m',	'男子主な戦績' ),
(2, 'captain_w',			'女子主将' ),
(2, 'player1_w',			'女子選手氏名1' ),
(2, 'player1_grade_w',	'女子学年1' ),
(2, 'player2_w',			'女子選手氏名2' ),
(2, 'player2_grade_w',	'女子学年2' ),
(2, 'player3_w',			'女子選手氏名3' ),
(2, 'player3_grade_w',	'女子学年3' ),
(2, 'player4_w',			'女子選手氏名4' ),
(2, 'player4_grade_w',	'女子学年4' ),
(2, 'player5_w',			'女子選手氏名5' ),
(2, 'player5_grade_w',	'女子学年5' ),
(2, 'introduction_w',	'女子チーム紹介' ),
(2, 'main_results_w',	'女子主な戦績' );

-- --------------------------------------------------------

drop table if exists `entry_select_def`;
create table `entry_select_def` (
	`id` int unsigned not null auto_increment,
	`series` int unsigned not null default 0,
	`field` varchar(128) NOT NULL,
	`data` text NOT NULL,
	primary key ( `id` )
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `entry_select_def` (`series`, `field`, `data` ) VALUES 
(2, 'address_pref', '北海道|1|青森県|2|岩手県|3|宮城県|4|秋田県|5|山形県|6|福島県|7|茨城県|8|栃木県|9|群馬県|10|埼玉県|11|千葉県|12|東京都|13|神奈川県|14|新潟県|15|富山県|16|石川県|17|福井県|18|山梨県|19|長野県|20|岐阜県|21|静岡県|22|愛知県|23|三重県|24|滋賀県|25|京都府|26|大阪府|27|兵庫県|28|奈良県|29|和歌山県|30|鳥取県|31|島根県|32|岡山県|33|広島県|34|山口県|35|徳島県|36|香川県|37|愛媛県|38|高知県|39|福岡県|40|佐賀県|41|長崎県|42|熊本県|43|大分県|44|宮崎県|45|鹿児島県|46|沖縄県|47' ),
(2, 'refereeing_category', '中学男子|m|中学女子|w' ),
(2, 'shumoku_dantai_m', '参加|1|不参加|0' ),
(2, 'shumoku_dantai_w', '参加|1|不参加|0' );

-- --------------------------------------------------------

drop table if exists `entry_field`;
create table `entry_field` (
	`id` int unsigned not null auto_increment,
	`series` int unsigned not null default 0,
	`info` int unsigned not null,
	`field` varchar(32) NOT NULL,
	`data` text NOT NULL,
	primary key ( `id` )
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `entry_field` (`info`, `field`, `language`, `data` ) VALUES 
(1, 'name', 'ja', 'テスト1' ),
(1, 'name', 'en', 'test1' );

-- --------------------------------------------------------

drop table if exists `entry_info`;
create table `entry_info` (
  `id` int unsigned not null auto_increment,
  `series` int unsigned not null default '0',
  `disp_order` int(11) unsigned not null default '0',
  `create_date` datetime not null,
  `public` tinyint(3) unsigned not null default '1',
  `deleted` tinyint(2) unsigned not null default '0',
primary key ( `id` )
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `entry_info` (`series`, `disp_order`, `create_date` ) VALUES 
(2, 1, NOW());

-- --------------------------------------------------------

drop table if exists `entry_users`;
CREATE TABLE IF NOT EXISTS `entry_users` (
  `id` INT(8) UNSIGNED NOT NULL auto_increment,
  `series` int unsigned not null default '0',
  `user_name` varchar(64) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `entry_users` (`series`,`user_name`,`user_pass`) values
(2,'mizu',SHA1('80mink86'));

-- --------------------------------------------------------

drop table if exists `entry_image`;
CREATE TABLE IF NOT EXISTS `entry_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `info` int(10) unsigned NOT NULL DEFAULT '0',
  `image` text NOT NULL DEFAULT '',
  `file` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

drop table if exists `entry`;
CREATE TABLE IF NOT EXISTS `entry` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `s_org` text NOT NULL default '',
  `org` tinyint(1) unsigned NOT NULL default 0,
  `s_name` text NOT NULL default '',
  `s_name_kana` text NOT NULL default '',
  `s_name_ryaku` text NOT NULL default '',
  `s_pref` tinyint(1) unsigned NOT NULL default 0,
  `s_zip` text NOT NULL default '',
  `s_address` text NOT NULL default '',
  `s_phone` text NOT NULL default '',
  `s_fax` text NOT NULL default '',
  `kouchou_sei` text NOT NULL default '',
  `kouchou_name` text NOT NULL default '',
  `mousikomi_month` tinyint(1) unsigned NOT NULL default 0,
  `mousikomi_day` tinyint(1) unsigned NOT NULL default 0,
  `shumoku_dantai_m` tinyint(1) unsigned NOT NULL default 0,
  `shumoku_dantai_w` tinyint(1) unsigned NOT NULL default 0,
  `shumoku_kojin_m` tinyint(1) unsigned NOT NULL default 0,
  `shumoku_kojin_w` tinyint(1) unsigned NOT NULL default 0,
  `kantoku_sei` text NOT NULL default '',
  `kantoku_name` text NOT NULL default '',
  `kantoku_bikou` text NOT NULL default '',
  `kantoku_sei_kana` text NOT NULL default '',
  `kantoku_name_kana` text NOT NULL default '',
  `kanktoku_shokumei` text NOT NULL default '',
  `kantoku_keitai` text NOT NULL default '',
  `kantoku_tel` text NOT NULL default '',
  `kantoku_email` text NOT NULL default '',
  `kantoku_pref` tinyint(1) unsigned NOT NULL default 0,
  `kantoku_zip` text NOT NULL default '',
  `kantoku_address` text NOT NULL default '',
  `insotu_sei` text NOT NULL default '',
  `insotuu_name` text NOT NULL default '',
  `insotu_bikou` text NOT NULL default '',
  `insotu_sei_kana` text NOT NULL default '',
  `insotu_name_kana` text NOT NULL default '',
  `insotu_keitai` text NOT NULL default '',
  `insotu_tel` text NOT NULL default '',
  `insotu_pref` tinyint(1) unsigned NOT NULL default 0,
  `insotu_zip` text NOT NULL default '',
  `insotu_address` text NOT NULL default '',
  `gaibu_sei` text NOT NULL default '',
  `gaibu_name` text NOT NULL default '',
  `gaibu_bikou` text NOT NULL default '',
  `gaibu_sei_kana` text NOT NULL default '',
  `gaibu_name_kana` text NOT NULL default '',
  `gaibu_keitai` text NOT NULL default '',
  `gaibu_tel` text NOT NULL default '',
  `gaibu_pref` tinyint(1) unsigned NOT NULL default 0,
  `gaibu_zip` text NOT NULL default '',
  `gaibu_address` text NOT NULL default '',
  `chuutairen_sei` text NOT NULL default '',
  `chuutairen_name` text NOT NULL default '',
  `chuutairen_bikou` text NOT NULL default '',
  `dantai_m` int(10) unsigned NOT NULL default 0,
  `dantai_w` int(10) unsigned NOT NULL default 0,
  `kojin_m` int(10) unsigned NOT NULL default 0,
  `kojin_w` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,

  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

drop table if exists `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `sei` text NOT NULL default '',
  `mei` text NOT NULL default '',
  `dispname` text NOT NULL default '',
  `bikou` text NOT NULL default '',
  `sei_kana` text NOT NULL default '',
  `mei_kana` text NOT NULL default '',
  `gakunen` tinyint(1) unsigned NOT NULL default 0,
  `dan` text NOT NULL default '',
  `b_year` smallint(4) unsigned NOT NULL default 0,
  `b_month` tinyint(1) unsigned NOT NULL default 0,
  `b_day` tinyint(1) unsigned NOT NULL default 0,
  `age` tinyint(1) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

drop table if exists `dantai_players`;
CREATE TABLE IF NOT EXISTS `dantai_players` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kaisuu` text NOT NULL default '',
  `player1` int(10) unsigned NOT NULL default 0,
  `player2` int(10) unsigned NOT NULL default 0,
  `player3` int(10) unsigned NOT NULL default 0,
  `player4` int(10) unsigned NOT NULL default 0,
  `player5` int(10) unsigned NOT NULL default 0,
  `player6` int(10) unsigned NOT NULL default 0,
  `player7` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

drop table if exists `kojin_players`;
CREATE TABLE IF NOT EXISTS `kojin_players` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `player1` int(10) unsigned NOT NULL default 0,
  `player2` int(10) unsigned NOT NULL default 0,
  `player3` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

drop table if exists `one_match`;
CREATE TABLE IF NOT EXISTS `one_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `player1` int(10) unsigned NOT NULL default 0,
  `faul1_1` tinyint(1) unsigned NOT NULL default 0,
  `faul1_2` tinyint(1) unsigned NOT NULL default 0,
  `waza1_1` tinyint(1) unsigned NOT NULL default 0,
  `waza1_2` tinyint(1) unsigned NOT NULL default 0,
  `waza1_3` tinyint(1) unsigned NOT NULL default 0,
  `player2` int(10) unsigned NOT NULL default 0,
  `faul2_1` tinyint(1) unsigned NOT NULL default 0,
  `faul2_2` tinyint(1) unsigned NOT NULL default 0,
  `waza2_1` tinyint(1) unsigned NOT NULL default 0,
  `waza2_2` tinyint(1) unsigned NOT NULL default 0,
  `waza2_3` tinyint(1) unsigned NOT NULL default 0,
  `end_match` tinyint(1) unsigned NOT NULL default 0,
  `hon1` tinyint(1) unsigned NOT NULL default 0,
  `hon2` tinyint(1) unsigned NOT NULL default 0,
  `winner` tinyint(1) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

drop table if exists `match_info`;
CREATE TABLE IF NOT EXISTS `match_info` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `place` smallint(4) unsigned NOT NULL default 0,
  `place_match_no` smallint(4) unsigned NOT NULL default 0,
  `category` smallint(4) unsigned NOT NULL DEFAULT 0,
  `team1` int(10) unsigned NOT NULL default 0,
  `team2` int(10) unsigned NOT NULL default 0,
  `match1` int(10) unsigned NOT NULL default 0,
  `match2` int(10) unsigned NOT NULL default 0,
  `match3` int(10) unsigned NOT NULL default 0,
  `match4` int(10) unsigned NOT NULL default 0,
  `match5` int(10) unsigned NOT NULL default 0,
  `match6` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `match_info` ( `place`,`place_match_no`,`category`,`team1`,`team2`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, 1, 2, NOW(), NOW() ),
 ( 1, 2, 1, 3, 4, NOW(), NOW() ),
 ( 1, 3, 1, 1, 2, NOW(), NOW() ),
 ( 1, 4, 1, 3, 4, NOW(), NOW() ),
 ( 1, 5, 1, 1, 2, NOW(), NOW() ),
 ( 1, 6, 1, 3, 4, NOW(), NOW() ),
 ( 2, 1, 1, 1, 2, NOW(), NOW() ),
 ( 2, 2, 1, 3, 4, NOW(), NOW() ),
 ( 2, 3, 1, 1, 2, NOW(), NOW() ),
 ( 2, 4, 1, 3, 4, NOW(), NOW() ),
 ( 2, 5, 1, 1, 2, NOW(), NOW() ),
 ( 2, 6, 1, 3, 4, NOW(), NOW() ),
 ( 3, 1, 1, 1, 2, NOW(), NOW() ),
 ( 3, 2, 1, 3, 4, NOW(), NOW() ),
 ( 3, 3, 1, 1, 2, NOW(), NOW() ),
 ( 3, 4, 1, 3, 4, NOW(), NOW() ),
 ( 3, 5, 1, 1, 2, NOW(), NOW() ),
 ( 3, 6, 1, 3, 4, NOW(), NOW() ),
 ( 4, 1, 1, 1, 2, NOW(), NOW() ),
 ( 4, 2, 1, 3, 4, NOW(), NOW() ),
 ( 4, 3, 1, 1, 2, NOW(), NOW() ),
 ( 4, 4, 1, 3, 4, NOW(), NOW() ),
 ( 4, 5, 1, 1, 2, NOW(), NOW() ),
 ( 4, 6, 1, 3, 4, NOW(), NOW() ),
 ( 1, 7, 1, 1, 2, NOW(), NOW() ),
 ( 2, 7, 1, 3, 4, NOW(), NOW() ),
 ( 3, 7, 1, 1, 2, NOW(), NOW() ),
 ( 4, 7, 1, 3, 4, NOW(), NOW() ),
 ( 1, 8, 1, 1, 2, NOW(), NOW() ),
 ( 2, 8, 1, 3, 4, NOW(), NOW() ),
 ( 3, 8, 1, 1, 2, NOW(), NOW() ),

 ( 1, 9, 2, 3, 4, NOW(), NOW() ),
 ( 1, 10, 2, 1, 2, NOW(), NOW() ),
 ( 1, 11, 2, 3, 4, NOW(), NOW() ),
 ( 1, 12, 2, 1, 2, NOW(), NOW() ),
 ( 1, 13, 2, 3, 4, NOW(), NOW() ),
 ( 1, 14, 2, 1, 2, NOW(), NOW() ),
 ( 2, 9, 2, 3, 4, NOW(), NOW() ),
 ( 2, 10, 2, 1, 2, NOW(), NOW() ),
 ( 2, 11, 2, 3, 4, NOW(), NOW() ),
 ( 2, 12, 2, 1, 2, NOW(), NOW() ),
 ( 2, 13, 2, 3, 4, NOW(), NOW() ),
 ( 2, 14, 2, 1, 2, NOW(), NOW() ),
 ( 3, 9, 2, 3, 4, NOW(), NOW() ),
 ( 3, 10, 2, 1, 2, NOW(), NOW() ),
 ( 3, 11, 2, 3, 4, NOW(), NOW() ),
 ( 3, 12, 2, 1, 2, NOW(), NOW() ),
 ( 3, 13, 2, 3, 4, NOW(), NOW() ),
 ( 3, 14, 2, 1, 2, NOW(), NOW() ),
 ( 4, 8, 2, 3, 4, NOW(), NOW() ),
 ( 4, 9, 2, 1, 2, NOW(), NOW() ),
 ( 4, 10, 2, 3, 4, NOW(), NOW() ),
 ( 4, 11, 2, 1, 2, NOW(), NOW() ),
 ( 4, 12, 2, 3, 4, NOW(), NOW() ),
 ( 4, 13, 2, 1, 2, NOW(), NOW() ),
 ( 1, 15, 2, 3, 4, NOW(), NOW() ),
 ( 2, 15, 2, 1, 2, NOW(), NOW() ),
 ( 3, 15, 2, 3, 4, NOW(), NOW() ),
 ( 4, 14, 2, 1, 2, NOW(), NOW() ),
 ( 1, 16, 2, 3, 4, NOW(), NOW() ),
 ( 2, 16, 2, 1, 2, NOW(), NOW() ),
 ( 3, 16, 2, 3, 4, NOW(), NOW() ),

 ( 1, 17, 3, 1, 2, NOW(), NOW() ),
 ( 2, 17, 3, 3, 4, NOW(), NOW() ),
 ( 3, 17, 3, 1, 2, NOW(), NOW() ),
 ( 4, 15, 3, 3, 4, NOW(), NOW() ),
 ( 1, 18, 3, 1, 2, NOW(), NOW() ),
 ( 2, 18, 3, 3, 4, NOW(), NOW() ),
 ( 3, 18, 3, 1, 2, NOW(), NOW() ),
 ( 4, 16, 3, 3, 4, NOW(), NOW() ),
 ( 1, 19, 3, 1, 2, NOW(), NOW() ),
 ( 2, 19, 3, 3, 4, NOW(), NOW() ),
 ( 3, 19, 3, 1, 2, NOW(), NOW() ),
 ( 4, 17, 3, 3, 4, NOW(), NOW() ),
 ( 1, 20, 3, 1, 2, NOW(), NOW() ),
 ( 2, 20, 3, 3, 4, NOW(), NOW() ),
 ( 3, 20, 3, 1, 2, NOW(), NOW() ),

 ( 1, 21, 4, 3, 4, NOW(), NOW() ),
 ( 2, 21, 4, 1, 2, NOW(), NOW() ),
 ( 3, 21, 4, 3, 4, NOW(), NOW() ),
 ( 4, 18, 4, 1, 2, NOW(), NOW() ),
 ( 1, 22, 4, 3, 4, NOW(), NOW() ),
 ( 2, 22, 4, 1, 2, NOW(), NOW() ),
 ( 3, 22, 4, 3, 4, NOW(), NOW() ),
 ( 4, 19, 4, 1, 2, NOW(), NOW() ),
 ( 1, 23, 4, 3, 4, NOW(), NOW() ),
 ( 2, 23, 4, 1, 2, NOW(), NOW() ),
 ( 3, 23, 4, 3, 4, NOW(), NOW() ),
 ( 4, 20, 4, 1, 2, NOW(), NOW() ),
 ( 1, 24, 4, 3, 4, NOW(), NOW() ),
 ( 2, 24, 4, 1, 2, NOW(), NOW() ),
 ( 3, 24, 4, 3, 4, NOW(), NOW() );


drop table if exists `dantai_match`;
CREATE TABLE IF NOT EXISTS `dantai_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `team1` int(10) unsigned NOT NULL default 0,
  `team2` int(10) unsigned NOT NULL default 0,
  `place` smallint(4) unsigned NOT NULL default 0,
  `place_match_no` smallint(4) unsigned NOT NULL default 0,
  `match1` int(10) unsigned NOT NULL default 0,
  `match2` int(10) unsigned NOT NULL default 0,
  `match3` int(10) unsigned NOT NULL default 0,
  `match4` int(10) unsigned NOT NULL default 0,
  `match5` int(10) unsigned NOT NULL default 0,
  `match6` int(10) unsigned NOT NULL default 0,
  `exist_match6` tinyint(1) unsigned NOT NULL default 0,
  `win1` tinyint(1) unsigned NOT NULL default 0,
  `hon1` tinyint(1) unsigned NOT NULL default 0,
  `win2` tinyint(1) unsigned NOT NULL default 0,
  `hon2` tinyint(1) unsigned NOT NULL default 0,
  `winner` tinyint(1) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_match` ( `team1`,`team2`,`place`,`place_match_no`,`create_date`, `update_date` ) VALUES
 ( 1, 1, 1, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 1, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 2, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 3, 6, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 1, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 2, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 3, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 4, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 5, NOW( ) , NOW( ) ),
 ( 1, 1, 4, 6, NOW( ) , NOW( ) );

drop table if exists `kojin_match`;
CREATE TABLE IF NOT EXISTS `kojin_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `place` smallint(4) unsigned NOT NULL default 0,
  `place_match_no` smallint(4) unsigned NOT NULL default 0,
  `match` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `kojin_match` ( `place`,`place_match_no`,`match`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, NOW() , NOW() ),
 ( 2, 1, 1, NOW() , NOW() ),
 ( 3, 1, 1, NOW() , NOW() ),
 ( 4, 1, 1, NOW() , NOW() ),
 ( 1, 2, 1, NOW() , NOW() ),
 ( 2, 2, 1, NOW() , NOW() ),
 ( 3, 2, 1, NOW() , NOW() ),
 ( 4, 2, 1, NOW() , NOW() ),
 ( 1, 3, 1, NOW() , NOW() ),
 ( 2, 3, 1, NOW() , NOW() ),
 ( 3, 3, 1, NOW() , NOW() ),
 ( 4, 3, 1, NOW() , NOW() ),
 ( 1, 4, 1, NOW() , NOW() ),
 ( 2, 4, 1, NOW() , NOW() ),
 ( 3, 4, 1, NOW() , NOW() ),
 ( 4, 4, 1, NOW() , NOW() ),
 ( 1, 5, 1, NOW() , NOW() ),
 ( 2, 5, 1, NOW() , NOW() ),
 ( 3, 5, 1, NOW() , NOW() ),
 ( 4, 5, 1, NOW() , NOW() ),
 ( 1, 6, 1, NOW() , NOW() ),
 ( 2, 6, 1, NOW() , NOW() ),
 ( 3, 6, 1, NOW() , NOW() ),
 ( 4, 6, 1, NOW() , NOW() ),
 ( 1, 7, 1, NOW() , NOW() ),
 ( 2, 7, 1, NOW() , NOW() ),
 ( 3, 7, 1, NOW() , NOW() ),
 ( 4, 7, 1, NOW() , NOW() ),
 ( 1, 8, 1, NOW() , NOW() ),
 ( 2, 8, 1, NOW() , NOW() ),
 ( 3, 8, 1, NOW() , NOW() ),
 ( 4, 8, 1, NOW() , NOW() );

drop table if exists `dantai_league`;
CREATE TABLE IF NOT EXISTS `dantai_league` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` smallint(4) unsigned NOT NULL default 0,
  `name` text NOT NULL default '',
  `team_num` smallint(4) unsigned NOT NULL default 0,
  `match_num` smallint(4) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_league` ( `category`,`name`,`team_num`,`match_num`,`create_date`, `update_date` ) VALUES
 ( 1, 'グループA', 4, 6, NOW( ) , NOW( ) ),
 ( 1, 'グループB', 4, 6, NOW( ) , NOW( ) ),
 ( 1, 'グループC', 4, 6, NOW( ) , NOW( ) ),
 ( 1, 'グループD', 4, 6, NOW( ) , NOW( ) ),
 ( 2, 'グループA', 4, 6, NOW( ) , NOW( ) ),
 ( 2, 'グループB', 4, 6, NOW( ) , NOW( ) ),
 ( 2, 'グループC', 4, 6, NOW( ) , NOW( ) ),
 ( 2, 'グループD', 4, 6, NOW( ) , NOW( ) );


drop table if exists `dantai_league_team`;
CREATE TABLE IF NOT EXISTS `dantai_league_team` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `league` int(10) unsigned NOT NULL default 0,
  `league_team_index` smallint(4) unsigned NOT NULL default 0,
  `team` int(10) unsigned NOT NULL default 0,
  `point` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `win` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `hon` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `advanced` tinyint(1) unsigned NOT NULL DEFAULT 0,
  `standing` smallint(4) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_league_team` ( `league`,`league_team_index`,`team`,`advanced`,`standing`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 1, 2, 2, 1, 2, NOW( ) , NOW( ) ),
 ( 1, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 1, 4, 4, 0, 3, NOW( ) , NOW( ) ),
 ( 2, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 2, 2, 2, 0, 3, NOW( ) , NOW( ) ),
 ( 2, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 2, 4, 4, 1, 2, NOW( ) , NOW( ) ),
 ( 3, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 3, 2, 2, 1, 2, NOW( ) , NOW( ) ),
 ( 3, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 3, 4, 4, 0, 3, NOW( ) , NOW( ) ),
 ( 4, 1, 1, 1, 2, NOW( ) , NOW( ) ),
 ( 4, 2, 2, 0, 4, NOW( ) , NOW( ) ),
 ( 4, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 4, 4, 4, 0, 3, NOW( ) , NOW( ) ),
 ( 5, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 5, 2, 2, 1, 2, NOW( ) , NOW( ) ),
 ( 5, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 5, 4, 4, 0, 3, NOW( ) , NOW( ) ),
 ( 6, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 6, 2, 2, 0, 3, NOW( ) , NOW( ) ),
 ( 6, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 6, 4, 4, 1, 2, NOW( ) , NOW( ) ),
 ( 7, 1, 1, 0, 4, NOW( ) , NOW( ) ),
 ( 7, 2, 2, 1, 2, NOW( ) , NOW( ) ),
 ( 7, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 7, 4, 4, 0, 3, NOW( ) , NOW( ) ),
 ( 8, 1, 1, 1, 2, NOW( ) , NOW( ) ),
 ( 8, 2, 2, 0, 4, NOW( ) , NOW( ) ),
 ( 8, 3, 3, 1, 1, NOW( ) , NOW( ) ),
 ( 8, 4, 4, 0, 3, NOW( ) , NOW( ) );

drop table if exists `dantai_league_match`;
CREATE TABLE IF NOT EXISTS `dantai_league_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `league` int(10) unsigned NOT NULL default 0,
  `league_match_index` smallint(4) unsigned NOT NULL default 0,
  `match` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_league_match` ( `league`,`league_match_index`,`match`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, NOW( ) , NOW( ) ),
 ( 1, 2, 2, NOW( ) , NOW( ) ),
 ( 1, 3, 3, NOW( ) , NOW( ) ),
 ( 1, 4, 4, NOW( ) , NOW( ) ),
 ( 1, 5, 5, NOW( ) , NOW( ) ),
 ( 1, 6, 6, NOW( ) , NOW( ) ),
 ( 2, 1, 7, NOW( ) , NOW( ) ),
 ( 2, 2, 8, NOW( ) , NOW( ) ),
 ( 2, 3, 9, NOW( ) , NOW( ) ),
 ( 2, 4, 10, NOW( ) , NOW( ) ),
 ( 2, 5, 11, NOW( ) , NOW( ) ),
 ( 2, 6, 12, NOW( ) , NOW( ) ),
 ( 3, 1, 13, NOW( ) , NOW( ) ),
 ( 3, 2, 14, NOW( ) , NOW( ) ),
 ( 3, 3, 15, NOW( ) , NOW( ) ),
 ( 3, 4, 16, NOW( ) , NOW( ) ),
 ( 3, 5, 17, NOW( ) , NOW( ) ),
 ( 3, 6, 18, NOW( ) , NOW( ) ),
 ( 4, 1, 19, NOW( ) , NOW( ) ),
 ( 4, 2, 20, NOW( ) , NOW( ) ),
 ( 4, 3, 21, NOW( ) , NOW( ) ),
 ( 4, 4, 22, NOW( ) , NOW( ) ),
 ( 4, 5, 23, NOW( ) , NOW( ) ),
 ( 4, 6, 24, NOW( ) , NOW( ) ),
 ( 5, 1, 25, NOW( ) , NOW( ) ),
 ( 5, 2, 26, NOW( ) , NOW( ) ),
 ( 5, 3, 27, NOW( ) , NOW( ) ),
 ( 5, 4, 28, NOW( ) , NOW( ) ),
 ( 5, 5, 29, NOW( ) , NOW( ) ),
 ( 5, 6, 30, NOW( ) , NOW( ) ),
 ( 6, 1, 31, NOW( ) , NOW( ) ),
 ( 6, 2, 32, NOW( ) , NOW( ) ),
 ( 6, 3, 33, NOW( ) , NOW( ) ),
 ( 6, 4, 34, NOW( ) , NOW( ) ),
 ( 6, 5, 35, NOW( ) , NOW( ) ),
 ( 6, 6, 36, NOW( ) , NOW( ) ),
 ( 7, 1, 37, NOW( ) , NOW( ) ),
 ( 7, 2, 38, NOW( ) , NOW( ) ),
 ( 7, 3, 39, NOW( ) , NOW( ) ),
 ( 7, 4, 40, NOW( ) , NOW( ) ),
 ( 7, 5, 41, NOW( ) , NOW( ) ),
 ( 7, 6, 42, NOW( ) , NOW( ) ),
 ( 8, 1, 43, NOW( ) , NOW( ) ),
 ( 8, 2, 44, NOW( ) , NOW( ) ),
 ( 8, 3, 45, NOW( ) , NOW( ) ),
 ( 8, 4, 46, NOW( ) , NOW( ) ),
 ( 8, 5, 47, NOW( ) , NOW( ) ),
 ( 8, 6, 48, NOW( ) , NOW( ) );

drop table if exists `dantai_tournament`;
CREATE TABLE IF NOT EXISTS `dantai_tournament` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` smallint(4) unsigned NOT NULL default 0,
  `team_num` smallint(4) unsigned NOT NULL default 0,
  `match_num` smallint(4) unsigned NOT NULL default 0,
  `match_level` smallint(4) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_tournament` ( `category`,`team_num`,`match_num`,`match_level`,`create_date`, `update_date` ) VALUES
 ( 1, 8, 7, 3, NOW( ) , NOW( ) ),
 ( 2, 8, 7, 3, NOW( ) , NOW( ) );

drop table if exists `dantai_tournament_team`;
CREATE TABLE IF NOT EXISTS `dantai_tournament_team` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tournament` smallint(4) unsigned NOT NULL default 0,
  `tournament_team_index` smallint(4) unsigned NOT NULL default 0,
  `team` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_tournament_team` ( `tournament`,`tournament_team_index`,`create_date`,`update_date` ) VALUES
 ( 1, 1, NOW( ), NOW( ) ),
 ( 1, 2, NOW( ), NOW( ) ),
 ( 1, 3, NOW( ), NOW( ) ),
 ( 1, 4, NOW( ), NOW( ) ),
 ( 1, 5, NOW( ), NOW( ) ),
 ( 1, 6, NOW( ), NOW( ) ),
 ( 1, 7, NOW( ), NOW( ) ),
 ( 1, 8, NOW( ), NOW( ) ),
 ( 2, 1, NOW( ), NOW( ) ),
 ( 2, 2, NOW( ), NOW( ) ),
 ( 2, 3, NOW( ), NOW( ) ),
 ( 2, 4, NOW( ), NOW( ) ),
 ( 2, 5, NOW( ), NOW( ) ),
 ( 2, 6, NOW( ), NOW( ) ),
 ( 2, 7, NOW( ), NOW( ) ),
 ( 2, 8, NOW( ), NOW( ) );

drop table if exists `dantai_tournament_match`;
CREATE TABLE IF NOT EXISTS `dantai_tournament_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tournament` int(10) unsigned NOT NULL default 0,
  `tournament_match_index` smallint(4) unsigned NOT NULL default 0,
  `match` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `dantai_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, NOW(), NOW( ) ),
 ( 1, 2, 2, NOW(), NOW( ) ),
 ( 1, 3, 3, NOW(), NOW( ) ),
 ( 1, 4, 4, NOW(), NOW( ) ),
 ( 1, 5, 5, NOW(), NOW( ) ),
 ( 1, 6, 6, NOW(), NOW( ) ),
 ( 1, 7, 7, NOW(), NOW( ) ),
 ( 2, 1, 8, NOW(), NOW( ) ),
 ( 2, 2, 9, NOW(), NOW( ) ),
 ( 2, 3, 10, NOW(), NOW( ) ),
 ( 2, 4, 11, NOW(), NOW( ) ),
 ( 2, 5, 12, NOW(), NOW( ) ),
 ( 2, 6, 13, NOW(), NOW( ) ),
 ( 2, 7, 14, NOW(), NOW( ) );

drop table if exists `kojin_tournament`;
CREATE TABLE IF NOT EXISTS `kojin_tournament` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` smallint(4) unsigned NOT NULL default 0,
  `player_num` smallint(4) unsigned NOT NULL default 0,
  `match_num` smallint(4) unsigned NOT NULL default 0,
  `match_level` smallint(4) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `kojin_tournament` ( `category`,`player_num`,`match_num`,`match_level`,`create_date`, `update_date` ) VALUES
 ( 1, 16, 15, 4, NOW(), NOW() ),
 ( 2, 16, 15, 4, NOW(), NOW() );

drop table if exists `kojin_tournament_player`;
CREATE TABLE IF NOT EXISTS `kojin_tournament_player` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tournament` smallint(4) unsigned NOT NULL default 0,
  `tournament_player_index` smallint(4) unsigned NOT NULL default 0,
  `player` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `kojin_tournament_player` ( `tournament`,`tournament_player_index`,`player`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, NOW(), NOW() ),
 ( 1, 2, 2, NOW(), NOW() ),
 ( 1, 3, 3, NOW(), NOW() ),
 ( 1, 4, 4, NOW(), NOW() ),
 ( 1, 5, 5, NOW(), NOW() ),
 ( 1, 6, 6, NOW(), NOW() ),
 ( 1, 7, 7, NOW(), NOW() ),
 ( 1, 8, 8, NOW(), NOW() ),
 ( 1, 9, 9, NOW(), NOW() ),
 ( 1, 10, 10, NOW(), NOW() ),
 ( 1, 11, 11, NOW(), NOW() ),
 ( 1, 12, 12, NOW(), NOW() ),
 ( 1, 13, 13, NOW(), NOW() ),
 ( 1, 14, 14, NOW(), NOW() ),
 ( 1, 15, 15, NOW(), NOW() ),
 ( 1, 16, 16, NOW(), NOW() ),
 ( 2, 1, 17, NOW(), NOW() ),
 ( 2, 2, 18, NOW(), NOW() ),
 ( 2, 3, 19, NOW(), NOW() ),
 ( 2, 4, 20, NOW(), NOW() ),
 ( 2, 5, 21, NOW(), NOW() ),
 ( 2, 6, 22, NOW(), NOW() ),
 ( 2, 7, 23, NOW(), NOW() ),
 ( 2, 8, 24, NOW(), NOW() ),
 ( 2, 9, 25, NOW(), NOW() ),
 ( 2, 10, 26, NOW(), NOW() ),
 ( 2, 11, 27, NOW(), NOW() ),
 ( 2, 12, 28, NOW(), NOW() ),
 ( 2, 13, 29, NOW(), NOW() ),
 ( 2, 14, 30, NOW(), NOW() ),
 ( 2, 15, 31, NOW(), NOW() ),
 ( 2, 16, 32, NOW(), NOW() );

drop table if exists `kojin_tournament_match`;
CREATE TABLE IF NOT EXISTS `kojin_tournament_match` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tournament` int(10) unsigned NOT NULL default 0,
  `tournament_match_index` smallint(4) unsigned NOT NULL default 0,
  `match` int(10) unsigned NOT NULL default 0,
  `create_date` DATETIME NOT NULL,
  `update_date` DATETIME NOT NULL,
  `del` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
INSERT INTO `kojin_tournament_match` ( `tournament`,`tournament_match_index`,`match`,`create_date`,`update_date` ) VALUES
 ( 1, 1, 1, NOW(), NOW() ),
 ( 1, 2, 2, NOW(), NOW() ),
 ( 1, 3, 3, NOW(), NOW() ),
 ( 1, 4, 4, NOW(), NOW() ),
 ( 1, 5, 5, NOW(), NOW() ),
 ( 1, 6, 6, NOW(), NOW() ),
 ( 1, 7, 7, NOW(), NOW() ),
 ( 1, 8, 8, NOW(), NOW() ),
 ( 1, 9, 9, NOW(), NOW() ),
 ( 1, 10, 10, NOW(), NOW() ),
 ( 1, 11, 11, NOW(), NOW() ),
 ( 1, 12, 12, NOW(), NOW() ),
 ( 1, 13, 13, NOW(), NOW() ),
 ( 1, 14, 14, NOW(), NOW() ),
 ( 1, 15, 15, NOW(), NOW() ),
 ( 2, 1, 16, NOW(), NOW() ),
 ( 2, 2, 17, NOW(), NOW() ),
 ( 2, 3, 18, NOW(), NOW() ),
 ( 2, 4, 19, NOW(), NOW() ),
 ( 2, 5, 20, NOW(), NOW() ),
 ( 2, 6, 21, NOW(), NOW() ),
 ( 2, 7, 22, NOW(), NOW() ),
 ( 2, 8, 23, NOW(), NOW() ),
 ( 2, 9, 24, NOW(), NOW() ),
 ( 2, 10, 25, NOW(), NOW() ),
 ( 2, 11, 26, NOW(), NOW() ),
 ( 2, 12, 27, NOW(), NOW() ),
 ( 2, 13, 28, NOW(), NOW() ),
 ( 2, 14, 29, NOW(), NOW() ),
 ( 2, 15, 30, NOW(), NOW() );

