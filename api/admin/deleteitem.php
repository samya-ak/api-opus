<?php 
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Authorization, Content-Type');
  header('content-type: multipart/form-data; charset=utf-8');
  header('Access-Control-Max-Age: 1728000');
  header('Content-Length: 0');
  die();
}

header("Access-Control-Allow-Origin: *");
header('content-type: multipart/form-data; charset=utf-8');

  include_once '../../config/Database.php';
  include_once '../../models/Delete.php';

  //Instantiate db and connect

  $database = new Database();
  $db = $database->connect();

  //Instantiate  object
  $item = new Delete($db);
  $data = json_decode(file_get_contents("php://input"));

  if(!empty($data->book_id)){
    $item->book_id = $data->book_id;
    if($item->delete_item()){
      //make json
      print_r(json_encode(
        array('message' => "Book has been removed.")
      ));
    }else{
      print_r(json_encode(
        array('message' => "Book Id is invalid.")
      ));
      http_response_code(400);
    }
  }else{
    print_r(json_encode(
      array('message' => "Book Id is not given.")
    ));
    http_response_code(400);
  }


  