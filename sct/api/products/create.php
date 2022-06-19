<?php 
  // Headers
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate prduct object
  $product = new Products($db);
  $ProductName = "";

  
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
// var_dump($_FILES);die();
  // $ProductName = $_POST['$ProductName'];
  $ProductDetails = $_POST['ProductDetails'];
  $categoriy_id = $_POST['categoriy_id'];
  $ProductPrice = $_POST['ProductPrice'];
  $image = $_FILES;
  // print_r($ProductName);
 

  

  // print_r($_FILES);
  
  $target_file = $image;
  $target_dir = "RUF/src/img/";
  $file_name = basename($_FILES["image"]["name"]);
  $target_file = $target_dir.$file_name;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $image = file_get_contents($_FILES['image']["tmp_name"]);
  // $imgContent = addslashes(file_get_contents($image)); 
            
  //Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

  $product->p_name = $_POST['ProductName'];
  $product->p_details = $ProductDetails;
  $product->p_category = $categoriy_id;
  $product->p_price = $ProductPrice;
  $product->image =$file_name;
  
  
  // Create product
  echo json_encode($product->create());

  if($product->create()) {
    echo json_encode(
      array('message' => 'Product Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Product Not Created')
    );
  }


  ?>

