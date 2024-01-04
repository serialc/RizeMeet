<?php
// Filename: php/functions.php
// Purpose: Some miscellaneous functions

namespace frakturmedia\RizeMeet;

use Eluceo\iCal\Domain\Entity\Event;
use Eluceo\iCal\Domain\ValueObject\UniqueIdentifier;

use Eluceo\iCal\Domain\ValueObject\Timestamp;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Uri;

use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\GeographicPosition;

use Eluceo\iCal\Domain\ValueObject\Organizer;
use Eluceo\iCal\Domain\ValueObject\EmailAddress;

use Eluceo\iCal\Domain\Entity\Calendar;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;

function createIcalContent ($start, $end, $name, $description, $location, $dest_email ) {

    // create the event with a unique identifier
    $event = (new Event( new UniqueIdentifier($_SERVER['SERVER_NAME'])))
        ->touch(new Timestamp())
        ->setSummary($name)
        ->setDescription($description)
        ->setOccurrence(
            new TimeSpan(
                new DateTime(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $start), false),
                new DateTime(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $end), false)
            )
        )
        ->setUrl( new Uri('https://' . $_SERVER['SERVER_NAME']))
        ->setLocation( 
            (new Location($location))
                ->withGeographicPosition(new GeographicPosition(49.504558,5.9464613))
        )
        ->setOrganizer(
            new Organizer(
                new EmailAddress(EMAIL_REPLYTO),
                'PORG'
            )
        );

    $calendar = new Calendar([$event]);
    $ical_content = (new CalendarFactory())->createCalendar($calendar);
    return (string) $ical_content;
}

function loadEventDetails() {
    if (file_exists(EVENT_DETAILS_FILE)) {
        return json_decode(file_get_contents(EVENT_DETAILS_FILE), true);
    }
    return [
        "rizemeet_date" => "",
        "rizemeet_stime" => "",
        "rizemeet_etime" => "",
        "rizemeet_location" => "",
        "rizemeet_meeting_topic" => "",
        "rizemeet_regular" => "second Monday of this month"
    ];
}

// https://stackoverflow.com/questions/4356289/php-random-string-generator
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

function hashPassword($pw)
{
    return password_hash(
        $pw,
        PASSWORD_DEFAULT,
        ['cost' => PASSWORD_HASH_COST]
    );
}

function determineNextEvent($conf)
{
    // get the requested date
    if (strcmp($conf['rizemeet_date'], '') !== 0) {
        $req_date = new \DateTime($conf['rizemeet_date']);
    }

    // get today's date
    $today = new \DateTime(date('Y-m-d'));

    // if the requested date is in the future, or today, display that
    if (strcmp($conf['rizemeet_date'], '') !== 0 and ($req_date == $today or $req_date > $today)) {
        $event_date = $req_date;
    } else {
        // figure out the next regular date

        // get this month's nth Monday, next month's nth Monday
        $thismonth = (clone $today)->modify($conf['rizemeet_regular']);
        $nextmonth = (clone $today)->modify('first day of next month')->modify($conf['rizemeet_regular']);

        // determine which date is the appropriate/next one (this month's or next month's)
        $is_today = false;

        if ($today < $thismonth) {
            $event_date = $thismonth;
        } elseif ($today == $thismonth) {
            $is_today = true;
            $event_date = $thismonth;
        } else {
            $event_date = $nextmonth;
        }
    }

    // debug
    /*
    print($today->format('l, M d, Y'));
    print('<br>');
    print($thismonth->format('l, M d, Y'));
    print('<br>');
    print($nextmonth->format('l, M d, Y'));
    print('<br>');
     */

    // Get the time, or use the default if not set
    $stime = '12:00';
    $etime = '13:00';

    if (strcmp($conf['rizemeet_stime'], '') !== 0) {
        $stime = $conf['rizemeet_stime'];
    }
    if (strcmp($conf['rizemeet_etime'], '') !== 0) {
        $etime = $conf['rizemeet_etime'];
    }

    // format event date for humans
    // l = day of week name
    // M = month name
    // j = day of month number (without leading zero)
    // Y = full year

    return array(
        "date" => $event_date,
        "pretty_date" => $event_date->format('l, M j, Y'),
        "today" => $is_today,
        "stime" => $stime,
        "etime" => $etime,
        "place" => $conf['rizemeet_location'],
        "start_dt" => $event_date->format('Y-m-d') . ' ' . $stime,
        "end_dt" => $event_date->format('Y-m-d') . ' ' . $etime,
    );
}

function saveEventDetails($conf)
{
    echo '<div id="regular_event_results" class="col-12">';
    if (file_put_contents(EVENT_DETAILS_FILE, json_encode($conf))) {
        echo '<div class="alert alert-success mt-3" role="alert">Update successful</div>';
    } else {
        echo '<div class="alert alert-danger mt-3" role="alert">Failed to update</div>';
    }
    echo '</div>';
}

function alertMessage($msg, $type, $container)
{
    if ($container) {
        echo '<div class="container mt-3"><div class="row">';
    }
    echo '<div class="col"><div class="alert alert-' . $type . '" role="alert">' . $msg. '</div></div>';
    if ($container) {
        echo '</div></div>';
    }
}

function alertDanger($msg, $container=true)
{ alertMessage($msg, 'danger', $container); }

function alertWarning($msg, $container=true)
{ alertMessage($msg, 'warning', $container); }

function alertSuccess($msg, $container=true)
{ alertMessage($msg, 'success', $container); }

function alertPrimary($msg, $container)
{ alertMessage($msg, 'primary', $container); }

function checkDatetimeValidity($rdt)
{
    // make sure it's a valid date
    $dt = \DateTime::createFromFormat("Y-m-d", $rdt);
    return $dt !== false && $dt::getLastErrors() === false;
}

// EOF
