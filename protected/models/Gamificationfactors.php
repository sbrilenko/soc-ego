<?php

/**
 * This is the model class for table "gamificationfactors".
 *
 * The followings are the available columns in table 'gamificationfactors':
 * @property string $id
 * @property integer $gamificationfactors_positions_id
 * @property integer $gamificationmanager_id
 * @property string $seniority_factor
 * @property string $experience_factor
 * @property integer $time
 * @property integer $user
 */
class Gamificationfactors extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gamificationfactors';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gamificationfactors_positions_id, gamificationmanager_id, seniority_factor, experience_factor, time, user', 'required'),
			array('gamificationfactors_positions_id, gamificationmanager_id, time, user', 'numerical', 'integerOnly'=>true),
			array('seniority_factor, experience_factor', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, gamificationfactors_positions_id, gamificationmanager_id, seniority_factor, experience_factor, time, user', 'safe', 'on'=>'search'),
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
			'gamificationfactors_positions_id' => 'Gamificationfactors Positions',
			'gamificationmanager_id' => 'Gamificationmanager',
			'seniority_factor' => 'Seniority Factor',
			'experience_factor' => 'Experience Factor',
			'time' => 'Time',
			'user' => 'User',
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
		$criteria->compare('gamificationfactors_positions_id',$this->gamificationfactors_positions_id);
		$criteria->compare('gamificationmanager_id',$this->gamificationmanager_id);
		$criteria->compare('seniority_factor',$this->seniority_factor,true);
		$criteria->compare('experience_factor',$this->experience_factor,true);
		$criteria->compare('time',$this->time);
		$criteria->compare('user',$this->user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gamificationfactors the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
