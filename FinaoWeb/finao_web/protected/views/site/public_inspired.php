<?php
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php"); 
    include_once("public_post_snippet.php");
    //print_r($public_inspired_posts);exit;
?>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("public_profile_details.php");?>
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <? include_once ("public_left_menu.php"); ?>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-5 margin-home-content-naveigarion">                
                 <?
                    if(is_array($public_inspired_posts))
                    {
                        foreach($public_inspired_posts as $public_inspired_post)
                        {
                            if ($public_inspired_post->status == 1)
                            {
                                render_public_post($user_details,
                                                   $public_inspired_post->uploaddetail_id, 
                                                   $public_inspired_post->user_id,
                                                   $public_inspired_post->profileimg,
                                                   $public_inspired_post->name,
                                                   $public_inspired_post->updateddate,
                                                   $public_inspired_post->image_urls,
                                                   $public_inspired_post->finao_id,
                                                   $public_inspired_post->finao_msg,
                                                   $public_inspired_post->upload_text,
                                                   $public_inspired_post->finao_status,
                                                   0,
                                                   $public_inspired_post->tile_image,
                                                   $public_inspired_post->videourls,
                                                   $public_inspired_post->video_img,
                                                   $public_inspired_post->totalinspired);
                            }
                        }
                        //old rendering method:
                        foreach($public_inspired_posts as $public_inspired_post)
                        {
                            break;
                            if($public_inspired_post->status == 1)
                            {
                                ?>
                                    <div class="row col-md-12 col-sm-12" style="margin: 0px 0px 10px -30px;">
                                        <a href="index.php?r=site/public_finao_posts&uname=<? echo $public_inspired_post->uname; ?>">
                                            <div class="col-md-1 col-sm-1" style="margin-right: 5px;">
                                                <img alt="Profile-image" src="<? echo ($public_inspired_post->profileimg != "" ? $public_inspired_post->profileimg : $image_path."no-image.png"); ?>"  class="post-image">                                            
                                            </div>
                                            <div class="col-md-5 col-sm-6 margin-posted-name margin-top-10px">
                                                <span class="updated-by-post"><? echo ucwords($public_inspired_post->name); ?></span>
                                            </div>
                                        </a> 
                                        <div class="col-md-3 col-sm-4 time-since-posted right text-fade margin-top-10px" style="margin-right: -50px;">                                            
                                            <? echo $public_inspired_post->updatedate; ?>
                                        </div>
                                    </div>
                                    <div class="row margin-20px" style="margin-left: 0px;">
                                        <div class="col-md-11 col-sm-11 img-responsive">
                                            <div id="carousel-example-generic" class="carousel slide row" data-ride="carousel">
                                                <ol class="carousel-indicators">
                                                    <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                                                        <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                                                        <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                                                </ol>
                                                <div class="carousel-inner">
                                                    <div class="item">
                                                        <img alt="Post-image" src="content/images/fireworks.png">
                                                    </div>
                                                    <div class="item active ">
                                                        <img alt="" src="content/images/finao-sample-img.jpg">
                                                    </div>
                                                    <div class="item  ">
                                                        <img alt="" src="content/images/finao-sample-img.jpg">
                                                    </div>
                                                </div>
                                                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                </a>
                                                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div> 
                                  
                                <?
                            }
                        }
                    }
                    if($public_inspired_posts == false)
                    {
                        ?>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 col-md-12">
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
