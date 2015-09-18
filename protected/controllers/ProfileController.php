<?php

class ProfileController extends Controller
{
    public function actionView($id)
    {
        /** @var User $profile */
        $this->user_id = $id;
        $user = User::model()->findByPk($id);
        $this->render('view', [
            'model' => $user,
            'me' => User::model()->findByPk(Yii::app()->user->id),
            'name' => Profile::model()->getName($user->id),
            'location' => LocationManager::model()->getLocation($user->id),
            'birthday'=>$this->renderPartial('//site/birthday',array('img'=>Profile::model()->birthdayImg($user->id),
                'date'=>Profile::model()->birthdayDate($user->id),
                'name'=>Profile::model()->birthdayName($user->id)),true),
            'rank'=>$this->renderPartial('//site/rank',array('img_class'=>Profile::model()->rankImgClass($user->id),
                'title'=>Profile::model()->jobTitle($user->id),
                'type'=>Profile::model()->jobType($user->id)),true),
            'store'=>$this->renderPartial('//site/store',array('stores'=>Store::model()->getCountAllVisibleItem()),true),
            'company'=>$this->renderPartial('//site/company',array('img'=>Profile::model()->companyImg($user->id)),true),
        ]);
    }
}