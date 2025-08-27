<?php

class User {
    private $db;

    public function __construct() {
       
        require_once __DIR__ . '/../../config/config.php';
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Create a new user in the database.
     * @param array $data User data (first_name, last_name, email, password)
     * @return bool True on success, false on failure.
     */
    public function create($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    /**
     * Find a user by their email address.
     * @param string $email
     * @return mixed User data array if found, false otherwise.
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Find a user by their ID.
     * @param int $id
     * @return mixed User data array if found, false otherwise.
     */
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update a user's profile information.
     * @param int $id User ID
     * @param array $data Data to update (e.g., ['first_name' => 'John'])
     * @return bool True on success, false on failure.
     */
    public function update($id, $data) {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':first_name', $data['first_name']);
        $stmt->bindParam(':last_name', $data['last_name']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
    
    /**
     * Update a user's profile picture filename.
     * @param int $id User ID
     * @param string $filename The new filename for the profile picture.
     * @return bool True on success, false on failure.
     */
    public function updateProfilePicture($id, $filename) {
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':profile_picture', $filename);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Delete a user's account.
     * @param int $id User ID
     * @return bool True on success, false on failure.
     */
    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

?>
