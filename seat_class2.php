<?php
class seat_class{
    private $dnsinfo = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_user = "root";
    private $db_pw = "";

    public function get_seat_number(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "select distinct seatnum from orderaccept order by seatnum ASC";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
        return $row;
    }

    public function sum_pay($A){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        //$sql = "select sum(value) from orderaccept where seatnum =".$A;
        $sql = "select sum(value) from orderaccept where seatnum =? and servingflag=1";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($A));
        $row = $stml->fetchAll();
        return $row;
    }

    public function pic_order($A){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        //$sql = "select productname, count(productname) from orderaccept where seatnum =".$A. " group by productname";
        $sql = "select productname, count(productname) from orderaccept where seatnum =? and servingflag=1 group by productname";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($A));
        $row = $stml->fetchAll();
        return $row;
    }

    public function del_order($A){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        // $sql = "DELETE FROM orderaccept WHERE seatnum =".$A;
        $sql = "DELETE FROM orderaccept WHERE seatnum =?";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($A));
    }

    public function get_info($seat_num){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "SELECT starthour FROM ordermanagement WHERE seatnum =? AND date= '".date('Y-m-d'). "' ORDER BY date ASC";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($seat_num));
        $row = $stml->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function del_management($seat_num, $time){
        //print_r($time);
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "DELETE FROM ordermanagement WHERE seatnum=? AND date='".date('Y-m-d')."' AND starthour=?";
        //print_r($sql);
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($seat_num, $time["starthour"]));
    }
}
?>
