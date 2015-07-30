<?php
// Needed minimum 5.5 version of PHP to use password hashing API
if (version_compare(phpversion(), '5.5', '<')) {
	die('Needed minimum 5.5 version of PHP to use password hashing API');
}

spl_autoload_register(function($namespace) {
	$namespaceArray = explode('\\', $namespace);
	$className = array_pop($namespaceArray);
	include root_path() . '/' . strtolower(implode('/', $namespaceArray)) . '/' . $className . '.php';
});

function root_path() {
	return realpath(__DIR__ . '/..');
}

function public_path() {
	return root_path() . '/public/';
}

function app_path() {
	return root_path() . '/app/';
}

function views_path() {
	return app_path() . 'views/';
}

function app() {
	return App\Application::instance();
}

$app = app();
$app->router->add('get', '/', 'App\Controllers\HomeController', 'index');
$app->router->add('get', '/users/{id}', 'App\Controllers\UserController', 'index');
$app->router->add('post', '/auth/registration', 'App\Controllers\AuthController', 'registration');
$app->router->add('post', '/auth/login', 'App\Controllers\AuthController', 'login');
$app->router->add('post', '/auth/logout', 'App\Controllers\AuthController', 'logout');
$app->router->add('get', '/locale/{locale}', 'App\Controllers\LocaleController', 'index');
$app->run();
?>