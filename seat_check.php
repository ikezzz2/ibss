<?php
	include('seat_class.php');
	$seat = new seat_class();
?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>座席使用状況</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
		<link rel="stylesheet" href="seat_check.css">
</head>
<body>
	<form action='today_reservation_check.php' name='seat_check' method='post'>
		<br>
		<br>
	<input type="submit" class="btn" value="戻る"  formaction="toppage.php">

	<?php
		$seat->write_seat_check();//出力
	?>
	<br>
	<br>
	<input type = "hidden" name = "res">
	<input id="btnL" class="btn" type="submit" value="今日の予定" >
	<input id="btnR" class="btn" type="submit" value="カレンダー"  formaction="day_input.php">
</body>
</html>
