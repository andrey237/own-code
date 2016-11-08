<?php

class ShopModel extends Model
{
  public function __construct()
  {
    // DB::$prefix = 'shop_';
    DB::addPrefix('shop');
    DB::connect();
  }
}