<?php
// Filename: php/functions.php
// Purpose: Some miscellaneous public functions

namespace frakturmedia\RizeMeet;

function hashPassword($pw)
{
    return password_hash(
        $pw,
        PASSWORD_DEFAULT,
        ['cost' => PASSWORD_HASH_COST]
    );
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

function determineNextEvent($conf)
{
    // if there's no set date
    $event_date = null;

    // get today's date
    $today = new \DateTime(date('Y-m-d'));
    $is_today = false;

    // if a specific date is requested (not a regular meeting date)
    // check if it's in the future
    if (!empty($conf['rizemeet_date'])) {
        $req_date = new \DateTime($conf['rizemeet_date']);

        // if the requested date is today or in the future, display that
        if (($req_date == $today or $req_date > $today)) {
            $event_date = $req_date;
        }
    }

    if (is_null($event_date) and !empty($conf['rizemeet_regular'])) {
        // no valid requested date 
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

        // debug
        /*
        print($today->format('l, M d, Y'));
        print('<br>');
        print($thismonth->format('l, M d, Y'));
        print('<br>');
        print($nextmonth->format('l, M d, Y'));
        print('<br>');
         */
    }

    // Get the time, or use the default if not set
    $stime = '12:00';
    $etime = '13:00';

    if (!empty($conf['rizemeet_stime'])) {
        $stime = $conf['rizemeet_stime'];
    }
    if (!empty($conf['rizemeet_etime'])) {
        $etime = $conf['rizemeet_etime'];
    }

    // Location - get contents
    if ( !file_exists(EVENT_ROOMS_FOLDER) ) {
        mkdir(EVENT_ROOMS_FOLDER);
    }
    if ( empty($conf['rizemeet_location'])) {
        $loc_contents = array(
            "name" => "To be specified",
            "description" => "Details forthcoming"
        );
    } else {
        $loc_contents = json_decode(file_get_contents(EVENT_ROOMS_FOLDER . $conf['rizemeet_location']), true);
    }

    // format event date for humans
    // l = day of week name
    // M = month name
    // j = day of month number (without leading zero)
    // Y = full year

    if ( is_null($event_date) ) {
        return array(
            "defined" => false,
        );
    }
    return array(
        "defined" => true,
        "date" => $event_date,
        "pretty_date" => $event_date->format('l, M j, Y'),
        "today" => $is_today,
        "stime" => $stime,
        "etime" => $etime,
        "place" => $loc_contents['name'],
        "place_details" => $loc_contents['description'],
        "start_dt" => $event_date->format('Y-m-d') . ' ' . $stime,
        "end_dt" => $event_date->format('Y-m-d') . ' ' . $etime,
    );
}

// EOF
