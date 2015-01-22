<?php

require_once 'Object.php';

/**
 * Handles publication data.
 *
 * TODO: comment
 */
class Publication extends Object {

	/**
	 * @var	array
	 */
	private $authors;


	/**
	 * @var	array
	 */
	private $key_terms;



	/**
	 * Returns the type.
	 *
	 * @return string
	 */
	public function getTypeName() {
		return $this -> getData('type');
	}
	public function getTypeId() {
		return $this -> getData('type_id');
	}


	/**
	 * Returns the field of study.
	 *
	 * @return string
	 */
	public function getStudyField() {
		return $this -> getData('study_field');
	}


	/**
	 * Returns the title of the publication.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this -> getData('title');
	}


	/**
	 * Returns the abstract.
	 *
	 * @return string
	 */
	public function getAbstract() {
		return $this -> getData('abstract');
	}


	/**
	 * @return string
	 */
	public function getJournalName() {
		return $this -> getData('journal');
	}
	public function getJournalId() {
		return $this -> getData('journal_id');
	}

	/**
	 * @return string
	 */
	public function getPublisherName() {
		return $this -> getData('publisher');
	}
	public function getPublisherId() {
		return $this -> getData('publisher_id');
	}

	/**
	 * @return string
	 */
	public function getVolume() {
		return $this -> getData('volume');
	}

	/**
	 * @return string
	 */
	public function getNumber() {
		return $this -> getData('number');
	}

	/**
	 * @return string
	 */
	public function getSeries() {
		return $this -> getData('series');
	}

	/**
	 * @return string
	 */
	public function getNote() {
		return $this -> getData('note');
	}

	/**
	 * @return string
	 */
	public function getIsbn() {
		return $this -> getData('isbn');
	}

	/**
	 * @return string
	 */
	public function getDoi() {
		return $this -> getData('doi');
	}

	/**
	 * @return string
	 */
	public function getBookName() {
		return $this -> getData('book_name');
	}
	public function getBookId() {
		return $this -> getData('book_id');
	}

	/**
	 * @return string
	 */
	public function getPages($divider) {
		$pages_from = $this -> getData('pages_from');
		$pages_to = $this -> getData('pages_to');

		if ($pages_from && $pages_to) {
			return $pages_from.' '.$divider.' '.$pages_to;
		}
		else {
			return false;
		}
	}


	/**
	 * Returns the publish date.
	 *
	 * @param	string		$format		date format (optional)
	 *
	 * @return	string
	 */
	public function getDatePublished($format) {
		if ($this -> getData('date_published')) {
			return date($format, strtotime($this -> getData('date_published')));
		}
		else {
			return false;
		}
	}


	/**
	 * Returns the date the publication was added.
	 *
	 * @param	string		$format		date format (optional)
	 *
	 * @return	string
	 */
	public function getDateAdded($format) {
		if ($this -> getData('date_added')) {
			return date($format, strtotime($this -> getData('date_added')));
		}
		else {
			return false;
		}
	}
	

	/**
	 * Returns an array with the authors of this publication.
	 * The array consists of Author objects.
	 *
	 * @return	array
	 */
	public function getAuthors() {
		return $this -> authors;
	}


	/**
	 * Returns an array with the key terms of this publication.
	 * The array consists of KeyTerm objects.
	 *
	 * @return	array
	 */
	public function getKeyTerms() {
		return $this -> key_terms;
	}


    /**
     * Adds the authors to the publication.
     *
     * @param	array	$authors	array with Author objects
     *
     * @return	void
     */
	public function setAuthors(array $authors) {
		// TODO: Input validation
		$this -> authors = $authors;
	}


    /**
     * Adds the key terms to the publication.
     *
     * @param	array	$key_terms	array with KeyTerm objects
     *
     * @return	void
     */
	public function setKeyTerms(array $key_terms) {
		// TODO: Input validation
		$this -> key_terms = $key_terms;
	}


	public function toArray() {

		$data = array();
		$authors = array();
		$key_terms = array();

		foreach ($this -> getAuthors() as $author) {
			$authors[] = array('given' => $author -> getFirstName(), 'family' => $author -> getLastName());
		}

		foreach ($this -> getKeyTerms() as $key_term) {
			$key_terms[] = $key_term -> getName();
		}

		$data['type'] = $this -> getTypeName();
		$data['cite_key'] = 'todo';
		$data['title'] = $this -> getTitle();
		$data['author'] = $authors;
		$data['journal'] = $this -> getJournalName();
		$data['booktitle'] = $this -> getBookName();
		$data['publisher'] = $this -> getPublisherName();
		// $data['edition'] = $this -> getEdition();
		// $data['institution'] = $this -> getInstitutionName();
		// $data['howpublished'] = $this -> getHowpublished();
		$data['year'] = $this -> getDatePublished('Y');
		$data['month'] = $this -> getDatePublished('F');
		$data['volume'] = $this -> getVolume();
		$data['pages']['from'] = $this -> getData('pages_from');
		$data['pages']['to'] = $this -> getData('pages_to');
		$data['number'] = $this -> getNumber();
		$data['series'] = $this -> getSeries();
		$data['abstract'] = $this -> getAbstract();
		// some more missing
		$data['keywords'] = $key_terms;

		return $data;
	}
	
}
