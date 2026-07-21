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

# REPARTITION DES TACHES VERSION 2 [Mandresy]
- Modification des tables [Mandresy]
  - operateur [ok]
  - bareme [ok]
- Modification des models [Mandresy]
  - operateur [ok]
  - bareme [ok]
- Rajout des methodes [Mandresy]
  - modification des prefixes pour chaque operateur [ok]
  - gestion des baremes de frais pour chaque operateur [ok]
  - gestion des gains via frais [ok]
  - situation des comptes clients [ok]

# REPARTITION DES TACHES V2 [Alexandre]
  # Coté opérateur
- Séparation du préfixe et du numéro durant le login. 
- Commission en % pour les autres operateurs.
- Page  “Situation gain via les différents frais” 
- Montant à envoyer à chaque opérateur.
  # Coté client 
- Frais de retrait durant l'envoi [ok]
- Envoi mulitple vers plusieurs numéros

# CONSTRUCTION DES PAGES PETIT À PETIT [Alexandre]
  # Coté opérateur 
- Liste barème []
- Liste prefixes []
- Gain différent frais [] 
- Compte client [] 

  # Coté client [] 
- Envoie multiple []