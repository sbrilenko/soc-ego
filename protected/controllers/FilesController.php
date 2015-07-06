<?php
class FilesController extends Controller
{
    /*get file from choose for only one category*/
    public function actionrefresh()
    {
        if(Yii::app()->request->isAjaxRequest && isset($_POST) && !empty($_POST) && !empty($_POST['direction']))
        {
            $direction=$_POST;
            echo Files::model()->FilesfromDb($direction);
        }
    }
}