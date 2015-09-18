<?php

class UserController extends Controller
{
    public $layout='//layouts/admin';
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view', 'show'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
        $profile=new Profile();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['User']) && isset($_POST['Profile']))
		{
			$model->attributes=$_POST['User'];
            $model->email=trim(strtolower($_POST['User']['email']));
            $model->work_count=isset($model->work_count) && !empty($model->work_count) ?strtotime($_POST['User']['work_count']):0;
            $model->day_count=isset($model->day_count) && !empty($model->day_count)?strtotime($_POST['User']['day_count']):0;
            $profile->attributes=$_POST['Profile'];
            $profile->bday=isset($profile->bday)?strtotime($_POST['Profile']['bday']):0;
			if($model->save())
            {
                $profile->user_id=$model->id;
                if(isset($_FILES['Profile']) && !empty($_FILES['Profile']['name']['avatar']))
                {
                    $file_ret=Files::model()->create($_FILES['Profile'],'avatar',$title='test',Profile::model()->tableName());
                    if(is_array($file_ret))
                    {
                        $this->render('create',array('message'=>$file_ret[0], 'model'=>$model));
                    }
                    else
                    {
                        $profile->avatar=$file_ret;
                        if($profile->save())
                        {
                            $this->redirect('index');
                        }
                        else
                        {
                            $this->render('create',array('message'=>'badges model not saved! Please ask your specialist', 'model'=>$model));
                        }
                    }
                }
                else
                {
                    $this->render('create',array('message'=>'please put the image', 'model' => $model));
                }
                if($profile->save())
                {
                    $this->redirect(array('view','id'=>$model->id));
                }
                else
                {
                    $this->render('create',array(
                        'model'=>$model,
                        'profile'=>$profile,
                    ));
                }
            }
		}
		$this->render('create',array(
			'model'=>$model,
            'profile'=>$profile,
            'message' => ''
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        if($model)
        {
            $profile=Profile::model()->findByAttributes(array("user_id"=>$model->id));
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if(isset($_POST['User']) && isset($_POST['Profile']))
        {
            $model->attributes=$_POST['User'];
            $model->work_count=isset($model->work_count) && !empty($model->work_count) ?strtotime($_POST['User']['work_count']):0;
            $model->day_count=isset($model->day_count) && !empty($model->day_count)?strtotime($_POST['User']['day_count']):0;

            if($model->save())
            {
                $profile->user_id=$model->id;

                if(isset($_FILES['Profile']) && !empty($_FILES['Profile']['name']['avatar']))
                {
                    $file_ret=Files::model()->create($_FILES['Profile'],'avatar','test',Profile::model()->tableName(),$profile->avatar);
                    if(is_array($file_ret))
                    {
                        $this->render('update',array('model'=>$model,'message'=>$file_ret[0]));
                        exit();
                    }
                    else
                    {
                        $profile->attributes=$_POST['Profile'];
                        /**
                         * checking if BDay is not number (we're expecting timestamp)
                         * if no then let's convert it to timestamp
                         */
                        if(!is_numeric($profile->bday)) {
                            $profile->bday = strtotime($profile->bday);
                        }
                        $profile->avatar=$file_ret;
                        if($profile->save())
                        {
                            $this->redirect(array('view','id'=>$model->id));
                        }
                        else
                        {
                            $this->render('update',array(
                                'model'=>$model,
                                'message'=>''
                            ));
                            exit();
                        }
                    }
                }
                else
                {
                    $image=$profile->avatar;
                    $profile->attributes=$_POST['Profile'];
                    $profile->bday=isset($profile->bday)?strtotime($profile->bday):0;
                    $profile->avatar=$image;
                    if($profile->save())
                    {
                        $this->redirect(array('view','id'=>$model->id));
                    }
                    else
                    {
                        $this->render('update',array(
                            'model'=>$model,
                            'message'=>''
                        ));
                    }
                }
            }
            else
            {
                $this->render('update',array(
                    'model'=>$model,
                    'message'=>''
                ));
            }
        }
        else
        $this->render('update',array(
            'model'=>$model,
            'message'=>''
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionShow($id) {
        $model = User::model()->findByPk($id);
        $this->render('//site/index',array("model"=>$model,
                                    'avatar'=>Profile::model()->getLittleAvatar($id),
                                    'name'=>Profile::model()->getName($id),
                                    'location'=>LocationManager::model()->getLocation($id),
                                    'birthday'=>$this->renderPartial('//site/birthday',array('img'=>Profile::model()->birthdayImg($id),
                                                                                      'date'=>Profile::model()->birthdayDate($id),
                                                                                      'name'=>Profile::model()->birthdayName($id)),true),
                                    'rank'=>$this->renderPartial('//site/rank',array('img_class'=>Profile::model()->rankImgClass($id),
                                                                              'title'=>Profile::model()->jobTitle($id),
                                                                              'type'=>Profile::model()->jobType($id)),true),

                                    'store'=>$this->renderPartial('//site/store',array('stores'=>Store::model()->getCountAllVisibleItem()),true),
                                    'company'=>$this->renderPartial('//site/company',array('img'=>Profile::model()->companyImg($id)),true),
        ));
    }
}
