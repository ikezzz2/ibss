<?php
	include('seat_class.php');
	$seat = new seat_class();
	if(isset($_POST["update"])){
		if(isset($_POST["resid"])){
			$seat->update_reservation($_POST["resid"],$_POST);
			$size = sizeof($_POST["seatnum"]);

			if(sizeof($_POST["seatnum"]) > 1){
				 $POST = [
					 "reservation_info" => $_POST["reservation_info"],
					 "seatnum"	=> array_slice($_POST["seatnum"],1)
				 ];
				 $seat->insertreservation($POST);
				 echo "<br>";
			}
		}else{
		$seat->insertreservation($_POST);
		}
	}

  $seatnums = $seat->get_number_of_seat();
  $seatlist =$seat->get_seat_list();
  $row = $seat->today_reservation_check($seatlist[1]["seatnum"]);
  $check = -1;
  ?>
<!--座席情報確認画面-->
<!DOCTYPE html>
<html>
<head>
	<title>本日の座席時間割</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8">
	  <meta http-equiv="Content-Script-Type" content="text/javascript">
		<link rel="stylesheet" href="today_reservation_check.css">

    <script type="text/javascript">
<!--
window.addEventListener("load", function(){
  baseset( <?php echo $seatnums ?> );
    <?php
    for($i = 1;$i <= 10;$i++){
      ?>
      draw_seat_num(<?php echo $i ?>);
    <?php
    }
    ?>
    draw_reservation();
}, false);

function draw_reservation(){
  var canvas3 = document.getElementById('sample1');
  var context3 = canvas3.getContext('2d');
  if (canvas3.getContext) {
  <?php
  for($j = 0;$j < $seatnums;$j++){
  $row = $seat->today_reservation_check($seatlist[$j]["seatnum"]);
  foreach ($row as $reservation) {
  $start_hour = 0;
  $start_minute = 0;
  $finish_hour = 0;
  $finish_minute = 0;
  //print_r($row);

  if(count($reservation) != 0){
    $check = $seatlist[$j]["seatnum"];
    $start_hour = substr($reservation["starthour"],11,2);
		$start_minute = substr($reservation["starthour"],14,2);
		if($start_hour < date("H") - 1){
			$start_hour = date("H") - 1;
			$start_minute = 0;
		}
    $finish_hour = substr($reservation["finhour"],11,2);
    $finish_minute = substr($reservation["finhour"],14,2);

   ?>

    var start_hour = <?php echo $start_hour ?>;
    var start_minute = <?php echo $start_minute ?>;
    var finish_hour = <?php echo $finish_hour ?>;
    var finish_minute = <?php echo $finish_minute ?>;
    hours = new Date().getHours() ;
    var rect_hour = start_hour - hours   ;
    var rect_finish = finish_hour - start_hour;
    context3.fillStyle="silver";
    context3.fillRect(200*( 2 + rect_hour + (start_minute / 60)) - 150,40 + (90*(<?php echo $seatlist[$j]["seatnum"] ?> - 1)),200 * (rect_finish +  (finish_minute / 60)) - 5,50);
    context3.fillStyle="black";
    context3.strokeRect(200*( 2 + rect_hour + (start_minute / 60))-150,40 + (90*(<?php echo $seatlist[$j]["seatnum"] ?> - 1)),200 * (rect_finish +  (finish_minute / 60)) - 5,50);
    context3.font = "30px serif";
    context3.fillText(<?php echo "'".$reservation["name"]."'"; ?>, 200*( 2 + rect_hour + (start_minute / 60)) + 10-150 , 40 + (90*(<?php echo $seatlist[$j]["seatnum"] ?> - 1)) + 35);
    <?php }
  }

  }?>
  }

}
function draw_seat_num(seat_number){
  var canvas2 = document.getElementById('sample1');
  if (canvas2.getContext) {
    var context2 = canvas2.getContext('2d');
    var seat_of_num = <?php echo $seatnums; ?>;
    context2.font = "30px serif";
    for(var i = 0 ; i < seat_of_num ; i++ ){
      context2.fillText(seat_number, 10, (70 +((seat_number - 1) * 90)));
    }
  }
}


function baseset(number_of_seat) {
//描画コンテキストの取得
var canvas = document.getElementById('sample1');
if (canvas.getContext) {
  var context = canvas.getContext('2d');
  canvas.height = 900 ;
  canvas.width = 1200 ;
  hours = new Date().getHours() ;
  var height = canvas.height ;
  var width = canvas.width ;
  for(var j = 50;j <= width -100  ; j += 200){
    jj = j + 150;
    context.font = "30px serif";
    settime = hours + ((jj / 200) - 2)
    if(settime > 24){
      break;
    }
    context.fillText(settime, j, 30);
    for(var i = 60 ;i < height ; i += 20){
      context.beginPath();
      //パスの開始座標を指定する
      context.moveTo(j,i - 10);
      //座標を指定してラインを引いていく
      context.lineTo(j,i);
      //パスを閉じる（最後の座標から開始座標に向けてラインを引く）
      context.closePath();
      //現在のパスを輪郭表示する
      context.stroke();
      }
    }
    settime = hours +  4;
    for(var i = 30;i < height ; i += (height/number_of_seat) ){
      if(hours + (j / 200) - 3 >= 24){
        context.strokeRect(50,i,200 * (settime - hours -1) ,60);
      }else{
        context.strokeRect(50,i,1000,60);
      }
    }
  }
}
//-->
</script>
</head>
<body -webkit-text-size-adjust: 100%;>
	<br>
	<br>
	<h1>
<?php
echo date("Y-m-d");
?>
</h1>
	<center>
  <?php $seat->today_reservation_check(1) ?>
  <div id="sample">

  <h2 style="padding-right: 200px;">座席時間割<h2><br>

  <canvas id="sample1" >
		  </div>
		<form action='reservation_input.php'  method='post'>
		<input type= "hidden" name = reservation_info[date_info] value = <?php echo date("Y/m/d") ?>>
		<input type= "hidden" name = reservation_info[return] value = 0>
		<input type = "hidden" name = "res">
<div>
	<p style="padding-right: 90px;">
		<input type="submit" class="btn" id="btn" value="戻る"  formaction="seat_check.php" >
		<input type="submit" class="btn" id="btn" value="予約"  >
		<input type="submit" class="btn" id="btn" value="編集" formaction="reservation_edit.php" >
	</p>
	</div>
</center>
</body>
</html>
