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
ob_start();
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
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
 
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.6.1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.min.js" type="text/javascript"></script>
<?php wp_head(); ?>
<script type="text/javascript">
$(document).ready(function() {
// CYCLE HEADER
$('#Cycle').after('<ul id="CycNav">').cycle({ 
    fx:     'fade', 
    speed:  '400', 
    timeout: '4000', 
    pager:  '#CycNav',
	pause:   1,
    pauseOnPagerHover: true, 
	startingSlide: 0, // zero-based 

pagerAnchorBuilder: function(id, slide) { 

		var s=$(slide);

		var imgsource=s.find('img.CycIMGs').attr('src');

        // Split off the filename with no extension (period + 3 letter extension)

        //var new_src = imgsource.substring(0,imgsource.length-4);

        // Add the "-t"

       // new_src += "-t";

        // Add the period and the 3 letter extension back on

       // new_src += imgsource.substring(imgsource.length-4,imgsource.length);
        
        // Set this as the source for our image

        return '<li><a href="#"><img src="' + imgsource + '" width="130" height="130" /></a></li>';	

}
});

});
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<?php if(is_page(134)){ ?> 
<script type="text/javascript">
var j = jQuery.noConflict(); 
	j(document).ready(function(){
	//j("#allspeakers").hide();
	   j("#viewall").hide(); 
		j('#viewall').click(function(){
			//alert("Clicked");
			j("#speakersmessage").hide(); 
			j("#viewall").hide(); 
			j("#allspeakers").show();
			return false;
		});
	
	 	j('#hide').click(function(){
			//alert("clicked");
			j("#speakersmessage").show(); 
			j("#viewall").show(); 
			j("#allspeakers").hide(); 
			return false;
		}); 
	
});
 
</script>


<?php } ?>
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
 

function Showchrisbio()
{

var j = jQuery.noConflict(); 
if(j('#Showmore').html()=='Less Chris Bio') j('#Showmore').html('Show Chris bio');
else j('#Showmore').html('Less Chris Bio')
j("#chrisbio").toggle();	

}

 
</script>
</head>

<body <?php body_class(); ?>>

<div class="MainWrapper">
<!--<div class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="margin-left:5px;"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" /> </a></div>-->