
<div class="image-gallery">
	<div >
	<span class="left my-finao-hdline orange">
		<?php $username  = ""; $userid = "";
			if(isset($userinfo) && count($userinfo) >= 1) { 
				$username = ucfirst($userinfo->fname)."'s";
				$userid = $userinfo->userid;
			 } ?>
		<?php if($uploadtype == 'Image')
			 {  ?>
			 <a class="orange my-finao-hdline" style="width:auto; !important" href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userid)); ?>"><?php echo $username; ?></a> Photo Gallery
		<?php }else if($uploadtype == 'Video')
			 {?>
			 <a class="orange my-finao-hdline" style="width:auto; !important" href="<?php  echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$userid)); ?>"><?php echo $username; ?></a> Video Gallery
		<?php }?>
	</span> 
	</div>

	<div class="clear-left"></div>

	<div class="gallery-navigation">
		<?php if($uploadtype == 'Image')
		{
			  $noofpages = $upPageNav["noofpage"];
			  $prev = $upPageNav["prev"];
			  $next = $upPageNav["next"];	 ?>
		
				<?php if($noofpages>1){
		
				if($prev<=$noofpages)
		
				{?>
		
					<a onclick="shownextpreImgVid(<?php echo $prev;?>,'<?php echo $uploadtype;?>','<?php echo $targetdiv; ?>')" class="slider-navigation-left" href="javascript:void(0)">&nbsp;</a>
		
				<?php 
				} ?>
		
				<?php if($next<=$noofpages){?>
		
					<a onclick="shownextpreImgVid(<?php echo $next;?>,'<?php echo $uploadtype;?>','<?php echo $targetdiv; ?>')" class="slider-navigation-right" href="javascript:void(0)">&nbsp;
					</a>
		
				<?php } }
		}elseif($uploadtype == 'Video') {
		
			 $noofpagesVid = $upPageNav["noofpage"];
			  $prevVid = $upPageNav["prev"];
			  $nextVid = $upPageNav["next"];	 ?>
		
			<?php if($noofpagesVid > 1){
		
				if($prevVid <= $noofpagesVid)
		
				{?>
		
					<a onclick="shownextpreImgVid(<?php echo $prevVid;?>,'<?php echo $uploadtype;?>','<?php echo $targetdiv; ?>')" class="slider-navigation-left" href="javascript:void(0)">&nbsp;</a>
		
				<?php 
				} ?>
		
				<?php if($nextVid <= $noofpagesVid){?>
		
					<a onclick="shownextpreImgVid(<?php echo $nextVid;?>,'<?php echo $uploadtype;?>','<?php echo $targetdiv; ?>')" class="slider-navigation-right" href="javascript:void(0)">&nbsp;
					</a>
		
				<?php } }
		
		} ?>
	</div>


	<div class="fixed-gallery-area">
	 <div class="finao-gallery-area" id="gallery">

   <?php if($uploadtype == Image){ 
   		
			$resizeWidth = ""; $resizeHeight = ""; 
			$targetWidth = 380;	$targetHeight = 430;
			list($sourceWidth,$sourceHeight) = getimagesize(Yii::app()->basePath."/..".$videoembedurl);
			
			if($sourceWidth <= $targetWidth && $sourceHeight <= $targetHeight)
			{
				$resizeWidth = $sourceWidth;
				$resizeHeight = $sourceHeight;
			}
			else
			{
				if($sourceWidth > $sourceHeight)
				{
					$targetWidth = 450;
					$targetHeight = 430;	
				}
				$resizevalue = FinaoController::getImgWidthHeight(Yii::app()->basePath."/..".$videoembedurl,$targetWidth,$targetHeight,$sourceWidth,$sourceHeight);
						
				$resizeWidth = $resizevalue['resizeWidth'];
				$resizeHeight = $resizevalue['resizeHeight'];
			} 	
   ?>
   <?php
         if($videoembedurl != "")
		 { 	?>
		 	 <!--  -->
			<img src="<?php echo $videoembedurl; ?>" style="width:<?php echo $resizeWidth;?>px;height:<?php echo $resizeHeight;?>px" /> 
 		
	<?php  	 } ?>
	<?php } else {
		echo $videoembedurl;	
	 }?>		 
	
	<div class="gallery-image-caption" id="captionofgallery" ><?php echo $caption;?></div>

     </div>
     </div>

 </div>