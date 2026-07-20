# Login 
## base
- Table prefix_config : id, value. qui stocke les préfixes valides pour les numéro (033, 037)
- Table role_utilisateur : id, libelle
- Table utilisateur : id, nom, prenom, numero, role

## fonction
- findByNumero($numero) : fontion pour récupérer un utilisateur par son numero
- login() : fonction pour faire le login, vérifier si l'utilisateur existe, message d'erreur sinon

## page
- login.php : formulaire pour se le login : input de numero, bouton valider