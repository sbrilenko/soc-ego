<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property string $id
 * @property integer $avatar
 * @property string $user_id
 * @property string $lastname
 * @property string $firstname
 * @property string $street
 * @property string $city
 * @property string $about
 * @property string $phone
 * @property integer $sex
 * @property integer $user_location
 * @property integer $bday
 */
class Profile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, bday', 'required'),
			array('avatar, sex, user_location, bday', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('lastname, firstname', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>512),
			array('about', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, avatar, user_id, lastname, firstname,  street, city, about, phone, sex, user_location, bday', 'safe', 'on'=>'search'),
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
			'avatar' => 'Avatar',
			'user_id' => 'User',
			'lastname' => 'Lastname',
			'firstname' => 'Firstname',
			'street' => 'Street',
			'city' => 'City',
			'about' => 'About',
			'phone' => 'Phone',
			'sex' => 'Sex',
			'user_location' => 'User Location',
			'bday' => 'Bday',
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
		$criteria->compare('avatar',$this->avatar);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('lastname',$this->lastname,true);
		$criteria->compare('firstname',$this->firstname,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('about',$this->about,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('user_location',$this->user_location);
		$criteria->compare('bday',$this->bday);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Profile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
