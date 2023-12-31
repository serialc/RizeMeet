<?php
// Filename: php/subscribe_process.php
// Purpose: Handles mailing list subscribe form processing (and sends an email)

namespace frakturmedia\RizeMeet;

require_once('../php/classes/mailer.php');
require_once('../php/classes/email_list.php');

echo <<< END
    <div class="container">
        <div class="row">
            <div class="col">
END;

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
    $text = $site['brand'] . " mailing list registration request\n";
    $text .= "======================================\n";

    // check if new email is already in mailing list 
    // customize content of email
    if ($eml->exists($newmailaddress)) {
        // Don't want to give away that this email is already in ML to prevent people trying to fish out emails
        // We'll send them an email with different content but
        // we do not want to indicate anything differently on the webpage
        $html .= '<p>You are already registered for the mailing list. If you did not request this, just ignore the message.</p>';
        $text .= "You are already registered for the mailing list. If you did not request this, just ignore the message\n";
    } else {
        // send the email with a link that contains both, their email address and the email in encrypted form
        // the link containing:
        // - The email address
        // - The encyrpted email address, using the salt
        $encryptedmail = $eml->saltAndHash($newmailaddress);
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/subscribe_validation/' . $newmailaddress . '/' . $encryptedmail;

        // Add consent text - e.g. By clicking the link below you consent to ....
        $consent = "By clicking on the link above you consent to the following. \n";
        $consent .= 'To ' . $site['brand'] . ' having your personal information (your email address) for the unique purpose of managing the mailing list. ' . "\n";
        $consent .= $site['brand'] . ' keeps your personal information, meaning your email, for its own use and will not transfer your data to any other entity outside the organization. ' . "\n";
        $consent .= 'Your personal information shall be kept by ' . $site['brand'] . ' for two years from the last email you have been sent, or until you unsubscribe. ' . "\n";
        $consent .= 'If ' . $site['brand'] . ' ceases to be active for two years, your personal information will be deleted. You have the following rights for your personal information: right of access at any time to all your personal information processed by ' . $site['brand'] . ', right to rectification of your personal information, right to erasure, right to withdraw your consent at any time, right to lodge a complaint with your appropriate data protection agency. To exercise your rights, please see the bottom of any ' . $site['brand'] . ' email, the website, or send us an email at: ' . $site['contact_email'] . "\n";


        // create the email content
        $html .= '<p>Please click the <a href="' . $url . '">link</a> to confirm your registration to ' . $site['brand'] . '.<br>';
        $html .= 'By clicking the link you consent to your email being stored by ' . $site['brand'] . '.' . "\n" .
            'See below for more details on consent and your rights.</p>';
        $text .= "Please visit the link (' . $url . ') to confirm your registration to " . $site['brand'] . ' mailing list registration request. ' . "\n";
        $text .= 'By clicking the link you consent to your email being stored by ' . $site['brand'] . '.' . "\n" .
            'See below for more details on consent and your rights.';

        $html .= '<h2>Consent</h2>' . nl2br($consent);
        $text .= "## Consent\n" . $consent;
    }
        
    // try sending it
    $email = new Mail();
    if (!$email->send($newmailaddress, 'New subscriber', $site['brand'] . ' mailing list registration', $html, $text)) {
        echo '<h1>Error</h1>';
        echo '<p>We failed to send you an email to confirm your registration.</p>';
        echo '<p>This may be our fault. If you think so too, let us know.</p>';
        return;
    } else {
        echo '<h1>Email confirmation sent</h1>';
        echo '<p>An email is being sent to you to confirm your registration.</p>';
    }
}

echo '</div></div></div>';

// EOF
