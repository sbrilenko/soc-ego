<?php

class GamificationManagerModule extends CWebModule
{
    public $installUrl='/gamificationmanager/gamificationmanager/install';
    public $installrenderUrl='/gamificationmanager/install';
    public $renderindexUrl='/gamificationmanager/index';
    public $indexUrl='/gamificationmanager/gamificationmanager/index';
    public $updateUrl='/gamificationmanager/gamificationmanager/update';
    public $addpositionUrl='/gamificationmanager/gamificationmanager/addposition';
    public $deleteUrl='/gamificationmanager/gamificationmanager/delete';
    public $gamificationmanagerTable='{{gamificationmanager}}';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'gamificationmanager.models.*',
			'gamificationmanager.components.*',
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
