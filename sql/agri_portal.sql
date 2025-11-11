CREATE DATABASE IF NOT EXISTS agri_portal;
USE agri_portal;

CREATE TABLE farmers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(150) UNIQUE,
  password_hash VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE soil_data (
  id INT AUTO_INCREMENT PRIMARY KEY,
  farmer_id INT,
  state_name VARCHAR(100),
  district_name VARCHAR(100),
  season VARCHAR(50),
  soil_type VARCHAR(100),
  crop VARCHAR(100),
  ph DECIMAL(4,2),
  n INT,
  p INT,
  k INT,
  rainfall DECIMAL(6,2),
  recommendation TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE CASCADE
);
