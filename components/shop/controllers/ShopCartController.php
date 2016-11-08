<?php

class ShopCartController extends ShopController
{
  protected $title = 'Cart';

  private $items = array();
  private $total_price = 0;

  private $model;

  private function calculate($is_order = false)
  {
    if (!isset($_SESSION['cart']))
    {
      return false;
    }

    // if (is_array($_SESSION['cart']))
    // {
    //   return false;
    // }

    $model = new ShopCartModel();

    // var_dump($_SESSION['cart']);
    foreach ($_SESSION['cart'] as $id => $item_count)
    {
      $fields = $model->getItem($id);

      if ($fields)
      {
        $item_price = $fields['price'] * $item_count;

        $this->items[$id] = array(
          'title' => $fields['title'],
          'price' => $fields['price'],
          'count' => $item_count,
          'total_price' => $item_price,
        );

        $this->total_price += $item_price;
      }
      else
      {
        if (!$is_order)
        {
          $this->items[$id] = array(
            'title' => 'Sorry! This product was deleted',
            'error' => true
          );
        }

        unset($_SESSION['cart'][$id]);
      }
    }

    $this->data['items'] = $this->items;
    $this->data['total_price'] = $this->total_price;
  }

	public function defaultAction()
	{
    $this->calculate();
	}

  public function addAction()
  {
    $id = $this->params['id'];

    if (isset($_SESSION['cart'][$id]))
    {
      $_SESSION['cart'][$id]++;
    }
    else
    {
      $_SESSION['cart'][$id] = 1;
    }

    // rs_var_dump($_SESSION['cart']);
    CMS::redirect($this->cart_page);
  }

  public function deleteAction()
  {
    $id = $this->params['id'];

    if (isset($_SESSION['cart'][$id]))
    {
      unset($_SESSION['cart'][$id]);
    }

    CMS::redirect($this->cart_page);
  }

  public function changeAction()
  {
    $items = $_POST['cart'];

    foreach ($items as $id => $item_count)
    {
      if (!$item_count)
      {
        unset($_SESSION['cart'][$id]);
      }
      else
      {
        $_SESSION['cart'][$id] = $item_count;
      }
    }

    CMS::redirect($this->cart_page);
  }

  public function orderAction()
  {
    $this->calculate();
  }

  public function execOrderAction()
  {
    if (!isset($_SESSION['cart']))
    {
      CMS::redirect($this->main_page);
    }

    $this->calculate(true);

    $message = '<table>
      <tr>
        <th>Title</th>
        <th>Image</th>
        <th>Price</th>
        <th>Count</th>
        <th>Result price</th>
      </tr>';

    foreach ($this->items as $id => $values)
    {
      $message .= '
        <tr>
          <td><h2>' . $id . ': ' . $values['title'] . '</h2></td>
          <td><img src="http://' . $_SERVER['HTTP_HOST'] . CMS::$root . 'images/products/thumbs/' . $id . '.jpg" alt="' . $item['title'] . '"></td>
          <td>' . $values['price'] . ' X </td>
          <td>' . $values['count'] . ' = </td>
          <td>' . $values['total_price'] . '</td>
        </tr>';
    }

    $message .= '<tr><td cols="5">Total price: ' . $this->total_price . '</td></tr></table>';

    $message .= '<table><tr><td>FIO:</td>';
    $message .= '<td>' . $_POST['fio'] . '</td></tr>';

    $message .= '<tr><td>Phone:</td>';
    $message .= '<td>' . $_POST['phone'] . '</td></tr>';

    $message .= '<tr><td>E-mail:</td>';
    $message .= '<td>' . $_POST['email'] . '</td></tr></table>';

    $to = $_POST['email'];
    $subject = 'The my shop';
    // $message = var_dump($this->items);
    $headers = 'From: my@shop.com' . "\r\n"
             . 'Reply-To: my@shop.com' . "\r\n"
             . 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    unset($_SESSION['cart']);
  }

}