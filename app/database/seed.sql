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

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `capacity`, `image`, `user_id`)
VALUES
-- John (id=2)
(1, 'Summer Tech Conference 2025', 'An annual conference bringing together the brightest minds in technology. Join us for insightful talks, networking opportunities, and workshops.', '2025-09-15 09:00:00', 150, 'tech_conference.jpg', 2),
(2, 'Community Charity Marathon', 'Run for a cause! Our annual 5k marathon to support local charities. All ages and fitness levels are welcome.', '2025-10-22 07:30:00', 500, 'marathon.jpg', 2),
(3, 'AI & Robotics Expo', 'Discover the latest in AI, robotics, and automation. Featuring keynote speakers, demos, and interactive exhibits.', '2025-11-25 10:00:00', 200, 'ai_robotics.jpg', 2),
(4, 'Sustainability Workshop', 'A hands-on workshop on eco-friendly practices and green technology for businesses.', '2025-12-15 13:00:00', 100, 'sustainability.jpg', 2),

-- Jane (id=3)
(5, 'Local Art & Music Festival', 'Experience a vibrant showcase of local talent. Featuring live bands, art installations, food trucks, and a craft market.', '2025-11-05 12:00:00', 300, 'music_festival.jpg', 3),
(6, 'Startup Pitch Night', 'A night for entrepreneurs to pitch their ideas to investors and mentors.', '2025-12-02 18:00:00', 120, 'startup_pitch.jpg', 3),
(7, 'Health & Wellness Expo', 'Connect with experts in health, fitness, and nutrition. Includes yoga sessions and cooking demos.', '2026-01-20 09:30:00', 250, 'wellness_expo.jpg', 3),
(8, 'Photography Masterclass', 'A 2-day workshop for amateur and professional photographers to improve their skills.', '2026-02-05 10:00:00', 60, 'photography.jpg', 3),

-- Peter (id=4)
(9, 'Winter Coding Bootcamp', 'An intensive 5-day bootcamp to sharpen your coding skills in Python, JavaScript, and SQL.', '2026-01-10 09:00:00', 80, 'coding_bootcamp.jpg', 4),
(10, 'Food & Wine Expo', 'Taste a wide selection of gourmet foods and wines from around the world.', '2026-02-14 11:00:00', 250, 'food_wine_expo.jpg', 4),
(11, 'Blockchain & FinTech Forum', 'Learn how blockchain and financial technologies are transforming the industry.', '2026-03-12 09:00:00', 180, 'blockchain.jpg', 4),
(12, 'Travel & Adventure Fair', 'Find inspiration for your next trip with travel agencies, gear shops, and guest adventurers.', '2026-04-05 10:00:00', 400, 'travel_fair.jpg', 4);



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