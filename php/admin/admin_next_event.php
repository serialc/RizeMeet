<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action="." method="post">';
echo '<div class="container"><div class="row">';

// the possible locations
if ( file_exists(EVENT_ROOMS_FOLDER) ) {
    $rizemeet_locs = array_diff(scandir(EVENT_ROOMS_FOLDER), array('.', '..'));
} else {
    $rizemeet_locs = [];
}

// update date
if (isset($_POST['rizemeet_date'])) {
    $conf['rizemeet_date'] = $_POST['rizemeet_date'];
}

// update time
if (isset($_POST['rizemeet_stime'])) {
    $conf['rizemeet_stime'] = $_POST['rizemeet_stime'];
}
if (isset($_POST['rizemeet_etime'])) {
    $conf['rizemeet_etime'] = $_POST['rizemeet_etime'];
}

// update location 
if (isset($_POST['rizemeet_location'])) {
    $conf['rizemeet_location'] = $_POST['rizemeet_location'];
}

// update topic 
if (isset($_POST['rizemeet_meeting_topic'])) {
    $conf['rizemeet_meeting_topic'] = $_POST['rizemeet_meeting_topic'];
}

// save form based on updated $conf
if (isset($_POST['rizemeet_date']) or isset($_POST['rizemeet_location']) or
    isset($_POST['rizemeet_stime']) or isset($_POST['rizemeet_etime']) ) {

    echo '<div class="col-12">';
    if (file_put_contents(EVENT_DETAILS_FILE, json_encode($conf))) {
        echo '<div class="alert alert-success mt-3" role="alert">Update successful</div>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Failed to update</div>';
    }
    echo '</div>';
}

// show the date form
echo '<div class="col-12"><h1>Next Event - ' . $next_event['pretty_date'] . '</h1></div>';

echo '<div class="col-12"><h2>Date-time</h2></div>';

echo '<div class="col-lg-6">' .
    '<p>You can override the date of the next event by selecting a futre date here.</p>' .
    '<p>Specify a regular meeting time or use the default.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">'.
     '<div class="input-group">' .
     '<label for="rizemeet_date" class="input-group-text meet_label">Select date</label>' .
     '<input type="date" class="form-control" id="rizemeet_date" name="rizemeet_date" value="' . $conf['rizemeet_date'] . '">' .
     '</div>';
     echo '<div class="form-text mb-2">If blank, next second Monday of month is used</div>';

echo '<div class="input-group">' .
     '<label for="rizemeet_stime" class="input-group-text meet_label">Start time</label>' .
     '<input type="time" class="form-control" id="rizemeet_stime" name="rizemeet_stime" value="' . $conf['rizemeet_stime'] . '">' .
     '</div>';

echo '<div class="input-group mt-1">
     <label for="rizemeet_etime" class="input-group-text meet_label">End time</label>
     <input type="time" class="form-control" id="rizemeet_etime" name="rizemeet_etime" value="' . $conf['rizemeet_etime'] . '">
     </div>';
     echo '<div class="form-text mb-2">If blank, default time of 12h00 - 13h00 is used</div>';
echo '</div>';

// show the location form
echo '<div class="col-12"><h2>Location</h2></div>';

echo '<div class="col-lg-6">' .
    '<p>Select a location.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">';

if (count($rizemeet_locs) === 0) {
    echo 'No locations available. See the <a href="/documentation">documentation</a>.';
}

foreach($rizemeet_locs as $fn) {

    $room = json_decode(file_get_contents(EVENT_ROOMS_FOLDER . $fn), true);

    echo '<div class="btn-group-vertical me-2" role="group">';
    echo '<input class="btn-check" type="radio" name="rizemeet_location" id="' .
        $room['name'] . '" value="' . $fn . '"';
    if ( strcmp($conf['rizemeet_location'], $fn) === 0 ) {
        echo " checked ";
    }
    echo '>';
    echo '<label class="btn btn-outline-primary mt-2" for="' . $room['name'] . '">' .
        $room['name'] . '</label></div>';
}
echo '</div>';

// Next topic
echo '<div class="col-12"><h2>Next meeting topic</h2></div>';

echo '<div class="col-lg-6">' .
    '<p>Describe information needed or of interest for next meeting.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-lg-6 col-md-9">';
echo '<textarea id="rizemeet_meeting_topic" name="rizemeet_meeting_topic" rows="5" class="w-100">' .
    $conf['rizemeet_meeting_topic'] .
    '</textarea>';
echo '<div class="form-text mb-2">The above is markdown that will be parsed to HTML</div>';
echo '</div>';

echo '<div class="col-12 text-end">';
echo '<button type="submit" class="btn btn-primary">Update event</button>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
