<script>
    function getinspired_by_post(userpostid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/get_inspired_by_post&userpostid="+ userpostid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                $("#inspiring" + userpostid).html("");
                $("#inspiring" + userpostid).html("Inspired");
            }
            else if (data = "You are already inspired by this post!")
            {
                //$("#inspiring" + userpostid).html("");
                //$("#inspiring" + userpostid).html("inpspired");
            }
        });
    }
    $(function(){
        $(".mycorousel").each(function(){
           $(this).find("div.item").last().addClass("active");  
        });
    });
</script>
<?
    include ("configuration/configuration.php");
    function render_public_post($user_details, $uploaddetail_id, $updateby, $profile_image, $profilename, $updateddate, $image_urls, $finao_id, $finao_msg, $upload_text, $finao_status, $tile_id = 0, $videourls, $video_img = "", $totalinspired = 0, $isinspired)
    {
        include ("configuration/configuration.php");
        ?>
            <div class="popup-selected-finao" id="row<? echo $uploaddetail_id; ?>">
                <div class="row left-margin-home">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <a href="index.php?r=site/public_finao_posts&uname=<? echo $updateby; ?>">
                            <div class="col-lg-2 col-md-2 col-sm-1" style="margin-right: 0px;">
                                <img alt="Profile-image" src="<? echo ($profile_image !="" ? $profile_image : "no-image.png") ?>" class="post-image">
                            </div>
                            <div class="col-lg-3 col-md-5 col-sm-6">
                                <span class="updated-by-post margin-posted-name-inspired"><? echo $profilename; ?></span>
                            </div>
                        </a>
                        <div class="col-lg-3 col-md-4 col-sm-4 time-since-posted text-align-right text-fade" style="margin-right:-40px;">
                            <? echo $updateddate; ?>
                        </div>
                        <div class="row col-lg-11 col-md-11 col-sm-11 margin-finao-text">
                          <p class="finao-title-text post-finaos font-18px seek-sm-finaos">
                          <img alt="Icon-finao"  src="<? echo $icon_path. "icon-finao.png";?>">
                                <? echo $finao_msg; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <div>
             <!--<p class="finao-title-text">
                    <img alt="Icon-finao" src="<? echo $icon_path. "icon-finao.png";?>">
                    <? echo $finao_msg; ?>
             </p>-->
            </div>
            <?
                $first = true;
                if(count($videourls) == 0 && count($image_urls) == 0)
                {
                    // do nothing
                }
                elseif((count($videourls) + count($image_urls)) == 1)
                {
                    if (count($videourls) == 1)
                    {
                        foreach($videourls as $video_url)
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
                        foreach($image_urls as $image_url)
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
                            <div class="carousel slide row" data-ride="carousel" data-interval="false" id="carousel<? echo $uploaddetail_id; ?>">
                                <div class="carousel-inner">
                                    <?
                                        if(is_array($videourls))
                                        {  
                                            foreach($videourls as $video_url)
                                            {
                                                ?>
                                                    <div class="item <? echo ($first ? "active" : ""); ?>">
                                                        <table style="height: 620px; 620px;">
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
                                        if(is_array($image_urls))
                                        {
                                            foreach($image_urls as $image_url)
                                            {
                                                ?>
                                                    <div class="item <? echo ($first ? "active" : ""); ?>" >                                                                                                                                                                                                                                                                                                                                                                                                    
                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: top center; background-size: 100% auto;"/>
                                                    </div>
                                                <?
                                                $first = false;
                                            }
                                        }
                                    ?>
                                </div>
                                <?
                                    if (count($image_urls) > 1 || count($videourls) >1 )
                                    {   //echo (count($image_urls) . " - " .count($videourls));
                                        ?>
                                            <a class="left carousel-control" href="#carousel<? echo $uploaddetail_id; ?>" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                            </a>
                                            <a class="right carousel-control" href="#carousel<? echo $uploaddetail_id; ?>" data-slide="next">
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
            <div class="col-lg-12 col-md-12 col-sm-12 right  popup-selected-finao-border ">
                <div class="row left-margin-home">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <p class="font-18px post-caption"><? echo $upload_text; ?></p>
                    </div>
                </div>
                <div class="row left-margin-home margin-20px">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <?
                            echo ($finao_status == 38 ? '<a href="#" data-toggle="dropdown" class="dropdown-toggle button-track finao-status-home">ON TRACK</a>' : ($finao_status == 40 ? '<a href="#" data-toggle="dropdown" class="dropdown-toggle button-behind finao-status-home">BEHIND</a>' : '<a href="#" data-toggle="dropdown" class="dropdown-toggle button-ahead finao-status-home">AHEAD</a>'));
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 text-right">
                        <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                            <img alt="Icon-share" src="<? echo $icon_path. "icon-share-options.png";?>">
                        </a>
                        <ul class="dropdown-menu pull-right" style="margin-top: 10px; margin-right: 50px;">
                            <li>
                                <div class="arrow2"></div>
                            </li>
                            <li style="<? echo ($updateby != $user_details->userid ? "display:none;" : "");?>" class="devider-header">
                                <div class=" text-align-left">
                                    <span class="padding-left10px" style="margin-top:5px;">
                                        <a href="#" onclick="sharepost(<? echo $uploaddetail_id; ?>,<? echo $finao_id;?>); return false;">Share</a>
                                    </span>
                                </div>
                            </li>
                            <?
                                if (intval($tile_id) > 0)
                                {
                                    ?>
                                        <li class="devider-header">
                                            <div class="text-align-left">
                                                <span class="padding-left10px"><a href="#" onclick="follow_travel_tile(<? echo $updateby;?>,<? echo $tile_id;?>); return false;">Follow Tile</a></span>
                                            </div>
                                        </li>
                                    <?
                                }
                            ?>
                            <li class="devider-header">
                                <div class="text-align-left">
                                    <span class="padding-left10px"><a href="#" onclick="mark_inappropriate_post(<? echo $uploaddetail_id;?>); return false;">Flag as Inappropriate</a></span>
                                </div>
                            </li>
                        </ul>
                        <?
                            if($isinspired == 1)
                            {
                                ?>
                                    <a href="#" id="<? echo "inspiring". $uploaddetail_id; ?>" class="inspiring" style="<? echo ($updateby == $user_details->userid ? "display:none;" : "");?>">Inspired</a>
                                <?
                            }
                            else
                            {
                                ?>
                                    <a href="#" id="<? echo "inspiring". $uploaddetail_id; ?>" class="inspiring" style="<? echo ($updateby == $user_details->userid ? "display:none;" : "");?>" onclick="getinspired_by_post(<? echo $uploaddetail_id; ?>); return false;">Inspiring</a>
                                <?
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?
    }
?>