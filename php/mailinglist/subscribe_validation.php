<?php
// Filename: php/subscribe_validation.php
// Purpose: When called URL should contain email and salted hashed email, then do the mailing list work

namespace frakturmedia\RizeMeet;

require_once('../php/classes/mailer.php');
require_once('../php/classes/email_list.php');

// Is there an email and a hashed salted email in the url - a response from the confirmation email?
// something like: http://SERVER_NAME/subscribe/cyrille@digitaltwin.lu/$2y$15......rf9uTX6

echo <<< END
<div class="container">
<div class="row">
<div class="col">
END;

if ( count($req) >= 3 ) {

    // get the data in the URL
    $the_email = $req[1];

    // the provided hashed email may be a lie and need to manually decode
    // URLs with special characters - there may be a slash in the hashed email
    // need to select $req[2+]
    $passed_hashed_email = $req[2];
    if ( count($req) > 3 ) {
        // array_splice gets the 2+ indexed items and implodes them
        $passed_hashed_email = implode('/', array_splice($req, 2));
    }

    // Load mailing list tool kit
    $mltk = new MailingList();

    // check that the email is valid AND
    // validate the hashed passed email to the provided hashed email
    if ( strcmp(filter_var($the_email, FILTER_VALIDATE_EMAIL), $the_email) === 0
        and $mltk->verifyEmail($the_email, $passed_hashed_email) ) {

        // Successful validation

        // Check that the email address is not already in the list
        if ($mltk->exists($the_email)) {
            echo '<h1>You are already registered</h1>';
        } else {
            $mltk->add($the_email);
            echo '<h1>Success</h1>';
            echo '<p>You are now registered to the ' . $site['brand'] . ' mailing list!</p>';
        }

    } else {
        // Failed validation (email not valid or doesn't match hashed version)
        echo '<h1>Error</h1>';
        echo 'Something went wrong trying to verify your email. Let us know.';
    }
} else {
    // this is not a validation of an email address, nor is it a valid email to submit for registration
    echo '<h1>Email invalid</h1>';
    echo '<p>The email address you provided is not valid.</p>';
}

echo '</div></div></div>';


// EOF
