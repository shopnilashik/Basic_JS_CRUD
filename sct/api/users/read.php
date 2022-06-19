<?php 
  // Headers

    ini_set('display_errors', 1);
  error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

 
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  

  // Instantiate blog post object
  $users = new Users($db);
  // Blog post query
  $result = $users->read();
//    echo $result,die();

  //Get row count
  $num = $result->rowCount();
  
  // Check if any posts
  if($num > 0) {
    // Post array
    $users_arr = array();
    // $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        
      extract($row);

      $users_item = array(
        'id' =>  $id,
        'name' => $name,
        'email' => $email,
        'password' => $password
        
      );
      
      // Push to "data"
      array_push($users_arr, $users_item);
      // array_push($posts_arr['data'], $post_item);
    }

    // Turn to JSON & output
    echo json_encode($users_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }


?>
