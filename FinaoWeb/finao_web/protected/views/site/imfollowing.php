<?php
  include("header.php");
  include ("configuration/configuration.php");
  //include ("imagemodal.php"); 
 //print_r (($followings));exit;
?>
<script>
    function change_finao_status(finao_id,finao_status,from)
    {
        $("#ajax_loader").show();
        if (from == "modal")
        {                     
            $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
                $("#ajax_loader").hide();
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
                    show_alert("Finao status changed successfully");
                }
            });
        }        
    }
    
    function sharepost(userpostid,finaoid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/sharepost&userpostid="+ userpostid + "&finaoid="+ finaoid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                show_alert("Post is shared successfully.")
            }
            else
            {
                show_alert(data);   
            }
        });
    }
    
    function deletepost(finao_id,uploaddetail_id)
    {
        if(confirm("Are you sure?"))
        {
            $("#ajax_loader").show();
            $.get("index.php?r=site/deletepost&finaoid="+ finao_id +"&userpostid="+ uploaddetail_id,function(data){
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    $("#row"+finao_id).remove();
                    show_alert("post deleted successfully");  
                }
                else
                {
                    show_alert("you can not delete post");
                }
            });
        }
    }
    
    function sortfollowingbytiles(tile_id)
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
    
    <?
                            if(is_array($followings))
                            {
                                $tile_id = 0;
                                $tile_image = "";
                                $tiles_arr = array();
                                foreach($followings as $following)
                                {
                                    if(is_array($following->tile_ids))
                                    {
                                        foreach ($following->tile_ids as $key => $tile)
                                        {                
                                            if(!in_array($tiles_arr[$tile->tile_id],$tiles_arr))
                                            {                                                               
                                                $tiles_arr[$tile->tile_id] = array("tile_id"=>$tile->tile_id,"tile_name"=>$following->tile_names[$key]->tile_name);
                                            }    
                                        } 
                                    }
                                }
                                
                                function multid_sort($arr, $index) 
                                {
                                    $b = array();
                                    $c = array();
                                    foreach ($arr as $key => $value) {
                                        $b[$key] = $value[$index];
                                    }

                                    asort($b);

                                    foreach ($b as $key => $value) {
                                        $c[] = $arr[$key];
                                    }

                                    return $c;
                                }
                                
                                $tiles_arr = multid_sort($tiles_arr, 'tile_name');                                
                            }
                        ?>
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("private_profile_details.php");?>
        <div class="row" style="margin-left: -80px">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <div class="left-rounded-box white-background" style="padding: 8px 5px 8px 8px;">
                    <div class="entered-finaos">
                        <ul class="fade-text">
                          <a href="index.php?r=site/myfinaos"><li>FINAOs</li></a>
                          <a href="index.php?r=site/mytiles"><li>Tiles</li></a>
                          <a href="index.php?r=site/myprofile">  <li>Posts</li></a>
                          <a href="index.php?r=site/myinspirations">  <li>Inspired</li></a>
                          <a href="index.php?r=site/imfollowing" >  <li class="current"><div>Following</div>
                          <div><select id="myowntiles" name="myowntiles" onchange="sortfollowingbytiles(this.value);">
                                    <option value="0">All</option>
                                    <?
                                        foreach ($tiles_arr as $tile)
                                        {
                                            ?>
                                                <option value="<? echo $tile["tile_id"]; ?>"><? echo $tile["tile_name"]; ?></option>
                                            <?
                                        }
                                    ?>
                                </select></div>
                          </li></a>
                          <a href="index.php?r=site/myfollowers" > <li class="last">Followers</li></a>
                        </ul>
                        <!--
                        <div class="row col-lg-12 col-md-12 col-sm-12">
                            <div class="label">
                                <select id="myowntiles" name="myowntiles" onchange="sortfollowingbytiles(this.value);">
                                    <option value="0">All</option>
                                    <?
                                        foreach ($tiles_arr as $tile)
                                        {
                                            ?>
                                                <option value="<? echo $tile["tile_id"]; ?>"><? echo $tile["tile_name"]; ?></option>
                                            <?
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>-->
                    </div>
                  <!--<div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
                    </div>
                    -->
                    <div class="row img-space img-responsive" style="margin: 0px;">
                         <?
                            //if(is_array($finao_recent_posts))
//                            {
//                                $j = 0;
//                                foreach($finao_recent_posts as $finao_recent_post)
//                                {
//                                    if($finao_recent_post->status == 1)
//                                    {  
//                                        $has_data = false;
//                                        if(is_array($finao_recent_post->image_urls))
//                                        {                                                        
//                                            foreach($finao_recent_post->image_urls as $image_url)
//                                            {                              
//                                                if ($image_url->image_url != "")
//                                                {
                                                    ?>
                                                        <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? //echo $finao_recent_post->uploaddetail_id; ?>);">                                                                    
                                                            <img class="left-photos" src="<? //echo $image_path."blank.gif"?>" style="background-image: url('<? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                        </a> -->
                                                    <?  
                                                    //$has_data = true;
//                                                    ++$j;
//                                                    break;
//                                                }
//                                            }                                                               
//                                        }
//                                        if(!$has_data)
//                                        {
//                                            if(is_array($finao_recent_post->videourls))
//                                            {                                                        
//                                                foreach($finao_recent_post->videourls as $videourls)
//                                                {                              
//                                                    if ($image_url->image_url != "")
//                                                    {
                                                        ?>                                                                    
                                                            <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? //echo $finao_recent_post->uploaddetail_id; ?>);">
                                                                <img class="left-photos" src="<? //echo $icon_path."nike.png"?>" style="background-image: url('<? ///echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                            </a>-->
                                                        <?
                                                        //$has_data = true;
//                                                        ++$j;
//                                                        break;
//                                                    }
//                                                }                                                               
//                                            }
//                                        }  
//                                    }
//                                    if($j == 3)
//                                    {
//                                        break;
//                                    }
//                                }
//                            }
//                            else
//                            {
//                                
//                            }
                        ?> 
                    </div>
                </div>
                <? include_once ("footer.php"); ?>
            </div>     
            <div class="col-lg-7 col-md-6 col-sm-5">
                <div class="row">
                    <div class="left-rounded-box" style="padding-top: 10px; padding-right:15px; padding-left: 10px; margin-right: -75px;">
                            <? 
                                $tile_id = 0;
                                $tile_image = "";
                                if(is_array($followings))
                                {
                                    foreach($followings as $following)
                                    {
                                        if(is_array($following->tile_ids))
                                        {
                                            $class_str = "";
                                            foreach ($following->tile_ids as $tile)
                                            {
                                                $class_str .= " jq-tile-follower".$tile->tile_id;
                                            }
                                        }
                                        ?>
                                             <div class="popup-selected-finao popup-selected-finao-border jq-tile-follower <? echo $class_str; ?>" style="margin-left: 25px;">
                                                <div class="row">
                                                    <a href="index.php?r=site/public_finao_posts&uname=<? echo $following->uname; ?>" class="font-black">
                                                        <img alt="Profile-image" src="<? echo ($following->image != "" ? $following->image : $image_path."no-image.png"); ?>" class="post-image" style="width:74px;">
                                                        <span class="font-18px updated-by-post profile-followers"><? echo ucwords($following->fname ." ". $following->lname); ?></span>
                                                    </a>
                                                    <div class="col-md-5 col-lg-5 right profile-followers-icons"> 
                                                        <?                                                              
                                                            if(is_array($following->tile_ids))
                                                            {
                                                                foreach ($following->tile_ids as $key => $tile)
                                                                {
                                                                    ?>
                                                                        <a href="index.php?r=site/tiles&tile_id=<? echo $tile->tile_id; ?>">
                                                                            <img alt="Icon" src="<? echo $following->tile_images[$key]->tile_image; ?>" style="width:20px; height:20px;">
                                                                        </a>
                                                                    <?
                                                                }
                                                            }
                                                        ?>                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        <?
                                    }
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>

