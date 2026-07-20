-- Table: operateur
CREATE TABLE IF NOT EXISTS operateur (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    nom     TEXT NOT NULL UNIQUE,
    mdp     TEXT NOT NULL
);

-- Table: prefixe (Modifiée : liée directement à un opérateur)
CREATE TABLE IF NOT EXISTS prefixe (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    sequence    TEXT NOT NULL UNIQUE,
    idOperateur INTEGER NOT NULL,
    FOREIGN KEY (idOperateur) REFERENCES operateur(id) ON DELETE CASCADE
);

-- Table: numero
CREATE TABLE IF NOT EXISTS numero (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    sequence    TEXT NOT NULL UNIQUE
);

-- Table: client
CREATE TABLE IF NOT EXISTS client (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    nom     TEXT NOT NULL,
    mdp     TEXT NOT NULL
);

-- Table: num_client
CREATE TABLE IF NOT EXISTS num_client (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    idClient    INTEGER NOT NULL,
    idNum       INTEGER NOT NULL,
    FOREIGN KEY (idClient) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (idNum) REFERENCES numero(id) ON DELETE CASCADE
);

-- Table: operation
CREATE TABLE IF NOT EXISTS operation (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle     TEXT NOT NULL UNIQUE
);

-- Table: bareme (Améliorée : dépend de l'opération et de l'opérateur)
CREATE TABLE IF NOT EXISTS bareme (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    min         REAL NOT NULL,
    max         REAL NOT NULL,
    frais       REAL NOT NULL,
    idOperation INTEGER NOT NULL,
    idOperateur INTEGER NOT NULL,
    FOREIGN KEY (idOperation) REFERENCES operation(id) ON DELETE CASCADE,
    FOREIGN KEY (idOperateur) REFERENCES operateur(id) ON DELETE CASCADE
);

-- Table: mouvement
CREATE TABLE IF NOT EXISTS mouvement (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    idN1            INTEGER NOT NULL,
    idN2            INTEGER,
    idOperation     INTEGER NOT NULL,
    idOperateur     INTEGER,
    argent          REAL NOT NULL,
    dateOperation   TEXT NOT NULL DEFAULT (datetime('now', 'localtime')),

    FOREIGN KEY (idN1) REFERENCES numero(id) ON DELETE CASCADE,
    FOREIGN KEY (idN2) REFERENCES numero(id) ON DELETE SET NULL,
    FOREIGN KEY (idOperateur) REFERENCES operateur(id) ON DELETE RESTRICT,
    FOREIGN KEY (idOperation) REFERENCES operation(id) ON DELETE RESTRICT
);