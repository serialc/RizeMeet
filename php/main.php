<?php
// Filename: php/main.php
// Purpose: Main/welcome page

namespace frakturmedia\RizeMeet;

// repackage and determine the event based on $conf and today's date
$next_event = determineNextEvent($conf);

include '../php/layout/splash_menu.php';

include '../php/layout/main_page.php';
