<?php
// Filename: php/admin/admin_manage_styling.php
// Purpose: displays forms to edit custom CSS

namespace frakturmedia\RizeMeet;


// generate the css from the template if it doesn't exist
if (!file_exists(SITE_CUSTOM_CSS)) {
    copy(CUSTOM_CSS_TEMPLATE, SITE_CUSTOM_CSS);
    copy(SITE_CUSTOM_CSS, WWW_SITE_CUSTOM_CSS);
}

// process the form
if (isset($_POST["css_styling"])) {
    file_put_contents(SITE_CUSTOM_CSS, $_POST["css_styling"]);
    copy(SITE_CUSTOM_CSS, WWW_SITE_CUSTOM_CSS);
}

echo '<div class="container" id="manage_style"><div class="row"><div class="col">';
echo '<h1 id="icon_manage_style" class="intico">Styling</h1></div></div></div>';

echo '<div id="manage_style_content">';

echo <<< END
<form action=".#manage_style" method="post">
<div class="container"><div class="row mb-3">
<div class="col-lg-4 col-md-12">
    <h2>Edit the site's CSS</h2>
    <p>Refresh your browser cache to see changes (Ctrl-Shift-R)</p>
</div>
<div class="col-lg-8 col-md-12"><div class="input-group">
<textarea id="css_styling" class="w-100" name="css_styling" rows="5">
END;

if (file_exists(SITE_CUSTOM_CSS)) {
    echo file_get_contents(SITE_CUSTOM_CSS);
}
echo <<< END
</textarea>
</div><div class="col-12 text-end"><button type="submit" class="btn btn-primary mt-2">Save</button></div></div>
</div></div></form>
END;


// end of styling content
echo '</div>';


// EOF
