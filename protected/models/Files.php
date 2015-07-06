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
 * @property integer $real_name
 */
class Files extends CActiveRecord
{
    private $table_rools=array(
        'badges'=>'badges_rools',
        'photo'=>'',
        'store'=>'store_rools',
        'usergroup'=>'usergroup_rools',
        'profile'=>'profile_rools',
        'comments'=>'comments_rools',
        'company'=>'company_rools');

    private $table_options=array(
        'badges'=>array('name'=>array('width'=>50,'height'=>50)),
        'photo'=>array('name'=>array('width'=>150,'height'=>150),'name_middle'=>array('width'=>100,'height'=>100),'name_little'=>array('width'=>75,'height'=>75)),
        'store'=>array('name'=>array('width'=>75,'height'=>75)),
        'usergroup'=>array('name'=>array('width'=>57,'height'=>57),'name_middle'=>array('width'=>36,'height'=>36)),
        'profile'=>array('name'=>array('width'=>314,'height'=>314),'name_middle'=>array('width'=>50,'height'=>50),'name_little'=>array('width'=>30,'height'=>30)),
        'comments'=>array('name'=>array('width'=>150,'height'=>150),'name_middle'=>array('width'=>100,'height'=>100),'name_little'=>array('width'=>75,'height'=>75)),
        'message'=>array('name'=>array('width'=>150,'height'=>150),'name_middle'=>array('width'=>100,'height'=>100),'name_little'=>array('width'=>75,'height'=>75)),
        'company'=>array('name'=>array('width'=>140,'height'=>"auto")));


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
    public function profile_rools($file,$name_field)
    {
        /*rools*/
        $w_h=314;
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width!==$height)
        {
            $errors_messages[]="Picture should be square";
        }
        elseif($width<$w_h)
        {
            $errors_messages[]="Picture width should be more than $w_h px";
        }
        elseif($height<$w_h)
        {
            $errors_messages[]="Picture height should be more than $w_h px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
        return true;
    }
    private function badges_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->image_resize          = true;
//                            $img->image_ratio_y         = true;
        $img->image_x               = $image['width'];
        $img->image_y               = $image['height'];
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }
    private function store_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->image_resize          = true;
//                            $img->image_ratio_y         = true;
        $img->image_x               = $image['width'];
        $img->image_y               = $image['height'];
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }
    private function profile_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->image_resize          = true;
        $img->image_x               = $image['width'];
        $img->image_y               = $image['height'];
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }

    private function usergroup_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->image_resize          = true;
        $img->image_x               = $image['width'];
        $img->image_y               = $image['height'];
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }

    private function company_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->image_resize          = true;
        $img->image_x               = $image['width'];
        $img->image_ratio_y         = true;
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }

    private function message_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }

    private function comments_img($img,$image,$filename)
    {
        $img->image_convert = 'png';
        $img->file_force_extension = false;
        $img->file_new_name_body =$filename;
        $img->process(Yii::app()->basePath."/../files");
        if ($img->processed) {
            return true;
        } else {
            return $img->error;
        }
    }

    private function store_rools($file,$name_field)
    {
        $w_h=75;
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width!==$height)
        {
            $errors_messages[]="Picture should be square";
        }
        elseif($width<$w_h)
        {
            $errors_messages[]="Picture width should be more than $w_h px";
        }
        elseif($height<$w_h)
        {
            $errors_messages[]="Picture height should be more than $w_h px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
            return true;
    }

    private function usergroup_rools($file,$name_field)
    {
        $w_h=57;
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width!==$height)
        {
            $errors_messages[]="Picture should be square";
        }
        elseif($width<$w_h)
        {
            $errors_messages[]="Picture width should be more than $w_h px";
        }
        elseif($height<$w_h)
        {
            $errors_messages[]="Picture height should be more than $w_h px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
            return true;
    }
    private function comments_rools($file,$name_field)
    {
        $w_h=140;
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width<$w_h)
        {
            $errors_messages[]="Picture width should be more than $w_h px";
        }
        elseif($height<$w_h)
        {
            $errors_messages[]="Picture height should be more than $w_h px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
            return true;
    }
    private function badges_rools($file,$name_field)
    {
        $w_h=50;
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width!==$height)
        {
            $errors_messages[]="Picture should be square";
        }
        elseif($width<$w_h)
        {
            $errors_messages[]="Picture width should be more than $w_h px";
        }
        elseif($height<$w_h)
        {
            $errors_messages[]="Picture height should be more than $w_h px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
            return true;
    }
    /*company rools*/
    public function company_rools($file,$name_field)
    {
        $errors_messages=array();
        $size=filesize($file['tmp_name'][$name_field]);
        list($width,$height)=getimagesize($file['tmp_name'][$name_field]);
        if($width<150)
        {
            $errors_messages[]="Picture width should be more than 150 px";
        }
        elseif($height<50 && $height>130)
        {
            $errors_messages[]="Picture height should be more than 50 px and less than 130 px";
        }
        elseif ($size > MAX_SIZE*1024)
            $errors_messages[]="You have exceeded the size limit";

        if(count($errors_messages)>0)
            return $errors_messages;
        else
            return true;
    }
    /*create file record in DB*/
    /**
     * @param $post
     * @param $name_field
     * @param string $title
     * @param $table
     * @param null $image_id
     * @return array|null|string
     */
    public function create($post,$name_field,$title='',$table,$image_id=null)
    {
        define ("MAX_SIZE","1000");
        $errors_messages=array();
        $image =$post["name"][$name_field];
        $uploadedfile = $post['tmp_name'][$name_field];
        $id=null;
        if ($image)
        {
            /*check extension*/
            $extension = strtolower(substr($post["name"][$name_field],strripos($post["name"][$name_field],'.'),strlen($post["name"][$name_field])));
            if (($extension != ".jpg") && ($extension != ".jpeg")
                && ($extension != ".png") && ($extension != ".gif"))
            {
                $errors_messages[]=' Unknown Image extension ';
            }
            else
            {
                if(array_key_exists($table,$this->table_rools))
                {
                    if(!empty($this->table_rools[$table]))
                    {
                        $funct=$this->table_rools[$table];
                        $error=$this->$funct($post,$name_field);
                        if(is_array($error))
                        {
                            return $error;
                        }
                    }
                }

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
                                    $name_in_db=str_replace('.png','',$old_image->image);
                                    if(file_exists(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".png"))
                                    {
                                        @unlink(Yii::app()->basePath."/../files/".$name_in_db.$real_name.".png");
                                    }
                                }
                            }
                        }
                        $save_flag=false;
                        $filename = uniqid();
                        $img = Yii::app()->imagemod->load($post['tmp_name'][$name_field]);
                        if ($img->uploaded) {
                        foreach($this->table_options[$table] as $name=>$image)
                        {
                            $real_name=str_replace('name','',$name);
                            /*new load image by exta*/
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
                                $file->image=$filename.$real_name.".png";
                                $file->table=$table;
                                $file->real_name=$post['name'][$name_field];
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
                                }
                            }
                            switch($table)
                            {
                                case 'badges':
                                    $res=$this->badges_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                                case 'photo':
                                break;
                                case 'store':
                                    $res=$this->store_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                                case 'usergroup':
                                    $res=$this->usergroup_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                                case 'profile':
                                    $res=$this->profile_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                                case 'comments':
                                    $res=$this->comments_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                                case 'message':
                                    $res=$this->message_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                    break;
                                case 'company':
                                    $res=$this->company_img($img,$image,$filename.".png");
                                    if(is_string($res))
                                        $errors_messages[]=$res;
                                break;
                            }
                        }
                            $img->clean(); //delete original image
                        }
                        else $errors_messages[]=$img->error;

