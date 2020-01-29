<?php

    if(isset($_GET['A'])){
      $message = $_GET['A'];
      $alert = "<script type='text/javascript'>alert('".$message."');</script>";
      echo $alert;
    }

    $db_hostname    = 'localhost';
    $db_username    = 'root';
    $db_password    = '';
    $db_name        = 'dbpractice';

    $link = "mysql:dbname=ibss;host=localhost;charset=utf8";
    $pdo = new PDO($link, $db_username, $db_password);
    $sql = "SELECT DISTINCT category FROM menutable";
    $stmt = $pdo->query($sql);
    $rows = Array();
    while($row = $stmt->fetch()){
        $rows[] = $row['category'];
    }
    $cnt = count($rows);

    $pdo2 = new PDO($link, $db_username, $db_password);
    $sql2 = "SELECT * FROM menutable";
    $stmt2 = $pdo2->query($sql2);
    while($row2 = $stmt2->fetch()){
        $input_menu_date[] = $row2;
    }
    $export_menu_date[] = array();
    for($j = 0; $j < count($input_menu_date); $j++){
        for($i = 0; $i < $cnt; $i++){
            if($input_menu_date[$j]['category'] == $rows[$i]){
                $export_menu_date[$i][] = $input_menu_date[$j];
            }
        }
    }


    for($i = 0; $i < count($export_menu_date); $i++){
        for($j = 0; $j < count($export_menu_date[$i]); $j++){
            $menu_date[] = $export_menu_date[$i][$j];
        }
    }
    ?>

<?php
    if(isset($_GET["menutop_back"]) && isset($_GET["topback_date"])){
      $show_input = $_GET["topback_date"];
      echo "<br /><br />";
      for($i = 0;$i < count($show_input); $i++){
          $s = explode(",",$show_input[$i]);
          $show[] = $s;
      }
    }else{
      $show = $menu_date;
    }

    ?>


<html>
  <head>
  <title>選択</title>
  <meta charset="utf-8">
  <link rel = "stylesheet" href="style.css">
  <style>
      <?php for($h = 0; $h < $cnt; $h++){
          if($h == $cnt - 1){
            echo "#a".$h.":checked ~ #a".$h."_content{display: block;}";
          }else{
            echo "#a".$h.":checked ~ #a".$h."_content,";
          }
        }
       ?>

      </style>
      <script type="text/javascript">

    </script>

  </head>
  <body -webkit-text-size-adjust: 100%;>
    <br>
    <br>
    <br>
    <br>
      <h1>メニュー編集</h1>
      <br>
    <!--generate_menuedit_inputとwrite_menuedit_inputのメソッド部分-->
    <form method="get" name="menutop"> <!--action="checkdelete.php"-->
    <div class="tabs">
    <?php
        for($k = 0; $k < $cnt; $k++){
            $radio = '<input id="a';
            $radio .= $k;
            if($k == 0) $radio .= '" type="radio" name="tab_item" checked>';
            else $radio .= '" type="radio" name="tab_item" >';
            echo $radio;

            $label1 = '<label class="tab_item" for="a';
            $label1 .= "$k";
            $label1 .= '">';
            $label1 .= $rows[$k];
            $label1 .= '</label>';
            echo $label1;
        }


        for($i = 0; $i < $cnt; $i++){
            $content = '<div class="tab_content" id="a';
            $content .= "$i";
            $content .= '_content">';
            $content .= '<div class="tab_content_description">';
            $content .= '<p class="c-txtsp">';
            echo $content;
            $c = 0;

            $editmenu = array();
            $editvalue = array();
            //$checkbox1 = 'onkeyup='."this.style.backgroundColor=''===this.value?'white':'pink';";
            echo "　　　メニュー名　　　　　　　　　金額<br />";
            for($j = 0; $j < count($show); $j++){
                if($show[$j][1] == $rows[$i]){
                    $c++;
                    $checkbox = '<input type="checkbox" name="checkslist[]" value="';
                    $checkbox .= "{$show[$j][0]}";
                    $checkbox .= '">';
                    if($c < 10) $checkbox .= "0{$c}　";
                    else $checkbox .= "{$c}　";
                    if($show[$j][0] == $menu_date[$j][0]) $checkbox .= '<input type="text" class="A" id="check'.$j.'" name="editmenu[]" value="'.$show[$j][0].'" style="margin:0px 0px 0px 10px; background-color: #ffffff;" onchange="name_color_change();" required>';
                    else $checkbox .= '<input type="text" class="A" id="check'.$j.'" name="editmenu[]" value="'.$show[$j][0].'" style="margin:0px 0px 0px 10px; background-color: #d9f6ff;" onchange="name_color_change();" required>';


                    if($show[$j][2] == $menu_date[$j][2]) $checkbox .= '<input type="int" id="ncheck'.$j.'" name="editvalue[]" value="'.$show[$j][2].'" style="margin:0px 0px 0px 10px; background-color: #ffffff;" onchange="value_color_change();" required>円<br /><br />';
                    else $checkbox .= '<input type="int" id="checkn'.$j.'" name="editvalue[]" value="'.$show[$j][2].'" style="margin:0px 0px 0px 10px; background-color: #d9f6ff;" onchange="value_color_change();" required>円<br /><br />';
                    echo $checkbox;
                    $m_date = array($show[$j][0],$show[$j][1],$show[$j][2]);
                    //$m_date = array($menu_date[$j][0],$menu_date[$j][1],$menu_date[$j][2]);

                    $mini_date = implode(',', $m_date);
                    $mini_dete_test[] = $mini_date;
                }
            }
            echo "</p></div></div>";
        }

    ?>
    </div>

    <?php
    for($j = 0; $j < count($menu_date); $j++){
        $m_date = array($menu_date[$j][0],$menu_date[$j][1],$menu_date[$j][2]);
        $moto_tan = implode(',', $m_date);
        echo '<input type="hidden" name="moto_date[]" value="'.$moto_tan.'">';
    }
    ?>
    <br>
    <p style="padding-left: 30px;">
    <input type="submit" name="end" class="btn" id="btn" value="終了" onClick="form.action='toppage.php';return true">

    <input type="submit" name="checkdelete" class="btn" id="btn" value="削除" onClick="form.action='menu_delete.php';return true">

    <input type="submit" name="menuadd" class="btn" id="btn" value="追加" onClick="form.action='menu_add.php';return true">

    <input type="submit" name="edit1" class="btn" id="btn" value="更新" onClick="form.action='menu_edit.php';return true">
  </p>
  </form>
</body>
</html>
