<div class="row">        
    <img src="<? echo $image_path."blank.gif"; ?>" alt="Banner-image" style="background-image: url('<? echo ($user_details->banner_image != "" ? $user_details->banner_image : $image_path."no-image-banner.jpg"); ?>');" class="width100 img-responsive profile-banner">
</div>
<div class="content-wrapper">
    <div class="row col-md-12 col-sm-12" style="margin-bottom:15px;">
        <div class="col-lg-3 col-md-3 col-sm-3">
            
                <img alt="Profile-image" src="<? echo ($user_details->profile_image != "" ? "".$user_details->profile_image : $image_path."no-image.png"); ?>"  class="img-border profile_image img-responsive">
          
        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-custom-sm-pull-45">
            <div class="row">
                <span class="font-25px margin-to-5px updated-by">
                    <a href="index.php?r=site/myprofile" class="font-black">
                        <? echo ucwords($user_details->fname ." ". $user_details->lname); ?>
                    </a>
                </span>
                <p class="font-18px bio-message">
                    <? echo $user_details->mystory; ?>
                </p>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-9" style="margin-left: -30px;">
                    <div class="col-md-2 col-sm-2 profile-finaos  profile-finaos-font border-right">
                        <p class="font-18px static-title"><a href="index.php?r=site/myfinaos">FINAOs</a></p>
                        <p class="orange font-25px static-numbers"><? echo $user_details->totalfinaos; ?></p>
                    </div>
                    <div class="col-md-2 col-sm-2 profile-finaos profile-finaos-font border-right">
                        <p class="font-18px static-title"><a href="index.php?r=site/mytiles">TILES</a></p>
                        <p class="orange font-25px static-numbers"><? echo $user_details->totaltiles; ?></p>
                    </div>
                    <div class="col-md-3 col-sm-3 profile-finaos profile-finaos-font border-right">
                        <p class="font-18px static-title"><a href="index.php?r=site/imfollowing">FOLLOWING</a></p>
                        <p class="orange font-25px static-numbers"><? echo $user_details->totalfollowings; ?></p>
                    </div>
                    <div class="col-md-3 col-sm-3 profile-finaos profile-finaos-font border-right">
                        <p class="font-18px static-title"><a href="index.php?r=site/myfollowers">FOLLOWERS</a></p>
                        <p class="orange font-25px static-numbers"><? echo $user_details->totalfollowers; ?></p>
                    </div>
                    <div class="col-md-2 col-sm-2 profile-finaos profile-finaos-font">
                        <p class="font-18px static-title"><a href="index.php?r=site/myinspirations">INSPIRED</a></p>
                        <p class="orange font-25px static-numbers"><? echo $user_details->totalinspired; ?></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-3 col-sm-push-1" >
                    <a href="index.php?r=site/edit_profile" class=" right status-button-ontrack button-myprofile font-15px">EDIT MY PROFILE</a>
                </div>
            </div>
        </div>
    </div>
</div>