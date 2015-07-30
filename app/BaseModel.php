<?php namespace App;

/**
*
*/
class BaseModel
{
	public $attributes = [];
	private $db;

	function __construct()
	{
		$this->db = app()->database();
	}

	public function fill($attributes)
	{
		$this->attributes = $attributes;
		foreach ($attributes as $key => $attribute) {
			$this->$key = $attribute;
		}
	}

	public function find($id)
	{
		return $this->where('id', '=', [$id])->first();
	}

	public function where($attribute, $compare, $values)
	{
		$this->db->addQuery('SELECT * FROM ' . $this->table . ' WHERE ' . $attribute . ' ' . $compare. ' ?', $values);
		return $this;
	}

	public function get()
	{
		$rows = $this->db->all();
		$models = [];
		foreach ($rows as $row) {
			$model = new static;
			$model->fill($row);
			$models[] = $model;
		};
		return $models;
	}

	public function first()
	{
		$this->db->addQuery('LIMIT 1');
		$data = $this->db->first();
		if ($data) {
			$model = new static;
			$model->fill($data);
			return $model;
		}
		return [];
	}

	public function create($data)
	{
		$fields = implode(',', array_keys($data));
		$values = implode(',', array_fill(0, count($data), '?'));
		$this->db->addQuery('INSERT INTO ' . $this->table . '(' . $fields . ') VALUES (' . $values . ')', array_values($data))->execute();
		$data['id'] = $this->db->lastInsertId($this->table, 'id');
		$this->fill($data);
		return $this;
	}



}