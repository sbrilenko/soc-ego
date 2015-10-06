
<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta http-equiv="X-UA-Compatible" content="IE=9" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->
    <script type="text/javascript">
        var authorizateduserid=<?php echo Yii::app()->user->isGuest?'null;':Yii::app()->user->getId();?>
    </script>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
    <?php if(isset(Yii::app()->user->id)) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css">
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/responsive.css">
    <?php } else { ?>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">
    <?php } ?>
    <?php if(isset(Yii::app()->user->id) && Yii::app()->controller->id=="site" && (Yii::app()->controller->action->id=="index")) { ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/index-responsive.css">
    <?php } ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <?php if(isset(Yii::app()->user->id) && Yii::app()->controller->id=="site" && (Yii::app()->controller->action->id=="index" || Yii::app()->controller->action->id=="faq" || Yii::app()->controller->action->id=="groups") || isset(Yii::app()->user->id) && Yii::app()->controller->id=="profile" && Yii::app()->controller->action->id=="view") { ?>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/nanoscroller.css" rel="stylesheet">
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.nanoscroller.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mousewheel.js"></script>
        <script>
            $(document).ready(function()
            {
                function initScrollPanes()
                {
                    $(function()
                    {
                        $(".nano").nanoScroller({flash: true  });
                    });
                }
                setTimeout(initScrollPanes, 100);
            })
        </script>
    <?php }?>
    <?php if(isset(Yii::app()->user->id)) { ?>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/socket.js"></script>
    <?php } ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
    <?php
    if(isset(Yii::app()->user->id))
    {
    ?>
    <div class="main-content">
    <div class="avatar-container left-block">
        <?php require_once "leftcolumn.php";?>
    </div>
    <div class="container">
        <?php require_once "header.php";?>
        <?php echo $content; ?>
    </div>
    </div>

<?php } else { ?>
            <?php echo $content; ?>
<?php } ?>
</body>
</html>
