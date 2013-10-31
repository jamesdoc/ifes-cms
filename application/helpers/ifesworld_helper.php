<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// Author:	James Doc
	// Date:	October 2011
	// Purpose:	This helper contains common functions used on the IFES website including localising dates, new lines to paragraphs, etc
	
	
	// Convert new lines to paragraphs
	if( ! function_exists('nls2p')){
		function nls2p($str){
			return str_replace('<p></p>', '', '<p>' 
				. preg_replace('#([\r\n]\s*?[\r\n]){2,}#', '</p>$0<p>', $str) 
				. '</p>');
		}
	}
	
	// Add links in a string
	if(!function_exists('add_links')){
		function add_links($string){
			$string= preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $string);
			$string= preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $string);
			return $string;
		}
	}

	if(!function_exists('toUrlSlug')){
		function toUrlSlug($clean, $maxLength = 50){
			setlocale(LC_ALL, 'en_GB');										// Tell PHP by which locale to replace characters
			$clean = mb_strtolower(trim($clean));							// Lowercase everything
			$clean = str_replace(' ', '-', $clean);							// Replace spaces with dashes
			$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);				// Replace all non-latin characters
			$clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);		// Remove any extra characters
			$clean = substr($clean, 0, $maxLength);							// Reduce string to $maxlength
			return $clean;
		}
	}


	if(!function_exists('get_video_thumbnail')){
		function get_video_thumbnail($url)
		{


			if(strpos($url, 'youtube') !== false)
			{

				parse_str( parse_url( $url, PHP_URL_QUERY ), $a );

				if(isset($a) && $a != null){

					$url = "http://gdata.youtube.com/feeds/api/videos/" . $a['v'] . "?v=2&prettyprint=true&alt=jsonc";

					$json = file_get_contents($url);

					$json = json_decode($json);

					return $json->data->thumbnail->hqDefault;

				}
				
			}
			else if(strpos($url, 'vimeo') !== false)
			{
				
				preg_match('/(\d+)/', $url, $a);

				if(isset($a) && $a != null){
					$url = "http://vimeo.com/api/v2/video/" . $a[0] . ".json";

					$json = file_get_contents($url);

					$json = json_decode($json);

					return $json[0]->thumbnail_large;
				}

			}
			
			return null;
			
		}
	}
	

	function array_strpos($haystack, $needles)
	{
	    foreach($needles as $needle)
	        if(strpos($haystack, $needle) !== false) return true;
	    return false;
	}
?>