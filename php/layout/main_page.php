<div class="container">
    <div class="row align-items-md-stretch">

        <div class="col-md-6">
            <div class="h-100 p-5 text-bg-dark rounded-3">

<?php
if (file_exists(SITE_PATH . 'introduction.md')) {
    echo $parsedown->text(file_get_contents(SITE_PATH . 'introduction.md'));
} else {
    echo '<h4>Customize ' . SITE_PATH . 'introduction.md</h4>';
}
?>
            </div>
        </div>

        <div id='event_date' class="col-md-6">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2>Next event</h2>
                <p class="fs-4 text-warning">

<?php
echo $next_event['pretty_date'] . '<br>' . $next_event['stime'] . ' - ' . $next_event['etime'] . '</p>';
?>

                        <h3>Location</h3>

<?php
// show the location based on $conf
if ( isset($conf['porg_location']) and file_exists(EVENT_ROOMS_FOLDER . $conf['porg_location'])) {
    $room = json_decode(file_get_contents(EVENT_ROOMS_FOLDER . $conf['porg_location']), true);
    echo $parsedown->text($room['description']);
} else {
    echo 'No location set yet';
}
?>

                        <h3 class="mt-5">Next meeting topic</h3>
                        <div>

<?php
// show the suggested next meeting topics
if ( $conf['porg_meeting_topic'] ) {
    echo $parsedown->text($conf['porg_meeting_topic']);
} else {
    echo 'Free form discussion';
}
?>

            </div>
        </div>

    </div>
</div>
