# Version 1
## Base
- Table prefix_config : id, value. qui stocke les préfixes valides pour les numéro (033, 037)
- Table role_utilisateur : id, libelle
- Table utilisateur : id, nom, prenom, numero, role
- Table operation_type : id, libelle. qui stocke les opérations valide (dépôt, retait, transfert)
- Table montant_frais : id, id_operation_type, montant1, montant2, frais. qui stocke les frais par type d'operation.
- Table historique_transaction : id, type_operation, montant, frais, num1, num2 (nullable) 

## fonctionnalité
### Côté opérateur
#### montant_frais
- Afficher la liste des montant_frais
- Cliquer sur un montant_frais pour modifier le montant1, montant2, et le frais
- Ajouter un montant_frais : select option de operation_type, montant1, montant2, frais
#### gain de frais
- calculer le montant obtenu par les gains via la table hitorique (somme des frais)
- situation des comptes clients : par client, voir le montant actuel, voir la liste des transaction
### Côté client
#### login
- page de login : numero de téléphone
#### opérations
- voir solde
- faire un dépôt
- faire un retrait
- faire un transfert (avec numero receveur)
- voir les historiques
