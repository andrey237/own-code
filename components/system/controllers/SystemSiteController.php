<?php

class SystemSiteController extends SystemController
{
	// public function run()
	// {
	// 	// $Gallery = new GalleryModel();
	// 	// $data['items'] = $Gallery->getItems();
	// 	$this->data['items'] = 'fghghjhjkvghjghj';
	// }

	// protected function actions()
	// {
	// 	return array(
	// 					'main' => array(
	// 						'class' => 'MainAction',
	// 						'title' => 'Главная'
	// 					),
	// 					'products' => array(
	// 						'class' => 'ProductsAction',
	// 						'title' => 'Товары'
	// 					),
	// 				);
	// }

	public function defaultAction()
	{
		echo "Он меня запустил!";
	}

}