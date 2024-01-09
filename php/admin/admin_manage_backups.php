<?php
// Filename: ../php/admin/admin_manage_backups.php
// Purpose: Creates backups of ../site and also can be used to restore ../site form backup

// display form
echo '<div class="container" id="manage_backup"><div class="row"><div class="col"><h1>Backups <img id="icon_manage_backup" class="intico" src="/imgs/icons/rise.svg"></h1></div></div></div>';

// the container that has visibility toggled
echo '<div id="manage_backup_content">';

// processing
if (isset($_POST['create_archive'])) {

    // create backup directory if possible
    if (!file_exists(BACKUP_DIR)) {
        if (!is_writable('..')) {
            alertDanger("Permission to create backup directory is denied");
            return;
        } 
        mkdir(BACKUP_DIR);
    }
    if (!is_writable(BACKUP_DIR)) {
        alertDanger("Permission to write to backup directory is denied");
        return;
    }

    $zfn = $site['brand'] . '_' . date('Y-m-d') . '.zip';
    $zf = ZipFolder(SITE_PATH, BACKUP_DIR . $zfn);

    if ($zf) {
        alertSuccess("Site backup ready for <a href=\"./?download=latest\">download</a>");
    } else {
        alertDanger("Failed to compress site data");
    }
}

if (isset($_FILES['uploaded_backup_file'])) {
    $fup = $_FILES["uploaded_backup_file"];

    $file_errors = parseFileUploadForErrors($fup);

    // clean up the filename (remove spaces)
    $filename = str_replace(' ', '_', $fup['name']);
    $filepath = $fup['tmp_name'];
    $filesize = filesize($filepath);

    // errors
    // was a file actually uploaded
    if ( $filesize === 0 ) {
        alertDanger("No file selected to upload");
        $file_errors = true;
    }

    if (!$file_errors) {
        $zip = new ZipArchive;
        if ($zip->open($filepath) === TRUE) {

            // reset the site - delete contents of SITE_PATH and WWW_SITE_IMAGES_FOLDER
            clearSite();

            // extract the zip files to the SITE_PATH
            $zip->extractTo(SITE_PATH);
            $zip->close();

            // if there's an images folder
            if (file_exists(SITE_IMAGES_FOLDER)) {
                // Copy images from SITE_IMAGES_FOLDER to WWW_SITE_IMAGES_FOLDER
                $rscs = array_diff(scandir(SITE_IMAGES_FOLDER), array('.', '..'));

                // only specified file types are allowed to be copied to WWW_SITE_IMAGES_FOLDER
                $allowed_ft = array("png", "gif", "svg", "jpg");

                foreach ($rscs as $rsc) {
                    $fext = pathinfo($rsc, PATHINFO_EXTENSION);
                    if (!in_array($fext, $allowed_ft)) {
                        alertWarning("The file <b>$rsc</b> is not valid. Only the following types are allowed: <b>" . implode(', ', $allowed_ft) . "</b>");
                        unlink(SITE_IMAGES_FOLDER . $rsc);
                    } else {
                        copy(SITE_IMAGES_FOLDER . $rsc, WWW_SITE_IMAGES_FOLDER . $rsc);
                    }
                }
            }

            // success message
            alertSuccess("File uploaded and extracted successfully. <a href=\"http://" . $_SERVER['SERVER_NAME'] . "/admin\">Refresh to see changes</a>");
        } else {
            alertDanger("Failed to extract the uploaded file");
        }
    } else {
        alertDanger("Failed to save the uploaded file");
    }
}

// show forms
echo <<< END
<form action=".#manage_backup" method="post">
 <div class="container">
  <div class="row">
   <div class="col-12"><h2>Create backup</h2></div>
   <div class="col-lg-6 col-md-12">
    <p>This will generate a zip file with your customized content inside.</p>
   </div>
   <div class="col-md-3 d-lg-none"></div>
   <div class="col-lg-6 col-md-9 text-end">
    <input type="hidden" name="create_archive" value="1">
    <button type="submit" class="btn btn-primary mt-2">Create backup</button>
   </div>
  </div>
 </div>
</form>
END;

echo <<< END
<form action=".#manage_backup" enctype="multipart/form-data" method="post">
 <div class="container">
  <div class="row">
   <div class="col-12"><h2>Load backup</h2></div>
   <div class="col-lg-6 col-md-12">
    <p>Upload a past archive (backup) to initialize or overwrite existing site.</p>
   </div>
   <div class="col-md-3 d-lg-none"></div>
   <div class="col-lg-6 col-md-9 text-end">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000">
    <div class="input-group">
     <input class="form-control" type="file" name="uploaded_backup_file">
     <input type="submit" class="btn btn-danger" value="Upload">
    </div><div class="form-text mb-2">Server settings: <code>upload_max_filesize</code> = 2M, <code>post_max_size</code> = 8M</div></form>
   </div>
  </div>
 </div>
</form>
END;
// end of container that has visibility toggled
echo '</div>';

// EOF
