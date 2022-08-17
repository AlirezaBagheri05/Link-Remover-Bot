<?php

// CREATE TABLE `eawallir_firstbot`.`jock` ( `id` INT NOT NULL , `name` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `value` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , `maker` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

// tables
define('JBOT','jock');
define('PBOT','poem');

class lib{
    private $SERVER_NAME;
    private $USER_NAME;
    private $USER_PASSWORD;
    private $DB_NM;

    public function __Construct($SERVER_NAME,$USER_NAME,$USER_PASSWORD,$DB_NM){
        $this->SERVER_NAME = $SERVER_NAME;
        $this->USER_NAME = $USER_NAME;
        $this->USER_PASSWORD = $USER_PASSWORD;
        $this->DB_NM = $DB_NM;
    }

    private function cov(){
        $SERVER_NAME = $this->SERVER_NAME;
        $USER_NAME = $this->USER_NAME;
        $USER_PASSWORD = $this->USER_PASSWORD;
        $DB_NM = $this->DB_NM;
        $all =  array(
            'S'=>$SERVER_NAME,
            'UN'=>$USER_NAME,
            'UP'=>$USER_PASSWORD,
            'D'=>$DB_NM
        );
        return $all;
    }
    private function connect(){
        $all = $this->cov();
        $link = mysqli_connect($all['S'],$all['UN'],$all['UP'],$all['D']);
        if (mysqli_connect_errno($link)){
            return "Failed to connect to MySQL: " . mysqli_connect_error($link);
        }
        return $link;
    }

    private function query($qr){
        $link = $this->connect();
        if(empty($qr)){
            return "qurery is empty";
        }
        $result = mysqli_query($link,$qr);
        // if(mysql_errno($result)){
        //     return mysql_errno($result) . ": " . mysql_error($result). "\n";
        // }
        return $result;
    }

    public function insert_jock($name,$value,$maker){
        $qr = "INSERT INTO `".JBOT."` (`id`, `name`, `value`, `maker`) VALUES (NULL, '$name', '$value', '$maker');";
        $result = $this->query($qr);
        return $result;
    }

    public function select_jock($id){
        $qr = "SELECT `name`, `value`, `maker` FROM `".JBOT."` WHERE id = '$id'";
        $result = $this->query($qr);
        $row = mysqli_fetch_array($result);
        return $row;
        mysqli_close($link);
    }

    public function insert_poem($name,$value,$maker){
        $qr = "INSERT INTO `".PBOT."` (`id`, `name`, `value`, `maker`) VALUES (NULL, '$name', '$value', '$maker');";
        $result = $this->query($qr);
        return $result;
    }

    public function select_poem($id){
        $qr = "SELECT `name`, `value`, `maker` FROM `".PBOT."` WHERE id = '$id'";
        $result = $this->query($qr);
        $row = mysqli_fetch_array($result);
        return $row;
        mysqli_close($link);
    }

    public function count($dbname){
        $qr = "select * from ".$dbname;
        $result = $this->query($qr);
        return mysqli_num_rows($result);
        mysqli_close($link);
    }
    
}