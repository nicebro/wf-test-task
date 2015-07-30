<?php namespace App;

/**
*
*/
class Config
{
	private $settings;

	function __construct()
	{
		$this->loadEnvironmentVars();
		$this->settings = include 'config/app.php';
	}

	public function set($key, $value)
	{
		$this->settings[$key] = $value;
	}

	public function get($key)
	{
		$keys = explode('.', $key);
		$value = $this->settings[array_shift($keys)];
		foreach ($keys as $key) {
			$value = $value[$key];
		}
		return $value;
	}

	public function loadEnvironmentVars()
	{
		$handle = fopen(root_path() . '/.env', 'r');
		if ($handle) {
			while (($line = fgets($handle)) !== false) {
				$var = explode('=', $line);
				if (!getenv($var[0])) {
					putenv(trim($line));
				}
			}
			fclose($handle);
		}
	}
}
?>