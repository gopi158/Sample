<div class="tiles-container">
	<div class="tile-container-navigation">
		<?php if($noofpages>1){
				if($prev <= $noofpages)
				{?>
					<a onclick="getnextprevtiles(<?php echo $userid;?>,<?php echo $prev;?>)" class="tile-container-navigation-left" href="javascript:void(0)">&nbsp;</a>
				<?php }?>
				<?php if($next<=$noofpages){?>
					<a onclick="getnextprevtiles(<?php echo $userid;?>,<?php echo $next;?>)" class="tile-container-navigation-right" href="javascript:void(0)">&nbsp;
					</a>
				<?php }?>
		<?php  }?>
	</div>
	<div class="detailed-container">
	<?php foreach($alltiles as $eachtile){?>
		<?php //print_r($eachtile->tile_id); print_r($eachtile->tilename); print_r($eachtile->tile_imageurl); echo "<br />"; ?>
		<div class="holder smooth">
    	   	<a onclick="putseltile(<?php echo $eachtile->tile_id;?>);getdetailtile(<?php echo $eachtile->userid;?>,<?php echo $eachtile->tile_id;?>)" href="javascript:void(0)">
			<?php if(isset($eachtile->tile_imageurl)){
					if(file_exists(Yii::app()->basePath."/../images/tiles/".str_replace(" ","",$eachtile->tile_imageurl)))
					{ ?>
					<img src="<?php echo $this->cdnurl;?>/images/tiles/<?php echo str_replace(" ","",$eachtile->tile_imageurl);?>"
					  width="125" height="90" title="<?php echo $eachtile->tilename; ?>" id="tile_imageurl-<?php echo $eachtile->tile_id; ?>"/>
					  <?php /*if ((preg_match("/.png\b/i", $eachtile->tile_imageurl)) || (preg_match("/.jpg\b/i", str_replace(" ","",$eachtile->tile_imageurl)))){ echo str_replace(" ","",$eachtile->tile_imageurl);}else{echo str_replace(" ","",$eachtile->tile_imageurl).".png";}*/?>
					<?php }else{?>
					<img src="<?php echo $this->cdnurl;?>/images/upload-tileimg-small.png"/>
					<?php }
				}else
				{ ?>
					 <img src="<?php echo $this->cdnurl;?>/images/upload-tileimg-small.png"/>
			  <?php 	}?>
			</a>
            <?php /*?><span class="tile-image-caption" id="tilename-<?php echo $eachtile->tile_id; ?>"><?php echo $eachtile->tilename; ?></span><?php */?>
            
            <span class="tile-image-caption" <?php if($eachtile->Is_customtile !=1){?>style="background:none;" <?php }?>  id="tilename-<?php echo $eachtile->tile_id; ?>">
			
            <span class="tile-image-caption-position">
			<?php echo $eachtile->tilename; ?>
            </span>
            
            
            </span>
			<div id="edittilename-<?php echo $eachtile->tile_id; ?>" style="display:none;">
			<input type="text" class="txtbox" id="tiletext-<?php echo $eachtile->tile_id; ?>" maxlength="16" onkeypress="submittile(this,event,<?php echo $userid;?>,<?php echo $eachtile->tile_id; ?>)"/>
			<a  id="savetile-<?php echo $eachtile->user_tileid; ?>" href="javascript:void(0)"   onclick="savetilename(<?php echo $userid;?>,<?php echo $eachtile->tile_id; ?>)" title="Save" style="float:left; width:35px;"><li class="icon-save"></li></a>

			<a id="closetile-<?php echo $eachtile->tile_id; ?>" href="javascript:void(0)" onclick="closetilename(<?php echo $userid;?>,<?php echo $eachtile->tile_id; ?>)" title="Close" style="float:left; width:35px;"><li class="icon-close"></li></a>
			</div>
			<?php if($eachtile->Is_customtile==1){?>
            <!--<span class="edit-tile-options" id="settingsmenu-<?php echo $eachtile->user_tileid;?>" style="display:none;">
				<a href="#" title="Edit Tile" ><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-settings.png" width="20" /></a>
				 <div class="tile-settings" style="display:none;" id="tilemenu-<?php echo $eachtile->user_tileid;?>">
                    <a href="#" class="white-link font-11px" onclick="changetilename(<?php echo $userid;?>,<?php echo $eachtile->user_tileid;?>)">Rename Tile</a>
                 	<a href="#" class="white-link font-11px">Change Tile Image</a>
				 
                 </div>
			</span>-->
			<?php }?>
        </div>
	<?php }?>
	</div>
</div>

<script type="text/javascript">

<?php foreach($alltiles as $eachtile){?>
/*if($('#settingsmenu-<?php echo $eachtile->user_tileid;?>').doesExist()==true){*/
	$("#settingsmenu-<?php echo $eachtile->tile_id;?>").mouseover(function(){
	$('#tilemenu-<?php echo $eachtile->tile_id;?>').show();
	});
$("#settingsmenu-<?php echo $eachtile->tile_id;?>").mouseout(function(){
	$('#tilemenu-<?php echo $eachtile->tile_id;?>').hide();
	});

<?php }?>

</script>