<?php namespace App;
/**
* Main application class, provides access to all parts of application.
*/
class Application
{
	public $router;
	private $config;
	private $auth;
	private $database;
	private $request;
	private $response;
	private $session;

	public function __construct()
	{
		$this->session = new Session;
		$this->request = new Request;
		$this->router = new Router;
	}

	protected static $instance;

	public static function instance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function config()
	{
		return $this->config;
	}

	public function auth()
	{
		return $this->auth;
	}

	public function database()
	{
		return $this->database;
	}

	public function request()
	{
		return $this->request;
	}

	public function session()
	{
		return $this->session;
	}

	public function redirect($path, $message = null)
	{
		$host = $_SERVER['HTTP_HOST'];
		$protocol = 'http';
		if ($this->request->isSecure()) {
			$protocol .= 's';
		}
		if (!is_null($message)) {
			$this->session()->flash(['message' => $message]);
		}
		//var_dump("${protocol}://$host$path");
		header("Location: ${protocol}://$host$path");
		exit();
	}

	public function run() {

		$this->config = new Config;

		if (!isset($this->request->cookie['locale'])) {
			setcookie('locale', $this->config->get('locale'), time() + 3600*24*30);
		} else {
			$this->config->set('locale', $this->request->cookie['locale']);
		}

		$this->messages = include 'lang/' . $this->config->get('locale') . '/main.php';
		$this->auth = new Auth;
		$this->database = new Database;
		$this->router->dispatch();
		$this->session->set('uri', $this->request()->uri);
	}
}

?>