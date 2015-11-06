<script>
  function follow_this_tile(followeduserid,tileid)
  {                  
      $("#ajax_loader").show();
      $.get("index.php?r=site/followuser&followeduserid="+ followeduserid +"&tileid="+ tileid,function(data){
          var result = $.parseJSON(data); 
          $("#ajax_loader").hide();
          if(result["return"] == "success")
          {                                           
            $("#follow"+tileid).removeClass("button-follow");
            $("#follow"+tileid).addClass("following-button");
            $("#follow"+tileid).text("");
            $("#follow"+tileid).text("FOLLOWING");
          }
          else
          {
            if(result["return"] == "Already following this tile ")
            {
                $.get("index.php?r=site/unfollowuser&followeduserid="+ followeduserid +"&tileid="+ tileid,function(data){
                    var result_unfollow = $.parseJSON(data);                     
                    if(result_unfollow["return"] == "success")
                    {
                        $("#follow"+tileid).removeClass("following-button");
                        $("#follow"+tileid).attr("style","");
                        $("#follow"+tileid).addClass("button-follow");                        
                        $("#follow"+tileid).text("");
                        $("#follow"+tileid).text("FOLLOW"); 
                    }
                    if(result_unfollow["status"] == "avail")               
                    {   
                        $("#follow_dropdown").removeClass("following-button");
                        $("#follow_dropdown").removeClass("status-button-ahead");   
                        $("#follow_dropdown").addClass("profile-follow-button");                     
                        $("#follow_dropdown").css("background-color","");                        
                        $("#follow_dropdown").text("");
                        $("#follow_dropdown").text("FOLLOW");    
                        $("#follow_all").removeClass("following-button");
                        $("#follow_all").addClass("button-follow");                        
                        $("#follow_all").css("background-color","");                        
                        $("#follow_all").text("");
                        $("#follow_all").text("FOLLOW");
                    }
                    
                });
            }
          }
          if(result["status"]== "notavail")
          {
            $(".followtile").removeClass("button-follow");
            $(".followtile").css("background-color","#FD6D20");
            $(".followtile").addClass("following-button");
            $(".followtile").text("");
            $(".followtile").text("FOLLOWING");    
          }
      });
  }
  
    function show_finao_msg_public(tile_id,user_id)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/get_finao_msg_public&tile_id="+ tile_id + "&user_id="+ user_id,function(data){
            $("#ajax_loader").hide();
            $("#finao"+tile_id).html(data); 
        });    
    } 
    
    function follow_users_all_tile(user_id, uname)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/follow_users_all_tile&user_id="+ user_id + "&uname=" + uname,function(data){
            $("#ajax_loader").hide();
            if(data == "unfollow_all")
            {                    
                $(".followtile").addClass("button-follow");
                $("#follow_dropdown").removeClass("button-follow");
                $("#follow_dropdown").removeClass("status-button-ahead");
                $("#follow_dropdown").addClass("profile-follow-button");
                $(".followtile").css("background-color","");
                $(".followtile").removeClass("following-button");
                $(".followtile").text("");
                $(".followtile").text("FOLLOW");
            }
            else if (data == "follow_all")  
            {   
                $(".followtile").removeClass("button-follow");
                $(".followtile").css("background-color","#FD6D20");
                $(".followtile").addClass("following-button");
                $(".followtile").text("");
                $(".followtile").text("FOLLOWING");
            }            
        });    
    } 
</script>  <? //print_r($public_profile_details); exit;?>
<div class="row" >
    <img src="<? echo $image_path."blank.gif"; ?>" alt="Banner-image" style="background-image: url('<? echo ($public_profile_details->banner_image != "" ?  $public_profile_details->banner_image : $image_path."no-image-banner.jpg"); ?>');" class="width100 img-responsive profile-banner"/>
