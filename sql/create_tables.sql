CREATE TABLE currency (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valuteID VARCHAR(255),
    numCode VARCHAR(10),
    charCode VARCHAR(10),
    name VARCHAR(255),
    value DECIMAL(10, 4),
    date DATE
);

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  PRIMARY KEY (id)
);