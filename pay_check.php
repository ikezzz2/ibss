<?php
    include('login_class.php');
    $login = new login_class();
    $login->ses_start();
    
    include('seat_class2.php');
    $seat = new seat_class();

    if(isset($_POST["end"])){
        $time=$seat->get_info($_POST["seat_num"]);

        $row =$seat->del_order($_POST["seat_num"]);

        $seat->del_management($_POST["seat_num"], $time);
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
        if($row==NULL){
            print("会計を行うための商品がありません");
            echo "<br>";
            print("完了ボタンを押すと予約情報が削除されます");
        }else{
            foreach ($row as $num){
                //print("　　　 ");
                echo $num[0];
                print(" × ");
                echo $num[1];
                echo "<br>";
            }
        }

    ?>
    </div>

    <style>

    </style>

    <span class="se1" style="border-bottom: solid 1px red;">
    <?php
        $row=$seat->sum_pay($_GET["A"]);
                if($row[0][0]!=NULL){
                    print("合計金額 ￥");
                    echo $row[0][0];
                }
                echo "<input type='hidden' name='seat_num' value=".$_GET["A"].">";

        // $time=$seat->get_info($_GET["A"]);
        // print_r($time);
        
        // // $seat->del_management($_GET["A"], $time);
    ?>
    </span>
    <div>
    <button class="btn" formaction="seat_select.php">戻るボタン</button>
    <button id="btnR" class="btn" type="submit" name="end" formaction="">完了ボタン</button>

    </div>
    </form>
    </body>
</html>
