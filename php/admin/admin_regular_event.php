<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action="." method="post">';
echo '<div class="container">';

// update date
$errors = false;
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
    if ($valid_date_string) {
        $conf['rizemeet_regular'] = $_POST['rizemeet_event_regularity'];
    } else {
        echo '<div class="row"><div class="col alert alert-danger mt-3" role="alert">' .
            '<p>Event date is invalid. Try the following:</p>' . 
            '<ul><li>Mondays</li><li>second Wednesday</li><li>last Friday</li><li>first day of this month</li></ul></div></div>';
        $errors = true;
    }
}

// update times
if (isset($_POST['rizemeet_stime'])) {
    $conf['rizemeet_stime'] = $_POST['rizemeet_stime'];
}
if (isset($_POST['rizemeet_etime'])) {
    $conf['rizemeet_etime'] = $_POST['rizemeet_etime'];
}

// save event details if any field was submitted (and there was no error above)
if (!$errors and (isset($_POST['rizemeet_event_regularity']) or isset($_POST['rizemeet_stime']) or isset($_POST['rizemeet_etime'])) ) {
        saveEventDetails($conf);
}

// show the date form
echo '<div class="row"><div class="col-12"><h2>Regular event schedule ' .
     '<img id="icon_regular_schedule" class="intico" src="/imgs/icons/rise_white.svg"></h2></div></div>';

echo '<div id="form_regular_schedule" class="row">' .
    '<div class="col-lg-6">' .
    '<p>Provide in textual form, when your regular event should occur.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">'.
     '<div class="input-group">' .
     '<label for="rizemeet_event_regularity" class="input-group-text meet_label">Event is on</label>' .
     '<input type="input" class="form-control" id="rizemeet_event_regularity" name="rizemeet_event_regularity" value="' . $conf['rizemeet_regular'] . '">' .
     '</div>';
echo '<div class="form-text mb-2">If blank, individual events will need to be selected. Which is fine.</div>';

echo '<div class="input-group">' .
     '<label for="rizemeet_stime" class="input-group-text meet_label">Start time</label>' .
     '<input type="time" class="form-control" id="rizemeet_stime" name="rizemeet_stime" value="' . $conf['rizemeet_stime'] . '">' .
     '</div>';

echo '<div class="input-group mt-1">
     <label for="rizemeet_etime" class="input-group-text meet_label">End time</label>
     <input type="time" class="form-control" id="rizemeet_etime" name="rizemeet_etime" value="' . $conf['rizemeet_etime'] . '">
     </div>';
echo '<div class="form-text mb-2">If blank, default time of 12h00 - 13h00 is used</div>';
echo '<div class="col-12 text-end">' .
    '<button type="submit" class="btn btn-primary mt-2">Save</button>' .
     '</div>';
echo '</div>';

echo '</div>';

echo '</div></div></div>';
echo '</form>';

// EOF
