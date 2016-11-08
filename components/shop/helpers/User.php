<?php

class User extends BaseComponent
{
  static public function isAdmin()
  {
    if (isset($_SESSION['admin']) && $_SESSION['admin'])
    {
      return $_SESSION['admin'];
    }

    return false;
  }

}
