<?php namespace App;

/**
 *  Used to access HTTP request data from one interface.
 */
class Request
{
	public $inputs;
	public $method;
	public $uri;
	public $referer;
	public $files;
	public $cookie;

	function __construct()
	{
		$this->inputs = $_REQUEST;
		$this->method = $_SERVER['REQUEST_METHOD'];
		$this->uri = $_SERVER['REQUEST_URI'];
		$this->files = $_FILES;
		$this->cookie = $_COOKIE;
	}

	public function isSecure()
	{
  		return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
	}
}

?>