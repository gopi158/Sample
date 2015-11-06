
<?php 
	$form = $this->beginWidget(
    	'CActiveForm',
				    array(
				        'id' => 'upload-form',
						'enableAjaxValidation' => false,
				        'htmlOptions' => array('enctype' => 'multipart/form-data'),
				    ));
					
?>
<input type="hidden" id="datadisplay" name="datadisplay" value="<?php echo $displaydata; ?>" />
         <?php echo CHtml::activeHiddenField($editprof, 'userid',array('value'=>$myprofile[0]->userid)); ?>
<div id="profile">
         <?php $this->widget('UserDetails',array('myprofile'=>$myprofile
											,'editprof'=>$editprof
											//,'myaddress'=>$myaddress
											,'page'=>'myprofile'
											,'userid'=>$userid
											)); ?>
		<div>
		<div  style="margin-bottom:10px;">
			<div id="disInt">
			<!-- onclick="js: editdata('disInt','editInt',true); $('#aeditSInt').show(); return false;" -->
			<a href="#" class="orange-link" style="font-size:16px; margin-bottom:10px;"  ><b>Add Interests</b></a>&nbsp;<a href="#" class="addspeech" title="Click on right panel to select interests. Double click on any interest to select or deselect."><img src="<?php echo Yii::app()->baseUrl;?>/images/icon-help.png" /></a>
			<?php if($userid==Yii::app()->session['login']['id']){?>
			<a href="#"  style="font-size:14px; margin-bottom:10px; margin-left:297px;" class="blue-link" onclick="js: uploadDetails('changeInterest',<?php echo $myprofile[0]->userid; ?>); return false;" >Save</a>
			<?php }?>			
			</div>
		</div>
			
			<div id="editInt" >
				
				<!--<a href="#"  style="font-size:14px; margin-bottom:10px;" class="blue-link" onclick="js: editdata('disInt','editInt',false); return false;" >Cancel</a>-->
			<?php
					$allinterestnew = array();
						 /* $j=0;
						  foreach($allinterest as $interests)
						  {
						  		foreach($interests["childint"] as $childintdetails) {
									$allinterestnew[$childintdetails->pv_lookup_id] = $childintdetails->lookup_name;
									
								}
						  }*/
						  foreach($allinterest as $interests)
						  {
						  		$allinterestnew[$interests->pv_lookup_id] = $interests->lookup_name;
						  }

				$this->widget('application.widget.emultiselect.EMultiSelect',
      								array('sortable'=>false/true, 'searchable'=>false/true)
				); 
				
				echo $form->dropDownList($editprof,'selectedInterest',$allinterestnew,array('multiple'=>'multiple',
																				  'key'=>'selectedInterest', 	
										          								  'class'=>'multiselect',
																				  'id'=>'dpselectInt',
																				  'options'=>$modelUserInterest)
										);
				
				?>
			</div>
			<!--<div style="margin-top:10px; margin-left:375px;">
			<input type="button" value="Save"   id="aeditSInt" class="blue-button" onclick="js: uploadDetails('changeInterest',<?php echo $myprofile[0]->userid; ?>); return false;" ><?php //$(this).hide();?>
			</div>	-->
				
		</div>
    </div>
<?php	$this->endWidget(); ?>