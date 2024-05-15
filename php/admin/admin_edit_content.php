<?php
// Filename: php/admin/admin_edit_content.php
// Purpose: displays forms to change main page content

namespace frakturmedia\RizeMeet;

use Yosymfony\Toml\Toml;

echo '<div class="container" id="manage_page"><div class="row"><div class="col"><h1 id="icon_manage_page" class="intico">Page Content</h1></div></div></div>';

echo '<div id="manage_page_content">';

$panels = [
    "Introduction" => "introduction",
    "Left footer" => "foot_left",
    "Middle footer" => "foot_middle",
    "Right footer" => "foot_right",
    "Site configuration" => "site"
];

// for each panel check submission
foreach ( $panels as $ptitle => $pfile ) {
    if (isset($_POST["rmce_" . $pfile])) {

        // the TOML site is different than the others, it's not markdown
        if (strcmp($pfile, "site") === 0) {

            // check validity of submitted TOML file
            try {
                // try parsing - throws exception if it's invalid
                Toml::Parse($_POST['rmce_' . $pfile]);

                // save it as it's parsed successfully
                file_put_contents(SITE_PATH . $pfile . ".toml", $_POST["rmce_" . $pfile]);
            }
            catch (\Exception $e) {
                alertDanger("Site configuration file is invalid - submission rejected");
                alertWarning("The Site configuration file has reverted to last valid version");
            }

        } else {
            file_put_contents(SITE_PATH . $pfile . ".md", $_POST["rmce_" . $pfile]);
        }
    }
}

// for each panel show the form
foreach ( $panels as $ptitle => $pfile ) {
    echo '<form action=".#manage_page" method="post">';
    echo '<div class="container"><div class="row mb-3">';
    echo '<div class="col-lg-3 col-md-12"><h2>' . $ptitle . '</h2></div>';
    echo '<div class="col-md-3 d-lg-none"></div>';
    echo '<div class="col-lg-9 col-md-9"><div class="input-group">';
    echo '<textarea id="rmce_' . $pfile . '" class="w-100" name="rmce_' . $pfile . '" rows="5">';
    if (file_exists(SITE_PATH . $pfile . ".md")) {
        echo file_get_contents(SITE_PATH . $pfile . ".md");
    }
    if (file_exists(SITE_PATH . $pfile . ".toml")) {
        echo file_get_contents(SITE_PATH . $pfile . ".toml");
    }
    echo '</textarea>';
    echo '</div><div class="col-12 text-end"><button type="submit" class="btn btn-primary mt-2">Save</button></div></div>';

    echo '</div></div></form>';
}

// manage_page_content end
echo '</div>';

// EOF
