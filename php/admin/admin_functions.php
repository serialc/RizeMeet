<?php
// Filename: php/admin/admin_functions.php
// Purpose: Some miscellaneous admin functions

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

function hashPassword($pw)
{
    return password_hash(
        $pw,
        PASSWORD_DEFAULT,
        ['cost' => PASSWORD_HASH_COST]
    );
}

function saveEventDetails($conf)
{
    echo '<div id="regular_event_results" class="col-12">';
    if (file_put_contents(EVENT_DETAILS_FILE, json_encode($conf))) {
        alertSuccess('Update successful', false);
    } else {
        alertDanger('Update failed', false);
    }
    echo '</div>';
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


// https://stackoverflow.com/questions/1334613/how-to-recursively-zip-a-directory-in-php
function ZipFolder($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if (is_dir($source) === true)
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file)
        {
            $file = str_replace('\\', '/', $file);

            // Ignore "." and ".." folders
            if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                continue;

            $file = realpath($file);

            if (is_dir($file) === true)
            {
                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
            }
            else if (is_file($file) === true)
            {
                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
            }
        }
    }
    else if (is_file($source) === true)
    {
        $zip->addFromString(basename($source), file_get_contents($source));
    }

    return $zip->close();
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

function alertPrimary($msg, $container=true)
{ alertMessage($msg, 'primary', $container); }

function checkDatetimeValidity($rdt)
{
    // make sure it's a valid date
    $dt = \DateTime::createFromFormat("Y-m-d", $rdt);
    return $dt !== false && $dt::getLastErrors() === false;
}

function parseFileUploadForErrors($fup)
{
    switch ($fup["error"]) {
    case 0:
        // okay
        return false;
        break;

    case 1:
        alertDanger("File is too large according to <code>upload_max_filesize</code>");
        $file_errors = true;
        break;

    case 2:
        alertDanger("File is too large according to limit specified in form");
        $file_errors = true;
        break;

    case 4:
        alertDanger("No file selected to upload");
        $file_errors = true;
        break;
    }
    return true;
}



// EOF
