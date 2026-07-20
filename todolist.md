# ===================================================================
# TODO LIST DU PROJET SUPERMARCHE
# Gestion de caisse avec CodeIgniter et SQLite
# ===================================================================

# ===================================================================
# 1. BASE DE DONNEES
# ===================================================================

# 1.1 CREATION DES TABLES

 Table produits

CREATE TABLE produits (
    id_produit INTEGER PRIMARY KEY AUTOINCREMENT,
    designation TEXT NOT NULL,
    prix_vente REAL NOT NULL CHECK(prix_vente >= 0),
    stock INTEGER NOT NULL DEFAULT 0 CHECK(stock >= 0),
    code_barre TEXT UNIQUE,
    categorie TEXT
);

 Table caisses

CREATE TABLE caisses (
    id_caisse INTEGER PRIMARY KEY AUTOINCREMENT,
    numero INTEGER UNIQUE NOT NULL,
    caissier TEXT,
    statut TEXT DEFAULT 'ouverte' CHECK(statut IN ('ouverte', 'fermee'))
);

 Table achats

CREATE TABLE achats (
    id_achat INTEGER PRIMARY KEY AUTOINCREMENT,
    id_caisse INTEGER NOT NULL,
    date_achat DATETIME DEFAULT CURRENT_TIMESTAMP,
    total REAL DEFAULT 0,
    statut TEXT DEFAULT 'en_cours' CHECK(statut IN ('en_cours', 'cloture')),
    FOREIGN KEY (id_caisse) REFERENCES caisses(id_caisse)
);

 Table lignes_achat

CREATE TABLE lignes_achat (
    id_ligne INTEGER PRIMARY KEY AUTOINCREMENT,
    id_achat INTEGER NOT NULL,
    id_produit INTEGER NOT NULL,
    quantite INTEGER NOT NULL CHECK(quantite > 0),
    prix_unitaire REAL NOT NULL,
    FOREIGN KEY (id_achat) REFERENCES achats(id_achat) ON DELETE CASCADE,
    FOREIGN KEY (id_produit) REFERENCES produits(id_produit)
);

 Table utilisateurs

CREATE TABLE utilisateurs (
    id_user INTEGER PRIMARY KEY AUTOINCREMENT,
    login TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    nom_complet TEXT,
    role TEXT DEFAULT 'caissier' CHECK(role IN ('admin', 'caissier'))
);

# 1.2 INSERTION DES DONNEES INITIALES

 Inserer 5 produits
 Inserer 2 caisses
 Inserer 2 utilisateurs (admin et caissier)

# 1.3 MODIFICATIONS

 Ajouter la colonne id_user dans achats

# ===================================================================
# 2. CONTROLEURS
# ===================================================================

# 2.1 AUTHCONTROLLER.PHP

 Methode login() - Afficher le formulaire de connexion
 Methode doLogin() - Traiter la connexion
 Methode logout() - Deconnecter l'utilisateur

# 2.2 CAISSECONTROLLER.PHP

 Methode choixCaisse() - Afficher les caisses disponibles
 Methode validerCaisse() - Selectionner une caisse
 Methode saisieAchat() - Afficher la page de saisie
 Methode ajouterProduit() - Ajouter un produit au panier
 Methode supprimerLigne() - Supprimer une ligne du panier
 Methode validerAchat() - Finaliser l'achat
 Methode viderPanier() - Vider le panier
 Methode historique() - Afficher l'historique des achats
 Methode detail($id_achat) - Afficher le detail d'un achat
 Methode listeProduits() - Afficher la liste des produits
 Methode listeCaisses() - Afficher la liste des caisses
 Methode listeUtilisateurs() - Afficher la liste des utilisateurs
 Methode statistiques() - Afficher les statistiques

# ===================================================================
# 3. MODELES
# ===================================================================

# 3.1 PRODUITMODEL.PHP

 getAllProduits() - Recuperer tous les produits
 getProduit($id) - Recuperer un produit par son ID
 hasStock($id, $quantite) - Verifier le stock
 updateStock($id, $quantite) - Mettre a jour le stock

# 3.2 CAISSEMODEL.PHP

 getAllCaisse() - Recuperer toutes les caisses ouvertes
 getById($id) - Recuperer une caisse par ID
 getByNumero($numero) - Recuperer une caisse par numero
 estOuverte($id) - Verifier si une caisse est ouverte
 ouvrirCaisse($id, $caissier) - Ouvrir une caisse
 fermerCaisse($id) - Fermer une caisse
 getAllCaisses() - Recuperer toutes les caisses
 countOuvertes() - Compter les caisses ouvertes

# 3.3 ACHATMODEL.PHP

 creerAchat($id_caisse, $id_user) - Creer un nouvel achat
 getAchatEnCours($id_caisse) - Recuperer l'achat en cours
 getAchat($id) - Recuperer un achat par ID
 calculerTotal($id) - Calculer le total d'un achat
 getAllAchats($id_caisse) - Recuperer tous les achats

# 3.4 LIGNEACHATMODEL.PHP

 ajouterProduit($id_achat, $id_produit, $quantite) - Ajouter un produit
 getLignesByAchat($id_achat) - Recuperer les lignes d'un achat
 getLignesAvecProduits($id_achat) - Recuperer les lignes avec produits
 supprimerLigne($id_ligne) - Supprimer une ligne
 getLigne($id_ligne) - Recuperer une ligne par ID

