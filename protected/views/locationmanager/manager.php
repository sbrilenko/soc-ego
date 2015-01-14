<?php
echo $this->renderPartial('_updateform',array('message'=>$message,'model'=>$model));
echo $this->renderPartial('_insertform',array('message'=>$message));