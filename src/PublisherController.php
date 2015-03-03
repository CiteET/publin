<?php


namespace publin\src;

class PublisherController {

	private $db;
	private $model;


	public function __construct(Database $db) {

		$this->db = $db;
		$this->model = new PublisherModel($db);
	}


	public function run(Request $request) {

		if ($request->post('delete') === 'yes') {
			$this->model->delete($request->get('id'));
		}
		else if ($request->get('m') === 'edit' && $request->post()) {

			$validator = new Validator();
			$validator->addRule('name', 'text', true, 'Name is required but invalid');

			if ($validator->validate($request->post())) {
				$input = $validator->getSanitizedResult();
				$success = $this->model->update($request->get('id'), $input);
			}
			else {
				print_r($validator->getErrors());
			}
		}

		$publishers = $this->model->fetch(true, array('id' => $request->get('id')));

		if ($request->get('m') === 'edit') {
			$view = new PublisherView($publishers[0], true);
		}
		else {
			$view = new PublisherView($publishers[0]);
		}

		return $view->display();
	}
}
