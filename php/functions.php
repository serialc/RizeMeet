<?php
// Filename: php/functions.php
// Purpose: Some miscellaneous public functions

namespace frakturmedia\RizeMeet;


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

function determineNextEvent($conf)
{
    // get the requested date
    if (strcmp($conf['rizemeet_date'], '') !== 0) {
        $req_date = new \DateTime($conf['rizemeet_date']);
    }

    // get today's date
    $today = new \DateTime(date('Y-m-d'));
    $is_today = false;

    // if the requested date is in the future, or today, display that
    if (strcmp($conf['rizemeet_date'], '') !== 0 and ($req_date == $today or $req_date > $today)) {
        $event_date = $req_date;
    } else {
        // figure out the next regular date

        // get this month's nth Monday, next month's nth Monday
        $thismonth = (clone $today)->modify($conf['rizemeet_regular']);
        $nextmonth = (clone $today)->modify('first day of next month')->modify($conf['rizemeet_regular']);

        // determine which date is the appropriate/next one (this month's or next month's)
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

// EOF
