<?php namespace App;

/**
*
*/
class BaseController
{
	public $view;
	public $validator;
	public $request;

	function __construct()
	{
		$this->view = new View;
		$this->validator = new Validator;
		$this->request = app()->request();
	}

	public function validate($request, $rules)
	{
		return $this->validator->validate($request, $rules);
	}
}