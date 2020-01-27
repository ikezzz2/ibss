<?php
  // ログインしているかを確認
  //include "login_class.php";
  //$login = new login_class();
  //$login->ses_start();

  // 直接URLを入力されたかを確認
  if(!isset($_POST["button_delete"])){ // 直接入力されたとき(注文管理画面で削除ボタンが押されていないとき)
    echo "手順が誤っています。やり直してください。";
    echo "<form action = 'toppage.php' method = 'post'>";
    echo "<input type = 'submit' value = 'TOPへ戻る'>";
    echo "</form>";
  }else{ // 注文管理画面から遷移したとき(削除ボタンが押されたとき)
    // 注文管理を行うための準備
    include "order_management_class.php"; // 注文管理をするための処理を記述したクラスファイル
    $order_management_delete = new order_management_class();
    ?>

    <!DOCTYPE html>
    <html>
      <head>
        <link rel = "stylesheet" type = "text/css" href = "order_management.css">
        <mata charset = "utf-8">
        <title>注文削除確認画面</title>
      </head>

      <body>
        <h2>削除内容確認</h2>

        <!-- チェックが入っているかの確認-->
        <?php
        if(!isset($_POST["product"])){ // チェックが入っていないとき
          echo "注文が指定されていません。";
          echo "<form action = 'order_management.php' method = 'post'>";
          echo "<input class='btn' type = 'submit' value = '注文管理画面へ'>";
          echo "</form>";
          echo "</body>";
          echo "</html>";
        }else{ // チェックが入っているとき
        ?>
          <form method = "post">
            <!-- 注文管理画面から送信された値を保持するための設定 -->
            <input type = "hidden" name = "button_delete" value = <?php echo $_POST["button_delete"] ?>>
            <?php
              foreach ($_POST["product"] as $key) {
                ?>
                <input type = "hidden" name = "product[]" value = <?php echo $key ?>>
                <?php
              }
            ?>
            <?php
            // 削除ボタンの処理
            if(isset($_POST["button_delete_check"]) and isset($_POST["product"])){
              $kbn = htmlspecialchars($_POST["button_delete_check"], ENT_QUOTES, "utf-8");
              switch($kbn){
                case "delete_check":
                  $order_management_delete->order_management_delete($_POST["product"]);
                  header("Location:order_management.php");
                  break;

                  default:
                  echo "削除処理が正常に行えませんでした。";
                  break;
                }
              }

              // 削除内容の確認をするための表を作成
              $order_management_delete->write_order_management_check($_POST["product"]);
            ?>

            <!-- ボタンの作成 -->
            <!-- 戻るボタン(注文管理画面へ遷移する) -->
  			    <button class="btn" type = "button" name = "button_delete_return" value = "delete_return" onclick = "location.href='order_management.php'">
              戻る
  			    </button>

            <!-- 削除ボタン -->
            <button class="btn" type = "submit" name = "button_delete_check" value = "delete_check">
              削除
            </button>

          </form>
          </body>
          </html>
          <?php
        } ?>

    <?php
  }
?>
