-- ============================================
-- INSERTION DES DÉPARTEMENTS
-- ============================================

INSERT INTO departements (nom, description) VALUES 
('Informatique', 'Département IT - Développement, infrastructure et support technique'),
('Finance', 'Département financier - Comptabilité, gestion et analyse financière'),
('Ressources Humaines', 'Département RH - Gestion du personnel, recrutement et administration');

-- ============================================
-- INSERTION DES TYPES DE CONGÉ
-- ============================================

INSERT INTO types_conge (libelle, jours_annuels, deductible) VALUES 
('Congé annuel', 30, TRUE),
('Congé maladie', 10, TRUE),
('Congé spécial', 5, TRUE);

-- ============================================
-- INSERTION DES SOLDES INITIAUX (2025)
-- ============================================

-- Pour Marie Rabe (RH) - id 1
INSERT INTO soldes (employee_id, type_conge_id, annee, jours_attribues, jours_prix) VALUES 
(1, 1, 2025, 30, 5),   -- Congé annuel : 30 attribués, 5 pris
(1, 2, 2025, 10, 1),   -- Congé maladie : 10 attribués, 1 pris
(1, 3, 2025, 5, 2);    -- Congé spécial : 5 attribués, 2 pris

-- Pour Haja Andria (Admin) - id 2
INSERT INTO soldes (employee_id, type_conge_id, annee, jours_attribues, jours_prix) VALUES 
(2, 1, 2025, 30, 8),   -- Congé annuel : 30 attribués, 8 pris
(2, 2, 2025, 10, 0),   -- Congé maladie : 10 attribués, 0 pris
(2, 3, 2025, 5, 1);    -- Congé spécial : 5 attribués, 1 pris

-- Pour Tsiry Fidy (Employé inactif) - id 3
INSERT INTO soldes (employee_id, type_conge_id, annee, jours_attribues, jours_prix) VALUES 
(3, 1, 2025, 30, 12),  -- Congé annuel : 30 attribués, 12 pris
(3, 2, 2025, 10, 2),   -- Congé maladie : 10 attribués, 2 pris
(3, 3, 2025, 5, 3);    -- Congé spécial : 5 attribués, 3 pris


-- Voir tous les employés avec leurs départements
SELECT 
    e.id,
    e.nom,
    e.prenom,
    e.email,
    e.role,
    d.nom AS departement,
    CASE WHEN e.actif = 1 THEN 'Actif' ELSE 'Inactif' END AS statut
FROM employes e
LEFT JOIN departements d ON d.id = e.departement_id;


-- ============================================
-- INSERTION DES CONGÉS (10 demandes)
-- ============================================

-- Pour Soa Rakoto (employe_id = 3)
-- 1. Vider les insertions précédentes (optionnel)
TRUNCATE TABLE conges RESTART IDENTITY;

-- 2. Ajouter le type "Sans solde"
INSERT INTO types_conge (libelle, jours_annuels, deductible) 
VALUES ('Sans solde', 0, FALSE);

-- 3. Réinsérer toutes les demandes
INSERT INTO conges (employee_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, commentaire_rh, created_at, traite_par) VALUES 
(3, 8, '2025-06-16', '2025-06-20', 5, 'Vacances familiales', 'en_attente', NULL, '2025-06-10 09:30:00', NULL),
(3, 2, '2025-06-02', '2025-06-03', 2, 'Grippe', 'approuvee', 'Validé - Repos recommandé', '2025-05-28 14:20:00', 1),
(3, 1, '2025-05-12', '2025-05-16', 5, 'Voyage à Nosy Be', 'approuvee', 'OK', '2025-05-05 11:15:00', 1),
(3, 3, '2025-04-05', '2025-04-05', 1, 'Mariage du frère', 'refusee', 'Chevauchement avec demande existante', '2025-03-25 08:45:00', 1),
(3, 4, '2025-03-10', '2025-03-12', 3, 'Affaires personnelles', 'annulee', 'Annulé par l''employé', '2025-03-05 16:30:00', NULL),
(3, 1, '2025-07-21', '2025-07-25', 5, 'Congé d''été', 'en_attente', NULL, '2025-07-15 10:00:00', NULL),
(3, 2, '2025-01-14', '2025-01-15', 2, 'Consultation médicale', 'approuvee', 'OK', '2025-01-10 09:00:00', 1),
(1, 1, '2025-08-11', '2025-08-15', 5, 'Congé annuel RH', 'en_attente', NULL, '2025-08-05 13:45:00', NULL),
(1, 3, '2025-04-20', '2025-04-21', 2, 'Événement familial', 'approuvee', 'Approuvé', '2025-04-15 11:30:00', 2),
(2, 1, '2025-09-01', '2025-09-05', 5, 'Congé administratif', 'approuvee', 'Validé par RH', '2025-08-25 08:20:00', 1),
(2, 2, '2025-02-10', '2025-02-11', 2, 'Maladie', 'approuvee', 'Certificat médical fourni', '2025-02-08 14:00:00', 1);



SELECT SUM(nb_jours) FROM conges WHERE type_conge_id = 1 AND employee_id = 3;
INSERT INTO conges (employee_id, type_conge_id, date_debut, date_fin, nb_jours, motif, statut, commentaire_rh, created_at, traite_par) VALUES 
(3, 8, '2025-06-16', '2025-06-20', 5, 'Vacances familiales', 'en_attente', NULL, '2025-06-10 09:30:00', NULL);
