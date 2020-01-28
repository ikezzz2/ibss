<?php
class login_class{
    private $dnsinfo = "mysql:dbname=ibss;host=localhost;charset=utf8";
    private $db_user = "root";
    private $db_pw = "";

    public function ses_start(){
        session_start();
        if (!isset($_SESSION['login'])) {
            header("Location:login_main.php");
        }
    }

    public function delete_yesterday(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "DELETE FROM ordermanagement WHERE date<'".date('Y-m-d')."'";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();
    }

    public function delete(){
        $pdo = new PDO($this->dnsinfo, $this ->db_user, $this->db_pw);
        $sql = "DELETE FROM ordermanagement WHERE finhour<'".date('Y-m-d H:i:s' , strtotime('-2 hour'))."'";
        $stml = $pdo->prepare($sql);
        $stml -> execute(null);
        $row = $stml->fetchAll();

    }



}
?>