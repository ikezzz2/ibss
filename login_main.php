<?php
//require 'password.php';   // password_verfy()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$db['host'] = "localhost";  // DBサーバのURL
//$db['user'] = "hogeUser";  // ユーザー名
//$db['pass'] = "hogehoge";  // ユーザー名のパスワード
$db['dbname'] = "ibss";  // データベース名

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["userid"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        // 入力したユーザIDを格納
        $userid = $_POST["userid"];

        // 2. ユーザIDとパスワードが入力されていたら認証する
        $dsn = sprintf('mysql: host=%s; dbname=%s; charset=utf8', $db['host'], $db['dbname']);

        // 3. エラー処理
        try {
            $pdo = new PDO($dsn, 'root', ''); //デーブルに接続
            $sql = "select  password from userinfo where id = ?"; // SQL文を作成
            $stmt = $pdo -> prepare($sql);//SQLを実行するための準備
            $stmt -> execute(array($_POST["userid"]));// SQLを実行
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);
            if (password_verify ($_POST['password'] , $row['password']) === true){
                    $_SESSION['login'] = 1;
                    header("Location: toppage.php");  // TOP画面へ遷移
                    exit();  // 処理終了
            } else {
                    // 認証失敗
                    $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            $errorMessage = $sql;
            $e->getMessage();//でエラー内容を参照可能（デバッグ時のみ表示）
            echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>IBSSログイン</title>
            <link rel="stylesheet" href="login_main.css">
    </head>
    <body>
      <center>
        <h1 style="padding-right: 160px; padding-top: 140px;">IBSSログイン画面</h1>
        <br>
        <form id="loginForm" name="loginForm" action="" method="POST">
          <legend style="padding-right: 160px;">ログインフォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <p style="padding-right: 160px;">
                <label for="userid">ユーザーID</label><input type="text" id="userid" name="userid" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["userid"])) {echo htmlspecialchars($_POST["userid"], ENT_QUOTES);} ?>">
              </p>
                <p style="padding-right: 160px;">
                <label for="password">パスワード</label><input type="password"  id="password" name="password" value="" placeholder="パスワードを入力">
              </p>
                <p style="padding-right: 160px;">
                <input type="submit" class="btn" id="login" name="login" value="ログイン">
              </p>
        </form>
      </center>
    </body>
</html>
