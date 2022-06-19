<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  
    class Products{
           // DB stuff
    private $conn;
    private $table = 'products';
  
    public $id;
    public $p_name;
    public $p_details;
    public $p_category;
    public $p_price;
    public $image;
  // Constructor with DB
    public function __construct(\PDO $db) {
      $this->conn = $db; 
    }
  
  // Create Post
    public function create() {
          // Create query
          try{
            
          $query = 'INSERT INTO ' . $this->table . ' SET p_name = :p_name, p_details = :p_details, p_category = :p_category, p_price = :p_price ,image = :image';

          // Prepare statement
          $stmt = $this->conn->prepare($query);
          
          // Clean data
          $this->p_name = htmlspecialchars(strip_tags($this->p_name));
          $this->p_details = htmlspecialchars(strip_tags($this->p_details));
          $this->p_category = htmlspecialchars(strip_tags($this->p_category));
          $this->p_price = htmlspecialchars(strip_tags($this->p_price));
          $this->image = htmlspecialchars(strip_tags($this->image));
          
        
          // Bind data
          $stmt->bindParam(':p_name', $this->p_name);
          $stmt->bindParam(':p_details', $this->p_details);
          $stmt->bindParam(':p_category', $this->p_category);
          $stmt->bindParam(':p_price', $this->p_price);
          $stmt->bindParam(':image', $this->image);

        //  print_r($this->p_details); 
          
          if($this->p_name && $this->p_details && $this->p_category && $this->p_price && $this->image > 0){
            // echo 123;die();÷
              // Execute query
             if($stmt->execute()) {
                return true;
            }
          }
        } 
        catch(PDOException $e) {
          return $e->getMessage();
        }


    }


    // Get Product
    public function read() {
      // Create query
      $query = 'SELECT c.name as category_name, p.id, p.p_category, p.p_name, p.p_details, p.p_price, p.image
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.p_category = c.id
                               ';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
     
      // Execute query
      $stmt->execute();
      return $stmt;
    }



    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT c.name as category_name, p.id, p.p_category, p.p_name, p.p_details, p.p_price
                                    FROM ' . $this->table . ' p
                                    LEFT JOIN
                                      categories c ON p.p_category = c.id
                                    WHERE
                                      p.id = ?
                                    LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->id = $row['id'];
          $this->p_name = $row['p_name'];
          $this->p_details = $row['p_details'];
          $this->p_category = $row['p_category'];
          $this->p_price = $row['p_price'];
          $this->category_name = $row['category_name'];
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET p_name = :p_name, p_details = :p_details, p_category = :p_category, p_price = :p_price, image = :image
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->p_name = htmlspecialchars(strip_tags($this->p_name));
          $this->p_details = htmlspecialchars(strip_tags($this->p_details));
          $this->p_category = htmlspecialchars(strip_tags($this->p_category));
          $this->p_price = htmlspecialchars(strip_tags($this->p_price));
          $this->id = htmlspecialchars(strip_tags($this->id));
          $this->image = htmlspecialchars(strip_tags($this->image));

          // Bind data
          $stmt->bindParam(':p_name', $this->p_name);
          $stmt->bindParam(':p_details', $this->p_details);
          $stmt->bindParam(':p_category', $this->p_category);
          $stmt->bindParam(':p_price', $this->p_price);
          $stmt->bindParam(':id', $this->id);
           $stmt->bindParam(':image', $this->image);
          

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    } 



    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    // Fetch Catagories
     public function readCategories() {
      // Create query
      $query = 'SELECT * FROM `categories`';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
       
      // Execute query
      $stmt->execute();
      
      return $stmt;
      
    }

      
}

    


?>