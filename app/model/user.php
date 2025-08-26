<?php
class User{
    private $user_id;
    private bool $is_admin;
    private $first_name;
    private $last_name;
    private $profile_picture;
    private $email;
    private $password;
    private $created_date;
    private $updated_date;
    

    private $conn;

   

    
    public static function findByEmail($email) {
        
        $pdo = getDB(); // Need to implement this connection.

        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ? $user : false;
    }
}

?>