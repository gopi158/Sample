<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>

<title>FINAO NATION</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />



<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/default.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/styles.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/home.css" type="text/css" media="screen" />





<link href="<?php echo $this->cdnurl;?>/css/hbcu.css" rel="stylesheet" />

  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/oswald/stylesheet.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/barkentina/stylesheet.css" type="text/css" media="screen" />

<link href="<?php echo $this->cdnurl;?>/css/responsive.css" rel="stylesheet"> 

   

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/ajaximage/js/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/ajaximage/js/file_uploads.js"></script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.js?v=2.1.5"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 



<!--Tool Tip script-->





<link type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/javascript/tooltip/atooltip.css" rel="stylesheet"  media="screen" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/javascript/tooltip/jquery.atooltip.js"></script>





<!--Tool Tip script-->

    

    



<script type="text/javascript">







$(document).ready(function($){

		/*Added by LK (01.07.2013)*/

		$(".fancybox").fancybox({

		//alert("Gallery image clicked");

		 'scrolling'   : 'no',

		openEffect	: 'elastic',

		closeEffect	: 'elastic'

		 

		});

		

		$("#my-story").fancybox({

		'scrolling'		: 'no',

		'titleShow'		: false,		

	});

		

		$(".fancybox123").fancybox({

			'beforeClose': function() { $('#videocontent').html(""); },

			'scrolling'  : 'no',

			'closeClick': false 

			

			 });



});



</script>



</head>

<body>



 <div class="header-home">



        <div class="logo-area"><a href="<?php echo Yii::app()->baseUrl; ?>/careercatapult-hbcu"><img src="<?php echo $this->cdnurl; ?>/images/logo2.png" title="FINAO NATION" width="180" /></a></div>



        <div class="search-area" style=" margin-top:0px;">

			<div class="search-area" style="padding-right:15px;">

	<?php if(isset(Yii::app()->session['login'])){ ?>

                    <a href="<?php echo Yii::app()->createUrl('site/logout1'); ?>" class="grey-link font-17px right" style="margin-left:10px;">Logout</a> <font class="welcome-text">Welcome <?php echo Yii::app()->session['login']['username']; ?>,</font>	</a>



    <?php }else{?> 

<a class="white-link font-16px right" onclick="fireClick();"  id="form-page3">LOGIN / REGISTER</a>    

    <?php }?>  

        </div>	

	   </div>

</div>



<div style="clear"></div>

<div id="content" >



<?php echo $content; ?></div>



<div id="footer">



    <div class="footer-left">

		

		 

<a href="<?php echo Yii::app()->createUrl('site/aboutus'); ?>">About FINAO</a> |

<a  href="<?php echo Yii::app()->createUrl('site/contestrules'); ?>">Contest Rules and Regulations</a> |

<a  href="<?php echo Yii::app()->createUrl('site/privacy'); ?>">Privacy Policy</a> |

<a  href="<?php echo Yii::app()->createUrl('site/contactuss'); ?>">Contact Us</a>



    </div>



    <div class="footer-right">



    	<!--<span class="follow-me">Follow Us On:</span>-->



    	<ul>



            <a href="https://www.facebook.com/FINAONation" target="_blank"><li class="facebook">&nbsp;</li></a>



            <a href="http://www.linkedin.com/company/2253999" target="_blank"><li class="linkedin">&nbsp;</li></a>



             <a href="http://pinterest.com/finaonation/" target="_blank"><li class="pinterest">&nbsp;</li></a>



            <a href="https://twitter.com/FINAONation" target="_blank"><li class="twitter">&nbsp;</li></a>



       </ul>



    </div>



    <div class="clear"></div>



    <div class="copyrights">&copy; Copyright 2013. All Rights Reserved. FINAO</div>



</div>



 







</body>



</html>

