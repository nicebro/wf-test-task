<?php namespace App;

/**
 * Used to manage session data.
 */
class Session
{
	public $flash;

	function __construct() {
		session_start();
		if ($this->has('flash')) {
			$this->flash = $this->get('flash');
			$this->delete('flash');
		}
	}

	public function get($key)
	{
		if ($this->has($key)) {
			return $_SESSION[$key];
		}
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function delete($key)
	{
		unset($_SESSION[$key]);
	}

	private function has($key)
	{
		return isset($_SESSION[$key]);
	}

	public function flash($data)
	{
		if (!$this->has('flash')) {
			$this->set('flash', []);
		}
		$this->set('flash', array_merge($this->get('flash'), $data));
	}
}

?>