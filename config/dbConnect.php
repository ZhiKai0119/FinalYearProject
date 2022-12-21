<?php
    class DBConfig{
        //Connect to database
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $database = "r&s";
    public $conn;
        
    function __construct(){
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
    }

    function selectQuery($query){
        $result = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            $array[] = $row;
        }
    
        return $array;
    }

    function executeQuery($query){
       return mysqli_query($this->conn, $query);
    }

    
    }
?>