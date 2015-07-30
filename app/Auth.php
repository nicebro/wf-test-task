<?php namespace App;

use App\Models\User;
use App\Hash;

/**
*  Provides user authorization.
*/
class Auth
{
	private $user;

	/**
	 * Check if user is authorized.
	 */
	public function check()
	{
		return !is_null($this->user());
	}

	/**
	 * Verify user credentials and authorize if everything fine.
	 */
	public function attempt($credentials, $field = 'email')
	{
		$model = new User;
		$user = $model->where($field, '=', [$credentials[$field]])->first();
		if ($user) {
			if (Hash::verify($credentials['password'], $user->password)) {
				$this->login($user);
			}
		}
		return false;
	}

	/**
	 * Authorize user
	 */
	public function login($user)
	{
		$this->user = $user;
		app()->session()->set('user_id', $user->id);
	}

	/**
	 * Unauthorize user
	 */
	public function logout()
	{
		$this->user = null;
		app()->session()->delete('user_id');
	}

	/**
	 * Return user model if user is authorized or null.
	 */
	public function user() {

		if (!is_null($this->user)) {
			return $this->user;
		}


		$id = app()->session()->get('user_id');

		if (!is_null($id)) {
			$model = new User;
			$user = $model->find($id);
			$this->user = $user;
			return $this->user;
		}
	}

}

?>