<?php

//	Основная обработка форм и таблиц. Является мостом между контроллером и базой данный.
//	Если представляет таблицу, то только одну.
class Model extends BaseComponent
{
	// protected static $connection_string;

	// protected $db;
	// protected $limit =  10;

	public function __construct($params = false)
	{
		// if ($params)
		// {
		// 	$this->limit = $params['limit'];
		// }

		// $db = new DB();

		// return $db;
	}

	// protected function connectDB()
	// {
	// 	$components = parse_url(CMS::$db_connection_string);

	// 	if (!$components)
	// 	{
	// 		return false;
	// 	}

	// 	if (!isset($components['scheme']) || !isset($components['host'])
	// 			|| !isset($components['user']) || !isset($components['path']))
	// 	{
	// 		return false;
	// 	}

	// 	if ($components['scheme'] !== 'mysql')
	// 	{
	// 		return false;
	// 	}

	// 	$pass = isset($components['pass']) ? $components['pass'] : '';

	// 	$dataBaseName = substr($components['path'], 1);

	// 	$this->db = new mysqli($components['host'], $components['user'], $pass, $dataBaseName) or
 //      die('Ошибка соединения с базой данных! ' . $this->db->error);

 //    $this->db->set_charset('utf8') or
 //      die('Ошибка выполнения дополнительных параметров соединения с базой данных! ' . $this->db->error);
	// }

	// protected function query($str)
	// {
	// 	$result = $this->db->query($str) or die('Fuilure query! ' . $this->db->error);
	// 	return $result;
	// }

	// protected function escapeValue($value, $type = 'str')
	// {
	// 	$value = trim($value);
	// 	$value = $this->db->real_escape_string($value);

	// 	if ($type === 'str')
	// 	{
	// 		$value = "'" . $value . "'";
	// 	}

	// 	return $value;
	// }

}