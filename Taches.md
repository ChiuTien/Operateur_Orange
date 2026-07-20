# LECTURE DU SUJET [Mandresy & Alexandre] [ok]
- Placement du fichier base.sql dans app/Database/Sql [Mandresy] [ok]

# REPARTITION DES TACHES [Mandresy & Alexandre]
- Interface & Userflow [Alexandre]
  - Userflow: login [ok]
  - Userflow: accueil [ok]
  - Interface: login [ok]
  - Interface: accueil [ok]
  - Controllers: OprationController
  - Routes 
- MCD & Back
  - Connexion Base de donnee
  - Tables: prefix, numero, num_prefix, type_operation, bareme, operation, client, num_client
  - Models: Client, Operation, TypeOperation, Prefix, NumPrefix, Numero
  - Services: OperationService
    - Depot