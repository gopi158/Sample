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
            $value = $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
            break;
        }
    }
    if ($value = "0 seconds")
        return "just now";
    else
        return $value;
}
?>
<script>
$(function(){        
    var width = $(window).width();
    var height = $(window).height();
    var document_height = $(document).height();
    $("#ajax_loader").attr("style","width:"+ width +"px;height:"+ document_height +"px; display:none; position:absolute; background:#F1F1F1; opacity:0.7; z-index:10000;");
    $("#loader_image").attr("style","margin-left:"+ width/2-600 +"px;padding-top:"+ height/2 +"px; z-index:1; position:relative;");
});      
</script>
<div id="ajax_loader" align="center">
    <img src="<? echo $icon_path."fast-loader.gif"; ?>" id="loader_image"/>
</div>
<?
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
                    $("#postandfinao").append('<input type="hidden" name="post_text" value="'+ $("#post_text").val() +'">');
                    //$("#postandfinao").append('<input type="file" name="post_image" class="prehtml" value="'+ $("#post_image").val() +'"/>');
                    //$("#postandfinao").append('<input type="file" name="post_video" class="prehtml" value="'+ $("#post_video").val() +'"/>');                    
                    $("#postandfinao").append('<input type="hidden" style="display:none;" class="finaostatus" name="finao_status" value="38"/>');                    
                });
                
                $(document).on("click","#finao_next",function(){
                    $("#postandfinao").find(".finaomodel").remove();
                    $("#postandfinao").append('<input type="hidden" name="finao_title" value="'+ $("#finao_title").val() +'">');
                     if($('#isfinaopublic').is(':checked'))
                     {
                        $("#postandfinao").append('<input type="text" style="display:none;" name="isfinaopublic" value="1"/>');
                     }
                     else
                     {
                         $("#postandfinao").append('<input type="text" style="display:none;" name="isfinaopublic" value="0"/>');
                     }
                }); 
                
                function addfinaoid(finaoid, object)
                {
                    $("#postandfinao").find(".finao").remove();
                    $("#finaotitlepreview").html($("#finaotext" + finaoid).html());
                    $("#postandfinao").append('<input type="hidden" style="display:none;" class="finao" name="finao_id" value="' + finaoid + '"/>');
                    $(".new_post_finao").removeClass("selected_finao");
                    $(".finao_selection" + finaoid).addClass("selected_finao");
                    show_post_preview_popup();
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
                $(function(){
                    $("#postandfinaoframe").load(function(){
                        $("#ajax_loader").hide();
                        data = $("#postandfinaoframe").contents().find("html").html();
                        if (data != "<head></head><body></body>")
                        {
                            var regex = /(<([^>]+)>)/ig
                            ,   data = data.replace(regex, "");
                            alert(data);
                            $('.bs-modal-sm5').modal("hide");
                            $('.bs-modal-sm6').modal("hide");
                            $('.bs-modal-sm7').modal("hide");
                            $('.bs-modal-sm1').modal("hide");
                            $('.bs-modal-sm2').modal("hide");
                            $("#postandfinaoframe").remove();
                            location.reload();
                        }
                    });
                })
                function show_finaolist_popup()
                {
                    if ($("#post_text").val() == "")
                    {
                        alert("Please enter some text to post!");
                        return;
                    }
                    $('.bs-modal-sm5').modal('hide');
                    $('.bs-modal-sm6').modal('show');
                }
                function show_post_preview_popup()
                {
                    $('.bs-modal-sm6').modal('hide');
                    $('.bs-modal-sm7').modal('show');
                }
                
                function show_create_finao_popup()
                {
                    $('.bs-modal-sm6').modal('hide');
                    $('.bs-modal-sm1').modal('show');
                }
                
                function show_choose_tile_popup()
                {
                    if ($("#finao_title").val() == "")
                    {
                        alert("Please enter the FINAO title!");
                        return;
                    }
                    $("#postandfinao").append("<input type='hidden' id='selected_tile_id' name='tile_id' class='tile' value='0'/>");
                    $('.bs-modal-sm1').modal('hide');
                    $('.bs-modal-sm2').modal('show');
                }
                function showpostpopup()
                {
                    $('.bs-modal-sm5').modal('show');
                    $("#post_text").val("");
                    $("#finao_title").val("");
                    $("#post_image").val("");
                    $("#post_video").val("");
                    $("#addpostimage").html("");
                }
                
                function addtileid(tile_id,tile_name, object)
                {
                    var tileid = parseInt(tile_id);
                    $("#postandfinao").find(".tile").remove();
                    $("#postandfinao").append("<input type='hidden' id='selected_tile_id' name='tile_id' class='tile' value='" + tileid + "'/>");                    
                    $("#postandfinao").append("<input type='hidden' name='tile_name' class='tile' value='" + tile_name + "'/>");                    
                    $(".choose_tile_new_finao").removeClass("selected_tile_new_finao");
                    $(".choose_tile_new_finao").find("img").removeClass("orange_border");
                    $(object).addClass("selected_tile_new_finao");
                    $(object).find("img").addClass("orange_border");
                    
                }
                
                function closeit_without_creating_finao() 
                {    
                    $("#ajax_loader").show();                                
                    $("#postandfinao").attr("action", "index.php?r=site/submitpost");
                    $("#postandfinao").submit();
                }
                
                function closeit_with_finao()
                {
                    if($("#selected_tile_id").val() == "0")
                    {
                        alert ("Select a tile.");
                        return false;
                    }
                    $("#ajax_loader").show();                                
                    $("#postandfinao").attr("action", "index.php?r=site/submitfinao");
                    $("#postandfinao").submit();
                }
                $("#post_image").change(function() {
                   readPostImageURL(this);
                });

                function readPostImageURL(input) {
                   if (input.files && input.files[0]) {
                       var reader = new FileReader();
                       reader.onload = function(e) {
                           $("#post_image_container").html("<img id='preview_post_image' src='"+ e.target.result +"' style='width: 100%; height: auto;'/>");
                       }

                       reader.readAsDataURL(input.files[0]);
                   }
                }
                
                function addmorepostimage()
                {
                     $("#addpostimage").append($("#dummypostimage").html());
                }
                
                function addmorepostvideo()
                {
                    $("#addpostvideo").append($("#dummypostvideo").html()); 
                }
            </script>
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container" style="box-shadow: none!important; border: 0;">
                    <div class="row">
                        <div class="col-md-5 col-sm-3" style="padding-left: 0;">
                            <div class="header-left">
                                <a href="index.php?r=site/home" class="home-header" title="Home">HOME</a>
                                <a class="profile-header" href="index.php?r=site/myposts" title="Profile">PROFILE</a>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 splash-logo" style="margin-right: 0px;">
                            <a href="index.php?r=site/home" title="Finao">
                                <img alt="Logo" src="<? echo $icon_path."logo-new.jpg"?>" class="img-responsive"/>
                            </a>
                        </div>
                        <div class="col-md-5 col-sm-7" style="padding-right: 0px;">
                            <div class="header-right">
                                <div class="horizontal">
                                    <ul>
                                        <li>
                                            <a href="#" onclick="showpostpopup(); return false;" title="New Post">
                                                <img alt="Icon-post" src="<? echo $icon_path."icon-post-finao.png"?>">
                                            </a>
                                        </li>
                                        <li class="dropdown">
                                            <a id="dNotifications" href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                                <img alt="Icon-notification" src="<? echo $icon_path."icon-notifications.png"; ?>">
                                            </a>
                                            <!--Header notifications-->
                                            <ul class="dropdown-menu notifications" style="margin-top: 22px; margin-left: -160px;" role="menu" aria-labelledby="dNotifications">
                                                <li>
                                                    <div class="arrow3"></div>
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
                                                                            <div class="col-md-2 col-sm-2">                                                                               
                                                                                <img alt="Profile-image" style='height:40px;width:40px;' alt="Image" src="<? echo ($mynotification->profile_image != "" ? $mynotification->profile_image : $image_path."no-image.png"); ?>" />                                                                                
                                                                            </div>
                                                                            <div class="col-md-10 col-sm-10 notifications-text"><span><? echo $mynotification->action; ?></span></div>
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
                                                                        <div class="col-md-2 col-sm-2"></div>
                                                                        <div class="col-md-10 col-sm-10 notifications-text"><span><? echo $mynotifications; ?></span></div>
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
                                                            <span style="padding-left: 10px;">
                                                    <a class="settings_menu" href="index.php?r=site/edit_profile">
                                                            Edit My Profile
                                                    </a>
                                                            </span>
                                                        </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-tagnotes" src="<? echo $icon_path."icon_tagnote.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a class="settings_menu" href="index.php?r=site/tagnotes">Tagnotes</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-globe" src="<? echo $icon_path."globe.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a class="settings_menu" href="index.php?r=site/privacy">Privacy</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div align="left" class="devider-header">
                                                        <img alt="Icon-bell" src="<? echo $icon_path."bell.png"; ?>" style="padding-left: 10px">
                                                        <span style="padding-left: 10px"><a class="settings_menu" href="#">Notifications</a></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="link-log" align="left">
                                                        <a class="settings_menu" href="index.php?r=site/logout"><span style="padding-left: 10px">Log out</span></a>
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
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-left orange-text post-finao-hdline">POST</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" onclick="show_finaolist_popup(); return false;" id="post_next">Next</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" rows="6" id="post_text" placeholder="Start Typing..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <div class="row col-md-12 col-sm-12"> 
                                <form id="postandfinao" method="post" target="postandfinaoframe" enctype="multipart/form-data">
                                    <div class="col-md-4 margin-left30 left col-sm-4">
                                        <span>
                                            <a href="#" class="upload-img">
                                                <label for="post_image">Upload an Image</label>
                                            </a>
                                            <input type="file" id="post_image" name="post_image[]" style="display:none;" onchange="readPostImageURL(this);"/>
                                        </span>
                                        <span id="addpostimage">
                                        </span>
                                        <a href="#" class=" button-ahead-green status-button" onclick="addmorepostimage();">Add More Image</a>
                                        <!--<input type="button" value="Add More Image" class="button-track" onclick="addmorepostimage();"/>-->
                                    </div> 
                                    <div class="col-md-4 col-sm-4">
                                        <a href="#" class="upload-video">
                                            <label for="post_video">Upload an video</label>
                                        </a>
                                        <input type="file" id="post_video" name="post_video" style="display:none;"/>
                                        <span id="addpostvideo">
                                        </span>
                                        <a href="#" class=" button-ahead-green status-button" onclick="addmorepostvideo();">Add More Video</a>
                                    </div>
                                </form> 
                                <div class="col-md-4 col-sm-4 margin-right30"> 
                                    <a href="#" id="next_finao_status" class="dropdown-toggle button-track" data-toggle="dropdown">ON TRACK</a>                                    
                                    <ul class="dropdown-menu left dropbox dropbox following-dropdown" style="margin-top: 13px; margin-right: -100px;" role="menu" aria-labelledby="dLabel">
                                        <li style="margin-top: -9px;">
                                            <div class="arrow3"></div>
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
                                <div class="col-sm-6">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A FINAO</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>
                                        <a href="#" class="status-button-ahead status-button" data-toggle="modal" onclick="show_create_finao_popup(); return false;" style="color: #FFF;">CREATE A FINAO</a>
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
                                                            <li><a class="new_post_finao finao_selection<? echo $finao->finao_id; ?>" onclick="addfinaoid(<? echo $finao->finao_id; ?>)" href="#" data-toggle="modal"><span id="finaotext<? echo $finao->finao_id; ?>"><? echo $finao->finao_msg; ?><span></a></li>
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
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" id="finao_next" onclick="show_choose_tile_popup(); return false;">Next</a></div>
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
                                <div class="col-md-6 col-sm-5">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A TILE</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" onclick="closeit_with_finao()" data-toggle="modal"  data-target="">Create</a></div>
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
                                            if($mytile->type == 1) 
                                            {
                                                $tile_name = "";
                                                $tile_name = $mytile->tile_name;
                                                if($tile_name == "")
                                                {
                                                    $tile_name = "-";
                                                }
                                                ?>
                                                    <div class="col-md-6 col-sm-6">                                                        
                                                        <a href="#" onclick="addtileid(<? echo $mytile->tile_id;?>,'<? echo $tile_name; ?>', this); return false;" class="choose_tile_new_finao">
                                                            <img alt="Tile-image" src="<? echo ($mytile->image_urls["0"]->image_url != "" ? $mytile->image_urls["0"]->image_url : $image_path . "no_tile_image.jpg") ?>" class="img-responsive"/>
                                                            <? echo $mytile->tile_name; ?>
                                                        </a>
                                                        <br />
                                                    </div>
                                                <?   
                                            }                                 
                                        }
                                    }
                                ?> 
                            </div>
                        </div>
                        <div class="row unused">UNUSED TILES</div>
                        <div class="modal-footer">
                            <div class="col-md- col-sm-6" style="margin-left: -40px;">
                                <div class=" post-li">
                                    <ul>
                                        <?                                        
                                            if(is_array($mytiles))
                                            {
                                                $prev_tile_id = "";
                                                foreach ($mytiles as $mytile)
                                                {
                                                    if($mytile->type == 0) 
                                                    {
                                                        $tile_name = "";
                                                        $tile_name = $mytile->tile_name;
                                                        if($tile_name == "")
                                                        {
                                                            $tile_name = "-";
                                                        }
                                                        ?>                                           
                                                             <li>
                                                                <a href="#" onclick="addtileid(<? echo $mytile->tile_id;?>,'<? echo $mytile->tile_name; ?>', this); return false;" class="choose_tile_new_finao">
                                                                    <div class="li-img">
                                                                        <img alt="Icon-tile" src="<? echo ($mytile->image_urls["0"]->image_url != "" ? $mytile->image_urls["0"]->image_url : $icon_path."tile.png"); ?>" class="unused-tiles" style="width:22px;">
                                                                        <? echo $mytile->tile_name; ?>
                                                                    </div>                                                                    
                                                                </a>
                                                            </li>    
                                                        <?   
                                                    }                                                                                                               
                                                }
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
                                <div class="col-sm-6 col-md-6">
                                    <div class="text-left orange-text post-finao-hdline">CHOOSE A FINAO</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
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
                                                            <li><a class="new_post_finao finao_selection<? echo $finao->finao_id; ?>" value="<? echo $finao->finao_id; ?>" href="#" data-toggle="modal" data-target=".bs-modal-sm7"><? echo $finao->finao_msg; ?></a></li>
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
                                            <img alt="Profile-image" height="40px" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : "no-image.png"); ?>"  class="img-border">                                            
                                            <span class="updated-by"><? echo ucwords($user_details->fname ." ". $user_details->lname); ?></span>
                                        </div>
                                        <div class="col-md-4 text-right text-fade">just now</div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 col-sm-12">
                                        <div id="post_image_container">
                                        </div>
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
                    $("#")
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
                        <div class="col-md-3 col-sm-3  splash-logo">
                            <a href="index.php">
                                <img alt="Logo" title="Finao" src="<? echo $icon_path."logo-new.jpg"?>" class="img-responsive"/>                                
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-1"></div>
                        <div class="col-md-6 col-sm-8 splash-logo">
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
<span style="display:none;" id="dummypostimage">
<br />
    <span>
        <a href="#" class="upload-img">
            <label for="post_image">Upload an Image</label>
        </a>
        <input type="file" id="post_image" class="post_image" name="post_image[]" style="display:none;" onchange="readPostImageURL(this);"/>
    </span>
