<?php

namespace publin\src;

use InvalidArgumentException;

/**
 * Class StudyFieldModel
 *
 * @package publin\src
 */
class StudyFieldModel extends Model {


	/**
	 * @param StudyField $study_field
	 *
	 * @return string
	 * @throws exceptions\DBDuplicateEntryException
	 * @throws exceptions\DBForeignKeyException
	 */
	public function store(StudyField $study_field) {

		$query = 'INSERT INTO `study_fields` (`name`, `description`) VALUES (:name, :description);';
		$this->db->prepare($query);
		$this->db->bindValue(':name', $study_field->getName());
		$this->db->bindValue(':description', $study_field->getDescription());
		$this->db->execute();

		return $this->db->lastInsertId();
	}


	/**
	 * @param $id
	 *
	 * @return int
	 * @throws exceptions\DBDuplicateEntryException
	 * @throws exceptions\DBForeignKeyException
	 */
	public function delete($id) {

		if (!is_numeric($id)) {
			throw new InvalidArgumentException('param should be numeric');
		}

		$query = 'DELETE FROM `study_fields` WHERE `id` = :id;';
		$this->db->prepare($query);
		$this->db->bindValue(':id', (int)$id);
		$this->db->execute();

		return $this->db->rowCount();
	}


	/**
	 * @return Validator
	 */
	public function getValidator() {

		$validator = new Validator();
		$validator->addRule('name', 'text', true, 'Name is required but invalid');

		return $validator;
	}
}
