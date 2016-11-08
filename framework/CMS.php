<?php

//	В рабочем приложении должен быть как false
defined('CMS_DEBUG') or define('CMS_DEBUG', false);

//	Базовый класс
class CMS
{
	static public $site_name;
	// static public $root = '/cms.test/';
	static public $root;
	static public $db_connection_string;
	static public $defaults;

	static private $application_path;
	static private $pathes = array(
									'models' => 'models',
									'controllers' => 'controllers',
									'actions' => 'actions',
									'views' => 'views',
									'components' => 'components',
									'templates' => 'templates',
								);
	static private $core_classes = array(
										'BaseComponent' => 'BaseComponent.php',
										'DB' => 'DB.php',
										'Router' => 'Router.php',
										'Model' => 'Model.php',
										'Controller' => 'Controller.php',
										'Action' => 'Action.php',
										'HTML' => 'HTML.php',
										'Template' => 'Template.php',
										'View' => 'View.php',
									);

	//	Точка входа в приложение
	static public function run($config)
	{
		self::init($config);

		session_start();
		
		$url_parts = Router::parse($_SERVER['REQUEST_URI']);

		// rs_var_dump($url_parts['controller']);
		if (!class_exists($url_parts['controller']))
		{
			$contrObj = new SystemErrorsController($url_parts['action_alias'], $url_parts['params']);
			$contrObj->run();
			return false;
		}

		// rs_var_dump($url_parts['controller']);
		// rs_var_dump($url_parts['action_alias']);
		// rs_var_dump($url_parts['params']);
		$contrObj = new $url_parts['controller']($url_parts['action_alias'], $url_parts['params']);

		// rs_var_dump($contrObj);
		$contrObj->run();
	}

	//	Прописывание путей для базовых классов и классов пользователя
	static private function init($config)
	{
		$config = require($config);

		self::$site_name = $config['name'];
		self::$application_path = $config['application_path'];
		self::$root = $config['root_dir'];

		foreach (self::$pathes as $key => $value)
		{
			self::$pathes[$key] = self::$application_path . $value . CMS_DS;
		}

		self::$defaults = $config['defaults'];

		DB::addPrefix($config['db']['prefix']);
		DB::$connection_string = $config['db']['connection_string'];
	}

	static public function redirect($page = false)
  {
    // if (!$page && $_SERVER['HTTP_REFERER'])
    // {
    //   $page = $_SERVER['HTTP_REFERER'];
    // }
  	// rs_var_dump($page);
    header('location: ' . self::$root . $page);
    exit();
  }

	static public function getControllerAndAction($str)
	{
		$contrPos = strpos($str, 'r=') !== false ? 2 : 0;
		// rs_var_dump($contrPos);
		$value = substr($str, $contrPos);
		$parts = explode('/', $value);
		
		if (count($parts) != 2)
			return false;
		
		if (!$parts[0] || !$parts[1])
			return false;
		
		return array($parts[0] . 'Controller', lcfirst($parts[1]));
	}

	static public function getObjNameWithoutType($name, $type)
	{
		// $point = $isStatic ? '::' : '->';

		$components = explode($type, $name);

		if (count($components) != 2)
			return false;

		// return lcfirst($components[0]);
		return $components[0];
	}

	//	Автозагрузка классов. Сначала производится поиск в путях базовых классов.
	//	Если не найден класс, то поиск продолжается в пользовательских путях.
	//	Если и там не найден класс, то выдаётся ошибка подключения класса.
	static public function autoload($className)
	{
		if (isset(self::$core_classes[$className]))
		{
			include_once(CMS_FRAMEWORK_PATH . self::$core_classes[$className]);
			$searched = true;
		}
		else
		{
			foreach (self::$pathes as $type => $path)
			{
				if (!is_dir($path))
				{
					continue;
				}

				if (self::searchFile($path, $className))
				{
					$searched = true;
					break;
				}
			}
		}
	}

	static private function searchFile($path, $class_name)
	{
		$searched_file = $path . $class_name . '.php';

		// rs_var_dump($searched_file);
		if (file_exists($searched_file))
		{
			include_once($searched_file);
			return true;
		}

		$files = scandir($path);

		foreach ($files as $file)
		{
			$inner_path = $path . $file . CMS_DS;

			if (is_dir($inner_path) && $file !== '.' && $file !== '..')
			{
				if (self::searchFile($inner_path, $class_name))
				{
					return true;
				}
			}
		}

		return false;
	}

}

function rs_var_dump($value)
{
	?>
		<pre><?php var_dump($value) ?></pre>
	<?php
}

//	Регистрация функции автозагрузки классов
spl_autoload_register(array('CMS', 'autoload'));