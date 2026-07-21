PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS commission_config;
DROP TABLE IF EXISTS reduction_config;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS statut_operateur;
DROP TABLE IF EXISTS prefix_config;
DROP TABLE IF EXISTS role_utilisateur;
DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS montant_frais;
DROP TABLE IF EXISTS operation_type;
DROP TABLE IF EXISTS historique_transaction;
DROP TABLE IF EXISTS epargne;



-- Statuts des opérateurs
CREATE TABLE statut_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(100) NOT NULL
);

-- Opérateurs
CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    id_statut INTEGER NOT NULL,
    FOREIGN KEY (id_statut) REFERENCES statut_operateur(id)
);

-- Config commissions
CREATE TABLE commission_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operateur INTEGER NOT NULL,
    pourcentage REAL NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateur(id)
);

-- Préfixes
CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value VARCHAR(100) NOT NULL,
    id_operateur INTEGER,
    FOREIGN KEY (id_operateur) REFERENCES operateur(id)
);

-- Rôles utilisateurs
CREATE TABLE role_utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle VARCHAR(100) NOT NULL
);

-- Utilisateurs
CREATE TABLE utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prenom VARCHAR(255),
    nom VARCHAR(255),
    numero VARCHAR(255) NOT NULL UNIQUE,
    id_role INTEGER NOT NULL,
    solde REAL NOT NULL DEFAULT 0,
    FOREIGN KEY (id_role) REFERENCES role_utilisateur(id)
);

-- Types d'opération
CREATE TABLE operation_type (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

-- Barèmes de frais
CREATE TABLE montant_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operation_type INTEGER NOT NULL,
    montant1 REAL NOT NULL,
    montant2 REAL,
    frais REAL NOT NULL,
    FOREIGN KEY (id_operation_type) REFERENCES operation_type(id)
);

-- Historique des transactions
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

-- reduction_config
CREATE TABLE reduction_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pourcentage REAL NOT NULL
);

CREATE TABLE epargne (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_client INTEGER NOT NULL,
    pourcentage REAL NOT NULL,
    solde REAL NOT NULL,
    FOREIGN KEY (id_client) REFERENCES utilisateur(id)
);

PRAGMA foreign_keys = ON;

-- Données de base
INSERT INTO statut_operateur (libelle) VALUES
('operateur'),
('valable'),
('non valable');

INSERT INTO operateur (nom, id_statut) VALUES
('Telma', 2),
('Orange', 1),
('Airtel', 3);

INSERT INTO commission_config (id_operateur, pourcentage) VALUES
(2, 5);

INSERT INTO prefix_config (value, id_operateur) VALUES
('033', 1),
('037', 2),
('038', 3);

INSERT INTO role_utilisateur (libelle) VALUES
('opérateur'),
('client');

INSERT INTO utilisateur (prenom, nom, numero, id_role, solde) VALUES
('Admin', 'Operateur', '0370000000', 1, 1000000),
('Jean', 'Client', '0331234567', 2, 500000),
('John', 'Client', '0331264567', 2, 500000),
('Marie', 'Client', '0371266567', 2, 250000),
('Pierre', 'Client', '0376934567', 2, 250000),
('Lolo', 'Client', '0371234567', 2, 250000),
('Paul', 'Client', '0381234567', 2, 200000);

INSERT INTO epargne (id_client , pourcentage , solde) VALUES
(1, 20, 0),
(2, 20, 0),
(3, 20, 0),
(4, 20, 0),
(5, 20, 0),
(6, 20, 0),
(7, 20, 0);

INSERT INTO operation_type (libelle) VALUES
('Depot'),
('Retrait'),
('Transfer');


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

-- Scénarios de test
INSERT INTO historique_transaction (id_type_operation, numero_sender, numero_receiver, montant, frais, commission) VALUES
(2, '0370000000', NULL, 1000, 50, 0),
(3, '0370000000', '0331234567', 1000, 50, 50);

-- Résultats attendus
-- 1) Liste des opérateurs et de leurs préfixes
SELECT o.id, o.nom, s.libelle AS statut, p.value AS prefixe
FROM operateur o
JOIN statut_operateur s ON s.id = o.id_statut
LEFT JOIN prefix_config p ON p.id_operateur = o.id
ORDER BY o.id;

-- Résultat attendu:
-- 1 | Telma  | operateur   | 033
-- 2 | Orange | valable     | 037
-- 3 | Airtel | non valable | 038

-- 2) Historique des transactions avec commission
SELECT id, id_type_operation, numero_sender, numero_receiver, montant, frais, commission
FROM historique_transaction
ORDER BY id;

-- Résultat attendu:
-- Retrait: commission = 0
-- Transfert vers Orange: commission = 50
-- Transfert vers Airtel: commission = 0

-- 3) Total des gains par type
SELECT
    SUM(CASE WHEN id_type_operation = 2 THEN frais ELSE 0 END) AS total_retrait,
    SUM(CASE WHEN id_type_operation = 3 THEN frais ELSE 0 END) AS total_transfert,
    SUM(CASE WHEN id_type_operation = 3 THEN commission ELSE 0 END) AS total_commission,
    SUM(CASE WHEN id_type_operation IN (2, 3) THEN frais + commission ELSE 0 END) AS total_general
FROM historique_transaction;

-- Résultat attendu:
-- total_retrait    = 50
-- total_transfert  = 100
-- total_commission = 50
-- total_general    = 200

-- 4) Montants envoyés par opérateur
SELECT
    op.nom AS operateur,
    SUM(ht.montant) AS montant_envoye,
    SUM(ht.commission) AS commission_total,
    COUNT(*) AS nb_transferts
FROM historique_transaction ht
JOIN prefix_config pc ON pc.value = SUBSTR(ht.numero_receiver, 1, LENGTH(pc.value))
JOIN operateur op ON op.id = pc.id_operateur
WHERE ht.id_type_operation = 3
GROUP BY op.nom
ORDER BY op.nom;

-- Résultat attendu:
-- Orange | 1000 | 50 | 1
-- Airtel | 1000 | 0 | 1

INSERT INTO reduction_config (pourcentage) VALUES
(5);