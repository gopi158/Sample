
<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'upload-form',
				'enableClientValidation'=>true,
				//'multiple'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>

<div class="update-finao-box">
                	<div class="update-finao-area">
                    	<textarea onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" placeholder="Update this FINAO" id="getjournalmsg" name="journalmsg" class="update-finao-textarea"><?php if(!empty($journalmsg)){ echo $journalmsg;}?></textarea>
                    </div>
                    <div class="upload-finao-media">
                        <span style="margin-right:5px; margin-top:0px;" class="left font-14px">Add Media:</span>
                        <ul class="status-buttons">
                            <a title="upload images" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>,'finao','Image')"><li class="finao-upload-image-active"></li></a>
                           <?php /*?> <a title="upload videos" href="javascript:void(0);" onclick=" addimages(<?php echo $userid;?>,<?php echo $eachfinao->user_finao_id;?>,'finao','Video');"><?php */?><li class="finao-upload-video-disable"></li><!--</a>-->
                        </ul>
                        
                        
                    </div>
                    <div class="upload-video-box">
                        <div class="upload-image" <?php if($style != "") { echo $style; } ?> >
			
        	

			

			<script type="text/javascript">

				$('#image').live('change', function(){  
									var ext = this.value.split('.').pop().toLowerCase();
									if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
										alert('Invalid Extension!');
										$("#hdnimgchange").val(""); 
										this.value = "";
									}else
										$("#hdnimgchange").val(this.value); 
										$("#menuselected").val($(".active-category").attr("rel"));
									});

			</script>

			 

			<div class="orange font-15px padding-5pixels">Upload <?php //echo ucfirst($sourcetype); ?> Image</div>

			 <span id="errormsgv" style="color:red"></span>
            <div style="width:100%; float:left;" >
		
           	
			<input type="file" onchange="readURL(this);" name="image[]" value="" id="image" class="upload-btn" style="width:190px;">
			<?php /*$this->widget('CMultiFileUpload', array(

			                'name' => 'image',

							'accept' => 'jpeg|jpg|gif|png', // useful for verifying files

			                'duplicate' => 'Duplicate file!', // useful, i think

			                'denied' => 'Invalid file type', // useful, i think

			    			'remove' => Yii::t('ui', '<div><img  title="Delete" style="float:right;padding-right:5px;padding-left:5px;" src="' . Yii::app()->request->baseUrl . '/images/delete.png" /></div>'),

							'htmlOptions'=>array('class'=>'upload-btn')

			                       ));*/ ?>

			<!--</div>

			<div style="clear:left"></div>

			<div class="left padding-20pixels">-->					  

			<?php

				echo $form->textField($newupload,'caption',array('value'=>'','placeholder'=>'Enter Caption','onclick'=>'if(placeholder == "Enter Caption") placeholder = ""','onblur'=>'if(!placeholder) placeholder="Enter Caption"','class'=>'txtbox left','style'=>'width:170px;','maxlength'=>60, 'id'=>'description')) 

			?>		
			<input type="hidden" id="hdnimgchange" value="" />
			<?php 
			echo $form->hiddenField($newupload,'uploadtype',array('value'=>$typeid->lookup_id)); 
			 ?>
			<?php echo $form->hiddenField($newupload,'upload_sourcetype',array('value'=>$sourcetypeid->lookup_id));?>
			 <?php 
			echo $form->hiddenField($newupload,'upload_sourceid',array('value'=>($sourcetype != 'journal') ? $finaoinfo->user_finao_id : $journalid)); 
			 ?>
			<?php 
			echo $form->hiddenField($newupload,'uploadedby',array('value'=>$finaoinfo->userid)); 
			 ?>
			 <?php 
			echo $form->hiddenField($newupload,'updatedby',array('value'=>$finaoinfo->userid)); 
			 ?>
			<?php 
			echo $form->hiddenField($newupload,'uploadsourcetype',array('value'=>$sourcetype)); 
			 
			 ?>
             <?php 
			echo $form->hiddenField($newupload,'groupid',array('value'=>$groupid)); 
			  
			 ?> 
              <?php 
			echo $form->hiddenField($newupload,'userid',array('value'=>Yii::app()->session['login']['id'])); 
			  
			 ?>  

			 

					<?php echo CHtml::submitButton('Update FINAO',array('id'=>'newfinaoimage','class'=>'orange-button','onclick'=>'if($("#hdnimgchange").val() == ""){ if(validatesubmit("hdnimgchange","errormsgv","Please select a file to Upload","","") == "1") {return false;} };')); ?>
                    
                    <?php echo CHtml::Button('Cancel',array('class'=>'orange-button','onclick'=>'$("#hideimgvideo").show();$("#imgvidupload").hide();'
					)); ?>
                
			</div>				  

			
<div style="width:100%; float:left;" >	<img alt="" id="test" src="#" width="60" height="60" style="display:none;"   /></div>
			<div style="clear:left"></div>	

			<?php $this->endWidget(); ?>

			

        </div>
                    </div>
</div>