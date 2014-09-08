<?php

class LocationmanagerModule extends CWebModule
{
    public $installUrl='/locationmanager/locationmanager/install';
    public $installrenderUrl='/locationmanager/install';
    public $rendermanagerUrl='/locationmanager/manager';
    public $managerUrl='/locationmanager/locationmanager/manager';
    public $locationmanagerTable='{{locationmanager}}';
    public $updateUrl='/locationmanager/locationmanager/update';
    public $insertUrl='/locationmanager/locationmanager/insert';
    public $deleteUrl='/locationmanager/locationmanager/delete';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'locationmanager.models.*',
			'locationmanager.components.*',
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
