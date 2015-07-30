<?php namespace App;

/**
* Provides routing of application
*/
class Router
{
	public $routes = [];

	/**
	 * Register specified route params.
	 */
	public function add($method, $path, $controller, $action)
	{
		$this->routes[] = [
			'method' => $method,
			'path' => $path,
			'controller' => $controller,
			'action' => $action
		];
		return $this;
	}

	/**
	 * Search if uri matched any route, and call route params.
	 */
	public function dispatch()
	{
		$request = app()->request();
		$path = $request->uri;
		$method = $request->method;
		$request_path_segments = explode('/', $path);

		foreach ($this->routes as $route) {
			if (strtoupper($route['method']) === $method) {

				if ($route['path'] === $path) {
					return call_user_func([new $route['controller'], $route['action']]);
				}

				$route_path_segments = explode('/', $route['path']);

				if (count($route_path_segments) === count($request_path_segments)) {

					$params = [];

					foreach ($route_path_segments as $key => $value) {

						if (substr($value, 0, 1) === '{' && substr($value, -1, 1) === '}') {
							$params[] = $request_path_segments[$key];
							continue;
						}

						if ($value !== $request_path_segments[$key]) {
							continue 2;
						}
					}

					return call_user_func_array([new $route['controller'], $route['action']], $params);
				}
			}
		}
		// If any routes not match redirect to home page with message
		app()->redirect('/', "404 Not Found");
	}
}

?>