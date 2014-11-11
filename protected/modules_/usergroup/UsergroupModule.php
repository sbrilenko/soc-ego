<?php
Yii::setPathOfAlias('UsergroupModule' , dirname(__FILE__));

class UsergroupModule extends CWebModule {
    public $createUrl='/usergroup/groups/create';
	public $usergroupTable = '{{usergroup}}';
	public $usergroupMessageTable = '{{usergroup_message}}';
	public $userparticipationTable = '{{user_usergroup}}';

	public $adminLayout = 'user.views.layouts.yum';
	public $layout = 'user.views.layouts.yum';

	public $controllerMap=array(
			'groups'=>array(
				'class'=>'UsergroupModule.controllers.YumUsergroupController'),
			);

	public function init() {
		$this->setImport(array(
					'user.controllers.*',
					'user.models.*',
					'usergroup.controllers.*',
					'usergroup.models.*',
                    'files.controllers.*',
                    'files.models.*',
					));
	}


}
