
<?php
  //check_login_ownerのメソッド部分
    if(isset($_POST["exe"])){

    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'ibss';
    $check = false;

    $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
        $name = $_POST['pass'];
        $pdo = new PDO($link, $db_username, $db_password);
        $sql = "SELECT * FROM ownerinfo";
        $stmt = $pdo->query($sql);
        while($row = $stmt->fetch()){

          if($row['id'] == 0 && htmlspecialchars($row['password'],ENT_QUOTES,'UTF-8') == $name){
            $check = true;
          }

        }
        if($check){
          //echo 'ログインできました';
          header("location: menutop_edit.php");
        }else{
          //echo 'ログインできませんでした';
          header("location: login_owner.php?A=".urlencode('もう一度入力してください'));
        }
      }

?>


<?php
  if(isset($_GET['A'])){
    $message = $_GET['A'];
    $alert = "<script type='text/javascript'>alert('".$message."');</script>";
    echo $alert;
  }
?>

  <html>
  <head>
  <title>ログイン</title>
  <meta charset="utf-8">
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h1 style="padding-left: 10px;">メニュー編集へログイン</h1>
    <!--generate_login_inputとwrite_login_inputのメソッド部分-->
    <form method="post" action="login_owner.php"> <?php //action="check_login_owner.php" ?>
      <p style="padding-right: 10px;">
      <input type="password" id="pass_input" name="pass" placeholder="パスワードを入力" required>
    </p>
      <br>
      <br>
      <br>
      <p style="padding-right: 10px;">
      <input type="submit" class="btn" id="btn" name="exe" value="ログイン">
    </p>
    </form>

    <form name='top'>
      <p style="padding-right: 340px;">
    <input type="submit" class="btn" id="btn" name="top" value="TOPへ" onClick="form.action='toppage.php';return true">
  </p>
  </center>
  </body>
</html>
<style>
input, button, textarea, select {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}

body{
  position:relative;
  text-align: center;
  color: #000000;
}

.btn {
  display: inline-block;
  text-align: center;
  padding: 0.5em 1em;
  font-size: 25px;
  text-decoration: none;
  background: #668AD8;/*ボタン色*/
  color: #FFF;
  border-bottom: solid 4px #627295;
  border-radius: 3px;
  width: 140px;
  height: 80px;
  }
.btn:active {
  /*ボタンを押したとき*/
  -webkit-transform: translateY(4px);
  transform: translateY(4px);/*下に動く*/
  border-bottom: none;/*線を消す*/
}

h1{
  font-size:5vw;
}
/*input[type="submit"]{
  position:absolute;
  background-color: #0066FF;
  color: #ffffff;
  width:15%;
  height:10%;
  font-size: 2vw;
  border-radius: 20px;
}*/
input[type="submit"]{
  position:absolute;
  /*background-color: #0066FF;
  color: #ffffff;*/
  /*border-radius: 20px;*/
  text-decoration: none;
  background: #668AD8;/*ボタン色*/
  color: #FFF;
  border-bottom: solid 4px #627295;
  border-radius: 3px;
}


input[type="password"]{
  width:400px;
  height:50px;
  font-size:3vw;
}
</style>
