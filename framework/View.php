<?php

//	В будущем может пригодится для более гибкого отображения представлений.
class View extends BaseComponent
{
	private $constructor_title;
  private $title;

	public function __construct($constructor_title, $title, $params = false)
	{
    $this->constructor_title = $constructor_title;
    $this->title = $title;

		$this->render($params);
	}

  protected function render($params = false)
  {
    // var_dump(CMS_APPLICATION_PATH . 'views' . CMS_DS . CMS::getObjNameWithoutType($this->_controller, 'Controller') . CMS_DS . $view . '.php');
    // var_dump($this->_title);
    Template::beginHeader($this->title);
    Template::endHeader();
    $this->renderPartial($view, $params);
    Template::endBody();
  }

  protected function renderPartial($params = false)
  {
  //   require_once(CMS_APPLICATION_PATH . 'views' . CMS_DS . CMS::getObjNameWithoutType($this->controller, 'Controller') . CMS_DS . $view . '.php');
  }
}