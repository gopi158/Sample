<?php if($pagetype=="tilepage"){?>

<style>

	.uploadedimage {

		clear: right;

		background: #000;

		text-align: center;

		padding: 15px 0;

		overflow: hidden;

}

</style>



<div class="finao-canvas"> 

	<div id="closefinaodiv" > <!--onclick="js:hidealldivs();$('#allinfo').show();"-->
		<?php
		if(isset($heroupdate) && $heroupdate != "")
		{
			$url = "";
		}
		else if($userid==Yii::app()->session['login']['id'] && $share!="share" && $completed != "completed"){
			$url = Yii::app()->createUrl('finao/motivationmesg');
			 }else{
			 $url = Yii::app()->createUrl('finao/motivationmesg/frndid/'.$userid);
			 }?>
		<a class="btn-close" <?php if($url != ""){?> href="<?php echo $url; ?>" <?php }else{?> onclick="closeheroupdate()" <?php }?>><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

	</div>

	<div class="image-gallery">

	<div >

	

	<span class="left my-finao-hdline orange">

	

		<?php if($uploadtype == 'Image')

			 { ?>

			 Photo Gallery

		<?php }else if($uploadtype == 'Video')

			 {?>

			 Video Gallery

		<?php }?>

	</span> 



	<span class="right" style="font-size:25px; padding-right:0px; padding-top:10px;">
	<?php if($heroupdate == ""){if($completed != "completed"){ ?>
<a id="allfinaos-images" onclick="getprevfinao(<?php echo $page;?> , <?php echo $userid;?>, 0, <?php echo $tileid;?> , 0)" class="journal-entry" style="float:right;"> <img src="<?php echo $this->cdnurl;?>/images/back-btn.png" align="Back to FINAO"/></a>
 <?php }else{?>
 <a id="allfinaos-images" onclick="getprevfinao(<?php echo $page;?> , <?php echo $userid;?>, 0, 0 , 'completed')" class="journal-entry" style="float:right;"> <img src="<?php echo $this->cdnurl;?>/images/back-btn.png" align="Back to FINAO"/></a>
 <?php }}?>
 
 		<span style="margin-right:10px;"> 
		<?php if(isset($tileinfo))

				echo $tileinfo->lookup_name;
		 ?>
		</span>
	</span>

	

	</div>

	

	<div class="clear-left"></div>

	

	<div class="gallery-navigation">

		<?php if($noofpages>1){

		if($prev<=$noofpages)

		{?>

			<a onclick="getprevImgVid(<?php echo $prev;?>,'<?php echo $groupid; ?>',<?php echo $userid;?>,'prev',<?php echo $tileid;?>,'<?php echo $uploadtype;?>','<?php echo $pagetype;?>')" class="slider-navigation-left" href="javascript:void(0)">&nbsp;<!--<img src="<?php echo $this->cdnurl;?>/images/icon-arrow-left.png" width="28" />--></a>

		<?php 
		} ?>

		<?php if($next<=$noofpages){?>



			<a onclick="getprevImgVid(<?php echo $next;?>,'<?php echo $groupid; ?>',<?php echo $userid;?>,'next',<?php echo $tileid;?>,'<?php echo $uploadtype;?>','<?php echo $pagetype;?>')" class="slider-navigation-right" href="javascript:void(0)">&nbsp;

				<!--<img src="<?php echo $this->cdnurl;?>/images/icon-arrow-right.png" width="28" />-->

			</a>



		<?php } }?>

	</div>

<?php foreach($uploadinfo as $eachImgVid)

 { 
	
?>
		<div class="fixed-gallery-area">
		 <div class="finao-gallery-area" id="gallery">

       <?php

         if($uploadtype == 'Image')
		 { 	
		 	 if(file_exists(Yii::app()->basePath."/../".$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"]) && $eachImgVid["uploadfile_name"] != "") { ?> 
			
			<img src="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"]; ?>" style="width:300<?php //echo $resizeWidth;?>px;height:<?php //echo $resizeHeight;?>px" /> 
			
 	<?php }else{ ?>
	
			<img src="<?php echo $this->cdnurl; ?>/images/logo-n.png" /> 
	
	<?php } ?>			

<?php	 }

		 elseif($uploadtype == 'Video')
		 {
			
			if(isset($eachImgVid["videoid"]) && $eachImgVid["videoid"] != "")
			{
				if(isset($videmcode) && $videmcode != "")
				{
					foreach($videmcode as $embcode)
					{
						if(isset($embcode["embedcode"]["video"]["embed_code"]))
							echo $embcode["embedcode"]["video"]["embed_code"];	
					}	
				}	
			}
			
			elseif($eachImgVid["video_embedurl"] != "")
			{
				echo $eachImgVid["video_embedurl"];
			}
			else{ 
	
				echo '<img src="<?php echo $this->cdnurl; ?>/images/logo-n.png" />';
	
			}
		 }

?>		 

		<div class="gallery-image-caption" id="captionofgallery" ><?php echo $eachImgVid["caption"];?></div>

         </div>
         </div>

		   

<?php				

 }?>

 </div>

</div>

<?php }elseif($pagetype=="finaopage"){ ?>

<div class="slider-navigation">

<?php if($noofpages>1){

if($prev<=$noofpages)

{?>

	<a onclick="getprevImgVid(<?php echo $prev;?>,'<?php echo $groupid; ?>',<?php echo $userid;?>,'prev',<?php echo $tileid;?>,'<?php echo $uploadtype;?>','<?php echo $pagetype;?>',<?php echo $finaoid; ?>,<?php echo $journalid; ?>)" class="slider-navigation-left" href="javascript:void(0)">&nbsp;<!--<img src="<?php echo $this->cdnurl;?>/images/icon-arrow-left.png" width="28" />--></a>

<?php 

} ?>

<?php if($next<=$noofpages){?>



	<a onclick="getprevImgVid(<?php echo $next;?>,'<?php echo $groupid; ?>',<?php echo $userid;?>,'next',<?php echo $tileid;?>,'<?php echo $uploadtype;?>','<?php echo $pagetype;?>',<?php echo $finaoid; ?>,<?php echo $journalid; ?>)" class="slider-navigation-right" href="javascript:void(0)">&nbsp;

		<!--<img src="<?php echo $this->cdnurl;?>/images/icon-arrow-right.png" width="28" />-->

	</a>



<?php } }?>

</div>

<?php $i=0; foreach($uploadinfo as $eachImgVid)
 { $i++;
 
 if($eachImgVid['videoid']=='' and $eachImgVid['video_embedurl']!='' )
 {
	$s=explode('src=',$eachImgVid['video_embedurl']);$ss=explode('"',$s[1]);
	$src=$ss[1];
 }
 else if($eachImgVid['video_img']!='')
 {
	$src="//www.viddler.com/embed/".$eachImgVid['videoid']."/?f=1&amp;player=simple&amp;secret=".$eachImgVid['videoid'];
 }		 		

	 
	if($eachImgVid["uploadfile_name"] != "" && file_exists(Yii::app()->basePath.'/../'.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"])){
?>
     
<?php if(file_exists(Yii::app()->basePath.'/../'.$eachImgVid["uploadfile_path"]."/medium/".$eachImgVid["uploadfile_name"])){   $path = "/medium/"; }else{  $path = "/";}?>
     <a class="fancybox_group" data-fancybox-group="gallery" href="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"]; ?>"> 
		<!--<div  style=" overflow:hidden;background:url('<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"].$path.$eachImgVid["uploadfile_name"]; ?>') center center no-repeat; width:<?php echo $resizeWidth;?>px;height:<?php echo $resizeHeight;?>px;"  >       
</div>-->
        <img src="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"].$path.$eachImgVid["uploadfile_name"]; ?>" style="width:<?php echo $resizeWidth;?>px;height:<?php echo $resizeHeight;?>px" title=""/>
		</a>

<?php } else if($eachImgVid["video_embedurl"] != '')
		 {?>
		 <a id="fancybox-media" rel="" href="<?php echo $src;?>" >
		 
						<img src="<?php echo $eachImgVid['video_img']; ?>" <?php //echo $style ; ?> />
					<span class="video-link-span1"></span>
                    </a>
		 <?php } 
		 else
		 {
		 	if(isset($videmcode) && $videmcode != "")
			{
				foreach($videmcode as $embcode)
				{
					if(isset($embcode["embedcode"]["video"]["embed_code"]))
					{?>
					<?php /*?> <a class="fancybox123" rel="" href="#inline1" onclick="videogallery(<?=$eachImgVid['uploadedby']?>,<?=$i;?>,'Video','populatevideos');" title="<?php //echo $eachImgVid["caption"]  ?>"><?php */?>
					<a id="fancybox-media" rel="" href="<?php echo $src;?>" title="<?php //echo $eachImgVid["caption"]  ?>">
					 	<img src="<?php echo $eachImgVid['video_img']; ?>" style="width:300px; height:240px;" <?php //echo $style ; ?> />	
                        <span class="video-link-span1"></span>
                        </a>				
				<?php }	
				}	
			}
			else
				echo '<img src="'.$this->cdnurl.'/images/logo-n.png" />';
		 }?>

