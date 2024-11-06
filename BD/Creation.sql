CREATE DATABASE projet;

USE projet;

CREATE TABLE tblDetection(
    id                      INT                 NOT NULL                AUTO_INCREMENT          PRIMARY KEY,
    temps                   DATETIME            NOT NULL
);

CREATE TABLE tblActivation(
    id                      INT                 NOT NULL                AUTO_INCREMENT          PRIMARY KEY,
    temps                   DATETIME            NOT NULL,
    OnOff                   BIT                 NOT NULL
);

CREATE TABLE role (
    role_id                 INT                 NOT NULL                AUTO_INCREMENT          PRIMARY KEY,
    role_name               VARCHAR(50)         NOT NULL                UNIQUE
);

CREATE TABLE tblUtilisateurs(
    id                      INT                 NOT NULL                AUTO_INCREMENT          PRIMARY KEY,
    nom                     VARCHAR(100)        NOT NULL,
    mdp                     VARCHAR(100)        NOT NULL,
    sel                     VARCHAR(64)         NOT NULL,
    email                   VARCHAR(255)        NOT NULL                UNIQUE,
    role_id                 INT,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
);
CREATE TABLE tblTentatives (
    id                      INT,
    derniere_tentative      DATETIME            NOT NULL,
    tentatives              INT                 NOT NULL,
    bloque                  BOOLEAN             NOT NULL,
    FOREIGN KEY (id) REFERENCES tblUtilisateurs(id)
);