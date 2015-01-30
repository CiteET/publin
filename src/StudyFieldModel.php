<?php

require_once 'StudyField.php';


class StudyFieldModel {


	private $db;
	private $num;

	
	public function __construct(Database $db) {
		$this -> db = $db;
	}


	public function getNum() {
		return $this -> num;
	}


	public function fetch(array $filter = array()) {

		$study_fields = array();

		$data = $this -> db -> fetchStudyFields($filter);
		$this -> num = $this -> db -> getNumRows();

		foreach ($data as $key => $value) {
			$study_fields[] = new StudyField($value);
		}

		return $study_fields;
	}


	public function validate(array $input) {

		$errors = array();
		// validation
		return $errors;
	}


	public function create(array $data) {

		// validation here?
		$study_field = new StudyField($data);
		return $study_field;
	}


	public function store(StudyField $study_field) {

		$data = $study_field -> getData();
		$id = $this -> db -> insertData('list_study_fields', $data);

		if (!empty($id)) {
			return $id;
		}
		else {
			throw new Exception('Error while inserting field of study to DB');
			
		}
	}

}