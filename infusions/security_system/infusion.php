<?php
/*--------------------------------------------+
| PHP-Fusion 6 - Content Management System    |
|---------------------------------------------|
| author: Nick Jones (Digitanium) © 2002-2005 |
| web: http://www.php-fusion.co.uk            |
| email: nick@php-fusion.co.uk                |
|---------------------------------------------|
| Released under the terms and conditions of  |
| the GNU General Public License (Version 2)  |
+--------------------------------------------*/
/*----------------------------------------------+
| SECURITY SYSTEM V1 FÜR PHP-FUSION             |
| copyright (c) 2006 by BS-Fusion Deutschland   |
| Email-Support: webmaster[at]bs-fusion.de      |
| Homepage: http://www.bs-fusion.de             |
| Inhaber: Manuel Kurz                          |
+----------------------------------------------*/
if (!defined("IN_FUSION") || !checkrights("I")) { header("Location: ../../index.php"); exit; }
if (file_exists(INFUSIONS."security_system/locale/".$settings['locale'].".php")) {
	include INFUSIONS."security_system/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."security_system/locale/German.php";
}
// Infusion general information
$inf_title = $locale['SYS100'];
$inf_description = $locale['SYS101'];
$inf_version = "1.8.5";
$inf_developer = "Silvermoon";
$inf_email = "webmaster@bs-fusion.de";
$inf_weburl = "http://www.bs-fusion.de";

$inf_folder = "security_system"; // The folder in which the infusion resides.
$inf_admin_image = ""; // Leave blank to use the default image.
$inf_admin_panel = "admin/index.php"; // The admin panel filename if required.

$inf_newtables = 10;// Number of new db tables to create or drop.
$inf_insertdbrows = 4;// Numbers rows added into created db tables.
$inf_altertables = 0;

// Database table commands are stored in an array, the first table, or a single
// table must always be in array [0].

$inf_newtable[1] = DB_PREFIX."secsys_filter (
    id INT(11) unsigned NOT NULL AUTO_INCREMENT ,
    list VARCHAR(255) NOT NULL,
    active TINYINT(1) unsigned NOT NULL DEFAULT '1',
    PRIMARY KEY  (id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_PREFIX."secsys_settings (
  secsys_started tinyint(1) unsigned NOT NULL,
  proxy_visit tinyint(1) unsigned NOT NULL,
  proxy_register tinyint(1) unsigned NOT NULL,
  proxy_login tinyint(1) unsigned NOT NULL,
  fctime int(11) unsigned NOT NULL,
  sctime int(11) unsigned NOT NULL,
  cctime int(11) unsigned NOT NULL,
  mctime int(11) unsigned NOT NULL,
  gctime int(11) unsigned NOT NULL,
  coctime int(11) unsigned NOT NULL,
  userlock smallint(1) unsigned NOT NULL,
  user_attempts smallint(1) unsigned NOT NULL,
  flood_active smallint(1) unsigned NOT NULL,
  forum_access mediumint(3) unsigned NOT NULL,
  shout_access mediumint(3) unsigned NOT NULL,
  comment_access mediumint(3) unsigned NOT NULL,
  pm_access mediumint(3) unsigned NOT NULL,
  contact_access mediumint(3) unsigned NOT NULL,
  gb_access mediumint(3) unsigned NOT NULL,
  ctracker_log tinyint(1) unsigned NOT NULL DEFAULT '1',
  filter_log tinyint(1) unsigned NOT NULL DEFAULT '1',
  spam_log tinyint(1) unsigned NOT NULL DEFAULT '1',
  flood_log tinyint(1) unsigned NOT NULL DEFAULT '1',
  proxy_log tinyint(1) unsigned NOT NULL DEFAULT '1',
  log_autodelete tinyint(1) unsigned NOT NULL DEFAULT '1',
  log_max mediumint(5) unsigned NOT NULL DEFAULT '500',
  log_expired int(11) unsigned NOT NULL DEFAULT '30',
  version varchar(10) NOT NULL,
  panel_set smallint(1) NOT NULL,
  license_accept smallint(1) NOT NULL,
  KEY version (version)
) TYPE=MyISAM;";


$inf_newtable[3] = DB_PREFIX."secsys_contact (
    contact_id SMALLINT(5) unsigned NOT NULL AUTO_INCREMENT ,
    contact_datestamp INT(10) NOT NULL,
    contact_ip VARCHAR(20) NOT NULL,
    PRIMARY KEY  (contact_id)
) TYPE=MyISAM AUTO_INCREMENT=1;";

$inf_newtable[4] = DB_PREFIX."secsys_logfile (
  hack_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  hack_type VARCHAR(255) NOT NULL,
  hack_userid INT(11) UNSIGNED NOT NULL,
  hack_ip VARCHAR(20) NOT NULL,
  hack_query TEXT NOT NULL,
  hack_referer TEXT NOT NULL,
  hack_agent TEXT NOT NULL,
  hack_datestamp INT(10) NOT NULL,
  PRIMARY KEY (hack_id)
) TYPE=MyISAM;";

