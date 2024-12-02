-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: proxysql-01.dd.scip.local
-- Tiempo de generación: 02-12-2024 a las 16:36:21
-- Versión del servidor: 10.10.2-MariaDB-1:10.10.2+maria~deb11
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ddb237128`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `titol` varchar(255) NOT NULL,
  `cos` text NOT NULL,
  `creat` timestamp NOT NULL DEFAULT current_timestamp(),
  `modificat` timestamp NULL DEFAULT NULL,
  `autor` int(11) NOT NULL,
  `ruta_imatge` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `titol`, `cos`, `creat`, `modificat`, `autor`, `ruta_imatge`) VALUES
(18, 'Els gats siamesosos: característiques i cures.', 'Els gats siamesos són coneguts per la seva bellesa i elegància. Són intel·ligents i molt socials. Descobreix com tenir cura d&#039;un gat siamès a casa i quines atencions especials necessita per estar feliç i saludable. Els siamesos són molt actius i curiosos, així que necessiten estimulació constant.', '2024-10-19 16:55:41', '2024-11-19 16:53:48', 12, '/uploads/gato-siames.jpg'),
(19, 'Beneficis de tenir un gat a casap', 'Els gats poden ser grans companys. A més, ajuden a reduir l&#039;estrès i l&#039;ansietat. També són animals molt nets i independents, ideals per a persones amb rutines atapeïdes. Descobreix per què tenir un gat pot millorar la teva vida', '2024-10-19 16:57:52', '2024-10-19 22:42:48', 12, '/uploads/chen-urucob5xlya-unsplash.jpg'),
(20, 'Tot sobre el Maine Coon, el gegant dels gats', 'El Maine Coon és una de les races més grans de gats domèstics. Amb el seu pelatge dens i la seva mida impressionant, aquest gat es converteix ràpidament en el centre de totes les mirades. A més, tenen una personalitat dolça i amigable, que els fa ideals per a famílies. Són gats molt juganers, i, malgrat la seva mida, s&#039;adapten bé a espais petits sempre que tinguin companyia.', '2024-10-19 17:03:51', '2024-10-21 14:37:29', 12, '/uploads/maine-coon-2.jpg'),
(21, 'Com ensenyar al teu gat a fer servir l&#039;arenal', 'Ensenyar al teu gat a utilitzar l&#039;arenal pot ser més fàcil del que sembla. Segueix aquests consells per ajudar al teu gat a aprendre ràpidament i a evitar problemes de comportament. És important triar un lloc tranquil i accessible per a l&#039;arenal, així com mantenir-lo net.', '2024-10-19 17:04:54', '2024-10-19 22:42:54', 12, '/uploads/hacer-que-el-gato-use-la-aja-de-arena-655x368.jpg'),
(22, 'Aliments perillosos per als gats', 'Hi ha certs aliments que poden ser perillosos per als gats, com la xocolata, la ceba i l&#039;all. Aquests aliments poden causar greus problemes de salut, incloent problemes digestius i fins i tot toxicitat. Descobreix quins aliments has d&#039;evitar per mantenir el teu gat sa i feliç. A més, ofereix-li una dieta equilibrada amb pinso específic per a gats.', '2024-10-19 17:05:31', '2024-10-19 22:42:57', 12, '/uploads/como-cambiar-la-comida-a-un-gato.png'),
(24, '10 curiositats sobre els gats que no coneixies', 'Els gats tenen comportaments i característiques úniques. Sabies que poden dormir fins a 16 hores al dia o que són capaços de reconèixer la veu del seu amo? Et contem 10 fets curiosos que et sorprendran i faran que coneguis millor al teu amic felí. A més, coneixeràs alguns mites sobre els gats que han circulat durant anys.', '2024-10-19 17:06:43', '2024-10-19 22:43:06', 12, '/uploads/images.jpg'),
(25, 'La història del gat persa', 'El gat persa és una de les races més antigues i populars del món. Coneix la seva història, des dels seus orígens a l&#039;antiga Pèrsia fins a convertir-se en un dels gats més apreciats en les llars de tot el món. El seu pelatge llarg i suau necessita molta cura, però la seva personalitat tranquil·la fa que valgui la pena.', '2024-10-19 17:07:19', '2024-10-19 22:43:12', 12, '/uploads/sitesdefaultfilesstylessquare_medium_440x440public2022-06Persian20Long20Hair.2.jpg'),
(26, 'Joguines casolanes per entretenir el teu gat', 'No cal gastar molts diners en joguines per al teu gat. Aquí et mostrem com fer algunes joguines amb materials que tens a casa, com cordes, caixes de cartró i pilotes de paper. Amb una mica de creativitat, podràs mantenir el teu gat actiu i divertit durant hores.', '2024-10-19 17:07:55', '2024-10-19 22:43:19', 12, '/uploads/Gato-jugando-con-su-peluche-319662.jpg'),
(27, 'La importància de l&#039;esterilització en els gats', 'Esterilitzar el teu gat pot evitar problemes de salut i comportament. A més, ajuda a controlar la superpoblació de gats i evita que es quedin gats sense llar. Descobreix per què és tan important per a ells i per a tu. La decisió d&#039;esterilitzar un gat és una de les més responsables que un propietari pot prendre.', '2024-10-19 17:08:23', '2024-10-19 22:43:24', 12, '/uploads/Esterilizar-gatos-1200x675.jpg'),
(28, 'Com presentar un nou gat a casa', 'Introduir un nou gat a la llar pot ser tot un repte, especialment si ja en tens un altre. Aquí tens alguns consells per assegurar una convivència harmònica i evitar problemes territorials. És important fer-ho de manera gradual i permetre que cada gat tingui el seu propi espai.', '2024-10-19 17:08:49', '2024-10-19 22:43:28', 12, '/uploads/gato-pequeno.jpg'),
(29, 'Els millors noms per a gats', 'Si acabes d&#039;adoptar un gat i no saps quin nom posar-li, aquí tens una llista d&#039;idees originals i divertides. Tria un nom que reflecteixi la personalitat del teu felí i que sigui fàcil de recordar. A més, et donem consells sobre com ensenyar-li el seu nou nom.', '2024-10-19 17:09:38', '2024-10-19 22:43:32', 12, '/uploads/7e71ccb1-ceac-4e9b-8f74-6010cefb6ec9_16-9-discover-aspect-ratio_default_0.jpg'),
(30, 'Cures per a gats de pèl llarg', 'Els gats de pèl llarg necessiten cures especials, com raspallats freqüents per evitar nusos i problemes de pell. També és important vigilar la seva alimentació i oferir-los una dieta rica en nutrients per mantenir el seu pelatge sa.', '2024-10-19 17:10:32', '2024-10-19 22:43:37', 12, '/uploads/Gatos de pelo largo_1_0.jpg'),
(31, 'El llenguatge dels gats: com entendre el teu felí', 'Els gats es comuniquen de moltes maneres, des de miols fins a postures corporals. Aprèn a entendre el que et diu el teu gat i millora la teva relació amb ell. Saber interpretar els senyals de tranquil·litat o d&#039;estrès és clau per a una bona convivència.', '2024-10-19 17:11:14', '2024-10-19 22:43:41', 12, '/uploads/Vinculo-con-tu-gato-bienestar-y-comportamiento-felino-scaled.jpg'),
(32, 'Els gats i la seva fascinació per les caixes', 'Si hi ha una cosa que als gats els encanta, són les caixes. Però, per què? Aquí explorem les raons darrere d&#039;aquest comportament i com pots aprofitar les caixes per entretenir el teu gat de manera segura.', '2024-10-19 17:11:51', '2024-10-19 22:43:47', 12, '/uploads/135703265_s.jpg'),
(33, 'Cures bàsiques per a un gatet acabat de néixer', 'Cuidar d&#039;un gatet acabat de néixer requereix molta atenció i dedicació. Descobreix com fer-ho de la millor manera, des de l&#039;alimentació fins a les primeres visites al veterinari. Els primers mesos de vida són crucials per al seu desenvolupament.', '2024-10-19 17:12:21', '2024-10-19 22:44:04', 12, '/uploads/cuidar-gato-recien-nacido.jpg'),
(34, 'Com tallar les ungles al teu gat de manera segura', 'Tallar les ungles del teu gat pot ser tot un repte, però amb aquests consells podràs fer-ho de forma segura i sense estrès. Recorda usar eines adequades i fer-ho en un moment en què el teu gat estigui relaxat.', '2024-10-19 17:12:50', '2024-10-19 22:44:10', 12, '/uploads/gatoscortarunas-77.jpg'),
(35, 'La millor alimentació per a un gat adult', 'L&#039;alimentació d&#039;un gat adult és fonamental per a la seva salut. Coneix quin tipus de menjar és el més adequat per a ells i com adaptar la seva dieta segons les seves necessitats.', '2024-10-19 17:14:04', '2024-11-29 16:53:52', 12, '/uploads/que-cantidad-de-alimento-debe-comer-un-gato.png'),
(36, 'Michi musica', 'Alguns estudis han demostrat que certs tipus de música poden relaxar els gats. Descobreix quins sons són els més recomanats per a ells i com pots usar la música per crear un ambient tranquil a casa.', '2024-10-19 17:14:52', '2024-11-27 19:13:30', 12, '/uploads/katze-musik-hoerer.jpg'),
(37, 'Els gats més famosos de la història. Part 1', 'Des de l&#039;antiguitat fins a la cultura popular actual, els gats han deixat una gran empremta. Coneix alguns dels gats més famosos de la història, com el gat de la reina Victòria o els gats que han viatjat a l&#039;espai.', '2024-10-19 17:15:17', '2024-11-20 14:53:15', 12, '/uploads/image_content_29204452_20170808125145.jpg'),
(48, 'Que es un gat &quot;jipi&quot; ?', 'Doncs un gat &quot;jipi&quot; es un gat que escolta Bob Marley.', '2024-11-09 16:23:35', NULL, 24, '/uploads/gato jipi.webp'),
(49, 'xxxxxxxxxxx', 'xxxxxxxxxxxxxxxxx', '2024-11-12 11:00:26', NULL, 35, '/uploads/tiger.jpg'),
(50, 'sssss', 'ssasASASASSASasdfczdvszdfvzdfsdf askldbalskjdlaksjvdakvsd\r\nasd\r\na\r\nsd\r\nas\r\nda\r\nsd\r\nasdañlsdjakslhfdlsafdksagfsgdfkñsgfklhgsfzñksagckz&lt;vxkclhf&lt;axgadfxhjcd&lt;hxzgck&lt;gzxc&lt;gcxzk&lt;jzcxk&lt;jzgcx&lt;khzgxc', '2024-11-15 09:57:50', '2024-11-29 10:27:45', 38, '/uploads/nicht-gut-gefaucht-kaetzchen.jpg'),
(51, 'prova1', 'sjkadhkasdgakdg asdasdasd', '2024-11-15 10:00:18', NULL, 38, '/uploads/jaguar.jpg'),
(52, 'pepe', 'el ave volaz', '2024-11-18 15:02:00', NULL, 40, '/uploads/as.jpg'),
(53, 'Batalla epica', 'batalla epica de mi amigo y compa @DonBigotes contra el gran @CajaDeArena', '2024-11-18 15:03:38', NULL, 40, '/uploads/ara.jpg'),
(54, 'Pelea aun mas Epika', 'Pelea mucho mas epica que la anterior', '2024-11-18 15:31:12', NULL, 40, '/uploads/ca.jpg'),
(56, 'Oni&#039;s Cat', 'Meooooowwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww', '2024-11-22 18:06:02', NULL, 56, '/uploads/onicat.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuaris`
--

