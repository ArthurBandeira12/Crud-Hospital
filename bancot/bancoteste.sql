CREATE DATABASE Hospital;

USE Hospital;


CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(200) NOT NULL UNIQUE,
    password VARCHAR(200) NOT NULL
    );


CREATE TABLE medicos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    especialidade VARCHAR(200) NOT NULL,
    usuario_id INT,
    FOREIGN KEY(usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL 
);


CREATE TABLE pacientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR (200) NOT NULL,
    idade INT NOT NULL,
    data_nascimento DATE NOT NULL,
    tipo_sangue VARCHAR(10) NOT NULL,
    usuario_id INT,
    FOREIGN KEY(usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);


CREATE TABLE consultas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    medicos_id INT,
    pacientes_id INT,
    data_hora DATETIME NOT NULL,
    obs TEXT NOT NULL,
    FOREIGN KEY (medicos_id) REFERENCES medicos(id) ON DELETE SET NULL,
    FOREIGN KEY (pacientes_id) REFERENCES pacientes(id) ON DELETE SET NULL
);


CREATE TABLE imagens(
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(200) NOT NULL

);

ALTER TABLE pacientes
ADD COLUMN imagem_id INT NULL,
ADD CONSTRAINT fk_paciente_imagem
  FOREIGN KEY (imagem_id) REFERENCES imagens(id) ON DELETE SET NULL;
