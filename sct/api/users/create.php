<?php
  // Headers
  // ini_set('display_errors', 1);
  // error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

   // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

    // Instantiate blog post object
  $users = new Users($db);

  // echo 123;die();
  
 
//   // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  
  $users->name = $data->name;
  $users->email = $data->email;
  $users->password = $data->password;
  
  
      if($users->create()) {
        
    echo json_encode(
      array('message' => 'User Created')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Created')
    );
  }
  
 

?>