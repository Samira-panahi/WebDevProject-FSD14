<?php

require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../helpers/Session.php'; // Assuming a Session helper

class AuthController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
        Session::start(); // Start session using the helper
    }

    // --- REGISTRATION ---
    public function register() {
        
       if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        
        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'confirm_password' => $_POST['confirm_password'] ?? ''
        ];
        
        if (empty($data['first_name']) || empty($data['email']) || empty($data['password'])) {
            Session::flash('message', 'Please fill out all required fields.');
            header('Location: ' . BASE_URL . '/public/register.php');
            exit();
        }
        if ($data['password'] !== $data['confirm_password']) {
            Session::flash('message', 'Passwords do not match.');
            header('Location: ' . BASE_URL . '/public/register.php');
            exit();
        }
        if ($this->userModel->findByEmail($data['email'])) {
            Session::flash('message', 'This email address is already registered.');
            header('Location: ' . BASE_URL . '/public/register.php');
            exit();
        }

        // Attempt to register user
        if ($this->userModel->create($data)) {
            // Registration successful, now log the user in automatically.
            $newUser = $this->userModel->findByEmail($data['email']);

            if ($newUser) {
                // Set the session variables to log them in
                Session::set('user_id', $newUser['id']);
                Session::set('user_role', $newUser['role']);
                Session::set('user_first_name', $newUser['first_name']);
                
                // Redirect to the new public profile page
                header('Location: ' . BASE_URL . '/public/profile.php');
                exit();
            }
        } else {
            Session::flash('message', 'An error occurred. Please try again.');
            header('Location: ' . BASE_URL . '/public/register.php');
            exit();
        }
    }

    // --- LOGIN & LOGOUT ---
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            
            Session::set('user_id', $user['id']);
            Session::set('user_role', $user['role']);
            Session::set('user_first_name', $user['first_name']);

            if ($user['role'] === 'admin') {
                // Redirect for admin users
                header('Location: ' . BASE_URL . '/public/admin/dashboard.php');
            } else {
                // Redirect for regular users to their profile
                header('Location: ' . BASE_URL . '/public/profile.php');
            }
            exit();
        } else {
            Session::flash('message', 'Invalid email or password.');
            // Redirect for failed login
            header('Location: ' . BASE_URL . '/public/login.php');
            exit();
        }
    }
    
  public function logout() {
        // Destroy all session data
        Session::destroy();
        
        // Redirect to the main welcome page
        header('Location: ' . BASE_URL . '/public');
        exit();
    }
    
    // --- PROFILE MANAGEMENT ---
    public function profile() {

        // This method shows the profile page. Assumes AuthMiddleware protects it.
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);
        
        // This is where you would load the view and pass the $user data to it.
        // Your router/view rendering system would handle this.
        // For example: View::render('auth/profile', ['user' => $user]);
        // For now, let's just imagine it's available.
    }

    public function updateProfile() {
        // Ensure this is a POST request and the user is logged in.
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !Session::has('user_id')) {
            // Redirect to login if not authorized.
            header('Location: ' . BASE_URL . '/public/login.php');
            exit();
        }

        $userId = Session::get('user_id');
        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name' => trim($_POST['last_name'] ?? '')
        ];

        // --- Handle File Upload ---
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $user = $this->userModel->findById($userId);
            $oldPicture = $user['profile_picture'];
            
            // Define the target directory for uploads.
            $targetDir = __DIR__ . "/../../public/uploads/profiles/";
            
            // Create a unique filename to prevent overwriting files.
            $imageFileType = strtolower(pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION));
            $newFilename = uniqid('profile_', true) . '.' . $imageFileType;
            $targetFile = $targetDir . $newFilename;

            // --- Basic Validation for the Uploaded File ---
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($imageFileType, $allowedTypes) && $_FILES["profile_picture"]["size"] < 5000000) { // 5MB limit
                if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                    $this->userModel->updateProfilePicture($userId, $newFilename);

                    // Delete old picture if it's not the default one.
                    if ($oldPicture && $oldPicture !== 'default.png' && file_exists($targetDir . $oldPicture)) {
                        unlink($targetDir . $oldPicture);
                    }
                }
            }
        }
        
        // --- Update Name in Database ---
        if ($this->userModel->update($userId, $data)) {
            Session::flash('message', 'Profile updated successfully.');
        } else {
            Session::flash('message', 'Could not update profile information.');
        }

        // Redirect back to the profile page.
        header('Location: ' . BASE_URL . '/public/profile.php');
        exit();
    }

    public function deleteProfile() {
        $userId = Session::get('user_id');
        $user = $this->userModel->findById($userId);

        if ($this->userModel->delete($userId)) {
            // Also delete their profile picture file
            $picturePath = 'uploads/profiles/' . $user['profile_picture'];
            if ($user['profile_picture'] != 'default.png' && file_exists($picturePath)) {
                unlink($picturePath);
            }
            // End session and redirect
            Session::destroy();
            header('Location: /');
            exit();
        } else {
            Session::flash('error', 'Could not delete account.');
            header('Location: /profile');
            exit();
        }
    }
}

?>