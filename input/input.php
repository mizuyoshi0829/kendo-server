<?php
//	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'common.php';
//	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'common'.DIRECTORY_SEPARATOR.'config.php';
	require_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.'page.php';

	$passtbl = array(
		'5qF7Quk8','YxTNddKl','eLVArBBp','aNetwpu4',
		'tf9QzSqQ','WnY1m37C','g9KdG7CI','MR3g6tB3'
	);

	session_start();
	if( !isset( $_SESSION['auth_input'] ) ){
		header( "Location: ".__HTTP_BASE__."input/login.php");
		exit;
	}
	$mode = get_field_string( $_POST, 'mode' );
	if( $mode == 'login' ){
		$pass = get_field_string( $_POST, 'pass' );
		$place = 1;
		foreach( $passtbl as $pv ){
			if( $pass == $pv ){
				$_SESSION['auth_input']['login'] = 1;
				$_SESSION['auth_input']['place'] = $place;
			}
			$place++;
		}
	}
	if( $_SESSION['auth_input']['login'] != 1 ){
		header( "Location: ".__HTTP_BASE__."input/login.php");
		exit;
	}

	$objPage = new form_page();
//	$place = get_field_string_number( $_GET, 'p', 1 );
	$match = get_field_string_number( $_GET, 'm', 1 );
	$data = $objPage->get_match_one_data_by_place( $_SESSION['auth_input']['place'], $match );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>試合結果入力フォーム</title>
<link href="main.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="content">
    <h1 align="left" class="tx-h1">第<?php echo $_SESSION['auth_input']['place'];?>試合場&nbsp;<?php if($match>1): ?><a href="input.php?p=<?php echo $place;?>&m=<?php echo ($match-1);?>">←前の試合</a>&nbsp;<?php endif; ?>第<?php echo $match;?>試合&nbsp;<a href="input.php?p=<?php echo $place;?>&m=<?php echo ($match+1);?>">次の試合→</a></h1>
    <div align="right">
      <input name="edit01" type="button" value="編集" />
    </div>
    <div align="center" class="tbscorein">
      <div style="width: 960px; padding: 4px; border: solid 1px #000000;">
        <div style="border: solid 0px #000000; overflow:hidden;">
        <tr>
          <div style="width: 240px; float: left; border: solid 1px #000000; padding: 4px;">{$list[datalist].name|escape}</div>
          <td colspan="2" class="tbprefname">学校名</td>
          <td class="tbprefname"><span class="tb_srect">先鋒</span></td>
          <td class="tbprefname"><span class="tb_srect">次鋒</span></td>
          <td class="tbprefname"><span class="tb_srect">中堅</span></td>
          <td class="tbprefname"><span class="tb_srect">副将</span></td>
          <td class="tbprefname"><span class="tb_srect">大将</span></td>
          <td class="tbprefnamehalf">代表戦</td>
          <td class="tbprefnamehalf">&nbsp;</td>
          <td class="tbprefnamehalf">勝敗</td>
        </tr>
        <tr>
          <td colspan="2" class="tbprefname"><?php echo $objPage->get_pref_name(null,intval($data['entry1']['s_pref']));?></td>
          <td class="tbprefname">○</td>
          <td class="tbprefname">△</td>
          <td class="tbprefname">○</td>
          <td class="tbprefname">△</td>
          <td class="tbprefname">△</td>
          <td>&nbsp;</td>
          <td><div align="center">本数</div></td>
          <td rowspan="6" class="tx-large">△</td>
        </tr>
        <tr>
          <td colspan="2" rowspan="5" class="tbprefname"><?php echo $data['entry1']['s_name'];?>中学校</td>
          <td class="tx-name"><?php echo $data['entry1']['dantai_sei_m1'];?></td>
          <td class="tx-name"><?php echo $data['entry1']['dantai_sei_m2'];?></td>
          <td class="tx-name"><?php echo $data['entry1']['dantai_sei_m3'];?></td>
          <td class="tx-name"><?php echo $data['entry1']['dantai_sei_m4'];?></td>
          <td class="tx-name"><?php echo $data['entry1']['dantai_sei_m5'];?></td>
          <td rowspan="2">
            <select name="a6name" class="tb_srect" id="a6name">
              <option value="1">-</option>
              <option value="2"><?php echo $data['entry1']['dantai_sei_m1'];?></option>
              <option value="3"><?php echo $data['entry1']['dantai_sei_m2'];?></option>
              <option value="4"><?php echo $data['entry1']['dantai_sei_m3'];?></option>
              <option value="5"><?php echo $data['entry1']['dantai_sei_m4'];?></option>
              <option value="6"><?php echo $data['entry1']['dantai_sei_m5'];?></option>

            </select>

          </td>
          <td rowspan="2"><div align="center">4</div></td>
        </tr>
        <tr>
          <td class="tx-name">
          <select name="a1fa" class="tb_srect" id="a1fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="a1fb" class="tb_srect" id="a1fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="a2fa" class="tb_srect" id="a2fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="a2fb" class="tb_srect" id="a2fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="a3fa" class="tb_srect" id="a3fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="a3fb" class="tb_srect" id="a3fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="a4fa" class="tb_srect" id="a4fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="a4fb" class="tb_srect" id="a41fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="a5fa" class="tb_srect" id="a5fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="a5fb" class="tb_srect" id="a5fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
        </tr>
        <tr>
          <td class="tb_srect">
           <select name="a1a" class="tb_srect" id="a1a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
