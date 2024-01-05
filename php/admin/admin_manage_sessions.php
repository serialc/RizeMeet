<?php
// Filename: php/admin/.admin_manage_sessions.php
// Purpose: displays sessions and allows submitting edits

namespace frakturmedia\RizeMeet;

// check that the sessions directory exists
if (!file_exists(SESSIONS_DIR)) { mkdir(SESSIONS_DIR); }


// heading for session management
echo '<div id="manage_sessions" class="container mb-2"><div class="row"><div class="col">' .
     '<h1>Manage Sessions <img id="icon_manage_session" class="intico" src="/imgs/icons/rise.svg"></h1></div></div></div>';

echo '<div id="manage_sessions_content">';

// process new session request
if (isset($_POST['rizemeet_new_session'])) {
    $dt = $_POST['rizemeet_new_session'];

    if (checkDatetimeValidity($dt)) {
        // transform valid date to filename, add markdown extension
        $fn = $dt . '.md';

        if (file_exists(SESSIONS_DIR . $fn)) {
            alertDanger("Session name '" . $fn . "' already exists");
        } else {
            alertSuccess("Session created");
            touch(SESSIONS_DIR . $fn);
        }
    }
}


// List the sessions that exist
$sess = array_diff(scandir(SESSIONS_DIR), array('.', '..'));
echo <<< END
<div class="container"><div class="row">
<div class="col-12"><h2>Edit session</h2></div>
<div class="col-md-3 col-sm-4"><p>Select session to edit.</p></div>
<div class="col-md-9 col-sm-8"><div class="row">
END;

foreach ($sess as $s) {
    echo '<div class="col-md-4 col-sm-6 mb-3"><a href=".?session=' . $s . '#manage_sessions"><button class="btn btn-secondary w-100">' . $s . '</button></a></div>';
}
echo '</div></div></div>';


// process the session content submission
if (isset($_POST['rizemeet_session_edit'])) {
    $fdata = $_POST['rizemeet_session_edit'];
    $fname = $_POST['rizemeet_session_name'];

    if (file_exists(SESSIONS_DIR . $fname)) {
        file_put_contents(SESSIONS_DIR . $fname, $fdata);
    } else {
        alertDanger("Unexpected file name", false);
    }
}


// show the session editing form
echo '<div class="col-12">';
// If a session is selected show the contents in a textarea
if (isset($_GET['session'])) {
    // get just the basename, remove the extension
    $fn = $_GET['session'];
    $pifn = pathinfo($fn)['filename'];

    if (checkDatetimeValidity($pifn)) {
        echo '<h2>Edit session <code>' . $fn . '</code></h2>';
        echo '<form action=".#manage_sessions" enctype="multipart/form-data" method="post">';
        echo '<textarea id="rizemeet_session_edit" name="rizemeet_session_edit" rows="10" class="w-100">' . file_get_contents(SESSIONS_DIR . $fn) . '</textarea>';
        echo '<input type="hidden" name="rizemeet_session_name" value="' . $fn . '">';
        echo '<div class="col-12 text-end mt-2"><button type="submit" class="btn btn-primary">Update</button></div>';
        echo '</form>';
    } else {
        alertDanger("Filename is not valid!", false);
    }
}
echo '</div></div>';


// Display form to create a new session
echo <<< END
<div class="container mt-3">
 <div class="row">
  <div class="col-12"><h2>Create a new session</div>
  <div class="col-md-3 col-lg-6">
   <p>Provide the new session name.</p>
  </div>
  <div class="col-md-9 col-lg-6">
   <form action=".#manage_sessions" enctype="multipart/form-data" method="post">
    <div class="input-group">
     <label for="rizemeet_new_session" class="input-group-text meet_label">Name</label>
     <input type="date" class="form-control" id="rizemeet_new_session" name="rizemeet_new_session">
     <button type="submit" class="btn btn-success">Create</button>
    </div>
    <div class="form-text mb-2">Extension '.md' added automatically</div>
   </form>
  </div>
 </div>
</div>
END;

// end of sessions content
echo '</div>';

// EOF
