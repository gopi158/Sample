<?
    include ("header.php");
    include ("configuration/configuration.php");
?>
<script src="<? echo $js_path."jquery.Jcrop.min.js"; ?>"></script>
<script src="<? echo $js_path."jquery.Jcrop.min.js"; ?>"></script>
<link href="<? echo $css_path."jquery.Jcrop.css"; ?>" rel="stylesheet">
<script>
    function validateform()
    {
        if($("#name").val() == "")
        {
            show_alert("Please enter name.");
            return false;
        }
        
        if($("#email").val() == "")
        {
            show_alert("Please enter email.");
            return false;
        }
        
        if($("#password").val() != "")
        {
            if($("#password").val() != $("#reenter_password").val())
            {
                show_alert("Passwords are not same.");
                return false;
            }
        }
        
        if($("#bio").val().length > 2000)
        {
            show_alert("Your bio is limited to 2000 characters.");
            return false;
        }
        return true;    
    }
    
    $("#profile_image").change(function() {
       readURL(this);
    });
    
    function crop_image_complete()
    {
        $(".bs-modal-sm-edit").modal("hide");
        $("#image_preview").html("");
    }
    
    function readURL(input)
    {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
               //$("#profile_image_container").html("<img id='preview_profile_image' src='"+ e.target.result +"' style='width: 100%; height: auto;'/>");
               $("#profile_image_container").html("<div style='width: 102px; height: 102px; overflow: hidden;'><img id='preview_profile_image' src='"+ e.target.result +"'/></div>");
               $("#image_preview").html("<img id='preview_profile' src='"+ e.target.result +"' style='width: 550px; height: auto;'/>");
               $(".bs-modal-sm-edit").modal("show");
               cropimage();
           }

           reader.readAsDataURL(input.files[0]);
       }
    }
   
   function cropimage()
   {    
      $('#preview_profile').Jcrop({
            //onChange: showPreview1,
            boxWidth : "550",
            boxHeight : "auto",            
            onSelect: updateCoords,
            aspectRatio: 1
        });
   }
   
    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
        showPreview1(c);
    };

    function checkCoords()
    {
        if (parseInt($('#x').val())) return true;
        show_alert('Please select a crop region then press submit.');
        return false;
    };
   function showPreview1(coords)
    {
        var preview_profile_image = $('#preview_profile_image')[0]
        var rx = 102 / coords.w;
        var ry = 102 / coords.h;
        $("#profile_image_container").css("overflow","hidden");
        $('#preview_profile_image').css({
            width: Math.round(rx * preview_profile_image.naturalWidth) + 'px',
            height: Math.round(ry * preview_profile_image.naturalHeight) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });
    }
    
    $("#profile_banner_image").change(function() {
       readBannerURL(input);
    });
    
    function readBannerURL(input)
    {
       if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e){
                $("#banner_image").html("");
                $("#banner_image").html("<div style='width: 233px; height: 112px; overflow: hidden;'><img id='preview_banner_image' src='"+ e.target.result +"'/></div>");
                $("#image_preview").html("<img id='preview_banner' src='"+ e.target.result +"' style='width: 550px; height: auto;'/>");
                $(".bs-modal-sm-edit").modal("show");
               /// $("#banner_image").html("<img id='preview_banner_image' src='"+ e.target.result +"' style='width: 100%; height: auto;'/>");
                cropbannerimage()
           }

           reader.readAsDataURL(input.files[0]);
       }
    }
    
   function cropbannerimage()
   {    
      $('#preview_banner').Jcrop({
            onSelect: updateBannerCoords,
            boxWidth : "550",
            boxHeight : "auto",            
            aspectRatio: 1
        });
   }
   
   function updateBannerCoords(coords)
    {
        $('#bannerx').val(coords.x);
        $('#bannery').val(coords.y);
        $('#bannerw').val(coords.w);
        $('#bannerh').val(coords.h);
        var preview_banner_image = $('#preview_banner_image')[0]
        var rx = 233 / coords.w;
        var ry = 112 / coords.h;
        $('#preview_banner_image').css({
            width: Math.round(rx * preview_banner_image.naturalWidth) + 'px',
            height: Math.round(ry * preview_banner_image.naturalHeight) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });
    };
    
   
   
</script>
<style type="text/css">
/*  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }  */
</style>

<style type="text/css">
/*.jcrop-holder #preview-pane {
  display: block;
  position: absolute;
  z-index: 2000;
  top: 10px;
  right: -280px;
  padding: 6px;
  border: 1px rgba(0,0,0,.4) solid;
  background-color: white;

  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;

  -webkit-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
  box-shadow: 1px 1px 5px 2px rgba(0, 0, 0, 0.2);
}

#preview-pane .preview-container {
  width: 150px;
  height: 150px;
  overflow: hidden;
}   */

