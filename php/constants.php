<?php
// Filename: constants.php
// Purpose: define values that are more general and not sensitive

namespace frakturmedia\RizeMeet;

// project specific files
define("EVENT_DETAILS_FILE", "../content/event_details.json");
define("ADMIN_SALT_FILE", "../content/salt_file.txt");
define("MAILING_LIST_MEMBERS_FILENAME", "../content/mailing_list.csv");
define("MAILING_ARCHIVE_FOLDER", "../content/ml_archive/");
define("EVENT_ROOMS_FOLDER", "../content/rooms/");

// config file
define("CONF_TEMPLATE", "../php/template_config.php");
define("CONF_FILE", "../php/config.php");

// logging
define('LOGSDIR', '../logs/');

// other
define("PASSWORD_HASH_COST", 10);

// EOF
