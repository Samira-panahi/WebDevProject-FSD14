<?php
class Validation {

    public static function validateEvent($data, $file = null) {
        $errors = [];

        $title = trim($data['title'] ?? '');
        if (!$title) {
            $errors[] = "Title is required.";
        }

        $eventDate = $data['event_date'] ?? '';
        if (!$eventDate || strtotime($eventDate) <= time()) {
            $errors[] = "Event date must be in the future.";
        }

        $capacity = isset($data['capacity']) ? (int)$data['capacity'] : 0;
        if ($capacity <= 0) {
            $errors[] = "Capacity must be greater than 0.";
        }
        
        $imageName = 'default_event.png';
        if ($file && !empty($file['name'])) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                $errors[] = "Invalid image format. Allowed: jpg, jpeg, png, gif.";
            } else {
                // Generate unique image name
                $imageName = time() . '_' . basename($file['name']);
                $uploadDir = __DIR__ . '/../../public/uploads/events/';

                // Debug log the resolved path
                error_log("Upload dir resolved to: " . $uploadDir);

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true); // Create folder if not exists
                    error_log("Upload dir created: " . $uploadDir);
                }

                // Debug log the file info
                error_log("File info: " . print_r($file, true));

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $imageName)) {
                    $errors[] = "Failed to upload image. File error code: " . $file['error'];
                    error_log("move_uploaded_file failed. tmp_name: " . $file['tmp_name']);
                } else {
                    error_log("File uploaded successfully: " . $uploadDir . $imageName);
                }
            }
        }


        return ['errors' => $errors, 'image' => $imageName];
    }
}
