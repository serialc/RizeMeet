<?php
// Filename: php/unsubscribe_validation.php
// Purpose: Handles request with email and salted hash of email for mailling list unsubscribe

namespace frakturmedia\RizeMeet;

require_once('../php/classes/email_list.php');

echo '<div class="container"><div class="row"><div class="col">';

// so there's no error if someone tests the URL
if ( count($req) < 3 ) {
    echo '<h1>Invalid request</h1>';
    echo '<p>The form of your request is unexpected. Reach out to us to let us know.</p>';
    return;
}

$this_email = $req[1];

// need to decode URLs with special characters
// we can't encode because the rewrite module doesn't like '%' in the URL
// so we do it the harder way
$hashed_email = $req[2];
if ( count($req) > 3 ) {
    // array_splice gets the 2+ indexed items and implodes them
    $hashed_email = implode('/', array_splice($req, 2));
}

// load the mailing list class (tool kit)
$mltk = new MailingList();

// check that passed password is valid and that the salted email is correct
if ( strcmp(filter_var($this_email, FILTER_VALIDATE_EMAIL), $this_email) === 0
    and $mltk->verifyEmail($this_email, $hashed_email) ) {

    // this is a successful validation
    // (this person has permission)
    
    // if already in list
    if ($mltk->exists($this_email)) {
        $mltk->remove($this_email);

        echo '<h1>You have been unsubscribed</h1>';
        echo '<p>Thank you for taking part!</p>';
    } else {
        echo '<h1>Email address not found</h1>';
        echo '<p>Perhaps you have already completed the action?</p>';
    }
} else {
    // this is not a validation of an email address, nor is it a valid email to submit for registration
    echo '<h1>Email invalid</h1>';
    echo '<p>The email address you provided is not valid.</p>';
}

echo '</div></div></div>';

// EOF
