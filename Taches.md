# LECTURE DU SUJET [Mandresy & Alexandre] [ok]
- Placement du fichier base.sql dans app/Database/Sql [Mandresy] [ok]

# REPARTITION DES TACHES VERSION 1 [Mandresy & Alexandre]
- Interface & Userflow [Alexandre]
  - Userflow: login [ok]
  - Userflow: accueil [ok]
  - Interface: login [ok]
  - Interface: accueil [ok]
    - Formulaire : 
      - depot [ok]
      - retrait [ok]
      - transfert [ok]
      - historique [ok]
    - Affichage solde [ok]
  - Voir Solde [ok]
- MCD & Back [Mandresy]
  - Connexion Base de donnee [ok]
  - Tables: prefix, numero, num_prefix, operation, bareme, mouvement, client, num_client [ok]
  - Models: Client, Operation, Mouvement, Prefix, NumPrefix, Numero, NumClient, Bareme [ok]
- Controller [Mandresy]
  - MouvementController [ok]
    - depot() [ok]
    - getSolde() [ok]
    - deductionFrais [ok]
    - retrait() [ok]
    - transfert() [ok]
    - historique() [ok]

# REPARTITION DES TACHES VERSION 2 [Mandresy & Alexandre]
- Modification des tables
  - operateur
  - prefixOperateur