<?php

class ShopProductModel extends ShopModel
{
  private $prod_id;

	public function __construct($id)
  {
    // $this->connectDB();
    parent::__construct();

    $this->prod_id = $id;
  }

  public function getItem()
  {
    $result = DB::query(
      '
        SELECT ?#
        FROM ?#
        WHERE ?#=?d
      ',
      array('id', 'title', 'price', 'description'),
      '?_products',
      'id',
      $this->prod_id
    );

    return $result[0];
  }

}