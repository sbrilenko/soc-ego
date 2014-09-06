<?php

class LevellistModule extends CWebModule
{
    public $installUrl="/levellist/levellist/install";
    public $installrenderUrl="/levellist/install";
    public $updateUrl="/levellist/levellist/update";
    public $createUrl="/levellist/levellist/create";
    public $deleteUrl="/levellist/levellist/delete";
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'levellist.models.*',
			'levellist.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
