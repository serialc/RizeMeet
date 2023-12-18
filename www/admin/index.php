<?php
// Filename: www/admin/index.php
// Purpose: provides administrative functionality protected by .htaccess/.htpasswd

namespace frakturmedia\RizeMeet;

use ozanhazer\php-htpasswd;

// check if there's an .htpasswd file
if (!file_exists(.htpasswd)) {
    echo "Need to create an htpasswd";
    $htpasswd = new Htpasswd('.htpasswd');
}

// move to same directory as main index page to use the same constants
chdir('..');

require_once('../php/initialization.php');
// $site specifies the site details based on site.toml


$conf = loadEventDetails();

#use phpmailer\phpmailer;

require_once('../php/classes/mailer.php');

include '../php/layout/head.php';

include '../php/admin/admin.php';

include '../php/admin/admin_mailing_list_manager.php';

include '../php/layout/foot.php';

// EOF
