<?php
class folderviewer extends CInputWidget
{
	public $options=array();
	
	public function init()
	{
		$this->publishFolder();
	}

    public function run()
    {
        /**/
        $attr=$this->options['attr'];;
        echo "<div class='folderviewer-button'>
            <input name='".get_class($this->options['model'])."[".$attr."]"."' value='".$this->value."' type='hidden'/>
        </div>";



//        echo "<div class='folderviewer-button'></div>";
//        if(is_dir(Yii::app()->basePath.'/..'.$this->options['path']))
//        {
//            $dirandfiles=scandir(Yii::app()->basePath.'/..'.$this->options['path']);
//            if(is_array($dirandfiles))
//            {
//                $fileswithoufolder=array();
//                $onlyimages=array('png','jpg','jpeg');
//                for($i=0;$i<count($dirandfiles);$i++)
//                {
//                    if(!in_array($dirandfiles[$i],array(".", "..")) && in_array(pathinfo($dirandfiles[$i], PATHINFO_EXTENSION),$onlyimages))
//                    {
//                        $fileswithoufolder[]=$dirandfiles[$i];
//                    }
//                }
//            }
//            echo "<div class='folderviewer-button'></div>";
//            $images=CJavaScript::encode($fileswithoufolder);
//            $id=uniqid();
            /*load from db*/

//            Yii::app()->clientScript->registerScript($id,"var folderviewerimagesfolder={$images}",CClientScript::POS_HEAD);

//            echo "<div class='folderviewer'>
//                    <div class='folderviewer-back'></div>
//                    <div class='pop-up'></div>
//            </div>";
//
//            if(isset($this->htmlOptions['id']))
//                $id=$this->htmlOptions['id'];
//            else
//                $this->htmlOptions['id']=$id;
//            if(isset($this->htmlOptions['name']))
//                $name=$this->htmlOptions['name'];
//            else
//                $this->htmlOptions['name']=$name;
//
//            if($this->hasModel())
//                echo CHtml::activeTextArea($this->model,$this->attribute,$this->htmlOptions);
//            else
//                echo CHtml::textArea($name,$this->value,$this->htmlOptions);
//
//            $options=CJavaScript::encode($this->options);
//            Yii::app()->clientScript->registerScript($id,"
//			$('#{$id}').cleditor({$options});
//		");
//        }
//        else throw new Exception('FolderViewer - Error: Couldn\'t find path to folder '.$this->options['path']);

	}
	
	private function publishFolder()
	{
		$assets=dirname(__FILE__)."/assets";
		$baseUrl=Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			Yii::app()->clientScript->registerCoreScript('jquery');
            $id=uniqid();
            $params=CJavaScript::encode($this->options['ajaxParams']);
            echo "<script>
            function ajaxrefreshfiles(callbackf)
            {
                $.ajax({
                    url: '{$this->options['ajaxUrl']}',
                    type: 'POST',
                    data:{$params},
                    dataType:'json',
                    timeout: 20000,
                    error: function(x, t, m) {

                    },

                    success:callbackf
                })
            }
            </script>";
            Yii::app()->clientScript->registerScriptFile($baseUrl.'/jquery.folderviewer.js');
//			Yii::app()->clientScript->registerScriptFile($baseUrl.'/jquery.folderviewer.js',CClientScript::POS_HEAD);
			Yii::app()->clientScript->registerCssFile($baseUrl.'/jquery.folderviewer.css');
            Yii::app()->clientScript->registerCssFile($baseUrl.'/nanoscroller.css');
            Yii::app()->clientScript->registerScriptFile($baseUrl.'/jquery.nanoscroller.js');
            Yii::app()->clientScript->registerScriptFile($baseUrl.'/jquery.mousewheel.js');
		} else {
			throw new Exception('EClEditor - Error: Couldn\'t find assets to publish.');
		}
	}
}