<?php
class order_input_class{
    private $dnsinfo = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_user = "root";
    private $db_pw = "";

    
    // public function get_seat_number(){
    //     $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
    //     $sql = "select seatnum from seatinfo order by seatnum ASC";
    //     $stml = $pdo->prepare($sql);
    //     $stml -> execute(null);
    //     $row = $stml->fetchAll();
    //     return $row;
    // }

    public function get_seat_number(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "SELECT DISTINCT seatnum FROM ordermanagement WHERE starthour <= '".date('Y-m-d H:i:s')."' order by seatnum ASC";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
        return $row;
    }

    public function get_category(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "select distinct category from menutable order by category ASC";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
        return $row;
    }

    public function get_menu(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "select productname, category, value from menutable";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
        return $row;
    }

    public function input_menu($menu_name, $seat_num, $value){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "INSERT INTO orderaccept( productname , seatnum, servingflag, value) VALUES (?, ?, 0,?)";
        //$sql = "INSERT INTO orderaccept( productname , seatnum, servingflag, value) VALUES ('".$menu_name."', ".$seat_num.", 0, ".$value[0][0].")";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($menu_name,$seat_num,$value[0][0]));
        $row = $stml->fetchAll();
    }

    public function get_max_orderid(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "SELECT max(orderid) FROM orderaccept";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
        return $row;
    }

    public function get_value($name){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "SELECT value FROM menutable where productname = ?";
        // $sql = "SELECT value FROM menutable where productname = '$name'";
        $stml = $pdo->prepare($sql);
        $stml -> execute(array($name));
        $row = $stml->fetchAll();
        return $row;

    }

}
?>
