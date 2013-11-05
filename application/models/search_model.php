<?php

class Search_model extends CI_Model {

	function resource_search($query)
	{
		$url = $this->config->item('api_endpoint') . "search?query=" . urlencode($query);

		$json = $this->curl($url);

		$json = json_decode($json);

		return $json;
	}

	function curl($url)
	{

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		$result = curl_exec($curl);
		curl_close($curl);

		return $result;
	}

}