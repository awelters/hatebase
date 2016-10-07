<?php

namespace Hatebase;

/**
* HatebaseAPI : Simple PHP wrapper for v3.0 of the hatebase.org API
*
* Example:  http://api.hatebase.org/v3-0/{key}/vocabulary/xml/about_nationality%3D1%7Clanguage%3Dfra
*
* PHP version 5.3.10
*
* @category Awesomeness
* @package Hatebase
* @author Andrew Welters <awelters@hugmehugyou.org>
* @license http://opensource.org/licenses/MIT The MIT License
* @link http://www.hatebase.org/connect_api
* @link https://github.com/awelters/HatebaseAPI
*/
class HatebaseAPI
{
	private $base_url = 'https://api.hatebase.org';
	private $version = '3';
    private $key;

    /**
	* Create the API access object. Requires an array of settings::
	* api key
	* Optional settings::
	* version
	* These are all available by creating your own application on hatebase.org
	* Requires the cURL library
	*
	* @param array $settings
	*/
    public function __construct(array $settings)
    {
        if (!in_array('curl', get_loaded_extensions()))
        {
            throw new Exception('You need to install cURL, see: http://curl.haxx.se/docs/install.html');
        }

        if (!isset($settings['key']))
        {
            throw new Exception('Make sure you are passing in the correct parameters');
        }

        $this->key = $settings['key'];
        if(isset($settings['version']))
        	$this->version = $settings['version'];
    }

    /**
	* Perform the actual data retrieval from the API
	*
	* @param string $filters The filters you'd like to search on
	* @param string $query_type Either 'vocabulary' or 'sightings'
	* @param string $output The output formatted from the returned results of the API call.  Either 'xml' or 'json'.
	*
	* @return string returns data from API (format is dependent on the $output parameter).
	*/
    public function performRequest($filters, $output = 'xml', $query_type = 'vocabulary')
    {
    	$url = $this->base_url . '/v' . $this->version . '-0/' . $this->key . '/' . $query_type . '/' . $output . '/' . $this->format_query($filters);

        $options = array(
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 0, //The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
            CURLOPT_TIMEOUT => 120//The maximum number of seconds to allow cURL functions to execute.
        );

		$curl_handle = curl_init();
        curl_setopt_array($curl_handle, $options);
        $result = curl_exec($curl_handle);
        $error = curl_error($curl_handle);
        curl_close($curl_handle);

		if($error != '')
			throw new Exception($error);

        return $result;
    }

    public function format_query($parameters, $primary='%3D', $secondary='%7C'){
        $query = "";
        foreach($parameters as $key => $value){
            $pair = array(urlencode($key), urlencode($value));
            $query .= implode($primary, $pair) . $secondary;
        }
        return rtrim($query, $secondary);
    }
}
