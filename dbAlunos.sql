CREATE DATABASE `dbalunos` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE Alunos (
    idAluno INT PRIMARY KEY,
    sobrenome VARCHAR(60),
    cidades VARCHAR(60),
    username VARCHAR(60),
    password VARCHAR(20)
) CHARACTER SET utf8 COLLATE utf8_general_ci;