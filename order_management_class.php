<?php
  class order_management_class {
    private $dnsinfo = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_user = "root";
    private $db_pw = "";
    private $order_management_html; // htmlのコードを格納する

    // 注文管理画面を生成するためのhtmlを格納する
    private function order_management(){
      try{
        // PDOインスタンスを生成
        $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
      }catch(Exception $e){
        // エラーメッセージ
        $res = $e -> getMessage();
      }

      $sql = "select orderid, productname, seatnum, servingflag from orderaccept";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(null);

      // 表の作成
      $this->order_management_html = "<div class = \"table_order_management\">";
      $this->order_management_html .= "<table>";
      $this->order_management_html .= "<tr><th>料理名</th><th>座席</th><th>確認</th></tr>";

      foreach($stmt as $row){
        if($row['servingflag'] == 0){ // 配膳フラグが0のものだけ表示
          $this->order_management_html .= "<tr>";
          $this->order_management_html .= "<td>".$row['productname']."</td>";
          $this->order_management_html .= "<td>".$row['seatnum']."</td>";
          $this->order_management_html .= "<td><input class='chekbox' type = \"checkbox\" name = \"product[]\" value = \"".$row['orderid']."\"></td>";
          $this->order_management_html .= "</tr>";
        }
      }
      $this->order_management_html .= "</table>";
      $this->order_management_html .= "</div>";
    }

    // 注文管理画面を出力する
    public function order_management_out(){
      $this->order_management();
      print_r($this->order_management_html);
    }

    // 注文受付テーブルの更新処理を行う(引数:注文ID)
    public function order_management_update($served_order){
      try{
        // PDOインスタンスを生成
        $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
      }catch(Exception $e){
        // エラーメッセージ
        $res = $e -> getMessage();
      }

      foreach($served_order as $row){
        $sql_update = "update orderaccept set servingflag = 1 where orderid = ?";
  			$stmt_update = $pdo -> prepare($sql_update);
  			$stmt_update -> execute(Array($row));
      }
    }

    // 注文受付テーブルの商品の削除処理を行う(引数:注文ID)
    public function order_management_delete($delete_order){
      try{
        // PDOインスタンスを生成
        $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
      }catch(Exception $e){
        // エラーメッセージ
        $res = $e -> getMessage();
      }

      foreach($delete_order as $row){
        $sql_delete = "delete from orderaccept where orderid = ?";
  			$stmt_delete = $pdo -> prepare($sql_delete);
  			$stmt_delete -> execute(Array($row));
      }
    }

    // 注文削除確認画面を生成するためのhtmlを格納する(引数:注文ID)
    private function generate_order_management_check($delete_order){
      try{
        // PDOインスタンスを生成
        $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
      }catch(Exception $e){
        // エラーメッセージ
        $res = $e -> getMessage();
      }

      // 削除しますか？の表記をいれる
      $this->order_management_html = "<p>以下の注文を削除しますか?</p>";

      // 削除する商品の情報を確認するための表を作成
      $this->order_management_html .= "<div class = \"table_order_management\">";
      $this->order_management_html .= "<table>";
      $this->order_management_html .= "<tr><th>料理名</th><th>座席</th></tr>";

      foreach($delete_order as $delete_order_id){ // 注文IDに対応する商品名、座席番号の取得
        $sql_check = "select productname, seatnum from orderaccept where orderid = ?";
  			$stmt_check = $pdo -> prepare($sql_check);
  			$stmt_check->execute(Array($delete_order_id));

        $row = $stmt_check->fetchAll();
        $this->order_management_html .= "<tr>";
        $this->order_management_html .= "<td>".$row[0]['productname']."</td>"; // why not? $stmt_check['productname']
        $this->order_management_html .= "<td>".$row[0]['seatnum']."</td>";
        $this->order_management_html .= "</tr>";
      }

      $this->order_management_html .= "</table>";
      $this->order_management_html .= "</div>";
    }

    // 注文削除確認画面を出力する(引数:注文ID)
    public function write_order_management_check($delete_order){
      $this->generate_order_management_check($delete_order);
      print_r($this->order_management_html);
    }


  }
?>
