<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
?>
<?php if ($code){?>
<!--<div align="center" style="width:100%;padding:40px 0px">
<img src="http://<?php echo $_SERVER['SERVER_NAME'];?>/404error.jpg" />
</div>-->
<?php } ?>

<h2>Error <?php echo $code; ?></h2>
<div class="error">
<?php echo CHtml::encode($message); ?>
</div>