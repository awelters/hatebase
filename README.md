Hatebase
===========

Simple PHP wrapper for v3.0 of the [hatebase.org API](http://www.hatebase.org/connect_api)

# How to use

1. Obtain a [hatebase API key](http://www.hatebase.org/request_api)
2. Install [composer](https://getcomposer.org/doc/00-intro.md)
3. Create a new composer.json file with awelters/hatebase as a dependency (or add to your project's existing composer.json file)

```
{
    "require": {
    	"awelters/hatebase": "dev-master"
    }
}
```

4. Use composer to [install the dependencies](https://getcomposer.org/doc/00-intro.md#using-composer)
5. Go ahead and try it out.  The following php script can be used as a starting point by simply adding your Hatebase API key

```
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
ini_set('display_errors', 1);
header('Content-type: application/json');

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload

use Hatebase\HatebaseAPI;

$settings = array(
    'key' => '',
    'version' => '3' //optional
);
$hatebase = new HatebaseAPI($settings);

//See http://www.hatebase.org/connect_api for filter options
$filters = array('about_nationality' => '1', 'language' => 'eng');
$output = 'json'; //either 'xml' or 'json', 'xml' is faster
$query_type = 'sightings'; //either 'vocabulary' or 'sightings'

try {
	$result = $hatebase->performRequest($filters, $output, $query_type);
	print_r($result);
}
catch(Exception $e) {
	echo 'Error: '.$e;
}
```
