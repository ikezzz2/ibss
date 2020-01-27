<?php
	include('seat_class.php');
	$seat = new seat_class();
	if(!isset($_POST["reservation_info"])){
		echo "手順が誤っています。やり直してください";
		echo "	<form action='toppage.php'  method='post'>";
		echo "<input type='submit' value='TOPに戻る'   >";
		echo "</form>";
}else{
  $seatnums = $seat->get_number_of_seat();
  $seatlist =$seat->get_seat_list();
  $row =$seat->check_seat($_POST);
	$arraykey= array_keys($_POST["reservation_info"]);
?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>予約座席選択</title>
	<link rel = "stylesheet" type = "text/css" href = "reservation.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
		<script type="text/javascript">
		window.addEventListener("load", function(){
			check();
		}, false);

			function check(){
				var form1= document.getElementById("seatsub");
				var flag = false;
				form1.disabled = true;
				console.log(form1);
				for (var i = 0; i < <?php echo $seatnums?>; i++) {
					console.log(document.seat.elements[i].checked  );
				if(document.seat.elements[i].checked == true){
						flag = true;
						form1.disabled = false;
						break;
				}
			}
		}
		</script>
</head>
<body>
	<form action='reservation_check.php'  method='post' name = "seat">


		<table border="1">
			<tr>
      <th>席番号</th>
      <th></th>
    </tr>
    <tr>
    <?php
		$i = 0;
	  foreach ($seatlist as $key ) {
      if(!in_array($key, $row)){
			echo "<tr><td>".$key["seatnum"]."<td>";
			echo "<input type='checkbox' name= seatnum[] value='".$key["seatnum"]."'  onclick='check()' ></tr></td>";
    }else if(isset($_POST["resid"] )){
			$reskey = array_keys($_POST["resid"]);
				if(substr($reskey[0],8,2) == $key["seatnum"]){
					echo "<tr><td>".$key["seatnum"]."<td>";
					echo "<input type='checkbox' name= seatnum[] value='".$key["seatnum"]."' checked = 'checked' onclick='check()' ></tr></td>";
				}
		}
		$i++;
	}
      ?>
  </select>
	</table>
	<?php
	if(isset($_POST["resid"])){
		$arraykeyres= array_keys($_POST["resid"]);
		echo "<input type = 'hidden' name =resid[".$arraykeyres[0]."] value = ".$_POST["resid"][$arraykeyres[0]].">";
		echo '<input type = "hidden" name = realtime value = "'.$_POST["realtime"].'">';
	}
	?>
	<?php foreach ($arraykey as $key){
			echo    " <input type= 'hidden' name = 'reservation_info[".$key."]'' value = ".$_POST["reservation_info"]["$key"] .">";
	} ?>
	<br>
	<br>
	<input class="btn" type="submit" value="戻る"  formaction="reservation_input.php" >
	<input class="btn" type="submit" value="次へ"   id = seatsub disabled="disabled">
	<? } ?>
</body>
</html>
