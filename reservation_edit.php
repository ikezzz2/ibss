<?php
	include('seat_class.php');
	$seat = new seat_class();
	if(!isset($_POST["reservation_info"])){
		echo "手順が誤っています。やり直してください";
		echo "	<form action='toppage.php'  method='post'>";
		echo "<input class='btn' type='submit' value='TOPに戻る'   >";
		echo "</form>";
}else{
  $seatnums = $seat->get_number_of_seat();
  $seatlist =$seat->get_seat_list();
	if(isset($_POST["delid"])){
		foreach ($_POST["delid"] as $key) {
			$seat->reservation_delete($key);
		}
	}

  if (isset($_POST["nameupdate"])) {
    $reskey = array_keys($_POST["resid"] );
    foreach ($seatlist as $key) {//座席番号
      $reservation =$seat->generate_reservation_edit($key[0],$_POST["reservation_info"]["date_info"]);//その座席番号の予約を取ってくる
      foreach ($reservation as $judge ) {//予約一つに対して
        foreach ($reskey as $res) {//入力されたもの
          $s =substr($res,8,2);
          $starthour = substr($_POST["reservation_info"]["date_info"],0,4)."-".substr($_POST["reservation_info"]["date_info"],5,2)."-".substr($_POST["reservation_info"]["date_info"],8,2);
          $starthour .= " ".substr($res,0,8);
          if($key[0] == $s  && $judge["starthour"] == $starthour){//residについてる座席番号,開始時間と比較
            if($_POST["resid"][$res] != $judge["name"]){
              $seat->updatename($res,$_POST["resid"][$res],$_POST["reservation_info"]["date_info"]);
            }
          }
        }
      }
    }
  }

?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>座席使用状況</title>
	<link rel = "stylesheet" type = "text/css" href = "reservation.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
  <style media="screen">
        .float_test{
          float: left;
        }
        .float_none{
          clear:both;
        }

      </style>

			<script type="text/javascript">
			window.addEventListener("load", function(){
				check();
			}, false);

				function check(){
					var form1= document.getElementById("delsub");
					form1.disabled = true;
					console.log(form1);
					for (var i = 0; i <document.seat.elements.length;i++) {
					if(document.seat.elements[i].checked){
							form1.disabled = false;
							break;
					}
				}
			}
			</script>

</head>
<body>
  <div class = "float_test">

  <form action=''  method='post' id = "all">

    <?php
    /*  echo "	<form action=''  method='post' id = ".substr($key["starthour"],11,5)."".$key['name'].">";
      echo "    ";
      $arraykey= array_keys($key);
      foreach ($arraykey as $key2 ) {
        print_r("<input type= 'hidden' name = reservation_info[".$key2."] value = ".$key[$key2] .">");
        echo 	"<input type='submit' value='編集' >";
      }
    */
		$resnum = 0;
    foreach ($seatlist as $seatnum ) {
    $row =$seat->generate_reservation_edit($seatnum[0],$_POST["reservation_info"]["date_info"]);
    if($row == NULL){
      continue;
    }else{
			$resnum ++;
      echo "座席番号:".$seatnum[0]."<br>";
    }
    foreach ($row as $key){

      print_r("<input type= 'hidden' name = reservation_info[return] value = ".$_POST["reservation_info"]["return"] .">");
      print_r("<input type= 'hidden' name = reservation_info[date_info] value = ".$_POST["reservation_info"]["date_info"] .">");
      echo "<input class='bx' type = 'text' name =  'resid[".substr($key["starthour"],11,8)."".$key['seatnum']."]' value =".$key['name']." form = 'all'>";
			echo substr($key["starthour"],10,6)."〜";
      echo substr($key["finhour"],10,6);
			echo "<br>";
			echo "</form>";


      }
			echo "<br>";

    }
		if($resnum == 0){
			echo "予約がありません。";
				if($_POST["reservation_info"]["return"] == 0){
			?>

				<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
			  <input class="btn" type="submit" value = "戻る" formaction = "today_reservation_check.php"  form = "all">
				<?php
			}else{
				?>
					<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
					<input class="btn" type="submit" value = "戻る" formaction = "day_input_reservation_check.php"  form = "all">
				<?php
				}
		}else{
?>
  </div>
  <div class = "float_test">
    <?php
    //編集
    foreach ($seatlist as $seatnum ) {
    $row =$seat->generate_reservation_edit($seatnum[0],$_POST["reservation_info"]["date_info"]);
    if($row == NULL){
      continue;
    }
		echo "<br>";
		echo "<div>";//aaa
    foreach ($row as $key){

      echo "  <form action='reservation_input.php'  method='post'  >";
      print_r("<input type= 'hidden'  name = reservation_info[return]  value = ".$_POST["reservation_info"]["return"] .">");
			echo '<input type= "hidden" name = reservation_info[return] value = 2>';

		  print_r("<input type= 'hidden'  name = reservation_info[date_info] value = ".$_POST["reservation_info"]["date_info"] .">");
      echo "<input type = 'hidden'  name =  'resid[".substr($key["starthour"],11,8)."".$key['seatnum']."]' value =".substr($key["starthour"],11,8)."".$key['seatnum']." >";

  /*  $arraykey= array_keys($key);
    foreach ($arraykey as $key2 ) {
      print_r("<input type= 'hidden' name = reservation_info[".$key2."] value = ".$key[$key2] .">");
      }
      */
			//echo "<br>";
      print_r("<input class='btnE' type= 'submit' value = '編集'>");
      echo "</form>";
    }
		echo "<br>";
		echo "</div>";//aaaa
    echo "<br>";
  }
    ?>

  </div>

  <div class = "float_test">
    <?php
		echo "  <form action='reservation_delete.php'  method='post' id = 'del'  name = 'seat'>";
		print_r("<input type= 'hidden' name = reservation_info[return] value = ".$_POST["reservation_info"]["return"] .">");
		print_r("<input type= 'hidden' name = reservation_info[date_info] value = ".$_POST["reservation_info"]["date_info"] .">");

	  foreach ($seatlist as $seatnum ) {
    $row =$seat->generate_reservation_edit($seatnum[0],$_POST["reservation_info"]["date_info"]);
    if($row == NULL){
      continue;
    }
		echo "<div>";//aaaaa
    foreach ($row as $key){
    $arraykey= array_keys($key);

		echo "<br>";
      echo "<input class='chekbox' type = 'checkbox' name =  'resid[".substr($key["starthour"],11,8)."".$key['seatnum']."]' value =".substr($key["starthour"],11,8)."".$key['seatnum']." onclick = 'check()'  >";

    }
		echo "<br>";
		echo "</div>";//aaaaa

    echo "<br>";
    }
    echo "</div>";
    echo '<div class = "float_none">';
    echo  "<input class='btn' type='submit' value = '削除' disabled='disabled' id = 'delsub'>";
    echo "</form>";
    ?>



<input type= 'hidden' name = nameupdate form = "all">
<input type= "hidden" name = reservation_info[return] value = <?php echo "'".$_POST["reservation_info"]["return"]."'" ?>>
<?php
	if($_POST["reservation_info"]["return"] == 0){
?>
	<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
  <input class="btn" type="submit" value = "戻る" formaction = "today_reservation_check.php"  form = "all">
	<?php
}else{
	?>
		<input type= "hidden" name = reservation_info[date_info] value = <?php echo "'".$_POST["reservation_info"]["date_info"]."'" ?>>
		<input class="btn" type="submit" value = "戻る" formaction = "day_input_reservation_check.php"  form = "all">

	<?php
	}
	?>


<input class="btn" type='submit' value='確認' form = "all">
</div>
	<br>
</form>
<?php }
} ?>
</body>
</html>
