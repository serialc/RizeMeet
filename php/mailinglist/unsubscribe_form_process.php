<?php
// Filename: php/layout/unsubscribe/.unsubscribe_form_process.php
// Purpose: process request. Check if name is on mailing list, if so send email

namespace frakturmedia\porg;

require_once('../php/classes/mailer.php');
require_once('../php/classes/email_list.php');

// is an email address sent and is it valid
if (isset($_POST['reg_email']) and filter_var($_POST['reg_email'], FILTER_VALIDATE_EMAIL)) {

// check if email is in mailing list
