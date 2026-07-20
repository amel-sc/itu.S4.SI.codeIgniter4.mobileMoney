PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS prefix_config;
DROP TABLE IF EXISTS role_utilisateur;
DROP TABLE IF EXISTS utilisateur;

-- table prefix_config
CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value VARCHAR(100) NOT NULL
);

INSERT INTO prefix_config (value)
VALUES 
('067'),
('069');

-- table role_utilisateur
CREATE TABLE role_utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO role_utilisateur (libelle)
VALUES
('opérateur'),
('client');

-- table utilisateur
CREATE TABLE utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prenom VARCHAR(255),
    nom VARCHAR(255),
    numero VARCHAR(255) NOT NULL UNIQUE,
    id_role INTEGER NOT NULL,
    solde REAL NOT NULL DEFAULT 0,
    FOREIGN KEY (id_role) REFERENCES role_utilisateur(id)
);

INSERT INTO utilisateur (prenom, nom, numero, id_role) 
VALUES
('admin', 'admin', '0670000000', 1),
('Jane', 'Doe', '0671234567', 2);