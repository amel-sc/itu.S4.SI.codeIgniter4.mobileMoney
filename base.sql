PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS commission_config;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS statut_operateur;
DROP TABLE IF EXISTS prefix_config;
DROP TABLE IF EXISTS role_utilisateur;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS montant_frais;
DROP TABLE IF EXISTS operation_type;

DROP TABLE IF EXISTS historique_transaction;


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
('033', 1),
('037', 2);

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
('admin', 'admin', '0370000000', 1),
('Jane', 'Doe', '0371234567', 2);

-- operation_type
CREATE TABLE operation_type (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

INSERT INTO operation_type (libelle) VALUES
('Depot'),
('Retrait'),
('Transfer');

-- montant_frais
CREATE TABLE montant_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operation_type INTEGER NOT NULL,
    montant1 REAL NOT NULL,
    montant2 REAL,
    frais REAL NOT NULL,
    FOREIGN KEY (id_operation_type) REFERENCES operation_type(id)
);


INSERT INTO montant_frais (id_operation_type, montant1, montant2, frais) VALUES
-- DEPOT
(1, 100, 1000, 0),
(1, 1001, 5000, 0),
(1, 5001, 10000, 0),
(1, 10001, 25000, 0),
(1, 25001, 50000, 0),
(1, 50001, 100000, 0),
(1, 100001, 250000, 0),
(1, 250001, 500000, 0),
(1, 500001, 1000000, 0),
(1, 1000001, 2000000, 0),

-- RETRAIT
(2, 100, 1000, 50),
(2, 1001, 5000, 50),
(2, 5001, 10000, 100),
(2, 10001, 25000, 200),
(2, 25001, 50000, 400),
(2, 50001, 100000, 800),
(2, 100001, 250000, 1500),
(2, 250001, 500000, 1500),
(2, 500001, 1000000, 2500),
(2, 1000001, 2000000, 3000),

-- TRANSFERT
(3, 100, 1000, 50),
(3, 1001, 5000, 50),
(3, 5001, 10000, 100),
(3, 10001, 25000, 200),
(3, 25001, 50000, 400),
(3, 50001, 100000, 800),
(3, 100001, 250000, 1500),
(3, 250001, 500000, 1500),
(3, 500001, 1000000, 2500),
(3, 1000001, 2000000, 3000);

-- historique_transaction
CREATE TABLE historique_transaction (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    numero_sender VARCHAR(255) NOT NULL,
    numero_receiver VARCHAR(255),
    montant REAL NOT NULL,
    frais REAL NOT NULL,
    commission REAL NOT NULL DEFAULT 0,
    date_transaction TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_type_operation) REFERENCES operation_type(id),
    FOREIGN KEY (numero_sender) REFERENCES utilisateur(numero),
    FOREIGN KEY (numero_receiver) REFERENCES utilisateur(numero)
);