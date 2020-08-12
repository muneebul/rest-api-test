<?php
 

header('content-type: application/json');

      $request=$_SERVER['REQUEST_METHOD'];
      // print_r($_GET);
      // die;

   switch ( $request) {
   	case 'GET':
   	  getmethod($_GET);
   	break;
   	case 'PUT':
          $data=json_decode(file_get_contents('php://input'),true);
         putmethod($data);
   	break;
   	case 'POST':
   		$data=json_decode(file_get_contents('php://input'),true);
         postmethod($data);
   	break;
   	case 'DELETE':
   		$data=json_decode(file_get_contents('php://input'),true);
         deletemethod($data);
   	break;
   	
   	default:
   		echo '{"name": "data not found"}';
   		break;
   }


//data read part are here
function getmethod($data){
  $id = $data["id"];
  $fmt = isset($data["fmt"]) ? true : false;
  include "db.php";
  $sql = "SELECT * FROM user ";
  if(isset($id)){
  	$sql .= "WHERE id =".$id;
  } 
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
       $rows=array();
       while ($r = mysqli_fetch_assoc($result)) {

          $rows["result"][] = $r;
       }
       if($fmt && $id){
       echo implode($rows["result"][0], ',');
       }else{
       echo json_encode($rows);
      }
   }else{
      echo '{"result": "no data found"}';
    }
}


//data insert part are here
function postmethod($data){
   include "db.php";
   $name=$data["name"];
   $email=$data["email"];
   $phone=$data["phone"];
   $city=$data["city"];

   $sql= "INSERT INTO user(name,email,phone,city) VALUES ('$name' , '$email', '$phone' , '$city'";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "data inserted"}';
   } else{

      echo '{"result": "data not inserted"}';
   }



}

//data edit part are here
function putmethod($data){
   include "db.php";
   $id=$data["id"];
   $name=$data["name"];
   $email=$data["email"];
   $phone=$data["phone"];
   $city=$data["city"];


   $sql= "UPDATE user SET name='$name', email='$email', phone='$phone', city ='$city' where id='$id'  ";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "Update Succesfully"}';
   } else{

      echo '{"result": "not updated"}';
   }



}

//delete method are here,,,,,,,,,,,,,,
function deletemethod($data){
   include "db.php";
   $id=$data["id"];
   $sql= "DELETE FROM user where id=$id";

   if (mysqli_query($conn , $sql)) {
      echo '{"result": "delete Succesfully"}';
   } else{

      echo '{"result": "not deleted"}';
   }
}
?>
