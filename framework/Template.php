<?php

//	Класс отображения активного шаблона. В основном в шаблонах прописывается вся вёрстка.
class Template extends BaseComponent
{
  static private $title;
  static private $data;

  static private $component;
  static private $controller;
  static private $component_view;

  static public function init($component, $controller, $view, $title, $data = false)
  {
    self::$component = $component;
    self::$controller = $controller;
    self::$component_view = $view;

    self::$title = $title;

    if ($data)
    {
      self::$data = $data;
    }
  }

  static public function render()
  {
  	// var_dump(self::$title);
  	require_once(CMS_APPLICATION_PATH . 'templates' . CMS_DS . CMS::$defaults['template'] . CMS_DS . 'index.php');
  }

  static public function renderHead()
  {
    php?>
    <meta charset="<?php echo $charset ?>">
    <title><?php echo CMS::$site_name ?> - <?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo CMS::$root ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $datetimepicker_path ?>jquery.datetimepicker.css">
    <?
  }

  static public function renderComponent()
  {
    // require_once(CMS_APPLICATION_PATH . 'views' . CMS_DS . self::$controller . CMS_DS . self::$component_view . '.php');

    require_once(CMS_APPLICATION_PATH . 'components'
                             . CMS_DS . self::$component
                             . CMS_DS . 'views'
                             . CMS_DS . self::$controller
                             . CMS_DS . self::$component_view . '.php');
  }

	// static public function beginHeader($title, $charset = 'utf-8', $params = false)
	// {
	// 	echo '
	// 		<!DOCTYPE html>
	// 				<html>
	// 					<head>
	// 						<meta charset="'. $charset .'">
	// 						<title>' . CMS::$siteName . ' - ' . $title . '</title>
	// 						<link rel="stylesheet" href="' . CMS::$root . 'css/style.css">';
	// }

	// static public function endHeader()
	// {
	// 	echo '</head><body>
	// 		<header class="hor-menu">
	// 			<a href="' . CMS::$root . 'goods/read" class="button">Goods</a>
	// 			<a href="' . CMS::$root . 'cart/read" class="button">Cart</a>';

	//   if (isset($_SESSION['admin']) && $_SESSION['admin'])
	//   {
	//     echo '<a href="' . CMS::$root . 'admin/logout" class="button">Log out</a>';
	//   }
	//   else
	//   {
	//     echo '
	//     	<form action="' . CMS::$root . 'admin/login" method="post">
	//     		<input type="text" name="admin" placeholder="Admin" required="required">
	//     		<input type="text" name="password" placeholder="Password" required="required">
	//     		<input class="button" type="submit" name="login" value="Log in">
	//     	</form>';
	//   }

	// 	echo '</header><main>';
	// }

	// static public function endBody()
	// {
	// 	echo '</main></body></html>';
	// }

	// static public function createLink($href = '#', $title = '', $class_str = false, $id = false)
	// {
	// 	// $a = '<a href="' . $_SERVER['HOST_NAME'] . '/' . $href . '"';

	// 	$a = '<a href="' . CMS::$root . $href . '"';

	// 	if ($id)
	// 	{
	// 		$a .= ' id="' . $id . '"';
	// 	}

	// 	if ($class_str)
	// 	{
	// 		$a .= ' class="' . $class_str . '"';
	// 	}

	// 	$a .= '>' . $title . '</a>';

	// 	echo $a;
	// }

	// static public function beginForm($action = '', $class_str = false, $data_type = false, $method = 'post', $id = false)
	// {
	// 	$form = '<form';

	// 	if ($action)
	// 	{
	// 		$form .= ' action="' . CMS::$root . $action . '"';
	// 	}

	// 	$form .= ' method="' . $method . '"';

	// 	if ($id)
	// 	{
	// 		$form .= ' id="' . $id . '"';
	// 	}

	// 	if ($class_str)
	// 	{
	// 		$form .= ' class="' . $class_str . '"';
	// 	}

	// 	switch ($data_type)
	// 	{
	// 		case 'file': $form .= ' enctype="multipart/form-data"';
	// 	}

	// 	$form .= '>';

	// 	echo $form;
	// }

	// static public function endForm()
	// {
	// 	echo '</form>';
	// }

 //  static public function htmlEscapeStr($str)
 //  {
 //    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
 //  }

	// static public function createSubmit($value = 'Send', $class_str = false, $name = false, $id = false)
	// {
	// 	$submit = '<input type="submit"';

	// 	if ($id)
	// 	{
	// 		$submit .= ' id="' . $id . '"';
	// 	}

	// 	if ($class_str)
	// 	{
	// 		$submit .= ' class="' . $class_str . '"';
	// 	}

	// 	if ($name)
	// 	{
	// 		$submit .= ' name="' . $name . '"';
	// 	}

	// 	$submit .= 'value="' . $value . '">';

	// 	echo $submit;
	// }

	// static public function setImage($src, $alt = '', $image_type = false, $class_str = false, $id = false)
	// {
	// 	// $image = '<img src="' . CMS::$root . $src . '" alt="' . $alt . '"';

	// 	$image = '<img src="' . CMS::$root . $src . '.';

	// 	if (!$image_type)
	// 	{
	// 		$image .= self::$image_types['image/jpeg'] . '"';
	// 	}
	// 	else
	// 	{
	// 		$image .= $image_type . '"';
	// 	}

	// 	$image .= ' alt="' . self::htmlEscapeStr($alt) . '"';

	// 	if ($id)
	// 	{
	// 		$image .= ' id="' . $id . '"';
	// 	}

	// 	if ($class_str)
	// 	{
	// 		$image .= ' class="' . $class_str . '"';
	// 	}

	// 	$image .= '>';

	// 	echo $image;
	// }

}