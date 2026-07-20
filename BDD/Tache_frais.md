# MONTANT FRAIS (LK)

# base 
- creation des tables :
    - Table operation_type : id, libelle. qui stocke les opérations valide (dépôt, retait, transfert)
    - Table montant_frais : id, id_operation_type, montant1, montant2, frais. qui stocke les frais par type d'operation.

# views 
- creation des pages frais/list et frais/form

# models
- creation du model montant_frais
- creation du model operation type

# controllers
- creation de fraisController :
    - creation des fonctions :
        - list (get liste des montant frais)
        - addType (ajouter libelle des types sur la table list montant-frais)

# routes 
- ajout des routes :
    - /frais
    - /frais/insert
    - /frais/update
    - /frais/delete