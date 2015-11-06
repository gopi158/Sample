<div class="friend-description">
    	<img src="<?php echo ($firstConnection["profile_image"] != "") ? Yii::app()->baseUrl.'/images/uploads/parentimages/'.$firstConnection["profile_image"] : Yii::app()->baseUrl."/images/default-photo.png" ; ?>" width="84" height="91" class="right"  style="margin-right:15px;"/>
        <div class="connection-right-title"><a href="<?php echo Yii::app()->createUrl('educationalPlan/EducationalPlans',array('frndid'=>$firstConnection["userid"])); ?>"><?php echo $firstConnection["fname"]; ?></a>
		</div>
         <p class="run-text padding-8pixels" ><?php echo $firstConnection["email"]; ?></p>
		 <?php if(isset($firstConnection["description"])){?>
		 <div>Summary:</div>
		 <p class="run-text"><?php if(strlen($firstConnection["description"])>80)
				{
		 		$str = wordwrap($firstConnection["description"], 80);
					$str = explode("\n", $str);
					$str = $str[0] . '<a class="orange-link" href="'.Yii::app()->createUrl('site/networkConnections',array('displaydata'=>'proflieOrg','frndid'=>$firstConnection["userid"])).'"> more...</a>';
					echo $str;
		 		}
				else
					echo $firstConnection["description"];?>
		 <?php /*echo Yii::app()->createUrl('site/networkConnections',array('displaydata'=>'proflieOrg'))*/?>
		 </p>
		 <?php }?>
		  <!--
   Start:Changed by varma on 14122012
   For sending the encoded email value through the URL
   -->
   <?php
   $encode_email = base64_encode($firstConnection["email"]);
   ?>
   <input type="hidden" value="<?php echo $firstConnection["userid"];?>" id="currentuserid"/>
   <li  style="font-weight:bold; color:#206c86;">TILES</li>
   <?php if(empty($displaytiles)){?>
   no tiles added
   <?php }else{ ?>
		<?php foreach($displaytiles as $tiledisplay){?>
			
			
			<span class="interest-blue"><?php echo $tiledisplay["tile_name"];  ?></span>
		<?php } }?>
    </div>
<script type="text/javascript">
 $( document ).ready( function() {
 var userid = document.getElementById('currentuserid').value;
  	
			<?php foreach($displaytiles as $tiledisplay)
				{ ?>
					
					document.getElementById('<?php echo $tiledisplay["tile_name"]; ?>-'+userid).checked = true;
						
			<?php }?>

 
  });
</script>