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
        alertWarning('Username or password is empty');
    } else {
        // create .htpasswd file if it doesn't exist
        if(!file_exists(ADMIN_HTPASSWD_FILE)) {
            touch(ADMIN_HTPASSWD_FILE);
        }

        $htpasswd = new Htpasswd(ADMIN_HTPASSWD_FILE);
        $htpasswd->addUser($uname, $upass, Htpasswd::ENCTYPE_SHA1);

        alertSuccess('User added');
    }
} 

// EOF
