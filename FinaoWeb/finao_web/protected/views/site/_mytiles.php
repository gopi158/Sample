<?php
    //print_r($mytiles);exit; 
    include ("header.php"); 
    include ("imagemodal.php"); 
    include ("configuration/configuration.php");
    include ("footer.php");
?>
<script>
    function change_finao_status(finao_id,finao_status,from)
    {
        if (from == "modal")
        {
             $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
                if(data == "ok")
                {
                    var finao_status_list_item = "";
                    if(finao_status == 38)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>';
                    }
                    
                    if(finao_status == 39)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>';
                       
                    }
                    
                    if(finao_status == 40)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>';
                    }
                    
                    $("#modal_link"+finao_id).remove();
                    $("#modal_finaostatus"+finao_id).prepend(finao_status_list_item);
                    alert("Finao status changed successfully");
                }
            });
        }       
    }
   
    function deletepost(finao_id,uploaddetail_id)
    {
        if(confirm("Are you sure?"))
        {
            $.get("index.php?r=site/deletepost&finaoid="+ finao_id +"&userpostid="+ uploaddetail_id,function(data){
                if(data == "ok")
                {
                    $("#row"+finao_id).remove();
                    alert("post deleted successfully");  
                }
                else
                {
                    alert("you can not delete post");
                }
            });
        }
    }
    
    function sharepost(userpostid,finaoid)
    {
        $.get("index.php?r=site/sharepost&userpostid="+ userpostid + "&finaoid="+ finaoid,function(data){
            if (data == "success")
            {
                alert ("Post is shared successfully.")
            }
            else
            {
                alert (data);   
            }
        });
    }
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <div class="row">
            <img src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo ($user_details->banner_image != "" ?  $user_details->banner_image : $image_path."no-image-banner.jpg"); ?>');background-repeat: no-repeat; background-position: center center; height: 200px;" class="width100 img-responsive">
            <!--<img alt="Image" src="images/uploads/backgroundimages/<? //echo ($user_details->banner_image != "" ? (file_exists("images/uploads/backgroundimages/".$user_details->banner_image) ? $user_details->banner_image : "no-image-banner.jpg") : "no-image-banner.jpg") ?>" class="width100 img-responsive"/>-->
        </div>
        <div class="content-wrapper">
            <div class="row col-md-12 col-sm-12" style="margin-bottom: 20px;">
                <div class="col-md-2 col-sm-2">
                    <div class="img-border">
                        <img alt="Profile-image" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : $image_path."no-image.png"); ?>"  class="width100 img-responsive">
                        <!--<img alt="Image" src="images/uploads/profileimages/<? echo ($user_details->profile_image != "" ? (file_exists("images/uploads/profileimages/".$user_details->profile_image) ? $user_details->profile_image : "no-image.png") : "no-image.png") ?>"  class="width100 img-responsive">-->
                    </div>
                </div>
                <div class="col-md-10 col-sm-10">
                    <div class="row">
                        <p class="font-25px updated-by">
                            <a href="index.php?r=site/myprofile" class="font-black">
                                <? echo ucwords($user_details->fname." ".$user_details->lname); ?>
                            </a>
                        </p>
                      <p class="font-18px p-text">
                            <? echo $user_details->mystory; ?>
                        </p>
                    </div>
                    <div class="row">
                      <div class="col-md-8 col-sm-9" style="margin-left: -30px;">
                            <div class="col-md-2 col-sm-2 profile-finaos  profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/myfinaos">FINAOs</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfinaos; ?></p>
                            </div>
                            <div class="col-md-2 col-sm-2 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/mytiles">TILES</a></p>
                                <p class="orange font-25px"><? echo $user_details->totaltiles; ?></p>
                            </div>
                            <div class="col-md-3 col-sm-3 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/imfollowing">FOLLOWING</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfollowings; ?></p>
                            </div>
                            <div class="col-md-3 col-sm-3 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/myfollowers">FOLLOWERS</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfollowers; ?></p>
                            </div>
                            <div class="col-md-2 col-sm-2 profile-finaos profile-finaos-font">
                                <p class="font-18px"><a href="index.php?r=site/iminspired">INSPIRED</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalinspired; ?></p>
                            </div>
                        </div>
                      <div class="col-lg-4 col-md-4 col-sm-3 col-sm-push-1">
                            <a href="index.php?r=site/edit_profile" class=" right status-button-ontrack button-myprofile">EDIT MY PROFILE</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="row" style="margin-left: -80px;">
        <div class="col-lg-3 col-md-4 col-sm-4">
          <div class="left-rounded-box" style="padding: 8px 5px 8px 8px; background: #fff;">
            <div class="entered-finaos entered-finaos-black">
              <ul>
                            <li><a href="index.php?r=site/myfinaos">FINAOS</a></li>
                            <li class="selected"><a href="index.php?r=site/mytiles">Tiles</a></li>
                            <li><a href="index.php?r=site/myposts">Posts</a></li>
                            <li><a href="index.php?r=site/myinspirations">Inspired</a></li>
                            <li><a href="index.php?r=site/imfollowing">Following</a></li>
                            <li><a href="index.php?r=site/myfollowers">Followers</a></li>
                        </ul>
                    </div>
            <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <p class="font-25px">PHOTOS + VIDEOS</p>
                    </div>
                    <div class="row" style="margin-left: 0px; display: inline;">
                    <?
                        if(is_array($finao_recent_posts))
                        {
                            $j = 0;
                            foreach($finao_recent_posts as $finao_recent_post)
                            {
                                ++$j;
                                if($finao_recent_post->status == 1)
                                {                                                              
                                    ?>
                                        <a href="#" data-target="#" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">
                                            <?
                                                if(is_array($finao_recent_post->image_urls))
                                                {                                                        
                                                    foreach($finao_recent_post->image_urls as $image_url)
                                                    {
                                                        if ($image_url->image_url != "")
                                                        {
                                                            ?>
                                                                <img alt="Post-image" src="<? echo $image_path."blank.gif"?>" style="background-image: url('images/uploads/posts/<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                            <?
                                                        }
                                                    }                                                               
                                                }
                                            ?>
                                        </a>
                                    <?
                                }
                                if($j == 3)
                                {
                                    break;
                                }
                            }
                        }
                        else
                        {
                            
                        }
                    ?>                        
                    </div>
                </div>
            </div>
        <div class="col-lg-9 col-md-8 col-sm-7">
                <?
                    if(is_array($mytiles))
                    {
                        foreach ($mytiles as $mytile)
                        {
                            ?>
                                 
                            <div class="col-lg-6 col-md-6 col-sm-12">
                              <ul class="nav  navbar-left img-responsive-tiles">
                                        <li id="fat-menu" class="dropdown">
                                            <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">

                                              <div class="view view-sixth" >
                                                <img alt="Tiles-image" src="images/uploads/finaoimages/<? echo ($mytile->tile_imageurl != "" ? (file_exists("images/uploads/finaoimages/".$mytile->tile_imageurl) ? $mytile->tile_imageurl : "no_tile_image.jpg") : "no_tile_image.jpg") ?>"  class="img-responsive"/>
                                                  <div class="mask">
                                                    <p class="info_travel">
                                                      <? echo $mytile->tilename; ?>
                                                    </p>
                                                  </div>
                                                </div>                                            
                                            </a>

                                          <ul class="dropdown-menu  col-lg-12 col-md-12 col-sm-12" role="menu" aria-labelledby="drop3">
                                            <div class="row list">
                                              <ul>
                                                <li>
                                                  <? echo $mytile->finao_message; ?>
                                                </li>
                                              </ul>
                                            </div>
                                          </ul>
                                          
                                        </li>
                                    </ul>
                                </div>
                            <?        
                        }
                    }
                    if($mytiles == false)
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-10 col-md-12">
                                    <div class="text">
                                        You don't have any tiles
                                    </div>
                                </div>
                            </div>
                        <?
                    }
                ?>
            </div>
        </div>
    </div>
</div>