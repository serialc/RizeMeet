<?php
// Filename: php/admin/admin_next_event.php
// Purpose: display and process the forms to customize the next meeting (location, date, subjects)

namespace frakturmedia\RizeMeet;

echo '<form action=".#manage_regular_event" method="post">';
echo '<div id="manage_regular_event" class="container mb-2"><div class="row"><div class="col">' .
     '<h1 id="icon_manage_regular_event" class="intico">Regular Event Schedule</h1></div></div></div>';

echo '<div class="container">';

global $apre_errors;

// show a message here if there were errors
if ($apre_errors) {
    alertDanger('Event date is invalid. Try the following:</p><ul><li>Mondays</li><li>second Wednesday of this month</li><li>last Friday</li><li>first day of this month</li></ul>', false);
} else {
    alertSuccess('Update successful');
}

// show the date form

echo '<div id="manage_regular_event_content" class="row">' .
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
echo '<div class="col-12 text-end mb-3">' .
    '<button type="submit" class="btn btn-primary mt-2">Save</button>' .
     '</div>';
echo '</div>';

echo '</div>';

echo '</div></div></div>';
echo '</form>';

// EOF
