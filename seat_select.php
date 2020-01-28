<?php
    include('seat_class2.php');
    $seat = new seat_class();

    if (isset($_POST["next"])) {
        if ($_POST["example"] == 'none'){
            echo '座席を選択してください';
        }else{
            header("Location: pay_check.php?A=".$_POST["example"]);
        }
    }
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>会計座席選択</title>
            <link rel="stylesheet" href="pay.css">
    </head>
    <body>
        <form id="select_seat" name="select_seat" action="" method="POST">
        座席番号
        <select class="bx" style="width: 200px" name="example" required>
        <option value="none" ></option>

        <?php
        $row = $seat->get_seat_number();
         //print_r($row);
        foreach ($row as $num){
            echo "<option value='".$num["seatnum"]."'>".$num["seatnum"]."</option>";
        }
        ?>
        </select>
        <br>
        <br>

        <div>
        <button class="btn" formaction="toppage.php">戻るボタン</button>
        <button id="btnR"class="btn" type="submit" name="next" formaction="">次へボタン</button>



    </body>
</html>
