<div id="carousel-demo6" class="sliderkit">
<div class="sliderkit-nav">
<div class="sliderkit-nav-clip" id="divtileslide">
<ul>

<?php
foreach($alltiles as $eachtile)
{?>
	<li class="details-holder show-details" id="tilenavigation-<?php echo $eachtile->tile_id;?>">
	<a href="javascript:void(0)" class="active-finao-tile" onclick="getfinaos(<?php echo $eachtile->userid;?>,<?php echo $eachtile->tile_id;?>)">
	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php echo strtolower($eachtile->tile_name);?>.png" height="" width="160"/>
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