<?php
// Filename: index.php
// Purpose: Main landing file of PORG

namespace frakturmedia\RizeMeet;

require_once('../php/initialization.php');
// $site specifies the site details based on site.toml

$conf = loadEventDetails();

//echo nl2br(print_r($site, true));

$req = explode("/", ltrim($_SERVER['REQUEST_URI'], "/"));
$page = $req[0];

include '../php/layout/head.php';

switch ($page) {
case 'documentation':
    include '../php/layout/documentation.php';
    break;

case 'unsubscribe_validation':
    include '../php/mailinglist/unsubscribe_validation.php';
    break;

case 'unsubscribe':
    include '../php/mailinglist/unsubscribe_main.php';
    break;

case 'subscribe_validation':
    include '../php/mailinglist/subscribe_validation.php';
    break;

case 'subscribe':
    include '../php/mailinglist/subscribe_process.php';
    break;

case 'sessions':
    include '../php/sessions.php';
    break;

default:
    include '../php/main.php';
}

include '../php/layout/foot.php';

// EOF

