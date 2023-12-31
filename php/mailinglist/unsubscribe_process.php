<?php
// Filename: php/mailinglist/unsubscribe_form_process.php
// Purpose: process request. Check if name is on mailing list, if so send email

namespace frakturmedia\rizemeet;

require_once('../php/classes/mailer.php');
require_once('../php/classes/email_list.php');

// is an email address sent and is it valid
if (isset($_POST['unsub_email']) and filter_var($_POST['unsub_email'], FILTER_VALIDATE_EMAIL)) {

    // mailling list toolkit
    $mltk = new MailingList();

    $the_email = $_POST['unsub_email'];

    // check if email is in mailing list
    if ($mltk->exists($the_email)) {
        // Send an email with the unsubscribe link
        $encryptedmail = $mltk->saltAndHash($the_email);
        $unsuburl = 'http://' . $_SERVER['SERVER_NAME'] . '/unsubscribe_validation/' . $the_email . '/' . $encryptedmail;

        // send an email
        $email = new Mail();

        $ehtml = '<h1>' . $site['brand'] . ' unsubscribe request</h1>' . "\n";
        $ehtml .= '<p><a href="' . $unsuburl . '">Unsubscribe from ' . $site['brand'] . '</a>.</p>' . "\n";
        $ehtml .= $unsuburl;

        if( !$email->send($the_email, '', $site['brand'] . ' unsubscribe', $ehtml, strip_tags($ehtml)) ) {
            echo '<h1>Failed to send the email for unsubscribing!</h1>';
            echo '<p>You did everything correctly but I was unable to send you your unsubscribe email.</p>';
            return;
        }
    } 

    echo <<< END
        <h1>Unsubscribe requested</h1>
        <p>A message has been sent to your email address with an unsubscribe link.</p>
        <p>Click the link in the email to finish unsubscription.</p>
    END;
}

