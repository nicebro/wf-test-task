<?php

return [
	'locale' => 'en',
	'default_locale' => 'en',
	'database' => [
		'host' => getenv('DB_HOST'),
		'database' => getenv('DB_NAME'),
		'username' => getenv('DB_USERNAME'),
		'password' => getenv('DB_PASSWORD'),
		'connection' => getenv('DB_CONNECTION'),
		'port' => getenv('DB_PORT'),
	],
];

?>