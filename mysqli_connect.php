<?php

require_once("config.php");
require_once("DbHandler.php");

class mysqli_Handler implements DbHandler{
    private $db_handler;

    public function connect(){
        $this->db_handler=mysqli_connect(__host__,__user__,__pass__,__db__); 
    }
    
    public function disconnect(){
        mysqli_close($this->db_handler);
    } 

    public function get_page($index){
        if($this->db_handler){
            
            //$result_handler=mysqli_query($this->db_handler,"select * from `items` limit". $index." , ".($index+5));
            $result_handler=mysqli_query($this->db_handler,"select * from `items` limit $index , 5");
            $results=mysqli_fetch_all($result_handler);
            return $results;
            
        }
        else{
            echo mysqli_connect_error();
        
        }
    }
    public function get_numberOfRecords(){
        $result_handler=mysqli_query($this->db_handler,"select * from `items` ");
        $results=mysqli_fetch_all($result_handler);
        $number= count($results);
        return $number;
        
    }
    public function get_all_records(){
        if($this->db_handler){
            $result_handler=mysqli_query($this->db_handler,"select * from `items`");
            $results=mysqli_fetch_all($result_handler);
            return $results;
            
        }
        else{
            echo mysqli_connect_error();
        
        }
    }
    
    public function get_data($fields = array(),  $start = 0){}
    public function get_record($index){
        $result_handler=mysqli_query($this->db_handler,"select * from `items` where id=$index");
        $results=mysqli_fetch_all($result_handler);
        return $results;
    }
}

/*
$db=mysqli_connect($host,$username,$password,$database);

if($db){
    $result_handler=mysqli_query($db,"select * from `items`");
    $results=mysqli_fetch_all($result_handler);
    var_dump($results);
    mysqli_close($db);
}
else{
    echo mysqli_connect_error();

}
*/