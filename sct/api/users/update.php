<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate User object
  $user = new Users($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  // print_r($data);
  // echo json_encode($data);
  
  // Set ID to update
  $user->id = $data->id;
  $user->name = $data->name;
  $user->email = $data->email;
  $user->password = $data->password;

  print_r($user);
  // Update user
  if($user->update()) {
    echo json_encode(
      array('message' => 'User Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'User Not Updated')
    );
  }

