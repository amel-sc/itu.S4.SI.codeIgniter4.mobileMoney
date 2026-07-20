# Version 1
## Login (Amel - 3938)
### base
- Table prefix_config : id, value. qui stocke les préfixes valides pour les numéro (033, 037)
- Table role_utilisateur : id, libelle
- Table utilisateur : id, nom, prenom, numero, role

### fonction
- findByNumero($numero) : fontion pour récupérer un utilisateur par son numero
- login() : controller pour faire le login, vérifier si l'utilisateur existe, message d'erreur sinon

### page
- login.php : formulaire pour se le login : input de numero, bouton valider

## MONTANT FRAIS (Lorick - 3892)
### base 
- creation des tables :
    - Table operation_type : id, libelle. qui stocke les opérations valide (dépôt, retait, transfert)
    - Table montant_frais : id, id_operation_type, montant1, montant2, frais. qui stocke les frais par type d'operation.

### views 
- creation des pages frais/list et frais/form

### models
- creation du model montant_frais
- creation du model operation type

### controllers
- creation de fraisController :
    - creation des fonctions :
        - list (get liste des montant frais)
        - addType (ajouter libelle des types sur la table list montant-frais)

### routes 
- ajout des routes :
    - /frais
    - /frais/insert
    - /frais/update
    - /frais/delete

## CONFIGURATION PREFIX (Lorick - 3892)
### base
- table prefix_config

### views 
- creation des pages prefix/list et prefix/form

### models
- creation du model PrefixConfigModel

### controllers
- creation de prefixConfigController

### routes 
- ajout des routes :
    - /prefix
    - /prefix/insert
    - /prefix/update
    - /prefix/delete

## transaction (Amel - 3938)
## base
- Table operation_type : id, libelle. qui stocke les opérations valide (dépôt, retait, transfert)
- Table historique_transaction : id, type_operation, montant, frais, num_sender, num_receiver (nullable), date_transaction
- Ajouter une colonne solde dans ma table utilisateur

## fonction
- getFrais($operation, $montant) : fonction pour récupérer le frais par operation et montant
- transaction() : controller pour faire une transaction
    - vérifier le operation_type, si depot, retrait le numero destinataiure est null et + ou - sender; si transfert le numero destinataire est pas null et + pour le sender et - pour le receiver

## page
- form.php : formulaire pour faire une transaction : select option operation_type, input de numero sender, input de numero receiver, input de montant

## SITUATION (Lorick - 3892)
### base
- table historique

### views 
- creation des pages : historique/index

### controllers
- creation de historiqueController

### routes 
- ajout des routes :
    - /historique

## SITUATION (Lorick - 3892)
### base
- table historique

### views 
- creation des pages : gains/index et clients/index

### controllers
- creation de clientsController et GainsController

### routes 
- ajout des routes :
    - /gain
    - /client
