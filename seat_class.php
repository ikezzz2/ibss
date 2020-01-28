<?php
class seat_class{
  private $dnsinfo = "mysql:dbname=ibss;host=localhost;charset=utf8";
  private $db_user = "root";
  private $db_pw = "";
  private $seat_check;
private function generate_seat_check(){//座席情報確認画面生成
  //現在時刻に予約情報が入っているか確認し、入っているなら使用中、入っていないなら空席と表示する
  $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
  $sql = "select seatnum from seatinfo";//座席数確保
  $stmt = $pdo->prepare($sql);
  $stmt->execute(null);
  $this->seat_check ="<table border=`1` width=`5000` cellspacing=`0` cellpadding=`5` bordercolor=`#333333`>";
  $this->seat_check .= "<tr><th>座席番号</th><th>座席情報</th></tr>";
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){//座席番号一つずつ取り出し
    $sql2 ="SELECT count(*)  FROM ordermanagement WHERE seatnum = ?  AND date = ? AND starthour <= ?
        AND finhour >= ?" ;//現在の予約を座席ごとに取り出してカウント
    $date = date("Y")."-".date("m")."-".date("d");
    $starthour = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
    $finhour = date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s");
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array($row["seatnum"],$date,$starthour,$finhour));
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    if($row2['count(*)'] > 0){//予約があるなら
      $this->seat_check .= "<tr><td>" .$row['seatnum']. "</td><td>使用中</td></tr>";
    }else{//ないとき
      $this->seat_check .= "<tr><td>" .$row['seatnum']. "</td><td>空席</td></tr>";
      }
      
    }
  $this->seat_check .= "</table>";
  }
  public function write_seat_check(){//座席情報確認画面出力
    $this->generate_seat_check();
    print_r($this->seat_check);
  }

  public function get_number_of_seat(){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "select distinct COUNT(seatnum) from seatinfo";//座席数確保
    $stmt = $pdo->prepare($sql);
    $stmt->execute(null);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["COUNT(seatnum)"];
  }

  public function today_reservation_check($seatnum){
    $start_hour = date("H") - 1;
    if($start_hour < 0){
      $start_hour = 0;
    }
    $finish_hour = date("H") + 4;
    if($finish_hour >= 23){
      $finish_hour = 23;
    }
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT * FROM ordermanagement WHERE seatnum = ".$seatnum." AND finhour >= ? ";
    $finhour = date("Y")."-".date("m")."-".date("d")." ".$start_hour.":00:00";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($finhour));
    $row = $stmt->fetchAll();
    return $row;
  }


  public function get_seat_list(){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT distinct seatnum FROM seatinfo";//座席数確保
    $stmt = $pdo->prepare($sql);
    $stmt->execute(null);
    $row = $stmt->fetchAll();
    return $row;
  }
  public function reservation_check($seatnum,$date){
    $start_hour = "00";
    $finish_hour = 23;
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT * FROM ordermanagement WHERE seatnum = ? AND date = ? AND
    starthour >= ? AND finhour <= ?";
    $date = $_POST["reservation_info"]["date_info"];
    $starthour = $_POST["reservation_info"]["date_info"]." 00:00:00";
    $finhour = $_POST["reservation_info"]["date_info"]." 23:59:00";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($seatnum,$date,$starthour,$finhour));
    $row = $stmt->fetchAll();
    return $row;
  }
  public function get_nomihoudai(){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT couseid,nomitime FROM nomimanagement" ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(null);
    $row = $stmt->fetchAll();
    return $row;
  }
  public function check_seat($POST){//座席選択画面で特定の時間の予約を取ってくる
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT distinct seatnum FROM ordermanagement WHERE date = ? AND
    ((finhour >= ?  AND finhour <= ?) OR
    (starthour >= ? AND starthour <= ?))";

    $date = substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2);
    $starttime = substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2)." ".$POST["reservation_info"]["starttime"].":00";
    $fintime = substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2)." ".$POST["reservation_info"]["finishtime"].":00'";
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array($date,$starttime,$fintime,$starttime,$fintime));
    $row = $stmt->fetchAll();
    return $row;
  }
  public function insertreservation($POST){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    foreach ($POST["seatnum"] as $key) {
      $sql = "INSERT INTO ordermanagement (`seatnum`, `date`, `name`, `phonenum`, `numofpeople`, `starthour`, `finhour`, `couseid`) VALUES (?,?,?,?,?,?,?,?)";
        $dateinfo = $POST['reservation_info']['date_info'];
        $name = $POST['reservation_info']['name'];
        $phonenumber = $POST['reservation_info']['phonenumber'];
        $people = $POST['reservation_info']['people'];
        $start = $POST['reservation_info']['date_info']." ".$POST['reservation_info']['starttime'] ;
        $fin = $POST['reservation_info']['date_info']." " .$POST['reservation_info']['finishtime'];
        $couse = $POST['reservation_info']['example'];
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($key,$dateinfo,$name,$phonenumber,$people,$start,$fin,$couse));
      }
    }
  public function generate_reservation_edit($seatnum,$POST){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT * FROM ordermanagement WHERE date = ? AND seatnum = ?" ;
    $date = substr($POST,0,4)."-".substr($POST,5,2)."-".substr($POST,8,2);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($date,$seatnum));
    $row = $stmt->fetchAll();
    return $row;
  }
  public function updatename($id,$name,$POST){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "UPDATE ordermanagement SET  name = ? WHERE starthour = ? AND seatnum = ?";
    $starthour = substr($POST,0,4)."-".substr($POST,5,2)."-".substr($POST,8,2)." ".substr($id,0,8);
    $seatnum = substr($id,8,2);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($name,$starthour,$seatnum ));
  }
  public function get_reservation($resid){//入力画面に入れる予約をとる
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT * FROM ordermanagement WHERE starthour = ?";
    $sql .=  " AND seatnum = ?";
    $starthour = substr($_POST["reservation_info"]["date_info"],0,4)."-".substr($_POST["reservation_info"]["date_info"],5,2)."-".substr($_POST["reservation_info"]["date_info"],8,2)." ".substr($resid,0,8);
    $seatnum = substr($resid,8,2);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($starthour,$seatnum));
    $row = $stmt->fetchAll();
    return $row;

  }
  public function update_reservation($id,$POST){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $key = array_keys($id);
    print_r($_POST["seatnum"]);

    $sql = "UPDATE ordermanagement SET  seatnum = ?,  name = ? ,phonenum = ? ,numofpeople = ?
    ,couseid = ? ,starthour = ?,finhour = ?
    WHERE starthour = ?  AND seatnum = ?";
    $starthour =substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2)." ".$POST["reservation_info"]["starttime"] .":00";
    $finhour = substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2)." ".$POST["reservation_info"]["finishtime"] .":00";
    $realtime = substr($POST["reservation_info"]["date_info"],0,4)."-".substr($POST["reservation_info"]["date_info"],5,2)."-".substr($POST["reservation_info"]["date_info"],8,2)." ".$POST["realtime"] .":00";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($POST["seatnum"][0],$POST["reservation_info"]["name"],$POST["reservation_info"]["phonenumber"],$POST["reservation_info"]["people"],$POST["reservation_info"]["example"],$starthour,$finhour,$realtime,substr($id[$key[0]],8,2)));

    /*
    UPDATE `ordermanagement` SET `seatnum`=[value-1],`date`=[value-2],`name`=[value-3],`phonenum`=[value-4],`numofpeople`=[value-5],`starthour`=[value-6],`finhour`=[value-7],`couseid`=[value-8] WHERE 1
    $stmt = $pdo->prepare($sql);
    $stmt->execute(null);
    */
  }
  public function delete_check($key){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "SELECT * FROM ordermanagement WHERE starthour = ? AND seatnum = ?";
    $stmt = $pdo->prepare($sql);
    $starthour = $_POST["reservation_info"]["date_info"]." ".substr($key,0,8);
    $stmt->execute(array($starthour,substr($key,8,2)));
    $row = $stmt->fetchAll();
    return $row;
  }

  public function reservation_delete($key){
    $pdo = new PDO($this->dnsinfo, $this->db_user, $this->db_pw);
    $sql = "DELETE FROM ordermanagement WHERE starthour = ? AND seatnum = ?";
    $starthour = $_POST["reservation_info"]["date_info"]." ".substr($key,0,8);
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($starthour,substr($key,8,2)));


  }

}
//ordermanagementの主キー変更 fin hour -> finhour
?>
