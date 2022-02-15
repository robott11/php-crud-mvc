CREATE TABLE depoimentos (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255),
    mensagem text,
    data timestamp
);

CREATE TABLE usuarios (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255),
    email varchar(255) NOT NULL UNIQUE,
    senha varchar(61) NOT NULL
);