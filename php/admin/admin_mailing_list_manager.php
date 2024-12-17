<?php
// Filename: php/emailing_list.php
// Purpose: show controls for e-mail list

namespace frakturmedia\RizeMeet;

use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

require_once('../php/classes/email_list.php');

// get the list of emailing list
$maillist = new MailingList();

// open the form
echo '<div class="container mt-2">
    <form action=".#contacts_mailing_list" method="post">
        <div class="row">
            <div class="col-12 mt-2"><h1 id="contacts_mailing_list">Contacts mailing list</h1></div>';


// process the email text, send it to the mailing list
if (isset($_POST['rizemeet_email_text'])) {
    echo '<div class="col-12">';

    $calendar_invite_type = false;
    if ( isset($_POST['calendar_invite_type']) ) {
        $calendar_invite_type = $_POST['calendar_invite_type'];
    }

    // get the salf file for deregistration/unsubscription
    $sfc = file_get_contents(ADMIN_SALT_FILE);

    // prep the calendar information if needed
    // variables created here are used again in the email address loop
    switch ($calendar_invite_type)
    {
    case "new":
        // Create calendar invite/ICS
        // generate a unique code for the calendar event
        $unique_event_identifier_obj = new UniqueIdentifier($site['brand'] . '_' . $next_event['start_dt'] . '_' . uniqid());

        // save it (will convert object to string) - add second line with sequence integer
        // SEQUENCE starts at 0
        // unique id of calendar event is on first line, SEQUENCE on the second
        file_put_contents(SITE_LAST_EVENT_ID, $unique_event_identifier_obj . "\n0");
        break;

    case "update":
        // create an invite with the old id, increment to SEQUENCE
        // unique id of calendar event is on first line, SEQUENCE on the second
        $ueio_parts = explode("\n", file_get_contents(SITE_LAST_EVENT_ID));
        $unique_event_identifier_obj = new UniqueIdentifier( $ueio_parts[0] );
        $sequence_num = $ueio_parts[1] + 1;

        // save updated sequence
        // unique id of calendar event is on first line, SEQUENCE on the second
        file_put_contents(SITE_LAST_EVENT_ID, $ueio_parts[0] . "\n" . $sequence_num);
        break;
    }

    $sent_count = 0;

    // send the emails
    foreach( $maillist->getList() as $email_address ) {
        // create hashed email
        $hashedemail = hashPassword($sfc . $email_address);
        $unsuburl = 'http://' . $_SERVER['SERVER_NAME'] . '/unsubscribe_validation/' . $email_address. '/' . $hashedemail;

        $email = new Mail();

        // send calendar invitation as selected
        switch ($calendar_invite_type)
        {
        case "none":
            // do nothing
            break;

        case "new":
            // create a new ical invitation for a specific email address
            $ical_content = createIcalContent($unique_event_identifier_obj, $next_event['start_dt'], $next_event['end_dt'], $site['brand'] . ' meeting', $conf['rizemeet_meeting_topic'], $next_event['place'], $email_address, 0);

            // attach ical event 
            $email->addStringAttachment($ical_content);
            break;

        case "update":
            // update ical invitation for a specific email address, with new SEQUENCE value
            $ical_content = createIcalContent($unique_event_identifier_obj, $next_event['start_dt'], $next_event['end_dt'], $site['brand'] . ' meeting', $conf['rizemeet_meeting_topic'], $next_event['place'], $email_address, $sequence_num);

            // attach ical event 
            $email->addStringAttachment($ical_content);
            break;
        }

        // select Parsedown from the global namespace
        $parsedown = new \Parsedown();

        // Build up the email content
        $ehtml = '<html><body>' . $parsedown->text($_POST['rizemeet_email_text']);

        // add deregister text at footer
        $ehtml .= '<p><a href="https://' . $_SERVER['SERVER_NAME'] . '">Visit the website</a> for more information.</p>';
        $ehtml .= '<p>To unsubscribe <a href="' . $unsuburl . '">click here</a> or visit the link ' . $unsuburl . '</p></body></html>';

        if( $email->send($email_address, $site['brand'] . ' member', $site['brand'] . ' news', $ehtml, strip_tags($ehtml)) ) {
            $sent_count += 1;
        } else {
            alertDanger('Failed to send message to ' . $email_address, false);
        }
    }

    // show count of emails successfully sent
    alertSuccess('Emails sent: ' . $sent_count, false);

    // close the col and row
    echo '</div>';
}

echo '<div class="col-lg-3 col-md-12"><p class="text-primary mb-1">Members on the mailing list: <b>' . $maillist->count() . '</b></p></div>';

echo '<div class="col-lg-9 col-md-12">' .
       '<textarea id="rizemeet_email_text" name="rizemeet_email_text" rows="10" class="w-100">' . 
        'Dear ' . $site['brand'] . " subscriber,\n\n";


// Create the template text for the email to send out
if ($next_event['defined']) {
    echo 'The next ' . $site['brand'] . ' meet-up is on **' . $next_event['pretty_date'] . ' at ' . $next_event['stime'] . ' - ' . $next_event['etime'] . '**.' . "\n\n";
} else {
    echo 'Next event date is not defined';
}

echo 'The topic(s) for discussion are:  ' . "\n";

echo $conf['rizemeet_meeting_topic'];

echo "\n\n" . 'The meeting will take place here:  ' . "\n";

// if the $conf is set and a corresponding location file exists
if ( isset($conf['rizemeet_location']) and strcmp($conf['rizemeet_location'], "") !== 0 and file_exists(EVENT_ROOMS_FOLDER . $conf['rizemeet_location']) ) {
    $loc_file = json_decode(file_get_contents(EVENT_ROOMS_FOLDER . $conf['rizemeet_location']), true);
    echo $loc_file['description'];
} else {
    echo 'No location set yet' . "\n";
}

echo <<< END
                </textarea>

                <div class="btn-group pt-2 input-group" role="group">
                    <label class="input-group-text" for="cit_none">Send calendar invitation type</label>

                    <input class="btn-check" type="radio" name="calendar_invite_type" id="cit_none" value="none" checked>
                    <label class="btn btn-outline-primary" for="cit_none">None</label>

                    <input class="btn-check" type="radio" name="calendar_invite_type" id="cit_new" value="new">
                    <label class="btn btn-outline-primary" for="cit_new">New</label>

                    <input class="btn-check" type="radio" name="calendar_invite_type" id="cit_update" value="update" disabled>
                    <label class="btn btn-outline-primary" for="cit_update">Update</label>
                </div>

            </div>

            <div class="col-12 text-end mt-2">
                <button type="submit" class="btn btn-primary">Send emails</button>
            </div>
        </div>
    </form>
</div>
END;
