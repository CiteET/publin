<?php


namespace publin\src;

use BadMethodCallException;
use publin\src\exceptions\PermissionRequiredException;
use UnexpectedValueException;

class KeywordController {

	private $db;
	private $auth;
	private $model;
	private $errors;


	public function __construct(Database $db, Auth $auth) {

		$this->db = new PDODatabase();
		$this->auth = $auth;
		$this->model = new KeywordModel($db);
		$this->errors = array();
	}


	/**
	 * @param Request $request
	 *
	 * @return string
	 * @throws PermissionRequiredException
	 * @throws \Exception
	 * @throws exceptions\LoginRequiredException
	 * @throws exceptions\NotFoundException
	 */
	public function run(Request $request) {

		if ($request->post('action')) {
			if (!$this->auth->checkPermission(Auth::EDIT_KEYWORD)) {
				throw new PermissionRequiredException(Auth::EDIT_KEYWORD);
			}
			$method = $request->post('action');
			if (method_exists($this, $method)) {
				$this->$method($request);
			}
			else {
				throw new BadMethodCallException;
			}
		}

		$repo = new KeywordRepository($this->db);
		$keyword = $repo->select()->where('id', '=', $request->get('id'))->findSingle();

		$repo = new PublicationRepository($this->db);
		$publications = $repo->select()->where('keyword_id', '=', $request->get('id'))->order('date_published', 'DESC')->find();

		if ($request->get('m') === 'edit') {
			$view = new KeywordView($keyword, $publications, $this->errors, true);
		}
		else {
			$view = new KeywordView($keyword, $publications, $this->errors);
		}

		return $view->display();
	}


	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param Request $request
	 *
	 * @return bool
	 */
	private function delete(Request $request) {

		$id = Validator::sanitizeNumber($request->get('id'));
		if (!$id) {
			throw new UnexpectedValueException;
		}

		$confirmed = Validator::sanitizeBoolean($request->post('delete'));
		if ($confirmed) {
			$this->model->delete($id);

			return true;
		}
		else {
			$this->errors[] = 'Please confirm the deletion';

			return false;
		}
	}


	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param Request $request
	 *
	 * @return bool|int
	 */
	private function edit(Request $request) {

		$id = Validator::sanitizeNumber($request->get('id'));
		if (!$id) {
			throw new UnexpectedValueException;
		}

		$validator = $this->model->getValidator();
		if ($validator->validate($request->post())) {
			$input = $validator->getSanitizedResult();
			$this->model->update($id, $input);

			return true;
		}
		else {
			$this->errors = array_merge($this->errors, $validator->getErrors());

			return false;
		}
	}
}
