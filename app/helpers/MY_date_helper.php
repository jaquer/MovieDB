<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Prettifies the output of the date helper's timespan().
   Turns single digit numbers into words, and trims all but the first part of
   the timespan.
*/
function pretty_timespan($seconds = 1, $time = '')
{
	$timespan = timespan($seconds, $time);

	if (strpos($timespan, ',') !== FALSE)
		$timespan = strstr($timespan, ',', TRUE);

	/* The tilde is added as a token to be able to limit the str_replace to the
	   beginning of the string. */
	$timespan = '~' . strtolower($timespan);
	$numbers = array('~1 ', '~2 ', '~3 ', '~4 ', '~5 ', '~6 ', '~7 ', '~8 ', '~9 ');
	$names = array('One ', 'Two ', 'Three ', 'Four ', 'Five ', 'Six ', 'Seven ', 'Eight ', 'Nine ');
	$timespan = str_replace($numbers, $names, $timespan);
	$timespan = str_replace('~', '', $timespan);

	return $timespan;
}

/* EOF helpers/my_date_helper.php */
