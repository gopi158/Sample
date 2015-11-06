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


 $current_page = $_GET["r"];
    $current_id = "";
    if($current_page == "site/myprofile")
    {
        $current_id = "myprofile";
    }
    else if($current_page == "site/home")
    {
        $current_id = "home";
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
<script src="<? echo $js_path."jquery.Jcrop.min.js"; ?>"></script>
<script src="<? echo $js_path."jquery.Jcrop.min.js"; ?>"></script>
<link href="<? echo $css_path."jquery.Jcrop.css"; ?>" rel="stylesheet">
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
                
                $(document).on("keyup click","#searchbox",function(){                 
                              $("#searchitems").removeClass("open");
                    if ($("#searchbox").val().length >= 3)
                    {
                        SearchUser();   
                    }                    
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
                
                function addfinaoid(finaoid)
                {
                    $("#postandfinao").find(".finao").remove();
                    $("#finaotitlepreview").html($("#finaotext" + finaoid).html());
                    $("#postandfinao").append('<input type="hidden" style="display:none;" class="finao" name="finao_id" value="' + finaoid + '"/>');
                    $(".new_post_finao").removeClass("selected_finao");
                    $(".finao_selection" + finaoid).addClass("selected_finao");
                    show_post_preview_popup();
                }
                
                $(function(){
                    //$('.carousel').carousel();
                   $(document).on("click",".delete_this",function(){
                      $(this).closest("span").remove();
                   }); 
                });
                
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
                            show_alert(data);
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
                        show_alert("Please enter some text to post!");
                        return;
                    }
                    $("#post_image_container").html("");
                    $("#single_image_preview").html();
                    if ($(".carousel_preview").length == 0)
                    {
                        $("#carousel_preview").hide();
                        $("#single_image_preview").hide();
                    }
                    else if ($(".carousel_preview").length ==1)
                    {
                        $("#carousel_preview").hide();
                        
                        $("#single_image_preview").show();
                        $("#single_image_preview").html("<div><div style='width: 450px; height: 450px; overflow: hidden;'>" + $(".carousel_preview").first().html() + "</div></div>");
                    }
                    else
                    {
                        $("#single_image_preview").hide();
                        
                        $("#carousel_preview").show();
                        $(".carousel_preview").each(function(){
                           $("#post_image_container").append("<div class='item'><div style='width: 620px; height: 620px; overflow: hidden;'>" + $(this).html() + "</div></div>");
                           //$("#post_image_container").append("<div class='item'><img id='preview_post_image' src='"+ $(this).attr("src") +"' style='width: 100%; height: auto;'/></div>");
                        });
                        $("#post_image_container").find(".item").first().addClass("active"); 
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
                        show_alert("Please enter the FINAO title!");
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
                    $("#post_image_container").html("");                    
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
                        show_alert ("Select a tile.");
                        return false;
                    }
                    $("#ajax_loader").show();                                
                    $("#postandfinao").attr("action", "index.php?r=site/submitfinao");
                    $("#postandfinao").submit();
                }
                $("#post_image").change(function() {
                   readPostImageURL(this);
                });
                
                function ImageCropUpdate(co)
                {
                    if (co != undefined)
                    {
                        var rx = 450 / co.w;
                        var ry = 450 / co.h;
                        var img_preview_element = $(".preview_image").eq(-2).find(".carousel_preview").find("img")[0]
                        $(".preview_image").eq(-2).find(".crop_args").html("<input type='hidden' name='x[]' value='" + co.x + "'>" +
                                                                     "<input type='hidden' name='y[]' value='" + co.y + "'>" +
                                                                     "<input type='hidden' name='w[]' value='" + co.w + "'>" +
                                                                     "<input type='hidden' name='h[]' value='" + co.h + "'>");
                        $(".preview_image").eq(-2).find(".carousel_preview").find("img").css({
                                                                    width: Math.round(rx * img_preview_element.naturalWidth) + 'px',
                                                                    height: Math.round(ry * img_preview_element.naturalHeight) + 'px',
                                                                    marginLeft: '-' + Math.round(rx * co.x) + 'px',
                                                                    marginTop: '-' + Math.round(ry * co.y) + 'px'
                        });
                    }
                    else
                    {
                        $(".preview_image").eq(-2).find(".crop_args").html("<input type='hidden' name='x[]' value='0'>" +
                                                                     "<input type='hidden' name='y[]' value='0'>" +
                                                                     "<input type='hidden' name='w[]' value='0'>" +
                                                                     "<input type='hidden' name='h[]' value='0'>");
                        $(".preview_image").eq(-2).find(".carousel_preview").find("img").css({
                                                                    width: '487px',
                                                                    height: '365px',
                                                                    marginLeft: "",
                                                                    marginTop: ""
                        });
                    }
                    return true;
                }
                function Crop_Complete()
                {
                    $(".bs-modal-sm9").modal("hide");
                    $("#post_crop_target").remove();
                }
                function readPostImageURL(input) {                     
                    //alert (input.files);
                   if (input.files && input.files[0]) {
                       var reader = new FileReader();
                       reader.onload = function(e) {
                           $(".preview_image").last().append("<div class='crop_args'>" +
                                                                 "<input type='hidden' name='x[]' value='0'>" +
                                                                 "<input type='hidden' name='y[]' value='0'>" +
                                                                 "<input type='hidden' name='w[]' value='0'>" +
                                                                 "<input type='hidden' name='h[]' value='0'>" +
                                                             "</div>" +
                                                             "<div class='carousel_preview' style='width: 600px; height: 600px; display: none;'>" +
                                                                "<img src='"+ e.target.result +"' style='width: 487px; height: 365px; padding-top:5px;'/>" +
                                                             "</div>" +
                                                             "<img class='for_carousel' src='"+ e.target.result +"' style='width: 50px; height: 50px; padding-top:5px;'/><img class='delete_this' src='<? echo $icon_path."delete.png"?>'/>");
                           $(".preview_image").last().find(".imagetype").attr("id", "");
                           $("#for_images").append('<span class="preview_image">' + 
                                                    '<input type="file" class="imagetype" id="post_image" name="post_image[]" style="display:none;" onchange="readPostImageURL(this);"/>' +
                                                    '</span>');

                           $("#crop_preview").html("<img id='post_crop_target' src='"+ e.target.result +"' style='width: 550px; height: auto;' />");
                           $(".bs-modal-sm9").modal("show");
                           $("#post_crop_target").Jcrop({
                                boxWidth : "550",
                                boxHeight : "auto",
                                aspectRatio: 1,
                                onSelect : ImageCropUpdate,
                                onRelease : ImageCropUpdate
                           });
                       }
                       reader.readAsDataURL(input.files[0]);
                   }
                }
                
                function create_finao()
                {
                    $(".bs-modal-sm7").modal("hide");
                    $(".bs-modal-sm1").modal("show");
                }                
              
                function readvideofile()
                {                    
                    $(".preview_video").last().append("<img class='for_carousel' src='<? echo $image_path."previewvideo.png"; ?>' style='width: 50px; height: 50px; padding-top:5px;'/><img class='delete_this' src='<? echo $icon_path."delete.png"?>'/>");                       
                    $(".preview_video").find(".videotype").last().attr("id", "");                           
                    $("#for_images").append('<span class="preview_video"><input type="file" class="videotype" id="post_video" name="post_video[]" style="display:none;" onchange="readvideofile();"/></span>');
                    $("#post_image_container").find(".item").last().removeClass("active");
                    $("#post_image_container").append("<div class='item'><img id='preview_post_image' src='<? echo $image_path."previewvideo.png"; ?>' style='width: 100%; height: auto;'/></div>");
                    $("#post_image_container").find(".item").last().addClass("active");
                }
            </script> 
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container" style="box-shadow: none!important; border: 0;">
                    <div class="row">
                        <div class="col-md-5 col-sm-3" style="padding-left: 0;">
                            <div class="header-left">
							
								 <a <? echo ($current_id == "home" ? "class='home-header-current'" : ""); ?> class="home-header" href="index.php?r=site/home" title="Home">HOME</a>
                                <a <? echo ($current_id == "myprofile" ? "class='profile-header-current'" : ""); ?> class="profile-header" href="index.php?r=site/myprofile" title="Profile">PROFILE</a>
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
										    <a href="#popupBottom-notifications" role="button" class="" data-container="body" data-toggle="modal-popover" data-placement="bottom">
                                        <img src="content/images/icons/icon-notifications.png" title="Notifications"></a>

										<!--    <a id="dNotifications" href="#" class="dropdown-toggle" data-toggle="dropdown" title="Notifications">
                                                <img alt="Icon-notification" src="<? echo $icon_path."icon-notifications.png"; ?>">
                                            </a>-->
                                        
										    <!--Header notifications-->
                                            <ul class="dropdown-menu notifications" style="margin-top: 22px; margin-left: -150px;" role="menu" aria-labelledby="dNotifications">
                                                <li>
                                                    <div class="arrow3"></div>
                                                </li>
                                              
                                            </ul>
                                            <!--Header notifications-->
                                        </li>
                                       
									    <li class="dropdown" id="searchitems">    
										                                       
                                          <input class="imagesearch no-border" type="image" src="content/images/icons/search.png">
                                            <input type="search" class="search-box no-border" name="searchword" id="searchbox" placeholder="Search"/> 
                                            <ul class="dropdown-menu" id="searchresults" role="menu" aria-labelledby="dSearch" style="width:340px; margin-top: 25px!important; auto; overflow:visible; margin-left: -15px;"></ul>
                                        </li> 
                                       

									   
									    <li class="dropdown">

										 <a href="#popupBottom-settings" role="button" class="" data-toggle="modal-popover" data-placement="bottom">
                                        <img src="content/images/icons/icon-settings.png" class="no-border" title="Settings"/></a>

										<!--
                                            <a id="dSettings" href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" title="Settings">
                                                <img alt="Icon-settings" src="<? echo $icon_path."icon-settings.png"; ?>">
                                            </a>
											-->
                                            <!--header settings-->
                                            
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
						 <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
						   <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive" />
						  </button>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-left orange-text post-finao-hdline">POST</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" onclick="show_finaolist_popup(); return false;" id="post_next">Next</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body modal-body-create-finao">
                            <textarea class="textarea-post" rows="6" id="post_text" placeholder="Start Typing..."></textarea>							
                        </div>
                        <form id="postandfinao" method="post" target="postandfinaoframe" enctype="multipart/form-data">
                            <div>
                                <style>
                                    .preview_image imagetype:last
                                    {
                                        display: none;
                                    }
                                    .preview_video videotype:last
                                    {
                                        display: none;
                                    }
                                </style>
                                <div id="for_images">                                
                                    <span class="preview_image">
                                        <input type="file" id="post_image" class="imagetype" name="post_image[]" style="display:none;" onchange="readPostImageURL(this);"/>
                                    </span>
                                    <span class="preview_video">
                                        <input type="file" id="post_video" class="videotype" name="post_video[]" style="display:none;" onchange="readvideofile();"/>
                                    </span>                                
                                </div>                            
                            </div>
                            <div class="modal-footer">
                                <div class="row col-md-12 col-sm-12"> 
                                        <div class="col-md-4 margin-left30 left col-sm-4">
                                            <span>
                                                <a href="#" class="upload-img">
                                                    <label for="post_image">Upload Images</label>
                                                </a> 
                                            </span>
                                            <!--<span id="addpostimage"></span>-->
                                            <!--<a href="#" class=" button-ahead-green status-button" onclick="addmorepostimage();">Add More Image</a>                                        -->
                                            <!--<input type="button" value="Add More Image" class="button-track" onclick="addmorepostimage();"/>-->
                                        </div>                                    
                                        <div class="col-md-4 col-sm-4">
                                            <a href="#" class="upload-video">
                                                <label for="post_video">Upload Videos</label>
                                            </a>                                        
                                        </div>
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
                        </form>
                    </div>
                </div>
            </div>
            <!--finao post pop up 1 end -->
            <!--modal for preview -->
             <div class="modal fade bs-modal-sm9" role="dialog" aria-labelledby="PostCropPreview" aria-hidden="true">
                <div class="modal-dialog modal-sm1">
                    <div class="modal-content">
                        <div class="modal-header">
						 <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
						   <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive" />
						  </button>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-left orange-text post-finao-hdline">CROP</div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" onclick="Crop_Complete(); return false;" id="post_next">Done</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                        
                            <div class="clear-50px" id="crop_preview">
                            </div>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
            <!--modal for preview -->
            <!--finao post pop up 2 -->
            <div class="modal fade bs-modal-sm6" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
						 <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
						   <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive" />
						  </button>
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
                                        <a href="#" class="create-finao oswald-font font-25px" data-toggle="modal" onclick="show_create_finao_popup(); return false;">CREATE A FINAO</a>
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
                                                        <li style="color : #131313; cursor : default;"><? echo $finao_list; ?></li>
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
                        <div class="modal-body modal-body-create-finao">
                            <textarea class="textarea-post font-23px" class="finaomodel" rows="5" maxlength="225" id="finao_title" placeholder='"I will..."'></textarea>
							<div class="row text-align-right text-fade margin-right-5px">225</div>
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
                                                    <div class="col-lg-3 col-md-5 col-sm-7">                                                        
                                                        <a href="#" onclick="addtileid(<? echo $mytile->tile_id;?>,'<? echo $tile_name; ?>', this); return false;" class="choose_tile_new_finao">
                                                            <img alt="Tile-image" src="<? echo ($mytile->image_urls["0"]->image_url != "" ? $mytile->image_urls["0"]->image_url : $image_path . "no_tile_image.jpg") ?>"  style="height:180px!important; height:180px!important;"/>
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
                        	<!--Left Side of the unused tiles column-->
                            <div class="col-md- col-sm-6" style="margin-left: -40px;">
                                <div class=" post-li">
                                    <ul>
                                        <?                                        
                                            if(is_array($mytiles))
                                            {
                                                $prev_tile_id = "";
                                                $leftCounter = 1;
                                                foreach ($mytiles as $mytile)
                                                {
                                                    if($mytile->type == 0 && $leftCounter % 2 == 1) 
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
                                                    $leftCounter++;                                                                                                               
                                                }
                                            }
                                        ?> 
                                    </ul>
                                </div>
                            </div>
                            
                            <!--Right side of the unused tiles column-->
                            <div class="col-md-6 col-sm-6">
                                <div class=" post-li">
                                    <ul>
                                        <?                                        
                                            if(is_array($mytiles))
                                            {
                                                $prev_tile_id = "";
                                                $rightCounter = 1;
                                                foreach ($mytiles as $mytile)
                                                {
                                                    if($mytile->type == 0 && $rightCounter % 2 == 0) 
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
                                                    $rightCounter++;                                                                                                              
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
						 <button type="button" class="close close-opacity no-border" style="margin-right: -30px; margin-top: -30px;" data-dismiss="modal" aria-hidden="true">
						   <img alt="Icon-close" src="<? echo $icon_path."icon-close.png"?>" class="img-responsive" />
						   </button>
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
                                        <a href="#" class="create-finao" data-toggle="modal" onclick="create_finao(); return false;" >CREATE A FINAO</a>
                                    </p>
                                    <div class="entered-finaos fade-text">
                                        <ul>
                                            <?
                                                if(is_array($finao_list))
                                                {
                                                    foreach ($finao_list as $finao)
                                                    {
                                                        ?>
                                                            <li><a class="new_post_finao finao_selection<? echo $finao->finao_id; ?>" value="<? echo $finao->finao_id; ?>" href="#" data-toggle="modal" onclick="addfinaoid(<? echo $finao->finao_id; ?>);"><? echo $finao->finao_msg; ?></a></li>
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
                                            <img alt="Profile-image" height="40px" src="<? echo ($user_details->profile_image != "" ? $user_details->profile_image : "no-image.png"); ?>"  class="post-image">                                            
                                            <span class="updated-by-post"><? echo ucwords($user_details->fname ." ". $user_details->lname); ?></span>
                                        </div>
                                        <div class="col-md-4 text-right time-since-posted text-fade margin-top-5px">just now</div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 col-sm-12">
                                        <div>
                                            <div id="single_image_preview">
                                            </div>
                                            <div id="carousel_preview" class="carousel slide row" data-ride="carousel">                                                
                                                <div class="carousel-inner" id="post_image_container">
                                                    
                                                </div>
                                                <a class="left carousel-control" href="#carousel_preview" data-slide="prev">
                                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                                </a>
                                                <a class="right carousel-control" href="#carousel_preview" data-slide="next">
                                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                                </a>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top: 15px; padding-left: 0;">
                                        <p class="finao-title-text post-finao">                                            
                                            <img alt="Icon-finao" src="<? echo $icon_path."icon-finao.png"; ?>">
                                            <strong id="finaotitlepreview"></strong>
                                        </p>
                                        <p class="finao-activity-text post-caption" id="post_preview_text"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- finao post pop up 5 end-->            
            <iframe id="postandfinaoframe" style="height:500px; width:500px; display: none;" name="postandfinaoframe" style="display: none;"></iframe>
            <!--settings-->
            <div id="popupBottom-settings" style="margin-top: 25px; margin-left: -50px; max-height:250px; position: fixed;" container=".body" class="popover bottom" aria-hidden="false">
                <div class="arrow" style="margin-left:40px;"></div>
                    <div class="popover-content left">
                        <li>
                            <div align="left" class="devider-header">
                                <img alt="Icon-edit" src="<? echo $icon_path."user.png";?>" style="padding-left: 10px">
                                <span style="padding-left: 10px; margin-right:30px;">
                                    <a class="settings_menu" href="index.php?r=site/edit_profile">
                                        Edit My Profile
                                    </a>
                                </span>
                            </div>
                        </li>
                    <li>
                        <div align="left" class="devider-header">
                            <img alt="Icon-tagnotes" src="<? echo $icon_path."icon_tagnote.png"; ?>" style="padding-left: 10px;">
                            <span style="padding-left: 10px; margin-right:30px;"><a class="settings_menu" href="index.php?r=site/tagnotes">Tagnotes</a></span>
                        </div>
                    </li>
                    <li>
                        <div align="left" class="devider-header">
                            <img alt="Icon-globe" src="<? echo $icon_path."globe.png"; ?>" style="padding-left: 10px;">
                            <span style="padding-left: 10px; margin-right:30px; "><a class="settings_menu" href="#" data-toggle="modal" data-target=".bs-modal-lg-privacy">Privacy</a></span>
                        </div>
                    </li>
                    <li>
                        <div align="left" class="devider-header">
                            <img alt="Icon-bell" src="<? echo $icon_path."bell.png"; ?>" style="padding-left: 10px;">
                            <span style="padding-left: 10px; margin-right:30px;"><a class="settings_menu" href="#">Notifications</a></span>
                        </div>
                    </li>
                    <li>
                        <div class="link-log" align="left">
                            <a class="settings_menu" href="index.php?r=site/logout"><span style="padding-left: 10px; margin-right:30px;">Log out</span></a>
                        </div>
                    </li>
                </div>
            </div>
            <!--settings-->
            <div id="popupBottom-notifications" style="margin-top: 22px; width:300px; margin-left: -115px; position:fixed; " container=".body" class="popover bottom" aria-hidden="false">
                <div class="arrow" style="margin-left:100px"></div>
                <div class="popover-content" >
                <? 
                    if(is_array($mynotifications))
                    {
                        foreach ($mynotifications as $mynotification)
                        {
                            ?>
                                <li>
                                    <div align="left" class="devider-header">
                                        <a href="index.php?r=site/public_finao_posts&uname=<? echo $mynotification->uname; ?>">
                                            <div class="row font-15px">
                                                <div class="col-md-2 col-sm-2">
                                                    <img alt="Profile-image" style='height:40px;width:40px;' alt="Image" src="<? echo ($mynotification->profile_image != "" ? $mynotification->profile_image : $image_path."no-image.png"); ?>" />
                                                </div>
                                                <div class="col-md-10 col-sm-10 notifications-text"><span><? echo $mynotification->action; ?></span></div>
                                            </div>
                                            <div class="row" align="right"><span class="text-fade notifications-postedon"><? echo ($mynotification->createddate);?></span></div>
                                        </a>
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
                                    <div class="row font-15px">
                                        <div class="col-md-2 col-sm-2"></div>
                                        <div class="col-md-10 col-sm-10 notifications-text"><span><? echo $mynotifications; ?></span></div>
                                    </div>
                                    <div class="row" align="right"><span class="text-fade notifications-postedon"></span></div>
                                </div>
                            </li>    
                        <?
                    }
                ?>
                </div>
            </div>
            <div id="popupBottom-search" style="margin-top: 22px; margin-left: 5px;" class="popover bottom" aria-hidden="true">
                <div class="arrow"></div>
                <div class="popover-content">
                    <ul class="dropdown-menu" id="searchresults" role="menu" aria-labelledby="dSearch" style="width:370px; margin-top: 22px; auto; margin-left: 0px;"></ul>
                </div>
            </div>
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
                        show_alert ("Please enter first name.");                        
                        $("#fname").focus();                    
                        $("#fname").addClass("control-error");
                        return false;
                    }
                    
                    if($("#lname").val() == "")
                    {
                        show_alert ("Please enter last name.");                        
                        $("#lname").focus();
                        $("#lname").addClass("control-error");
                        return false;
                    }
                    
                    if($("#email_signup").val() == "")
                    {
                        show_alert ("Please enter email address.");
                        $("#email_signup").focus();
                        $("#email_signup").addClass("control-error");
                        return false;                        
                    }
                    
                    if($("#email_signup").val() != "")
                    {  
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#email_signup").val()))
                        {
                            show_alert("Please enter valid email address.");
                            $("#email_signup").focus();
                            $("#email_signup").addClass("control-error");
                            return false;
                        }
                    }
                    
                    if($("#password").val() == "")
                    {
                        show_alert ("Please enter password.");
                        $("#password").focus();
                        $("#password").addClass("control-error");                        
                        return false;
                    }
                    
                    if($("#reenter_password").val() == "")
                    {
                        show_alert ("Re enter password.");
                        $("#reenter_password").focus();
                        $("#reenter_password").addClass("control-error");
                        return false;
                    }
                    
                    if($("#password").val() != $("#reenter_password").val())
                    {     
                        show_alert ("Passwords does not match.");
                        $("#reenter_password,#password").addClass("control-error");                        
                        return false;
                    }
                    $("#")
                    $.get("index.php?r=site/submitsignup",$("#signup").serialize(),function(data){ 
                            if(data == "invalid_captcha_code")
                            {
                                show_alert("Please enter captcha words correctly");
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
                        show_alert ("Please enter email");
                        $("#forgot_email").focus();
                        $("#forgot_email").addClass("control-error");
                        return false;
                    }
                    if($("#forgot_email").val() != "")
                    {  
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#forgot_email").val()))
                        {
                            show_alert("Please enter valid email address.");
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
                        show_alert("Please enter email address.");
                        $("#login_email").focus();
                        $("#login_email").addClass("control-error");
                        return false;
                    }
                    if($("#login_email").val() != "")
                    {
                        var email_pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                        if (!email_pattern.test($("#login_email").val()))
                        {
                            show_alert("Please enter valid email address.");
                            $("#login_password").focus();
                            //$("#login_password").addClass('has-error');
                            return false;
                        }
                    }
                    if($("#login_password").val() == "")
                    {
                        show_alert("Please enter password.");
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
                            show_alert ("Invalid username/password.");
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
<?
    //include_once("alert_modal.php");
?>

<div class="modal fade bs-modal-lg-privacy" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display:none!important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">      
      <div class="modal-body">
        <div class="content-page">
		<div class="orange font-20px padding-10pixels">
                      <span class="left">Privacy Policy</span>
                      <span class="right">
                        <a href="">
                          <img src="http://cdn.finaonation.com/images/back.png" width="60">
                        </a>
                      </span>
                    </div>
                    <div class="clear"></div>
        		
            <p><strong>We use the latest technologies to ensure that your email address and all personal information is safe.</strong></p>
            <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>and/or its subsidiaries, as owner(s) of this website, strives to offer its visitors the many advantages of Internet technology and to provide an interactive and personalized experience. We may use Personally Identifiable Information (your name, email address, street address and telephone number) subject to the terms of this privacy policy.</p>
             <p><strong>How we gather information from users</strong></p>   
             <p>How we collect and store information depends on the page you are visiting, the activities in which you elect to participate and the services provided. </p>
             <p>Like most Web sites, JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, also collects information automatically and through the use of electronic tools that may be transparent to our visitors. For example, we may log the name of your Internet Service Provider or use cookie technology to recognize you and hold information from your visit. Among other things, the cookie may store your user name and password, sparing you from having to re-enter that information each time you visit, or may control the number of times you encounter a particular advertisement while visiting our site.</p>
             <p><strong>What we do with the information we collect</strong></p>
             <p>Like other Web publishers, we collect information to enhance your visit and deliver more individualized content and advertising.
Aggregated Information (information that does not personally identify you) may be used in many ways. For example, we may combine information about your usage patterns with similar information obtained from other users to help enhance our site and services (e.g., to learn which pages are visited most or what features are most attractive). Aggregated Information may occasionally be shared with our advertisers and business partners. Again, this information does not include any Personally Identifiable Information about you or allow anyone to identify you individually.</p>
     
             <p><span class="orange">Information we share</span></p>
            <p>We do not share personal information with companies, organizations and individuals outside of FINAO unless one of the following circumstances apply:</p>
                <ul class="answers">
                    <li class="orange">With your consent</li>
                </ul>
                <p style="padding-left:25px;">We will share personal information with companies, organizations or individuals outside of FINAO when we have your consent to do so. We will require opt-in consent for the sharing of any sensitive personal information</p>
                
                <ul class="answers">
                    <li class="orange">With domain administrators</li>
                </ul>
                <p style="padding-left:25px;">If your FINAO Account is managed for you by a domain administrator (for example, for FINAO Apps users) then your domain administrator and resellers who provide user support to your organization will have access to your FINAO Account information (including your email and other data). Your domain administrator may be able to:</p>
               
                   <ul class="answers">
                    <li style="padding-left:50px; padding-bottom:5px;">View statistics regarding your account, like statistics regarding applications you install.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Change your account password.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Suspend or terminate your account access.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Access or retain information stored as part of your account.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Receive your account information in order to satisfy applicable law, regulation, legal process or enforceable governmental request.</li>
                    <li style="padding-left:50px;">Restrict your ability to delete or edit information or privacy settings.</li>
                </ul>
                
                <ul class="answers">
                    <li class="orange">For external processing</li>
                </ul>
                <p style="padding-left:25px;">We provide personal information to our affiliates or other trusted businesses or persons to process it for us, based on our instructions and in compliance with our Privacy Policy and any other appropriate confidentiality and security measures.</p>
                
                <ul class="answers">
                    <li class="orange">For legal reasons</li>
                </ul>
                <p style="padding-left:25px;">We will share personal information with companies, organizations or individuals outside of FINAO if we have a good-faith belief that access, use, preservation or disclosure of the information is reasonably necessary to:</p>
                <ul class="answers">
                    <li style="padding-left:50px; padding-bottom:5px;">Meet any applicable law, regulation, legal process or enforceable governmental request.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Enforce applicable Terms of Service, including investigation of potential violations.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Detect, prevent, or otherwise address fraud, security or technical issues.</li>
                    <li style="padding-left:50px; padding-bottom:5px;">Protect against harm to the rights, property or safety of FINAO, our users or the public as required or permitted by law.</li>
                </ul>
                <p>We may share aggregated, non-personally identifiable information publicly and with our partners - like publishers, advertisers or connected sites. For example, we may share information publicly to show trends about the general use of our services.</p>
              <p>If FINAO is involved in a merger, acquisition or asset sale, we will continue to ensure the confidentiality of any personal information and give affected users notice before personal information is transferred or becomes subject to a different privacy policy.</p>
              <p>We may use Personally Identifiable Information collected on JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup> and/or its subsidiaries, as owner(s) of this website, to communicate with you about your registration and customization preferences; our Terms of Service and privacy policy; services and products offered by JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, and other topics we think you might find of interest. </p>
              
              <p>Personally Identifiable Information collected by JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, may also be used for other purposes, including but not limited to site administration, troubleshooting, processing of e-commerce transactions, administration of sweepstakes and contests, and other communications with you. In certain cases, you can choose not to provide us with information, for example by setting your browser to refuse to accept Certain third parties who provide support for the operation of our site (our Web hosting service, our shopping cart providers and fulfillment partners, for example) and for our business (marketing services for example) may also access such information. We will use your information only as permitted by law. In addition, from time to time as we continue to develop our business, we may sell, buy, merge or partner with other companies or businesses. In such transactions, user information may be among the transferred assets. If you do not wish your information to be used by third parties for non-order related services (such as marketing), please contact us at the email or U.S. mail addresses below.</p>
              
              <p>We may also disclose your information in response to a court order, at other times when we believe we are reasonably required to do so by law, in connection with the collection of amounts you may owe to us, and/or to law enforcement authorities whenever we deem it appropriate or necessary. Please note we may not provide you with notice prior to disclosure in such cases.</p>
              
              <p><span class="orange">Affiliated sites, linked sites and advertisements</span></p>
              <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, expects its partners, advertisers and affiliates to respect the privacy of our users. Be aware, however, that third parties, including our partners, advertisers, affiliates and other content providers accessible through our site, may have their own privacy and data collection policies and practices. For example, during your visit to our site you may link to, or view as part of a frame on a JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, page, certain content that is actually created or hosted by a third party. Also, through JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, you may be introduced to, or be able to access, information, Web sites, features, contests or sweepstakes offered by other parties.</p>
              <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, is not responsible for the actions or policies of such third parties. You should check the applicable privacy policies of those third parties when providing information on a feature or page operated by a third party.</p>
              <p>While on our site, our advertisers, promotional partners or other third parties may use cookies or other technology to attempt to identify some of your preferences or retrieve information about you. For example, some of our advertising is served by third parties and may include cookies that enable the advertiser to determine whether you have seen a particular advertisement before. Other features available on our site may offer services operated by third parties and may use cookies or other technology to gather information. JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, does not control the use of this technology by third parties or the resulting information, and is not responsible for any actions or policies of such third parties.</p>
                <p>You should also be aware that if you voluntarily disclose Personally Identifiable Information on message boards or in chat areas, that information can be viewed publicly and can be collected and used by third parties without our knowledge and may result in unsolicited messages from other individuals or third parties. Such activities are beyond the control of JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, and this policy.</p>
                
                <p><span class="orange">Children</span></p>
                <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, does not knowingly collect or solicit Personally Identifiable Information from or about children under 13 except as permitted by law. If we discover we have received any information from a child under 13 in violation of this policy, we will delete that information immediately. If you believe JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, has any information from or about anyone under 13, please contact us at the address listed below.</p>
                
                <p><span class="orange font-16px">How to Stop email Communication from Us</span></p>
                <p>If you do not want to receive commercial/promotional email from us, please let us know by utilizing the unsubscribe option available at the bottom of any of our email communications, by accessing the form <a href="mailto:unsubscribe@finaonation.com?Subject=Please Unsubscribe me!!" target="_blank" class="orange-link font-14px">unsubscribe@finaonation.com</a>, by calling us at PHONE or by writing to us at: JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, <span class="orange">13024 Beverly Park Rd Suite 201, Mukilteo WA 98275</span></p>
                
                <p><span class="orange">Changes to this Policy</span></p>
                <p>JoMoWaG, LLC - Dba FINAO<sup>&reg;</sup>, and/or its subsidiaries, as owner(s) of this website, reserves the right to change this policy at any time. Please check this page periodically for changes. Your continued use of our site following the posting of changes to these terms will mean you accept those changes. Information collected prior to the time any change is posted will be used according to the rules and laws that applied at the time the information was collected.</p>
                
                <p><span class="orange">Governing law</span></p>
                <p>This policy and the use of this Site are governed by Washington law. If a dispute arises under this Policy we agree to first try to resolve it with the help of a mutually agreed-upon mediator in the following location: Snohomish, Washington. Any costs and fees other than attorney fees associated with the mediation will be shared equally by each of us.</p>
                <p>If it proves impossible to arrive at a mutually satisfactory solution through mediation, we agree to submit the dispute to binding arbitration at the following location: Snohomish, Washington, under the rules of the American Arbitration Association. Judgment upon the award rendered by the arbitration may be entered in any court with jurisdiction to do so.</p>
                <p>This statement and the policies outlined herein are not intended to and do not create any contractual or other legal rights in or on behalf of any party.</p>
                <p>If it proves impossible to arrive at a mutually satisfactory solution through mediation, we agree to submit the dispute to binding arbitration at the following location: Snohomish, Washington, under the rules of the American Arbitration Association. Judgment upon the award rendered by the arbitration may be entered in any court with jurisdiction to do so.</p>
                <p>This statement and the policies outlined herein are not intended to and do not create any contractual or other legal rights in or on behalf of any party.</p>
			</div>
      </div>
    </div>
  </div>
</div>
<!--privacy modal-->