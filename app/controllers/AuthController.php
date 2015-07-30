<?php namespace App\Controllers;

use App;
use App\BaseController;
use App\Models\User;
use App\Hash;

/**
*
*/
class AuthController extends BaseController
{
	private $auth;

	function __construct() {
		parent::__construct();
		$this->auth = app()->auth();
		$this->user = new User;
	}

	public function registration()
	{
		$data = $this->request->inputs;
		$validator = $this->validate($data, [
			'email' => 'max:70|email|unique:users',
			'password' => 'min:6|max:255|required',
			'name' => 'max:255|required',
			'photo' => 'image'
		]);

		if ($validator->fail) {
			return app()->redirect('/');
		}

		$tmp_name = $this->request->files['photo']['tmp_name'];
		$uploads_dir = public_path() . 'photos/';
		$filename = md5($data['email']) . '.' . pathinfo($this->request->files['photo']['name'], PATHINFO_EXTENSION);

		if (!file_exists($uploads_dir)) {
			mkdir($uploads_dir, 0755, true);
		}
		move_uploaded_file($tmp_name, $uploads_dir . $filename);

		$credentials = [
			'email' => $data['email'],
			'password' =>  Hash::make($data['password']),
			'photo' => '/photos/' . $filename,
			'name' => $data['name']
		];

		$this->user->create($credentials);
		$this->auth->login($this->user);
		return app()->redirect('/users/' . $this->user->id, app()->messages['welcome']);
	}

	public function login()
	{

		$data = $this->request->inputs;

		$validator = $this->validate($data, [
			'l_email' => 'email|required',
			'l_password' => 'required',
		]);

		if ($validator->fail) {
			return app()->redirect('/');
		}

		$credentials = [
			'email' => $data['l_email'],
			'password' => $data['l_password'],
		];

		if (!$this->auth->attempt($credentials)) {
			return app()->redirect('/', app()->messages['wrong_credentials']);
		};

		return app()->redirect('/users/' . $this->auth->user()->id, app()->messages['welcome'] . $this->auth->user()->name);
	}

	public function logout()
	{
		$this->auth->logout();
		return app()->redirect('/');
	}


}