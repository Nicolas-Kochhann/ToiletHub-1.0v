-- Create the database
CREATE DATABASE project_shiba;
USE project_shiba;

-- Users table
CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    profilePicture TEXT DEFAULT NULL,
    password TEXT NOT NULL
);

-- Bathrooms table
CREATE TABLE bathrooms (
    bathroomId INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(100),
    isPaid BOOLEAN NOT NULL DEFAULT FALSE,
    price BIGINT DEFAULT NULL,
    lat DECIMAL(9,6) NOT NULL,
    lon DECIMAL(9,6) NOT NULL,
    ownerId INT NOT NULL,
    FOREIGN KEY (ownerId) REFERENCES users(userId)
);

-- Reviews table
CREATE TABLE reviews (
    reviewId INT AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    bathroomId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (bathroomId) REFERENCES bathrooms(bathroomId) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES users(userId)
);

-- Bathroomm images table
CREATE TABLE bathrooms_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image TEXT NOT NULL,
    bathroomId INT NOT NULL,
    FOREIGN KEY (bathroomId) REFERENCES bathrooms(bathroomId) ON DELETE CASCADE
)
