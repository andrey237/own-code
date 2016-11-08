<?php

class BookingProductController extends BookingController
{
  public $item;

  private $model;

	public function defaultAction()
	{
		$this->model = new BookingProductModel($this->params['id']);
    // $this->item = $this->model->getItem();
    $this->data['item'] = $this->model->getItem();

    // $this->title .= $this->item['title'];
    $this->title .= $this->data['item']['title'];
	}

}