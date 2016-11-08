<?php

class BookingModel extends Model
{
  public function __construct()
  {
    // DB::$prefix = 'booking_';
    DB::addPrefix('booking');
    DB::connect();
  }
}