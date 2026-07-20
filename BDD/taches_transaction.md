# transaction
## base
- Table operation_type : id, libelle. qui stocke les opérations valide (dépôt, retait, transfert)
- Table historique_transaction : id, type_operation, montant, frais, num_sender, num_receiver (nullable), date_transaction
- Ajouter une colonne solde dans ma table utilisateur

## fonction
- makeTransaction($data) : fonction pour faire une transaction
- getFrais($operation, $montant) : fonction pour récupérer le frais par operation et montant
- transaction() : controller pour faire une transaction
    - vérifier le operation_type, si depot, retrait le numero destinataiure est null et + ou - sender; si transfert le numero destinataire est pas null et + pour le sender et - pour le receiver

## page
- form.php : formulaire pour faire une transaction : select option operation_type, input de numero sender, input de numero receiver, input de montant