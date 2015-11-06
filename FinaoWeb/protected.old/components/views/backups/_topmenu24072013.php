
	<span class="person-FINAO">
		<a href="javascript:void(0)" onclick="closefrommenu('main')"><?php if(isset($userinfo) && !empty($userinfo->fname)){?><?php echo ucfirst($userinfo->fname)."'s FINAO"; } ?></a>
	</span>
    <ul id="ultopmenu">
		<?php if(!empty($tilescount)){?>
    		<!--<a href="#" class="active-category" onclick="getalltiles(<?php echo $userinfo->userid;?>,'<?php echo $isshare;?>')">-->
    		<a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,1,'tiles','tilescount')" href="javascript:void(0)" rel="tiles">
				<li class="first-item-border" id="tilescount">TILES <?php echo "(".$tilescount.")";?></li>
			</a>
		<?php }else{?>
			<li>TILES <?php echo "(".$tilescount.")";?></li>
		<?php }?>
		
		<?php if(!empty($finaocount)){?>
    		<a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,1,'finaos','finaoscount');" href="javascript:void(0)" rel="finaos">
				<li id="finaoscount">FINAOs <?php echo "(".$finaocount.")";?></li>
			</a>
		<?php }else{?>
			<li>FINAOs <?php echo "(".$finaocount.")";?></li>
		<?php }?>
		<?php if(!empty($imgcount)){?>
    		<a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,1,'images','imagescount');" href="javascript:void(0)" rel="photos">
				<li id="imagescount">PHOTOS <?php echo "(".$imgcount.")";?></li>
			</a>
		<?php }else{?>
			<li>PHOTOS <?php echo "(".$imgcount.")";?></li>
		<?php }?>
		<?php if(!empty($videocount)){?>
    		<a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,1,'videos','videoscount');" href="javascript:void(0)" rel="videos">
				<li id="videoscount">VIDEOS <?php echo "(".$videocount.")";?></li>
			</a>
		<?php }else{?>
			<li>VIDEOS <?php echo "(".$videocount.")";?></li>
		<?php }?>
        
		<?php if(!empty($followcnt)){?>
    		<a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,1,'follow','followcount');" href="javascript:void(0)" rel="following">
				<li id="followcount">FOLLOWING <?php echo "(".$followcnt.")";?></li>
			</a>
		<?php }else{?>
			<li>FOLLOWING <?php echo "(".$followcnt.")";?></li>
		<?php }?>
        <!--<a href="#" class=""><li>GROUPS </li></a>-->
        <!--<a href="#" class=""><li>SPONSORS </li></a>-->
    </ul>




