CREATE DATABASE IF NOT EXISTS event_booking
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