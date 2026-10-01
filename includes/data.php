<?php
declare(strict_types=1);

function fallback_articles(): array
{
    return [
        [
            'id' => 1,
            'titre' => 'Comprendre la précarité menstruelle en Côte d\'Ivoire',
            'slug' => 'comprendre-la-precarite-menstruelle',
            'image' => 'img/article-1.jpg',
            'extrait' => 'Un éclairage sur les obstacles concrets que rencontrent les filles et les femmes pour vivre leurs règles dans la dignité.',
            'contenu' => '<p>La précarité menstruelle désigne l\'impossibilité d\'accéder à des protections périodiques suffisantes, à de l\'eau, à des sanitaires décents et à une information fiable. En Côte d\'Ivoire, elle touche particulièrement les adolescentes scolarisées, les filles des quartiers populaires et les femmes en situation de précarité économique.</p><p>Gouttes Rouges documente ces réalités, forme les communautés et distribue des kits afin que les règles ne soient plus un facteur d\'exclusion.</p><p>Briser le silence, c\'est déjà commencer à réparer une injustice quotidienne.</p>',
            'auteur' => 'Rédaction Gouttes Rouges',
            'categorie' => 'Guides',
            'date_publication' => '2026-03-12',
        ],
        [
            'id' => 2,
            'titre' => 'Comment parler des règles à l\'école',
            'slug' => 'parler-des-regles-a-lecole',
            'image' => 'img/article-2.jpg',
            'extrait' => 'Un guide pratique pour enseignants, éducateurs et parents qui souhaitent aborder le sujet avec respect et clarté.',
            'contenu' => '<p>Parler des règles en classe n\'est pas un luxe : c\'est une condition de la réussite scolaire. Trop de filles manquent l\'école chaque mois par manque de protections, de sanitaires ou simplement d\'information.</p><p>Ce guide propose des mots justes, des activités adaptées et des réflexes pour créer un climat de confiance.</p>',
            'auteur' => 'Marie-Laure Adjoua',
            'categorie' => 'Éducation',
            'date_publication' => '2026-02-04',
        ],
        [
            'id' => 3,
            'titre' => 'Hygiène menstruelle : gestes essentiels',
            'slug' => 'hygiene-menstruelle-gestes-essentiels',
            'image' => 'img/article-3.jpg',
            'extrait' => 'Les bons réflexes pour prendre soin de son corps pendant les règles, même avec peu de moyens.',
            'contenu' => '<p>Se laver les mains, changer régulièrement de protection, sécher les tissus au soleil et connaître son cycle sont des gestes simples qui protègent la santé.</p><p>Ce guide rappelle les essentiels, sans jargon, pour les adolescentes comme pour leurs familles.</p>',
            'auteur' => 'Aminata Koné',
            'categorie' => 'Santé',
            'date_publication' => '2026-01-18',
        ],
        [
            'id' => 4,
            'titre' => 'Les droits menstruels, un enjeu de justice',
            'slug' => 'droits-menstruels-enjeu-de-justice',
            'image' => 'img/article-4.jpg',
            'extrait' => 'Pourquoi l\'accès aux protections et à l\'information n\'est pas une faveur, mais un droit.',
            'contenu' => '<p>La santé menstruelle s\'inscrit dans le droit à la santé, à l\'éducation et à la dignité. Gouttes Rouges porte ce plaidoyer auprès des établissements, des collectivités et des partenaires institutionnels.</p>',
            'auteur' => 'Fatoumata Diallo',
            'categorie' => 'Plaidoyer',
            'date_publication' => '2025-11-22',
        ],
    ];
}

