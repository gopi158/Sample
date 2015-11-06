<a id="allfinaos-newjournal" onclick="getfinaos(<?php echo $userid;?>,<?php echo $tileid->tile_id;?>)" class="journal-entry" > Back </a>
<div class="journal-slider">
<!--<div class="journal-tab-left" style="margin-top:30px;" >-->
<div id="newjournal-singlefinao-<?php echo $finaoinfo->user_finao_id;?>">
<?php $this->renderPartial('_singlefinao',array('finaoinfo'=>$finaoinfo,'status'=>$status,'userid'=>$userid,'getimages'=>$getimages));?>
</div>
<!--</div>-->
<div id="rightjournal" class="journal-tab-content">
<h1 class="orange font-18px">Add Journal</h1>
<div id="journalmesgs">
<?php /*foreach($journalinfo as $eachjournal){?>
<?php echo $eachjournal->finao_journal;?>
<?php }*/?>
</div>
<div id="journalform">
<div id="errormesg"></div>
<?php
$form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-journal-form',
		//'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
		)); ?>

<p class="left padding-10pixels">
	<?php //echo $form->labelEx($newjournal,'finao_journal'); ?>
	<?php echo $form->textArea($newjournal,'finao_journal',array('class'=>'finao-desc','id'=>'journaltext','onfocus'=>'remove()')); ?>
</p>
	<?php echo $form->hiddenField($newjournal,'finao_id',array('id'=>'finao_id','value'=>$finaoinfo->user_finao_id));
	?>
	<p class="left padding-10pixels"><?php //echo $form->textField($newjournal,'journal_startdate',array('id'=>'startdate'));?>
	<input type="checkbox" id="journalstatus" /><span>Make Journal Public</span>
	</p>
	<p class="left padding-10pixels"><input type="button" class="orange-button" value="Submit" id="savejournal" onclick="submitjournal(<?php echo $userid;?>)"/>
<input type="button" class="orange-button" value="Cancel" id="cancelnewjournal" onclick="canceljournal(<?php echo $finaoinfo->user_finao_id;?>,<?php echo $userid;?>)"/></p>
<?php /*echo CHtml::ajaxSubmitButton('SaveJournal',          
							array('/finao/addJournal'),
							array(
								'type'=>'POST',
								'error'=>'js:function(){
											alert("error");
											}',
								'beforeSend'=>'js:function(){
												alert("beforeSend"); 
												}',
								'complete'=>'js:function(){
												alert("complete");
												}',
								'success'=>'js:function(data){
												alert("success, data from server: "+data);
												  if(data=="saved")
												{
													$("#journalform").hide();
													getalljournals(<?php echo $finaoinfo->user_finao_id;?>);
												}
												else
												{
													$("#errormesg").html(data);
												}  
												}',
		       					//'update'=>'#data', 
								),array('id'=>"savejournal-".$finaoinfo->user_finao_id));*/
	//echo CHtml::ajaxLink('savejournal', array('finao/addJournal','userid'=> $finaoinfo->userid), array('update'=>'#rightjournal'),array('id'=>"savejournal-".$finaoinfo->user_finao_id))."<br/>";
?>
<?php /*echo CHtml::ajaxSubmitButton('Getupdatedjournals',          
							array('/finao/allJournals/finaoid/'.$finaoinfo->user_finao_id),
							array(
								'type'=>'POST',
								'error'=>'js:function(){
											alert("error");
											}',
								'beforeSend'=>'js:function(){
												alert("beforeSend"); 
												}',
								'complete'=>'js:function(){
												alert("complete");
												}',
								'success'=>'js:function(data){
												alert("success, data from server: "+data);
												  $("#journalmesgs").html(data);
												}',
		       					//'update'=>'#data', 
								),array('id'=>"getalljournals-".$finaoinfo->user_finao_id));*/?>
<?php $this->endWidget();
?>
</div>
</div>
 </div>
<script type="text/javascript">
function getalljournals(id,userid)
{
	//alert(id);
	//$("#getalljournals-"+id).trigger("click");
	var url='<?php echo Yii::app()->createUrl("/finao/allJournals"); ?>';
 	$.post(url, { finaoid : id, userid :  userid},
   		function(data){
   			//alert(data);
			if(data)
			{
				//$("#changediv").html(data);
				$("#finaoform").hide();
				$("#journaldiv").html(data);
			}
			
     });
}
function submitjournal(id)
{
	var userid = id;
	var text = document.getElementById('journaltext').value;
	var ispublic = document.getElementById('journalstatus');
		if (ispublic.checked){
	       ispublic = 1;
	    }else{
	       ispublic = 0;
	    }
	var finaoid = document.getElementById('finao_id').value;
	if(text.length >= 1)
	{
		var url='<?php echo Yii::app()->createUrl("/finao/addJournal"); ?>';
	 	$.post(url, { text : text , finaoid : finaoid, userid : userid},
	   		function(data){
	   			//alert(data);
				if(data == "saved")
				{
					$("#journalform").hide();
					getalljournals(finaoid,userid);
				}
				else
				{
					$("#errormesg").html(data);
				}
	    
	     });
	}
	else
	{
		document.getElementById('journaltext').className = "finao-desc-error";
	}
}
function canceljournal(id,userid)
{
	getalljournals(id,userid)
	/*alert(id);
	var url='<?php echo Yii::app()->createUrl("/finao/default"); ?>';
 	$.post(url, { },
   		function(data){
   			//alert(data);
			 $("#totalpage").html(data);   
     });*/
}
function remove()
{
	document.getElementById('journaltext').className = "finao-desc";
}
</script>