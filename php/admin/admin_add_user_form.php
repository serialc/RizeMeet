<?php
// Filename: php/admin/admin_add_user_form.php
// Purpose: displays form to add admin user 

namespace frakturmedia\RizeMeet;

use Htpasswd;

echo '<form action=".#manage_admin" method="post">';
echo '<div class="container"><div class="row">';

echo '<div class="col-12"><h2>Add</h2></div>';
echo '<div class="col-lg-6 col-md-12">' .
     '<p>Set a username and password to access the admin area.</p>' .
     '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">';
echo '<div class="input-group">' .
     '<label for="rizemeet_admin_username" class="input-group-text meet_label">Username</label>' .
     '<input type="input" class="form-control" id="rizemeet_admin_username" name="rizemeet_admin_username">' .
     '</div>';
echo '<div class="input-group mt-1">' .
     '<label for="rizemeet_admin_pw" class="input-group-text meet_label">Password</label>' .
     '<input type="password" class="form-control" id="rizemeet_admin_pw" name="rizemeet_admin_pw">' .
     '</div>';
echo '<div class="col-12 text-end">' .
     '<button type="submit" class="btn btn-primary mt-2">Add admin</button>' .
     '</div>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
