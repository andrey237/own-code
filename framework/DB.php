<?php

defined('CMS_DB_SKIP') or define('CMS_DB_SKIP', '/');

//	Класс обработки запросов и подкючения базы данных
class DB extends BaseComponent
{
	static public $connection_string;

	static public $conn = false;

	static private $prefix = '';
	static private $query_type = '';

	static private $query_types = array(

																				// user
																				'select', 'insert', 'update', 'delete',

																				// admin
																				'create', 'alter', 'drop',

																				// super admin
																				'show', 'describe', 'explain'
																			);

	public function __construct()
	{
		self::connect(self::$connection_string);
	}

	public function __destruct()
	{
		self::$conn->close($this->conn) or die('Ошибка разрыва соединения с сервером! ' . self::$conn->error);
	}

	static public function connect()
	{
		$components = parse_url(self::$connection_string);

		if (!$components)
		{
			return false;
		}

		if (!isset($components['scheme']) || !isset($components['host'])
				|| !isset($components['user']) || !isset($components['path']))
		{
			return false;
		}

		if ($components['scheme'] !== 'mysqli')
		{
			return false;
		}

		$pass = isset($components['pass']) ? $components['pass'] : '';

		$dataBaseName = substr($components['path'], 1);

		self::$conn = new mysqli($components['host'], $components['user'], $pass, $dataBaseName) or
      die('Ошибка соединения с базой данных! ' . self::$conn->error);

		if (isset($components['query']))
		{
			self::parseConnectAddingParams($components['query'], $conn);
		}
	}

	static public function select()
	{
		$args = func_get_args();

		return call_user_func_array(array(self, 'query'), $args);
	}

	static public function selectOne()
	{
		$args = func_get_args();

		$result_array = call_user_func_array(array(self, 'query'), $args);

		$result = array();

		foreach ($result_array[0] as $key => $value)
		{
			$result[$key] = $value;
		}

		return $result;
	}

	static public function query()
	{
		$args = func_get_args();
		//$query = $args[0];
		$query = self::replaceTablePrefix($args[0]);
		$pieces = explode('{', $query);

		if (!count($pieces))
		{
			return false;
		}

		$firstPiece = array_shift($pieces);

		$countOpeningBrakers = count($pieces);
		$countClosingBrakers = 0;

		$aResult = array(
			0 => array(
				'value' => $firstPiece,
				'breakers' => false
			)
		);

		if ($countOpeningBrakers)
		{
			$curPart = 1;

			foreach ($pieces as $value)
			{
				$aTemp = array();
				$aTemp = explode('}', $value);
				
				if (count($aTemp) != 2)
					return false;
				
				$aResult[$curPart]['value'] = $aTemp[0];
				$aResult[$curPart]['breakers'] = true;
				
				$curPart++;
				$aResult[$curPart]['value'] = $aTemp[1];
				$aResult[$curPart]['breakers'] = false;
				
				$curPart++;
				$countClosingBrakers++;
			}
		}
		
		if ($countOpeningBrakers !== $countClosingBrakers)
		{
			return false;
		}

		$args[0] = $aResult;

		// var_dump($countOpeningBrakers);echo '<br>';
		// var_dump($countClosingBrakers);echo '<br>';
		// var_dump($aResult);echo '<br>';

		return call_user_func_array(array(self, 'replacePlaceholders'), $args);
	}

	static public function addPrefix($prefix)
	{
		self::$prefix .= $prefix . '_';
	}

	static private function parseConnectAddingParams($params, $conn)
	{
		$params = explode('&', $params);
		
		foreach ($params as $i => $v)
		{
			$values = explode('=', $v);

			switch (strtolower($values[0]))
			{
				case 'charset': self::$conn->set_charset($values[1])
								or die('Ошибка выполнения дополнительных параметров соединения с базой данных! ' . self::$conn->error);
								break;
			}
		}
	}

