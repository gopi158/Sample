
 <?php 
 if(isset($_REQUEST['share']))
		{
			$share = "share";
		}
		else
		{
			$share = "no";
		}
 ?>
	
    <?php if(empty($isgroup)){?> 
       
       
        <span class="person-FINAO">
        <a href="javascript:void(0)" onclick="closefrommenu('main')"><?php if(isset($userinfo) && !empty($userinfo->fname)){?><?php echo ucfirst($userinfo->fname)."'s FINAO"; } ?></a>
	 <?php if(isset($_GET['tile'])) echo '<span class="hbcucou" ></span>';?> 	
		
        </span>

        <ul id="ultopmenu">
        
        
        <?php if(!empty($finaocount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'finaos','finaoscount');" href="javascript:void(0)" rel="finaos">
            <li id="finaoscount" class="first-item-border">FINAOs <?php echo "(".$finaocount.")";?></li>
        </a>
        <?php }else{?>
        
        <?php if($userid != Yii::app()->session['login']['id']){?>		   
           <li class="first-item-border">FINAOs <?php  echo "(".$finaocount.")";?></li>              
        <?php }else if((isset($share) && $share=="share")){?> 
                 <li class="first-item-border">FINAOs <?php echo "(".$finaocount.")";?></li>	
        <?php } else {?>
                <a class="" onclick="createfinao(<?php echo  Yii::app()->session['login']['id']?>,'0');" href="javascript:void(0)" rel="finaos">
                     <li class="first-item-border">Create FINAO <?php //echo "(".$finaocount.")";?></li>
              </a>		   		 
        <?php }?>            
        <?php }?> 
        
        
        <?php if(!empty($tilescount)){?>
        <!--<a href="#" class="active-category" onclick="getalltiles(<?php echo $userinfo->userid;?>,'<?php echo $isshare;?>')">-->
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'tiles','tilescount')" href="javascript:void(0)" rel="tiles">
            <li id="tilescount">TILES <?php echo "(".$tilescount.")";?></li>
        </a>
        <?php }else{?>
        <li>TILES <?php echo "(".$tilescount.")";?></li>
        <?php }?>
        
        <?php if(!empty($imgcount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'images','imagescount');" href="javascript:void(0)" rel="photos">
            <li id="imagescount">PHOTOS <?php echo "(".$imgcount.")";?></li>
        </a>
        <?php }else{?>
        <li>PHOTOS <?php echo "(".$imgcount.")";?></li>
        <?php }?>
        <?php if(!empty($videocount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'videos','videoscount');" href="javascript:void(0)" rel="videos">
            <li id="videoscount">VIDEOS <?php echo "(".$videocount.")";?></li>
        </a>
        <?php }else{?>
        <li>VIDEOS <?php echo "(".$videocount.")";?></li>
        <?php }?>
        
        <?php if(!empty($followcnt)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'follow','followcount');" href="javascript:void(0)" rel="following">
            <li id="followcount">FOLLOWING <?php echo "(".$followcnt.")";?></li>
        </a>
        <?php }else{?>
        <li>FOLLOWING <?php echo "(".$followcnt.")";?></li>
        <?php }?>
        
        <?php if(!empty($groupcnt)){?> 
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,'',1,'groups','groupcount');" href="javascript:void(0)" rel="Group">
            <li id="groupcount">GROUPS <?php echo "(".$groupcnt.")";?></li>
        </a>
        <?php }else{?>
        
        <?php if($userid == Yii::app()->session['login']['id']){?> 
		 <a class="" onclick="creategroup(0,0);"  href="javascript:void(0)" rel="Group">
        <li id="groupcount">Create Group</li>
        </a>
		<?php }else{?> 
		
		<li class="menu-grey-link">GROUPS <?php echo "(".$groupcnt.")";?> </li>
		
		<?php } ?>
        
        <?php } ?>
        
        
        <li class="menu-grey-link">SPONSORS </li>
        </ul>

	<?php }else{?> 
	
	   <span class="person-FINAO">
        <a href="javascript:void(0)" onclick="closefrommenu('main')">
		<?php if(isset($groupinfo) && !empty($groupinfo)){?>
		<?php echo ucfirst($groupinfo->group_name)."'s FINAO"; } ?></a>
		
	<!-- updated by ramesh    --->

	<span class="right">  <!-- Monitored | <span class="orange">Group Member</span> | -->    <?php if($userid != Yii::app()->session['login']['id']) { ?><a class="orange-link font-16px" href="javascript:void(0);" id="gropfollowing" onclick="follow_group(<?php echo $userid;?>,<?php echo $groupinfo->group_id;?>);"><?php echo $results_group;?></a> <?php } else { ?> <span ><a href="javascript:void(0)" onclick="return creategroup('<?php echo $_GET['groupid'];?>','1');">Edit Group</a>  </span>| <a href="javascript:void(0)" onclick="return delete_group(<?php echo $_GET['groupid'];?>);"> Delete Group </a> <?php }?></span>
	
       </span>
        
        
        <ul id="ultopmenu" style="float:right; width:688px;">
        
        
        <?php if(!empty($finaocount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,<?php echo $isgroup?>,1,'finaos','finaoscount');" href="javascript:void(0)" rel="finaos">
            <li id="finaoscount" class="first-item-border">FINAOs <?php echo "(".$finaocount.")";?></li>
        </a>
        <?php }else{?>
        
        <?php if($userid != Yii::app()->session['login']['id']){?>		   
           <li class="first-item-border">FINAOs <?php  echo "(".$finaocount.")";?></li>              
        <?php }else if((isset($share) && $share=="share")){?> 
                 <li class="first-item-border">FINAOs <?php echo "(".$finaocount.")";?></li>	
        <?php } else {?>
                <a class="" onclick="createfinao(<?php echo  Yii::app()->session['login']['id']?>,<?=$isgroup?>);" href="javascript:void(0)" rel="finaos">
                     <li class="first-item-border">Create FINAO <?php //echo "(".$finaocount.")";?></li>
              </a>		   		 
        <?php }?>            
        <?php }?> 
        
        
        <?php if(!empty($tilescount)){?>
        <!--<a href="#" class="active-category" onclick="getalltiles(<?php echo $userinfo->userid;?>,'<?php echo $isshare;?>')">-->
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,<?php echo $isgroup?>,1,'tiles','tilescount')" href="javascript:void(0)" rel="tiles">
            <li id="tilescount">TILES <?php echo "(".$tilescount.")";?></li>
        </a>
        <?php }else{?>
        <li>TILES <?php echo "(".$tilescount.")";?></li>
        <?php }?>
        
        <?php if(!empty($imgcount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,<?php echo $isgroup?>,1,'images','imagescount');" href="javascript:void(0)" rel="photos">
            <li id="imagescount">PHOTOS <?php echo "(".$imgcount.")";?></li>
        </a>
        <?php }else{?>
        <li>PHOTOS <?php echo "(".$imgcount.")";?></li>
        <?php }?>
        <?php if(!empty($videocount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,<?php echo $isgroup?>,1,'videos','videoscount');" href="javascript:void(0)" rel="videos">
            <li id="videoscount">VIDEOS <?php echo "(".$videocount.")";?></li>
        </a>
        <?php }else{?>
        <li>VIDEOS <?php echo "(".$videocount.")";?></li>
        <?php }?>
        
        
        <?php if(!empty($memcount)){?>
        <a class="" onclick="displayalldata(<?php echo $userinfo->userid;?>,<?php echo $isgroup?>,1,'members','memberscount');" href="javascript:void(0)" rel="members">
            <li id="videoscount">MEMBERS <?php echo "(".$memcount.")";?></li>
        </a>
        <?php }else{?>
        <li>MEMBERS <?php echo "(".$memcount.")";?></li>
        <?php }?>
        
        
        
        

       <!-- <a class="" href="#"><li>MEMBERS (52)</li></a>-->
       <!-- <a class="" href="#"><li>FOLLOWERS (100)</li></a>-->
        
        </ul>
	<?php } ?>
    
    
    
   



