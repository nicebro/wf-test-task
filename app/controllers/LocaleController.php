<?php namespace App\Controllers;

use App\BaseController;

/**
*
*/
class LocaleController extends BaseController
{

	public function index($locale)
	{
		setcookie('locale', $locale, time() + 60*60*24*30, '/');
		app()->redirect('/');
	}
}