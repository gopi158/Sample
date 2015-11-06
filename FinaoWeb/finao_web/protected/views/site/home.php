<?
    //print_r(($who_to_follows));exit;
    include ("header.php");
    include ("configuration/configuration.php");
    include_once("public_post_snippet.php");
?> 
<script>
   // function getinspired_by_post(userpostid)
//    {
//        $("#ajax_loader").show();
//        $.get("index.php?r=site/get_inspired_by_post&userpostid="+ userpostid,function(data){
//            $("#ajax_loader").hide();
//            if (data == "success")
//            {
//                show_alert("You are now inspired by this post.")
//            }
//            else if (data = "You are already inspired by this post!")
//            {
//                show_alert(data);
//            }
//        });
//    }
    
    function mark_inappropriate_post(userpostid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/mark_inappropriate_post&userpostid="+ userpostid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {   
                show_alert("Post is inappropriated.");
                $("#row"+ userpostid).remove();
            }
            else
            {
                show_alert(data);
            }
        });
    }
    
    function sharepost(userpostid,finaoid)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/sharepost&userpostid="+ userpostid + "&finaoid="+ finaoid,function(data){
            $("#ajax_loader").hide();
            if (data == "success")
            {
                show_alert("Post is shared successfully.")
            }
            else
            {
                show_alert(data);   
            }
        });
    }
    
    function follow_travel_tile(followeduserid, tileid)
    {                                         
        $("#ajax_loader").show(); 
        $.get("index.php?r=site/followuser&followeduserid="+ followeduserid +"&tileid="+ tileid,function(data){
            $("#ajax_loader").hide();
            var result = $.parseJSON(data);
            if(result["return"] = "success")
            {
                show_alert("You are now following this tile.")
            }
            else
            {
                show_alert(result["return"]);   
            }            
        });
    }
    var posts_page = 0;
    var loading_posts = false;
    function loadPosts()
    {
        if (posts_page < 0)
            return;
        if (!loading_posts)
        {
            loading_posts = true;
            posts_page++;
            $("#postscontainer").html('<div style="text-align:center; padding-top:35%; padding-bottom:60%;"><img src="content/images/icons/fast-loader.gif" /><br/>Loading...</div>');
            $.get("index.php?r=site/homepostsmarkup&page=" + posts_page, function(data){
                loading_posts = false;
                $("#postscontainer").replaceWith(data);
            });
        }
    }
    $(function(){
        loadPosts();
    })
    $(window).scroll(function(){
        if($(window).scrollTop() == $(document).height() - $(window).height()){
            loadPosts();
        }
    }); 
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 40px">
        <div class="row">		
                           <div class="col-lg-4 col-md-5 col-sm-6" style="margin-left: -60px; ">
                        <div class="content-wrapper-left">
                            <div class="profile-finao-details sidebar-background left-rounded-box">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                    <img alt="Profile-image" src="<? echo ($user_details->profile_image != "" ? "".$user_details->profile_image : $image_path."no-image.png"); ?>"  class="home-image img-border">
                                
                            </div>
                           <div class="row margin-top-18px">
                                        <div class="col-lg-2 col-lg-2 col-md-2 col-sm-2 "  style="margin-left: 5px;">
                                    <div class="profile-finaos ">
                                        <p class="font-15px profile-finaos-sidebar"><a href="index.php?r=site/myfinaos" style="font-size:15px;">FINAOs</p>
                                        <p class="orange orange-margin-top font-25px"><? echo $user_details->totalfinaos; ?></p></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 " style="margin-left: -5px;">
                                    <div class="profile-finaos ">
                                        <p class="font-15px profile-finaos-sidebar "><a href="index.php?r=site/myfollowers" style="font-size:15px;">FOLLOWERS</p>
                                        <p class="orange orange-margin-top font-25px"><? echo $user_details->totalfollowers; ?></p></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 " style="margin-left: -5px;">
                                    <div class="profile-finaos">
                                        <p class="font-15px profile-finaos-sidebar "><a href="index.php?r=site/imfollowing" style="font-size:15px;">FOLLOWING</p>
                                        <p class="orange orange-margin-top font-25px"><? echo $user_details->totalfollowings; ?></p></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="who-to-follow sidebar-background left-rounded-box">
                                <p class="profile-finaos font-18px who-to-follow margin-top-5px " style="margin-left:-10px;">FINAOs TO FOLLOW</p>
                        <? 
                            if(is_array($who_to_follows))
                            {                                
                                foreach($who_to_follows as $whotofollow)
                                {                             
                                    ?>
                                       <div class="row who-to-follow-border">
                                            <div class="col-lg-2 col-md-2 col-sm-2" style="padding-right: 0;">
                                                <a href="index.php?r=site/public_finao_posts&uname=<? echo $whotofollow->uname; ?>">
                                                    <img alt="Profile-image" src="<? echo ($whotofollow->image != "" ?  $whotofollow->image : "no-image.png"); ?>"  class="img-responsive" style="height:40px; width:40px;">
                                                </a>
                                            </div>
                                           <div class="col-lg-10 col-md-10 col-sm-10" style="margin-left: -2%;">
                                                <a href="index.php?r=site/public_finao_posts&uname=<? echo $whotofollow->uname; ?>" class="font-black">
                                                    <p class="font-14px updated-by-post margin-top-5px" ><? echo $whotofollow->username; ?></p>
                                                </a>
                                               <div class="row col-lg-12 col-md-12 col-sm-12" style="margin-left: -28px; margin-top: -14px;">
                                                     <div class="col-lg-5 col-md-5 col-sm-6 border-right-15px"><span class="fade-text font-10px">FINAOs</span><span class="text-muted font-15px  "><? echo $whotofollow->totalfinaos; ?></span></div>
                                                   <div class="col-lg-4 col-md-4 col-sm-6 border-right-15px"><span class="fade-text  font-10px">TILES</span><span class="text-muted font-15px"><? echo $whotofollow->totaltiles; ?></span></div>
                                                   <div class="col-lg-3 col-md-3 col-sm-3 "><span class="fade-text  font-10px">INSPIRED</span><span class="text-muted font-15px"><? echo $whotofollow->totalinspired; ?></span></div>
                                                </div>
                                            </div>
                                        </div>    
                                    <?
                                }
                            }
                            else
                            {
                                ?>
                                    <div class="row who-to-follow-border">
                                        <div class="col-lg-2 col-md-2 col-sm-2" style="padding-right: 0;">
                                           
                                        </div>
                                       <div class="col-lg-10 col-md-10 col-sm-10 margin-top-5px">
                                            <a href="#" class="font-black">
                                                <p class="font-20px updated-by"><? echo $who_to_follows; ?></p>
                                            </a>
                                        </div>
                                    </div>    
                                <?   
                            }
                        ?> 
                    </div>    
					              
                    <? include_once ("footer.php"); ?>
                </div>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6 ">
             	<div id="postscontainer"></div>
            </div>
        </div>
</div>
<?
    include_once("alert_modal.php");
?>
