<?php

class Validation {

    /**
     * Validate event data
     * 
     * @param array $data $_POST data
     * @param array|null $file $_FILES['image'] data
     * @return array ['errors' => array, 'image' => string]
     */
    public static function validateEvent(array $data, $file = null): array {
        $errors = [];
        $imageName = 'default_event.png';

        // Title
        $title = trim($data['title'] ?? '');
        if ($title === '') {
            $errors[] = "Title is required.";
        }

        // Event Date
        $eventDate = $data['event_date'] ?? '';
        if (!$eventDate) {
            $errors[] = "Event date is required.";
        } elseif (strtotime($eventDate) <= time()) {
            $errors[] = "Event date must be in the future.";
        }

        // Capacity
        $capacity = isset($data['capacity']) ? (int)$data['capacity'] : 0;
        if ($capacity <= 0) {
            $errors[] = "Capacity must be greater than 0.";
        }

        // Image
        if ($file && !empty($file['name'])) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','gif'])) {
                $errors[] = "Invalid image format. Allowed: jpg, jpeg, png, gif.";
            } else {
                // Generate unique filename and move uploaded file
                $imageName = time() . '_' . basename($file['name']);
                $uploadDir = __DIR__ . '/../public/uploads/events/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadDir . $imageName)) {
                    $errors[] = "Failed to upload image.";
                    $imageName = 'default_event.png';
                }
            }
        }

        return [
            'errors' => $errors,
            'image'  => $imageName
        ];
    }
}

?>
