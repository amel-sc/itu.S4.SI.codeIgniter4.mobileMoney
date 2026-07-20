PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS montant_frais;
DROP TABLE IF EXISTS operation_type;

PRAGMA foreign_keys = ON;

-- MONTANT FRAIS
CREATE TABLE operation_type (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

CREATE TABLE montant_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_operation_type INTEGER NOT NULL,
    montant1 REAL NOT NULL,
    montant2 REAL,
    frais REAL NOT NULL,
    FOREIGN KEY (id_operation_type) REFERENCES operation_type(id)
);

-- DATA TEST
INSERT INTO operation_type (libelle) VALUES
('Depot'),
('Retrait'),
('Transfer');

INSERT INTO montant_frais (id_operation_type, montant1, montant2, frais) VALUES
(1, 100, 1000, 0),
(1, 1001, 5000, 0),
(1, 5001, 10000, 0),

(2, 100, 1000, 50),
(2, 1001, 5000, 100),
(2, 5001, 10000, 150),

(3, 100, 1000, 50),
(3, 1001, 5000, 100),
(3, 5001, 10000, 150);