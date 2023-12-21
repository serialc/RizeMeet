<?php
// Filename: php/register.php
// Purpose: Handles submission of email address and validation

namespace frakturmedia\RizeMeet;

require_once('../php/classes/mailer.php');
require_once('../php/classes/email_list.php');

echo '<div class="container">';

// is an email address sent and is it valid
if (isset($_POST['reg_email']) and filter_var($_POST['reg_email'], FILTER_VALIDATE_EMAIL)) {
    $newmailaddress = $_POST['reg_email'];

    # check if email is already in mailing list
    # - if so and verified, just say 'added'
    # - if in but not verified, send 'regular' message regarding email confirmation
    # - if not in mailing list, add to mailing list but unverified, and send message regarding email verification

    // read registered emails
    // get the list of emailing list
    $eml = new MailingList();

    // start building the email content
    $html = '<h1>' . $site['brand'] . ' mailing list registration request</h1>';
    $text = $site['brand'] . "mailing list registration request\n";
    $text .= "======================================\n";

    // check if new email is already in mailing list 
    if ($eml->exists($newmailaddress)) {
        // Don't want to give away that it is to prevent people trying to fish out emails
        // We'll send them an email with different content but
        // we do not want to indicate anything differently on the webpage
        $html .= '<p>You are already registered for the mailing list.</p>';
        $text .= "You are already registered for the mailing list.\n";
    } else {
        // send the email with a link that contains both, their email address and the email in encrypted form
        // the link containing:
        // - The email address
        // - The encyrpted email address, using the salt
        $encryptedmail = $eml->saltAndHash($newmailaddress);
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/register/' . $newmailaddress . '/' . $encryptedmail;

        // Add consent text - e.g. By clicking the link below you consent to ....
        $consent = $site['brand'] . ' collects personal information, based on your consent, for the unique purpose of managing the mailing list. ';
        $consent .= $site['brand'] . ' keeps your personal information, meaning your email, for its own use and ensure not to transfer your data to any other entity outside the organization. ';
        $consent .= 'Your personal information shall be kept by ' . $site['brand'] . ' two years from the last email you have been sent, or until you unsubscribe. ';
        $consent .= 'If ' . $site['brand'] . ' ceases to be active for two years, your personal information shall be deleted. You have the following rights on your personal information: right of access at any time to all your personal information processed by ' . $site['brand'] . ', right to rectification of your personal information, right to erasure, right to withdraw your consent at any time, right to lodge a complaint with your appropriate data protection agency. To exercise your rights, please see the bottom of any ' . $site['brand'] . ' email, the website, or send us an email at: ' . $site['contact_email'];

        $html .= '';
        $text .= '';

        // create the email content
        $html .= '<p>Please click the <a href="' . $url . '">link</a> to confirm your registration to ' . $site['brand'] . '.</p>';
        $text .= "Please visit the link (' . $url . ') to confirm your registration to " . $site['brand'] . ' mailing list registration request', $html, $text) ) {
        echo '<h1>Email confirmation sent</h1>';
        echo '<p>An email is being sent to you to confirm your registration.</p>';
    } else {
        echo '<h1>Error</h1>';
        echo '<p>We failed to send you an email to confirm your registration.</p>';
        echo '<p>This may be our fault. If you think so, let us know.</p>';
    }
} else {
    // no valid email is submitted

    // Is there an email and a hashed salted email in the url - a response from the confirmation email?
    // something like: http://SERVER_NAME/register/cyrille@digitaltwin.lu/$2y$15......rf9uTX6
    if ( count($req) >= 3 ) {
        $the_email = $req[1];

        // Get the mailing list
        $eml = new MailingList();
        $hashed_email = $eml->saltAndHash($the_email);

        // get the provided hashed email in the URL (may be a lie)
        // need to decode URLs with special characters
        $passed_hashed_email = urldecode($req[2]);

        // check that the email is valid AND
        // validate the hashed passed email to the provided hashed email
        if ( strcmp(filter_var($the_email, FILTER_VALIDATE_EMAIL), $the_email) === 0
            and password_verify($passed_hashed_email, $hashed_email) ) {
            // Successful validation

            // Check that the email address is not already in the list
            if ($eml->exists($the_email)) {
                echo '<h1>You are already registered</h1>';
            } else {
                $eml->add($the_email);
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
}

echo '</div>';

// EOF