//                        foreach($this->table_options[$table] as $name=>$image)
//                        {
//                            $real_name=str_replace('name','',$name);
//                            $newwidth=$image['width'];
//                            $newheight=$image['height'];
//                            $tmp=imagecreatetruecolor($newwidth,$newheight);
//                            $uploadedfile = $post['tmp_name'][$name_field];
//                            if($extension==".jpg" || $extension==".jpeg" )
//                                $src = imagecreatefromjpeg($uploadedfile);
//                            else if($extension==".png")
//                                $src = imagecreatefrompng($uploadedfile);
//                            else
//                                $src = imagecreatefromgif($uploadedfile);
//                            imagecopyresized($tmp,$src,0,0,0,0,$newwidth,$newheight,
//                                $width,$height);
//                            if(!$save_flag)
//                            {
//                                if(!is_null($image_id))
//                                {
//                                    $old_image=Files::model()->findByPk($image_id);
//                                    if($old_image)
//                                        $file=$old_image;
//                                    else $file=new Files();
//                                }
//                                else $file=new Files();
//                                $file->title=$title;
//                                $file->image=$filename.$real_name.".jpg";
//                                $file->table=$table;
//                                $file->timecreated=strtotime(date('Y-m-d H:i:s'));
//                                $file->user_id=Yii::app()->user->id;
//                                if($file->save())
//                                {
//                                    $id=$file->id;
//                                    $save_flag=true;
//                                }
//                                else {
//                                    $errors_messages[]='Not saved';
//                                    $save_flag=true;
//                                }
//                            }
//                            imagejpeg($tmp,Yii::app()->basePath."/../files/".$filename.$real_name.".jpg",100);
//                            imagedestroy($src);
//                            imagedestroy($tmp);
//                        }
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

    /*files from DB*/
    public function FilesfromDb($settings)
    {
        $fileswithoufolder=array();
        $filemodels=Files::model()->findAllByAttributes(array('table'=>$settings['direction']));
        if($filemodels)
        {
            foreach($filemodels as $file)
            {
                /*check if file exists*/
                if(file_exists(Yii::app()->basePath.'/../files/'.$file->image))
                {
                    $fileswithoufolder[$file->id]="/files/".$file->image;
                }
            }
        }
        return json_encode($fileswithoufolder);
    }
}
