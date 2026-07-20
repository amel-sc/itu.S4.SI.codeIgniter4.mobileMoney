PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS commission_config;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS statut_operateur;
DROP TABLE IF EXISTS prefix_config;
DROP TABLE IF EXISTS role_utilisateur;
DROP TABLE IF EXISTS utilisateur;

-- table statut_operateur
CREATE TABLE statut_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(100) NOT NULL
);

INSERT INTO statut_operateur (libelle)
VALUES
('operateur'),
('valable'),
('non valable');

-- table operateur
CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    id_statut INTEGER NOT NULL,
    FOREIGN KEY (id_statut) REFERENCES statut_operateur(id)
);

INSERT INTO operateur (nom, id_statut)
VALUES
('Telma', 1),
('Orange', 2),
('Airtel', 3);

-- table commission_config
CREATE TABLE commission_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur INTEGER NOT NULL,
    pourcentage REAL NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateur(id)
);

INSERT INTO commission_config (id_operateur, pourcentage)
VALUES
(2, 5);

-- table prefix_config
CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value VARCHAR(100) NOT NULL,
    id_operateur INTEGER,
    FOREIGN KEY (id_operateur) REFERENCES operateur(id)
);

INSERT INTO prefix_config (value, id_operateur)
VALUES 
('067', 1),
('069', 2);

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