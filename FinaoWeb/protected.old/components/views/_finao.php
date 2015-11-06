
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl;?>/css/form-style.css" type="text/css" media="screen" />
 
	<!--<div class="font-14px padding-10pixels orange">Start a FINAO</div>-->
            	
<?php
$form=$this->beginWidget('CActiveForm', array(
'id'=>'user-finao-form',
'htmlOptions' => array('enctype' => 'multipart/form-data','autocomplete'=>'off'),
)); ?>
   <!--<div id="divshowtiles" onclick="finaomsgerr()" class="transperant-layer"></div>-->                
                    	<div class="padding-5pixels">
                        
<?php // $model->finao_msg = "What's Your FINAO?";?>
<?php echo $form->textArea($model,'finao_msg',array('class'=>'finaos-area','maxlength'=>100,'id'=>'finaomesg','style'=>'width:506px; resize:none; height:60px;','value'=>'', 'placeholder'=>"My new FINAO: I will...",'onkeyup' => 'change_va(event);')); ?>         
                        
                       </div>
                        <div class="font-18px orange bolder padding-5pixels">Select Tile<span style="float:right; font-size:12px; color:#FF0000" id="badword"></span></div>
                        <div class="finao-tile-container">
					
<input type="hidden" id="userid" value="<?php echo $userid;?>"/>
<input type="hidden" id="tileid" value="" />
<input type="hidden" id="tilename" value="" />
<input type="hidden" id="groupid" value="<?php echo $isgroup ?>" />
<div id="mesg"></div>	
  <div id="newtile"></div>
  <div id="newusertile"></div>                          
  
  <div id="oldtiles">                           
        <a onclick="addnewtilefinao('<?php echo $userid;?>','<?php echo $isgroup;?>')"> <div class="create-tile">
        Create<br /> New Tile
        </div></a>
                
				  

				<?php foreach($tiles as $i => $eachtile ){ ?>
	                  	<a href="javascript:void(0);">
	                  	<div class="holder smooth" id="div-<?php echo str_replace("'","",str_replace(" ","",$eachtile["tilename"]));?>-<?php echo $eachtile["tile_id"];?>" onclick="clickdiv(this.id,'<?php echo $eachtile["tilename"]; ?>')">
						<?php if(file_exists(Yii::app()->basePath."/../images/tiles/".str_replace(" ","",$eachtile["tileimg"])))
					{ ?>
					  	<img src="<?php echo Yii::app()->baseUrl;?>/images/tiles/<?php echo str_replace(" ","",$eachtile["tileimg"]);
						//echo strtolower($eachtile["lookup_name"]).".jpg";?>"  width="96" height="70" />
						<?php }else{?>
						<img src="<?php echo Yii::app()->baseUrl;?>/images/upload-tileimg-small.png" width="96" height="70"/>
						<?php }?>
	                     <div class="create-finao-text-position" <?php if($eachtile["custom"] !=1){?>style="background:none;" <?php }?> >
                        <div class="text-position"><?php echo $eachtile["tilename"];?></div></div>
					  	</div>
	             		</a>
			<?php } ?>
            
            </div>
                       
                        </div>
                        <div>
                        	<span class="left font-14px">
							
							
						 
         <input type="radio"  name="ispublic" value="1" id="ispublic" />
      Make FINAO Public
       
        <input type="radio" checked="checked" name="ispublic" value="0" id="ispublic_1" />
      Make FINAO Private
                           </span>
                            <span class="right">
                            	<a id="addanotherfinao" onclick="submitfinao(<?php echo $userid;?>,'addanotherfinao','tilefinao')" class="orange-square">Create FINAO</a>
                                <a onclick="closefrommenu(0);" class="orange-square">Cancel</a>
                            </span>
                        </div>
                    
            
<?php $this->endWidget();?>                       
               
       
 




 

<script type="text/javascript" >
function finaomsgerr()
{
	$('#finaomesg').css({'border':'2px solid #F00'});
	$('#finaomesg').attr('value','Enter your FINAO to activate Tiles') 
	
}
$('#finaomesg').focus(function(){
	msg = $(this).val();
	 
	//$('#finaomesg').attr('value' ,'');	 
	 
	$('#finaomesg').css({'border':''});
	
	});
$('#finaomesg').keyup(function()
{
	//alert($(this).val());
});
	
function change_va(event)
{
	var url = '<?php echo Yii::app()->createUrl("finao/badWords"); ?>';
	if(event.keyCode == 32) 
	{
		var valu=$('#finaomesg').val();
		//alert(valu);
		var mySplitResult = valu.split(" ");
		//alert(mySplitResult[mySplitResult.length-1]); 
		var lastWord =  mySplitResult[mySplitResult.length-2];
//		alert(valu.length);
//		alert(valu.length-lastWord.length);
		
		$.post(url, { word : lastWord}, function (data){if(data=='yes'){
			if(valu.length-lastWord.length<=1){$('#finaomesg').val('');}
			else {// alert('f'); //var ss=valu.slice(0,lastword.length);
			$('#finaomesg').val($('#finaomesg').val().slice(0,valu.length-lastWord.length-2)); }
			$('#badword').html('Bad word');
		}});
		$('#badword').html('');	   
	}	
}
</script> 
