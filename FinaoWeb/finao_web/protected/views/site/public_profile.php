<?php
    //print_r($public_user_posts);exit;
    include ("header.php");
    include ("configuration/configuration.php");
    //include ("imagemodal_public.php");
?>
<script>
    function getinspired_by_post(userpostid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/get_inspired_by_post&userpostid="+ userpostid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                //$("#inspiring" + userpostid).html("");
                $("#inspiring" + userpostid).html("Inpspiring");
            }
            else if (data == "You are already inspired by this post!")
            {
                show_alert(data);
                $("#inspiring" + userpostid).html("");
                $("#inspiring" + userpostid).html("Inspired");
            }
        });
    }
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("public_profile_details.php");?>
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <? include_once ("public_left_menu.php"); ?>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
                <?
                    if(is_array($public_user_posts))
                    {
                        $pc = 0;
                        foreach($public_user_posts as $public_user_post)
                        {
                            if($public_user_post->status == 1)
                            {
                                ++$pc;
                                ?>
                                    <div class="row col-lg-12 col-md-12 col-sm-12" style="margin: 0px 0px 10px -30px;">
                                        <a href="index.php?r=site/public_profile&uname=<? echo $public_profile_details->uname; ?>" class="font-black">
                                            <div class="col-md-1 col-sm-1" style="margin-right: 5px;">
                                                <img alt="Profile-image" src="<? echo ($public_profile_details->profile_image != "" ? $public_profile_details->profile_image : $image_path . "no-image.png"); ?>"  class="post-image"> 
                                            </div>
                                            <div class="col-md-5 col-sm-6 margin-posted-name " >
                                                <span class="updated-by-post">                                                
                                                        <? echo ucwords($public_profile_details->fname ." ".$public_profile_details->lname); ?>                                                
                                                </span>
                                            </div>
                                        </a>
                                        <div class="col-md-3 col-sm-4 time-since-posted right text-fade" style="margin-right: -50px;">
                                            <? echo ($public_user_post->updateddate); ?>
                                        </div>
                                        <div class="row col-lg-11 col-md-11 col-sm-11 margin-finao-text">
                                            <p class="finao-title-text post-finaos font-18px">
                                                <img alt="Icon-finao" src="<? echo $icon_path. "icon-finao.png";?>"/>                                                                                               
                                                <? echo $public_user_post->finao_msg; ?>                                            
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row margin-20px margin-left-0px">
                                        <div class="col-md-11 col-sm-11 img-responsive">
                                            <?
                                                $first = true;
                                                if(count($public_user_post->videourls) == 0 && count($public_user_post->image_urls) == 0)
                                                {
                                                    // do nothing
                                                }
                                                elseif((count($public_user_post->videourls) + count($public_user_post->image_urls)) == 1)
                                                {
                                                    if (count($public_user_post->videourls) == 1)
                                                    {
                                                        foreach($public_user_post->videourls as $video_url)
                                                        {
                                                            ?>
                                                                <div style="height:600px; width:auto; background: #161618;" align="center">
                                                                    <table style="height: 600px; width: 100%;">
                                                                       <tr>
                                                                          <td align="center" valign="middle">
                                                                            <video controls style="max-height :600px; max-width :600px;">
                                                                                <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                                            </video> 
                                                                          </td>
                                                                       </tr>
                                                                    </table>> 
                                                                </div>
                                                            <?
                                                        }
                                                    }
                                                    else
                                                    {
                                                        foreach($public_user_post->image_urls as $image_url)
                                                        {
                                                            ?>
                                                                <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: top center; background-size: 100% auto;"/>
                                                            <?
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    ?>
                                                        <div class="row uploaded-finao-image mycarousel">
                                                            <div class="carousel slide row" data-ride="carousel" data-interval="false" id="carousel<? echo $public_user_post->uploaddetail_id; ?>">
                                                                <div class="carousel-inner">
                                                                    <?
                                                                        if(is_array($public_user_post->image_urls))
                                                                        {
                                                                            foreach($public_user_post->image_urls as $image_url)
                                                                            {
                                                                                ?>
                                                                                    <div class="item <? echo ($first ? "active" : ""); ?>" >                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: center center; background-size: 100% auto;"/>
                                                                                    </div>
                                                                                <?
                                                                                $first = false;
                                                                            }
                                                                        }
                                                                        if(is_array($public_user_post->videourls))
                                                                        {  
                                                                            foreach($public_user_post->videourls as $video_url)
                                                                            {
                                                                                ?>
                                                                                    <div class="item <? echo ($first ? "active" : ""); ?>">
                                                                                        <table style="height: 600px; width: 100%;">
                                                                                           <tr>
                                                                                              <td align="center" valign="middle">
                                                                                                <video controls style="max-height :600px; max-width :600px;">
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
                                                                    ?>
                                                                </div>
                                                                <?
                                                                    if (count($public_user_post->image_urls) > 1 || count($public_user_post->videourls) >1 )
                                                                    {   //echo (count($image_urls) . " - " .count($videourls));
                                                                        ?>
                                                                            <a class="left carousel-control" href="#carousel<? echo $public_user_post->uploaddetail_id; ?>" data-slide="prev">
                                                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                                            </a>
                                                                            <a class="right carousel-control" href="#carousel<? echo $public_user_post->uploaddetail_id; ?>" data-slide="next">
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
                                            <div class="row col-lg-12 col-md-12 col-sm-12" style="margin-top:5px; margin-left:-30px!important;">
                                                <p class="font-18px post-caption"><? echo $public_user_post->upload_text; ?></p>
                                            </div>
                                            <!--ss-->
                                            <div class="row col-md-12 col-sm-12" style="margin-top:5px; margin-left:-30px!important;">
                                                <div class="row col-lg-5 col-md-5 col-sm-5" id="finaostatus<? echo $public_user_post->finao_id; ?>">
                                                    <?
                                                        echo ($public_user_post->finao_status == 38 ? '<a id="link'. $public_user_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($public_user_post->finao_status == 40 ? '<a href="#" id="link'. $public_user_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="link'. $public_user_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                    ?>                                                
                                                </div>
                                              <div class="col-lg-6 col-md-5 col-sm-4">
                                              <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                    <img alt="Icon-share" src="<? echo $icon_path. "icon-share-options.png";?>" class="right">                                                        
                                                </a>
                                                
                                                <ul class="dropdown-menu pull-right" style="margin-top: 7px; margin-right: -35px;">
                                                    <li>
                                                        <div class="arrow1"></div>
                                                    </li>
                                                    <li>
                                                        <div class="text-align-left devider-header">
                                                            <span class="padding-left10px"><a href="#" onclick="follow_travel_tile(<? echo $public_user_post->updateby;?>,<? echo $public_user_post->tile_id;?>); return false;">Follow Tile</a></span>
                                                        </div>
                                                    </li>  
                                                    <li>
                                                        <div class="text-align-left devider-header">
                                                            <span class="padding-left10px"><a href="#" onclick="mark_inappropriate_post(<? echo $public_user_post->uploaddetail_id;?>); return false;">Flag as Inappropriate</a></span>
                                                        </div>
                                                    </li>                                                    
                                                </ul>
                                                </div>
                                                <div class="col-lg-1 col-md-2 col-sm-2 right"><a href="#" class="inspiring" id="<? echo "inspiring". $public_user_post->uploaddetail_id; ?>" onclick="getinspired_by_post(<? echo $public_user_post->uploaddetail_id; ?>); return false;">Inspired</a></div>
                                            </div>
                                          <!--ss-->
                                        </div>
                                    </div> 
                                <?
                            }
                            if($pc == $post_count)
                            {
                                break;
                            }
                        }
                    }
                    if($public_user_posts == false)
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
    include_once("alert_modal.php");
?>