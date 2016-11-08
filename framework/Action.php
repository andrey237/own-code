<?php

//	Финальный этап обработки данных и вывода представления активного шаблона.
class Action extends BaseComponent
{
	public $controller;
	public $id;

	public $controllerPath;
	public $path;

	protected $title;
	protected $view;

	public function __construct($controller, $actionValues, $params = false)
	{
		var_dump($actionValues);

		foreach ($this as $key => $value)
		{
			if (isset($actionValues[$key]))
			{
				$this->$key = $actionValues[$key];
			}
		}

		$this->id = $actionValues['class'];
		$this->controller = $controller;
	}

	public function run()
	{
		// $classView = ucfirst (CMS::getObjNameWithoutType($this->_id, 'Action')) . 'View';
		// new $classView();

		$this->render($this->view);
	}

	private function render($view, $params = false)
	{
	 	// var_dump(CMS_APPLICATION_PATH . 'views' . CMS_DS . CMS::getObjNameWithoutType($this->_controller, 'Controller') . CMS_DS . $view . '.php');
		// var_dump($this->_title);
		Template::beginHeader($this->title);
		Template::endHeader();
		$this->renderPartial($view, $params);
		Template::endBody();
	}

	private function renderPartial($view, $params = false)
	{
		require_once(CMS_APPLICATION_PATH . 'views' . CMS_DS . CMS::getObjNameWithoutType($this->controller, 'Controller') . CMS_DS . $view . '.php');
	}
}