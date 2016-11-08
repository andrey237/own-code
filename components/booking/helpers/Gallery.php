<?php

class Gallery
{
  private $_path;
  private $_thumbs_path;
  private $_effect_thumbs_path;
  private $_thumb_sizes;

  private $_items = array();
  private $_types = array(
    'image/jpeg' => 'jpeg',
    'image/pjpeg' => 'jpeg',
    'image/png' => 'png',
    'image/gif' => 'gif'
  );

  private static $_db;

  public function __construct($path, $get_files = true, array $thumb_sizes = array(200, 200), array $types = array())
  {
    $this->_path = $path;
    $this->_thumbs_path = $this->_path . 'thumbs'. F_DS;
    $this->_effect_thumbs_path = $this->_thumbs_path . 'effect'. F_DS;

    $this->_thumb_sizes = array(
      'width' => $thumb_sizes[0],
      'height' => $thumb_sizes[1]
    );

    if (count($types))
    {
      $this->_types = $types;
    }

    // if ($get_files)
    // {
    //   $files = scandir($this->_path);

    //   foreach ($files as $i => $value)
    //   {
    //     if (is_dir($this->_path . $value))
    //     {
    //       continue;
    //     }

    //     $this->_items[] = new GalleryItem($this->_path, $value);
    //   }
    // }

    self::$_db = new mysqli('localhost', 'root', '', 'reasanik') or
      die('Ошибка соединения с базой данных! ' . self::$_db->connect_error());

    self::$_db->set_charset('utf8') or
      die('Ошибка выполнения дополнительных параметров соединения с базой данных! ' . self::$_db->connect_error());
  }

  public function getItem($name)
  {
    return $this->_path . $name;
  }

  public function getItems()
  {
    $result = self::$_db->query('
      SELECT `id`, `title`
      FROM `reasanik`.`gallery_item`
    ');

    while ($row = $result->fetch_assoc())
    {
      // $this->_items[ $row['id'] ]->_title = $row['title'];
      $this->_items[] = new GalleryItem($this->_path, $row['id'], $row['title']);
    }

    return $this->_items;
  }

  public function addItem(array $file, array $props)
  {
    if (!$this->checkType($file['type']))
    {
      Messages::addErrorMessage('Недопустимый формат файла!');
      return false;
    }

    if ($file['error'])
    {
        switch($file['error'])
        {
          case UPLOAD_ERR_INI_SIZE:
            Messages::addErrorMessage('Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini!');
            return false;
          case UPLOAD_ERR_FORM_SIZE:
            Messages::addErrorMessage('Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме!');
            return false;
          case UPLOAD_ERR_PARTIAL:
            Messages::addErrorMessage('Загружаемый файл был получен только частично!');
            return false;
          case UPLOAD_ERR_NO_FILE:
            Messages::addErrorMessage('Файл не был загружен!');
            return false;
        }
    }

    self::$_db->query('
      INSERT INTO `reasanik`.`gallery_item` (`title`, `file_type_id`, `gallery_id`)
      VALUES (
        \'' . self::$_db->real_escape_string($props['title']) . '\',
        1,
        1
      )'
    )
    or die('Ошибка выполнения запроса! ' . self::$_db->connect_error());

    if (self::$_db->affected_rows <= 0)
    {
      return false;
    }

    $id = self::$_db->insert_id;

    if (!move_uploaded_file($file['tmp_name'], $this->_path . $id . $this->_types[ $file['type'] ]))
    {
      Messages::addErrorMessage('Не удалось загрузить изображение!');
      return false;
    }

    $this->createThumbs($id, $this->_types[ $file['type'] ]);

    $is_image = strpos($file['type'], 'image/') !== false ? true : false;

    if ($is_image)
    {
      $parts = explode('image/', $file['type']);
      $type = $parts[1];
    }

    // $result = mysql_query('
    //   SELECT id
    //   FROM reasanik.gallery_file_type
    //   WHERE is_image = ' . $is_image . ' and type = ' . $type . '
    //   )',
    //   self::$_db)
    // or die('Ошибка выполнения запроса! ' . mysql_error());

    return true;
  }

  public function deleteItem($file_name)
  {
    $file = $this->_path . $file_name;
    $thumb_file = $this->_thumbs_path . $file_name;
    $effect_thumb_file = $this->_effect_thumbs_path . $file_name;

    if (!file_exists($file))
    {
      return false;
    }

    if (file_exists($effect_thumb_file) && !unlink($effect_thumb_file))
    {
      return false;
    }

    if (file_exists($thumb_file) && !unlink($thumb_file))
    {
      return false;
    }

    if (!unlink($file))
    {
      return false;
    }

    return true;
  }

  private function checkType($cheking_type)
  {
    if (!isset($this->_types[$cheking_type]))
    {
      return false;
    }

    return true;
  }

  private function createThumbs($file_name, $file_type)
  {
    $size = getimagesize($this->_path . $file_name);

    if (!file_exists($this->_thumbs_path . $file_name))
    {
      $func_image_create_from = 'imagecreatefrom' . $file_type;

      $image = $func_image_create_from($this->_path . $file_name);
      $new_image = imagecreatetruecolor(
        $this->_thumb_sizes['width'],
        $this->_thumb_sizes['height']
      );

      $this->createThumb(
        $image,
        $new_image,
        array(
          'full_name' => $this->_thumbs_path . $file_name,
          'type' => $file_type
        ),
        array('w' => $size[0], 'h' => $size[1])
      );

      $this->createThumb(
        $image,
        $new_image,
        array(
          'full_name' => $this->_effect_thumbs_path . $file_name,
          'type' => $file_type
        ),
        array('w' => $size[0], 'h' => $size[1]),
        IMG_FILTER_GRAYSCALE
      );

      imagedestroy($new_image);
      imagedestroy($image);
    }
  }

  private function createThumb($or_image, $th_image, array $file, array $or_sizes, $filter = false)
  {
    $func_image = 'image' . $file['type'];

    if ($file['type'] !== 'jpeg')
    {
      imagealphablending($th_image, false);
      imagesavealpha($th_image, true);
    }

    if (imagecopyresampled($th_image, $or_image, 0, 0, 0, 0, $this->_thumb_sizes['width'], $this->_thumb_sizes['height'], $or_sizes['w'], $or_sizes['h']))
    {
      if ($filter !== false)
      {
        imagefilter($th_image, $filter);
      }

      $func_image($th_image, $file['full_name']);
    }
  }
}

class GalleryItem
{
  private $_image_dir;
  private $_image_file;

  private $_id;
  private $_title;

  public function __construct($image_dir, $id, $title, $file_type)
  {
    $this->_title = $title;
    $this->_id = $id;
    $this->_image_dir = $image_dir;
    $this->_image_file = $id . '.' . $file_type;
  }

  public function getImageFile()
  {
    return $this->_image_file;
  }

  public function __set($property, $value)
  {
    $this->$property = $value;
  }

  public function __get($property)
  {
    return $this->$property;
  }
}
