<?php if(count($uploadedimages) >= 1) { ?>

<script>

	jQuery(document).ready(function ($) {

	"use strict";
	if($('#Default5').length)
		$('#Default5').perfectScrollbar();

	});

</script>

 	<div class="orange font-16px padding-10pixels">Recently <?php echo ($IsImag == 1) ? "Uploaded Images" : "Uploaded Videos"; ?> </div>

	<div id="Default5" class="contentHolder1">

	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#b3b3b3">

		<tr>

            <th width="20%" class="table-header"><?php echo ($IsImag == 1) ? "Image" : "Video"; ?></th>

            <!-- Adding extra column for Video status -->

			<?php if($IsImag != 1){ ?>

			<th  class="table-header">Status</th>

			<?php } ?>

			<th width="50%" class="table-header">Caption</th>

			<th width="30%" class="table-header">Action</th>

        </tr>

	

	<?php 

		foreach($uploadedimages as $i => $uploadImg)

		{ 

				if($i == 0 || $i%2 == 0){

					$class="image-upload";

				}else{

					$class="image-upload-alternate";

					

				}

		?> 

			<tr>

			<td width="20%" class="<?php echo $class; ?>">

				<?php if($IsImag == 1) {

					

					echo '<img src="'.$this->cdnurl.'/images/uploads/finaoimages/'.$uploadImg->uploadfile_name.'" style="width:50px;height:50px; " />';

				}

				else

				{
					if(isset($uploadImg->video_img) && $uploadImg->video_img != "")
						echo '<img src="'.$uploadImg->video_img.'" style="width:50px;height:50px; " />';
					/*else	
						echo "<div style='height:50px;'>".$uploadImg->video_embedurl."</div>";	*/
				}

				?>

			</td>

			<!-- Adding extra column for Video status -->

			<?php if($IsImag != 1){ ?>

				<td class="<?php echo $class; ?>">

					<?php echo $uploadImg->videostatus; ?>

				</td>

			<?php }?>

			

			<td width="50%"  class="<?php echo $class; ?>" >

				

				<div id="caption-<?php echo $uploadImg->uploaddetail_id;?>" style="word-wrap:break-word;">

				<?php echo $uploadImg->caption; ?>

				</div>

				<span id="divhideeditcaption-<?php echo $uploadImg->uploaddetail_id;?>" style="display:none;">

				<input type="text" maxlength="60" value="<?php echo $uploadImg->caption;?>" id="newcaption-<?php echo $uploadImg->uploaddetail_id;?>" class="txtbox" style="width:95%; float:left;"/>

				</span>

				

			</td>	

			<td width="30%"  class="<?php echo $class; ?>">

				<div id="">

				<ul class="media-action-btns">

				<a  id="showeditcaption-<?php echo $uploadImg->uploaddetail_id;?>" onclick="showeditcaption(<?php echo $uploadImg->uploaddetail_id;?>)" title="Edit" style="float:left; width:35px;"><li class="icon-edit"></li> </a>

				<?php if($IsImag != 1) {	

						if($uploadImg->videostatus != "ready")

			 			{ 

			    ?>

							<a onclick="js:refreshvideo('<?php echo $uploadImg->videoid; ?>','<?php echo $uploadImg->uploaddetail_id; ?>','<?php echo $uploadImg->upload_sourceid; ?>')" title="Refresh" style="float:left; width:35px;"><img src="<?php echo $this->cdnurl."/images/refresh.gif"; ?>"  /></a>					

				<?php 	} else { ?>

							<a onclick="js:deletevideo('<?php echo $uploadImg->videoid; ?>','<?php echo $uploadImg->uploaddetail_id; ?>','<?php echo $uploadImg->upload_sourceid; ?>','<?php echo $userid; ?>','<?php echo $sourcetype; ?>')" title="Delete" style="float:left; width:35px;"><li class="icon-delete"></li></a>	

				<?php   }

					 }else {	?>	

				<a onclick="js:deleteimag('<?php echo $this->cdnurl.'/images/uploads/finaoimages/'.$uploadImg->uploadfile_name ;?>','<?php echo $uploadImg->uploaddetail_id; ?>','<?php echo $uploadImg->upload_sourceid; ?>','<?php echo $userid; ?>','<?php echo $sourcetype; ?>')" title="Delete" style="float:left; width:35px;"><li class="icon-delete"></li></a>

				<?php } ?>

				<span id="hideeditcaption-<?php echo $uploadImg->uploaddetail_id;?>" style="display:none;">

			<!--<input type="text" maxlength="40" value="<?php echo $uploadImg->caption;?>" id="newcaption-<?php echo $uploadImg->uploaddetail_id;?>" class="textbox" style="width:35%; float:left;"/>-->

			<a  id="savefinao-<?php echo $uploadImg->uploaddetail_id;?>" href="javascript:void(0)"   onclick="savecaption(<?php echo $userid;?>,<?php echo $uploadImg->uploaddetail_id;?>)" title="Save" style="float:left; width:35px;"><li class="icon-save"></li></a>

			<a id="closefinao-<?php echo $uploadImg->uploaddetail_id;?>" href="javascript:void(0)" onclick="closecaption(<?php echo $userid;?>,<?php echo $uploadImg->uploaddetail_id;?>)" title="Close" style="float:left; width:35px;"><li class="icon-close"></li></a>

		</span>

        		</ul>

				</div>

			</td>	

			</tr>

	<?php	}

	?>

	</table>

	</div>

	<?php } else { echo '<input type="hidden" id="nodata" value = "data" />'; } ?>