$inf_newtable[5] = DB_PREFIX."secsys_statistics (
  stats_id TINYINT(1) UNSIGNED NOT NULL,
  hacks INT(11) UNSIGNED NOT NULL,
  floods INT(11) UNSIGNED NOT NULL,
  blocks INT(11) UNSIGNED NOT NULL,
  spams INT(11) UNSIGNED NOT NULL,
  proxy_visit INT(11) UNSIGNED NOT NULL,
  proxy_login INT(11) UNSIGNED NOT NULL,
  proxy_register INT(11) UNSIGNED NOT NULL,
  proxy_blacklist INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (stats_id)
) TYPE=MyISAM;";

$inf_newtable[6] = DB_PREFIX."secsys_membercontrol (
  c_user_id INT(10) UNSIGNED NOT NULL,
  c_flood_count SMALLINT(1) NOT NULL,
  c_userlock SMALLINT(1) NOT NULL DEFAULT 0,
  c_userlock_datestamp INT(10) NOT NULL,
  PRIMARY KEY (c_user_id)
) TYPE=MyISAM;";

$inf_newtable[7] = DB_PREFIX."secsys_spamfilter (
  spam_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  spam_word VARCHAR(255) NOT NULL,
  PRIMARY KEY (spam_id)
) TYPE=MyISAM;";

$inf_newtable[8] = DB_PREFIX."secsys_blacklist (
  blacklist_ip varchar(15) NOT NULL DEFAULT '0.0.0.0',
  blacklist_datestamp int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (blacklist_ip)
) TYPE=MyISAM;";

$inf_newtable[9] = DB_PREFIX."secsys_proxy_blacklist (
  proxy_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  proxy_ip VARCHAR(15) NOT NULL,
  proxy_datestamp INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (proxy_id)
) TYPE=MyISAM;";

$inf_newtable[10] = DB_PREFIX."secsys_proxy_whitelist (
  proxy_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, 
  proxy_ip VARCHAR(15) NOT NULL,
  proxy_datestamp INT(10) UNSIGNED NOT NULL,
  proxy_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (proxy_id)
) TYPE=MyISAM;";

$inf_insertdbrow[1]=DB_PREFIX."secsys_filter VALUES (1, 'Aqua_Products',1),(2, 'asterias',1),(3, 'b2w',1),(4, 'BackDoorBot',1),(5, 'Bait & Tackle',1),(6, 'BlowFish',1),(7, 'Bookmark search tool',1),(8, 'BotALot',1),(9, 'BruteForce',1),(10, 'BuiltBotTough',1),(11, 'BullsEye',1),(12, 'BunnySlippers',1),(13, 'CheeseBot',1),(14, 'CherryPicker',1),(15, 'CopyRightCheck',1),(16, 'cosmos',1),(17, 'Crescent',1),(18, 'DittoSpyder',1),(19, 'EmailCollector',1),(20, 'EmailSiphon',1),(21, 'EmailWolf',1),(22, 'EroCrawler',1),(23, 'ExtractorPro',1),(24, 'FairAd Client',1),(25, 'Flaming AttackBot',1),(26, 'Foobot',1),(27, 'Gaisbot',1),(28, 'GetRight',1),(29, 'grup',1),(30, 'grub-client',1),(31, 'Harvest/1.5',1),(32, 'hloader',1),(33, 'httplib',1),(34, 'HTTrack',1),(35, 'humanlinks',1),(36, 'ia_archiver',1),(37, 'InfoNaviRobot',1),(38, 'Iron33',1),(39, 'JennyBot',1),(40, 'Kenjin Spider',1),(41, 'Keyword Density',1),(42, 'larbin',1),(43, 'LexiBot',1),(44, 'libWeb/clsHTTP',1),(45, 'LinkextractorPro',1),(46, 'LinkScan',1),(47, 'LinkWalker',1),(48, 'LNSpiderguy',1),(49, 'looksmart',1),(50, 'lwp',1),(51, 'Mata Hari',1),(52, 'URL Control',1),(53, 'MIIxpc',1),(54, 'Mister PiX',1),(55, 'moget',1),(56, 'MSIECrawler',1),(57, 'NetAnts',1),(58, 'NetMechanic',1),(59, 'NICErsPRO',1),(60, 'Offline Explorer',1),(61, 'Openbot',1),(62, 'Openfind',1),(63, 'Oracle Ultra Search',1),(64, 'PerMan',1),(65, 'ProPowerBot',1),(66, 'ProWebwalker',1),(67, 'psbot',1),(68, 'Python-urllib',1),(69, 'QueryN MetaSearch',1),(70, 'Radiation Retriever',1),(71, 'RepoMonkey',1),(72, 'RMA',1),(73, 'searchpreview',1),(74, 'SiteSnagger',1),(75, 'SpankBot',1),(76, 'spanner',1),(77, 'suzuran',1),(78, 'Szukacz',1),(79, 'Teleport',1),(80, 'The Intraformant',1),(81, 'TheNomad',1),(82, 'TightTwatBot',1),(83, 'True Robot',1),(84, 'toCrawl',1),(85, 'turingos',1),(86, 'UrlDispatcher',1),(87, 'URL_Spider_Pro',1),(88, 'VCI',1),(89, 'Warning',1),(90, 'WebAuto',1),(91, 'WebBandit',1),(92, 'WebCopier',1),(93, 'WebDownloader',1),(94, 'WebEnhancer',1),(95, 'Wget',1),(96, 'Web Image Collector',1),(97, 'WebmasterWorldForumBot',1),(98, 'WebSauger',1),(99, 'Website Quester',1),(100, 'Webster',1),(101, 'WebStripper',1),(102, 'WebZip',1),(103, 'WWW-Collector-E',1),(104, 'Xenu\'s',1),(105, 'Zeus',1),(106, 'AntiLeech Leecher',1),(107, 'HenryTheMiragoRobot',1),(108,'libwww',1)";

