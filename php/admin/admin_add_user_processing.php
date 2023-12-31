<?php
// Filename: php/admin/admin_add_user_process.php
// Purpose: processes username and password

namespace frakturmedia\RizeMeet;

use Htpasswd;

if (isset($_POST['rizemeet_admin_username']) and isset($_POST['rizemeet_admin_pw'])) {

    $uname = $_POST['rizemeet_admin_username'];
    $upass = $_POST['rizemeet_admin_pw'];

    // check either isn't empty
    if ($uname == "" or $upass == "") {
        echo '<div class="container"><div class="row"><div class="col">Username or password is empty';
        echo '</div></div></div>';
    } else {
        // create .htpasswd file if it doesn't exist
        if(!file_exists('admin/.htpasswd')) {
            touch('admin/.htpasswd');
        }
        $htpasswd = new Htpasswd('admin/.htpasswd');
        $htpasswd->addUser($uname, $upass, Htpasswd::ENCTYPE_SHA1);
    }
} 

// EOF
