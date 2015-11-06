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
?>

<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
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
 
<!--<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>-->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/idangerous.swiper.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css">
<script  src="<?php echo get_template_directory_uri(); ?>/js/libs/jquery-1.7.1.min.js"></script>
<!-- Swiper -->
<script  src="<?php echo get_template_directory_uri(); ?>/js/idangerous.swiper-1.9.1.min.js"></script>
<!-- Demos code -->
<script  src="<?php echo get_template_directory_uri(); ?>/js/swiper-demos.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js" type="text/javascript" charset="utf-8"></script>
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
			$('#booknow').addClass('selected');
			//$('div.tabs ul.tabNavigation a:second').addClass('selected');
			//$('#second').addClass('selected');
			return false;
			
			});
		
		
	});
</script>
</head>

<body>