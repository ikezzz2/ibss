<?php
	include('seat_class.php');
	$seat = new seat_class();
  $seatnums = $seat->get_number_of_seat();
  $seatlist =$seat->get_seat_list();
	if(!isset($_POST["reservation_info"])){
		echo "手順が誤っています。やり直してください";
		echo "	<form action='toppage.php'  method='post'>";
		echo "<input type='submit' value='TOPに戻る'   >";
		echo "</form>";
}else{
?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>座席使用状況</title>
	<link rel = "stylesheet" type = "text/css" href = "reservation.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
		<style media="screen">
	        .float_test{
	          float: left;
	        }
	        .float_none{
	          clear:both;
	        }

	      </style>

</head>
<body>
	<form action='reservation_edit.php' name='seat_check' method='post' id = seatsub>
	<div>
	<?php
	print_r("<input type= 'hidden' name = reservation_info[return] value = ".$_POST["reservation_info"]["return"] .">");
	print_r("<input type= 'hidden' name = reservation_info[date_info] value = ".$_POST["reservation_info"]["date_info"] .">");

  $key = array_keys($_POST["resid"]);
 	echo "<table border=`1` width=`5000` cellspacing=`0` cellpadding=`5` bordercolor=`#333333` >";
 	echo "<tr><th>名前</th><th>日付</th><th>開始時間</th><th>終了時間</th></tr>";
		foreach ($key as $akey) {
        $row = $seat->delete_check($akey);
				echo "<tr><td>" .$row[0][2]. "</td><td>".substr($row[0][5],0,10)."</td><td>".substr($row[0][5],11,8)."</td><td>".substr($row[0][6],11,8)."</td></tr>";
		//		echo "<input type = 'checkbox' name =  'resid[".substr($key["starthour"],11,8)."".$key['seatnum']."]' value =".substr($key["starthour"],11,8)."".$key['seatnum']." onclick = 'check()'  >";

		}
	?>
</table>
上記の予約を削除します
	<br>
	<div style="display:inline-flex">
	<input class="btn" type="submit" value="戻る"  formaction="reservation_edit.php">
</form>
<form action='reservation_edit.php' name='seat_check' method='post' id = seatsub>

	<?php
	print_r("<input type= 'hidden' name = reservation_info[return] value = ".$_POST["reservation_info"]["return"] .">");
	print_r("<input type= 'hidden' name = reservation_info[date_info] value = ".$_POST["reservation_info"]["date_info"] .">");
	foreach ($key as $akey) {
			$row = $seat->delete_check($akey);
			echo "<input type = 'hidden' name = delid[".$akey."] value = ".$akey.">";
	}
	?>
	<input id="btnR" class="btn" type="submit" value="削除" >
<?php }?>
</form>
</div>
</body>
</html>
