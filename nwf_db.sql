--

-- Database: `ibis_dsl_db`

--

-- --------------------------------------------------------

--

-- Table structure for table `category`

--

CREATE TABLE `category` (
    `categoryID` int(11) NOT NULL,
    `userID` int(11) NOT NULL,
    `categoryType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `categoryLink` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    `categoryName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `categoryDescription` text COLLATE utf8_unicode_ci NOT NULL,
    `categoryDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `categoryDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

--

-- Dumping data for table `category`

--

INSERT INTO
    `category` (
        `categoryID`,
        `userID`,
        `categoryType`,
        `categoryLink`,
        `categoryName`,
        `categoryDescription`,
        `categoryDateCreated`,
        `categoryDateUpdated`
    )
VALUES
    (
        1,
        1,
        'product',
        'FIREPLACE INSERTS',
        'CRYSTAL SERIES',
        'GERMAN EDITION',
        '2020-11-20 23:09:40',
        '2022-05-04 14:32:28'
    ),
    (
        2,
        1,
        'product',
        'FIREPLACE INSERTS',
        'CORNER SERIES',
        'CORNER SERIES',
        '2022-05-07 17:39:40',
        '2022-05-16 07:43:06'
    ),
    (
        3,
        33,
        'product',
        'FIREPLACE INSERTS',
        'FLAT SERIES',
        'GERMAN EDITION',
        '2020-11-22 13:35:17',
        '2022-05-16 07:44:25'
    ),
    (
        4,
        33,
        'product',
        'FIREPLACE INSERTS',
        'TUNNEL SERIES',
        'GERMAN EDITION',
        '2020-11-22 13:35:17',
        '2022-05-16 07:45:55'
    ),
    (
        5,
        1,
        'product',
        'FREESTANDING SERIES',
        'FREESTANDING SERIES',
        'FREESTANDING SERIES',
        '2020-11-22 13:35:17',
        '2022-05-16 07:46:56'
    );

-- --------------------------------------------------------

--

-- Table structure for table `pages`

--

CREATE TABLE `pages` (
    `pageID` int(11) NOT NULL,
    `userID` int(11) NOT NULL,
    `pageName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `pageTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `pageContent` text COLLATE utf8_unicode_ci NOT NULL,
    `pageLanguage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '''FR''',
    `pageStatus` int(11) NOT NULL DEFAULT 0,
    `pageDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `pageDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

--

-- Dumping data for table `pages`

--

INSERT INTO
    `pages` (
        `pageID`,
        `userID`,
        `pageName`,
        `pageTitle`,
        `pageContent`,
        `pageLanguage`,
        `pageStatus`,
        `pageDateCreated`,
        `pageDateUpdated`
    )
VALUES
    (
        22,
        1,
        'about',
        'About Us',
        '<p><span style=\"font-size:18px;\"><em><span style=\"font-family:Arial,Helvetica,sans-serif\">In mehr als 27 Jahren hat sich das Unternehmen Acaminetti aus einem kleinen italienischen Familienunternehmen zu einem gro&szlig;en Unternehmen entwickelt, das alle Anforderungen der Kunden erf&uuml;llt. Acaminetti h&auml;lt sich an alle Standards, Einfachheit in der Zuverl&auml;ssigkeit und Verfeinerung im Design. A.Caminetti hat es sich zur Aufgabe gemacht, W&auml;rme bequem, wirtschaftlich, umweltbewusst und bedarfsgerecht zu erzeugen. Mit einer Vielzahl herausragender Produktentwicklungen und L&ouml;sungen zur Probleml&ouml;sung hat A.Caminetti Meilensteine gesetzt, die es oft zum Vorreiter und Trendsetter f&uuml;r ihre gesamte Branche gemacht haben. Die Ausrichtung von A.Caminetti ist international - da es in Europa, dem Nahen Osten, Asien, Afrika und den USA exportiert.</span></em></span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong><span style=\"font-size:16px;\">​Die Qualit&auml;t der hergestellten Materialien, die einfache Bedienung und die g&uuml;nstigen Preise werden auch den anspruchsvollsten K&auml;ufer &uuml;berzeugen.</span></strong></p>\r\n\r\n<p><span style=\"font-size:16px;\">- Produktionsfl&auml;che 7000 qm</span><br />\r\n<span style=\"font-size:16px;\">- 500 qm Lager in Landshut/Deutschland f&uuml;r den Expressversand in DE<br />\r\n- J&auml;hrliche Produktionskapazit&auml;t 8000 Hubt&uuml;rkamine / Holzverbrennung<br />\r\n- Mitarbeiter 150</span></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong><span style=\"font-size:16px;\">Glas in&nbsp; A. Caminetti Kamine werden in folgenden angebote ausf&uuml;hrungen:</span></strong></p>\r\n\r\n<p><em><span style=\"color:#e74c3c;\"><span style=\"font-size:16px;\">- Flachglas<br />\r\n- Eckglas<br />\r\n- 3 Seiten Glas (3D)<br />\r\n- 4 Seiten Glas (4D)</span></span></em></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><span style=\"font-size:18px\"><strong>A. Caminetti Kamineins&auml;tze haben folgende Eigenschaften:</strong></span></p>\r\n\r\n<ul>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Jedes Modell kann&nbsp; in jeder Gr&ouml;&szlig;e bestellt werden.</span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Die Kamine sind aus Stahl gefertigt, was Ihnen einen zuverl&auml;ssigen Einsatz &uuml;ber Jahrzehnte erm&ouml;glicht.</span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Die Garantie von 5 Jahren erm&ouml;glicht es Ihnen, ruhig und zuversichtlich in die Zuverl&auml;ssigkeit&nbsp; unserer Produkte zu sein.</span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Brennstoff f&uuml;r Briketts und Brennholz</span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Hohe Leistung sorgt f&uuml;r W&auml;rme auch in einem gro&szlig;en Raum.&nbsp;</span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-size:16px\">Die Produkte sind zertifiziert mit - EN 13229, BImSchV II, Flamme VERTE, ECODESIGN</span></p>\r\n	</li>\r\n</ul>\r\n',
        'DE',
        1,
        '2020-04-10 13:04:03',
        '2022-05-20 23:02:11'
    ),
    (
        26,
        1,
        'home',
        'Home Page',
        '',
        'DE',
        1,
        '2020-04-13 13:43:10',
        '2022-05-16 14:42:07'
    ),
    (
        31,
        1,
        'contact',
        'Contact Us',
        '<p><span style=\"font-size:2em;\"><i class=\"fas fa-map-marker-alt\"></i></span><br />\r\n<span style=\"font-size:20px;\">Acaminetti<br />\r\nPenzingerstrasse 53/8,<br />\r\n1140 Wien,<br />\r\n&Ouml;sterreich<br />\r\n<br />\r\n<i class=\"fas fa-phone-square-alt\"></i> <strong class=\"pl-1\">Tel: </strong><a href=\"tel:+43 670 50 63 561\">+43 670 50 63 561</a><br />\r\n<i class=\"fas fa-phone-square-alt\"></i> <strong class=\"pl-1\">Tel: </strong><a href=\"tel:+43 670 50 63 561\">+43 670 50 63 561</a><br />\r\n<i class=\"fas fa-envelope\"></i> <small class=\"pl-1\"><strong>E-Mail:</strong> <a href=\"mailto:office@ibis-dsl.ch\">office@ibis-dsl.ch</a></small></span></p>\r\n',
        'DE',
        1,
        '2020-04-13 17:15:46',
        '2022-05-20 23:04:57'
    ),
    (
        37,
        1,
        'product',
        'Renova DL - Projekte',
        '&lt;!-- Database data START --&gt;\r\n&lt;?php\r\n// Page header\r\nshowPageBanner(\r\n    &quot;PROJEKTE&quot;,\r\n    &quot;Wir führen Ihre Decken, Ihre Wände, eine sorgfältige und sorgfältige Installation.&quot;,\r\n    &quot;https://images.unsplash.com/photo-1595814433015-e6f5ce69614e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1350&amp;q=80&quot;\r\n);\r\n?&gt;\r\n&lt;!-- Database data END --&gt;',
        'DE',
        1,
        '2020-11-20 23:10:32',
        '2022-04-01 07:19:06'
    ),
    (
        48,
        48,
        'individual',
        'individual',
        '<h5 class=\"card-title m-0\">Danke dass Sie A.caminetti gew&auml;hlt haben!</h5>\r\n\r\n<hr class=\"mt-2\" />\r\n<p class=\"card-text text-muted mt-4\">Das A.caminetti Unternehmen erf&uuml;llt alle Kundenanforderungen, wir haben eine neue Vision, die Fantasie des Kunden mit den individuellen Gr&ouml;&szlig;en zu verwirklichen.</p>\r\n',
        'DE',
        1,
        '2022-04-26 12:02:06',
        '2022-04-26 10:04:55'
    ),
    (
        49,
        1,
        'advantages',
        'advantages',
        '<p>...</p>\r\n',
        'DE',
        0,
        '2022-04-27 13:38:44',
        '2022-05-07 13:18:07'
    ),
    (
        64,
        1,
        'distributors',
        'distributors',
        '<p style=\"text-align: center;\">&nbsp;</p>\r\n\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n\r\n<p style=\"text-align: center;\"><span style=\"font-size:26px;\"><strong>Page Under Construction!</strong></span></p>\r\n\r\n<p style=\"text-align: center;\"><span style=\"font-size:26px;\"><strong><img alt=\"yes\" height=\"23\" src=\"http://localhost/ibis-dsl.ch/app/Library/ckeditor/plugins/smiley/images/thumbs_up.png\" title=\"yes\" width=\"23\" /></strong></span></p>\r\n',
        'DE',
        1,
        '2022-05-10 16:35:18',
        '2022-05-10 14:36:45'
    );

-- --------------------------------------------------------

--

-- Table structure for table `product`

--

CREATE TABLE `product` (
    `productID` int(111) NOT NULL,
    `categoryID` int(11) DEFAULT NULL,
    `userID` int(11) NOT NULL,
    `productTitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `productSubTitle` varchar(255) NOT NULL,
    `productDescription` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `productImage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `productDetailsImage` varchar(255) NOT NULL,
    `productFile` varchar(255) NOT NULL,
    `productBg` varchar(255) NOT NULL,
    `productStatus` int(11) NOT NULL,
    `productOrder` int(11) NOT NULL,
    `productDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `productDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

--

-- Dumping data for table `product`

--

INSERT INTO
    `product` (
        `productID`,
        `categoryID`,
        `userID`,
        `productTitle`,
        `productSubTitle`,
        `productDescription`,
        `productImage`,
        `productDetailsImage`,
        `productFile`,
        `productBg`,
        `productStatus`,
        `productOrder`,
        `productDateCreated`,
        `productDateUpdated`
    )
VALUES
    (
        369,
        1,
        1,
        'CRYSTAL 80 MAX',
        'CRYSTAL 80 MAX',
        '',
        '62819297a6b96.jpg',
        '62819297a867d.jpg',
        '62819297a89ff.pdf',
        '',
        1,
        2,
        '2022-05-16 01:53:59',
        '2022-06-21 13:25:29'
    ),
    (
        370,
        1,
        1,
        'CRYSTAL 90 MAX',
        'CRYSTAL 90 MAX',
        '',
        '6281934e4a593.jpg',
        '6281934e4b76a.jpg',
        '6281934e4bab4.pdf',
        '',
        1,
        1,
        '2022-05-16 01:57:02',
        '2022-06-21 13:25:36'
    ),
    (
        371,
        1,
        1,
        'CRYSTAL 110 MAX',
        'CRYSTAL 110 MAX',
        '',
        '628193e6c16cd.jpg',
        '628193e6c2a90.jpg',
        '628193e6c2de9.pdf',
        '',
        1,
        6,
        '2022-05-16 01:59:34',
        '2022-06-21 13:51:07'
    ),
    (
        372,
        1,
        1,
        'CRYSTAL 3D 50x60',
        'CRYSTAL 3D 50x60',
        '',
        '6281942ff0471.jpg',
        '6281942ff08a3.jpg',
        '6281942ff0c4b.pdf',
        '',
        1,
        4,
        '2022-05-16 02:00:47',
        '2022-06-21 13:05:56'
    ),
    (
        373,
        1,
        1,
        'CRYSTAL 3D 50x70',
        'CRYSTAL 3D 50x70',
        '',
        '628194bb30bb7.jpg',
        '628194bb31034.jpg',
        '628194bb31328.pdf',
        '',
        1,
        5,
        '2022-05-16 02:03:07',
        '2022-06-21 13:06:01'
    ),
    (
        374,
        1,
        1,
        'CRYSTAL 3D MAX',
        'CRYSTAL 3D MAX',
        '',
        '6281950d5d854.jpg',
        '6281950d5dc67.jpg',
        '6281950d5df35.pdf',
        '',
        1,
        6,
        '2022-05-16 02:04:29',
        '2022-06-21 13:06:03'
    ),
    (
        375,
        2,
        1,
        'QUATTRO 80 L',
        'QUATTRO 80 L',
        '',
        '628195fe1de6e.jpg',
        '628195fe1e29e.jpg',
        '628195fe1f4e6.pdf',
        '',
        1,
        7,
        '2022-05-16 02:08:30',
        '2022-06-21 13:06:06'
    ),
    (
        376,
        2,
        1,
        'QUATTRO 90 L',
        'QUATTRO 90 L',
        '',
        '628196a212c4e.jpg',
        '628196a21312b.jpg',
        '628196a213d89.pdf',
        '',
        1,
        8,
        '2022-05-16 02:11:14',
        '2022-06-21 13:06:08'
    ),
    (
        377,
        2,
        1,
        'QUATTRO 100 L',
        'QUATTRO 100 L',
        '',
        '628196f6e92b9.jpg',
        '628196f6e97f2.jpg',
        '628196f6ea65e.pdf',
        '',
        1,
        9,
        '2022-05-16 02:12:38',
        '2022-06-21 13:06:11'
    ),
    (
        378,
        2,
        1,
        'QUATTRO 80 R',
        'QUATTRO 80 R',
        '',
        '62819742c3dc7.jpg',
        '62819742c5279.jpg',
        '62819742c55ef.pdf',
        '',
        1,
        10,
        '2022-05-16 02:13:54',
        '2022-06-21 13:06:14'
    ),
    (
        379,
        2,
        1,
        'QUATTRO 90 R',
        'QUATTRO 90 R',
        '',
        '6281977d345f7.jpg',
        '6281977d34ae9.jpg',
        '6281977d393e5.pdf',
        '',
        1,
        11,
        '2022-05-16 02:14:53',
        '2022-06-21 13:06:17'
    ),
    (
        380,
        2,
        1,
        'QUATTRO 100 R',
        'QUATTRO 100 R',
        '',
        '628197d739d2c.jpg',
        '628197d73a166.jpg',
        '628197d73a4de.pdf',
        '',
        1,
        12,
        '2022-05-16 02:16:23',
        '2022-06-21 13:06:20'
    ),
    (
        381,
        3,
        1,
        'FLAT 75x50',
        'FLAT 75x50',
        '',
        '628198673d151.jpg',
        '628198673dbd5.jpg',
        '628198673e067.pdf',
        '',
        1,
        13,
        '2022-05-16 02:18:47',
        '2022-06-21 13:06:23'
    ),
    (
        382,
        3,
        1,
        'FLAT 75x60',
        'FLAT 75x60',
        '',
        '628198cad6a6e.jpg',
        '628198cad6f05.jpg',
        '628198cad7b79.pdf',
        '',
        1,
        0,
        '2022-05-16 02:20:26',
        '2022-05-16 07:45:23'
    ),
    (
        383,
        3,
        1,
        'FLAT 90x50',
        'FLAT 90x50',
        '',
        '628199951415a.jpg',
        '628199951513f.jpg',
        '6281999515523.pdf',
        '',
        1,
        0,
        '2022-05-16 02:23:49',
        '2022-05-16 07:45:23'
    ),
    (
        384,
        3,
        1,
        'FLAT 90x60',
        'FLAT 90x60',
        '',
        '628199ebee135.jpg',
        '628199ebee5ff.jpg',
        '628199ebee951.pdf',
        '',
        1,
        0,
        '2022-05-16 02:25:15',
        '2022-05-16 07:45:23'
    ),
    (
        385,
        3,
        1,
        'FLAT 90x70',
        'FLAT 90x70',
        '',
        '62819a2580863.jpg',
        '62819a258120f.jpg',
        '62819a258155a.pdf',
        '',
        1,
        0,
        '2022-05-16 02:26:13',
        '2022-05-16 07:45:23'
    ),
    (
        386,
        3,
        1,
        'FLAT 120x50',
        'FLAT 120x50',
        '',
        '62819c7dc249f.jpg',
        '62819c7dc3589.jpg',
        '62819c7dc3908.pdf',
        '',
        1,
        0,
        '2022-05-16 02:36:13',
        '2022-05-16 07:45:24'
    ),
    (
        387,
        3,
        1,
        'FLAT 120x60',
        'FLAT 120x60',
        '',
        '6281fa65287e4.jpg',
        '62819d0a7f189.jpg',
        '6281fad8927de.pdf',
        '',
        1,
        0,
        '2022-05-16 02:38:34',
        '2022-05-16 07:45:24'
    ),
    (
        389,
        4,
        1,
        'FLAT W 90x60',
        'FLAT W 90x60',
        '',
        '62819f1c8b1ef.jpg',
        '62819f1c8b855.jpg',
        '62819f1c8b9b1.pdf',
        '',
        1,
        0,
        '2022-05-16 02:47:24',
        '2022-05-16 07:46:26'
    ),
    (
        390,
        4,
        1,
        'FLAT W 120x60',
        'FLAT W 120x60',
        '',
        '62819f53a17e0.jpg',
        '62819f53a2f75.jpg',
        '62819f53a3158.pdf',
        '',
        1,
        0,
        '2022-05-16 02:48:19',
        '2022-05-16 07:46:26'
    ),
    (
        391,
        5,
        1,
        'SCANDINAVIAN 65BH',
        'SCANDINAVIAN 65BH',
        '',
        '6281a996465cd.jpg',
        '6281a99646bd7.jpg',
        '6281a99646ef4.pdf',
        '',
        1,
        0,
        '2022-05-16 03:32:06',
        '2022-05-16 07:49:12'
    ),
    (
        392,
        5,
        1,
        'SCANDINAVIAN 65WH',
        'SCANDINAVIAN 65WH',
        '',
        '6281a9cd587cd.jpg',
        '6281b1264d121.jpg',
        '6281a9cd59acf.pdf',
        '',
        1,
        0,
        '2022-05-16 03:33:01',
        '2022-05-16 07:49:18'
    ),
    (
        393,
        5,
        1,
        'SCANDINAVIAN 50BH',
        'SCANDINAVIAN 50BH',
        '',
        '6281aa9be012f.jpg',
        '6281aa9be0547.jpg',
        '6281aa9be08a0.pdf',
        '',
        1,
        0,
        '2022-05-16 03:36:27',
        '2022-05-16 07:49:20'
    ),
    (
        394,
        5,
        1,
        'SCANDINAVIAN 50WH',
        'SCANDINAVIAN 50WH',
        '',
        '6281ac7323ed8.jpg',
        '6281ac732437a.jpg',
        '6281ac732466a.pdf',
        '',
        1,
        0,
        '2022-05-16 03:44:19',
        '2022-05-16 07:49:28'
    ),
    (
        395,
        5,
        1,
        'MEDITERRANEAN  C65',
        'MEDITERRANEAN  C65',
        '',
        '6281ad1029f1f.jpg',
        '6281ad102a42a.jpg',
        '6281ad102a790.pdf',
        '',
        1,
        0,
        '2022-05-16 03:46:56',
        '2022-05-16 07:49:25'
    ),
    (
        396,
        5,
        1,
        'SCANDINAVIAN QUATTRO 50',
        'SCANDINAVIAN QUATTRO 50',
        '',
        '6281ada269e17.jpg',
        '6281ada26a228.jpg',
        '6281ada26a53c.pdf',
        '',
        1,
        0,
        '2022-05-16 03:49:22',
        '2022-05-16 07:49:31'
    ),
    (
        397,
        5,
        1,
        'SCANDINAVIAN 50',
        'SCANDINAVIAN 50',
        '',
        '6281ae05c3b9b.jpg',
        '6281ae05c4049.jpg',
        '6281ae05c4339.pdf',
        '',
        1,
        0,
        '2022-05-16 03:51:01',
        '2022-05-16 07:49:33'
    ),
    (
        398,
        5,
        1,
        'SCANDINAVIAN 65',
        'SCANDINAVIAN 65',
        '',
        '6281ae6cdfdd4.jpg',
        '6281ae6ce03ff.jpg',
        '6281ae6ce0852.pdf',
        '',
        1,
        0,
        '2022-05-16 03:52:44',
        '2022-05-16 07:49:36'
    ),
    (
        399,
        5,
        1,
        'SCANDINAVIAN 75',
        'SCANDINAVIAN 75',
        '',
        '6281aee38906d.jpg',
        '6281aee389556.jpg',
        '6281aee3898ed.pdf',
        '',
        1,
        0,
        '2022-05-16 03:54:43',
        '2022-05-16 07:49:40'
    ),
    (
        400,
        5,
        1,
        'TUNNEL 90',
        'TUNNEL 90',
        '',
        '62821d873c33d.jpg',
        '6281af213225a.jpg',
        '6281af2132525.pdf',
        '',
        1,
        0,
        '2022-05-16 03:55:45',
        '2022-06-21 13:22:23'
    ),
    (
        401,
        5,
        1,
        'PANORAMA 75',
        'PANORAMA 75',
        '',
        '6281af726f742.jpg',
        '6281af726fc0c.jpg',
        '6281af726ff3d.pdf',
        '',
        1,
        0,
        '2022-05-16 03:57:06',
        '2022-05-16 07:49:44'
    ),
    (
        402,
        5,
        1,
        'PANORAMA 90',
        'PANORAMA 90',
        '',
        '6281afcf0df73.jpg',
        '6281afcf0e526.jpg',
        '6281afcf0e865.pdf',
        '',
        1,
        0,
        '2022-05-16 03:58:39',
        '2022-05-16 07:49:45'
    ),
    (
        403,
        5,
        1,
        'AMSTERDAM RS67',
        'AMSTERDAM RS67',
        '',
        '6281b032aaecd.jpg',
        '6281b032ab8f8.jpg',
        '6281b032abc27.pdf',
        '',
        1,
        0,
        '2022-05-16 04:00:18',
        '2022-05-16 07:49:47'
    ),
    (
        404,
        5,
        1,
        'PANORAMA RS18',
        'PANORAMA RS18',
        '',
        '6281b09f91298.jpg',
        '6281b09f91899.jpg',
        '6281b09f91c2a.pdf',
        '',
        1,
        0,
        '2022-05-16 04:02:07',
        '2022-05-16 07:49:49'
    ),
    (
        405,
        4,
        1,
        'FLAT W 75x60',
        'FLAT W 75x60',
        '',
        '6281b77c6bda4.jpg',
        '6281b77c6c726.jpg',
        '6281b77c6e25c.pdf',
        '',
        1,
        0,
        '2022-05-16 04:21:28',
        '2022-05-16 07:46:26'
    ),
    (
        407,
        3,
        1,
        'FLAT 150x50',
        'FLAT 150x50',
        '',
        '6281f562467ae.jpg',
        '6281f1d653ebf.jpg',
        '6281f1d656598.pdf',
        '',
        1,
        0,
        '2022-05-16 08:40:22',
        '2022-05-16 07:45:24'
    ),
    (
        408,
        3,
        1,
        'FLAT 180x50',
        'FLAT 180x50',
        '',
        '6281f6dc9723c.jpg',
        '6281f243b1cfb.jpg',
        '6281f243b2079.pdf',
        '',
        1,
        0,
        '2022-05-16 08:42:11',
        '2022-05-16 07:45:24'
    ),
    (
        409,
        5,
        55,
        'BARBEQUE',
        'BARBEQUE',
        '',
        '62abaee307edb.jpg',
        '62abae6095776.jpg',
        '62abae6095876.pdf',
        '',
        1,
        0,
        '2022-06-16 10:16:06',
        '2022-06-16 22:29:55'
    ),
    (
        410,
        5,
        55,
        'OUTDOOR 4D',
        'Outdoor 4D',
        '',
        '62abaf3b7e9e5.jpg',
        '62abaf3b7eaa4.jpg',
        '62abaf3b7ec60.pdf',
        '',
        1,
        0,
        '2022-06-16 10:21:35',
        '2022-06-16 22:33:47'
    ),
    (
        411,
        1,
        1,
        'test',
        'test',
        '',
        '62b1cd41b61f1.png',
        '62b1cd41b64f8.png',
        '62b1cd41b6be0.pdf',
        '',
        1,
        39,
        '2022-06-21 15:53:05',
        '2022-06-21 13:53:22'
    );

-- --------------------------------------------------------

--

-- Table structure for table `user`

--

CREATE TABLE `user` (
    `userID` int(11) NOT NULL,
    `userName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `userEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `userPassword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `userRole` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'default',
    `userDateCreated` datetime NOT NULL DEFAULT current_timestamp(),
    `userDateUpdated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

--

-- Dumping data for table `user`

--

INSERT INTO
    `user` (
        `userID`,
        `userName`,
        `userEmail`,
        `userPassword`,
        `userRole`,
        `userDateCreated`,
        `userDateUpdated`
    )
VALUES
    (
        1,
        'admin',
        'office@ibis-dsl.ch',
        '$2y$10$gvonhclnWtn05CpWVYYgjuhJrV2O1P4dUpBHOzy0A6IFsc8MU9DhS',
        'admin',
        '2019-12-28 18:58:35',
        '2022-05-21 01:11:25'
    ),
    (
        33,
        'support',
        'support@ibis-dsl.ch',
        '$2y$10$aR7v7r9Jj9.IQl8BseJhje/vkke1wTW.k9Hn7U3/8mvr8SzSj/oFK',
        'default',
        '2019-11-26 20:19:44',
        '0000-00-00 00:00:00'
    ),
    (
        43,
        'test',
        'test@test.com',
        '$2y$10$adoBi2Qk/BpAkaFyZboqHOxL.dk0sX942Jk9fJo27vmZuQfrnIYTK',
        'default',
        '2019-12-03 01:54:32',
        '0000-00-00 00:00:00'
    ),
    (
        44,
        'nesho',
        'ademi.neshat@gmail.com',
        '$2y$10$EIc7mYel10zCUUG/uU9wnOWTLz9t6v5ACXViziAYDo89pIxZben0S',
        'admin',
        '2022-04-21 22:03:45',
        '2022-05-21 09:38:08'
    ),
    (
        48,
        'office',
        'office@office.com',
        '$2y$10$QLegVapHhrSEyJ6pZnUFgOZeFZyL0vbvVbLRRUZ2B.xO5Xe1yGiEy',
        'admin',
        '2022-04-21 23:31:38',
        '2022-04-21 21:31:38'
    ),
    (
        55,
        'zhivina',
        'jetmir.kazimi@gmail.com',
        '$2y$10$6n9iWk.sKoQ5BCs7LluCrunG2o7ucY13IJoJM1CgBzYfeIQ0BCxV2',
        'admin',
        '2022-06-15 20:48:10',
        '2022-06-15 18:48:10'
    );

--

-- Indexes for dumped tables

--

--

-- Indexes for table `category`

--

ALTER TABLE `category` ADD PRIMARY KEY (`categoryID`);

--

-- Indexes for table `pages`

--

ALTER TABLE `pages` ADD PRIMARY KEY (`pageID`);

--

-- Indexes for table `product`

--

ALTER TABLE `product` ADD PRIMARY KEY (`productID`);

--

-- Indexes for table `user`

--

ALTER TABLE `user` ADD PRIMARY KEY (`userID`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `category`

--

ALTER TABLE
    `category`
MODIFY
    `categoryID` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 46;

--

-- AUTO_INCREMENT for table `pages`

--

ALTER TABLE
    `pages`
MODIFY
    `pageID` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 65;

--

-- AUTO_INCREMENT for table `product`

--

ALTER TABLE
    `product`
MODIFY
    `productID` int(111) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 412;

--

-- AUTO_INCREMENT for table `user`

--

ALTER TABLE
    `user`
MODIFY
    `userID` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 56;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;