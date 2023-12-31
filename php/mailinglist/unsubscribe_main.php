<?php
// Filename: php/mailinglist/unsubscribe_page.php
// Purpose: either show form or process form

if (count($req) != 2) {
    return;
}

echo '<div class="container"><div class="row"><div class="col">';

switch ($req[1]) {
case 'form':
    include '../php/mailinglist/unsubscribe_form.php';
    break;

case 'process':
    include '../php/mailinglist/unsubscribe_process.php';
    break;

default:
    echo 'Unexpected request';
}

echo '</div></div></div>';

// EOF
