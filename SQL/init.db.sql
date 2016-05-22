-- for development only
CREATE DATABASE movies_dev;
CREATE USER 'movies_dev_user'@'localhost' IDENTIFIED BY 'p@55W0rd';
GRANT ALL PRIVILEGES ON movies_dev.* TO 'movies_dev_user'@'localhost';
