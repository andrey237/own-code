<?php

class BookingProductModel extends Model
{
  private $prod_id;

	public function __construct($id)
  {
    // $this->connectDB();
    DB::connect();
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
      'products',
      'id',
      $this->prod_id
    );

    return $result[0];
  }

}