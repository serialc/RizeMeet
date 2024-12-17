<?php
// Filename: php/admin/admin_process_regular_event.php
// Purpose: process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

// update date
$apre_errors = false;
if (isset($_POST['rizemeet_event_regularity']) ) {

    // if empty, that's fine
    if (empty($_POST['rizemeet_event_regularity'])) {
        $valid_date_string = true;
    } else {
        // validate first
        $today = new \DateTime(date('Y-m-d'));
        //print($today->format('l, M j, Y'));
        
        try {
            // DateTime::modify() in PHP 8.3.0 throws an error, but earlier versions just throw a warning
            // suppress the invalid date error/warning with '@'
            // This won't trigger an exception. Update when we go to latest PHP.
            $valid_date_string = @(clone $today)->modify($_POST['rizemeet_event_regularity']);
        } catch (\DateMalformedStringException $e) {
            $valid_date_string = false;
        }
    }

    // if valid
    if ($valid_date_string) {
        $conf['rizemeet_regular'] = $_POST['rizemeet_event_regularity'];
    } else {
        $apre_errors = true;
    }
}

// update event time start/end
if (isset($_POST['rizemeet_stime'])) {
    $conf['rizemeet_stime'] = $_POST['rizemeet_stime'];
}
if (isset($_POST['rizemeet_etime'])) {
    $conf['rizemeet_etime'] = $_POST['rizemeet_etime'];
}

// save event details if any field was submitted (and there was no error above)
if (!$apre_errors and (isset($_POST['rizemeet_event_regularity']) or isset($_POST['rizemeet_stime']) or isset($_POST['rizemeet_etime'])) ) {
    saveEventDetails($conf);
}

// EOF
