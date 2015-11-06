
<input type="hidden" id="voteduser" value="<?php echo $voted_userid; ?>"  />
<input type="hidden" id="sourceid" value="<?php echo $sourceid; ?>"  />
<link href="<?php echo $this->cdnurl;?>/css/hbcu.css" rel="stylesheet" />
 <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/oswald/stylesheet.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $this->cdnurl;?>/Fonts/barkentina/stylesheet.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->cdnurl; ?>/javascript/fancybox-1.3.4/source/jquery.fancybox.css?v=2.1.5" media="screen" /> 
<script type="text/javascript">
	$(document).ready(function($){$(".fancybox-share").fancybox({});});
</script>
<style>
.vote-now {
/*background: url(../images/vote-bg.png) left top repeat-x;*/
background-color:#f57b20;
height: 19px;
padding: 0 10px;
font-size: 12px;
color: #FFF;
}
.voted-now {
background-color:#E5E5E5;
/*background: url(../images/voted-bg.png) left top repeat-x; */
height: 19px;
padding: 0 10px;
font-size: 12px;
color: #343434;
cursor:default!important
}
</style>


<link href="<?php echo $this->cdnurl;?>/css/responsive.css" rel="stylesheet">
<a id="registered1" href="#registeredcontent1" ></a>
<div class="hbcu-pages-wrapper">
    <div id="hbcu-middle-container">
        <div id="hbcu-promo-container">
            <div class="hbcu-splash-banner">
            	<img src="<?php echo $this->cdnurl;?>/images/splashHeader.png">
                <div class="hbcu-share-container">
                	<div class="hbcu-share-top-area">
                    	<span><a href="hbcu-promo.html"><img class="careercatapult-logo" src="<?php echo $this->cdnurl;?>/images/careerCatapult.png"></a></span>
                        <span class="hbcu-shared-person"><span class="orange"><?php echo " ".ucfirst($displayvideo1['fname']);?></span> Shared a Video</span>
                        <span style="margin-top:10px;" class="right">
						<?php if(empty(Yii::app()->session['login']['id'])){?> 	
					<a id="registere" href="javascript:void(0)" onclick="fireClick();" class="orange-link1 font-14px">					Vote Now</a><?php } else { if($votevideo) {?>
					<span  class='votevideo voted-now' >Voted</span><?php } else {?>
					<span id='votes' class='votevideo vote-now' style="cursor:pointer" onclick='myFunctions(<?php echo $displayvideo['uploadedby'];?>,<?php echo $displayvideo['uploaddetail_id'];?>)'>Vote Now</span> <?php  } }?>
					
					</span> 
                    </div>
                    <div class="hbcu-share-area">
					
                        <iframe frameborder="0" webkitallowfullscreen="true" mozallowfullscreen="true" src="//www.viddler.com/embed/<?php echo $displayvideo['videoid']?>/?f=1&amp;player=simple&amp;secret=<?php echo $displayvideo['videoid']?>" id="viddler-bb13af7"></iframe>
						<?php if(Yii::app()->session['login']['id']){?><div style=" display:none" class="view-more-videos"><a href="<?php echo Yii::app()->createUrl('finao/Viewvideohdcu');?>" ><input type="button" class="blue-button" value="View more Videos" /></a></div><?php }?>
                    </div>
                    <div class="hbcu-finao-shared-message"><?php echo $finaovideoprofile['finao_msg'];?></div>
                </div>                
            </div>
        </div>
    </div>
<script type="text/javascript">

<?php 
 if(!empty($confirm) and $confirm == 'true'){?> 
$("#registered1").fancybox({
		'scrolling'		: 'no',
		'titleShow'		: false,
		'hideOnOverlayClick' : false,
		'autoScale'           : true,
		  'fixed': false,
         'resizeOnWindowResize' : false
	});
	
$("#registered1").trigger('click');	
 
<?php }?>


function fireClick()
{
  //alert("Hello");
 <?php $type = 'video'; ?>
 $("#registered_video").trigger('click');
  
 
}
<?php if(Yii::app()->session['login']['id']){?>
function myFunctions(userid,videoid)
{
	var url='<?php echo Yii::app()->createUrl("/finao/voteVideo"); ?>';
	$.post(url, { voteduserid:userid, videoid:videoid,voteruserid:<?php echo Yii::app()->session['login']['id']; ?> },
		function(data){$('#votes').attr('onclick','');$('.view-more-videos').show();$('#votes').html('Voted'); $("#votes").toggleClass('vote-now voted-now');});
 }
 <?php }?>
 
</script>

<?php   $this->widget('EasyRegister',array('type'=> $type,'pid'=>'65')); ?>
