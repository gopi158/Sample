<?php
  //print_r($myfollowers);exit;
  include("header.php");
  include ("configuration/configuration.php");
  include ("footer.php");
  include ("imagemodal.php"); 
?>
<script>
function sortfollowerbytiles(tile_id)
{
    if(tile_id == "0")
    {
        $(".jq-tile-follower").show();
    }
    else
    {
        $(".jq-tile-follower").hide();
        $(".jq-tile-follower" + tile_id).show();
    }
}

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
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <div class="row">
            <img src="<? echo $image_path."blank.gif"; ?>" alt="Banner-image" style="background-image: url('<? echo ($user_details->banner_image != "" ?  $user_details->banner_image : $image_path."no-image-banner.jpg"); ?>');background-repeat: no-repeat; background-position: center center; height: 200px;" class="width100 img-responsive">            
        </div>
        <div class="content-wrapper">
            <div class="row col-md-12 col-xs-12" style="margin-bottom: 20px;">
                <div class="col-md-2 col-xs-2">
                    <div class="thumbnail ">
                        <img alt="Profile-image" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : $image_path."no-image.png"); ?>"  class="width100 img-responsive">                        
                    </div>
                </div>
                <div class="col-md-10 col-xs-10">
                    <div class="row">
                        <p class="font-25px updated-by">
                            <a href="index.php?r=site/myprofile" class="font-black">
                                <? echo ucwords($user_details->fname ." ". $user_details->lname); ?> 
                            </a>
                        </p>
                        <p class="font-14px">
                            <? echo $user_details->mystory; ?>
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-xs-10" style="margin-left: -30px;">
                            <div class="col-md-2 col-xs-2 profile-finaos  profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/myfinaos">FINAOs</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfinaos; ?></p>
                            </div>
                            <div class="col-md-2 col-xs-2 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/mytiles">TILES</a></p>
                                <p class="orange font-25px"><? echo $user_details->totaltiles; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-3 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/imfollowing">FOLLOWING</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfollowings; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-3 profile-finaos profile-finaos-font border-right">
                                <p class="font-18px"><a href="index.php?r=site/myfollowers">FOLLOWERS</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalfollowers; ?></p>
                            </div>
                            <div class="col-md-2 col-xs-2 profile-finaos profile-finaos-font">
                                <p class="font-18px"><a href="index.php?r=site/myinspirations">INSPIRED</a></p>
                                <p class="orange font-25px"><? echo $user_details->totalinspired; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-4">
                            <a href="index.php?r=site/edit_profile" class=" right status-button-ontrack button-myprofile">EDIT MY PROFILE</a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left: -80px">
            <div class="col-md-4 col-xs-5">
                <div class="left-rounded-box" style="padding: 8px 5px 8px 8px; background: #fff;">
                    <div class="entered-finaos">
                        <ul class="fade-text">
                            <li><a href="index.php?r=site/myfinaos">FINAOS</a></li>
                            <li><a href="index.php?r=site/mytiles">Tiles</a></li>
                            <li><a href="index.php?r=site/myposts">Posts</a></li>
                            <li><a href="index.php?r=site/myinspirations">Inspired</a></li> 
                            <li><a href="index.php?r=site/imfollowing">Following</a></li>
                            <li class="selected last"><a href="index.php?r=site/myfollowers">Followers</a></li>
                        </ul>
                        <div class="row col-md-12">
                            <label-select>
                                <select id="myowntiles" name="myowntiles" onchange="sortfollowerbytiles(this.value);">
                                    <option value="0">All</option>
                                    <?
                                        if(is_array($owntiles))
                                        {
                                            foreach($owntiles as $owntile)
                                            {
                                                ?>
                                                    <option value="<? echo $owntile->tileid; ?>" <? echo @($tileid == $owntile->tileid ? 'selected=selected' : '') ?>><? echo $owntile->tile_name; ?></option>
                                                <?
                                            }
                                        }
                                    ?>
                                </select>
                            </label-select>
                        </div>
                    </div>
                    <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <p class="font-25px">PHOTOS + VIDEOS</p>
                    </div>
                    <div class="row img-space img-responsive" style="margin: 0px;">
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
                                                                    <img alt="Post-image" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('images/uploads/posts/<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
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
            <div class="col-md-7 col-xs-6">
                <div class="row">
                    <div class="left-rounded-box" style="padding-top: 10px; margin-right: -30px;">
                        <?
                            if(is_array($myfollowers))
                            {
                                foreach($myfollowers as $follower)
                                {
                                    ?>
                                        <div class="popup-selected-finao popup-selected-finao-border jq-tile-follower jq-tile-follower<? echo $follower->tile_id; ?>" style="margin-left: 25px;">
                                            <div class="row">
                                                <a href="index.php?r=site/public_profile&userid=<? echo $follower->userid; ?>" class="font-black">
                                                    <img alt="Profile-image" src="images/uploads/profileimages/<? echo ($follower->image != "" ? (file_exists('images/uploads/profileimages/'.$follower->image) ? $follower->image : "no-image.png") : "no-image.png") ?>" class="img-border">
                                                    <!--<img alt="Image" src="images/uploads/profileimages/<? echo (file_exists('images/uploads/profileimages/'.$follower->image) ? $follower->image : "no-image.png") ?>" class="img-border"/>-->                                                
                                                    <span class="font-18px profile-followers"><? echo ucwords($follower->fname ." ". $follower->lname); ?></span>
                                                </a>
                                                <div class="col-md-2 right profile-followers-icons">
                                                    <img alt="Icon-family" src="<? echo $icon_path."family.png";?>">
                                                    <img alt="Icon-school" src="<? echo $icon_path."school.png"; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?
                                }
                            }
                            else
                            {
                                ?>
                                <div class="row">
                                    <div class="col-xs-10 col-md-12">
                                        <div class="text font-18px">
                                            No follower is available for<br />
                                            the Tile.<br /><br /><br /><br />
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
    </div>
</div>
