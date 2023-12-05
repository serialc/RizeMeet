<?php
// Filename: constants.php
// Purpose: define values that are more general and not sensitive

namespace frakturmedia\RizeMeet;

// project specific files
define("SITE_PATH", "../site/");
define("EVENT_DETAILS_FILE",            SITE_PATH . "event_details.json");
define("ADMIN_SALT_FILE",               SITE_PATH . "salt_file.txt");
define("MAILING_LIST_MEMBERS_FILENAME", SITE_PATH . "mailing_list.csv");
define("MAILING_ARCHIVE_FOLDER",        SITE_PATH . "ml_archive/");
define("EVENT_ROOMS_FOLDER",            SITE_PATH . "rooms/");
define("SESSIONS_DIR",                  SITE_PATH . "sessions/");

// config file
define("CONF_TEMPLATE", "../php/template_config.php");
define("CONF_FILE", SITE_PATH . "config.php");

// logging
define('LOGSDIR', '../logs/');

// other
define("PASSWORD_HASH_COST", 10);

// EOF
