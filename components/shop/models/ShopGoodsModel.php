<?php

class ShopGoodsModel extends ShopModel
{
  private $gallery_path;
  private $thumbs_path;
  private $effect_thumbs_path;

  private $thumb_sizes = array('w' => 270, 'h' => 270);

  public function __construct()
  {
    parent::__construct();

    $this->gallery_path = CMS_IMAGES_PATH . 'shop' . CMS_DS;
    $this->thumbs_path = $this->gallery_path . 'thumbs'. CMS_DS;
    $this->effect_thumbs_path = $this->gallery_path . 'effect-thumbs'. CMS_DS;
  }

  public function getItems()
  {
    return DB::query(
      '
        SELECT ?#
        FROM ?#
      ',
      array('id', 'title', 'price'),
      '?_products'
    );
  }

  public function createItem($title, $description, $price, $image)
  {
    $result = DB::query(
      '
        INSERT INTO ?# (?#)
        VALUES (?a)
      ',
      '?_products',
      array('title', 'description', 'price'),
      array($title, $description, $price)
    );

    if ($image['name'])
    {
      $this->addImage($image, $this->db->insert_id);
    }
  }

  public function updateItem($id, $title, $description, $price, $image)
  {
    $result = DB::query(
      '
        UPDATE ?#
        SET ?a
        WHERE ?# = ?d
      ',
      '?_products',
      array('title' => $title, 'description' => $description, 'price' => $price),
      'id',
      $id
    );

    if ($image['name'])
    {
      $this->deleteImage($id);
      $this->addImage($image, $id);
    }
    else
    {
      $this->createThumbs($id);
    }
  }

  public function deleteItem($id)
  {
    $result = DB::query(
      '
        DELETE
        FROM ?#
        WHERE ?# = ?d
      ',
      '?_products',
      'id',
      $id
    );

    $this->deleteImage($id);
  }

  private function addImage(array $file, $id)
  {
    if (!$this->checkType($file['type']))
    {
      // Messages::addErrorMessage('Недопустимый формат файла!');
      echo 'Недопустимый формат файла!';
      return false;
    }

    if ($file['error'])
    {
      switch($file['error'])
      {
        case UPLOAD_ERR_INI_SIZE:
          // Messages::addErrorMessage('Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini!');
          echo 'Размер принятого файла превысил максимально допустимый размер, который задан директивой upload_max_filesize конфигурационного файла php.ini!';
          return false;
        case UPLOAD_ERR_FORM_SIZE:
          // Messages::addErrorMessage('Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме!');
          echo 'Размер загружаемого файла превысил значение MAX_FILE_SIZE, указанное в HTML-форме!';
          return false;
        case UPLOAD_ERR_PARTIAL:
          // Messages::addErrorMessage('Загружаемый файл был получен только частично!');
          echo 'Загружаемый файл был получен только частично!';
          return false;
        case UPLOAD_ERR_NO_FILE:
          // Messages::addErrorMessage('Файл не был загружен!');
          echo 'Файл не был загружен!';
          return false;
      }
    }

    if (!move_uploaded_file($file['tmp_name'], $this->gallery_path . $id . '.' . Template::$image_types[ $file['type'] ]))
    {
      // Messages::addErrorMessage('Не удалось загрузить изображение!');
      echo 'Не удалось загрузить изображение!';
      return false;
    }

    $this->createThumbs($id, Template::$image_types[ $file['type'] ]);

    return true;
  }

  private function deleteImage($id, $type = false)
  {
    if (!$type)
    {
      $type = Template::$image_types['image/jpeg'];
    }

    $file_name = $id . '.' . $type;

    $file = $this->gallery_path . $file_name;
    $thumb_file = $this->thumbs_path . $file_name;
    $effect_thumb_file = $this->effect_thumbs_path . $file_name;

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
    if (!isset(Template::$image_types[$cheking_type]))
    {
      return false;
    }

    return true;
  }

  private function createThumbs($id, $file_type = false)
  {
    if (!$file_type)
    {
      $file_type = Template::$image_types['image/jpeg'];
    }

    $file_name = $id . '.' . $file_type;
    $size = getimagesize($this->gallery_path . $file_name);

    if (!file_exists($this->thumbs_path . $file_name))
    {
      $func_image_create_from = 'imagecreatefrom' . $file_type;

      $image = $func_image_create_from($this->gallery_path . $file_name);

      $new_image = imagecreatetruecolor(
        $this->thumb_sizes['w'],
        $this->thumb_sizes['h']
      );

      $this->createThumb(
        $image,
        $new_image,
        array(
          'full_name' => $this->thumbs_path . $file_name,
          'type' => $file_type
        ),
        array('w' => $size[0], 'h' => $size[1])
      );

      $this->createThumb(
        $image,
        $new_image,
        array(
          'full_name' => $this->effect_thumbs_path . $file_name,
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

    if (imagecopyresampled($th_image, $or_image, 0, 0, 0, 0, $this->thumb_sizes['w'], $this->thumb_sizes['h'], $or_sizes['w'], $or_sizes['h']))
    {
      if ($filter !== false)
      {
        imagefilter($th_image, $filter);
      }

      $func_image($th_image, $file['full_name']);
    }
  }

}