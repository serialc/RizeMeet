<?php
// Filename: www/admin/index.php
// Purpose: provides administrative functionality protected by .htaccess/.htpasswd

namespace frakturmedia\RizeMeet;

// move to same directory as main index page to use the same constants
chdir('..');

require_once('../php/initialization.php');

#use phpmailer\phpmailer;
require_once('../php/classes/mailer.php');

include '../php/layout/head.php';

include '../php/admin.php';

include '../php/emailing_list.php';

include '../php/layout/foot.php';

// EOF
