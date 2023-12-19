<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action="." method="post">';
echo '<div class="container"><div class="row">';

// the possible locations
if ( file_exists(EVENT_ROOMS_FOLDER) ) {
    $porg_locs = array_diff(scandir(EVENT_ROOMS_FOLDER), array('.', '..'));
} else {
    $porg_locs = [];
}

// update date
if (isset($_POST['porg_date'])) {
    $conf['porg_date'] = $_POST['porg_date'];
}

// update time
if (isset($_POST['porg_stime'])) {
    $conf['porg_stime'] = $_POST['porg_stime'];
}
if (isset($_POST['porg_etime'])) {
    $conf['porg_etime'] = $_POST['porg_etime'];
}

// update location 
if (isset($_POST['porg_location'])) {
    $conf['porg_location'] = $_POST['porg_location'];
}

// update topic 
if (isset($_POST['porg_meeting_topic'])) {
    $conf['porg_meeting_topic'] = $_POST['porg_meeting_topic'];
}

// save form based on updated $conf
if (isset($_POST['porg_date']) or isset($_POST['porg_location']) or
    isset($_POST['porg_stime']) or isset($_POST['porg_etime']) ) {

    echo '<div class="col-12">';
    if (file_put_contents(EVENT_DETAILS_FILE, json_encode($conf))) {
        echo '<div class="alert alert-success mt-3" role="alert">Update successful</div>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Failed to update</div>';
    }
    echo '</div>';
}

// show the date form
echo '<div class="col-12"><h1>Next Event details</h1></div>';

echo '<div class="col-lg-4 col-md-8"><h2>Next meeting date-time</h2>';

echo '<div class="input-group">' .
     '<label for="porg_date" class="input-group-text meet_label">Select date</label>' .
     '<input type="date" class="form-control" id="porg_date" name="porg_date" value="' . $conf['porg_date'] . '">' .
     '</div>';
     echo '<div class="form-text mb-2">If blank, next second Monday of month is used</div>';

echo '<div class="input-group">' .
     '<label for="porg_stime" class="input-group-text meet_label">Start time</label>' .
     '<input type="time" class="form-control" id="porg_stime" name="porg_stime" value="' . $conf['porg_stime'] . '">' .
     '</div>';

echo '<div class="input-group mt-1">
     <label for="porg_etime" class="input-group-text meet_label">End time</label>
     <input type="time" class="form-control" id="porg_etime" name="porg_etime" value="' . $conf['porg_etime'] . '">
     </div>';
     echo '<div class="form-text mb-2">If blank, default time of 12h00 - 13h00 is used</div>';
echo '</div>';

// show the location form
echo '<div class="col-lg-3 col-md-4"><h2>Meeting location</h2>';

if (count($porg_locs) === 0) {
    echo 'No locations available. See the <a href="/documentation">documentation</a>.';
}

foreach($porg_locs as $fn) {

    $room = json_decode(file_get_contents(EVENT_ROOMS_FOLDER . $fn), true);

    echo '<div class="btn-group-vertical me-2" role="group">';
    echo '<input class="btn-check" type="radio" name="porg_location" id="' .
        $room['name'] . '" value="' . $fn . '"';
    if ( strcmp($conf['porg_location'], $fn) === 0 ) {
        echo " checked ";
    }
    echo '>';
    echo '<label class="btn btn-outline-primary mt-2" for="' . $room['name'] . '">' .
        $room['name'] . '</label></div>';
}
echo '</div>';

// Next topic
echo '<div class="col-lg-5 col-md-12"><h2>Next meeting topic</h2>';
echo '<textarea id="porg_meeting_topic" name="porg_meeting_topic" rows="5" class="w-100">' .
    $conf['porg_meeting_topic'] .
    '</textarea>';
echo '<div class="form-text mb-2">The above is markdown that will be parsed to HTML</div>';
echo '</div>';

echo '<div class="col-12 text-end">';
echo '<button type="submit" class="btn btn-primary">Update event</button>';
echo '</div>';

echo '</div></div>';
echo '</form>';

// EOF
