# LECTURE DU SUJET [Mandresy & Alexandre] [ok]
- Placement du fichier base.sql dans app/Database/Sql [Mandresy] [ok]

# REPARTITION DES TACHES [Mandresy & Alexandre]
- Interface & Userflow [Alexandre]
  - Userflow: login [ok]
  - Userflow: accueil [ok]
  - Interface: login [ok]
  - Interface: accueil [ok]
- MCD & Back [Mandresy]
  - Connexion Base de donnee [ok]
  - Tables: prefix, numero, num_prefix, operation, bareme, mouvement, client, num_client [ok]
  - Models: Client, Operation, Mouvement, Prefix, NumPrefix, Numero, NumClient [ok]
- Controller [Mandresy & Alexandre]
  - MouvementController
    - depot(idNum, idOperation, montant)