<?php
//print_r($inspired_posts);exit;   
    include ("header.php");
    include ("imagemodal.php"); 
    include ("configuration/configuration.php");
    include_once("public_post_snippet.php");
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
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("private_profile_details.php");?>
    </div>
    <div class="row" style="margin-top: 10px; margin-left: -80px; ">
        <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
            <div class="left-rounded-box white-background" style="padding: 8px 5px 8px 8px;">
                <div class="entered-finaos">
                    <ul class="fade-text">
                      <a href="index.php?r=site/myfinaos">  <li>FINAOS</li></a>
                      <a href="index.php?r=site/mytiles"> <li>Tiles</li></a>
                      <a href="index.php?r=site/myprofile"><li>Posts</li></a>
                      <a href="index.php?r=site/myinspirations" ><li class="current">Inspired</li></a>
                      <a href="index.php?r=site/imfollowing"> <li>Following</li></a>
                      <a href="index.php?r=site/myfollowers"> <li class="last">Followers</li></a>
                    </ul>
                </div>
              <!-- <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
               <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
                </div>-->
                <div class="row  img-responsive" style="margin: 0px;">
                     <?
                        //if(is_array($finao_recent_posts))
//                        {
//                            $j = 0;
//                            foreach($finao_recent_posts as $finao_recent_post)
//                            {
//                                if($finao_recent_post->status == 1)
//                                {  
//                                    $has_data = false;
//                                    if(is_array($finao_recent_post->image_urls))
//                                    {                                                        
//                                        foreach($finao_recent_post->image_urls as $image_url)
//                                        {                              
//                                            if ($image_url->image_url != "")
//                                            {
                                                ?>
                                                   <!-- <a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? //echo $finao_recent_post->uploaddetail_id; ?>);">                                                                    
                                                        <img class="left-photos" src="<? //echo $image_path."blank.gif"?>" style="background-image: url('<? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                    </a>-->
                                                <?  
                                               // $has_data = true;
//                                                ++$j;
//                                                break;
//                                            }
//                                        }                                                               
//                                    }
//                                    if(!$has_data)
//                                    {
//                                        if(is_array($finao_recent_post->videourls))
//                                        {                                                        
//                                            foreach($finao_recent_post->videourls as $videourls)
//                                            {                              
//                                                if ($image_url->image_url != "")
//                                                {
                                                    ?>                                                                    
                                                       <!-- <a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? //echo $finao_recent_post->uploaddetail_id; ?>);">
                                                            <img class="left-photos" src="<? //echo $icon_path."nike.png"?>" style="background-image: url('<? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                        </a> -->
                                                    <?
                                                   // $has_data = true;
//                                                    ++$j;
//                                                    break;
//                                                }
//                                            }                                                               
//                                        }
//                                    }  
//                                }
//                                if($j == 3)
//                                {
//                                    break;
//                                }
//                            }
//                        }
//                        else
//                        {
//                            
//                        }
                    ?> 
                </div>
            </div>
            <? include_once ("footer.php"); ?>
        </div>
        <div class="col-lg-7 col-md-6 col-sm-5 col-sm-push-custom">
            <?
                if(is_array($inspired_posts))
                {
                    $pc = 0;
                    foreach($inspired_posts as $inspired_post)
                    {
                        ++$pc;
                        render_public_post($user_details,
                                           $inspired_post->uploaddetail_id, 
                                           $inspired_post->inspireuserid,
                                           $inspired_post->profileimg,
                                           $inspired_post->name,
                                           $inspired_post->updateddate,
                                           $inspired_post->image_urls,
                                           $inspired_post->finao_id,
                                           $inspired_post->finao_msg,
                                           $inspired_post->upload_text,
                                           $inspired_post->finao_status,
                                           $inspired_post->tile_image,
                                           $inspired_post->videourls,
                                           $inspired_post->video_img,
                                           $inspired_post->totalinspired,
                                           $inspired_post->isinspired);
                        ?>
                            <!--<div class="row">
                                <div class="popup-selected-finao " style="margin-left: 35px;">
                                    <div class="row" style="padding: 0px 15px 10px 15px;">
                                        <div class="row col-md-12 col-sm-12" style="margin: 30px 0px 10px -30px;">
                                            <a href="index.php?r=site/public_profile&userid=<? echo $inspired_post->inspireuserid;?>" class="font-black">
                                                <div class="col-md-1 col-sm-1" style="margin-right: 5px;">
                                                    <img alt="Profile-image" src="<? echo ($inspired_post->profileimg != "" ? $inspired_post->profileimg  : $image_path."no-image.png"); ?>"  class="post-image">  
                                                </div>
                                                <div class="col-md-5 col-sm-6" style="margin-top: 2%; margin-left: 5px;">
                                                    <span class="updated-by">                                                    
                                                            <? echo $inspired_post->name; ?>                                                    
                                                    </span>
                                                </div>
                                            </a>
                                            <div class="col-md-3 col-sm-4 text-fade" style="margin-right: -50px; margin-top: 2%;">
                                                <? echo (date("Y-m-d",strtotime($inspired_post->updateddate)) != "0000-00-00" && date("Y-m-d",strtotime($inspired_post->updateddate)) != "1970-01-01" ? date("d-M-Y",strtotime($inspired_post->updateddate)) : ""); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-11"> 
                                                <?
                                                    if(is_array($inspired_post->image_urls))
                                                    {                                         
                                                        ?>
                                                            <div class="carousel slide row" data-ride="carousel" data-interval="false">
                                                                <div class="carousel-inner">
                                                                    <?
                                                                        foreach($inspired_post->image_urls as $image_url)
                                                                        {
                                                                            if ($image_url->image_url != "")
                                                                            {
                                                                                ?>
                                                                                    <div class="">
                                                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: center center; background-size: 100% auto;">                                                                                    
                                                                                    </div>
                                                                                <?
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?
                                                    }
                                                ?>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                        <?
                        if($pc == $post_count)
                        {
                            break;
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>