<?
    include ("configuration/configuration.php");
    include_once("public_post_snippet.php");
    if(is_array($homepage_posts))
    {
        $pc = 0;                         
        foreach ($homepage_posts as $homepage_post)
        {
            //print_r($homepage_post);exit;
            ++$pc;
            render_public_post($user_details,
                               $homepage_post->uploaddetail_id, 
                               $homepage_post->updateby,
                               $homepage_post->profile_image,
                               $homepage_post->profilename,
                               $homepage_post->updateddate,
                               $homepage_post->image_urls,                                           
                               $homepage_post->finao_id,
                               $homepage_post->finao_msg,
                               $homepage_post->upload_text,
                               $homepage_post->finao_status,
                               $homepage_post->tile_id,
                               $homepage_post->videourls,
                               $homepage_post->videoimg,
                               $homepage_post->totalinspired,
                               $homepage_post->isinspired
                               );
            if($pc == $post_count)
            {
                break;
            }
        }
        ?>
            <div id="postscontainer"></div>
        <?
    }
    else
    {
        ?>
            <div class="popup-selected-finao ">
                <div class="row left-margin-home">
                    <div class="col-lg-11 col-md-11 col-sm-11 text-align-center" style="margin-top: 35%;  margin-bottom:60%;">
                        <p class="finao-title-text"><? echo $homepage_posts; ?></p>
                        <script>
                            $(function(){
                                posts_page = -1;
                            });
                                
                        </script>
                    </div>
                </div>
            </div>
        <?       
    }
?>