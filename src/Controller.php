<?php

namespace publin\src;

use Exception;
use publin\src\exceptions\NotFoundException;

/**
 * Controls everything.
 *
 * TODO: comment
 */
class Controller {

	private $auth;
	private $db;


	/**
	 * Constructs the controller and the needed Model and View.
	 *
	 * TODO: change parameters to one array with all parameters
	 *
	 *
	 */
	public function __construct() {

		mb_internal_encoding('utf8');
		header('Content-Type: text/html; charset=UTF-8');

		$this->db = new Database();
		// TODO: catch exception here
		$this->auth = new Auth($this->db);
	}


	/**
	 * Displays the page.
	 *
	 * TODO: comment
	 *
	 * @param $page
	 * @param $id
	 * @param $by
	 *
	 * @return string
	 */
	public function run($page, $id, $by) {

		$db = $this->db;
		$this->auth->checkLoginStatus();

		try {
			switch ($page) {
				case 'browse':
					$model = new BrowseModel($db);
					$model->handle($by, $id);
					$view = new BrowseView($model);

					return $view->display();
					break;

				case 'author':
					$model = new AuthorModel($db);
					$author = $model->fetch(true, array('id' => $id));
					$view = new AuthorView($author[0]);

					return $view->display();
					break;

				case 'publication':
					$model = new PublicationModel($db);
					$publication = $model->fetch(true, array('id' => $id));
					$view = new PublicationView($publication[0]);

					return $view->display();
					break;

				case 'submit':
					if ($this->auth->checkLoginStatus()) {
						$controller = new SubmitController($db);

						return $controller->run();
					}
					else {
						$view = new View('login');

						return $view->display();
					}

					break;

				case 'manage':
					if ($this->auth->checkLoginStatus()) {
						$controller = new ManageController($db);

						return $controller->run();
					}
					else {
						$view = new View('login');

						return $view->display();
					}

					break;

				case 'login':
					// TODO: redirect if already logged in
					if (!empty($_POST['username']) && !empty($_POST['password'])) {
						if ($this->auth->validateLogin($_POST['username'], $_POST['password'])) {
							// header();
							print_r('success');
						}
						else {
							print_r('incorrect login');
						}
					}
					$view = new View('login');

					return $view->display();
					break;

				case 'logout':
					if ($this->auth->checkLoginStatus()) {
						$this->auth->logout();
					}
					$view = new View('login');

					return $view->display();
					break;

				default:
					$view = new View($page);

					return $view->display();
					break;
			}

			// return $view -> display();
		}
		catch (NotFoundException $e) {
			// header(..)
			return 'Ooops, something missing here: '.$e->getMessage();
		}
		catch (Exception $e) {

			// TODO maybe put this in view?
			ob_end_clean();

			return 'Error: '.$e->getMessage();
		}


	}

}
