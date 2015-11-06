<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; ?>/css/form.css" /> -->
    <title>FINAONATION</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="content/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="content/css/landing.css" rel="stylesheet">
    <link href="content/css/images.css" rel="stylesheet">
    <link rel="stylesheet" href="content/fonts/proximanova/stylesheet.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="content/fonts/oswald/stylesheet.css" type="text/css" media="screen" />

    <script src="content/js/jquery-2.1.0.min.js"></script>
    <script src="content/bootstrap/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="content/images/icons/favicon.ico">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php echo $content; ?>
</body>
</html>
