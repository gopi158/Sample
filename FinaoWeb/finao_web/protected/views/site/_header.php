<?
include ("configuration/configuration.php");
function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

    $return = Users::isLogin();
    if($return)
    {
        //print_r($mytiles);
//        exit;
        ?> 
            <script type="text/javascript">
                $(document).on("click",function()
                {
                    $("#searchitems").removeClass("open");
                });
                
                $(document).on("keyup click","#searchbox",function(data){                 
                     SearchUser();
                });
                
                function SearchUser()
                {
                    $.get("index.php?r=site/search_user&searchword=" + $("#searchbox").val(),function(data){
                        if(data != "")
                          {    
                               $("#searchresults").html("");             
                               $("#searchresults").html(data);
                               $("#searchresults").children("li").last().children("div").removeClass("devider-header");
                               $("#searchitems").addClass("open");
                               $("#searchbox").focus();
                          }
                          else
                          {
                              $("#searchitems").removeClass("open");
                          }
                    });   
                }
                
                $(document).on("click","#post_next",function(){
                    $("#postandfinao").find(".prehtml").remove();
                    $("#post_preview_text").html($("#post_text").val());                    
                    $("#postandfinao").append('<textarea name="post_text" class="prehtml" style="display:none;">'+ $("#post_text").val() +'</textarea>');
                    //$("#postandfinao").append('<input type="file" name="post_image" class="prehtml" value="'+ $("#post_image").val() +'"/>');
                    //$("#postandfinao").append('<input type="file" name="post_video" class="prehtml" value="'+ $("#post_video").val() +'"/>');                    
                    $("#postandfinao").append('<input type="hidden" class="finaostatus" name="finao_status" value="38"/>');                    
                });
                
                $(document).on("click","#finao_next",function(){
                    $("#postandfinao").find(".finaomodel").remove();
                    $("#postandfinao").append('<textarea name="finao_title" class="text">'+ $("#finao_title").val() +'</textarea>');
                     if($('#isfinaopublic').is(':checked'))
                     {
                        $("#postandfinao").append('<input type="text" name="isfinaopublic" value="1"/>');
                     }
                     else
                     {
                         $("#postandfinao").append('<input type="text" name="isfinaopublic" value="0"/>');
                     }
                }); 
                
                function addfinaoid(finaoid)
                {
                    $("#postandfinao").find(".finao").remove();
                    $("#finaotitlepreview").html($("#finaotext" + finaoid).html());
                    $("#postandfinao").append('<input type="hidden" class="finao" name="finao_id" value="' + finaoid + '"/>');
                }
                
                function add_finao_status(status)
                {
                    switch(status)
                    {
                        case 38:
                            $("#next_finao_status").attr("class", "button-track").html("ON TRACK");
                            break;
                        case 39:
                            $("#next_finao_status").attr("class", "button-ahead-green").html("AHEAD");
                            break;
                        case 40:
                            $("#next_finao_status").attr("class", "button-behind").html("BEHIND");
                            break;
                    }
                    $("#finaocurrentstatus").html("");
                    $("#finaocurrentstatus").html($("#status"+status).html());
                    $("#postandfinao").find(".finaostatus").remove();
                    $("#postandfinao").append('<input type="hidden" class="finaostatus" name="finao_status" value="' + status +'"/>'); 
                }                
            </script>
             <script type="text/javascript">
                function showpostpopup()
                {
                    $('.bs-modal-sm5').modal('show');
                    $("#post_text").val("");
                    $("#finao_title").val("");
                    $("#post_image").val("");
                    $("#post_video").val("");                     
                }
                
                function addtileid(tile_id,tile_name)
                {
                    $("#postandfinao").find(".tile").remove();
                    $("#postandfinao").append("<input type='hidden' name='tile_id' class='tile' value='" + tile_id + "'/>");                    
                    $("#postandfinao").append("<input type='hidden' name='tile_name' class='tile' value='" + tile_name + "'/>");                    
                }
                
                function closeit_without_creating_finao() { //alert ($("#postandfinao").html());return false; 
                                 
                    $.post("index.php?r=site/submitpost",$("#postandfinao").serialize(),function(data){
                        if(data != "")
                        {
                            alert (data);
                            setTimeout(" window.open('index.php?r=site/myprofile', '_self');", 0);
                        }  
                    });                    
                }
                
                function closeit() {
                    $.post("index.php?r=site/submitfinao",$("#postandfinao").serialize(),function(data){ 
                        if(data != "")
                        {
                            alert (data);
                            setTimeout(" window.open('index.php?r=site/myprofile', '_self');", 0);
                        }  
                    });                    
                }
            </script>
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container" style="box-shadow: none!important; border: 0;">
                    <div class="row">
                        <div class="col-md-5 col-xs-3" style="padding-left: 0;">
                            <div class="header-left">
                                <a href="index.php?r=site/home" class="home-header" title="Home">HOME</a>
                                <a class="profile-header" href="index.php?r=site/myprofile" title="Profile">PROFILE</a>
                            </div>
                        </div>
                        <div class="col-md-2 col-xs-2 splash-logo" style="margin-right: 0px;">
                            <a href="index.php?r=site/home" title="Finao">
                                <img alt="Logo" src="<? echo $icon_path."logo-new.jpg"?>" class="img-responsive"/>
                            </a>
                        </div>
                        <div class="col-md-5 col-xs-7" style="padding-right: 0px;">
                            <div class="header-right">
                                <div class="horizontal">
                                    <ul>
                                        <li>
                                            <a href="#" onclick="showpostpopup(); return false;" title="New Post">
                                                <img alt="Icon-post" src="<? echo $icon_path."icon-post-finao.png"?>">
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a id="dNotifications" href="Header_notifications.html" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                                <img alt="Icon-notification" src="<? echo $icon_path."icon-notifications.png"; ?>">
                                            </a>
                                            <!--Header notifications-->
                                            <ul class="dropdown-menu notifications" style="margin-top: 22px; margin-left: -160px;" role="menu" aria-labelledby="dNotifications">
                                                <li>
                                                    <div class="arrow1"></div>
                                                </li>
                                                <? 
                                                    if(is_array($mynotifications))
                                                    {
                                                        foreach ($mynotifications as $mynotification)
                                                        {
                                                            ?>
                                                                <li>
                                                                    <div align="left" class="devider-header">
                                                                        <div class="row font-18px">
                                                                            <div class="col-md-2 col-xs-2">                                                                               
                                                                                <img alt="Profile-image" style='height:40px;width:40px;' alt="Image" src="<? echo ($mynotification->profile_image != "" ? $mynotification->profile_image : $image_path."no-image.png"); ?>" />                                                                                
                                                                            </div>
                                                                            <div class="col-md-10 col-xs-10 notifications-text"><span><? echo $mynotification->action; ?></span></div>
                                                                        </div>
                                                                        <div class="row" align="right"><span class="text-fade notifications-postedon"><? echo date("d-M-Y, H:i:s",strtotime($mynotification->createddate));?></span></div>
                                                                    </div>
                                                                </li>
                                                            <?
                                                        }
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                            <li>
                                                                <div align="left" class="devider-header">
                                                                    <div class="row font-18px">
                                                                        <div class="col-md-2 col-xs-2"></div>
                                                                        <div class="col-md-10 col-xs-10 notifications-text"><span><? echo $mynotifications; ?></span></div>
                                                                    </div>
                                                                    <div class="row" align="right"><span class="text-fade notifications-postedon"></span></div>
                                                                </div>
                                                            </li>    
                                                        <?
                                                    }
                                                ?>
                                            </ul>
                                            <!--Header notifications-->
                                        </li>
                                        <li class="dropdown" id="searchitems">                                           
                                            <input class="imagesearch no-border" type="image" src="content/images/icons/search.png">
                                            <input type="search" class="search-box no-border" name="searchword" id="searchbox" placeholder="Search"/> 
                                            <!--search-->
                                            <!--<ul id="searchresults" class="dropdown-menu" id></ul>-->
                                            <!--<ul class="dropdown-menu" id="searchresults" role="menu" aria-labelledby="dSearch" style="margin-top: 22px; auto; margin-left: 0px;"></ul>-->
                                            <ul class="dropdown-menu" id="searchresults" role="menu" aria-labelledby="dSearch" style="margin-top: 22px; auto; margin-left: 0px;"></ul>
                                        </li> 
                                        <li class="dropdown">
                                            <a id="dSettings" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" title="Settings">
                                                <img alt="Icon-settings" src="<? echo $icon_path."icon-settings.png"; ?>">
                                            </a>
                                            <!--header settings-->
                                            <ul class="dropdown-menu pull-right" style="margin-top: 15px; margin-right: 3px;" aria-labelledby="dSettings">
                                                <li>
                                                    <div class="arrow1" style="float: right;"></div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-edit" src="<? echo $icon_path."user.png";?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px;"><a href="index.php?r=site/edit_profile">Edit My Profile</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-user" src="<? echo $icon_path."user.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a href="index.php?r=site/tagnotes">Tagnotes</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-globe" src="<? echo $icon_path."globe.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a href="#">Privacy</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-bell" src="<? echo $icon_path."bell.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a href="#">Notifications</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="link-log" align="left">
                                                        <a href="index.php?r=site/logout"><span style="padding-left: 10px">Log out</span></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!--finao post pop up 1 -->
            <div class="modal fade bs-modal-sm5" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm1">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="text-left orange-text post-finao-hdline">POST</div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" data-target=".bs-modal-sm6" id="post_next">Next</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="6" id="post_text" placeholder="Start Typing..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="row col-md-12 col-xs-12"> 
                                <form id="postandfinao" method="post" enctype="multipart/form-data">
                                    <div class="col-md-4 margin-left30 left col-xs-4">
                                        <a href="#" class="upload-img">
                                            <label for="post_image">Upload an Image</label>
                                        </a>
                                        <input type="file" id="post_image" style="display:none;"/>
                                    </div> 
                                    <div class="col-md-4 col-xs-4">
                                        <a href="#" class="upload-video">
                                            <label for="post_video">Upload an video</label>
                                        </a>
                                        <input type="file" id="post_video" style="display:none;"/>
                                    </div>
                                </form> 
                                <div class="col-md-4 col-xs-4 margin-right30"> 
                                    <a href="#" id="next_finao_status" class="dropdown-toggle button-track" data-toggle="dropdown">ON TRACK</a>                                    
                                    <ul class="dropdown-menu left dropbox dropbox following-dropdown" style="margin-top: 13px; margin-right: -100px;" role="menu" aria-labelledby="dLabel">
                                        <li style="margin-top: -9px;">
                                            <div class="arrow1"></div>
                                        </li>
                                        <li>
                                            <div class="dropdown-menu-padding" id="status39">
                                                <a href="#" class=" button-ahead-green status-button" style="padding-left: 23px; padding-right: 23px;" onclick="add_finao_status(39); return false;">AHEAD </a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-menu-padding" id="status38">
                                                <a href="#" class=" button-track status-button" onclick="add_finao_status(38); return false;">ON TRACK</a>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-menu-padding" id="status40">
                                                <a href="#" class=" button-behind status-button" style="padding-left: 21px; padding-right: 22px;" onclick="add_finao_status(40); return false;">BEHIND </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--finao post pop up 1 end -->
            <!--finao post pop up 2 -->
            <div class="modal fade bs-modal-sm6" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A FINAO</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <a href="#" class="status-button-ahead status-button" data-toggle="modal" data-target=".bs-modal-sm1" style="color: #FFF;">CREATE A FINAO</a>
                                    </p>
                                    <div class="entered-finaos">
                                    <? //echo($finao_list);exit;?>
                                        <ul>
                                            <?
                                                if(is_array($finao_list))
                                                {
                                                    foreach ($finao_list as $finao)
                                                    {
                                                        ?>
                                                            <li><a onclick="addfinaoid(<? echo $finao->finao_id; ?>)" href="#" data-toggle="modal" data-target=".bs-modal-sm7"><span id="finaotext<? echo $finao->finao_id; ?>"><? echo $finao->finao_msg; ?><span></a></li>
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
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- finao post pop up 2 end -->
            <!-- finao post pop up 3 -->
            <div class="modal fade bs-modal-sm1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm1">
                    <div class="modal-content">
                        <div align="right" style="margin: -15px;">
                            <button type="button" class="close close-opacity no-border" data-dismiss="modal" aria-hidden="true">
                                <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">                                
                            </button>
                        </div>
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-left orange-text post-finao-hdline">CREATE A FINAO</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" id="finao_next" data-target=".bs-modal-sm2">Next</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" class="finaomodel" rows="6" id="finao_title" placeholder='"I will..."'></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="col-md-2 text-align-left">
                                <input type="checkbox" checked class="finaomodel" id="isfinaopublic">
                                <span class="text-fade">Public</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- finao post pop up 3 end -->
            <!-- finao post pop up 4 -->
            <div class="modal fade bs-modal-sm2" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm2">
                    <div class="modal-content">
                        <div style="margin: -15px;">
                            <button type="button" class="close close-opacity no-border" data-dismiss="modal" aria-hidden="true">
                                <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">                                
                            </button>
                        </div>
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-md-6 col-xs-5">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A TILE</div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" onclick="closeit()" data-toggle="modal"  data-target="">Create</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <?   
                                    if(is_array($mytiles))
                                    {
                                        $prev_tile_id = "";
                                        foreach ($mytiles as $mytile)
                                        {
                                            if ($prev_tile_id != $mytile->tile_id)
                                            {
                                                ?>
                                                    <div class="col-md-6 col-xs-6">
                                                        <a href="#" onclick="addtileid(<? echo $mytile->tile_id;?>,<? echo $mytile->tilename; ?>)">
                                                            <img alt="Tile-image" src="images/uploads/finaoimages/<? echo ($mytile->tile_imageurl != "" ? (file_exists("images/uploads/finaoimages/".$mytile->tile_imageurl) ? $mytile->tile_imageurl : "no_tile_image.jpg") : "no_tile_image.jpg") ?>" class="img-responsive">
                                                            <? echo $mytile->tilename; ?>
                                                        </a>
                                                    </div>
                                                <?
                                                $prev_tile_id = $mytile->tile_id;
                                            }
                                        }
                                    }
                                ?> 
                            </div>
                        </div>
                        <div class="row unused">UNUSED TILES</div>
                        <div class="modal-footer">
                            <div class="col-md- col-xs-6" style="margin-left: -40px;">
                                <div class=" post-li">
                                    <ul>
                                        <?
                                            if(is_array($unused_tiles))
                                            {
                                                foreach ($unused_tiles as $unused_tile)
                                                {
                                                    ?>
                                                         <li>
                                                            <a href="#" onclick="addtileid(<? echo $unused_tile->tile_id;?>)">
                                                                <div class="li-img">
                                                                    <img alt="Icon-tile" src="images/uploads/finaoimages/<? echo ($unused_tile->tile_imageurl != "" ? (file_exists("images/uploads/finaoimages/".$unused_tile->tile_imageurl) ? $unused_tile->tile_imageurl : "tile.png") : "tile.png") ?>">
                                                                </div>
                                                                <? echo $unused_tile->tile_name; ?>
                                                            </a>
                                                        </li>    
                                                    <?
                                                }
                                            }
                                            if($unused_tiles == "false")
                                            {
                                                ?>
                                                     <li>
                                                        <a href="#">
                                                            <? echo "No unused tiles."; ?>
                                                        </a>
                                                    </li>    
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
            <!-- finao post pop up 4  end--> 
            <!-- finao post pop up 5-->
            <div class="modal fade bs-modal-sm7" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A FINAO</div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" onclick="closeit_without_creating_finao()">Submit</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <p>
                                        <a href="#" class="status-button-ahead status-button" data-toggle="modal" data-target=".bs-modal-sm1" style="color: #FFF;">CREATE A FINAO</a>
                                    </p>
                                    <div class="entered-finaos fade-text">
                                        <ul>
                                            <?
                                                if(is_array($finao_list))
                                                {
                                                    foreach ($finao_list as $finao)
                                                    {
                                                        ?>
                                                            <li><a value="<? echo $finao->finao_id; ?>" href="#" data-toggle="modal" data-target=".bs-modal-sm7"><? echo $finao->finao_msg; ?></a></li>
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
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-8" style="padding-left: 0;">
                                            <img alt="Profile-image" height="40px" src="images/uploads/profileimages/<? echo ($user_details->profile_image != "" ? (file_exists("images/uploads/profileimages/".$user_details->profile_image) ? $user_details->profile_image : "no-image.png") : "no-image.png") ?>"  class="img-border">                                            
                                            <span class="updated-by"><? echo ucwords($user_details->fname ." ". $user_details->lname); ?></span>
                                        </div>
                                        <div class="col-md-4 text-right text-fade">just now</div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 col-xs-12">
                                        <img alt="Post-image" class="img-responsive" src="content/images/finao-sample-img.jpg">
                                    </div>
                                    <div class="col-md-12" style="padding-top: 15px; padding-left: 0;">
                                        <p class="finao-title-text">                                            
                                            <img alt="Icon-finao" src="<? echo $icon_path."icon-finao.png"; ?>">
                                            <strong id="finaotitlepreview"></strong>
                                        </p>
                                        <p class="finao-activity-text" id="post_preview_text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- finao post pop up 5 end-->
            
            <iframe id="postandfinaoframe" style="height:500px; width:500px; display: none;" name="postandfinaoframe" style="display: none;"></iframe>
        <?
    }
    else
    {
        ?>
            <script>
                $(function(){
                    $(document).on("keypress","#login_password",function(e){
                        if($("#login_password").val() != "")
                        {
                            if(e.keyCode == 13)
                            {
                                $("#submitlogin").click();
                            }  
                        }
                    });
                });
            
                $(document).on('click',"#signup_submit",function() {
                    if($("#fname").val() == "")
                    {
                        alert ("Please enter first name.");                        
                        $("#fname").focus();                    
                        $("#fname").addClass("control-error");
                        return false;
                    }
                    
                    if($("#lname").val() == "")
                    {
                        alert ("Please enter last name.");                        
                        $("#lname").focus();
                        $("#lname").addClass("control-error");
                        return false;
                    }
                    
                    if($("#email_signup").val() == "")
                    {
                        alert ("Please enter email address.");
                        $("#email_signup").focus();
                        $("#email_signup").addClass("control-error");
                        return false;                        
                    }
                    
                    if($("#email_signup").val() != "")
                    {  
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#email_signup").val()))
                        {
                            alert("Please enter valid email address.");
                            $("#email_signup").focus();
                            $("#email_signup").addClass("control-error");
                            return false;
                        }
                    }
                    
                    if($("#password").val() == "")
                    {
                        alert ("Please enter password.");
                        $("#password").focus();
                        $("#password").addClass("control-error");                        
                        return false;
                    }
                    
                    if($("#reenter_password").val() == "")
                    {
                        alert ("Re enter password.");
                        $("#reenter_password").focus();
                        $("#reenter_password").addClass("control-error");
                        return false;
                    }
                    
                    if($("#password").val() != $("#reenter_password").val())
                    {     
                        alert ("Passwords does not match.");
                        $("#reenter_password,#password").addClass("control-error");                        
                        return false;
                    }
                    
                    $.get("index.php?r=site/submitsignup",$("#signup").serialize(),function(data){ 
                            if(data == "invalid_captcha_code")
                            {
                                alert("Please enter captcha words correctly");
                                Recaptcha.reload();
                                return false; 
                            }    
                            $("#fname,#lname,#password,#reenter_password,#email_signup").val("");
                            $(".bs-modal-sm2").modal('hide');
                            $("#msg_alert_popup").modal('show');
                            $("#alert_msg").text(data);
                            //$("#signup").html("<p style='margin-left:10px;'>"+ data + "</p>");
                    });
                });
                
                 $(document).on('click',"#forgot_email_submit",function() {                    
                    if ($("#forgot_email").val() == "")
                    {
                        alert ("please enter email");
                        $("#forgot_email").focus();
                        $("#forgot_email").addClass("control-error");
                        return false;
                    }
                    if($("#forgot_email").val() != "")
                    {  
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#forgot_email").val()))
                        {
                            alert("Please enter valid email address.");
                            $("#forgot_email").focus();
                            $("#forgot_email").addClass("control-error");
                            return false;
                        }
                    }
                    $.get("index.php?r=site/Forgot_password",$("#forgot_form").serialize(),function(data){
                            $(".bs-modal-sm").modal('hide');
                            $("#msg_alert_popup").modal('show');
                            $("#alert_msg").text(data);
                    });
                    return false;
                });
                
//                $(document).on('click',"#submitlogin",function(data){
//                    $.get("index.php?r=site/submitlogin",$("#loginform").serialize(),function(data){
//                        if(data == "true")
//                        {
//                            window.location = "index.php?r=site/myprofile";                            
//                        }
//                        if(data == "false")
//                        {
//                            alert ("Username / Password invalid.");
//                        }
//                    });    
//                })
                
                function SubmitLoginForm()
                {
                    if($("#login_email").val() == "")
                    {
                        alert ("Please enter email address.");
                        $("#login_email").focus();
                        $("#login_email").addClass("control-error");
                        return false;
                    }
                    if($("#login_email").val() != "")
                    {
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#login_email").val()))
                        {
                            alert("Please enter valid email address.");
                            $("#login_password").focus();
                            //$("#login_password").addClass('has-error');
                            return false;
                        }
                    }
                    if($("#login_password").val() == "")
                    {
                        alert("Please enter password.");
                        $("#login_password").focus();
                        $("#login_password").addClass("control-error");
                        return false;
                    }
                    $.get("index.php?r=site/submitlogin",$("#loginform").serialize(),function(data){
                        if(data == "true")
                        {
                            window.location = "index.php?r=site/myprofile";                            
                        }
                        if(data == "false")
                        {
                            alert ("Invalid username/password.");
                        }
                    }); 
                }
                function forgotemail()
                {
                    $("#forgot_email").val("");
                    $("#forgot_email").focus();
                    return;
                }
                
                function forgot_email_cancel()
                {
                    $("#forgot_password").modal('hide');
                }
            </script>
           
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container" style="box-shadow: none!important; border: 0;">
                    <div class="row">
                        <div class="col-md-3 col-xs-3  splash-logo">
                            <a href="index.php">
                                <img alt="Logo" title="Finao" src="<? echo $icon_path."logo-new.jpg"?>" class="img-responsive"/>                                
                            </a>
                        </div>
                        <div class="col-md-3 col-xs-1"></div>
                        <div class="col-md-6 col-xs-8 splash-logo">
                            <form class="row" role="form" method="post" id="loginform">
                                <input class="txtbox textbox-pad no-border" placeholder="Email" title="Email" autofocus type="text" id="login_email" name="LoginForm[username]" autocomplete="off"></input>
                                <input class="txtbox textbox-pad no-border" placeholder="Password" title="Password" type="password" id="login_password" name="LoginForm[password]" autocomplete="off"></input>
                                <button class="landing-login no-border font-15px" id="submitlogin" onclick="SubmitLoginForm(); return false;" type="button">Login</button>
                            </form>
                            <div class="font-12px">
                                <a href="#" data-toggle="modal" title="Forgot password" onclick="forgotemail()" data-target=".bs-modal-sm" style="color: #FFF; margin-left: 7px;">
                                    <span class="text-forgotpassword">Forgot your password?</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal fade bs-modal-sm" tabindex="-1" id="forgot_password" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content forgot-password-container" style="border-radius: 1px;">
                        <div align="right" style="margin: -20px;">
                                <button type="button" class="close close-opacity" data-dismiss="modal" aria-hidden="true">
                                    <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">                                    
                                </button>
                            </div>
                        <div>
                            <div class="row splash-logo">
                                <div class="orange-text text-forgot-password" align="center" id="forgot_heading">FORGOT YOUR PASSWORD?</div>
                            </div>
                        </div>
                        <form id="forgot_form" role="form">
                            <div>
                                <div class="row font-18px forgot-password-message" align="center">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <span>You will receive a password reset link to change your password.</span>
                                    </div>
                                </div>
                                <div class="row" style="padding-top: 20px; margin-bottom: 10px">
                                    <div class="col-md-12">
                                        <div class="forgot-password-email" align="center">
                                            <div class="col-md-1"></div>
                                            <input class="col-md-10" placeholder="email" id="forgot_email" name="forgot_email" style="text-align: center" autofocus type="text" autocomplete="off"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div align="center" class="landing-submit">
                                <button data-dismiss="modal" aria-hidden="true" class="landing-forgot-submit cancel"> CANCEL </button>
                                <button id="forgot_email_submit" class="landing-forgot-submit submit"> SUBMIT </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>    
        <?
    }
?>