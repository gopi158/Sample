	<?php if(!isset($frndprofile) && $frndprofile!="mainpage"){?>
	<div style="float:left; width:200px;"><img src="<?php echo Yii::app()->baseUrl;?>/images/uploads/profileimages/<?php echo $user->profile_image;?>" width="50%"/></div>
	<?php }?>
	<?php $total = count($ontrack)+count($ahead)+count($behind);//+count($completed);
			if($total<=0){ $total = 1;}
			$ontrackwidth = floor((count($ontrack)/$total)*100);
			$aheadwidth = floor((count($ahead)/$total)*100);
			//$behindwidth = ceil((count($behind)/$total)*100);
			//$behindwidth = 100 - ($ontrackwidth) - ($aheadwidth);
			$behindwidth = floor((count($behind)/$total)*100);
			//$completedwidth = floor((count($completed)/$total)*100);
	?>
	<?php if($total >= 1) { ?>
		<?php if(isset($leftlayout) && $leftlayout != ""){?>
			<div class="font-16px padding-10pixels">ALL UP STATUS</div>
			<!--<div class="prog-bar-width">
				<span class="ahead-bar"></span>
				<span class="status-text">A Head</span>
			</div>-->
            
            <!--<div class="ahead"></div>
            <div class="behind"></div>
            <div class="ontrack"></div>-->
            
			<?php if(count($ahead)>0){?>
			<div class="prog-bar-width">
            <div class="ahead" style="width:<?php echo $aheadwidth;?>%"></div>
			<span class="status-text">AHEAD <?php echo $aheadwidth." %";?></span>
			</div>
			<?php }?>

            <div class="clear-left" ></div>

			<?php if(count($ontrack)>0){?>

			<div class="prog-bar-width">

            <span class="ontrack-bar" style="width:<?php echo $ontrackwidth;?>%"></span>

			<span class="status-text">ON TRACK <?php echo $ontrackwidth." %";?></span>

			</div>

            <?php }?>

            <div class="clear-left"></div>

			<?php if(count($behind)>0){?>

			<div class="prog-bar-width">

            <span class="behind-bar" style="width:<?php echo $behindwidth;?>%"></span>

			<span class="status-text">BEHIND <?php echo $behindwidth." %";?></span>

			</div>

            <?php }?>		

	<?php }elseif(isset($finaopage) && $finaopage=="finao"){?>
		
		<?php if(count($ontrack)>0){?>
            <div class="ontrack" style="width:<?php echo $ontrackwidth;?>%"><?php echo count($ontrack);?></div>
        <?php }?>
		<?php if(count($ahead)>0){?>
           <div class="ahead" style="width:<?php echo $aheadwidth;?>%"><?php echo count($ahead);?></div>
		<?php }?>
		<?php if(count($behind)>0){?>
            <div class="behind" style="width:<?php echo $behindwidth;?>%"><?php echo count($behind);?></div>
        <?php }?>
		<?php }else {?>

	<div class="progress-meter" style="width:99%;position:absolute; bottom:0;">

	<?php if(count($behind)>0){?>

	<div class="behind" style="width:<?php echo $behindwidth;?>%">

	<span><?php echo $behindwidth .'%';?></span>

	</div>

	<?php }?>

	<?php if(count($ontrack)>0){?>

	<div class="ontrack" style="width:<?php echo $ontrackwidth;?>%">

	<span><?php echo $ontrackwidth .'%';?></span>

	</div>

	<?php }?>

	<?php if(count($ahead)>0){?>

	<div class="ahead" style="width:<?php echo $aheadwidth;?>%">

	<span><?php echo $aheadwidth .'%';?></span>

	</div>

	<?php }?>

	</div>

	<?php }?>

<?php } ?>