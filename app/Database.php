<?php namespace App;

use PDO;
/**
*
*/
class Database
{
	private $pdo;
	private $query = [];
	private $params = [];

	function __construct()
	{
		extract(app()->config()->get('database'));
		$this->connection = $connection;
		$dsn = trim("$connection:host=$host;port=$port;dbname=$database");
		$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		];

		$this->pdo = new PDO($dsn, $username, $password, $options);
	}

	public function addQuery($query, $params = [])
	{
		$this->query[] = $query;
		foreach ($params as $param) {
			$this->params[] = $param;
		}
		return $this;
	}

	public function execute()
	{
		$query = implode(' ', $this->query);
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($this->params);
		$this->query = [];
		$this->params = [];
		return $stmt;
	}

	public function first()
	{
		return $this->execute()->fetch();
	}

	public function all()
	{
		return $this->execute()->fetchAll();
	}

	public function lastInsertId($table, $column)
	{
		return $this->pdo->lastInsertId("${table}_${column}_seq");
	}

}
?>