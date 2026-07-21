-- Active: 1784529240551@@127.0.0.1@3306
INSERT INTO operation(id,libelle) VALUES(1,'Depot');
INSERT INTO operation(id,libelle) VALUES(2,'Retrait');
INSERT INTO operation(id,libelle) VALUES(3,'Transfert');

-- =============================================================
-- 1. INSERTION DES OPÉRATEURS
-- =============================================================
INSERT INTO operateur (id, nom, mdp) VALUES 
(1, 'Orange', 'orange123'),
(2, 'Airtel', 'airtel123'),
(3, 'Telma',  'telma123');

-- =============================================================
-- 2. INSERTION DES PRÉFIXES
-- =============================================================
-- Orange : 032
-- Airtel : 033
-- Telma  : 034
INSERT INTO prefixe (sequence, idOperateur) VALUES 
('032', 1),
('033', 2),
('034', 3);

-- =============================================================
-- 3. INSERTION DES NUMÉROS DE TÉLÉPHONE
-- =============================================================
INSERT INTO numero (id, sequence) VALUES 
(1, '0321111111'), -- Numéro 1 (Orange)
(2, '0322222222'), -- Numéro 2 (Orange)
(3, '0333333333'), -- Numéro 3 (Airtel)
(4, '0334444444'), -- Numéro 4 (Airtel)
(5, '0345555555'); -- Numéro 5 (Telma)

-- =============================================================
-- 4. INSERTION DES CLIENTS
-- =============================================================
INSERT INTO client (id, nom, mdp) VALUES 
(1, 'Jean Rakoto',   'pass123'),
(2, 'Rasoa Marie',   'pass123'),
(3, 'Paul Randria',  'pass123');

-- =============================================================
-- 5. ASSOCIATION CLIENTS <-> NUMÉROS (num_client)
-- =============================================================
INSERT INTO num_client (idClient, idNum) VALUES 
(1, 1), -- Jean possède 0321111111 (Orange)
(1, 3), -- Jean possède aussi 0333333333 (Airtel)
(2, 2), -- Rasoa possède 0322222222 (Orange)
(3, 4); -- Paul possède 0334444444 (Airtel)

-- =============================================================
-- 6. INSERTION DES TYPES D'OPÉRATIONS
-- =============================================================
INSERT INTO operation (id, libelle) VALUES 
(1, 'Dépôt'),
(2, 'Retrait'),
(3, 'Transfert');

-- =============================================================
-- 7. INSERTION DES BARÈMES DE FRAIS
-- =============================================================
-- Barème pour les Transferts (idOperation = 3) chez Orange (idOperateur = 1)
INSERT INTO bareme (min, max, frais, idOperation, idOperateur) VALUES 
(100, 5000, 100, 3, 1),
(5001, 20000, 300, 3, 1),
(20001, 100000, 1000, 3, 1),
(100001, 1000000, 2500, 3, 1);

-- Barème pour les Transferts (idOperation = 3) chez Airtel (idOperateur = 2)
INSERT INTO bareme (min, max, frais, idOperation, idOperateur) VALUES 
(100, 5000, 150, 3, 2),
(5001, 20000, 400, 3, 2),
(20001, 100000, 1200, 3, 2);

-- Barème pour les Retraites (idOperation = 2) chez Orange (idOperateur = 1)
INSERT INTO bareme (min, max, frais, idOperation, idOperateur) VALUES 
(500, 10000, 200, 2, 1),
(10001, 50000, 500, 2, 1);

-- =============================================================
-- 8. HISTORIQUE INITIAL DES MOUVEMENTS (Solder les comptes)
-- =============================================================
-- Dépôt initial de 50 000 Ar sur le numéro 0321111111 (Jean) chez Orange
INSERT INTO mouvement (idN1, idN2, idOperation, idOperateur, argent) VALUES 
(1, NULL, 1, 1, 50000);

-- Dépôt initial de 20 000 Ar sur le numéro 0322222222 (Rasoa) chez Orange
INSERT INTO mouvement (idN1, idN2, idOperation, idOperateur, argent) VALUES 
(2, NULL, 1, 1, 20000);

-- Dépôt initial de 100 000 Ar sur le numéro 0333333333 (Jean - Airtel) chez Airtel
INSERT INTO mouvement (idN1, idN2, idOperation, idOperateur, argent) VALUES 
(3, NULL, 1, 2, 100000);