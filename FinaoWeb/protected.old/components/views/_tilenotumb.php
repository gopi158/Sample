<!-- ========== Portfolio Slider Dropdown ============ -->

<!--<script src="<?php echo Yii::app()->baseUrl;?>/javascript/jquery.carouFredSel-6.0.4-packed.js" type="text/javascript"></script>-->

<script type="text/javascript">

	/*$(function() {

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

	});*/

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

	}

	

	function getprevImgVid(pageid , userid, type, tileid, imageorvideo)

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

  	<div class="mytiles"><?php if(isset($userinfo) && !empty($userinfo->fname)){?><h3><?php echo $userinfo->fname; } ?>'s Tiles <?php if(isset($alltiles) && !empty($alltiles)){echo "(".$totaltilecount.")";}?></h3></div>

    	

	<div class="portfolio-slider" style="color:#FFF;">

		<div id="wrapper">

			<div id="stripstatislink" >&nbsp;

			</div>

		</div>	

	</div>



<div class="videos" style="text-align: center;">

	<div id="showVideos" >

	    <?php if($videocount > 0) {?>

		<a onclick="getDetails('Video',<?php echo $userinfo->userid; ?>)" href="javascript:void(0)">

		<?php } ?>

			<h3 >VIDEOS <span id="spncntVid"><?php echo ($videocount > 0) ? "(".$videocount.")" :""; ?></span></h3>

		<?php if($videocount > 0) {?>

		</a>

		<?php } ?>

	</div>



</div>	

<div class="photos" style="text-align: center;">

	<div id="showImages" >

	  <?php if($imgcount > 0) {?>

		<a onclick="getDetails('Image',<?php echo $userinfo->userid; ?>)" href="javascript:void(0)">

	  <?php } ?>	

		<h3 >PHOTOS <span id="spncntImg"><?php echo ($imgcount > 0) ? "(".$imgcount.")" : ""; ?></span></h3>

	  <?php if($imgcount > 0) {?>	

		</a>

	  <?php } ?>	

	</div>

	

</div>

    <div style="clear:right;"></div>

</div>



