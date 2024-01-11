<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action=".#regular_event_results" method="post">';
echo '<div class="container"><div class="row">';

// load the possible meeting locations / rooms
// Create the folder if it doesn't yet exist
if ( !file_exists(EVENT_ROOMS_FOLDER) ) {
    mkdir(EVENT_ROOMS_FOLDER);
    // also add a template
    copy(EVENT_ROOM_TEMPLATE, EVENT_ROOMS_FOLDER . 'template.json');
}

$rizemeet_locs = array_diff(scandir(EVENT_ROOMS_FOLDER), array('.', '..'));

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

// save form based on updated $conf
if (isset($_POST['rizemeet_date']) or isset($_POST['rizemeet_location'])) {
    saveEventDetails($conf);
}

// show the date form
alertPrimary('Next event is ' . $next_event['pretty_date'] . ' at ' . $next_event['stime'] . '-' . $next_event['etime']);

echo <<< END
<div class="col-12"><h2>Date override</h2></div>
<div class="col-lg-6">
 <p>You can override the date of the next event by selecting a future date here.</p>
 <p>Specify a regular meeting time or use the default.</p>
</div>

<div class="col-md-3 d-lg-none"></div>
<div class="col-lg-6 col-md-9">
 <div class="input-group">
  <label for="rizemeet_date" class="input-group-text meet_label">Select date</label>
END;

echo '<input type="date" class="form-control" id="rizemeet_date" name="rizemeet_date" value="' . $conf['rizemeet_date'] . '">' .
     '</div>' . 
     '<div class="form-text mb-2">If blank, the regular event schedule is used</div>' .
     '</div>';

// show the location form
echo '<div class="col-12"><h2>Location</h2></div>';

echo '<div class="col-md-3">' .
    '<p>Select a location.</p>' .
    '</div>';

echo '<div class="col-md-3 d-lg-none"></div>';

echo '<div class="col-md-9 col-sm-12">';

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
echo '<div class="col-12 mt-3"><h2>Next meeting topic</h2></div>';

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
