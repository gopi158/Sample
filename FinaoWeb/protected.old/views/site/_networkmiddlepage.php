		 <?php $firstrecord = true;
		 	   
		  ?>
		  <?php //print_r(Yii::app()->session['allcontacts']);?>
		 <?php foreach($userDet as $connectionDetails) { ?>								
	<?php //print_r(Yii::app()->session['knownusers']); 
		
		$knownusers = Yii::app()->session['knownusers']; //print_r($knownusers); ?>
		
        	<div class="alphabet-group">
            	<h2 class="alphabet-headline"><?php echo strtoupper($connectionDetails["alpha"]); ?><img src="<?php echo Yii::app()->baseUrl; ?>/images/hrline.png" class="hrrline" /></h2>
				<?php foreach($connectionDetails["details"] as $indiviualDetails) { 
				
					if($firstrecord)
						$firstConUserID = $indiviualDetails["userid"];
						
				?>
				
				<!-- class="friend-details friend-details-active" -->
                <div id="div<?php echo $indiviualDetails["userid"]; ?>" <?php if($firstrecord) echo 'class="friend-details friend-details-active"'; else echo 'class="friend-details"'; ?>  style="border-bottom:none;">
                	<div class="check-friend" style="display:none"><input type="checkbox" /></div>
                    <div class="friend-pic"><a href="#" ><!--<img src="<?php echo Yii::app()->baseUrl; ?>/images/default-photo.png" width="44" style="border:solid 1px #e6e6e6;" />-->
					<img src="<?php echo ($indiviualDetails["profile_image"] != "") ? Yii::app()->baseUrl."/images/uploads/parentimages/".$indiviualDetails["profile_image"] : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="46" height="50" style="border:solid 1px #e6e6e6;" />
					</a></div>
                    <div class="friend-name"><a href="#" class="black-link" onclick="displaySelectedData(<?php echo $indiviualDetails["userid"]; ?>); return false;" ><?php echo $indiviualDetails["fname"];?></a></div>
				
                </div>
				
				<?php if(isset(Yii::app()->session['knownusers'])) if(in_array($indiviualDetails["socialnetworkid"] , $knownusers))
				{
					echo "UR FB FRIEND";
				} ?>
				<?php $firstrecord = false; } ?>
				
            </div>
			<input type="hidden" name="firstConUserId" id="firstConUserId" value="<?php echo $firstConUserID; ?>" />
          <?php } ?>  