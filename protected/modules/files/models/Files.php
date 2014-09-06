<?php

/**
 * This is the model class for table "files".
 *
 * The followings are the available columns in table 'files':
 * @property string $id
 * @property string $title
 * @property string $image
 * @property string $table
 * @property integer $timecreated
 * @property integer $user_id
 */
class Files extends CActiveRecord
{
    private $table_options=array('badges'=>array('name'=>array('width'=>150,'height'=>150),'name_middle'=>array('width'=>100,'height'=>100),'name_little'=>array('width'=>75,'height'=>75)),
'photo'=>array('name'=>array('width'=>150,'height'=>150),'name_middle'=>array('width'=>100,'height'=>100),'name_little'=>array('width'=>75,'height'=>75)));

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, image, table, timecreated, user_id', 'required'),
			array('timecreated, user_id', 'numerical', 'integerOnly'=>true),
			array('title, image, table', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, image, table, timecreated, user_id', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'image' => 'Image',
			'table' => 'Table',
			'timecreated' => 'Timecreated',
			'user_id' => 'User',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('table',$this->table,true);
		$criteria->compare('timecreated',$this->timecreated);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Files the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /*delete all images by id*/
    public function delete($id=null)
    {
        if(!is_null($id) && $id>0)
        {
            $file=Files::model()->findByPk($id);
            if($file)
            {
                foreach($this->table_options[$file->table] as $name=>$image)
                {
                    $real_name=str_replace('name','',$name);
                    $name_in_db=str_replace('.jpg','',$file->image);
                    if(file_exists(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".jpg"))
                    {
                        @unlink(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".jpg");
                    }
                }
                $file->delete();
            }
        }
    }
    /*create file record in DB*/
    public function create($post,$title='',$table,$image_id=null)
    {
        define ("MAX_SIZE","1000");
        $errors_messages=array();
        $image =$post["name"]['image'];
        $uploadedfile = $post['tmp_name']['image'];
        $id=null;
        if ($image)
        {
            $extension = strtolower(substr($post["name"]['image'],strripos($post["name"]['image'],'.'),strlen($post["name"]['image'])));
            if (($extension != ".jpg") && ($extension != ".jpeg")
                && ($extension != ".png") && ($extension != ".gif"))
            {
                $errors_messages[]=' Unknown Image extension ';
            }
            else
            {
                $size=filesize($post['tmp_name']['image']);

                if ($size > MAX_SIZE*1024)
                {
                    $errors_messages[]="You have exceeded the size limit";
                }

                list($width,$height)=getimagesize($uploadedfile);
                if(array_key_exists($table,$this->table_options))
                {
                    if(!empty($this->table_options[$table]))
                    {
                        if(!is_null($image_id))
                        {
                            $old_image=Files::model()->findByPk($image_id);
                            if($old_image)
                            {
                                foreach($this->table_options[$table] as $name=>$image)
                                {
                                    $real_name=str_replace('name','',$name);
                                    $name_in_db=str_replace('.jpg','',$old_image->image);
                                    if(file_exists(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".jpg"))
                                    {
                                        @unlink(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".jpg");
                                    }
                                }
                            }
                        }
                       $save_flag=false;
                       $filename = uniqid();
                       foreach($this->table_options[$table] as $name=>$image)
                       {

                           $real_name=str_replace('name','',$name);
                           $newwidth=$image['width'];
                           $newheight=$image['height'];
                           $tmp=imagecreatetruecolor($newwidth,$newheight);
                           $uploadedfile = $post['tmp_name']['image'];
                           if($extension==".jpg" || $extension==".jpeg" )
                               $src = imagecreatefromjpeg($uploadedfile);
                           else if($extension==".png")
                                $src = imagecreatefrompng($uploadedfile);
                           else
                                $src = imagecreatefromgif($uploadedfile);
                           imagecopyresized($tmp,$src,0,0,0,0,$newwidth,$newheight,
                               $width,$height);
                           if(!$save_flag)
                           {
                               if(!is_null($image_id))
                               {
                                   $old_image=Files::model()->findByPk($image_id);
                                   if($old_image)
                                        $file=$old_image;
                                   else $file=new Files();
                               }
                               else $file=new Files();
                               $file->title=$title;
                               $file->image=$filename.$real_name.".jpg";
                               $file->table=$table;
                               $file->timecreated=strtotime(date('Y-m-d H:i:s'));
                               $file->user_id=Yii::app()->user->id;
                               if($file->save())
                               {
                                   $id=$file->id;
                                   $save_flag=true;
                               }
                               else {
                                   $errors_messages[]='Not saved';
                                   $save_flag=true;
                                   break;
                               }
                           }
                           imagejpeg($tmp,Yii::app()->basePath."/../files/".$filename.$real_name.".jpg",100);
                           imagedestroy($src);
                           imagedestroy($tmp);
                       }
                    }
                    else $errors_messages[]='Options for this table is empty';
                }
                else $errors_messages[]='Wrong parameters';
            }
        }
//If no errors registred, print the success message
        if(!is_null($id)) return $id;
        else
        if(!empty($errors_messages))
        {
            return $errors_messages;
        }

    }
}
