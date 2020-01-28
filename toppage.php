<?php
      include('login_class.php');
      $login = new login_class();
      $login->ses_start();

      $login ->delete_yesterday();
      $login ->delete();


      if(isset($_POST["log_out"])){
        session_destroy();
        header("location:login_main.php");
      }
?>
​
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">

        <title>TOPページ</title>
        <link rel="stylesheet" href="toppage.css">
    </head>
    <body>
      <center>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    <h1 style="padding-right: 90px;">IBSS</h1>
    <form id="top_page" name="top_page" action="" method="POST">
        <div>
          <p style="padding-right: 100px;">
        <input type="submit" class="btn1" id="btn1" formaction="order_input.php" value="注文受付">
        <input type="submit" class="btn2" id="btn2" formaction="seat_check.php" value="座席状況">
        <input type="submit" class="btn3" id="btn3" formaction="order_management.php" value="注文管理">
      </p>
        <br>
        <p style="padding-right: 90px;">
        <input type="submit" class="btn4" id="btn4" formaction="seat_select.php" value="会計">
        <input type="submit" class="btn5" id="btn5" formaction="login_owner.php" value="メニュー編集">
      </p>
        </div>
​
  <p style="padding-left: 400px; padding-top: 160px" >
        <?php

            echo "<input type='submit' class='btn6' id='btn6' formaction='toppage.php' name='log_out' value='ログアウト'>"
        ?>
      </p>
    </form>
  </center>
    </body>
</html>