# 3.5 UTILISATEURMODEL.PHP

 logged_in($login, $password) - Verifier les identifiants
 loginExiste($login) - Verifier si un login existe
 getByLogin($login) - Recuperer un utilisateur par login
 getCaissiers() - Recuperer tous les caissiers

# ===================================================================
# 4. VUES
# ===================================================================

# 4.1 PAGES D'AUTHENTIFICATION

 login.php - Formulaire de connexion

# 4.2 PAGES DE CAISSE

 choix_caisse.php - Choix de la caisse
 saisie_achat.php - Saisie des achats

# 4.3 PAGES D'HISTORIQUE

 historique.php - Liste des achats
 historique_detail.php - Detail d'un achat

# 4.4 PAGES DE GESTION

 produits.php - Liste des produits
 caisses.php - Liste des caisses
 utilisateurs.php - Liste des utilisateurs

# 4.5 PAGES DE STATISTIQUES

 statistiques.php - Statistiques

# 4.6 TEMPLATES

 sidebar.php - Barre laterale
 layout.php - Layout principal

# ===================================================================
# 5. ROUTES
# ===================================================================

# 5.1 ROUTES D'AUTHENTIFICATION

 GET / -> AuthController::login
 POST /auth/login -> AuthController::doLogin
 GET /auth/logout -> AuthController::logout
 POST /auth/logout -> AuthController::logout

# 5.2 ROUTES DE CAISSE

 GET /choix-caisse -> CaisseController::choixCaisse
 POST /valider-caisse -> CaisseController::validerCaisse

# 5.3 ROUTES D'ACHAT

 GET /saisie-achat -> CaisseController::saisieAchat
 POST /ajouter-produit -> CaisseController::ajouterProduit
 POST /supprimer-ligne -> CaisseController::supprimerLigne
 POST /valider-achat -> CaisseController::validerAchat
 POST /vider-panier -> CaisseController::viderPanier

# 5.4 ROUTES D'HISTORIQUE

 GET /historique -> CaisseController::historique
 GET /historique/detail/(:num) -> CaisseController::detail

# 5.5 ROUTES DE GESTION

 GET /produits -> CaisseController::listeProduits
 GET /caisses -> CaisseController::listeCaisses
 GET /utilisateurs -> CaisseController::listeUtilisateurs

# 5.6 ROUTES DE STATISTIQUES

 GET /statistiques -> CaisseController::statistiques

# ===================================================================
# 6. FONCTIONNALITES IMPLEMENTEES
# ===================================================================

# 6.1 AUTHENTIFICATION

 Connexion avec login et mot de passe
 Deconnexion
 Gestion de session
 Comptes de test (admin/admin123, caissier/caisse123)

# 6.2 CHOIX DE LA CAISSE

 Afficher les caisses ouvertes
 Selectionner une caisse
 Stocker la caisse en session

# 6.3 SAISIE DES ACHATS

 Ajouter un produit au panier
 Modifier la quantite
 Supprimer une ligne du panier
 Voir le total du panier
 Valider l'achat
 Vider le panier
 Verifier le stock avant ajout
 Mettre a jour le stock apres validation
 Assigner l'utilisateur a l'achat

# 6.4 HISTORIQUE

 Voir la liste des achats
 Voir le detail d'un achat
 Afficher les lignes d'un achat
 Afficher le total de l'achat

# 6.5 GESTION DES PRODUITS

 Voir la liste des produits
 Voir le stock
 Voir le prix
 Voir la categorie

# 6.6 GESTION DES CAISSES

 Voir la liste des caisses
 Voir le statut des caisses
 Voir le caissier

# 6.7 GESTION DES UTILISATEURS

 Voir la liste des utilisateurs
 Voir le role des utilisateurs

# 6.8 STATISTIQUES

 Voir le nombre total d'achats
 Voir le chiffre d'affaires total
 Voir le nombre d'utilisateurs
 Voir le nombre de produits
 Voir le graphique des achats par jour
 Voir le top des utilisateurs

# ===================================================================
# 7. FONCTIONNALITES A VENIR
# ===================================================================

# 7.1 PRODUITS

[ ] Ajouter un produit
[ ] Modifier un produit
[ ] Supprimer un produit
[ ] Rechercher un produit

# 7.2 CAISSES

[ ] Ouvrir une caisse
[ ] Fermer une caisse
[ ] Ajouter une caisse

# 7.3 UTILISATEURS

[ ] Ajouter un utilisateur
[ ] Modifier un utilisateur
[ ] Supprimer un utilisateur

# 7.4 SECURITE

[ ] Hasher les mots de passe
[ ] Ajouter un filtre d'authentification
[ ] Ajouter la validation CSRF
[ ] Limiter les tentatives de connexion

# 7.5 AMELIORATIONS

[ ] Recherche de produits
[ ] Pagination de l'historique
[ ] Impression des tickets
[ ] Export des donnees
[ ] Gestion des promotions
[ ] Gestion des remises
[ ] Mode sombre

# ===================================================================
# 8. TESTS
# ===================================================================

 Connexion avec admin/admin123
 Connexion avec caissier/caisse123
 Choix d'une caisse
 Ajout d'un produit au panier
 Suppression d'une ligne du panier
 Validation d'un achat
 Vidage du panier
 Affichage de l'historique
 Affichage du detail d'un achat
 Affichage de la liste des produits
 Affichage de la liste des caisses
 Affichage de la liste des utilisateurs
 Affichage des statistiques
 Deconnexion
