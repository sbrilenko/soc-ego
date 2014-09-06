<?php
class LocationManager extends YumActiveRecord {

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		$this->_tableName = Yum::module('locationmanager')->locationmanagerTable;
		return $this->_tableName;
	}

	public function rules()
	{
		return array(
				array('locationname', 'required'),
				array('locationname', 'length', 'max' => '512'),
				);
	}

	public function scopes() {
		return array(
				'possible_memberships' => array(
					'condition' => 'membership_priority > 0'),
				);
	}

	public function relations()
	{
		return array();
	}


	public function attributeLabels()
	{
		return array(
				'id'=>Yum::t("#"),
				'locationname'=>Yum::t("Location Name")
				);
	}
}
