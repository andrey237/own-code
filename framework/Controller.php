<?php

//	Служит для обработки входных данных и группировки экшенов.
class Controller extends BaseComponent
{
	// private $action;
	// private $actionValues = array();

	protected $action;
	protected $id;
	protected $title;
  protected $component;

  protected $params;
	protected $data;

	// protected $view_path;
	protected $view_title;
	protected $view;

	public function __construct($action_alias, $params = false)
	{
		// $actions = $this->actions();

		// if (!isset($actions[$actionAlias]['class']))
		// 	return false;

		// $this->actionValues['view'] = $actionAlias;
		// $this->actionValues['data'] = $data;

		// foreach ($actions[$actionAlias] as $key => $value)
		// 	$this->actionValues[$key] = $value;
		// //var_dump($this->actionValues);
		// $this->action = $actions[$actionAlias]['class'];

		$this->id = get_class($this);
		$this->action = $action_alias . 'Action';
    $this->params = $params;

		// $this->view = CMS::getObjNameWithoutType($id, 'Controller') . CMS_DS . $action_alias . 'View';
		// $this->view = ucfirst(CMS::getObjNameWithoutType($id, 'Controller')) . ucfirst($action_alias) . 'View';
		$this->view = $action_alias;
	}

	public function run()
	{
		if (!method_exists($this, $this->action))
		{
			$this->error404();
			return false;
		}

		call_user_func(array($this, $this->action));
    // var_dump($this->view);
		// new $this->view($this->title, $this->view_title);

		$this->render($this->view, $this->params);
	}

  private function render($view, $params = false, $controller = false, $component = false)
  {
    // var_dump(CMS_APPLICATION_PATH . 'views' . CMS_DS . CMS::getObjNameWithoutType($this->_controller, 'Controller') . CMS_DS . $view . '.php');
    // var_dump($this->_title);
    // Template::beginHeader($this->title . $this->view_title);
    // Template::endHeader();
    // $this->renderPartial($view, $params, $controller);
    // // $this->renderPartial($this->view, $params);
    // Template::endBody();

    if ($params)
    {
      $this->data['params'] = $params;
    }

    // rs_var_dump($this->id);
    $contr = $controller ? $controller : CMS::getObjNameWithoutType($this->id, 'Controller');
    // rs_var_dump(ucfirst($this->component));
    // rs_var_dump($contr);
    // $contr = lcfirst(str_replace(ucfirst($this->component), '', $contr));

    $comp = $component ? $component : $this->component;
    $contr = lcfirst(str_replace(ucfirst($comp), '', $contr));

    Template::init($comp, $contr, $view, $this->title . $this->view_title, $this->data);
    Template::render();
  }

  // private function renderPartial($view, $params = false, $controller = false)
  // {
  //   $contr = $controller ? $controller : CMS::getObjNameWithoutType($this->id, 'Controller');
  //   require_once(CMS_APPLICATION_PATH . 'views' . CMS_DS . $contr . CMS_DS . $view . '.php');
  // }

	protected function error404()
	{
    // rs_var_dump($this->component);
    $this->render('404', $this->params, 'Errors', 'system');
	}

	// public function createAction()
	// {
	// 	$actionObj = new $this->action($this->id, $this->actionValues);

	// 	unset($this->actionValues);

	// 	return $actionObj;
	// }

	// protected function actions()
	// {
	// 	return array();
	// }
}