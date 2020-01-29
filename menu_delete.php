<?php
//menu_deleteのメソッド部分
if(isset($_GET["delete2"]) && isset($_GET["delete_menu"])){
    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'dbpractice';
    $delete_menu = $_GET["delete_menu"];
        
    $delete_menu = $_GET['delete_menu'];
    $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    $pdo5 = new PDO($link, $db_username, $db_password);
    $inClause = substr(str_repeat(',?', count($delete_menu)), 1);
    $sql5 = "DELETE FROM menutable WHERE productname IN ({$inClause})";
    $stmt5 = $pdo5->prepare($sql5);
    $stmt5 -> execute($delete_menu);
    header("location: menutop_edit.php?A=".urlencode('メニュー情報を削除しました'));

}else if(isset($_GET["checkslist"]) && $_GET["checkslist"] != NULL){ 
    //削除チェックボックスに保存されたメニュー名からメニューデータを取得
        $checklist = $_GET['checkslist'];

        $db_hostname    = 'localhost';
        $db_username    = 'root';
        $db_password    = '';
        $db_name        = 'dbpractice';

        $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
        $pdo3 = new PDO($link, $db_username, $db_password);
        $inClause = substr(str_repeat(',?', count($checklist)), 1);
        $sql3 = "SELECT * FROM menutable WHERE productname IN ({$inClause})";
        $sql4 = "SELECT DISTINCT category FROM menutable WHERE productname IN ({$inClause})";
        $stmt3 = $pdo3->prepare($sql3);
        $stmt3 -> execute($checklist);
        $stmt4 = $pdo3->prepare($sql4);
        $stmt4 -> execute($checklist);
        while($row3 = $stmt3->fetch()){
            $d1_menu[] = $row3;
        }
        while($row4 = $stmt4->fetch()){
            $rows[] = $row4['category'];
        }
    }else{
       header("location: menutop_edit.php?A=".urlencode('削除するメニューを選択してください'));
    }


