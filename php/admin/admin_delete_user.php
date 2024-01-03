<?php
// Filename: php/admin/admin_edit_htpasswd.php
// Purpose: allows editing of the .htpasswd file and admin access

namespace frakturmedia\RizeMeet;

use Htpasswd;

if (isset($_POST['rizemeet_admin_delete'])) {
    $duname = $_POST['rizemeet_admin_delete'];

    // check either isn't empty
    if ($duname == "") {
        alertWarning("No username provided");
    } else {
        $htpasswd = new Htpasswd('admin/.htpasswd');
        if ($htpasswd->userExists($duname)) {
            $htpasswd->deleteUser($duname);
        } else {
            alertWarning("User does not exist");
        }
    }
} 

echo '<form action=".#form_manage_admin" method="post">';
echo '<div class="container"><div class="row">';

echo '<div class="col-12"><h2>Delete admin</h2></div>';
echo '<div class="col-lg-6 col-md-12">' .
     '<p>Administrators: ';
$admins = explode("\n", file_get_contents('admin/.htpasswd'));
foreach ($admins as $admin) {
    echo '<b>' . explode(':', $admin)[0] . '</b> ';
}
echo '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">';
echo '<div class="input-group">' .
     '<label for="rizemeet_admin_delete" class="input-group-text meet_label">Username</label>' .
     '<input type="input" class="form-control" id="rizemeet_admin_delete" name="rizemeet_admin_delete">' .
     '</div>';
echo '<div class="col-12 text-end">' .
     '<button type="submit" class="btn btn-primary mt-2">Delete</button>' .
     '</div>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
