<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/form-style.css" type="text/css" media="screen" />
 	<div class="font-14px padding-10pixels orange">Enter a FINAO</div>
 	<?php
		$form=$this->beginWidget('CActiveForm', array(
						'id'=>'user-finao-form',
						'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
						)); ?>
 	<div class="add-finao-strip">
	
		<div class="finao-strip">
			 		
			<!--<div class="fina-strip-right" <?php if($Isprofile != "0") echo 'style="display:none;"'; ?> >-->
			<?php $model->finao_msg = "What's Your FINAO?";?>
			<?php echo $form->textArea($model,'finao_msg',array('class'=>'finao-strip-txtarea','maxlength'=>140,'id'=>'finaomesg','style'=>'width:402px; ','value'=>'')); ?>
			<!--</div>-->
			
        </div>
		
	<div id="divshowtiles" style="display:none;" class="auto-add-finao"> 
		<!--<div class="orange font-20px padding-8pixels">Add FINAO <span class="font-12px" style="color:#343434;">(140 chars only)</span></div>-->
	      <input type="hidden" id="userid" value="<?php echo $userid;?>"/>
		  <div id="mesg"></div>
		
		<!--<p class="padding-5pixels">
			<?php //echo $form->labelEx($model,'finao_msg'); ?>
		</p>-->
	<div class="orange font-20px">Select Tile<span style="padding-top:5px; float:right;" class="font-15px"> 	
		<?php echo $form->checkBox($model,'finao_status_Ispublic',array('id'=>'ispublic'));?>
		Make Finao Public?</span></div>
    	<p class="padding-10pixels">
          	<div id="finaotiles" class="tiles-div" style="width:100%;">
			<input type="hidden" id="tileid" value="" />
			<input type="hidden" id="tilename" value="" />
				<table id="tiledisplay" width="100%" cellpadding="3" cellspacing="10">
				<?php $j = 0;?>
				<?php foreach($tiles as $i => $eachtile ){
					if($j==0){
				?>
				<tr>
					<?php
						}
					?>
              		<td>
	                  	<a href="#">
	                  	<div class="holder smooth" id="div-<?php echo $eachtile->lookup_name;?>-<?php echo $eachtile->lookup_id;?>" onclick="clickdiv(this.id)">
					  	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php echo strtolower($eachtile->lookup_name);?>.png" width="83" />
	                    <div class="text-position"><?php echo $eachtile->lookup_name;?></div>
					  	</div>
	             		</a>
              		</td>
				<?php
					$j=$j+1;
					if($j > 4){
					$j=0;	
				?>
				</tr>
			<?php
				}	
				} ?>
       		</table>
	   </div>
           <div style="clear:left;"></div>
	   </p>
		<!--<p class="padding-5pixels left">-->
		<?php //echo $form->labelEx($model,'finao_status_Ispublic'); ?>
		<!--<span style="padding-top:5px; float:left;" class="font-15px"> -->	
		<?php //echo $form->checkBox($model,'finao_status_Ispublic',array('id'=>'ispublic'));?>
		<!--Make Finao Public?</span>-->
		<!--<span class="right" style="padding-top:10px;" >	-->
			
		<!--</span>	-->
		 <!--</p>-->
           <p style="clear:left; padding:0px;"></p>
	<p class="center left">
			
		<input type="button" class="orange-button right" value="Save" id="addanotherfinao" onclick="submitfinao(<?php echo $userid;?>,'addanotherfinao','tilefinao')"/>
		
	</p>

 </div>
 </div>
 <?php $this->endWidget();?>
 
