-- Create the database
CREATE DATABASE IF NOT EXISTS HealthHub;
USE HealthHub;

-- Create the Users table
CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer', 'delivery') DEFAULT 'customer',
    reset_token VARCHAR(64) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin user
-- Password: admin123 (hashed using password_hash())
INSERT INTO Users (username, email, password_hash, role)
VALUES (
    'admin',
    'admin@healthhub.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Hashed version of 'admin123'
    'admin'
);

-- Insert sample customer user
-- Password: customer123 (hashed using password_hash())
INSERT INTO Users (username, email, password_hash, role)
VALUES (
    'customer1',
    'customer1@healthhub.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Hashed version of 'customer123'
    'customer'
);

-- Insert sample delivery user
-- Password: delivery123 (hashed using password_hash())
INSERT INTO Users (username, email, password_hash, role)
VALUES (
    'delivery1',
    'delivery1@healthhub.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- Hashed version of 'delivery123'
    'delivery'
);

-- Optional: Create a Products table (if needed)
CREATE TABLE IF NOT EXISTS Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Insert sample products
INSERT INTO Products (name, description, price, stock_quantity, image_url)
VALUES
    ('Vitamin C', 'Boosts immunity and improves skin health.', 15.99, 100, 'https://example.com/vitamin-c.jpg'),
    ('Yoga Mat', 'Non-slip yoga mat for comfortable workouts.', 29.99, 50, 'https://example.com/yoga-mat.jpg'),
    ('Organic Snacks', 'Healthy and delicious organic snacks.', 9.99, 200, 'https://example.com/organic-snacks.jpg');

-- Optional: Create an Orders table (if needed)
CREATE TABLE IF NOT EXISTS Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('Pending', 'Shipped', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);

-- Optional: Create an OrderItems table (if needed)
CREATE TABLE IF NOT EXISTS OrderItems (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Products(product_id) ON DELETE CASCADE
);