function fallback_campagnes(): array
{
    return [
        [
            'id' => 1,
            'titre' => 'Brisons le Silence',
            'slug' => 'brisons-le-silence',
            'image' => 'img/campagne-1.jpg',
            'description' => 'Une campagne nationale pour lever les tabous autour des règles et ouvrir la parole dans les familles, les écoles et les médias.',
            'contenu' => '<p>Brisons le Silence invite les communautés à nommer ce qui a trop longtemps été chuchoté. Ateliers, témoignages et actions de rue pour que plus aucune fille ne vive ses règles dans la honte.</p>',
            'date_debut' => '2023-10-01',
            'date_fin' => '2023-10-31',
        ],
        [
            'id' => 2,
            'titre' => 'Règles Sûres, Règles Dignes',
            'slug' => 'regles-sures-regles-dignes',
            'image' => 'img/campagne-2.jpg',
            'description' => 'Distribution de kits, formation à l\'hygiène menstruelle et aménagement d\'espaces d\'accueil dans les établissements scolaires.',
            'contenu' => '<p>Cette campagne relie don matériel et éducation : un kit ne suffit pas si la fille n\'a ni information ni lieu sûr pour se changer.</p>',
            'date_debut' => '2024-03-01',
            'date_fin' => '2024-06-30',
        ],
        [
            'id' => 3,
            'titre' => 'Sang Peur',
            'slug' => 'sang-peur',
            'image' => 'img/campagne-3.jpg',
            'description' => 'Une campagne jeunesse pour déconstruire la peur, les mythes et les interdits qui entourent le sang menstruel.',
            'contenu' => '<p>Sang Peur joue sur les mots pour désarmer la peur. Capsules vidéo, clubs scolaires et ateliers de leadership pour que les filles osent parler, rêver et agir.</p>',
            'date_debut' => '2025-05-01',
            'date_fin' => '2025-08-31',
        ],
        [
            'id' => 4,
            'titre' => 'Mois de l\'hygiène menstruelle',
            'slug' => 'mois-hygiene-menstruelle',
            'image' => 'img/hero-actions.jpg',
            'description' => 'Chaque année, un mois d\'actions scolaires, de distributions et de prises de parole pour ancrer la dignité menstruelle dans le débat public.',
            'contenu' => '<p>Le mois de l\'hygiène menstruelle rassemble établissements, partenaires et bénévoles autour d\'ateliers, de kits et de campagnes médias.</p>',
            'date_debut' => '2026-05-01',
            'date_fin' => '2026-05-31',
        ],
    ];
}

function fallback_partenaires(): array
{
    return [
        ['nom' => 'Ministère de la Santé', 'logo' => 'img/partner-1.svg', 'site_web' => '#'],
        ['nom' => 'UNICEF Côte d\'Ivoire', 'logo' => 'img/partner-2.svg', 'site_web' => '#'],
        ['nom' => 'Fondation Femmes d\'Avenir', 'logo' => 'img/partner-3.svg', 'site_web' => '#'],
        ['nom' => 'Réseau Écoles Solidaires', 'logo' => 'img/partner-4.svg', 'site_web' => '#'],
        ['nom' => 'Clinique Espoir Abidjan', 'logo' => 'img/partner-5.svg', 'site_web' => '#'],
    ];
}

function fallback_temoignages(): array
{
    return [
        [
            'citation' => 'Grâce au Club Rouge, j\'ai appris à comprendre mon cycle et je ne manque plus l\'école pendant mes règles. On peut enfin en parler sans avoir honte.',
            'nom' => 'Amélie',
            'role' => 'Bénéficiaire, Club Rouge',
            'photo' => 'img/avatar-amelie.jpg',
        ],
        [
            'citation' => 'Les ateliers en établissement ont changé le regard des élèves et des enseignants. Les filles osent demander de l\'aide, et les garçons écoutent.',
            'nom' => 'Thomas',
            'role' => 'Enseignant partenaire',
            'photo' => 'img/avatar-thomas.jpg',
        ],
    ];
}

function fallback_equipe(): array
{
    return [
        ['nom' => 'Aminata Koné', 'fonction' => 'Fondatrice & Présidente', 'bio' => 'Militante de la santé menstruelle, elle a créé Gouttes Rouges pour que chaque fille puisse vivre ses règles dans la dignité.', 'photo' => 'img/team-1.jpg'],
        ['nom' => 'Yao Kouassi', 'fonction' => 'Coordinateur des programmes', 'bio' => 'Il pilote les actions de terrain à Abidjan et dans les villes de l\'intérieur.', 'photo' => 'img/team-2.jpg'],
        ['nom' => 'Marie-Laure Adjoua', 'fonction' => 'Responsable sensibilisation', 'bio' => 'Elle conçoit les ateliers éducatifs et forme les relais communautaires.', 'photo' => 'img/team-3.jpg'],
        ['nom' => 'Fatoumata Diallo', 'fonction' => 'Chargée de plaidoyer', 'bio' => 'Elle porte la voix des filles auprès des institutions et des partenaires.', 'photo' => 'img/team-4.jpg'],
    ];
}

