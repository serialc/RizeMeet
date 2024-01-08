<?php
// Filename: www/admin/index.php
// Purpose: provides administrative functionality protected by .htaccess/.htpasswd

namespace frakturmedia\RizeMeet;

// move to same directory as main index page to use the same constants
chdir('..');

require_once('../php/initialization.php');
// $site specifies the site details based on site.toml
require_once('../php/admin/admin_functions.php');

if (isset($_GET['download'])) {

    // we don't read any passed file name - just get the one generated today
    $zfn = $site['brand'] . '_' . date('Y-m-d') . '.zip';

    // do download and not site loading
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $zfn. '"');
    readfile(BACKUP_DIR . $zfn);
    return;
}

$conf = loadEventDetails();

use phpmailer\phpmailer;

require_once('../php/classes/mailer.php');

include '../php/layout/head.php';

include '../php/admin/admin.php';

include '../php/layout/foot.php';

// EOF
