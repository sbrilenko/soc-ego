<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
        $this->layout = Yum::module('admin')->adminLayout;
		$this->render('index');
	}
}
