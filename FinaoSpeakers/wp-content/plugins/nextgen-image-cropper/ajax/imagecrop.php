<?php
require_once '../config.php';
require_once(nggGallery::graphic_library());

// Pull the image from the NextGen DB
$pictureID = $_REQUEST['pictureID'];
$pic = nggdb::find_image($pictureID);

// If Processing the Crop
if(!empty($_POST['ngg_crop'])) {
	$image = new ngg_Thumbnail($pic->imagePath, TRUE);
	
	// Create backup
	@copy($image->fileName, $image->fileName . '_backup');
	
	$image->crop($_POST['ngg_crop']['x1'], $_POST['ngg_crop']['y1'], $_POST['ngg_crop']['cropwidth'], $_POST['ngg_crop']['cropheight']);
	$image->save($image->fileName);
	
	// Save the new MetaData
	nggdb::update_image_meta($pictureID, array(
											'width'		=>	$_POST['ngg_crop']['cropwidth'],
											'height'	=>	$_POST['ngg_crop']['cropheight']));
		
	
	exit;
}

echo '<div class="ngg_crop">';
	echo '<form class="ngg_crop_form" action="' . $nggcropobj->plugin_path . 'ajax/imagecrop.php" method="post">';
		echo '<input type="hidden" id="pictureID" name="pictureID" value="' . $pictureID . '">';
		echo '<input type="hidden" id="cropprocess" name="ngg_crop[cropprocess]" value="1">';
		echo '<input type="hidden" id="x1" name="ngg_crop[x1]" />';
		echo '<input type="hidden" id="y1" name="ngg_crop[y1]" />';
		echo '<input type="hidden" id="x2" name="ngg_crop[x2]" />';
		echo '<input type="hidden" id="y2" name="ngg_crop[y2]" />';
		
		echo '<table cellspacing="3">';
			echo '<tr>';
				echo '<td class="ngg_crop_image">';
					echo '<img src="' . $pic->imageURL . '?' . rand(0,10000) . '" id="cropthis" style="display: none">';
				echo '</td>';
				echo '<td class="ngg_crop_data" style="vertical-align: top; padding: 5px">';
					echo '<div class="postbox metabox-holder">';
						echo '<h3>';
							echo '<span>Select the area to crop</span>';
						echo '</h3>';
						echo '<br>';
						echo '<table cellspacing="3">';
							echo '<tbody>';
								echo '<tr>';
									echo '<td colspan="2">';
										echo '<input type="checkbox" name="ngg_crop[optimizeforhome]" id="usepreselected" value="1" checked="checked">&nbsp;<label for="usepreselected">Use pre-selected size</label>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td colspan="2">';
										echo '<input type="checkbox" name="ngg_crop[lockaspect]" id="lockaspect" value="1" checked="checked" disabled="disabled">&nbsp;<label for="lockaspect">Lock Aspect Ratio</label>';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<th>Selected Width</th>';
									echo '<td>';
										echo '<input type="text" size="4" id="cropwidth" name="ngg_crop[cropwidth]" readonly="readonly" style="background-color: #F2F2F2" />px';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<th>Selected Height</th>';
									echo '<td>';
										echo '<input type="text" size="4" id="cropheight" name="ngg_crop[cropheight]" readonly="readonly" style="background-color: #F2F2F2" />px';
									echo '</td>';
								echo '</tr>';
								echo '<tr>';
									echo '<td colspan="2">';
										echo '<input type="submit" name="ngg_crop[cropsubmit]" value="Save">';
									echo '</td>';
								echo '</tr>';
							echo '</tbody>';
						echo '</table>';
					echo '</div>';
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	echo '</form>';
echo '</div>';