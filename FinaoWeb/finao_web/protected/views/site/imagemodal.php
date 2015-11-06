<script>
    function openimagedialog(uploaddetail_id)
    {
        $(".bs-modal-sm"+uploaddetail_id).modal('show');
    }
     $(function(){
        $(".modal_corousel").each(function(){
           $(this).find("div.item").last().addClass("active");  
        });
    });
</script>
<?
    include ("configuration/configuration.php");
    //print_r($image_modal_item_arr);exit;
?>
<?
        if(is_array($finao_recent_posts))
        { 
            foreach($finao_recent_posts as $finao_recent_post)
            {
                if($finao_recent_post->status == 1)
                {                                                              
                    ?>
                        <div class="modal fade bs-modal-sm<? echo $finao_recent_post->uploaddetail_id; ?>" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-sm1">
                                <div class="modal-content">
                                    <div class="text-align-right" style="margin: -15px;">
                                        <button type="button" class="close close-opacity no-border" onclick="close_imagemodal();" data-dismiss="modal" aria-hidden="true">
                                            <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">
                                        </button>
                                    </div>
                                    <div class="modal-body finao-margin">
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
                                                            <div style="height:600px; width:auto; background: #161618;" align="center">
                                                                <video controls type="video/mp4">
                                                                    <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                                </video> 
                                                            </div>
                                                        <?
                                                    }
                                                }
                                                else
                                                {
                                                    foreach($finao_recent_post->image_urls as $image_url)
                                                    {
                                                        ?>
                                                            <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: center center; background-size: 100% auto;"/>
                                                        <?
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                ?>
                                                    <div class="row uploaded-finao-image mycarousel">
                                                        <div class="carousel slide row" data-ride="carousel" data-interval="false" id="carousel<? echo $finao_recent_post->uploaddetail_id; ?>">
                                                            <div class="carousel-inner">
                                                                <?
                                                                    if(is_array($finao_recent_post->image_urls))
                                                                    {
                                                                        foreach($finao_recent_post->image_urls as $image_url)
                                                                        {
                                                                            ?>
                                                                                <div class="item <? echo ($first ? "active" : ""); ?>" >                                                                                                                                                                                                                                                                                                                                                                                                    
                                                                                    <img class="left-photos" src="<? echo $image_path."blank.gif"; ?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 600px; width: 100%; background-repeat: no-repeat; background-position: center center; background-size: 100% auto;"/>
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
                                                                                        <div style="height:600px; width:auto; background: #161618;" align="center">
                                                                                            <video controls type="video/mp4">
                                                                                                <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                                                            </video> 
                                                                                        </div>
                                                                                    </div>
                                                                                <?
                                                                                $first = false;
                                                                            }                                                                                
                                                                        }
                                                                    }                                                                        
                                                                ?>
                                                            </div>
                                                            <?
                                                                if (count($finao_recent_post->image_urls) > 1 || count($finao_recent_post->videourls) >1 )
                                                                {   //echo (count($image_urls) . " - " .count($videourls));
                                                                    ?>
                                                                        <a class="left carousel-control" href="#carousel<? echo $finao_recent_post->uploaddetail_id; ; ?>" data-slide="prev">
                                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                                        </a>
                                                                        <a class="right carousel-control" href="#carousel<? echo $finao_recent_post->uploaddetail_id; ; ?>" data-slide="next">
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
                                         <div class="row margin-top-10px col-lg-12 col-sm-12 col-md-12">
                                            <div class=" post-finaos font-15px col-lg-9 col-md-9 col-sm-9">
                                                <img alt="Icon-finao" src="<? echo $icon_path."icon-finao.png"; ?>">
                                                <? echo $finao_recent_post->finao_msg; ?>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 text-fade time-since-posted text-align-right margin-left-0px">
                                                <? echo $finao_recent_post->updateddate; ?>
                                            </div>
                                        </div>
                                        <div class="margin-5px col-lg-12 col-md-12 col-sm-12">
                                            <p class="post-caption">
                                                <? echo $finao_recent_post->upload_text; ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 finao-top-padding">
                                                <div class="row col-md-9 col-sm-10">
                                                    <div id="modal_finaostatus<? echo $finao_recent_post->finao_id; ?>">
                                                        <?
                                                            echo ($finao_recent_post->finao_status == 38 ? '<a id="modal_link'. $finao_recent_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($finao_recent_post->finao_status == 40 ? '<a href="#" id="modal_link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="modal_link'. $finao_recent_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                        ?>
                                                        <ul class="dropdown-menu left dropbox dropbox following-dropdown" style="margin-top: 12px; margin-left: -20px;" role="menu">
                                                            <li style="margin-top: -9px; margin-right: 36%">
                                                                <div class="arrow1"></div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,39,'modal'); return false;" class=" button-ahead-green status-button" style="padding-left: 23px; padding-right: 23px;">AHEAD </a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,38,'modal'); return false;" class=" button-track status-button">ON TRACK</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="dropdown-menu-padding">
                                                                    <a href="#" onclick="change_finao_status(<? echo $finao_recent_post->finao_id; ?>,40,'modal'); return false;" class=" button-behind status-button" style="padding-left: 21px; padding-right: 18px;">BEHIND </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 text-right finao-top-padding">
                                                <div class=" col-md-9 col-sm-9 right finao-share-options">
                                                    <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                        <img alt="Icon-share" src="<? echo $icon_path. "/icon-share-options.png";?>">
                                                    </a>
                                                    <ul class="dropdown-menu pull-right" style="margin-top: 8px; margin-right:-25px;">
                                                        <li>
                                                            <div class="arrow1"></div>
                                                        </li>

                                                        <li>
                                                            <div class=" text-align-left  devider-header" style="margin-top: 5px;">
                                                                <span class="padding-left10px">
                                                                    <a href="#" onclick="sharepost(<? echo $finao_recent_post->uploaddetail_id;?>,<? echo $finao_recent_post->finao_id;?>); return false;">Share</a>
                                                                </span>
                                                            </div>
                                                        </li>                                                       
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
                                </div>
                            </div>
                        </div>                        
                    <?
                }
            }
        }
        else
        {
            
        }
    ?>
<?
    //include_once("alert_modal.php");
?>