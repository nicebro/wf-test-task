<?php namespace App\Controllers;

use App\BaseController;

/**
*
*/
class HomeController extends BaseController
{

	public function index()
	{
		if (app()->auth()->check()) {
			app()->redirect('/users/' . app()->auth()->user()->id);
		}
		return $this->view->render('main');
	}
}