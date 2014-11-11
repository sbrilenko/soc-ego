<?php

class StoreModule extends CWebModule
{
    public $installUrl="/store/store/install";
    public $installrenderUrl="/store/install";
    public $updateUrl="/store/store/update";
    public $deleteUrl="/store/store/delete";
//    public $badgeusermanagerUrl="/store/store/badgeusermanager";
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
            'store.models.*',
			'store.components.*',
            'files.models.*',
            'files.components.*',
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
