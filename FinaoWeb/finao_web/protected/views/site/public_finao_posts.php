<?php
    //print_r($public_profile_details);exit;
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php");
?>
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
                                if($pc == 1)
                                {
                                    ?>
                                        <div class="row  col-lg-11 col-md-11 col-sm-11 getback margin-20px" style="margin-left:25px;">
                                            <? echo $public_user_post->finao_msg; ?>
                                        </div>
                                    <?
                                }
                                ?>
                                    <div class="row col-md-12 col-sm-12" style="margin: 0px 0px 10px -30px;">
                                        <a href="index.php?r=site/public_finao_posts&uname=<? echo $public_profile_details->uname; ?>" class="font-black">
                                            <div class="col-lg-1 col-md-1 col-sm-1" style="margin-right: 5px;">
                                                <img alt="Profile-image" src="<? echo ($public_profile_details->profile_image != "" ? $public_profile_details->profile_image : $image_path . "no-image.png"); ?>"  class="post-image"> 
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-6 margin-posted-name margin-top-10px">
                                                <span class="updated-by-post">                                                
                                                        <? echo ucwords($public_profile_details->fname ." ".$public_profile_details->lname); ?>
                                                </span>
                                            </div>
                                        </a>
                                        <div class="col-lg-3 col-md-5 col-sm-5 time-since-posted right text-fade margin-top-10px" style="margin-right: -50px;">
                                            <? echo ($public_user_post->updateddate); ?>
                                        </div>
                                    </div>
                                    <div class="row margin-20px" style="margin-left: 0px; margin-top: 20px;">
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
                                                                
                                                                    <table class="post-images-slider">
                                                                       <tr>
                                                                          <td align="center" valign="middle">
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
                                                                                       <table style="height: 620px; width: 620px;">
                                                                                           <tr>
                                                                                              <td align="center" valign="middle">
                                                                                                <video controls style="max-height :620px; max-width :620px;">
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
                                        </div>
                                        <div class="row col-lg-12 col-md-12 col-sm-12">
                                            <span class="font-18px p-text">
                                                <img alt="Icon-inspire" src="<? echo $icon_path."bulb.jpg";?>">
                                                <? echo intval($public_user_post->totalinspired); ?> 
                                                people were inspired by your post.
                                            </span>
                                            
                                            <p class="post-caption font-18px">
                                                <? echo $public_user_post->upload_text; ?> 
                                            </p>
                                            <div class="row col-lg-12 col-md-12 col-sm-12">
                                                <div class="row col-lg-4 col-md-4 col-sm-4" id="finaostatus<? echo $public_user_post->finao_id; ?>">
                                                    <?
                                                        echo ($finao_recent_post->finao_status == 38 ? '<a id="link'. $finao_recent_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($finao_recent_post->finao_status == 40 ? '<a href="#" id="link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                    ?>
                                                </div>
                                              <div class="col-lg-8 col-md-8 col-sm-8  right">

                                                <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                  <img alt="Icon-share" class="right" src="<? echo $icon_path. "icon-share-options.png";?>">
                                                </a>
                                                <ul class="dropdown-menu pull-right" style="margin-top: 7px; margin-right: -35px;">                                                                                        
                                                    <li>
                                                        <div class="arrow1"></div>
                                                    </li>
                                                     <?
                                                        if (intval($tile_id) > 0)
                                                        {
                                                            ?>
                                                                <li class="devider-header">
                                                                    <div class="text-align-left">
                                                                        <span class="padding-left10px"><a href="#" onclick="follow_travel_tile(<? echo $public_user_post->userid ;?>,<? echo $tile_id;?>); return false;">Follow Tile</a></span>
                                                                    </div>
                                                                </li>
                                                            <?
                                                        }
                                                    ?>
                                                    <li class="devider-header">
                                                        <div class="text-align-left">
                                                            <span class="padding-left10px"><a href="#" onclick="mark_inappropriate_post(<? echo $public_user_post->uploaddetail_id;?>); return false;">Flag as Inappropriate</a></span>
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
                                                </ul>
                                              </div>
                                            </div>
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
                                <div class="col-lg-9 col-sm-10 col-md-12">
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