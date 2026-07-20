PRAGMA foreign_keys = ON;

-- table prefix_config
CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value VARCHAR(100) NOT NULL
);

INSERT INTO prefix_config (value)
VALUES 
('038'),
('037'),
('033'),
('034');

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
    numero VARCHAR(255),
    id_role INTEGER NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role_utilisateur(id)
);

INSERT INTO utilisateur (prenom, nom, numero, id_role) 
VALUES
('admin', 'admin', '0389409519', 1),
('Jane', 'Doe', '0385425624', 2);