PRAGMA foreign_keys = OFF;

DROP TABLE IF EXISTS prefix_config;

PRAGMA foreign_keys = ON;

CREATE TABLE prefix_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    value TEXT NOT NULL
);

-- DATA TEST
INSERT INTO prefix_config (value) VALUES
('033'),
('037');