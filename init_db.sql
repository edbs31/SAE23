CREATE DATABASE sae23 CHARACTER SET utf8 COLLATE utf8_general_ci;
USE sae23;
CREATE TABLE administration (
  login VARCHAR(50) PRIMARY KEY,
  mdp   VARCHAR(50) NOT NULL
);
CREATE TABLE batiments (
  id_batiment        INT AUTO_INCREMENT PRIMARY KEY,
  nom                VARCHAR(50) NOT NULL,
  login_gestionnaire VARCHAR(50) NOT NULL,
  pswd_gestionnaire  VARCHAR(50) NOT NULL,
  FOREIGN KEY (login_gestionnaire) REFERENCES administration(login)
);
CREATE TABLE salles (
  nom_salle   VARCHAR(4) PRIMARY KEY,
  type        VARCHAR(50) NOT NULL,
  capacite    INT NOT NULL,
  id_batiment INT NOT NULL,
  FOREIGN KEY (id_batiment) REFERENCES batiments(id_batiment)
);
CREATE TABLE capteurs (
  nom_capteur VARCHAR(50) PRIMARY KEY,
  type        VARCHAR(50) NOT NULL,
  unite       VARCHAR(20) NOT NULL,
  nom_salle   VARCHAR(4) NOT NULL,
  FOREIGN KEY (nom_salle) REFERENCES salles(nom_salle)
);
CREATE TABLE mesures (
  id_mesure   INT AUTO_INCREMENT PRIMARY KEY,
  date        DATE NOT NULL,
  horaire     TIME NOT NULL,
  valeur      FLOAT NOT NULL,
  nom_capteur VARCHAR(50) NOT NULL,
  FOREIGN KEY (nom_capteur) REFERENCES capteurs(nom_capteur)
);
INSERT INTO administration(login, mdp) VALUES ('admin','adminpass');
