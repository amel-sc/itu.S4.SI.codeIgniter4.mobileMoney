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