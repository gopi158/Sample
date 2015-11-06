<script>
    function openimagedialog(uploaddetail_id)
    {
        $(".bs-modal-sm"+uploaddetail_id).modal('show');
    }
    function getinspired_by_post_modal(uploaddetail_id)
    {
        //$("#ajax_loader").show();
        $.get("index.php?r=site/get_inspired_by_post&userpostid="+ uploaddetail_id,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                $("#inspiring_modal" + uploaddetail_id).html("");
                $("#inspiring_modal" + uploaddetail_id).html("inpspiring");
                show_alert("You are now inspired by this post.")
            }
            else if (data == "You are already inspired by this post!")
            {
                show_alert(data);
                $("#inspiring_modal" + uploaddetail_id).html("");
                $("#inspiring_modal" + uploaddetail_id).html("inpspired");
            }
        });
    }
</script>
<?
    include ("configuration/configuration.php");
?>

<?
    //print_r($public_user_posts);exit;
    if(is_array($public_user_posts))
    {
        $j = 0;
        foreach($public_user_posts as $public_user_post)
        {
            if($public_user_post->status == 1)
            {
                ?>
                   <div class="modal fade bs-modal-sm<? echo $public_user_post->uploaddetail_id; ?>" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-sm1">
                            <div class="modal-content">
                                <div class="text-align-right" style="margin: -15px;">
                                    <button type="button" class="close close-opacity no-border" onclick="closeit()" data-dismiss="modal" aria-hidden="true">
                                        <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">
                                    </button>
                                </div>
                                <div class="modal-header finao-margin">
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
                                                            <video controls type="video/mp4">
                                                                <source src="<? echo $video_url->videourl; ?>">                                                                                
                                                            </video> 
                                                        </div>
                                                    <?
                                                }
                                            }
                                            else
                                            {
                                                foreach($public_user_post->image_urls as $image_url)
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
                                                            if (count($public_user_post->image_urls) > 1 || count($public_user_post->videourls) >1 )
                                                            {   //echo (count($image_urls) . " - " .count($videourls));
                                                                ?>
                                                                    <a class="left carousel-control" href="#carousel<? echo $public_user_post->uploaddetail_id; ; ?>" data-slide="prev">
                                                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                                                    </a>
                                                                    <a class="right carousel-control" href="#carousel<? echo $public_user_post->uploaddetail_id; ; ?>" data-slide="next">
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
                                    <div class="row">
                                        <div class="finao-text col-md-8 col-sm-8">
                                            <img alt="Icon-finao" src="<? echo $icon_path."icon-finao.png"; ?>">
                                            <? echo $public_user_post->finao_msg; ?>
                                        </div>
                                        <div class="col-md-3 col-sm-3 text-fade finao-top-padding">
                                            <? echo $public_user_post->updateddate; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12">
                                        <p class="finao-title-text">
                                            <? echo $public_user_post->upload_text; ?>
                                        </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 finao-top-padding">
                                            <div class="row col-md-9 col-sm-10">
                                                <div id="modal_finaostatus<? echo $public_user_post->finao_id; ?>">
                                                    <?
                                                        echo ($public_user_post->finao_status == 38 ? '<a id="modal_link'. $public_user_post->finao_id .'" href="#" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>' : ($public_user_post->finao_status == 40 ? '<a href="#" id="modal_link'. $public_user_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>' : '<a href="#" id="modal_link'. $public_user_post->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>'));
                                                    ?>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8 text-right finao-top-padding">
                                            <div class=" col-md-9 col-sm-9  finao-share-options">
                                                <a href="#" class="dropdown-toggle status-button" data-toggle="dropdown">
                                                    <img alt="Icon-share" src="<? echo $icon_path. "/icon-share-options.png";?>">
                                                </a>
                                                <ul class="dropdown-menu pull-right" style="margin-top: 10px; margin-right:-25px;">
                                                    <li>
                                                        <div class="arrow1"></div>
                                                    </li>

                                                    <li>
                                                        <div class=" text-align-left  devider-header" style="margin-top: 5px;">
                                                            <span class="padding-left10px">
                                                                <a href="#" onclick="sharepost(<? echo $public_user_post->uploaddetail_id;?>,<? echo $public_user_post->finao_id;?>); return false;">Share</a>
                                                            </span>
                                                        </div>
                                                    </li>                                                       
                                                    <li>
                                                        <div class="text-align-left">
                                                            <span class="padding-left10px link-log"><a href="#" onclick="deletepost(<? echo $public_user_post->finao_id; ?>,<? echo $public_user_post->uploaddetail_id; ?>); return false;">Delete Post</a></span>
                                                        </div>
                                                    </li>
                                                </ul>                                                
                                                <div class="col-lg-1 col-md-2 col-sm-2 right"><a href="#" class="inspiring" id="<? echo "inspiring_modal". $public_user_post->uploaddetail_id; ?>" onclick="getinspired_by_post_modal(<? echo $public_user_post->uploaddetail_id; ?>); return false;">Inspired</a></div>
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