CREATE TABLE `usuaris` (
  `id` int(11) NOT NULL,
  `alies` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom_complet` varchar(100) DEFAULT NULL,
  `token_remember_me` varchar(255) DEFAULT NULL,
  `token_recuperacio` varchar(255) DEFAULT NULL,
  `expiracio_token` timestamp NULL DEFAULT NULL,
  `ruta_imatge` varchar(255) DEFAULT NULL,
  `es_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `alies`, `email`, `password`, `nom_complet`, `token_remember_me`, `token_recuperacio`, `expiracio_token`, `ruta_imatge`, `es_admin`) VALUES
(12, 'admin', 'admin@oni.cat', '$2y$10$j6Dy2PMvfy.6WWys7P9TLOO.Z.mKgmlK8DL9zHzVfnHY27dSDDJn2', 'Santi Onieva', '1a55fc56374619c54d4786932eafe8ba2ae826fdbd264653171f046d01338edc', NULL, NULL, 'uploads/profiles/admin.png', 1),
(23, 'irene', 'irenelupianez04@gmail.com', '$2y$10$sC185po9NBLQoNX0nRM1qu/LEiMOyzxIWWkrw8Tldt7xRSeBwm4.G', NULL, NULL, NULL, NULL, NULL, 0),
(24, 'alax', 'Lupianezalex@gmail.com', '$2y$10$.0tmpxlxqPKfQGHsdE8a/.9vnDRBGAnKyuLeVMZLGwqUhgcVd4YnK', NULL, NULL, NULL, NULL, 'uploads/profiles/alax.jpg', 0),
(27, 'Chris', 'c.torres2@sapalomera.cat', '$2y$10$5BYL06GQyHtl6R3Jjo3/HOG2umSWicGBnD4ky8ym4w/Qd7q2EZvtO', NULL, NULL, NULL, NULL, NULL, 0),
(35, 'xavi', 'xavi@xavi.cat', '$2y$10$XCV/oWc/UNzNO70MdY6cZe4a1oAdZxKnFeBB78OXcH1sAIuDmU3dy', NULL, NULL, NULL, NULL, NULL, 0),
(37, 'ADM1N', 'a.gomez9@sapalomera.cat', '$2y$10$ItNyx91r6vb95q6HUTjaHuQ25lUxHywAfpn9KlqliycF1A.thJkrG', 'Alvaro', NULL, NULL, NULL, 'uploads/profiles/ADM1N.png', 0),
(38, 'xmm', 'backendisthedarkside@gmail.com', '$2y$10$Fh48jV./kxjMZwNIkN8zNu9Fze7gwaVldvCVt83seufaZYlD93DzG', NULL, NULL, NULL, NULL, NULL, 1),
(40, 'Santiagiño', 'santi@nonieva.cat', '$2y$10$QbAudOaqY8T0oXL2YIYTROD8eNbnVj5BEOOm0XxNLq3AnQ2Y.9tS6', 'Santiagiño', NULL, NULL, NULL, NULL, 0),
(46, 'Serpent-Diplomàtic-342', 'No proporcionat', 'SocialAuth', NULL, NULL, NULL, NULL, 'https://www.redditstatic.com/avatars/defaults/v2/avatar_default_2.png', 0),
(47, 'Cocodril-Malalt-574', 'markalvarezcaballero@gmail.com', 'SocialAuth', 'Mark Alvarez Caballero', NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a/ACg8ocL70NZV5tJ_0lBm_gX-xOCQZZNgU5S87D5oXNro-Dz3mKAzbA=s96-c', 0),
(55, 'Elefant-Ingratit-948', 'psanchez@sapalomera.cat', 'SocialAuth', 'Pere Sanchez', NULL, NULL, NULL, '/uploads/profiles/Elefant-Ingratit-948.png', 0),
(56, 'oniii', 'onicat@gmail.com', '$2y$10$MwI4N28ZNOJw0LkhCyYCxufs3mJtqZi0vIKAnpWiG4.gAGYJ86aHK', NULL, NULL, NULL, NULL, 'uploads/profiles/oniii.jpg', 0),
(58, 'Juliarore', 'juliarore6@gmail.com', '$2y$10$XGfyFO4MaWJMYbLhfNtefeCM.U5b5i015UThjdHz1Ss7.aBipLdUC', NULL, NULL, NULL, NULL, NULL, 0),
(59, 'Sepieta-Solitari-654', 'santionieva@gmail.com', 'SocialAuth', 'Santi Onieva', NULL, NULL, NULL, '/uploads/profiles/Sepieta-Solitari-654.jpg', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autor` (`autor`);

--
-- Indices de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alies` (`alies`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_autor` FOREIGN KEY (`autor`) REFERENCES `usuaris` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
