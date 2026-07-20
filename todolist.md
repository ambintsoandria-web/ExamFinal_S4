# creation de la base de donnée : 
- > creation des tables : 
    -utilisateurs
    -roles
    -utilisateur_roles
    -comptes_clients
    -types_operations
    -frais
    -transactions
    -transferts
    -prefixes

# login client et operateur(Alan et Ambinintsoa):
    ## Client (Ambinintsoa):
        . (ok)Front:
            .. (ok)Numero de telephone
            .. (ok)bouton valider
        . (ok)Services:
            .. (ok)isNumeroValide
            .. (ok)login
        . (ok)Controllers:
            .. (ok)ClientController:
                ...(ok)/
                ...(ok)connexion
                ...(ok)connexion client
    ## Operateur (Alan):
        . (ok)Front:
            .. (ok)Email
            .. (ok)bouton valider
        . (ok)Services:
            .. (ok)isNumeroValide
            .. (ok)login
        . (ok)Controllers:
            .. (ok)ClientController:
                ...(ok)/
                ...(ok)connexion
                ...(ok)connexion client