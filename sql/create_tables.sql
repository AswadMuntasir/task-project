CREATE TABLE currency (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valuteID VARCHAR(255),
    numCode VARCHAR(10),
    charCode VARCHAR(10),
    name VARCHAR(255),
    value DECIMAL(10, 4),
    date DATE
);