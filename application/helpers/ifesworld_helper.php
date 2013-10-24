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
	
	
?>