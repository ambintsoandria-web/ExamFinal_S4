-- ============================================
-- BASE DE DONNÉES - GESTION DES CONGÉS
-- TechMada RH
-- ============================================

-- TABLE : departements
CREATE TABLE departements (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT
);

-- TABLE : types_conge
CREATE TABLE types_conge (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    jours_annuels INTEGER NOT NULL,
    deductible BOOLEAN DEFAULT TRUE
);

-- TABLE : employes
CREATE TABLE employes (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'employe' CHECK (role IN ('employe', 'rh', 'admin')),
    departement_id INTEGER REFERENCES departements(id),
    date_embauche DATE,
    actif INTEGER DEFAULT 1 CHECK (actif IN (0, 1))
);

-- TABLE : soldes
CREATE TABLE soldes (
    id SERIAL PRIMARY KEY,
    employee_id INTEGER REFERENCES employes(id),
    type_conge_id INTEGER REFERENCES types_conge(id),
    annee INTEGER NOT NULL,
    jours_attribues INTEGER NOT NULL,
    jours_prix INTEGER DEFAULT 0,
    -- restant = jours_attribues - jours_prix (calculé, jamais stocké)
    UNIQUE(employee_id, type_conge_id, annee)
);

-- TABLE : conges
CREATE TABLE conges (
    id SERIAL PRIMARY KEY,
    employee_id INTEGER REFERENCES employes(id),
    type_conge_id INTEGER REFERENCES types_conge(id),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    nb_jours INTEGER NOT NULL,
    motif TEXT,
    statut VARCHAR(20) DEFAULT 'en_attente', -- en_attente, approuvee, refusee, annulee
    commentaire_rh TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER REFERENCES employes(id)
);


SELECT * FROM conges JOIN types_conge ON conges.type_conge_id = types_conge.id;

INSERT INTO employes (nom, prenom, email, password, role, actif) 
VALUES ('Rabe', 'Marie', 'marie@techmada.mg', 'hash', 'rh', 1);

INSERT INTO employes (nom, prenom, email, password, role, actif) 
VALUES ('Andria', 'Haja', 'haja@techmada.mg', 'hash', 'admin', 1);

INSERT INTO employes (nom, prenom, email, password, role, actif) 
VALUES ('Rakoto', 'Soa', 'employe@techmada.mg', 'emp123', 'employe', 1);



CREATE OR REPLACE FUNCTION calculerDureeJours(
    dateDebut DATE,
    dateFin DATE
)
RETURNS INTEGER AS $$
DECLARE
    duree INTEGER;
BEGIN
    SELECT (dateFin - dateDebut + 1) INTO duree;
    RETURN duree;
END;
$$ LANGUAGE plpgsql;


SELECT distinct(role) FROM employes;

SELECT * FROM employes JOIN departements ON employes.departement_id = departements.id;