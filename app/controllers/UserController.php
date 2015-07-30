<?php namespace App\Controllers;

use App\BaseController;
use App\Models\User;
/**
*
*/
class UserController extends BaseController
{

	public function index($id)
	{
		if (!app()->auth()->check()) {
			return app()->redirect(app()->session()->get('uri'), app()->messages['need_authorize']);
		}

		if (is_numeric($id)) {
			$model = new User;
			$user = $model->find($id);
			if ($user) {
				return $this->view->render('users/profile', compact('user'));
			}
		}

		return app()->redirect(app()->session()->get('uri'), app()->messages['user_not_exist']);
	}
}