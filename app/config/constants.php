<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/* MovieDB Rating Values */
define('NOT_INTERESTED', 	0);
define('HATED_IT',			1);
define('DIDNT_LIKE_IT',		2);
define('LIKED_IT',			3);
define('REALLY_LIKED_IT',	4);
define('LOVED_IT',			5);
define('REMOVE_RATING',		-1);

/* MovieDB Rating Titles */
define('RATING_TITLES', serialize(array(
	NOT_INTERESTED =>	"Not Interested",
	HATED_IT =>			"Hated It",
	DIDNT_LIKE_IT =>	"Didn't Like It",
	LIKED_IT =>			"Liked It",
	REALLY_LIKED_IT =>	"Really Liked It",
	LOVED_IT =>			"Loved It",
	REMOVE_RATING =>	"Remove Rating"
)));

/* End of file constants.php */
/* Location: ./application/config/constants.php */