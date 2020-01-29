

<?php
//menu_addメソッド部分
    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'dbpractice';

    $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    $pdo2 = new PDO($link, $db_username, $db_password);
    $sql2 = "SELECT * FROM menutable";
    $stmt2 = $pdo2->query($sql2);
    while($row2 = $stmt2->fetch()){
        $menu_name[] = $row2['productname'];
    }

        if(isset($_GET["add1"]) && isset($_GET["addname_check"]) && isset($_GET["addvalue_check"]) && isset($_GET["select_category"])){
            $addname_check = $_GET['addname_check'];
            $addvalue_check = $_GET['addvalue_check'];
            $select_category = $_GET['select_category'];

            $arrayAdd[] = array();
            for($i = 0; $i < count($addname_check); $i++){
                $arrayAdd[$i] = '("'.$addname_check[$i].'", "'.$select_category.'", "'.$addvalue_check[$i].'")';
                print_r($arrayAdd[$i]);
            }
            
            $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
            $pdo6 = new PDO($link, $db_username, $db_password);
            $sql6 = 'INSERT INTO menutable (productname, category, value) VALUES '.join(",", $arrayAdd);
            $stmt6 = $pdo6->query($sql6);
            echo $sql6;
            
            header("location: menutop_edit.php?A=".urlencode('メニュー情報を追加しました'));
            
        }else if(!isset($_GET["addcheck"])) header("location: menu_add.php?A=".urlencode('追加エラーです'));
    ?>


<html>
  <head>
  <title>追加確認</title>
  <meta charset="utf-8">
