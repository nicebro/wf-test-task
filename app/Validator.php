<?php namespace App;

/**
* Validation of requested data.
*/
class Validator
{
	public $fail = true;
	public $errors = [];
	public $messages = [];
	public $input;

	function __construct() {
		$this->messages = include app_path() . 'lang/' . app()->config()->get('locale') . '/validation.php';
	}

	/**
	 * Validate requested data by specified rules
	 */
	public function validate($input, $validation_rules)
	{
		$this->input = $input;

		foreach ($validation_rules as $attribute => $rules) {
			$rules = explode('|', $rules);
			foreach ($rules as $rule) {
				$method = $rule;
				$params = [$attribute];

				if (strpos($rule, ':') !== false) {
    				$rule = explode(':', $rule);
    				$method = $rule[0];
    				$params[] = $rule[1];
				}

				call_user_func_array([$this, $method], $params);
			}
		}

		if (!count($this->errors)) {
			$this->fail = false;
		}

		app()->session()->flash(['errors' => $this->errors]);

		return $this;
	}

	private function required($attribute)
	{
		$input = $this->input[$attribute];
		if (mb_strlen($input) == 0) {
			$this->errors[$attribute][] = $this->messages['required'];
			;
		};
	}

	private function max($attribute, $limit)
	{
		$input = $this->input[$attribute];
		if (mb_strlen($input) > $limit) {
			$this->errors[$attribute][] = str_replace(':max', $limit, $this->messages['max']);
			;
		};
	}

	private function min($attribute, $limit)
	{
		$input = $this->input[$attribute];
		if (mb_strlen($input) < $limit) {
			$this->errors[$attribute][] = str_replace(':min', $limit, $this->messages['min']);
			;
		};
	}

	private function email($attribute)
	{
		if (!filter_var($this->input[$attribute], FILTER_VALIDATE_EMAIL)) {
			$this->errors[$attribute][] = str_replace(':attribute', $attribute, $this->messages['email']);
			;
		};
	}

	private function unique($attribute, $table)
	{
		if (app()->database()->addQuery('SELECT 1 FROM ' . $table . ' WHERE ' . $attribute . ' = ?' , [$this->input[$attribute]])->first()) {
			$this->errors[$attribute][] = str_replace(':attribute', $attribute, $this->messages['unique']);
			;
		};
	}

	private function image($attribute)
	{
		$mimes = ['image/png', 'image/gif', 'image/jpeg'];
		$file = app()->request()->files[$attribute];

		switch ($file['error']) {
			case 0:
				$image = getimagesize($file['tmp_name']);
				if ($image) {
					if (in_array($image['mime'], $mimes)) {
						return;
					}
				}
				$this->errors[$attribute][] = $this->messages['not_image'];
				break;
			case 4:
				$this->errors[$attribute][] = $this->messages['image_not_uploaded'];
				break;
			default:
				$this->errors[$attribute][] = $this->messages['image_error'];
				break;
		}
	}

}