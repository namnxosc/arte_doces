<?php

// redefine the user error constants - PHP 4 only
define("FATAL", E_USER_ERROR);
define("ERROR", E_USER_WARNING);
define("WARNING", E_USER_NOTICE);

// set the error reporting level for this script
error_reporting(FATAL | ERROR | WARNING);

// error handler function
function myErrorHandler($errno, $errstr, $errfile, $errline) 
{
  switch ($errno) {
  case FATAL:
   echo "<b>FATAL</b> [$errno] $errstr<br />\n";
   echo "  Fatal error na linha $errline of file $errfile";
   echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
   echo "Aborting...<br />\n";
   exit(1);
   break;
  case ERROR:
   echo "<b>ERROR</b> [$errno] $errstr<br />\n";
   break;
  case WARNING:
   echo "<b>WARNING</b> [$errno] $errstr<br />\n";
   break;
  default:
   echo "Tipo desconhecido de erro: [$errno] $errstr<br />\n";
   break;
  }
}


// set to the user defined error handler
$old_error_handler = set_error_handler("myErrorHandler");

?> 