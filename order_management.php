<?php
  // ログインしているかを確認
  //include "login_class.php";
  //$login = new login_class();
  //$login->ses_start();

  // 注文管理を行うための準備
  include "order_management_class.php"; // 注文管理をするための処理を記述したクラスファイル
  $order_management = new order_management_class();
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel = "stylesheet" type = "text/css" href = "order_management.css">
    <meta http-equiv = "refresh" content = "15"> <!-- 15秒ごとに再読み込み -->
    <mata charset = "utf-8">
    <title>注文管理画面</title>
  </head>

  <body>
    <h2>注文管理</h2>

    <form method = "post" action="">
      <?php
        // 更新ボタンの処理
        if(isset($_POST["button_update"]) and isset($_POST["product"])){
          $kbn = htmlspecialchars($_POST["button_update"], ENT_QUOTES, "utf-8");
          switch($kbn){
            case "update":
              $order_management->order_management_update($_POST["product"]);
              break;

            default:
              echo "更新処理が正常に行えませんでした。";
              break;
          }
        }

        // 注文管理画面の出力
        $order_management->order_management_out();
      ?>

      <!-- ボタンの設定 -->
      <br>
      <!-- TOPへ戻るボタン(top画面へ遷移する) -->
			<button class="btn" type = "button" name = "button_return" value = "return" onclick = "location.href='toppage.php'">
				TOPへ戻る
			</button>

			<!-- 更新ボタン(配膳フラグの更新する) -->
			<button class="btn" type = "submit" name = "button_update" value = "update">
				更新
			</button>

      <br>

			<!-- リセットボタン(チェックを全てはずす) -->
			<button class="btn" type = "reset" name = "button_reset" value = "reset">
				リセット
			</button>

      <!-- 削除ボタン(遷移先で、商品の削除確認を行う) -->
			<button class="btn" type = "submit" name = "button_delete" value = "delete" formaction = "order_management_delete.php">
				削除
			</button>
    </form>
  </body>

</html>
