-- =============================================================================
-- Donnees de demonstration Revieweo
-- A executer APRES database/schema.sql (base revieweo creee, tables presentes).
--
-- Comptes de test (meme mot de passe pour tous) :
--   user@revieweo.test      -> role user
--   critique@revieweo.test  -> role critique
--   admin@revieweo.test     -> role admin
-- Mot de passe : revieweo123
--
-- Si vous reimportez le seed sur une base deja remplie, videz d'abord les tables
-- dependantes ou supprimez les lignes conflictuelles (emails uniques).
-- =============================================================================

USE revieweo;

-- Hash bcrypt PHP (password_hash('revieweo123', PASSWORD_DEFAULT)) — compatible AuthController
SET @pwd := '$2y$10$ttYtgZDrnJ4VaxmKwXzsdOQcxuKpyBj6CcJNpJ0fsAeIITUi1O3Ry';

-- Utilisateurs fixes id 1..3 pour referencer critiques et likes sans ambiguite
-- INSERT IGNORE : ne remplace pas une ligne deja presente (id ou email deja pris)
INSERT IGNORE INTO users (id, username, email, password, role) VALUES
    (1, 'demo_user', 'user@revieweo.test', @pwd, 'user'),
    (2, 'demo_critique', 'critique@revieweo.test', @pwd, 'critique'),
    (3, 'demo_admin', 'admin@revieweo.test', @pwd, 'admin');

-- Categories : deja inserees par schema.sql (ids 1-6). On ne les duplique pas ici.

-- Critiques de demo (ids 1..3). Auteurs : critique (2) et admin (3).
INSERT IGNORE INTO reviews (id, title, content, rating, is_pinned, user_id) VALUES
    (1,
     'Inception',
     'Un thriller de science-fiction ambitieux qui joue sur les niveaux de reve. La mise en scene est dense, la bande-son marquante, et la fin laisse place a l interpretation. Quelques longueurs au milieu, mais l ensemble reste memorisable.',
     9,
     1,
     2),
    (2,
     'Le Grand Bleu',
     'Visuellement magnifique et hypnotique. Le rythme est lent mais assume. Pour les amateurs de cinema poetique plutot que d action pure.',
     7,
     0,
     2),
    (3,
     'Dune (2021)',
     'Adaptation soignee avec une photographie impressionnante. L univers est credibe et les enjeux politiques bien poses. A voir sur grand ecran si possible.',
     8,
     0,
     3);

-- Liaisons critique <-> categorie (ids categories = ordre dans schema.sql)
-- 1 Inception : Action + Science-fiction
INSERT IGNORE INTO review_category (review_id, category_id) VALUES
    (1, 1),
    (1, 3);

-- 2 Le Grand Bleu : Drame
INSERT IGNORE INTO review_category (review_id, category_id) VALUES
    (2, 4);

-- 3 Dune : Science-fiction + Thriller
INSERT IGNORE INTO review_category (review_id, category_id) VALUES
    (3, 3),
    (3, 5);

-- Likes : demo_user (1) like les deux premieres ; demo_critique (2) like Dune
INSERT IGNORE INTO likes (user_id, review_id) VALUES
    (1, 1),
    (1, 2),
    (2, 3);

-- Synchroniser les AUTO_INCREMENT si des ids explicites ont ete utilises
ALTER TABLE users AUTO_INCREMENT = 10;
ALTER TABLE reviews AUTO_INCREMENT = 10;