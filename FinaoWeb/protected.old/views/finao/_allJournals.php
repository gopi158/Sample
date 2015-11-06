<!--<div class="add-finao">-->
	<a id="allfinaos-journal" onclick="getfinaos(<?php echo $userid;?>, <?php echo $tileid->tile_id;?>)" class="journal-entry">Back </a>
	
<!--</div>-->
<div class="journal-slider">
	<!--<div class="journal-tab-left">-->
	<div id="alljournal-singlefinao-<?php echo $finaoinfo->user_finao_id;?>">
		<?php $this->renderPartial('_singlefinao',array('finaoinfo'=>$finaoinfo,'status'=>$status,'userid'=>$userid,'getimages'=>$getimages,'share'=>$share));?>
		</div>
	<!--</div>-->
	<div class="journal-tab-content">
		<h2 class="fitness-detail-hdline"><?php echo $tileid->tile_name;?> Activity Log</h2>
		<?php //$this->widget('UploadImageVideo',array('uploadTargetpage'=>'Image')); ?>
		<?php if($userid==Yii::app()->session['login']['id']){ if(isset($share) && $share!="share"){?>
				<a id="addnewjournal" onclick="getnewjournal(<?php echo $userid;?>,<?php echo $finaoinfo->user_finao_id;?>)" class="journal-entry">Add Journal</a>
	 			<img src="<?php echo Yii::app()->baseUrl;?>/images/add.png" class="left" />
	<?php } }?>
		<?php
		foreach($journals as $eachjournal)
		{?>
			<div class="log-detail">
			<?php if($userid==Yii::app()->session['login']['id']){ if(isset($share) && $share!="share"){?>
			<a href="#" onclick="showeditjournal(<?php echo $eachjournal->finao_journal_id;?>)" >Edit</a>
			<?php } }?>
			<div id="journalmesg-<?php echo $eachjournal->finao_journal_id;?>"><?php echo $eachjournal->finao_journal;?></div>
			<p id="editjournal-<?php echo $eachjournal->finao_journal_id;?>" style="display:none;">
			<input type="text" maxlength="140" value="<?php echo $eachjournal->finao_journal;?>" id="newjournalmesg-<?php echo $eachjournal->finao_journal_id;?>"/>
		<a  id="savejournal-<?php echo $eachjournal->finao_journal_id;?>" href="javascript:void(0)"   onclick="savejournalmesg(<?php echo $userid;?>,<?php echo $eachjournal->finao_journal_id;?>)" >save</a>
		<a id="closejournal-<?php echo $eachjournal->finao_journal_id;?>" href="javascript:void(0)" onclick="closejournal(<?php echo $userid;?>,<?php echo $eachjournal->finao_journal_id;?>)">close</a>
			</p>
			</div>
	<?php }
		?>
	</div>
</div>
