CREATE DATABASE IF NOT EXISTS autodeal;

USE autodeal;

-- =========================
-- USERS TABLE
-- =========================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- CARS TABLE
-- =========================

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,

    seller_id INT NOT NULL,

    car_name VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,

    year INT NOT NULL,
    fuel_type VARCHAR(50),
    transmission VARCHAR(50),

    kilometers_driven INT,
    price DECIMAL(12,2) NOT NULL,

    description TEXT,

    image VARCHAR(255),

    status ENUM('available', 'sold') DEFAULT 'available',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (seller_id)
    REFERENCES users(id)
    ON DELETE CASCADE
);

-- =========================
-- CART TABLE
-- =========================

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    car_id INT NOT NULL,

    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (car_id)
    REFERENCES cars(id)
    ON DELETE CASCADE
);

-- =========================
-- WISHLIST TABLE
-- =========================

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,
    car_id INT NOT NULL,

    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (car_id)
    REFERENCES cars(id)
    ON DELETE CASCADE
);

-- =========================
-- SAMPLE CAR DATA
-- =========================

INSERT INTO cars (
    seller_id,
    car_name,
    brand,
    model,
    year,
    fuel_type,
    transmission,
    kilometers_driven,
    price,
    description,
    image
)

VALUES
(
    1,
    'Hyundai Creta',
    'Hyundai',
    'Creta SX',
    2021,
    'Petrol',
    'Manual',
    25000,
    1250000,
    'Excellent condition, single owner',
    'creta.jpg'
),

(
    1,
    'Honda City',
    'Honda',
    'City VX',
    2019,
    'Diesel',
    'Automatic',
    40000,
    950000,
    'Well maintained sedan',
    'city.jpg'
);