<?php

class ProfileController extends Controller
{
    public function actionView($id)
    {
        $profile = Profile::model()->findByPk($id);
        $this->render('view');
    }
}