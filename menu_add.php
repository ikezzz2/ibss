<?php
//
    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'dbpractice';

    $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    $pdo6 = new PDO($link, $db_username, $db_password);
    $sql6 = "SELECT DISTINCT category FROM menutable";
    $stmt6 = $pdo6->query($sql6);
    $rows6 = Array();
    while($row6 = $stmt6->fetch()){
        $rows6[] = $row6['category']; 
    }
    $cc = "";
    if(isset($_GET['A'])){
        $message = $_GET['A'];
        $alert = "<script type='text/javascript'>alert('".$message."');</script>";
        echo $alert;
      } 
?>

<?php 
    if(isset($_GET["backadd_name_check"]) && isset($_GET["backadd_value_check"]) && isset($_GET["back_category"])){
      $show_name = $_GET["backadd_name_check"];
      $show_value = $_GET["backadd_value_check"];
      $select_category = $_GET["back_category"]; 
    }else{
      $show_name = array_fill(0,20,"メニュー名");
      $show_value = array_fill(0,20,0);
      $select_category = "shoki";
    }
    ?>


<html>
  <head>
  <title>追加</title>
  <meta charset="utf-8">
  <style>
       /*div.scroll {
        width: 400px;
        height: 200px;
        overflow: scroll;
        overflow-x: hidden;
    }*/
  </style>
  <script type="text/javascript">
  //set_add_categoryのメソッド部分

    function category_change(){
      
        if(document.page1.select_category_input.options[<?php echo count($rows6)+1; ?>].selected){
          document.page1.newcategory.style.display = "";
        }else{
          document.page1.newcategory.style.display = "none";
        }  
    }
    window.onload = category_change;
    </script>
  </head>
  <body>
    <h1>追加情報を入力してください</h1>
    <!--generate_menuaddinput_inputとwrite_menuaddinput_inputのメソッド部分-->
    <form method="get" name="page1">
    
        <select name="select_category_input" style="margin:10px 10px 10px 0px; float:left;" onchange="category_change();">
            <?php
            if($select_category == "shoki") echo '<option value="shoki" selected>選択してください</option>';
            else echo '<option value="shoki">選択してください</option>';
            for($i = 0; $i < count($rows6); $i++){
              if($select_category == $rows6[$i]) echo '<option value="'.$rows6[$i].'" selected>' .$rows6[$i]. '</option>';
              else echo '<option value="'.$rows6[$i].'">' .$rows6[$i]. '</option>';
            }
            if(isset($_GET["back_newcategory"])) echo '<option value="newcate" selected>新規</option>';
            else echo '<option value="newcate">新規</option>';
            ?>
        </select>

            <?php if(isset($_GET["back_newcategory"])): ?>
              <input class="newcategory" name="newcategory" type="text" value="<?php echo $select_category?>">
            <?php else: ?>
              <input class="newcategory" name="newcategory" type="text">
            <?php endif ?>
            <br /><br /><br />
        <?php 
          echo '<div class="menu_mei">メニュー名</div>';
          echo '<div class="menu_kin">金額</div>';
          echo "<br /><br />";
            echo '<div class="scroll">';
            //set_add_listのメソッド部分
            
            for($j = 0; $j < 20; $j++){
              echo '<input class="menu_name" type="text" name="addname[]" placeholder = "メニュー名を入力" value="'.$show_name[$j].'" style="margin:10px 10px 10px 0px;  float:left;" required>';
              echo '<input class="menu_value" type="int" name="addvalue[]" placeholder = "金額を入力" value="'.$show_value[$j].'" style="margin:10px 10px 10px 0px; float:left;" required>';
              echo "<br /><br />";
            }
            echo "</div>";
        ?>
        <input type="submit" class="addcheck" name="addcheck" value="確認" onClick="form.action='menu_check_add.php';return true">
        </form>
        <br /><br />
        <form name="back">
        <input type="submit" class="menutop_back" name="exe3" value="戻る" onClick="form.action='menutop_edit.php';return true">
      </form>
  </body>
  </html>
  <style>
    body{
        position:relative;
        /*text-align: center;*/
        color: #000000;
        font-size: 2vw;
    }
    h1{
        text-align: center;
        font-size:4vw;
        color: #0066FF;
    }
    .newcategory{
      position:absolute; 
      top:7vw; 
      left:58%;
      width:18%;
      height:5%; 
      min-width:250px ;
      min-height:30px ;
      font-size:1.5vw;
      float:left;
    }
    div.menu_mei{
        position:absolute;
        font-size:2vw;
        top: 15vw;
        left: 28%;
    }
    div.menu_kin{
        position:absolute;
        font-size:2vw;
        top: 15vw;
        left: 58%;
        float: left;
    }
    div.cate{
        position:absolute;
        top: 15vw;
        left: 25%;
    }
    div.scroll {
    top: 19vw;
    font-size:2vw;
    position:absolute;
    left: 28%;
    width: 60%;
    height: 40%;
    overflow: scroll;
    overflow-x: hidden;
    }

table{
    font-size: 1.5vw;
}
table.add_menu{
    left: 0%;
    float:left;
}
table.add_value{
    float:left;
}
table.add_menu td{
    padding: 1vw 0vw;
}
table.add_value td{
    padding: 1vw 0vw;
}

select{
  position:absolute;
  top: 6vw;
  left: 28%;
  width:18%;
  height:5%;
  min-width:200px ;
  min-height:30px ;
  font-size:1.5vw;
}

    
input[type="submit"]{
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

.addcheck{
  /*margin:10px 10px 10px 0px;*/
  left:45%;
  top: 85%;
  margin-left:-2.5vw;
}

.menutop_back{
  /*margin:10px 10px 10px 0px;*/
  left:5%;
  top: 90%;
}
.menu_name{
  position:absolute;
  left: 0%;
  width:30%;
  height:10%;
  min-width:200px ;
  min-height:30px ;
  font-size:1.5vw;
}
.menu_value{
  position:absolute;
  left: 50%;
  width:30%;
  height:10%;
  min-width:150px ;
  min-height:30px ;
  font-size:1.5vw;
}
