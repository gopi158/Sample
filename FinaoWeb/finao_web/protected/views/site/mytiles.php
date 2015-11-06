<?php
    //print_r($mytiles);exit; 
    include ("header.php"); 
    include ("imagemodal.php"); 
    include ("configuration/configuration.php");
?>
<script>
    function change_finao_status(finao_id,finao_status,from)
    {
        $("#ajax_loader").show();
        if (from == "modal")
        {
             $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    var finao_status_list_item = "";
                    if(finao_status == 38)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-track">ON TRACK</a>';
                    }
                    
                    if(finao_status == 39)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-ahead">AHEAD</a>';
                       
                    }
                    
                    if(finao_status == 40)
                    {
                        finao_status_list_item = '<a href="#" id="modal_link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-behind">BEHIND</a>';
                    }
                    
                    $("#modal_link"+finao_id).remove();
                    $("#modal_finaostatus"+finao_id).prepend(finao_status_list_item);
                }
            });
        }       
    }
   
    function deletepost(finao_id,uploaddetail_id)
    {
        $("#ajax_loader").show();
        if(confirm("Are you sure?"))
        {
            $.get("index.php?r=site/deletepost&finaoid="+ finao_id +"&userpostid="+ uploaddetail_id,function(data){
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    $("#row"+finao_id).remove();
                    show_alert("post deleted successfully");  
                }
                else
                {
                    show_alert("you can not delete post");
                }
            });
        }
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
    
    function show_finao_msg(tile_id,user_id)
    {
        $("#ajax_loader").show();
        $.get("index.php?r=site/get_finao_msg&tile_id="+ tile_id + "&user_id="+ user_id,function(data){
            $("#ajax_loader").hide();
            if(data == "There is no finao")
            {
                $("#finao"+tile_id).html(data); 
                $("#finao"+tile_id).css("cursor","default");    
            }
            else
            {
                $("#finao"+tile_id).html(data);    
            }
        });    
    }
</script>
<div class="container white-background">
    <div class="content-wrapper" style="margin-top: 23px;">
        <? include_once ("private_profile_details.php");?>
        <div class="row" style="margin-left: -80px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <div class="left-rounded-box white-background" style="padding: 8px 5px 8px 8px; ">
                    <div class="entered-finaos entered-finaos-black">
                        <ul>
                          <a href="index.php?r=site/myfinaos"> <li>FINAOs</li></a>
                          <a href="index.php?r=site/mytiles"  > <li class="current">Tiles</li></a>
                          <a href="index.php?r=site/myprofile"> <li>Posts</li></a>
                          <a href="index.php?r=site/myinspirations">  <li>Inspired</li></a>
                          <a href="index.php?r=site/imfollowing">  <li>Following</li></a>
                          <a href="index.php?r=site/myfollowers">  <li class="last">Followers</li></a>
                        </ul>
                    </div>
                  <!--  <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                        <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
                    </div>-->
                    <div class="row" style="margin-left: 0px;">
                        <?
                            //if(is_array($finao_recent_posts))
//                            {
//                                $j = 0;
//                                foreach($finao_recent_posts as $finao_recent_post)
//                                {
//                                    if($finao_recent_post->status == 1)
//                                    {                                                              
                                        ?>
                                            <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">-->
                                                <?
                                                    //$has_data = false;
//                                                    if(is_array($finao_recent_post->image_urls))
//                                                    {                                                        
//                                                        foreach($finao_recent_post->image_urls as $image_url)
//                                                        {                              
//                                                            if ($image_url->image_url != "")
//                                                            {
                                                                ?>                                                                    
                                                                    <!--<img class="left-photos" src="<? echo $image_path."blank.gif"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">-->
                                                                <?
                                                                // ++$j;
//                                                                $has_data = true;
//                                                                break;
//                                                            }
//                                                        }                                                               
//                                                    }
//                                                    if(!$has_data)
//                                                    {
//                                                        if(is_array($finao_recent_post->videourls))
//                                                        {                                                        
//                                                            foreach($finao_recent_post->videourls as $videourls)
//                                                            {                              
//                                                                if ($image_url->image_url != "")
//                                                                {
                                                                    ?>                                                                    
                                                                        <!--<img class="left-photos" src="<? echo $icon_path."nike.png"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">-->
                                                                    <?
                                                                     //++$j;
//                                                                    $has_data = true;
//                                                                    break;
//                                                                }
//                                                            }                                                               
//                                                        }
//                                                    }                                                    
                                                ?>
                                            <!--</a>-->
                                        <?
                                   // }
//                                    if($j == 3)
//                                    {
//                                        break;
//                                    }
//                                }
//                            }
//                            else
//                            {
//                                
//                            }
                        ?>                        
                    </div>
                </div>
                <? include_once ("footer.php"); ?>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-6">
                <?
                    if(is_array($mytiles))
                    {
                        foreach ($mytiles as $mytile)
                        {
                            if ($mytile->type == 1)
                            {
                                ?>                                  
                                   
                                <div class="col-lg-4 col-md-5 col-sm-7">
                                        <ul class="nav  navbar-left img-responsive-tiles">
                                            <li id="fat-menu" class="dropdown">
                                                <a href="#" id="drop<? echo $mytile->tile_id; ?>" onclick="show_finao_msg(<? echo $mytile->tile_id; ?>,<? echo $user_details->userid; ?>); return false;" role="button" class="dropdown-toggle" data-toggle="dropdown">
                                                    <div class="view view-sixth" >
                                                        <img alt="Tile Image" src="<? echo ($mytile->image_urls["0"]->image_url != "" ? $mytile->image_urls["0"]->image_url :  $image_path."blank.gif"); ?>" style="height: 180px; width: 180px;"/>                                                        
                                                        <div class="mask">
                                                            <p class="info_travel">
                                                                <? echo $mytile->tile_name; ?>
                                                            </p>
                                                        </div>
                                                    </div>                                            
                                                </a>
                                                <ul class="dropdown-menu " role="menu" aria-labelledby="drop<? echo $mytile->tile_id; ?>">
                                                    <div class="row list">
                                                        <ul id="finao<? echo $mytile->tile_id; ?>">
                                                            
                                                        </ul>
                                                    </div>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                <?    
                            }                                   
                        }
                    }
                    if($mytiles == false)
                    {
                        ?>
                            <div class="row">
                                <div class="col-sm-10 col-md-12">
                                    <div class="text">
                                        You don't have any tiles
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