-- Create the database
CREATE DATABASE project_shiba;
USE project_shiba;

-- Users table
CREATE TABLE users (
    userId INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Bathrooms table
CREATE TABLE bathrooms (
    bathroomId INT AUTO_INCREMENT PRIMARY KEY,
    isPaid BOOLEAN NOT NULL DEFAULT FALSE,
    price DECIMAL(10,2),
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    ownerId INT NOT NULL,
    FOREIGN KEY (ownerId) REFERENCES users(userId)
);

-- Reviews table
CREATE TABLE reviews (
    reviewId INT AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL,
    bathroomId INT NOT NULL,
    userId INT NOT NULL,
    FOREIGN KEY (bathroomId) REFERENCES bathrooms(bathroomId),
    FOREIGN KEY (userId) REFERENCES users(userId)
);
