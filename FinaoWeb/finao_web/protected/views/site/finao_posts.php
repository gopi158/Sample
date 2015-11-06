<?
    include ("header.php");
    include ("configuration/configuration.php");
   // print_r($finao_posts);exit;
?>
<script>
    function change_finao_status(finao_id,finao_status,from)
    {
        if (from == "finao_posts")
        {
            $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
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
                    
                    //alert (finao_status_list_item);return false;
                    $("#link"+finao_id).remove();                             
                    $("#finaostatus"+finao_id).prepend(finao_status_list_item);
                    show_alert("Finao status changed successfully");
                }
            });   
        }
        else if (from == "modal")
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
                    show_alert("Finao status changed successfully");
                }
            });
        }        
    }
    
    function sharepost(userpostid,finaoid)
    {
        $.get("index.php?r=site/sharepost&userpostid="+ userpostid + "&finaoid="+ finaoid,function(data){
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
    
    function deletepost(finao_id,uploaddetail_id, from)
    {
        if(from == "finao_posts")
        {
            if(confirm("Are you sure?"))
            {
                alert (uploaddetail_id);
                $("#ajax_loader").show();
                $.get("index.php?r=site/deletepost&finaoid="+ finao_id +"&userpostid="+ uploaddetail_id,function(data){
                    alert (data); return false;
                    $("#ajax_loader").hide(); 
                    //alert (data); return false;                   
                    if(data == "ok")
                    {
                        $("#row_post"+ uploaddetail_id).remove();
                        show_alert("post deleted successfully");  
                    }
                    else
                    {
                        show_alert("you can not delete post");
                    }
                });
            }   
        }
    }
</script>
<div class="container white-background" style="margin-top: 23px;">
    <div class="content-wrapper">
        <? include_once ("private_profile_details.php");?>
        <div class="row" style="margin-left: -80px;">
            <div class="left-menu-width margin-top-15px col-lg-3 col-md-4 col-sm-5">
                <div class="left-rounded-box white-background" style="padding: 8px 5px 8px 8px;">
                    <div class="entered-finaos">
                        <ul>
                            <li ><a href="index.php?r=site/myfinaos" class="current">FINAOS</a></li>
                            <li><a href="index.php?r=site/mytiles">Tiles</a></li>
                            <li><a href="index.php?r=site/myposts">Posts</a></li>
                            <li><a href="index.php?r=site/myinspirations">Inspired</a></li>
                            <li><a href="index.php?r=site/imfollowing">Following</a></li>
                            <li><a href="index.php?r=site/myfollowers">Followers</a></li>
                        </ul>
                    </div>
                    <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <!--<p class="font-25px photos-videos">PHOTOS + VIDEOS</p>  -->
                    </div>
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
                                                    <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">                                                                    
                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
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
                                                        <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">
                                                            <img class="left-photos" src="<? echo $icon_path."nike.png"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
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
			    <?
                    if(is_array($finao_posts))
                    {
                        $pc = 0;
                        foreach($finao_posts as $finao_post)
                        {
                            if($finao_post->status == 1)
                            {
                                ++$pc;
                                if($pc == 1)
                                {
                                    ?>
                                        <div class="row  col-lg-11 col-md-11 col-sm-11 getback margin-20px" style="margin-left:25px;">
                                            <? echo $finao_post->finao_msg; ?>
                                        </div>
                                    <?
                                }
                                ?>
                                    <div class="row "  id="row_post<? echo $finao_post->uploaddetail_id; ?>">
                                        <div class="row col-lg-12 col-md-12 col-sm-12" style="margin: 15px 0px 10px -25px;"> 
                                            <a href="index.php?r=site/myprofile" class="font-black">
                                                <div class="col-md-1 col-sm-1" style="margin-right: 5px;">                                        
                                                    <img alt="Profile-image" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : "no-image.png") ?>"  class="post-image">
                                                </div>
                                                <div class="col-md-5 col-sm-6 margin-posted-name">
                                                    <span class="updated-by-post"><? echo ucwords($user_details->fname ." ". $user_details->lname); ?></span>                                            
                                                </div>
                                                <div class="col-md-3 col-sm-4 time-since-posted text-align-right text-fade" style="margin-right: -50px;">
                                                    <? echo $finao_post->updateddate;?>                                            
                                                </div>
                                            </a>                                        
                                        </div>
                                        <div class="col-lg-11 col-md-11 col-sm-11 margin-20px img-responsive">
                                            <?                                                
                                                $first = true;
                                                if(count($finao_post->videourls) == 0 && count($finao_post->image_urls) == 0)
                                                {
                                                    // do nothing
                                                }
                                                elseif((count($finao_post->videourls) + count($finao_post->image_urls)) == 1)
                                                {
                                                    if (count($finao_post->videourls) == 1)
                                                    {
                                                        foreach($finao_post->videourls as $video_url)
                                                        {
                                                            ?>
                                                                
                                                                    <table class="post-images-slider">
                                                                       <tr>
                                                                          <td align="left" valign="top">
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
                                                        foreach($finao_post->image_urls as $image_url)
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
                                                            <div class="carousel slide row" data-ride="carousel" data-interval="false" id="carousel<? echo $finao_post->uploaddetail_id; ?>">
                                                                <div class="carousel-inner "  style="margin-left:12px!important;">
                                                                    <?
                                                                        if(is_array($finao_post->image_urls))
                                                                        {
                                                                            foreach($finao_post->image_urls as $image_url)
                                                                            {
                                                                                ?>
                                                                                    <div class="item <? echo ($first ? "active" : ""); ?>" >                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 98.5%; background-repeat: no-repeat; background-position: center center; background-size: 100% auto;"/>
                                                                                    </div>
                                                                                <?
                                                                                $first = false;
                                                                            }
                                                                        }
                                                                        if(is_array($finao_post->videourls))
                                                                        {  
                                                                            foreach($finao_post->videourls as $video_url)
                                                                            {
                                                                                if($video_url != "")
                                                                                {
                                                                                    ?>
                                                                                        <div class="item <? echo ($first ? "active" : ""); ?>">
                                                                                            <table class="post-images-slider">
                                                                                               <tr>
                                                                                                  <td align="center" valign="top">
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
                                                                    if (count($finao_post->image_urls) > 0 || count($finao_post->videourls) > 0 )
                                                                    {   //echo (count($image_urls) . " - " .count($videourls));
                                                                        ?>
                                                                            <a class="left carousel-control" style="margin-left:12px!important;" href="#carousel<? echo $finao_post->uploaddetail_id; ; ?>" data-slide="prev">
                                                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                                            </a>
                                                                            <a class="right carousel-control"   href="#carousel<? echo $finao_post->uploaddetail_id; ; ?>" data-slide="next">
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
                                            <div class="row margin-5px">
                                                <span class="font-18px p-text">
                                                    <img alt="Icon-inspire" src="<? echo $icon_path."bulb.jpg";?>">
                                                    <? echo intval($finao_post->totalinspired); ?> 
                                                    people were inspired by your post.
                                                </span>
                                                <p class="font-18px post-caption">
                                                    <? echo $finao_post->upload_text; ?>
                                                </p>
                                                <div class="row col-md-12 col-sm-12">
                                                    <div class="left" id="finaostatus<? echo $finao_post->finao_id; ?>">
                                                        <?
                                                            echo ($finao_post->finao_status == 38 ? '<a id="link'. $finao_recent_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($finao_post->finao_status == 40 ? '<a href="#" id="link'. $finao_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="link'. $finao_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                        ?>
                                                        <ul class="dropdown-menu left dropbox dropbox following-dropdown" style="margin-top: 10px; margin-left: -30px;" role="menu"  >
                                                            <li style="margin-top: -9px; margin-right: 36%">
                                                                <div class="arrow1"></div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_post->finao_id; ?>,39,'finao_posts'); return false;" class=" button-ahead-green status-button" style="padding-left: 23px; padding-right: 23px;">AHEAD </a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_post->finao_id; ?>,38,'finao_posts'); return false;" class=" button-track status-button">ON TRACK</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_post->finao_id; ?>,40,'finao_posts'); return false;" class=" button-behind status-button" style="padding-left: 21px; padding-right: 22px;">BEHIND </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                        <img alt="Icon-share" src="<? echo $icon_path. "icon-share-options.png";?>" class="right text-align-right">                                                        
                                                    </a>
                                                    <ul class="dropdown-menu pull-right" style="margin-top: 5px; margin-right: -35px;">
                                                        <li>
                                                            <div class="arrow1"></div>
                                                        </li>

                                                        <li>
                                                            <div class=" text-align-left devider-header">
                                                                <span class="padding-left10px" style="margin-top: 5px;"><a href="#" onclick="sharepost(<? echo $finao_post->uploaddetail_id;?>,<? echo $finao_post->uploaddetail_id;?>); return false;">Share</a></span>
                                                            </div>
                                                        </li>                                                   
                                                        <li>
                                                            <div class="text-align-left">
                                                                <span class="padding-left10px link-log"><a href="#" onclick="deletepost(<? echo $finao_post->finao_id; ?>,<? echo $finao_post->uploaddetail_id; ?>,'finao_posts'); return false;">Delete Post</a></span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="margin-top-18px"></div>
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
                    if($finao_posts == false)
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
    include ("imagemodal.php");
    include_once("alert_modal.php");
?>
