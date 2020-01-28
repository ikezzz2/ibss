<?php
    // include('login_class.php');
    // $login = new login_class();
    // $login->ses_start();

    include('order_input_class.php');
    $seat = new order_input_class();

?>


<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>注文受付</title>
            <link rel = "stylesheet" type = "text/css" href = "order.css">
    </head>
    <body>

        <form id="select_seat" name="select_seat" action="" method="POST">
            座席番号
            <select class="bx" style="width: 130px" name="seat_num" required>
            <?php
                if(isset($_POST["seat_num"])){
                    echo "<option value='' >".$_POST["seat_num"]."</option>";
                }else{
                    echo "<option value='' >--</option>";
                }
            ?>

<?php
                $seat_num = $seat->get_seat_number();
                //print_r($row);
                foreach ($seat_num as $num){
                    echo "<option value='".$num["seatnum"]."'>".$num["seatnum"]."</option>";
                }
                echo "</select><br>";

                $count = 0;
                $category=$seat->get_category();
                $menu=$seat->get_menu();

                $count2=0;
                //print_r($menu);

                echo "<div class='tab-wrap'>";
                foreach ($category as $num){
                    if($count == 0){
                        echo "<input id=".$num["0"]." type='radio' name='TAB' class='tab-switch' /><label class='tab-label' for=".$num["0"]." checked='checked'>".$num["0"]."</label>";
                        $count =1;
                    }else{
                        echo "<input id=".$num["0"]." type='radio' name='TAB' class='tab-switch' /><label class='tab-label' for=".$num["0"].">".$num["0"]."</label>";
                    }
                    echo "<div class='tab-content'>";
                    echo "<div class='scroll'>";
                    foreach ($menu as $num2){
                        if($num["0"] == $num2[1]){
                            echo $num2[0];
                            //注文確認画面からデータがPOSTされているかの確認
                            if(isset($_POST["name"])){
                                $array_count = count($_POST["name"]);
                                //POSTされたデータの名前と表を生成する際の名前が一緒なら初期値の個数を変更する
                                if($_POST["name"][$count2]==$num2[0]){
                                    echo "<input class='bx1' type='number' max='10' min='0' value=".$_POST["sum"][$count2]." name=".$num2[0]."[]>";
                                    echo "<br>";
                                    //POSTされた商品名の数超えていなければカウントプラスする
                                    if($count2 < $array_count -1){
                                        $count2++;
                                    }
                                }else{
                                    echo "<input class='bx1' type='number' max='10' min='0' value='0' name=".$num2[0]."[]>";
                                    echo "<br>";
                                }
                            }else{
                                echo "<input class='bx1' type='number' max='10' min='0' value='0' name=".$num2[0]."[]>";
                                echo "<br>";
                            }
                        }
                    }
                    echo "</div></div>";

                }
                echo "</div>";

            ?>
            <button class="btn" type="submit" formaction="toppage.php" formnovalidate>戻るボタン</button>
            <button class="btn" type="reset">リセット</button>
            <button class="btn" type="submit" name="end" formaction="order_check.php">完了ボタン</button>
        </form>




    </body>
</html>