</div>
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3">           
                <img alt="Profile-image" src="<? echo ($public_profile_details->profile_image != "" ? $public_profile_details->profile_image : $image_path."no-image.png"); ?>"  class="profile_image img-border img-responsive">           
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-custom-sm-pull-55">
            <div class="row">
                <p class="font-25px updated-by">
                    <a href="index.php?r=site/public_finao_posts&uname=<? echo $public_profile_details->uname; ?>" class="font-black">
                        <? echo ucwords($public_profile_details->fname ." ".$public_profile_details->lname); ?>
                    </a>
                </p>
            </div>
            <div class="row">
                <p class="font-18px bio-message">
                    <? echo ucwords($public_profile_details->mystory); ?>
                </p>
            </div>
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-10" style="margin-left: -30px;">
                    <div class="col-lg-2 col-md-2 col-sm-2 profile-finaos  profile-finaos-font border-right">
                        <p class="font-18px static-name">
                            <a href="index.php?r=site/public_finaos&uname=<? echo $public_profile_details->uname; ?>">
                                FINAOs                  
                            </a>
                        </p>
                        <p class="orange font-25px static-numbers">
                            <? echo $public_profile_details->totalfinaos; ?> 
                        </p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 profile-finaos profile-finaos-font border-right">
                        <p class="font-18px static-name">
                            <a href="index.php?r=site/public_tiles&uname=<? echo $public_profile_details->uname; ?>">
                                TILES                  
                            </a>
                        </p>
                        <p class="orange font-25px static-numbers">
                            <? echo $public_profile_details->totaltiles; ?>                
                        </p>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 profile-finaos profile-finaos-font border-right">
                        <p class="font-18px static-name">
                            <a href="index.php?r=site/public_followings&uname=<? echo $public_profile_details->uname; ?>">
                                FOLLOWING                  
                            </a>
                        </p>
                        <p class="orange font-25px static-numbers">
                            <? echo $public_profile_details->totalfollowings; ?>                
                        </p>
                    </div>
                    <div class="col-lg-3  col-md-2 col-sm-2 profile-finaos profile-finaos-font">
                        <p class="font-18px static-name">
                            <a href="index.php?r=site/public_inspired&uname=<? echo $public_profile_details->uname; ?>">
                                INSPIRED                  
                            </a>
                        </p>
                        <p class="orange font-25px static-numbers">
                            <? echo $public_profile_details->totalinspired; ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-sm-push-7" style="margin-top: -55px; ">
                    <?   
                        $total_tile_count = 0;
                        $total_followed_tiles = 0;
                        if(is_array($public_tiles))                  
                        {                        
                            $total_tile_count = count($public_tiles);                            
                            foreach ($public_tiles as $public_tile)
                            {    
                                if($public_tile->type == 1)
                                {
                                    ++ $total_followed_tiles;
                                }    
                            }
                            
                            if($total_tile_count > $total_followed_tiles)
                            {
                                ?>
                                    <a href="#" id="follow_dropdown" class="profile-follow-button  following-button border-profile-tile followtile" data-toggle="dropdown">
                                        FOLLOW
                                    </a>
                                <?
                            }
                            else
                            {
                                ?>
                                    <a href="#" id="follow_dropdown" class="status-button-ahead following-button border-profile-tile followtile" data-toggle="dropdown">
                                        FOLLOWING
                                    </a>
                                <?    
                            }                            
                        }
                    ?>                    
                    <ul class="dropdown-menu pull-right text-align-right following-dropdown" role="menu" style="margin-right: -60px; margin-top: 11px;" aria-labelledby="dLabel">
                        <li style="margin-top:-26px;">
                            <div class="arrow1" ></div>
                        </li>
                        <li class="menu-divider">
                            <div class="dropdown-menu-padding" style="margin-top:5px;">
                                <div class="dropdown-following-button padding-left10px">
                                    <img alt="Icon-tile" src="<? echo $icon_path."icon-all.png"; ?>">
                                    All tiles
                                </div>
                                <?
                                    if($total_tile_count > $total_followed_tiles)
                                    {
                                        ?>
                                            <a href="#" id="follow_all" onclick="follow_users_all_tile(<? echo $public_profile_details->userid; ?>,'<? echo $public_profile_details->uname; ?>'); return false;" class="status-button-ahead button-follow followtile">
                                                FOLLOW
                                            </a>
                                        <?
                                    }
                                    else
                                    {
                                        ?>
                                            <a href="#" id="follow_all" class="status-button-ahead following-button followtile" onclick="follow_users_all_tile(<? echo $public_profile_details->userid; ?>, '<? echo $public_profile_details->uname; ?>'); return false;">
                                                FOLLOWING
                                            </a>
                                        <?    
                                    } 
                                ?>                                
                            </div>
                        </li>
                        <?   
                            if(is_array($public_tiles))
                            {                        
                                $total_tile_count = count($public_tiles);
                                $total_followed_tiles = 0;
                                foreach ($public_tiles as $public_tile)
                                {                                            
                                    ?>        
                                        <li class="menu-divider">
                                            <div class="dropdown-menu-padding" style="margin-top:5px;">
                                                <div class="dropdown-following-button  padding-left10px">
                                                    <img alt="Tile Image" src="<? echo ($public_tile->tile_image != "" ? $public_tile->tile_image : $icon_path."tile.png"); ?>" style="width:22px; height:22px;">
                                                    <? echo $public_tile->tile_name; ?>
                                                </div>
                                                <?
                                                    if($public_tile->type == 1)
                                                    {   
                                                        ++$total_followed_tiles;
                                                        ?>
                                                            <a id="follow<? echo $public_tile->tile_id; ?>" href="#" class="status-button-ahead following-button followtile" onclick="follow_this_tile('<? echo $public_profile_details->userid; ?>','<? echo $public_tile->tile_id; ?>'); return false;">
                                                                FOLLOWING                                                           
                                                            </a>                                                            
                                                        <?                                                        
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                            <a id="follow<? echo $public_tile->tile_id; ?>" href="#" class="status-button-ahead button-follow followtile" onclick="follow_this_tile('<? echo $public_profile_details->userid; ?>','<? echo $public_tile->tile_id; ?>'); return false;">
                                                                FOLLOW                                                            
                                                            </a>
                                                        <?
                                                    }
                                                ?>                                                
                                            </div>
                                        </li>
                                    <?                                   
                                }                                
                            }
                        ?>      
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>