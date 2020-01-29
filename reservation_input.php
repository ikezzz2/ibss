<?php
	include('seat_class.php');
	$seat = new seat_class();
	$nomi = $seat->get_nomihoudai();
	if(!isset($_POST["reservation_info"])){
		echo "手順が誤っています。やり直してください";
		echo "	<form action='toppage.php'  method='post'>";
		echo "<input type='submit' value='TOPに戻る'   >";
		echo "</form>";
}else{


	if(isset($_POST["resid"])){
		$arraykey= array_keys($_POST["resid"]);
		$row =	$seat->get_reservation($_POST["resid"][$arraykey[0]]);
	}
?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>座席使用状況</title>
	<link rel = "stylesheet" type = "text/css" href = "reservation.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
		<script type="text/javascript">
			function setfintime(){
				var form1 = document.getElementById("select");
				var	form2 = document.getElementById("fin");
				var	form3 = document.getElementById("start");

				if(form1.value != "none"){
					<?php echo "var nomitime = []";?>;
					<?php foreach ($nomi as $key ){
						echo "nomitime.push(".$key['nomitime'].");";
					}
				 	?>
					hour =	form3.value.substr(0,2);
					console.log(hour);

					hour = Number(hour) + Number(nomitime[form1.selectedIndex - 1]);
					if(hour > 23){
						form2.value = "23:59";
					}else{

					if(hour < 10){
						hour = "0" + String(hour);
					}else{
						hour = String(hour);
					}
					form2.value = hour + ":" + form3.value.substr(3,2);
					}
				}
			}

			function time_move1(id){
				var id1 = "start";
				var id2 = "fin";
				var form1 = document.getElementById(id1);
				var form2 = document.getElementById(id2);
				var form3 = document.getElementById("select");

				if( form1.value > form2.value ){
					if(form3.value == "none"){
					min = Number(form1.value.substr(3,2)) + 1;
				}else{
					min = Number(form1.value.substr(3,2));
				}
					hour =	form1.value.substr(0,2);
					if(min < 10){
						min = "0"+String(min);
					}else if(min == 60){
						hour =	Number(hour);
						hour ++;
						hour = String(hour);
						min = "00";
					}
					form2.value = hour +":"+String(min) ;
				}
				if(form3.value != "none"){
					setfintime();
				}
			}
		</script>
</head>
<body id="edit">
	<form action='reservation_seat.php'  method='post'>
		<?php
		if(isset($_POST["resid"])){
			echo "<input type = 'hidden' name =resid[".$arraykey[0]."] value = ".$_POST["resid"][$arraykey[0]].">";
		}
		?>
    <?php echo $_POST["reservation_info"]["date_info"]
		 ?><br>
		<input type= "hidden" name = reservation_info[date_info] value = <?php print_r($_POST['reservation_info']['date_info'])?>>
		<dl>
    <dt>名前</dt>
		<dd><input class="bx" type = "text" name = reservation_info[name]
		<?php
		if(isset($_POST["resid"])){
			echo "value = ".htmlentities($row[0]["name"]);
		}
		?>
		 required><dd><br>
    <dt>電話番号</dt>
		<dd><input class="bx" type = "number" name = reservation_info[phonenumber] max = 999999999 min = 000000000
		<?php
		if(isset($_POST["resid"])){
			echo "value = ".$row[0]["phonenum"];
		}
		?>
		required></dd><br>
    <dt>人数</dt>
		<input class="bx" type = "number" name = reservation_info[people]
		<?php
		if(isset($_POST["resid"])){
			echo "value = ".$row[0]["numofpeople"];
		}
		?>
	 	max = 50 min = 1  required><br>
		<dt>飲み放題コース</dt>
  <dd><select class="bx" name=reservation_info[example] id = "select" onchange="setfintime()"  required></dd>
  <option value="none">なし</option>
  <?php
  foreach ($nomi as $key ) {
    echo "<option value='".$key["couseid"]."'";
		if(isset($_POST["resid"])){
			if($key["couseid"] == $row[0]["couseid"]){
				echo "selected";
			}
		}
		echo " onClick = 'setfintime()'; >".$key["couseid"]."</option>";
  }
    ?>
</select><br>
<dt>開始時間</dt>
 <dd><input class="bx" type = "time" name = reservation_info[starttime]
<?php
if(isset($_POST["resid"])){
	echo "value = ".substr($row[0]["starthour"],11,5);
}
?>
 onchange='time_move1(this.id)' id = "start" required ></dd><br>
 <?php
 if(isset($_POST["resid"])){
	 echo '<input type = "hidden" name = realtime value = '.substr($row[0]["starthour"],11,5).' >';
 }
 ?>


<dt>終了時間</dt>
<dd><input class="bx" type = "time" name = reservation_info[finishtime]
<?php
if(isset($_POST["resid"])){
	echo "value = ".substr($row[0]["finhour"],11,5);
}
?>
 onchange='time_move1(this.id)' id = "fin" required></dd><br>

<input type= "hidden" name = reservation_info[return] value = <?php echo "'".$_POST["reservation_info"]["return"]."'" ?>>
<?php
	if($_POST["reservation_info"]["return"] == 0){
?>
	<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
  <input class="btn" type="submit" value = "戻る" formaction="today_reservation_check.php" formnovalidate >
	<?php
}else if ($_POST["reservation_info"]["return"] == 1){
	?>
		<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
		<input class="btn" type="submit" value = "戻る" formaction="day_input_reservation_check.php" formnovalidate >
	<?php
}else{
	?>
	<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
	<input class="btn" type="submit" value = "戻る" formaction="reservation_edit.php" formnovalidate >
	<?php
	}
	?>
	<input id="btnR" class="btn" type="submit" value="次へ" id = "sub" required >
</form>
<?php }?>
</body>
</html>
