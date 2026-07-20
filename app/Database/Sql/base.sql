-- Table: prefixe
CREATE TABLE IF NOT EXISTS prefixe (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    sequence    TEXT NOT NULL UNIQUE
);

-- Table: numero
CREATE TABLE IF NOT EXISTS numero (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    sequence    TEXT NOT NULL UNIQUE
);

-- Table: num_prefixe (Table d'association)
CREATE TABLE IF NOT EXISTS num_prefixe (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    idNum       INTEGER NOT NULL,
    idPrefixe   INTEGER NOT NULL,

    FOREIGN KEY (idNum) REFERENCES numero(id) ON DELETE CASCADE,
    FOREIGN KEY (idPrefixe) REFERENCES prefixe(id) ON DELETE CASCADE
);

-- Table: client
CREATE TABLE IF NOT EXISTS client (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    nom     TEXT NOT NULL,
    mdp     TEXT NOT NULL
);

-- Table: num_client (Table d'association entre client et numero)
CREATE TABLE IF NOT EXISTS num_client (
    id          INTEGER PRIMARY KEY AUTOINCREMENT,
    idClient    INTEGER NOT NULL,
    idNum       INTEGER NOT NULL,
    
    FOREIGN KEY (idClient) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (idNum) REFERENCES numero(id) ON DELETE CASCADE
);

-- Table: operation
CREATE TABLE IF NOT EXISTS operation (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL UNIQUE
);

-- Table: bareme
CREATE TABLE IF NOT EXISTS bareme (
    id      INTEGER PRIMARY KEY AUTOINCREMENT,
    min     REAL NOT NULL UNIQUE,
    max     REAL NOT NULL UNIQUE,
    frais   REAL NOT NULL UNIQUE 
);

-- Table: mouvement
CREATE TABLE IF NOT EXISTS mouvement (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    idN1            INTEGER NOT NULL,
    idN2            INTEGER,
    idOperation     INTEGER NOT NULL,
    argent          REAL NOT NULL,
    dateOperation   TEXT NOT NULL DEFAULT (datetime('now', 'localtime')),

    FOREIGN KEY (idN1) REFERENCES numero(id) ON DELETE CASCADE,
    FOREIGN KEY (idN2) REFERENCES numero(id) ON DELETE SET NULL,
    FOREIGN KEY (idOperation) REFERENCES operation(id) ON DELETE RESTRICT
);
