<?php
    include('order_input_class.php');
    $menu_class = new order_input_class();

    // nclude('login_class.php');
    // $login = new login_class();
    // $login->ses_start();

    $menu_name = array_keys($_POST);
    $count = count($menu_name);

?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>注文確認画面</title>
            <link rel = "stylesheet" type = "text/css" href = "order.css">
    </head>
    <body>
    <body>
    座席番号 <?php  print_r($_POST["seat_num"]);?>

    <form method="post" action="">
        <?php
            $menu = [];
            $menu_name = array_keys($_POST);
            $count = count($menu_name);
            $menu_count1=0;

            echo "<input type='hidden' name='seat_num' value=".$_POST["seat_num"].">";

            for($i = 1; $i < $count -1; $i++){
                if($menu_name[$i] != "TAB" && $_POST[$menu_name[$i]][0] != 0){
                    echo "<dvi class ='pay_check_size'>";
                    print_r($menu_name[$i]);
                    echo (" × ");
                    print_r($_POST[$menu_name[$i]][0]);
                    echo "<br>";
                    echo "<input type='hidden' name=name[] value=".$menu_name[$i].">";
                    echo "<input type='hidden' name=sum[] value=".$_POST[$menu_name[$i]][0].">";
                    $menu_count1++;
                    echo "<dvi>";

                }else{
                    if($_POST[$menu_name[$i]][0] == NULL){
                        header("Location:order_input.php");
                    }
                    continue;
                }
            }
            if($menu_count1==0){
                header("Location:order_input.php");
            }


        ?>
        <button class="btn" type="submit" name="input_name" value="実行" formaction="order_end.php" >送信ボタン</button>
        <button class="btn" formaction="order_input.php">戻るボタン</button>
    </form>

    </body>

</html>
