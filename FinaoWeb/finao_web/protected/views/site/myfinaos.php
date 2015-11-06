<?
    include ("header.php");
    include ("imagemodal.php");
    include ("configuration/configuration.php");
    //print_r($finao_list);exit;
?>
<script>
    function change_finao_status(finao_id,finao_status,from)
    {
        $("#ajax_loader").show();
        if (from == "myfinao")
        {
            $.get("index.php?r=site/change_finao_status&finao_id="+ finao_id +"&finao_status="+ finao_status,function(data){
                $("#ajax_loader").hide();
                if(data == "ok")
                {
                    var finao_status_list_item = "";
                    if(finao_status == 38)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-track right">ON TRACK</a>';
                    }
                    
                    if(finao_status == 39)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle right button-ahead">AHEAD</a>';
                       
                    }
                    
                    if(finao_status == 40)
                    {
                        finao_status_list_item = '<a href="#" id="link'+ finao_id +'" data-toggle="dropdown" class="dropdown-toggle button-behind right">BEHIND</a>';
                    }
                    
                    $("#link"+finao_id).remove();                             
                    $("#finaostatus"+finao_id).append(finao_status_list_item);
                }
            });   
        }
        else if (from == "modal")
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
    
    function deletepost(finao_id,uploaddetail_id)
    {
        if(confirm("Are you sure?"))
        {
            $("#ajax_loader").show();
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
</script>
<div class="container white-background" style="margin-top: 23px;">
    <div class="content-wrapper">
        <? include_once ("private_profile_details.php");?>
        <div class="row" style="margin-top: 10px; margin-left: -80px;">
            <div class="left-menu-width col-lg-3 col-md-4 col-sm-5">
                <div class="left-rounded-box white-background" style="padding: 8px 5px 8px 8px;">
                    <div class="entered-finaos">
                        <ul>
                           <a href="index.php?r=site/myfinaos" > <li  class="current">FINAOs</li></a>
                           <a href="index.php?r=site/mytiles"> <li>Tiles</li></a>
                           <a href="index.php?r=site/myprofile"> <li>Posts</li></a>
                           <a href="index.php?r=site/myinspirations"> <li>Inspired</li></a>
                           <a href="index.php?r=site/imfollowing"> <li>Following</li></a>
                          <a href="index.php?r=site/myfollowers">  <li class="last">Followers</li></a>
                        </ul>
                    </div>
                     <!-- <div class="profile-finaos profile-finaos-font" style="padding-top: 15px;">
                      <p class="font-25px photos-videos">PHOTOS + VIDEOS</p>
                    </div>-->
                    <div class="row img-responsive" style="margin: 0px;">
                    <?
                        //if(is_array($finao_recent_posts))
//                        {
//                            $j = 0;
//                            foreach($finao_recent_posts as $finao_recent_post)
//                            {
//                                if($finao_recent_post->status == 1)
//                                {                                                              
//                                    $has_data = false;
//                                    if(is_array($finao_recent_post->image_urls))
//                                    {                                                        
//                                        foreach($finao_recent_post->image_urls as $image_url)
//                                        {                              
//                                            if ($image_url->image_url != "")
//                                            {
                                                ?>                                                                    
                                                    <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">
                                                        <img class="left-photos" src="<? echo $image_path."blank.gif"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                    </a>-->
                                                <?
                                                //$has_data = true;
//                                                ++$j;
//                                                break;
//                                            }
//                                        }                                                               
//                                    }
//                                    if(!$has_data)
//                                    {
//                                        if(is_array($finao_recent_post->videourls))
//                                        {                                                        
//                                            foreach($finao_recent_post->videourls as $videourls)
//                                            {                              
//                                                if ($image_url->image_url != "")
//                                                {
                                                    ?>   
                                                        <!--<a href="#" data-target="#" data-interval="false" onclick="openimagedialog(<? echo $finao_recent_post->uploaddetail_id; ?>);">                                                                                                                                        
                                                            <img class="left-photos" src="<? echo $icon_path."nike.png"?>" style="background-image: url('<? echo $image_url->image_url; ?>'); height: 60px; width: 60px;">
                                                        </a>-->
                                                    <?
                                                    //$has_data = true;
//                                                    ++$j;
//                                                    break;
//                                                }
//                                            }                                                               
//                                        }
//                                    }
//                                }
//                                if($j == 3)
//                                {
//                                    break;
//                                }
//                            }
//                        }
//                        else
//                        {
//                            
//                        }
                    ?>
                    </div>
                </div>
                <? include_once ("footer.php"); ?>
            </div>
            <? //print_r($finao_list); ?>
            <div class="col-lg-8 col-md-7 col-sm-6 ">
			   <!--<div class="col-lg-6 col-md-8 col-sm-10 margin-left-10px margin-bottom-10px">
			   <button class="button-orange font-20px oswald-font">CREATE A FINAO</button>
			   </div>
			   -->
                <div class="col-lg-12 col-md-12 col-sm-12 left-rounded-box white-background" style="padding: 5px 5px 8px 5px;">
                    <div class="entered-finaos">
                        <div class="color-fff" style="padding:10px;">
                            <ul>
                                <? 
                                    if(is_array($finao_list))
                                    {
                                        foreach($finao_list as $finao)
                                        {
                                            ?>
                                                <li id="finaostatus<? echo $finao->finao_id; ?>">  
                                                    <div style="width: 78%;" class="left">
                                                        <a href="index.php?r=site/finao_posts&finao_id=<? echo $finao->finao_id; ?>" class="finao_names" style="word-wrap: normal;">
                                                            <? 
                                                                echo $finao->finao_msg; 
                                                            ?>                                                     
                                                        </a>
                                                    </div>
                                                    <?
                                                        echo ($finao->finao_status == 38 ? '<a href="#" id="link'. $finao->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-track right">ON TRACK</a>' : ($finao->finao_status == 40 ? '<a href="#" id="link'. $finao->finao_id .'" data-toggle="dropdown" class="dropdown-toggle button-behind right">BEHIND</a>' : '<a href="#" id="link'. $finao->finao_id .'" data-toggle="dropdown" class="dropdown-toggle right button-ahead">AHEAD</a>'));                                                
                                                    ?>
                                                    <ul class="dropdown-menu right dropbox following-dropdown" style="margin-top: 10px; margin-left: 140px; position: relative; z-index:1000;" role="menu">
                                                        <li>
                                                            <div class="arrow1 center" style="margin-top:-18px;"></div>
                                                        </li>
                                                        <li>
                                                            <div class="dropdown-menu-padding">
                                                                <a href="#" onclick="change_finao_status(<? echo $finao->finao_id; ?>,39,'myfinao'); return false;" class=" button-ahead status-button ">AHEAD </a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dropdown-menu-padding">
                                                                <a href="#" onclick="change_finao_status(<? echo $finao->finao_id; ?>,38,'myfinao'); return false;" class=" button-track status-button">ON TRACK</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dropdown-menu-padding">
                                                                <a href="#" onclick="change_finao_status(<? echo $finao->finao_id; ?>,40,'myfinao'); return false;" class=" button-behind status-button">BEHIND </a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div style="clear: both;"></div>
                                                </li>
                                            <?
                                        }
                                    }
                                    
                                    if(is_string($finao_list))
                                    {
                                        ?>
                                            <li><? echo $finao_list; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?
    include_once("alert_modal.php");
?>