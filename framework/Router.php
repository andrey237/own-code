<?php

class Router
{
	static public function parse($url)
	{
		//$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];

		// self::$root = '/shop.test/';
		// Template::$root = '/';

		$is_admin = false;
		$a_result = array();

		$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		// var_dump($url);
		$url = str_replace(CMS::$root, '/', $url);
		// var_dump($url);
		$url_parts = explode('/', trim($url, ' /'));
		// var_dump($url_parts);
		if (empty($url_parts[0]))
		{
			$url_parts = explode('/', CMS::$defaults['controller']);
		}

		// $query = $_SERVER['QUERY_STRING'];

		// if (isset($query) && !empty($query))
		// {
		// 	$aQuery = explode('&', $query);
		// }
		// else
		// {
		// 	$aQuery = array();
		// }

		// $contrClass = ucfirst($url_parts[0]) . 'Controller';
		// $actionAlias = $url_parts[1];

		$a_result['component'] = self::getComponentName($url_parts[0]);

		$contrClass = self::hyphen2CamelCase($url_parts[0], true) . 'Controller';

		if (isset($url_parts[1]))
		{
			$actionAlias = self::hyphen2CamelCase($url_parts[1]);
			$i = 2;
		}
		elseif (isset(CMS::$defaults['action']))
		{
			$actionAlias = CMS::$defaults['action'];
			$i = 1;
		}

		$params = array();

		for ($len = count($url_parts); $i < $len; $i += 2)
		{
			// $parts = explode('=', $aQuery[$i]);
			$next_i = $i + 1;

			if (isset($url_parts[$next_i]))
			{
				$params[$url_parts[$i]] = $url_parts[$next_i];
			}
		}

		$a_result['controller'] = $contrClass;
		$a_result['action_alias'] = $actionAlias;
		$a_result['params'] = $params;

		return $a_result;
	}

	static private function hyphen2CamelCase($str, $ucFirst = false)
	{
		$result = '';
		$parts = explode('-', $str);

		foreach ($parts as $i => $value)
		{
			$result .= ucfirst($value);
		}

		if (!$ucFirst)
		{
			$result = lcfirst($result);
		}

		return $result;
	}

	static private function getComponentName($str)
	{
		$parts = explode('-', $str, 2);

		if (count($parts) < 2)
		{
			return false;
		}

		return $parts[0];
	}

}
