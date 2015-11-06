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

<script src="jscript/jquery.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
	$(function () {
		var tabContainers = $('div.tabs > div');
		tabContainers.hide().filter(':first').show();
		
		$('div.tabs ul.tabNavigation a').click(function () {
			tabContainers.hide();
			//alert(this.hash);
			tabContainers.filter(this.hash).show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$(this).addClass('selected');
			return false;
		}).filter(':first').click();
		
		$('#book-now').click(function(){
			var tabContainers = $('div.tabs > div');
			 tabContainers.hide();
			//alert(this.hash);
			tabContainers.filter('#second').show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			
			//$('div.tabs ul.tabNavigation a').addClass('selected');
			$('#second').addClass('selected');
			return false;
			
			//tabContainers.hide().filter(':second').show();
			/*tabContainers.hide();
			tabContainers.filter(:second).show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$(this).addClass('selected');
			return false;*/
			//alert("Clicked");
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

<body>
<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>
<div class="MainWrapper">