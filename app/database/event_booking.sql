CREATE DATABASE IF NOT EXISTS event_booking;
USE event_booking;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255),
    role ENUM('user','admin') DEFAULT 'user',
    profile_image VARCHAR(255) DEFAULT 'default.png',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    capacity INT NOT NULL CHECK (capacity > 0),
    image VARCHAR(255) DEFAULT 'default_event.png',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rsvps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Modifications to users table (Elizabeth's part)

ALTER TABLE users
DROP COLUMN name,
ADD COLUMN first_name VARCHAR(100) NOT NULL AFTER id,
ADD COLUMN last_name VARCHAR(100) NOT NULL AFTER first_name,
ADD COLUMN updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
CHANGE COLUMN profile_image profile_picture VARCHAR(255) DEFAULT 'default.png';

ALTER TABLE users
MODIFY COLUMN profile_picture VARCHAR(255) DEFAULT 'default.png';

-- Modifications to users table (Belinda's part)
ALTER TABLE events ADD COLUMN user_id INT NULL;

--  Linking event to the users table
ALTER TABLE events 
ADD CONSTRAINT fk_events_user 
FOREIGN KEY (user_id) REFERENCES users(id) 
ON DELETE CASCADE;

-- Updating existing rows with a valid user_id and
-- assigning existing rows to the admin (id = 1)
UPDATE events SET user_id = 1 WHERE user_id IS NULL;

ALTER TABLE events MODIFY user_id INT NOT NULL;

