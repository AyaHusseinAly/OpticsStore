<?php

//require_once("config.php");
//require_once("DbHandler.php");

class mysqli_connect implements DbHandler{
    private $db_handler;
    public function __construct(){
        $this->connect();
    }

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

    public function delete_record($index){
        mysqli_query($this->db_handler,"delete from `items` where id=$index");
        $this->disconnect();
 
    }

    public function update_record($field,$value,$index){
        mysqli_query($this->db_handler,"update `items` set $field=$value where id=$index");
        $this->disconnect();
 
    }

    public function insert_record($val){
        
        $values=array_values($val);
        //print_r($values);
        //echo $values[0];echo $values[1];echo $values[2];echo $values[3];echo $values[4];echo $values[5];
   
        mysqli_query($this->db_handler,'insert into `items` values("'.$values[0].'","'.$values[1].'","'.$values[2].'","'.$values[3].'","'.$values[4].'","'.$values[5].'","'.$values[6].'","'.$values[7].'","'.$values[8].'","'.$values[9].'","'.$values[10].'","'.$values[11].'");');
        $this->disconnect();
    }
}

