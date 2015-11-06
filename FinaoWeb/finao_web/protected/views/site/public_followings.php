<?php   
   // print_r($followings);exit;                                         
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php");
?>
<script>
  function sortfollowerbytiles(tile_id)
  {
      if(tile_id == "0")
      {
        $(".jq-tile-follower").show();
      }
      else
      {
          $(".jq-tile-follower").hide();
          $(".jq-tile-follower" + tile_id).show();
      }
  }
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("public_profile_details.php");?>         
        <div class="row" style="margin-left: -80px; margin-top:10px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <? include_once ("public_left_menu.php"); ?>
            </div>                          
            <? include_once ("footer.php"); ?>
            <div class="col-lg-7 col-md-6 col-sm-5">
                <div class="row">
                    <div class="left-rounded-box" style="padding-top: 10px; padding-left:10px margin-right: -60px;">
                            <? 
                                $tile_id = 0;
                                $tile_image = "";
                                if(is_array($followings))
                                {
                                    foreach($followings as $following)
                                    {
                                        if(is_array($following->tile_ids))
                                        {
                                            $class_str = "";
                                            foreach ($following->tile_ids as $tile)
                                            {
                                                $class_str .= " jq-tile-follower".$tile->tile_id;
                                            }
                                        }
                                        ?>
                                            <div class="popup-selected-finao popup-selected-finao-border jq-tile-follower <? echo $class_str; ?>" style="margin-left: 25px;">
                                                <div class="row">
                                                    <a href="index.php?r=site/public_finao_posts&uname=<? echo $following->uname; ?>" class="font-black">
                                                        <img alt="profile_image" src="<? echo ($following->image != "" ? $following->image : $image_path."no-image.png"); ?>" class="post-image" style="width:74px;">
                                                        <span class="font-18px updated-by-post profile-followers"><? echo ucwords($following->fname ." ". $following->lname); ?></span>
                                                    </a>
                                                    <div class="col-lg-5 col-md-5 right profile-followers-icons"> 
                                                        <?                                                              
                                                            if(is_array($following->tile_ids))
                                                            {
                                                                foreach ($following->tile_ids as $key => $tile)
                                                                {
                                                                    ?>
                                                                        <a href="index.php?r=site/tiles&tile_id=<? echo $tile->tile_id; ?>">
                                                                            <img alt="Icon" src="<? echo $following->tile_images[$key]->tile_image; ?>" style="width:20px; height:20px;">
                                                                        </a>
                                                                    <?
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?
                                    }
                                }
                            ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>