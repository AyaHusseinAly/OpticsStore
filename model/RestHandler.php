<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestHandler
 *
 * @author memad
 */
class RestHandler {

    //put your code here
    private $url;
    private $method;
    private $allowed_methods = array("get","post","put","delete");
    private $parameters;  //post and delete
    private $resource;
    private $resource_id = "";  //get, delete , put //initial value 34an myb2ash null fe el post
    private $db_h;

    public function __construct() {

        $this->db_h= new mysqli_connect();
        
        $this->method=$_SERVER["REQUEST_METHOD"];
        if(!in_array(strtolower($this->method),$this->allowed_methods)){
            $this->send_error(405,"Method is not suppported");
        }
        $this->url=$_SERVER["REQUEST_URI"];
        $this->read_resource();
        $this->prepare_response();

    }

    public function send_data($results=array(),$success_code=200) {
        header("Content-Type: application/json");
        http_response_code($success_code);
        echo json_encode($results);
        exit();
    }

    public function send_error($error_code, $error_message = "") {
        header("Content-Type: application/json");
        http_response_code($error_code);
        echo json_encode(array("error"=>$error_message));
        exit();
    }

    public function read_resource() {
        $url_pieces=explode("/",$this->url);
        if(is_numeric($url_pieces[count($url_pieces)-1])){ //get last one it's id
            $this->resource_id=$url_pieces[count($url_pieces)-1];
            $this->resource=$url_pieces[count($url_pieces)-2];
        }
        else{
            $this->resource=$url_pieces[count($url_pieces)-1];
        }
    }
    
    public function prepare_response(){
       switch (strtolower($this->method)) {
           case "get":
               $this->prepare_response_get();
           break;
           case "post":
               $this->prepare_response_post();
           break;
           case "delete":
               $this->prepare_response_delete();
           break;
           case "put":
               $this->prepare_response_put();
           break;
       }
    }
    
    private function prepare_response_get(){
        $data=($this->db_h)->get_record($this->resource_id);
        $resObj=array(
            "id"=>$data[0][0],
            "product_code"=>$data[0][1],
            "product_name"=> $data[0][1],
            "photo"=>$data[0][2],
            "list_price"=> $data[0][3],
            "reorder_level"=>$data[0][4],
            "units_in_stock"=> $data[0][5],
            "category"=> $data[0][6],
            "country"=> $data[0][7],
            "rating"=> $data[0][8],
            "discontinued"=> $data[0][9],
            "date"=> $data[0][10]
        

        );
        $this->send_data($resObj);     
     
    }
    
    private function  prepare_response_post(){
      
        $entityBody = file_get_contents('php://input');

        $fetchedData=json_decode($entityBody,true);
        ($this->db_h)->insert_record($fetchedData);
        header("Content-Type: application/json");
        http_response_code(200);
        echo "{'success':'Record was inserted Successfully'}";
        exit();
        
    }
    
    private function prepare_response_delete(){
        $data=($this->db_h)->delete_record($this->resource_id);
        header("Content-Type: application/json");
        http_response_code(200);
        echo "{'success':'Record was deleted Successfully'}";
        exit();
        
    }
    
    private function prepare_response_put(){
        
        $entityBody = file_get_contents('php://input');
        
        $fetchedData=json_decode($entityBody,true);
        $keys=array_keys($fetchedData);
        $value= $fetchedData[array_keys($fetchedData)[0]];

        $data=($this->db_h)->update_record($keys[0],$value,$this->resource_id);
        header("Content-Type: application/json");
        http_response_code(200);
        echo "{'success':'Record was updates Successfully'}";
        exit();
        
        
    }
    
    
    

}
