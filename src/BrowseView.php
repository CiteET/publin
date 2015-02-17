<?php

namespace publin\src;

/**
 * View for browse page
 *
 * TODO: comment
 */
class BrowseView extends View {

	/**
	 * @var    BrowseModel
	 */
	private $model;


	/**
	 * Constructs the browse view.
	 *
	 * @param    BrowseModel $model The browse model
	 */
	public function __construct(BrowseModel $model) {

		parent::__construct('browse');
		$this->model = $model;

		$this->browse_type_list =
			array(
				'recent'      => array(
					'name'       => 'Recent Publications',
					'url'        => './?p=browse&amp;by=recent',
					'result_url' => './?p=publication&amp;id='),
				'author'      => array(
					'name'       => 'Authors',
					'url'        => './?p=browse&amp;by=author',
					'result_url' => './?p=author&amp;id='),
				'key_term'    => array(
					'name'       => 'Key Terms',
					'url'        => './?p=browse&amp;by=key_term',
					'result_url' => './?p=key_term&amp;id='),
				'study_field' => array(
					'name'       => 'Fields of Study',
					'url'        => './?p=browse&amp;by=study_field',
					'result_url' => './?p=study_field&amp;id='),
				'type'        => array(
					'name'       => 'Types',
					'url'        => './?p=browse&amp;by=type',
					'result_url' => './?p=browse&amp;by=type&amp;id='),
				'journal'     => array(
					'name'       => 'Journals',
					'url'        => './?p=browse&amp;by=journal',
					'result_url' => './?p=journal&amp;id='),
				'publisher'   => array(
					'name'       => 'Publishers',
					'url'        => './?p=browse&amp;by=publisher',
					'result_url' => './?p=publisher&amp;id='),
				'year'        => array(
					'name'       => 'Years',
					'url'        => './?p=browse&amp;by=year',
					'result_url' => './?p=browse&amp;by=year&amp;id='),
			);

		if (!array_key_exists($this->model->getBrowseType(), $this->browse_type_list)) {
			$this->browse_type = array('name'       => '',
									   'url'        => '',
									   'result_url' => '');
		}
		else {
			$this->browse_type = $this->browse_type_list[$this->model->getBrowseType()];
		}
	}


	/**
	 * Shows the page title.
	 *
	 * @return    string
	 */
	public function showPageTitle() {

		return $this->showBrowseType();
	}


	/**
	 * Shows the browse.
	 *
	 * @return    string
	 */
	public function showBrowseType() {

		return 'Browse '.$this->browse_type['name'];
	}


	/**
	 * Shows the number of found entries.
	 *
	 * @return    int
	 */
	public function showBrowseNum() {

		return $this->model->getNum();
	}


	/**
	 * Shows the browse list.
	 *
	 * @return    string
	 */
	public function showBrowseList() {

		$string = '';
		$browse_list = $this->model->getBrowseList();
		$browse_type = $this->model->getBrowseType();

		if (!empty($browse_list)) {
			if ($browse_type == 'year') {
				foreach ($browse_list as $year) {
					$string .= '<li><a href="'.$this->browse_type['result_url'].$year.'">'.$year.'</a></li>'."\n";
				}
			}
			else if ($browse_type == 'author') {
				/* @var $author Author */
				foreach ($browse_list as $author) {
					$string .= '<li><a href="'.$this->browse_type['result_url'].$author->getId().'">'.$author->getLastName().', '.$author->getFirstName().'</a></li>'."\n";
				}
			}
			else {
				/* @var $object Object */
				foreach ($browse_list as $object) {
					$string .= '<li><a href="'.$this->browse_type['result_url'].$object->getId().'">'.$object->getName().'</a></li>'."\n";
				}
			}

		}
		else {
			foreach ($this->browse_type_list as $browse_type) {
				$string .= '<li><a href="'.$browse_type['url'].'">'.$browse_type['name'].'</a></li>'."\n";
			}
		}

		return $string;
	}


	/**
	 * Returns true if there is a browse result.
	 *
	 * This is used to determine whether the result list or the browse list should be shown,
	 * so this returns true even if the browse result is empty.
	 *
	 * @return    boolean
	 */
	public function isBrowseResult() {

		return $this->model->isBrowseResult();
	}


	/**
	 * Shows the browse results.
	 *
	 * @return string
	 */
	public function showBrowseResult() {

		$string = '';

		foreach ($this->model->getBrowseResult() as $publication) {

			$string .= '<li>'.$this->showCitation($publication).'</li>'."\n";
		}

		return $string;
	}

}