	static private function replacePlaceholders()
	{
		$args = func_get_args();
		$aResult = array_shift($args);
		$curArg = 0;
		$result = '';

		$queryType = self::getQueryType($aResult[0]['value']);

		foreach ($aResult as &$fragment)
		{
			$isBreakers = $fragment['breakers'];
			$toAddFragment = true;
			$parts = array();

			$temp = $fragment['value'];

			$parts = explode('?', $temp);
			
			foreach ($parts as $j => &$part)
			{
				if (!$j)
					continue;
				
				$type = substr($part, 0, 1);
				
				$value = $args[$curArg + $j - 1];

				$value = self::checkParam($value, $type);

				if ($value === CMS_DB_SKIP)
				{
					if (!$isBreakers)
						return false;
					
					$toAddFragment = false;
					break;
				}
				
				if ($value === false)
					return false;

				$part = substr_replace($part, $value, 0, 1);
			}
			
			if ($toAddFragment)
			{
				if ($isBreakers)
					$result .= ' ' . implode('', $parts) . ' ';
				else
					$result .= implode('', $parts);
			}
			
			$curArg += count($parts) - 1;
		}

		return self::getResult($result, $queryType);
	}

	static private function getQueryType($firstQueryPiece)
	{
		$firstQueryPiece = strtolower($firstQueryPiece);

		foreach (self::$query_types as $type)
		{
			if (strpos($firstQueryPiece, $type) !== false)
			{
				$query_type = $type;
				return $type;
			}
		}

		return 'other';
	}

	static private function getResult($query, $queryType)
	{
		$resultSet = self::$conn->query($query) or die('Ошибка выполнения запроса! ' . self::$conn->error);

		switch ($queryType)
		{
			// case 'select':	for ($result = array(); $row = self::$conn->fetch_assoc($resultSet); $result[] = $row);
			case 'select':
			case 'show':
			case 'describe':
			case 'explain':
											for ($result = array(); $row = $resultSet->fetch_assoc(); $result[] = $row);
											break;
			case 'insert':
											$result = $resultSet ? self::$conn->insert_id : false;
											break;

			default:				$result = $resultSet;
		}

		return $result;
	}

	static private function checkParam($value, $type)
	{
		if (!is_array($value))
		{
			return self::checkSingleParam($value, $type);
		}

		if ($type != 'a' && $type != '#')
		{
			return false;
		}

		return self::checkArrayParam($value, $type);
	}

	static private function checkSingleParam($value, $type)
	{
		$value = trim($value);

		if ($value === CMS_DB_SKIP)
			return CMS_DB_SKIP;

		if ($value === '' && $type !== 's')
			return false;

		switch (strtolower($type))
		{
			case 'd':	if (!settype($value, 'integer'))
							return false;
						break;
			case 'f':	if (!settype($value, 'float'))
							return false;
						break;
			case 's':	$value = self::escape($value);
						break;
			case '#':	$value = self::escape($value, true);
						break;
			default:	return false;
		}

		return $value;
	}

	static private function escape($value, $isIdent = false)
	{
		if (!$isIdent)
		{
			return "'" . self::$conn->real_escape_string($value) . "'";
		}

		$word_as = ' as ';

		$value = self::replaceTablePrefix($value);
		$value = str_ireplace($word_as, $word_as, $value);

		$pseoudonim_parts = explode($word_as, $value, 2);

		foreach ($pseoudonim_parts as $i => $part)
		{
			$pseoudonim_parts[$i] = trim($part);
		}

		$ident_parts = explode('.', $pseoudonim_parts[0]);

		foreach ($ident_parts as $i => $part)
		{
			$ident_parts[$i] = self::identEscape($part);
		}

		$ident = implode('.', $ident_parts);

		if (count($pseoudonim_parts) === 2)
		{
			return $ident . $word_as . self::identEscape($pseoudonim_parts[1]);
		}

		return $ident;
	}

	static private function identEscape($value)
	{
		return '`' . str_replace('`', '``', $value) . '`';
	}

	static private function replaceTablePrefix($str)
	{
		return str_replace('?_', self::$prefix, $str);
	}

	static private function checkArrayParam($array, $type)
	{
		$isAssoc = false;
		$aTemp = array();

		if (!isset($array[0]) && $type != '#')
		{
			$isAssoc = true;
		}

		foreach ($array as $key => $v)
		{
			$value = self::checkArrayCellValue($v, $type);

			if (!$value)
			{
				return false;
			}

			// $str = $isAssoc ? $key . ' = ' : '';
			$str = $isAssoc ? self::escape($key, true) . ' = ' : '';

			$aTemp[] = $str . $value;
		}

		return implode(', ', $aTemp);
	}

	static private function checkArrayCellValue($cell, $type)
	{
		if ($type != '#')
		{
			if (is_numeric($cell))
			{
				if (strpos($cell, '.') > 0 || strpos($cell, ',') > 0)
					$type = 'f';
				else
					$type = 'd';
			}
			else
				$type = 's';
		}

		return self::checkSingleParam($cell, $type);
	}

}