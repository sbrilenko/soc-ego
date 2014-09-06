<?php

class DefaultController extends Controller
{
    public $layout = '/layouts/index';
	public function actionIndex()
	{
        $this->render('index');
	}
}