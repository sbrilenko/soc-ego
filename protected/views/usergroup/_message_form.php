<?php
  echo CHtml::beginForm(array('//usergroup/write'));

	echo CHtml::hiddenField('UsergroupMessage[group_id]', $group_id);

	echo CHtml::label('Title', 'UsergroupMessage_title') . '<br />';
	echo CHtml::textField('UsergroupMessage[title]', isset($title) ? $title : '') . '<br />';

	echo CHtml::label('Message', 'UsergroupMessage_message') . '<br />';
	echo CHtml::textArea('UsergroupMessage[message]', '', array(
				'cols' => 40, 'rows' => 6,
				)) . '<br />';

	echo CHtml::submitButton('Write message');

	echo CHtml::endForm();

?>
