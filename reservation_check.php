<?php
	include('seat_class.php');
	$seat = new seat_class();
	if(!isset($_POST["reservation_info"])){
		echo "手順が誤っています。やり直してください";
		echo "	<form action='toppage.php'  method='post'>";
		echo "<input type='submit' value='TOPに戻る'   >";
		echo "</form>";
}else{
	$arraykey= array_keys($_POST["reservation_info"]);
?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>座席使用状況</title>
	<link rel = "stylesheet" type = "text/css" href = "reservation.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
</head>
<body>
	<form action='day_input_reservation_check.php'  method='post'>
		<?php
		if(isset($_POST["resid"])){
			$arraykeyres= array_keys($_POST["resid"]);
			count($_POST["seatnum"]  );

			echo "<input type = 'hidden' name =resid[".$arraykeyres[0]."] value = ".$_POST["resid"][$arraykeyres[0]].">";


			echo '<input type = "hidden" name = realtime value = "'.$_POST["realtime"].'">';
		}
		?>
		<?php foreach ($arraykey as $key){
				print_r("<input type= 'hidden' name = 'reservation_info[".$key."]'' value = ".$_POST["reservation_info"]["$key"] .">");
		} ?>
		<?php foreach ($_POST["seatnum"] as $key){
				echo    " <input type= 'hidden' name = 'seatnum[]' value = ".$key .">";
		} ?>
      名前:<?php print_r($_POST ["reservation_info"]["name"]) ?><br>
      電話番号:<?php print_r($_POST ["reservation_info"]["phonenumber"]) ?><br>
      人数:<?php print_r($_POST ["reservation_info"]["people"]) ?>人<br>
      <?php if($_POST ["reservation_info"]["example"] == "none"){?>
        飲み放題コース:なし<br>
      <?php
    }else{
      ?>
      飲み放題コース:<?php print_r($_POST ["reservation_info"]["example"]) ?><br>
      <?php
      }
      ?>
			席番号:<?php  foreach ( $_POST["seatnum"] as $value) {
				print_r($value . " ");
			}?><br>
      開始時間:<?php print_r($_POST ["reservation_info"]["starttime"]) ?><br>
      終了時間:<?php print_r($_POST ["reservation_info"]["finishtime"]) ?><br>
      <br>上記の内容で登録しますか？

	<br>
	<input class="btn" type="submit" value="戻る"  formaction="reservation_seat.php" >
	<?php
		if($_POST["reservation_info"]["return"] == 0){
	?>
		<input type= "hidden" name = update ?>
		<input id="btnR" class="btn" type="submit" value="確定"  formaction="today_reservation_check.php">
		<?php
	}else{
		?>
			<input class="btn" type= "hidden" name = update  ?>
			<input id="btnR" class="btn" type="submit" value="確定"  formaction="day_input_reservation_check.php">
		<?php
		}
	}
		?>
</body>
</html>
