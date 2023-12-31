<?php
// Filename: php/admin/admin_edit_content.php
// Purpose: displays forms to change main page content

namespace frakturmedia\RizeMeet;

$panels = [
    "Introduction" => "introduction_text",
    "Left footer" => "foot_left",
    "Middle footer" => "foot_middle",
    "Right footer" => "foot_right"
];


// for each panel check submission

// for each panel show the form
foreach ( $panels as $ptitle => $pfile ) {
    echo '<form action="." method="post">';
    echo '<div class="container"><div class="row mb-3">';
    echo '<div class="col-lg-3 col-md-12"><h2>' . $ptitle . '</h2></div>';
    echo '<div class="col-md-3 d-lg-none"></div>';
    echo '<div class="col-lg-9 col-md-9"><div class="input-group">';
    echo '<textarea id="rizemeet_' . $pfile . '" class="w-100" name="rizemeet_' . $pfile . '" rows="5">';
    if (file_exists(SITE_PATH . $pfile . '.md')) {
        echo file_get_contents(SITE_PATH . $pfile . '.md');
    }
    echo '</textarea>';
    echo '</div><div class="col-12 text-end"><button type="submit" class="btn btn-primary mt-2">Save</button></div></div>';

    echo '</div></div></form>';
}



// EOF
