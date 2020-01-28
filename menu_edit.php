<?php
    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'dbpractice';
    
    //menu_editのメソッド部分
        if(isset($_GET["edit"]) && isset($_GET["edit_menu"]) && isset($_GET["edit_value"]) && isset($_GET["edit_category"])){ //&& isset($_GET["befor_menu"])){
            $edit_menu = $_GET['edit_menu'];
            $edit_value = $_GET['edit_value'];
            $edit_category = $_GET['edit_category'];
            $b_menu = $_GET['befor_menu'];
            for($i = 0; $i < count($b_menu); $i++){
                $befor_date[] = explode(",",$b_menu[$i]);
            }
            
            $arrayEdit[] = array();
            for($i = 0; $i < count($edit_menu); $i++){
                $arrayEdit[$i][] = $edit_menu[$i];
                $arrayEdit[$i][] = $edit_category[$i];
                $arrayEdit[$i][] = $edit_value[$i];
                print_r($arrayEdit[$i]);
                echo "　　";
                print_r($befor_date[$i]);
                echo "<br /><br />";
                
            }

            $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
            $pdo6 = new PDO($link, $db_username, $db_password);

            for($i = 0; $i < count($edit_menu); $i++){
                if(!($arrayEdit[$i][0] == $befor_date[$i][0] && $arrayEdit[$i][1] == $befor_date[$i][1] && $arrayEdit[$i][2] == $befor_date[$i][2])){
                    $sql6 = 'UPDATE menutable SET productname = "'.$arrayEdit[$i][0].'", category = "'.$arrayEdit[$i][1].'", value = "'.$arrayEdit[$i][2].'" WHERE productname = "'.$befor_date[$i][0].'" AND category = "'.$befor_date[$i][1].'" AND value = "'.$befor_date[$i][2].'";';
                    echo "<br />";
                    print_r($sql6);
                    $stmt6 = $pdo6->query($sql6);
                }
            }
            header("location: menutop_edit.php?A=".urlencode('メニュー情報を更新しました'));
        }else
    

    
    //従来のデータから変更があるか、そもそもデータがあるかの確認処理
    if(isset($_GET["edit1"])){
        if(isset($_GET["editmenu"]) && isset($_GET["editvalue"]) && isset($_GET["moto_date"])){
            $editcheck_menu = $_GET["editmenu"];
            $editcheck_value = $_GET["editvalue"];
            $m_date = $_GET["moto_date"];
            //print_r($editcheck_menu);

            $edit_check = true;
            
            //while($row = $stmt->fetch()){
              //  $menu_date[] = $row;
            //}

            for($i = 0; $i < count($m_date); $i++){
                $moto_date[] = explode(",",$m_date[$i]);
            }
            //print_r($moto_date);
            //echo count($editcheck_menu);

            for($i = 0; $i < count($moto_date); $i++){
                //echo $moto_date[$i][1]."　".$moto_date[$i][0]."　".$editcheck_menu[$i]."　".$moto_date[$i][2]."　".$editcheck_value[$i]."<br />";
                if($moto_date[$i][0] != $editcheck_menu[$i] || $moto_date[$i][2] != $editcheck_value[$i]){
                    $edit_check = false; 
                }
                for($j = 0; $j < count($editcheck_menu); $j++){
                    if($i != $j && $moto_date[$i][0] == $editcheck_menu[$j]) header("location: menutop_edit.php?A=".urlencode('同じメニュー名が存在しています'));
                }
            }
            if($edit_check) header("location: menutop_edit.php?A=".urlencode('更新情報が入力されていません'));
            //else echo 1;
            
        }else{
          header("location: menutop_edit.php?A=".urlencode('メニューデータがありません'));
        }  
    }else if(!isset($_GET["edit1"])) header("location: menutop_edit.php?A=".urlencode('更新情報が入力されていません..'));
    else echo 1;

