<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Users.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $users = new Users($db);

  // Get ID
  $users->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $users->read_single();


  // Create array
  $users_arr = array(
    'id' => $users->id,
    'name' => $users->name,
    'email' => $users->email,
    'password' => $users->password
    
  );

  // Make JSON
  print_r(json_encode($users_arr));