<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action="." method="post">';
echo '<div class="container"><div class="row">';

// update date
if (isset($_POST['rizemeet_event_regularity'])) {
    // validate first
    $today = new \DateTime(date('Y-m-d'));
    //print($today->format('l, M j, Y'));

    try {
        // DateTime::modify() in PHP 8.3.0 throws an error, but earlier versions just throw a warning
        // suppress the invalid date error/warning with '@'
        // This won't trigger an exception. Update when we go to latest PHP.
        @$valid_date_string = (clone $today)->modify($_POST['rizemeet_event_regularity']);
    } catch (Exception $e) {
        $valid_date_string = false;
    }

    // if valid
    echo '<div class="col-12">';
    if ($valid_date_string) {
        $conf['rizemeet_regular'] = $_POST['rizemeet_event_regularity'];
    
        // process and save
        if (file_put_contents(EVENT_DETAILS_FILE, json_encode($conf))) {
            echo '<div class="alert alert-success mt-3" role="alert">Update successful</div>';
        } else {
            echo '<div class="alert alert-danger mt-3" role="alert">Failed to update</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">' .
            '<p>Date string is invalid. Try the following:</p>' . 
            '<ul><li>Mondays</li><li>second Wednesday</li><li>last Friday</li><li>first day of this month</li></ul></div>';
    }
    echo '</div>';
}

// show the date form
echo '<div class="col-12"><h1>Regular Event Schedule</h1></div>';

echo '<div class="col-lg-6">' .
    '<p>Provide in textual form, when your regular event should occur.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">'.
     '<div class="input-group">' .
     '<label for="rizemeet_event_regularity" class="input-group-text meet_label">Event is on</label>' .
     '<input type="input" class="form-control" id="rizemeet_event_regularity" name="rizemeet_event_regularity" value="' . $conf['rizemeet_regular'] . '">' .
     '</div>';
echo '<div class="form-text mb-2">If blank, individual events will need to be selected. Which is fine.</div>';
echo '<div class="col-12 text-end">' .
     '<button type="submit" class="btn btn-primary mt-2">Save</button>' .
     '</div></div>';

echo '</div></div></div>';
echo '</form>';

// EOF
