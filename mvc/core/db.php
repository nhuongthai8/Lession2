<?php
class db{
    public $con;
    protected $host = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "btphp";

    function __construct(){
        $this->con = mysqli_connect($this->host,$this->username,$this->password);
        mysqli_select_db($this->con,$this->dbname);
        mysqli_query($this->con, "SET NAMES 'utf8'");
    }

}
?>