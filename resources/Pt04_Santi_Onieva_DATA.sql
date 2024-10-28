-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 28-10-2024 a las 15:40:32
-- Versión del servidor: 8.4.2
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Pt04_Santi_Onieva`
--

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `titol`, `cos`, `creat`, `modificat`, `autor`, `ruta_imatge`) VALUES
(18, 'Els gats siamesos: característiques i cures.', 'Els gats siamesos són coneguts per la seva bellesa i elegància. Són intel·ligents i molt socials. Descobreix com tenir cura d&#039;un gat siamès a casa i quines atencions especials necessita per estar feliç i saludable. Els siamesos són molt actius i curiosos, així que necessiten estimulació constant.', '2024-10-19 16:55:41', '2024-10-20 18:34:56', 12, '/uploads/gato-siames.jpg'),
(19, 'Beneficis de tenir un gat a casap', 'Els gats poden ser grans companys. A més, ajuden a reduir l&#039;estrès i l&#039;ansietat. També són animals molt nets i independents, ideals per a persones amb rutines atapeïdes. Descobreix per què tenir un gat pot millorar la teva vida', '2024-10-19 16:57:52', '2024-10-19 22:42:48', 12, '/uploads/chen-urucob5xlya-unsplash.jpg'),
(20, 'Tot sobre el Maine Coon, el gegant dels gats', 'El Maine Coon és una de les races més grans de gats domèstics. Amb el seu pelatge dens i la seva mida impressionant, aquest gat es converteix ràpidament en el centre de totes les mirades. A més, tenen una personalitat dolça i amigable, que els fa ideals per a famílies. Són gats molt juganers, i, malgrat la seva mida, s&#039;adapten bé a espais petits sempre que tinguin companyia.', '2024-10-19 17:03:51', '2024-10-21 14:37:29', 12, '/uploads/maine-coon-2.jpg'),
(21, 'Com ensenyar al teu gat a fer servir l&#039;arenal', 'Ensenyar al teu gat a utilitzar l&#039;arenal pot ser més fàcil del que sembla. Segueix aquests consells per ajudar al teu gat a aprendre ràpidament i a evitar problemes de comportament. És important triar un lloc tranquil i accessible per a l&#039;arenal, així com mantenir-lo net.', '2024-10-19 17:04:54', '2024-10-19 22:42:54', 12, '/uploads/hacer-que-el-gato-use-la-aja-de-arena-655x368.jpg'),
(22, 'Aliments perillosos per als gats', 'Hi ha certs aliments que poden ser perillosos per als gats, com la xocolata, la ceba i l&#039;all. Aquests aliments poden causar greus problemes de salut, incloent problemes digestius i fins i tot toxicitat. Descobreix quins aliments has d&#039;evitar per mantenir el teu gat sa i feliç. A més, ofereix-li una dieta equilibrada amb pinso específic per a gats.', '2024-10-19 17:05:31', '2024-10-19 22:42:57', 12, '/uploads/como-cambiar-la-comida-a-un-gato.png'),
(23, 'Per què els gats amassen?', 'L&#039;amassat és un comportament típic dels gats que es remunta a la seva etapa de cadells. Tot i que pot semblar curiós, té diverses explicacions, com la cerca de confort o un record dels moments en què mamaven de la mare. A més, els gats poden amassar per mostrar afecte als seus propietaris.', '2024-10-19 17:06:07', '2024-10-19 22:43:00', 12, '/uploads/GATO.jpg'),
(24, '10 curiositats sobre els gats que no coneixies', 'Els gats tenen comportaments i característiques úniques. Sabies que poden dormir fins a 16 hores al dia o que són capaços de reconèixer la veu del seu amo? Et contem 10 fets curiosos que et sorprendran i faran que coneguis millor al teu amic felí. A més, coneixeràs alguns mites sobre els gats que han circulat durant anys.', '2024-10-19 17:06:43', '2024-10-19 22:43:06', 12, '/uploads/images.jpg'),
(25, 'La història del gat persa', 'El gat persa és una de les races més antigues i populars del món. Coneix la seva història, des dels seus orígens a l&#039;antiga Pèrsia fins a convertir-se en un dels gats més apreciats en les llars de tot el món. El seu pelatge llarg i suau necessita molta cura, però la seva personalitat tranquil·la fa que valgui la pena.', '2024-10-19 17:07:19', '2024-10-19 22:43:12', 12, '/uploads/sitesdefaultfilesstylessquare_medium_440x440public2022-06Persian20Long20Hair.2.jpg'),
(26, 'Joguines casolanes per entretenir el teu gat', 'No cal gastar molts diners en joguines per al teu gat. Aquí et mostrem com fer algunes joguines amb materials que tens a casa, com cordes, caixes de cartró i pilotes de paper. Amb una mica de creativitat, podràs mantenir el teu gat actiu i divertit durant hores.', '2024-10-19 17:07:55', '2024-10-19 22:43:19', 12, '/uploads/Gato-jugando-con-su-peluche-319662.jpg'),
(27, 'La importància de l&#039;esterilització en els gats', 'Esterilitzar el teu gat pot evitar problemes de salut i comportament. A més, ajuda a controlar la superpoblació de gats i evita que es quedin gats sense llar. Descobreix per què és tan important per a ells i per a tu. La decisió d&#039;esterilitzar un gat és una de les més responsables que un propietari pot prendre.', '2024-10-19 17:08:23', '2024-10-19 22:43:24', 12, '/uploads/Esterilizar-gatos-1200x675.jpg'),
(28, 'Com presentar un nou gat a casa', 'Introduir un nou gat a la llar pot ser tot un repte, especialment si ja en tens un altre. Aquí tens alguns consells per assegurar una convivència harmònica i evitar problemes territorials. És important fer-ho de manera gradual i permetre que cada gat tingui el seu propi espai.', '2024-10-19 17:08:49', '2024-10-19 22:43:28', 12, '/uploads/gato-pequeño.jpg'),
(29, 'Els millors noms per a gats', 'Si acabes d&#039;adoptar un gat i no saps quin nom posar-li, aquí tens una llista d&#039;idees originals i divertides. Tria un nom que reflecteixi la personalitat del teu felí i que sigui fàcil de recordar. A més, et donem consells sobre com ensenyar-li el seu nou nom.', '2024-10-19 17:09:38', '2024-10-19 22:43:32', 12, '/uploads/7e71ccb1-ceac-4e9b-8f74-6010cefb6ec9_16-9-discover-aspect-ratio_default_0.jpg'),
(30, 'Cures per a gats de pèl llarg', 'Els gats de pèl llarg necessiten cures especials, com raspallats freqüents per evitar nusos i problemes de pell. També és important vigilar la seva alimentació i oferir-los una dieta rica en nutrients per mantenir el seu pelatge sa.', '2024-10-19 17:10:32', '2024-10-19 22:43:37', 12, '/uploads/Gatos de pelo largo_1_0.jpg'),
(31, 'El llenguatge dels gats: com entendre el teu felí', 'Els gats es comuniquen de moltes maneres, des de miols fins a postures corporals. Aprèn a entendre el que et diu el teu gat i millora la teva relació amb ell. Saber interpretar els senyals de tranquil·litat o d&#039;estrès és clau per a una bona convivència.', '2024-10-19 17:11:14', '2024-10-19 22:43:41', 12, '/uploads/Vinculo-con-tu-gato-bienestar-y-comportamiento-felino-scaled.jpg'),
(32, 'Els gats i la seva fascinació per les caixes', 'Si hi ha una cosa que als gats els encanta, són les caixes. Però, per què? Aquí explorem les raons darrere d&#039;aquest comportament i com pots aprofitar les caixes per entretenir el teu gat de manera segura.', '2024-10-19 17:11:51', '2024-10-19 22:43:47', 12, '/uploads/135703265_s.jpg'),
(33, 'Cures bàsiques per a un gatet acabat de néixer', 'Cuidar d&#039;un gatet acabat de néixer requereix molta atenció i dedicació. Descobreix com fer-ho de la millor manera, des de l&#039;alimentació fins a les primeres visites al veterinari. Els primers mesos de vida són crucials per al seu desenvolupament.', '2024-10-19 17:12:21', '2024-10-19 22:44:04', 12, '/uploads/cuidar-gato-recien-nacido.jpg'),
(34, 'Com tallar les ungles al teu gat de manera segura', 'Tallar les ungles del teu gat pot ser tot un repte, però amb aquests consells podràs fer-ho de forma segura i sense estrès. Recorda usar eines adequades i fer-ho en un moment en què el teu gat estigui relaxat.', '2024-10-19 17:12:50', '2024-10-19 22:44:10', 12, '/uploads/gatoscortarunas-77.jpg'),
(35, 'La millor alimentació per a un gat adult', 'L&#039;alimentació d&#039;un gat adult és fonamental per a la seva salut. Coneix quin tipus de menjar és el més adequat per a ells i com adaptar la seva dieta segons les seves necessitats.', '2024-10-19 17:14:04', '2024-10-19 22:44:16', 12, '/uploads/que-cantidad-de-alimento-debe-comer-un-gato.png'),
(36, 'Els gats i la música: els hi agrada?', 'Alguns estudis han demostrat que certs tipus de música poden relaxar els gats. Descobreix quins sons són els més recomanats per a ells i com pots usar la música per crear un ambient tranquil a casa.', '2024-10-19 17:14:52', '2024-10-19 22:44:20', 12, '/uploads/katze-musik-hoerer.jpg'),
(37, 'Els gats més famosos de la història', 'Des de l&#039;antiguitat fins a la cultura popular actual, els gats han deixat una gran empremta. Coneix alguns dels gats més famosos de la història, com el gat de la reina Victòria o els gats que han viatjat a l&#039;espai.', '2024-10-19 17:15:17', '2024-10-19 22:44:26', 12, '/uploads/image_content_29204452_20170808125145.jpg'),
(42, 'ndjnajdja', 'a,zndjfjsnj', '2024-10-21 13:11:27', '2024-10-21 13:15:36', 14, '/uploads/Captura de pantalla 2024-07-16 105616.png');

--
-- Volcado de datos para la tabla `usuaris`
--

INSERT INTO `usuaris` (`id`, `alies`, `email`, `password`, `nom_complet`) VALUES
(12, 'admin', 'admin@oni.es', '$2y$10$/TgNbSI3bsTXKUpxshY12uX1VGw6Ed5glXTqZuW9uSwjBO.RDTR8q', 'Santi'),
(14, 'Andreu69', 'snjas@kdnk.com', '$2y$10$.Yuj68azeQ7GzsfFT3obye1Rb63WmX2FZE/25uEDkQW5pR1Nuvayy', 'kanjdn');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
