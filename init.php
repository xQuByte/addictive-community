<?php

## -------------------------------------------------------
#  ADDICTIVE COMMUNITY
## -------------------------------------------------------
#  Created by Brunno Pleffken Hosti
#  https://github.com/addictivehub/addictive-community
#
#  File: init.php
#  License: GPLv2
#  Copyright: (c) 2017 - Addictive Community
## -------------------------------------------------------

// Show all kind of errors
ini_set('display_errors', 'On');
error_reporting(E_ALL);

// Set default timezone to UTC (timezones are defined by user)
date_default_timezone_set("UTC");

// Set default charset for PHP as UTF-8
// In case of an action returning JSON encoded objects
header('Content-Type: text/html; charset=utf-8');

/**
 * --------------------------------------------------------------------
 * ADDICTIVE COMMUNITY VERSION
 * --------------------------------------------------------------------
 */
define("VERSION", "v0.13.0");
define("CHANNEL", "Beta"); // e.g.: Alpha, Beta, Release Candidate, Final

define("MIN_PHP_VERSION", 5.4);
define("MIN_SQL_VERSION", 5.6);

/**
 * --------------------------------------------------------------------
 * TIME DEFINITION CONSTANTS
 * --------------------------------------------------------------------
 */
define("SECONDS", 1);
define("MINUTE", 60);
define("HOUR", 3600);
define("DAY", 86400);
define("WEEK", 604800);
define("MONTH", 2592000);
define("YEAR", 31536000);

/**
 * --------------------------------------------------------------------
 * AUTOLOADER
 * --------------------------------------------------------------------
 */

function autoLoaderClass($class_name)
{
	$bits = explode("\\", ltrim($class_name, "\\"));
	array_shift($bits);
	$path = __DIR__ . "/" . lcfirst(implode("/", $bits)) . ".php";

	if(!file_exists($path)) {
		return false;
	}

	require_once($path);
	return true;
}

/**
 * --------------------------------------------------------------------
 * The awesome internationalization function!
 * Translation INDEX is provided in $string to locate the corresponding
 * translated string. If the INDEX does not exists, the value in
 * $string is treated simply as string (shortcut for "echo"). ;)
 * --------------------------------------------------------------------
 */
function __($string, $variables = array())
{
	echo \AC\Kernel\i18n::translate($string, $variables);
}