?>
<html>
  <head>
  <title>削除</title>
  <meta charset="utf-8">
  </head>
  <body>
  <!--generate_checkdelete_inputとwrite_checkdelete_inputのメソッド部分-->
    <h1>これらのメニューを削除しますか</h1>
    
    <form method="get">
        
    <?php 
    $de_menu[] = array();
    for($j = 0; $j < count($d1_menu); $j++){
    for($i = 0; $i < count($rows); $i++){
        
            if($d1_menu[$j]['category'] == $rows[$i]){
                $de_menu[$i][] = $d1_menu[$j];
                break;
            }
        }
    }
    /*echo count($rows);
    echo count($de_menu);
    for($i = 0; $i < count($rows); $i++){
        echo $rows[$i];
    }
    for($j = 0; $j < count($de_menu); $j++){
        print_r($de_menu[$j]);
    }*/
    
    for($i = 0; $i < count($de_menu); $i++){
        for($j = 0; $j < count($de_menu[$i]); $j++){
            $d_menu[] = $de_menu[$i][$j];
        }
    }
    //print_r($d_menu);
        echo '<div class="menu_mei">メニュー名</div>';
        echo '<div class="menu_kin">金額</div>';
        echo "<br /><br />";
        /*$max_cate = mb_strlen($d_menu[0]['category']);
        for($i = 0; $i < count($d_menu); $i++){
            if($max_cate < mb_strlen($d_menu[$i]['category'])) $max_cate = mb_strlen($d_menu[$i]['category']);
        }
        $max_cate *= 2;
        $cate = "calc(35% - ".$max_cate."%)";*/
        echo '<div class="scroll">';
        
        $max_moji = strlen($d_menu[0]['productname']);
        

        $catecheck = "";/*$d_menu[0]['category'];/*
        //$show_delete = '<table class="delete_menu"><tr><td>'.$catecheck."</td><td></td></tr>";
        $show_delete = '<table class="delete_menu"><tr><td></td></tr>';
        for($i = 0; $i < count($d_menu); $i++){
            if($catecheck != $d_menu[$i]['category']){
                echo "カテゴリー名：".$d_menu[$i]['category'];
                if($max_moji < strlen($d_menu[$i]['productname'])) $max_moji = strlen($d_menu[$i]['productname']);
                //$show_delete .= "<tr><td>".$d_menu[$i]['category']."</td><td>　</td></tr>";
                $show_delete .= "<tr><td></td></tr>";
                $catecheck = $d_menu[$i]['category'];
            }
            //$show_delete .= "<tr><td></td><td>".$d_menu[$i]['productname']."</td></tr>";
            $show_delete .= "<tr><td>".$d_menu[$i]['productname']."</td></tr>";
            $delete_menu[] = $d_menu[$i]['productname'];
        }
        $show_delete .= "</table>";
        $moji = "calc(55% - ".$max_moji."%)";
        $show_delete .= "<table class='delete_value'" .'style="left: 68%"'."><tr><td></td></tr>";
        $catecheck = $d_menu[0]['category'];
        for($j = 0; $j < count($d_menu); $j++){
            if($catecheck != $d_menu[$j]['category']){
                $show_delete .= "<tr><td></td></tr>";
                $catecheck = $d_menu[$j]['category'];
            }
            $show_delete .= "<tr><td>".$d_menu[$j]['value']."円</td></tr>";
        }*/
        $show_delete = '<table class="delete_menu"><tr><td></td><td></td></tr>';
        for($i = 0; $i < count($d_menu); $i++){
            if($catecheck != $d_menu[$i]['category']){
                
                if($max_moji < strlen($d_menu[$i]['productname'])) $max_moji = strlen($d_menu[$i]['productname']);
                //$show_delete .= "<tr><td>".$d_menu[$i]['category']."</td><td>　</td></tr>";
                $show_delete .=  "<tr><td></td></tr><tr><td style='padding:2vw 0vw;'>カテゴリー名：".$d_menu[$i]['category']."</td></tr>";
                $show_delete .= "<tr><td></td><td></td></tr>";
                $catecheck = $d_menu[$i]['category'];
            }
            //$show_delete .= "<tr><td></td><td>".$d_menu[$i]['productname']."</td></tr>";
            $show_delete .= "<tr><td>".$d_menu[$i]['productname'].'</td><td style="left: 68%;">'.$d_menu[$i]['value']."円</td></tr>";
            $delete_menu[] = $d_menu[$i]['productname'];
        }
        $show_delete .= "</table>";
        echo $show_delete;
        echo '</div>';

        /*foreach($d_menu as $value1){
            $kuhaku ="";
            if($catecheck != $value1['category']){
                echo $value1['category']."<br />";
                echo "　　メニュー名　　　　　　金額<br /><br />";
                $catecheck = $value1['category'];
            }
            for($c = 0; $c < 10 - mb_strlen("{$value1['productname']}", 'utf8'); $c++){
                $kuhaku .= "　";
            } 
            
            echo "　　".$value1['productname'].$kuhaku."　".$value1['value']."円<br /><br />";
            
            

            $delete_menu[] = $value1['productname'];
        }*/ 
        

        for($d = 0; $d < count($delete_menu); $d++){
            echo '<input type="hidden" name="delete_menu[]" value="';
            echo $delete_menu[$d];
            echo '">';
        }
    ?>
     
    <input type="submit" name="delete2" class="delete" value="削除" style="margin:10px 20px 10px 0px; float:left;" onClick="form.action='menu_delete.php';return true">
    </form>
    <form name="back">
    <input type="submit" name="back" class="menutop_back" value="戻る" style="margin:10px 20px 10px 0px; float:left;" onClick="form.action='menutop_edit.php';return true">
    </form>
    
   
  </body>
</html>
<style>
body{
        position:relative;
        /*text-align: center;*/
        color: #000000;
        font-size: 2vw;
        background:#eeeeee;
    }
    h1{
        text-align: center;
        font-size:6vw;
        color: #0066FF;
    }
    div.menu_mei{
        position:absolute;
        font-size:4.5vw;
        top: 13vw;
        left: 10%;
    }
    div.menu_kin{
        position:absolute;
        font-size:4.5vw;
        top: 13vw;
        left: 70%;
        float: left;
    }
    div.cate{
        position:absolute;
        font-size:4.5vw;
        top: 13vw;
        left: 20%;
    }
    div.scroll {
    top: 22vw;
    font-size:2vw;
    position:absolute;/*
    left: <?php //echo $cate; ?>;*/
    left:3%;
    width: 95%;
    height: 60%;
    overflow: scroll;
    /*overflow-x: hidden;*/
    }

table{
    width:100%;
    font-size: 4vw;
}
table.delete_menu{
    float:left;
}
table.delete_value{/*
    position: relative;*/
    position:absolute;
    left: 30%;
    float:left;
}
table.delete_menu td{
    padding: 1vw 0vw;
}
table.delete_value td{
    padding: 1vw 0vw;
}



    
input[type="submit"]{
  position:absolute;
  /*background-color: #0066FF;
  color: #ffffff;*/
  width:15%;
  height:7%;
  font-size: 4vw;
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

.delete{
  /*margin:10px 10px 10px 0px;*/
  left:45%;
  top: 80%;
  margin-left:-2.5vw;
}

.menutop_back{
  /*margin:10px 10px 10px 0px;*/
  left:5%;
  top: 80%;
}
</style>