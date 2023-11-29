<?php
// Filename: template_config.php
// Purpose: Serve as a generalized template to copy
// to php/config.php if it doesn't exist

namespace frakturmedia\RizeMeet;

// Define email parameters
define('EMAIL_HOST', 'smtp.example.com');
define('EMAIL_SENDER', 'user@example.com');
define('EMAIL_REPLYTO', 'info@example.com');
define('EMAIL_REPLYTONAME', 'Mailer name');
define('EMAIL_PASSWORD', 'password');
define('EMAIL_PORT', 465);

// Define if production or development
define('SERVER_IS_PRODUCTION', FALSE);

// EOF
