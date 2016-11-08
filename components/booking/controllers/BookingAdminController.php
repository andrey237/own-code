<?php

class BookingAdminController extends BookingController
{
  public $item;

  private $model;

  private $admin_data = array(
    'admin' => 'admin',
    'password' => '12345'
  );

  // public function getadmin()
  // {
  //   $this->logout();
  //   $this->login();

  //   if (isset($_SESSION['admin']) && $_SESSION['admin'])
  //   {
  //     return $_SESSION['admin'];
  //   }

  //   return false;
  // }

  public function loginAction()
  {
    // var_dump($_POST);
    if (isset($_POST['login']))
    {
      if ($this->admin_data['admin'] === trim($_POST['admin']) &&
          $this->admin_data['password'] === trim($_POST['password']))
      {
        $_SESSION['admin'] = $this->admin_data['admin'];
      }
    }

    CMS::redirect($this->main_page);
  }

  public function logoutAction()
  {
    if (isset($_SESSION['admin']))
    {
      unset($_SESSION['admin']);
    }

    CMS::redirect($this->main_page);
  }

  public function createAction()
  {
    if (isset($_POST['create']))
    {
      $this->model = new BookingRoomsModel();
      $this->model->createItem($_POST['number'], $_POST['type_id'], 1, $_FILES['image']);
    }

    CMS::redirect($this->main_page);
  }

  public function updateAction($value='')
  {
    if (isset($_POST['update']))
    {
      $this->model = new BookingRoomsModel();
      $this->model->updateItem($this->params['id'], $_POST['title'], $_POST['description'], $_POST['price'], $_FILES['image']);
      CMS::redirect('shop-admin/update/id/' . $this->params['id']);
    }
    else
    {
      $this->model = new BookingProductModel($this->params['id']);

      $this->data['item'] = $this->model->getItem();
    }
  }

  public function deleteAction()
  {
    // $id = $this->params['id'];

    $this->model = new BookingRoomsModel();
    $this->model->deleteItem($this->params['id']);

    CMS::redirect($this->main_page);
  }

}