<?php
// Filename: php/admin/admin_edit_htpasswd.php
// Purpose: allows editing of the .htpasswd file and admin access

namespace frakturmedia\RizeMeet;

use Htpasswd;

if (isset($_POST['rizemeet_admin_delete'])) {
    $duname = $_POST['rizemeet_admin_delete'];

    // initialize class object that manages the htpasswd file
    $htpasswd = new Htpasswd(ADMIN_HTPASSWD_FILE);

    // check either isn't empty
    if (strcmp($duname, "") === 0) {
        alertWarning("No username provided!");
    } elseif (count($htpasswd->getUsers()) === 1) {
        alertWarning("You cannot have less than one administrator!");
    } else {
        if ($htpasswd->userExists($duname)) {
            $htpasswd->deleteUser($duname);
            alertSuccess('User ' . $duname . ' deleted!');
        } else {
            alertWarning('User ' . $duname . ' does not exist!');
        }
    }
} 

echo '<form action=".#manage_admin" method="post">';
echo '<div class="container"><div class="row">';

echo '<div class="col-12"><h2>Delete admin</h2></div>';
echo '<div class="col-lg-6 col-md-12">' .
     '<p>Administrators: ';

$htpasswd = new Htpasswd(ADMIN_HTPASSWD_FILE);
foreach ($htpasswd->getUsers() as $admin => $pw) {
    echo '<b>' . $admin . '</b> ';
}

echo '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">';

echo '<div class="input-group">' .
     '<label for="rizemeet_admin_delete" class="input-group-text meet_label">Username</label>' .
     '<input type="input" class="form-control" id="rizemeet_admin_delete" name="rizemeet_admin_delete">' .
     '<button type="submit" class="btn btn-danger">Delete</button>' .
     '</div>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
