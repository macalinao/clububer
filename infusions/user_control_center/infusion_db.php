<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| User Control Center 2.40
| Author: Sebastian Schüssler (slaughter)
| Download:
| http://basti2web.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/


// UCC Settings

if (!defined("DB_UCC_SETTINGS")) {
	define("DB_UCC_SETTINGS", DB_PREFIX."ucc_settings");
}


// PHP-Fusion 6 Compatibility

if (!defined("DB_ADMIN")) {
define("DB_ADMIN", DB_PREFIX."admin");
}

if (!defined("DB_ARTICLE_CATS")) {
define("DB_ARTICLE_CATS", DB_PREFIX."article_cats");
}

if (!defined("DB_ARTICLES")) {
define("DB_ARTICLES", DB_PREFIX."articles");
}

if (!defined("DB_BBCODES")) {
define("DB_BBCODES", DB_PREFIX."bbcodes");
}

if (!defined("DB_BLACKLIST")) {
define("DB_BLACKLIST", DB_PREFIX."blacklist");
}

if (!defined("DB_CAPTCHA")) {
define("DB_CAPTCHA", DB_PREFIX."captcha");
}

if (!defined("DB_COMMENTS")) {
define("DB_COMMENTS", DB_PREFIX."comments");
}

if (!defined("DB_CUSTOM_PAGES")) {
define("DB_CUSTOM_PAGES", DB_PREFIX."custom_pages");
}

if (!defined("DB_DOWNLOAD_CATS")) {
define("DB_DOWNLOAD_CATS", DB_PREFIX."download_cats");
}

if (!defined("DB_DOWNLOADS")) {
define("DB_DOWNLOADS", DB_PREFIX."downloads");
}

if (!defined("DB_FAQ_CATS")) {
define("DB_FAQ_CATS", DB_PREFIX."faq_cats");
}

if (!defined("DB_FAQS")) {
define("DB_FAQS", DB_PREFIX."faqs");
}

if (!defined("DB_FLOOD_CONTROL")) {
define("DB_FLOOD_CONTROL", DB_PREFIX."flood_control");
}

if (!defined("DB_FORUM_ATTACHMENTS")) {
define("DB_FORUM_ATTACHMENTS", DB_PREFIX."forum_attachments");
}

if (!defined("DB_FORUM_POLL_OPTIONS")) {
define("DB_FORUM_POLL_OPTIONS", DB_PREFIX."forum_poll_options");
}

if (!defined("DB_FORUM_POLL_VOTERS")) {
define("DB_FORUM_POLL_VOTERS", DB_PREFIX."forum_poll_voters");
}

if (!defined("DB_FORUM_POLLS")) {
define("DB_FORUM_POLLS", DB_PREFIX."forum_polls");
}

if (!defined("DB_FORUM_RANKS")) {
define("DB_FORUM_RANKS", DB_PREFIX."forum_ranks");
}

if (!defined("DB_FORUMS")) {
define("DB_FORUMS", DB_PREFIX."forums");
}

if (!defined("DB_INFUSIONS")) {
define("DB_INFUSIONS", DB_PREFIX."infusions");
}

if (!defined("DB_MESSAGES")) {
define("DB_MESSAGES", DB_PREFIX."messages");
}

if (!defined("DB_MESSAGES_OPTIONS")) {
define("DB_MESSAGES_OPTIONS", DB_PREFIX."messages_options");
}

if (!defined("DB_NEW_USERS")) {
define("DB_NEW_USERS", DB_PREFIX."new_users");
}

if (!defined("DB_NEWS")) {
define("DB_NEWS", DB_PREFIX."news");
}

if (!defined("DB_NEWS_CATS")) {
define("DB_NEWS_CATS", DB_PREFIX."news_cats");
}

if (!defined("DB_ONLINE")) {
define("DB_ONLINE", DB_PREFIX."online");
}

if (!defined("DB_PANELS")) {
define("DB_PANELS", DB_PREFIX."panels");
}

if (!defined("DB_PHOTO_ALBUMS")) {
define("DB_PHOTO_ALBUMS", DB_PREFIX."photo_albums");
}

if (!defined("DB_PHOTOS")) {
define("DB_PHOTOS", DB_PREFIX."photos");
}

if (!defined("DB_POLL_VOTES")) {
define("DB_POLL_VOTES", DB_PREFIX."poll_votes");
}

if (!defined("DB_POLLS")) {
define("DB_POLLS", DB_PREFIX."polls");
}

if (!defined("DB_POSTS")) {
define("DB_POSTS", DB_PREFIX."posts");
}

if (!defined("DB_RATINGS")) {
define("DB_RATINGS", DB_PREFIX."ratings");
}

if (!defined("DB_SETTINGS")) {
define("DB_SETTINGS", DB_PREFIX."settings");
}

if (!defined("DB_SHOUTBOX")) {
define("DB_SHOUTBOX", DB_PREFIX."shoutbox");
}

if (!defined("DB_SITE_LINKS")) {
define("DB_SITE_LINKS", DB_PREFIX."site_links");
}

if (!defined("DB_SMILEYS")) {
define("DB_SMILEYS", DB_PREFIX."smileys");
}

if (!defined("DB_SUBMISSIONS")) {
define("DB_SUBMISSIONS", DB_PREFIX."submissions");
}

if (!defined("DB_THREAD_NOTIFY")) {
define("DB_THREAD_NOTIFY", DB_PREFIX."thread_notify");
}

if (!defined("DB_THREADS")) {
define("DB_THREADS", DB_PREFIX."threads");
}

if (!defined("DB_USER_FIELDS")) {
define("DB_USER_FIELDS", DB_PREFIX."user_fields");
}

if (!defined("DB_USER_GROUPS")) {
define("DB_USER_GROUPS", DB_PREFIX."user_groups");
}

if (!defined("DB_USERS")) {
define("DB_USERS", DB_PREFIX."users");
}

if (!defined("DB_WEBLINK_CATS")) {
define("DB_WEBLINK_CATS", DB_PREFIX."weblink_cats");
}

if (!defined("DB_WEBLINKS")) {
define("DB_WEBLINKS", DB_PREFIX."weblinks");
}

?>