$inf_insertdbrow[2]=DB_PREFIX."secsys_settings VALUES (1, 1, 1, 1, 15, 15, 15, 15, 15, 15, 0, 3, 1, 102, 102, 102, 102, 102, 102, 1, 1, 1, 1, 1, 0, 200, 30, '".$inf_version."', 1, 0)";
// Einfügen der Statistiken auf Null
$inf_insertdbrow[3]=DB_PREFIX."secsys_statistics VALUES ('1','0','0','0','0','0','0','0','0')";
$inf_insertdbrow[4]=DB_PREFIX."secsys_spamfilter VALUES (1, 'poker'),(2, 'spons'),(3,'pharma'),(4, 'viagra'),(5, 'scheis'),(6, 'scheiß'),(7, 'votz'),(8, 'idiot'),(9, 'schwanz'),(10, 'arsch'),(11, 'marketing'),(12, 'female'),(13, 'katalog'),(14, 'buy'),(15, 'ionamin'),
(16, 'pills'),(17, 'amandarighetti'),(18, 'adult'),(19, 'religious'),(20, 'porno'),
(21, 'casino'),(22, 'constitutionpartyofwa'),(23, 'cellular-deals'),(24, 'phentermine'),
(25, 'searchadvisor'),(26, 'thesuitelifeofzackandcody'),(27, 'freewebpages.org'),
(28, 'tits'),(29, 'sex'),(30, 'casa-olympus'),(31, 'leucainfo'),(32, 'xenical'),
(33, 'cellular'),(34, 'sperm'),(35, 'drewbarrimore'),(36, 'nude'),(37, 'breast'),(38, 'cyberbuzz'),(39, 'payless'),(40, 'of109'),(41, 'untergeek'),(42, 'guy'),(43, 'gayemanhole'),(44, 'willywonka'),(45, 'iagreewithyou'),(46, 'asd'),(47, 'boob'),
(48, 'lesbian'),(49, 'popnet'),(50, 'erection'),(51, 'preobrajensky'),(52, 'spacepeople'),(53, 'furniture'),(54, 'stores'),(55, 'kastrulya'),(56, 'dicembre'),(57, 'teenmovies'),(58, 'gangbang'),(59, 'webarch'),(60, 'cialis'),(61, 'for order '),(62, 'hardcore'),(63, 'movies'),(64, 'tux.ini'),(65, 'penis'),(66, 'naked'),(67, 'hacked by'),(68, 'cumshot'),(69, 'figlia'),(70, 'cerc2tw.info')";

// Database Table Drop Command : Drop tables if infusion is uninstalled.
$inf_droptable[1] = DB_PREFIX."secsys_filter";
$inf_droptable[2] = DB_PREFIX."secsys_settings";
$inf_droptable[3] = DB_PREFIX."secsys_contact";
$inf_droptable[4] = DB_PREFIX."secsys_logfile";
$inf_droptable[5] = DB_PREFIX."secsys_statistics";
$inf_droptable[6] = DB_PREFIX."secsys_membercontrol";
$inf_droptable[7] = DB_PREFIX."secsys_spamfilter";
$inf_droptable[8] = DB_PREFIX."secsys_blacklist";
$inf_droptable[9] = DB_PREFIX."secsys_proxy_blacklist";
$inf_droptable[10] = DB_PREFIX."secsys_proxy_whitelist";

$inf_adminpanel[1] = array(
	"title" => $locale['SYS100'],
	"image" => "image.gif",
	"panel" => "admin/index.php",
	"rights" => "SC"
);
?>
