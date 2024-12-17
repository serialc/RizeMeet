<?php
// Filename: php/admin/admin_process_specific_event.php
// Purpose: process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;


// update date
if (isset($_POST['rizemeet_date'])) {
    $conf['rizemeet_date'] = $_POST['rizemeet_date'];
}

// update location 
if (isset($_POST['rizemeet_location'])) {
    $conf['rizemeet_location'] = $_POST['rizemeet_location'];
}

// update topic 
if (isset($_POST['rizemeet_meeting_topic'])) {
    $conf['rizemeet_meeting_topic'] = $_POST['rizemeet_meeting_topic'];
}

// save form based on updated $conf above if necessary (any posted data)
if ( isset($_POST['rizemeet_date']) or isset($_POST['rizemeet_location']) or isset($_POST['rizemeet_meeting_topic']) ) {
    echo '<div class="container"><div class="row">';
    saveEventDetails($conf);
    echo '</div></div>';
}
