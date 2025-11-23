-- Direction Wise Tourism Database Schema
-- MySQL 8.0+

CREATE DATABASE IF NOT EXISTS directionwise CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE directionwise;

-- Tours table
CREATE TABLE IF NOT EXISTS tours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    excerpt TEXT,
    description TEXT,
    duration VARCHAR(100),
    price_from DECIMAL(10, 2),
    currency VARCHAR(10) DEFAULT 'USD',
    image VARCHAR(255),
    image_webp VARCHAR(255),
    images JSON,
    tags JSON,
    inclusions TEXT,
    exclusions TEXT,
    itinerary JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id VARCHAR(50) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    tour_id INT,
    tour_title VARCHAR(255),
    date DATE NOT NULL,
    guests INT DEFAULT 1,
    message TEXT,
    status VARCHAR(50) DEFAULT 'pending',
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_tour_id (tour_id),
    INDEX idx_date (date),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

