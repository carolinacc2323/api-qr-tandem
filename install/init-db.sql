-- Active: 1718607564007@@127.0.0.1@3306@tandem_qr_db
DROP DATABASE IF EXISTS tandem_qr_db;
CREATE DATABASE tandem_qr_db;
USE tandem_qr_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    delegacion VARCHAR(100),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    image_url VARCHAR(255) DEFAULT 'images/users/avatar_default.jpg',
    role ENUM('guest','employee', 'admin') DEFAULT 'employee',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE qr_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data VARCHAR(255) NOT NULL UNIQUE,
    nombre_ref VARCHAR(255),
    description TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users (id)
);