function fallback_chiffres(): array
{
    return [
        ['valeur' => '5000+', 'libelle' => 'Filles sensibilisées', 'icone' => 'users'],
        ['valeur' => '2000+', 'libelle' => 'Kits distribués', 'icone' => 'kit'],
        ['valeur' => '15+', 'libelle' => 'Villes visitées', 'icone' => 'map'],
        ['valeur' => '30+', 'libelle' => 'Campagnes réalisées', 'icone' => 'megaphone'],
    ];
}

function fallback_domaines(): array
{
    return [
        [
            'titre' => 'Éducation menstruelle',
            'texte' => 'Ateliers en milieu scolaire et communautaire pour comprendre le cycle, briser les mythes et adopter les bons gestes d\'hygiène.',
            'image' => 'img/article-2.jpg',
        ],
        [
            'titre' => 'Lutte contre la précarité',
            'texte' => 'Distribution de kits menstruels, dons en nature et accès à des protections pour que plus aucune fille ne manque l\'école.',
            'image' => 'img/programme-2.jpg',
        ],
        [
            'titre' => 'Plaidoyer institutionnel',
            'texte' => 'Dialogue avec les établissements, collectivités et autorités pour faire reconnaître la santé menstruelle comme un droit.',
            'image' => 'img/article-4.jpg',
        ],
        [
            'titre' => 'Recherche & Analyse',
            'texte' => 'Collecte de données, enquêtes de terrain et publications pour documenter la précarité menstruelle en Côte d\'Ivoire.',
            'image' => 'img/article-1.jpg',
        ],
        [
            'titre' => 'Leadership des jeunes filles',
            'texte' => 'Clubs, mentorat et camps pour que les adolescentes prennent la parole, s\'entraident et deviennent des relais dans leurs communautés.',
            'image' => 'img/programme-5.jpg',
        ],
        [
            'titre' => 'Sensibilisation communautaire',
            'texte' => 'Actions de proximité dans les quartiers et les villages pour ouvrir la parole avec les familles, les relais et les jeunes.',
            'image' => 'img/campagne-2.jpg',
        ],
    ];
}

function fallback_programmes(): array
{
    return [
        [
            'titre' => 'Club Rouge',
            'texte' => 'Des clubs scolaires où les filles apprennent, s\'entraident et deviennent ambassadrices de la santé menstruelle dans leur établissement.',
            'image' => 'img/programme-1.jpg',
            'ancre' => 'club-rouge',
        ],
        [
            'titre' => 'Garantie Rouge',
            'texte' => 'Un filet de sécurité : kits, stocks d\'urgence et relais dans les écoles pour que personne ne se retrouve sans protection.',
            'image' => 'img/programme-2.jpg',
            'ancre' => 'garantie-rouge',
        ],
        [
            'titre' => 'Camp Rouge',
            'texte' => 'Des séjours intensifs d\'éducation, de leadership et de sororité pour des adolescentes venues d\'Abidjan et de l\'intérieur.',
            'image' => 'img/programme-3.jpg',
            'ancre' => 'camp-rouge',
        ],
        [
            'titre' => 'Mes Menstrues Libres',
            'texte' => 'Un parcours d\'information et d\'accompagnement pour vivre ses règles sans honte, sans douleur ignorée et sans interruption scolaire.',
            'image' => 'img/programme-4.jpg',
            'ancre' => 'mes-menstrues-libres',
        ],
        [
            'titre' => 'Je suis une fille, je peux aussi rêver',
            'texte' => 'Mentorat, ateliers d\'estime de soi et plaidoyer pour que les règles ne dictent plus les rêves ni les trajectoires des jeunes filles.',
            'image' => 'img/programme-5.jpg',
            'ancre' => 'je-peux-aussi-rever',
        ],
    ];
}

