CREATE DATABASE IF NOT EXISTS gouttes_rouges
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE gouttes_rouges;

CREATE TABLE administrateurs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  slug VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE articles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(180) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  image VARCHAR(255) DEFAULT NULL,
  extrait TEXT,
  contenu MEDIUMTEXT,
  auteur VARCHAR(120) DEFAULT NULL,
  categorie_id INT UNSIGNED DEFAULT NULL,
  date_publication DATE DEFAULT NULL,
  statut ENUM('brouillon','publie') DEFAULT 'publie',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_articles_categorie FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE campagnes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(180) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  image VARCHAR(255) DEFAULT NULL,
  description TEXT,
  contenu MEDIUMTEXT,
  date_debut DATE DEFAULT NULL,
  date_fin DATE DEFAULT NULL,
  statut ENUM('brouillon','publie') DEFAULT 'publie',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE types_dons (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  libelle VARCHAR(80) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE utilisateurs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  telephone VARCHAR(40) DEFAULT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE donateurs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL,
  telephone VARCHAR(40) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE dons (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  donateur_id INT UNSIGNED NOT NULL,
  type_don_id INT UNSIGNED NOT NULL,
  montant DECIMAL(12,2) DEFAULT NULL,
  quantite INT DEFAULT NULL,
  materiel VARCHAR(160) DEFAULT NULL,
  campagne_id INT UNSIGNED DEFAULT NULL,
  message TEXT,
  statut ENUM('en_attente','recu','traite') DEFAULT 'en_attente',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dons_donateur FOREIGN KEY (donateur_id) REFERENCES donateurs(id) ON DELETE CASCADE,
  CONSTRAINT fk_dons_type FOREIGN KEY (type_don_id) REFERENCES types_dons(id),
  CONSTRAINT fk_dons_campagne FOREIGN KEY (campagne_id) REFERENCES campagnes(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE visiteurs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  email VARCHAR(160) NOT NULL,
  telephone VARCHAR(40) DEFAULT NULL,
  ville VARCHAR(80) DEFAULT NULL,
  domaine_interet VARCHAR(120) DEFAULT NULL,
  motivation TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  telephone VARCHAR(40) DEFAULT NULL,
  objet VARCHAR(160) NOT NULL,
  message TEXT NOT NULL,
  statut ENUM('nouveau','traite','archive') DEFAULT 'nouveau',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE partenaires (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(160) NOT NULL,
  logo VARCHAR(255) DEFAULT NULL,
  site_web VARCHAR(255) DEFAULT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE demandes_partenariat (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  organisation VARCHAR(160) NOT NULL,
  responsable VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL,
  telephone VARCHAR(40) DEFAULT NULL,
  type_partenariat VARCHAR(80) DEFAULT NULL,
  message TEXT,
  statut ENUM('nouvelle','en_cours','acceptee','refusee') DEFAULT 'nouvelle',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE newsletter (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NOT NULL UNIQUE,
  date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('actif','desinscrit') DEFAULT 'actif'
) ENGINE=InnoDB;

CREATE TABLE equipe (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(120) NOT NULL,
  fonction VARCHAR(120) NOT NULL,
  bio TEXT,
  photo VARCHAR(255) DEFAULT NULL,
  ordre INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE temoignages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  citation TEXT NOT NULL,
  nom VARCHAR(80) NOT NULL,
  role VARCHAR(120) DEFAULT NULL,
  photo VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE chiffres_cles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  valeur VARCHAR(40) NOT NULL,
  libelle VARCHAR(120) NOT NULL,
  icone VARCHAR(40) DEFAULT 'star',
  ordre INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE faq (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  question VARCHAR(255) NOT NULL,
  reponse TEXT NOT NULL,
  ordre INT DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE glossaire (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  terme VARCHAR(120) NOT NULL,
  definition TEXT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE supports_educatifs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(180) NOT NULL,
  type VARCHAR(40) DEFAULT 'PDF',
  description TEXT,
  fichier VARCHAR(255) DEFAULT NULL,
  date_publication DATE DEFAULT NULL
) ENGINE=InnoDB;

INSERT INTO administrateurs (nom, prenom, email, mot_de_passe) VALUES
('Koné', 'Aminata', 'admin@gouttesrouges.org', '$2y$12$7IxMC0BnsRK/c5GezgFWweRkXsbod1MiWUvfVKn60WO4s8cZ6eeCS');

INSERT INTO categories (nom, slug) VALUES
('Guides', 'guides'),
('Éducation', 'education'),
('Santé', 'sante'),
('Plaidoyer', 'plaidoyer');

INSERT INTO articles (titre, slug, image, extrait, contenu, auteur, categorie_id, date_publication, statut) VALUES
('Comprendre la précarité menstruelle en Côte d''Ivoire', 'comprendre-la-precarite-menstruelle', 'img/article-1.jpg',
 'Un éclairage sur les obstacles concrets que rencontrent les filles et les femmes pour vivre leurs règles dans la dignité.',
 '<p>La précarité menstruelle désigne l''impossibilité d''accéder à des protections périodiques suffisantes, à de l''eau, à des sanitaires décents et à une information fiable.</p><p>Gouttes Rouges documente ces réalités, forme les communautés et distribue des kits afin que les règles ne soient plus un facteur d''exclusion.</p>',
 'Rédaction Gouttes Rouges', 1, '2026-03-12', 'publie'),
('Comment parler des règles à l''école', 'parler-des-regles-a-lecole', 'img/article-2.jpg',
 'Un guide pratique pour enseignants, éducateurs et parents qui souhaitent aborder le sujet avec respect et clarté.',
 '<p>Parler des règles en classe n''est pas un luxe : c''est une condition de la réussite scolaire.</p>',
 'Marie-Laure Adjoua', 2, '2026-02-04', 'publie'),
('Hygiène menstruelle : gestes essentiels', 'hygiene-menstruelle-gestes-essentiels', 'img/article-3.jpg',
 'Les bons réflexes pour prendre soin de son corps pendant les règles, même avec peu de moyens.',
 '<p>Se laver les mains, changer régulièrement de protection et connaître son cycle sont des gestes simples qui protègent la santé.</p>',
 'Aminata Koné', 3, '2026-01-18', 'publie'),
('Les droits menstruels, un enjeu de justice', 'droits-menstruels-enjeu-de-justice', 'img/article-4.jpg',
 'Pourquoi l''accès aux protections et à l''information n''est pas une faveur, mais un droit.',
 '<p>La santé menstruelle s''inscrit dans le droit à la santé, à l''éducation et à la dignité.</p>',
 'Fatoumata Diallo', 4, '2025-11-22', 'publie');

INSERT INTO campagnes (titre, slug, image, description, contenu, date_debut, date_fin, statut) VALUES
('Brisons le Silence', 'brisons-le-silence', 'img/campagne-1.jpg',
 'Une campagne nationale pour lever les tabous autour des règles et ouvrir la parole dans les familles, les écoles et les médias.',
 '<p>Ateliers, témoignages et actions de rue pour que plus aucune fille ne vive ses règles dans la honte.</p>',
 '2023-10-01', '2023-10-31', 'publie'),
('Règles Sûres, Règles Dignes', 'regles-sures-regles-dignes', 'img/campagne-2.jpg',
 'Distribution de kits, formation à l''hygiène menstruelle et aménagement d''espaces d''accueil dans les établissements scolaires.',
 '<p>Cette campagne relie don matériel et éducation.</p>',
 '2024-03-01', '2024-06-30', 'publie'),
('Sang Peur', 'sang-peur', 'img/campagne-3.jpg',
 'Une campagne jeunesse pour déconstruire la peur, les mythes et les interdits qui entourent le sang menstruel.',
 '<p>Capsules vidéo, clubs scolaires et ateliers de leadership.</p>',
 '2025-05-01', '2025-08-31', 'publie');

INSERT INTO types_dons (libelle) VALUES ('financier'), ('materiel');

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

INSERT INTO equipe (nom, fonction, bio, photo, ordre) VALUES
('Aminata Koné', 'Fondatrice & Présidente', 'Militante de la santé menstruelle.', 'img/team-1.jpg', 1),
('Yao Kouassi', 'Coordinateur des programmes', 'Pilote les actions de terrain.', 'img/team-2.jpg', 2),
('Marie-Laure Adjoua', 'Responsable sensibilisation', 'Conçoit les ateliers éducatifs.', 'img/team-3.jpg', 3),
('Fatoumata Diallo', 'Chargée de plaidoyer', 'Porte la voix des filles auprès des institutions.', 'img/team-4.jpg', 4);

INSERT INTO temoignages (citation, nom, role, photo) VALUES
('Grâce au Club Rouge, j''ai appris à comprendre mon cycle et je ne manque plus l''école pendant mes règles.', 'Amélie', 'Bénéficiaire, Club Rouge', 'img/avatar-amelie.jpg'),
('Les ateliers en établissement ont changé le regard des élèves et des enseignants.', 'Thomas', 'Enseignant partenaire', 'img/avatar-thomas.jpg');

INSERT INTO chiffres_cles (valeur, libelle, icone, ordre) VALUES
('5000+', 'Filles sensibilisées', 'users', 1),
('2000+', 'Kits distribués', 'kit', 2),
('15+', 'Villes visitées', 'map', 3),
('30+', 'Campagnes réalisées', 'megaphone', 4);

INSERT INTO faq (question, reponse, ordre) VALUES
('Qu''est-ce que la précarité menstruelle ?', 'C''est l''impossibilité d''accéder à des protections, à de l''eau, à des sanitaires adaptés et à une information fiable.', 1),
('Comment sont utilisés les dons ?', 'Les dons financiers servent à l''achat de protections et à l''organisation d''ateliers. Les dons matériels sont distribués sur le terrain.', 2),
('Puis-je faire un don en nature ?', 'Oui. Serviettes, culottes menstruelles, savon et sous-vêtements neufs sont les produits les plus utiles.', 3),
('Comment devenir bénévole ?', 'Remplissez le formulaire sur la page Nous soutenir. L''équipe vous recontacte selon les besoins.', 4);

INSERT INTO glossaire (terme, definition) VALUES
('Cycle menstruel', 'Ensemble des transformations hormonales, généralement sur 21 à 35 jours.'),
('Précarité menstruelle', 'Situation dans laquelle une personne ne peut pas gérer ses règles de façon sûre et digne.'),
('Kit menstruel', 'Ensemble de protections distribué aux bénéficiaires.'),
('Santé menstruelle', 'État de bien-être physique, psychique et social en lien avec le cycle.');

INSERT INTO supports_educatifs (titre, type, description, fichier, date_publication) VALUES
('Livret « Mes premières règles »', 'PDF', 'Un support illustré pour les adolescentes et les familles.', 'supports/livret-premieres-regles.pdf', '2026-01-10'),
('Affiche hygiène menstruelle', 'Affiche', 'À coller dans les écoles et les centres de santé.', 'supports/affiche-hygiene.pdf', '2026-02-02'),
('Fiche atelier Club Rouge', 'Fiche', 'Trame d''animation pour les relais scolaires.', 'supports/fiche-atelier.pdf', '2026-03-01');
