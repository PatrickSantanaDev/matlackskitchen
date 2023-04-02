CREATE DATABASE IF NOT EXISTS matlacks;
USE matlacks;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS uploaded_menu;
DROP TABLE IF EXISTS out_of_stock_items;
DROP TABLE IF EXISTS recipes;
DROP TABLE IF EXISTS builds;
DROP TABLE IF EXISTS am_duties;
DROP TABLE IF EXISTS pm_duties;
DROP TABLE IF EXISTS weekly_duties;
DROP TABLE IF EXISTS ingredients;
DROP TABLE IF EXISTS ingredients_needed;
DROP TABLE IF EXISTS uploaded_schedule;
DROP TABLE IF EXISTS photos;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT,
    username VARCHAR(25) NOT NULL,
    pass VARCHAR(50) NOT NULL,
    email VARCHAR(25) NOT NULL UNIQUE,
    PRIMARY KEY(user_id)
);

CREATE TABLE uploaded_menu (
    id INT NOT NULL AUTO_INCREMENT,
    file_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    uploaded_on datetime NOT NULL,
    status enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE out_of_stock_items (
    id INT AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    item_name VARCHAR(50) NOT NULL,
    date_added DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE recipes (
    id INT AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    recipe_name VARCHAR(50) NOT NULL,
    category VARCHAR(25) NOT NULL,
    ingredients VARCHAR(500) NOT NULL,
    instructions VARCHAR(1000) NOT NULL,
    date_added DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE builds (
    id INT AUTO_INCREMENT,
    build_name VARCHAR(50) NOT NULL,
    category VARCHAR(25) NOT NULL,
    ingredients VARCHAR(500) NOT NULL,
    instructions VARCHAR(1000) NOT NULL,
    file_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    image_status enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
    image_type VARCHAR(10) NOT NULL,
    user_id INT NOT NULL,
    date_added DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE am_duties (
    id INT AUTO_INCREMENT,
    duty_name VARCHAR(50) NOT NULL,
    username VARCHAR(20) NOT NULL,
    completed INT NOT NULL DEFAULT 0,
    date_completed DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE pm_duties (
    id INT AUTO_INCREMENT,
    duty_name VARCHAR(50) NOT NULL,
    username VARCHAR(20) NOT NULL,
    completed INT NOT NULL DEFAULT 0,
    date_completed DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE weekly_duties (
    id INT AUTO_INCREMENT,
    duty_name VARCHAR(50) NOT NULL,
    -- am_pm?
    -- weekday?
    username VARCHAR(20) NOT NULL,
    completed INT NOT NULL DEFAULT 0,
    date_completed DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE ingredients(
    id INT AUTO_INCREMENT,
    ingredient_name VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    added_by_username VARCHAR(20) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (added_by_username) REFERENCES users(username)
);

CREATE TABLE ingredients_needed (
    id INT AUTO_INCREMENT,
    ingredient_name VARCHAR(255) NOT NULL,
    is_needed BOOLEAN NOT NULL DEFAULT 0,
    added_by_username VARCHAR(20) NOT NULL,
    date_added DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (added_by_username) REFERENCES users(username)
);

CREATE TABLE uploaded_schedule (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    schedule_location VARCHAR(200) NOT NULL,
    date_added DATE,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE photos (
    id INT NOT NULL AUTO_INCREMENT,
    file_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    image_status enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
    image_type VARCHAR(10) NOT NULL,
    date_added DATE NOT NULL,
    PRIMARY KEY (id)
);
