# base
- table operateur : id, nom, id_statut
- table statut_operateur : id, libelle avec trois ligne ('operateur', 'valable', 'non valable')
- Modifier la table prefix_config en ajoutant une colonne id_operateur
- table commission_config : id, id_operateur, pourcentage
- Modifier la table historique_transaction en ajoutant une colonne commission (prix)

# fonctionnalité
## côté opérateur
### Operateur
- crud operateur 

### prefix
- modifier le crud de prefix : en ajoutant un select option de operateur

### Commission config 
- CRUD pour la configuration des poucentages de transfert vers d'autre operateur dans la table (commission_config)

### transaction
- lors d'un transaction il faut verifier le numero du destinataire si elle est statut operateur ou valable : 
    - si operateur suit transaction normale
    - si valable commission = montant * pourcentage (du commission de l'operateur) , solde envoyeur - commission (lors du calcul de solde) et operateur valable + commission (lors de calcul gain)
    - il faut tjrs verifier le solde avant chaque transaction

### Situation gain (rectification)
- dans situation des gains :
    - ajoute uns table details gains des autres operateurs
### Montant envoyer vers chaque opérateur
- Afficher les montants envoyer vers chaque operateur

## client
### transaction
- Lors d'un transfert, ajouter un checkbox si on veut aussi envoyer le frais de retrait lors de l'envoi ou pas (montant envoyer au destinataire sera + frais de retrait si checker)

### Envoie multiple vers plusieurs numero 
- ajouter un btn pour insérer d'autres numero
- diviser le montant pour chaque numero
- uniquement pour les mêmes opérateurs