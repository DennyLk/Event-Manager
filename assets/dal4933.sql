-- Delete all tables if they exist
DROP TABLE IF EXISTS attendee_event;
DROP TABLE IF EXISTS attendee;
DROP TABLE IF EXISTS event;
DROP TABLE IF EXISTS venue;
DROP TABLE IF EXISTS role;

-- Create the 'role' table
CREATE TABLE role (
    role_id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(10) UNIQUE NOT NULL
);

-- Create the 'venue' table
CREATE TABLE venue (
    venue_id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    capacity INT NOT NULL
);

-- Create the 'event' table with ON DELETE CASCADE for venue_id
CREATE TABLE event (
    event_id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    allowed_number INT NOT NULL,
    venue_id SMALLINT,
    FOREIGN KEY (venue_id) REFERENCES venue(venue_id) ON DELETE CASCADE
);

-- Create the 'attendee' table
CREATE TABLE attendee (
    attendee_id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(45) NOT NULL,
    last_name VARCHAR(45) NOT NULL,
    email VARCHAR(50) NOT NULL,
    username VARCHAR(16) NOT NULL,
    password VARCHAR(60) NOT NULL, -- Passwords stored as plain text (for demonstration purposes)
    role_id SMALLINT,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
);

-- Create the 'attendee_event' table with ON DELETE CASCADE for event_id
CREATE TABLE attendee_event (
    attendee_event_id SMALLINT AUTO_INCREMENT PRIMARY KEY,
    attendee_id SMALLINT,
    event_id SMALLINT,
    paid TINYINT NOT NULL DEFAULT 0,
    
    FOREIGN KEY (attendee_id) REFERENCES attendee(attendee_id),
    FOREIGN KEY (event_id) REFERENCES event(event_id) ON DELETE CASCADE
);

-- Insert mock data into 'role' table
INSERT INTO role (name) VALUES ('attendee'), ('admin');

-- Insert mock data into 'venue' table
INSERT INTO venue (name, capacity) VALUES ('Main Hall', 200), ('Conference Room A', 50);

-- Insert mock data into 'event' table
INSERT INTO event (name, start_date, end_date, allowed_number, venue_id)
VALUES ('Tech Conference', '2024-11-01 09:00:00', '2024-11-01 17:00:00', 150, 1),
       ('Workshop on AI', '2024-11-02 10:00:00', '2024-11-02 13:00:00', 50, 2);

-- Insert mock data into 'attendee' table with plain-text passwords
INSERT INTO attendee (first_name, last_name, email, username, password, role_id)
      VALUES('Jane', 'Smith', 'jane.smith@example.com', 'user', 'user', 2),
       ('Admin', 'User', 'admin@example.com', 'admin', 'admin', 1);

-- Insert mock data into 'attendee_event' table
INSERT INTO attendee_event (attendee_id, event_id, paid)
VALUES (1, 1, 1), (2, 2, 0);
