
		<div class="journal-navigation">
				<?php
					$noofpagjr = 0;
					$prevjr = 0;
					$nextjr = 0;
					
					if(isset($jornavigation) && $jornavigation != "")
					{
						$noofpagjr = $jornavigation['noofpage'];
						$prevjr = $jornavigation['prev'];
						$nextjr = $jornavigation['next'];
					}
					
				?>
				<?php if($noofpagjr>1){
						/*if($prevjr <= $noofpagjr){*/?>
						<a onclick="viewjournal(<?php echo $prevjr; ?>,<?php echo $finaoid; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1);" class="journal-navigation-left" href="javascript:void(0)" >&nbsp;</a>												<?php //}?>
				  <?php // if($nextImg<=$noofpagImgVid){?>
		                <a onclick="viewjournal(<?php echo $nextjr; ?>,<?php echo $finaoid; ?>,<?php echo $userid; ?>,<?php echo $completed; ?>,1);" class="journal-navigation-right" href="javascript:void(0)" >&nbsp;</a>
				<?php //}
					 }?>							
		</div>
		<?php foreach($journals as $eachjournal) {  
					 $jourmesg = ""; $maxlen = 150;
						  $jourmesg = ucfirst($eachjournal->finao_journal);
						  if(strlen($jourmesg) > $maxlen)
						  {
						  	$offset = ($maxlen - 11) - strlen($jourmesg);
							$jourmesg = substr($jourmesg, 0, strrpos($jourmesg, ' ', $offset)) . ' ..[<a class="orange-link font-12px" onclick="js:hideshow(\'showjoumsg\',\'show\'); hideshow(\'journalmesg-'.$eachjournal->finao_journal_id.'\',\'hide\'); " href="javascript:void(0);"> Read more </a>]';
						  }	
			?>
			<div class="journal-display"  >
				<div id="journalmesg-<?php echo $eachjournal->finao_journal_id;?>">
				<p class="font-13px">
				<?php echo date("m/j/Y  \a\&#116 g:i A", strtotime($eachjournal->updateddate));?>
				</p> 
				<p class="font-14px"> 
					
					<?php echo $jourmesg;//ucfirst($eachjournal->finao_journal);?>
				</p>
				</div>
				
				<div id="showjoumsg"  style="display:none;" >
					<p class="font-13px">
						<?php echo date("m/j/Y  \a\&#116 g:i A", strtotime($eachjournal->updateddate));?>
					</p> 
					<p class="font-14px">
						<?php echo ucfirst($eachjournal->finao_journal); 
							  echo ' ..[<a class="orange-link font-12px" onclick="js:hideshow(\'journalmesg-'.$eachjournal->finao_journal_id.'\',\'show\'); hideshow(\'showjoumsg\',\'hide\'); " href="javascript:void(0);"> Read less </a>]';  	
						?>
					</p>
				</div>
				
				<div id="editjournal-<?php echo $eachjournal->finao_journal_id;?>" style="display:none;">
				<p>
					<textarea class="finaos-area" id="newjournalmesg-<?php echo $eachjournal->finao_journal_id;?>" style="width: 98%; float: left;"  onkeydown="closefunction(this,event,'journal',<?php echo $userid;?>,<?php echo $eachjournal->finao_journal_id;?>)"><?php echo ucfirst($eachjournal->finao_journal);?></textarea>
		
				</p>
				<p>
		
				<a class="orange-link font-13px" id="savejournal-<?php echo $eachjournal->finao_journal_id;?>"  onclick=" if(validateSubmitJournal('savejournal-<?php echo $eachjournal->finao_journal_id;?>') == 'false') return false; savejournalmesg(<?php echo $userid;?>,<?php echo $eachjournal->finao_journal_id;?>)" href="javascript:void(0)"><img style="width:20px;" src="<?php echo Yii::app()->baseUrl; ?>/images/icon-save.png"></a>
		
				<a class="orange-link font-13px" id="closejournal-<?php echo $eachjournal->finao_journal_id;?>"  onclick="closejournal(<?php echo $userid;?>,<?php echo $eachjournal->finao_journal_id;?>)" href="javascript:void(0)"><img style="width:20px;" src="<?php echo Yii::app()->baseUrl; ?>/images/icon-close.png"></a>
		
				</p>
		
				</div>
			</div>
		
		<?php } ?>	
		<div class="journal-mgmt-icons"> 
				
				<a  <?php if($userid==Yii::app()->session['login']['id'] && $completed != "completed") {
							if(!isset($imageexists) || $imageexists == "noimage"){
						?> 
						onclick="addimages(<?php echo $userid;?>,<?php echo $finaoid;?>,'journal','Image',<?php echo $journalid;?>)" title="upload photos" <?php }else{ ?> onclick="getDetails('Image',<?php echo $userid;?>,<?php echo $journalid; ?>,'journalpage')" title="view photos" <?php } 
						}elseif($userid!=Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){ 
							if(!isset($imageexists) || $imageexists == "noimage"){ ?> 
						title="no photos" <?php }  
					}else{?> 
						onclick="getDetails('Image',<?php echo $userid;?>,<?php echo $journalid; ?>,'journalpage')" title="view photos"			<?php }?> href="javascript:void(0)" ><img src="<?php echo Yii::app()->baseUrl; ?>/images/journal-icons/icon-photo.png" />
				</a> 
					<!--<?php echo "hi"; echo $completed; ?>-->
		 		<a <?php if($userid==Yii::app()->session['login']['id'] && $completed != "completed")  {
							if(!isset($videoexists) || $videoexists == "novideo"){
						?> 
					onclick="addimages(<?php echo $userid;?>,<?php echo $finaoid; ?>,'journal','Video',<?php echo $journalid; ?>)" title="upload videos" <?php }else{ ?> onclick="getDetails('Video',<?php echo $userid;?>,<?php echo $finaoid;?>,'journalpage')" title="view videos"  <?php } 
					}elseif($userid!=Yii::app()->session['login']['id'] || $share=="share" || $completed == "completed"){ 
						if(!isset($videoexists) || $videoexists == "novideo"){?> 
							tiltle="no videos" <?php }else{?> onclick="getDetails('Video',<?php echo $userid;?>,<?php echo $finaoid;?>,'journalpage')" title="view videos"<?php } }?> href="javascript:void(0)"><img src="<?php echo Yii::app()->baseUrl; ?>/images/journal-icons/icon-video.png" /></a>
							 
				<?php if($userid==Yii::app()->session['login']['id'] && $completed != "completed"){ ?>	
				<a onclick="hideshow('showjoumsg','hide');showeditjournal(<?php echo $journalid; ?>)" href="javascript:void(0)"><img src="<?php echo Yii::app()->baseUrl; ?>/images/journal-icons/icon-edit.png" title="Edit Journal" /></a> 
				<a onclick="hideshow('showjoumsg','hide');deletefj('journal',<?php echo $userid;?>,<?php echo $journalid;?>,<?php echo $finaoid; ?>)" href="javascript:void(0)">
					<img src="<?php echo Yii::app()->baseUrl; ?>/images/journal-icons/icon-delete.png" title="Delete Journal" />
				</a>
				<?php } ?>
				
		</div>