?>
<html>
  <head>
  <title>更新</title>
  <meta charset="utf-8">
  </head>
  <body>
    <h1>これらのメニューを更新しますか</h1>
    <form method="get">
        <div class="show"> 
    <?php
         echo '<div class="menu_mei">メニュー名</div>';
         echo '<div class="menu_kin">金額</div>';
         echo "<br /><br />";
        $show_category="";
        echo '<div class="scroll">';
        for($i = 0; $i < count($moto_date); $i++){
            if($moto_date[$i][0] != $editcheck_menu[$i] || $moto_date[$i][2] != $editcheck_value[$i]){
                if($moto_date[$i][1] != $show_category){
                    $show_category = $moto_date[$i][1];
                    echo '<div class="cate">'.$show_category."</div>";
                    //echo "　　　　　メニュー名　　　　　　金額<br /><br />";
                }
                //check_editのメソッド部分
                //金額の入力内容をチェック
                if(!is_numeric($editcheck_value[$i]) || $editcheck_value[$i] <= 0 || strpos($editcheck_value[$i],'.')){
                  header("location: menutop_edit.php?A=".urlencode('金額は半角数字で入力してください'));
                }  
                //echo '<div class="change">変更前</div><div class="mei">'.$moto_date[$i][0].'</div><div class="kin">'.$moto_date[$i][2].'円</div><br /><div class="kaigyo"></div>';
                //echo '<div class="change">変更後</div><div class="mei">'.$editcheck_menu[$i].'</div><div class="kin">'.$editcheck_value[$i].'円</div><br /><br /><br /><div class="kaigyo"></div>';
                
                //echo "　変更前　".$moto_date[$i][0]."　　　　".$moto_date[$i][2]."円<br /><br />";
                //echo "　変更後　".$editcheck_menu[$i]."　　　　".$editcheck_value[$i]."円<br /><br /><br />";
                echo '<div class="kaigyo"></div>';
                echo "<table class='change1'><tr><td>変更前</td></tr><tr><td>変更後</td></tr></table>";
                //echo "<table class='date'><tr><td>".$moto_date[$i][0]."</td><td>".$moto_date[$i][2]."円</td></tr><tr><td>".$editcheck_menu[$i]."</td><td>".$editcheck_value[$i]."円</td></tr></table>";
                
                echo "<table class='date_menu'><tr><td>".$moto_date[$i][0]."</td></tr><tr><td>".$editcheck_menu[$i]."</td></tr></table>";
                if(strlen($editcheck_menu[$i]) <= strlen($moto_date[$i][0])) $moji = "calc(60% - ".strlen($moto_date[$i][0])."%)";
                else $moji = "calc(60% - ".strlen($editcheck_menu[$i])."%)";
                echo '<table class="date_value" style="position: relative; left: '.$moji.'"><tr><td>'.$moto_date[$i][2]."円</td></tr><tr><td>".$editcheck_value[$i]."円</td></tr></table>";
                

                $b_date = array($moto_date[$i][0],$moto_date[$i][1],$moto_date[$i][2]);
                
                $befor_date = implode(',', $b_date);
                echo '<input type="hidden" name="befor_menu[]" value="'.$befor_date.'">';
                echo '<input type="hidden" name="edit_menu[]" value="'.$editcheck_menu[$i].'">';
                echo '<input type="hidden" name="edit_value[]" value="'.$editcheck_value[$i].'">';
                echo '<input type="hidden" name="edit_category[]" value="'.$moto_date[$i][1].'">';
            }
        }
    echo "</div>";
    ?>
    </div>
    <footer>
        <input type="submit" class="edit" name="edit" value="更新" style="margin:10px 10px 10px 0px; float:left;" onClick="form.action='menu_edit.php';return true"> <?php //onClick="form.action='menu_edit.php';return true"?>
    </form>
    <form name="back">
    <?php
    for($i = 0; $i < count($moto_date); $i++){
        $tb = array($editcheck_menu[$i],$moto_date[$i][1],$editcheck_value[$i]);
        $topback = implode(',', $tb);
        echo '<input type="hidden" name="topback_date[]" value="'.$topback.'">';
        $topback_date2[] = $topback;
    }
    //print_r($topback_date2);
    ?>
        <input type="submit" class="menutop_back" name="menutop_back" value="戻る" style="margin:10px 10px 10px 0px; float:left;" formaction="menutop_edit.php">
    </form>
</footer>
</body>
</html>
<style>
    body{
  position:relative;
  /*text-align: center;*/
  color: #000000;
  font-size: 2vw
}
h1{
    text-align: center;
  font-size:4vw;
  color: #0066FF;
}
div.menu_mei{
    position:absolute;
    font-size:2vw;
    top: 8vw;
    left: 35%;
}
div.menu_kin{
    position:absolute;
    font-size:2vw;
    top: 8vw;
    left: 65%;
    float: left;
}
div.scroll {
    top: 12vw;
    font-size:2vw;
    position:absolute;
    left: 29%;
    width: 50%;
    height: 40%;
    overflow: scroll;
    overflow-x: hidden;
    }

div.change{
    position:absolute;
    top: 0.5vw;
    left: 30%;
}
div.mei{
    position:absolute;
    top: 0.5vw;
    font-size:2vw;
    left: 35%;
}
div.kin{
    position:absolute;
    top: 0.5vw;
    left: 65%;
    float: left;
}
.kaigyo {
    content: "\A";
		white-space: pre; /* ←あわせてこれを指定しないと改行しない場合があるらしい */
  }

div.cate{
    padding: 1vw 0vw;
}

footer input[type="submit"]{
  position:absolute;
  /*background-color: #0066FF;
  color: #ffffff;*/
  width:10%;
  height:7%;
  font-size: 2vw;
  /*border-radius: 20px;*/


  text-decoration: none;
  background: #668AD8;/*ボタン色*/
  color: #FFF;
  border-bottom: solid 4px #627295;
  border-radius: 3px;
}
input[type="submit"]:active {
  /*ボタンを押したとき*/
  -webkit-transform: translateY(4px);
  transform: translateY(4px);/*下に動く*/
  border-bottom: none;/*線を消す*/
}

.edit{
  /*margin:10px 10px 10px 0px;*/
  left:45%;
  top: 70%;
  margin-left:-2.5vw;
}

.menutop_back{
  /*margin:10px 10px 10px 0px;*/
  left:5%;
  top: 80%;
}

input[type="password"]{
  width:50%;
  height:10%;
  min-width:250px ;
  min-height:30px ;
  font-size:3vw;
}

table{
    font-size: 1.5vw;
}
table.change1 {
    left: 10%;
    float: left;
}
/*table.date{
    
}*/
table.change1 td{
    padding: 1vw 2vw 0vw 0vw;
}
/*table.date td{
    padding: 1vw 10vw 0vw 0vw;
}*/
table.date_menu td{
    padding: 1vw 0vw 0vw 0vw;
}
/*table.date_value{
    position: relative;
    left: 65%;
}*/
table.date_menu{
    position: relative;
    left: 0%;
    float:left;
}
table.date_value td{
    padding: 1vw 0vw 0vw 0vw;
}
    </style>