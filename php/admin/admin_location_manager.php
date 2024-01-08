<?php
// Filename: php/admin/.admin_location_manager.php
// Purpose: displays forms for customizing locations/rooms and does processing

namespace frakturmedia\RizeMeet;

// check that the room/locations directory exists
if (!file_exists(EVENT_ROOMS_FOLDER)) { mkdir(EVENT_ROOMS_FOLDER); }

// heading for session management
echo '<div id="manage_locations" class="container mb-2"><div class="row"><div class="col">' .
     '<h1>Meeting Locations <img id="icon_manage_locations" class="intico" src="/imgs/icons/rise.svg"></h1></div></div></div>';

echo '<div id="manage_locations_content">';

// process new location request
if (isset($_POST['rizemeet_new_location'])) {
    $alphanum = $_POST['rizemeet_new_location'];

    if (ctype_alnum($alphanum)) {
        // transform valid date to filename, add markdown extension
        $fn = $alphanum . '.json';

        if (file_exists(EVENT_ROOMS_FOLDER . $fn)) {
            alertDanger("File name '" . $fn . "' already exists");
        } else {
            alertSuccess("File created");
            copy(EVENT_ROOM_TEMPLATE, EVENT_ROOMS_FOLDER . $fn);
        }
    } else {
        alertDanger("File name '" . $alphanum . "' is not valid as it contains other characters than <b>letters and numbers</b>");
    }
}


// List the room/location files that exist
$rooms = array_diff(scandir(EVENT_ROOMS_FOLDER), array('.', '..'));
echo <<< END
<div class="container"><div class="row">
  <div class="col-12"><h2>Edit room</h2></div>
  <div class="col-md-3 col-sm-4"><p>Select room file to edit.</p></div>
  <div class="col-md-9 col-sm-8"><div class="row">
END;

foreach ($rooms as $r) {
    echo '<div class="col-md-4 col-sm-6 mb-3"><a href=".?room=' . $r . '#manage_locations"><button class="btn btn-secondary w-100">' . $r . '</button></a></div>';
}
echo '</div></div></div>';


// process the location content submission
if (isset($_POST['rizemeet_location_edit'])) {
    $fdata = $_POST['rizemeet_location_edit'];
    $fname = $_POST['rizemeet_location_name'];

    if (file_exists(EVENT_ROOMS_FOLDER . $fname)) {
        file_put_contents(EVENT_ROOMS_FOLDER . $fname, $fdata);
    } else {
        alertDanger("Unexpected file name", false);
    }
}


// If a location file is selected show the contents in a textarea
echo '<div class="row"><div class="col-lg-3"></div>';
echo '<div class="col-lg-9">';
if (isset($_GET['room'])) {
    // get just the basename, remove the extension
    $fn = $_GET['room'];
    $pifn = pathinfo($fn)['filename'];

    if (ctype_alnum($pifn)) {
        echo '<h2>Edit room <code>' . $fn . '</code></h2>';
        echo '<form action=".#manage_locations" enctype="multipart/form-data" method="post">';
        echo '<textarea id="rizemeet_location_edit" name="rizemeet_location_edit" rows="10" class="w-100">' . file_get_contents(EVENT_ROOMS_FOLDER . $fn) . '</textarea>';
        echo '<input type="hidden" name="rizemeet_location_name" value="' . $fn . '">';
        echo '<div class="col-12 text-end mt-2"><button type="submit" class="btn btn-primary">Update</button></div>';
        echo '</form>';
    } else {
        alertDanger("Filename is not valid!", false);
    }
}
echo '</div></div></div>';

// Display form to create a new location/room
echo <<< END
<div class="container mt-3">
 <div class="row">
  <div class="col-12"><h2>Create a new room/meeting location</div>
  <div class="col-md-3 col-lg-6">
   <p>Provide the new room file name.</p>
  </div>
  <div class="col-md-9 col-lg-6">
   <form action=".#manage_locations" enctype="multipart/form-data" method="post">
    <div class="input-group">
     <label for="rizemeet_new_location" class="input-group-text meet_label">File name</label>
     <input type="input" class="form-control" id="rizemeet_new_location" name="rizemeet_new_location" placeholder="letters and digits only">
     <button type="submit" class="btn btn-success">Create</button>
    </div>
    <div class="form-text mb-2">Extension '.json' added automatically.</div>
   </form>
  </div>
 </div>
</div>
END;

// end of sessions content
echo '</div>';

// EOF
