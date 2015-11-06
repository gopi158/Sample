<?php
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal.php"); 
    include_once("public_post_snippet.php");
    //print_r($tile_posts);exit;
?>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("private_profile_details.php");?>
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="col-md-4 col-xs-5">
                <div class="left-rounded-box" style="padding: 8px 3px 8px 8px; background: #fff;">
                    <div class="entered-finaos">
                        <ul class="fade-text">
                            <li><a href="index.php?r=site/myfinaos">FINAOS</a></li>
                            <li><a href="index.php?r=site/mytiles">Tiles</a></li>
                            <li class="selected"><a href="index.php?r=site/myposts">Posts</a></li>
                            <li><a href="index.php?r=site/myinspirations">Inspired</a></li>
                            <li><a href="index.php?r=site/imfollowing">Following</a></li>
                            <li><a href="index.php?r=site/myfollowers">Followers</a></li>
                        </ul>
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
                                    if($finao_recent_post->status == 1)
                                    {  
                                        $has_data = false;
                                        if(is_array($finao_recent_post->image_urls))
                                        {                                                        
                                            foreach($finao_recent_post->image_urls as $image_url)
                                            {                              
                                                if ($image_url->image_url != "")
                                                {
                                                    ?>
                                                        <a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">                                                                    
                                                            <img class="left-photos" src="<? echo $image_path."blank.gif"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                        </a>
                                                    <?  
                                                    $has_data = true;
                                                    ++$j;
                                                    break;
                                                }
                                            }                                                               
                                        }
                                        if(!$has_data)
                                        {
                                            if(is_array($finao_recent_post->videourls))
                                            {                                                        
                                                foreach($finao_recent_post->videourls as $videourls)
                                                {                              
                                                    if ($image_url->image_url != "")
                                                    {
                                                        ?>                                                                    
                                                            <a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">
                                                                <img class="left-photos" src="<? echo $icon_path."nike.png"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                            </a>
                                                        <?
                                                        $has_data = true;
                                                        ++$j;
                                                        break;
                                                    }
                                                }                                                               
                                            }
                                        }  
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
                <? include_once ("footer.php"); ?>
            </div>
            <div class="col-md-8 col-xs-7">                
                 <?
                    if(is_array($tile_posts))
                    {
                        foreach($tile_posts as $tile_post)
                        {                                                 
                            if ($tile_post->status == 1)
                            {
                                render_public_post($user_details,
                                   $tile_post->uploaddetail_id, 
                                   $tile_post->userid,
                                   $tile_post->profile_image,
                                   "",
                                   $tile_post->uploadeddate,
                                   $tile_post->image_urls,
                                   $tile_post->finao_id,
                                   $tile_post->finao_msg,
                                   $tile_post->upload_text,
                                   $tile_post->finao_status,
                                   0,
                                   "",
                                   $tile_post->videourls,
                                   "",
                                   ""
                                );
                            }
                        }
                    }    
                 ?>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>
