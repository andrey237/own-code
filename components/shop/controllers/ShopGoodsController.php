<?php

class ShopGoodsController extends ShopController
{
  public $items;

  protected $title = 'Товары';
  private $model;

	public function defaultAction()
	{
    // $this->title = 'Товары';
		$this->model = new ShopGoodsModel();
    // $this->items = $this->model->getItems();
    $this->data['items'] = $this->model->getItems();
	}

}