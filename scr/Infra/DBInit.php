<?php

return $statements = [
    'CREATE TABLE users (
        id INT AUTO_INCREMENT,
        name varchar(240) NOT NULL,
        nickname varchar(240) NOT NULL UNIQUE,
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    );',
    'CREATE TABLE transactions (
        id INT AUTO_INCREMENT,
        id_user INT NOT NULL,
        type varchar(240) NOT NULL,
        value decimal[(65[,2]],
        created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
    );',

    'ALTER TABLE transactions
        ADD CONSTRAINT fk_id_user
        FOREIGN KEY(id_user) 
        REFERENCES users (id);
    ',
    'INSERT INTO users (id, name, nickname)
        (1, Bruno, brunoribeiro),
        (2, Bruce, batman);
    ',
    'INSERT INTO transactions (user, type, value)
        (1, entrada, 500.00),
        (1, entrada, 380.00),
        (1, entrada, 220.50),
        (1, saida, -375.45),
        (2, entrada, 180.75),
        (2, entrada, 197.55),
        (2, entrada, 1052.80),
        (2, saida, -285.95);
    '
];