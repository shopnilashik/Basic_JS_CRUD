<?php
    class Users{
           // DB stuff
    private $conn;
    private $table = 'users';
  
  // Constructor with DB
    public function __construct(\PDO $db) {
      $this->conn = $db;
    }
  // Create Post
    public function create() {
        try {
            $query = 'INSERT INTO ' . $this->table . ' SET name = :name, email = :email, password = :password';
          
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          
          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->password = htmlspecialchars(strip_tags($this->password));
          

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':password', $this->password);
          
          // if($this->name && $this->email && $this->password = null){
            
          //  }
         if($this->name && $this->email && $this->password > 0){
              // Execute query
             if($stmt->execute()) {
                return true;
            }
          }
        } catch(PDOException $e) {
          // $e->getMessage()
          return false;
        }
    }
    



    // Get Users
    public function read() {
      // Create query
      $query = 'SELECT * FROM `users`';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
       
      // Execute query
      $stmt->execute();
      
      return $stmt;
      
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM `users` 
                                    WHERE
                                      id = ?
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
          $this->name = $row['name'];
          $this->email = $row['email'];
          $this->password = $row['password'];
          
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


    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET name = :name, email = :email, password = :password
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->password = htmlspecialchars(strip_tags($this->password));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':name', $this->name);
          $stmt->bindParam(':email', $this->email);
          $stmt->bindParam(':password', $this->password);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    } 


    }
?>

