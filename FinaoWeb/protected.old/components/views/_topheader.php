<div class="fixed-image-slider" id="tiles-strip">
	<span class="person-FINAO">
		<?php if(isset($userinfo) && !empty($userinfo->fname)){?><?php echo ucfirst($userinfo->fname); } ?>
	</span>
    <ul>
		<?php if(!empty($tilescount)){?>
    		<a href="#" class="" onclick="getalltiles()">
				<li id="tilescount">TILES <?php echo "(".$tilescount.")";?></li>
			</a>
		<?php }else{?>
			<li>TILES <?php echo "(".$tilescount.")";?></li>
		<?php }?>
		
		<?php if(!empty($finaocount)){?>
    		<a href="#" class="" onclick="getallfinaos()">
				<li id="finaoscount">FINAOs <?php echo "(".$finaocount.")";?></li>
			</a>
		<?php }else{?>
			<li>FINAOs <?php echo "(".$finaocount.")";?></li>
		<?php }?>
		<?php if(!empty($imgcount)){?>
    		<a href="#" class="" onclick="getallimages()">
				<li id="imagescount">PHOTOS <?php echo "(".$imgcount.")";?></li>
			</a>
		<?php }else{?>
			<li>PHOTOS <?php echo "(".$imgcount.")";?></li>
		<?php }?>
		<?php if(!empty($videocount)){?>
    		<a href="#" class="" onclick="getallfinaos()">
				<li id="videoscount">VIDEOS <?php echo "(".$videocount.")";?></li>
			</a>
		<?php }else{?>
			<li>VIDEOS <?php echo "(".$videocount.")";?></li>
		<?php }?>
        <a href="#" class=""><li>GROUPS (6)</li></a>
        <a href="#" class=""><li>FOLLOWING (86)</li></a>
        <a href="#" class=""><li style="border-right:none!important;">SPONSORS (6)</li></a>
    </ul>
</div>



