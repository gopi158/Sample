<?php

$serverName = $_SERVER['SERVER_NAME'];
$userId = isset($user[0]['userid']) ? $user[0]['userid'] : 0;

if($userimage[0]["profile_image"]!='') {
    $src = $this->cdnurl."/images/uploads/profileimages/".$userimage[0]["profile_image"];
} else {
    $src=$this->cdnurl.'/images/FINAO.png';
}

?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/styles.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/home.css" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<div class="header-home">
	<div class="logo-area"><a href="index.html"><img title="FINAO NATION" src="<?php echo $this->cdnurl; ?>/images/logo2.png" width="220" height="73"></a></div>
</div>

<div class="tagnotes-container">
    <div style="width:100%;" class="font-20px padding-10pixels left">
        <span style="width:100%;" class="left"><?php if($user[0]['fname']) echo $user[0]['fname'];  else echo ' Guest ';?></a></span>
        <span class="clear"></span>
    </div>
    <div class="product-image left"><a href="http://<?php echo $serverName ?>/finao/motivationmesg/frndid/<?php echo $userId ?>"><img width="220" height="220" class="container-border" src="<?php echo $src;?>"></a></div>
    <div style="line-height:36px;" class="finao-message font-20px left"><?php echo $tagnote;?></div>
    <div class="clear"></div>
    <div><?php if($user[0]['userid']!=''){?><a class="orange-link font-14px" href="http://<?php echo $serverName ?>/finao/motivationmesg/frndid/<?php echo $userId;?>">View <?php echo $user[0]['fname']."'s   ";?> profile</a><?php }?></div>
</div>

<div id="footer">
     <div class="footer-left">
    	<a href="<?php echo Yii::app()->createUrl('profile/aboutus'); ?>">About FINAO</a> |
    	<a  href="<?php echo Yii::app()->createUrl('profile/faq'); ?>">FAQ</a> |
        <a  href="<?php echo Yii::app()->createUrl('profile/grouppurchase'); ?>">Group Purchase</a> |
        <a  href="<?php echo Yii::app()->createUrl('profile/terms'); ?>">Terms of Use</a> |
        <a  href="<?php echo Yii::app()->createUrl('profile/privacy'); ?>">Privacy Policy</a> |
        <a  href="<?php echo Yii::app()->createUrl('profile/contactus'); ?>">Contact Us</a>
    </div>
    <div class="footer-right">
    	<ul>
            <a target="_blank" href="https://www.facebook.com/FINAONation"><li class="facebook">&nbsp;</li></a>
            <a target="_blank" href="http://www.linkedin.com/company/2253999"><li class="linkedin">&nbsp;</li></a>
            <a target="_blank" href="http://pinterest.com/finaonation/"><li class="pinterest">&nbsp;</li></a>
            <a target="_blank" href="https://twitter.com/FINAONation"><li class="twitter">&nbsp;</li></a>
       </ul>
    </div>
    <div class="clear"></div>
    <div class="copyrights">&copy; Copyright 2013. All Rights Reserved. FINAO</div>
</div>