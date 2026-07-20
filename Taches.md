# LECTURE DU SUJET [Mandresy & Alexandre] [ok]
- Placement du fichier base.sql dans app/Database/Sql [Mandresy] [ok]

# REPARTITION DES TACHES [Mandresy & Alexandre]
- Interface & Userflow [Alexandre]
  - Userflow: login [ok]
  - Userflow: accueil [ok]
  - Interface: login
  - Interface: accueil
  - Controllers: OprationController
  - Routes 
- MCD & Back
  - Tables: prefix, numero, num_prefix, type_operation, bareme, operation, client, num_client
  - Models: Client, Operation, TypeOperation, Prefix, NumPrefix, Numero
  - Services: OperationService
    - Depot