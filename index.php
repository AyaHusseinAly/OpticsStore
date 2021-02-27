<?php

$current_index=0;
$next_index=$current_index+5;
$prev_index=$current_index-5;


require_once("mysqli_connect.php");

$mysqli_obj= new mysqli_Handler();

$mysqli_obj->connect();

echo "<style>
body{
  background-color:E2D9CA;
  padding:70px;
}
p,a,table{
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  background-color:#FAEBD7;
}
</style>";

if(isset($_GET['id'])){
  $record=$mysqli_obj->get_record($_GET['id']);
  $mysqli_obj->disconnect();
  /*
  echo "<pre>";
  print_r($record);
  echo "</pre>";
*/
  echo "
  <h4 align='center' style='color:#DC143C'><ins>Glasses Model ".$record[0][2]."</ins></h4>
        <table style='border:1px solid black' align='center'>
        <tr><th style='border:1px solid black' >Type:".$record[0][2]."</th><th style='border:1px solid black' >Price:".$record[0][4]."</th></tr>
        <tr><td style='border:1px solid black' ><strong>Details:</strong></br>code:".$record[0][1]."</br>item id:".$record[0][0]."</br>rating:".$record[0][9]."</td><td style='border:1px solid black' ><img src='images/".$record[0][3]."'></img></td></tr>
        </table>";

}
else{
    if(isset($_GET['next'])){
      $current_index=$_GET['next'];
      $next_index=$current_index+5;
      $prev_index=$current_index-5;

      
    }
    else if(isset($_GET['prev'])){
      $current_index=$_GET['prev'];
      $next_index=$current_index+5;
      $prev_index=$current_index-5;

    }
    $table_data=$mysqli_obj->get_page($current_index);
    $number_of_records=$mysqli_obj->get_numberOfRecords();
    $mysqli_obj->disconnect();

 
    echo "<h3 align='center' style='color:#DC143C; margin:30px;'> <ins>Welcome to our Optics Store</ins>  </h3> " ;

    echo "<table align='center' style='width:50%;padding:10px; height:50%'><tr><th>Item ID</th><th>Name</th><th>Details</th></tr>";

    //ob_start();

    foreach($table_data as $data){
        echo "<tr align='center'><td>".$data[0]."</td><td>".$data[2]."</td><td><a href='index.php?id=$data[0]'>more</a></td></tr>";

    }


    echo "</table></br></br> <div align='center' >";
    if($prev_index<0){
      echo "<p style='margin: 50px;color:grey; display:inline;background-color:#FAEBD7;padding:5px' >Prev</p><a style=' background-color:#FAEBD7;padding:5px' href='index.php?next=$next_index'>Next</a>";

    }
    else if ($next_index>$number_of_records){
      echo "<a style=' background-color:#FAEBD7;padding:5px' href='index.php?prev=$prev_index'>Prev</a><p style='margin: 50px;color:grey; display:inline;background-color:#FAEBD7;padding:5px' >Next</p>";
    }
    else{
    echo "<a style='margin: 50px; background-color:#FAEBD7;padding:5px' href='index.php?prev=$prev_index'>Prev</a><a style=' background-color:#FAEBD7;padding:5px' href='index.php?next=$next_index'>Next</a>";
    }
    echo "</div>";

}