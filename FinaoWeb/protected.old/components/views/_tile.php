<!-- ========== Portfolio Slider Dropdown ============ -->

<script src="<?php echo Yii::app()->baseUrl;?>/javascript/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>

<script type="text/javascript">

	$(function() {

		$('#thumbs').carouFredSel({

			synchronise: ['#images', false, true],

			auto: false,

			width: 450,

			items: {

				visible: 3,

				start: -1

			},

			scroll: {

				items : 1,

				onBefore: function( data ) {

					data.items.old.eq(1).removeClass('selected');

					data.items.visible.eq(1).addClass('selected');

				}

			},

			prev: '#prev',

			next: '#next'

		});



		$('#images').carouFredSel({

			auto: false,

			items: 1,

			scroll: {

				fx: 'fade'

			}

		});



		$('#thumbs img').click(function() {

			$('#thumbs').trigger( 'slideTo', [this, -1] );

		});

		$('#thumbs img:eq(1)').addClass('selected');

	});

</script>

<!-- ========== Portfolio Slider Dropdown ============ -->



<script type="text/javascript">



	/*function getDetails(imageorvideo,userid)

	{

		tileid = $("#dispfinaotileid").val();

		var url='<?php echo Yii::app()->createUrl("/finao/getDetails"); ?>';

		$.post(url, { tileid :  tileid , imageorvideo : imageorvideo, userid:userid },

   		function(data){

   			if(data)

			{

				//alert(data);

				hidealldivs();

				$("#divImgVid").show();

				$("#divImgVid").html(data);

			}

			

     	});

	}*/

	

	/*function getprevImgVid(pageid , userid, type, tileid, imageorvideo)

	{

		

		var url='<?php echo Yii::app()->createUrl("/finao/getDetails"); ?>';

		$.post(url, { pageid :  pageid , userid : userid , type : type , tileid : tileid , imageorvideo : imageorvideo },

	   		function(data){

	   			//alert(data);

				if(data)

				{

					$("#divImgVid").show();

					$("#divImgVid").html(data);

				}

				

	     });

	}*/



</script>







<div class="fixed-image-slider" id="tiles-strip">

  	<div class="mytiles"><?php if(isset($userinfo) && !empty($userinfo->fname)){?><h3><?php echo ucfirst($userinfo->fname); } ?>'s <br />Tiles <?php if(isset($alltiles) && !empty($alltiles)){echo "(".$totaltilecount.")";}?></h3></div>

    	

	<div class="portfolio-slider" style="color:#FFF;" >

	

	<div id="wrapper">

		<div id="thumbs">

		

		<?php if(isset($alltiles) && !empty($alltiles)){

			

			foreach($alltiles as $eachtile)

			{?>

				<!--<div class="tiles-display-area">-->
	             <!--<span class="tile-image">-->
	                 <!--<a href="#">-->
									
					 <img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php if ((preg_match("/.png\b/i", $eachtile->tile_profileImagurl)) || (preg_match("/.jpg\b/i", str_replace(" ","",$eachtile->tile_profileImagurl)))){ echo str_replace(" ","",$eachtile->tile_profileImagurl);}else{echo str_replace(" ","",$eachtile->tile_profileImagurl).".png";}?>" width="80" height="60" title="<?php echo $eachtile->tile_name; ?>" alt="<?php echo $eachtile->tile_name; ?>" onclick="deselectfinao(); getfinaos(<?php echo $eachtile->userid;?>,<?php echo $eachtile->tile_id;?>)" />
					 
					 <!--</a>-->
	              <!--      <span class="tile-caption"><?php echo $eachtile->tile_name; ?></span>
	                </span>-->
	            <!--</div>-->
				
				       

	<?php 	} }

?>

        

		</div>

        <a id="prev" href="#"></a>

		<a id="next" href="#"></a>

		</div>

	

	</div>

	

	

	

	<div id="stripstatislink" >

	</div>



<div class="videos" style="text-align: center;">

	<div id="showVideos" <?php if($videocount == 0) {?> class="no-photo-video"  <?php } ?>  >

	    <?php if($videocount > 0) {?>

		<a class="photos-videos" onclick="getDetails('Video',<?php echo $userinfo->userid; ?>,0,'tilepage')" href="javascript:void(0)">

		<?php } ?>

			VIDEOS <span id="spncntVid"><?php echo ($videocount > 0) ? "(".$videocount.")" :""; ?></span>

		<?php if($videocount > 0) {?>

		</a>

		<?php } ?>

	</div>

</div>	

<div class="photos" style="text-align: center;">

	<div id="showImages" <?php if($imgcount == 0) {?> class="no-photo-video"  <?php } ?>  >

	  <?php if($imgcount > 0) {?>

		<a class="photos-videos" onclick="getDetails('Image',<?php echo $userinfo->userid; ?>,0,'tilepage')" href="javascript:void(0)">

	  <?php } ?>	

		PHOTOS <span id="spncntImg"><?php echo ($imgcount > 0) ? "(".$imgcount.")" : ""; ?></span>

	  <?php if($imgcount > 0) {?>	

		</a>

	  <?php } ?>	

	</div>

</div>

    <div style="clear:right;"></div>

</div>



