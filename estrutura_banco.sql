-- Estrutura do banco de dados para o microserviço de controle de entrega de marmitas

CREATE TABLE user_type (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    user_type_id INT NOT NULL,
    FOREIGN KEY (user_type_id) REFERENCES user_type(id)
);

CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL
);

CREATE TABLE menu_option (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    user_type_id INT NOT NULL,
    description VARCHAR(100) NOT NULL,
    FOREIGN KEY (menu_id) REFERENCES menu(id),
    FOREIGN KEY (user_type_id) REFERENCES user_type(id)
);

CREATE TABLE delivery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    menu_option_id INT NOT NULL,
    delivered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (menu_option_id) REFERENCES menu_option(id)
);
