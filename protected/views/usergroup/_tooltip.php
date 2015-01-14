<?php

$template = '<p> %s: %s </p>';

if($data->privacy && $data->privacy->show_online_status)
	if($data->isOnline()) {
		echo 'User is Online!';
//		echo CHtml::image(Yum::register('images/green_button.png'));
	}

printf($template, 'Username', $data->username);

echo CHtml::link('Write a message', array(
			'//message/compose', 'to_user_id' => $data->id)) . '<br />';
echo CHtml::link('Visit profile', array(
			'//profile/view', 'id' => $data->id));