<div class="image-caption" id="finaoimagecaption" >

<?php //echo $eachImgVid["caption"]; //if(isset($getimages) && !empty($getimages)) echo $allimages["caption"]; ?>

<?php  
   $check=$eachImgVid["caption"];
 if ($check == 'Add Caption' || $check == 'Enter Caption' ) {

} else {
     echo $eachImgVid["caption"];
}
    ?>

</div>

<?php				

 }?>

<?php }elseif($pagetype=="journalpage"){?>

<div id="closejournalimagediv" > <!-- onclick="js:hidealldivs();$('#allinfo').show();"     -->

		<a class="btn-close" onclick="js: if($('#ifrplayer').length){ $('#ifrplayer').attr('src',''); } $('#Default4').show(); $('#journalimages').hide();  " href="javascript:void(0)"><img src="<?php echo $this->cdnurl; ?>/images/close.png" width="40" /></a>

	</div>

<?php foreach($uploadinfo as $eachImgVid)

 {

?>

		 <div>

                 <?php

                 if($uploadtype == 'Image')

		 { ?>

		 	

			<!--<img src="<?php echo $this->cdnurl."/".$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"]; ?>" style="width:870px;height:305px;" />		 		-->
		<?php if(file_exists(Yii::app()->basePath."/../".$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"])) { ?>
			<img src="<?php echo $this->cdnurl.$eachImgVid["uploadfile_path"]."/".$eachImgVid["uploadfile_name"]; ?>" style="width:<?php echo $resizeWidth;?>px;height:<?php echo $resizeHeight;?>px"/> 
	<?php }else{ ?>
	
			<img src="" /> 
	
	<?php } ?>

<?php	 }

		 else if($uploadtype == 'Video')
		 {

		 	if($eachImgVid["video_embedurl"] != "")
			{
			 	echo $eachImgVid["video_embedurl"];	
			}
			else if(isset($videmcode) && $videmcode != "")
			{
				foreach($videmcode as $embcode)
				{
					if(isset($embcode["embedcode"]["video"]["embed_code"]))
						echo $embcode["embedcode"]["video"]["embed_code"];	
				}	
			}
		 }

?>		 

		<div class="gallery-image-caption" id="" ><?php echo $eachImgVid["caption"];?></div>

         </div>

		   

<?php				

 }?>

<?php }?>