</style>
 <div class="container white-background">
    <div class="content-wrapper"  style="margin-top: 23px; ">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-5" style="height: 100%;">
                <div>
                    <div class="entered-finaos ">
                        <div class="entered-finaos">
                            <ul class="fade-text" style="padding-left: 30px;">
                                <li><a href="index.php?r=site/edit_profile" class="current">My Profile</a></li>
                                <li><a href="index.php?r=site/tagnotes">Tagnotes</a></li>
                                <li><a href="index.php?r=site/privacy">Privacy</a></li>
                                <li><a href="#">Notifications</a></li>
                                <li class="last"><a href="<? echo $global_shop_url; ?>">FINAO Shop</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <? include_once("footer.php"); ?>
            </div>           
            <form id="editprofile" method="post" action="index.php?r=site/update_profile" enctype="multipart/form-data">    
                <div class="col-lg-7 col-md-7 col-sm-6 content-wrapper-right" style="padding-left:40px; padding-top:30px; border-left:1px solid #afafaf; ">
                    <div class="row">
                        <div class="col-md-2 col-sm-3">
                            <span class="font-15px">Name :</span>
                        </div>
                        <div class="col-md-4 col-sm-2">
                            <input type="hidden" name="profile_info[userid]" value="<? //echo $user_details->userid; ?>"/>
                            <input type="text" size="30" id="name" placeholder="Name" name="profile_info[name]" value="<? echo $user_details->fname." ".$user_details->lname; ?>"/>
                        </div>
                    </div>
                    <div class="space-setting"></div>
                    <div class="row">
                        <div class="col-md-2 col-sm-3">
                            <span class="font-15px">Email :</span>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" placeholder="Email" id="email" size="30" readonly="readonly" name="profile_info[email]" value="<? echo $user_details->email; ?>"/>
                        </div>
                    </div>
                    <div class="space-setting"></div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <span class="font-15px">Edit password :</span>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <input type="password" id="password" name="profile_info[password]"/>
                        </div>
                    </div>
                    <div class="space-setting"></div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <span class="font-15px">Re-enter password :</span>
                        </div>
                        <div class="col-md-4 col-sm-4">
                            <input type="password" id="reenter_password" name="profile_info[reenter_password]"/>
                        </div>
                    </div>
                    <div class="space-setting"></div>
                    <div class="row finao-setting-padding margin-none" id="preview-pane">
<!--                        <div class="col-md-3 col-sm-3 settings-picture-padding preview-container">
                        </div>-->
                        <div class="col-md-3 col-sm-3 update-pictures" style="padding-left:0px;"> 
                            <div id="profile_image_container">
                                <img id="croped_profile_image" src="<? echo ($user_details->profile_image !="" ? $user_details->profile_image : $image_path . "no-image.png") ?>" class="width100 jcrop-preview">
                            </div>
                            <input type="hidden" id="x" name="profile_info[x]" />
                            <input type="hidden" id="y" name="profile_info[y]" />
                            <input type="hidden" id="w" name="profile_info[w]" />
                            <input type="hidden" id="h" name="profile_info[h]" /> 
                        </div> 
                        <div class="col-md-8 col-sm-7 update-pictures">
                            <ul class="col-md-12 col-sm-12 profile-share-text">
                                <li>
                                    <label for="profile_image" style="margin-bottom:0px; font-weight:normal;">Upload Profile Picture</label>
                                    <input type="file" id="profile_image" style="display:none;" name="profile_image" onchange="readURL(this)" />
                                    <!--<input type="file" style="display:none;" id="profile_image" name="profile_image"/>-->
                                </li>
                                <li>Take a Profile Picture</li>
                            </ul>
                        </div> 
                    </div>
                    <div class="row finao-setting-padding margin-none">
                        <div class="row col-md-6 col-sm-6 settings-picture-padding update-pictures">
                            <div class="update-pictures" id="banner_image">                                
                                <img src="<? echo ($user_details->banner_image != "" ? $user_details->banner_image : "content/images/no-image-banner.jpg"); ?>" class="width100 jcrop-preview">
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 update-pictures">
                            <ul class="col-md-12 col-sm-12 ">
                                <li>
                                    <label for="profile_banner_image" style="margin-bottom:0px; font-weight:normal;">Upload Banner Picture</label>
                                    <input type="file" id="profile_banner_image" style="display:none;" name="profile_banner_image" onchange="readBannerURL(this);"/> 
                                </li>
                                <li>Take a Banner Picture</li>
                            </ul>
                            <input type="hidden" id="bannerx" name="profile_info[bannerx]" />
                            <input type="hidden" id="bannery" name="profile_info[bannery]" />
                            <input type="hidden" id="bannerw" name="profile_info[bannerw]" />
                            <input type="hidden" id="bannerh" name="profile_info[bannerh]" />
                        </div>
                    </div>
                    <div class="row finao-setting-padding">
                        <p>Your bio:</p>
                        <textarea class="form-control font-18px color" maxlength="2000" id="bio" name="profile_info[bio]" rows="10" ><? echo $user_details->mystory; ?></textarea>
                        <div class="row col-md-12 col-sm-12">
                             <input type="submit" value="SAVE" class="button-save" style="margin-right: 20px;" onclick="return validateform();"/>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modal for preview -->
 <div class="modal fade bs-modal-sm-edit" role="dialog" aria-labelledby="PostCropPreview" aria-hidden="true">
    <div class="modal-dialog">
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
                        <div class="text-right orange-text post-finao-right-text"><a href="#" data-toggle="modal" onclick="crop_image_complete(); return false;" id="post_next">Done</a></div>
                    </div>
                </div>
            </div>
            <div class="modal-body">            
                <div class="clear-50px" id="image_preview">
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>
<!--modal for preview -->
<?
    include_once("alert_modal.php");
?>