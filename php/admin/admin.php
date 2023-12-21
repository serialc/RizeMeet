<?php
// Filename: php/admin.php
// Purpose: show admin forms

namespace frakturmedia\RizeMeet;

// To do
echo <<< _END
<div class="container"><div class="row"><div class="col">
<h1>To do:</h1>
<ul>
<li>Sessions submit and edit form</li>
<li>Edit the htpasswd file</li>
<li>Add a second admin page (cog/settings) that allows the customization of the entirety of the site.toml and all the other content pages</li>
</ul>
</div> </div> </div>

_END;

// check if there's an .htpasswd file 
// if not, show the form to create it
if (!file_exists('admin/.htpasswd')) {
    include('../php/admin/admin_create_htpasswd.php');
}

// show the form for the regular meeting time
include('../php/admin/admin_regular_event.php');
// this may change the next event date so load the NextEvent() after this

// repackage and determine the event based on $conf and today's date
$next_event = determineNextEvent($conf);

// show the form to customize the next event (date, location, topics)
include('../php/admin/admin_next_event.php');

// show the form to email registrants with info on next event
include '../php/admin/admin_mailing_list_manager.php';

// EOF
