<?php
// Filename: php/admin.php
// Purpose: show admin forms

namespace frakturmedia\RizeMeet;

use Htpasswd;

// select Parsedown from the global namespace
$parsedown = new \Parsedown();

// check the www/admin folder exists and has permission
if ( !is_writable('admin') ) {
    exit("Check 'www/admin' write permissions");
}

// check if there's at least one administrator in the .htpasswd
// if not, show the form to create it
include('../php/admin/admin_add_user_processing.php');
$htpasswd = new Htpasswd(ADMIN_HTPASSWD_FILE);
if(count($htpasswd->getUsers()) === 0) {
    // process .htpasswd username addition
    alertDanger("You must add an administrator to secure the site.");
    include('../php/admin/admin_add_user_form.php');
    return;
}

echo '<div class="container"><div class="row"><div class="col"><h1>Next event</h1></div></div></div>';


// process submitted form to customize the next event (date, location, topics)
include('../php/admin/admin_process_specific_event.php');
include('../php/admin/admin_process_regular_event.php');

// repackage and determine the event based on $conf and today's date
$next_event = determineNextEvent($conf);

// show the form to customize the next event (date, location, topics)
include('../php/admin/admin_next_event.php');

// show the form to email registrants with info on next event
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include '../php/admin/admin_mailing_list_manager.php';

// show the form for the regular meeting date time
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_regular_event.php');

// Manage locations
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include '../php/admin/admin_location_manager.php';

// divider, below is the infrequent updates
// Manage sessions
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_manage_sessions.php');

// divider, below is the backup
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_manage_styling.php');

// Manage Administrators
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';

echo '<div id="manage_admin" class="container"><div class="row"><div class="col">' .
     '<h1 id="icon_manage_admin" class="intico">Administrators</h1>' .
     '</div></div></div>';

// process .htpasswd username addition
include('../php/admin/admin_add_user_processing.php');

// show the admin access controls
if (file_exists(ADMIN_HTPASSWD_FILE) and file_exists(ADMIN_HTACCESS_FILE)) {
    echo '<div id="manage_admin_content">';
    include('../php/admin/admin_add_user_form.php');
    include('../php/admin/admin_delete_user.php');
    echo '</div>';
} else {
    alertDanger("The administration site is not secured! You must configure the .htaccess and .htpasswd correctly.");
}

// divider, below is the images manager
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_images_manager.php');

// divider, below is the public content
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_edit_content.php');

// divider, below is the backup
echo '<div class="container"><div class="row"><div class="col"><hr></div></div></div>';
include('../php/admin/admin_manage_backups.php');

// EOF
