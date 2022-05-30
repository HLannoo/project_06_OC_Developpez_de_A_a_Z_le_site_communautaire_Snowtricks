-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : lun. 30 mai 2022 à 17:55
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Grabs'),
(2, 'Rotations'),
(3, 'Flips'),
(4, 'Rotations désaxées'),
(5, 'Slides');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CB281BE2E` (`trick_id`),
  KEY `IDX_9474526CA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `trick_id`, `content`, `created_at`, `user_id`) VALUES
(3, 36, 'Cela à l\'air vraiment compliqué à faire, surtout à grande vitesse.', '2022-05-25 12:30:18', 70),
(4, 57, 'Toujours peur de tomber sur la barre, Ahah !', '2022-05-25 16:07:02', 70);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220407204939', '2022-04-07 20:49:51', 905),
('DoctrineMigrations\\Version20220411170407', '2022-04-11 17:04:19', 238),
('DoctrineMigrations\\Version20220411173720', '2022-04-11 17:42:36', 936),
('DoctrineMigrations\\Version20220411175749', '2022-04-11 17:58:00', 146),
('DoctrineMigrations\\Version20220414184426', '2022-04-14 18:44:48', 284),
('DoctrineMigrations\\Version20220415102625', '2022-04-15 10:26:30', 130),
('DoctrineMigrations\\Version20220419132820', '2022-04-19 13:28:25', 165),
('DoctrineMigrations\\Version20220419133103', '2022-04-19 13:31:10', 264),
('DoctrineMigrations\\Version20220421134345', '2022-04-21 13:43:51', 172),
('DoctrineMigrations\\Version20220425090033', '2022-04-25 09:00:41', 187),
('DoctrineMigrations\\Version20220425121053', '2022-04-25 12:12:48', 149),
('DoctrineMigrations\\Version20220426135954', '2022-04-26 14:00:02', 165),
('DoctrineMigrations\\Version20220428202216', '2022-04-28 20:22:27', 306),
('DoctrineMigrations\\Version20220503124049', '2022-05-03 12:40:56', 155),
('DoctrineMigrations\\Version20220503125850', '2022-05-03 12:58:56', 147),
('DoctrineMigrations\\Version20220503193727', '2022-05-03 19:37:32', 42),
('DoctrineMigrations\\Version20220505144802', '2022-05-05 14:48:05', 197),
('DoctrineMigrations\\Version20220506094431', '2022-05-06 09:44:37', 172),
('DoctrineMigrations\\Version20220507094801', '2022-05-07 09:48:04', 294),
('DoctrineMigrations\\Version20220507110638', '2022-05-07 11:06:43', 353),
('DoctrineMigrations\\Version20220511161113', '2022-05-11 16:11:20', 51),
('DoctrineMigrations\\Version20220511200005', '2022-05-11 20:00:10', 162),
('DoctrineMigrations\\Version20220511200737', '2022-05-11 20:07:41', 156),
('DoctrineMigrations\\Version20220518123554', '2022-05-18 12:35:58', 177),
('DoctrineMigrations\\Version20220526123654', '2022-05-26 12:37:00', 148);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `trick_id`, `path`) VALUES
(85, 36, '669771b26b633444894335697edd8471.jpg'),
(86, 36, 'f96b335bd5756fbc2064f4e7546bf6dd.jpg'),
(87, 36, '63e45e598cede8e96b5ed05b8b4f60a5.webp'),
(88, 37, '6d4dea46f4db30ee0485a998d7a4a7f6.bin'),
(89, 37, '45682c9e5f728e97cc2e230a596bfa84.jpg'),
(91, 38, '8a6c17e52947433dd7d103614a273666.jpg'),
(92, 38, 'ba2abd4d75078cad83ec4791767eb008.jpg'),
(93, 38, '2718f28cf23c48467322fc4bb2b55101.jpg'),
(94, 39, '770e314170815cca93025ae841a03129.jpg'),
(95, 39, '553fa1197b6bd11e3223562b757d1261.jpg'),
(96, 39, '745e73491940a54d10c66b20b784076d.jpg'),
(97, 40, '8b40ec6d29dd142251fcb04d1f021a8d.jpg'),
(98, 40, 'd8096cf6412fb77b6af382863020ba82.jpg'),
(99, 40, '88f5847eee9974ba04b91308d47a4c09.jpg'),
(100, 41, '75af19b9e343d4f9d539b5e74ea47a64.jpg'),
(101, 41, '2e66eb8fe638cb15bec2ddce5dd6c533.bin'),
(102, 42, '66b37bd823efa86d1f0ece914a50c3a1.jpg'),
(103, 42, 'e65d5842df359aea1cef238b72bb5c00.jpg'),
(104, 42, '2287b0dda96ff3f7e4b522f48e3c10e9.jpg'),
(105, 43, '810f4009caf9d78fd8df10790cbbf536.bin'),
(106, 43, '8f1864be3086266de1b5e561ead990c1.jpg'),
(108, 44, '08c16b5c12f62b603ee333a90ad0fe7a.jpg'),
(109, 45, '7c13a6e94b31ebd9ca5f820f051abc82.jpg'),
(110, 45, 'e7868f8adfafe57a1bc42a87d3cae2dc.jpg'),
(111, 46, 'ea8b7aefe22eab28c76c14f41d7b7db7.jpg'),
(112, 46, 'c94a95c8da79c1d7495eec8759341bc8.jpg'),
(113, 47, '33e0b5d01b08cff965e41c79fe31b5d0.jpg'),
(114, 47, '0b576b5dd70244bfd33d6c8e400247ff.jpg'),
(115, 48, '014403e9b9af40c6b47bd5c50eada544.jpg'),
(116, 48, 'd7f53dd0652a019d32a1cb4000809fa4.jpg'),
(117, 49, '5a4f5d8167b22e0e886f8052ba21960d.jpg'),
(118, 50, 'd25cf29d20cba4973e5c1f55436c7300.jpg'),
(119, 50, '47bc12b74e4f2e44133b9a86a8a81b87.jpg'),
(120, 51, '223137d606edbf002634561b6c296986.jpg'),
(121, 52, '2b667f68da0d50755365fd3dc690255f.webp'),
(122, 53, '16d869c70136d1a58fcffa0fb25a3b3c.jpg'),
(123, 53, '776c7c8b617a28d23dabd20102023929.jpg'),
(124, 54, 'f287b171491084e416140d0002d74f0d.jpg'),
(125, 55, 'faa87b376b293ae11f1640a3ec43dd77.jpg'),
(126, 55, '9715c22fbc45cf158d17324fba7d5ff0.jpg'),
(127, 56, '37aa73ecddb27199011d133705a324e7.jpg'),
(128, 57, 'f86c27ffa1bfd7ea31115315cabac400.jpg'),
(129, 57, '6b46b9db60f1ba26f668b003bb630d74.jpg'),
(130, 57, '4f65bd9b7abf0f406237fd0138582102.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
CREATE TABLE IF NOT EXISTS `reset_password_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(85) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D8F0A91E5E237E06` (`name`),
  KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  KEY `IDX_D8F0A91EA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `category_id`, `name`, `description`, `created_at`, `updated_at`, `slug`, `user_id`) VALUES
(36, 1, 'Mute', 'Un autre classique - tenez votre talon entre vos fixations en utilisant votre main arrière. Astuce : parce que c\'est un étirement pour atteindre derrière votre fixation arrière, poussez votre pied arrière en travers en même temps. C\'est aussi très stylé.', '2022-05-25 12:29:38', '2022-05-25 12:34:09', 'mute', 70),
(37, 1, 'Sad', 'Une plante triste ou un air triste était tout ce qui impliquait de saisir avec la main avant, le côté du talon, derrière le pied avant. Lorsque les skateurs de rue ont découvert comment faire un ollie à l\'air triste, ils l\'ont ingénieusement surnommé Melanchollie ou Sad (mélancolie = triste, donc ollie à l\'air triste, CQFD), ainsi toute prise arrière est devenue une version abrégée de Melanchollie -> Melon', '2022-05-25 12:50:53', NULL, 'sad', 70),
(38, 1, 'Indy', 'L\'Indy est une simple prise en utilisant votre main arrière pour saisir le bord des orteils entre vos pieds. Vous finirez généralement par saisir un peu plus près de votre pied gauche. C\'est tout bon. Faites juste attention cependant, car si vous attrapez votre bord d\'orteil derrière votre fixation arrière, c\'est connu sous le nom de Tindy qui peut (et sera) mal vu ! C\'est une prise facile et amusante et l\'une des meilleures à prendre des airs droits en 360 et des rotations plus importantes plus tard. C\'est amusant hors des falaises, des hanches et dans le tuyau, et c\'est aussi génial avec des retournements de miller. Considérez-le comme une base pour tous vos futurs freestyles. Vous devriez être à l\'aise pour faire des ollies et faire de petits sauts avant de commencer.', '2022-05-25 12:58:50', '2022-05-25 13:00:19', 'Indy', 70),
(39, 1, 'Stalefish', 'Un stalefish, c\'est quand vous attrapez l\'arrière de votre planche avec votre main arrière juste devant votre pied arrière. Cela se fait le plus souvent en frontside, mais cela peut se faire de n\'importe quelle manière. Comme beaucoup d\'autres tours, Tony Hawk a inventé le stalefish en 1985. Cependant, ce sont les Gonz qui lui ont donné du style et l\'ont rendu populaire.\r\n\r\nMaintenant que vous savez ce qu\'est un stalefish et d\'où il vient, vous êtes prêt à en faire un. Je suppose que vous pouvez déjà faire des ollies frontside et, espérons-le, des airs frontside. Sinon, vous voudrez peut-être travailler sur ceux-ci en premier, ou simplement le punk.', '2022-05-25 13:05:24', '2022-05-25 13:14:37', 'Stalefish', 70),
(40, 1, 'Tail Grab', 'Un Tail Grab est l\'endroit où votre main arrière attrape la pointe arrière (queue) de votre planche . Ramenez votre jambe arrière et tendez la main vers l\'arrière pour saisir la planche. Étendez votre jambe avant pour vous aider à atteindre la prise.', '2022-05-25 13:21:48', NULL, 'tail-grab', 70),
(41, 1, 'Nose grab', 'Un Nose Grab est l\'endroit où votre main arrière attrape la pointe avant (tête) de votre planche . Ramenez votre jambe arrière et tendez la main vers l\'avant pour saisir la planche. Étendez votre jambe arrière pour vous aider à atteindre la prise.', '2022-05-25 13:43:51', NULL, 'nose-grab', 70),
(42, 1, 'Japan Air', 'Selon Tony Hawk, « Il y avait un article de TWS avec un reportage sur le Japon vers 1984. La première diffusion était une énorme photo d\'un Japonais faisant un air muet modifié avec le titre JAPAN au-dessus. Nous n\'avions jamais vu un air comme ça et avons immédiatement commencé à l\'appeler par ce nom parce que la mise en page du magazine le nommait presque par défaut. Quelqu\'un devrait trouver ce problème.\r\n\r\nEh bien, après avoir feuilleté suffisamment de pages d\'anciens problèmes de TransWorld SKATEboarding pour avoir les pouces à vif, nous l\'avons trouvé. La mémoire peut être une chose glissante, et il s\'avère que l\'astuce est apparue dans le numéro de février 1985, et la photo est le petit encart, pas une double page. Sinon, le souvenir des Hawks est parfait, et le réglage unique des patineurs japonais inconnus sur une prise muette conventionnelle a jeté les bases de ce qui sera à jamais appelé le Japon. Inspiré, Hawk a commencé à reproduire ce mouvement, et sa silhouette dégingandée a accentué ce réglage comme personne d\'autre ne le pouvait. Peu de temps après, deux clichés de Hawk ont ​​été diffusés dans le TWSKATE d\'août 1985, immortalisant à jamais la prise et le nom.', '2022-05-25 14:16:49', NULL, 'japan-air', 70),
(43, 1, 'Seat Belt', 'Mettez votre corps vers l\'avant (comme si vous mettiez une ceinture de sécurité) et reliez votre main arrière au nez de la planche . Cela aide si vous pliez votre genou avant et étendez votre jambe arrière droite; cela rapprochera le nez de votre planche de votre corps et affinera vraiment la prise.', '2022-05-25 14:39:56', '2022-05-25 14:41:41', 'seat-belt', 70),
(44, 1, 'Truck Driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)', '2022-05-25 14:45:04', NULL, 'truck-driver', 70),
(45, 2, '180°', 'Un 180 consiste essentiellement à faire tourner votre snowboard, dans les airs, à 180 degrés. Vous commencerez par faire face à une direction vers le bas de la montagne et finirez par faire face à l\'autre.\r\n\r\nAvant d\'apprendre à faire un 180, vous devez déjà être à l\'aise avec les ollies et le riding switch.\r\n\r\nVous devrez être capable de décoller pour effectuer ce tour (vous devez donc être capable de faire un ollie)\r\nVous serez soit en train de vous installer, soit d\'atterrir en switch (vous devez donc pouvoir rouler en switch relativement confortablement)', '2022-05-25 14:47:00', '2022-05-25 14:49:45', '1800', 70),
(46, 2, '360°', 'Si vous aimez le snowboard, vous voudrez probablement apprendre quelques trucs et sauts ! Un frontside 360, c\'est quand vous quittez la pente et tournez dans les airs à 360 degrés avant de toucher à nouveau le sol.', '2022-05-25 14:49:33', NULL, '3600', 70),
(47, 2, '540°', 'L’impulsion se fait à 2 pieds au bout du kicker. Ne pas pousser trop fort aux premiers essais au risque d’être déséquilibré. Donc impulsion à 2 pieds en lançant la rotation avec les épaules comme un 3.6 front mais il faut les lancer plus vite et donc plus fort. La vitesse à laquelle il faut lancer les épaule pour lancer la rotation dépend de la taille du saut évidement... Au début il faut commencer par des petits sauts de bord de piste en lançant fort les épaules. \r\nPour un 5.4 front on peut avoir une impulsion bien à plat, en appui léger sur les talons ou en appui pointe de pied suivant le style qu\'on veut donner à son tricks et surtout suivant comme on se sent à l’aise. Mais surtout il faut déraper le moins possible sur le kicker pour ne pas perdre d’élan, en particulier sur une table de park.', '2022-05-25 14:51:27', NULL, '5400', 70),
(48, 2, '720°', 'Manœuvre aérienne au cours de laquelle le surfeur effectue une rotation de 720 degrés — deux pirouettes complètes .', '2022-05-25 14:52:29', NULL, '7200', 70),
(49, 2, '900°', 'Le surfeur effectue une rotation de 900° dans les airs et atterrit en switch . Dans la demi-lune, le coureur s\'approche du mur en roulant vers l\'avant, effectue une rotation de 900° et atterrit en roulant vers l\'avant.', '2022-05-25 14:53:40', NULL, '9000', 70),
(50, 2, '1080°', 'Un saut frontside 1080, ou F1080, signifie que le snowboardeur fait tourner son corps, de sorte que son \"avant\" soit face à la montagne (ou dans ce cas le halfpipe).', '2022-05-25 14:57:22', NULL, '10800', 70),
(51, 3, 'Front Flip', 'Bras avant levé, poids sur la jambe arrière tout en gardant le nez sur la neige. 2. Lorsque vous lancez le nollie, jetez avec votre bras avant pour commencer la rotation. Gardez vos épaules sur le côté et alignées avec votre nez et votre queue. Le nez de votre planche se pliera et vous poussera vers l\'avant dans un mouvement de retournement.', '2022-05-25 15:02:31', NULL, 'front-flip', 70),
(52, 3, 'Back Flip', 'Pliez vos genoux. Au fur et à mesure que vous montez au décollage, étendez vos genoux et pop tout en permettant à votre poitrine de se soulever et vous vous jetez en arrière . Ne vous concentrez pas trop sur le retournement et retournez trop tôt. J\'ai vu des gens se cogner la tête au décollage parce qu\'ils se sont retournés trop tôt.', '2022-05-25 15:03:17', NULL, 'back-flip', 70),
(53, 4, 'Corkscrew', 'Une rotation hors axe . Si un coureur se retourne deux fois, le tour devient un double cork. Un troisième en fait un triple cork.', '2022-05-25 15:05:32', NULL, 'corkscrew', 70),
(54, 4, 'Rodeo', 'Rodeo= flip+spin (généralement back roll+180), tout simplement !', '2022-05-25 15:08:08', '2022-05-25 15:08:53', 'rodeo', 70),
(55, 4, 'Misty', 'Le Misty Flip est une rotation backside 540 hors axe pratiquée dans les sports de style libre tels que le freeski, le snowboard, le skateboard, le patin à roues alignées ou le trampoline. Le Misty Flip a été réalisé pour la première fois par Jason King à partir du half-pipe de Sugarbush vers 1991.', '2022-05-25 15:08:43', NULL, 'misty', 70),
(56, 5, 'Tail Slide', 'Il s\'agit d\'un slide effectué sur le tail de la planche, tout en gardant le nose du sol . Le tail slide est un excellent moyen de développer votre équilibre, votre contrôle de planche et rendra d\'autres tricks beaucoup plus accessibles. Il s\'agit d\'un slide effectué sur le tail de la planche, tout en gardant le nose du sol.', '2022-05-25 15:11:11', NULL, 'tail-slide', 70),
(57, 1, 'Nose Slide', 'Qu\'est-ce qu\'un Nose ou Tail Slide ? Pour les Nose & Tail Slides, sautez sur une box ou un rail comme vous le feriez pour un boardslide, mais centrez-vous soit sur le nose, soit sur le tail de votre planche .', '2022-05-25 15:11:41', '2022-05-29 14:02:10', 'Nose-Slide', 70);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `pseudo`, `email`, `password`, `roles`, `image`, `is_verified`, `token`) VALUES
(70, 'Kayoken', 'hedilannoo@gmail.com', '$2y$13$Lh3U2eAhaDqWSbKtrxICXeVI83fLWW0P3W.gK1lBuhgmaz5S49wVO', '[\"ROLE_USER\"]', '15e71bbff01a9ae70d4fce4d1c56d11b.jpg', 1, 'TiY4uEKzT2i/taKJPAkTKk47MI2Dkkji8n2/etq9ppk='),
(71, 'Azenor', 'hedilannoo+1@gmail.com', '$2y$13$783e2u8Xr0ETacgu9c7jKOeS/BhrSWr937PUkQfEv63rrKrzIUcem', '[\"ROLE_USER\"]', 'ce028666473ef912674c7f253bdaab60.jpg', 1, 'vppybF5xLQIjB/TLc7Mgi9x5S5ydPPCoL0OLkpnT2sc=');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(4, 36, 'https://www.youtube.com/embed/jm19nEvmZgM'),
(5, 36, 'https://www.youtube.com/embed/yyN1gQqsMwM'),
(6, 37, 'https://www.youtube.com/embed/KEdFwJ4SWq4'),
(7, 38, 'https://www.youtube.com/embed/6yA3XqjTh_w'),
(8, 38, 'https://www.youtube.com/embed/FracN6hoD7c'),
(9, 39, 'https://www.youtube.com/embed/f9FjhCt_w2U'),
(10, 39, 'https://www.youtube.com/embed/dG3zpAFm2fo'),
(11, 39, 'https://www.youtube.com/embed/__2s5nUdUWI'),
(12, 40, 'https://www.youtube.com/embed/id8VKl9RVQw'),
(13, 41, 'https://www.youtube.com/embed/M-W7Pmo-YMY'),
(14, 42, 'https://www.youtube.com/embed/jH76540wSqU'),
(15, 43, 'https://www.youtube.com/embed/4vGEOYNGi_c'),
(16, 43, 'https://www.youtube.com/embed/eTx2uVcbLzM');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `reset_password_request`
--
ALTER TABLE `reset_password_request`
  ADD CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
