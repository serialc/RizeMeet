<?php
// Filename: constants.php
// Purpose: define values that are more general and not sensitive

namespace frakturmedia\RizeMeet;

// project specific files
define("SITE_PATH",                     "../site/");
define("EVENT_DETAILS_FILE",            SITE_PATH . "event_details.json");
define("MAILING_LIST_MEMBERS_FILENAME", SITE_PATH . "mailing_list.csv");
define("MAILING_LIST_DB_BACKUP",        SITE_PATH . "mailing_list_db_backup.csv");
define("MAILING_ARCHIVE_FOLDER",        SITE_PATH . "ml_archive/");
define("EVENT_ROOMS_FOLDER",            SITE_PATH . "rooms/");
define("SESSIONS_DIR",                  SITE_PATH . "sessions/");
define("CONF_FILE",                     SITE_PATH . "config.php");
define("SITE_IMAGES_FOLDER",            SITE_PATH . "images/");
define("SITE_CUSTOM_CSS",               SITE_PATH . "custom.css");
define("SITE_TOML",                     SITE_PATH . "site.toml");
define("SITE_LAST_EVENT_ID",            SITE_PATH . "last_event_id.txt");

// templates
define("CONF_TEMPLATE", "../templates/template_config.php");
define("SITE_TOML_TEMPLATE", "../templates/template_site.toml");
define("EVENT_ROOM_TEMPLATE", "../templates/template_location.json");
define("CUSTOM_CSS_TEMPLATE", "../templates/custom.css");

// logging
define("LOGSDIR", "../logs/");

// other
define("ADMIN_AREA", "admin/");
define("ADMIN_SALT_FILE", ADMIN_AREA . "salt_file.txt");
define("ADMIN_HTPASSWD_FILE", SITE_PATH . ".htpasswd");
define("ADMIN_HTACCESS_FILE", ADMIN_AREA . ".htaccess");
define("ALLOWED_UPLOAD_FILE_TYPES", array("png", "gif", "svg", "jpg", "zip"));
define("PASSWORD_HASH_COST", 10);
define("TIMEZONE", 'CET');
define("WWW_IMAGES_FOLDER", "imgs/");
define("WWW_IMAGES_SITE_FOLDER", WWW_IMAGES_FOLDER . "site/");
define("WWW_SITE_CUSTOM_CSS",    "css/custom.css");
define("BACKUP_DIR", "../backups/");

// EOF
