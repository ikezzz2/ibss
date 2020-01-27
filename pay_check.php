<?php
    include('seat_class2.php');
    $seat = new seat_class();

    if(isset($_POST["end"])){
        $row =$seat->del_order($_GET["A"]);
        header("Location: toppage.php");
    }

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>会計確認画面</title>
        <link rel="stylesheet" href="pay.css">
    </head>
    <body>
    <span class="se" >座席番号 <?php print_r($_GET["A"]); ?> </span>

    <br>
    <form id="select_seat" name="select_seat" action="" method="POST">
    <div class = "line1">
    <?php
        $row=$seat->pic_order($_GET["A"]);
        //print_r ($row);
        foreach ($row as $num){
            //print("　　　 ");
            echo $num[0];
            print(" × ");
            echo $num[1];
            echo "<br>";
        }
    ?>
    </div>

    <style>

    </style>

    <span class="se1" style="border-bottom: solid 1px red;">
    <?php
        $row=$seat->sum_pay($_GET["A"]);
                print("合計金額 ￥");
                echo $row[0][0];
    ?>
    </span>
    <div>
    <button class="btn" formaction="seat_select.php">戻るボタン</button>
    <button id="btnR" class="btn" type="submit" name="end" formaction="">完了ボタン</button>

    </div>
    </form>
    </body>
</html>
