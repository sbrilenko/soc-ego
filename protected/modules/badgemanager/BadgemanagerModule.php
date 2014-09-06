<?php

class BadgemanagerModule extends CWebModule
{
    public $installUrl="/badgemanager/badges/install";
    public $installrenderUrl="/badges/install";
    public $updateUrl="/badgemanager/badges/update";
    public $deleteUrl="/badgemanager/badges/delete";
    public $badgeusermanagerUrl="/badgemanager/badges/badgeusermanager";
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'badgemanager.models.*',
			'badgemanager.components.*',
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
