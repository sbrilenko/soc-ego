<?php

/**
 * This is the model class for table "usergroup".
 *
 * The followings are the available columns in table 'usergroup':
 * @property integer $id
 * @property integer $image
 * @property integer $completed
 * @property string $title
 * @property string $description
 * @property integer $pm
 * @property integer $company
 * @property integer $time_create
 * @property integer $user_create
 * @property integer $time_update
 * @property integer $user_update
 */
class Usergroup extends CActiveRecord
{
    public $participants="";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usergroup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image, completed, title, description, pm, company, time_create, user_create', 'required'),
			array('image, completed, pm, company, time_create, user_create, time_update, user_update', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, image, completed, title, description, pm, company, time_create, user_create, time_update, user_update', 'safe', 'on'=>'search'),
		);
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
			'image' => 'Image',
			'completed' => 'Completed',
			'title' => 'Title',
			'description' => 'Description',
			'pm' => 'Pm',
            'company'=>'Company',
			'time_create' => 'Time Create',
			'user_create' => 'User Create',
			'time_update' => 'Time Update',
			'user_update' => 'User Update',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('image',$this->image);
		$criteria->compare('completed',$this->completed);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('pm',$this->pm);
        $criteria->compare('pm',$this->company);
        $criteria->compare('time_create',$this->time_create);
		$criteria->compare('user_create',$this->user_create);
		$criteria->compare('time_update',$this->time_update);
		$criteria->compare('user_update',$this->user_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usergroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


}
