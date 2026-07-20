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


# Version 2
## Login (Amel - 3938)
### base
- Table prefix_config : id, value, id_operateur. qui relie le numéro à l'opérateur
- Table statut_operateur : id, libelle. qui stocke les statuts (operateur, valable, non valable)
- Table operateur : id, nom, id_statut. qui stocke les opérateurs

### fonction
- findOperatorByNumero($numero) : fonction pour récupérer l'opérateur à partir du préfixe du numéro
- login() : controller pour faire le login, vérifier si le numéro appartient au bon opérateur, message d'erreur sinon

### page
- login.php : formulaire pour se le login : input de numero, bouton valider

## CONFIGURATION PREFIX (Lorick - 3892)
### base
- table prefix_config : ajout de la colonne id_operateur

### views 
- creation des pages prefix/list et prefix/form

### models
- creation du model PrefixConfigModel
- creation du model OperateurModel
- creation du model StatutOperateurModel

### controllers
- creation de prefixConfigController
- ajout du select opérateur dans le formulaire de prefix

### routes 
- ajout des routes :
    - /prefix
    - /prefix/insert
    - /prefix/update
    - /prefix/delete

## OPERATEUR ET COMMISSION (Amel - 3938)
### base
- table commission_config : id, id_operateur, pourcentage. qui stocke les commissions par opérateur
- table historique_transaction : ajout de la colonne commission

### views 
- creation des pages operateur/list et operateur/form
- creation des pages commission_config/list et commission_config/form

### models
- creation du model CommissionConfigModel

### controllers
- creation de operateurController
- creation de commissionConfigController

### routes 
- ajout des routes :
    - /operateurs
    - /commission-config

## TRANSACTION (Amel - 3938)
### base
- Table historique_transaction : id, type_operation, montant, frais, commission, num_sender, num_receiver, date_transaction
- Ajouter une colonne solde dans ma table utilisateur

### fonction
- getFrais($operation, $montant) : fonction pour récupérer le frais par operation et montant
- transaction() : controller pour faire une transaction
    - vérifier le operation_type
    - si depot, le numero destinataire est null et + ou - sender
    - si retrait, le numero destinataire est null et - sender
    - si transfert, le numero destinataire n'est pas null et + pour le sender et - pour le receiver
    - si l'option frais de retrait est cochée, le frais est ajouté seulement au solde du destinataire

### page
- form.php : formulaire pour faire une transaction : select option operation_type, input de numero sender, input de numero receiver, input de montant
- ajout d'un bouton pour plusieurs numéros destinataires

## SITUATION (Lorick - 3892)
### base
- table historique_transaction : ajout du champ commission pour le suivi des gains

### views 
- creation des pages historique/index et gains/index
- affichage des montants envoyés par opérateur

### controllers
- creation de historiqueController
- creation de GainsController

### routes 
- ajout des routes :
    - /historique
    - /gains

## CLIENT (Lorick - 3892)
### base
- table historique_transaction : conservation des opérations clients dans l'historique

### views 
- creation de la page client/historique

### controllers
- creation de clientController

### routes 
- ajout des routes :
    - /client/dashboard
    - /client/historique

