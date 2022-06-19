<?php 
  // Headers
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $product = new Products($db);
  
  // Get ID
  $product->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $product->read_single();
 
  // Create array
  $product_arr = array(
        'id' => $product->id,
        'p_name' => $product->p_name,
        'p_details' => $product->p_details,
        'p_category' => $product->p_category,
        'p_price' => $product->p_price,
        'category_name' =>$product->category_name
  );

  // Make JSON
  print_r(json_encode($product_arr));