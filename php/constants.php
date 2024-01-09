<?php
// Filename: constants.php
// Purpose: define values that are more general and not sensitive

namespace frakturmedia\RizeMeet;

// project specific files
define("SITE_PATH",                     "../site/");
define("EVENT_DETAILS_FILE",            SITE_PATH . "event_details.json");
define("MAILING_LIST_MEMBERS_FILENAME", SITE_PATH . "mailing_list.csv");
define("MAILING_ARCHIVE_FOLDER",        SITE_PATH . "ml_archive/");
define("EVENT_ROOMS_FOLDER",            SITE_PATH . "rooms/");
define("SESSIONS_DIR",                  SITE_PATH . "sessions/");
define("CONF_FILE",                     SITE_PATH . "config.php");
define("SITE_IMAGES_FOLDER",            SITE_PATH . "images/");

// config file
define("ADMIN_SALT_FILE", "../php/admin/salt_file.txt");
define("CONF_TEMPLATE", "../php/template_config.php");
define("SITE_TOML", "../site/site.toml");
define("SITE_TOML_TEMPLATE", "../php/template_site.toml");
define("EVENT_ROOM_TEMPLATE", "../php/template_location.json");
define("BACKUP_DIR", "../backups/");

// logging
define("LOGSDIR", "../logs/");

// other
define("ALLOWED_UPLOAD_FILE_TYPES", array("png", "gif", "svg", "jpg", "zip"));
define("PASSWORD_HASH_COST", 10);
define("TIMEZONE", 'CET');
define("WWW_SITE_IMAGES_FOLDER", "imgs/site/");

// tables if data is using DB
define("TABLE_MAILINGLIST", "mailing_list");
define("TABLE_SESSIONS", "sessions");

// EOF
