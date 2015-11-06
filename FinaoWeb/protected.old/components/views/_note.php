<?php
 if($type == 'note'): ?>
<a href="javascript:void(0);">
<img src="<?php echo Yii::app()->baseUrl; ?>/images/note_compose.png" width="25" id="notepopup-<?php echo $i;?>"/>
</a>
			<div id="overlay_form<?php echo $i;?>" class="goodjob_bubble">
            <ul type="none" style="cursor:pointer; color:#343434;" id="noteol" >
			<?php //$result= array('cool finao','You inspire me','Rock on','I dig your finao','Nice job','Way to go','Keep going','proud of you','Fist bump');$k=0;
			foreach($result as $result)
			{$k++;?>
				 <li id="noteol<?php echo $k;?>" onclick = "$('#overlay_form'+<?php echo $i;?>).fadeOut(500); popups(<?php echo $k;?>,<?php echo $sourceid;?>,<?php echo $userid;?>,<?php echo $sourcetype;?>,'<?php echo mysql_escape_string($result->name);?>',<?php echo $result->id;?>);"><?php echo $result['name'];?></li>
		<?php }?>
            </ul>
			<a  id="close<?php echo $i;?>" class="goodjob-bubble-close-btn"><img src="<?php echo Yii::app()->baseUrl; ?>/images/close.png" width="25"></a>
		</div>
   
 <?php else : 
// echo count($notes);
 if(count($notek)!='') : ?> 
 	<img width="25" src="<?php echo Yii::app()->baseUrl; ?>/images/note_notification.png" style="cursor:pointer" onclick="return view_notes('<?php echo $i;?>');">
	
	<div id="light<?php echo $i;?>" class="white_content1"> <a href = "javascript:void(0)" onclick = "document.getElementById('light'+<?php echo $i;?>).style.display='none';document.getElementById('fade').style.display='none'"><img src="<?php echo Yii::app()->baseUrl; ?>/images/close.png" width="30"  style="position:absolute; top:0; right:0;" /></a> 
	<form action="<?php echo Yii::app()->createUrl('finao/deletenote'); ?>" method="post">
    
    
	<table width="100%" id="results<?php echo $i;?>"><tr><td style="height:1px!important;">&nbsp;</td></tr>
	<?php foreach($notek as $notek){ ?>
	<tr><td>
	<span style="font-size:16px;"><?php echo $notek['fname'].' Likes your FINAO !';  ?></span>
	<br /><br />
	<h3 style="font-size:24px; text-align:center; padding-bottom:10px;">
	<a href="<?php echo Yii::app()->createUrl('finao/motivationmesg',array('frndid'=>$notek["tracker_userid"])); ?>" class="orange-link font-25px"><?php echo $notek['fname'];?></a><?php echo ' says, "'.$notek['name'].'"';?></h3>
 	 <div class="htm" id="note_contents<?php echo $i;?>" style="font-size:16px; font-style:normal; color:#000000; border:solid 1px #CCCCCC; float:left; margin-bottom:10px;"></div>
	 <br /><br /> 
	 <input type="hidden" value="<?php echo $notek['note_id'];?>" name="deletenote"  />
	 <input type="submit" value="Block User" name="block_note" class="orange-button bolder" onclick="return check_delete();" />	 
	 <input type="submit" class="orange-button bolder" name="delete_note" value="Delete Note" onclick="return check_delete();"  />		
	 </td></tr>
 <?php }?></table>
 	</form>
 <div id="pageNavPosition<?php echo $i;?>"></div> 
 <script type="text/javascript"><!--
        var pager = new Pager('results', 1,<?php echo $i;?>); 
        pager.init(); 
        pager.showPageNav('pager', 'pageNavPosition'); 
        pager.showPage(1);
		
function check_delete()
{
	if(!confirm('Are you Sure to Delete Note')) return false;
	else return true;
}		
    </script>
 </div> 
 
 <?php endif; endif;?>
 