</head>
<body>

    <form method="get">
    
    <h1>以下を追加しますか</h1>
        <!--generate_checkadd_inputとwrite_checksddinputのメソッド部分-->
    <?php
    //check_add_listのメソッド部分 
    $sc_back = "";
        if(isset($_GET["addcheck"]) && isset($_GET["select_category_input"])){
            $sc = $_GET["select_category_input"];
            if($sc == "shoki"){
                header("location: menu_add.php?A=".urlencode('カテゴリーを選択してください'));
            }else if($sc == "newcate"){
                if(isset($_GET["newcategory"])){
                    $sc_back = $sc; 
                    $sc = $_GET["newcategory"];
                    if($sc == "") header("location: menu_add.php?A=".urlencode('新規カテゴリー名を入力してください'));
                    if(strpos($sc,'<') || strpos($sc,'>') || strpos($sc,'"') || strpos($sc,"'"))  header("location: menu_add.php?A=".urlencode('不正な文字が利用されています')); 
                }else{
                    header("location: menu_add.php?A=".urlencode('追加エラーです'));
                }
            }
            
            if(isset($_GET['addname']) && isset($_GET['addvalue'])){
                $addname[] = $_GET['addname'];
                $addvalue[] = $_GET['addvalue'];
                $select_category = $sc;
                $check_add = 0;
                for($i = 0; $i < count($addname[0]); $i++){
                    
                   if($addname[0][$i] == "メニュー名"){
                       if($addvalue[0][$i] == 0){
                            continue;
                       }else{
                            header("location: menu_add.php?A=".urlencode('金額だけ入力されている欄があります'));
                       }
                   }else if($addvalue[0][$i] <= 0 || strpos($addvalue[0][$i],'.') || strpos($addvalue[0][$i],'．')){
                        header("location: menu_add.php?A=".urlencode('金額は自然数を入力してください'));
                   }else if($addvalue[0][$i] > 10000) header("location: menu_add.php?A=".urlencode('金額は1万円以下で入力してください'));
                    else if(mb_strlen($addname[0][$i]) > 15) header("location: menu_add.php?A=".urlencode('メニュー名は15文字以下で入力してください')); 

                   for($j = 0; $j < count($menu_name); $j++){
                        if($menu_name[$j] == $addname[0][$i]) header("location: menu_add.php?A=".urlencode('同じメニュー名が存在しています')); 
                        if(strpos($addname[0][$i],'<') || strpos($addname[0][$i],'>') || strpos($addname[0][$i],'"') || strpos($addname[0][$i],"'"))  header("location: menu_add.php?A=".urlencode('不正な文字が利用されています'));
                    }
                     
                    $addname_check[] = $addname[0][$i];
                    $addvalue_check[] = $addvalue[0][$i];
                    $sql_taisaku = htmlentities($addname[0][$i]);
                    echo '<input type="hidden" name="select_category" value="'.htmlentities($select_category).'">';
                    echo '<input type="hidden" name="addname_check[]" value=';
                    echo $sql_taisaku;
                    echo "'>";
                    echo '<input type="hidden" name="addvalue_check[]" value="';
                    echo htmlentities($addvalue[0][$i]);
                    echo '">';
                    $check_add++;
                }
                if($check_add == 0) header("location: menu_add.php?A=".urlencode('追加情報を入力してください'));
            }else{
                header("location: menu_add.php?A=".urlencode('追加エラーです'));
            }
        }
    ?>

    <?php
    echo '<div class="menu_mei">メニュー名</div>';
    echo '<div class="menu_kin">金額</div>';
    echo "<br /><br />"; 
    echo '<div class="cate">カテゴリ名：'.htmlentities($sc)."</div>";

        /*echo "　　メニュー名　　　　　　金額<br /><br />";*/
        /*for($j = 0; $j < count($addname_check); $j++){
            $kuhaku2 ="";

            for($c = 0; $c < 10 - mb_strlen("{$addname_check[$j]}", 'utf8'); $c++){
                $kuhaku2 .= "　";
            } */
            echo '<div class="scroll">';
            $show_add = "<table class='add_menu'>";
            $max_moji = strlen($addname_check[0]);
            for($j = 0; $j < count($addname_check); $j++){
                $show_add .= "<tr><td>".$addname_check[$j]."</td></tr>";
                if($max_moji < strlen($addname_check[$j])) $max_moji = strlen($addname_check[$j]);
            }
            $show_add .= "</td></tr></table>";
            $moji = "calc(55% - ".$max_moji."%)";
            $show_add .= '<table class="add_value" style="position: absolute; left: 68%">';//.$moji.'">';
            for($j = 0; $j < count($addname_check); $j++){
                $show_add .= "<tr><td>".htmlentities($addvalue_check[$j])."円</td></tr>";
            }
            $show_add .= "</td></tr></table>";
            echo $show_add;
            echo "</div>";
            
            
            //echo "　　".$addname_check[$j].$kuhaku2."　".$addvalue_check[$j]."円<br /><br />";
        //}
    ?>
    <input type="submit" class="add1" name="add1" value="追加" style="margin:10px 10px 10px 0px; float:left;" onClick="form.action='menu_check_add.php';return true">
    </form>
    <form name="back">
    <?php 
    echo '<input type="hidden" name="back_category" value="'.$sc.'">';
    for($i = 0; $i < count($addname[0]); $i++){
        echo '<input type="hidden" name="backadd_name_check[]" value="';
        echo htmlentities($addname[0][$i]);
        echo '">';
        echo '<input type="hidden" name="backadd_value_check[]" value="';
        echo htmlentities($addvalue[0][$i]);
        echo '">';
    }
    if($sc_back != ""){
        echo '<input type="hidden" name="back_newcategory" value="'.htmlentities($sc_back).'">';
    } 
    ?>
    <input type="submit" class="add_back" name="exe3" value="戻る" style="margin:10px 10px 10px 0px; float:left;" onClick="form.action='menu_add.php';return true">
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
        font-size:8vw;
        color: #0066FF;
    }
    div.menu_mei{
        position:absolute;/*
        font-size:2vw;*/
        font-size:4.5vw;/*
        top: 8vw;
        left: 33%;*/
        top: 22vw;
        left: 10%;
    }
    div.menu_kin{
        position:absolute;/*
        font-size:2vw;*/
        font-size:4.5vw;/*
        top: 8vw;
        left: 63%;*/
        top:22vw;
        left:70%;
        float: left;
    }
    div.cate{
        position:absolute;/*
        top: 12vw;*/
        font-size:4.5vw;
        top:13vw;/*
        left: 25%;*/
        left:25%;
    }
    div.scroll {
    top: 30vw;
    font-size:2vw;
    position:absolute;/*
    left: 33%;*/
    left:3%;/*
    width: 50%;*/
    width: 95%;
    height: 60%;
    overflow: scroll;
    overflow-x: hidden;
    }

table{
    font-size: 4vw;
}
table.add_menu{
    left: 0%;
    float:left;
}
table.add_value{
    float:left;
}
table.add_menu td{
    padding: 2vw 0vw;
}
table.add_value td{
    padding: 2vw 0vw;
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

.add1{
  /*margin:10px 10px 10px 0px;*/
  left:45%;
  top: 85%;
  margin-left:-2.5vw;
}

.add_back{
  /*margin:10px 10px 10px 0px;*/
  left:5%;
  top: 85%;
}
