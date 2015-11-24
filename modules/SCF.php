<?php


namespace publin\modules;

use DOMDocument;
use publin\modules\scf\xml;
use publin\src\Publication;

/**
 * Class DublinCoreXML
 *
 * @package publin\modules
 */
class SCF extends Module {

	/**
	 * @var array
	 */
	private $fields;

	public function __construct() {
		
		/* Map your fields here. You can change the order or leave out fields. */
		$this->fields = array(
			/* scf field => your field */
			'author'		=> 'authors',
			'title'			=> 'title',
			'publisher'     => 'publisher',
			'date'			=> 'date_published',
			'abstract'		=> 'abstract',
			'source'		=> 'url'
		);
	}
	
	/**
	 * @param    string $string
	 *
	 * @return    array
	 */
	private function extractAuthor($string) {
		// Note: copied from Bibtex.php
		if (substr_count($string, ',') == 1) {
			$names = explode(',', $string);
			$given = $names[1];
			$family = $names[0];
		}
		else if (substr_count($string, ' ') == 1) {
			$names = explode(' ', $string);
			$given = $names[0];
			$family = $names[1];
		}
		else if (substr_count($string, ' ') > 1) {
			$pos = strrpos($string, ' ');
			$given = substr($string, 0, $pos);
			$family = substr($string, $pos);
		}
		else {
			$given = '';
			$family = '';
		}
		
		$author = array();
		$author['given'] = trim($given);
		$author['family'] = trim($family);
		
		return $author;
	}
	
	private function extractDate($input_year) {
		// TODO: may set month
		$month = 'January';
		$day = '01';
		$date = strtotime($day.' '.$month.' '.$input_year);
		if ($date) {
			return date('Y-m-d', $date);
		}
		else {
			return false;
		}
	}
	
	/**
	 * 
	 * @param string $input
	 * @return array
	 */
	public function import($input) {
		$parser = new xml($input);
		$entries = $parser->data;
		
		$result = array();
		//var_dump($entries);
		foreach ($entries as $entry) {
			$entry = $entry['publication'];
			if (is_array($entry)) {
				$result_entry = array();
				$result_entry['authors'] = array();

				foreach ($entry as $tmp) {
					$scf_field = key($tmp);
					if (isset($this->fields[$scf_field])) {
						$your_field = $this->fields[$scf_field];						
						$value = $tmp[$scf_field];
						if ($value) {
							if ($scf_field == 'author') {
								$result_entry[$your_field][] = self::extractAuthor($value);
							}
							else if($scf_field == 'date') {
								$result_entry[$your_field] = self::extractDate($value);
							}
							/* The rest */
							else {
								$result_entry[$your_field] = $value;
							}
						}						
					}
				}

				$result[] = $result_entry;				
			}			
		}
		if (count($result) == 0) {
			return false;
		}
		
		return $result;
	}
}
