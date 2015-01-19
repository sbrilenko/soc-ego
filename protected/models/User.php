<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $confirm_password
 * @property string $email
 * @property string $activationKey
 * @property integer $createtime
 * @property integer $lastvisit
 * @property integer $lastaction
 * @property integer $lastpasswordchange
 * @property integer $failedloginattempts
 * @property integer $superuser
 * @property integer $status
 * @property integer $day_count
 * @property string $points
 * @property integer $was_flag
 * @property integer $work_count
 * @property string $job_type
 * @property string $job_title
 * @property integer $level
 * @property string $start_month
 * @property string $company_id
 * @property integer $rememberme
 */
class User extends CActiveRecord
{
    public $confirm_password;
    public $_identify;
    public $rememberme;
    public $error="";

    protected function beforeSave() {
        if ($this->isNewRecord)
        {
            $this->createtime=strtotime(date("Y-m-d H:i:s"));
            $this->password=$this->generate_pas($this->password,$this->createtime);
        }
        else
        {
            $this->password=$this->generate_pas($this->password,$this->createtime);
        }
        return parent::beforeSave();
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email', 'required'),
			array('createtime, company_id, lastvisit, lastaction, lastpasswordchange, failedloginattempts, superuser, status, day_count, was_flag, work_count, level', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>255),
			array('password, confirm_password', 'length', 'max'=>64),
            array('email', 'check_dublicates'),
            array('password', 'confirm'),
			array('activationKey', 'length', 'max'=>128),
			array('points', 'length', 'max'=>10),
			array('job_type, job_title, email', 'length', 'max'=>512),
			array('start_month', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, company_id, activationKey, createtime, lastvisit, lastaction, lastpasswordchange, failedloginattempts, superuser, status, day_count, points, was_flag, work_count, job_type, job_title, level, start_month', 'safe', 'on'=>'search'),
		);
	}
    public function check_dublicates()
    {
        $email_dubl=User::model()->findByAttributes(array('email'=>$this->email));
        if($email_dubl && $email_dubl->id!==$this->id)
        {
            $this->addError("email","User with this email already exist");
        }
    }
    public function confirm()
    {
        if($this->isNewRecord)
        {
            if(empty($this->password) || empty($this->confirm_password))
            {
                $this->addError("password"," Password cannot be empty");
            }
            elseif($this->password!==$this->confirm_password)
            {
                $this->addError("password"," Make sure that the passwords match");
            }
        }
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
            'rememberme'=>'Remember Me',
            'confirm_password'=>'Retype password',
            'email'=>'Email',
			'activationKey' => 'Activation Key',
			'createtime' => 'Createtime',
			'lastvisit' => 'Lastvisit',
			'lastaction' => 'Lastaction',
			'lastpasswordchange' => 'Lastpasswordchange',
			'failedloginattempts' => 'Failedloginattempts',
			'superuser' => 'Superuser',
			'status' => 'Status',
			'day_count' => 'Day Count',
			'points' => 'Points',
			'was_flag' => 'Was Flag',
			'work_count' => 'Work Count',
			'job_type' => 'Job Type',
			'job_title' => 'Job Title',
			'level' => 'Level',
			'start_month' => 'Start Month',
            'company_id' => 'Company',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('company_id',$this->company_id,true);
		$criteria->compare('activationKey',$this->activationKey,true);
		$criteria->compare('createtime',$this->createtime);
		$criteria->compare('lastvisit',$this->lastvisit);
		$criteria->compare('lastaction',$this->lastaction);
		$criteria->compare('lastpasswordchange',$this->lastpasswordchange);
		$criteria->compare('failedloginattempts',$this->failedloginattempts);
		$criteria->compare('superuser',$this->superuser);
		$criteria->compare('status',$this->status);
		$criteria->compare('day_count',$this->day_count);
		$criteria->compare('points',$this->points,true);
		$criteria->compare('was_flag',$this->was_flag);
		$criteria->compare('work_count',$this->work_count);
		$criteria->compare('job_type',$this->job_type,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('start_month',$this->start_month,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function generate_pas()
    {
        return crypt($this->password,$this->createtime);
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function login()
    {
        if($this->_identify==null)
        {
            $this->_identify=new UserIdentity($this->email,$this->password);
            $this->_identify->authenticate();
        }
        if($this->_identify->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration=$this->rememberme ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identify,$duration);
            return true;
        }
        else return false;
    }

    /*get all user from company*/
    public function getAllUsersByCompany($company_id)
    {
        if(isset($company_id) && $company_id>0 && Company::model()->findByPk($company_id))
        {
            return User::model()->findAllByAttributes(array("company_id"=>$company_id,"status"=>1));
        }
        else return array();
    }

    public function getLevel($user_id)
    {
        return User::model()->findByPk($user_id)->level;
    }

	/*return work_count*/
	public function getWorkCount($user_id)
	{
		return User::model()->findByPk($user_id)->work_count;
	}

	/*return job_type*/
	public function getJobType($user_id)
	{
		return User::model()->findByPk($user_id)->job_type;
	}


}
