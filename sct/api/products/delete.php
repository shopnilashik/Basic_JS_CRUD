<?php 
  // Headers
   ini_set('display_errors', 1);
  error_reporting(E_ALL);
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Products.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $product = new Products($db);
  
  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  // $image = $_POST['image'];
  if (unlink("test/src/img/".$data->image)) {
	echo 'The file ' . $data->image . ' was deleted successfully!';
} else {
	echo 'There was a error deleting the picture ' . $data->image;
}
  // Set ID to update
  $product->id = $data->id;

  // Delete post
  if($product->delete()) {
    echo json_encode(
      array('message' => 'Product Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Product Not Deleted')
    );
  }
?>
