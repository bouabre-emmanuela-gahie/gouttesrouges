-- Mise à jour d'octobre 2026 : comptes donateurs et logos « Ils soutiennent la cause ».
-- À exécuter une fois sur une base existante (phpMyAdmin > SQL).

CREATE TABLE IF NOT EXISTS utilisateurs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  telephone VARCHAR(40) DEFAULT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

DELETE FROM partenaires WHERE logo LIKE 'img/partner-%.svg';

INSERT INTO partenaires (nom, logo, site_web, description) VALUES
('Ministère de la Santé et de l''Hygiène Publique', 'img/partenaires/ministere-sante.png', 'https://www.sante.gouv.ci', 'Partenaire institutionnel'),
('Equipop', 'img/partenaires/equipop.png', 'https://equipop.org', ''),
('EngenderHealth', 'img/partenaires/engenderhealth.png', 'https://www.engenderhealth.org', ''),
('Ipas Afrique Francophone', 'img/partenaires/ipas.png', 'https://www.ipas.org', ''),
('Solthis', 'img/partenaires/solthis.png', 'https://www.solthis.org', ''),
('PNSME', 'img/partenaires/pnsme.png', '', 'Programme National de Santé de la Mère et de l''Enfant'),
('Perfect', 'img/partenaires/perfect.png', '', ''),
('Africa Forward', 'img/partenaires/africa-forward.png', '', ''),
('PNSSU-SAJ', 'img/partenaires/pnssu-saj.png', '', 'Programme National de Santé Scolaire et Universitaire'),
('Médecins du Monde', 'img/partenaires/medecins-du-monde.png', 'https://www.medecinsdumonde.org', '');