function fallback_faq(): array
{
    return [
        ['question' => 'Qu\'est-ce que la précarité menstruelle ?', 'reponse' => 'C\'est l\'impossibilité d\'accéder à des protections périodiques, à de l\'eau, à des sanitaires adaptés et à une information fiable, ce qui compromet la santé, la scolarité et la dignité.'],
        ['question' => 'Comment sont utilisés les dons ?', 'reponse' => 'Les dons financiers servent principalement à l\'achat de protections, à l\'organisation d\'ateliers et au suivi des bénéficiaires. Les dons matériels sont triés, conditionnés et distribués lors des actions de terrain.'],
        ['question' => 'Puis-je faire un don en nature ?', 'reponse' => 'Oui. Serviettes hygiéniques, culottes menstruelles, savon et sous-vêtements neufs sont les produits les plus utiles. Utilisez le formulaire de don matériel.'],
        ['question' => 'Comment devenir bénévole ?', 'reponse' => 'Rendez-vous sur la page Nous soutenir, remplissez le formulaire « Devenir bénévole » et notre équipe vous recontactera selon les besoins à Abidjan et à l\'intérieur.'],
        ['question' => 'Intervenez-vous hors d\'Abidjan ?', 'reponse' => 'Oui. Gouttes Rouges agit à Abidjan et dans plusieurs villes de l\'intérieur, selon les partenariats scolaires et associatifs.'],
        ['question' => 'Les contenus éducatifs sont-ils gratuits ?', 'reponse' => 'Oui. Guides, glossaire et supports pédagogiques sont accessibles depuis la page Ressources.'],
    ];
}

function fallback_glossaire(): array
{
    return [
        ['terme' => 'Cycle menstruel', 'definition' => 'Ensemble des transformations hormonales, généralement sur 21 à 35 jours, qui préparent l\'organisme à une éventuelle grossesse et se terminent par les règles si celle-ci n\'a pas lieu.'],
        ['terme' => 'Précarité menstruelle', 'definition' => 'Situation dans laquelle une personne ne peut pas gérer ses règles de façon sûre, hygiénique et digne, faute de moyens, d\'information ou d\'infrastructures.'],
        ['terme' => 'Kit menstruel', 'definition' => 'Ensemble de protections (serviettes, culottes, savon, sous-vêtements, notice) distribué aux bénéficiaires lors des actions de terrain.'],
        ['terme' => 'Dysménorrhée', 'definition' => 'Douleurs menstruelles parfois invalidantes. Elles ne sont pas une fatalité : elles méritent écoute et, si besoin, un avis de santé.'],
        ['terme' => 'Santé menstruelle', 'definition' => 'État de bien-être physique, psychique et social en lien avec le cycle, l\'hygiène, l\'information et l\'accès aux soins.'],
        ['terme' => 'Tabou menstruel', 'definition' => 'Ensemble de silences, mythes et interdits qui empêchent de parler des règles et isolent les filles et les femmes.'],
    ];
}

function fallback_supports(): array
{
    return [
        ['titre' => 'Livret « Mes premières règles »', 'type' => 'PDF', 'description' => 'Un support illustré pour les adolescentes et les familles.', 'fichier' => 'supports/livret-premieres-regles.pdf'],
        ['titre' => 'Affiche hygiène menstruelle', 'type' => 'Affiche', 'description' => 'À coller dans les écoles et les centres de santé.', 'fichier' => 'supports/affiche-hygiene.pdf'],
        ['titre' => 'Fiche atelier Club Rouge', 'type' => 'Fiche', 'description' => 'Trame d\'animation pour les relais scolaires.', 'fichier' => 'supports/fiche-atelier.pdf'],
    ];
}

function fallback_valeurs(): array
{
    return [
        ['titre' => 'Dignité', 'texte' => 'Chaque fille et chaque femme a le droit de vivre ses règles sans humiliation ni exclusion.'],
        ['titre' => 'Solidarité', 'texte' => 'Nous agissons avec les communautés, jamais à leur place, en tissant des relais durables.'],
        ['titre' => 'Éducation', 'texte' => 'L\'information claire et accessible est le premier levier contre le tabou et la précarité.'],
        ['titre' => 'Engagement', 'texte' => 'Nous tenons nos promesses de terrain : distribuer, former, documenter et rendre compte.'],
    ];
}
