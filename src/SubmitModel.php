<?php

namespace publin\src;

class SubmitModel {

	private $old_db;
	private $db;


	public function __construct(Database $db) {

		$this->old_db = $db;
		$this->db = new PDODatabase();
	}


	public function formatPost(array $post) {

		$result = array();

		foreach ($post as $key => $value) {

			if ($key == 'authors' && !empty($value)) {
				$value = $this->rewriteArray($value);
				$value = array_filter($value);
				if ($value) {
					$result[$key] = $value;
				}
			}
			if ($key == 'keywords' && !empty($value)) {
				$value = array_filter($value);
				if ($value) {
					$result[$key] = $value;
				}
			}
			else if (!empty($value)) {
				$result[$key] = $value;
			}
		}

		return $result;
	}


	private function rewriteArray(array $input) {

		$result = array();
		$given_fields = array_keys($input);

		foreach ($given_fields as $field) {
			foreach ($input[$field] as $key => $value) {
				if (!empty($value)) {
					$result[$key][$field] = $value;
				}
			}
		}

		return $result;
	}


	public function createTypes() {

		$model = new TypeModel($this->old_db);

		return $model->fetch();
	}


	public function createStudyFields() {

		$repo = new StudyFieldRepository($this->db);

		return $repo->select()->order('name', 'ASC')->find();
	}
}
