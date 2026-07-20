PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS prefix_config;

DROP TABLE IF EXISTS commission_config;
DROP TABLE IF EXISTS operateur;
DROP TABLE IF EXISTS statut_operateur;

CREATE TABLE statut_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL
);

INSERT INTO statut_operateur (libelle) VALUES
('operateur'),
('valable'),
('non valable');

CREATE TABLE operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    id_statut INTEGER NOT NULL,
    FOREIGN KEY (id_statut) REFERENCES statut_operateur(id)
);

INSERT INTO operateur (nom, id_statut) VALUES
('Telma', 1),
('Orange', 2),
('Airtel', 3);

PRAGMA foreign_keys = ON;

CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value TEXT NOT NULL,
    id_operateur INTEGER,
    FOREIGN KEY (id_operateur) REFERENCES operateur(id)
);

-- DATA TEST
INSERT INTO prefix_config (value, id_operateur) VALUES
('033', 1),
('037', 2);