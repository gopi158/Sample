<link href="<?php echo Yii::app()->baseUrl ;?>/javascript/sliderkit/lib/css/sliderkit-core.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl ;?>/javascript/sliderkit/lib/css/sliderkit-demos.css" rel="stylesheet" type="text/css" />
<link href="<?php echo Yii::app()->baseUrl ;?>/javascript/sliderkit/lib/css/sliderkit-site.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/sliderkit/lib/js/external/jquery.easing.1.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/sliderkit/lib/js/external/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/sliderkit/lib/js/sliderkit/jquery.sliderkit.1.9.2.pack.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/feat-video/jquery.carouFredSel-5.6.1.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/jquery.tinyscrollbar.min.js"></script>
<link href="<?php echo Yii::app()->baseUrl ;?>/css/website.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/css_browser_selector.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl;?>/javascript/nivo2.js"></script>
<style type="text/css" media="all">
.wrapper {background-color: white; width: 400px; padding: 0px;	box-shadow: 0 0 5px #999;}
.list_carousel {margin: 0 0 10px 0px; width: 330px; float:left; margin-top:10px; height:260px;}
.list_carousel a{color:#000;}
.list_carousel ul {margin: 0; padding: 0;list-style: none; display: block;}
.list_carousel li {font-size: 15px; color: #F60; height:auto; padding: 0;  display: block; float: left;}
.list_carousel.responsive {width: auto; margin-left: 0;}
.prev {float: left;	margin-left: 0px; margin-top:15px; }
.next {float: right; margin-right: 10px; margin-top:15px;}
.pager {float: left; width: 260px;	text-align: center; padding-top:15px;}
.pager a {margin: 0 5px; text-decoration: none;}
.pager a.selected {text-decoration: none; color:#F60;}
.timer {background-color: #999;	height: 6px; width: 0px;}
</style>
	<script type="text/javascript">
	$(window).load(function(){
		$("#carousel-demo7").sliderkit({
			auto:false,
			//autospeed:4000,
			shownavitems:3,
			circular:false,
			fastchange:false,
			scrolleasing:"easeOutExpo", 
			scrollspeed:500
		});	
	});	
</script>
<script type="text/javascript" language="javascript">
    $(function() {

        //	Basic carousel, no options
        $('#foo0').carouFredSel();

        //	Scrolled by user interaction
        $('#foo2').carouFredSel({
            prev: '#prev2',
            next: '#next2',
            pagination: "#pager2",
            auto: false
        });

    });
</script>

<div id="carousel-demo7" class="sliderkit">
<div class="sliderkit-nav">
<div class="sliderkit-nav-clip" id="divtileslide">
<ul>

<?php
foreach($alltiles as $eachtile)
{?>
	<li class="details-holder show-details" id="tilenavigation-<?php echo $eachtile->tile_id;?>">
	<a href="javascript:void(0)" class="active-finao-tile" onclick="getfinaos(<?php echo $eachtile->userid;?>,<?php echo $eachtile->tile_id;?>)">
	<img src="<?php echo Yii::app()->baseUrl;?>/images/uploads/tilesimages/<?php echo $eachtile->tile_profileImagurl;?>" height="" width="160"/>
		<div class="img-info">
                        
                You can write the description about this image here.
        </div>
	<?php echo $eachtile->tile_name;?>
	</a>
	
	</li>
<?php }
?>

</ul>
</div>
<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev"><a href="#" title="Scroll to the left"><img src="<?php echo Yii::app()->baseUrl;?>/images/arrow-left.png" /></a></div>
<div class="sliderkit-btn sliderkit-nav-btn sliderkit-nav-next"><a href="#" title="Scroll to the right"><img src="<?php echo Yii::app()->baseUrl;?>/images/arrow-right.png" /></a>
</div>
</div>
</div>