<?php 
  // Headers
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
 
  // Instantiate blog post object
  $product = new Products($db);
  $data = json_decode(file_get_contents("php://input"));
  // var_dump($_POST);die();

  $ProductDetails = $_POST['ProductDetails'];
  $categoriy_id = $_POST['categoriy_id'];
  $ProductPrice = $_POST['ProductPrice'];
  $image = $_FILES;
  $remove_image = $_POST['u_image'];
  // Get raw posted data
  

  $target_file = $image;
  $target_dir = "_crud/src/img/";
  $file_name = basename($_FILES["image"]["name"]);
  $target_file = $target_dir.$file_name;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $image = $_FILES['image']["name"];
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
  // REMOVE PICTURE
  if (unlink("test/src/img/".$remove_image)) {
    echo 'The file ' . $remove_image . ' was deleted successfully!';
  } else {
    echo 'There was a error deleting the picture ' . $remove_image;
  }
  // Set ID to update
  $product->id = $_POST['id'];
  $product->p_name = $_POST['ProductName'];
  $product->p_details = $ProductDetails;
  $product->p_category = $categoriy_id;
  $product->p_price = $ProductPrice;
  $product->image =$file_name;

  // Update post
  if($product->update()) {
    echo json_encode(
      array('message' => 'Product Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Product Not Updated')
    );
  }

