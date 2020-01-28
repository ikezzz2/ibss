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
       div.scroll {
        width: 400px;
        height: 200px;
        overflow: scroll;
        overflow-x: hidden;
    }
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
              <input name="newcategory" type="text" value="<?php echo $select_category?>" style="margin:10px 10px 10px 0px; float:left;">
            <?php else: ?>
              <input name="newcategory" type="text" style="margin:10px 10px 10px 0px; float:left;">
            <?php endif ?>
            <br /><br /><br />
        <?php 
            echo "メニュー名　　　　　　金額<br />";
            echo '<div class="scroll">';
            //set_add_listのメソッド部分
            
            for($j = 0; $j < 20; $j++){
              echo '<input type="text" name="addname[]" value="'.$show_name[$j].'" style="margin:10px 10px 10px 0px; float:left;" required>';
              echo '<input type="int" name="addvalue[]" value="'.$show_value[$j].'" style="margin:10px 10px 10px 0px; float:left;" required>';
              echo "<br /><br />";
            }
            echo "</div>";
        ?>
        <input type="submit" name="addcheck" value="確認" style="margin:10px 10px 10px 140px; float:left;" onClick="form.action='menu_check_add.php';return true">
        </form>
        <br /><br />
        <form name="back">
        <input type="submit" name="exe3" value="戻る" style="margin:10px 10px 10px 0px; float:left;" onClick="form.action='menutop_edit.php';return true">
      </form>
  </body>
  </html>