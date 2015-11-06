<?php if(isset($isjournals) && $isjournals=="journals"){?>
<div class="journal-slider">
<?php $this->renderPartial('_completedSingle',array('eachfinao'=>$finaoinfo,'getimages'=>$getimages,'userid'=>$userid));?>
<div class="journal-tab-content">
		<h2 class="fitness-detail-hdline"><?php echo $tileid->tile_name;?> Activity Log</h2>
		<?php if(!empty($journals)){
			
		
		foreach($journals as $eachjournal)
		{?>
			<div class="log-detail">
			<div id="journalmesg-<?php echo $eachjournal->finao_journal_id;?>"><?php echo $eachjournal->finao_journal;?></div>
			</div>
	<?php } }
		?>
	</div>
</div>

<?php }else{?>
<div class="slider-navigation">
<?php 
if($prev<$noofpages && $prev>0)
{?>
	<a href="javascript:void(0)" onclick="getprevfinao(<?php echo $prev;?>,<?php echo $userid;?>,'prev',0,'completed')" class="slider-navigation-left"><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-arrow-left.png" width="28" /></a>
<?php 
}else{?>
	<!--<a href="javascript:void(0)" class="slider-navigation-left"><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-arrow-left.png" width="28" /></a>-->
	
<?php }?>
<?php if($next<=$noofpages){?>

	<a onclick="getprevfinao(<?php echo $next;?>,<?php echo $userid;?>,'next',0,'completed')" class="slider-navigation-right">
		<img src="<?php echo Yii::app()->baseUrl;?>/images/icon-arrow-right.png" width="28" />
	</a>

<?php }else{?>

	<!--<a href="javascript:void(0)" class="slider-navigation-right"><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-arrow-right.png" width="28" /></a>-->

<?php }?>
</div>
<div class="journal-slider">
<?php
foreach($allfinaos as $eachfinao)
{?>
<?php $this->renderPartial('_completedSingle',array('eachfinao'=>$eachfinao,'getimages'=>$getimages,'userid'=>$userid));?>
	
<?php }?>
</div>
<?php }?>