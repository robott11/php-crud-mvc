CREATE TABLE depoimentos (
    id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255),
    mensagem text,
    data timestamp
);