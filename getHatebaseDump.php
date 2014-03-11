<?php
/**
* Andrew's Hatebase script : Simple script to retrieve results from Hatebase API
*
* @category Awesomeness
* @date 3/03/2014
* @author Andrew Welters <awelters@hugmehugyou.org>
* @license http://opensource.org/licenses/MIT The MIT License
* @link http://www.hatebase.org/connect_api
* @link https://github.com/awelters/hatebase
*/
header('Content-type: application/json');

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Hatebase\HatebaseAPI;

date_default_timezone_set('America/Chicago');

$settings = array(
    'key' => "46b9350a3c6afb36344bcafb9f61a44e",
    'version' => '3' //optional
);
$hatebase = new HatebaseAPI($settings);

//See http://www.hatebase.org/connect_api for filter options
$filters = array('about_nationality' => '1', 'language' => 'eng');
$output = 'xml'; //either 'xml' or 'json', 'xml' is faster
$query_type = 'sightings'; //either 'vocabulary' or 'sightings'

try {
	$result = $hatebase->performRequest($filters, $output, $query_type);
	print_r($result);
}
catch(Exception $e) {
	echo 'Error: '.$e;
}
	
?>