</span>

<span style="display:none;" id="dummypostvideo">
<br />
    <span>
        <a href="#" class="upload-video">
            <label for="post_video">Upload an video</label>
        </a>
        <input type="file" id="post_video" class="post_video" name="post_video[]" style="display:none;"/>
    </span>
</span>
<!--term and conditions-->
<!--<div class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">                    
                    <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive">
                </button>
            </div>
            <div class="modal-body">
                <div class="content-page">
                    <h4 class="modal-title orange" id="myModalLabel">Terms &amp; Conditions</h4>
                    <p>Thank you for using finaonation.com.  These Terms of Use (&quot;Terms of Use&quot;) govern your access and use of <span class="orange">both finaonation.com and the FINAO<sup>&reg;</sup> mobile app</span> (collectively, the &quot;Site&quot;).   By accessing, using, or placing an order through the Site, you consent to the Terms of Use listed below.  FINAO<sup>&reg;</sup> reserves the right to add, change, or remove portions of these Terms of Use at any time.  It is the your responsibility to check the Terms of Use each time prior to using the Site.  Continued use of the site is your consent to the latest Terms of Use.</p>
                    <p><span class="orange">Use of Site and Customer Accounts</span></p>
                    <p>Only if you agree to these Terms of Use will FINAO<sup>&reg;</sup> grant you (the &quot;End User&quot;) a personal, non-exclusive, non-transferrable, non-sub-licensable, limited privilege to enter and use the Site. <span class="orange">Any use or access by anyone under the age of 13 is prohibited, unless a parent or legal guardian consents to such use.</span>  Most services offered through the Site require you to create a user account, and to provide complete and accurate information about yourself and your billing information.  You are responsible for maintaining the confidentiality of your account information, including your password, and for all activity that occurs under your account.  You agree to notify FINAO<sup>&reg;</sup> immediately of unauthorized use of your account or password, or other breach of security.  You may be held liable for loss incurred by FINAO<sup>&reg;</sup> or another Site user due to someone else using your password or customer account.  You may not attempt to or in any way gain unauthorized access to the Site.  Should you do so or assisting others in making such attempts, or distributing tools, software, or instructions for that purpose, your customer account will be terminated.</p>
                    <p>All media (downloaded or samples), software, text, images, graphics, user interfaces, music, videos, photographs, trademarks, logos, artwork and other content on the Site (collectively, "Content"), including but not limited to the design, selection, arrangement, and coordination of such Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>.  You may not use any automatic device, program, algorithm, or methodology, or any similar manual process to access, acquire, copy, probe, test, or monitor any portion of the Site or any Content, or in any way reproduce or circumvent the navigational structure or presentation of the Site or any Content.  You may not obtain or attempt to obtain any materials, documents, or information through any means not purposely made available through the Site.  You may not take any action that imposes unreasonably large load on the infrastructure of the Site or any of the systems or networks comprising of or connected to the Site.</p>
                    <p>If you create an account on behalf of a company, organization, or other entity, then both you and that entity warrant that you are authorized as an agent of the entity, and that you agree to and bind the entity to these Terms of Use.</p>
                    <p>You also agree that FINAO<sup>&reg;</sup> may, in its sole discretion and without prior notice to you, terminate your access to the Site and your Account for any reason, including without limitation: (1) attempts to gain unauthorized access to the Site or assistance to others' attempting to do so, (2) overcoming software security features limiting use of or protecting any Content, (3) discontinuance or material modification of the Site or any service offered on or through the Site, (4) violations of this Terms of Use, (5) failure to pay for purchases, (6) suspected or actual copyright infringement, (7) unexpected operational difficulties, or (8) requests by law enforcement or other government agencies. You agree that FINAO<sup>&reg;</sup> will not be liable to you or to any third party for termination of your access to the Site.</p>
                    <p><span class="orange">Acceptable Use Policy</span></p>
                    <p>FINAO<sup>&reg;</sup> provides a safe environment in which we all share and track goals and aspirations.  In order to promote this positive vibe, you agree to adhere to the following Acceptable Use Policy while using this Site.</p>
                    <p>You agree to not post Content that:</p>
                    <ul class="answers">
                        <li>Is sexually explicit or looks to exploit children by exposing inappropriate content;</li>
                        <li>Creates risk of or actual mental or physical injury, death, disfigurement, or loss to any person or property;</li>
                        <li>Is deemed hateful, violent, abusive, racially offensive, defamatory, infringing, threatening, or humiliating;</li>
                        <li>Infringes on a third party&acute;s rights; or</li>
                        <li>Violates or encourages the violation of laws or regulations.</li>
                    </ul>
                    <p><span class="orange">Data Use Policy and Personal Information</span></p>
                    <p>As more fully described in our <a href="index.php?r=site/privacy">Privacy Policy</a>, you must disclose certain Personally Identifiable Information to use our Site, register, and make purchases. As a condition of registering with our Site or making any purchases of any products and/or services or conduct any transactions, you represent that you have first read our <a href="index.php?r=site/privacy">Privacy Policy</a> and consent to the collection, use and disclosure of your Personally Identifiable Information and Non-Personally Identifiable Information as described in our <a href="index.php?r=site/privacy">Privacy Policy</a>. We reserve the right to modify our <a href="index.php?r=site/privacy">Privacy Policy</a>; as a condition of browsing the Site, using any features or making any purchase, you agree that you will first review our <a href="index.php?r=site/privacy">Privacy Policy</a> prior to making any initial or subsequent purchases.</p>
                    <p>While FINAO<sup>&reg;</sup> takes reasonable steps to safeguard and to prevent unauthorized access to your personal information, we cannot be responsible for the acts of those who gain unauthorized access, and we make no warranty, express, implied, or otherwise, that we will prevent unauthorized access to your private information. IN NO EVENT SHALL FINAO<sup>&reg;</sup> OR ITS AFFILIATES BE LIABLE FOR ANY DAMAGES (WHETHER CONSEQUENTIAL, DIRECT, INCIDENTAL, INDIRECT, PUNITIVE, SPECIAL OR OTHERWISE) ARISING OUT OF, OR IN ANY WAY CONNECTED WITH, A THIRD PARTY'S UNAUTHORIZED ACCESS TO YOUR PERSONAL INFORMATION, REGARDLESS OF WHETHER SUCH DAMAGES ARE BASED ON CONTRACT, STRICT LIABILITY, TORT OR OTHER THEORIES OF LIABILITY, AND ALSO REGARDLESS OF WHETHER FINAO<sup>&reg;</sup> WAS GIVEN ACTUAL OR CONSTRUCTIVE NOTICE THAT DAMAGES WERE POSSIBLE.</p>
                    <p><span class="orange">Email Communications</span></p>
                    <p>By establishing an Account with us, and each time you make a purchase through our Site, you grant permission for FINAO<sup>&reg;</sup> to contact you at your e-mail address. To stop receiving our marketing emails, send an e-mail to us at <a href="#" class="orange-link font-14px">askus@finaonation.com</a> or follow the opt-out procedures set forth in such marketing emails. FINAO<sup>&reg;</sup> cannot be held responsible for emails not received due to SPAM filters installed by your Internet Service Provider (ISP), email provider or by you, the Customer. FINAO<sup>&reg;</sup> cannot be held responsible for order delays or failure to receive out of stock or declined notifications created by SPAM filters or other related computer software and/or hardware.</p>
                    <p><span class="orange">Intellectual Property</span></p>
                    <p>All media and Content on the Site is owned or licensed by or to FINAO<sup>&reg;</sup>, and is protected by copyright, trade dress, and trademark laws, and various other intellectual property rights laws. Except as expressly provided in this Terms of Use, no part of the Site and no Content may be reproduced, recorded, retransmitted, sold, rented, broadcast, distributed, published, uploaded, posted, publicly displayed, altered to make new works, performed, digitized, compiled, translated or transmitted in any way to any other computer, website or other medium or for any commercial purpose, without FINAO<sup>&reg;</sup>'s prior express written consent. Except as expressly provided herein, you are not granted any rights or license to patents, copyrights, trade secrets, trade dress, rights of publicity or trademarks with respect to any of the Content, and FINAO<sup>&reg;</sup> reserves all rights not expressly granted hereunder. FINAO<sup>&reg;</sup> expressly disclaims all responsibility and liability for uses by you of any Content obtained on or in connection with the Site.</p>
                    <p>FINAO<sup>&reg;</sup> and FlipWear are registered trademarks, trademarks or service marks of JoMoWaG, LLC &shy; Dba FINAO <sup>&reg;</sup>. All custom graphics, icons, logos and service names are registered trademarks, trademarks or service marks of JoMoWaG, LLC &shy; Dba FINAO<sup>&reg;</sup>. All other trademarks or service marks are property of their respective owners. The use of any FINAO <sup>&reg;</sup> trademark or service mark without FINAO<sup>&reg;</sup>'s express written consent is strictly prohibited.</p>
                    <p>By submitting a design to FINAO<sup>&reg;</sup>, or using logos stored on the site, you warrant and represent that you are the sole, legal owner or licensee of all rights, including copyright, to each copyright, trademark, service mark, trade name, logo, statement, portrait, graphic, artwork, photograph, picture or illustration of any person or any other intellectual property included in such design.</p>
                    <p>Further, you warrant and represent that no part of the design: (a) violates or infringes upon any common law or statutory right of any person or entity, including, but not limited to, rights relating to copyrights, trademarks, contract rights, moral rights or rights of public performance; (b) is the subject of any notice of such infringement you have received; or (c) is subject to any restriction or right of any kind or nature whatsoever which would prevent FINAO<sup>&reg;</sup> from legally reproducing the images or text submitted.</p>
                    <p>You agree to defend, at your sole expense, any claim, suit, or proceeding brought against FINAO<sup>&reg;</sup> which relates to, or is based upon, a claim that any portion of the design infringes or constitutes wrongful use of any copyright, trademark, or other right of any third party, provided that FINAO<sup>&reg;</sup> gives you written notice of any such claim and provides you such reasonable cooperation and assistance as you may require in the defense thereof. You shall pay any damages and costs assessed against FINAO<sup>&reg;</sup> pursuant to such a suit or proceeding. Further, you agree to indemnify and hold FINAO<sup>&reg;</sup> harmless from and with respect to any such loss or damage (including, but not limited to, reasonable attorneys' fees and costs) associated with any such claim, suit or proceeding.</p>
                    <p>All items shown on this web site containing corporate logos or registered trademarks are shown only to illustrate FINAO<sup>&reg;</sup>'s logo reproduction capabilities. Purchase of merchandise from FINAO<sup>&reg;</sup> in no way, shape or form grants you permission to reproduce logos, nor does it transfer, grant or lease ownership of any logos or trademarks to you.</p>
                    <p><span class="orange">Conditions of Sale and Payment Terms.</span></p>
                    <p>To purchase any goods and/or services on our Site, you must (a) be at least eighteen (18) years of age or the applicable state age of majority. Prior to the purchase of any goods or services on our Site, you must provide us with a valid credit card number and associated payment information including all of the following: (i) your name as it appears on the card, (ii) your credit card number, (iii) the credit card type, (iv) the date of expiration and (v) any activation numbers or codes needed to charge your card. By submitting that information to us, you hereby agree that you authorize us to charge your card at our convenience but within thirty (30) days of credit card authorization.</p>
                    <p><span class="orange">Methods of Payment, Credit Card Terms and Taxes.</span></p>
                    <p>All payments must be made by VISA, MasterCard, American Express, or Discover Card. Your card issuer agreement governs your use of your designated card, and you must refer to that agreement and not this Terms of Use to determine your rights and liabilities as a cardholder. YOU, AND NOT FINAO<sup>&reg;</sup>, ARE RESPONSIBLE FOR PAYING ANY UNAUTHORIZED AMOUNTS BILLED TO YOUR CREDIT CARD BY A THIRD PARTY. You agree to pay all fees and charges incurred in connection with your purchases (including any applicable taxes) at the rates in effect when the charges were incurred. Unless you notify FINAO<sup>&reg;</sup> of any discrepancies within sixty (60) days after they first appear on your credit card statement, you agree that they will be deemed accepted by you for all purposes. If FINAO<sup>&reg;</sup> does not receive payment from your credit card issuer or its agent, you agree to pay all amounts due upon demand by FINAO<sup>&reg;</sup> or its agents. You are responsible for paying any governmental taxes imposed on your purchases and shipping, including, but not limited to, sales, use or value-added taxes. FINAO<sup>&reg;</sup> shall automatically charge and withhold the applicable sales tax for orders to be delivered to addresses within Washington State and any other states or localities that it deems are required.</p>
                    <p><span class="orange">Improper/Fraudulent Chargeback fee: $25.00</span></p>
                    <p><strong>Explanation:</strong> Customers issuing chargeback(s) with their Credit Card's issuing Bank without proper cause will be billed any fees incurred by FINAO<sup>&reg;</sup> in disputing the chargeback as well as a $25.00 Chargeback fee. This is necessary to recover the charges we were billed by Visa/MasterCard/Discover Card when the no cause chargeback was issued. With this type of fraud/negligence on the rise, and little recourse given to the Merchant by the credit card issuers, we must protect ourselves from this new type of crime/negligence.</p>
                    <p><span class="orange">Order Acceptance Policy</span></p>
                    <p>Your receipt of an electronic or other form of order confirmation does not signify our acceptance of your order, nor does it constitute confirmation of our offer to sell. FINAO<sup>&reg;</sup> reserves the right at any time after receipt of your order to accept or decline your order for any reason. FINAO<sup>&reg;</sup> further reserves the right any time after receipt of your order, without prior notice to you, to supply less than the quantity you ordered of any item. Your order will be deemed accepted by FINAO<sup>&reg;</sup> upon our shipment of products or delivery of services that you have ordered. All orders placed over $1000.00 (U.S.) must obtain pre-approval with an acceptable method of payment, as established by our credit and fraud avoidance department. We may require additional verifications or information before accepting any order.</p>
                    <p><span class="orange">Jurisdiction and Limited Liability</span></p>
                    <p>These Terms of Use are governed by the laws of the State of Washington.  By using or accessing the Site, you agree to submit personal jurisdiction to the State Courts in King County or the United States District Court for the Western District of Washington.  </p>
                    <p><span class="orange">International Use</span></p>
                    <p>If you are a user of the site that is outside of the United States, you consent to your personal information and any information transferred through the use of the Site, to be transmitted and stored in the United States.  All Site users, even if located or domiciled outside of the United States, consent to these Terms of Use.  </p>
                    <p>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Close</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>-->
<!--term and conditions-->