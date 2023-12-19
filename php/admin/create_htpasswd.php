<?php
// Filename: php/admin/create_htpasswd.php
// Purpose: displays form to make htpasswd when no htpasswd exists in www/admin and processes form

namespace frakturmedia\RizeMeet;

use Htpasswd;

if (isset($_POST['porg_admin_username']) and isset($_POST['porg_admin_pw'])) {

    $uname = $_POST['porg_admin_username'];
    $upass = $_POST['porg_admin_pw'];

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
echo '<div class="col-lg-6"><p>Set a username and password to access the admin area.</p></div>';
echo '<div class="col-lg-6">';
echo '<div class="input-group">' .
     '<label for="porg_admin_username" class="input-group-text">Username</label>' .
     '<input type="input" class="form-control" id="porg_admin_username" name="porg_admin_username">' .
     '</div>';
echo '<div class="input-group mt-1">' .
     '<label for="porg_admin_pw" class="input-group-text">Password</label>' .
     '<input type="password" class="form-control" id="porg_admin_pw" name="porg_admin_pw">' .
     '</div>' .
     '<div class="form-text mb-2">This form will disappear once the password is set</div>';
echo '<div class="col-12 text-end">' .
     '<button type="submit" class="btn btn-primary">Save</button>' .
     '</div>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
