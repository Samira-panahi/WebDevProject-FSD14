-- Disable safe update mode for this session
SET SQL_SAFE_UPDATES = 0;

-- =================================================================
-- SEEDER SCRIPT FOR 'event_booking' DATABASE
-- =================================================================

-- Use the target database
USE event_booking;

-- Empty existing tables to prevent duplicate entries on re-running the script
DELETE FROM rsvps;
DELETE FROM events;
DELETE FROM users;

-- Reset AUTO_INCREMENT counters for clean seeding
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE events AUTO_INCREMENT = 1;
ALTER TABLE rsvps AUTO_INCREMENT = 1;


-- =================================================================
-- SEED USERS
-- =================================================================
-- The password for every user is hashed version of 'password123'.
-- =================================================================

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `profile_picture`)
VALUES
(1, 'Admin', 'User', 'admin@example.com', '$2y$10$YjhvMmKIelIAhOlw3VY36.VIHIqs.tCZ7i0vM8jLvuQcU2Iyy69ji', 'admin', 'default.png'),
(2, 'John', 'Smith', 'john.smith@example.com', '$2y$10$YjhvMmKIelIAhOlw3VY36.VIHIqs.tCZ7i0vM8jLvuQcU2Iyy69ji', 'user', 'default.png'),
(3, 'Jane', 'Doe', 'jane.doe@example.com', '$2y$10$YjhvMmKIelIAhOlw3VY36.VIHIqs.tCZ7i0vM8jLvuQcU2Iyy69ji', 'user', 'default.png'),
(4, 'Peter', 'Jones', 'peter.jones@example.com', '$2y$10$YjhvMmKIelIAhOlw3VY36.VIHIqs.tCZ7i0vM8jLvuQcU2Iyy69ji', 'user', 'default.png');


-- =================================================================
-- SEED EVENTS
-- =================================================================

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `capacity`, `image`)
VALUES
(1, 'Summer Tech Conference 2025', 'An annual conference bringing together the brightest minds in technology. Join us for insightful talks, networking opportunities, and workshops.', '2025-09-15 09:00:00', 150, 'tech_conference.jpg'),
(2, 'Community Charity Marathon', 'Run for a cause! Our annual 5k marathon to support local charities. All ages and fitness levels are welcome.', '2025-10-22 07:30:00', 500, 'marathon.jpg'),
(3, 'Local Art & Music Festival', 'Experience a vibrant showcase of local talent. Featuring live bands, art installations, food trucks, and a craft market.', '2025-11-05 12:00:00', 300, 'music_festival.jpg');


-- =================================================================
-- SEED RSVPS
-- =================================================================

INSERT INTO `rsvps` (`user_id`, `event_id`)
VALUES
(2, 1), -- John for Tech Conference
(4, 1), -- Peter for Tech Conference
(2, 2), -- John for Charity Marathon
(3, 2), -- Jane for Charity Marathon
(4, 2), -- Peter for Charity Marathon
(3, 3), -- Jane for Art & Music Festival
(4, 3); -- Peter for Art & Music Festival


-- Re-enable safe update mode at the end of the script
SET SQL_SAFE_UPDATES = 1;