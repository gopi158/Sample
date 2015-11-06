<?php
//    print_r($user_details);
//    echo "<br /><br /><br />";
//    print_r($finao_recent_posts);
//    exit;
//    print_r($finao_recent_posts); exit; 
    include ("header.php");
    include ("configuration/configuration.php"); 
?>
<script> 
    function change_finao_status(finao_id,finao_status,from)
    {  
        $("#ajax_loader").show();
        if(from == "myposts")
        {
            $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    var finao_status_list_item = "";
                    if(finao_status == 38)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>';
                    }
                    
                    if(finao_status == 39)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>';
                       
                    }
                    
                    if(finao_status == 40)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>';
                    }
                    
                    $("#link"+finao_id).remove();
                    $("#finaostatus"+finao_id).prepend(finao_status_list_item);
                }
           });   
        }
        else if (from == "modal")
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
    
   // function mark_inappropriate_post(userpostid)
//    {
//        $.get("index.php?r=site/mark_inappropriate_post&userpostid="+ userpostid,function(data){
//           alert (data); 
//        });
//    }
//     $(function(){ 
//        $(".mycorousel").each(function(){
//           $(this).find("div.item").last().addClass("active");  
//        });
//    });
    function sharepost(userpostid,finaoid)
    {
        $("#ajax_loader").hide();
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
                $("#row"+finao_id).remove();
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    $("."+uploaddetail_id).remove();
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
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <div class="left-rounded-box white-background" style="padding: 8px 3px 8px 8px;">
                    <div class="entered-finaos">
                        <ul class="fade-text">
                          <a href="index.php?r=site/myfinaos"> <li>FINAOs</li></a>
                          <a href="index.php?r=site/mytiles">  <li>Tiles</a></li></a>
                          <a href="index.php?r=site/myposts" > <li class="current">Posts</li></a>
                          <a href="index.php?r=site/myinspirations">  <li>Inspired</li>
                          <a href="index.php?r=site/imfollowing"> <li>Following</li>
                          <a href="index.php?r=site/myfollowers"><li class="last">Followers</li>
                        </ul>
                    </div>
                  <!-- <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
                    </div>-->
                    <div class="row img-responsive" style="margin: 0px;">
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
                                                    <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? //echo $finao_recent_post->uploaddetail_id; ?>);">                                                                    
                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"?>" style="background-image: url('<? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                    </a> -->
                                                <?  
                                                //$has_data = true;
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
                                                            <img class="left-photos" src="<? echo $icon_path."nike.png"?>" style="background-image: url('<? //echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
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
            <div class="col-lg-8 col-md-7 col-sm-6">
             <!--<div class="row getback ">
                    <div class="col-lg-10 col-md-10 col-sm-9 ">I WILL GET BACK TO HAWAII WITH MY WIFE BY FALL OF 2014.</div>
                    <a class="col-lg-2 col-md-2 col-sm-2 right post-orange">POST
                        <img alt="Image" src="content/images/icons/icon-post-finao-white.png">
                    </a>
                </div>--> 
                <?
                    if(is_array($finao_recent_posts))
                    {
                        $pc = 0;
                        foreach($finao_recent_posts as $finao_recent_post)
                        {
                            if($finao_recent_post->status == 1)
                            {
                                ++$pc;
                                ?>  
                                    <div class="row "  id="row<? echo $finao_recent_post->finao_id; ?>">                                        
                                        <div class="row col-lg-12 col-md-12 col-sm-12" style="margin: 0px 0px 10px -30px;">
                                            <a href="index.php?r=site/myprofile" class="font-black">
                                                <div class="col-md-1 col-sm-1" style="margin-right: 0px;">
                                                    <img alt="Image" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : "no-image.png"); ?>"  class="post-image">
                                                </div>
                                                <div class="col-md-5 col-sm-6 margin-posted-name">
                                                    <span class="updated-by-post"><? echo ucwords($user_details->fname ." ". $user_details->lname); ?></span>
                                                </div>
                                            </a>
                                            <div class="col-md-3 col-sm-4 time-since-posted right text-fade" style="margin-right: -50px; ">                                                
                                                <? echo  $finao_recent_post->updateddate;?>
                                            </div>
                                          <div class="row col-lg-11 col-md-11 col-sm-11 margin-finao-text">
                                            <p class="finao-title-text post-finaos font-18px">
                                              <img alt="Icon-finao" src="<? echo $icon_path. "icon-finao.png";?>"/>
                                                <? echo $finao_recent_post->finao_msg; ?>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 margin-20px img-responsive" > 
                                             <?                                                
                                                $first = true;
                                                if(count($finao_recent_post->videourls) == 0 && count($finao_recent_post->image_urls) == 0)
                                                {
                                                    // do nothing
                                                }
                                                elseif((count($finao_recent_post->videourls) + count($finao_recent_post->image_urls)) == 1)
                                                {
                                                    if (count($finao_recent_post->videourls) == 1)
                                                    {
                                                        foreach($finao_recent_post->videourls as $video_url)
                                                        {
                                                            ?>
                                                                <table class="post-images-slider">
                                                                   <tr>
                                                                      <td align="center" valign="top">
                                                                        <video controls class="post-images-slider">
                                                                            <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                                        </video> 
                                                                      </td>
                                                                   </tr>
                                                                </table>
                                                            <?
                                                        }
                                                    }
                                                    else
                                                    {
                                                        foreach($finao_recent_post->image_urls as $image_url)
                                                        {
                                                            ?>
                                                                <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 98%; background-repeat: no-repeat; background-position: top center; background-size: 100% auto;"/>
                                                            <?
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                        <div class="row uploaded-finao-image mycarousel">
                                                            <div class="carousel  slide row" data-ride="carousel" data-interval="false" id="carousel<? echo $finao_recent_post->uploaddetail_id; ?>">
                                                                <div class="carousel-inner "  style="margin-left:12px!important;">
                                                                    <?
                                                                        if(is_array($finao_recent_post->image_urls))
                                                                        {
                                                                            foreach($finao_recent_post->image_urls as $image_url)
                                                                            {
                                                                                ?>
                                                                                    <div class="item <? echo ($first ? "active" : ""); ?>" >                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 98.5%; background-repeat: no-repeat; background-position: top center; background-size: 100% auto;"/>
                                                                                    </div>
                                                                                <?
                                                                                $first = false;
                                                                            }
                                                                        }
                                                                        if(is_array($finao_recent_post->videourls))
                                                                        {  
                                                                            foreach($finao_recent_post->videourls as $video_url)
                                                                            {
                                                                                if($video_url != "")
                                                                                {
                                                                                    ?>
                                                                                        <div class="item <? echo ($first ? "active" : ""); ?>">
                                                                                            <table class="post-images-slider">
                                                                                               <tr>
                                                                                                  <td align="left" valign="top">
                                                                                                    <video controls class="post-images-slider">
                                                                                                        <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                                                                    </video> 
                                                                                                  </td>
                                                                                               </tr>
                                                                                            </table>
                                                                                        </div>
                                                                                    <?
                                                                                    $first = false;
                                                                                }                                                                                
                                                                            }
                                                                        }                                                                        
                                                                    ?>
                                                                </div>
                                                                <?
                                                                    if (count($finao_recent_post->image_urls) > 0 || count($finao_recent_post->videourls) > 0 )
                                                                    {   //echo (count($image_urls) . " - " .count($videourls));
                                                                        ?>
                                                                            <a class="left carousel-control"  data-slide="prev" style="margin-left:12px!important;" href="#carousel<? echo $finao_recent_post->uploaddetail_id; ; ?>">
                                                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                                            </a>
                                                                            <a class="right carousel-control"  data-slide="next"  href="#carousel<? echo $finao_recent_post->uploaddetail_id; ; ?>">
                                                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                                                            </a>
                                                                        <?
                                                                    }
                                                                ?>                                                
                                                            </div>
                                                        </div>
                                                    <?
                                                }
                                             ?>                                                 
                                            <div class="row col-lg-12 col-md-12 colsm-12">
                                                <span class="font-18px p-text">
                                                    <img alt="Icon-inspire" src="<? echo $icon_path."bulb.jpg";?>">
                                                    <? echo intval($finao_recent_post->totalinspired); ?> 
                                                    people were inspired by your post.
                                                </span>
                                                
                                                <p class="post-caption font-18px">
                                                    <? echo $finao_recent_post->upload_text; ?> 
                                                </p>
                                                <div class="row col-lg-12 col-md-12 col-sm-12">
                                                    <div class="row col-lg-4 col-md-4 col-sm-4" id="finaostatus<? echo $finao_recent_post->finao_id; ?>">
                                                        <?
                                                            echo ($finao_recent_post->finao_status == 38 ? '<a id="link'. $finao_recent_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($finao_recent_post->finao_status == 40 ? '<a href="#" id="link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                        ?>
                                                        <ul class="dropdown-menu left dropbox dropbox following-dropdown" style="margin-top: 10px; margin-left: -30px;" role="menu">
                                                            <li style="margin-top: -9px; margin-right: 36%">
                                                                <div class="arrow1"></div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,39,'profile'); return false;" class=" button-ahead-green status-button" style="padding-left: 23px; padding-right: 23px;">AHEAD </a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,38,'profile'); return false;" class=" button-track status-button">ON TRACK</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,40,'profile'); return false;" class=" button-behind status-button" style="padding-left: 21px; padding-right: 18px;">BEHIND </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                  <div class="col-lg-8 col-md-8 col-sm-8 col-sm-push-2">
                                                    <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                        <img alt="Icon-share" src="<? echo $icon_path. "icon-share-options.png";?>" class="right">                                                        
                                                    </a>
                                                    </div>
                                                    <ul class="dropdown-menu pull-right" style="margin-top: 7px; margin-right: -35px;">
                                                        <li>
                                                            <div class="arrow1"></div>
                                                        </li>
                                                        <li>
                                                            <div class=" text-align-left  devider-header" style="margin-top: 5px;">
                                                                <span class="padding-left10px"><a href="#" onclick="sharepost(<? echo $finao_recent_post->uploaddetail_id;?>,<? echo $finao_recent_post->finao_id;?>); return false;">Share</a></span>
                                                            </div>
                                                        </li>
                                                       <!-- <li>
                                                            <div class="text-align-left devider-header">
                                                                <span class="padding-left10px"><a href="#" onclick="return false;">Follow Travel Tile</a></span>
                                                            </div>
                                                        </li>  -->
                                                        <!--<li>
                                                            <div class="text-align-left devider-header">
                                                                <span class="padding-left10px"><a href="#" onclick="mark_inappropriate_post(<? //echo $finao_recent_post->uploaddetail_id;?>); return false;">Flag as Inappropriate</a></span>
                                                            </div>
                                                        </li>-->
                                                        <li>
                                                            <div class="text-align-left">
                                                                <span class="padding-left10px link-log"><a href="#" onclick="deletepost(<? echo $finao_recent_post->finao_id; ?>,<? echo $finao_recent_post->uploaddetail_id; ?>); return false;">Delete Post</a></span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                          
                                <?
                                if($pc == $post_count)
                                {
                                    break;
                                }
                            }
                        }
                    }
                    if($finao_recent_posts == false)
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-10 col-md-12">
                                    <div class="text">
                                        You don't have any posts.<br>
                                        Edit your profile and create a FINAO!
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
<?
    //include ("imagemodal.php");
    include_once("alert_modal.php");
?>