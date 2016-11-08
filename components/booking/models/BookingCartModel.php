<?php

class BookingCartModel extends Model
{
	public function __construct()
  {
    DB::connect();
  }

  public function getItem($id)
  {
    $result = DB::query(
      '
        SELECT ?#
        FROM ?#
        WHERE ?# = ?d
      ',
      array('id', 'title', 'price'),
      'products',
      'id',
      $id
    );

    return $result[0];
  }

}