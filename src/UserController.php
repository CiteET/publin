<?php


namespace publin\src;

use BadMethodCallException;
use publin\src\exceptions\SQLDuplicateEntryException;

class UserController {

	private $db;
	private $auth;
	private $model;
	private $errors;
	private $user;


	public function __construct(Database $db, Auth $auth) {

		$this->db = new PDODatabase();
		$this->auth = $auth;
		$this->user = $this->auth->getCurrentUser();
		$this->model = new UserModel($db);
		$this->errors = array();
	}


	/**
	 * @param Request $request
	 *
	 * @return string
	 * @throws \Exception
	 * @throws exceptions\NotFoundException
	 */
	public function run(Request $request) {

		if ($request->post('action')) {
			$method = $request->post('action');
			if (method_exists($this, $method)) {
				$this->$method($request);
			}
			else {
				throw new BadMethodCallException;
			}
		}

		$repo = new UserRepository($this->db);
		$user = $repo->select()->where('id', '=', $this->user->getId())->findSingle(true);

		$view = new UserView($user, $this->errors);

		return $view->display();
	}


	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param Request $request
	 *
	 * @return bool
	 */
	private function delete(Request $request) {

		$confirmed = Validator::sanitizeBoolean($request->post('delete'));
		if (!$confirmed) {
			$this->errors[] = 'Please confirm the deletion';

			return false;
		}

		return $this->model->delete($this->user->getId());
	}


	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param Request $request
	 *
	 * @return bool|int
	 */
	private function changeMail(Request $request) {

		$password = Validator::sanitizeText($request->post('password'));
		if (!$password || !$this->auth->validateLogin($this->user->getName(), $password)) {
			$this->errors[] = 'Invalid password';

			return false;
		}

		$mail = Validator::sanitizeEmail($request->post('mail'));
		$mail_confirm = Validator::sanitizeEmail($request->post('mail_confirm'));

		if (!$mail || !$mail_confirm) {
			$this->errors[] = 'New email address is required but invalid';

			return false;
		}

		if ($mail !== $mail_confirm) {
			$this->errors[] = 'Entered email addresses are not the same';

			return false;
		}

		try {
			return $this->model->update($this->user->getId(), array('mail' => $mail));
		}
		catch (SQLDuplicateEntryException $e) {
			$this->errors[] = 'This email address is already in use';

			return false;
		}
	}


	/** @noinspection PhpUnusedPrivateMethodInspection
	 * @param Request $request
	 *
	 * @return bool|int
	 */
	private function changePassword(Request $request) {

		$password = Validator::sanitizeText($request->post('password'));
		if (!$password || !$this->auth->validateLogin($this->user->getName(), $password)) {
			$this->errors[] = 'Invalid password';

			return false;
		}

		$password_new = Validator::sanitizeText($request->post('password_new'));
		$password_confirm = Validator::sanitizeText($request->post('password_confirm'));

		if (!$password_new || !$password_confirm) {
			$this->errors[] = 'New password required but invalid';

			return false;
		}

		if ($password_new !== $password_confirm) {
			$this->errors[] = 'Entered passwords are not the same';

			return false;
		}

		return $this->model->update($this->user->getId(), array('password' => $password_new));
	}
}