</td>
          <td class="tb_srect">
          <select name="a2a" class="tb_srect" id="a2a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          
          </td>
          <td class="tb_srect">
            <select name="a3a" class="tb_srect" id="a3a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a4a" class="tb_srect" id="a4a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
			<select name="a5a" class="tb_srect" id="a5a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>          </td>
          <td rowspan="3">
          <select name="a61a" class="tb_srect" id="a6a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td>
          <div align="center">勝数</div>
          </td>
        </tr>
        <tr>
          <td class="tb_srect">
             <select name="a1b" class="tb_srect" id="a1b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select></td>
          <td class="tb_srect">
          <select name="a2b" class="tb_srect" id="a2b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a3b" class="tb_srect" id="a3b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a4b" class="tb_srect" id="a4b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a5b" class="tb_srect" id="a5b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td><div align="center">2</div>
          </td>
        </tr>
        <tr>
          <td class="tb_srect">
            <select name="a1c" class="tb_srect" id="a1c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a2c" class="tb_srect" id="a2c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a3c" class="tb_srect" id="a3c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a4c" class="tb_srect" id="a4c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tb_srect">
            <select name="a5c" class="tb_srect" id="a5c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="tbprefname"><?php echo $objPage->get_pref_name(null,intval($data['entry2']['s_pref']));?></td>
          <td class="tbprefname">△</td>
          <td class="tbprefname">○</td>
          <td class="tbprefname">△</td>
          <td class="tbprefname">○</td>
          <td class="tbprefname">○</td>
          <td>
          </td>
          <td><div align="center">本数</div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" rowspan="5" class="tbprefnamehalf"><span class="tbprefname"><?php echo $data['entry2']['s_name'];?>中学校</span></td>
          <td class="tx-name"><?php echo $data['entry2']['dantai_sei_m1'];?></td>
          <td class="tx-name"><?php echo $data['entry2']['dantai_sei_m2'];?></td>
          <td class="tx-name"><?php echo $data['entry2']['dantai_sei_m3'];?></td>
          <td class="tx-name"><?php echo $data['entry2']['dantai_sei_m4'];?></td>
          <td class="tx-name"><?php echo $data['entry2']['dantai_sei_m5'];?></td>
          <td>
              <select name="b6name" class="tb_srect" id="b6name">
              <option value="1">-</option>
              <option value="2"><?php echo $data['entry2']['dantai_sei_m1'];?></option>
              <option value="3"><?php echo $data['entry2']['dantai_sei_m2'];?></option>
              <option value="4"><?php echo $data['entry2']['dantai_sei_m3'];?></option>
              <option value="5"><?php echo $data['entry2']['dantai_sei_m4'];?></option>
              <option value="6"><?php echo $data['entry2']['dantai_sei_m5'];?></option>

            </select>

          </td>
          <td><div align="center">5</div></td>
          <td rowspan="5" class="tx-large">○</td>
        </tr>
        <tr>
          <td class="tbprefname">
          <select name="b1a" class="tb_srect" id="b1a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
         <select name="b2a" class="tb_srect" id="b2a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select> 
          </td>
          <td class="tbprefname">
          <select name="b3a" class="tb_srect" id="b3a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b4a" class="tb_srect" id="b4a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b5a" class="tb_srect" id="b5a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td rowspan="4">
          <select name="b6a" class="tb_srect" id="b6a">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td><div align="center">勝数</div></td>
        </tr>
        <tr>
          <td class="tbprefname">
          <select name="b1b" class="tb_srect" id="b1b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b2b" class="tb_srect" id="b2b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b3b" class="tb_srect" id="b3b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b4b" class="tb_srect" id="b4b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
            <select name="b5b" class="tb_srect" id="b5b">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
              <option value="反">4</option>
            </select>
          </td>
          <td><div align="center">3</div></td>
        </tr>
        <tr>
          <td class="tbprefname">
          <select name="b1c" class="tb_srect" id="b1c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b2c" class="tb_srect" id="b2c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b3c" class="tb_srect" id="b3c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
              <option value="反">4</option>
            </select>
          </td>
          <td class="tbprefname">
          <select name="b4c" class="tb_srect" id="b4c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
            </select>
          </td>
          <td class="tbprefname">
            <select name="b5c" class="tb_srect" id="b5c">
              <option value="1">-</option>
              <option value="2">メ</option>
              <option value="3">ド</option>
              <option value="4">コ</option>
              <option value="5">反</option>
              <option value="反">4</option>
            </select>
          </td>
          <td rowspan="2"></td>
        </tr>
        <tr>
          <td class="tx-name">
          <select name="b1fa" class="tb_srect" id="b1fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="b1fb" class="tb_srect" id="b1fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="b2fa" class="tb_srect" id="b2fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="b2fb" class="tb_srect" id="b2fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="b3fa" class="tb_srect" id="b3fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="b3fb" class="tb_srect" id="b3fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="b4fa" class="tb_srect" id="b4fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="b4fb" class="tb_srect" id="b41fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
          <td class="tx-name">
          <select name="b5fa" class="tb_srect" id="b5fa">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            <select name="b5fb" class="tb_srect" id="b5fb">
              <option value="1">-</option>
              <option value="2">▲</option>
            </select>
            </td>
        </tr>
      </table>
