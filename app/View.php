<?php namespace App;

/**
* Rendering templates
*/
class View
{
	private $session;
	private $inputs;
	private $request;
	private $translations;
	public $locale;

	function __construct() {
		$this->locale = app()->config()->get('locale');
		$this->session = app()->session();
		$this->session->flash(['inputs' => app()->request()->inputs]);
		$this->translations = include app_path() . '/lang/' . app()->config()->get('locale') . '/main.php';
	}

	/**
	 * Render the template, returning it's content.
	 */
	public function render($template, $variables = [])
	{
		extract($variables);
		ob_start();
		include views_path() . '/' . $template . '.php';
		return ob_end_flush();
	}

	public function errors($attribute = null)
	{
		$flash = $this->session->flash;

		if (isset($flash['errors'])) {
			if (!is_null($attribute)) {
				if (isset($flash['errors'][$attribute])) {
					return $flash['errors'][$attribute];
				}
				return;
			}
			return $flash['errors'];
		}
	}

	public function error($attribute)
	{
		$errors = $this->errors($attribute);
		if (!is_null($errors)) {
			return $errors[0];
		}
	}

	public function input($attribute)
	{
		if (isset($this->session->flash['inputs'][$attribute])) {
			return $this->session->flash['inputs'][$attribute];
		}
	}

	public function message()
	{
		if (isset($this->session->flash['message'])) {
			return $this->session->flash['message'];
		}
	}

	public function trans($key)
	{
		return $this->translations[$key];
	}

}

?>