<?php

//	Класс отображения активного шаблона. В основном в шаблонах прописывается вся вёрстка.
class HTML extends BaseComponent
{
  static public $image_types = array(
    'image/jpeg' => 'jpeg',
    'image/pjpeg' => 'jpeg',
    'image/png' => 'png',
    'image/gif' => 'gif'
  );

	static public function link($href = '#', $title = '', $class_str = false, $id = false)
	{
		// $a = '<a href="' . $_SERVER['HOST_NAME'] . '/' . $href . '"';

		$a = '<a href="' . CMS::$root . $href . '"';

		if ($id)
		{
			$a .= ' id="' . $id . '"';
		}

		if ($class_str)
		{
			$a .= ' class="' . $class_str . '"';
		}

		$a .= '>' . $title . '</a>';

		echo $a;
	}

	static public function beginForm($action = '', $class_str = false, $data_type = false, $method = 'post', $id = false)
	{
		$form = '<form';

		if ($action)
		{
			$form .= ' action="' . CMS::$root . $action . '"';
		}

		$form .= ' method="' . $method . '"';

		if ($id)
		{
			$form .= ' id="' . $id . '"';
		}

		if ($class_str)
		{
			$form .= ' class="' . $class_str . '"';
		}

		switch ($data_type)
		{
			case 'file': $form .= ' enctype="multipart/form-data"';
		}

		$form .= '>';

		echo $form;
	}

	static public function endForm()
	{
		echo '</form>';
	}

  static public function htmlEscapeStr($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }

	static public function submit($value = 'Send', $class_str = false, $name = false, $id = false)
	{
		$submit = '<input type="submit"';

		if ($id)
		{
			$submit .= ' id="' . $id . '"';
		}

		if ($class_str)
		{
			$submit .= ' class="' . $class_str . '"';
		}

		if ($name)
		{
			$submit .= ' name="' . $name . '"';
		}

		$submit .= 'value="' . $value . '">';

		echo $submit;
	}

	static public function image($src, $alt = '', $image_type = false, $class_str = false, $id = false)
	{
		// $image = '<img src="' . CMS::$root . $src . '" alt="' . $alt . '"';

		$image = '<img src="' . CMS::$root . $src . '.';

		if (!$image_type)
		{
			$image .= self::$image_types['image/jpeg'] . '"';
		}
		else
		{
			$image .= $image_type . '"';
		}

		$image .= ' alt="' . self::htmlEscapeStr($alt) . '"';

		if ($id)
		{
			$image .= ' id="' . $id . '"';
		}

		if ($class_str)
		{
			$image .= ' class="' . $class_str . '"';
		}

		$image .= '>';

		echo $image;
	}

}