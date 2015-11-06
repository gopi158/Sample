<?php //print_r($tileid);?>
 <script>
	jQuery(document).ready(function ($) {
	"use strict";
	if($('#Default3').length)
		$('#Default3').perfectScrollbar();
	});
</script>	
<!-- Accordian Start -->

<!--<script type="text/javascript" src="<?php //echo Yii::app()->baseUrl;?>/javascript/accordian/scriptbreaker-multiple-accordion-1.js"></script>-->

<!--<script language="JavaScript">

$(document).ready(function() {

	$(".topnav").accordion({

		accordion:false,

		speed: 500,

		closedSign: '+',

		openedSign: '-'

	});

});



</script>-->

<!-- Accordian End -->
<!--<link rel="stylesheet" href="<?php echo $this->cdnurl; ?>/css/component.css" type="text/css" media="screen" />-->

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/javascript/modernizr.custom.js"></script>

<?php $findwho = User::model()->findByPk($userid);?>

<?php 


if($type=="trackingyou"){?>

		<?php

		if(isset($findalltiles) && !empty($findalltiles))

		{ ?>

			<div class="font-14px padding-10pixels left"> <?php if($findwho->userid == Yii::app()->session['login']['id'] && $share != "share"){?> <?php } else { echo ucfirst($findwho->fname)."'s"; }?>  Followers </div>
				
			<?php //if(count($imtracking)>0){?>
				
			<!--<div class="left show-links" style="margin-top:4px;"><!--  yourtracking('trackingyou',this.value) <a href="javascript:void(0)" class="orange-link" onclick="showtile()">Sort By Tile</a> |<a href="javascript:void(0)" class="orange-link" onclick="yourtracking('trackingyou')">Show All</a></div>-->

	

	   <?php // if(!empty($findalltiles) && count($findalltiles) >= 1) { ?>

		<div class="right">Filter By: <?php echo CHtml::dropDownList('tilefilter',$tileid,CHtml::listData($findalltiles, 'tile_id', 'tile_name'),array('prompt'=>'All Tiles',"class"=>"dropdown-grid","onchange"=>"yourtracking('trackingyou',this.value)"));?></div>

		<?php //} ?>

		<?php // }
		if(empty($imtracking)) { echo "Followers List Empty";}
else {?>

		<div class="clear-right padding-10pixels"></div>

		<div id="Default3" class="contentHolder2">

			<div class="friends-list-wrapper" id="divtrackedlist">
			  <ul class="grid cs-style-7">

				<?php  $i=1;
				  foreach($imtracking as $track){ $i++; //echo $track->tracked_userid;
				
				$ful_tracking = Tracking::model()->findByAttributes(array('tracker_userid'=>$track->tracker_userid));
				//print_r($ful_tracking);
						$userimage = UserProfile::model()->findByAttributes(array('user_id'=>$track->tracker_userid));

						if(isset($userimage->profile_image) && $userimage->profile_image != "") 

							$src = Yii::app()->baseUrl."/images/uploads/profileimages/".$userimage->profile_image;

						else

							$src = Yii::app()->baseUrl."/images/no-image.jpg"

				?>	
						<li>
                             <figure> 
						<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg/frndid/'.$track->tracker_userid);?>"><img src="<?php echo $src ?>" width="45" height="45" style="border:solid 3px #d7d7d7;" title="<?php echo ucfirst($track->trackerUser->fname)." ".ucfirst($track->trackerUser->lname); ?>" /></a>
						<figcaption><?php if($ful_tracking->status =='1'){?>
						<a id="stat_<?php  echo $i;?>" href="javascript:void(0)" onclick="change_status_block('<?php echo $track->tracker_userid;?>','2','<?php echo $i;?>');">Block</a>
						<?php } else { // if($ful_tracking->status =='2')?>
						<a id="stat_<?php echo $i;?>" href="javascript:void(0)" onclick="change_status_block('<?php echo $track->tracker_userid;?>','1','<?php echo $i;?>');">Unblock<?php }?></a></figcaption>						
							 </figure>
						</li>	
				<?php }?>
			</ul>
			
			</div>

		</div>

	<!--<ul class="topnav" id="sorttile">-->

	    

		

	<?php } /*}

	}*/?>

	<!--</ul>-->

<?php }
else{?>
	<div class="font-14px padding-10pixels">Followers </div>
<?php }
?>

<div id="showall" style="display:none;">

<?php foreach($imtracking as $track){?>

	<div>

	<?php echo ucfirst($track->trackerUser->fname)." ".ucfirst($track->trackerUser->lname);?>

	</div>

<?php }?>

</div>

<?php }?>

<script type="text/javascript">

function sortshowall()

{

	$("#sorttile").hide();

	$("#showall").show();

}

function showtile()

{

	$("#sorttile").show();

	$("#showall").hide();

}

</script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl;?>/javascript/toucheffects.js"></script>