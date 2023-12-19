<?php
// Filename: initialization.php
// Purpose: do the messy bits at the start of the index file

namespace frakturmedia\RizeMeet;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// load constants
require_once("../php/constants.php");

date_default_timezone_set(TIMEZONE);

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");


// load or create ../php/config.php
if ( !file_exists(CONF_FILE) ) {
    copy(CONF_TEMPLATE, CONF_FILE);
}
require_once(CONF_FILE);

// Composer autoloader for components
require_once("../vendor/autoload.php");

# log errors according to PRODUCTION or DEVELOPMENT
ini_set("log_errors", 1);
ini_set("error_log", "../php-error.log");

// use logging and present errors differently
if (SERVER_IS_PRODUCTION) {
    # load appropriate php configs
    ini_set('display_startup_errors', 0);
    ini_set('display_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    # Error diagnostic
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();

    # load appropriate php configs
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

// load the main utility functions
require_once('../php/functions.php');

// Monolog - create log channels
$log = new Logger('main');
$log->pushHandler(new StreamHandler(LOGSDIR . 'main.log', Level::Info));
// Use: $log->info("something"), $log->warning(), or $log->error()

use Yosymfony\Toml\Toml;
if ( !file_exists( SITE_TOML ) ) {
    copy(SITE_TOML_TEMPLATE, SITE_TOML);
}
$site = Toml::ParseFile( SITE_TOML );

// EOF
