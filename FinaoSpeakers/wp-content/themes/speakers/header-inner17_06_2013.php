<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>

<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<!--Datapicker js starts-->
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
 <!--Datapicker js Ends-->
 
 <!--Scrollbar Start--> 
<link href="<?php echo get_template_directory_uri(); ?>/js/scrollbar/perfect-scrollbar.css" rel="stylesheet">
<script src="<?php echo get_template_directory_uri(); ?>/js/scrollbar/jquery.mousewheel.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/scrollbar/perfect-scrollbar.js"></script>
<script>
	jQuery(document).ready(function ($) {
	"use strict";
	$('#Default').perfectScrollbar();
	$('#first').perfectScrollbar();
	$('#first').perfectScrollbar('update');
	});
</script>
 
 <!--Scrollbar End -->
<script type="text/javascript">
var j = jQuery.noConflict(); 
	j(document).ready(function(){
		j("#listbyfilter").hide();
	
		j('#filterbytopic').click(function(){
		 j("#filtershow").removeClass("active-button");
		  j("#filterbytopic").addClass("active-button");
          j("#listbyfilter").show();
			return false;
		});
	j('#hide').click(function(){
	        j("#listbyfilter").hide();
			//j("#speakersmessage").show(); 
			j("#viewall").show(); 
			j("#allspeakers").hide(); 
			return false;
		}); 
	 
});
 
</script>
<script src="jscript/jquery.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	jQuery(function () {
		var tabContainers = $('div.tabs > div');
		tabContainers.hide().filter(':first').show();
		
		$('div.tabs ul.tabNavigation a').click(function () {
			//alert("Changed");
			/*document.getElementById("bform").reset();*/
			tabContainers.hide();
			//alert(this.hash);
			tabContainers.filter(this.hash).show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$(this).addClass('selected');
			if(this.hash == '#second')
			{
				$('#bform')[0].reset();
				//$('#bform').reset();
			}
			
			
			return false;
		}).filter(':first').click();
		
		$('#book-now').click(function(){
			 
			var tabContainers = $('div.tabs > div');
			 tabContainers.hide();
			//alert(this.hash);
			tabContainers.filter('#second').show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$('#booknow').addClass('selected');
			//$('div.tabs ul.tabNavigation a:second').addClass('selected');
			//$('#second').addClass('selected');
			/*$("#content-animate").animate(
            {"top": "+=50px"},
            "fast");*/
			/*var flag = false;
			$(window).scroll(function(){
			if  ($(window).scrollTop() >= 500 && flag == false)
			{
			flag = true;
			var tabContainers = $('div.tabs > div');
			 tabContainers.hide();
			//alert(this.hash);
			tabContainers.filter('#second').show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$('#booknow').addClass('selected');
			//$('div.tabs ul.tabNavigation a:second').addClass('selected');
			//$('#second').addClass('selected');
			return false;
			
			}
			});*/
			
			});
			$('#bio-now').click(function()
			{
				//alert("Clicked");
			var tabContainers = $('div.tabs > div');
			tabContainers.hide().filter(':first').show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$('#bio-more').addClass('selected');
			
			});
		
		
	});
</script>

 <script type="text/javascript">
 
 var z = jQuery.noConflict();
   z(document).ready(function(){
	// alert("HEllo");  
	var date = new Date();
	var currentMonth = date.getMonth();
	var currentDate = date.getDate();
	var currentYear = date.getFullYear();
	z('.Date').datepicker({
	minDate: new Date(currentYear, currentMonth, currentDate)
	});
	   });
   
 
</script>
 
</head>

<body id="content-animate">

<div class="MainWrapper">
<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>