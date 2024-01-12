<?php
// Filename: php/admin/.admin_images_manager.php.php
// Purpose: Upload of images to two locations: site/images/ and  www/imgs/site/

namespace frakturmedia\RizeMeet;

echo <<< END
<div id="manage_images" class="container">
 <div class="row">
  <div class="col-12">
   <h1>
    Images 
    <img id="icon_manage_images" class="intico" src="/imgs/icons/rise.svg">
   </h1>
  </div>
 </div>
</div>
END;

echo '<div id="manage_images_content">';

// check if the necessary folders exist, create them if not
if (!file_exists(SITE_IMAGES_FOLDER)) {
    // a copy is stored on the site folder - for backup
    mkdir(SITE_IMAGES_FOLDER);
}
if (!file_exists(WWW_SITE_IMAGES_FOLDER)) {
    // this is the 'live' version of the image
    mkdir(WWW_SITE_IMAGES_FOLDER);
}


// validate / check uploaded files
if (isset($_FILES["uploaded_file"])) {
    $fup = $_FILES["uploaded_file"];

    $file_errors = parseFileUploadForErrors($fup);

    // clean up the filename (remove spaces)
    $filename = str_replace(' ', '_', $fup['name']);
    $fext = pathinfo($filename, PATHINFO_EXTENSION);
    $filepath = $fup['tmp_name'];
    $filesize = filesize($filepath);

    // Errors
    // Is it a valid file type
    if (!in_array($fext, ALLOWED_UPLOAD_FILE_TYPES)) {
        alertDanger("File type is not valid. Only the following types are allowed: <b>" . implode(', ', ALLOWED_UPLOAD_FILE_TYPES) . "</b>");
        $file_errors = true;
    }

    // was a file actually uploaded
    if ( $filesize === 0 ) {
        alertDanger("No file selected to upload");
        $file_errors = true;
    }

    // warnings
    if ( $filesize > 2000000 ) {
        alertWarning("That's a rather large file - but okay");
    }

    if (!$file_errors) {
        if( move_uploaded_file($filepath, SITE_IMAGES_FOLDER . $filename) ) {
            alertSuccess("File uploaded successfully");

            // copy the file to the www/live directory
            copy(SITE_IMAGES_FOLDER . $filename, WWW_SITE_IMAGES_FOLDER . $filename);
        } else {
            alertDanger("Failed to save the uploaded file");
        }
    }
}


// Show the upload form
echo <<< END
<div id="upload_images" class="container">
 <div class="row">
  <div class="col-12"><h2>Upload an image or resource</h2></div>
  <div class="col-lg-6">
   <p>Refer to your uploaded images as being in the <code>/imgs/site/</code> directory.</p>
  </div>

  <div class="d-lg-none col-md-3"></div>
  <div class="col-lg-6 col-md-9">
   <form action=".#manage_images" enctype="multipart/form-data" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
    <div class="input-group">
     <input class="form-control" type="file" name="uploaded_file">
     <input type="submit" class="btn btn-success" value="Upload">
    </div>
END;
echo '<div class="form-text mb-2">Server settings: ' .
    '<code>upload_max_filesize</code> = ' . ini_get('upload_max_filesize') . ', ' .
    '<code>post_max_size</code> = ' . ini_get('post_max_size') . '</div>';
echo '</form> </div> </div> </div>';

// get list of imgs/rscs
$rscs = array_diff(scandir(WWW_SITE_IMAGES_FOLDER), array('.', '..'));

// validate / file deletion
if (isset($_POST['delete_rscs'])) {
    // check each value agains list of resources
    foreach ($_POST as $rsc_id => $val) {
        if (strcmp($val, "") !== 0) {
            // if there's a match delete it from the two resource locations
            if (in_array($val, $rscs)) {
                unlink(SITE_IMAGES_FOLDER . $val);
                unlink(WWW_SITE_IMAGES_FOLDER . $val);
            }
        }
    }
    // update list of files as some files may have been deleted
    $rscs = array_diff(scandir(WWW_SITE_IMAGES_FOLDER), array('.', '..'));
}

// list the images that are uploaded
echo '<form action=".#manage_images" enctype="multipart/form-data" method="post">';
echo '<div class="container"><div class="row"><div class="col-12 mt-3 mb-2"><h2>Images uploaded</h2></div>';

// list rscs so that they can be deleted if wished
$rsc_index = 0;
foreach ($rscs as $rsc) {
    echo '<div class="col-6 col-md-4 col-lg-3 col-xl-2">' .
        '<input type="checkbox" class="form-check-input file-selection" id="rsc_' . $rsc_index . '" name="rsc_' . $rsc_index. '" value="' . $rsc . '">' .
        '<label class="form-check-label w-100 file-selection-label" for="rsc_' . $rsc_index . '">' . 
        '<img src="/' . WWW_SITE_IMAGES_FOLDER . $rsc . '" width="100%" height="50" style="object-fit:cover;"></label>' .
        '<br><div onclick="RM.copyToClipboard(\'/' . WWW_SITE_IMAGES_FOLDER . $rsc . '\')" class="btn ps-0 w-100" title="Click to copy path">' . $rsc . '</div></div>';
    $rsc_index += 1;
}

echo '<div class="col-12 text-end">' .
    '<input type="hidden" name="delete_rscs">' .
    '<button type="submit" class="btn btn-danger">Delete selected</button>' .
    '</div>';
echo '</div></div>';
echo '</form>';

// end of manages_images_content
echo '</div>';

// EOF
