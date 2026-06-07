<?php
define('APP_NAME', 'ClinicDesk');
define('BASE_URL', 'http://localhost/clinicdesk');
define('ITEMS_PER_PAGE', 10);
define('MAX_AVATAR_SIZE', 1048576);    // 1MB
define('MAX_PDF_SIZE', 3145728);       // 3MB

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

session_start();

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);
