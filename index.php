<?php

//	Сохранение путей в константы
//	Разделитель каталогов: Windows - '\', остальные - '/'
defined('CMS_DS') or define('CMS_DS', DIRECTORY_SEPARATOR);

//	Корень приложения
defined('CMS_BASE_PATH') or define('CMS_BASE_PATH', dirname(__FILE__));

//	Путь к фреймворку
defined('CMS_FRAMEWORK_PATH') or define('CMS_FRAMEWORK_PATH',  CMS_BASE_PATH . CMS_DS . 'framework' . CMS_DS);

//	Путь к пользовательскому ПО (Контроллеры, экшены, шаблоны, вьюхи и т.д.)
// defined('CMS_APPLICATION_PATH') or define('CMS_APPLICATION_PATH', CMS_BASE_PATH . CMS_DS . 'protected' . CMS_DS);
defined('CMS_APPLICATION_PATH') or define('CMS_APPLICATION_PATH', CMS_BASE_PATH . CMS_DS);

defined('CMS_IMAGES_PATH') or define('CMS_IMAGES_PATH', CMS_BASE_PATH . CMS_DS . 'images' . CMS_DS);

//	Сохранение конфига в переменную $config
// $config = dirname(__FILE__) . '/config.php';

// var_dump($config);
//	Подключение главного класса фреймворка
require_once(dirname(__FILE__) . '/framework/CMS.php');

//	Запуск фреймворка
// CMS::run($config);
CMS::run(dirname(__FILE__) . '/config.php');