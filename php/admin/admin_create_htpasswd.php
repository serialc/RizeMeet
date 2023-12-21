<?php
// Filename: php/admin/create_htpasswd.php
// Purpose: displays form to make htpasswd when no htpasswd exists in www/admin and processes form

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
        touch('admin/.htpasswd');
        $htpasswd = new Htpasswd('admin/.htpasswd');
        $htpasswd->addUser($uname, $upass, Htpasswd::ENCTYPE_SHA1);

        // leave the file, don't show the form
        return;
    }
} 

echo '<form action="." method="post">';
echo '<div class="container"><div class="row">';

echo '<div class="col-12"><h1>Set Admin Password</h1></div>';
echo '<div class="col-md-6">' .
     '<p>Set a username and password to access the admin area.</p>' .
     '<p>This form will disappear once the password is set.</p>' .
     '</div>';
echo '<div class="col-md-6">';
echo '<div class="input-group">' .
     '<label for="rizemeet_admin_username" class="input-group-text meet_label">Username</label>' .
     '<input type="input" class="form-control" id="rizemeet_admin_username" name="rizemeet_admin_username">' .
     '</div>';
echo '<div class="input-group mt-1">' .
     '<label for="rizemeet_admin_pw" class="input-group-text meet_label">Password</label>' .
     '<input type="password" class="form-control" id="rizemeet_admin_pw" name="rizemeet_admin_pw">' .
     '</div>';
echo '<div class="col-12 text-end">' .
     '<button type="submit" class="btn btn-primary mt-2">Save</button>' .
     '</div>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
