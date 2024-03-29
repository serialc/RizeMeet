<?php
// Filename: php/admin.php
// Purpose: show admin forms

namespace frakturmedia\RizeMeet;

// select Parsedown from the global namespace
$parsedown = new \Parsedown();

// check if there's an .htpasswd file 
// if not, show the form to create it
if (!file_exists('admin/.htpasswd')) {
    // process .htpasswd username addition
    include('../php/admin/admin_add_user_processing.php');
    include('../php/admin/admin_add_user_form.php');
}

echo '<div class="container"><div class="row"><div class="col"><h1>Event</h1></div></div></div>';


// show the form for the regular meeting time
include('../php/admin/admin_regular_event.php');
// this may change the next event date so load the NextEvent() after this

// process submitted form to customize the next event (date, location, topics)
include('../php/admin/admin_process_event.php');

// repackage and determine the event based on $conf and today's date
$next_event = determineNextEvent($conf);

// show the form to customize the next event (date, location, topics)
include('../php/admin/admin_next_event.php');

// show the form to email registrants with info on next event
include '../php/admin/admin_mailing_list_manager.php';

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
     '<h1>Administrators <img id="icon_manage_admin" class="intico" src="/imgs/icons/rise.svg"></h1>' .
     '</div></div></div>';

// process .htpasswd username addition
include('../php/admin/admin_add_user_processing.php');

echo '<div id="manage_admin_content">';
// show the admin access controls
if (file_exists('admin/.htpasswd')) {
    include('../php/admin/admin_add_user_form.php');
    include('../php/admin/admin_delete_user.php');
}
echo '</div>';

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
