# base
- table operateur : id, nom, id_statut
- table statut_operateur : id, libelle avec trois ligne ('operateur', 'valable', 'non valable')
- Modifier la table prefix_config en ajoutant une colonne id_operateur
- table commission_config : id, id_operateur, precent
- Modifier la table historique_transaction en ajoutant une colonne commission
# fonctionnalité
## côté opérateur
### Operateur valable
- crud operateur 
- modifier le crud de prefix : en ajoutant un select option de operateur
### Commission config 
- CRUD pour la configuration des poucentages de transfert vers d'autre operateur dans la table (commission_config)
### Situation gain (rectification)
- Situation des gains par type d'opération et par opérateur (opérateur et les autres opérateurs), tel que pour les autres operateur, on affiche uniquement les situation de l'opération transfert
### Montant envoyer vers chaque opérateur
- Afficher les montants envoyer vers chaque operateur

## client
### Option retrait
- Lors d'un transfert, ajouter un checkbox si on veut aussi envoyer le frais de retrait lors de l'envoi ou pas
### Envoie multiple vers plusieurs numero 
- ajouter une ligne pour insérer d'autres numero
- diviser le montant pour chaque numero
- uniquement pour les mêmes opérateurs