<?php                                            
    include ("header.php");
    include ("configuration/configuration.php");
    include ("imagemodal_public.php");
?>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("public_profile_details.php");?>         
        <div class="row" style="margin-left: -80px">
            <div class="col-lg-3 col-md-4 col-sm-5">
                <? include_once ("public_left_menu.php"); ?>
            </div>                          
            <? include_once ("footer.php"); ?>
            <div class="col-lg-7 col-md-7 col-sm-6">
                <div class="row">
                    <div class="left-rounded-box" style="padding-top: 10px; margin-right: -60px;">
                            <? 
                                if(is_array($followers))
                                {
                                    foreach($followers as $follower)
                                    {
                                        ?>
                                            <div class="popup-selected-finao popup-selected-finao-border jq-tile-follower jq-tile-follower<? echo $follower->tile_id; ?>" style="margin-left: 25px;">
                                                <div class="row">
                                                    <a href="index.php?r=site/public_finao_posts&uname=<? echo $follower->uname; ?>" class="font-black">
                                                        <img alt="Profile-image" src="<? echo ($follower->image != "" ? $follower->image : $image_path."no-image.png"); ?>" class="img-border" style="width:74px;">
                                                        <span class="font-18px profile-followers"><? echo ucwords($follower->fname ." ". $follower->lname); ?></span>
                                                    </a>
                                                    <div class="col-lg-1 col-md-1 right profile-followers-icons"> 
                                                      <img alt="Icon" src="<? echo $icon_path."school.png"; ?>">
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