<table  class="tb_score_in" width="960" border="0">
        <tr>
          <td colspan="2" class="tbprefname">&nbsp;</td>
          <td colspan="3">
            <div align="center" class="tbprefname">
              <input type="checkbox" name="r-ab1" id="r-ab1" />
              <br />
            </div>
            <label for="r-ab1" class="tx-small">
              試合終了
          </label></td>
          <td colspan="3"><div align="center" class="tbprefname">
              <input type="checkbox" name="r-ab2" id="r-ab2" />
              <br />
            </div>
            <label for="r-ab2" class="tx-small">
              試合終了
          </label></td>
          <td colspan="3"><div align="center" class="tbprefname">
            <input type="checkbox" name="r-ab3" id="r-ab3" />
          </div>
            <label for="r-ab3" class="tx-small">
                試合終了
          </label></td>
          <td colspan="3"><div align="center" class="tbprefname">
            <input type="checkbox" name="r-ab4" id="r-ab4" />
          </div>
            <label for="r-ab4" class="tx-small">
                試合終了
          </label></td>
          <td colspan="3"><div align="center" class="tbprefname">
            <input type="checkbox" name="r-ab5" id="r-ab5" />
          </div>
            <label for="r-ab5" class="tx-small">
                試合終了
          </label></td>
          <td><div align="center" class="tbprefnamehalf">
            <input type="checkbox" name="r-ab6" id="r-ab6" />
          </div>
            <label for="r-ab6" class="tx-small">
              代表有
          </label></td>
          <td><div align="center" class="tbprefnamehalf">
            <input type="checkbox" name="r-ab7" id="r-ab7" />
          </div>
            <label for="r-ab7" class="tx-small">
              代表終了
          </label></td>
          <td>
          <input name="end01" type="submit" class="tbprefnamehalf" id="end01" value="終了" /></td>
        </tr>
      </table>
      <h2 align="left" class="tx-h1"><a href="index.html">←TOPに戻る</a></h2>
    <!-- end .content --></div>
  </div>
  <!-- end .container --></div>
</body>
</html>
