<?php
// Filename: php/admin.php
// Purpose: show controls next porg meet, location, and topic

// check if there's an .htpasswd file 
// if not, show the form to create it
if (!file_exists('.htpasswd')) {
    include('../php/admin/create_htpasswd.php');
}

// show the form to customize the next event (date, location, topics)
include('../php/admin/admin_next_event.php');

// show the form to email registrants with info on next event
include '../php/admin/admin_mailing_list_manager.php';

// EOF
